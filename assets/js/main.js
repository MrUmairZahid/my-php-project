// Thread Tapes — front-end interactions

// Mobile nav toggle
const toggle = document.querySelector('.nav-toggle');
const nav = document.querySelector('.main-nav');
if (toggle && nav) {
    toggle.addEventListener('click', () => {
        const open = nav.classList.toggle('open');
        toggle.classList.toggle('active', open);
        toggle.setAttribute('aria-expanded', open);
    });
}

// Back to top button
const backBtn = document.querySelector('.back-to-top');
if (backBtn) {
    window.addEventListener('scroll', () => {
        backBtn.classList.toggle('show', window.scrollY > 480);
    });
}

// Scroll reveal
const revealEls = document.querySelectorAll('.reveal');
if ('IntersectionObserver' in window && revealEls.length) {
    const io = new IntersectionObserver((entries) => {
        entries.forEach((e) => {
            if (e.isIntersecting) { e.target.classList.add('in'); io.unobserve(e.target); }
        });
    }, { threshold: 0.12 });
    revealEls.forEach((el) => io.observe(el));
} else {
    revealEls.forEach((el) => el.classList.add('in'));
}

// Animated stat counters
const stats = document.querySelectorAll('[data-count]');
if ('IntersectionObserver' in window && stats.length) {
    const so = new IntersectionObserver((entries) => {
        entries.forEach((e) => {
            if (!e.isIntersecting) return;
            const el = e.target;
            const target = +el.dataset.count;
            let cur = 0;
            const step = Math.max(1, Math.ceil(target / 60));
            const tick = () => {
                cur += step;
                if (cur >= target) { el.textContent = target.toLocaleString(); }
                else { el.textContent = cur.toLocaleString(); requestAnimationFrame(tick); }
            };
            tick();
            so.unobserve(el);
        });
    }, { threshold: 0.5 });
    stats.forEach((s) => so.observe(s));
}
