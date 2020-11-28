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
$i=1;

// Best Sellers
$best_sellers_args = array(
    'post_type' => 'product',
    'meta_key' => 'total_sales',
    'posts_per_page' => $avn_option['count_product_per_page'],
    'orderby' =>'meta_value_num',
    'order' => $avn_option['sort_product']
);
$products = new WP_Query( $best_sellers_args );
?>


<?php if ( $products->have_posts() ) { ?>
<section class="relative-box">
    <header class="ngr-eleman-title"><span class="best-product-counter"><?php echo $avn_option['count_product_per_page'] ?></span> محصول پرفروش
        <span class="topbox-best-product"></span>
    </header>
    <div class="hscroll-product swiper-container">
        <div class="hscroll-product-slider swiper-wrapper">

            <?php while ( $products->have_posts() ) : $products->the_post(); global $product; ?>

                <div class="swiper-slide">
                    <div <?php wc_product_class( '', $product ); ?>>
                        <?php
                        echo '<span class="count">'. $i .'</span>';
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
                        $i++;
                        ?>
                    </div>
                </div>
            <?php endwhile; ?>

        </div>
    </div>
</section>
<?php } wp_reset_postdata(); ?>
