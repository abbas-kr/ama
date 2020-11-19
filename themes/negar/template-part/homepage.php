<?php if (!defined('ABSPATH')) exit; ?>
<?php
$avn_option = getSetting();

if ($avn_option['popup_activation']==1){
    if (!empty($avn_option['popup_box'])){
        echo '<div id="category-modal" class="show"><div class="popup-data"><a id="popup-closer" href="javascript:void(0)" class="active"><i class="fal fa-times"></i></a>';
        echo $avn_option['popup_box'];
        echo '</div></div>';
    }
}

foreach ($avn_option['home_content']['enable'] as $key => $value) {
    if (strpos($key, 'hscrol_') !== false && file_exists(NGR_PATH . '/elemans/hscroll.php')) {

        $getId = explode('hscrol_', $key);
        $theId = end($getId);
        require NGR_PATH . '/elemans/hscroll.php';

    }

    elseif (file_exists(NGR_PATH . '/elemans/' . $key . '.php')) {
        require_once NGR_PATH . '/elemans/' . $key . '.php';

    }

    elseif (strpos($key, 'banner_') !== false && file_exists(NGR_PATH . '/elemans/full-banner.php')) {
        $getId = explode('banner_', $key);
        $theId = end($getId);
        require NGR_PATH . '/elemans/full-banner.php';
    }

    elseif (strpos($key, 'halfb_') !== false && file_exists(NGR_PATH . '/elemans/half-banner.php')) {
        $getId = explode('halfb_', $key);
        $theId = end($getId);
        require NGR_PATH . '/elemans/half-banner.php';
    }

    elseif (strpos($key, 'banner-slider') !== false && file_exists(NGR_PATH . '/elemans/banner-slider.php')) {
        require NGR_PATH . '/elemans/banner-slider.php';
    }

}

