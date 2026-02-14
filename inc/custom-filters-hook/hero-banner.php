<?php
// Add JPEG compression quality
add_filter('jpeg_quality', function() { return 85; });
add_filter('wp_editor_set_quality', function() { return 85; });

// Preload first hero image for LCP optimization
function preload_hero_images() {
    if (is_front_page() || is_page()) {
        $frontpage_id = (int) get_option( 'page_on_front' );

        // Get the first hero image
        if (have_rows('rha_hero_image_banner_slider', $frontpage_id)) {
            the_row();
            
            $banner_image = get_sub_field('rha_hero_slider_image');
            if ($banner_image) {
                $img_xl = wp_get_attachment_image_src($banner_image['ID'], 'img_xl');
                $img_lg = wp_get_attachment_image_src($banner_image['ID'], 'img_lg');
                
                if ($img_xl) {
                    echo '<link rel="preload" as="image" href="' . esc_url($img_xl[0]) . '" media="(min-width: 1200px)">';
                    echo '<link rel="preload" as="image" href="' . esc_url($img_lg[0]) . '" media="(max-width: 1199px)">';
                }
            }
            reset_rows();
        }
    }
}
add_action('wp_head', 'preload_hero_images', 5);

// Lazy load images except hero
function add_lazy_load_except_hero($attr, $attachment, $size) {
    // Don't lazy load if it's a hero image size
    if ($size === 'img_xl' || $size === 'img_lg') {
        return $attr;
    }
    
    if (!isset($attr['loading'])) {
        $attr['loading'] = 'lazy';
    }
    
    return $attr;
}
add_filter('wp_get_attachment_image_attributes', 'add_lazy_load_except_hero', 10, 3);

// Add structured data for hero section
function add_hero_schema() {
    $frontpage_id = (int) get_option( 'page_on_front' );
    if (is_front_page() && have_rows('rha_hero_image_banner_slider', $frontpage_id)) {
        $slides = array();
        
        while (have_rows('rha_hero_image_banner_slider', $frontpage_id)) {
            the_row();
            $banner_image = get_sub_field('rha_hero_slider_image');
            $banner_title = get_sub_field('hero_banner_title');
            
            if ($banner_image) {
                $slides[] = array(
                    '@type' => 'ImageObject',
                    'url' => $banner_image['url'],
                    'name' => $banner_title,
                    'description' => get_sub_field('hero_banner_subtitle')
                );
            }
        }
        
        if (!empty($slides)) {
            $schema = array(
                '@context' => 'https://schema.org',
                '@type' => 'WebPage',
                'mainEntity' => array(
                    '@type' => 'ImageGallery',
                    'image' => $slides
                )
            );
            
            echo '<script type="application/ld+json">' . json_encode($schema) . '</script>';
        }
        
        reset_rows();
    }
}
add_action('wp_footer', 'add_hero_schema');
