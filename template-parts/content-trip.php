<?php
/**
 * Block Name: Trip content
 */
$post_id = get_the_ID();

$average_rating = get_post_meta($post_id, 'average_rating', true);
$total_reviews  = get_post_meta($post_id, 'total_reviews', true);
$duration       = get_post_meta($post_id, 'trip_duration', true);
$group_size     = get_post_meta($post_id, 'trip_group_size', true);
$price          = get_post_meta($post_id, 'trip_sale_price', true);
$trip_grade     = get_post_meta($post_id, 'trip_grade', true);

$permalink = get_permalink($post_id);
$title     = get_the_title($post_id);
?>

<article class="col card-tour">
    <div class="card-wrap">

        <!-- Image -->
        <figure class="img-wrap">
            <a href="<?php echo esc_url($permalink); ?>" class="chip">Top Rated</a>

            <?php
            if (has_post_thumbnail($post_id)) {
                echo get_the_post_thumbnail(
                    $post_id,
                    'img_md',
                    [
                        'alt'   => esc_attr($title),
                        'loading' => 'lazy'
                    ]
                );
            }
            ?>
        </figure>

        <!-- Content -->
        <div class="text-wrap">

            <?php if ($average_rating): ?>
                <div class="card-rating">
                    <span class="rating">
                        <?php echo esc_html($average_rating); ?>
                        <?php if ($total_reviews): ?>
                            <span class="review">
                                (<?php echo esc_html($total_reviews); ?> reviews)
                            </span>
                        <?php endif; ?>
                    </span>
                </div>
            <?php endif; ?>

            <h3 class="tour-title">
                <a href="<?php echo esc_url($permalink); ?>">
                    <?php echo esc_html($title); ?>
                </a>
            </h3>

            <div class="card-program">
                <ul class="tour-list">
                    <?php if ($duration): ?>
                        <li class="duration"><?php echo esc_html($duration); ?></li>
                    <?php endif; ?>

                    <?php if ($group_size): ?>
                        <li class="guest"><?php echo esc_html($group_size); ?></li>
                    <?php endif; ?>

                    <?php if ($trip_grade): ?>
                        <li class="grade"><?php echo esc_html($trip_grade); ?></li>
                    <?php endif; ?>
                </ul>

                <?php if ($price): ?>
                    <div class="card-pricing">
                        <strong class="price">
                            $<?php echo esc_html($price); ?>
                            <sub>/ person</sub>
                        </strong>

                        <div class="btn-wrap">
                            <a href="<?php echo esc_url($permalink); ?>" class="btn small">
                                Book Now
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>
</article>