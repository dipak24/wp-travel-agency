<?php
get_header(); 
?>
	<main id="primary" class="site-main site-main--contents">
        <section id="hero-section-one-block_5876ba001b6df5136ab815f46e9e5d4b" class="section section-banner page-banner d-flex align-items-center p-medium">
            <div class="container">
                <div class="section-heading text-start" style="max-width: 70rem;">
                    <h1 class="section-heading__title text-white "> <?php the_title(); ?></h1>
                </div>
            </div>
            <div class="background-image">
                <img fetchpriority="high" decoding="async" width="1600" height="320" src="<?php echo home_url();?>/wp-content/uploads/2025/01/inner-small-banner.jpg" class="attachment-background-image size-background-image" alt="" loading="eager">
            </div>
        </section>
        <section class="breadcrumb-block">
            <div class="container">
                <?php if (function_exists('rank_math_the_breadcrumbs')) rank_math_the_breadcrumbs(); ?>
            </div>
        </section>
        <section class="section review-details pt-5 pb-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="review-details-content">
                            <?php
                            while (have_posts()) :
                                the_post();
                                $reviewerName = get_field('reviewer_name');
                                $reviewerRating = get_field('rating');
                                ?>
                                <div class="review-rating mb-2">
                                    <span class="review-stars">
                                        <?php
                                        for ($i = 1; $i <= 5; $i++) {
                                            if ($i <= $reviewerRating) {
                                                echo '<span class="dashicons dashicons-star-filled" style="color: #f1c40f;"></span>';
                                            } else {
                                                echo '<span class="dashicons dashicons-star-empty" style="color: #ccc;"></span>';
                                            }
                                        }
                                        ?>
                                    </span>
                                    <?php if ($reviewerName) {
                                        echo '<br/><strong>' . esc_html__('Reviewer name', 'Royal_Holidays_Adventures') . '</strong>: ' . ucFirst($reviewerName);  
                                    }
                                    ?>
                                </div>
                                <?php
                                the_content();
                            endwhile;
                            ?>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="trip-details-sidebar">
                            <?php
                            if (is_active_sidebar('trip-sidebar')) {
                                dynamic_sidebar('trip-sidebar');
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
	</main>

<?php get_footer();