<?php

if ( !defined( 'ABSPATH' ) ) exit;

function franklin_media_block($atts) {

    extract(shortcode_atts(
        array(
            'align' => null,
            'title' => null,
            'subtitle' => null,
            'text' => null,
            'link' => null,
            'linktext' => null,
            'logo' => null,
            'alttext' => 'no alt text provided'
        ),
        $atts
    ));

    if(!$logo)
        return false;

    if(!$text && !$title)
        return false;

    $align = ($align == 'right') ? 'usa-media_block--right' : '';

    $output = '';
    // $output .= '<div class="usa-graphic_list">';
        $output .= '<div class="usa-media_block '.$align.'">';

            $output .= '<img class="usa-media_block-img" src="'.$logo.'" alt="'.$alttext.'">';

            $output .= '<div class="usa-media_block-body">';
                $output .= $title ? '<h3>'.$title.'</h3>': $title;
                $output .= $text ? '<p>'.$text.'</p>' : $text;
            $output .= '</div>';

        $output .= '</div>';
    // $output .= '</div>';

    return $output;
}

add_shortcode('media-block', 'franklin_media_block');
