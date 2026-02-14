<?php
/**
 * Blog Sidebar Content
 *
 * @package starterkit-theme-four
 */

$left_sidebar_categories_title_one = get_field('left_sidebar_categories_title_one','option') ? get_field('left_sidebar_categories_title_one','option') : 'Latest';
$left_sidebar_categories_one_content = get_field('left_sidebar_categories_one_content','option');
$left_sidebar_categories_one = get_field('left_sidebar_categories_one','option');
$left_sidebar_categories_title_two = get_field('left_sidebar_categories_title_two','option') ? get_field('left_sidebar_categories_title_two','option') : 'Other Resources';
$left_sidebar_categories_two_content = get_field('left_sidebar_categories_two_content','option');
$left_sidebar_categories_two = get_field('left_sidebar_categories_two','option');

$default_taxonomy = 'resource';

if( is_archive() ){
    $queried_obj = get_queried_object();
}

$current_taxonomy = isset( $queried_obj->taxonomy ) ? $queried_obj->taxonomy : '';
$tcurrent_term_id = isset( $queried_obj->term_id ) ? $queried_obj->term_id : ''; 
$class = $current_taxonomy ? '' : 'current-active-archive'; ?>

<div class="side-bar">

    <?php $has_categories = rha_get_post_categories_taxonomy($left_sidebar_categories_one_content, $left_sidebar_categories_one, 'category'); 

    if($has_categories) { ?>

        <div class="side-bar-category">
            <ul class="side-bar-category__list">
                <li class="list-item <?php echo esc_attr($class); ?>"><a href="<?php echo esc_url( home_url('/blog/') ); ?>" ><?php echo esc_html($left_sidebar_categories_title_one); ?></a></li>
                <?php  foreach ($has_categories as $category) {
                    $class = "";
                    if( $current_taxonomy == 'category' && $tcurrent_term_id == $category->term_id ){
                        $class = "current-active-archive";
                    }
                    echo '<li class="list-item ' .esc_attr($class).'"><a href="' . esc_url( get_category_link( $category ) ) . '">' . esc_html( $category->name ). '</a></li>';
                } ?>
            </ul>
        </div>

    <?php } 
    
    $has_resources = rha_get_post_categories_taxonomy($left_sidebar_categories_two_content, $left_sidebar_categories_two, $default_taxonomy); 

    if($has_resources) { ?>
    
        <div class="other-resources">

            <h3 class="h6 other-resources__title"><?php echo esc_html( $left_sidebar_categories_title_two ); ?></h3>
            <ul class="other-resources__list">
                <?php foreach ($has_resources as $resource_term) {
                    $class = "";
                    if( $current_taxonomy == 'resource' && $tcurrent_term_id == $resource_term->term_id ) {
                        $class = "current-active-archive";
                    }
                    echo '<li class="list-item ' .esc_attr($class).'"><a href="' . esc_url(get_term_link($resource_term)) . '">' . esc_html( $resource_term->name ). '</a></li>';
                } ?>
            </ul>
        </div>
    <?php } ?>

</div>
