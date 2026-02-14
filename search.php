<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Royal_Holidays_Adventures
 */

get_header();


$search_blog = get_search_query() ? get_search_query() : '';

$search_field = array(
	'finalurl' => home_url(),
	'search_blog' => $search_blog,
);
?>

	<main id="primary" class="site-main">

		<!-- blog listing -->
		<section id="<?php echo esc_attr($section_id); ?>" class="section blog-listing <?php echo esc_attr($section_padding);?>">
			<div class="container">
				<div class="heading-block">
					<h1 class="h2"><?php echo esc_html( 'Search: '.$search_blog ); ?></h1>
					<?php get_template_part('template-parts/search-form/blog', 'search', $search_field); ?>
				</div>

				<div class="row">
					<div class="blog-post">
						<div class="blog-post-wrap">
							
							<?php
							if ( have_posts() ) { ?>
								<div class="row">
									<?php 
									
										while ( have_posts() ) {
											the_post();
											
											echo '<div class="col card-blog">';
												get_template_part( 'template-parts/grid-layouts/grid', 'search' );
											echo '</div>';

										}

										wp_reset_postdata(); 
										
									?>
								
								</div>

								<div class="col">
									<div class="pagination">
										<?php
										rha_pagination(); ?>
									</div>
								</div>
							<?php 
							} else { ?>
								<p><?php esc_html_e('No posts found', 'rha'); ?></p>
							<?php 
							} ?>
						</div>
					</div>
				</div>
			</div>
		</section>

	</main><!-- #main -->

<?php
get_footer();
