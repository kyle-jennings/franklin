<?php

if ( !defined( 'ABSPATH' ) ) exit;



/**
 * Remove some default settings from the customizer
 * @param  object $wp_customize
 */
function franklin_customizer_settings($wp_customize){

    require_once 'controls/Franklin_Video_Control.php';
    $wp_customize->register_control_type( 'Franklin_Video_Control' );
}
add_action('customize_register', 'franklin_customizer_settings', 50);


/**
 * Layout settings for each templates
 *
 * Settings allow configuring th hero size, the hero image,
 * and the position of the navbar.  I will soon add the ability to "activate"
 * the settings.  So if a user wants, they would only need to set the "default"
 * layout settings
 * @param  object $wp_customize
 */
function franklin_template_layout_settings($wp_customize) {


    $templates = benjamin_the_template_list();
    // for each template in the template list, we set up their customizer sections
    foreach($templates as $name => $template):


        /**
        * Hero video
        * @var array
        */
        $wp_customize->add_setting( $name . '_video_setting', array(
        'default'      => null,
        'sanitize_callback' => 'esc_url_raw',
        ) );

        $description = __('Use an uploaded video, or a video from youtube to display
        in the header. Uploaded videos should be 8M and should be a .mp4, .mov, or .webm format.', 'benjamin');

        $args = array(
            'description' => $description,
            'label'   => __('Header Video', 'benjamin'),
            'section' => $name . '_settings_section',
            'settings'   => $name . '_video_setting',
            'input_attrs' => array(
              'data-toggled-by' => $name . '_settings_active',
            ),
            'priority' => 3,
        );

        $wp_customize->add_control(
            new Franklin_Video_Control(
                $wp_customize,
                $name . '_video_setting_control',
                $args
            )
        );

    endforeach;

}
add_action('customize_register', 'franklin_template_layout_settings', 51);