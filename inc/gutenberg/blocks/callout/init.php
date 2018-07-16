<?php


  // Register our block script with WordPress.
  wp_register_script(
    'franklin-callout-block-js',
    plugins_url( '/lib/block.js', __FILE__ ),
    array( 'wp-blocks', 'wp-element' )
  );

  // Register our block's editor-specific CSS.
  wp_register_style(
    'franklin-callout-block-css',
    plugins_url( '/lib/backend.css', __FILE__ ),
    array( 'wp-edit-blocks' )
  );

  // Enqueue the script in the editor.
  register_block_type(
    'franklin/callout', 
    array(
      'editor_script' => 'franklin-callout-block-js',
      'editor_style' => 'franklin-callout-block-css',
    )
  );