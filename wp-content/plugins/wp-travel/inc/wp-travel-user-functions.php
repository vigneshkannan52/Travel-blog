<?php
/**
 * User Functions.
 *
 * @package WP_Travel
 */

if ( ! function_exists( 'wptravel_disable_admin_bar' ) ) {
	/**
	 * Prevent any user who cannot 'edit_posts' (subscribers, customers etc) from seeing the admin bar.
	 *
	 * Note: get_option( 'wp_travel_lock_down_admin', true ) is a deprecated option here for backwards compatibility. Defaults to true.
	 *
	 * @access public
	 * @param bool $show_admin_bar Show hide adminbar.
	 * @return bool
	 */
	function wptravel_disable_admin_bar( $show_admin_bar ) {
		$cant_edit = apply_filters( 'wp_travel_disable_admin_bar', ! current_user_can( 'edit_posts' ) ); // @phpcs:ignore
		$cant_edit = apply_filters( 'wptravel_disable_admin_bar', $cant_edit );
		if ( $cant_edit ) {
			$show_admin_bar = false;
		}
		return $show_admin_bar;
	}
	add_filter( 'show_admin_bar', 'wptravel_disable_admin_bar', 10, 1 );
}

if ( ! function_exists( 'wptravel_create_new_customer' ) ) {

	/**
	 * Create a new customer.
	 *
	 * @param  string $email Customer email.
	 * @param  string $username Customer username.
	 * @param  string $password Customer password.
	 * @return int|WP_Error Returns WP_Error on failure, Int (user ID) on success.
	 */
	function wptravel_create_new_customer( $email, $username = '', $password = '' ) {

		$settings = wptravel_get_settings();

		$generate_username_from_email = isset( $settings['generate_username_from_email'] ) ? $settings['generate_username_from_email'] : 'no';
		$generate_user_password       = isset( $settings['generate_user_password'] ) ? $settings['generate_user_password'] : 'no';

		// Check the email address.
		if ( empty( $email ) || ! is_email( $email ) ) {
			return new WP_Error( 'registration-error-invalid-email', __( 'Please provide a valid email address.', 'wp-travel' ) );
		}

		if ( email_exists( $email ) ) {
			$error_message = apply_filters( 'wp_travel_registration_error_email_exists', __( 'An account is already registered with your email address. Please log in.', 'wp-travel' ), $email ); // @phpcs:ignore
			$error_message = apply_filters( 'wptravel_registration_error_email_exists', $error_message, $email );
			return new WP_Error( 'registration-error-email-exists', $error_message ); // @phpcs:ignore
		}

		// Handle username creation.
		if ( 'no' === $generate_username_from_email || ! empty( $username ) ) {
			if ( empty( $username ) ) {
				$username = sanitize_user( current( explode( '@', $email ) ), true );
			}
			$username = sanitize_user( $username );

			if ( empty( $username ) || ! validate_username( $username ) ) {
				return new WP_Error( 'registration-error-invalid-username', __( 'Please enter a valid account username.', 'wp-travel' ) );
			}

			if ( username_exists( $username ) ) {
				return new WP_Error( 'registration-error-username-exists', __( 'An account is already registered with that username. Please choose another.', 'wp-travel' ) );
			}
		} else {
			$username = sanitize_user( current( explode( '@', $email ) ), true );

			// Ensure username is unique.
			$append     = 1;
			$o_username = $username;

			while ( username_exists( $username ) ) {
				$username = $o_username . $append;
				$append++;
			}
		}

		// Handle password creation.
		if ( 'yes' === $generate_user_password && empty( $password ) ) {
			$password           = wp_generate_password();
			$password_generated = true;
		} elseif ( empty( $password ) ) {
			$password           = wp_generate_password(); // Quick fix.
			$password_generated = true;

		} else {
			$password_generated = false;
		}

		// Use WP_Error to handle registration errors.
		$errors = new WP_Error();

		$errors = apply_filters( 'wp_travel_registration_errors', $errors, $username, $email ); // @phpcs:ignore
		$errors = apply_filters( 'wptravel_registration_errors', $errors, $username, $email );

		if ( $errors->get_error_code() ) {
			return $errors;
		}

		$new_customer_data = apply_filters(
			'wp_travel_new_customer_data',  // @phpcs:ignore
			array(
				'user_login' => $username,
				'user_pass'  => $password,
				'user_email' => $email,
				'role'       => 'wp-travel-customer',
			)
		);
		$new_customer_data = apply_filters(
			'wptravel_new_customer_data',
			$new_customer_data
		);

		$customer_id = wp_insert_user( $new_customer_data );

		if ( is_wp_error( $customer_id ) ) {
			return new WP_Error( 'registration-error', '<strong>' . __( 'Error:', 'wp-travel' ) . '</strong> ' . __( 'Couldn&#8217;t register you&hellip; please contact us if you continue to have problems.', 'wp-travel' ) );
		}

		wptravel_do_deprecated_action( 'wp_travel_created_customer', array( $customer_id, $new_customer_data, $password_generated ), '4.4.7', 'wptravel_created_customer' ); // @phpcs:ignore
		do_action( 'wptravel_created_customer', $customer_id, $new_customer_data, $password_generated );

		return $customer_id;
	}
}

