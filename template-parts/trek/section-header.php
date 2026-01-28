<?php
$totalReview        = get_field('rha_trip_advisor_number_of_review', 'options');
$reviewLink         = get_field('rha_review_link', 'options');
$recommendedPercent = get_field('rha_number_of_recommended_percent', 'options');
$reviewerIds         = get_field('rha_reviewer_imaage', 'options'); // Post Object (multiple)

// Review link handling (ACF Link field)
$review_url    = '';
$review_target = '';
$review_rel    = '';

if (is_array($reviewLink)) {
    $review_url    = $reviewLink['url'] ?? '';
    $review_target = !empty($reviewLink['target']) ? ' target="_blank"' : '';
    $review_rel    = !empty($reviewLink['target']) ? ' rel="noopener noreferrer"' : '';
}

// Share data
$share_url   = urlencode(get_permalink());
$share_title = urlencode(get_the_title());
$share_media = '';

if (has_post_thumbnail()) {
    $thumb = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
    $share_media = $thumb ? urlencode($thumb[0]) : '';
}
?>

<div class="trip-header">
    <div class="trip-content">
        <div class="content-wrap">
            <h1 class="h2"><?php the_title(); ?></h1>

            <div class="trip-review-advisor">
                <div class="review-info">

                    <?php if ($totalReview && $review_url) : ?>
                        <img
                            src="<?php echo esc_url(RHA_THEME_IMAGES_DIR . '/social-icons/img-star-tripadvisor.svg'); ?>"
                            alt="TripAdvisor rating"
                            width="79"
                            height="12"
                            loading="lazy"
                        >

                        <span class="review-in">
                            <a href="<?php echo esc_url($review_url); ?>"<?php echo $review_target . $review_rel; ?>>
                                <?php echo esc_html($totalReview); ?> Reviews
                            </a> in TripAdvisor
                        </span>
                    <?php endif; ?>

                    <?php if (!empty($reviewerIds) && is_array($reviewerIds)) : ?>
                        <ul class="reviewer">
                            <?php
                            foreach ($reviewerIds as $reviewerId) :
                                setup_postdata($reviewerId);

                                $avatar_id = get_post_thumbnail_id($reviewerId);
                                $avatar    = $avatar_id
                                    ? wp_get_attachment_image_src($avatar_id, 'img_sm_icon')
                                    : false;

                                if (!$avatar) {
                                    continue;
                                }
                            ?>
                                <li>
                                    <div class="img-wrap">
                                        <img
                                            src="<?php echo esc_url($avatar[0]); ?>"
                                            alt="<?php echo esc_attr(get_the_title($reviewerId)); ?>"
                                            title="<?php echo esc_attr(get_the_title($reviewerId)); ?>"
                                            width="24"
                                            height="24"
                                            loading="lazy"
                                            decoding="async"
                                        >
                                    </div>
                                </li>
                            <?php
                            endforeach;
                            wp_reset_postdata();
                            ?>
                        </ul>
                    <?php endif; ?>

                </div>

                <div class="travel-recommended">
                    <?php if ($recommendedPercent) : ?>
                        <span class="text">
                            Recommended by <?php echo esc_html($recommendedPercent); ?>% of travelers
                        </span>
                    <?php endif; ?>

                    <div class="share-mobile d-none">
                        <a href="#" class="share-opener"></a>
                        <div class="share"></div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="trip-share">
        <div class="share-list">
            <span class="share">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M12 2v13"></path>
                    <path d="m16 6-4-4-4 4"></path>
                    <path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"></path>
                </svg>
                Share
            </span>

            <ul class="social-networks">
                <li>
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $share_url; ?>" target="_blank" rel="noopener noreferrer">
                        <img src="<?php echo esc_url(RHA_THEME_IMAGES_DIR . '/social-icons/icon-facebook-share.svg'); ?>" alt="Share on Facebook" width="22" height="22">
                    </a>
                </li>

                <li>
                    <a href="https://pinterest.com/pin/create/button/?url=<?php echo $share_url; ?>&media=<?php echo $share_media; ?>&description=<?php echo $share_title; ?>" target="_blank" rel="noopener noreferrer">
                        <img src="<?php echo esc_url(RHA_THEME_IMAGES_DIR . '/social-icons/icon-pinterest-share.svg'); ?>" alt="Share on Pinterest" width="22" height="22">
                    </a>
                </li>

                <li>
                    <a href="https://twitter.com/intent/tweet?url=<?php echo $share_url; ?>&text=<?php echo $share_title; ?>" target="_blank" rel="noopener noreferrer">
                        <img src="<?php echo esc_url(RHA_THEME_IMAGES_DIR . '/social-icons/icon-twitter-share.svg'); ?>" alt="Share on Twitter" width="22" height="22">
                    </a>
                </li>

                <li>
                    <a href="<?php echo esc_url(get_permalink()); ?>"
                       onclick="event.preventDefault(); navigator.clipboard.writeText('<?php echo esc_js(get_permalink()); ?>');"
                       title="Copy link">
                        <img src="<?php echo esc_url(RHA_THEME_IMAGES_DIR . '/social-icons/icon-link-share.svg'); ?>" alt="Copy link" width="22" height="22">
                    </a>
                </li>

                <li>
                    <a href="https://www.instagram.com/" target="_blank" rel="noopener noreferrer">
                        <img src="<?php echo esc_url(RHA_THEME_IMAGES_DIR . '/social-icons/icon-instagram-share.svg'); ?>" alt="Instagram" width="22" height="22">
                    </a>
                </li>
            </ul>
        </div>

        <a href="#" class="btn outline small">
            Download Trip PDF
        </a>
    </div>
</div>
