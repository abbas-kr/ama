<?php if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('AVN_Negar_Theme')) {

    class AVN_Negar_Theme
    {

        public function __construct()
        {

            add_action('wp_head', array($this, 'head_contents'));
            add_action('after_setup_theme', array($this, 'initialize'));
            add_action('ngr_footer_setting_widget', array($this, 'render_footer_widget_setting'));

            add_action('wp_head', array($this, 'ngr_pwa_load_manifest'), 99);
            add_action('wp_footer', array($this, 'ngr_pwa_moda_render'));

            add_action('wp_head', array($this, 'ngr_analytics_code'), 100);

        }


        public function head_contents()
        {


            if (!class_exists('AVN_Negar_plugin')) {
                wp_die('پلاگین نسخه موبایل نگار غیر فعال است. وارد پیشخوان وردپرس و منوی افزونه ها شوید و پلاگین نسخه موبایل نگار را فعال کنید.');
            }


            $setting = getSetting();
            ob_start();
            $favicon = get_option('favicon-information');

            ?>
            <meta name="theme-color" content="<?= $setting['addressbar_color']; ?>">
            <meta name="msapplication-navbutton-color" content="<?= $setting['addressbar_color']; ?>">
            <meta name="apple-mobile-web-app-capable" content="yes">
            <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

            <?php if ($favicon) {

            ?>
            <link rel="apple-touch-icon" sizes="57x57" href="<?= $favicon['57']; ?>">
            <link rel="apple-touch-icon" sizes="60x60" href="<?= $favicon['60']; ?>">
            <link rel="apple-touch-icon" sizes="72x72" href="<?= $favicon['72']; ?>">
            <link rel="apple-touch-icon" sizes="76x76" href="<?= $favicon['76']; ?>">
            <link rel="apple-touch-icon" sizes="120x120" href="<?= $favicon['120']; ?>">
            <link rel="apple-touch-icon" sizes="144x144" href="<?= $favicon['144']; ?>">
            <link rel="apple-touch-icon" sizes="152x152" href="<?= $favicon['152']; ?>">
            <link rel="apple-touch-icon" sizes="180x180" href="<?= $favicon['180']; ?>">
            <link rel="icon" type="image/png" sizes="192x192" href="<?= $favicon['192']; ?>">
            <link rel="icon" type="image/png" sizes="32x32" href="<?= $favicon['32']; ?>">
            <link rel="icon" type="image/png" sizes="96x96" href="<?= $favicon['96']; ?>">
            <link rel="icon" type="image/png" sizes="16x16" href="<?= $favicon['16']; ?>">
        <?php } ?>

            <?php
            $buffer = ob_get_clean();
            echo $buffer;

        }

        public function ngr_pwa_load_manifest()
        {
            global $avn_negar;
            if (is_front_page() && $avn_negar['pwa_activation'] == 1) {
                ?>

                <link rel="manifest" href="manifest.webmanifest">
                <script src="index.js" defer></script>

                <?php
            }
        }

        public function ngr_pwa_moda_render()
        {

            global $avn_negar;


            if (is_front_page() && $avn_negar['pwa_activation'] == 1) {
                $set_cookie = 1;

                if (isset($_COOKIE['PWACookie'])) {
                    $set_cookie = 0;
                }

                ?>
                <div class="add-shortcut-btn hidden" data-cookie="<?= $set_cookie ?>">
                    <?php
                    if (!empty($avn_negar['favicon']['url'])) {
                        ?>
                        <div class="pwa-icon"><img src="<?= $avn_negar['favicon']['url'] ?>"></a></div>
                    <?php } ?>
                    <div class="andriod">
                        <p class="pwa-title">برای دسترسی سریع تر به فروشگاه میتوانید از وب اپلیکیشن سایت استفاده
                            کنید.برای افزوده شدن وب اپلیکیشن کافیست دکمه زیر را لمس کنید.</p>
                        <button class="add-mobile-view">نصب وب اپلیکیشن</button>
                        <button class="cancel-mobile-view">متوجه شدم! فعلا نه !</button>
                    </div>
                    <div class="ios">
                        <p class="pwa-title">برای دسترسی سریع تر به فروشگاه میتوانید از وب اپلیکیشن سایت استفاده
                            کنید.کافیست مطابق آموزش زیر عمل کنید :</p>
                        <p>در نوار پایین گوشی روی <i class="fal fa-sign-out"></i> لمس کنید.</p>
                        <p>منو را بالا بکشید و روی گزینه <i class="fal fa-plus-square"></i> لمس کنید.</p>
                        <p>در آخر در بالای صفحه گزینه Add را انتخاب کنید.</p>
                        <button class="cancel-mobile-view">متوجه شدم! فعلا نه !</button>
                    </div>
                </div>
                <?php
            }

        }

        /**
         * Sets up theme defaults and registers support for various features
         *
         * Note: the first-loaded translation file overrides any following ones if the same translation is present.
         */
        public function initialize()
        {

            global $avn_option;
            // Hide admin bar
            add_filter('show_admin_bar', '__return_false');
            add_theme_support('title-tag');

            // Clean up the head
            if ($avn_option['clean_head']) {
                remove_action('wp_head', 'rsd_link');
                remove_action('wp_head', 'wp_generator');

                remove_action('wp_head', 'feed_links', 2);
                remove_action('wp_head', 'feed_links_extra', 3);
                remove_action('wp_head', 'wp_resource_hints', 2);

                remove_action('wp_head', 'index_rel_link');
                remove_action('wp_head', 'wlwmanifest_link');
                remove_action('wp_head', 'start_post_rel_link', 10, 0);
                remove_action('wp_head', 'parent_post_rel_link', 10, 0);
                remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
                remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

                remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
                remove_action('wp_head', 'rel_canonical');
                remove_action('wp_head', 'rest_output_link_wp_head', 10);

                remove_action('wp_head', 'print_emoji_detection_script', 7);
                remove_action('admin_print_scripts', 'print_emoji_detection_script');
                remove_action('wp_print_styles', 'print_emoji_styles');
                remove_action('admin_print_styles', 'print_emoji_styles');

                remove_action('rest_api_init', 'wp_oembed_register_route');
                remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
                remove_action('wp_head', 'wp_oembed_add_discovery_links');
                remove_action('wp_head', 'wp_oembed_add_host_js');
            }
        }


        public function ngr_analytics_code()
        {
            global $avn_negar;
            if (!empty($avn_negar['header_html'])) {
                echo $avn_negar['header_html'];
            }
        }

        //setting footer widget
        public function render_footer_widget_setting()
        {
            global $avn_negar;
            if (!empty($avn_negar['first_footer_menu'])) {
                echo '<div class="first-menu"><h4>' . wp_get_nav_menu_object($avn_negar['first_footer_menu'])->name . '</h4>';
                wp_nav_menu(array('menu' => $avn_negar['first_footer_menu'], 'container_id' => 'accordian'));
                echo '</div>';
            }

            if (!empty($avn_negar['second_footer_menu'])) {
                echo '<div class="second-menu"><h4>' . wp_get_nav_menu_object($avn_negar['second_footer_menu'])->name . '</h4>';
                wp_nav_menu(array('menu' => $avn_negar['second_footer_menu'], 'container_id' => 'accordian'));
                echo '</div>';
            }

            echo '<div class="footer-image-widget">';
            if (!empty($avn_negar['title_image_widget'])) {
                echo '<h4>' . $avn_negar['title_image_widget'] . '</h4>';
            }
            foreach ($avn_negar['image_widget'] as $image) {
                echo '<a href="' . $image['url'] . '"><img src="' . $image['image'] . '"></a>';
            }
            echo '</div>';

            if (!empty($avn_negar['enamad_logo']) || !empty($avn_negar['samandehi_logo']) || !empty($avn_negar['melat_bank_logo'])) { ?>
                <div class="validationlogos">
                    <h4>مجوزها</h4>
                    <div class="validation-logos-slider swiper-container" data-slidePerView="1" data-loop="true" data-pagination="1">
                        <div class="swiper-wrapper">
                            <?php if (!empty($avn_negar['enamad_logo'])) { ?>
                                <div class="footer-images swiper-slide">
                                    <?php echo $avn_negar['enamad_logo']; ?>
                                </div>
                            <?php }

                            if (!empty($avn_negar['samandehi_logo'])) { ?>
                                <div class="footer-images swiper-slide">
                                    <?php echo $avn_negar['samandehi_logo']; ?>
                                </div>
                            <?php }

                            if (!empty($avn_negar['melat_bank_logo'])) { ?>
                                <div class="footer-images swiper-slide">
                                    <?php echo $avn_negar['melat_bank_logo']; ?>
                                </div>
                            <?php } ?>
                        </div>
                        <!-- Add Pagination -->
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            <?php } ?>

            <div class="social-link-button">
                <?php
                $socialnames = array('telegram', 'instagram', 'whatsapp', 'twitter', 'aparat');
                foreach ($socialnames as $socialname) {
                    if (!empty($avn_negar[$socialname . '_link'])) {
                        echo '<a target="_blank" href="' . $avn_negar[$socialname . '_link'] . '"><img src="' . NGR_URL . '/assets/svg/' . $socialname . '.svg"></a>';
                    }
                }
                ?>
            </div>

            <?php
            if ($avn_negar['show_contact_infooter'] == '1') {
                if (!empty($avn_negar['menu_contact'])) {
                    echo '<div class="footer-phone-info"><h4>اطلاعات تماس</h4><div class="phones">';
                    foreach ($avn_negar['menu_contact'] as $number) {
                        $formated_number = explode("-", $number);
                        echo '<div class="box-phone"><a href="tel:' . $formated_number[0] . $formated_number[1] . '"><i class="fal fa-phone"></i><span class="phone_code">' . $formated_number[0] . '</span>' . $formated_number[1] . '</a></div>';
                    }
                    echo '</div></div>';
                }
            }
            ?>

            <?php
            if (!empty($avn_negar['about_us_footer'])) {
                echo '<div class="about-us-footer"><span>' . $avn_negar['about_us_footer'] . '</span></div>';
            }
            ?>

            <?php
            if (!empty($avn_negar['google_location_add']) || !empty($avn_negar['wase_location_add'])) {
                echo '<div class="footer-location-image">';
                if (!empty($avn_negar['google_location_add'])) {
                    echo '<a href="' . $avn_negar['google_location_add'] . '" class="box-map"><i class="fal fa-map-pin"></i><span>گوگل مپ</span></a>';
                }
                if (!empty($avn_negar['wase_location_add'])) {
                    echo '<a href="' . $avn_negar['wase_location_add'] . '" class="box-map"><i class="fal fa-map-marker-smile"></i><span>آدرس ویز</span></a>';
                }
                echo '</div>';
            }
            ?>

            <?php
            dynamic_sidebar('ngr_footer_widget');
            ?>

            <?php
            if (!empty($avn_negar['copy_right_box'])) {
                echo '<span class="copy-right-footer">' . $avn_negar['copy_right_box'] . '</span>';
            }
            ?>


            <?php

        }

    }

}
new AVN_Negar_Theme();
