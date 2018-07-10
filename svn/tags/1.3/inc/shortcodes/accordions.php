<?php

if ( !defined( 'ABSPATH' ) ) exit;

// Accordions
function franklin_accordion($atts, $content = null) {

    extract(shortcode_atts(
        array(
            'title' => null,
            'style' => null,
            'id' => null,
            'single' => null
        ),
        $atts
    ));


    if(!$content || !$title)
        return false;

    $style = $style ? 'usa-alert-bordered' : 'usa-alert';

    $output = '';
    $output .= '<div class="usa-accordion-bordered">';
        $output .= '<button class="usa-accordion-button"
            aria-controls="accordion-'.$id.'"
            aria-expanded="false">';
            $output .= $title;
        $output .= '</button>';
        $output .= '<div class="usa-accordion-content" id="accordion-'.$id.'" >';
            $output .= '<p>';
            $output .= do_shortcode($content);
            $output .= '</p>';
        $output .= '</div>';
    $output .= '</div>';

    return $output;

}
add_shortcode('accordion', 'franklin_accordion');


// number the accordions
function franklin_number_accordions($content) {

    $output = preg_replace_callback('(\[accordion )', function($matches){

        static $id = 0;
        $id++;

        return '[accordion id="'.$id.'" ';
    }, $content);

    return $output;
}
add_filter( 'the_content', 'franklin_number_accordions');
