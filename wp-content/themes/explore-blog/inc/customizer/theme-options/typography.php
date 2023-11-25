<?php

// Typography.
$wp_customize->add_section(
	'explore_blog_typography',
	array(
		'panel' => 'explore_blog_theme_options',
		'title' => esc_html__( 'Typography', 'explore-blog' ),
	)
);

$wp_customize->add_setting(
	'explore_blog_site_title_font',
	array(
		'default'           => 'Montserrat',
		'sanitize_callback' => 'explore_blog_sanitize_google_fonts',
	)
);

$wp_customize->add_control(
	'explore_blog_site_title_font',
	array(
		'label'    => esc_html__( 'Site Title Font Family', 'explore-blog' ),
		'section'  => 'explore_blog_typography',
		'settings' => 'explore_blog_site_title_font',
		'type'     => 'select',
		'choices'  => explore_blog_get_all_google_font_families(),
	)
);

$wp_customize->add_setting(
	'explore_blog_site_description_font',
	array(
		'default'           => 'Montserrat',
		'sanitize_callback' => 'explore_blog_sanitize_google_fonts',
	)
);

$wp_customize->add_control(
	'explore_blog_site_description_font',
	array(
		'label'    => esc_html__( 'Site Description Font Family', 'explore-blog' ),
		'section'  => 'explore_blog_typography',
		'settings' => 'explore_blog_site_description_font',
		'type'     => 'select',
		'choices'  => explore_blog_get_all_google_font_families(),
	)
);

$wp_customize->add_setting(
	'explore_blog_header_font',
	array(
		'default'           => 'Lobster Two',
		'sanitize_callback' => 'explore_blog_sanitize_google_fonts',
	)
);

$wp_customize->add_control(
	'explore_blog_header_font',
	array(
		'label'    => esc_html__( 'Header Font Family', 'explore-blog' ),
		'section'  => 'explore_blog_typography',
		'settings' => 'explore_blog_header_font',
		'type'     => 'select',
		'choices'  => explore_blog_get_all_google_font_families(),
	)
);


$wp_customize->add_setting(
	'explore_blog_body_font',
	array(
		'default'           => 'Poppins',
		'sanitize_callback' => 'explore_blog_sanitize_google_fonts',
	)
);

$wp_customize->add_control(
	'explore_blog_body_font',
	array(
		'label'    => esc_html__( 'Body Font Family', 'explore-blog' ),
		'section'  => 'explore_blog_typography',
		'settings' => 'explore_blog_body_font',
		'type'     => 'select',
		'choices'  => explore_blog_get_all_google_font_families(),
	)
);
