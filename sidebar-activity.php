<?php
/**
 * Destination & Activity Sidebar Content
 *
 * @package Royal_Holidays_Adventures
 */

$left_sidebar_categories_title_one = get_field('destinations_sidebar_label','option') ? get_field('destinations_sidebar_label','option') : 'All nepal trek packages';
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
    <?php $has_categories = rha_get_post_categories_taxonomy($left_sidebar_categories_one_content, $left_sidebar_categories_one, 'destination'); 
    if($has_categories) { ?>

        <div class="side-bar-category">
            <ul class="side-bar-category__list">
                <li class="list-item <?php echo esc_attr($class); ?>"><a href="<?php echo esc_url( home_url('/destination/nepal/') ); ?>" ><?php echo esc_html($left_sidebar_categories_title_one); ?></a></li>
                <?php  foreach ($has_categories as $category) {
                    $class = "";
                    if( $current_taxonomy == 'category' && $tcurrent_term_id == $category->term_id ){
                        $class = "current-active-archive";
                    }
                    echo '<li class="list-item ' .esc_attr($class).'"><a href="' . esc_url( get_category_link( $category ) ) . '">' . esc_html( $category->name ). '</a></li>';
                } ?>
            </ul>
        </div>
    <?php } ?>
</div>