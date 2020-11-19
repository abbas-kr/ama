<li <?php echo ( is_product_category() || is_shop() ) ? 'class="active"' : ''; ?>><a href="<?= get_permalink(wc_get_page_id('shop')); ?>" class="tab-link">
        <i class="fal fa-store-alt"></i>
        <p>فروشگاه</p>
    </a>
</li>
