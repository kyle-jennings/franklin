<?php

if ( !defined( 'ABSPATH' ) ) exit;

// Accordions
function franklin_accordion_group($atts, $content = null) {

    // if($atts['query'] !== 'advanced'){
        $args = franklin_accordion_group_simple($atts);
    // } else {
    //     $args = franklin_accordion_group_advanced($atts);
    // }


    $posts = get_posts($args);

    $output = '';

    // loop through each post and create teh accordion shortcode
    foreach($posts as $post){
        $t = $post->post_title;
        $c = $post->post_content;
        $output .= '[accordion title="'.$t.'"]'.$c.'[/accordion]';
    }

    // number the accordions
    $output = franklin_number_accordions($output);

    return do_shortcode($output);
}

add_shortcode('accordion-group', 'franklin_accordion_group');


function franklin_accordion_group_simple($atts) {

    extract(shortcode_atts(
        array(
            'ids' => null,
            'post_type' => 'post',
            'taxonomy' => null,
            'term' => null,
            'count' => 10,
            'query' => 'simple'
        ),
        $atts
    ));


    $args = array(
        'post_type' => $post_type,
        'post__in' => franklin_accordion_group_make_list($ids),
    );

    // if a taxonomy was set, and the posttype is not post then
    // we build the taxonomy args
    if($taxonomy != null && $post_type != 'post') {
        $args['tax_query'] = array(
    		array(
    			'taxonomy' => $taxonomy,
    			'field'    => 'slug',
    			'terms'    => franklin_accordion_group_make_list($term),
    		),
    	);
        // otherwise we just set the category name
    } else {
        $args['category_name'] = $term;
    }

    return $args;
}

function franklin_accordion_group_make_list($str) {
    // franklin_examine($str);
    $arr = array();
    if(strpos($str, ',')){

        $arr = explode(',', $str);

    } elseif(strpos($str, ', ') ){
        $arr = explode(', ', $str);
    }

    if(!empty($arr))
        return $arr;

    return false;
}

// function franklin_accordion_group_advanced($atts) {
//     unset($atts['query']);
//
//     $find = array('(',')', '=');
//     $replace = array('[', ']', '=>');
//
//     $args = array();
//     foreach($atts as $k=>$v){
//         if(strpos($v, '(') !== false ){
//
//             $tmp = explode(',', $v);
//             franklin_examine($tmp);
//         }
//     }
//
//     franklin_examine($atts);
// }
