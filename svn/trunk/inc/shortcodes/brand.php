<?php

if ( !defined( 'ABSPATH' ) ) exit;

// brand blocks
function franklin_brand_block($atts, $content = null){

    extract(shortcode_atts(
        array(
            'logo' => wp_get_attachment_url(get_theme_mod('custom_logo')),
            'title' => get_bloginfo( 'name' ),
            'url' => get_site_url(),
            'size' => null
        ),
        $atts
    ));
    $size = ($size == 'slim') ? '-slim' : '';
    $output .= '<div class="usa-footer-logo">';
        $output .= '<img class="usa-footer'.$size.'-logo-img" ';
            $output .= 'src="'.$logo.'" alt="Logo image">';
        $output .= '<h3 class="usa-footer'.$size.'-logo-heading">';
            $output .= '<a href="'.$url.'">'.$title.'</a>';
        $output .= '</h3>';
    $output .= '</div>';

    if(!$logo || $logo == '' || empty($logo))
        return;

    if(!$title || $title == '' || empty($title))
        return;

    return $output;
}
add_shortcode('brand', 'franklin_brand_block');
