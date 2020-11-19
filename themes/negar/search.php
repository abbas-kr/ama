<?php if ( ! defined( 'ABSPATH' ) ) exit;

wp_redirect( home_url( "?s=".get_search_query()."&post_type=product" ) );
exit;
