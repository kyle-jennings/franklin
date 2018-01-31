<?php

/*
    Plugin Name: Franklin
    Plugin URI: https://github.com/kyle-jennings/franklin
    Description: Companion plugin for the Benjamin theme.  This plugin contains shortcodes, and support for Digital Search
    Author: Kyle Jennings
    Version: 1.2.3.1
    Author URI: https://kylejenningsdesign.com

    Sites report is released under GPL:
    http://www.opensource.org/licenses/gpl-license.php
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

if(!function_exists('franklin_examine')){

    function franklin_examine($obj, $type = null, $tags = null){
        if (empty($obj) && $obj != 0)
            return;

        if($tags == 'tags')
            $obj = htmlspecialchars($obj);

        echo '<pre>';
        if($type == 'var_dump')
            var_dump($obj);
        else
            print_r($obj);
        echo '</pre>';

        die;
    }
}


if(wp_get_theme()->Name !== 'Benjamin')
    return;



$files = array(

    'assets.php',

    'customizer/video-header.php',
    'customizer/digital-search.php',
    'customizer/contact.php',

    'metabox-featured-video.php',
    'video-markup.php',
    'get-options.php',
    'get-search-atts.php',

    'ajax.php',
    'shortcodes.php',
    'searchform.php',
);

foreach($files as $file)
    require_once 'inc/'.$file;
