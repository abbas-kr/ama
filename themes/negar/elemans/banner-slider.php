<?php if (!defined('ABSPATH')) exit;
$avn_option = getSetting();
?>
<section>
    <?php if ($avn_option['slider_slection_mode']=='navigation_mode'){ ?>
    <div class="ngr_slider text-banner-slider">
        <div class="swiper-wrapper">
            <?php
            if (!empty($avn_option['banner_slider'])) {
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
            if (!empty($avn_option['banner_slider'])) {
                foreach ($avn_option['banner_slider'] as $slider) {
                    if (empty($slider['url'])) {
                        $slider['url'] = 'javascript:void(0)';
                    }
                    echo '<div class="swiper-slide top-slider-image"><a href="' . $slider['url'] . '"><img src="' . $slider['image'] . '" /></a></div>';
                }
            }
            ?>
        </div>
    </div>
    <?php } elseif ($avn_option['slider_slection_mode']=='wavy_mode') { ?>
        <div class="ngr_slider image-banner-slider-wavy">
            <div class="swiper-wrapper">
                <?php
                if (!empty($avn_option['banner_slider'])) {
                    foreach ($avn_option['banner_slider'] as $slider) {
                        if (empty($slider['url'])) {
                            $slider['url'] = 'javascript:void(0)';
                        }
                        echo '<div class="swiper-slide top-slider-image"><a href="' . $slider['url'] . '"><img src="' . $slider['image'] . '" /></a><div class="negar-svg">';
                        ngr_svg('wavy1');
                        ngr_svg('wavy2');
                        echo '<div class="negar-slider-meta">';
                        echo '<span class="svg-right-part">' . $slider['title'] . '</span>';
                        echo '<span class="svg-left-part">اطلاعات بیشتر</span>';
                        echo '</div></div></div>';
                    }
                }
                ?>
            </div>
        </div>
    <?php } else{ ?>
        <div class="ngr_slider image-banner-slider-simple">
            <div class="swiper-wrapper">
                <?php
                if (!empty($avn_option['banner_slider'])) {
                    foreach ($avn_option['banner_slider'] as $slider) {
                        if (empty($slider['url'])) {
                            $slider['url'] = 'javascript:void(0)';
                        }
                        echo '<div class="swiper-slide top-slider-image"><a href="' . $slider['url'] . '"><img src="' . $slider['image'] . '" /></a></div>';
                    }
                }
                ?>
            </div>
        </div>
    <?php } ?>
</section>


