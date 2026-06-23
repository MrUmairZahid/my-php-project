<?php
$current = 'portfolio';
$page_title = 'Portfolio';
require __DIR__ . '/includes/header.php';

$types = [
    'vector'     => ['label' => 'Vector',     'desc' => 'Pixelated, low-res or skewed art rebuilt into clean, scalable vector files.'],
    'digitizing' => ['label' => 'Digitizing', 'desc' => 'Production-ready embroidery files digitized for flawless machine sewouts.'],
    'website'    => ['label' => 'Website',    'desc' => 'Modern websites and web apps built to be the foundation of your business.'],
    'logo'       => ['label' => 'Logo',       'desc' => 'Custom logos and brand marks designed from scratch — with unlimited free edits.'],
];
$active_type = $_GET['type'] ?? 'vector';
if (!isset($types[$active_type])) $active_type = 'vector';

// Sample portfolio items keyed by type.
$items = [
    'vector' => [
        ['Eagle Crest Logo', 'Logo Vectorization', '#1d3a6e', $VECTOR_SHOTS[0]],
        ['Coffee Co. Badge',  'Raster to Vector',   '#7a4a1e', $VECTOR_SHOTS[1]],
        ['Moto Club Emblem',  'Color Separation',   '#3b2a5a', $VECTOR_SHOTS[2]],
        ['Gym Brand Mark',    'Clean Redraw',       '#0e5a4a', $VECTOR_SHOTS[3]],
        ['Festival Crest',    'Vector Art',         '#8a2d3b'],
        ['Auto Shop Sign',    'Logo Redraw',        '#2a4a1e'],
    ],
    'digitizing' => [
        ['Greece Flag Patch',  'Flag Embroidery', '#1d6fa5', $DIGITIZING_SHOTS[0]],
        ['Romero Threads',     'Logo Patch',      '#1d3a6e', $DIGITIZING_SHOTS[1]],
        ['Crocubot Squad',     'Custom Patch',    '#2a4a1e', $DIGITIZING_SHOTS[2]],
        ['Adventure Crest',    'Iron-On Patch',   '#b08d2a', $DIGITIZING_SHOTS[3]],
        ['Sleeve Lettering',   'Small Text',      '#102a4a'],
        ['Towel Monogram',     'Monogram',        '#0e3a55'],
    ],
    'website' => [
        ['Cloud Storage Site', 'SaaS Landing',    '#1d3a6e', $WEBSITE_SHOTS[0]],
        ['Finance Web App',    'Web App',         '#1f7a4d', $WEBSITE_SHOTS[1]],
        ['Tech Landing Page', 'Marketing Site',   '#7a4a1e', $WEBSITE_SHOTS[2]],
        ['Agency Portfolio',  'Landing Page',     '#0e5a4a', $WEBSITE_SHOTS[3]],
        ['Food Truck',        'One-Page Site',    '#8a2d3b'],
        ['Fitness Coach',     'Membership Site',  '#2a4a1e'],
    ],
    'logo' => [
        ['Flame Fish Mark',  'Mascot Logo',      '#b3261e', $LOGO_SHOTS[0]],
        ['Fire Symbol',      'Abstract Mark',    '#d8651e', $LOGO_SHOTS[1]],
        ['Fire Brand',       'Logo & Slogan',    '#c0392b', $LOGO_SHOTS[2]],
        ['Flame Hand',       'Gradient Mark',    '#8e2d8e', $LOGO_SHOTS[3]],
        ['Monogram Crest',   'Lettermark',       '#1d3a6e'],
        ['Vintage Badge',    'Emblem Logo',      '#2a4a1e'],
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
                    <?php if (!empty($it[3])): ?>
                        <img src="<?= base_url($it[3]) ?>" alt="<?= htmlspecialchars($it[0]) ?>" loading="lazy" onerror="this.style.display='none'">
                    <?php else: ?>
                        <?= htmlspecialchars($it[0]) ?>
                    <?php endif; ?>
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
