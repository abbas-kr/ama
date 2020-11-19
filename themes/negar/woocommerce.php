<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * DanTheCoder - Innovative Web Solutions
 *
 * @author	DanTheCoder
 * @link	http://danthecoder.com
*/

get_header();
	if ( is_singular( 'product' ) ) {
		woocommerce_content();
	} else {
		wc_get_template( 'archive-product.php' );
	}
get_footer(); 
?>
