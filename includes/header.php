<?php
/**
 * Shared header: <head>, theme bootstrap, and navigation.
 * Usage: set $pageTitle and $activePage before including.
 */
$pageTitle  = $pageTitle  ?? 'Portfolio';
$activePage = $activePage ?? '';
$navItems = [
    'index'     => ['Home', 'index.php'],
    'about'     => ['About', 'about.php'],
    'portfolio' => ['Portfolio', 'portfolio.php'],
    'contact'   => ['Contact', 'contact.php'],
];
?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Personal portfolio of Ali Khan — web designer & developer.">
    <title><?= htmlspecialchars($pageTitle) ?> | Ali Khan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;700&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- Apply saved theme before paint to avoid flash -->
    <script>
        (function () {
            var t = localStorage.getItem('theme') ||
                (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
            document.documentElement.setAttribute('data-theme', t);
        })();
    </script>
</head>
<body>
<header class="site-header" id="top">
    <nav class="nav container" aria-label="Main navigation">
        <a href="index.php" class="logo">Ali<span>.</span></a>

        <ul class="nav-links" id="navLinks">
            <?php foreach ($navItems as $key => [$label, $href]): ?>
                <li>
                    <a href="<?= $href ?>" class="<?= $activePage === $key ? 'active' : '' ?>"
                       <?= $activePage === $key ? 'aria-current="page"' : '' ?>><?= $label ?></a>
                </li>
            <?php endforeach; ?>
        </ul>

        <div class="nav-actions">
            <button class="icon-btn" id="themeToggle" aria-label="Toggle dark mode">
                <i class="fa-solid fa-moon"></i>
            </button>
            <button class="icon-btn menu-toggle" id="menuToggle" aria-label="Open menu" aria-expanded="false" aria-controls="navLinks">
                <i class="fa-solid fa-bars"></i>
            </button>
        </div>
    </nav>
</header>
<main>
