<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Royal_Holidays_Adventures
 */

get_header(); ?>

<main id="primary" class="site-main">
	<section class="section section-blog-listing">
		<div class="container">

			<?php if (have_posts()) { ?>
				<div class="blog-posts">
					<div class="row">
						<?php
						/* Start the Loop */
						while (have_posts()) :
							the_post();
						?>
							<div class="col-md-4">
								<?php get_template_part('template-parts/content', get_post_type()); ?>
							</div>
						<?php endwhile; ?>
					</div>
				</div>
			<?php

				$big = 999999999; // need an unlikely integer
				$num_pages = paginate_links(array(
					'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
					'format' => '/page/%#%',
					'current' => max(1, get_query_var('paged')),
					// 'total' => $wp_query->max_num_pages,
					'end_size' => 1,
					'mid_size' => 1,
					'next_text' => '<span class="next-icon"></span>',
					'prev_text' => '<span class="prev-icon"></span>',
					'type'     => 'array'
				));

				if (is_array($num_pages)) :
					echo '<div class="col-12"><div class="pagination">';
					foreach ($num_pages as $num_page) :
						echo "$num_page";
					endforeach;
					echo '</div></div>';
				endif;
			} else {

				get_template_part('template-parts/content', 'none');
			}
			?>
		</div>
	</section>

</main><!-- #main -->

<?php
// get_sidebar();
get_footer();
