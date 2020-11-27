<?php if (!defined('ABSPATH')) exit;

$categories = get_terms(array(
    'taxonomy' => 'product_cat',
    'hide_empty' => false,
    'parent' => '0'
));
if (!empty($categories)) { ?>
<section>
    <header class="ngr-eleman-title"><span>دسته بندی</span>محصولات</header>
    <div class="hscroll-category-product category-swiper-container">
        <div class="swiper-wrapper">
            <?php foreach ($categories as $category) { ?>
                <div class="swiper-slide">
                    <div class="card-content">
                        <a href="<?php echo get_term_link($category); ?>">
                            <?php
                            $thumbnail_id = absint( get_term_meta( $category->term_id, 'thumbnail_id', true ) );
                            $thumbnail_img = wp_get_attachment_image( $thumbnail_id, array(170, 80) );
                            //echo
                            if (!empty($thumbnail_img)) {
                            echo $thumbnail_img;
                            }
                            else{
                                $placeholder_image = get_option( 'woocommerce_placeholder_image'  );
                                echo wp_get_attachment_image( $placeholder_image );
                            }
                            ?>
                            <div class="footer">
                                <a href="<?= get_term_link($category); ?>"><?= $category->name; ?></a>
                                <span class="price"><?= $category->count; ?> محصول</span>
                            </div>
                        </a>
                    </div>
                </div>
            <?php } ?>

        </div>
    </div>
</section>

<?php } ?>

