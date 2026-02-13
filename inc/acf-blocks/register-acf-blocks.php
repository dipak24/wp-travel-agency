<?php
add_action('acf/init', 'rha_init_block_types');
function rha_init_block_types() {

	// Check function exists.
	if (function_exists('acf_register_block_type')) {

		// registers hero one block. (Home page hero)
		acf_register_block_type(
			array(
				'name' 				=> 'block-hero-banner',
				'title' 			=> __('Hero Banner', 'rha'),
				'description' 		=> __('A custom hero banner.', 'rha'),
				'render_callback' 	=> 'render_acf_block_callback',
				'category' 			=> 'eb-blocks',
				'icon' 				=> 'align-full-width',
				'keywords' 			=> array('hero', 'banner'),
				'mode' 				=> 'edit',
				'supports' 			=> array(
					'mode' 			=> 'false',
					'align' 		=> false,
				),
				'example' 			=> array(
					'attributes' => array(
						'mode' 	 => 'preview',
						'data' 	 => array(
							'block_preview_image' => RHA_THEME_IMAGES_DIR . '/acf-block-preview/hero-banner.png',
						)
					)
				),
			)
		);

		// register a custom block for Blog listing ( General page )
		acf_register_block_type(
			array(
				'name' 				=> 'block-general-post-listing',
				'title' 			=> __('General Post Listing', 'rha'),
				'description' 		=> __('A custom blog post listing, for general page', 'rha'),
				'render_callback' 	=> 'render_acf_block_callback',
				'category' 			=> 'eb-blocks',
				'icon'				=> 'filter',
				'keywords' 			=> array('blog', 'listing'),
				'mode' 				=> 'edit',
				'supports' 			=> array(
					'mode' 	=> 'false',
					'align' => false,
				),
				'example' 			=> array(
					'attributes' => array(
						'mode' 	 => 'preview',
						'data'   => array(
							'block_preview_image' => RHA_THEME_IMAGES_DIR . '/acf-block-preview/blog-listing.png',
						)
					)
				),
			)
		);

		// register a custom block for Testimonial
		acf_register_block_type(
			array(
				'name' 				=> 'block-testimonial',
				'title' 			=> __('Testimonial', 'rha'),
				'description' 		=> __('A custom Testimonial .', 'rha'),
				'render_callback' 	=> 'render_acf_block_callback',
				'category' 			=> 'eb-blocks',
				'icon' 				=> 'testimonial',
				'keywords' 			=> array('Testimonial'),
				'mode' 				=> 'edit',
				'supports' 			=> array(
					'mode'  => 'false',
					'align' => false,
				),
				'example' 			=> array(
					'attributes' => array(
						'mode'   => 'preview',
						'data'   => array(
							'block_preview_image' => RHA_THEME_IMAGES_DIR . '/acf-block-preview/testimonial.png',
						)
					)
				),
			)
		);
		
		// Multiple Column Icon Text and Description
		acf_register_block_type(
			array(
				'name' 				=> 'block-multiple-column-icon-text-description',
				'title'				=> __('Multiple Column Icon Text and Description', 'rha'),
				'description'	 	=> __('A custom Icon,Text and Description listing block in multiple columns.', 'rha'),
				'render_callback' 	=> 'render_acf_block_callback',
				'category'	 		=> 'eb-blocks',
				'icon' 				=> 'grid-view',
				'keywords' 			=> array('Multiple Column Icon Text Description', 'Multiple Column', 'Listing'),
				'mode' 				=> 'edit',
				'supports' 			=> array(
					'mode'  => 'false',
					'align' => false,
				),
				'example' 			=> array(
					'attributes' => array(
						'mode'   => 'preview',
						'data'   => array(
							'block_preview_image' => RHA_THEME_IMAGES_DIR . 'acf-block-preview/multiple-column.png',
						)
					)
				),
			)
		);

		// register a custom block for Multiple column blog
		acf_register_block_type(
			array(
				'name' 				=> 'block-multiple-column-blog',
				'title' 			=> __('Multiple Column Blog', 'rha'),
				'description' 		=> __('A custom Multiple Column Blog.', 'rha'),
				'render_callback' 	=> 'render_acf_block_callback',
				'category' 			=> 'eb-blocks',
				'icon' 				=> 'grid-view',
				'keywords' 			=> array('multiple', 'column', 'blog'),
				'mode' 				=> 'edit',
				'supports' 			=> array(
					'mode'  => 'false',
					'align' => false,
				),
				'example' 			=> array(
					'attributes' => array(
						'mode' 	 => 'preview',
						'data'   => array(
							'block_preview_image' => RHA_THEME_IMAGES_DIR . '/acf-block-preview/multiple-column-blog.png',
						)
					)
				),
			)
		);

		// register a custom block for Multiple column Trip
		acf_register_block_type(
			array(
				'name' 				=> 'block-featured-multiple-column-trip',
				'title' 			=> __('Featured Multiple Column Trips', 'rha'),
				'description' 		=> __('List featured trips in multiple columns.', 'rha'),
				'render_callback' 	=> 'render_acf_block_callback',
				'category' 			=> 'eb-blocks',
				'icon' 				=> 'grid-view',
				'keywords' 			=> array('Featured', 'tour', 'trip'),
				'mode' 				=> 'edit',
				'supports' 			=> array(
					'mode'  => 'false',
					'align' => false,
				),
				'example' 			=> array(
					'attributes' => array(
						'mode' 	 => 'preview',
						'data'   => array(
							'block_preview_image' => RHA_THEME_IMAGES_DIR . 'acf-block-preview/feature-multiple-trek.png',
						)
					)
				),
			)
		);

		// register a custom block for Multiple column block
		acf_register_block_type(array(
			'name'    			=> 'block-trip-promotion',
			'title'    			=> __('Trip Promotion', 'rha'),
			'description'  		=> __('A custom Trip Promotion section by adding image and text.', 'rha'),
			'render_callback' 	=> 'render_acf_block_callback',
			'category'   		=> 'eb-blocks',
			'icon' 				=> 'megaphone',
			'keywords'   		=> array('promotion', 'advertisement', 'branding'),
			'mode'    			=> 'edit',
			'supports'   		=> array(
			 'mode'   			=> 'false',
			 'align'   			=> false,
			),
			'example'  			=> array(
			 	'attributes' 	=> array(
			  		'mode' => 'preview',
			  		'data' => array(
			   		'block_preview_image' => RHA_THEME_IMAGES_DIR . 'acf-block-preview/trip-promotion.png',
			  )
			 )
			),
		));

		// register a Content one block.
		acf_register_block_type(array(
			'name'				=> 'block-half-image-half-content',
			'title'				=> __('Half Image Half Content', 'rha'),
			'description'		=> __('A custom Half Content Half Image block.', 'rha'),
			'render_callback'	=> 'render_acf_block_callback',
			'category'			=> 'eb-blocks',
			'icon'				=> 'embed-photo',
			'keywords'			=> array('content'),
			'mode'				=> 'edit',
			'supports'			=> array(
				'mode'	=> 'false',
				'align'	=> false,
			),
			'example'  			=> array(
				'attributes' => array(
					'mode' => 'preview',
					'data' => array(
						'block_preview_image' => RHA_THEME_IMAGES_DIR . '/acf-block-preview/half-image-half-content.png',
					)
				)
			),
		));

		// Multiple Column Icon Text and Description - With Slider
		acf_register_block_type(array(
			'name'				=> 'block-multiple-column-icon-text-description-slider',
			'title'				=> __('Multiple Column Icon Text and Description - Slider', 'rha'),
			'description'		=> __('A custom Icon,Text and Description listing block in multiple columns with slider.', 'rha'),
			'render_callback'	=> 'render_acf_block_callback',
			'category'			=> 'eb-blocks',
			'icon'				=> 'grid-view',
			'keywords'			=> array('Feature', 'Feature One', 'Listing'),
			'mode'				=> 'edit',
			'supports'			=> array(
				'mode'	=> 'false',
				'align'	=> false,
			),
			'example'  			=> array(
				'attributes' => array(
					'mode' => 'preview',
					'data' => array(
						'block_preview_image' => RHA_THEME_IMAGES_DIR . '/acf-block-preview/Multi-Column-Text-Icon-Description-With-Slider.png',
					)
				)
			),
		));

		// register a Notable Achievement Counter Block.
		acf_register_block_type(array(
			'name'				=> 'block-notable-achievement-counter',
			'title'				=> __('Notable Achievement Counter', 'rha'),
			'description'		=> __('A custom achievement counter block.', 'rha'),
			'render_callback'	=> 'render_acf_block_callback',
			'category'			=> 'eb-blocks',
			'icon'				=> 'embed-photo',
			'keywords'			=> array('content'),
			'mode'				=> 'edit',
			'supports'			=> array(
				'mode'	=> 'false',
				'align'	=> false,
			),
			'example'  			=> array(
				'attributes' => array(
					'mode' => 'preview',
					'data' => array(
						'block_preview_image' => RHA_THEME_IMAGES_DIR . '/acf-block-preview/counter-percentage.png',
					)
				)
			),
		));

		// registers hero one block.
		acf_register_block_type(array(
			'name'				=> 'block-banner-with-title-subtitle-image-collage',
			'title'				=> __('Banner With Title Subtitle & Image Collage', 'rha'),
			'description'		=> __('A custom Banner block with Title,Subtitle and Image Collage.', 'rha'),
			'render_callback'	=> 'render_acf_block_callback',
			'category'			=> 'eb-blocks',
			'icon'				=> 'align-full-width',
			'keywords'			=> array('hero', 'banner'),
			'mode'				=> 'edit',
			'supports'			=> array(
				'mode'	=> 'false',
				'align'	=> false,
			),
			'example'  			=> array(
				'attributes' => array(
					'mode' => 'preview',
					'data' => array(
						'block_preview_image' => RHA_THEME_IMAGES_DIR . 'acf-block-preview/Multiple-image-banner.png',
					)
				)
			),
		));

		// Register Resource Listing
		acf_register_block_type(array(
			'name'				=> 'block-services-listing',
			'title'				=> __('Service Listing', 'rha'),
			'description'		=> __('A Custom Service Listing Block.', 'rha'),
			'render_callback'	=> 'render_acf_block_callback',
			'category'			=> 'eb-blocks',
			'icon'				=> 'filter',
			'keywords'			=> array('Service', 'Listing'),
			'mode'				=> 'edit',
			'supports'			=> array(
				'mode'	=> 'false',
				'align'	=> false,
			),
			'example'  			=> array(
				'attributes' => array(
					'mode' => 'preview',
					'data' => array(
						'block_preview_image' => RHA_THEME_IMAGES_DIR . '/acf-block-preview/service-listing.png',
					)
				)
			),
		));

		// register a gallery grid
		acf_register_block_type(array(
			'name'				=> 'block-gallery-grid',
			'title'				=> __('Gallery Grid', 'rha'),
			'description'		=> __('A Gallery Grid Block', 'rha'),
			'render_callback'	=> 'render_acf_block_callback',
			'category'			=> 'eb-blocks',
			'icon'				=> 'embed-photo',
			'keywords'			=> array('gallery', 'grid', 'image'),
			'mode'				=> 'edit',
			'supports'			=> array(
				'mode'	=> 'false',
				'align'	=> false,
			),
			'example'  			=> array(
				'attributes' => array(
					'mode' => 'preview',
					'data' => array(
						'block_preview_image' => RHA_THEME_IMAGES_DIR . '/acf-block-preview/gallery-grid.png',
					)
				)
			),
		));

		// register a gallery slider Page
		acf_register_block_type(array(
			'name'				=> 'block-gallery-slide',
			'title'				=> __('Page Gallery Slider', 'rha'),
			'description'		=> __('A Gallery Slider Block', 'rha'),
			'render_callback'	=> 'render_acf_block_callback',
			'category'			=> 'eb-blocks',
			'icon'				=> 'embed-photo',
			'keywords'			=> array('gallery', 'slide', 'image'),
			'mode'				=> 'edit',
			'supports'			=> array(
				'mode'	=> 'false',
				'align'	=> false,
			),
			'example'  => array(
				'attributes' => array(
					'mode' => 'preview',
					'data' => array(
						'block_preview_image' => RHA_THEME_IMAGES_DIR . 'acf-block-preview/gallery-slider.png',
					)
				)
			),
		));

		// register a Gallery Slider with Content
		acf_register_block_type(array(
			'name'				=> 'block-gallery-slider-with-content',
			'title'				=> __('Gallery Slider with Content', 'rha'),
			'description'		=> __('A custom Gallery slider with content', 'rha'),
			'render_callback'	=> 'render_acf_block_callback',
			'category'			=> 'eb-blocks',
			'icon'				=> 'embed-photo',
			'keywords'			=> array('Gallery', 'slider'),
			'mode'				=> 'edit',
			'supports'			=> array(
				'mode'			=> 'false',
				'align'			=> false,
			),
			'example'  => array(
				'attributes' => array(
					'mode' => 'preview',
					'data' => array(
						'block_preview_image' => RHA_THEME_IMAGES_DIR . '/acf-block-preview/gallery-slider-with-content.png',
					)
				)
			),
		));

		// register a Gallery Slider with Content
		acf_register_block_type(array(
			'name'				=> 'block-gallery-slide-with-grid',
			'title'				=> __('Gallery Slider with Grid', 'rha'),
			'description'		=> __('A custom Gallery slider with grid', 'rha'),
			'render_callback'	=> 'render_acf_block_callback',
			'category'			=> 'eb-blocks',
			'icon'				=> 'embed-photo',
			'keywords'			=> array('gallery', 'slide' , 'grid'),
			'mode'				=> 'edit',
			'supports'			=> array(
				'mode'			=> 'false',
				'align'			=> false,
			),
			'example'  => array(
				'attributes' => array(
					'mode' => 'preview',
					'data' => array(
						'block_preview_image' => RHA_THEME_IMAGES_DIR . '/acf-block-preview/gallery-slider-with-grid.png',
					)
				)
			),
		));

		// register a Trip Fact Block ( Trip detail page )
        acf_register_block_type(array(
            'name'				=> 'block-trip-fact',
            'title'				=> __('Trip Fact', 'rha'),
            'description'		=> __('A custom trip fact section', 'rha'),
            'render_callback'	=> 'render_acf_block_callback',
            'category'			=> 'eb-blocks',
            'icon'				=> 'embed-photo',
            'keywords'			=> array('Trip fact', 'Trip info'),
            'mode'				=> 'edit',
            'supports'			=> array(
                'mode'			=> 'false',
                'align'			=> false,
            ),
           'example'  => array(
                'attributes' => array(
                    'mode' => 'preview',
                    'data' => array(
                        'block_preview_image' => RHA_THEME_IMAGES_DIR . '/acf-block-preview/trip-fact.png',
                    )
                )
            ),
        ));

		// register a Trip Detail Itinerary Block ( Trip detail page )
        acf_register_block_type(array(
            'name'				=> 'block-details-itinerary',
            'title'				=> __('Trip Detail Itinerary', 'rha'),
            'description'		=> __('A custom detail itinerary for everyday trip', 'rha'),
            'render_callback'	=> 'render_acf_block_callback',
            'category'			=> 'eb-blocks',
            'icon'				=> 'embed-photo',
            'keywords'			=> array('Details Itinerary', 'itinerary', 'trip itinerary'),
            'mode'				=> 'edit',
            'supports'			=> array(
                'mode'			=> 'false',
                'align'			=> false,
            ),
            'example'  => array(
                 'attributes' => array(
                     'mode' => 'preview',
                     'data' => array(
                         'block_preview_image' => RHA_THEME_IMAGES_DIR . '/acf-block-preview/trip-itinerary.png',
                     )
                 )
             ),
        ));

		// Package Include Exclude Block ( Trip detail page )
        acf_register_block_type(array(
            'name'				=> 'block-package-include-exclude',
            'title'				=> __('Package Include/Exclude', 'rha'),
            'description'		=> __('You can add any packages include & exclude in your price or services', 'rha'),
            'render_callback'	=> 'render_acf_block_callback',
            'category'			=> 'eb-blocks',
            'icon'				=> 'embed-photo',
            'keywords'			=> array('include', 'exclude', 'trip exclude include '),
            'mode'				=> 'edit',
            'supports'			=> array(
                'mode'			=> 'false',
                'align'			=> false,
            ),
            /* 'example'  => array(
                 'attributes' => array(
                     'mode' => 'preview',
                     'data' => array(
                         'block_preview_image' => RHA_THEME_IMAGES_DIR . 'acf-block-preview/ecommerce-dropdown-filter.png',
                     )
                 )
             ),*/
        ));

		// Fix Departure Block ( Trip detail page )
		acf_register_block_type(array(
            'name'				=> 'block-fix-departure',
            'title'				=> __('Fix Departure', 'rha'),
            'description'		=> __('You can display fix departure dates for the specigic dates', 'rha'),
            'render_callback'	=> 'render_acf_block_callback',
            'category'			=> 'eb-blocks',
            'icon'				=> 'embed-photo',
            'keywords'			=> array('departure', 'dates'),
            'mode'				=> 'edit',
            'supports'			=> array(
                'mode'			=> 'false',
                'align'			=> false,
            ),
            /* 'example'  => array(
                 'attributes' => array(
                     'mode' => 'preview',
                     'data' => array(
                         'block_preview_image' => RHA_THEME_IMAGES_DIR . 'acf-block-preview/ecommerce-dropdown-filter.png',
                     )
                 )
             ),*/
        ));

		// Why choose us Block
		acf_register_block_type(array(
            'name'				=> 'block-why-choose-us',
            'title'				=> __('Why Choose Us', 'rha'),
            'description'		=> __('Why Choose us, background image', 'rha'),
            'render_callback'	=> 'render_acf_block_callback',
            'category'			=> 'eb-blocks',
            'icon'				=> 'embed-photo',
            'keywords'			=> array('tripadvisor', 'reivews'),
            'mode'				=> 'edit',
            'supports'			=> array(
                'mode'			=> 'false',
                'align'			=> false,
            ),
            'example'  => array(
                'attributes' => array(
                    'mode' => 'preview',
                    'data' => array(
                        'block_preview_image' => RHA_THEME_IMAGES_DIR . '/acf-block-preview/why-choose-us.png',
                    )
                )
             ),
        ));
	}
}
