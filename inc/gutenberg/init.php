<?php


function franklin_register_button_block() {

  // Register our block script with WordPress.
  wp_register_script(
    'franklin-button-block',
    plugins_url( '/blocks/button/block.js', __FILE__ ),
    array( 'wp-blocks', 'wp-element' )
  );

  // Enqueue the script in the editor.
  register_block_type('franklin/button', array(
    'editor_script' => 'franklin-button-block',
  ));
}

add_action( 'init', 'franklin_register_button_block' );