/* Summit Prints — T-Shirt Mockup Tool (client-side only) */
(function () {
    const svg     = document.getElementById('mk-svg');
    if (!svg) return;

    const shirt   = document.getElementById('mk-shirt');
    const collar  = document.getElementById('mk-collar');
    const shade1  = document.getElementById('mk-shade1');
    const shade2  = document.getElementById('mk-shade2');
    const guide   = document.getElementById('mk-guide');
    const hint    = document.getElementById('mk-hint');
    const logo    = document.getElementById('mk-logo');
    const fileIn  = document.getElementById('mk-file');
    const fname   = document.getElementById('mk-filename');
    const sizeIn  = document.getElementById('mk-size');
    const dlBtn   = document.getElementById('mk-download');
    const resetBtn= document.getElementById('mk-reset');
    const guideChk= document.getElementById('mk-guide-toggle');

    const NS = 'http://www.w3.org/2000/svg';
    const XLINK = 'http://www.w3.org/1999/xlink';

    // Current logo box state (centre-based)
    let state = { cx: 300, cy: 315, w: 185, ratio: 1, href: null };
    // Bounds the logo centre may travel within (roughly the shirt body)
    const BOUNDS = { minX: 135, maxX: 465, minY: 160, maxY: 540 };

    function applyLogo() {
        if (!state.href) return;
        const h = state.w * state.ratio;
        logo.setAttribute('width', state.w);
        logo.setAttribute('height', h);
        logo.setAttribute('x', state.cx - state.w / 2);
        logo.setAttribute('y', state.cy - h / 2);
    }

    function showLogo(show) {
        logo.style.display = show ? '' : 'none';
        hint.style.display = show ? 'none' : '';
        dlBtn.disabled = !show;
    }

    /* ---- Upload ---- */
    fileIn.addEventListener('change', function () {
        const file = this.files && this.files[0];
        if (!file) return;
        if (!file.type.startsWith('image/')) { alert('Please choose an image file.'); return; }
        const reader = new FileReader();
        reader.onload = (e) => {
            const dataUrl = e.target.result;
            const probe = new Image();
            probe.onload = () => {
                state.ratio = probe.naturalHeight / probe.naturalWidth || 1;
                state.href = dataUrl;
                logo.setAttributeNS(XLINK, 'xlink:href', dataUrl);
                logo.setAttribute('href', dataUrl);
                // Default to centre-chest preset
                state.w = 185; state.cx = 300; state.cy = 315;
                sizeIn.value = 185;
                document.querySelectorAll('#mk-presets .pf-tab').forEach((t, i) => t.classList.toggle('active', i === 1));
                applyLogo();
                showLogo(true);
            };
            probe.src = dataUrl;
        };
        reader.readAsDataURL(file);
        fname.textContent = file.name;
    });

    /* ---- Shirt colour ---- */
    document.getElementById('mk-swatches').addEventListener('click', (e) => {
        const b = e.target.closest('.swatch');
        if (!b) return;
        document.querySelectorAll('#mk-swatches .swatch').forEach((s) => s.classList.remove('active'));
        b.classList.add('active');
        const body = b.dataset.body, line = b.dataset.line, sh = b.dataset.shade;
        shirt.setAttribute('fill', body);
        shirt.setAttribute('stroke', line);
        collar.setAttribute('stroke', line);
        shade1.setAttribute('fill', sh);
        shade2.setAttribute('fill', sh);
    });

    /* ---- Placement presets ---- */
    document.getElementById('mk-presets').addEventListener('click', (e) => {
        const b = e.target.closest('.pf-tab');
        if (!b) return;
        document.querySelectorAll('#mk-presets .pf-tab').forEach((t) => t.classList.remove('active'));
        b.classList.add('active');
        state.w  = +b.dataset.w;
        state.cx = +b.dataset.cx;
        state.cy = +b.dataset.cy;
        sizeIn.value = state.w;
        applyLogo();
    });

    /* ---- Size slider ---- */
    sizeIn.addEventListener('input', function () {
        state.w = +this.value;
        applyLogo();
    });

    /* ---- Guide toggle ---- */
    guideChk.addEventListener('change', function () {
        guide.style.display = this.checked ? '' : 'none';
    });

    /* ---- Drag to position ---- */
    let dragging = false;
    function toSvg(evt) {
        const pt = svg.createSVGPoint();
        pt.x = evt.clientX; pt.y = evt.clientY;
        const ctm = svg.getScreenCTM().inverse();
        return pt.matrixTransform(ctm);
    }
    function clamp(v, lo, hi) { return Math.max(lo, Math.min(hi, v)); }

    function startDrag(evt) {
        if (logo.style.display === 'none') return;
        dragging = true;
        logo.style.cursor = 'grabbing';
        evt.preventDefault();
    }
    function moveDrag(evt) {
        if (!dragging) return;
        const p = toSvg(evt);
        state.cx = clamp(p.x, BOUNDS.minX, BOUNDS.maxX);
        state.cy = clamp(p.y, BOUNDS.minY, BOUNDS.maxY);
        applyLogo();
    }
    function endDrag() { dragging = false; logo.style.cursor = 'grab'; }

    logo.addEventListener('pointerdown', startDrag);
    svg.addEventListener('pointermove', moveDrag);
    window.addEventListener('pointerup', endDrag);

    /* ---- Reset ---- */
    resetBtn.addEventListener('click', () => {
        state = { cx: 300, cy: 315, w: 185, ratio: 1, href: null };
        logo.removeAttribute('href');
        logo.removeAttributeNS(XLINK, 'href');
        fileIn.value = '';
        fname.textContent = '';
        sizeIn.value = 185;
        showLogo(false);
    });

    /* ---- Download as PNG ---- */
    dlBtn.addEventListener('click', () => {
        if (!state.href) return;
        guide.style.display = 'none'; // keep guide out of the export
        const xml = new XMLSerializer().serializeToString(svg);
        if (guideChk.checked) guide.style.display = '';
        const svg64 = 'data:image/svg+xml;base64,' +
            btoa(unescape(encodeURIComponent(xml)));
        const img = new Image();
        img.onload = () => {
            const scale = 2; // export at 2x for crispness
            const canvas = document.createElement('canvas');
            canvas.width = 600 * scale;
            canvas.height = 620 * scale;
            const ctx = canvas.getContext('2d');
            ctx.fillStyle = '#ffffff';
            ctx.fillRect(0, 0, canvas.width, canvas.height);
            ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
            const a = document.createElement('a');
            a.download = 'summit-prints-mockup.png';
            a.href = canvas.toDataURL('image/png');
            a.click();
        };
        img.src = svg64;
    });
})();
