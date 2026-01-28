<?php
/**
 * Block Name: Trip Include & Exclude
 *
 * This is the template that displays the trip include and exclude base on select type:
 */
remove_filter('the_content', 'wpautop');

// Rendering in inserter preview 
if ( isset($block['data']['block_preview_image']) ) {
    echo '<img src="' . esc_url($block['data']['block_preview_image']) . '" style="width:100%; height:auto;">';
    return;
}

// create id attribute for specific styling
$section_id = 'trip-inc-exc-' . $block['id'];

//Check for section padding
$section_padding = rha_get_block_style();

//Check if section is enable or disable
$section_enable = get_field('trip_fact_filter_enable_section');
if ($section_enable) {
    $section_title = get_field('content_section_title');
    $description = get_field('section_descripton');
    ?>
    <div id="<?php echo esc_attr($section_id); ?>" class="trip-content-card <?php echo $section_padding; ?>">
        <div class="trip-content-heading">
            <?php if (!empty($section_title) ) { ?>
                <h2 class="h3"><?php echo esc_html($section_title); ?></h2>
            <?php } ?>
        </div>

        <?php if( have_rows('rha_trip_include_exclude_lists') ): ?>
        <ul class="include-lists">
            <?php while( have_rows('rha_trip_include_exclude_lists') ) : the_row(); 
                $isInclude = get_sub_field('is_include');
                $item_text = get_sub_field('rha_pkg_title');

                if( $isInclude) { ?>
                    <li>
                        <img src="<?php echo RHA_THEME_IMAGES_DIR; ?>/icons/icon-tick-circle.svg" alt="Tick" width="24" height="24">
                        <span><?php echo esc_html($item_text); ?></span>
                    </li>
                <?php } else {  ?>
                    <li>
                        <img src="<?php echo RHA_THEME_IMAGES_DIR; ?>/icons/icon-cross-circle.svg" alt="Cross" width="24" height="24">
                        <span><?php echo esc_html($item_text); ?></span>
                    </li>
                <?php } ?>
            <?php endwhile; ?>
        </ul>
        <?php endif; ?>

        <?php
        // Description 
        if ( !empty($description) ) { ?>
            <div class="trip-fact__wrap-desc">
                <?php echo wpautop(wp_kses_post($description)); ?>
            </div>
        <?php } ?>
    </div>
<?php } ?>
