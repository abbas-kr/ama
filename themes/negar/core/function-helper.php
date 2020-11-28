<?php

function sw_zanbil_active() {
    if (class_exists('TCW')) {
        return true;
    }
    return false;
}

function sw_woocommerce_active() {
    if (defined( 'WCURL' )) {
        return true;
    }
    return false;
}

function ngr_svg($name) {
    get_template_part('assets/svg/'.$name.'.svg');
}

add_action( 'template_redirect', 'ngr_setcookie', 20 );

function ngr_setcookie (){

    if (!isset($_COOKIE['PWACookie']) && is_front_page() && class_exists( 'WooCommerce' )) {
        wc_setcookie('PWACookie', 'PWA', time() + (86400 * 10));
    }

}
