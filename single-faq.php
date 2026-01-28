<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Royal_Holidays_Adventures
 */

get_header();
$social_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ?
	"https" : "http") . "://" . $_SERVER['HTTP_HOST'] .
$_SERVER['REQUEST_URI'];
$author_id = get_post_field( 'post_author' , $post );
$fname = get_the_author_meta('first_name' , $author_id);
$lname = get_the_author_meta('last_name' , $author_id);
$display_name = get_the_author_meta('display_name' , $author_id);
$user_pic = get_field('user_image', 'user_'.$author_id);
$full_name = '';
if( empty( $fname ) && empty( $lname )){
	$full_name = $display_name;
} elseif( empty($fname)){
	$full_name = $lname;
} elseif( empty( $lname )){
	$full_name = $fname;
} else {
//both first name and last name are present
	$full_name = $fname. ' ' .$lname;
}
?>
<main id="primary" class="site-main">
	<div class="blog-single">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<?php if (function_exists('rank_math_the_breadcrumbs')) { ?>
						<?php
							rank_math_the_breadcrumbs();
						}
					?>
					<div class="page-heading">
						<h1 class="page-title"><?php the_title(); ?></h1>
					</div>

					<div class="single-content">
						<div class="blog-page-heading">
							<?php if(has_post_thumbnail()) { ?>
								<div class="img-wrap">
									<img src="<?php echo esc_url(get_the_post_thumbnail_url($post->ID, 'full')); ?>" alt="<?php the_title(); ?>" width="853" height="524" />
								</div>
							<?php } else { ?>
                    			<img src="<?php echo esc_url(RHA_THEME_IMAGES_DIR.'nepal-trekking-faq.jpg'); ?>" alt="blog-image" alt="blog-image" width="855" height="440" />
							<?php } ?>

							<div class="text-wrap">
								<strong class="title"><?php esc_html_e('Published', 'Royal_Holidays_Adventures'); ?></strong>
									<time class="date" datetime="<?php echo esc_attr(get_the_date('Y-m-d')); ?>"><em><?php echo get_the_date('d M Y'); ?></em></time>
								</span>

								<strong class="title"><?php esc_html_e('Content', 'Royal_Holidays_Adventures'); ?></strong>
								<p><em><?php echo esc_html($full_name); ?></em></p>

								<div class="social-networks">
									<ul>
										<li>
											<a href="javascript:void(0)" class="share-link">
												<img src="<?php echo esc_url(RHA_THEME_IMAGES_DIR.'blog-share/link.svg'); ?>" alt="Link" width="20" height="20">
											</a>
										</li>
										<li>
											<a class="resp-sharing-button__link" href="<?php echo esc_url('https://www.linkedin.com/shareArticle?mini=true&amp;url='.$social_link); ?>" target="_blank" rel="noopener noreferrer nofollow" aria-label="Share on LinkedIn">
												<div class="resp-sharing-button resp-sharing-button--linkedin resp-sharing-button--large">
													<div aria-hidden="true" class="resp-sharing-button__icon resp-sharing-button__icon--solid">
														<img src="<?php echo esc_url(RHA_THEME_IMAGES_DIR.'blog-share/linkedin.svg'); ?>" alt="Linkedin Icon" width="20" height="20">
													</div>
												</div>
											</a>
										</li>
										<li>
											<a class="resp-sharing-button__link" href="<?php echo esc_url('https://facebook.com/sharer/sharer.php?u='.$social_link); ?>" target="_blank" rel="noopener noreferrer nofollow" aria-label="Share on Facebook">
												<div class="resp-sharing-button resp-sharing-button--facebook resp-sharing-button--large">
													<div aria-hidden="true" class="resp-sharing-button__icon resp-sharing-button__icon--solid">
														<img src="<?php echo esc_url(RHA_THEME_IMAGES_DIR.'blog-share/facebook.svg'); ?>" alt="Facebook" width="20" height="20">
													</div>
												</div>
											</a>
										</li>
										<li>
											<a class="resp-sharing-button__link" href="<?php echo esc_url('https://twitter.com/intent/tweet/?url='.$social_link); ?>" target="_blank" rel="noopener noreferrer nofollow" aria-label="Share on Twitter">
												<div class="resp-sharing-button resp-sharing-button--twitter resp-sharing-button--large">
													<div aria-hidden="true" class="resp-sharing-button__icon resp-sharing-button__icon--solid">
														<img src="<?php echo esc_url(RHA_THEME_IMAGES_DIR.'blog-share/twitter.svg'); ?>" alt="Twitter Icon" width="20" height="20">
													</div>
												</div>
											</a>
										</li>
									</ul>
								</div>
							</div>
						</div>

						<?php
						while ( have_posts() ) :
							the_post(); ?>
							<div class="single-blog-content">
								<div class="row">
									<div class="col-12 col-lg-8 col-xl-9 col-content">
										<div class="content-wrap">
											<?php the_content(); ?>

											<?php
											$cat_terms = get_the_terms($post->ID, 'category');
											if($cat_terms) { ?>
												<div class="meta">
													<ul>
														<li><span class="title"><?php esc_html_e('Topics:', 'Royal_Holidays_Adventures'); ?></span></li>
														<?php
														$total = count($cat_terms);
														$count = 1;
														foreach( $cat_terms as $cat_term ) {
															$category_link = get_category_link( $cat_term->term_id ); ?>
															<li>
																<a href="<?php echo esc_url($category_link); ?>"><?php echo esc_html($cat_term->name); ?></a>
															</li>
															<?php
															$count++;
														} ?>
													</ul>
												</div>
											<?php 
											} ?>

											<hr/>
										</div>
									</div>
								</div>
							</div>
						<?php endwhile; ?>
					</div>
				</div>
			</div>

			<?php
			$categories = get_the_category();
			$arr = [];
			if ($categories) {
				foreach($categories as $category) {
					array_push($arr, $category->term_id);
				}
			}
			$args = array(
				'category__in'   => $arr,
				'post__not_in'   => array($post->ID),
				'posts_per_page' => 3,
				'post_type' 	=> 'faq',
				'post_status' 	=> 'publish',
				'orderby'        => 'date',
				'order'          => 'DESC',
			);
			$my_query = new WP_Query($args);
			if( $my_query->have_posts() ) {
				?>
				<div class="blog-post related-blog">
					<div class="blog-post-wrap">
						<div class="blog-post-wrap-title d-flex justify-content-between align-items-center">
							<h2><?php esc_html_e('See more FAQ like this', 'Royal_Holidays_Adventures'); ?></h2>
							<?php if ($arr) { ?>
								<div class="view-all-link">
									<a href="<?php echo esc_url(get_category_link( $arr[0])); ?>" class="btn btn-primary btn-lg"><?php esc_html_e('See all', 'Royal_Holidays_Adventures'); ?></a>
								</div>	
							<?php } ?>
						</div>

						<div class="row">
							<?php while($my_query->have_posts()) {
								$my_query->the_post();
								echo '<div class="col-md-4">';
									get_template_part( 'template-parts/grid-layout/faqs', 'grid' );
								echo '</div>';
							} wp_reset_postdata(); ?>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>
	</div>
</main>
<!-- #main -->
<?php
get_footer();