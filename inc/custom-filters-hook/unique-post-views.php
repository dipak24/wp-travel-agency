<?php
/**
 * Track unique post visitors without storing IP addresses.
 *
 * Increments a custom field 'unique_post_views' for each unique visitor.
 * Uses cookies to track if a visitor has already been counted for a post.
 *
 * Excludes logged-in admins and counts only on single post views.
 */
function rha_track_unique_post_views_secure() {

    // Only single posts (exclude admin, preview, feeds)
    if (
        !is_single() ||
        is_admin() ||
        is_preview() ||
        wp_doing_ajax()
    ) {
        return;
    }

    global $post;
    if (!$post || empty($post->ID)) {
        return;
    }

    $post_id = (int) $post->ID;

    // Exclude logged-in admins
    if (current_user_can('manage_options')) {
        return;
    }

    // Create unique visitor fingerprint (NO IP STORAGE)
    $fingerprint = hash(
        'sha256',
        wp_get_session_token() . ($_SERVER['HTTP_USER_AGENT'] ?? '')
    );

    $cookie_name = 'rha_post_view_' . $post_id;

    // Already counted
    if (isset($_COOKIE[$cookie_name])) {
        return;
    }

    // Increment counter
    $views = (int) get_post_meta($post_id, 'unique_post_views', true);
    update_post_meta($post_id, 'unique_post_views', $views + 1);

    // Store cookie (30 days)
    setcookie(
        $cookie_name,
        $fingerprint,
        time() + (30 * DAY_IN_SECONDS),
        COOKIEPATH,
        COOKIE_DOMAIN,
        is_ssl(),   // Secure cookie on HTTPS
        true        // HttpOnly
    );
}
add_action('wp', 'rha_track_unique_post_views_secure');
