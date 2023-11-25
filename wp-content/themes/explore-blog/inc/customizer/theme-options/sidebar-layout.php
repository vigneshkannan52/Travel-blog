<?php

// Sidebar Option.
$wp_customize->add_section(
	'explore_blog_sidebar_option',
	array(
		'title' => esc_html__( 'Layout', 'explore-blog' ),
		'panel' => 'explore_blog_theme_options',
	)
);

// Sidebar Option - Global Sidebar Position.
$wp_customize->add_setting(
	'explore_blog_sidebar_position',
	array(
		'sanitize_callback' => 'explore_blog_sanitize_select',
		'default'           => 'right-sidebar',
	)
);

$wp_customize->add_control(
	'explore_blog_sidebar_position',
	array(
		'label'   => esc_html__( 'Global Sidebar Position', 'explore-blog' ),
		'section' => 'explore_blog_sidebar_option',
		'type'    => 'select',
		'choices' => array(
			'right-sidebar' => esc_html__( 'Right Sidebar', 'explore-blog' ),
			'left-sidebar'  => esc_html__( 'Left Sidebar', 'explore-blog' ),
			'no-sidebar'    => esc_html__( 'No Sidebar', 'explore-blog' ),
		),
	)
);

// Sidebar Option - Post Sidebar Position.
$wp_customize->add_setting(
	'explore_blog_post_sidebar_position',
	array(
		'sanitize_callback' => 'explore_blog_sanitize_select',
		'default'           => 'right-sidebar',
	)
);

$wp_customize->add_control(
	'explore_blog_post_sidebar_position',
	array(
		'label'   => esc_html__( 'Post Sidebar Position', 'explore-blog' ),
		'section' => 'explore_blog_sidebar_option',
		'type'    => 'select',
		'choices' => array(
			'right-sidebar' => esc_html__( 'Right Sidebar', 'explore-blog' ),
			'left-sidebar'  => esc_html__( 'Left Sidebar', 'explore-blog' ),
			'no-sidebar'    => esc_html__( 'No Sidebar', 'explore-blog' ),
		),
	)
);

// Sidebar Option - Page Sidebar Position.
$wp_customize->add_setting(
	'explore_blog_page_sidebar_position',
	array(
		'sanitize_callback' => 'explore_blog_sanitize_select',
		'default'           => 'right-sidebar',
	)
);

$wp_customize->add_control(
	'explore_blog_page_sidebar_position',
	array(
		'label'   => esc_html__( 'Page Sidebar Position', 'explore-blog' ),
		'section' => 'explore_blog_sidebar_option',
		'type'    => 'select',
		'choices' => array(
			'right-sidebar' => esc_html__( 'Right Sidebar', 'explore-blog' ),
			'left-sidebar'  => esc_html__( 'Left Sidebar', 'explore-blog' ),
			'no-sidebar'    => esc_html__( 'No Sidebar', 'explore-blog' ),
		),
	)
);
