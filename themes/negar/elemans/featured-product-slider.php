<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * DanTheCoder - Innovative Web Solutions
 *
 * @author	DanTheCoder
 * @link	http://danthecoder.com
 */

?>

<?php
$avn_option = getSetting();

// featured products
$featured_args = array(
    'tax_query' => array(
        array(
            'taxonomy' => 'product_visibility',
            'field'    => 'name',
            'terms'    => 'featured',
            'operator' => 'IN'
        ),
    ),
    'posts_per_page' => $avn_option['count_product_per_page'],
    'orderby' =>'rand',
    'order' => $avn_option['sort_product']
);

$products = new WP_Query( $featured_args );
?>


<?php if ( $products->have_posts() ) { ?>
    <div class="ngr-eleman-title">
        <div class="ngr-eleman-title"><span>محصولات</span>ویژه
        </div>
    </div>
    <div class="hscroll-product swiper-container">
        <div class="hscroll-product-slider swiper-wrapper">

            <?php while ( $products->have_posts() ) : $products->the_post(); global $product; ?>

                <div class="swiper-slide">
                    <div <?php wc_product_class( '', $product ); ?>>
                        <?php
                        /**
                         * Hook: woocommerce_before_shop_loop_item.
                         *
                         * @hooked woocommerce_template_loop_product_link_open - 10
                         */
                        do_action( 'woocommerce_before_shop_loop_item' );

                        /**
                         * Hook: woocommerce_before_shop_loop_item_title.
                         *
                         * @hooked woocommerce_show_product_loop_sale_flash - 10
                         * @hooked woocommerce_template_loop_product_thumbnail - 10
                         */
                        do_action( 'woocommerce_before_shop_loop_item_title' );

                        /**
                         * Hook: woocommerce_shop_loop_item_title.
                         *
                         * @hooked woocommerce_template_loop_product_title - 10
                         */
                        do_action( 'woocommerce_shop_loop_item_title' );

                        /**
                         * Hook: woocommerce_after_shop_loop_item_title.
                         *
                         * @hooked woocommerce_template_loop_rating - 5
                         * @hooked woocommerce_template_loop_price - 10
                         */
                        do_action( 'woocommerce_after_shop_loop_item_title' );

                        /**
                         * Hook: woocommerce_after_shop_loop_item.
                         *
                         * @hooked woocommerce_template_loop_product_link_close - 5
                         * @hooked woocommerce_template_loop_add_to_cart - 10
                         */
                        do_action( 'woocommerce_after_shop_loop_item' );
                        ?>
                    </div>
                </div>
            <?php endwhile; ?>

        </div>
    </div>
<?php } wp_reset_postdata(); ?>
