<?php if (!defined('ABSPATH')) exit; /* negar */ ?>

<?php
$avn_option = getSetting();
?>
<section>
    <div class="svg-slider swiper-container" data-slidePerView="2.7">
        <div class="swiper-wrapper">
            <?php
            foreach ($avn_option['svg_slider'] as $slider) {
                echo '<div class="swiper-slide svg-box-button"><a href="' . $slider['url'] . '">' . $slider['description'] . '</a><p>' . $slider['title'] . '</p></div>';
            }
            ?>
        </div>
    </div>
</section>
