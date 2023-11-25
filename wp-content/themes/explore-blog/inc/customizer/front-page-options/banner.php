<?php
/**
 * Banner Section
 *
 * @package Explore_BLog
 */

$wp_customize->add_section(
	'explore_blog_banner_section',
	array(
		'panel' => 'explore_blog_front_page_options',
		'title' => esc_html__( 'Banner Section', 'explore-blog' ),
	)
);

// Banner Section - Enable Section.
$wp_customize->add_setting(
	'explore_blog_enable_banner_section',
	array(
		'default'           => false,
		'sanitize_callback' => 'explore_blog_sanitize_switch',
	)
);

$wp_customize->add_control(
	new Explore_Blog_Toggle_Switch_Custom_Control(
		$wp_customize,
		'explore_blog_enable_banner_section',
		array(
			'label'    => esc_html__( 'Enable Banner Section', 'explore-blog' ),
			'section'  => 'explore_blog_banner_section',
			'settings' => 'explore_blog_enable_banner_section',
		)
	)
);

if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial(
		'explore_blog_enable_banner_section',
		array(
			'selector' => '#explore_blog_banner_section .section-link',
			'settings' => 'explore_blog_enable_banner_section',
		)
	);
}

// Banner Section - Content Type.
$wp_customize->add_setting(
	'explore_blog_banner_content_type',
	array(
		'default'           => 'post',
		'sanitize_callback' => 'explore_blog_sanitize_select',
	)
);

$wp_customize->add_control(
	'explore_blog_banner_content_type',
	array(
		'label'           => esc_html__( 'Select Content Type', 'explore-blog' ),
		'section'         => 'explore_blog_banner_section',
		'settings'        => 'explore_blog_banner_content_type',
		'type'            => 'select',
		'active_callback' => 'explore_blog_is_banner_section_enabled',
		'choices'         => explore_blog_get_banner_content_type_choices(),
	)
);

// Banner Section - Number of Slides.
$wp_customize->add_setting(
	'explore_blog_banner_slide_count',
	array(
		'default'           => 3,
		'sanitize_callback' => 'explore_blog_sanitize_number_range',
		'validate_callback' => 'explore_blog_validate_slide_count',
	)
);

$wp_customize->add_control(
	'explore_blog_banner_slide_count',
	array(
		'label'           => esc_html__( 'Number of Slides', 'explore-blog' ),
		'description'     => esc_html__( 'Note: Min 1 | Max 3. Please input the valid number and save. Then refresh the page to see the change.', 'explore-blog' ),
		'section'         => 'explore_blog_banner_section',
		'settings'        => 'explore_blog_banner_slide_count',
		'type'            => 'number',
		'input_attrs'     => array(
			'min' => 1,
			'max' => 3,
		),
		'active_callback' => 'explore_blog_is_banner_section_enabled',
	)
);

	// Banner Section - Button Label.
$wp_customize->add_setting(
	'explore_blog_banner_button_label',
	array(
		'default'           => __( 'Explore Now', 'explore-blog' ),
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	'explore_blog_banner_button_label',
	array(
		'label'           => esc_html__( 'Button Label', 'explore-blog' ),
		'section'         => 'explore_blog_banner_section',
		'settings'        => 'explore_blog_banner_button_label',
		'type'            => 'text',
		'active_callback' => 'explore_blog_is_banner_section_enabled',
	)
);

	// List out selected number of fields.
$slide_count = get_theme_mod( 'explore_blog_banner_slide_count', 3 );

for ( $i = 1; $i <= $slide_count; $i++ ) {

		// Banner Section - Subtitle.
	$wp_customize->add_setting(
		'explore_blog_banner_subtitle_' . $i,
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'explore_blog_banner_subtitle_' . $i,
		array(
			'label'           => sprintf( esc_html__( 'Subtitle %d', 'explore-blog' ), $i ),
			'section'         => 'explore_blog_banner_section',
			'settings'        => 'explore_blog_banner_subtitle_' . $i,
			'type'            => 'text',
			'active_callback' => 'explore_blog_is_banner_section_enabled',
		)
	);

		// Banner Section - Content Type Post.
	$wp_customize->add_setting(
		'explore_blog_banner_content_post_' . $i,
		array(
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'explore_blog_banner_content_post_' . $i,
		array(
			'label'           => sprintf( esc_html__( 'Select Post %d', 'explore-blog' ), $i ),
			'section'         => 'explore_blog_banner_section',
			'settings'        => 'explore_blog_banner_content_post_' . $i,
			'active_callback' => 'explore_blog_is_banner_section_and_content_type_post_enabled',
			'type'            => 'select',
			'choices'         => explore_blog_get_post_choices(),
		)
	);

		// Banner Section - Content Type Trip.
	$wp_customize->add_setting(
		'explore_blog_banner_content_trip_' . $i,
		array(
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'explore_blog_banner_content_trip_' . $i,
		array(
			'label'           => sprintf( esc_html__( 'Select Trip %d', 'explore-blog' ), $i ),
			'section'         => 'explore_blog_banner_section',
			'settings'        => 'explore_blog_banner_content_trip_' . $i,
			'active_callback' => 'explore_blog_is_banner_section_and_content_type_trip_enabled',
			'type'            => 'select',
			'choices'         => explore_blog_get_trip_choices(),
		)
	);

		// Banner Section - Horizontal Line.
	$wp_customize->add_setting(
		'explore_blog_banner_horizontal_line_' . $i,
		array(
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		new Explore_Blog_Customize_Horizontal_Line(
			$wp_customize,
			'explore_blog_banner_horizontal_line_' . $i,
			array(
				'section'         => 'explore_blog_banner_section',
				'settings'        => 'explore_blog_banner_horizontal_line_' . $i,
				'active_callback' => 'explore_blog_is_banner_section_enabled',
				'type'            => 'hr',
			)
		)
	);

}
