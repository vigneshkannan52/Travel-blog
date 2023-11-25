<?php

/**
 * Dynamic CSS
 */
function explore_blog_dynamic_css() {
	$header_font           = get_theme_mod( 'explore_blog_header_font', 'Lobster Two' );
	$body_font             = get_theme_mod( 'explore_blog_body_font', 'Poppins' );
	$site_title_font       = get_theme_mod( 'explore_blog_site_title_font', 'Montserrat' );
	$site_description_font = get_theme_mod( 'explore_blog_site_description_font', 'Montserrat' );

	$custom_css  = '';
	$custom_css .= '
	/* Color */
	:root {
		--header-text-color: ' . esc_attr( '#' . get_header_textcolor() ) . ';
	}
	';

	$custom_css .= '
	/* Typograhpy */
	:root {
		--font-heading: "' . esc_attr( $header_font ) . '", serif;
		--font-main: -apple-system, BlinkMacSystemFont,"' . esc_attr( $body_font ) . '", "Segoe UI", Montserrat, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
	}

	body,
	button, input, select, optgroup, textarea {
		font-family: "' . esc_attr( $body_font ) . '", serif;
	}

	.site-title a {
		font-family: "' . esc_attr( $site_title_font ) . '", serif;
	}

	.site-description {
		font-family: "' . esc_attr( $site_description_font ) . '", serif;
	}
	';

	wp_add_inline_style( 'explore-blog-style', $custom_css );

}
add_action( 'wp_enqueue_scripts', 'explore_blog_dynamic_css', 99 );
