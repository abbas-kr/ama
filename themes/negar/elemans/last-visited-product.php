<?php if (!defined('ABSPATH')) exit; ?>
<?php

$viewed_products = !empty($_COOKIE['avn_woocommerce_recently_viewed']) ? (array)explode('|', wp_unslash($_COOKIE['avn_woocommerce_recently_viewed'])) : array(); // @codingStandardsIgnoreLine
$viewed_products = array_reverse(array_filter(array_map('absint', $viewed_products)));
if (empty($viewed_products)) {
    return;
}
$i = 0;
?>
<section>
    <header class="ngr-eleman-title"><span>آخرین</span>محصولات بازدید شده</header>
    <div class="avn-marquee">
        <?php ngr_svg('marquee'); ?>
        <div>
            <?php
            foreach ($viewed_products as $viewed_product) {
                $i++;
                if ($i > 3) {
                    break;
                }
                $terms = get_the_terms($viewed_product, 'product_cat');
                $rn = array_rand($terms, 1);
                $cat_slug = $terms[$rn]->slug;
                $default = array(
                    'post_type' => 'product',
                    'post_status' => 'publish',
                    'showposts' => '4',
                    'meta_query' => array(
                        array(
                            'key' => '_stock_status',
                            'value' => 'instock',
                            'compare' => '='
                        )
                    )
                );
                $default['tax_query'] = array(
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'slug',
                        'terms' => $cat_slug
                    )
                );
                $list = new WP_Query($default);

                if ($list->have_posts()) : ?>
                    <marquee scrolldelay="200" behavior="alternate" class="avn-marquee-style">
                        <?php
                        while ($list->have_posts()) : $list->the_post();
                            global $product;

                            $link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product );
                            ?>
                            <a href=" <?= esc_url( $link ) ?>"class="woocommerce-LoopProduct-link woocommerce-loop-product__link <?php if ($product->is_on_sale()) { echo 'border-sale'; } ?> ">
                            <?php
                            //if ($product->is_on_sale()) { echo ''; }
                            echo woocommerce_get_product_thumbnail('thumbnail');
                            echo '</a>';
                        endwhile; ?>
                    </marquee>
                <?php
                endif;
            }
            ?>
        </div>
    </div>
</section>