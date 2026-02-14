<?php
/* To upload SVG */
function rha_mime_types($mimes)
{
    $mimes['svg'] = 'image/svg+xml';
    $mimes['webp'] = 'image/webp';
    return $mimes;
}
add_filter('upload_mimes', 'rha_mime_types');

/* Allowed HTML tags for ACF WYSIWYG field */
function getAllowedHtmlTags(){
    $allowed_html = [
        'span'   => [
            'class' => [],
            'id'    => [],
            'style' => [],
        ],
        'strong' => [],
        'b'      => [],
        'em'     => [],
        'i'      => [],
        'sup'    => [],
        'sub'    => [],
        'br'     => [],
        'small'  => [],
        'mark'   => [
            'class' => [],
        ],
    ];

    return $allowed_html;
}


/* To hide ACF field for sub level menu */
function rha_acf_parent_menu_show()
{
    echo '<style>
    .acf-menu-item-fields {
	    display: none!important;
	}
	.menu-item-depth-0 .acf-menu-item-fields {
	    display: block!important;
	}
  </style>';
}
add_action('admin_head', 'rha_acf_parent_menu_show');


/* render wrapper element for guttenburg core blocks */
add_filter('render_block', 'rha_wrap_core_block', 10, 2);
function rha_wrap_core_block($block_content, $block)
{
    $blockslist = array(
        'archives',
        'audio',
        'buttons',
        'calendar',
        'categories',
        'code',
        'columns',
        'coverImage',
        'embed',
        'file',
        'freeform',
        'gallery',
        'heading',
        'html',
        'image',
        'latest-comments',
        'latestPosts',
        'list',
        'more',
        'media-text',
        'nextpage',
        'paragraph',
        'preformatted',
        'pullquote',
        'quote',
        'query',
        'navigation',
        'site-title',
        'site-logo',
        'loginout',
        'rss',
        'reusableBlock',
        'separator',
        'shortcode',
        'spacer',
        'subhead',
        'search',
        'tag-cloud',
        'table',
        'textColumns',
        'verse',
        'video',
        'form',
        'facebook',
        'youtube',
        'instagram',
        'twitter',
        'latest-posts',
        'page-list',
        'post-navigation-link',
        'social-links'
    );

    foreach ($blockslist as $item) {

        if ('core/' . $item === $block['blockName'] || 'core-embed/' . $item === $block['blockName'] || 'gravityforms/' . $item === $block['blockName']) {

            $block_content = '<div class="wp-core-block block-' .  $item . '"><div class="container">' . $block_content . '</div></div>';
        }
    }

    return $block_content;
}

/* Show error message if acf plugin is not activated */
function acf_activation_message()
{
    if (!is_plugin_active('advanced-custom-fields-pro/acf.php')) {
        echo '<div class="container ecommerce-block-error mt-4">
			<div class="bg-danger text-white p-3">
				Please install and activate Advanced Custom Fields PRO to use this theme.
			</div>
		</div>';
        die;
    }
}
add_action('wp_head', 'acf_activation_message');


/*
 * This function alters the nav menu objects by appending Menu icon before the menu title 
 * if Menu with icon is enabled and menu title consists of menu icons
 */
add_filter('wp_nav_menu_objects', 'my_wp_nav_menu_objects', 10, 3);
function my_wp_nav_menu_objects($items, $args) {
    foreach ($items as &$item) {
        $icon = get_field('menu_icon', $item);
        if ($icon && isset($icon) ) {
            $icon_cropped_url = wp_get_attachment_image_src($icon['id'], array(24,24));
            $icon_alt = (isset($icon['alt']) && !empty($icon['alt'])) ? $icon['alt'] : $icon['title'];
            $item->title = '<img class="svg" src="' . $icon_cropped_url[0] . '" alt="'. $icon_alt .'" width="24" height="24">' . $item->title;
        }
    }
    return $items;
}

/*
 * Get post taxonomy list
 * Taxonomy list for blog sidebar 
 */ 
function rha_get_post_categories_taxonomy($left_sidebar_categories_selected_content, $left_sidebar_selected_categories, $taxonomy) {
    $resources_term = false;

    $all_resources_term = get_terms(array(
        'exclude'       => 1,
        'taxonomy'      => $taxonomy,
        'hide_empty'    => true,
    ));

    if( $left_sidebar_categories_selected_content == 'show-custom' && $left_sidebar_selected_categories ) {
        foreach ($left_sidebar_selected_categories as $term_id) {
            $term = get_term($term_id, $taxonomy);
            if ($term && !is_wp_error($term)) { 
                if(in_array($term, $all_resources_term)) {
                    $resources_term[] = $term;
                }
            }
        }
    
    } else {
        if (!empty($all_resources_term) && !is_wp_error($all_resources_term)) {
            $resources_term = $all_resources_term;
        }
    }
    return $resources_term;
}

/* Convert number digit into number word */
function rha_number_to_word($number) {
    switch($number) {
        case 2:
            $word = 'two';
            break;
        case 3:
            $word = 'three';
            break;
        case 4:
            $word = 'four';
            break;
        case 5:
            $word = 'five';
            break;
        case 6:
            $word = 'six';
            break;
        default:
            $word = 'one';
            break;
    }
    return $word;
}

/* Get Gallery Grid data from Gallery listing block */
function rha_gallery_grid_image($field) {
    $gallery_loop = array();
    $i = 0;
    $gallery_img = get_field($field);
    if($gallery_img!='' && is_array($gallery_img)) {
        foreach($gallery_img as $gallery) {
            if(isset($gallery['image_row']) && $gallery['image_row']!='') {
                $image_row = $gallery['image_row'];
                $j = 0;
                foreach($image_row as $image) {
                    if(isset($image['image'])) {
                        $img = $image['image'];
                        if($img!='') {
                            if(is_array($img) && isset($img['id'])) {
                                $logoid = $img['id'];
                                $gallery_loop[$i][] = $logoid;
                            } else {
                                $gallery_loop[$i][] = $img;
                            }
                            $j++;
                        }                  
                    }
                }
                $gallery_loop[$i][] = $j;
            }
            $i++;
        }
        return $gallery_loop;
    }
    return false;
}

/* Get page name from url for any link */
function rha_get_aria_label($url,$link_title) {
    // Remove the home URL to get the relative path
    $path = str_replace(home_url('/'), '', $url);

    // Get the post object based on the path
    $post = get_page_by_path($path);

    // Return the post title
    return 'Click ' . $link_title . ' link to know more about it' ;
}

function rha_nopaged_url() {
    $url =  isset($_SERVER['HTTPS']) && 
    $_SERVER['HTTPS'] === 'on' ? "https://" : "http://";   
 
    $url .= $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];     
    return $url;

}