<?php
$current = 'mockup';
$page_title = 'Design Studio';
require __DIR__ . '/includes/header.php';

/* Shirt SVG — front/back share one silhouette; only the neckline differs. */
function studio_shirt($view = 'front') {
    $neck   = $view === 'front' ? 'C268,114 332,114 350,76' : 'C268,94 332,94 350,76';
    $collar = $view === 'front' ? 'M254,80 C270,112 330,112 346,80' : 'M256,80 C272,96 328,96 344,80';
    return '<svg class="shirt-svg" data-view="' . $view . '" viewBox="0 0 600 620" xmlns="http://www.w3.org/2000/svg">
        <defs><filter id="ss-soft-' . $view . '" x="-20%" y="-20%" width="140%" height="140%">
            <feDropShadow dx="0" dy="10" stdDeviation="14" flood-color="#0e1b33" flood-opacity="0.16"/></filter></defs>
        <g filter="url(#ss-soft-' . $view . ')">
            <path class="shirt-fill" d="M250,76 ' . $neck . ' L408,98 L520,164 L488,280 L440,252 L450,286 L430,548 C388,560 212,560 170,548 L150,286 L160,252 L112,280 L80,164 L192,98 Z"
                fill="#f3f4f6" stroke="#cfd4de" stroke-width="3" stroke-linejoin="round"/>
            <path class="shirt-stroke" d="' . $collar . '" fill="none" stroke="#cfd4de" stroke-width="7" stroke-linecap="round"/>
            <path class="shirt-shade" d="M150,286 L170,548 C182,552 196,554 202,554 L182,292 Z" fill="rgba(0,0,0,.04)"/>
            <path class="shirt-shade" d="M450,286 L430,548 C418,552 404,554 398,554 L418,292 Z" fill="rgba(0,0,0,.04)"/>
        </g>
    </svg>';
}
?>
<section class="studio-hero">
    <div class="container">
        <h1>Design Studio</h1>
        <p>Upload art, add text, pick your colour &mdash; design your shirt right here, then send it to us to print.</p>
    </div>
</section>

