<?php
/**
 * Categories Section
 *
 * @package Explore_Blog
 */

$wp_customize->add_section(
	'explore_blog_categories_section',
	array(
		'panel' => 'explore_blog_front_page_options',
		'title' => esc_html__( 'Categories Section', 'explore-blog' ),
	)
);

// Categories Section - Enable Section.
$wp_customize->add_setting(
	'explore_blog_enable_categories_section',
	array(
		'default'           => false,
		'sanitize_callback' => 'explore_blog_sanitize_switch',
	)
);

$wp_customize->add_control(
	new Explore_Blog_Toggle_Switch_Custom_Control(
		$wp_customize,
		'explore_blog_enable_categories_section',
		array(
			'label'    => esc_html__( 'Enable Categories Section', 'explore-blog' ),
			'section'  => 'explore_blog_categories_section',
			'settings' => 'explore_blog_enable_categories_section',
		)
	)
);

if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial(
		'explore_blog_enable_categories_section',
		array(
			'selector' => '#explore_blog_categories_section .section-link',
			'settings' => 'explore_blog_enable_categories_section',
		)
	);
}

// Categories Section - Background Image.
$wp_customize->add_setting(
	'explore_blog_categories_background_image',
	array(
		'sanitize_callback' => 'explore_blog_sanitize_image',
	)
);

$wp_customize->add_control(
	new WP_Customize_Image_Control(
		$wp_customize,
		'explore_blog_categories_background_image',
		array(
			'label'           => esc_html__( 'Background Image', 'explore-blog' ),
			'section'         => 'explore_blog_categories_section',
			'settings'        => 'explore_blog_categories_background_image',
			'active_callback' => 'explore_blog_is_categories_section_enabled',
		)
	)
);

// Categories Section - Section Title.
$wp_customize->add_setting(
	'explore_blog_categories_title',
	array(
		'default'           => __( 'Categories', 'explore-blog' ),
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	'explore_blog_categories_title',
	array(
		'label'           => esc_html__( 'Section Title', 'explore-blog' ),
		'section'         => 'explore_blog_categories_section',
		'settings'        => 'explore_blog_categories_title',
		'type'            => 'text',
		'active_callback' => 'explore_blog_is_categories_section_enabled',
	)
);

// Categories Section - Section Text.
$wp_customize->add_setting(
	'explore_blog_categories_text',
	array(
		'default'           => '',
		'sanitize_callback' => 'wp_kses_post',
	)
);

$wp_customize->add_control(
	'explore_blog_categories_text',
	array(
		'label'           => esc_html__( 'Section Text', 'explore-blog' ),
		'section'         => 'explore_blog_categories_section',
		'settings'        => 'explore_blog_categories_text',
		'type'            => 'textarea',
		'active_callback' => 'explore_blog_is_categories_section_enabled',
	)
);

for ( $i = 1; $i <= 6; $i++ ) {

	// Categories Section - Select Category.
	$wp_customize->add_setting(
		'explore_blog_categories_content_category_' . $i,
		array(
			'sanitize_callback' => 'explore_blog_sanitize_select',
		)
	);

	$wp_customize->add_control(
		'explore_blog_categories_content_category_' . $i,
		array(
			'label'           => sprintf( esc_html__( 'Select Category %d', 'explore-blog' ), $i ),
			'section'         => 'explore_blog_categories_section',
			'settings'        => 'explore_blog_categories_content_category_' . $i,
			'active_callback' => 'explore_blog_is_categories_section_enabled',
			'type'            => 'select',
			'choices'         => explore_blog_get_post_cat_choices(),
		)
	);

	// Categories Section - Category Image.
	$wp_customize->add_setting(
		'explore_blog_category_category_image_' . $i,
		array(
			'sanitize_callback' => 'explore_blog_sanitize_image',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'explore_blog_category_category_image_' . $i,
			array(
				'label'           => sprintf( esc_html__( 'Category Image %d', 'explore-blog' ), $i ),
				'section'         => 'explore_blog_categories_section',
				'settings'        => 'explore_blog_category_category_image_' . $i,
				'active_callback' => 'explore_blog_is_categories_section_enabled',
			)
		)
	);

}
