<?php
/**
 * Admin Settings.
 *
 * @package WP_Travel
 */

/**
 * Class for admin settings.
 */
class WP_Travel_Admin_Settings { // @phpcs:ignore
	/**
	 * Parent slug.
	 *
	 * @var string
	 */
	public static $parent_slug;

	/**
	 * Page.
	 *
	 * @var string
	 */
	public static $collection = 'settings';
	/**
	 * Constructor.
	 */
	public function __construct() {

		self::$parent_slug = 'edit.php?post_type=itinerary-booking';
		add_filter( 'wp_travel_admin_tabs', array( $this, 'add_tabs' ) );
		// Save Settings.
		add_action( 'load-itinerary-booking_page_settings', array( $this, 'save_settings' ) );
	}

	/**
	 * Call back function for Settings menu page. [ inc > admin > class-admin-menu.php]
	 */
	public static function setting_page_callback() {

		$args['settings']       = wptravel_get_settings();
		$url_parameters['page'] = self::$collection;
		$url                    = admin_url( self::$parent_slug );
		$url                    = add_query_arg( $url_parameters, $url );
		$sysinfo_url            = add_query_arg( array( 'page' => 'sysinfo' ), $url );

		echo '<div class="wrap wp-trave-settings-warp">';
			echo '<h1>' . esc_html__( 'WP Travel Settings', 'wp-travel' ) . '</h1>';
			echo '<div class="wp-trave-settings-form-warp">';
			do_action( 'wp_travel_before_admin_setting_form' ); // @phpcs:ignore
			echo '<form method="post" action="' . esc_url( $url ) . '">';
				echo '<div class="wp-travel-setting-buttons">';
				submit_button( __( 'Save Settings', 'wp-travel' ), 'primary', 'save_settings_button', false, array( 'id' => 'save_settings_button_top' ) );
				echo '</div>';
				WPTravel()->tabs->load( self::$collection, $args );
				echo '<div class="wp-travel-setting-buttons">';
				echo '<div class="wp-travel-setting-system-info">';
					echo '<a href="' . esc_url( $sysinfo_url ) . '" title="' . esc_attr__( 'View system information', 'wp-travel' ) . '"><span class="dashicons dashicons-info"></span>';
						esc_html_e( 'System Information', 'wp-travel' );
					echo '</a>';
				echo '</div>';
				echo '<input type="hidden" name="current_tab" id="wp-travel-settings-current-tab">';
				wp_nonce_field( 'wp_travel_settings_page_nonce' );
				submit_button( __( 'Save Settings', 'wp-travel' ), 'primary', 'save_settings_button', false );
				echo '</div>';
			echo '</form>';
			do_action( 'wp_travel_after_admin_setting_form' ); // @phpcs:ignore
		echo '</div>';
		echo '</div>';
	}

	/**
	 * Call back function for Settings menu page.
	 */
	public static function setting_page_callback_new() {
		?>
			<div id="wp-travel-settings-block-wrapper">
				<div id="wp-travel-settings-block"></div>
				<div id="aside-wrap-container">
					<div id="aside-wrap" class="single-module-side">
						<div class="aside-wrap-buttons-container">
							<h2 class="wp-travel-aside-wrap-block-title">
								<span><?php esc_html_e( 'Need Help?', 'wp-travel' ); ?></span>
							</h2>
							<div class="wp-travel-aside-help-block">
							<?php
							wptravel_meta_box_support();
							wptravel_meta_box_documentation();
							?>
							</div>
						</div>
						<?php
							wptravel_meta_box_review();
						?>
					</div>
				</div>
			</div>
		<?php
	}

