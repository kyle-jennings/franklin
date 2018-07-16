<?php


function franklin_register_button_block() {
  
  if( !function_exists('register_block_type') ) {
    return;
  }

  $blocks = array(
    'accordion',
    'alert',
    'alertpanel',
    'button',
    'callout',
  );

  foreach($blocks as $block) {
    $blocks_dir = plugin_dir_path(__FILE__) . 'blocks/';
    include_once( $blocks_dir . $block . '/init.php' );
  }

}


add_action( 'init', 'franklin_register_button_block' );