<?php

class AVN_Negar_plugin {
	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'wp_ajax_avn_favicon_generator', array( $this, 'avn_ajax_favicon_process' ) );

		add_filter( 'template', array( $this, 'ngr_swich_theme' ) );
		add_filter( 'option_template', array( $this, 'ngr_swich_theme' ) );
		add_filter( 'option_stylesheet', array( $this, 'ngr_swich_theme' ) );
	}


	/**
	 * Load necessary files
	 */
	public function ngr_swich_theme( $theme ) {
		if ( ! is_admin() ) {
			// Load for mobile
			if ( wp_is_mobile() ) {

				$theme = 'negar';

			}
		}

		return $theme;
	}

	/**
	 * Enqueue CSS and JS
	 */
	public function enqueue_scripts() {
		if ( isset( $_GET['page'] ) ) {
			if ( $_GET['page'] == 'avn_negar_options' ) {

				wp_enqueue_media();

				wp_enqueue_style( 'negar-style', AVN_URL . '/assets/css/style.css' );
				wp_enqueue_script( 'negar-script', AVN_URL . '/assets/js/app.js', array( 'jquery' ) );

				wp_localize_script( 'negar-script', 'avn', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
			}
		}
	}

	/**
	 * Use WordPress Image editor to manipulate an image
	 */
	public function avn_ajax_favicon_process() {
		// resize the image
		$sizes_array = array(
			array( 'width' => 16, 'height' => 16, 'crop' => false ),
			array( 'width' => 32, 'height' => 32, 'crop' => false ),
			array( 'width' => 57, 'height' => 57, 'crop' => false ),
			array( 'width' => 60, 'height' => 60, 'crop' => false ),
			array( 'width' => 72, 'height' => 72, 'crop' => false ),
			array( 'width' => 76, 'height' => 76, 'crop' => false ),
			array( 'width' => 96, 'height' => 96, 'crop' => false ),
			array( 'width' => 114, 'height' => 114, 'crop' => false ),
			array( 'width' => 120, 'height' => 120, 'crop' => false ),
			array( 'width' => 144, 'height' => 144, 'crop' => false ),
			array( 'width' => 152, 'height' => 152, 'crop' => false ),
			array( 'width' => 180, 'height' => 180, 'crop' => false ),
			array( 'width' => 192, 'height' => 192, 'crop' => false )
		);

		$upload_dir = wp_upload_dir();
		$img_url    = str_replace( '-150x150', '', $_POST['url'] );
		$img_exp    = explode( 'uploads', $img_url );
		$img_dir    = $upload_dir['basedir'] . end( $img_exp );
		$image      = wp_get_image_editor( $img_dir );
		$resize     = $image->multi_resize( $sizes_array );

		if ( is_array( $resize ) ) {
			foreach ( $resize as $name ) {
				$out[ $name['width'] ] = $upload_dir['url'] . '/' . $name['file'];
			}
		}

		update_option( 'favicon-information', $out );
		$this->ngr_creat_manifest();
		$this->ngr_create_index_js();
		$this->ngr_create_sw_js();
		wp_die();
	}

	private function ngr_creat_manifest() {
		$favicon = get_option( 'favicon-information' );

		ob_start(); ?>

        {
        "background_color": "#ffffff",
        "description": "<?= get_bloginfo( 'description' ) ?>",
        "display": "fullscreen",
        "icons": [
        {
        "src": "<?= $favicon['192']; ?>",
        "sizes": "192x192",
        "type": "image/png"
        }
        ],
        "name": "<?= get_bloginfo( 'name' ) ?>",
        "short_name": "<?= get_bloginfo( 'name' ) ?>",
        "start_url": "/"
        }

		<?php $buffer = ob_get_clean();

		//header('Content-Type: application/json');
		$address = fopen( get_home_path() . 'manifest.webmanifest', 'w+' );
		fwrite( $address, $buffer );
		fclose( $address );
	}

	private function ngr_create_index_js() {
		ob_start(); ?>
        // Register service worker to control making site work offline

        if('serviceWorker' in navigator) {
        navigator.serviceWorker
        .register('/sw.js')
        .then(function() { console.log('Service Worker Registered'); });
        }
        // Code to handle install prompt on desktop

        let deferredPrompt;
        const addBtn = document.querySelector('.add-mobile-view');
        const addBox = document.querySelector('.add-shortcut-btn');

        window.addEventListener('beforeinstallprompt', (e) => {
        // Prevent Chrome 67 and earlier from automatically showing the prompt
        e.preventDefault();
        // Stash the event so it can be triggered later.
        deferredPrompt = e;

        addBtn.addEventListener('click', (e) => {
        // hide our user interface that shows our A2HS button
        addBtn.style.display = 'none';
        addBox.style.display = 'none';
        // Show the prompt
        deferredPrompt.prompt();
        // Wait for the user to respond to the prompt
        deferredPrompt.userChoice.then((choiceResult) => {
        if (choiceResult.outcome === 'accepted') {
        console.log('User accepted the A2HS prompt');
        } else {
        console.log('User dismissed the A2HS prompt');
        }
        deferredPrompt = null;
        });
        });
        });

		<?php
		$buffer = ob_get_clean();

		$address = fopen( get_home_path() . 'index.js', 'w+' );
		fwrite( $address, $buffer );
		fclose( $address );
	}

	private function ngr_create_sw_js() {
		ob_start(); ?>
        self.addEventListener('install', function(e) {
        e.waitUntil(
        caches.open('fox-store').then(function(cache) {
        return cache.addAll([
        '/',
        '/index.php',
        '/index.js'
        ]);
        })
        );
        });

        self.addEventListener('fetch', function(e) {
        console.log(e.request.url);
        e.respondWith(
        caches.match(e.request).then(function(response) {
        return response || fetch(e.request);
        })
        );
        });
		<?php
		$buffer = ob_get_clean();

		$address = fopen( get_home_path() . 'sw.js', 'w+' );
		fwrite( $address, $buffer );
		fclose( $address );
	}

}

new AVN_Negar_plugin();