	/**
	 * Add Tabs to settings page.
	 *
	 * @param array $tabs Tabs array list.
	 */
	public function add_tabs( $tabs ) {
		$settings_fields['general'] = array(
			'tab_label'     => __( 'General', 'wp-travel' ),
			'content_title' => __( 'General Settings', 'wp-travel' ),
			'priority'      => 10,
			'callback'      => 'wptravel_settings_callback_general',
			'icon'          => 'fa-sticky-note',
		);

		$settings_fields['itinerary'] = array(
			'tab_label'     => ucfirst( WP_TRAVEL_POST_TITLE_SINGULAR ),
			'content_title' => __( ucfirst( WP_TRAVEL_POST_TITLE_SINGULAR ) . ' Settings', 'wp-travel' ), // @phpcs:ignore
			'priority'      => 20,
			'callback'      => 'wptravel_settings_callback_itinerary',
			'icon'          => 'fa-hiking',
		);

		$settings_fields['email'] = array(
			'tab_label'     => __( 'Email', 'wp-travel' ),
			'content_title' => __( 'Email Settings', 'wp-travel' ),
			'priority'      => 25,
			'callback'      => 'wptravel_settings_callback_email',
			'icon'          => 'fa-envelope',
		);

		$settings_fields['account_options_global'] = array(
			'tab_label'     => __( 'Account', 'wp-travel' ),
			'content_title' => __( 'Account Settings', 'wp-travel' ),
			'priority'      => 30,
			'callback'      => 'wptravel_settings_callback_account_options_global',
			'icon'          => 'fa-lock',
		);

		$settings_fields['tabs_global'] = array(
			'tab_label'     => __( 'Tabs', 'wp-travel' ),
			'content_title' => __( 'Global Tabs Settings', 'wp-travel' ),
			'priority'      => 40,
			'callback'      => 'wptravel_settings_callback_tabs_global',
			'icon'          => 'fa-window-maximize',
		);
		$settings_fields['payment']     = array(
			'tab_label'     => __( 'Payment', 'wp-travel' ),
			'content_title' => __( 'Payment Settings', 'wp-travel' ),
			'priority'      => 50,
			'callback'      => 'wptravel_settings_callback_payment',
			'icon'          => 'fa-credit-card',
		);
		$settings_fields['facts']       = array(
			'tab_label'     => __( 'Facts', 'wp-travel' ),
			'content_title' => __( 'Facts Settings', 'wp-travel' ),
			'priority'      => 60,
			'callback'      => 'wptravel_settings_callback_facts',
			'icon'          => 'fa-industry',
		);
		if ( ! is_multisite() ) :
			$settings_fields['license'] = array(
				'tab_label'     => __( 'License', 'wp-travel' ),
				'content_title' => __( 'License Details', 'wp-travel' ),
				'priority'      => 70,
				'callback'      => 'wptravel_settings_callback_license',
				'icon'          => 'fa-id-badge',
			);
		endif;
		$settings_fields['field_editor']                  = array(
			'tab_label'     => __( 'Field Editor', 'wp-travel' ),
			'content_title' => __( 'Field Editor', 'wp-travel' ),
			'priority'      => 75,
			'callback'      => 'wptravel_settings_callback_field_editor',
			'icon'          => 'fa-newspaper',
		);
		$settings_fields['utilities_faq_global']          = array(
			'tab_label'     => __( 'FAQs', 'wp-travel' ),
			'content_title' => __( 'Global FAQs', 'wp-travel' ),
			'priority'      => 80,
			'callback'      => 'wptravel_settings_callback_utilities_faq_global',
			'icon'          => 'fa-question-circle',
		);
		$settings_fields['cart_checkout_settings_global'] = array(
			'tab_label'     => __( 'Cart & Checkout', 'wp-travel' ),
			'content_title' => __( 'Cart & Checkout Process Options', 'wp-travel' ),
			'priority'      => 85,
			'callback'      => 'wptravel_settings_callback_cart_checkout_settings_global',
			'icon'          => 'fa-shopping-cart',
		);

		$settings_fields['addons_settings']     = array(
			'tab_label'     => __( 'Addons Settings', 'wp-travel' ),
			'content_title' => __( 'Addons Settings', 'wp-travel' ),
			'priority'      => 90,
			'callback'      => 'wptravel_settings_callback_addons_settings',
			'icon'          => 'fa-plug',
		);
		$settings_fields['misc_options_global'] = array(
			'tab_label'     => __( 'Misc. Options', 'wp-travel' ),
			'content_title' => __( 'Miscellaneous Options', 'wp-travel' ),
			'priority'      => 95,
			'callback'      => 'wptravel_settings_callback_misc_options_global',
			'icon'          => 'fa-thumbtack',
		);
		$settings_fields['debug']               = array(
			'tab_label'     => __( 'Debug', 'wp-travel' ),
			'content_title' => __( 'Debug Options', 'wp-travel' ),
			'priority'      => 100,
			'callback'      => 'wptravel_settings_callback_debug',
			'icon'          => 'fa-bug',
		);

		$tabs[ self::$collection ] = wptravel_sort_array_by_priority( apply_filters( 'wp_travel_settings_tabs', $settings_fields ) ); // @phpcs:ignore
		return $tabs;
	}

