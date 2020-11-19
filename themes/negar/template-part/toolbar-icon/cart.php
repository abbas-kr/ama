<li>
    <?php
    global $woocommerce;
    ?>
    <a class="cart-customlocation" href="<?php echo esc_url(wc_get_cart_url()); ?>"
       title="نمایش سبد خرید"><i
                class="fal fa-shopping-bag"></i><span><?php echo $woocommerce->cart->cart_contents_count; ?></span></a>
    <p>سبد خرید</p>
</li>
