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

if(get_current_theme() !== 'Benjamin')
    return;

$files = array('customizer-contact.php', 'shortcodes.php', 'digital-search.php', 'searchform.php');

foreach($files as $file)
    require_once 'inc/'.$file;
