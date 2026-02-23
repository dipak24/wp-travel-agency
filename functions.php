<?php
/**
 * Royal Holidays Adventures functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Royal_Holidays_Adventures
 */

if ( !defined('RHA_THEME_VERSION') ) {
	define('RHA_THEME_VERSION', rand(1,100));
}

/* Message while ACF plugin not activated */
if ( !class_exists('ACF') && !is_admin() ){
	die('ACF plugin is required for the theme');
}

define('RHA_THEME_PARENT_URL', get_template_directory_uri());
define('RHA_THEME_IMAGES_DIR', RHA_THEME_PARENT_URL . '/assets/images');
define('RHA_ASSETS_DIR', RHA_THEME_PARENT_URL . '/assets');

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function rha_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on Royal Holidays Adventures, use a find and replace
		* to change 'rha' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'rha', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'primary' => esc_html__( 'Primary menu', 'rha' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			//'comment-form',
			//'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'rha_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 108,
			'width'       => 124,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);

	/**
	 * Universal image system
	 * Works for blog, trek, banner, gallery
	*/
	add_image_size('img_xl', 1920, 1080, false); // Hero / Banner / Background
	add_image_size('img_lg', 1200, 675, true);  // Featured / Banner (16:9 ratio)
	add_image_size('img_md', 800, 450, true);   // Tablet devices
	add_image_size('img_sm', 480, 270, true);   // Mobile devices
	add_image_size('img_xs', 150, 150, true);   // icons or avatar
}
add_action( 'after_setup_theme', 'rha_setup' );

// Disable default image sizes
add_filter('intermediate_image_sizes_advanced', function ($sizes) {
	unset($sizes['thumbnail']);
	unset($sizes['medium']);
	unset($sizes['medium_large']);
	unset($sizes['large']);
	return $sizes;
});

//Enabled block editor in term pages
add_filter('use_block_editor_for_term', '__return_true');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function rha_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'rha_content_width', 640 );
}
add_action( 'after_setup_theme', 'rha_content_width', 0 );

/**
 * Enqueue scripts and styles.
 */
function rha_scripts() {
	wp_enqueue_style('rha-swiper', RHA_ASSETS_DIR . '/css/swiper.min.css', array(), RHA_THEME_VERSION);
	wp_enqueue_style('rha-fancybox', RHA_ASSETS_DIR . '/css/fancybox.min.css', array(), RHA_THEME_VERSION);
	wp_enqueue_style( 'rha-style', get_stylesheet_uri(), array(), RHA_THEME_VERSION );
	wp_enqueue_style( 'dashicons' ); // Dashicons for admin icons on frontend

	//scripts
	wp_enqueue_script( 'rha-swiper', RHA_ASSETS_DIR . '/js/swiper.min.js', array(), RHA_THEME_VERSION, true );
	wp_enqueue_script( 'rha-fancybox', RHA_ASSETS_DIR . '/js/fancybox.min.js', array(), RHA_THEME_VERSION, true );
	wp_enqueue_script( 'rha-main', RHA_ASSETS_DIR . '/js/main.js', array(), RHA_THEME_VERSION, true );
	
	// Register trip filter script only on trip archive page
	if (is_archive('trip') || is_post_type_archive('trip')) {
		wp_enqueue_script( 'rha-trip-filter', RHA_ASSETS_DIR . '/js/trip-filter.js', array(), RHA_THEME_VERSION, true );
	}
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	$ajax_nonce = wp_create_nonce('ajax_callback_nonce');

	$array = array(
		'ajax_url'   => esc_url(admin_url('admin-ajax.php')),
		'ajax_nonce' => $ajax_nonce,
		'home_url' => home_url(),
	);

	// Localize script only on trip archive page
	if (is_archive('trip') || is_post_type_archive('trip')) {
		wp_localize_script('rha-trip-filter', 'ajax_callback_data', $array);
	}
}
add_action( 'wp_enqueue_scripts', 'rha_scripts' );

// Defer Swiper JS for better performance
function defer_swiper_js($tag, $handle) {
    if ('swiper' !== $handle) {
        return $tag;
    }
    return str_replace(' src', ' defer src', $tag);
}
add_filter('script_loader_tag', 'defer_swiper_js', 10, 2);

/**
 * Include function filesz
 */
require get_template_directory() . '/inc/include/directory.php';

