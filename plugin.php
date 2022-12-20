<?php
/**
 * Plugin Name:       @ TON Gateway
 * Description:       Toncoin payments via The Open Network blockchain for WordPress & WooCommerce
 * Plugin URI:        https://github.com/uptimizt/ton-gateway
 * Author:            uptimizt
 * Author URI:        https://github.com/uptimizt
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ton-gateway
 * Domain Path:       /languages
 * Version:           0.2
 */

namespace TonGateway;

// If this file is called directly, abort.
defined('ABSPATH') || die;

$files = glob(__DIR__ . '/includes/*.php');
foreach ($files as $file) {
	require_once $file;
}

add_action('plugins_loaded', function () {
	load_plugin_textdomain( 'ton-gateway', false, __DIR__ . '/languages/' );
});