<?php
$current = 'home';
$page_title = 'Home';
require __DIR__ . '/includes/header.php';

// Inline SVG icons for the service cards.
function service_icon($name){
    $i = [
        'logo'   => '<path d="M12 2 2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5M2 12l10 5 10-5" fill="none" stroke="currentColor" stroke-width="1.6"/>',
        'thread' => '<circle cx="12" cy="12" r="9" fill="none" stroke="currentColor" stroke-width="1.6"/><path d="M7 12c2-4 8-4 10 0-2 4-8 4-10 0z" fill="none" stroke="currentColor" stroke-width="1.6"/><circle cx="12" cy="12" r="1.7"/>',
        'web'    => '<rect x="3" y="4" width="18" height="14" rx="2" fill="none" stroke="currentColor" stroke-width="1.6"/><path d="M3 8h18M7 20h10" stroke="currentColor" stroke-width="1.6"/>',
        'vector' => '<path d="M5 19 19 5M7 5H5v2M19 17v2h-2" fill="none" stroke="currentColor" stroke-width="1.6"/><rect x="3" y="3" width="4" height="4" fill="currentColor"/><rect x="17" y="17" width="4" height="4" fill="currentColor"/>',
    ];
    return '<svg viewBox="0 0 24 24" width="28" height="28" fill="currentColor">'.($i[$name] ?? '').'</svg>';
}
?>

<!-- HERO -->
<section class="hero">
    <div class="container hero-inner">
        <div class="hero-copy reveal">
            <span class="eyebrow">Where threads meet quality</span>
            <h1>When every <em>thread</em> matters!</h1>
            <p class="lead">Quality is our first priority &mdash; so when you need something done, and done right, we are your best option. Fast turnaround, unlimited edits, around the clock.</p>
            <div class="hero-cta">
                <a href="<?= base_url('quote.php') ?>" class="btn btn-accent">Get a Patch Quote</a>
                <a href="<?= base_url('portfolio.php') ?>" class="btn btn-outline">View Our Work</a>
            </div>
            <div class="hero-badge">
                <div><b>24/7</b><small>SERVICE</small></div>
                <div><b>Unlimited</b><small>FREE EDITS</small></div>
                <div><b>Rush</b><small>TURNAROUND</small></div>
            </div>
        </div>
        <div class="hero-visual reveal">
            <div class="hero-card">
                <div class="hoop"><span>Summit<br>Prints</span></div>
            </div>
        </div>
    </div>
</section>

<!-- SERVICES -->
<section id="services">
    <div class="container">
        <div class="sec-head reveal">
            <span class="kicker">What We Do</span>
            <h2>Our Services</h2>
            <p>From a single embroidered patch to a full brand identity &mdash; we cover every thread of the process.</p>
        </div>
        <div class="services-grid">
            <?php foreach ($SERVICES as $s): ?>
            <div class="service-card reveal">
                <div class="service-ico"><?= service_icon($s['icon']) ?></div>
                <h3><?= htmlspecialchars($s['title']) ?></h3>
                <p><?= htmlspecialchars($s['text']) ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- WHY CHOOSE US -->
<section class="why">
    <div class="container">
        <div class="sec-head reveal">
            <span class="kicker">The Thread Tapes Difference</span>
            <h2>Why Choose Us</h2>
            <p>Six reasons businesses across the country trust us with their embroidery and design work.</p>
        </div>
        <div class="why-grid">
            <?php foreach ($WHY as $idx => $w): ?>
            <div class="why-card reveal">
                <div class="why-num"><?= sprintf('%02d', $idx + 1) ?></div>
                <div>
                    <h3><?= htmlspecialchars($w['title']) ?></h3>
                    <p><?= htmlspecialchars($w['text']) ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- STATS -->
<section class="bg-alt">
    <div class="container">
        <div class="sec-head reveal">
            <span class="kicker">Our Portfolio In Numbers</span>
            <h2>Work We're Proud Of</h2>
        </div>
        <div class="stats-grid">
            <?php foreach ($STATS as $st): ?>
            <div class="stat reveal">
                <b data-count="<?= (int)$st['value'] ?>">0</b>
                <span><?= htmlspecialchars($st['label']) ?></span>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- TESTIMONIALS -->
<section>
    <div class="container">
        <div class="sec-head reveal">
            <span class="kicker">Testimonials</span>
            <h2>What Our Clients Say</h2>
            <p>Don't just take our word for it &mdash; here's what business owners say about working with us.</p>
        </div>
        <div class="tst-grid">
            <?php foreach ($TESTIMONIALS as $t): ?>
            <div class="tst-card reveal">
                <div class="quote">&ldquo;</div>
                <div class="tst-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
                <p><?= htmlspecialchars($t['text']) ?></p>
                <div class="tst-author">
                    <div class="tst-avatar"><?= htmlspecialchars(strtoupper($t['name'][0])) ?></div>
                    <div>
                        <b><?= htmlspecialchars($t['name']) ?></b>
                        <small><?= htmlspecialchars($t['role']) ?></small>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="cta">
    <div class="container reveal">
        <h2>Ready to get stitching?</h2>
        <p>Send us your artwork and we'll get you a quote fast. No edit charges, no surprises &mdash; just quality work on time.</p>
        <a href="<?= base_url('quote.php') ?>" class="btn btn-dark">Request Your Quote</a>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
