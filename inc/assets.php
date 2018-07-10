<?php

function franklin_enqueue_script() {   
    wp_enqueue_script( 
        'franklin', 
        plugin_dir_url( dirname(__FILE__) ) . 'assets/js/franklin.js',
        array( 'jquery' )
    );
}

add_action( 'customize_controls_enqueue_scripts', 'franklin_enqueue_script' );


function franklin_admin_enqueue_script() {   
    wp_enqueue_script( 
        'franklin-admin', 
        plugin_dir_url( dirname(__FILE__) ) . 'assets/js/franklin-post-formats.js',
        array( 'jquery' )
    );
}

add_action( 'admin_enqueue_scripts', 'franklin_admin_enqueue_script' );