<?php
if ( !defined( 'ABSPATH' ) ) exit;


function franklin_get_search_atts() {

    $id = get_current_blog_id();

    extract( franklin_get_options() );

    // if the search engine was set tp digital Search
    // and the search account was
    $use_search = ( in_array($search_engine, array('digitalgov', 'digital-search'))
                    && !empty($search_id)
                ) ? true : false ;


    // if using digital search, we have either a boutique search url,
    // or the standard url at search.usa.gov
    $spec_action = !empty($search_url)
        ?  $search_url . '/search'
        : 'http://search.usa.gov/search';

    // if using D search, we used the special url, otherwise we use the default WP url
    $action = $use_search ? $spec_action : home_url( '/' );

    // D search requires a hidden field
    $hidden = $use_search
        ? '<input id="affiliate" name="affiliate" type="hidden" value="'.$search_id.'" />'
        : '';

    // D search uses it's own name for the input field, WP uses "s"
    $name = $use_search ? 'query' : 's';

    // package up these args
    $args = array(
        'use_search' => $use_search,
        'action' => $action,
        'hidden' => $hidden,
        'name' => $name
    );

    return $args;
}
