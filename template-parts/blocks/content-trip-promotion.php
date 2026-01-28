<?php
/**
 * Block Name: Trip Promotion
 */

// Block preview image (Gutenberg)
if (!empty($block['data']['block_preview_image'])) {
    echo '<img src="' . esc_url($block['data']['block_preview_image']) . '" style="width:100%;height:auto;" alt="Block preview">';
    return;
}

// Section enable check
if (!get_field('is_enabled_trip_promotion')) {
    return;
}

// Unique ID
$section_id      = 'trip-promotion-' . esc_attr($block['id']);
$section_padding = rha_get_block_style();

// ACF fields
$main_title       = get_field('rha_trip_promotion_title');
$description_main = get_field('rha_trip_promotion_description');
?>

<section id="<?php echo esc_attr($section_id); ?>" class="section trip-block <?php echo esc_attr($section_padding); ?>">
    <div class="container">

        <?php if ($main_title || $description_main): ?>
            <header class="heading-block">
                <?php if ($main_title): ?>
                    <h2><?php echo esc_html($main_title); ?></h2>
                <?php endif; ?>

                <?php if ($description_main): ?>
                    <p><?php echo esc_html($description_main); ?></p>
                <?php endif; ?>
            </header>
        <?php endif; ?>

        <?php if (have_rows('rha_promotion_details')): ?>
            <div class="row">

                <?php while (have_rows('rha_promotion_details')): the_row();

                    $image_id = get_sub_field('promotion_background_image'); // Image ID
                    $title    = get_sub_field('promotion_text');
                    $button   = get_sub_field('promotion_button');

                    // Button values
                    $link        = $button['url']    ?? '';
                    $buttonTitle = $button['title']  ?? '';
                    $target      = $button['target'] ?? '_self';
                    ?>

                    <div class="col card-trip">
                        <div class="card-wrap">

                            <?php if ($image_id): ?>
                                <figure class="img-wrap">
                                    <?php
                                    echo wp_get_attachment_image(
                                        $image_id,
                                        'img_md',
                                        false,
                                        [
                                            'loading' => 'lazy',
                                        ]
                                    );
                                    ?>
                                </figure>
                            <?php endif; ?>

                            <div class="text-wrap">
                                <?php if ($title): ?>
                                    <h4><?php echo esc_html($title); ?></h4>
                                <?php endif; ?>

                                <?php if ($link && $buttonTitle): ?>
                                    <a
                                        href="<?php echo esc_url($link); ?>"
                                        class="btn small"
                                        target="<?php echo esc_attr($target); ?>"
                                        rel="<?php echo ($target === '_blank') ? 'noopener noreferrer' : ''; ?>"
                                    >
                                        <?php echo esc_html($buttonTitle); ?>
                                    </a>
                                <?php endif; ?>
                            </div>

                        </div>
                    </div>

                <?php endwhile; ?>

            </div>
        <?php endif; ?>

    </div>
</section>
