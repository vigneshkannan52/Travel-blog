<?php
/**
 * Enquiry Functions.
 *
 * @package WP_Travel
 */

/**
 * Array List of form field to generate enquiry form fields.
 *
 * @return array Returns form fields.
 */
function wptravel_enquiries_form_fields() {

	// Default enquiry fields.
	$enquiry_fields = WP_Travel_Default_Form_Fields::enquiry();
	$enquiry_fields = apply_filters( 'wp_travel_enquiries_form_fields', $enquiry_fields );
	$strings = array();
	if ( class_exists( 'WpTravel_Helpers_Strings' ) ) {
		$string = WpTravel_Helpers_Strings::get(); 
	}
	$strings = isset( $string['enquiry'] ) ? $string['enquiry'] : apply_filters( 'wp_travel_trip_enquiry_label', __( 'Enquiry', 'wp-travel' ) ) ;

	if ( ! is_admin() ) {
		$enquiry_fields['label_submit_enquiry'] = array(
			'type'    => 'hidden',
			'label'   => '',
			'name'    => 'wp_travel_label_submit_enquiry',
			'id'      => 'wp_travel_label_submit_enquiry',
			'default' => __( 'SUBMIT ', 'wp-travel' ) . $strings,
		);
		$enquiry_fields['label_processing']     = array(
			'type'    => 'hidden',
			'label'   => '',
			'name'    => 'wp_travel_label_processing',
			'id'      => 'wp_travel_label_processing',
			'default' => __( 'PROCESSING...', 'wp-travel' ),
		);
		$enquiry_fields['action']               = array(
			'type'    => 'hidden',
			'label'   => '',
			'name'    => 'action',
			'id'      => 'wp_travel_enquiry_action',
			'default' => 'wptravel_save_user_enquiry',
		);
	}

	return $enquiry_fields;
}

/**
 * Return HTM of Enquiry Form
 *
 * @return void [description]
 */
function wptravel_get_enquiries_form( $trips_dropdown = false ) {
	global $post;

	$settings = wptravel_get_settings();

	$gdpr_msg = isset( $settings['wp_travel_gdpr_message'] ) ? esc_html( $settings['wp_travel_gdpr_message'] ) : __( 'By contacting us, you agree to our ', 'wp-travel' );

	$privacy_policy_url = false;

	if ( function_exists( 'get_privacy_policy_url' ) ) {

		$privacy_policy_url = get_privacy_policy_url();

	}

	include_once WP_TRAVEL_ABSPATH . 'inc/framework/form/class.form.php';
	$enquiry_fields = WP_Travel_Default_Form_Fields::enquiry();
	$enquiry_fields = apply_filters( 'wp_travel_enquiries_form_fields', $enquiry_fields );
	$strings = array();
	if ( class_exists( 'WpTravel_Helpers_Strings' ) ) {
		$string = WpTravel_Helpers_Strings::get(); 
	}
	$strings = isset( $string['enquiry'] ) ? $string['enquiry'] : apply_filters( 'wp_travel_trip_enquiry_label', __( 'Enquiry', 'wp-travel' ) ) ;

	$form_options = array(
		'id'            => 'wp-travel-enquiries',
		'class'         => 'mfp-hide wp-travel-enquiries-form',
		'wrapper_class' => 'wp-travel-enquiries-form-wrapper',
		'submit_button' => array(
			'name'  => 'wp_travel_enquiry_submit',
			'class' => 'button wp-block-button__link',
			'id'    => 'wp-travel-enquiry-submit',
			'value' => apply_filters( 'wp_travel_enquiry_submit_button_label', __( 'SUBMIT ', 'wp-travel' ) ) . $strings,
		),
		'nonce'         => array(
			'action' => 'wp_travel_security_action',
			'field'  => 'wp_travel_security',
		),
	);

	$fields                = wptravel_enquiries_form_fields();
	$form                  = new WP_Travel_FW_Form();
	$form_options['class'] = 'wp-travel-enquiries-form';
	if ( $trips_dropdown ) {
		$query = new WP_Query(
			array(
				'post_type'      => WP_TRAVEL_POST_TYPE,
				'status'         => 'published',
				'posts_per_page' => '-1',
			)
		);

		$trips   = $query->posts;
		$options = array( '' => 'Select' );
		foreach ( $trips as $trip ) {
			$options[ $trip->ID ] = $trip->{'post_title'};
		}
		$fields['wp_travel_enquiry_post_id'] = array(
			'label'   => __( 'Trips', 'wp-travel' ),
			'type'    => 'select',
			'name'    => 'wp_travel_enquiry_post_id',
			'id'      => 'wp-travel-enquiry-post-id',
			'options' => $options,
		);
	} else {
		$fields['wp_travel_enquiry_post_id'] = array(
			'type'    => 'hidden',
			'name'    => 'wp_travel_enquiry_post_id',
			'id'      => 'wp-travel-enquiry-post-id',
			'default' => $post->ID,
		);
	}
	$policy_link = wptravel_privacy_link();
	if ( ! empty( $gdpr_msg ) && $policy_link ) {
		// GDPR Compatibility for enquiry.
		$fields['wp_travel_enquiry_gdpr'] = array(
			'type'              => 'checkbox',
			'label'             => __( 'Privacy Policy', 'wp-travel' ),
			'options'           => array( 'gdpr_agree' => sprintf( '%1s %2s', $gdpr_msg, $policy_link ) ),
			'name'              => 'wp_travel_enquiry_gdpr_msg',
			'id'                => 'wp-travel-enquiry-gdpr-msg',
			'validations'       => array(
				'required' => true,
			),
			'option_attributes' => array(
				'required' => true,
			),
			'priority'          => 500,
			'wrapper_class'     => 'wp-travel-enquiry-gdpr-section',

		);

	}
	$form->init( $form_options )->fields( $fields )->template();
}

