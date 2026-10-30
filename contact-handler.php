<?php
/**
 * Contact form handler.
 * - Validates & sanitizes input
 * - CSRF + honeypot + simple rate limit
 * - Sends email via PHP mail() (swap for PHPMailer/SMTP in production)
 * - Responds with JSON for AJAX, or redirects back for normal POST
 */
session_start();

// ===== Configuration =====
const RECIPIENT_EMAIL = 'hello@alikhan.dev';   // <-- your inbox
const FROM_EMAIL      = 'no-reply@alikhan.dev'; // <-- address on your domain
const RATE_LIMIT_SECS = 60;

$isAjax = strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'xmlhttprequest';

/** Send a response in the right format and stop. */
function respond(bool $ok, string $message, array $errors = [], array $old = []): void
{
    global $isAjax;
    if ($isAjax) {
        header('Content-Type: application/json');
        http_response_code($ok ? 200 : 422);
        echo json_encode(['success' => $ok, 'message' => $message, 'errors' => $errors]);
    } else {
        $_SESSION['flash']  = ['type' => $ok ? 'success' : 'error', 'message' => $message];
        $_SESSION['errors'] = $errors;
        $_SESSION['old']    = $ok ? [] : $old;
        header('Location: contact.php');
    }
    exit;
}

// Only POST allowed
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: contact.php');
    exit;
}

// CSRF check
if (empty($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'])) {
    respond(false, 'Invalid session. Please refresh the page and try again.');
}

// Honeypot: silently "succeed" for bots
if (!empty($_POST['website'])) {
    respond(true, 'Thank you! Your message has been sent.');
}

// Rate limit
if (isset($_SESSION['last_submit']) && time() - $_SESSION['last_submit'] < RATE_LIMIT_SECS) {
    respond(false, 'Please wait a minute before sending another message.');
}

// ===== Sanitize =====
$clean = fn($v) => trim(strip_tags((string)($v ?? '')));
$name    = $clean($_POST['name'] ?? '');
$email   = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
$subject = $clean($_POST['subject'] ?? '');
$message = $clean($_POST['message'] ?? '');

// Prevent email header injection
$name    = str_replace(["\r", "\n"], ' ', $name);
$subject = str_replace(["\r", "\n"], ' ', $subject);

$old = compact('name', 'email', 'subject', 'message');

// ===== Validate =====
$errors = [];
if ($name === '' || mb_strlen($name) < 2)      $errors['name'] = 'Please enter your name (min 2 characters).';
elseif (mb_strlen($name) > 100)                 $errors['name'] = 'Name must be under 100 characters.';

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors['email'] = 'Please enter a valid email address.';
elseif (mb_strlen($email) > 255)                $errors['email'] = 'Email is too long.';

if ($subject === '' || mb_strlen($subject) < 3) $errors['subject'] = 'Subject must be at least 3 characters.';
elseif (mb_strlen($subject) > 150)              $errors['subject'] = 'Subject must be under 150 characters.';

if ($message === '' || mb_strlen($message) < 10) $errors['message'] = 'Message must be at least 10 characters.';
elseif (mb_strlen($message) > 2000)              $errors['message'] = 'Message must be under 2000 characters.';

if ($errors) {
    respond(false, 'Please fix the errors below.', $errors, $old);
}

// ===== Send email =====
$body = "New message from your portfolio\n\n"
      . "Name: {$name}\nEmail: {$email}\nSubject: {$subject}\n\n"
      . "Message:\n{$message}\n";

$headers = [
    'From: Portfolio <' . FROM_EMAIL . '>',
    'Reply-To: ' . $email,
    'Content-Type: text/plain; charset=UTF-8',
    'X-Mailer: PHP/' . phpversion(),
];

$sent = @mail(RECIPIENT_EMAIL, '[Portfolio] ' . $subject, $body, implode("\r\n", $headers));

// Backup: log message to a file (useful on localhost where mail() isn't configured)
$logDir = __DIR__ . '/storage';
if (!is_dir($logDir)) @mkdir($logDir, 0750, true);
@file_put_contents(
    $logDir . '/messages.log',
    '[' . date('Y-m-d H:i:s') . "] {$name} <{$email}> | {$subject}\n{$message}\n---\n",
    FILE_APPEND | LOCK_EX
);

if ($sent) {
    $_SESSION['last_submit'] = time();
    $_SESSION['csrf_token']  = bin2hex(random_bytes(32)); // rotate token
    respond(true, "Thank you, {$name}! Your message has been sent. I'll reply soon.");
}

respond(false, 'Sorry, the message could not be sent right now. Please email me directly.', [], $old);
