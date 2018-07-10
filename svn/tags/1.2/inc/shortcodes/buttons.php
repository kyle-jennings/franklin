<?php

if ( !defined( 'ABSPATH' ) ) exit;

//// buttons
function franklin_button($atts, $content = null){
    extract(shortcode_atts(
        array(
            'target' => null,
            'size' => null,
            'color' => 'primary',
            'state' => null,
            'text' => null
        ),
        $atts
    ));

    $state = $state ? 'usa-button-'.$state : null;
    $color = 'usa-button-'.$color;
    $class = implode(array($size, $color, $state), ' ');

    $output = '';
    $output .= '<a class="usa-button '.$class.'" href="'.$target.'" >';
        $output .= $text;
    $output .= '</a>';

    if(!$text || !$target)
        return false;

    return $output;
}
add_shortcode('button', 'franklin_button');


// button group
function franklin_button_group($atts, $content = null){
    extract(shortcode_atts(
        array(
            'class' => null,
        ),
        $atts
    ));
    $class = ($class == 'dark') ? ' button_wrapper-dark' : '';
    return '<div class="button_wrapper'.$class.'">'. do_shortcode( $content ). '</div>';
}
add_shortcode('buttongroup', 'franklin_button_group');
