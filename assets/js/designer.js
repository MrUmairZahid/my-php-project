/* Summit Prints — Design Studio (photo model + Fabric.js, 100% client-side) */
(function () {
    if (typeof fabric === 'undefined') { console.error('Fabric.js failed to load'); return; }
    const CFG = window.STUDIO_CFG;
    const SW = CFG.stageW, SH = CFG.stageH;
    const PRINT = {
        left: Math.round(CFG.printN.l * SW),
        top:  Math.round(CFG.printN.t * SH),
        width: Math.round(CFG.printN.w * SW),
        height: Math.round(CFG.printN.h * SH),
    };

    /* ---------- Stage + shirt canvas ---------- */
    const stage = document.getElementById('ss-stage');
    stage.style.width = SW + 'px';
    stage.style.height = SH + 'px';
    const shirtCv = document.getElementById('ss-shirt');
    shirtCv.width = SW; shirtCv.height = SH;
    const shirtCtx = shirtCv.getContext('2d');

    const canvasEl = document.getElementById('ss-canvas');
    canvasEl.width = PRINT.width; canvasEl.height = PRINT.height;
    function place(el) {
        el.style.position = 'absolute';
        el.style.left = PRINT.left + 'px'; el.style.top = PRINT.top + 'px';
        el.style.width = PRINT.width + 'px'; el.style.height = PRINT.height + 'px';
    }
    place(document.getElementById('ss-guide'));

    const canvas = new fabric.Canvas('ss-canvas', { preserveObjectStacking: true, backgroundColor: 'transparent' });
    place(canvas.wrapperEl);
    canvas.wrapperEl.style.zIndex = 3;
    fabric.Object.prototype.set({
        cornerColor: '#d8232a', cornerStrokeColor: '#fff', cornerSize: 11,
        transparentCorners: false, borderColor: '#d8232a', cornerStyle: 'circle',
    });

    /* ---------- Load photos + masks, build shirt-alpha per view ---------- */
    let currentView = 'front';
    let shirtColor = '#ffffff', isWhite = true;
    const photos = {}, alpha = {};
    let ready = false;

    function loadImg(src) {
        return new Promise((res) => { const i = new Image(); i.crossOrigin = 'anonymous'; i.onload = () => res(i); i.onerror = () => res(null); i.src = src; });
    }
    // Build a stage-sized alpha mask: opaque where shirt fabric is (raw mask AND bright/low-sat).
    function buildAlpha(photoImg, maskImg) {
        const pc = document.createElement('canvas'); pc.width = SW; pc.height = SH;
        const px = pc.getContext('2d'); px.drawImage(photoImg, 0, 0, SW, SH);
        const P = px.getImageData(0, 0, SW, SH).data;
        const mc = document.createElement('canvas'); mc.width = SW; mc.height = SH;
        const mx = mc.getContext('2d'); mx.drawImage(maskImg, 0, 0, SW, SH);
        const M = mx.getImageData(0, 0, SW, SH).data;
        const out = px.createImageData(SW, SH);
        const O = out.data;
        for (let i = 0; i < P.length; i += 4) {
            let on = 0;
            if (M[i] > 110) { // inside raw mask
                const r = P[i], g = P[i + 1], b = P[i + 2];
                const max = Math.max(r, g, b), min = Math.min(r, g, b);
                const lum = max / 255, sat = max > 0 ? (max - min) / max : 0;
                if (lum > 0.6 && sat < 0.18) on = 1;
            }
            if (on) { O[i] = O[i + 1] = O[i + 2] = 255; O[i + 3] = 255; }
        }
        const ac = document.createElement('canvas'); ac.width = SW; ac.height = SH;
        ac.getContext('2d').putImageData(out, 0, 0);
        return ac;
    }

    // Paint the shirt (photo + optional multiply tint) into a context at WxH.
    function paintShirt(ctx, W, H, view, color, white) {
        ctx.clearRect(0, 0, W, H);
        if (!photos[view]) return;
        ctx.drawImage(photos[view], 0, 0, W, H);
        if (white) return;
        const t = document.createElement('canvas'); t.width = W; t.height = H;
        const tc = t.getContext('2d');
        tc.drawImage(photos[view], 0, 0, W, H);
        tc.globalCompositeOperation = 'multiply';
        tc.fillStyle = color; tc.fillRect(0, 0, W, H);
        tc.globalCompositeOperation = 'destination-in';
        tc.drawImage(alpha[view], 0, 0, W, H);
        ctx.drawImage(t, 0, 0);
    }
    function drawShirt() { paintShirt(shirtCtx, SW, SH, currentView, shirtColor, isWhite); }

    Promise.all([
        loadImg(CFG.photo.front), loadImg(CFG.photo.back),
        loadImg(CFG.mask.front), loadImg(CFG.mask.back),
    ]).then(([pf, pb, mf, mb]) => {
        photos.front = pf; photos.back = pb;
        if (pf && mf) alpha.front = buildAlpha(pf, mf);
        if (pb && mb) alpha.back = buildAlpha(pb, mb);
        ready = true;
        drawShirt();
    });

    /* ---------- History (per view) ---------- */
    let history = [], hpos = -1, locked = false;
    const undoBtn = document.getElementById('ss-undo'), redoBtn = document.getElementById('ss-redo');
    function snapshot() {
        if (locked) return;
        history = history.slice(0, hpos + 1);
        history.push(JSON.stringify(canvas.toJSON()));
        if (history.length > 40) history.shift();
        hpos = history.length - 1; updateHistoryButtons();
    }
    function loadState(json) { locked = true; canvas.loadFromJSON(json, () => { canvas.renderAll(); locked = false; updateHistoryButtons(); updateSelButtons(); }); }
    function updateHistoryButtons() { undoBtn.disabled = hpos <= 0; redoBtn.disabled = hpos >= history.length - 1; }
    undoBtn.addEventListener('click', () => { if (hpos > 0) { hpos--; loadState(history[hpos]); } });
    redoBtn.addEventListener('click', () => { if (hpos < history.length - 1) { hpos++; loadState(history[hpos]); } });
    canvas.on('object:added', snapshot); canvas.on('object:modified', snapshot); canvas.on('object:removed', snapshot);

    /* ---------- Selection toolbar ---------- */
    const selBtns = document.querySelectorAll('.needs-sel');
    function updateSelButtons() { const has = !!canvas.getActiveObject(); selBtns.forEach((b) => (b.disabled = !has)); }
    canvas.on('selection:created', () => { updateSelButtons(); syncTextTools(); });
    canvas.on('selection:updated', () => { updateSelButtons(); syncTextTools(); });
    canvas.on('selection:cleared', updateSelButtons);
    document.getElementById('ss-delete').addEventListener('click', () => { const o = canvas.getActiveObject(); if (o) { canvas.remove(o); canvas.discardActiveObject(); canvas.requestRenderAll(); } });
    document.getElementById('ss-duplicate').addEventListener('click', () => { const o = canvas.getActiveObject(); if (!o) return; o.clone((c) => { c.set({ left: o.left + 14, top: o.top + 14 }); canvas.add(c); canvas.setActiveObject(c); canvas.requestRenderAll(); }); });
    document.getElementById('ss-forward').addEventListener('click', () => { const o = canvas.getActiveObject(); if (o) { o.bringForward(); canvas.requestRenderAll(); snapshot(); } });
    document.getElementById('ss-backward').addEventListener('click', () => { const o = canvas.getActiveObject(); if (o) { o.sendBackwards(); canvas.requestRenderAll(); snapshot(); } });
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Delete' || e.key === 'Backspace') { const o = canvas.getActiveObject(); if (o && !o.isEditing) { e.preventDefault(); canvas.remove(o); canvas.discardActiveObject(); canvas.requestRenderAll(); } }
    });
    canvas.on('object:moving', (e) => { const o = e.target; o.left = Math.max(0, Math.min(o.left, canvas.width)); o.top = Math.max(0, Math.min(o.top, canvas.height)); });
    function addObject(obj) { obj.set({ originX: 'center', originY: 'center', left: canvas.width / 2, top: canvas.height / 2 }); canvas.add(obj); canvas.setActiveObject(obj); canvas.requestRenderAll(); }

    /* ---------- Panels ---------- */
    document.querySelectorAll('.rail-btn').forEach((btn) => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.rail-btn').forEach((b) => b.classList.remove('active'));
            btn.classList.add('active');
            const name = btn.dataset.panel;
            document.querySelectorAll('.studio-panel .panel').forEach((p) => p.classList.toggle('active', p.dataset.panel === name));
        });
    });

    /* ---------- Upload ---------- */
    document.getElementById('ss-file').addEventListener('change', function () {
        const file = this.files && this.files[0]; if (!file) return;
        const reader = new FileReader();
        reader.onload = (e) => fabric.Image.fromURL(e.target.result, (img) => { const max = canvas.width * 0.8; if (img.width > max) img.scaleToWidth(max); addObject(img); });
        reader.readAsDataURL(file); this.value = '';
    });

    /* ---------- Text ---------- */
    const textInput = document.getElementById('ss-text-input'), fontSel = document.getElementById('ss-font');
    const textColor = document.getElementById('ss-text-color'), textSize = document.getElementById('ss-text-size'), sizeVal = document.getElementById('ss-size-val');
    document.getElementById('ss-add-text').addEventListener('click', () => {
        const t = new fabric.IText((textInput.value || 'Your Text').trim() || 'Your Text', { fontFamily: fontSel.value.replace(/'/g, ''), fill: textColor.value, fontSize: +textSize.value, textAlign: 'center' });
        addObject(t);
    });
    function activeText() { const o = canvas.getActiveObject(); return o && o.type === 'i-text' ? o : null; }
    function syncTextTools() { const t = activeText(); if (!t) return; textColor.value = (typeof t.fill === 'string' && t.fill[0] === '#') ? t.fill : '#1e2a63'; textSize.value = Math.round(t.fontSize); sizeVal.textContent = Math.round(t.fontSize); }
    fontSel.addEventListener('change', () => { const t = activeText(); if (t) { t.set('fontFamily', fontSel.value.replace(/'/g, '')); canvas.requestRenderAll(); snapshot(); } });
    textColor.addEventListener('input', () => { const t = activeText(); if (t) { t.set('fill', textColor.value); canvas.requestRenderAll(); } });
    textColor.addEventListener('change', snapshot);
    textSize.addEventListener('input', () => { sizeVal.textContent = textSize.value; const t = activeText(); if (t) { t.set('fontSize', +textSize.value); canvas.requestRenderAll(); } });
    textSize.addEventListener('change', snapshot);
    document.querySelectorAll('#ss-text-tools .style-btns button').forEach((b) => {
        b.addEventListener('click', () => {
            const t = activeText(); if (!t) return;
            if (b.dataset.style === 'bold') t.set('fontWeight', t.fontWeight === 'bold' ? 'normal' : 'bold');
            if (b.dataset.style === 'italic') t.set('fontStyle', t.fontStyle === 'italic' ? 'normal' : 'italic');
            if (b.dataset.style === 'underline') t.set('underline', !t.underline);
            if (b.dataset.align) t.set('textAlign', b.dataset.align);
            b.classList.toggle('on'); canvas.requestRenderAll(); snapshot();
        });
    });
    const QUICK = ['#1e2a63', '#d8232a', '#ffffff', '#000000', '#f4c430', '#1f7a4d', '#6b4ea0', '#ff7a00'];
    const quickWrap = document.getElementById('ss-quick-colors');
    QUICK.forEach((c) => { const s = document.createElement('button'); s.className = 'qc'; s.style.background = c; s.title = c; s.addEventListener('click', () => { textColor.value = c; const t = activeText(); if (t) { t.set('fill', c); canvas.requestRenderAll(); snapshot(); } }); quickWrap.appendChild(s); });

    /* ---------- Art ---------- */
    const ART = {
        star: '<polygon points="50,5 61,38 96,38 68,59 79,93 50,72 21,93 32,59 4,38 39,38" fill="C"/>',
        heart: '<path d="M50 88C20 64 8 46 8 30 8 17 18 8 30 8c8 0 15 4 20 12 5-8 12-12 20-12 12 0 22 9 22 22 0 16-12 34-42 58z" fill="C"/>',
        circle: '<circle cx="50" cy="50" r="42" fill="C"/>',
        bolt: '<polygon points="55,5 25,55 45,55 40,95 75,40 52,40" fill="C"/>',
        crown: '<path d="M12 78h76l8-46-24 18-22-34-22 34-24-18z" fill="C"/>',
        flame: '<path d="M50 6c8 22-14 24-14 44 0 7 4 13 10 16-2-6 0-12 6-15-1 10 8 12 8 22 0 9-7 15-16 15-13 0-24-10-24-26 0-26 22-34 24-56z" fill="C"/>',
        ball: '<circle cx="50" cy="50" r="42" fill="none" stroke="C" stroke-width="7"/><path d="M50 8v84M8 50h84M20 20c40 8 40 52 0 60M80 20c-40 8-40 52 0 60" fill="none" stroke="C" stroke-width="5"/>',
        note: '<path d="M40 20l40-10v50" fill="none" stroke="C" stroke-width="8" stroke-linecap="round"/><circle cx="32" cy="72" r="13" fill="C"/><circle cx="72" cy="60" r="13" fill="C"/>',
        paw: '<circle cx="50" cy="62" r="20" fill="C"/><circle cx="24" cy="40" r="9" fill="C"/><circle cx="44" cy="28" r="9" fill="C"/><circle cx="62" cy="28" r="9" fill="C"/><circle cx="78" cy="42" r="9" fill="C"/>',
        arrow: '<path d="M10 50h60l-18-18M70 50l-18 18" fill="none" stroke="C" stroke-width="9" stroke-linecap="round" stroke-linejoin="round"/>',
        smile: '<circle cx="50" cy="50" r="42" fill="none" stroke="C" stroke-width="7"/><circle cx="37" cy="42" r="5" fill="C"/><circle cx="63" cy="42" r="5" fill="C"/><path d="M32 60c8 12 28 12 36 0" fill="none" stroke="C" stroke-width="7" stroke-linecap="round"/>',
        diamond: '<polygon points="50,6 94,50 50,94 6,50" fill="C"/>',
    };
    const artSvg = (body, color) => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100">' + body.replace(/C/g, color) + '</svg>';
    const artDataUrl = (body, color) => 'data:image/svg+xml;charset=utf-8,' + encodeURIComponent(artSvg(body, color));
    const artGrid = document.getElementById('ss-art-grid');
    Object.keys(ART).forEach((key) => {
        const b = document.createElement('button'); b.className = 'art-item'; b.innerHTML = artSvg(ART[key], '#1e2a63');
        b.addEventListener('click', () => fabric.Image.fromURL(artDataUrl(ART[key], '#d8232a'), (img) => { img.scaleToWidth(canvas.width * 0.45); img._artBody = ART[key]; addObject(img); }));
        artGrid.appendChild(b);
    });
    document.getElementById('ss-art-color').addEventListener('input', function () {
        const o = canvas.getActiveObject();
        if (o && o.type === 'image' && o._artBody) {
            const body = o._artBody, color = this.value;
            fabric.Image.fromURL(artDataUrl(body, color), (img) => { img.set({ left: o.left, top: o.top, scaleX: o.scaleX, scaleY: o.scaleY, angle: o.angle, originX: 'center', originY: 'center' }); img._artBody = body; canvas.remove(o); canvas.add(img); canvas.setActiveObject(img); canvas.requestRenderAll(); });
        }
    });

    /* ---------- Shirt colour ---------- */
    const colorName = document.getElementById('sb-color-name'), chip = document.getElementById('sb-chip');
    document.getElementById('ss-swatches').addEventListener('click', (e) => {
        const b = e.target.closest('.swatch'); if (!b) return;
        document.querySelectorAll('#ss-swatches .swatch').forEach((s) => s.classList.remove('active'));
        b.classList.add('active');
        shirtColor = b.dataset.body; isWhite = (b.dataset.name === 'White');
        colorName.textContent = b.dataset.name; chip.style.background = shirtColor;
        drawShirt();
    });
    document.getElementById('sb-change-color').addEventListener('click', (e) => { e.preventDefault(); document.querySelector('.rail-btn[data-panel="product"]').click(); });
    chip.style.background = '#f3f4f6';

    /* ---------- Guide toggle ---------- */
    const guide = document.getElementById('ss-guide');
    document.getElementById('ss-guide-toggle').addEventListener('change', function () { guide.style.display = this.checked ? '' : 'none'; });

    /* ---------- View switch ---------- */
    document.querySelectorAll('.view-btn[data-view]').forEach((btn) => {
        btn.addEventListener('click', () => {
            const to = btn.dataset.view; if (to === currentView) return;
            viewState[currentView] = JSON.stringify(canvas.toJSON());
            document.querySelectorAll('.view-btn').forEach((b) => b.classList.remove('active'));
            btn.classList.add('active');
            currentView = to; drawShirt();
            locked = true; canvas.clear();
            const restore = () => { locked = false; history = []; hpos = -1; snapshot(); updateSelButtons(); };
            if (viewState[to]) canvas.loadFromJSON(viewState[to], () => { canvas.renderAll(); restore(); }); else restore();
        });
    });
    const viewState = { front: null, back: null };

    /* ---------- Compose shirt + design into one PNG ---------- */
    function renderComposite(scale, cb) {
        canvas.discardActiveObject(); canvas.renderAll();
        const out = document.createElement('canvas'); out.width = SW * scale; out.height = SH * scale;
        const ctx = out.getContext('2d');
        ctx.fillStyle = '#ffffff'; ctx.fillRect(0, 0, out.width, out.height);
        paintShirt(ctx, SW * scale, SH * scale, currentView, shirtColor, isWhite);
        const design = new Image();
        design.onload = () => { ctx.drawImage(design, PRINT.left * scale, PRINT.top * scale, PRINT.width * scale, PRINT.height * scale); cb(out); };
        design.src = canvas.toDataURL({ format: 'png', multiplier: scale });
    }

    document.getElementById('ss-save').addEventListener('click', () => {
        renderComposite(2, (out) => { const a = document.createElement('a'); a.download = 'summit-prints-' + currentView + '-design.png'; a.href = out.toDataURL('image/png'); a.click(); });
    });

    const lightbox = document.getElementById('ss-lightbox');
    document.getElementById('ss-zoom').addEventListener('click', () => { renderComposite(2, (out) => { document.getElementById('ss-preview-img').src = out.toDataURL('image/png'); lightbox.hidden = false; }); });
    document.getElementById('ss-lightbox-close').addEventListener('click', () => (lightbox.hidden = true));
    lightbox.addEventListener('click', (e) => { if (e.target === lightbox) lightbox.hidden = true; });

    /* ---------- Init ---------- */
    snapshot(); updateSelButtons();
})();
