<?php
$current = '';
$page_title = 'Privacy Policy';
require __DIR__ . '/includes/header.php';
?>
<section class="page-hero">
    <div class="container">
        <h1>Privacy Policy</h1>
        <p>How Thread Tapes handles your information.</p>
        <div class="crumbs"><a href="<?= base_url('index.php') ?>">Home</a> &nbsp;/&nbsp; Privacy Policy</div>
    </div>
</section>
<section>
    <div class="container" style="max-width:820px">
        <div class="reveal" style="color:var(--body)">
            <h2 style="font-size:1.5rem;margin-bottom:12px">Information We Collect</h2>
            <p style="margin-bottom:22px">When you request a quote, contact us, or subscribe to our newsletter, we collect the details you provide &mdash; such as your name, email, phone number, and any project information. We use this solely to respond to your request and deliver our services.</p>

            <h2 style="font-size:1.5rem;margin-bottom:12px">How We Use Your Information</h2>
            <p style="margin-bottom:22px">Your information is used to prepare quotes, complete orders, provide customer support, and (if you opt in) send occasional updates. We never sell your data to third parties.</p>

            <h2 style="font-size:1.5rem;margin-bottom:12px">Your Artwork</h2>
            <p style="margin-bottom:22px">Artwork and files you send us remain your property. We use them only to produce the work you've requested and store them securely.</p>

            <h2 style="font-size:1.5rem;margin-bottom:12px">Contact</h2>
            <p>Questions about this policy? Email us at <a href="mailto:<?= htmlspecialchars($SITE['email']) ?>" style="color:var(--gold-deep)"><?= htmlspecialchars($SITE['email']) ?></a>.</p>
        </div>
    </div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
