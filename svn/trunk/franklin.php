<?php

/*
    Plugin Name: Franklin
    Plugin URI: https://github.com/kyle-jennings/franklin
    Description: Companion plugin for the Benjamin theme.  This plugin contains shortcodes, and support for Digital Search
    Author: Kyle Jennings
    Version: 1.1.1
    Author URI: https://kylejenningsdesign.com

    Sites report is released under GPL:
    http://www.opensource.org/licenses/gpl-license.php
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

if(!function_exists('franklin_examine')){

    function examine($obj, $type = null, $tags = null){
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




// if(get_current_theme() !== 'Benjamin')
//     return;

$files = array(
    'customizer/digital-search.php',
    'customizer/contact.php',
    'shortcodes.php',
    'get-options.php',
    'get-search-atts.php',
    'searchform.php'
);

foreach($files as $file)
    require_once 'inc/'.$file;
