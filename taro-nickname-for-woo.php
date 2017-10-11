<?php
/*
Plugin Name: Taro Nickname for Woo
Plugin URI: https://wordpress.org/plugin/taro-nickname-for-woo
Description: Add nickname field for WooCommerce.
Author: TAROSKY INC.
Author URI: https://tarosky.co.jp
Text Domain: taro-nickname
Domain Path: /languages/
License: GPL v3 or later.
Version: 1.0.0
WC requires at least: 3.0.0
WC tested up to: 3.1.2
PHP Version: 5.4.0
*/

defined( 'ABSPATH' ) || die( 'Do not load directly.' );

add_action( 'plugins_loaded', 'tnnfw_init' );

/**
 * Bootstrap
 *
 * @package tnnfw
 * @since 1.0.0
 * @access private
 */
function tnnfw_init() {
	load_plugin_textdomain( 'taro-nickname', false, basename( dirname( __FILE__ ) ) . '/languages' );
	if ( version_compare( phpversion(), '5.4.0', '<' ) ) {
		add_action( 'admin_notices', 'tnnfw_version_error' );
	} elseif ( ! function_exists( 'WC' ) || version_compare( WC()->version, '3.0.0', '<' ) ) {
		add_action( 'admin_notices', 'tnnfw_woocommerce_error' );
	} else {
		// Requirements filled.
		foreach ( scandir( dirname( __FILE__ ) . '/includes' ) as $file ) {
			if ( preg_match( '#^[^._].*\.php$#u', $file ) ) {
				require dirname( __FILE__ ) . '/includes/' . $file;
			}
		}
	}
}

/**
 * Display PHP error version.
 *
 * @since 1.0.0
 * @package tnnfw
 */
function tnnfw_version_error() {
	printf( '<p class="error">%s</p>', esc_html( sprintf(
		/* translators: %s PHP version */
		__( 'Taro Nickname for Woo requires PHP 5.4 and over, but your version is %s.', 'taro-nickname' ),
		phpversion()
	) ) );
}


/**
 * Display WooCommerce compatibility.
 *
 * @since 1.0.0
 * @package tnnfw
 */
function tnnfw_woocommerce_error() {
	printf( '<p class="error">%s</p>', esc_html__( 'Taro Nickname for Woo requires WooCommerce 3.0 and over.', 'taro-nickname' ) );
}
