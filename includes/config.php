<?php
/**
 * Site-wide configuration & shared data for the Thread Tapes replica.
 */

// Base URL helper — works whether the site lives at the web root or a sub-folder.
function base_url($path = '') {
    $dir = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');
    // When the script sits in the project root this is the folder; normalize trailing slash.
    return $dir . '/' . ltrim($path, '/');
}

// Mark the active nav item.
function active($page, $current) {
    return $page === $current ? ' active' : '';
}

require_once __DIR__ . '/logo.php';

$SITE = [
    'name'    => 'Summit Prints',
    'tagline' => 'Collaborate, Create, Conquer',
    'phone'   => '(347) 706-3039',
    'email'   => 'info@threadtapes.com',
    'address' => '803 S Florida Street #4, Arlington, VA 22204',
    'instagram' => '#',
];

$SERVICES = [
    [
        'icon'  => 'logo',
        'tag'   => 'Custom Logo',
        'title' => 'Custom Logo Works',
        'text'  => 'Need something new for your new business? We got you! All custom works come with unlimited edits.',
        'link'  => 'quote.php',
    ],
    [
        'icon'  => 'thread',
        'tag'   => 'Digitizing',
        'title' => 'Embroidery Digitizing',
        'text'  => "Digitizing is what we started our company with (hint: it's in the name) and that's what we do best!",
        'link'  => 'portfolio.php?type=digitizing',
    ],
    [
        'icon'  => 'web',
        'tag'   => 'Websites',
        'title' => 'Website Works',
        'text'  => 'We know websites are the foundation of a new business so we offer them on a subscription basis (no burden on you homie!)',
        'link'  => 'portfolio.php?type=website',
    ],
    [
        'icon'  => 'vector',
        'tag'   => 'Vector Arts',
        'title' => 'Vector Arts',
        'text'  => 'We can get your pixelated, low quality, skewed & badly photographed artwork into a full-fledged vector art.',
        'link'  => 'portfolio.php?type=vector',
    ],
];

// Vector showcase images — used both in the Portfolios > Vector grid and as the
// background slideshow on the home "Vector Arts" service tile.
$VECTOR_SHOTS = [
    'assets/img/portfolio/vector-1.png',
    'assets/img/portfolio/vector-2.png',
    'assets/img/portfolio/vector-3.png',
    'assets/img/portfolio/vector-4.png',
];

// Custom Logo showcase images — Portfolios > Logo grid + home "Custom Logo Works" slideshow.
$LOGO_SHOTS = [
    'assets/img/portfolio/logo-1.png',
    'assets/img/portfolio/logo-2.png',
    'assets/img/portfolio/logo-3.png',
    'assets/img/portfolio/logo-4.png',
];

// Website showcase images — Portfolios > Website grid + home "Website Works" slideshow.
$WEBSITE_SHOTS = [
    'assets/img/portfolio/website-1.jpg',
    'assets/img/portfolio/website-2.jpg',
    'assets/img/portfolio/website-3.avif',
    'assets/img/portfolio/website-4.avif',
];

// Embroidery digitizing showcase images — Portfolios > Digitizing grid + home "Embroidery Digitizing" slideshow.
$DIGITIZING_SHOTS = [
    'assets/img/portfolio/digitizing-1.png',
    'assets/img/portfolio/digitizing-2.webp',
    'assets/img/portfolio/digitizing-3.jpg',
    'assets/img/portfolio/digitizing-4.jpg',
];

$WHY = [
    ['title' => '24/7 Service',     'text' => 'Round-the-clock support — send your files any time, day or night.'],
    ['title' => 'Affordable',       'text' => 'Premium quality work at prices that respect your budget.'],
    ['title' => 'Rush Jobs',        'text' => 'Tight deadline? We turn rush orders around fast without cutting corners.'],
    ['title' => 'No Edit Charges',  'text' => 'Unlimited edits on every order until it is exactly right.'],
    ['title' => 'Customer Service', 'text' => 'Real people, real answers — we treat every client like family.'],
    ['title' => 'Machine Sewout',   'text' => 'Every design is tested on the machine so it stitches perfectly.'],
];

$STATS = [
    ['label' => 'Custom Logos',          'value' => 1200],
    ['label' => 'Vector Conversion',     'value' => 3400],
    ['label' => 'Embroidery Digitizing', 'value' => 5600],
    ['label' => 'Websites & Webapps',    'value' => 85],
];

$TESTIMONIALS = [
    ['name' => 'Jason Barton',       'role' => 'Owner', 'text' => 'Their digitizing work is high quality, fast, and reasonably priced.'],
    ['name' => 'Calah Voisin',       'role' => 'Owner', 'text' => 'Great work and fast turnaround.'],
    ['name' => 'James Clark',        'role' => 'Owner', 'text' => 'Great customer service fast turn around.'],
    ['name' => 'Monica Normanpeters','role' => 'Owner', 'text' => 'They do great work.'],
    ['name' => 'William Shaw',       'role' => 'Owner', 'text' => 'Jack gives great service and on time vector files and does color separation.'],
    ['name' => 'Glenn Reineke',      'role' => 'Owner', 'text' => 'Great Digitizing work — quality is great as well as pricing and customer service.'],
];
