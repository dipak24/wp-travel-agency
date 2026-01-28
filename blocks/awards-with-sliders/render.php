<?php
/**
 * Awards With Slider – Render
 */

// Preview image in block inserter
if (!empty($block['data']['block_preview_image'])) {
    echo '<img src="' . esc_url($block['data']['block_preview_image']) . '" style="width:100%;height:auto;" alt="">';
    return;
}

// Enable check
if (!get_field('awards_slider_enable')) {
    return;
}

// ID
$section_id = !empty($block['anchor'])
    ? esc_attr($block['anchor'])
    : 'awards-slider-' . esc_attr($block['id']);
$section_padding = rha_get_block_style();

// Fields   
$description = get_field('awards_slider_description');
?>

<section id="<?php echo esc_attr($section_id); ?>" class="section content-with-award-slider <?php echo esc_attr($section_padding); ?>">
    <div class="container">
        <div class="row">

            <!-- Content Column -->
            <div class="col col-description">
                <div class="col-wrap">
                    <?php echo wp_kses_post($description); ?>
                    <div class="btn-wrap show-desktop">
                        <button class="award-prev" aria-label="Previous awards">Prev</button>
                        <button class="award-next" aria-label="Next awards">Next</button>
                    </div>
                </div>
            </div>

            <!-- Slider Column -->
            <div class="col col-award-slider">
                <div class="col-wrap">
                    <?php if (have_rows('rha_awards_with_slider', 'option')): ?>
                        <div class="swiper award-slider">
                            <div class="swiper-wrapper">

                                <?php while (have_rows('rha_awards_with_slider', 'option')): the_row();
                                    $image_id = get_sub_field('award_certification_image');
                                    $a_title  = get_sub_field('award_title');
                                    $a_desc   = get_sub_field('award_sub_title');
                                ?>
                                    <div class="swiper-slide">
                                        <div class="award-card">
                                            <div class="img-wrap">
                                                <?php
                                                if ($image_id) {
                                                    echo wp_get_attachment_image(
                                                        $image_id,
                                                        'img_sm',
                                                        false,
                                                        [
                                                            'loading' => 'lazy',
                                                            'decoding'=> 'async',
                                                            'alt'     => esc_attr(
                                                                get_post_meta($image_id, '_wp_attachment_image_alt', true)
                                                                ?: $a_title
                                                            ),
                                                            'sizes'   => '(max-width:480px) 120px, 160px'
                                                        ]
                                                    );
                                                }
                                                ?>
                                            </div>

                                            <div class="text-wrap">
                                                <?php if ($a_title): ?>
                                                    <h3 class="h5"><?php echo esc_html($a_title); ?></h3>
                                                <?php endif; ?>

                                                <?php if ($a_desc): ?>
                                                    <p><?php echo esc_html($a_desc); ?></p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endwhile; ?>

                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="btn-wrap hide-desktop">
                        <button class="award-prev" aria-label="Previous awards">Prev</button>
                        <button class="award-next" aria-label="Next awards">Next</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

