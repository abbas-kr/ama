<?php if (!defined('ABSPATH')) exit;

$brands = get_terms(array(
    'taxonomy' => 'product_brand',
    'hide_empty' => false,
));


if (taxonomy_exists('product_brand') && !empty($brands)) { ?>
<section>
    <header class="ngr-eleman-title"><span>برندهای</span>محصولات</header>
    <div class="brand-swiper-container swiper-init" data-auto-height="true" data-free-mode="true"
         data-slides-per-view="auto">
        <div class="swiper-wrapper">

            <?php foreach ($brands as $brand) { ?>

                <div class="swiper-slide">
                    <div class="card">
                        <div class="card-content">
                            <a href="<?= get_term_link($brand); ?>">
                                <?php
                                $thumbnail_id = absint( get_term_meta( $brand->term_id, 'thumbnail_bid', true ) );
                                $thumb = wp_get_attachment_image( $thumbnail_id, array(350, 230) );
                                echo $thumb;
                                ?>
                            </a>
                            <div class="footer">
                                <a href="<?= get_term_link($brand); ?>"><h2 class="title"><?= $brand->name; ?></h2></a>
                                <div class="item-text product-price">
                                    <span class="price"><?= $brand->count; ?> محصول</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>

        </div>
    </div>
</section>

<?php } ?>
