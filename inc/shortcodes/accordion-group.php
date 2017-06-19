<?php

if ( !defined( 'ABSPATH' ) ) exit;

// Accordions
function franklin_accordion_group($atts, $content = null) {

    extract(shortcode_atts(
        array(
            'ids' => null,
            'posttype' => 'post',
            'taxonomy' => 'category',
            'term' => null,
            'count' => 10,
        ),
        $atts
    ));

    $args = array(
        'post_type' => $posttype,
        'post__in' => $ids,
    );
    if($taxonomy != 'category' && $posttype != 'post') {
        $args['tax_query'] = array(
    		array(
    			'taxonomy' => $taxonomy,
    			'field'    => 'slug',
    			'terms'    => array($term),
    		),
    	);
    } else {
        $args['category_name'] = $term;
    }
    $posts = get_posts($args);

    $output = '';
    foreach($posts as $post){
        $t = $post->post_title;
        $c = $post->post_content;
        $output .= '[accordion title="'.$t.'"]'.$c.'[/accordion]';
    }
    $output = franklin_number_accordions($output);
    return do_shortcode($output);
}

add_shortcode('accordion-group', 'franklin_accordion_group');
