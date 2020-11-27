<?php if (!defined('ABSPATH')) exit; /* negar */ ?>
<?php
$avn_option = getSetting();

$category = get_term_by('id', $theId, 'product_cat');
$category_slug = $category->slug;
$category_name = $category->name;

$new_args = array(
    'post_type' => 'product',
    'posts_per_page' => $avn_option['count_product_per_page'],
    'product_cat' => $category_slug,
    'order' => $avn_option['sort_product'],
    'meta_query' => array(
        array(
            'key' => '_stock_status',
            'value' => 'instock',
            'compare' => '='
        )
    )
);
$products = new WP_Query($new_args);


if ($products->have_posts()) { ?>

    <section>
        <header class="ngr-eleman-title">
            <?php
            $titles = strpos($category_name, ' ');
            $title = ($titles !== false) ? '<span>' . substr($category_name, 0, $titles) . '</span>' . ' ' . substr($category_name, $titles + 1) : $category_name;
            echo '<h2>' . $title;
            ?>
            <a class="list-link" href="<?php echo get_category_link($category) ?>">
                <i class="fal fa-ellipsis-h"></i>
            </a>
            </h2>
        </header>


        <div class="hscroll-product swiper-container">
            <div class="hscroll-product-slider swiper-wrapper">
                <?php while ($products->have_posts()) : $products->the_post();
                    global $product; ?>

                    <div class="swiper-slide">
                        <div <?php wc_product_class('', $product); ?>>
                            <?php
                            /**
                             * Hook: woocommerce_before_shop_loop_item.
                             *
                             * @hooked woocommerce_template_loop_product_link_open - 10
                             */
                            do_action('woocommerce_before_shop_loop_item');

                            /**
                             * Hook: woocommerce_before_shop_loop_item_title.
                             *
                             * @hooked woocommerce_show_product_loop_sale_flash - 10
                             * @hooked woocommerce_template_loop_product_thumbnail - 10
                             */
                            do_action('woocommerce_before_shop_loop_item_title');

                            /**
                             * Hook: woocommerce_shop_loop_item_title.
                             *
                             * @hooked woocommerce_template_loop_product_title - 10
                             */
                            do_action('woocommerce_shop_loop_item_title');

                            /**
                             * Hook: woocommerce_after_shop_loop_item_title.
                             *
                             * @hooked woocommerce_template_loop_rating - 5
                             * @hooked woocommerce_template_loop_price - 10
                             */
                            do_action('woocommerce_after_shop_loop_item_title');

                            /**
                             * Hook: woocommerce_after_shop_loop_item.
                             *
                             * @hooked woocommerce_template_loop_product_link_close - 5
                             * @hooked woocommerce_template_loop_add_to_cart - 10
                             */
                            do_action('woocommerce_after_shop_loop_item');
                            ?>
                        </div>

                    </div>

                <?php endwhile; ?>


            </div>

        </div>
    </section>

<?php }
wp_reset_postdata(); ?>
