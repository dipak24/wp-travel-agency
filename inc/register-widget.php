<?php
function rha_widgets_init()
{
    register_sidebar(
        array(
            'name'          => esc_html__('Sidebar', 'rha'),
            'id'            => 'sidebar-1',
            'description'   => esc_html__('Add widgets here.', 'rha'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        )
    );

    if (function_exists('get_field')) {
        $dynamic_widget_areas = array(
            "Footer Widget 1",
            "Footer Widget 2",
            "Footer Widget 3",
            "Footer Widget 4",
            "Footer Widget 5",
            "Footer Widget 6",
        );

        if (function_exists('register_sidebar')) {
            $index = 1;
            foreach ($dynamic_widget_areas as $widget_area_name) {
                register_sidebar(array(
                    'name' => $widget_area_name,
                    'id'            => 'footer-widget-' . $index,
                    'before_widget' => '<div id="%1$s" class="widget %2$s">',
                    'after_widget'  => '</div>',
                    'before_title' => '<strong class="title">',
                    'after_title' => '</strong>',
                ));
                $index++;
            }
        }
    }
}
add_action('widgets_init', 'rha_widgets_init');