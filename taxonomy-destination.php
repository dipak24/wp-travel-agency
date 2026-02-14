<?php
/**
 * The template for displaying destination taxonomy pages.
 *
 * @package Royal_Holidays_Adventures
 */
$current_term = get_queried_object();

if (!$current_term || empty($current_term->term_id)) {
    return;
}

$child_destinations = get_terms(array(
    'taxonomy' => 'destination',
    'parent' => $current_term->term_id,
    'hide_empty' => false,
));

get_header();

?>
<div class="main" role="main" id="main">
    <!-- banner section -->
    <?php get_template_part('template-parts/taxonomy/section', 'banner'); ?>

    <!-- Breadcrumbs -->
    <section class="section pb-0">
        <div class="container">
            <?php if (function_exists('rank_math_the_breadcrumbs')) {
                rank_math_the_breadcrumbs();
            } ?>
        </div>
    </section>

    <!-- Activity Title & content Section -->
    <section class="section itinary-block pt-0">
        <div class="container">
            <div class="row">
                <div class="col col-content">
                    <div class="trip-content-heading">
                        <h1 class="h3"><?php single_term_title(); ?></h1>
                    </div>

                    <?php
                    $term_description = get_field('destination_detail_information', 'destination_' . get_queried_object()->term_id);

                    if (!empty($term_description)): ?>
                        <div class="term-description">
                            <?php echo wp_kses_post($term_description); ?>
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

            <?php if (!empty($child_destinations) && !is_wp_error($child_destinations)): ?>

                <!-- Child Destinations -->
                <header class="heading-block">
                    <h2 class="h3">
                        <?php esc_html_e('Explore Popular ' . single_term_title('', false) . ' Destinations', 'rha'); ?>
                    </h2>
                </header>

                <div class="row destination-grid">

                    <?php foreach ($child_destinations as $child):
                        $term_link = get_term_link($child);
                        $thumbnail = get_field('rha_act_desc_feature_image', 'destination_' . $child->term_id);
                        $total_packages = $child->count;
                        ?>

                        <article class="col card-tour">
                            <div class="card-wrap">

                                <!-- Image -->
                                <figure class="img-wrap">
                                    <?php if ($total_packages > 0): ?>
                                        <a href="<?php echo esc_url($term_link); ?>" class="chip">
                                            <?php
                                            /* translators: %s: Number of packages */
                                            printf(esc_html__('%s Trips', 'rha'), esc_html($total_packages));
                                            ?>
                                        </a>
                                    <?php endif; ?>

                                    <?php
                                    if ($thumbnail) {
                                        echo wp_get_attachment_image(
                                            $thumbnail,
                                            'img_md',
                                            [
                                                'loading' => 'lazy',
                                                'decoding' => 'async',
                                                'alt' => esc_attr(
                                                    get_post_meta($thumbnail, '_wp_attachment_image_alt', true)
                                                    ?: $child->name
                                                ),
                                            ]
                                        );
                                    }
                                    ?>
                                </figure>

                                <!-- Content -->
                                <div class="text-wrap">
                                    <h3 class="tour-title">
                                        <a href="<?php echo esc_url($term_link); ?>">
                                            <?php echo esc_html($child->name); ?>
                                        </a>
                                    </h3>

                                    <?php if ($child->description): ?>
                                        <div class="card-program">
                                            <p><?php echo esc_html($child->description); ?></p>
                                        </div>
                                    <?php endif; ?>

                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>

                </div>

            <?php else: ?>
                <!-- Associated Trips -->
                <header class="heading-block">
                    <h2 class="h3"><?php esc_html_e('Related Trips', 'rha'); ?></h2>
                </header>

                <div class="row">
                    <?php
                    if (have_posts()):
                        while (have_posts()):
                            the_post();
                            get_template_part('template-parts/content', 'trip');
                        endwhile;

                        the_posts_pagination();
                    endif;
                    ?>
                </div>

            <?php endif; ?>

        </div>
    </section>

    <!-- Section for fixed departure lists -->
    <section class="section section-fixed-departure pt-0">
        <div class="container">
            <div class="row">
                <div class="col col-content">
                    <div class="trip-content-heading">
                        <h2 class="h3">Join Fixed Departure Trips</h2>
                        <p>Join our Fixed Departure trip. Perfect for a solo traveler and friends who like trekking with
                            others.</p>
                    </div>

                    <?php dwt_list_available_departures(); ?>
                </div>
            </div>
        </div>
    </section>

    <?php
    get_footer();
