<?php
$term_object = get_queried_object();

if (!$term_object || empty($term_object->term_id)) {
    return;
}

// ACF gallery field (returns attachment IDs)
$gallery_ids = get_field('rha_act_desc_gallery', 'term_' . $term_object->term_id);

if (empty($gallery_ids) || !is_array($gallery_ids)) {
    return;
}

// Context
$term_title   = single_term_title('', false);
$total_images = count($gallery_ids);
?>

<section class="banner-gallery-block"
    itemscope
    itemtype="https://schema.org/ImageGallery"
    aria-label="<?php echo esc_attr($term_title); ?> photo gallery">

    <!-- ================= Desktop Gallery ================= -->
    <div class="banner-gallery-wrap">
        <?php
        $desktop_index = 0;

        foreach (array_slice($gallery_ids, 0, 5) as $attachment_id) :
            $desktop_index++;

            if (!$attachment_id) {
                continue;
            }

            // Attachment data
            $meta        = wp_get_attachment_metadata($attachment_id);
            $alt_text    = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
            $title_text  = get_the_title($attachment_id);
            $caption_txt = wp_get_attachment_caption($attachment_id);

            // SEO fallbacks
            $alt_text = $alt_text ?: ($title_text ?: $term_title . ' - Image ' . $desktop_index);
            $caption  = $caption_txt ?: ($title_text ?: $term_title . ' - Photo ' . $desktop_index);

            // Image sizes
            $img_xl = wp_get_attachment_image_src($attachment_id, 'img_xl');
            $img_lg = wp_get_attachment_image_src($attachment_id, 'img_lg');
            $img_md = wp_get_attachment_image_src($attachment_id, 'img_md');
            $img_sm = wp_get_attachment_image_src($attachment_id, 'img_sm');

            $url_xl = $img_xl[0] ?? wp_get_attachment_url($attachment_id);
            $url_lg = $img_lg[0] ?? $url_xl;
            $url_md = $img_md[0] ?? $url_lg;
            $url_sm = $img_sm[0] ?? $url_md;

            // Dimensions (CLS safe)
            $width  = $img_md[1] ?? ($meta['width'] ?? 800);
            $height = $img_md[2] ?? ($meta['height'] ?? 500);

            // Loading strategy
            $loading       = ($desktop_index === 1) ? 'eager' : 'lazy';
            $fetchpriority = ($desktop_index === 1) ? 'high' : 'auto';
        ?>
            <div class="img-wrap"
                data-src="<?php echo esc_url($url_lg); ?>"
                data-thumb="<?php echo esc_url($url_sm); ?>"
                data-fancybox="gallery-desktop"
                data-caption="<?php echo esc_attr($caption); ?>"
                itemprop="associatedMedia"
                itemscope
                itemtype="https://schema.org/ImageObject">

                <img
                    src="<?php echo esc_url($url_md); ?>"
                    srcset="
                        <?php echo esc_url($url_sm); ?> 400w,
                        <?php echo esc_url($url_md); ?> 800w,
                        <?php echo esc_url($url_lg); ?> 1200w,
                        <?php echo esc_url($url_xl); ?> 1920w
                    "
                    sizes="(max-width: 640px) 100vw, (max-width: 1024px) 50vw, 33vw"
                    alt="<?php echo esc_attr($alt_text); ?>"
                    title="<?php echo esc_attr($caption); ?>"
                    width="<?php echo esc_attr($width); ?>"
                    height="<?php echo esc_attr($height); ?>"
                    loading="<?php echo esc_attr($loading); ?>"
                    fetchpriority="<?php echo esc_attr($fetchpriority); ?>"
                    decoding="async"
                    itemprop="contentUrl"
                >

                <meta itemprop="name" content="<?php echo esc_attr($caption); ?>">
                <meta itemprop="description" content="<?php echo esc_attr($alt_text); ?>">
            </div>
        <?php endforeach; ?>
    </div>

    <!-- ================= Mobile Slider ================= -->
    <div class="slider-wrap hide-desktop">
        <div class="swiper banner-gallery-slider-mobile">
            <div class="swiper-wrapper">

                <?php
                $mobile_index = 0;

                foreach ($gallery_ids as $attachment_id) :
                    $mobile_index++;

                    if (!$attachment_id) {
                        continue;
                    }

                    $meta        = wp_get_attachment_metadata($attachment_id);
                    $alt_text    = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
                    $title_text  = get_the_title($attachment_id);
                    $caption_txt = wp_get_attachment_caption($attachment_id);

                    $alt_text = $alt_text ?: ($title_text ?: $term_title . ' - Image ' . $mobile_index);
                    $caption  = $caption_txt ?: ($title_text ?: $term_title . ' - Photo ' . $mobile_index);

                    $img_lg = wp_get_attachment_image_src($attachment_id, 'img_lg');
                    $img_md = wp_get_attachment_image_src($attachment_id, 'img_md');
                    $img_sm = wp_get_attachment_image_src($attachment_id, 'img_sm');

                    $url_lg = $img_lg[0] ?? wp_get_attachment_url($attachment_id);
                    $url_md = $img_md[0] ?? $url_lg;
                    $url_sm = $img_sm[0] ?? $url_md;

                    $width  = $img_md[1] ?? ($meta['width'] ?? 800);
                    $height = $img_md[2] ?? ($meta['height'] ?? 500);

                    $loading       = ($mobile_index <= 3) ? 'eager' : 'lazy';
                    $fetchpriority = ($mobile_index === 1) ? 'high' : 'auto';
                ?>
                    <div class="swiper-slide">
                        <div class="img-wrap"
                            data-src="<?php echo esc_url($url_lg); ?>"
                            data-thumb="<?php echo esc_url($url_sm); ?>"
                            data-fancybox="gallery-mobile"
                            data-caption="<?php echo esc_attr($caption); ?>">

                            <img
                                src="<?php echo esc_url($url_md); ?>"
                                srcset="
                                    <?php echo esc_url($url_sm); ?> 400w,
                                    <?php echo esc_url($url_md); ?> 800w,
                                    <?php echo esc_url($url_lg); ?> 1200w
                                "
                                sizes="100vw"
                                alt="<?php echo esc_attr($alt_text); ?>"
                                title="<?php echo esc_attr($caption); ?>"
                                width="<?php echo esc_attr($width); ?>"
                                height="<?php echo esc_attr($height); ?>"
                                loading="<?php echo esc_attr($loading); ?>"
                                fetchpriority="<?php echo esc_attr($fetchpriority); ?>"
                                decoding="async"
                            >
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>
    </div>
</section>
