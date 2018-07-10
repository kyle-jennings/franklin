<?php

if ( !defined( 'ABSPATH' ) ) exit;

// Labels
function franklin_label($atts){
    extract(shortcode_atts(
        array(
            'size' => null,
            'color' => 'primary',
            'text' => null
        ),
        $atts
    ));

    $size = $size ? 'usa-label-'.$size : null;
    $color = 'usa-label-'.$color;
    $class = implode(array($size, $color, $size), ' ');

    $output = '';
    $output .= '<span class="usa-label '.$class.'" >';
        $output .= $text;
    $output .= '</span>';

    if(!$text)
        return false;

    return $output;
}
add_shortcode('label', 'franklin_label');
