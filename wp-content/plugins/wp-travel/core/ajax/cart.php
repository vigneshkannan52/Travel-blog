<?php
/**
 * Ajax Request for cart.
 *
 * @package WP_Travel
 */

/**
 * Ajax request main class.
 */
class WP_Travel_Ajax_Cart {

	/**
	 * Init ajax requests.
	 */
	public static function init() {
		// Get Cart items.
		add_action( 'wp_ajax_wp_travel_get_cart', array( __CLASS__, 'get_cart' ) );
		add_action( 'wp_ajax_nopriv_wp_travel_get_cart', array( __CLASS__, 'get_cart' ) );

		// Add to cart.
		add_action( 'wp_ajax_wp_travel_add_to_cart', array( __CLASS__, 'add_to_cart' ) );
		add_action( 'wp_ajax_nopriv_wp_travel_add_to_cart', array( __CLASS__, 'add_to_cart' ) );

		// Remove item from cart.
		add_action( 'wp_ajax_wp_travel_remove_cart_item', array( __CLASS__, 'remove_cart_item' ) );
		add_action( 'wp_ajax_nopriv_wp_travel_remove_cart_item', array( __CLASS__, 'remove_cart_item' ) );

		// Remove item from cart.
		add_action( 'wp_ajax_wp_travel_update_cart_item', array( __CLASS__, 'update_cart_item' ) );
		add_action( 'wp_ajax_nopriv_wp_travel_update_cart_item', array( __CLASS__, 'update_cart_item' ) );

		add_action( 'wp_ajax_wptravel_get_payment_field', array( __CLASS__, 'wp_get_payment_fied' ) );
		add_action( 'wp_ajax_nopriv_wptravel_get_payment_field', array( __CLASS__, 'wp_get_payment_fied' ) );

	}

	/**
	 * Get cart ajax request.
	 */
	public static function get_cart() {
		WP_Travel::verify_nonce();
		/**
		 * We are checking nonce using WP_Travel::verify_nonce(); method.
		 */
		$response = WP_Travel_Helpers_Cart::get_cart();
		WP_Travel_Helpers_REST_API::response( $response );
	}

	/**
	 * Add to cart ajax request.
	 */
	public static function add_to_cart() {
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
		$post_data = json_decode( file_get_contents( 'php://input' ) );
		$post_data = is_object( $post_data ) ? (array) $post_data : array();
		$post_data = wptravel_sanitize_array( $post_data );
		$response  = WP_Travel_Helpers_Cart::add_to_cart( $post_data );
		WP_Travel_Helpers_REST_API::response( $response );
	}

	/**
	 * Remove from cart ajax request.
	 */
	public static function remove_cart_item() {
		$request = WP_Travel::get_sanitize_request();

		$cart_id  = ! empty( $request['cart_id'] ) ? $request['cart_id'] : 0;
		$response = WP_Travel_Helpers_Cart::remove_cart_item( $cart_id );
		WP_Travel_Helpers_REST_API::response( $response );
	}

	/**
	 * Update cart ajax request.
	 */
	public static function update_cart_item() {
		$request   = WP_Travel::get_sanitize_request();
		$cart_id   = ! empty( $request['cart_id'] ) ? $request['cart_id'] : 0;
		$post_data = json_decode( file_get_contents( 'php://input' ) );
		$post_data = is_object( $post_data ) ? (array) $post_data : array();
		$post_data = wptravel_sanitize_array( $post_data );
		// print_r( $request );
		// print_r( $post_data );
		// die;
		$response = WP_Travel_Helpers_Cart::update_cart_item( $cart_id, $post_data );
		WP_Travel_Helpers_REST_API::response( $response );
	}
	/**
	 * get all payment field for one page booking
	 *
	 * @since 7.0
	 */
	public static function wp_get_payment_fied() {
		global $wt_cart;
		$trip_items     = $wt_cart->getItems();
		$all_form_field = wptravel_get_checkout_form_fields();
		$get_cart       = WP_Travel_Helpers_Cart::get_cart();
		$total_cart     = isset( $get_cart['cart'] ) && isset( $get_cart['cart']['total'] ) ? $get_cart['cart']['total'] : array( 'total' => '0' );
		$price_listing  = array(
			'partial_amount' => isset( $total_cart['total_partial'] ) ? $total_cart['total_partial'] : '0',
			'trip_price'     => isset( $total_cart['total'] ) ? $total_cart['total'] : $total_cart['total'],
		);
		$payment_field  = array(
			'payment'    => isset( $all_form_field['payment_fields'] ) ? $all_form_field['payment_fields'] : '',
			'form_key'   => ! empty( $trip_items ) ? array_key_first( $trip_items ) : 'one',
			'price_list' => $price_listing,
			'cart_price' => $total_cart,
		);
		WP_Travel_Helpers_REST_API::response( $payment_field );
	}
}

WP_Travel_Ajax_Cart::init();
