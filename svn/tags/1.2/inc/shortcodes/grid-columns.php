<?php

if ( !defined( 'ABSPATH' ) ) exit;

function franklin_grid($atts, $content = null){
    return do_shortcode( $content );
    // return '<div class="usa-grid">'. do_shortcode( $content ). '</div>';
}
add_shortcode('grid', 'franklin_grid');


function franklin_column($atts, $content = null) {
    extract(shortcode_atts(
        array(
            'width' => null,
        ),
        $atts
    ));
    if($width == null)
        return false;
    return '<div class="usa-width-'.$width.'">'. do_shortcode( $content ). '</div>';
}
add_shortcode('column', 'franklin_column');
