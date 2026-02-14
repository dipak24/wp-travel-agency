<?php
/**
 * Block Name: Fixed departures
 */

// Block preview (Gutenberg)
if (!empty($block['data']['block_preview_image'])) {
    echo '<img src="' . esc_url($block['data']['block_preview_image']) . '" style="width:100%;height:auto;" alt="Block preview">';
    return;
}

// Enable check
if (!get_field('is_enable_fixed_departures_section')) {
    return;
}

// Unique ID & spacing
$section_id      = 'fixed-departures-' . esc_attr($block['id']);
$section_padding = rha_get_block_style();

// ACF fields
$section_title       = get_field('rha_fixed_departures_title');
$section_description = get_field('rha_fixed_departures_description');
$trip_id = get_field('rha_fixed_departures_trip_id'); // taxonomy term objects

if (empty($trip_id)) {
    return;
}
?>

<section id="<?php echo esc_attr($section_id); ?>" class="section deal-offer-block <?php echo esc_attr($section_padding); ?>">
    <div class="container">

        <!-- Section Heading -->
        <?php 
        if ($section_title || $section_description): ?>
            <header class="heading-block">
                <?php if ($section_title): ?>
                    <h2><?php echo esc_html($section_title); ?></h2>
                <?php endif; ?>

                <?php if ($section_description): ?>
                    <p><?php echo esc_html($section_description); ?></p>
                <?php endif; ?>
            </header>
            <?php 
        endif;

        // If trip ID is provided, list departures for that trip, otherwise list all fixed departures
        if ($trip_id) {
            dwt_list_available_departures(intval($trip_id));
        } else {
            wt_list_available_departures();
        }
        ?>
    </div>
</section>
