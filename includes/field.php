<?php
/**
 * Show nickname field and save it.
 *
 * @package tnnfw
 */

defined( 'ABSPATH' ) || die( 'Do not load directly.' );

/**
 * Add nickname field if allowed.
 */
add_action( 'woocommerce_edit_account_form_start', function () {
	if ( 'nickname' === get_option( 'taro_nickname_for_woo_setting', 'nickname' ) ) {
		$user = wp_get_current_user();
		?>
		<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
			<label for="account_nickname"><?php esc_html_e( 'Nick Name', 'taro-nickname' ); ?> <span
						class="required">*</span></label>
			<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_nickname"
				   id="account_nickname" value="<?php echo esc_attr( $user->display_name ); ?>"/>
		</p>
		<?php
	}
}, 99999 );

/**
 * Save nickname as display field.
 */
add_action( 'woocommerce_save_account_details_errors', function ( WP_Error &$errors, stdClass &$user ) {
	switch ( get_option( 'taro_nickname_for_woo_setting', 'nickname' ) ) {
		case 'nickname':
			// Use nick name field.
			if ( ! isset( $_POST['account_nickname'] ) || empty( $_POST['account_nickname'] ) ) {
				$errors->add( 'nicknam_required', __( 'Nick name is required.', 'taro-nickname' ) );
				return;
			}
			$user->display_name = wc_clean( $_POST['account_nickname'] );
			break;
		case 'first':
			$user->display_name = $user->first_name;
			break;
		case 'last':
			$user->display_name = $user->last_name;
			break;
		case 'first_last':
			// Auto generate.
			$user->display_name = implode( ' ', [ $user->first_name, $user->last_name ] );
			break;
		case 'last_first':
			// Auto generate in Japanese way.
			$user->display_name = implode( ' ', [ $user->last_name, $user->first_name ] );
			break;
		default:
			/**
			 * tnnfw_generate_nickname
			 *
			 * Do action for extra options.
			 *
			 * @param stdClass $user
			 * @param WP_Error $errors
			 */
			do_action( 'tnnfw_generate_nickname', $user, $errors );
			break;
	}
}, 10, 2 );
