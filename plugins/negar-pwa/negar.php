<?php
/*
Plugin Name: نسخه موبایل نگار
Plugin URI: http://avin-tarh.ir/
Description: افزونه نسخه موبایل نگار باید فعال شود تا قالب نگار را فراخوانی کنید
Version: 5.2.0
Author: آوین
Author URI: http://avin-tarh.ir/
*/

if (!defined('WPINC')) die;
require_once ('init.php');
require_once('includes/negar-plugin-tools.php');
require_once('includes/redux-fix.php');
require_once('lib/plugin-update-checker-master/plugin-update-checker.php');
require_once('includes/smart-offer.php');

$ngrUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://avin-tarh.ir/autoupdate/negar/negar.json',
	__FILE__, //Full path to the main plugin file or functions.php.
	'negar-pwa'
);
