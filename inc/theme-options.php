<?php 
//For theme settings
add_action('acf/init', function () {

	if (function_exists('acf_add_options_page')) {

		$option_page = acf_add_options_page(array(
			'page_title'  => __('Theme Options', 'rha'),
			'menu_title'  => __('Theme Options', 'rha'),
			'menu_slug'   => 'theme-options',
			'capability'  => 'edit_posts',
			'redirect'    => false,
		));

		acf_add_options_page(array(
			'page_title'  => __('Header', 'rha'),
			'menu_title'  => __('Header', 'rha'),
			'parent_slug'=> $option_page['menu_slug'],
		));

		acf_add_options_page(array(
			'page_title'  => __('Footer', 'rha'),
			'menu_title'  => __('Footer', 'rha'),
			'parent_slug'=> $option_page['menu_slug'],
		));
	}
});
