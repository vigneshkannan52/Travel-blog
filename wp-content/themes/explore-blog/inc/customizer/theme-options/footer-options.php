<?php

// Footer Options.
$wp_customize->add_section(
	'explore_blog_footer_options',
	array(
		'panel' => 'explore_blog_theme_options',
		'title' => esc_html__( 'Footer Options', 'explore-blog' ),
	)
);

// Footer Options - Copyright Text.
/* translators: 1: Year, 2: Site Title with home URL. */
$copyright_default = sprintf( esc_html_x( 'Copyright &copy; %1$s %2$s', '1: Year, 2: Site Title with home URL', 'explore-blog' ), '[the-year]', '[site-link]' );
$wp_customize->add_setting(
	'explore_blog_footer_copyright_text',
	array(
		'default'           => $copyright_default,
		'sanitize_callback' => 'wp_kses_post',
	)
);

$wp_customize->add_control(
	'explore_blog_footer_copyright_text',
	array(
		'label'    => esc_html__( 'Copyright Text', 'explore-blog' ),
		'section'  => 'explore_blog_footer_options',
		'settings' => 'explore_blog_footer_copyright_text',
		'type'     => 'textarea',
	)
);

// Footer Options - Scroll Top.
$wp_customize->add_setting(
	'explore_blog_scroll_top',
	array(
		'sanitize_callback' => 'explore_blog_sanitize_switch',
		'default'           => true,
	)
);

$wp_customize->add_control(
	new Explore_Blog_Toggle_Switch_Custom_Control(
		$wp_customize,
		'explore_blog_scroll_top',
		array(
			'label'   => esc_html__( 'Enable Scroll Top Button', 'explore-blog' ),
			'section' => 'explore_blog_footer_options',
		)
	)
);
