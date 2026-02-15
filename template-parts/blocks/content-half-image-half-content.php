<?php
/**
 * Block Name: Half Image Half Content
 */

// Gutenberg preview image
if (!empty($block['data']['block_preview_image'])) {
    echo '<img src="' . esc_url($block['data']['block_preview_image']) . '" style="width:100%;height:auto;" alt="Block preview">';
    return;
}

// Section enable check (early return = performance boost)
if (!get_field('half_image_half_content_enable_section')) {
    return;
}

/**
 * Section ID (anchor support)
 */
$section_id = !empty($block['anchor'])
    ? sanitize_title($block['anchor'])
    : 'half-content-half-image-' . esc_attr($block['id']);

/**
 * Layout & styles
 */
$section_padding = rha_get_block_style();
$image_position  = get_field('half_image_half_content_image_position') === 'left'
    ? 'image-left'
    : 'image-right';

/**
 * ACF Fields
 */
$image        = get_field('half_image_half_content_image'); // image ID
$title        = get_field('half_image_half_content_title');
$subtitle     = get_field('half_image_half_content_sub_title');
$description  = get_field('half_image_half_content_description');
$linkPrimary  = get_field('half_image_half_content_link');
$linkSecondary = get_field('half_image_half_content_link_2');
$underline    = get_field('half_image_half_content_underline') ? ' has-border' : '';

/**
 * Primary button values
 */
$btn_url    = !empty($linkPrimary['url']) ? esc_url($linkPrimary['url']) : '';
$btn_title  = !empty($linkPrimary['title']) ? esc_html($linkPrimary['title']) : '';
$btn_target = !empty($linkPrimary['target']) ? esc_attr($linkPrimary['target']) : '_self';

/**
 * Secondary button values
 */
$btn_secondary_url    = !empty($linkSecondary['url']) ? esc_url($linkSecondary['url']) : '';
$btn_secondary_title  = !empty($linkSecondary['title']) ? esc_html($linkSecondary['title']) : '';
$btn_secondary_target = !empty($linkSecondary['target']) ? esc_attr($linkSecondary['target']) : '_self';
?>

<section id="<?php echo esc_attr($section_id); ?>"
    class="section half-content-half-image-block <?php echo esc_attr("$image_position $section_padding"); ?>">

    <div class="container">
        <div class="row">

            <!-- Content Column -->
            <div class="col col-content">
                <div class="col-wrap">
                    <div class="text-wrap">

                        <?php if ($subtitle): ?>
                            <strong class="h5-subtitle">
                                <?php echo esc_html($subtitle); ?>
                            </strong>
                        <?php endif; ?>

                        <?php if ($title): ?>
                            <div class="heading <?php echo esc_attr($underline); ?>">
                                <h2><?php echo wp_kses($title, getAllowedHtmlTags()); ?></h2>
                            </div>
                        <?php endif; ?>

                        <?php
                        // Allow safe HTML from editor
                        if ($description) {
                            echo wp_kses_post($description);
                        }
                        ?>
                    </div>
                    <div class="btn-wrap mt-4">
                        <?php if ($btn_url && $btn_title): ?>
                            <a href="<?php echo $btn_url; ?>"
                               class="btn"
                               target="<?php echo $btn_target; ?>">
                                <?php echo $btn_title; ?>
                            </a>
                        <?php endif; ?>

                        <?php if ($btn_secondary_url && $btn_secondary_title): ?>
                            <a href="<?php echo $btn_secondary_url; ?>"
                               class="btn outline"
                               target="<?php echo $btn_secondary_target; ?>">
                                <?php echo $btn_secondary_title; ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Image Column -->
            <?php if ($image): ?>
                <div class="col col-image">
                    <div class="col-wrap">
                        <div class="img-wrap">
                            <?php
                            echo wp_get_attachment_image(
                                (int) $image,
                                'img_lg',
                                false,
                                [
                                    'loading'  => 'lazy',
                                    'decoding' => 'async',
                                    'sizes'    => '(max-width: 768px) 100vw, 50vw',
                                ]
                            );
                            ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>
</section>
