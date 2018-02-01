<?php
/**
 * This file contains the function which produce html videos, and also has some
 * helper functions
 */

/**
 * Get the featured video post meta
 */
function franklin_get_the_post_video_url() {
    global $post;
    $url = get_post_meta($post->ID, 'featured-video', true);

    return $url;
}

/**
 * Does this post have a featured video?
 * @return boolean
 */
function franklin_has_post_video() {
    global $post;

    $url = get_post_meta($post->ID, 'featured-video', true);
    if($url)
        return true;

    return false;
}

/**
 * returns the video markup
 * @param  string $url the url of the video
 * @param  string $background is this a background video (header)?
 * @return string the markup
 */
function franklin_get_the_video_markup($url = null, $background = null) {
    if(!$url)
        return;

    $settings = '';
    $src = ($background == 'background') ? 'data-src' : 'src';
    $type = franklin_get_video_type($url);

    $output = '';
    $atts = '';

    // if the video type is not YT or vimeo then its a locally hosted vid.. maybe
    if( !in_array($type, array('youtube', 'vimeo') )){
        if($background == 'background')
            $atts = 'autoplay loop muted';
        else
            $atts = 'controls';

        $output .= '<div class="video-bg">';
            $output .= '<video class="video" '.esc_attr($atts).' '.$src.'="'.esc_attr($url).'" type="video/'.esc_attr($type).'">';
            $output .= '</video>';
        $output .= '</div>';
    }elseif( wp_oembed_get($url) ) {

        if($background == 'background')
            $atts = 'autoplay loop muted';
        else
            $atts = 'controls';

        // $args = $background ? 'autoplay loop muted' : '';
        $id = franklin_get_youtube_id($url);
        $poster = 'style="background-image: url(https://img.youtube.com/vi/'.esc_attr($id).'/0.jpg); background-repeat:no-repeat; background-size:cover;"';

        $output .= '<div class="video-bg video-bg--youtube" '.$poster.'>';
            $output .= wp_oembed_get($url, $atts);
        $output .= '</div>';
    }



    return $output;
}


/**
 * Echos the video markup from the franklin_get_the_video_markup function
 *
 * escaping happens in franklin_get_the_video_markup function(); 
 * @param  string $url the url of the video
 * @param  string $background is this a background video (header)?
 * @return echo the markup
 */
function franklin_the_video_markup($url, $background = null) {
    echo franklin_get_the_video_markup($url, $background);  // WPCS: xss ok;
} 

/**
 * Just grabs the ID of hte youtube video - used to get hte poster
 * @param  string $url the url of the video
 * @return string      YT id
 */
function franklin_get_youtube_id($url) {
    preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
    return $match[1];
}


/**
 * Identifies whether or not the video is locally uploaded (looks at the file type)
 * or if its a youtube or vimeo video
 * @param  string $url the url of the video
 * @return string      the video type
 */
function franklin_get_video_type($url) {


    $last_dot = strrpos($url, '.') + 1;
    $type = null;

    if ( preg_match( '#^https?:\/\/(?:www\.)?(?:youtube\.com|youtu\.be)#', $url ) ) {
        $type = 'youtube';
    } elseif( preg_match( '#^https?:\/\/(?:www\.)?(?:vimeo\.com|youtu\.be)#', $url ) ) {
        $type = 'vimeo';
    } elseif( in_array( $type = substr( $url, $last_dot), array('mp4', 'mov', 'webm') ) ) {
        $type = substr( $url, $last_dot);
    }


    return $type;
}


/**
 * adds teh correct settings to oembeded stuff
 * @param  [type] $html [description]
 * @return [type]       [description]
 */
function franklin_youtube_embed_url($html) {
    $settings ='autoplay=1&mute=1&loop=1&autohide=1&modestbranding=0&rel=0&showinfo=0&controls=0&disablekb=1&enablejsapi=0&iv_load_policy=3';
    return str_replace("?feature=oembed", "?feature=oembed&".$settings, $html);
}
add_filter('oembed_result', 'franklin_youtube_embed_url');
