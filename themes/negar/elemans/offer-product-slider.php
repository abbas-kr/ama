<?php if (!defined('ABSPATH')) exit;
// On sale products
$sale_args = array(
    'post_type' => array('product', 'product_variation'),
    'meta_query' => array(
        array(
            'key' => '_sale_price',
            'value' => 0,
            'compare' => '>',
            'type' => 'NUMERIC'
        ),
        array(
            'key' => '_sale_price_dates_to',
            'value' => time(),
            'compare' => '>',
            'type' => 'NUMERIC'

        )
    ),
    'post_status' => 'publish',
    'showposts' => '6'
);
$total = 1;
$products = new WP_Query($sale_args);
$id = 'sw_countdown_' . rand() . time();
?>

<?php if ($products->have_posts()) { ?>
<section>
    <header class="ngr-eleman-title"><span>پیشنهاد</span>شگفت انگیز</header>
    <div class="timer-product-slider swiper-container">
        <div class="swiper-wrapper">

            <?php while ($products->have_posts()) : $products->the_post();
                global $product; ?>

                <div class="swiper-slide">
                    <div class="card" style="border: 0;">
                        <div class="card-content">
                            <div class="base">

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
                            <?php
                            $start_time = get_post_meta($post->ID, '_sale_price_dates_from', true);
                            $countdown_time = get_post_meta($post->ID, '_sale_price_dates_to', true);
                            ?>
                            <div class="contdown-sale countdown-left">
                                <div class="product-countdown"
                                     data-starttime="<?php echo esc_attr($start_time); ?>"
                                     data-cdtime="<?php echo esc_attr($countdown_time); ?>"
                                     data-id="<?php echo 'product_' . $id . $post->ID; ?>"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php $total++; endwhile; ?>

        </div>
    </div>
</section>
<?php }
wp_reset_postdata(); ?>
