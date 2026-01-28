<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Royal_Holidays_Adventures
 */

get_header();

global $wp_query;
$queried_obj = get_queried_object();

if (is_author()) {
	$author = get_queried_object();
	$authorid = $author->ID;
	$current_name = $author->display_name;
} else {
	$current_name = isset($queried_obj->name) ? $queried_obj->name : '';
	$description = isset($queried_obj->description) ? $queried_obj->description : '';
}
$search_field = array(
	'finalurl' => home_url(),
	'search_blog' => get_search_query(),
);
?>

	<main id="primary" class="site-main">

		<!-- blog listing -->
		<section id="<?php echo esc_attr($section_id); ?>" class="section blog-listing <?php echo esc_attr($section_padding);?>">
			<div class="container">
				<div class="heading-block d-flex">
					<h2><?php echo esc_html($current_name); ?></h2>

					<?php echo $description; ?>

					<?php get_template_part('template-parts/search-form/blog', 'search', $search_field); ?>

				</div>
				<div class="row">
					<div class="col-lg-3 col-xl-2">
						<?php get_sidebar('blog'); ?>
					</div>
					
					<div class="col-lg-9 col-xl-10">
						<div class="blog-post">
							<div class="blog-post-wrap">
								
								<?php
								if ( have_posts() ) { ?>
									<div class="row">
										<?php 
										
											while ( have_posts() ) {
												the_post();
												
												echo '<div class="col card-blog">';
													get_template_part( 'template-parts/grid-layouts/grid', 'blog' );
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
			</div>
		</section>

	</main><!-- #main -->

<?php
get_footer();
