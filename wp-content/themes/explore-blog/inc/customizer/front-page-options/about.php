<?php
/**
 * About Section
 *
 * @package Explore_Blog
 */

$wp_customize->add_section(
	'explore_blog_about_section',
	array(
		'panel' => 'explore_blog_front_page_options',
		'title' => esc_html__( 'About Section', 'explore-blog' ),
	)
);

// About Section - Enable Section.
$wp_customize->add_setting(
	'explore_blog_enable_about_section',
	array(
		'default'           => false,
		'sanitize_callback' => 'explore_blog_sanitize_switch',
	)
);

$wp_customize->add_control(
	new Explore_Blog_Toggle_Switch_Custom_Control(
		$wp_customize,
		'explore_blog_enable_about_section',
		array(
			'label'    => esc_html__( 'Enable About Section', 'explore-blog' ),
			'section'  => 'explore_blog_about_section',
			'settings' => 'explore_blog_enable_about_section',
		)
	)
);

if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial(
		'explore_blog_enable_about_section',
		array(
			'selector' => '#explore_blog_about_section .section-link',
			'settings' => 'explore_blog_enable_about_section',
		)
	);
}

// About Section - Section Subtitle.
$wp_customize->add_setting(
	'explore_blog_about_subtitle',
	array(
		'default'           => __( 'LIFE IS WONDERFUL', 'explore-blog' ),
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	'explore_blog_about_subtitle',
	array(
		'label'           => esc_html__( 'Section Subtitle', 'explore-blog' ),
		'section'         => 'explore_blog_about_section',
		'settings'        => 'explore_blog_about_subtitle',
		'type'            => 'text',
		'active_callback' => 'explore_blog_is_about_section_enabled',
	)
);

// About Section - Content Type.
$wp_customize->add_setting(
	'explore_blog_about_content_type',
	array(
		'default'           => 'post',
		'sanitize_callback' => 'explore_blog_sanitize_select',
	)
);

$wp_customize->add_control(
	'explore_blog_about_content_type',
	array(
		'label'           => esc_html__( 'Select Content Type', 'explore-blog' ),
		'section'         => 'explore_blog_about_section',
		'settings'        => 'explore_blog_about_content_type',
		'type'            => 'select',
		'active_callback' => 'explore_blog_is_about_section_enabled',
		'choices'         => array(
			'page' => esc_html__( 'Page', 'explore-blog' ),
			'post' => esc_html__( 'Post', 'explore-blog' ),
		),
	)
);

// About Section - Content Type Post.
$wp_customize->add_setting(
	'explore_blog_about_content_post',
	array(
		'sanitize_callback' => 'absint',
	)
);

$wp_customize->add_control(
	'explore_blog_about_content_post',
	array(
		'section'         => 'explore_blog_about_section',
		'settings'        => 'explore_blog_about_content_post',
		'label'           => esc_html__( 'Select Post', 'explore-blog' ),
		'active_callback' => 'explore_blog_is_about_section_and_content_type_post_enabled',
		'type'            => 'select',
		'choices'         => explore_blog_get_post_choices(),
	)
);

// About Section - Content Type Page.
$wp_customize->add_setting(
	'explore_blog_about_content_page',
	array(
		'sanitize_callback' => 'absint',
	)
);

$wp_customize->add_control(
	'explore_blog_about_content_page',
	array(
		'label'           => esc_html__( 'Select Page', 'explore-blog' ),
		'section'         => 'explore_blog_about_section',
		'settings'        => 'explore_blog_about_content_page',
		'active_callback' => 'explore_blog_is_about_section_and_content_type_page_enabled',
		'type'            => 'select',
		'choices'         => explore_blog_get_page_choices(),
	)
);

// About Section - Button Label.
$wp_customize->add_setting(
	'explore_blog_about_button_label',
	array(
		'default'           => __( 'About Us', 'explore-blog' ),
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	'explore_blog_about_button_label',
	array(
		'label'           => esc_html__( 'Button Label', 'explore-blog' ),
		'section'         => 'explore_blog_about_section',
		'settings'        => 'explore_blog_about_button_label',
		'type'            => 'text',
		'active_callback' => 'explore_blog_is_about_section_enabled',
	)
);