add_action( 'add_meta_boxes', 'wptravel_add_enquiries_data_metaboxes', 10, 2 );

/**
 * Add Enquiries Metaboxes.
 */
function wptravel_add_enquiries_data_metaboxes() {

	global $post;
	global $wp_travel_itinerary;

	$wp_travel_post_id = get_post_meta( $post->ID, 'wp_travel_post_id', true );
	$string	= array();
	if ( class_exists( 'WpTravel_Helpers_Strings' ) ) {
		$string = WpTravel_Helpers_Strings::get();
	}
	$strings = isset( $string['enquiry'] ) ? $string['enquiry'] : __( 'Enquiry', 'wp-travel' );
	add_meta_box( 'wp-travel-enquiries-info', __( $strings . ' Details <span class="wp-travel-view-enquiries"><a href="edit.php?post_type=itinerary-enquiries&wp_travel_post_id=' . $wp_travel_post_id . '">View All ' . get_the_title( $wp_travel_post_id ) . ' enquiries</a></span>', 'wp-travel' ), 'wptravel_enquiries_info', 'itinerary-enquiries', 'normal', 'default' );

}

/**
 * WP Travel Enquiries Info
 */
function wptravel_enquiries_info() {
	?>
	<div class="wp-travel-booking-form-wrapper">
		<div id="wp_travel_enquiries">
		</div>
	</div>
	<?php
}

/*
 * ADMIN COLUMN - HEADERS
 */
add_filter( 'manage_edit-itinerary-enquiries_columns', 'wptravel_enquiries_list_columns' );

/**
 * Customize Admin column.
 *
 * @param  Array $enquiries_column List of columns.
 * @return Array                  [description]
 */
function wptravel_enquiries_list_columns( $enquiries_column ) {

	$new_columns['cb']            = '<input type="checkbox" />';
	$new_columns['title']         = _x( 'Title', 'column name', 'wp-travel' );
	$new_columns['contact_name']  = __( 'Contact Name', 'wp-travel' );
	$new_columns['contact_email'] = __( 'Contact Email', 'wp-travel' );
	$new_columns['date']          = __( 'Enquiry Date', 'wp-travel' );
	return $new_columns;
}