<div class="studio" id="studio">
    <!-- ============ LEFT ICON RAIL ============ -->
    <div class="studio-rail">
        <button class="rail-btn active" data-panel="upload" title="Upload">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M12 16V4m0 0L8 8m4-4 4 4"/><path d="M4 16v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2"/></svg>
            <span>Upload</span>
        </button>
        <button class="rail-btn" data-panel="text" title="Add Text">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M4 7V5h16v2M9 19h6M12 5v14"/></svg>
            <span>Add Text</span>
        </button>
        <button class="rail-btn" data-panel="art" title="Add Art">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="m21 15-5-5L5 21"/></svg>
            <span>Add Art</span>
        </button>
        <button class="rail-btn" data-panel="product" title="Product">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M4 7l4-3 4 2 4-2 4 3-3 3v9H7v-9z"/></svg>
            <span>Product</span>
        </button>
    </div>

    <!-- ============ SLIDE PANEL ============ -->
    <div class="studio-panel">
        <!-- Upload -->
        <div class="panel active" data-panel="upload">
            <h3>Upload your art</h3>
            <label class="upload-drop" id="ss-drop">
                <input type="file" id="ss-file" accept="image/*" hidden>
                <svg viewBox="0 0 24 24" width="30" height="30" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M12 16V4m0 0L8 8m4-4 4 4"/><path d="M4 16v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2"/></svg>
                <b>Click to upload</b>
                <span>PNG, JPG or SVG &middot; transparent PNG works best</span>
            </label>
            <p class="panel-note">Your file is processed in your browser &mdash; nothing is uploaded to a server.</p>
        </div>

        <!-- Text -->
        <div class="panel" data-panel="text">
            <h3>Add text</h3>
            <textarea id="ss-text-input" rows="2" placeholder="Type your text…">Your Text</textarea>
            <button class="btn btn-accent btn-block" id="ss-add-text">Add to Design</button>

            <div class="text-tools" id="ss-text-tools">
                <label>Font</label>
                <select id="ss-font">
                    <option value="Poppins">Poppins</option>
                    <option value="Arial">Arial</option>
                    <option value="Impact">Impact</option>
                    <option value="Georgia">Georgia</option>
                    <option value="'Courier New'">Courier New</option>
                    <option value="'Comic Sans MS'">Comic Sans</option>
                    <option value="'Brush Script MT'">Brush Script</option>
                    <option value="'Playfair Display'">Playfair</option>
                </select>

                <label>Colour</label>
                <div class="color-row">
                    <input type="color" id="ss-text-color" value="#1e2a63">
                    <div class="quick-colors" id="ss-quick-colors"></div>
                </div>

                <label>Size <span id="ss-size-val">40</span></label>
                <input type="range" id="ss-text-size" min="12" max="120" value="40">

                <div class="style-btns">
                    <button data-style="bold" title="Bold"><b>B</b></button>
                    <button data-style="italic" title="Italic"><i>I</i></button>
                    <button data-style="underline" title="Underline"><u>U</u></button>
                    <button data-align="left" title="Align left">&#8676;</button>
                    <button data-align="center" title="Align center">&#8596;</button>
                    <button data-align="right" title="Align right">&#8677;</button>
                </div>
                <p class="panel-note">Select a text element on the shirt to edit it. Double-click to retype.</p>
            </div>
        </div>

        <!-- Art -->
        <div class="panel" data-panel="art">
            <h3>Add art</h3>
            <p class="panel-note">Click a graphic to drop it on your design. Recolour it with the colour picker below after selecting it.</p>
            <div class="art-grid" id="ss-art-grid"></div>
            <label style="margin-top:14px;display:block;font-weight:500;color:var(--ink)">Recolour selected art</label>
            <input type="color" id="ss-art-color" value="#d8232a">
        </div>

        <!-- Product -->
        <div class="panel" data-panel="product">
            <h3>Shirt colour</h3>
            <div class="swatches" id="ss-swatches">
                <button class="swatch active" data-body="#f3f4f6" data-line="#cfd4de" data-shade="rgba(0,0,0,.05)" data-name="White" style="background:#f3f4f6" title="White"></button>
                <button class="swatch" data-body="#191a1d" data-line="#000000" data-shade="rgba(255,255,255,.06)" data-name="Black" style="background:#191a1d" title="Black"></button>
                <button class="swatch" data-body="#1e2a63" data-line="#141d47" data-shade="rgba(255,255,255,.06)" data-name="Navy" style="background:#1e2a63" title="Navy"></button>
                <button class="swatch" data-body="#b9bec7" data-line="#9aa1ad" data-shade="rgba(0,0,0,.05)" data-name="Heather Grey" style="background:#b9bec7" title="Heather Grey"></button>
                <button class="swatch" data-body="#d8232a" data-line="#a81a20" data-shade="rgba(255,255,255,.06)" data-name="Red" style="background:#d8232a" title="Red"></button>
                <button class="swatch" data-body="#1f7a4d" data-line="#155c39" data-shade="rgba(255,255,255,.06)" data-name="Green" style="background:#1f7a4d" title="Green"></button>
                <button class="swatch" data-body="#f4c430" data-line="#caa11f" data-shade="rgba(0,0,0,.05)" data-name="Gold" style="background:#f4c430" title="Gold"></button>
                <button class="swatch" data-body="#6b4ea0" data-line="#523a7d" data-shade="rgba(255,255,255,.06)" data-name="Purple" style="background:#6b4ea0" title="Purple"></button>
            </div>
            <label class="check-row"><input type="checkbox" id="ss-guide-toggle" checked> Show print-area guide</label>
            <h3 style="margin-top:24px">Product</h3>
            <p class="panel-note">Gildan Softstyle Jersey T-Shirt &middot; Unisex &middot; S&ndash;3XL<br>Premium ring-spun cotton, retail fit.</p>
        </div>
    </div>

    <!-- ============ STAGE ============ -->
    <div class="studio-main">
        <div class="studio-toolbar" id="ss-toolbar">
            <button id="ss-undo" title="Undo" disabled>&#8630;</button>
            <button id="ss-redo" title="Redo" disabled>&#8631;</button>
            <span class="tb-sep"></span>
            <button id="ss-forward" class="needs-sel" title="Bring forward" disabled>&#9633;&#8593;</button>
            <button id="ss-backward" class="needs-sel" title="Send backward" disabled>&#9633;&#8595;</button>
            <button id="ss-duplicate" class="needs-sel" title="Duplicate" disabled>&#10697;</button>
            <button id="ss-delete" class="needs-sel danger" title="Delete" disabled>&#128465;</button>
        </div>

        <div class="stage-wrap">
            <div class="stage" id="ss-stage">
                <canvas id="ss-shirt"></canvas>
                <canvas id="ss-canvas"></canvas>
                <div class="print-guide" id="ss-guide"></div>
            </div>
        </div>
    </div>

    <!-- ============ RIGHT VIEW RAIL ============ -->
    <div class="studio-views">
        <button class="view-btn active" data-view="front">
            <span class="view-thumb"><img src="<?= base_url('assets/img/model-front.png') ?>" alt="Front"></span>
            <small>Front</small>
        </button>
        <button class="view-btn" data-view="back">
            <span class="view-thumb"><img src="<?= base_url('assets/img/model-back.png') ?>" alt="Back"></span>
            <small>Back</small>
        </button>
        <button class="view-btn" id="ss-zoom">
            <span class="view-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3M11 8v6M8 11h6"/></svg></span>
            <small>Preview</small>
        </button>
    </div>
</div>

<!-- ============ BOTTOM BAR ============ -->
<div class="studio-bottom">
    <div class="sb-product">
        <span class="sb-chip" id="sb-chip"></span>
        <div>
            <b>Gildan Softstyle Jersey T-Shirt</b>
            <small><span id="sb-color-name">White</span> &middot; <a href="#" id="sb-change-color">Change Colour</a></small>
        </div>
    </div>
    <div class="sb-actions">
        <button class="btn btn-outline-dark" id="ss-save">Save / Download</button>
        <a class="btn btn-accent" href="<?= base_url('quote.php') ?>">Get Price</a>
    </div>
</div>

<!-- Preview lightbox -->
<div class="ss-lightbox" id="ss-lightbox" hidden>
    <div class="ss-lightbox-inner">
        <button class="ss-lightbox-close" id="ss-lightbox-close">&times;</button>
        <img id="ss-preview-img" alt="Design preview">
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.3.1/fabric.min.js"></script>
<script>
window.STUDIO_CFG = {
    stageW: 460, stageH: 651,
    photo: {
        front: '<?= base_url('assets/img/model-front.png') ?>',
        back:  '<?= base_url('assets/img/model-back.png') ?>'
    },
    mask: {
        front: '<?= base_url('assets/img/mask-front.png') ?>',
        back:  '<?= base_url('assets/img/mask-back.png') ?>'
    },
    // Chest print area as fractions of the photo (tuned to the model image)
    printN: { l: 0.355, t: 0.205, w: 0.30, h: 0.235 }
};
</script>
<script src="<?= base_url('assets/js/designer.js') ?>"></script>
<?php require __DIR__ . '/includes/footer.php'; ?>
