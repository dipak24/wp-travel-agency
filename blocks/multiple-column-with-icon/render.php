<?php
/**
 * Block Name: Multiple Column With Icon Block
 * Description: A custom Gutenberg block to display multiple column with icon.
 * Category: eb-blocks
 */

// Block preview (Gutenberg)
if (!empty($block['data']['block_preview_image'])) {
    echo '<img src="' . esc_url($block['data']['block_preview_image']) . '" style="width:100%;height:auto;" alt="Block preview">';
    return;
}

// Enable check
if (!get_field('is_enable_multiple_column_with_icon_block')) {
    return;
}

// Unique ID & spacing
$section_id      = 'multiple-column-with-icon-' . esc_attr($block['id']);
$section_padding = rha_get_block_style();

// ACF fields
$section_title = get_field('rha_multiple_column_with_icon_title');
$section_description = get_field('rha_multiple_column_with_icon_description');
$multipleColumnDatas = get_field('rha_multiple_column_with_icon_lists'); // ACF Image gallery field: retunr on array of datas

if (empty($multipleColumnDatas) || !is_array($multipleColumnDatas)) {
    return;
}
?>

<section id="<?php echo esc_attr($section_id); ?>" class="section columns-with-icon-block three-columns <?php echo esc_attr($section_padding); ?>">
    <div class="container">

        <!-- Section Heading -->
        <?php if ($section_title || $section_description): ?>
            <header class="heading-block">
                <?php if ($section_title): ?>
                    <h2><?php echo esc_html($section_title); ?></h2>
                <?php endif; ?>

                <?php if ($section_description): ?>
                    <p><?php echo esc_html($section_description); ?></p>
                <?php endif; ?>
            </header>
        <?php endif; ?>

        <div class="row">
            <div class="col card-content-with-icon">
                <div class="card-wrap">
                    <a href="#"></a>
                    <span class="arrow">Arrow</span>
                    <div class="icon-wrap">
                        <img src="assets/images/icon-clock.svg" alt="image-description">
                    </div>
                    <div class="content-wrap">
                        <h3>Mobile App Development</h3>
                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Recusandae repellendus mollitia quod accusantium ipsa dicta libero cumque exercitationem, architecto voluptatibus, quo quas, dolor perspiciatis modi.</p>
                    </div>
                </div>
            </div>
            <div class="col card-content-with-icon">
                <div class="card-wrap">
                    <a href="#"></a>
                    <span class="arrow">Arrow</span>
                    <div class="icon-wrap">
                        <img src="assets/images/icon-clock.svg" alt="image-description">
                    </div>
                    <div class="content-wrap">
                        <h3>Mobile App Development</h3>
                        <p>Lorem, ipsum dolor sit amet, consectetur adipisicing elit. Debitis explicabo omnis inventore deleniti repudiandae adipisci.</p>
                    </div>
                </div>
            </div>
            <div class="col card-content-with-icon">
                <div class="card-wrap">
                    <a href="#"></a>
                    <span class="arrow">Arrow</span>
                    <div class="icon-wrap">
                        <img src="assets/images/icon-clock.svg" alt="image-description">
                    </div>
                    <div class="content-wrap">
                        <h3>Mobile App Development</h3>
                        <p>Lorem, ipsum dolor sit amet, consectetur adipisicing elit. Debitis explicabo omnis inventore deleniti repudiandae adipisci.</p>
                    </div>
                </div>
            </div>
            <div class="col card-content-with-icon">
                <div class="card-wrap">
                    <a href="#"></a>
                    <span class="arrow">Arrow</span>
                    <div class="icon-wrap">
                        <img src="assets/images/icon-clock.svg" alt="image-description">
                    </div>
                    <div class="content-wrap">
                        <h3 class="h4">Mobile App Development</h3>
                        <p>Lorem, ipsum dolor sit amet, consectetur adipisicing elit. Debitis explicabo omnis inventore deleniti repudiandae adipisci.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
