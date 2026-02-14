<?php
add_filter('wp_nav_menu_objects', 'rha_wp_nav_menu_objects', 10, 2);
function rha_wp_nav_menu_objects( $items, $args ) {

    foreach ( $items as &$item ) {

        $enable_mega = get_field('enable_mega_memu', $item);
        $col         = get_field('sub_menu_column', $item);

        if ( $enable_mega ) {
            $item->classes[] = 'has-megamenu';
            $item->classes[] = 'sub-menu-col-' . intval( $col );
            $item->is_mega   = true; // custom flag for walker
        } else {
            $item->is_mega = false;
        }
    }

    return $items;
}
