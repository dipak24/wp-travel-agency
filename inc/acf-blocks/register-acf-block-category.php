<?php
function register_acf_block_category( $categories, $post ) {
	return array_merge(
		$categories,
		array(
			array(
				'slug' => 'eb-blocks',
				'title' => __( 'RHA Blocks', 'rha' ),
			),
		)
	);
}
add_filter( 'block_categories_all', 'register_acf_block_category', 10, 2);