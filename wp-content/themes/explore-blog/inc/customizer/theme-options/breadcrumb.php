<?php

// Breadcrumb.
$wp_customize->add_section(
	'explore_blog_breadcrumb',
	array(
		'title' => esc_html__( 'Breadcrumb', 'explore-blog' ),
		'panel' => 'explore_blog_theme_options',
	)
);

// Breadcrumb - Enable Breadcrumb.
$wp_customize->add_setting(
	'explore_blog_enable_breadcrumb',
	array(
		'sanitize_callback' => 'explore_blog_sanitize_switch',
		'default'           => true,
	)
);

$wp_customize->add_control(
	new Explore_Blog_Toggle_Switch_Custom_Control(
		$wp_customize,
		'explore_blog_enable_breadcrumb',
		array(
			'label'   => esc_html__( 'Enable Breadcrumb', 'explore-blog' ),
			'section' => 'explore_blog_breadcrumb',
		)
	)
);

// Breadcrumb - Separator.
$wp_customize->add_setting(
	'explore_blog_breadcrumb_separator',
	array(
		'sanitize_callback' => 'sanitize_text_field',
		'default'           => '/',
	)
);

$wp_customize->add_control(
	'explore_blog_breadcrumb_separator',
	array(
		'label'           => esc_html__( 'Separator', 'explore-blog' ),
		'section'         => 'explore_blog_breadcrumb',
		'active_callback' => 'explore_blog_is_breadcrumb_enabled',
	)
);
