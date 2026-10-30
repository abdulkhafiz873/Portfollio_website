<?php
/** Portfolio page: filterable grid + modal */
$pageTitle  = 'Portfolio';
$activePage = 'portfolio';
require __DIR__ . '/includes/projects.php';
require __DIR__ . '/includes/header.php';

$filters = ['all' => 'All', 'design' => 'Web Design', 'development' => 'Development', 'uiux' => 'UI/UX'];
?>

<section class="page-hero">
    <div class="container">
        <h1>My Portfolio</h1>
        <p>A selection of recent work.</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <!-- Filter buttons -->
        <div class="filters" role="tablist" aria-label="Filter projects">
            <?php foreach ($filters as $key => $label): ?>
                <button class="filter-btn <?= $key === 'all' ? 'active' : '' ?>" data-filter="<?= $key ?>"><?= $label ?></button>
            <?php endforeach; ?>
        </div>

        <!-- Grid -->
        <div class="projects-grid" id="projectsGrid">
            <?php foreach ($projects as $p): ?>
                <article class="project-card" data-category="<?= $p['category'] ?>"
                         data-project='<?= htmlspecialchars(json_encode($p), ENT_QUOTES) ?>' tabindex="0">
                    <img src="<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['title']) ?>" loading="lazy">
                    <div class="project-body">
                        <span class="tag"><?= htmlspecialchars($p['tag']) ?></span>
                        <h3><?= htmlspecialchars($p['title']) ?></h3>
                        <p><?= htmlspecialchars($p['desc']) ?></p>
                        <span class="link-more">View details <i class="fa-solid fa-arrow-right"></i></span>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Project modal -->
<div class="modal" id="projectModal" aria-hidden="true" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
    <div class="modal-backdrop" data-close></div>
    <div class="modal-content">
        <button class="modal-close" data-close aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
        <img id="modalImage" src="" alt="">
        <div class="modal-body">
            <span class="tag" id="modalTag"></span>
            <h2 id="modalTitle"></h2>
            <p id="modalDesc"></p>
            <ul class="tech-list" id="modalTech"></ul>
            <a href="#" id="modalLink" class="btn btn-primary" target="_blank" rel="noopener">Live Preview</a>
        </div>
    </div>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
