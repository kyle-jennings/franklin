<?php

/*
    Plugin Name: Franklin
    Plugin URI: https://github.com/kyle-jennings/franklin
    Description: Companion shortcodes for the Benjamin theme.
    Author: Kyle Jennings
    Version: 1.1.0
    Author URI: https://kylejenningsdesign.com

    Sites report is released under GPL:
    http://www.opensource.org/licenses/gpl-license.php
*/

if(get_current_theme() !== 'Benjamin')
    return;

$files = array('shortcodes.php');

foreach($files as $file)
    require_once 'inc/'.$file;
