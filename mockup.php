<?php
$current = 'mockup';
$page_title = 'T-Shirt Mockup Tool';
require __DIR__ . '/includes/header.php';
?>
<section class="page-hero">
    <div class="container">
        <h1>T-Shirt Mockup Tool</h1>
        <p>Upload your logo and preview how your print will look on a shirt &mdash; right in your browser.</p>
        <div class="crumbs"><a href="<?= base_url('index.php') ?>">Home</a> &nbsp;/&nbsp; Mockup Tool</div>
    </div>
</section>

<section>
    <div class="container">
        <div class="mockup-wrap">
            <!-- ============ STAGE ============ -->
            <div class="shirt-stage" id="mk-stage">
                <svg id="mk-svg" viewBox="0 0 600 620" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <defs>
                        <filter id="mk-soft" x="-20%" y="-20%" width="140%" height="140%">
                            <feDropShadow dx="0" dy="12" stdDeviation="15" flood-color="#0e1b33" flood-opacity="0.18"/>
                        </filter>
                    </defs>

                    <!-- Shirt body (XL American tee: wide chest, long-but-balanced body, set-in sleeves) -->
                    <g filter="url(#mk-soft)">
                        <path id="mk-shirt"
                            d="M250,76
                               C268,114 332,114 350,76
                               L408,98 L520,164 L488,280 L440,252 L450,286
                               L430,548 C388,560 212,560 170,548 L150,286 L160,252 L112,280 L80,164 L192,98 Z"
                            fill="#f3f4f6" stroke="#cfd4de" stroke-width="3" stroke-linejoin="round"/>
                        <!-- collar rib -->
                        <path id="mk-collar" d="M254,80 C270,112 330,112 346,80"
                            fill="none" stroke="#cfd4de" stroke-width="7" stroke-linecap="round"/>
                        <!-- subtle fabric side shading (thin, hugs the seams) -->
                        <path id="mk-shade1" d="M150,286 L170,548 C182,552 196,554 202,554 L182,292 Z" fill="rgba(0,0,0,.04)"/>
                        <path id="mk-shade2" d="M450,286 L430,548 C418,552 404,554 398,554 L418,292 Z" fill="rgba(0,0,0,.04)"/>
                    </g>

                    <!-- Print-area guide (dashed) -->
                    <rect id="mk-guide" x="210" y="200" width="180" height="235" rx="6"
                        fill="none" stroke="#d8232a" stroke-width="2" stroke-dasharray="7 7" opacity="0.45"/>

                    <!-- Placeholder text -->
                    <text id="mk-hint" x="300" y="320" text-anchor="middle"
                        font-family="Poppins,Arial,sans-serif" font-size="18" fill="#9aa1ad">
                        <tspan x="300" dy="0">Upload your logo</tspan>
                        <tspan x="300" dy="26" font-size="13">it will appear here &mdash; drag to position</tspan>
                    </text>

                    <!-- Logo (filled in after upload) -->
                    <image id="mk-logo" x="207" y="222" width="185" height="185"
                        preserveAspectRatio="xMidYMid meet" style="display:none;cursor:grab"></image>
                </svg>
            </div>

            <!-- ============ CONTROLS ============ -->
            <div class="mock-panel">
                <h3>1. Upload your logo</h3>
                <label class="upload-drop" id="mk-drop">
                    <input type="file" id="mk-file" accept="image/*" hidden>
                    <svg viewBox="0 0 24 24" width="30" height="30" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M12 16V4m0 0L8 8m4-4 4 4"/><path d="M4 16v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2"/></svg>
                    <b>Click to upload</b>
                    <span>PNG with transparent background works best</span>
                    <em id="mk-filename"></em>
                </label>

                <h3>2. Shirt colour</h3>
                <div class="swatches" id="mk-swatches">
                    <button class="swatch active" data-body="#f3f4f6" data-line="#cfd4de" data-shade="rgba(0,0,0,.05)" style="background:#f3f4f6" title="White" aria-label="White"></button>
                    <button class="swatch" data-body="#191a1d" data-line="#000000" data-shade="rgba(255,255,255,.06)" style="background:#191a1d" title="Black" aria-label="Black"></button>
                    <button class="swatch" data-body="#1e2a63" data-line="#141d47" data-shade="rgba(255,255,255,.06)" style="background:#1e2a63" title="Navy" aria-label="Navy"></button>
                    <button class="swatch" data-body="#b9bec7" data-line="#9aa1ad" data-shade="rgba(0,0,0,.05)" style="background:#b9bec7" title="Heather Grey" aria-label="Heather Grey"></button>
                    <button class="swatch" data-body="#d8232a" data-line="#a81a20" data-shade="rgba(255,255,255,.06)" style="background:#d8232a" title="Red" aria-label="Red"></button>
                </div>

                <h3>3. Placement</h3>
                <div class="preset-row" id="mk-presets">
                    <button class="pf-tab" data-w="90"  data-cx="356" data-cy="242">Left Chest</button>
                    <button class="pf-tab active" data-w="185" data-cx="300" data-cy="315">Center Chest</button>
                    <button class="pf-tab" data-w="262" data-cx="300" data-cy="380">Full Front</button>
                </div>

                <div class="slider-row">
                    <label for="mk-size">Size</label>
                    <input type="range" id="mk-size" min="50" max="310" value="185">
                </div>

                <label class="check-row">
                    <input type="checkbox" id="mk-guide-toggle" checked> Show print area guide
                </label>

                <div class="mock-actions">
                    <button class="btn btn-accent" id="mk-download" disabled>Download Mockup</button>
                    <button class="btn btn-outline-dark" id="mk-reset">Reset</button>
                </div>

                <p class="mock-note">Tip: drag the logo on the shirt to move it. Everything stays on your device &mdash; nothing is uploaded.</p>
            </div>
        </div>
    </div>
</section>

<section class="cta">
    <div class="container reveal">
        <h2>Happy with the look?</h2>
        <p>Send us your file and we'll turn it into a press-ready print or stitch-perfect embroidery.</p>
        <a href="<?= base_url('quote.php') ?>" class="btn btn-dark">Get a Quote</a>
    </div>
</section>

<script src="<?= base_url('assets/js/mockup.js') ?>"></script>
<?php require __DIR__ . '/includes/footer.php'; ?>
