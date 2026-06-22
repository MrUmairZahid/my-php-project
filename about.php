<?php
$current = 'about';
$page_title = 'About';
require __DIR__ . '/includes/header.php';
?>
<section class="page-hero">
    <div class="container">
        <h1>About Thread Tapes</h1>
        <p>Where threads meet quality.</p>
        <div class="crumbs"><a href="<?= base_url('index.php') ?>">Home</a> &nbsp;/&nbsp; About</div>
    </div>
</section>

<section>
    <div class="container about-grid">
        <div class="reveal">
            <span class="kicker" style="color:var(--gold-deep);font-weight:600;letter-spacing:2px;text-transform:uppercase;font-size:.8rem">Our Story</span>
            <h2 style="font-size:2.2rem;margin:10px 0 16px">Quality stitched into everything we do</h2>
            <p class="lead">Thread Tapes is a Virginia-based embroidery digitizing and vector art studio. We started with one thing &mdash; digitizing &mdash; and grew into a full creative partner for businesses that need custom logos, vector conversions, and websites.</p>
            <p>Our name says it all: digitizing is in our DNA. Whether you hand us a crisp brand file or a blurry photo of a sketch, we turn it into clean, production-ready artwork that stitches and prints beautifully every time.</p>
            <ul class="check-list">
                <li>Unlimited free edits on every project</li>
                <li>Rush jobs handled without the rush-job quality drop</li>
                <li>Real machine sewouts so your design works in the real world</li>
                <li>Friendly, around-the-clock customer service</li>
            </ul>
            <a href="<?= base_url('quote.php') ?>" class="btn btn-dark" style="margin-top:24px">Get a Patch Quote</a>
        </div>
        <div class="about-visual reveal">
            <svg viewBox="0 0 120 120" width="160" height="160" fill="none" stroke="currentColor" stroke-width="3">
                <circle cx="60" cy="60" r="50"/>
                <path d="M30 60c12-26 48-26 60 0-12 26-48 26-60 0z"/>
                <circle cx="60" cy="60" r="9" fill="currentColor"/>
            </svg>
        </div>
    </div>
</section>

<section class="bg-alt">
    <div class="container">
        <div class="sec-head reveal">
            <span class="kicker">Our Values</span>
            <h2>What we stand for</h2>
        </div>
        <div class="why-grid" style="--gold:var(--gold)">
            <?php
            $values = [
                ['Craftsmanship', 'Every stitch and curve is checked by a human who cares about the result.'],
                ['Speed',         'Fast turnaround is standard, not a premium upsell.'],
                ['Honesty',       'Clear pricing with no hidden edit charges, ever.'],
            ];
            foreach ($values as $i => $v): ?>
            <div class="why-card reveal" style="background:#fff;border:1px solid var(--line)">
                <div class="why-num"><?= sprintf('%02d', $i+1) ?></div>
                <div>
                    <h3 style="color:var(--ink)"><?= htmlspecialchars($v[0]) ?></h3>
                    <p style="color:var(--body)"><?= htmlspecialchars($v[1]) ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
