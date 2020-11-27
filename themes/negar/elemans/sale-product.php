<?php if ( ! defined( 'ABSPATH' ) ) exit;
$avn_option = getSetting();

// On sale products
$sale_args = array(
    'post_type'      => array('product', 'product_variation'),
    'posts_per_page' => $avn_option['count_product_per_page'],
    'orderby' =>'rand',
    'order' => $avn_option['sort_product'],
    'meta_query'     => array(
        'relation' => 'OR',
        array( // Simple products type
            'key'           => '_sale_price',
            'value'         => 0,
            'compare'       => '>',
            'type'          => 'numeric'
        ),
        array( // Variable products type
            'key'           => '_min_variation_sale_price',
            'value'         => 0,
            'compare'       => '>',
            'type'          => 'numeric'
        )
    )
);
$total=1;
$products = new WP_Query( $sale_args );
?>


<?php if ( $products->have_posts() ) { ?>
<section>
    <header class="ngr-eleman-title"><span>محصولات</span>تخفیف خورده</header>
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

                <?php $total++; endwhile; ?>
        </div>
    </div>
</section>
<?php } wp_reset_postdata(); ?>
