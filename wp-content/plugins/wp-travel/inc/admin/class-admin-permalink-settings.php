<?php
/**
 * Adds settings to the permalinks admin settings page
 *
 * @category Admin
 * @package WP_Travel
 * @version 1.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WP_Travel_Admin_Permalink_Settings', false ) ) :

	/**
	 * WP_Travel_Admin_Permalink_Settings Class.
	 */
	class WP_Travel_Admin_Permalink_Settings {

		/**
		 * Permalink settings.
		 *
		 * @var array
		 */
		private $permalinks = array();

		/**
		 * Hook in tabs.
		 */
		public function __construct() {
			$this->settings_init();
			$this->settings_save();
		}

		/**
		 * Init our settings.
		 */
		public function settings_init() {

			// Add our settings
			add_settings_field(
				'wp_travel_trip_slug',            // id
				__( 'Trip base', 'wp-travel' ),   // setting title
				array( $this, 'trip_slug_input' ),  // display callback
				'permalink',                        // settings page
				'optional'                          // settings section
			);
			add_settings_field(
				'wp_travel_trip_type_slug',            // id
				__( 'Trip Type base', 'wp-travel' ),   // setting title
				array( $this, 'trip_type_slug_input' ),  // display callback
				'permalink',                        // settings page
				'optional'                          // settings section
			);
			add_settings_field(
				'wp_travel_destination_slug',            // id
				__( 'Trip Destination base', 'wp-travel' ),   // setting title
				array( $this, 'destination_slug_input' ),  // display callback
				'permalink',                        // settings page
				'optional'                          // settings section
			);
			add_settings_field(
				'wp_travel_activity_slug',            // id
				__( 'Trip Activity base', 'wp-travel' ),   // setting title
				array( $this, 'activity_slug_input' ),  // display callback
				'permalink',                        // settings page
				'optional'                          // settings section
			);
			$this->permalinks = wptravel_get_permalink_structure();
		}

		/**
		 * Show a slug input box.
		 */
		public function trip_slug_input() {

			?>
		<input name="wp_travel_trip_base" type="text" class="regular-text code" value="<?php echo esc_attr( $this->permalinks['wp_travel_trip_base'] ); ?>" placeholder="<?php echo esc_attr_x( 'trip', 'slug', 'wp-travel' ); ?>" />
			<?php
		}

		/**
		 * Show a slug input box.
		 */
		public function trip_type_slug_input() {

			?>
		<input name="wp_travel_trip_type_base" type="text" class="regular-text code" value="<?php echo esc_attr( $this->permalinks['wp_travel_trip_type_base'] ); ?>" placeholder="<?php echo esc_attr_x( 'trip-type', 'slug', 'wp-travel' ); ?>" />
			<?php
		}

		/**
		 * Show a slug input box.
		 */
		public function destination_slug_input() {

			?>
		<input name="wp_travel_destination_base" type="text" class="regular-text code" value="<?php echo esc_attr( $this->permalinks['wp_travel_destination_base'] ); ?>" placeholder="<?php echo esc_attr_x( 'travel-locations', 'slug', 'wp-travel' ); ?>" />
			<?php
		}

		/**
		 * Show a slug input box.
		 */
		public function activity_slug_input() {

			?>
		<input name="wp_travel_activity_base" type="text" class="regular-text code" value="<?php echo esc_attr( $this->permalinks['wp_travel_activity_base'] ); ?>" placeholder="<?php echo esc_attr_x( 'travel-locations', 'slug', 'wp-travel' ); ?>" />
			<?php
		}

		/**
		 * Save the settings.
		 */
		public function settings_save() {
			if ( ! is_admin() ) {
				return;
			}
			// We need to save the options ourselves; settings api does not trigger save for the permalinks page.
			if ( isset( $_POST['permalink_structure'] ) || isset( $_POST['category_base'] ) ) {
				check_admin_referer( 'update-permalink' );

				$permalinks = (array) get_option( 'wp_travel_permalinks', array() );

				$trip_base = isset( $_POST['wp_travel_trip_base'] ) ? sanitize_text_field( trim( $_POST['wp_travel_trip_base'] ) ) : '';
				if ( ! empty( $trip_base ) ) {
					$permalinks['wp_travel_trip_base'] = preg_replace( '#/+#', '', '/' . str_replace( '#', '', $trip_base ) );
				}

				$trip_type_base = isset( $_POST['wp_travel_trip_type_base'] ) ? sanitize_text_field( trim( $_POST['wp_travel_trip_type_base'] ) ) : '';
				if ( ! empty( $trip_type_base ) ) {
					$permalinks['wp_travel_trip_type_base'] = preg_replace( '#/+#', '', '/' . str_replace( '#', '', $trip_type_base ) );
				}

				$destination_base = isset( $_POST['wp_travel_destination_base'] ) ? sanitize_text_field( trim( $_POST['wp_travel_destination_base'] ) ) : '';
				if ( ! empty( $destination_base ) ) {
					$permalinks['wp_travel_destination_base'] = preg_replace( '#/+#', '', '/' . str_replace( '#', '', $destination_base ) );
				}

				$activity_base = isset( $_POST['wp_travel_activity_base'] ) ? sanitize_text_field( trim( $_POST['wp_travel_activity_base'] ) ) : '';
				if ( ! empty( $activity_base ) ) {
					$permalinks['wp_travel_activity_base'] = preg_replace( '#/+#', '', '/' . str_replace( '#', '', $activity_base ) );
				}

				update_option( 'wp_travel_permalinks', $permalinks );
			}
		}
	}

endif;

return new WP_Travel_Admin_Permalink_Settings();
