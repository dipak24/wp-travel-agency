<?php

/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 */

 /** Link target check */
function rha_target($data)
{
    if ($data['target']) {
        echo ' target="' . $data['target'] . '"';
    }
}

// get alt from image check
function rha_alt($data)
{
    echo esc_attr($data['alt'] ? $data['alt'] : $data['title']);
}

// get the post category lists
function rha_get_category()
{
    $terms_list = get_the_category();
    if (!empty($terms_list)) { // Check $terms_list has value
        echo '<ul class="cat-lists">';
        foreach ($terms_list as $term) {
            $term_id = $term->term_id;
            $cat_name = $term->name;
            echo '<li class="cat-lists__item"><a href="' . get_term_link($term_id) . '">' . $cat_name . '</a></li>';
        }
        echo '</ul>';
    }
}

if (!function_exists('rha_posted_on')) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function rha_posted_on()
	{
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if (get_the_time('U') !== get_the_modified_time('U')) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr(get_the_date(DATE_W3C)),
			esc_html(get_the_date()),
			esc_attr(get_the_modified_date(DATE_W3C)),
			esc_html(get_the_modified_date())
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x('Posted on %s', 'post date', 'rha'),
			'<a href="' . esc_url(get_permalink()) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}
endif;

if (!function_exists('rha_posted_by')) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function rha_posted_by() {

		$author_id   = get_the_author_meta('ID');
		$post_date   = get_the_date('F j, Y');

		// Try ACF user image first
		$user_pic = get_field('user_image', 'user_' . $author_id);

		if ( $user_pic && isset($user_pic['url']) ) {
			$avatar_html = '<img src="' . esc_url($user_pic['url']) . '" width="48" height="48" alt="' . esc_attr(get_the_author()) . '">';
		} else {
			// Fallback to WordPress avatar (already returns <img>)
			$avatar_html = get_avatar( $author_id, 48 );
		}

		echo '<div class="author-block d-flex">';
			echo '<div class="img-wrap">' . $avatar_html . '</div>';
			echo '<div class="text">';
				echo '<span class="author">';
					echo '<a href="' . esc_url( get_author_posts_url($author_id) ) . '">';
						echo esc_html( get_the_author() );
					echo '</a>';
				echo '</span>';
				echo '<time datetime="' . esc_attr( get_the_date('Y-m-d') ) . '">' . esc_html( $post_date ) . '</time>';
			echo '</div>';
		echo '</div>';
	}
endif;

if (!function_exists('rha_entry_footer')) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function rha_entry_footer()
	{
		// Hide category and tag text for pages.
		if ('post' === get_post_type()) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list(esc_html__(', ', 'rha'));
			if ($categories_list) {
				/* translators: 1: list of categories. */
				printf('<span class="cat-links">' . esc_html__('Posted in %1$s', 'rha') . '</span>', $categories_list); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list('', esc_html_x(', ', 'list item separator', 'rha'));
			if ($tags_list) {
				/* translators: 1: list of tags. */
				printf('<span class="tags-links">' . esc_html__('Tagged %1$s', 'rha') . '</span>', $tags_list); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}
	}
endif;

if (!function_exists('rha_post_thumbnail')) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function rha_post_thumbnail()
	{
		if (post_password_required() || is_attachment() || !has_post_thumbnail()) {
			return;
		}

		if (is_singular()) : ?>

			<div class="post-thumbnail">
				<?php the_post_thumbnail(); ?>
			</div><!-- .post-thumbnail -->

		<?php else : ?>

			<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
				<?php
				the_post_thumbnail(
					'post-thumbnail',
					array(
						'alt' => the_title_attribute(
							array(
								'echo' => false,
							)
						),
					)
				);
				?>
			</a>

		<?php
		endif; // End is_singular().
	}
endif;

if (!function_exists('wp_body_open')) :
	/**
	 * Shim for sites older than 5.2.
	 *
	 * @link https://core.trac.wordpress.org/ticket/12563
	 */
	function wp_body_open()
	{
		do_action('wp_body_open');
	}
endif;
