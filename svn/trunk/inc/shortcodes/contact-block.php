<?php

if ( !defined( 'ABSPATH' ) ) exit;

// contact block
function franklin_contact_block($atts, $content = null){
    $options = get_option('contact_settings', null);

    extract(shortcode_atts(
        array(
            'facebook' => ($options['facebook'] ? $options['facebook'] : null ),
            'twitter' => ($options['twitter'] ? $options['twitter'] : null ),
            'youtube' => ($options['youtube'] ? $options['youtube'] : null ),
            'instagram' => ($options['instagram'] ? $options['instagram'] : null ),
            'phone' => ($options['phone'] ? $options['phone'] : null ),
            'email' => ($options['email'] ? $options['email'] : null ),
            'title' => ($options['title'] ? $options['title'] : null ),
            'rss' => get_bloginfo('rss2_url', null),
            'defaults' => null,
            'align' => null
        ),
        $atts
    ));

    $things = array('youtube', 'facebook', 'twitter', 'instagram', 'phone', 'email', 'rss', 'title');
    foreach($things as $thing){
            $$thing = ($$thing !== none && $$thing && $defaults != 'no' ) ? $$thing : null;
            $$thing = ($defaults == 'no' && isset($atts[$thing]) ) ? $atts[$thing] : $$thing;
    }

    $alignment = $align ? ' '.$align : '';

    $output = '';
    $output .= '<div class="usa-footer-contact-links'.$alignment.'">';
        if($facebook){
            $output .= '<a class="usa-social-link usa-link-facebook" href="'.$facebook.'">';
                $output .= '<span>Facebook</span>';
            $output .= '</a>';
        }
        if($twitter){
            $output .= '<a class="usa-social-link usa-link-twitter" href="'.$twitter.'">';
                $output .= '<span>Twitter</span>';
            $output .= '</a>';
        }

        if($youtube){
            $output .= '<a class="usa-social-link usa-link-youtube" href="'.$youtube.'">';
                $output .= '<span>YouTube</span>';
            $output .= '</a>';
        }

        if($rss){

            $output .= '<a class="usa-link-rss" href="'.$rss.'">';
                $output .= '<span>RSS</span>';
            $output .= '</a>';
        }
        $output .= '<address>';
            $output .= $title ? '<h3 class="usa-footer-contact-heading">'.$title.'</h3>' : '';
            $output .= $phone ? '<p>'.$phone.'</p>': '' ;
            $output .= $email ? '<a href="mailto:'.$email.'">'.$email.'</a>' : '' ;
        $output .= '</address>';
    $output .= '</div>';

    return $output;
}
add_shortcode('contact-block', 'franklin_contact_block');