//hide WordPress version
remove_action('wp_head', 'wp_generator');
function searchForId($id, $array) {
	foreach ($array as $key => $val) {
		if ($val->slug === $id) {
			return $key;
		}
	}
	return null;
 }

// Register ACF blocks with block.json
add_action('init', function () {

    $blocks_dir = get_template_directory() . '/blocks';

    if (!is_dir($blocks_dir)) {
        return;
    }

    $blocks = scandir($blocks_dir);

    foreach ($blocks as $block) {

        if ($block === '.' || $block === '..') {
            continue;
        }

        $block_path = $blocks_dir . '/' . $block;

        if (
            is_dir($block_path) &&
            file_exists($block_path . '/block.json')
        ) {
            register_block_type($block_path);
        }
    }
});

/**
 * Trip Filter AJAX Functions
 * Handles filtering trips via AJAX
 */
function ajax_filter_tours() {
    // Verify nonce for security
    check_ajax_referer('ajax_callback_nonce', 'ajax_nonce');

    // Sanitize and validate inputs
    $paged = isset($_POST['paged']) ? absint($_POST['paged']) : 1;
    $max_price = isset($_POST['max_price']) ? floatval($_POST['max_price']) : 500;
    $min_duration = isset($_POST['min_duration']) ? absint($_POST['min_duration']) : 0;
    $max_duration = isset($_POST['max_duration']) ? absint($_POST['max_duration']) : 30;
    
    // Sanitize arrays
    $activities = isset($_POST['activities']) ? array_map('absint', $_POST['activities']) : array();
    $destinations = isset($_POST['destinations']) ? array_map('absint', $_POST['destinations']) : array();

    // Build query arguments
    $args = array(
        'post_type'      => 'trip',
        'posts_per_page' => 9,
        'paged'          => $paged,
        'post_status'    => 'publish',
    );

    // Meta query for price and duration
    $meta_query = array('relation' => 'AND');

    if ($max_price < 500) {
        $meta_query[] = array(
            'key'     => 'trip_sale_price',
            'value'   => $max_price,
            'type'    => 'NUMERIC',
            'compare' => '<=',
        );
    }

    if ($min_duration > 0 || $max_duration < 30) {
        $meta_query[] = array(
            'key'     => 'trip_duration',
            'value'   => array($min_duration, $max_duration),
            'type'    => 'NUMERIC',
            'compare' => 'BETWEEN',
        );
    }

    if (count($meta_query) > 1) {
        $args['meta_query'] = $meta_query;
    }

    // Tax query for activities and destinations
    $tax_query = array('relation' => 'AND');

    if (!empty($activities)) {
        $tax_query[] = array(
            'taxonomy' => 'activity',
            'field'    => 'term_id',
            'terms'    => $activities,
            'operator' => 'IN',
        );
    }

    if (!empty($destinations)) {
        $tax_query[] = array(
            'taxonomy' => 'destination',
            'field'    => 'term_id',
            'terms'    => $destinations,
            'operator' => 'IN',
        );
    }

    if (count($tax_query) > 1) {
        $args['tax_query'] = $tax_query;
    }

    // Execute query
    $trip_query = new WP_Query($args);

    // Prepare response
    $response = array(
        'success' => false,
        'html'    => '',
        'pagination' => '',
        'found_posts' => 0,
    );

    if ($trip_query->have_posts()) {
        ob_start();
        
        while ($trip_query->have_posts()) {
            $trip_query->the_post();
            get_template_part('template-parts/content', 'trip-card');
        }
        
        $response['html'] = ob_get_clean();
        $response['found_posts'] = $trip_query->found_posts;

        // Generate pagination
        if ($trip_query->max_num_pages > 1) {
            ob_start();
            echo paginate_links(array(
                'total'     => $trip_query->max_num_pages,
                'current'   => $paged,
                'prev_text' => __('Previous'),
                'next_text' => __('Next'),
                'type'      => 'list',
            ));
            $response['pagination'] = ob_get_clean();
        }

        $response['success'] = true;
    } else {
        $response['html'] = '<p class="no-tours-found">No trips found matching your criteria.</p>';
        $response['success'] = true;
    }

    wp_reset_postdata();

    // Send JSON response
    wp_send_json($response);
}

// Register AJAX handlers for both logged-in and non-logged-in users
add_action('wp_ajax_filter_tours', 'ajax_filter_tours');
add_action('wp_ajax_nopriv_filter_tours', 'ajax_filter_tours');

