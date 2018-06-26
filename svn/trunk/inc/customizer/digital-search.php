<?php

if ( !defined( 'ABSPATH' ) ) exit;


// if( function_exists('franklin_digital_search') )
//     return;

function franklin_digital_search($wp_customize) {


    $wp_customize->add_section( 'digital_search_section', array(
        'title'          => 'Digital Search',
        'priority'       => 38,
    ) );

    // the search engine
    $wp_customize->add_setting( 'digital_search_settings[engine]', array(
        'default'        => 'default',
        'sanitize_callback' => 'franklin_search_engine_sanitize',
        'type' => 'option'
    ) );

    $wp_customize->add_control(  'digital_search_engine'.'_control', array(
            'label'   => 'Search Engine',
            'section' => 'digital_search_section',
            'settings' => 'digital_search_settings[engine]',
            'type' => 'select',
            'choices' => array(
                'default' => 'Default (WordPress)',
                'digital-search' => 'Digital Search',
            )
        )
    );

    // the account handle
    $wp_customize->add_setting( 'digital_search_settings[id]', array(
        'default'        => '',
        'sanitize_callback' => 'wp_filter_nohtml_kses',
        'type' => 'option'
    ) );

    $wp_customize->add_control(  'digital_search_id_control', array(
            'label'   => 'Account ID',
            'section' => 'digital_search_section',
            'settings' => 'digital_search_settings[id]',
            'type' => 'text',
            'active_callback' => function() use ( $wp_customize ) {
                  return 'digital-search' === $wp_customize->get_setting( 'digital_search_settings[engine]' )->value();
             },
        )
    );

    // the custom domain field
    $wp_customize->add_setting( 'digital_search_settings[custom_domain]', array(
        'default'        => '',
        'sanitize_callback' => 'esc_url_raw',
        'type' => 'option'
    ) );

    $wp_customize->add_control(  'digital_search_custom_domain_control', array(
            'label'   => 'Custom Domain',
            'section' => 'digital_search_section',
            'settings' => 'digital_search_settings[custom_domain]',
            'type' => 'text',
            'active_callback' => function() use ( $wp_customize ) {
                  return 'digital-search' === $wp_customize->get_setting( 'digital_search_settings[engine]' )->value();
             },
        )
    );


}

if( !in_array('sites-dashboard/sites_dashboard.php', get_option('active_plugins')) )
    add_action('customize_register', 'franklin_digital_search');



function franklin_search_engine_sanitize($val) {
    $valids = array('default', 'digital-search');

    if(in_array($val, $valids))
        return $val;

    return false;
}
