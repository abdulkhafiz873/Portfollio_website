<?php
/** Home page */
$pageTitle  = 'Home';
$activePage = 'index';
require __DIR__ . '/includes/projects.php';
require __DIR__ . '/includes/header.php';
$featured = array_filter($projects, fn($p) => $p['featured']);
?>

<!-- Hero -->
<section class="hero">
    <div class="container hero-grid">
        <div class="hero-text reveal">
            <p class="eyebrow">Hello, I'm</p>
            <h1>Ali Khan<br><span class="accent">Web Designer &amp; Developer</span></h1>
            <p class="lead">I design and build fast, accessible websites that help brands grow.</p>
            <div class="btn-group">
                <a href="portfolio.php" class="btn btn-primary">View My Work</a>
                <a href="contact.php" class="btn btn-outline">Hire Me</a>
            </div>
        </div>
        <div class="hero-image reveal">
            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=600&q=70" alt="Portrait of Ali Khan">
        </div>
    </div>
    <a href="#intro" class="scroll-down" aria-label="Scroll down"><i class="fa-solid fa-chevron-down"></i></a>
</section>

<!-- Brief intro -->
<section class="section" id="intro">
    <div class="container intro reveal">
        <h2 class="section-title">A little about me</h2>
        <p>With 5+ years of experience, I turn ideas into clean, user-friendl digital products —         
           from first sketch to final deploy.</p>
        <div class="stats">
            <div><strong>5+</strong><span>Years experience</span></div>
            <div><strong>60+</strong><span>Projects done</span></div>
            <div><strong>40+</strong><span>Happy clients</span></div>
        </div>
    </div>
</section>

<!-- Featured projects -->
<section class="section section-alt">
    <div class="container">
        <h2 class="section-title reveal">Featured Projects</h2>
        <div class="projects-grid">
            <?php foreach ($featured as $p): ?>
                <article class="project-card reveal">
                    <img src="<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['title']) ?>" loading="lazy">
                    <div class="project-body">
                        <span class="tag"><?= htmlspecialchars($p['tag']) ?></span>
                        <h3><?= htmlspecialchars($p['title']) ?></h3>
                        <p><?= htmlspecialchars($p['desc']) ?></p>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
        <div class="center"><a href="portfolio.php" class="btn btn-outline">See all projects</a></div>
    </div>
</section>

<!-- Call to action -->
<section class="cta">
    <div class="container reveal">
        <h2>Have a project in mind?</h2>
        <p>Let's build something great together.</p>
        <a href="contact.php" class="btn btn-light">Get in touch</a>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
