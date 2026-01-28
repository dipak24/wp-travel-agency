<?php
/**
 * Template part for displaying trip cards
 *
 * @package YourTheme
 */

$post_id = get_the_ID();

// Get ACF custom fields
$average_rating = get_post_meta($post_id, 'average_rating', true);
$total_reviews  = get_post_meta($post_id, 'total_reviews', true);
$duration       = get_post_meta($post_id, 'trip_duration', true);
$group_size     = get_post_meta($post_id, 'trip_group_size', true);
$price          = get_post_meta($post_id, 'trip_sale_price', true);
$trip_grade     = get_post_meta($post_id, 'trip_grade', true);

// Set defaults
$average_rating = $average_rating ? $average_rating : '0';
$total_reviews  = $total_reviews ? $total_reviews : '0';
$duration       = $duration ? $duration : '1';
$group_size     = $group_size ? $group_size : '1-10';
$price          = $price ? $price : '0.00';
?>

<div class="tour-list card-tour" data-tour-id="<?php echo esc_attr($post_id); ?>">
    <div class="card-wrap">
        <div class="img-wrap">
            <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('medium', array('alt' => get_the_title())); ?>
            <?php else : ?>
                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/placeholder.png'); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
            <?php endif; ?>
        </div>
        <div class="text-wrap">
            <div class="card-rating">
                <span class="rating">
                    <?php echo esc_html($average_rating); ?>
                    <span class="review">
                        (<?php echo esc_html($total_reviews); ?> reviews)
                    </span>
                </span>
            </div>
            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
            <div class="card-program">
                <ul class="tour-list">
                    <li class="duration">
                        <?php echo esc_html($duration); ?> days
                    </li>
                    <li class="guest">
                        <?php echo esc_html($group_size); ?> guest
                    </li>
                    <?php if (!empty($trip_grade)) : ?>
                        <li class="grade">
                            Grade: <?php echo esc_html($trip_grade); ?>
                        </li>
                    <?php endif; ?>
                </ul>

                <div class="card-pricing">
                    <strong class="price">
                        $<?php echo esc_html(number_format($price, 2)); ?> <sub>/ person</sub>
                    </strong>
                    <div class="btn-wrap">
                        <a href="<?php the_permalink(); ?>" class="btn small">Book Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
