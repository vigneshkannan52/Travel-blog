<?php

// Archive Layout.
$wp_customize->add_section(
	'explore_blog_archive_layout',
	array(
		'title' => esc_html__( 'Archive layout', 'explore-blog' ),
		'panel' => 'explore_blog_theme_options',
	)
);

// Archive Layout - Grid Style.
$wp_customize->add_setting(
	'explore_blog_archive_grid_column',
	array(
		'default'           => 'column-2',
		'sanitize_callback' => 'explore_blog_sanitize_select',
	)
);

$wp_customize->add_control(
	'explore_blog_archive_grid_column',
	array(
		'label'   => esc_html__( 'Select Grid Style', 'explore-blog' ),
		'section' => 'explore_blog_archive_layout',
		'type'    => 'select',
		'choices' => array(
			'column-2' => __( 'Column 2', 'explore-blog' ),
			'column-3' => __( 'Column 3', 'explore-blog' ),
		),
	)
);

// Archive Layout - Button Label.
$wp_customize->add_setting(
	'explore_blog_archive_button_label',
	array(
		'default'           => __( 'Read More', 'explore-blog' ),
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	'explore_blog_archive_button_label',
	array(
		'label'    => esc_html__( 'Button Label', 'explore-blog' ),
		'section'  => 'explore_blog_archive_layout',
		'settings' => 'explore_blog_archive_button_label',
		'type'     => 'text',
	)
);
