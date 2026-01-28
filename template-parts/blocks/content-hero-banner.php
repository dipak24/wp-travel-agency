<?php
/**
 * Block Name: Hero banner | Slider
 *
 * This is the template that displays the Hero banner
 */
// Rendering in inserter preview 
if (isset($block['data']['block_preview_image'])):
	echo '<img src="' . $block['data']['block_preview_image'] . '" style="width:100%; height:auto;">';
endif;

// create id attribute for specific styling
$section_id = 'hero-section-one-' . $block['id'];
//Check for section padding
$section_padding = rha_get_block_style();
//Check if section is enable or disable
$section_enable = get_field('hero_banner_enable_section');

if ($section_enable && have_rows('rha_hero_image_banner_slider')) {
?>
<section id="<?php echo esc_attr($section_id); ?>" class="banner-slider swiper <?php echo $section_padding; ?>">
    <div class="swiper-wrapper">
        <?php
        $slide_index = 0;
        while (have_rows('rha_hero_image_banner_slider')) {
            the_row();
            $slide_index++;

            $banner_image = get_sub_field('rha_hero_slider_image');
            $banner_title = get_sub_field('hero_banner_title');
            $banner_subtitle = get_sub_field('hero_banner_subtitle');
            $buttonLink = get_sub_field('hero_banner_button_one');
            $buttonText = !empty($buttonLink['title']) ? $buttonLink['title'] : '';
            $buttonUrl = !empty($buttonLink['url']) ? $buttonLink['url'] : '#';
            $target = !empty($buttonLink['target']) ? $buttonLink['target'] : '_self';
            
            // Get image sizes for responsive images
            $img_xl = wp_get_attachment_image_src($banner_image['ID'], 'img_xl');
            $img_lg = wp_get_attachment_image_src($banner_image['ID'], 'img_lg');
            $img_md = wp_get_attachment_image_src($banner_image['ID'], 'img_md');
            $img_sm = wp_get_attachment_image_src($banner_image['ID'], 'img_sm');
            
            // Alt text for SEO
            $img_alt = get_post_meta($banner_image['ID'], '_wp_attachment_image_alt', true);
            $img_alt = $img_alt ? $img_alt : $banner_title;
            
            // Lazy load after first slide
            $loading = ($slide_index === 1) ? 'eager' : 'lazy';
            $fetchpriority = ($slide_index === 1) ? 'high' : 'auto';
            ?>
            <div class="swiper-slide">
                <!-- Responsive background image with picture element -->
                <picture class="banner-bg-picture">
                    <source media="(min-width: 1200px)" srcset="<?php echo esc_url($img_xl[0]); ?>">
                    <source media="(min-width: 768px)" srcset="<?php echo esc_url($img_lg[0]); ?>">
                    <source media="(min-width: 480px)" srcset="<?php echo esc_url($img_md[0]); ?>">
                    <img 
                        src="<?php echo esc_url($img_lg[0]); ?>" 
                        srcset="<?php echo esc_url($img_sm[0]); ?> 480w, 
                                <?php echo esc_url($img_md[0]); ?> 800w, 
                                <?php echo esc_url($img_lg[0]); ?> 1200w, 
                                <?php echo esc_url($img_xl[0]); ?> 1920w"
                        sizes="100vw"
                        alt="<?php echo esc_attr($img_alt); ?>"
                        class="banner-bg-image"
                        loading="<?php echo esc_attr($loading); ?>"
                        fetchpriority="<?php echo esc_attr($fetchpriority); ?>"
                        width="<?php echo esc_attr($img_xl[1]); ?>"
                        height="<?php echo esc_attr($img_xl[2]); ?>"
                    >
                </picture>
                
                <div class="container">
                    <div class="banner-text">
                        <?php if ($banner_title): ?>
                            <h2><?php echo esc_html($banner_title); ?></h2>
                        <?php endif; ?>
                        <?php echo esc_html($banner_subtitle); ?>
                        
                        <?php if ($buttonLink && $buttonText): ?>
                            <a href="<?php echo esc_url($buttonUrl); ?>" 
                               target="<?php echo esc_attr($target); ?>" 
                               class="btn"
                               <?php echo ($target === '_blank') ? 'rel="noopener noreferrer"' : ''; ?>>
                                <?php echo esc_html($buttonText); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    
    <a href="#banner-end" class="scroll-down" aria-label="Scroll down to content">
        <span></span>
    </a>
</section>
<div id="banner-end"></div>
<?php
}