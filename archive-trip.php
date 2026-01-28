<?php
/**
 * Template Name: Trip Listing
 * Description: Ajax-powered trip listing page with filters
 */

get_header();
?>
<main id="main" role="main">
    <section class="section tour-listing-block">
        <div class="container">
            <div class="tour-lists-wrap">
                <aside class="sidebar">
                    <div class="sidebar-wrap">
                        <form id="tour-filter-form" class="tour-filter" method="post">
                            <!-- Filter Price -->
                            <div class="filter-group">
                                <h3 class="filter-title">Filter Price</h3>
                                <div class="box-slide">
                                    <input 
                                        type="range" 
                                        name="max_price" 
                                        min="100" 
                                        max="10000" 
                                        value="5000" 
                                        class="range"
                                        step="100" 
                                        id="price-range"
                                    />
                                    <div class="price-label">
                                        $<span id="min-price-display">100</span> - $<span id="max-price-display">500</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Filter by Duration -->
                            <div class="filter-group">
                                <h3 class="filter-title">By Durations</h3>
                                <div class="box-slide">
                                    <ul class="duration-lists">
                                        <li>
                                            <label for="min-duration">Min Duration (days):</label>
                                            <input 
                                                type="number" 
                                                name="min_duration" 
                                                min="0" 
                                                value="0" 
                                                id="min-duration"
                                            />
                                        </li>
                                        <li>
                                            <label for="max-duration">Max Duration (days):</label>
                                            <input 
                                                type="number" 
                                                name="max_duration" 
                                                min="0" 
                                                value="30" 
                                                id="max-duration"
                                            />
                                        </li>
                                    </ul>
                                </div>
                            </div>

                             <!-- Filter by Destinations -->
                            <div class="filter-group">
                                <h3 class="filter-title">By Destinations</h3>
                                <div class="box-slide">
                                    <ul class="check-list">
                                        <?php
                                        $destinations = get_terms(array(
                                            'taxonomy' => 'destination',
                                            'hide_empty' => true,
                                        ));
                                        
                                        if (!empty($destinations) && !is_wp_error($destinations)) :
                                            foreach ($destinations as $destination) : ?>
                                                <li>
                                                    <div class="checkbox-list">
                                                        <input 
                                                            type="checkbox" 
                                                            name="destinations[]" 
                                                            value="<?php echo esc_attr($destination->term_id); ?>" 
                                                            id="destination-<?php echo esc_attr($destination->term_id); ?>"
                                                        >
                                                        <label for="destination-<?php echo esc_attr($destination->term_id); ?>">
                                                            <?php echo esc_html($destination->name); ?>
                                                        </label>
                                                    </div>
                                                    <span class="badge"><?php echo esc_html($destination->count); ?></span>
                                                </li>
                                            <?php endforeach;
                                        endif; ?>
                                    </ul>
                                </div>
                            </div>

                            <!-- Filter by Activities -->
                            <div class="filter-group">
                                <h3 class="filter-title">By Activities</h3>
                                <div class="box-slide">
                                    <ul class="check-list">
                                        <?php
                                        $activities = get_terms(array(
                                            'taxonomy' => 'activity',
                                            'hide_empty' => false,
                                        ));
                                        
                                        if (!empty($activities) && !is_wp_error($activities)) :
                                            foreach ($activities as $activity) : ?>
                                                <li>
                                                    <div class="checkbox-list">
                                                        <input 
                                                            type="checkbox" 
                                                            name="activities[]" 
                                                            value="<?php echo esc_attr($activity->term_id); ?>" 
                                                            id="activity-<?php echo esc_attr($activity->term_id); ?>"
                                                        >
                                                        <label for="activity-<?php echo esc_attr($activity->term_id); ?>">
                                                            <?php echo esc_html($activity->name); ?>
                                                        </label>
                                                    </div>
                                                    <span class="badge"><?php echo esc_html($activity->count); ?></span>
                                                </li>
                                            <?php endforeach;
                                        endif; ?>
                                    </ul>
                                </div>
                            </div>

                            <!-- Reset Button -->
                            <div class="filter-group">
                                <button type="button" id="reset-filters" class="btn btn-secondary">Reset Filters</button>
                            </div>
                        </form>
                    </div>
                </aside>

                <div class="content-wrap">
                    <!-- Loading Overlay -->
                    <div id="tours-loading" class="tours-loading" style="display: none;">
                        <div class="spinner"></div>
                    </div>

                    <!-- Trips Container -->
                    <div id="tours-container" class="tour-lists">
                        <?php
                        // Initial trip query
                        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                        
                        $args = array(
                            'post_type' => 'trip',
                            'posts_per_page' => 9,
                            'paged' => $paged,
                            'post_status' => 'publish',
                        );
                        
                        $trip_query = new WP_Query($args);
                        
                        if ($trip_query->have_posts()) :
                            while ($trip_query->have_posts()) : $trip_query->the_post();
                                get_template_part('template-parts/content', 'trip-card');
                            endwhile;
                        else :
                            echo '<p class="no-tours-found">No trips found matching your criteria.</p>';
                        endif;
                        ?>
                    </div>

                    <!-- Pagination Container -->
                    <div id="pagination-container" class="pagination">
                        <?php
                        if ($trip_query->max_num_pages > 1) :
                            echo paginate_links(array(
                                'total' => $trip_query->max_num_pages,
                                'current' => $paged,
                                'prev_text' => __('Previous'),
                                'next_text' => __('Next'),
                                'type' => 'list',
                            ));
                        endif;
                        wp_reset_postdata();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php
get_footer();
