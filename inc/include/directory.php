<?php 

/*********************************************
 * All the required files are included here
 ********************************************/


 /**
 * Custom acf field option.
 */
require get_template_directory() . '/inc/admin/acf-field-option.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/admin/customizer.php';

/**
 * For Style variable.
 */
require get_template_directory() . '/inc/admin/global-style.php';

/**
 * get_field of acf field.
 */
require get_template_directory() . '/inc/acf-get-field.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/blog-meta.php';

/**
 * Starterkit custom fuctions.
 */
require get_template_directory() . '/inc/custom-function.php';

/**
 * Custom Gravity Forms functions.
 */
require get_template_directory() . '/inc/gravity-form.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
    require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Register widget area.
 */
require get_template_directory() . '/inc/pagination-function.php';

/**
 * Register widget area.
 */
require get_template_directory() . '/inc/register-widget.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Starterkit register theme options.
 */
require get_template_directory() . '/inc/theme-options.php';

/**
 * Custom ACF Gutenberg block category.
 */
require get_template_directory() . '/inc/acf-blocks/register-acf-block-category.php';

/**
 * Custom ACF Gutenberg blocks.
 */
require get_template_directory() . '/inc/acf-blocks/register-acf-blocks.php';

/**
 * Custom render callback function for ACF Gutenberg blocks.
 */
require get_template_directory() . '/inc/acf-blocks/render-acf-callback.php';

/**
 * custom filter hook.
 */
require get_template_directory() . '/inc/custom-filters-hook/hero-banner.php';

/**
 * Custom post views tracking.
 */
require get_template_directory() . '/inc/custom-filters-hook/unique-post-views.php';

/**
 * Add mega menu walker.
 */
require get_template_directory() . '/inc/class-rha-mega-menu-walker.php';

/**
 * Filter class for mega menu.
 */
require get_template_directory() . '/inc/acf-filters/nav-mega-menu.php';