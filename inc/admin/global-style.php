<?php
function rha_enqueue_admin_styles() {
    // Enqueue your global-style.php file
    $h1_font_size =  48;
    $h2_font_size =  38;
    $h3_font_size =  32;
    $h4_font_size =  28;
    $h5_font_size =  24;
    $h6_font_size =  20;
    $body_font_size =  16;

    //Color
    $primary_color = '#ff8c00';
    $secondary_color = '#1b6394';
    $secondary_alt_color = '#23527c';
    $body_color = '#fff';
    $body_text_color = '#000';
    $body_text_color_secondary = '#385cdd';
    $tonal_primary_color = '#385cdd';
    $tonal_secondary_color = '#385cdd';

    //Button Style
    $border_radius = '2';
    $custom_css_content = "
        :root {
            /* Font Size */
            --h1-font-size: " . (!empty($h1_font_size) ? esc_attr($h1_font_size) / 16 . 'rem' : '56/16 rem') . ";
            --h2-font-size: " . (!empty($h2_font_size) ? esc_attr($h2_font_size) / 16 . 'rem' : '48/16 rem') . ";
            --h3-font-size: " . (!empty($h3_font_size) ? esc_attr($h3_font_size) / 16 . 'rem' : '40/16 rem') . ";
            --h4-font-size: " . (!empty($h4_font_size) ? esc_attr($h4_font_size) / 16 . 'rem' : '32/16 rem') . ";
            --h5-font-size: " . (!empty($h5_font_size) ? esc_attr($h5_font_size) / 16 . 'rem' : '24/16 rem') . ";
            --h6-font-size: " . (!empty($h6_font_size) ? esc_attr($h6_font_size) / 16 . 'rem' : '20/16 rem') . ";
            --body-font-size: " . esc_attr($body_font_size) / 16 . 'rem' . ";
            /* Color */
            --primary-color: " . esc_attr($primary_color) . ";
            --secondary-color: " . esc_attr($secondary_color) . ";
            --body-color: " . esc_attr($body_color) . ";
            --body-text-color: " . esc_attr($body_text_color) . ";
            --body-text-color-secondary: " . esc_attr($body_text_color_secondary) . ";
            --tonal-primary-color: " . esc_attr($tonal_primary_color) . ";
            --tonal-secondary-color: " . esc_attr($tonal_secondary_color) . ";
            /* border radius */
            --border-radius: " . esc_attr($border_radius) / 16 . 'rem' . ";
        }";
        wp_add_inline_style('rha-travel-style', $custom_css_content);
        wp_add_inline_style('rha-travel-admin-style',$custom_css_content);
    }

/* Access dashboard while ACF plugin is not active */
if ( class_exists('ACF') ) {
    add_action('admin_enqueue_scripts', 'rha_enqueue_admin_styles');
}
add_action('enqueue_block_assets', 'rha_enqueue_admin_styles');