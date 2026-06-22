<?php
$current = 'portfolio';
$page_title = 'Portfolio';
require __DIR__ . '/includes/header.php';

$types = [
    'vector'     => ['label' => 'Vector',     'desc' => 'Pixelated, low-res or skewed art rebuilt into clean, scalable vector files.'],
    'digitizing' => ['label' => 'Digitizing', 'desc' => 'Production-ready embroidery files digitized for flawless machine sewouts.'],
    'website'    => ['label' => 'Website',    'desc' => 'Modern websites and web apps built to be the foundation of your business.'],
];
$active_type = $_GET['type'] ?? 'vector';
if (!isset($types[$active_type])) $active_type = 'vector';

// Sample portfolio items keyed by type.
$items = [
    'vector' => [
        ['Eagle Crest Logo', 'Logo Vectorization', '#1d3a6e'],
        ['Coffee Co. Badge',  'Raster to Vector',   '#7a4a1e'],
        ['Moto Club Emblem',  'Color Separation',   '#3b2a5a'],
        ['Gym Brand Mark',    'Clean Redraw',       '#0e5a4a'],
        ['Festival Crest',    'Vector Art',         '#8a2d3b'],
        ['Auto Shop Sign',    'Logo Redraw',        '#2a4a1e'],
    ],
    'digitizing' => [
        ['Cap Front Logo',    'Left-Chest Digitizing', '#0e1b33'],
        ['Jacket Back',       'Large Format',          '#16264a'],
        ['Polo Crest',        '3D Puff',               '#1d2f57'],
        ['Beanie Patch',      'Applique',              '#22305a'],
        ['Sleeve Lettering',  'Small Text',            '#102a4a'],
        ['Towel Monogram',    'Monogram',              '#0e3a55'],
    ],
    'website' => [
        ['Bakery Storefront', 'E-commerce Site',  '#1d3a6e'],
        ['Barber Booking',    'Web App',          '#3b2a5a'],
        ['Apparel Brand',     'Shopify Build',    '#7a4a1e'],
        ['Studio Portfolio',  'Landing Page',     '#0e5a4a'],
        ['Food Truck',        'One-Page Site',    '#8a2d3b'],
        ['Fitness Coach',     'Membership Site',  '#2a4a1e'],
    ],
];
?>
<section class="page-hero">
    <div class="container">
        <h1>Our Portfolio</h1>
        <p><?= htmlspecialchars($types[$active_type]['desc']) ?></p>
        <div class="crumbs"><a href="<?= base_url('index.php') ?>">Home</a> &nbsp;/&nbsp; Portfolio &nbsp;/&nbsp; <?= htmlspecialchars($types[$active_type]['label']) ?></div>
    </div>
</section>

<section>
    <div class="container">
        <div class="pf-tabs reveal">
            <?php foreach ($types as $key => $t): ?>
                <a class="pf-tab<?= $key === $active_type ? ' active' : '' ?>" href="<?= base_url('portfolio.php?type=' . $key) ?>"><?= htmlspecialchars($t['label']) ?></a>
            <?php endforeach; ?>
        </div>

        <div class="pf-grid">
            <?php foreach ($items[$active_type] as $it): ?>
            <div class="pf-item reveal">
                <div class="pf-thumb" style="background:linear-gradient(150deg,<?= $it[2] ?>,#0e1b33)">
                    <?= htmlspecialchars($it[0]) ?>
                </div>
                <div class="pf-body">
                    <h4><?= htmlspecialchars($it[0]) ?></h4>
                    <span><?= htmlspecialchars($it[1]) ?></span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="cta">
    <div class="container reveal">
        <h2>Like what you see?</h2>
        <p>Let's create something just as sharp for your brand.</p>
        <a href="<?= base_url('quote.php') ?>" class="btn btn-dark">Start a Project</a>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
