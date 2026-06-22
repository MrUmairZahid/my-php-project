<?php
/**
 * Summit Prints logo (logooo.png).
 *   summit_logo('dark')  -> logo as-is (use on light backgrounds, e.g. header)
 *   summit_logo('light') -> whitened logo (use on dark backgrounds, e.g. footer)
 * The PNG has navy text, so the 'light' variant is whitened via CSS filter
 * to stay visible on dark backgrounds.
 */
function summit_logo($variant = 'dark') {
    $src = base_url('assets/img/logooo.png');
    return '<img class="site-logo site-logo--' . htmlspecialchars($variant) . '" '
        . 'src="' . htmlspecialchars($src) . '" alt="Summit Prints — Collaborate, Create, Conquer">';
}
