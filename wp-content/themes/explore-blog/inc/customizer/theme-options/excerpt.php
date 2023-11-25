<?php

// Excerpt.
$wp_customize->add_section(
	'explore_blog_excerpt_options',
	array(
		'panel' => 'explore_blog_theme_options',
		'title' => esc_html__( 'Excerpt', 'explore-blog' ),
	)
);

// Excerpt - Excerpt Length.
$wp_customize->add_setting(
	'explore_blog_excerpt_length',
	array(
		'default'           => 20,
		'sanitize_callback' => 'explore_blog_sanitize_number_range',
		'validate_callback' => 'explore_blog_validate_excerpt_length',
	)
);

$wp_customize->add_control(
	'explore_blog_excerpt_length',
	array(
		'label'       => esc_html__( 'Excerpt Length (no. of words)', 'explore-blog' ),
		'section'     => 'explore_blog_excerpt_options',
		'settings'    => 'explore_blog_excerpt_length',
		'type'        => 'number',
		'input_attrs' => array(
			'min'  => 10,
			'max'  => 200,
			'step' => 1,
		),
	)
);