	/**
	 * Save settings.
	 *
	 * @return void
	 */
	public function save_settings() {
		if ( isset( $_POST['save_settings_button'] ) ) {
			check_admin_referer( 'wp_travel_settings_page_nonce' );
			$current_tab = isset( $_POST['current_tab'] ) ? sanitize_text_field( wp_unslash( $_POST['current_tab'] ) ) : '';
			// Getting saved settings first.
			$settings        = wptravel_get_settings();
			$settings_fields = array_keys( wptravel_settings_default_fields() );

			foreach ( $settings_fields as $settings_field ) {
				if ( 'wp_travel_trip_facts_settings' === $settings_field ) {
					continue;
				}
				if ( isset( $_POST[ $settings_field ] ) ) {
					// Default pages settings. [only to get page in - wptravel_get_page_id()] // Need enhanchement.
					$page_ids = array( 'cart_page_id', 'checkout_page_id', 'dashboard_page_id', 'thank_you_page_id' );
					if ( in_array( $settings_field, $page_ids ) && ! empty( $_POST[ $settings_field ] ) ) {
						$page_id = absint( $_POST[ $settings_field ] );
						/**
						 * @since 3.1.8 WPML configuration.
						 */
						if ( defined( 'ICL_LANGUAGE_CODE' ) ) {
							update_option( 'wp_travel_' . $settings_field . '_' . ICL_LANGUAGE_CODE, $page_id );
							continue;
						} else {
							update_option( 'wp_travel_' . $settings_field, $page_id );
						}
					}

					$settings[ $settings_field ] = wp_unslash( $_POST[ $settings_field ] );
				}
			}

			// Email Templates
			// Booking Admin Email Settings.
			if ( isset( $_POST['booking_admin_template_settings'] ) && '' !== $_POST['booking_admin_template_settings'] ) {
				$settings['booking_admin_template_settings'] = wp_kses_post( stripslashes_deep( $_POST['booking_admin_template_settings'] ) );
			}

			// Booking Client Email Settings.
			if ( isset( $_POST['booking_client_template_settings'] ) && '' !== $_POST['booking_client_template_settings'] ) {
				$settings['booking_client_template_settings'] = wp_kses_post( stripslashes_deep( $_POST['booking_client_template_settings'] ) );
			}

			// Payment Admin Email Settings.
			if ( isset( $_POST['payment_admin_template_settings'] ) && '' !== $_POST['payment_admin_template_settings'] ) {
				$settings['payment_admin_template_settings'] = wp_kses_post( stripslashes_deep( $_POST['payment_admin_template_settings'] ) );
			}

			// Payment Client Email Settings.
			if ( isset( $_POST['payment_client_template_settings'] ) && '' !== $_POST['payment_client_template_settings'] ) {
				$settings['payment_client_template_settings'] = wp_kses_post( stripslashes_deep( $_POST['payment_client_template_settings'] ) );
			}

			// Enquiry Admin Email Settings.
			if ( isset( $_POST['enquiry_admin_template_settings'] ) && '' !== $_POST['enquiry_admin_template_settings'] ) {
				$settings['enquiry_admin_template_settings'] = wp_kses_post( stripslashes_deep( $_POST['enquiry_admin_template_settings'] ) );
			}

			// Trip Fact.
			$indexed = wp_kses_post( $_POST['wp_travel_trip_facts_settings'] );
			if ( array_key_exists( '$index', $indexed ) ) {
				unset( $indexed['$index'] );
			}
			foreach ( $indexed as $key => $index ) {
				if ( ! empty( $index['name'] ) ) {
					$index['id']      = $key;
					$index['initial'] = ! empty( $index['initial'] ) ? $index['initial'] : $index['name'];
					if ( is_array( $index['options'] ) ) {
						$options = array();
						$i       = 1;
						foreach ( $index['options'] as $option ) {
							$options[ 'option' . $i ] = $option;
							$i++;
						}
						$index['options'] = $options;
					}
					$indexed[ $key ] = $index;
					continue;
				}
				unset( $indexed[ $key ] );
			}
			$settings['wp_travel_trip_facts_settings'] = $indexed;

			if ( ! isset( $_POST['wp_travel_bank_deposits'] ) ) {
				$settings['wp_travel_bank_deposits'] = array();
			}

			// @since 1.0.5 Used this filter below.
			$settings = apply_filters( 'wp_travel_before_save_settings', $settings );

			update_option( 'wp_travel_settings', $settings );
			WPTravel()->notices->add( 'error ' );
			$url_parameters['page']    = self::$collection;
			$url_parameters['updated'] = 'true';
			$redirect_url              = admin_url( self::$parent_slug );
			$redirect_url              = add_query_arg( $url_parameters, $redirect_url ) . '#' . $current_tab;
			wp_redirect( $redirect_url );
			exit();
		}
	}

	/**
	 * System info.
	 */
	public static function get_system_info() {
		require_once sprintf( '%s/inc/admin/views/status.php', WP_TRAVEL_ABSPATH );
	}

}

new WP_Travel_Admin_Settings();
