<?php
/**
 * Block Name: Blog Listing
 *
 * This is the template that displays the Blog Listing block. 
 */

/* Rendering in inserter preview */
if (isset($block['data']['block_preview_image'])) :
    echo '<img src="' . $block['data']['block_preview_image'] . '" style="width:100%; height:auto;">';
endif;

/* create id attribute for specific styling */
$section_id = 'blog-listing-' . $block['id'];

/* Check for section padding */
$section_padding = rha_get_block_style();

/* Check if section is enable or disable */
$section_enable = get_field('blog_listing_enable_section');
$section_title = get_field('rha_blog_listing_section_title');

if ($section_enable) {
    $posts_per_page = 9;
    $num_page = (get_query_var('paged')) ? absint(get_query_var('paged')) : 1;

    /* GET Data */
    $get_data = ($_GET);
    $search_blog = isset($get_data['title']) ? isset($get_data['title']) : ''; 
    $search_field = array(
        'finalurl'      => home_url(),
        'search_blog'   => $search_blog,
    ); ?>

    <!-- blog listing -->
    <section id="<?php echo esc_attr($section_id); ?>" class="section blog-listing <?php echo esc_attr($section_padding);?>">
        <div class="container">
            <div class="heading-block d-flex">
                <h2><?php echo esc_html($section_title); ?></h2>

                <?php 
                get_template_part('template-parts/search-form/blog', 'search', $search_field); ?>
            </div>
            <div class="row">
                <div class="col-lg-3 col-xl-2">
                    <?php get_sidebar('blog'); ?>
                </div>
                
                <div class="col-lg-9 col-xl-10">
                    <div class="blog-post">
                        <div class="blog-post-wrap">
                            
                            <?php
                            $exclude_posts = array();
                            $args = array(
                                'post_type'      => 'post',
                                'posts_per_page' => $posts_per_page,
                                'paged'          => $num_page,
                                'orderby'        => 'date',
                                'order'          => 'DESC',
                            );
                            
                            if($search_blog) {
                                $args['s'] = $search_blog;
                            }
                            
                            $query = new WP_Query( $args );
                            
                            if ( $query->have_posts() ) { ?>
                                <div class="row">
                                    <?php while ( $query->have_posts() ) {
                                        $query->the_post();
                                        $exclude_posts[] = get_the_ID();
                                        
                                        echo '<div class="col card-blog">';
                                            get_template_part( 'template-parts/grid-layouts/grid', 'blog' );
                                        echo '</div>';

                                    } wp_reset_postdata(); ?>
                                
                                </div>

                                <div class="col">
                                    <div class="pagination">
                                        <?php
                                        rha_pagination($query); ?>
                                    </div>
                                </div>
                            <?php 
                            } else { ?>
								<p><?php esc_html_e('No posts found', 'rha'); ?></p>
							<?php 
                            } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php }
