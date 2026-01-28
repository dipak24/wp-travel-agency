<?php
/**
 * Block Name: Sidebar accourdion with faq lists
 *
 * This is the template that displays the Feature Ten to Eleven block.
*/
remove_filter('the_content', 'wpautop');

// Rendering in inserter preview
if (isset($block['data']['block_preview_image'])):
    echo '<img src="' . $block['data']['block_preview_image'] . '" style="width:100%; height:auto;">';
endif;

// create id attribute for specific styling
$section_id = 'image-accordion-' . $block['id'];

//Check for section padding
$section_padding = rha_get_block_style();

//Check if section is enable or disable
$section_enable = get_field('full_width_faq_enable_section');
if ($section_enable) { 
    $section_title = get_field('full_width_faq_title');
    ?>
    <section id="<?php echo esc_attr($section_id); ?>" class="section sidebar-with-accordion <?php echo $section_padding; ?>">
        <div class="container">
            <?php if ( ! empty($section_title) ) : ?>
                <div class="trip-content-heading">
                    <h2 class="h3"><?php echo $section_title; ?></h2>
                </div>
            <?php endif; ?>

            <?php if ( have_rows('full_width_faq_accordion_item') ) : ?>
            <div class="row">
                <!-- SIDEBAR -->
                <div class="col col-sidebar">
                    <div class="sidebar-wrap">
                        <ul>
                            <?php
                            $i = 1;
                            while ( have_rows('full_width_faq_accordion_item') ) : the_row();
                                $topic_title = get_sub_field('topic_title');
                            ?>
                                <li>
                                    <a class="sidebar-link <?php echo ($i === 1) ? 'active' : ''; ?>" href="#tab<?php echo $i; ?>">
                                        <?php echo esc_html($topic_title); ?>
                                    </a>
                                </li>
                            <?php $i++; endwhile; ?>
                        </ul>
                    </div>
                </div>

                <!-- CONTENT -->
                <div class="col col-content">
                    <div class="col-wrap">
                        <div class="accordion-lists">

                            <?php
                            $tab = 1;
                            while ( have_rows('full_width_faq_accordion_item') ) : the_row();
                                $topic_title = get_sub_field('topic_title');
                            ?>
                            <div id="tab<?php echo $tab; ?>" class="accordion-list">

                                <div class="accordion-heading">
                                    <h3><?php echo esc_html($topic_title); ?></h3>
                                    <a href="#" class="btn-toggle">Expand All</a>
                                </div>

                                <?php if ( have_rows('rha_faq_lists') ) : ?>
                                <div class="accordion">

                                    <?php while ( have_rows('rha_faq_lists') ) : the_row();
                                        $title = get_sub_field('title');
                                        $description = get_sub_field('description');
                                        $image = get_sub_field('image');
                                    ?>
                                    <div class="accordion-item">
                                        <strong class="title">
                                            <?php echo esc_html($title); ?>
                                        </strong>

                                        <div class="slide">
                                            <div class="slide-wrap">

                                                <?php if ( $image ) : ?>
                                                    <img 
                                                        src="<?php echo esc_url($image['url']); ?>"
                                                        alt="<?php echo esc_attr($image['alt']); ?>"
                                                        loading="lazy"
                                                    >
                                                <?php endif; ?>

                                                <?php if ( $description ) : ?>
                                                    <?php echo wp_kses_post($description); ?>
                                                <?php endif; ?>

                                            </div>
                                        </div>
                                    </div>
                                    <?php endwhile; ?>

                                </div>
                                <?php endif; ?>

                            </div>
                            <?php $tab++; endwhile; ?>

                        </div>
                    </div>
                </div>

            </div>
            <?php endif; ?>
        </div>
    </section>
<?php }
