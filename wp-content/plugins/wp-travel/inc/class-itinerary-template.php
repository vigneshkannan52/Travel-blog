<?php
class WP_Travel_Itinerary_Template {
	public function __construct() {
		add_filter( 'template_include', array( $this, 'load_single_template' ) );
	}

	public function load_single_template( $template ) {
		$post_types = array( WP_TRAVEL_POST_TYPE );

		if ( is_singular( $post_types ) ) {
			$template = wptravel_get_template( 'single-itineraries.php' );
		}

		return $template;
	}
}

// new WP_Travel_Itinerary_Template();
