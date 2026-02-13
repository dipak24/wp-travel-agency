<?php
get_header();
?>
<main id="main" role="main">
	<?php
	while ( have_posts() ) :

		the_post();
		// Banner Gallery
		get_template_part( 'template-parts/trek/section-banner' );		
		?>
		<section class="section itinary-block pt-0">

			<div class="container">

				<?php
				// Breadcrumbs
				if (function_exists('rank_math_the_breadcrumbs')) {
					rank_math_the_breadcrumbs();
				}
				
				// Section Header
				get_template_part( 'template-parts/trek/section-header' );

				?>
				<div class="row">

					<div class="col col-content">

						<div class="col-wrap">

							<?php
							// apply filter block category text and media only
							$content = get_post_field('post_content', get_the_ID());
							$blocks = parse_blocks($content);
							$allowed_blocks = [
								'acf/block-trip-fact',
								'acf/block-package-include-exclude',
								'acf/block-details-itinerary',
								'core/paragraph',
								'core/heading',
								'core/list',
								'core/image',
								'core/video',
								'core/table',
								'rha/admin-message',
							];

							foreach ($blocks as $block) {

								if (in_array($block['blockName'], $allowed_blocks, true)) {
									// Core blocks already handle formatting
									if (str_starts_with($block['blockName'], 'core/')) {
										echo render_block($block);
									} 
									// ACF blocks
									else {
										echo render_block($block);
									}
								}
							}
							?>
						</div>
					</div>
					<?php echo get_sidebar('trip'); ?>
				</div>
			</div>

		</section>

		<?php 

		$allowed_blocks = [
			'rha/sidebar-accordion-with-faq',
			'rha/fixed-departures',
			'rha/our-team',
		];

		//print_r($blocks);

		foreach ($blocks as $block) {

			if ( in_array($block['blockName'], $allowed_blocks) ) {
				echo apply_filters('the_content', render_block($block));
			}
		}

		?>

	<?php
	endwhile; // End of the loop.
	?>
</main>
<?php

get_footer();