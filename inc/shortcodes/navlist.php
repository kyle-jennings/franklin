<?php

if ( !defined( 'ABSPATH' ) ) exit;

function franklin_nav_list($atts, $content = null) {
    extract(shortcode_atts(
        array(
            'title' => null,
            'menu' => null,
        ),
        $atts
    ));

    $items = wp_get_nav_menu_items($menu);
    if(empty($items))
        return;

    $output = '';
    $output .= '<ul class="usa-unstyled-list">';
        $output .= '<li class="usa-footer-primary-link">';
            $output .= '<h4>Topic</h4>';
        $output .= '</li>';
        foreach($items as $item)
            $output .= '<li><a href="'.$item->url.'">'.$item->title.'</a></li>';

    $output .= '</ul>';

    return $output;
}
add_shortcode('nav-list', 'franklin_nav_list');
