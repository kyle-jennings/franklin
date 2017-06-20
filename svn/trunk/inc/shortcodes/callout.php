<?php

if ( !defined( 'ABSPATH' ) ) exit;

function franklin_callout($atts, $content = null) {

    extract(shortcode_atts(
        array(
            'title' => null,
            'subtitle' => null,
            'text' => null,
            'link' => null,
            'linktext' => null

        ),
        $atts
    ));

    if(!$title && !$text)
        return false;

    $output = '';
    $output .= '<div class="usa-hero-callout usa-section-dark">';
        $output .= '<h2>';
            $output .= '<span class="usa-hero-callout-alt">'.$title.'</span> ';
            $output .= $subtitle;
        $output .= '</h2>';
        $output .= $text ? '<p class="site-description">'.$text.'</p>' : '';
        if($link && $linktext):
        $output .= '<a class="usa-button usa-button-big usa-button-secondary"
            href="'.$link.'">';
            $output .= $linktext;
        $output .= '</a>';
        endif;
    $output .= '</div>';

    return $output;
}

add_shortcode('callout', 'franklin_callout');
