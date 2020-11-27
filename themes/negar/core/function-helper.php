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
