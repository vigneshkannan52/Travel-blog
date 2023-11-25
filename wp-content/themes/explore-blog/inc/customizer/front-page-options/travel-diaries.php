<?php
/**
 * Travel Diaries Section
 *
 * @package Explore_Blog
 */

$wp_customize->add_section(
	'explore_blog_travel_diaries_section',
	array(
		'panel' => 'explore_blog_front_page_options',
		'title' => esc_html__( 'Travel Diaries Section', 'explore-blog' ),
	)
);

// Travel Diaries Section - Enable Section.
$wp_customize->add_setting(
	'explore_blog_enable_travel_diaries_section',
	array(
		'default'           => false,
		'sanitize_callback' => 'explore_blog_sanitize_switch',
	)
);

$wp_customize->add_control(
	new Explore_Blog_Toggle_Switch_Custom_Control(
		$wp_customize,
		'explore_blog_enable_travel_diaries_section',
		array(
			'label'    => esc_html__( 'Enable Travel Diaries Section', 'explore-blog' ),
			'section'  => 'explore_blog_travel_diaries_section',
			'settings' => 'explore_blog_enable_travel_diaries_section',
		)
	)
);

if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial(
		'explore_blog_enable_travel_diaries_section',
		array(
			'selector' => '#explore_blog_travel_diaries_section .section-link',
			'settings' => 'explore_blog_enable_travel_diaries_section',
		)
	);
}

