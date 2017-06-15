<?php

if ( !defined( 'ABSPATH' ) ) exit;


$includes = array(
    'buttons',
    'labels',
    'alerts',
    'accordions',
    'brand',
    'contact-block',
    'navlist',
    'callout',
    'media-block',
    'grid-columns',
);
foreach($includes as $include)
    include 'shortcodes/'.$include.'.php';
