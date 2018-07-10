<?php

if ( !defined( 'ABSPATH' ) ) exit;

// Alerts
function franklin_alert($atts, $content = null){
    extract(shortcode_atts(
        array(
            'color' => 'primary',
            'title' => null,
            'text' => null,
        ),
        $atts
    ));


    $class = 'usa-alert-'.$color;

    $output = '';
    $output .= '<div class="usa-alert '.$class.'">';
        $output .= '<div class="usa-alert-body">';
            $output .= '<h3 class="usa-alert-heading">'.$title.'</h3>';
            $output .= '<p class="usa-alert-text">'.$text.'</p>';
        $output .= '</div>';
    $output .= '</div>';

    if(!$text)
        return false;

    return $output;
}
add_shortcode('alert', 'franklin_alert');