// Travel Diaries Section - Section Subtitle.
$wp_customize->add_setting(
	'explore_blog_travel_diaries_subtitle',
	array(
		'default'           => __( 'Life is a Journey', 'explore-blog' ),
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	'explore_blog_travel_diaries_subtitle',
	array(
		'label'           => esc_html__( 'Section Subtitle', 'explore-blog' ),
		'section'         => 'explore_blog_travel_diaries_section',
		'settings'        => 'explore_blog_travel_diaries_subtitle',
		'type'            => 'text',
		'active_callback' => 'explore_blog_is_travel_diaries_section_enabled',
	)
);

// Travel Diaries Section - Section Title.
$wp_customize->add_setting(
	'explore_blog_travel_diaries_title',
	array(
		'default'           => __( 'Travel Diaries', 'explore-blog' ),
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	'explore_blog_travel_diaries_title',
	array(
		'label'           => esc_html__( 'Section Title', 'explore-blog' ),
		'section'         => 'explore_blog_travel_diaries_section',
		'settings'        => 'explore_blog_travel_diaries_title',
		'type'            => 'text',
		'active_callback' => 'explore_blog_is_travel_diaries_section_enabled',
	)
);

// Travel Diaries Section - Number of Posts.
$wp_customize->add_setting(
	'explore_blog_travel_diaries_posts_count',
	array(
		'default'           => 3,
		'sanitize_callback' => 'explore_blog_sanitize_number_range',
		'validate_callback' => 'explore_blog_validate_diaries_posts_count',
	)
);

$wp_customize->add_control(
	'explore_blog_travel_diaries_posts_count',
	array(
		'label'           => esc_html__( 'Number of Posts', 'explore-blog' ),
		'description'     => esc_html__( 'Note: Min 1 | Max 6. Please input the valid number and save. Then refresh the page to see the change.', 'explore-blog' ),
		'section'         => 'explore_blog_travel_diaries_section',
		'settings'        => 'explore_blog_travel_diaries_posts_count',
		'type'            => 'number',
		'input_attrs'     => array(
			'min' => 1,
			'max' => 6,
		),
		'active_callback' => 'explore_blog_is_travel_diaries_section_enabled',
	)
);

// Travel Diaries Section - Post Button Label.
$wp_customize->add_setting(
	'explore_blog_travel_diaries_post_button_label',
	array(
		'default'           => __( 'Read More', 'explore-blog' ),
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	'explore_blog_travel_diaries_post_button_label',
	array(
		'label'           => esc_html__( 'Post Button Label', 'explore-blog' ),
		'section'         => 'explore_blog_travel_diaries_section',
		'settings'        => 'explore_blog_travel_diaries_post_button_label',
		'type'            => 'text',
		'active_callback' => 'explore_blog_is_travel_diaries_section_enabled',
	)
);

// Travel Diaries Section - Content Type.
$wp_customize->add_setting(
	'explore_blog_travel_diaries_content_type',
	array(
		'default'           => 'post',
		'sanitize_callback' => 'explore_blog_sanitize_select',
	)
);

$wp_customize->add_control(
	'explore_blog_travel_diaries_content_type',
	array(
		'label'           => esc_html__( 'Select Content Type', 'explore-blog' ),
		'section'         => 'explore_blog_travel_diaries_section',
		'settings'        => 'explore_blog_travel_diaries_content_type',
		'type'            => 'select',
		'active_callback' => 'explore_blog_is_travel_diaries_section_enabled',
		'choices'         => array(
			'post'     => esc_html__( 'Post', 'explore-blog' ),
			'category' => esc_html__( 'Category', 'explore-blog' ),
		),
	)
);

// List out selected number of fields.
$travel_diaries_count = get_theme_mod( 'explore_blog_travel_diaries_posts_count', 3 );

for ( $i = 1; $i <= $travel_diaries_count; $i++ ) {
	// Travel Diaries Section - Select Post.
	$wp_customize->add_setting(
		'explore_blog_travel_diaries_content_post_' . $i,
		array(
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'explore_blog_travel_diaries_content_post_' . $i,
		array(
			'label'           => sprintf( esc_html__( 'Select Post %d', 'explore-blog' ), $i ),
			'section'         => 'explore_blog_travel_diaries_section',
			'settings'        => 'explore_blog_travel_diaries_content_post_' . $i,
			'active_callback' => 'explore_blog_is_travel_diaries_section_and_content_type_post_enabled',
			'type'            => 'select',
			'choices'         => explore_blog_get_post_choices(),
		)
	);

}

// Travel Diaries Section - Select Category.
$wp_customize->add_setting(
	'explore_blog_travel_diaries_content_category',
	array(
		'sanitize_callback' => 'explore_blog_sanitize_select',
	)
);

$wp_customize->add_control(
	'explore_blog_travel_diaries_content_category',
	array(
		'label'           => esc_html__( 'Select Category', 'explore-blog' ),
		'section'         => 'explore_blog_travel_diaries_section',
		'settings'        => 'explore_blog_travel_diaries_content_category',
		'active_callback' => 'explore_blog_is_travel_diaries_section_and_content_type_category_enabled',
		'type'            => 'select',
		'choices'         => explore_blog_get_post_cat_choices(),
	)
);

// Travel Diaries Section - Button Label.
$wp_customize->add_setting(
	'explore_blog_travel_diaries_button_label',
	array(
		'default'           => __( 'Explore All Diaries', 'explore-blog' ),
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	'explore_blog_travel_diaries_button_label',
	array(
		'label'           => esc_html__( 'Button Label', 'explore-blog' ),
		'section'         => 'explore_blog_travel_diaries_section',
		'settings'        => 'explore_blog_travel_diaries_button_label',
		'type'            => 'text',
		'active_callback' => 'explore_blog_is_travel_diaries_section_enabled',
	)
);

// Travel Diaries Section - Button Link.
$wp_customize->add_setting(
	'explore_blog_travel_diaries_button_link',
	array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	)
);

$wp_customize->add_control(
	'explore_blog_travel_diaries_button_link',
	array(
		'label'           => esc_html__( 'Button Link', 'explore-blog' ),
		'section'         => 'explore_blog_travel_diaries_section',
		'settings'        => 'explore_blog_travel_diaries_button_link',
		'type'            => 'url',
		'active_callback' => 'explore_blog_is_travel_diaries_section_enabled',
	)
);