/*
 * ADMIN COLUMN - CONTENT
 */
add_action( 'manage_itinerary-enquiries_posts_custom_column', 'wptravel_enquiries_content_manage_columns', 10, 2 );

/**
 * Add data to custom column.
 *
 * @param  String $column_name Custom column name.
 * @param  int    $id          Post ID.
 */
function wptravel_enquiries_content_manage_columns( $column_name, $id ) {

	$column_data = get_post_meta( $id, 'wp_travel_trip_enquiry_data', true );

	switch ( $column_name ) {
		case 'contact_name':
			$name = isset( $column_data['wp_travel_enquiry_name'] ) ? $column_data['wp_travel_enquiry_name'] : '';
			echo esc_html( $name );
			break;
		case 'contact_email':
			$email = isset( $column_data['wp_travel_enquiry_email'] ) ? $column_data['wp_travel_enquiry_email'] : '';
			?>
				<a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a>
			<?php
			break;
		default:
			break;
	} // end switch
}

/**
 * Save Post meta data.
 *
 * @param  int $post_id ID of current post.
 *
 * @return Mixed
 */
function wptravel_save_backend_enqueries_data( $post_id ) {

	if ( ! isset( $_POST['wp_travel_security'] ) ) {
		return;
	}
	if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['wp_travel_security'] ) ), 'wp_travel_security_action' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	// If this is just a revision, don't send the email.
	if ( wp_is_post_revision( $post_id ) ) {
		return;
	}

	$post_type = get_post_type( $post_id );

	// If this isn't a 'itineraries' post, don't update it.
	if ( 'itinerary-enquiries' !== $post_type ) {
		return;
	}

	if ( ! is_admin() ) {
		return;
	}
	$enqueries_data    = array();
	$wp_travel_post_id = isset( $_POST['wp_travel_post_id'] ) ? absint( $_POST['wp_travel_post_id'] ) : 0;
	update_post_meta( $post_id, 'wp_travel_post_id', sanitize_text_field( $wp_travel_post_id ) );
	$enquery_data['post_id'] = $wp_travel_post_id;

	$fields   = wptravel_enquiries_form_fields();
	$priority = array();
	foreach ( $fields as $key => $row ) {
		$priority[ $key ] = isset( $row['priority'] ) ? $row['priority'] : 1;
	}
	array_multisort( $priority, SORT_ASC, $fields );
	foreach ( $fields as $key => $field ) :
		$meta_val          = isset( $_POST[ $field['name'] ] ) ? sanitize_text_field( wp_unslash( ( $_POST[ $field['name'] ] ) ) ) : '';
		$post_id_to_update = apply_filters( 'wp_travel_booking_post_id_to_update', $post_id, $key, $field['name'] );
		update_post_meta( $post_id_to_update, $field['name'], sanitize_text_field( $meta_val ) );
		$enquery_data[ $field['name'] ] = $meta_val;
	endforeach;

	$enquery_data = array_map( 'sanitize_text_field', wp_unslash( $enquery_data ) );
	$enquery_data = apply_filters( 'wp_travel_admin_enquiry_data', $enquery_data );
	update_post_meta( $post_id, 'wp_travel_trip_enquiry_data', $enquery_data );
	/**
	 * Hook used to initialize zapier automation.
	 *
	 * @since 2.0.9
	 */
	do_action( 'wp_travel_after_enquiry_save', $post_id, $enquery_data );
}

add_action( 'save_post', 'wptravel_save_backend_enqueries_data' );

/**
 * Save Front End Trip Enqueries data.
 */
