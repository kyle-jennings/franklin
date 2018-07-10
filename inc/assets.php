<?php

function franklin_enqueue_script() {   
    wp_enqueue_script( 
        'franklin', 
        plugin_dir_url( dirname(__FILE__) ) . 'assets/js/franklin.min.js',
        array( 'jquery' )
    );
}

add_action( 'customize_controls_enqueue_scripts', 'franklin_enqueue_script' );
