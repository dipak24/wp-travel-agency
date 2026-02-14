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
$link         = get_field('half_image_half_content_link');
$underline    = get_field('half_image_half_content_underline') ? 'bg-line' : '';

/**
 * Button values
 */
$btn_url    = !empty($link['url']) ? esc_url($link['url']) : '';
$btn_title  = !empty($link['title']) ? esc_html($link['title']) : '';
$btn_target = !empty($link['target']) ? esc_attr($link['target']) : '_self';
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
                            <h2 class="h2 <?php echo esc_attr($underline); ?>">
                                <?php echo esc_html($title); ?>
                            </h2>
                        <?php endif; ?>

                        <?php
                        // Allow safe HTML from editor
                        if ($description) {
                            echo wp_kses_post($description);
                        }
                        ?>

                        <?php if ($btn_url && $btn_title): ?>
                            <a href="<?php echo $btn_url; ?>"
                               class="btn"
                               target="<?php echo $btn_target; ?>">
                                <?php echo $btn_title; ?>
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
                                'img_md',
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
