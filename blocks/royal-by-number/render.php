<?php
/**
 * Block Name: Royal by number block
 * Description: A custom Gutenberg block to display royal by number.
 * Category: eb-blocks
 */

// Block preview (Gutenberg)
if (!empty($block['data']['block_preview_image'])) {
    echo '<img src="' . esc_url($block['data']['block_preview_image']) . '" style="width:100%;height:auto;" alt="Block preview">';
    return;
}

// Enable check
if (!get_field('is_enable_royal_by_number_block')) {
    return;
}

// Unique ID & spacing
$section_id      = 'royal-by-number-' . esc_attr($block['id']);
$section_padding = rha_get_block_style();

// ACF fields
$section_title = get_field('rha_royal_by_number_title');
$section_description = get_field('rha_royal_by_number_description');
$numberLists = get_field('rha_royal_in_number_lists'); // ACF Image gallery field: retunr on array of ids

if (empty($numberLists) || !is_array($numberLists)) {
    return;
}
?>

<section id="<?php echo esc_attr($section_id); ?>" class="section royal-by-number-block <?php echo esc_attr($section_padding); ?>">
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
            <div class="col card-number">
                <div class="card-wrap">
                    <h3 class="title">116M</h3>
                    <p>Daily active uniques</p>
                </div>
            </div>

            <div class="col card-number">
                <div class="card-wrap">
                    <h3 class="title">443M+</h3>
                    <p>Weekly active uniques</p>
                </div>
            </div>

            <div class="col card-number">
                <div class="card-wrap">
                    <h3 class="title">100K+</h3>
                    <p>Active communities</p>
                </div>
            </div>

            <div class="col card-number">
                <div class="card-wrap">
                    <h3 class="title">23B+</h3>
                    <p>Posts & comments</p>
                </div>
            </div>
        </div>

    </div>
</section>
