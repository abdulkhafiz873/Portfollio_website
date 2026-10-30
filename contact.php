<?php
/** Contact page: form posts to contact-handler.php (AJAX or normal POST). */
session_start();
$pageTitle  = 'Contact';
$activePage = 'contact';

// CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Flash data from non-JS fallback submit
$flash  = $_SESSION['flash'] ?? null;
$old    = $_SESSION['old'] ?? [];
$errors = $_SESSION['errors'] ?? [];
unset($_SESSION['flash'], $_SESSION['old'], $_SESSION['errors']);

$e = fn($k) => htmlspecialchars($old[$k] ?? '', ENT_QUOTES);
require __DIR__ . '/includes/header.php';
?>

<section class="page-hero">
    <div class="container">
        <h1>Contact Me</h1>
        <p>Have a question or a project? Send a message.</p>
    </div>
</section>

<section class="section">
    <div class="container contact-grid">
        <!-- Info -->
        <aside class="contact-info reveal">
            <h2>Let's talk</h2>
            <p><i class="fa-solid fa-envelope"></i> <a href="mailto:hello@alikhan.dev">hello@alikhan.dev</a></p>
            <p><i class="fa-solid fa-phone"></i> +92 300 0000000</p>
            <p><i class="fa-solid fa-location-dot"></i> Karachi, Pakistan</p>
            <div class="socials big">
                <a href="https://github.com/" target="_blank" rel="noopener" aria-label="GitHub"><i class="fa-brands fa-github"></i></a>
                <a href="https://linkedin.com/" target="_blank" rel="noopener" aria-label="LinkedIn"><i class="fa-brands fa-linkedin"></i></a>
                <a href="https://twitter.com/" target="_blank" rel="noopener" aria-label="Twitter"><i class="fa-brands fa-x-twitter"></i></a>
                <a href="https://instagram.com/" target="_blank" rel="noopener" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
            </div>
        </aside>

        <!-- Form -->
        <form class="contact-form reveal" id="contactForm" action="contact-handler.php" method="POST" novalidate>
            <div id="formAlert" class="alert <?= $flash ? 'alert-' . $flash['type'] : '' ?>" role="alert" <?= $flash ? '' : 'hidden' ?>>
                <?= $flash ? htmlspecialchars($flash['message']) : '' ?>
            </div>

            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            <!-- Honeypot (bots fill this; humans don't see it) -->
            <input type="text" name="website" class="hp" tabindex="-1" autocomplete="off">

            <div class="form-row">
                <div class="field">
                    <label for="name">Name *</label>
                    <input type="text" id="name" name="name" maxlength="100" required value="<?= $e('name') ?>">
                    <small class="error"><?= $errors['name'] ?? '' ?></small>
                </div>
                <div class="field">
                    <label for="email">Email *</label>
                    <input type="email" id="email" name="email" maxlength="255" required value="<?= $e('email') ?>">
                    <small class="error"><?= $errors['email'] ?? '' ?></small>
                </div>
            </div>
            <div class="field">
                <label for="subject">Subject *</label>
                <input type="text" id="subject" name="subject" maxlength="150" required value="<?= $e('subject') ?>">
                <small class="error"><?= $errors['subject'] ?? '' ?></small>
            </div>
            <div class="field">
                <label for="message">Message *</label>
                <textarea id="message" name="message" rows="6" maxlength="2000" required><?= $e('message') ?></textarea>
                <small class="error"><?= $errors['message'] ?? '' ?></small>
            </div>
            <button type="submit" class="btn btn-primary" id="submitBtn">
                <span class="btn-text">Send Message</span> <i class="fa-solid fa-paper-plane"></i>
            </button>
        </form>
    </div>
</section>

<!-- Map placeholder: replace iframe src with your own Google Maps embed -->
<section class="map-wrap">
    <iframe title="Location map" loading="lazy"
        src="https://www.openstreetmap.org/export/embed.html?bbox=66.95%2C24.80%2C67.15%2C24.95&amp;layer=mapnik"></iframe>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
