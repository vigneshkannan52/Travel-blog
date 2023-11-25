<?php
/**
 * Counter Section
 *
 * @package Explore_Blog
 */

$wp_customize->add_section(
	'explore_blog_counter_section',
	array(
		'panel' => 'explore_blog_front_page_options',
		'title' => esc_html__( 'Counter Section', 'explore-blog' ),
	)
);

// Counter Section - Enable Section.
$wp_customize->add_setting(
	'explore_blog_enable_counter_section',
	array(
		'default'           => false,
		'sanitize_callback' => 'explore_blog_sanitize_switch',
	)
);

$wp_customize->add_control(
	new Explore_Blog_Toggle_Switch_Custom_Control(
		$wp_customize,
		'explore_blog_enable_counter_section',
		array(
			'label'    => esc_html__( 'Enable Counter Section', 'explore-blog' ),
			'section'  => 'explore_blog_counter_section',
			'settings' => 'explore_blog_enable_counter_section',
		)
	)
);

if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial(
		'explore_blog_enable_counter_section',
		array(
			'selector' => '#explore_blog_counter_section .section-link',
			'settings' => 'explore_blog_enable_counter_section',
		)
	);
}

// Counter Section - Section Subtitle.
$wp_customize->add_setting(
	'explore_blog_counter_subtitle',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	'explore_blog_counter_subtitle',
	array(
		'label'           => esc_html__( 'Section Subtitle', 'explore-blog' ),
		'section'         => 'explore_blog_counter_section',
		'settings'        => 'explore_blog_counter_subtitle',
		'type'            => 'text',
		'active_callback' => 'explore_blog_is_counter_section_enabled',
	)
);

// Counter Section - Section Title.
$wp_customize->add_setting(
	'explore_blog_counter_title',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	'explore_blog_counter_title',
	array(
		'label'           => esc_html__( 'Section Title', 'explore-blog' ),
		'section'         => 'explore_blog_counter_section',
		'settings'        => 'explore_blog_counter_title',
		'type'            => 'text',
		'active_callback' => 'explore_blog_is_counter_section_enabled',
	)
);

// Counter Section - Background Image.
$wp_customize->add_setting(
	'explore_blog_counter_background_image',
	array(
		'sanitize_callback' => 'explore_blog_sanitize_image',
	)
);

$wp_customize->add_control(
	new WP_Customize_Image_Control(
		$wp_customize,
		'explore_blog_counter_background_image',
		array(
			'label'           => esc_html__( 'Background Image', 'explore-blog' ),
			'section'         => 'explore_blog_counter_section',
			'settings'        => 'explore_blog_counter_background_image',
			'active_callback' => 'explore_blog_is_counter_section_enabled',
		)
	)
);

for ( $i = 1; $i <= 4; $i++ ) {

	// Counter Section - Counter Icon.
	$wp_customize->add_setting(
		'explore_blog_counter_icon_' . $i,
		array(
			'sanitize_callback' => 'explore_blog_sanitize_image',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'explore_blog_counter_icon_' . $i,
			array(
				'label'           => sprintf( esc_html__( 'Icon %d', 'explore-blog' ), $i ),
				'section'         => 'explore_blog_counter_section',
				'settings'        => 'explore_blog_counter_icon_' . $i,
				'active_callback' => 'explore_blog_is_counter_section_enabled',
			)
		)
	);

	// Counter Section - Counter Label.
	$wp_customize->add_setting(
		'explore_blog_counter_label_' . $i,
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'explore_blog_counter_label_' . $i,
		array(
			'label'           => sprintf( esc_html__( 'Label %d', 'explore-blog' ), $i ),
			'section'         => 'explore_blog_counter_section',
			'settings'        => 'explore_blog_counter_label_' . $i,
			'type'            => 'text',
			'active_callback' => 'explore_blog_is_counter_section_enabled',
		)
	);

	// Counter Section - Counter Value.
	$wp_customize->add_setting(
		'explore_blog_counter_value_' . $i,
		array(
			'default'           => '',
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'explore_blog_counter_value_' . $i,
		array(
			'label'           => sprintf( esc_html__( 'Value %d', 'explore-blog' ), $i ),
			'section'         => 'explore_blog_counter_section',
			'settings'        => 'explore_blog_counter_value_' . $i,
			'type'            => 'number',
			'input_attrs'     => array( 'min' => 1 ),
			'active_callback' => 'explore_blog_is_counter_section_enabled',
		)
	);

	// Counter Section - Counter Suffix.
	$wp_customize->add_setting(
		'explore_blog_counter_value_suffix_' . $i,
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'explore_blog_counter_value_suffix_' . $i,
		array(
			'label'           => sprintf( esc_html__( 'Value Suffix %d', 'explore-blog' ), $i ),
			'section'         => 'explore_blog_counter_section',
			'settings'        => 'explore_blog_counter_value_suffix_' . $i,
			'type'            => 'text',
			'active_callback' => 'explore_blog_is_counter_section_enabled',
		)
	);

	// Counter Section - Horizontal Line.
	$wp_customize->add_setting(
		'explore_blog_counter_horizontal_line_' . $i,
		array(
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		new Explore_Blog_Customize_Horizontal_Line(
			$wp_customize,
			'explore_blog_counter_horizontal_line_' . $i,
			array(
				'section'         => 'explore_blog_counter_section',
				'settings'        => 'explore_blog_counter_horizontal_line_' . $i,
				'active_callback' => 'explore_blog_is_counter_section_enabled',
				'type'            => 'hr',
			)
		)
	);

}
