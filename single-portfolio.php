<?php
get_header(); 
?>

	<main id="primary" class="site-main site-main--contents">

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', 'page' );

		endwhile; // End of the loop.
		?>

	</main>

<?php get_footer();