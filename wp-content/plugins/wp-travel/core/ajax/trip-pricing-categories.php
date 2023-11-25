<?php
class WP_Travel_Ajax_Trip_Pricings_Categories {
	public static function init() {
		// Get Cart items
		add_action( 'wp_ajax_wp_travel_remove_pricing_categories', array( __CLASS__, 'remove_pricing_categories' ) );
		add_action( 'wp_ajax_nopriv_wp_travel_remove_pricing_categories', array( __CLASS__, 'remove_pricing_categories' ) );

		add_action( 'wp_ajax_wp_travel_remove_pricing_category', array( __CLASS__, 'remove_pricing_category' ) );
		add_action( 'wp_ajax_nopriv_wp_travel_remove_pricing_category', array( __CLASS__, 'remove_pricing_category' ) );
	}

	public static function remove_pricing_categories() {
		WP_Travel::verify_nonce();

		if ( ! current_user_can( 'manage_options' ) ) {
			$error = WP_Travel_Helpers_Error_Codes::get_error( 'WP_TRAVEL_INVALID_PERMISSION' );
			WP_Travel_Helpers_REST_API::response( $error );
		}
		/**
		 * We are checking nonce using WP_Travel::verify_nonce(); method.
		 */
		$pricing_id = ! empty( $_GET['pricing_id'] ) ? absint( $_GET['pricing_id'] ) : 0; // @phpcs:ignore
		$response   = WP_Travel_Helpers_Trip_Pricing_Categories::remove_trip_pricing_categories( $pricing_id );
		WP_Travel_Helpers_REST_API::response( $response );
	}

	public static function remove_pricing_category() {
		WP_Travel::verify_nonce();

		if ( ! current_user_can( 'manage_options' ) ) {
			$error = WP_Travel_Helpers_Error_Codes::get_error( 'WP_TRAVEL_INVALID_PERMISSION' );
			WP_Travel_Helpers_REST_API::response( $error );
		}
		/**
		 * We are checking nonce using WP_Travel::verify_nonce(); method.
		 */
		$pricing_id  = ! empty( $_GET['pricing_id'] ) ? absint( $_GET['pricing_id'] ) : 0; // @phpcs:ignore
		$category_id = ! empty( $_GET['category_id'] ) ? absint( $_GET['category_id'] ) : 0;  // @phpcs:ignore
		$response    = WP_Travel_Helpers_Trip_Pricing_Categories::remove_individual_pricing_category( $pricing_id, $category_id );
		WP_Travel_Helpers_REST_API::response( $response );
	}
}

WP_Travel_Ajax_Trip_Pricings_Categories::init();
