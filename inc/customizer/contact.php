<?php

if ( !defined( 'ABSPATH' ) ) exit;

function franklin_contact_settings($wp_customize) {
    $wp_customize->add_section( 'contact_settings_section', array(
        'title'          => 'Contact Info',
        'priority'       => 30,
    ) );


    $links = array(
        'facebook' => 'Facebook Profile Link',
        'twitter' => 'Twitter Profile Link',
        'youtube' => 'Youtube Channel Link',
        'title' => 'Contact Title',
        'phone' => 'Contact Phone Number',
        'email' => 'Contact Email',
    );

    foreach($links as $name=>$label) {

        $wp_customize->add_setting( 'contact_settings['.$name.']', array(
            'default'        => '',
            'sanitize_callback' => 'franklin_'.$name.'_sanitize',
            'type' => 'option'
        ) );


        $wp_customize->add_control(
            'contact_'.$name.'_control',
            array(
                'label' => $label,
                'section' => 'contact_settings_section',
                'settings' => 'contact_settings['.$name.']',
                'type' => 'text',
            )
        );
    }


}

add_action('customize_register', 'franklin_contact_settings');



// sanitize functions
function franklin_social_link_sanitize($val = null, $site = null) {
    if(
        !$site
        || !$val
        || strpos($val, $site) < 0
        || filter_var($val, FILTER_VALIDATE_URL) === false
    )
        return null;

    $val = esc_url($val, array('http', 'https') );
    return $val;
}

function franklin_facebook_sanitize($val) {
    $site = 'facebook.com';
    return franklin_social_link_sanitize($val, $site);
}

function franklin_twitter_sanitize($val) {
    $site = 'twitter.com';
    return franklin_social_link_sanitize($val, $site);
}

function franklin_youtube_sanitize($val) {
    $site = 'youtube.com';
    return franklin_social_link_sanitize($val, $site);
}


function franklin_ig_sanitize($val) {
    $site = 'instagram.com';
    return franklin_social_link_sanitize($val, $site);
}


function franklin_phone_sanitize($val) {

    $val = preg_replace ('/\D/', '', $val);

    if ($val[0] == '1')
        $val = substr ($val, 1);  // remove prefix

    $invalid = strlen ($val) != 10  ||
               preg_match ('/^1/',      $val) ||  // ac start with 1
               preg_match ('/^.11/',    $val) ||  // telco services
               preg_match ('/^...1/',   $val) ||  // exchange start with 1
               preg_match ('/^....11/', $val) ||  // exchange services
               preg_match ('/^.9/',     $val);    // ac center digit 9
    if($invalid)
        return "NOPE";

    return $val;
}


function franklin_email_sanitize($val) {
    if(filter_var($val, FILTER_VALIDATE_EMAIL) === false)
        return null;

    return $val;
}


function franklin_title_sanitize($val) {
    return call_user_func('wp_filter_nohtml_kses', $val);
}