/**
 * Login a member (set auth cookie and set global user object).
 *
 * @param int $customer_id Current user id.
 */
function wptravel_set_customer_auth_cookie( $customer_id ) {
	global $current_user;
	if ( get_user_by( 'id', $customer_id ) ) {
		wp_set_auth_cookie( $customer_id, true );
	}
}

/**
 * Get endpoint URL.
 *
 * Gets the URL for an endpoint, which varies depending on permalink settings.
 *
 * @param  string $endpoint  Endpoint slug.
 * @param  string $value     Query param value.
 * @param  string $permalink Permalink.
 *
 * @return string
 */
function wptravel_get_endpoint_url( $endpoint, $value = '', $permalink = '' ) {
	if ( ! $permalink ) {
		$permalink = get_permalink();
	}

	// Map endpoint to options.
	$query_class = new WP_Travel_Query();
	$query_vars  = $query_class->get_query_vars();
	$endpoint    = ! empty( $query_vars[ $endpoint ] ) ? $query_vars[ $endpoint ] : $endpoint;

	if ( get_option( 'permalink_structure' ) ) {
		if ( strstr( $permalink, '?' ) ) {
			$query_string = '?' . wp_parse_url( $permalink, PHP_URL_QUERY );
			$permalink    = current( explode( '?', $permalink ) );
		} else {
			$query_string = '';
		}
		$url = trailingslashit( $permalink ) . trailingslashit( $endpoint );

		if ( $value ) {
			$url .= trailingslashit( $value );
		}

		$url .= $query_string;
	} else {
		$url = add_query_arg( $endpoint, $value, $permalink );
	}

	$url = apply_filters( 'wp_travel_get_endpoint_url', $url, $endpoint, $value, $permalink ); // @phpcs:ignore
	$url = apply_filters( 'wptravel_get_endpoint_url', $url, $endpoint, $value, $permalink );
	return $url;
}

/**
 * Returns the url to the lost password endpoint url.
 *
 * @return string
 */
function wptravel_lostpassword_url() {
	$default_url = wp_lostpassword_url();
	// Avoid loading too early.
	if ( ! did_action( 'init' ) ) {
		$url = $default_url;
	} else {
		// Don't redirect to the WP Travel endpoint on global network admin lost passwords.
		/**
		 * Already checking nonce using WP_Travel::verify_nonce.
		 */
		if ( is_multisite() && isset( $_GET['redirect_to'] ) && false !== strpos( wp_unslash( $_GET['redirect_to'] ), network_admin_url() ) ) { // @phpcs:ignore
			$url = $default_url;
		} else {
			$wp_travel_account_page_url    = wptravel_get_page_permalink( 'wp-travel-dashboard' );
			$wp_travel_account_page_exists = wptravel_get_page_id( 'wp-travel-dashboard' ) > 0;

			if ( $wp_travel_account_page_exists ) {
				$url = $wp_travel_account_page_url . '?action=lost-pass&_nonce=' . WP_Travel::create_nonce();
			} else {
				$url = $default_url;
			}
		}
	}
	$url = apply_filters( 'wp_travel_lostpassword_url', $url, $default_url ); // @phpcs:ignore
	$url = apply_filters( 'wptravel_lostpassword_url', $url, $default_url );
	return $url;
}
