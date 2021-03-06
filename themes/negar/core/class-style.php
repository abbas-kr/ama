<?php if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'AVN_Negar_Theme_Style' ) ) {

	class AVN_Negar_Theme_Style {

		public function __construct() {
			add_action( 'wp_enqueue_scripts', array( $this, 'add_assets' ) , 999 );
			add_action( 'wp_enqueue_scripts', array( $this, 'inline_color_code_css' ) );
		}

		/**
		 * Enqueue CSS & JS files
		 */
		public function add_assets() {

			wp_enqueue_style( 'avn-style', get_template_directory_uri() . '/assets/css/main.css', '', time(), 'screen' );
			wp_add_inline_style( 'avn-style', $this->inline_color_code_css() );
			wp_add_inline_style( 'avn-style', $this->inline_custom_css() );
			wp_add_inline_script( 'avn-style', $this->inline_custom_js() );
			wp_enqueue_style( 'avn-vendor', get_template_directory_uri() . '/assets/css/vendor.css', '', '', 'screen' );
			wp_enqueue_script( 'avn-bootstrap-script', get_template_directory_uri() . '/assets/js/bootstrap.min.js', '', false, true );
			wp_enqueue_style( 'swiper-slider-css', get_template_directory_uri() . '/assets/swiper/css/swiper-bundle.min.css', '', '', 'screen' );
			wp_enqueue_script( 'swiper-slider-js', get_template_directory_uri() . '/assets/swiper/js/swiper-bundle.min.js', array( 'jquery' ), false, true );
			wp_enqueue_script( 'avn-custom-js', get_template_directory_uri() . '/assets/js/custom.js', array( 'jquery' ), time(), true );

			wp_localize_script( 'avn-custom-js', 'avn_negar', array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
			) );

			wp_dequeue_script( 'swiper' );
			wp_dequeue_style( 'swiper' );
            wp_dequeue_style( 'wc-block-style' );

            if (!sw_woocommerce_active() || is_single()){
                wp_enqueue_script( 'avn-countdown-js', get_template_directory_uri() . '/assets/js/jquery.countdown.min.js', array( 'jquery' ), time(), true );
            }

        }

        public function inline_custom_css()
        {
            global $avn_negar;
            if ( ! empty( $avn_negar['custom_css'] ) ) {
                return $avn_negar['custom_css'];
            }
		}

        public function inline_custom_js()
        {
            global $avn_negar;
            if ( ! empty( $avn_negar['custom_js'] ) ) {
                return $avn_negar['custom_js'];
            }
        }

		public function inline_color_code_css() {
			global $avn_negar;
			ob_start();
			?>
            :root {

            <?php if ( ! empty( $avn_negar['light_bg'] ) ){ ?>
                --light-bg: <?= $avn_negar['light_bg'] ?>;
            <?php } ?>

            <?php if ( ! empty( $avn_negar['light_element_bg'] ) ){ ?>
                --light-element-bg: <?= $avn_negar['light_element_bg'] ?>;
            <?php } ?>

            <?php if ( ! empty( $avn_negar['text_light'] ) ){ ?>
                --text-light: <?= $avn_negar['text_light'] ?>;
            <?php } ?>

            <?php if ( ! empty( $avn_negar['night_bg'] ) ){ ?>
                --night-bg: <?= $avn_negar['night_bg'] ?>;
            <?php } ?>

            <?php if ( ! empty( $avn_negar['night_element_bg'] ) ){ ?>
                --night-element-bg: <?= $avn_negar['night_element_bg'] ?>;
            <?php } ?>

            <?php if ( ! empty( $avn_negar['text_night'] ) ){ ?>
                --text-night: <?= $avn_negar['text_night'] ?>;
            <?php } ?>

            <?php if ( ! empty( $avn_negar['primary_color'] ) ){ ?>
                --primary: <?= $avn_negar['primary_color'] ?>;
            <?php } ?>

            <?php if ( ! empty( $avn_negar['secondry_color'] ) ){ ?>
                --secondry: <?= $avn_negar['secondry_color'] ?>;
            <?php } ?>

            }

            <?php if (  $avn_negar['transparent_activation'] == '1' ){ ?>
                header#headerArea,.footer-nav-area .buttonbar-first,.footer-nav-area .buttonbar-second {
                backdrop-filter: blur(10px);
                background-color: #ffffff0f!important;
                }
            <?php } ?>
            <?php if ( is_single() && $avn_negar['transparent_activation'] == '1' ){ ?>
                .woocommerce-variation-add-to-cart, .summary.entry-summary .woocommerce-variation-add-to-cart, .product-type-simple form.cart {
                backdrop-filter: blur(10px);
                background-color: #ffffff0f!important;
                }
            <?php } ?>

            <?php
			$buffer = ob_get_clean();
			$minifiedCSS = str_replace( array( "\r\n", "\r", "\n", "\t", '  ', '    ', '    ' ), '', $buffer );

			return $minifiedCSS;
		}

	}

}
new AVN_Negar_Theme_Style();
