<?php

if ( !defined( 'ABSPATH' ) ) exit;


function franklin_get_options() {

    if( in_array('sites-dashboard/sites_dashboard.php', get_option('active_plugins')) ) {

        $search = get_option('sites-select-search', null);
        $search_engine = isset($search['sites-select-search-status']) ? $search['sites-select-search-status'] : null;
        $search_id = isset($search['sites-select-search-id']) ? $search['sites-select-search-id'] : null;
        $search_url = isset($search['sites-select-search-url']) ? $search['sites-select-search-url'] : null;

    } else {

        $digital_search = get_option('digital_search_settings', array());
        $search_engine = $digital_search['engine'] ? $digital_search['engine'] : null;
        $search_id = $digital_search['id'] ? $digital_search['id'] : null;
        $search_url = $digital_search['custom_domain'] ? $digital_search['custom_domain'] : null;
    }

    return array(
        'search_engine' => $search_engine,
        'search_id' => $search_id,
        'search_url' => $search_url,
    );
}
