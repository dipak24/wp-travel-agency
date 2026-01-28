<?php
/**
 * Block Name: General Post Listing
 */

// Block preview image (Gutenberg)
if (!empty($block['data']['block_preview_image'])) {
    echo '<img src="' . esc_url($block['data']['block_preview_image']) . '" style="width:100%;height:auto;" alt="Block preview">';
    return;
}

// Section enable check
if (!get_field('is_general_post_enable')) {
    return;
}

// Unique ID & padding
$section_id      = 'general-post-' . esc_attr($block['id']);
$section_padding = rha_get_block_style();

$section_title       = get_field('rha_general_post_title');
$section_description = get_field('rha_genearl_post_section_description');
?>

<section id="<?php echo esc_attr($section_id); ?>" class="section blog-block <?php echo esc_attr($section_padding); ?>">
    <div class="container">

        <?php if ($section_title || $section_description): ?>
            <header class="heading-block">
                <?php if ($section_title): ?>
                    <h2><?php echo esc_html($section_title); ?></h2>
                <?php endif; ?>

                <?php if ($section_description): ?>
                    <p><?php echo esc_html($section_description); ?></p>
                <?php endif; ?>
            </header>
        <?php endif; ?>

        <div class="row">

            <!-- LEFT: Latest Posts -->
            <div class="col col-blog-list">
                <div class="col-wrap">

                    <?php
                    $latest_query = new WP_Query([
                        'post_type'      => 'post',
                        'posts_per_page' => 4,
                        'post_status'    => 'publish',
                        'no_found_rows'  => true,
                    ]);
                    ?>

                    <?php if ($latest_query->have_posts()): ?>
                        <?php $count = 0; ?>

                        <?php while ($latest_query->have_posts()): $latest_query->the_post(); ?>
                            <?php $count++; ?>

                            <?php
                            $post_id = get_the_ID();
                            $title   = get_the_title();
                            $author_id = get_the_author_meta('ID');
                            ?>

                            <?php if ($count === 1): ?>
                                <!-- FEATURED POST -->
                                <div class="blog-featured-image">
                                    <div class="img-wrap">
                                        <?php
                                        if (has_post_thumbnail($post_id)) {
                                            echo wp_get_attachment_image(
                                                get_post_thumbnail_id($post_id),
                                                'img_md', // default fallback
                                                false,
                                                [
                                                    'loading' => 'lazy',
                                                    'decoding' => 'async',
                                                    'alt' => esc_attr(get_post_meta(get_post_thumbnail_id($post_id), '_wp_attachment_image_alt', true) ?: $title),
                                                    'sizes' => '(max-width: 480px) 480px, (max-width: 768px) 800px, (max-width: 1200px) 1200px, 1920px',
                                                ]
                                            );
                                        }
                                        ?>
                                    </div>

                                    <div class="text-wrap">
                                        <h3 class="h5">
                                            <a href="<?php the_permalink(); ?>"><?php echo esc_html($title); ?></a>
                                        </h3>

                                        <div class="author-block">
                                            <div class="img-wrap">
                                                <?php echo get_avatar($author_id, 48); ?>
                                            </div>
                                            <div class="text">
                                                <span class="author">
                                                    <a href="<?php echo esc_url(get_author_posts_url($author_id)); ?>">
                                                        <?php the_author(); ?>
                                                    </a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="blog-lists">
                            <?php else: ?>
                                <!-- LIST POSTS -->
                                <div class="blog-card">
                                    <div class="card-wrap">
                                        <div class="img-wrap">
                                            <?php
                                            if (has_post_thumbnail($post_id)) {
                                                echo wp_get_attachment_image(
                                                    get_post_thumbnail_id($post_id),
                                                    'img_sm', // small for list
                                                    false,
                                                    [
                                                        'loading' => 'lazy',
                                                        'decoding' => 'async',
                                                        'alt' => esc_attr(get_post_meta(get_post_thumbnail_id($post_id), '_wp_attachment_image_alt', true) ?: $title),
                                                        'sizes' => '(max-width: 480px) 480px, (max-width: 768px) 800px, (max-width: 1200px) 1200px, 1920px',
                                                    ]
                                                );
                                            }
                                            ?>
                                        </div>

                                        <div class="text-wrap">
                                            <h3 class="h6"><a href="<?php the_permalink(); ?>"><?php echo esc_html($title); ?></a></h3>
                                            <div class="author-block">
                                                <div class="img-wrap">
                                                    <?php echo get_avatar($author_id, 32); ?>
                                                </div>
                                                <div class="text">
                                                    <span class="author">
                                                        <a href="<?php echo esc_url(get_author_posts_url($author_id)); ?>">
                                                            <?php the_author(); ?>
                                                        </a>
                                                    </span>
                                                    <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                                        <?php echo esc_html(get_the_date()); ?>
                                                    </time>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>

                        <?php endwhile; ?>
                        </div><!-- .blog-lists -->

                        <?php wp_reset_postdata(); ?>
                    <?php endif; ?>

                </div>
            </div>

            <!-- RIGHT: Popular Posts -->
            <div class="col col-lists">
                <div class="col-wrap">
                    <h3 class="h6 title">Popular Posts</h3>

                    <?php
                    $popular_query = new WP_Query([
                        'post_type'      => 'post',
                        'posts_per_page' => 5,
                        'meta_key'       => 'unique_post_views',
                        'orderby'        => 'meta_value_num',
                        'order'          => 'DESC',
                        'post_status'    => 'publish',
                        'no_found_rows'  => true,
                    ]);
                    ?>

                    <?php if ($popular_query->have_posts()): ?>
                        <ul>
                            <?php while ($popular_query->have_posts()): $popular_query->the_post(); ?>
                                <?php
                                $views = (int) get_post_meta(get_the_ID(), 'unique_post_views', true);
                                ?>
                                <li>
                                    <span class="count"><?php echo esc_html($views); ?></span>
                                    <strong class="title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </strong>
                                </li>
                            <?php endwhile; ?>
                        </ul>
                        <?php wp_reset_postdata(); ?>
                    <?php endif; ?>

                </div>
            </div>

        </div>
    </div>
</section>
