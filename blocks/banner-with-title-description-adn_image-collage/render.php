<?php
/**
 * Block Name: Banner With Title Subtitle & Image Collage
 * Description: A custom Gutenberg block to display a grid of images.
 * Category: eb-blocks
 */

// Block preview (Gutenberg)
if (!empty($block['data']['block_preview_image'])) {
    echo '<img src="' . esc_url($block['data']['block_preview_image']) . '" style="width:100%;height:auto;" alt="Block preview">';
    return;
}

// Enable check
if (!get_field('is_enable_image_grid_block')) {
    return;
}

// Unique ID & spacing
$section_id      = 'image-grid-' . esc_attr($block['id']);
$section_padding = rha_get_block_style();

// ACF fields
$section_title = get_field('rha_image_grid_title');
$section_description = get_field('rha_image_grid_description');
$imageIds = get_field('rha_image_grid_lists'); // ACF Image gallery field: retunr on array of ids

if (empty($imageIds) || !is_array($imageIds)) {
    return;
}
?>

<section id="<?php echo esc_attr($section_id); ?>" class="section image-grid-block <?php echo esc_attr($section_padding); ?>">
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
        
       <div class="images-grid">
            <div class="top-images">
                <div class="row">
                    <div class="col col-1">
                        <div class="img-wrap">
                            <img src="assets/images/banner1.jpg" alt="image description">
                        </div>
                    </div>
                    <div class="col col-2">
                        <div class="img-wrap">
                            <img src="assets/images/img-tour1.png" alt="image description">
                        </div>
                    </div>
                </div>
            </div>

            <div class="bottom-images">
                <div class="row">
                    <div class="col col-1">
                        <div class="img-wrap">
                            <img src="assets/images/banner2.jpg" alt="image description">
                        </div>
                    </div>
                    <div class="col col-2">
                        <div class="img-wrap">
                            <img src="assets/images/explore1.jpg" alt="image description">
                        </div>
                    </div>
                    <div class="col col-3">
                        <div class="img-wrap">
                            <img src="assets/images/img-trip1.png" alt="image description">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
