<?php
require_once __DIR__ . '/config.php';
$current = $current ?? 'home';
$page_title = $page_title ?? $SITE['name'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title) ?> &mdash; <?= htmlspecialchars($SITE['name']) ?></title>
    <meta name="description" content="Thread Tapes — embroidery digitizing, vector art, custom logos and website works. Where threads meet quality.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>
<body>
<header class="site-header" id="top">
    <div class="container header-inner">
        <a href="<?= base_url('index.php') ?>" class="brand" aria-label="<?= htmlspecialchars($SITE['name']) ?> home">
            <?= summit_logo('dark') ?>
        </a>

        <button class="nav-toggle" aria-label="Toggle menu" aria-expanded="false">
            <span></span><span></span><span></span>
        </button>

        <nav class="main-nav">
            <ul>
                <li><a class="<?= active('home', $current) ?>" href="<?= base_url('index.php') ?>">Home</a></li>
                <li><a class="<?= active('about', $current) ?>" href="<?= base_url('about.php') ?>">About</a></li>
                <li class="has-dropdown">
                    <a class="<?= active('portfolio', $current) ?>" href="<?= base_url('portfolio.php') ?>">Portfolios &#9662;</a>
                    <ul class="dropdown">
                        <li><a href="<?= base_url('portfolio.php?type=vector') ?>">Vector</a></li>
                        <li><a href="<?= base_url('portfolio.php?type=digitizing') ?>">Digitizing</a></li>
                        <li><a href="<?= base_url('portfolio.php?type=website') ?>">Website</a></li>
                    </ul>
                </li>
                <li><a class="<?= active('mockup', $current) ?>" href="<?= base_url('designer.php') ?>">Design Studio</a></li>
                <li><a class="btn-quote<?= active('quote', $current) ?>" href="<?= base_url('quote.php') ?>">Get a Patch Quote</a></li>
                <li><a class="<?= active('contact', $current) ?>" href="<?= base_url('contact.php') ?>">Contact</a></li>
            </ul>
        </nav>
    </div>
</header>
<main>
