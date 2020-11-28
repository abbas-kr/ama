<?php

if(isset($_GET['page']) && $_GET['page'] == 'avn_negar_options') {

	function wpdev_170663_remove_parent_theme_stuff() {

		remove_action( 'admin_enqueue_scripts', 'mweb_register_backend_script' );
	}
}

