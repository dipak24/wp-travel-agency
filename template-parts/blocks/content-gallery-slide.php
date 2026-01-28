<?php
/**
 * Block Name: Image Gallery Lists
 */

// Block preview image (Gutenberg)
if (!empty($block['data']['block_preview_image'])) {
    echo '<img src="' . esc_url($block['data']['block_preview_image']) . '" style="width:100%;height:auto;" alt="Block preview">';
    return;
}

// Section enable check
if (!get_field('rha_page_gallery_enable_section')) {
    return;
}

// Unique ID
$section_id      = 'gallery-' . esc_attr($block['id']);
$section_padding = rha_get_block_style();

// ACF fields
$main_title        = get_field('rha_gallery_slider_title');
$description_main  = get_field('rha_gallery_slider_description');
$gallery_posts     = get_field('rha_gallery_slider_lists'); // Post IDs
?>

<section id="<?php echo esc_attr($section_id); ?>" class="section gallery-block <?php echo esc_attr($section_padding); ?>">
    <div class="container">

        <?php if ($main_title || $description_main): ?>
            <header class="heading-block text-center">
                <?php if ($main_title): ?>
                    <h2><?php echo esc_html($main_title); ?></h2>
                <?php endif; ?>

                <?php if ($description_main): ?>
                    <p><?php echo esc_html($description_main); ?></p>
                <?php endif; ?>
            </header>
        <?php endif; ?>

        <?php if (!empty($gallery_posts) && is_array($gallery_posts)): ?>
            <div class="swiper gallery-slider">
                <div class="swiper-wrapper">

                    <?php foreach ($gallery_posts as $post_id): ?>

                        <?php
                        if (get_post_status($post_id) !== 'publish') {
                            continue;
                        }

                        $title     = get_the_title($post_id);
                        $permalink = get_permalink($post_id);
                        ?>

                        <div class="swiper-slide card-gallery">
                            <div class="card-wrap">

                                <a href="<?php echo esc_url($permalink); ?>" class="gallery-link" aria-label="<?php echo esc_attr($title); ?>">
                                    <span class="icon-image" aria-hidden="true"></span>

                                    <?php
                                    if (has_post_thumbnail($post_id)) {
                                        echo get_the_post_thumbnail(
                                            $post_id,
                                            'img_md',
                                            [
                                                'alt'   => esc_attr($title),
                                                'loading' => 'lazy'
                                            ]
                                        );
                                    }
                                    ?>
                                </a>

                                <h3 class="h5">
                                    <a href="<?php echo esc_url($permalink); ?>">
                                        <?php echo esc_html($title); ?>
                                    </a>
                                </h3>

                            </div>
                        </div>

                    <?php endforeach; ?>

                </div>

                <div class="swiper-button swiper-button-prev" aria-label="Previous slide"></div>
                <div class="swiper-button swiper-button-next" aria-label="Next slide"></div>
            </div>
        <?php endif; ?>

    </div>
</section>
