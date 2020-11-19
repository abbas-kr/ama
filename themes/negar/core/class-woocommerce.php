<?php if ( ! defined( 'ABSPATH' ) ) exit; /* negar */ ?>
<?php

class Woocommerce_Functions
{

    public function __construct()
    {

        add_action('after_setup_theme', array($this, 'ngr_woocommerce_add_theme_support'));
        add_filter('woocommerce_add_to_cart_fragments', array($this, 'update_header_add_to_cart_fragment'));

        add_filter('woocommerce_show_variation_price', function () {
            return TRUE;
        });

        //show variation on cart
        add_filter('woocommerce_cart_item_name', array($this, 'cart_variation_description'), 20, 3);

        //add view account button on thank you page
        add_action( 'woocommerce_thankyou',  array($this, 'view_my_account') , 20 );

        // WooCommerce Rename Checkout Fields
        add_filter( 'woocommerce_checkout_fields' , array($this, 'custom_rename_wc_checkout_fields') , 1 );

        $this->ngr_single_product_hook();
        $this->ngr_archive_product_hook();

        add_action('woocommerce_account_dashboard' , array($this , 'show_last_order_in_dashboard'));

        add_filter('woocommerce_get_catalog_ordering_args', array($this,'am_woocommerce_catalog_orderby') , 9999);
        add_filter('posts_clauses', array($this,'order_by_stock_status') , 9999);

        //add woocommerce_breadcrumb
        add_action( 'woocommerce_after_single_product',  array($this, 'avn_single_product_breadcrumbs') , 20 );

        //remove up sells products
        remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );

    }

    public function avn_single_product_breadcrumbs()
    {
        woocommerce_breadcrumb();
    }

    function am_woocommerce_catalog_orderby( $args ) {
        $args['orderby'] = 'date';
        $args['order'] = 'desc';
        return $args;
    }

    function order_by_stock_status($posts_clauses) {
        global $wpdb;
        // only change query on WooCommerce loops
        if (is_woocommerce() && (is_shop() || is_product_category() || is_product_tag() || is_product_taxonomy())) {
            $posts_clauses['join'] .= " INNER JOIN $wpdb->postmeta istockstatus ON ($wpdb->posts.ID = istockstatus.post_id) ";
            $posts_clauses['orderby'] = " istockstatus.meta_value ASC, " . $posts_clauses['orderby'];
            $posts_clauses['where'] = " AND istockstatus.meta_key = '_stock_status' AND istockstatus.meta_value <> '' " . $posts_clauses['where'];
        }
        return $posts_clauses;
    }

    // Change placeholder and label text
    public function custom_rename_wc_checkout_fields( $fields ) {

        unset($fields['billing']['billing_address_2']);
        unset($fields['billing']['billing_company']);

        return $fields;
    }

    public function show_last_order_in_dashboard() {

        woocommerce_account_orders( 1 );

    }

    public function ngr_single_product_hook()
    {
        if (class_exists('TM_WC_Compare_Wishlist')){

            //Remove Wish & Compare
            remove_action( 'woocommerce_product_thumbnails', 'tm_woocompare_add_button_single', 35 );
            remove_action( 'woocommerce_product_thumbnails', 'tm_woowishlist_add_button_single', 35 );

            //Add Wish & Compare
            add_action( 'woocommerce_before_single_product_summary', 'tm_woowishlist_add_button_single', 5 );
            add_action( 'woocommerce_before_single_product_summary', 'tm_woocompare_add_button_single', 5 );

        }

        //add sharing button
        add_action( 'woocommerce_before_single_product_summary', array($this , 'ngr_share_button') , 5 );

        // add Close Button For Madal tabs
        add_action( 'woocommerce_product_after_tabs', array($this , 'modal_tabs_close_button' ), 10 );


        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
        remove_action('woocommerce_review_before', 'woocommerce_review_display_gravatar', 10);

        add_action('woocommerce_single_product_summary', array($this, 'ngr_star_rating') , 33);

        if (class_exists('TCW')) {
            add_action('woocommerce_single_product_summary', array($this, 'ngr_zanbi_custom_attribute') , 34);
            add_filter('remove_modal_in_negar' , '__return_false' );
        }

        add_action('woocommerce_single_product_summary', array($this, 'ngr_short_description') , 35);
    }

    public function ngr_archive_product_hook() {

        //archive Filter
        add_action('woocommerce_after_main_content', array($this, 'shop_modal_product_filter'));

        // Add top Category of Archive page
        add_action( 'woocommerce_before_main_content',  array($this, 'ngr_product_subcategories') , 20 );

        //Remove archive sidebar
        remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);

        //Remove Compare button
        remove_action( 'woocommerce_after_shop_loop_item', 'tm_woocompare_add_button_loop', 12 );

        //order By Stock
        add_filter( 'woocommerce_get_catalog_ordering_args', array($this, 'ngr_first_sort_by_stock_amount'), 99 );

        //Remove star rating
        remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
        remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count',  20);

        // Add top Category of Archive page
        add_action( 'woocommerce_before_shop_loop',  array($this, 'ngr_grid_list_swich_button') , 20 );

    }

    // Add WooCommerce to the theme
    public function ngr_woocommerce_add_theme_support()
    {
        add_theme_support('woocommerce');
        add_theme_support('wc-product-gallery-zoom');
        add_theme_support('wc-product-gallery-lightbox');
        add_theme_support('wc-product-gallery-slider');
    }


    public function cart_variation_description($name, $cart_item, $cart_item_key)
    {
        // Get the corresponding WC_Product
        $product_item = $cart_item['data'];

        if (!empty($product_item) && $product_item->is_type('variation')) {
            $result = $product_item->attribute_summary;
            $result2 = str_replace('::',':',$result);
            $result3 = str_replace(',','<br>',$result2);
            return '<a>'.$product_item->get_title().'</a><p class="product-attr">'. $result3 .'</p>';
        } else
            return $name;
    }

    public function view_my_account() {
        echo '<a class="view-account-btn" href="'.get_permalink(get_option('woocommerce_myaccount_page_id')).'">حساب کاربری</a>';
    }

    public function ngr_grid_list_swich_button()
    {
        echo '<div class="view-mode">
						<i class="fal fa-th-large active"></i>
						<i class="fal fa-th-list"></i>
				</div>';

    }

    public function ngr_first_sort_by_stock_amount( $args ) {
        $args['orderby'] = 'meta_value';
        $args['order'] = 'ASC';
        $args['meta_key'] = '_stock_status';
        return $args;
    }

    public function ngr_product_subcategories()
    {
        $args = array();
        $parentid = get_queried_object_id();
        $args = array('parent' => $parentid);
        $terms = get_terms('product_cat', $args);
        if (is_tax('product_cat')) {
            $cat = get_queried_object();
            if (0 == $cat->parent) {

                if ($terms) {
                    echo '<div class="hscroll-product swiper-container top-category-archive-page"><div class="hscroll-product-slider swiper-wrapper">';
                    foreach ($terms as $term) {
                        echo '<div class="swiper-slide"><a href="' . esc_url(get_term_link($term)) . '" class="' . $term->slug . '">';

                        $thumbnail_id = get_term_meta($term->term_id, 'thumbnail_id', true); // Get Category Thumbnail
                        $image = wp_get_attachment_url($thumbnail_id);

                        if ($image) {
                            echo '<div class="card-grad-back"><img src="' . $image . '" alt="' . $term->name . '" /></div>';
                        }
                        echo '<h2>' . $term->name . '</h2></a>';
                        $wct_id = $term->term_id;
                        $wcatTerms = get_terms('product_cat', array('hide_empty' => 0, 'orderby' => 'ASC', 'parent' => $wct_id,));
                        echo '<ul>';
                        foreach ($wcatTerms as $wcatTerm) {
                            ?>
                            <li>
                                <a href="<?php echo get_term_link($wcatTerm->slug, $wcatTerm->taxonomy); ?>"><?php echo $wcatTerm->name; ?></a>
                            </li>
                        <?php }
                        echo '</ul></div>';
                    }
                    echo '</div></div>';
                }
            }
        }
    }

    public function shop_modal_product_filter()
    {
        if (is_active_sidebar('ngr_filter')) : ?>
            <div id="ngr_product_filter" class="product-filter-modal">
                <?php dynamic_sidebar('ngr_filter'); ?>
            </div><!-- #primary-sidebar -->
        <?php endif;
    }

    public function ngr_share_button() {
        global $product;
        ?>
        <button class="button" id="ngr-share"><i class="fal fa-share-alt"></i></button>
        <script>
            window.addEventListener('load', function() {
                document.getElementById('ngr-share').addEventListener('click', function() {
                    navigator.share({
                        title: '<?php echo get_bloginfo( 'name' ); ?>',
                        text: '<?php echo $product->get_title(); ?>',
                        url: '<?php echo wp_get_shortlink( $product->get_id() ); ?>'
                    });
                });
            });

        </script>

    <?php }

    public function ngr_star_rating()
    {
        global $product;
        echo '<p class="ppla">';
        if (!empty(get_post_meta(get_the_ID(), 'pplu', true))) {
            echo ' آخرین بروزرسانی قیمت : ' . get_post_meta(get_the_ID(), 'pplu', true);
        }
        echo '</p>';
        if (!wc_review_ratings_enabled()) {
            return;
        }

        $rating_count = $product->get_rating_count();
        $review_count = $product->get_review_count();
        $average      = $product->get_average_rating();

        echo '<div class="single-side-box">';
        if ( $rating_count > 0 ) { ?>

            <div class="woocommerce-product-rating">
                <?php echo wc_get_rating_html( $average, $rating_count ); // WPCS: XSS ok. ?>
                <?php if ( comments_open() ) : ?>
                    <?php //phpcs:disable ?>
                    <a href="#reviews" class="woocommerce-review-link" rel="nofollow">(<?php printf( _n( '%s customer review', '%s customer reviews', $review_count, 'woocommerce' ), '<span class="count">' . esc_html( $review_count ) . '</span>' ); ?>)</a>
                    <?php // phpcs:enable ?>
                <?php endif ?>
            </div>

        <?php } else{ ?>
            <div class="star-rating"></div>
            <a href="#reviews" class="woocommerce-review-link" rel="nofollow">بدون امتیاز</a>
        <?php }

        if($product->is_in_stock()) {
            echo '<p class="is-in-stock"><i class="fal fa-check-circle"></i> موجود</p>';
        } else {
            echo '<p class="out-of-stock"><i class="fal fa-times"></i> ناموجود</p>';
        }
        echo '</div>';

    }



    public function modal_tabs_close_button()
    {
        echo '<a id="tab-closer" href="javascript:void(0)"><i class="fal fa-times"></i></a><div id="ngr-product-tab-modal"></div>';
    }


    public function ngr_short_description()
    {
        global $post;
        $short_description = apply_filters('woocommerce_short_description', $post->post_excerpt);

        if (!$short_description) {
            return;
        }
        ?>

        <div class="woocommerce-product-details__short-description">
            <div class="title-intro content-red-title">توضیح کوتاه<span> محصول </span></div>

            <?php echo $short_description; // WPCS: XSS ok.
            ?>
        </div>

        <?php
    }

    public function ngr_zanbi_custom_attribute()
    {
        $product_keys = get_post_meta(get_the_ID() , 'avn_product_key_attr', true);
        if(!empty($product_keys)) {
            echo '<div class="cus-box-style"><div class="title-intro content-red-title">ویژگی‌های کلیدی <span>محصول</span></div><ul class="cus-style">';
            foreach ($product_keys as $product_key) {
                echo '<li>' . $product_key . '</li>';
            }
            echo '</ul></div>';
        }
    }


    public function update_header_add_to_cart_fragment($fragments)
    {
        global $woocommerce;
        ob_start();
        ?>
        <a class="cart-customlocation" href="<?php echo esc_url(wc_get_cart_url()); ?>"
           title="نمایش سبد خرید"><i
                    class="fal fa-shopping-bag"></i><span><?php echo $woocommerce->cart->cart_contents_count; ?></span></a>
        <?php
        $fragments['a.cart-customlocation'] = ob_get_clean();
        return $fragments;
    }

}

new Woocommerce_Functions();
