<?php
/**
 * The template for displaying Activity taxonomy pages.
 *
 * @package Royal_Holidays_Adventures
 */
get_header(); ?>
<div class="main" role="main" id="main">
    <!-- banner section -->
    <?php get_template_part( 'template-parts/taxonomy/section', 'banner' ); ?>

    <!-- Breadcrumbs -->
    <div class="container">
        <?php if (function_exists('rank_math_the_breadcrumbs')) { rank_math_the_breadcrumbs();} ?>
    </div>

    <!-- Activity Title & content Section -->
    <section class="section itinary-block pt-0">
        <div class="container">
            <div class="row">
                <div class="col col-content">
                    <div class="trip-content-heading">
                        <h1 class="h3"><?php single_term_title(); ?></h1>
                    </div>

                    <?php
                    $term_description = get_field('destination_detail_information', 'activity_' . get_queried_object()->term_id);

                    if ( ! empty( $term_description ) ) : ?>
                        <div class="term-description">
                            <?php echo wp_kses_post( $term_description ); ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col col-sidebar">
                    <div class="col-wrap">
                        <?php get_sidebar(); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Related Posts -->
     <section class="section tour-block">
        <div class="container">
           <header class="heading-block">
                <h2 class="h3"><?php esc_html_e( 'Related Trips', 'rha' ); ?></h2>

                <?php 
                echo term_description();
                ?>
            </header>
            
            <div class="row">
                <?php
                if ( have_posts() ) :
                    while ( have_posts() ) :
                        the_post();

                        get_template_part( 'template-parts/content', 'trip' );
                    endwhile;

                    // Pagination.
                    the_posts_pagination(
                        array(
                            'prev_text'          => esc_html__( 'Previous', 'buddyboss-theme' ),
                            'next_text'          => esc_html__( 'Next', 'buddyboss-theme' ),
                            'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'buddyboss-theme' ) . ' </span>',
                        )
                    );
                endif;
                ?>
            </div>
        </div>

     </section>
<?php
get_footer();