function wptravel_save_user_enquiry() {

	if ( ! isset( $_POST['nonce'] ) ) {
		return;
	}

	$formdata = wptravel_sanitize_array( $_POST );

	if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'wp_travel_frontend_security' ) ) {

		$errors['message'] = __( 'Nonce Verification Failed !!', 'wp-travel' );

		wp_send_json_error( $errors );

		return;

	}

	$validation_check = apply_filters( 'wp_travel_frontend_enqueries_validation_check', array( 'status' => true ) );

	if ( ! empty( $validation_check ) && false === $validation_check['status'] ) {
		$errors['message'] = $validation_check['message'];
		wp_send_json_error( $errors );
		return;
	}

	$settings = wptravel_get_settings();

	$post_id = (int) $formdata['wp_travel_enquiry_post_id'];
	if ( ! $post_id ) {
		$errors['message'] = __( 'Please select trip', 'wp-travel' );
		wp_send_json_error( $errors );
	}

	$post_type = get_post_type( $post_id );

	// If this isn't a 'itineraries' post, don't update it.
	if ( WP_TRAVEL_POST_TYPE !== $post_type ) {

		$errors['message'] = __( 'Invalid Post Type', 'wp-travel' );

		wp_send_json_error( $errors );

		return;
	}
	$string = array();
	if ( class_exists( 'WpTravel_Helpers_Strings' ) ) {
		$string = WpTravel_Helpers_Strings::get();
	}
	$strings = isset( $string['enquiry'] ) ? $string['enquiry'] : __( 'Enquiry', 'wp-travel' );
	$enquiry_data = array();

	$enquiry_data['post_id'] = isset( $formdata['wp_travel_enquiry_post_id'] ) ? $formdata['wp_travel_enquiry_post_id'] : '';

	$enquiry_data['wp_travel_enquiry_name'] = isset( $formdata['wp_travel_enquiry_name'] ) ? $formdata['wp_travel_enquiry_name'] : '';

	$enquiry_data['wp_travel_enquiry_email'] = isset( $formdata['wp_travel_enquiry_email'] ) ? $formdata['wp_travel_enquiry_email'] : '';

	$enquiry_data['wp_travel_enquiry_query'] = isset( $formdata['wp_travel_enquiry_query'] ) ? $formdata['wp_travel_enquiry_query'] : '';

	$enquiry_data = apply_filters( 'wp_travel_frontend_enquiry_data', $enquiry_data, $formdata );

	$trip_code = wptravel_get_trip_code( $post_id );

	$title = 'Enquiry - ' . $trip_code;

	$post_array = array(
		'post_title'   => $title,
		'post_content' => '',
		'post_status'  => 'publish',
		'post_slug'    => uniqid(),
		'post_type'    => 'itinerary-enquiries',
	);

	$new_enquiry = wp_insert_post( $post_array );

	// Update Data.
	if ( ! empty( $enquiry_data ) ) {

		// Sanitize Values.
		$enquiry_data = stripslashes_deep( $enquiry_data );

		$wp_travel_post_id = isset( $enquiry_data['post_id'] ) ? $enquiry_data['post_id'] : 0;
		update_post_meta( $new_enquiry, 'wp_travel_post_id', sanitize_text_field( $wp_travel_post_id ) );

		// Finally Update enquiry data.
		update_post_meta( $new_enquiry, 'wp_travel_trip_enquiry_data', $enquiry_data );

	}

	$site_admin_email = get_option( 'admin_email' );

	$admin_email = apply_filters( 'wp_travel_enquiries_admin_emails', $site_admin_email );

	// Email Variables.
	if ( is_multisite() ) {
		$sitename = get_network()->site_name;
	} else {
		/*
			* The blogname option is escaped with esc_html on the way into the database
			* in sanitize_option we want to reverse this for the plain text arena of emails.
			*/
		$sitename = wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );
	}
	$enquiry_id      = $new_enquiry;
	$itinerary_id    = absint( $enquiry_data['post_id'] );
	$itinerary_title = get_the_title( $itinerary_id );
	$customer_name   = sanitize_text_field( $enquiry_data['wp_travel_enquiry_name'] );
	$customer_email  = sanitize_text_field( $enquiry_data['wp_travel_enquiry_email'] );
	$customer_note   = sanitize_text_field( $enquiry_data['wp_travel_enquiry_query'] );

	$email_tags = array(
		'{sitename}'          => $sitename,
		'{itinerary_link}'    => get_permalink( $itinerary_id ),
		'{itinerary_title}'   => $itinerary_title,
		'{enquery_id}'        => $enquiry_id,
		'{enquery_edit_link}' => get_edit_post_link( $enquiry_id ),
		'{customer_name}'     => $customer_name,
		'{customer_email}'    => $customer_email,
		'{customer_note}'     => $customer_note,
	);
	$email_tags = apply_filters( 'wp_travel_admin_enquery_email_tags', $email_tags, $formdata );

	$email = new WP_Travel_Emails();

	$enquiry_template = $email->wptravel_get_email_template( 'enquiry', 'admin' );
	// Admin message.
	$enquiry_message = str_replace( array_keys( $email_tags ), $email_tags, $enquiry_template['mail_content'] );
	// Admin Subject.
	$enquiry_subject = $enquiry_template['subject'];

	$reply_to_email = isset( $settings['wp_travel_from_email'] ) ? $settings['wp_travel_from_email'] : $site_admin_email;

	// To send HTML mail, the Content-type header must be set.
	$headers = $email->email_headers( $reply_to_email, $customer_email );
	$trip_enquiry_mail = apply_filters( 'wp_travel_trip_enquiry_mail', true ) ;
	if (  $trip_enquiry_mail == true ) {
		if ( ! wp_mail( $admin_email, $enquiry_subject, $enquiry_message, $headers ) ) {

			$errors = array(
				'result'  => 0,
				'message' => __( 'Your Enquiry has been added but the email could not be sent.', 'wp-travel' ) . "<br />\n" . __( 'Possible reason: your host may have disabled the mail() function.', 'wp-travel' ),
			);

			wp_send_json_error( $errors );
			return;
		}
	}
	do_action( 'wp_travel_after_enquiries_email_sent', $admin_email, $customer_email, $formdata, $enquiry_id );
	// If we reach here, Send Success message !!
	$trip_name = get_the_title( $post_id );
	$success   = array(
		'message' => __( $strings . ' sent succesfully !!', 'wp-travel' ),
	);

	// Send Success Message.
	wp_send_json_success( $success );

	die();
}
add_action( 'wp_ajax_wptravel_save_user_enquiry', 'wptravel_save_user_enquiry' );
add_action( 'wp_ajax_nopriv_wptravel_save_user_enquiry', 'wptravel_save_user_enquiry' );

/**
 * Check if current page is blog page.
 *
 * @return Boolen
 */
function is_blog() {
	return ( is_archive() || is_author() || is_category() || is_home() || is_tag() );
}

function wptravel_enquiry_form_header() {
	if ( is_blog() ) {
		return;
	}
	$strings = array();
	if ( class_exists( 'WpTravel_Helpers_Strings' ) ) {
		$string = WpTravel_Helpers_Strings::get(); 
	}
	$strings = isset( $string['trip_enquiry'] ) ? $string['trip_enquiry'] : apply_filters( 'wp_travel_trip_enquiry_title', __( 'Trip Enquiry', 'wp-travel' ) ) ;
	$enquiry = isset( $string['enquiry'] ) ? $string['enquiry'] : apply_filters( 'wp_travel_enquiry_labels', __( 'Enquiry', 'wp-travel' ) ) ;
	?>
		<div class="wp-travel-inquiry__form-header">
			<h3><?php echo esc_html( sprintf( _x( $enquiry .': %s', $strings . ' Form Title', 'wp-travel' ), get_the_title() ) ); ?></h3>
		</div>
	<?php
}
// add_action( 'wp_travel_enquiries_before_form_field', 'wptravel_enquiry_form_header', 20 );
