<?php
/** About page */
$pageTitle  = 'About';
$activePage = 'about';
require __DIR__ . '/includes/header.php';

$skills = [
    ['HTML5', 'fa-brands fa-html5', 95],
    ['CSS3 / Tailwind', 'fa-brands fa-css3-alt', 90],
    ['JavaScript', 'fa-brands fa-js', 85],
    ['PHP', 'fa-brands fa-php', 80],
    ['MySQL', 'fa-solid fa-database', 75],
    ['Figma', 'fa-brands fa-figma', 88],
];

$timeline = [
    ['2023 – Present', 'Senior Web Developer', 'Pixel Studio, Karachi', 'Leading front-end builds for agency clients.'],
    ['2021 – 2023', 'Web Developer', 'CodeCraft, Lahore', 'Built PHP/MySQL web apps and e-commerce sites.'],
    ['2019 – 2021', 'Junior Designer', 'Freelance', 'Designed websites and brand kits for small businesses.'],
    ['2015 – 2019', 'BS Computer Science', 'University of Karachi', 'Graduated with focus on software engineering.'],
];
?>

<section class="page-hero">
    <div class="container">
        <h1>About Me</h1>
        <p>Designer, developer, and lifelong learner.</p>
    </div>
</section>

<!-- Background -->
<section class="section">
    <div class="container about-grid">
        <img class="about-img reveal" src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=600&q=70" alt="Ali Khan at work">
        <div class="reveal">
            <h2 class="section-title left">My Background</h2>
            <p>I started coding in university and quickly fell in love with building for the web.
               Today I help startups and businesses create websites that look great and work flawlessly.</p>
            <p>I care about clean code, accessibility, and performance. Outside work I enjoy photography and chai.</p>
            <a href="assets/cv.pdf" class="btn btn-primary" download><i class="fa-solid fa-download"></i> Download CV</a>
        </div>
    </div>
</section>

<!-- Skills -->
<section class="section section-alt">
    <div class="container">
        <h2 class="section-title reveal">Skills</h2>
        <div class="skills-grid">
            <?php foreach ($skills as [$name, $icon, $level]): ?>
                <div class="skill reveal">
                    <div class="skill-head">
                        <span><i class="<?= $icon ?>"></i> <?= $name ?></span>
                        <span><?= $level ?>%</span>
                    </div>
                    <div class="progress" role="progressbar" aria-valuenow="<?= $level ?>" aria-valuemin="0" aria-valuemax="100" aria-label="<?= $name ?>">
                        <div class="progress-bar" data-width="<?= $level ?>"></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Timeline -->
<section class="section">
    <div class="container">
        <h2 class="section-title reveal">Experience &amp; Education</h2>
        <ol class="timeline">
            <?php foreach ($timeline as [$date, $role, $place, $desc]): ?>
                <li class="timeline-item reveal">
                    <span class="timeline-date"><?= $date ?></span>
                    <h3><?= $role ?></h3>
                    <p class="muted"><?= $place ?></p>
                    <p><?= $desc ?></p>
                </li>
            <?php endforeach; ?>
        </ol>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
