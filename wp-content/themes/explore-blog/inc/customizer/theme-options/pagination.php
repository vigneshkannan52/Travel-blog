<?php

// Pagination.
$wp_customize->add_section(
	'explore_blog_pagination',
	array(
		'panel' => 'explore_blog_theme_options',
		'title' => esc_html__( 'Pagination', 'explore-blog' ),
	)
);

// Pagination - Enable/Disable Pagination.
$wp_customize->add_setting(
	'explore_blog_enable_pagination',
	array(
		'default'           => true,
		'sanitize_callback' => 'explore_blog_sanitize_switch',
	)
);

$wp_customize->add_control(
	new Explore_Blog_Toggle_Switch_Custom_Control(
		$wp_customize,
		'explore_blog_enable_pagination',
		array(
			'label'    => esc_html__( 'Enable Pagination', 'explore-blog' ),
			'section'  => 'explore_blog_pagination',
			'settings' => 'explore_blog_enable_pagination',
			'type'     => 'checkbox',
		)
	)
);

// Pagination - Pagination Type.
$wp_customize->add_setting(
	'explore_blog_pagination_type',
	array(
		'default'           => 'default',
		'sanitize_callback' => 'explore_blog_sanitize_select',
	)
);

$wp_customize->add_control(
	'explore_blog_pagination_type',
	array(
		'label'           => esc_html__( 'Pagination Type', 'explore-blog' ),
		'section'         => 'explore_blog_pagination',
		'settings'        => 'explore_blog_pagination_type',
		'active_callback' => 'explore_blog_is_pagination_enabled',
		'type'            => 'select',
		'choices'         => array(
			'default' => __( 'Default (Older/Newer)', 'explore-blog' ),
			'numeric' => __( 'Numeric', 'explore-blog' ),
		),
	)
);
