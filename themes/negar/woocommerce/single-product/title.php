<?php
/**
 * Single Product title
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/title.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see        https://docs.woocommerce.com/document/template-structure/
 * @package    WooCommerce/Templates
 * @version    1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
global $product;
the_title( '<h1 class="product_title entry-title">', '</h1>' );
if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>

    <span class="sku_wrapper"><?php esc_html_e( 'SKU:', 'woocommerce' ); ?> <span class="sku"><?php echo ( $sku = $product->get_sku() ) ? $sku : esc_html__( 'N/A', 'woocommerce' ); ?></span></span>

<?php endif; ?>


<?php
$product_posetive_keys = get_post_meta(get_the_ID(), 'avn_product_positive_key', true);
$product_negative_keys = get_post_meta(get_the_ID(), 'avn_product_negative_key', true);
if ((!empty($product_posetive_keys) || !empty($product_negative_keys)) && ( $product_posetive_keys[0] != '' || $product_negative_keys[0] != '' )) {
    ?>
    <div class="single-product-bottom">
        <div id="product-point-tabs">
            <a id="pos-tab" class="active" href="javascript:void(0)"><i class="fal fa-thumbs-up"></i><strong>نقاط
                    قوت</strong></a>
            <a id="neg-tab" href="javascript:void(0)"><i class="fal fa-thumbs-down"></i><strong>نقاط ضعف</strong></a>

            <?php
            if (!empty($product_posetive_keys)) {
                echo '<div class="product-point positive zshow"><ul>';
                foreach ($product_posetive_keys as $product_posetive_key) {
                    echo '<li>' . $product_posetive_key . '</li>';
                }
                echo '</ul></div>';
            }
            if (!empty($product_negative_keys)) {
                echo '<div class="product-point negative"><ul>';
                foreach ($product_negative_keys as $product_negative_key) {
                    echo '<li>' . $product_negative_key . '</li>';
                }
                echo '</ul></div>';
            }
            ?>
        </div>
    </div>
    <?php
}

?>
