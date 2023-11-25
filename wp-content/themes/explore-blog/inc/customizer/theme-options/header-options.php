<?php
/**
 * Header Options
 *
 * @package Explore_Blog
 */

$wp_customize->add_section(
	'explore_blog_topbar_options',
	array(
		'panel' => 'explore_blog_theme_options',
		'title' => esc_html__( 'Header Options', 'explore-blog' ),
	)
);

// Topbar Options - Enable topbar.
$wp_customize->add_setting(
	'explore_blog_enable_topbar',
	array(
		'sanitize_callback' => 'explore_blog_sanitize_switch',
		'default'           => false,
	)
);

$wp_customize->add_control(
	new Explore_Blog_Toggle_Switch_Custom_Control(
		$wp_customize,
		'explore_blog_enable_topbar',
		array(
			'label'   => esc_html__( 'Enable Topbar', 'explore-blog' ),
			'section' => 'explore_blog_topbar_options',
		)
	)
);

// Topbar Options - Hide topbar on responsive device.
$wp_customize->add_setting(
	'explore_blog_hide_topbar_on_responsive_device',
	array(
		'sanitize_callback' => 'explore_blog_sanitize_switch',
		'default'           => false,
	)
);

$wp_customize->add_control(
	new Explore_Blog_Toggle_Switch_Custom_Control(
		$wp_customize,
		'explore_blog_hide_topbar_on_responsive_device',
		array(
			'label'           => esc_html__( 'Hide Topbar On Responsive Device', 'explore-blog' ),
			'section'         => 'explore_blog_topbar_options',
			'active_callback' => 'explore_blog_is_topbar_enabled',
		)
	)
);

// Topbar Options - Contact Number.
$wp_customize->add_setting(
	'explore_blog_contact_number',
	array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	'explore_blog_contact_number',
	array(
		'label'           => esc_html__( 'Contact Number', 'explore-blog' ),
		'section'         => 'explore_blog_topbar_options',
		'settings'        => 'explore_blog_contact_number',
		'type'            => 'text',
		'active_callback' => 'explore_blog_is_topbar_enabled',
	)
);

// Topbar Options - Email Address.
$wp_customize->add_setting(
	'explore_blog_email_address',
	array(
		'default'           => '',
		'sanitize_callback' => 'explore_blog_sanitize_email',
	)
);

$wp_customize->add_control(
	'explore_blog_email_address',
	array(
		'label'           => esc_html__( 'Email Address', 'explore-blog' ),
		'section'         => 'explore_blog_topbar_options',
		'settings'        => 'explore_blog_email_address',
		'type'            => 'email',
		'active_callback' => 'explore_blog_is_topbar_enabled',
	)
);
