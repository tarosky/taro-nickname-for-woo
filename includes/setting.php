<?php
/**
 * Add setting field to WooCommerce
 *
 * @package tnnfw
 */

defined( 'ABSPATH' ) || die( 'Do not load directly.' );


/**
 * Get account settings
 *
 * @param array $settings
 * @return array
 */
add_filter( 'woocommerce_account_settings', function( $settings ) {
	$new_settings = [];
	foreach ( $settings as $setting ) {
		$new_settings[] = $setting;
		if ( 'woocommerce_registration_generate_password' === $setting['id'] ) {
			// Add display field?
			/* translators: %1$s first or last name, %2$s last or first name. */
			$place_holder = __( 'Auto Generate: %1$s %2$s', 'taro-nickname' );
			/**
			 * tnnfw_nickname_options
			 *
			 * Filter option list. You can customize.
			 *
			 * @param string $options
			 */
			$options = apply_filters( 'tnnfw_nickname_options', [
				'nickname'   => __( 'Add nickname input field for user.', 'taro-nickname' ),
				'first_last' => sprintf( $place_holder, __( 'First Name' ), __( 'Last Name' ) ),
				'last_first' => sprintf( $place_holder, __( 'Last Name' ), __( 'First Name' ) ),
				'first'      => sprintf( $place_holder, __( 'First Name' ), ' ' ),
				'last'       => sprintf( $place_holder, __( 'Last Name' ), ' ' ),
				'no'         => __( 'Keep WooCommerce default behavior', 'taro-nickname' ),
			] );
			$new_settings[] = [
				'id'       => 'taro_nickname_for_woo_setting',
				'title'    => __( 'Display Name', 'taro-nickname' ),
				'desc'     => __( 'By default, WooCommerce generate display name and keep it. You can change this behavior with this option.', 'taro-nickname' ),
				'type'     => 'select',
				'default'  => 'nickname',
				'autoload' => false,
				'options'  => $options,
				'desc_tip' => true,
			];
		}
	}
	return $new_settings;
} );
