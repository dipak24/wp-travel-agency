<?php
/**
 * Template part for displaying blog Grid Content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package starterkit-theme-four
 */
?>
<article id="post-<?php the_ID(); ?>" class="card-wrap">

    <div class="img-wrap">
        <a href="<?php the_permalink(); ?>">
            <?php
            if (has_post_thumbnail()) {
                the_post_thumbnail('blog-thumb');
            } else { ?>
                <div class="img-wrap no-image-box">
                    <img src="<?php echo esc_url(RHA_THEME_IMAGES_DIR . 'blog-image.png'); ?>" alt="blog-image"
                        width="326" height="223" />
                </div>
            <?php } ?>
        </a>
    </div>

    <div class="text-wrap">

        <div class="tags">
            <div class="content-category-tag">
                <?php
                $categories = get_the_category();

                if (!empty($categories) && is_array($categories)) {
                    foreach ($categories as $category) {
                        $category_name = $category->name;
                        $category_id = $category->term_id;
                        $category_url = get_category_link($category_id);
                        echo '<a href="' . esc_url($category_url) . '" rel="bookmark">' . esc_html($category_name) . '</a>';
                    }
                } ?>
            </div>
        </div>
        <div class="content-title">
            <?php the_title('<h2 class="h5 entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>'); ?>
        </div>
        <div class="content-description">
            <?php echo wpautop(wp_trim_words(get_the_content(), 20, '')); ?>
        </div>

        <div class="btn-wrap">
           <a href="<?php the_permalink(); ?>" class="btn">
                <?php esc_html_e('View Post', 'rha'); ?>
            </a>
        </div>
    </div>
</article>