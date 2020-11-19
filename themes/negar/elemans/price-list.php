<?php if ( ! defined( 'ABSPATH' ) ) exit; /* negar */ ?>

<?php
$all_product_ids = get_posts(array(
    'post_type' => 'product',
    'numberposts' => 4,
    'post_status' => 'publish',
    'fields' => 'ids',
));
$all_product_ids = implode(',', $all_product_ids);
echo do_shortcode('[vc_price_table title="لیست قیمت" products="' . $all_product_ids . '"]');
