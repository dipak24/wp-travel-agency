<?php
/**
 * Block Name: Trip Details Itinerary
 *
 * This is the template that displays the details trip itinerary lits:
 */
remove_filter('the_content', 'wpautop');
// Rendering in inserter preview 
if (isset($block['data']['block_preview_image'])):
    echo '<img src="' . $block['data']['block_preview_image'] . '" style="width:100%; height:auto;">';
endif;

// create id attribute for specific styling
$section_id = 'trip-itinerary-' . $block['id'];

// create align class ("alignwide") from block setting ("wide")
$align_class = $block['align'] ? 'align' . $block['align'] : '';


//Check for section padding
$section_padding = rha_get_block_style();

//Check if section is enable or disable
$section_enable = get_field('trip_fact_filter_enable_section');
if ($section_enable) {
    $section_title = get_field('itinerary_section_title');
    $description = get_field('itinerary_section_descripton');
?>
<div id="<?php echo esc_attr($section_id); ?>" class="trip-content-card <?php echo $section_padding; ?>">
    <div class="trip-content-heading">
        <?php if (!empty($section_title) ) { ?>
            <h2 class="h3"><?php echo esc_html($section_title); ?></h2>
            <a href="#" class="toggle-all-accordion">Show All</a>
        <?php } ?>
    </div>

    <?php if ($description) { ?>
        <div class="short-info">
            <?php echo wpautop(wp_kses_post($description)); ?>
        </div>
    <?php } ?>

    <?php 
    $rows = get_field('itl_detail_itinerary');
    if( $rows ): 
        $total = count($rows);
        ?>
        <div class="itinary-accordion">
            <?php
            while( have_rows('itl_detail_itinerary') ) : the_row();
                $title = get_sub_field('title');
                $description = get_sub_field('description');
                $short_description = get_sub_field('short_description');
                ?>
                <div class="accordion-list">
                    <?php if (get_row_index() === 1 ) { ?>
                        <img src="<?php echo esc_url(RHA_THEME_IMAGES_DIR . '/icons/icon-map-point-wave.svg'); ?>" alt="start point">
                    <?php } elseif (get_row_index() === $total) { ?>
                        <img src="<?php echo esc_url(RHA_THEME_IMAGES_DIR . '/icons/icon-flag.svg'); ?>" alt="end point">
                    <?php } else {} ?>

                    <div class="accordion-list-wrap">
                        <div class="accordion-heading">
                            <?php if ( !empty($title) ) { ?>
                                <h3 class="h5"><?php echo esc_html($title); ?></h3>
                            <?php } ?>

                            <ul>
                                <?php if (get_sub_field('accommodation')) { ?>
                                    <li>
                                        <div class="icon-wrap">
                                            <img src="<?php echo esc_url(RHA_THEME_IMAGES_DIR . '/icons/home.svg'); ?>" alt="icon" width="24" height="24" />
                                        </div>
                                        <div class="text-wrap">
                                            <strong class="title">Accomodation: </strong>
                                            <span class="text"><?php echo get_sub_field('accommodation'); ?></span>
                                        </div>
                                    </li>
                                <?php } ?>

                                <?php if (get_sub_field('meals')) { ?>
                                <li>
                                    <div class="icon-wrap">
                                        <img src="<?php echo esc_url(RHA_THEME_IMAGES_DIR . '/icons/meals.svg'); ?>" alt="icon" width="24" height="24" />
                                    </div>
                                    <div class="text-wrap">
                                        <strong class="title">Meals: </strong>
                                        <span class="text"><?php echo get_sub_field('meals'); ?></span>
                                    </div>
                                </li>
                                <?php } ?>

                                <?php if (get_sub_field('elevation')) { ?>
                                <li>
                                    <div class="icon-wrap">
                                        <img src="<?php echo esc_url(RHA_THEME_IMAGES_DIR . '/icons/elevation-walk.svg'); ?>" alt="icon" width="24" height="24" />
                                    </div>
                                    <div class="text-wrap">
                                        <strong class="title">Elevation: </strong>
                                        <span class="text"><?php echo get_sub_field('elevation'); ?></span>
                                    </div>
                                </li>
                                <?php } ?>

                                <?php if (get_sub_field('duration')) { ?>
                                <li>
                                    <div class="icon-wrap">
                                        <img src="<?php echo esc_url(RHA_THEME_IMAGES_DIR . '/icons/clock.svg'); ?>" alt="icon" width="24" height="24" />
                                    </div>
                                    <div class="text-wrap">
                                        <strong class="title">Duration: </strong>
                                        <span class="text"><?php echo get_sub_field('duration'); ?></span>
                                    </div>
                                </li>
                                <?php } ?>
                                
                                <?php if (get_sub_field('itl_distance')) { ?>
                                <li>
                                    <div class="icon-wrap">
                                        <img src="<?php echo esc_url(RHA_THEME_IMAGES_DIR . '/icons/clock.svg'); ?>" alt="icon" width="24" height="24" />
                                    </div>
                                    <div class="text-wrap">
                                        <strong class="title">Distance: </strong>
                                        <span class="text"><?php echo get_sub_field('itl_distance'); ?></span>
                                    </div>
                                </li>
                                <?php } ?>
                            </ul>
                        </div>
                        <div class="accordion-slide">
                            <div class="slide-wrap">
                               <?php echo $description; ?>
                            </div>
                        </div>

                       <?php if ( !empty($short_description) ) { ?>
                            <div class="short-description">
                                <p><?php echo esc_html($short_description); ?></p>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php
            endwhile; ?>
        </div>
    <?php endif; ?>
</div>
<?php }