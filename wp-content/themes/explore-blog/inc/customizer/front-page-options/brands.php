<?php
/**
 * Brands Section
 *
 * @package Explore_Blog
 */

$wp_customize->add_section(
	'explore_blog_brands_section',
	array(
		'panel' => 'explore_blog_front_page_options',
		'title' => esc_html__( 'Brands Section', 'explore-blog' ),
	)
);

// Brands Section - Enable Section.
$wp_customize->add_setting(
	'explore_blog_enable_brands_section',
	array(
		'default'           => false,
		'sanitize_callback' => 'explore_blog_sanitize_switch',
	)
);

$wp_customize->add_control(
	new Explore_Blog_Toggle_Switch_Custom_Control(
		$wp_customize,
		'explore_blog_enable_brands_section',
		array(
			'label'    => esc_html__( 'Enable Brands Section', 'explore-blog' ),
			'section'  => 'explore_blog_brands_section',
			'settings' => 'explore_blog_enable_brands_section',
		)
	)
);

if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial(
		'explore_blog_enable_brands_section',
		array(
			'selector' => '#explore_blog_brands_section .section-link',
			'settings' => 'explore_blog_enable_brands_section',
		)
	);
}

for ( $i = 1; $i <= 6; $i++ ) {

	// Brands Section - Logo.
	$wp_customize->add_setting(
		'explore_blog_brands_logo_' . $i,
		array(
			'sanitize_callback' => 'explore_blog_sanitize_image',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'explore_blog_brands_logo_' . $i,
			array(
				'label'           => sprintf( esc_html__( 'Logo %d', 'explore-blog' ), $i ),
				'section'         => 'explore_blog_brands_section',
				'settings'        => 'explore_blog_brands_logo_' . $i,
				'active_callback' => 'explore_blog_is_brands_section_enabled',
			)
		)
	);

	// Brands Section - Logo URL.
	$wp_customize->add_setting(
		'explore_blog_brands_logo_url_' . $i,
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control(
		'explore_blog_brands_logo_url_' . $i,
		array(
			'label'           => sprintf( esc_html__( 'Logo URL %d', 'explore-blog' ), $i ),
			'section'         => 'explore_blog_brands_section',
			'settings'        => 'explore_blog_brands_logo_url_' . $i,
			'type'            => 'url',
			'active_callback' => 'explore_blog_is_brands_section_enabled',
		)
	);

}
