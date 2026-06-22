</main>

<section class="newsletter">
    <div class="container newsletter-inner">
        <div>
            <h3>Recent R&amp;D &amp; Updates</h3>
            <p>Join the newsletter for tips on digitizing, vector art and running a merch business.</p>
        </div>
        <form class="newsletter-form" action="<?= base_url('subscribe.php') ?>" method="post">
            <input type="email" name="email" placeholder="Your email address" required>
            <button type="submit" class="btn btn-accent">Subscribe</button>
        </form>
    </div>
</section>

<footer class="site-footer">
    <div class="container footer-grid">
        <div class="footer-col">
            <a href="<?= base_url('index.php') ?>" class="brand brand-light footer-logo" aria-label="<?= htmlspecialchars($SITE['name']) ?> home">
                <?= summit_logo('light') ?>
            </a>
            <p class="footer-muted">Embroidery digitizing, vector art &amp; custom logo design based in Arlington, VA.</p>
        </div>

        <div class="footer-col">
            <h4>Explore</h4>
            <ul>
                <li><a href="<?= base_url('index.php') ?>">Home</a></li>
                <li><a href="<?= base_url('about.php') ?>">About</a></li>
                <li><a href="<?= base_url('portfolio.php') ?>">Portfolios</a></li>
                <li><a href="<?= base_url('quote.php') ?>">Get a Patch Quote</a></li>
                <li><a href="<?= base_url('contact.php') ?>">Contact</a></li>
            </ul>
        </div>

        <div class="footer-col">
            <h4>Services</h4>
            <ul>
                <li><a href="<?= base_url('portfolio.php?type=digitizing') ?>">Embroidery Digitizing</a></li>
                <li><a href="<?= base_url('portfolio.php?type=vector') ?>">Vector Art</a></li>
                <li><a href="<?= base_url('index.php#services') ?>">Custom Logos</a></li>
                <li><a href="<?= base_url('portfolio.php?type=website') ?>">Website Works</a></li>
            </ul>
        </div>

        <div class="footer-col">
            <h4>Contact</h4>
            <ul class="footer-contact">
                <li><?= htmlspecialchars($SITE['address']) ?></li>
                <li><a href="tel:<?= preg_replace('/[^0-9+]/', '', $SITE['phone']) ?>"><?= htmlspecialchars($SITE['phone']) ?></a></li>
                <li><a href="mailto:<?= htmlspecialchars($SITE['email']) ?>"><?= htmlspecialchars($SITE['email']) ?></a></li>
            </ul>
            <a class="social-link" href="<?= htmlspecialchars($SITE['instagram']) ?>" aria-label="Instagram">
                <svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor"><path d="M12 2.2c3.2 0 3.6 0 4.9.07 1.2.05 1.8.25 2.2.42.56.22.96.48 1.38.9.42.42.68.82.9 1.38.17.4.37 1 .42 2.2.06 1.3.07 1.7.07 4.9s0 3.6-.07 4.9c-.05 1.2-.25 1.8-.42 2.2a3.7 3.7 0 0 1-.9 1.38c-.42.42-.82.68-1.38.9-.4.17-1 .37-2.2.42-1.3.06-1.7.07-4.9.07s-3.6 0-4.9-.07c-1.2-.05-1.8-.25-2.2-.42a3.7 3.7 0 0 1-1.38-.9 3.7 3.7 0 0 1-.9-1.38c-.17-.4-.37-1-.42-2.2C2.2 15.6 2.2 15.2 2.2 12s0-3.6.07-4.9c.05-1.2.25-1.8.42-2.2.22-.56.48-.96.9-1.38.42-.42.82-.68 1.38-.9.4-.17 1-.37 2.2-.42C8.4 2.2 8.8 2.2 12 2.2zm0 1.8c-3.1 0-3.5 0-4.7.07-.9.04-1.4.2-1.7.32-.43.17-.74.37-1.06.7-.32.32-.52.63-.7 1.06-.12.3-.28.8-.32 1.7C3.96 8.5 3.96 8.9 3.96 12s0 3.5.07 4.7c.04.9.2 1.4.32 1.7.17.43.37.74.7 1.06.32.32.63.52 1.06.7.3.12.8.28 1.7.32 1.2.07 1.6.07 4.7.07s3.5 0 4.7-.07c.9-.04 1.4-.2 1.7-.32.43-.17.74-.37 1.06-.7.32-.32.52-.63.7-1.06.12-.3.28-.8.32-1.7.07-1.2.07-1.6.07-4.7s0-3.5-.07-4.7c-.04-.9-.2-1.4-.32-1.7a2.86 2.86 0 0 0-.7-1.06 2.86 2.86 0 0 0-1.06-.7c-.3-.12-.8-.28-1.7-.32C15.5 4 15.1 4 12 4zm0 3.06A4.94 4.94 0 1 1 7.06 12 4.94 4.94 0 0 1 12 7.06zm0 1.8A3.14 3.14 0 1 0 15.14 12 3.14 3.14 0 0 0 12 8.86zm6.3-2.96a1.15 1.15 0 1 1-1.15-1.15A1.15 1.15 0 0 1 18.3 5.9z"/></svg>
            </a>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container footer-bottom-inner">
            <p>&copy; <?= date('Y') ?> <?= htmlspecialchars($SITE['name']) ?>. All rights reserved.</p>
            <ul>
                <li><a href="<?= base_url('privacy.php') ?>">Privacy Policy</a></li>
                <li><a href="<?= base_url('about.php') ?>">About</a></li>
                <li><a href="<?= base_url('contact.php') ?>">Contact</a></li>
            </ul>
        </div>
    </div>
</footer>

<a href="#top" class="back-to-top" aria-label="Back to top">&uarr;</a>
<script src="<?= base_url('assets/js/main.js') ?>"></script>
</body>
</html>
