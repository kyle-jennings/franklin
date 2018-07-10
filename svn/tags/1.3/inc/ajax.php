<?php


function franklin_ajax_video() {
    if(isset($_POST['data']))
        $url = esc_url_raw( wp_unslash( $_POST['data'] ) );
    else
        wp_die();

    franklin_the_video_markup($url);
    wp_die();
}
add_action('wp_ajax_franklin_video_shortcode', 'franklin_ajax_video');