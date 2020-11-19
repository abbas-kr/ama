<?php if (!defined('ABSPATH')) exit;
$avn_option = getSetting();
?>

<div class="ngr_slider text-banner-slider">
    <div class="swiper-wrapper">

        <?php
        if($avn_option['banner_title_activation']==1) {
            foreach ($avn_option['banner_slider'] as $slider) {
                echo '<div class="swiper-slide">' . $slider['title'] . '</div>';
            }
        }
        ?>
    </div>
</div>
<div class="ngr_slider image-banner-slider">
    <div class="swiper-wrapper">
        <?php
        foreach ($avn_option['banner_slider'] as $slider) {
            if (empty($slider['url'])) {
                $slider['url'] = 'javascript:void(0)';
            }
            echo '<div class="swiper-slide top-slider-image"><a href="' . $slider['url'] . '"><img src="' . $slider['image'] . '" /></a></div>';
        }
        ?>
    </div>
</div>


