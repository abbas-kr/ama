<?php

class Negar_Plugin_tools{
    public function __construct()
    {
        add_action('wp_ajax_ngr_modal_category', array($this, 'load_ngr_modal_category') );
        add_action('wp_ajax_nopriv_ngr_modal_category', array($this, 'load_ngr_modal_category') );
        add_action( 'widgets_init', array($this,'ngr_widgets' ) );
	    add_action('admin_enqueue_scripts', array($this,'ngr_admin_style') , PHP_INT_MAX );
    }


    public function load_ngr_modal_category()
    {
        $args = array(
            'taxonomy' => 'product_cat',
            'hide_empty' => true,
            'parent' => 0
        );
        $product_cat = get_terms($args);
        $i = 0;
        echo '<div class="ngr-eleman-title"><span>دسته بندی</span>محصولات</div>';
        $cat_style = get_option('avn_negar');

        if ($cat_style['category_selection'] == 'style_six'){
            ?>
            <style>
                .category-style-six {
                    width: 100%;
                    height: 100%;
                }
            </style>
            <script>
                var swiper = new Swiper('.category-style-six', {
                    effect: 'coverflow',
                    grabCursor: true,
                    centeredSlides: true,
                    slidesPerView: 'auto',
                    coverflowEffect: {
                        rotate: 50,
                        stretch: 0,
                        depth: 100,
                        modifier: 1,
                        slideShadows : true,
                    },
                    pagination: {
                        el: '.swiper-pagination',
                    },
                });
            </script>

            <div class="ngr_slider category-style-six">
            <div class="swiper-wrapper">

                <?php
                foreach ($product_cat as $parent_product_cat) {
                    $category_thumbnail_id = get_woocommerce_term_meta($parent_product_cat->term_id, 'thumbnail_id', true);
                    $category_image = wp_get_attachment_url($category_thumbnail_id);
                    if (empty($category_image)) {
                        $placeholder_image = get_option('woocommerce_placeholder_image');
                        $category_image = wp_get_attachment_url($placeholder_image);
                    }
                ?>

                    <div class="swiper-slide" style="background-image:url(<?php echo esc_url($category_image) ?>)"></div>

                <?php } ?>

            </div>
            <div class="swiper-pagination"></div>
            </div>

        <?php
        }
        if ($cat_style['category_selection'] == 'style_seven'){
            foreach ($product_cat as $parent_product_cat) {
                $category_thumbnail_id = get_woocommerce_term_meta($parent_product_cat->term_id, 'thumbnail_id', true);
                $category_image = wp_get_attachment_url($category_thumbnail_id);
                if (empty($category_image)) {
                    $placeholder_image = get_option('woocommerce_placeholder_image');
                    $category_image = wp_get_attachment_url($placeholder_image);
                }
                echo '<div class="style-seven-box">';
                    echo '<a href="' . get_term_link($parent_product_cat->term_id) . '" class="ngr-cat-box" style="background-image: url(' . esc_url($category_image) . ')">';
                    echo '<span>'.$parent_product_cat->name.'</span></a>';
                    $wct_id = $parent_product_cat->term_id;
                    $wcatTerms = get_terms('product_cat', array('hide_empty' => 0,'number' => 3, 'orderby' => 'ASC', 'parent' => $wct_id,));
                    echo '<ul>';
                    foreach ($wcatTerms as $wcatTerm) {
                        ?>
                        <li>
                            <a href="<?php echo get_term_link($wcatTerm->slug, $wcatTerm->taxonomy); ?>"><?php echo $wcatTerm->name; ?></a>
                        </li>
                    <?php }
                    echo '</ul>';
                echo '</div>';
            }
        }
        else {
            foreach ($product_cat as $parent_product_cat) {
                $category_thumbnail_id = get_woocommerce_term_meta($parent_product_cat->term_id, 'thumbnail_id', true);
                $category_image = wp_get_attachment_url($category_thumbnail_id);
                if (empty($category_image)) {
                    $placeholder_image = get_option('woocommerce_placeholder_image');
                    $category_image = wp_get_attachment_url($placeholder_image);
                }
                switch ($i) {
                    case 0 :
                        echo '<a href="' . get_term_link($parent_product_cat->term_id) . '" class="ngr-cat-box part-0" style="background-image: url(' . esc_url($category_image) . ')"><span><span>' . $parent_product_cat->name . '</span></br><span class="number">' . $parent_product_cat->count . 'محصول<span><span/></a>';
                        $i++;
                        break;
                    case 1 :
                        echo '<a href="' . get_term_link($parent_product_cat->term_id) . '" class="ngr-cat-box part-1" style="background-image: url(' . esc_url($category_image) . ')"><span><span>' . $parent_product_cat->name . '</span></br><span class="number">' . $parent_product_cat->count . 'محصول<span><span/></a>';
                        $i++;
                        break;
                    case 2 :
                        echo '<a href="' . get_term_link($parent_product_cat->term_id) . '" class="ngr-cat-box part-2" style="background-image: url(' . esc_url($category_image) . ')"><span><span>' . $parent_product_cat->name . '</span></br><span class="number">' . $parent_product_cat->count . 'محصول<span><span/></a>';
                        $i++;
                        break;
                    case 3 :
                        echo '<a href="' . get_term_link($parent_product_cat->term_id) . '" class="ngr-cat-box part-3" style="background-image: url(' . esc_url($category_image) . ')"><span><span>' . $parent_product_cat->name . '</span></br><span class="number">' . $parent_product_cat->count . 'محصول</span><span/></a>';
                        $i = 0;
                        break;
                    default:
                        break;
                }
            }
        }
        wp_die();
    }

    public function ngr_widgets() {
        register_sidebar( array(
            'name'          => 'فیلتر فروشگاه قالب نگار',
            'id'            => 'ngr_filter',
            'before_widget' => '<div class="ngr_filter">',
            'after_widget'  => '</div>'
        ) );

        register_sidebar( array(
            'name'          => 'ابزارک اول قالب نگار',
            'id'            => 'ngr_first_widget',
            'before_widget' => '<div class="ngr_home_widget">',
            'after_widget'  => '</div>'
        ) );

        register_sidebar( array(
            'name'          => 'ابزارک دوم قالب نگار',
            'id'            => 'ngr_second_widgetfooter-nav-area .buttonbar-second span',
            'before_widget' => '<div class="ngr_home_widget">',
            'after_widget'  => '</div>'
        ) );

        register_sidebar( array(
            'name'          => 'فوتر قالب نگار',
            'id'            => 'ngr_footer_widget',
            'before_widget' => '<div class="ngr_footer_widget">',
            'after_widget'  => '</div>'
        ) );
    }

	// Update CSS within in Admin
	public function ngr_admin_style() {
    	    if(isset($_GET['page']) && $_GET['page'] == 'avn_negar_options') {
		        wp_enqueue_style('ngr_admin-styles', AVN_URL.'/assets/css/admin.css');
		        wp_dequeue_style( 'redux-admin-css');
		        wp_dequeue_style( 'redux-fields-css');

	        }

	}
}

new Negar_Plugin_tools();