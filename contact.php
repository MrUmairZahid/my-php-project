<?php
$current = 'contact';
$page_title = 'Contact';

$errors = [];
$sent = false;
$old = ['name' => '', 'email' => '', 'subject' => '', 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($old as $k => $v) $old[$k] = trim($_POST[$k] ?? '');
    if ($old['name'] === '') $errors['name'] = 'Required.';
    if ($old['email'] === '' || !filter_var($old['email'], FILTER_VALIDATE_EMAIL)) $errors['email'] = 'Valid email required.';
    if ($old['message'] === '') $errors['message'] = 'Required.';
    if (!$errors) {
        $line = sprintf("[%s] %s <%s> | %s | %s\n", date('Y-m-d H:i'), $old['name'], $old['email'],
            $old['subject'] ?: '-', str_replace(["\r","\n"], ' ', $old['message']));
        @file_put_contents(__DIR__ . '/storage/messages.log', $line, FILE_APPEND | LOCK_EX);
        $sent = true;
        $old = array_fill_keys(array_keys($old), '');
    }
}

require __DIR__ . '/includes/header.php';
?>
<section class="page-hero">
    <div class="container">
        <h1>Contact Us</h1>
        <p>Questions, quotes, or just want to say hi? We're here 24/7.</p>
        <div class="crumbs"><a href="<?= base_url('index.php') ?>">Home</a> &nbsp;/&nbsp; Contact</div>
    </div>
</section>

<section>
    <div class="container form-wrap">
        <div class="reveal">
            <span class="kicker" style="color:var(--gold-deep);font-weight:600;letter-spacing:2px;text-transform:uppercase;font-size:.8rem">Get In Touch</span>
            <h2 style="font-size:2rem;margin:10px 0 14px">We'd love to hear from you</h2>
            <p>Reach out any time &mdash; our team responds fast, day or night.</p>
            <ul class="info-list" style="margin-top:30px">
                <li>
                    <div class="info-ico"><svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor"><path d="M12 2a7 7 0 0 0-7 7c0 5 7 13 7 13s7-8 7-13a7 7 0 0 0-7-7zm0 9.5A2.5 2.5 0 1 1 12 6a2.5 2.5 0 0 1 0 5.5z"/></svg></div>
                    <div><h4>Address</h4><p><?= htmlspecialchars($SITE['address']) ?></p></div>
                </li>
                <li>
                    <div class="info-ico"><svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor"><path d="M6.6 10.8a15.9 15.9 0 0 0 6.6 6.6l2.2-2.2a1 1 0 0 1 1-.25 11.4 11.4 0 0 0 3.6.57 1 1 0 0 1 1 1V20a1 1 0 0 1-1 1A17 17 0 0 1 3 4a1 1 0 0 1 1-1h3.5a1 1 0 0 1 1 1 11.4 11.4 0 0 0 .57 3.6 1 1 0 0 1-.25 1z"/></svg></div>
                    <div><h4>Phone</h4><p><a href="tel:<?= preg_replace('/[^0-9+]/', '', $SITE['phone']) ?>"><?= htmlspecialchars($SITE['phone']) ?></a></p></div>
                </li>
                <li>
                    <div class="info-ico"><svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor"><path d="M4 4h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2zm8 7L4 6.5V7l8 4.5L20 7v-.5z"/></svg></div>
                    <div><h4>Email</h4><p><a href="mailto:<?= htmlspecialchars($SITE['email']) ?>"><?= htmlspecialchars($SITE['email']) ?></a></p></div>
                </li>
            </ul>
        </div>

        <div class="form-card reveal">
            <?php if ($sent): ?>
                <div class="alert alert-success">Thanks for reaching out! We'll reply as soon as possible.</div>
            <?php elseif ($errors): ?>
                <div class="alert alert-error">Please complete the required fields.</div>
            <?php endif; ?>
            <form method="post" action="<?= base_url('contact.php') ?>" novalidate>
                <div class="field">
                    <label for="name">Name *</label>
                    <input type="text" id="name" name="name" value="<?= htmlspecialchars($old['name']) ?>" required>
                </div>
                <div class="field">
                    <label for="email">Email *</label>
                    <input type="email" id="email" name="email" value="<?= htmlspecialchars($old['email']) ?>" required>
                </div>
                <div class="field">
                    <label for="subject">Subject</label>
                    <input type="text" id="subject" name="subject" value="<?= htmlspecialchars($old['subject']) ?>">
                </div>
                <div class="field">
                    <label for="message">Message *</label>
                    <textarea id="message" name="message" required><?= htmlspecialchars($old['message']) ?></textarea>
                </div>
                <button type="submit" class="btn btn-accent" style="width:100%">Send Message</button>
            </form>
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
