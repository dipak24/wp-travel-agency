<?php
/**
 * WordPress Mega Menu Implementation
 * Works with existing ACF fields: 'enable_mega_memu' and 'sub_menu_column'
 * 
 * Add this to your theme's functions.php or include it as a separate file
 */

// ============================================================================
// CUSTOM WALKER FOR MEGA MENU
// ============================================================================

class Mega_Menu_Walker extends Walker_Nav_Menu {
    
    private $megamenu_tabs = array();
    private $current_tab_id = '';
    private $current_tab_items = array();
    private $current_megamenu_columns = 2;
    private $current_item_is_megamenu = false;
    private $parent_is_megamenu = false;
    private $in_sub_items = false;
    
    /**
     * Start Level - Opening <ul>
     */
    function start_lvl(&$output, $depth = 0, $args = null) {
        
        if ($depth === 0 && $this->current_item_is_megamenu) {
            // This is a mega menu dropdown
            $output .= '<div class="menu-dropdown">
                <div class="menu-dropdown-wrap">
                    <div class="left-content">
                        <div class="tab-lists">';
        } elseif ($depth === 1 && $this->parent_is_megamenu) {
            // This is the sub-items container for mega menu (right content area)
            // We'll handle this differently - don't output here
            $this->in_sub_items = true;
        } else {
            // Regular dropdown (for non-mega menu items)
            $indent = str_repeat("\t", $depth);
            $output .= "\n$indent<ul class=\"sub-menu\">\n";
        }
    }
    
    /**
     * End Level - Closing </ul>
     */
    function end_lvl(&$output, $depth = 0, $args = null) {
        
        if ($depth === 0 && $this->current_item_is_megamenu) {
            // Close mega menu structure
            $output .= '</div>
                    </div>
                    <div class="right-content">';
            
            // Output all the tab contents
            foreach ($this->megamenu_tabs as $tab_id => $tab_content) {
                $output .= $tab_content;
            }
            
            $output .= '</div>
                </div>
            </div>';
            
            // Reset mega menu flags
            $this->megamenu_tabs = array();
            $this->current_item_is_megamenu = false;
            $this->parent_is_megamenu = false;
        } elseif ($depth === 1 && $this->in_sub_items) {
            // End of mega menu sub-items
            $this->in_sub_items = false;
        } else {
            // Regular dropdown closing
            $indent = str_repeat("\t", $depth);
            $output .= "$indent</ul>\n";
        }
    }
    
    /**
     * Start Element - Individual menu item
     */
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';
        
        // Get mega menu settings from ACF
        $is_megamenu = isset($item->is_mega) ? $item->is_mega : false;
        $columns = get_field('sub_menu_column', $item);
        $columns = $columns ? absint($columns) : 2;
        
        // Classes
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        
        // Add 'menu-item-has-children' class for items with children (non-mega menu)
        if (!$is_megamenu && in_array('menu-item-has-children', $item->classes)) {
            $classes[] = 'has-dropdown';
        }
        
        // Set mega menu flags
        if ($is_megamenu && $depth === 0) {
            $this->current_item_is_megamenu = true;
            $this->parent_is_megamenu = false;
            $this->megamenu_tabs = array();
            $this->current_megamenu_columns = $columns;
        }
        
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
        
        // ID
        $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';
        
        // Build attributes array
        $atts = array();
        $atts['title']  = !empty($item->attr_title) ? $item->attr_title : '';
        $atts['target'] = !empty($item->target) ? $item->target : '';
        $atts['rel']    = !empty($item->xfn) ? $item->xfn : '';
        $atts['href']   = !empty($item->url) ? $item->url : '';
        
        $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);
        
        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }
        
        $title = apply_filters('the_title', $item->title, $item->ID);
        $title = apply_filters('nav_menu_item_title', $title, $item, $args, $depth);
        
        // For mega menu - depth 0 (parent)
        if ($depth === 0 && $is_megamenu) {
            $output .= $indent . '<li' . $id . $class_names . '>';
            
            $item_output = $args->before;
            $item_output .= '<a' . $attributes . '>';
            $item_output .= $args->link_before . $title . $args->link_after;
            $item_output .= '</a>';
            $item_output .= $args->after;
            
            $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
            
        } 
        // For mega menu - depth 1 (left tabs)
        elseif ($depth === 1 && $this->current_item_is_megamenu) {
            $this->parent_is_megamenu = true;
            $tab_id = 'tab-' . $item->ID;
            
            // Output tab button
            $output .= '<button data-target="' . esc_attr($tab_id) . '">' . esc_html($title) . '</button>';
            
            // Store current tab for sub-items
            $this->current_tab_id = $tab_id;
            $this->current_tab_items = array();
            
        } 
        // For mega menu - depth 2 (sub-items in columns)
        elseif ($depth === 2 && $this->parent_is_megamenu) {
            // Store sub-items for current tab
            $this->current_tab_items[] = '<li><a' . $attributes . '>' . esc_html($title) . '</a></li>';
            
        } 
        // Regular menu items (depth 0, 1, 2, etc. - non-mega menu)
        else {
            $output .= $indent . '<li' . $id . $class_names . '>';
            
            $item_output = $args->before;
            $item_output .= '<a' . $attributes . '>';
            $item_output .= $args->link_before . $title . $args->link_after;
            $item_output .= '</a>';
            $item_output .= $args->after;
            
            $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
        }
    }
    
    /**
     * End Element - Close menu item
     */
    function end_el(&$output, $item, $depth = 0, $args = null) {
        // For mega menu - depth 1 (after left tab and all its sub-items)
        if ($depth === 1 && $this->parent_is_megamenu && !empty($this->current_tab_items)) {
            // Create tab content with columns
            $columns = $this->current_megamenu_columns;
            $items_per_column = ceil(count($this->current_tab_items) / $columns);
            
            $tab_content = '<div class="tab-content" id="' . esc_attr($this->current_tab_id) . '">';
            
            $chunks = array_chunk($this->current_tab_items, $items_per_column);
            
            foreach ($chunks as $chunk) {
                $tab_content .= '<ul>' . implode('', $chunk) . '</ul>';
            }
            
            $tab_content .= '</div>';
            
            // Store tab content
            $this->megamenu_tabs[$this->current_tab_id] = $tab_content;
            
            // Reset
            $this->current_tab_items = array();
        } 
        // For mega menu - depth 2 (sub-items) - don't close anything
        elseif ($depth === 2 && $this->parent_is_megamenu) {
            // Don't output closing tag for mega menu sub-items
        } 
        // Regular menu items - close li tag
        else {
            $output .= "</li>\n";
        }
    }
}


// ============================================================================
// DISPLAY MENU FUNCTION
// ============================================================================

/**
 * Display mega menu in your theme template
 * 
 * Usage in header.php or wherever you want the menu:
 * 
 * <?php 
 * if (has_nav_menu('primary')) {
 *     display_megamenu('primary');
 * }
 * ?>
 */
function display_megamenu($theme_location = 'primary') {
    wp_nav_menu(array(
        'theme_location'  => $theme_location,
        'container'       => 'div',
        'container_class' => 'drop-wrap',
        'menu_class'      => '',
        'walker'          => new Mega_Menu_Walker(),
        'items_wrap'      => '<ul>%3$s</ul>',
        'depth'           => 0, // No depth limit - supports unlimited nesting
    ));
}