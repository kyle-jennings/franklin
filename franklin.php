<?php

/*
    Plugin Name: Franklin
    Plugin URI: https://github.com/kyle-jennings/franklin
    Description: Companion plugin for the Benjamin theme.  This plugin contains shortcodes, and support for Digital Search
    Author: Kyle Jennings
    Version: 1.4
    Author URI: https://kylejenningsdesign.com

    Sites report is released under GPL:
    http://www.opensource.org/licenses/gpl-license.php
*/

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

if(!defined('BENJAMIN_POST_FORMATS')) {
    define('BENJAMIN_POST_FORMATS', json_encode(
        array('audio', 'image', 'gallery', 'link', 'quote', 'status', 'video')
    ));

}


if(wp_get_theme()->Name !== 'Benjamin' )
    return;


$files = array(
    'assets',
    'customizer/digital-search',
    'customizer/contact',
    'video-markup',
    'get-options',
    'get-search-atts',
    'columns',
    'class-post-formats',
    'ajax',
    'shortcodes',
    'searchform',
);


// examine(plugin_dir_path(__FILE__) . 'inc/');
foreach($files as $file) {
    require_once plugin_dir_path(__FILE__) . 'inc/' . $file . '.php';
}


if(class_exists('BenjaminPostFormat')) {
    $files      = array('aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', '_markup');
    $admin_root = plugin_dir_path(__FILE__) . 'inc';
    foreach ($files as $file) {
        require_once $admin_root . DIRECTORY_SEPARATOR . 'post-formats' . DIRECTORY_SEPARATOR . $file . '.php';
    }
    
    BenjaminPostFormat::init(array('post', 'page'));
}

