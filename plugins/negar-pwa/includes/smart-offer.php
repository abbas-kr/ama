<?php

class NGR_Smart_Offer
{
    private static $instance = null;

    public function __construct()
    {
        add_action('wp_ajax_ngr_smart_offer', array($this, 'load_ngr_smart_offer') );
        add_action('wp_ajax_nopriv_ngr_smart_offer', array($this, 'load_ngr_smart_offer') );
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new NGR_Smart_Offer();
        }
        return self::$instance;
    }

    public function load_ngr_smart_offer()
    {
        global $product;
        $upsells = $product->get_upsells();
        if (!$upsells)
            return;

        if (!is_wp_error($upsells) && is_array($upsells)) {
            $product = new WC_Product($upsells[0]);
            $thumbnail = has_post_thumbnail($upsells[0]) ? get_the_post_thumbnail_url($upsells[0], 'shop_catalog') : wc_placeholder_img_src();
            $products = array(
                'link' => get_the_permalink($upsells[0]),
                'title' => get_the_title($upsells[0]),
                'thumbnail' => $thumbnail,
                'sale_price' => strip_tags(wc_price($product->get_sale_price())),
                'regular_price' => strip_tags(wc_price($product->get_regular_price())),
            );
            ?>

            <div class="ngr-smart-offer row">
                <div class="col-4"><img src="<?= $products['thumbnail'] ?>" alt=""></div>
                <div class="col-8">
                    <a href="<?= $products['link'] ?>"><?= $products['title'] ?></a>
                    <span class="regular-price"><?= $products['regular_price'] ?></span>
                    <span class="sale-price"><?= $products['sale_price'] ?></span>
                </div>
            </div>

            <?php
        }

    }
}

NGR_Smart_Offer::getInstance();