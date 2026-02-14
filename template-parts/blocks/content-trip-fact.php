<?php

/**

 * Block Name: Trip Info | Trip Facts

 *

 * This is the template that displays the trip information.

 */

remove_filter('the_content', 'wpautop');

// Rendering in inserter preview 

if (isset($block['data']['block_preview_image'])):

    echo '<img src="' . $block['data']['block_preview_image'] . '" style="width:100%; height:auto;">';

endif;

// create id attribute for specific styling

$section_id = 'trip-info-' . $block['id'];



//Check if section is enable or disable

$section_enable = get_field('trip_fact_filter_enable_section');

if ($section_enable && have_rows('trip_fact_details_lists') ) {

    $section_title = get_field('fact_section_title');

    $description = get_field('fact_section_description');

    //Check for section padding

    $section_padding = rha_get_block_style();

    ?>
    <div class="trip-content-card <?php echo $section_padding; ?>" id="<?php echo esc_attr($section_id); ?>">
        <div class="trip-content-heading">
            <?php 
            if (!empty($section_title) ) { 
                echo "<h2>";
                echo esc_html($section_title);
                echo "</h2>";
            }
            ?>
        </div>
        <div class="overview-lists" >
            <?php while( have_rows('trip_fact_details_lists') ) : the_row(); ?>

                <div class="overview-list">

                    <?php 

                    $icon = get_sub_field('rha_trip_fact_icon');

                    $description = get_sub_field('fact_description');

                    if( $icon): ?>

                        <div class="icon-wrap" style="position: relative;">

                            <img src="<?php echo esc_url($icon['url']); ?>" alt="<?php echo esc_attr($icon['alt']); ?>">



                            <?php if( $description ): ?>

                                <span class="info-tooltip">i

                                    <span class="tooltip-text"><?php echo esc_html($description); ?></span>

                                </span>

                            <?php endif; ?>

                        </div>

                    <?php else: ?>

                        <div class="icon-wrap">

                            <img src="<?php echo RHA_THEME_IMAGES_DIR. '/icons/home-white.svg'?>" alt="trip fact icon">

                        </div>

                    <?php endif; ?>

                    <div class="text-wrap">

                        <span class="tagline"><?php the_sub_field('fact_title'); ?></span>

                        <span class="title"><?php the_sub_field('fact_value'); ?></span>

                    </div>

                </div>

            <?php endwhile; ?>
        </div>
    </div>

<?php }