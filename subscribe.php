<?php
$current = '';
$page_title = 'Newsletter';

$ok = false;
$email = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        @file_put_contents(__DIR__ . '/storage/subscribers.log', date('Y-m-d H:i') . ' ' . $email . "\n", FILE_APPEND | LOCK_EX);
        $ok = true;
    }
}
require __DIR__ . '/includes/header.php';
?>
<section class="page-hero">
    <div class="container">
        <h1><?= $ok ? "You're subscribed!" : 'Subscription' ?></h1>
        <p><?= $ok ? 'Thanks for joining the Thread Tapes newsletter.' : 'We could not process that email address.' ?></p>
    </div>
</section>
<section>
    <div class="container" style="text-align:center">
        <p style="margin-bottom:24px"><?= $ok
            ? htmlspecialchars($email) . ' has been added to our list. Watch your inbox for tips and updates.'
            : 'Please go back and enter a valid email address.' ?></p>
        <a href="<?= base_url('index.php') ?>" class="btn btn-dark">Back to Home</a>
    </div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
