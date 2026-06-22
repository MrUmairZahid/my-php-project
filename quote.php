<?php
$current = 'quote';
$page_title = 'Get a Patch Quote';

$errors = [];
$sent = false;
$old = ['name' => '', 'email' => '', 'phone' => '', 'service' => '', 'qty' => '', 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($old as $k => $v) {
        $old[$k] = trim($_POST[$k] ?? '');
    }
    if ($old['name'] === '')  $errors['name']  = 'Please enter your name.';
    if ($old['email'] === '' || !filter_var($old['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Please enter a valid email address.';
    }
    if ($old['service'] === '') $errors['service'] = 'Please choose a service.';
    if ($old['message'] === '') $errors['message'] = 'Tell us a little about your project.';

    if (!$errors) {
        // Persist the request so it isn't lost (a real site would email / store in a DB).
        $line = sprintf("[%s] %s <%s> | %s | qty:%s | %s | %s\n",
            date('Y-m-d H:i'), $old['name'], $old['email'], $old['service'],
            $old['qty'] ?: '-', $old['phone'] ?: '-', str_replace(["\r","\n"], ' ', $old['message']));
        @file_put_contents(__DIR__ . '/storage/quotes.log', $line, FILE_APPEND | LOCK_EX);
        $sent = true;
        $old = array_fill_keys(array_keys($old), '');
    }
}

require __DIR__ . '/includes/header.php';
?>
<section class="page-hero">
    <div class="container">
        <h1>Get a Patch Quote</h1>
        <p>Send us your artwork and details &mdash; we'll get back to you fast with a price.</p>
        <div class="crumbs"><a href="<?= base_url('index.php') ?>">Home</a> &nbsp;/&nbsp; Get a Patch Quote</div>
    </div>
</section>

<section>
    <div class="container form-wrap">
        <div class="reveal">
            <span class="kicker" style="color:var(--gold-deep);font-weight:600;letter-spacing:2px;text-transform:uppercase;font-size:.8rem">Request a Quote</span>
            <h2 style="font-size:2rem;margin:10px 0 14px">Tell us about your project</h2>
            <p>Fill out the form and our team will reach out with a quote and turnaround time. No edit charges, ever &mdash; we work with you until it's perfect.</p>

            <ul class="info-list" style="margin-top:30px">
                <li>
                    <div class="info-ico"><svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor"><path d="M12 2a7 7 0 0 0-7 7c0 5 7 13 7 13s7-8 7-13a7 7 0 0 0-7-7zm0 9.5A2.5 2.5 0 1 1 12 6a2.5 2.5 0 0 1 0 5.5z"/></svg></div>
                    <div><h4>Visit Us</h4><p><?= htmlspecialchars($SITE['address']) ?></p></div>
                </li>
                <li>
                    <div class="info-ico"><svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor"><path d="M6.6 10.8a15.9 15.9 0 0 0 6.6 6.6l2.2-2.2a1 1 0 0 1 1-.25 11.4 11.4 0 0 0 3.6.57 1 1 0 0 1 1 1V20a1 1 0 0 1-1 1A17 17 0 0 1 3 4a1 1 0 0 1 1-1h3.5a1 1 0 0 1 1 1 11.4 11.4 0 0 0 .57 3.6 1 1 0 0 1-.25 1z"/></svg></div>
                    <div><h4>Call Us</h4><p><a href="tel:<?= preg_replace('/[^0-9+]/', '', $SITE['phone']) ?>"><?= htmlspecialchars($SITE['phone']) ?></a></p></div>
                </li>
                <li>
                    <div class="info-ico"><svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor"><path d="M4 4h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2zm8 7L4 6.5V7l8 4.5L20 7v-.5z"/></svg></div>
                    <div><h4>Email Us</h4><p><a href="mailto:<?= htmlspecialchars($SITE['email']) ?>"><?= htmlspecialchars($SITE['email']) ?></a></p></div>
                </li>
            </ul>
        </div>

        <div class="form-card reveal">
            <?php if ($sent): ?>
                <div class="alert alert-success">Thanks! Your quote request has been received. We'll be in touch shortly.</div>
            <?php elseif ($errors): ?>
                <div class="alert alert-error">Please fix the highlighted fields and try again.</div>
            <?php endif; ?>

            <form method="post" action="<?= base_url('quote.php') ?>" novalidate>
                <div class="form-grid-2">
                    <div class="field">
                        <label for="name">Full Name *</label>
                        <input type="text" id="name" name="name" value="<?= htmlspecialchars($old['name']) ?>" required>
                    </div>
                    <div class="field">
                        <label for="phone">Phone</label>
                        <input type="text" id="phone" name="phone" value="<?= htmlspecialchars($old['phone']) ?>">
                    </div>
                </div>
                <div class="form-grid-2">
                    <div class="field">
                        <label for="email">Email *</label>
                        <input type="email" id="email" name="email" value="<?= htmlspecialchars($old['email']) ?>" required>
                    </div>
                    <div class="field">
                        <label for="qty">Quantity</label>
                        <input type="text" id="qty" name="qty" value="<?= htmlspecialchars($old['qty']) ?>" placeholder="e.g. 50 patches">
                    </div>
                </div>
                <div class="field">
                    <label for="service">Service Needed *</label>
                    <select id="service" name="service" required>
                        <option value="">— Select a service —</option>
                        <?php foreach (['Embroidery Digitizing','Vector Art','Custom Logo','Patch','Website Works'] as $opt): ?>
                            <option value="<?= $opt ?>" <?= $old['service'] === $opt ? 'selected' : '' ?>><?= $opt ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="field">
                    <label for="message">Project Details *</label>
                    <textarea id="message" name="message" placeholder="Describe your artwork, dimensions, deadline, etc."><?= htmlspecialchars($old['message']) ?></textarea>
                </div>
                <button type="submit" class="btn btn-accent" style="width:100%">Request Quote</button>
            </form>
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
