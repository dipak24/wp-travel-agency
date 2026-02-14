<?php
/**
 * Block Name: Travel Style Explore Out
 */

// Block preview (Gutenberg)
if (!empty($block['data']['block_preview_image'])) {
    echo '<img src="' . esc_url($block['data']['block_preview_image']) . '" style="width:100%;height:auto;" alt="Block preview">';
    return;
}

// Enable check
if (!get_field('is_enable_travel_style_section')) {
    return;
}

// Unique ID & spacing
$section_id      = 'travel-style-' . esc_attr($block['id']);
$section_padding = rha_get_block_style();

// ACF fields
$section_title       = get_field('rha_travel_style_title');
$section_description = get_field('rha_travel_style_description');
$travel_styles       = get_field('rha_travel_style_lists'); // taxonomy term objects

if (empty($travel_styles) || !is_array($travel_styles)) {
    return;
}
?>

<section id="<?php echo esc_attr($section_id); ?>" class="section explore-out-block <?php echo esc_attr($section_padding); ?>">
    <div class="container">

        <!-- Section Heading -->
        <?php if ($section_title || $section_description): ?>
            <header class="heading-block text-center">
                <?php if ($section_title): ?>
                    <h2><?php echo esc_html($section_title); ?></h2>
                <?php endif; ?>

                <?php if ($section_description): ?>
                    <p><?php echo esc_html($section_description); ?></p>
                <?php endif; ?>
            </header>
        <?php endif; ?>

        <!-- Slider -->
        <div class="swiper explore-slider" aria-label="Travel styles slider">
            <div class="swiper-wrapper">

                <?php foreach ($travel_styles as $term): 
                    if (!($term instanceof WP_Term)) {
                        continue;
                    }

                    // Term data
                    $term_link  = get_term_link($term);
                    $term_name  = $term->name;
                    $term_desc  = term_description($term->term_id, $term->taxonomy);

                    // ACF term image
                    $term_image = get_field('rha_act_desc_feature_image', $term->taxonomy . '_' . $term->term_id); // Image ids
                ?>
                    <div class="swiper-slide card-explore">
                        <article class="card-wrap">

                            <div class="img-wrap">
                                <a href="<?php echo esc_url($term_link); ?>">
                                    <?php
                                    if ($term_image) {
                                        echo wp_get_attachment_image(
                                            $term_image,
                                            'img_sm',
                                            false,
                                            [
                                                'loading' => 'lazy',
                                                'decoding'=> 'async',
                                                'alt'     => esc_attr(
                                                    get_post_meta($term_image, '_wp_attachment_image_alt', true)
                                                    ?: $term_name
                                                ),
                                            ]
                                        );
                                    }
                                    ?>
                                </a>
                            </div>

                            <div class="text-wrap">
                                <h3 class="h6">
                                    <a href="<?php echo esc_url($term_link); ?>">
                                        <?php echo esc_html($term_name); ?>
                                    </a>
                                </h3>

                                <?php if ($term_desc): ?>
                                    <p><?php echo wp_trim_words(wp_strip_all_tags($term_desc), 14); ?></p>
                                <?php endif; ?>
                            </div>

                        </article>
                    </div>
                <?php endforeach; ?>

            </div>

            <!-- Navigation -->
            <div class="swiper-button swiper-button-prev" aria-label="Previous slide"></div>
            <div class="swiper-button swiper-button-next" aria-label="Next slide"></div>
        </div>

    </div>
</section>
