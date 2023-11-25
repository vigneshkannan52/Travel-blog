<?php
/**
 * Trending Article Section
 *
 * @package Explore_Blog
 */

$wp_customize->add_section(
	'explore_blog_trending_article_section',
	array(
		'panel' => 'explore_blog_front_page_options',
		'title' => esc_html__( 'Trending Article Section', 'explore-blog' ),
	)
);

// Trending Article Section - Enable Section.
$wp_customize->add_setting(
	'explore_blog_enable_trending_article_section',
	array(
		'default'           => false,
		'sanitize_callback' => 'explore_blog_sanitize_switch',
	)
);

$wp_customize->add_control(
	new Explore_Blog_Toggle_Switch_Custom_Control(
		$wp_customize,
		'explore_blog_enable_trending_article_section',
		array(
			'label'    => esc_html__( 'Enable Trending Article Section', 'explore-blog' ),
			'section'  => 'explore_blog_trending_article_section',
			'settings' => 'explore_blog_enable_trending_article_section',
		)
	)
);

if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial(
		'explore_blog_enable_trending_article_section',
		array(
			'selector' => '#explore_blog_trending_article_section .section-link',
			'settings' => 'explore_blog_enable_trending_article_section',
		)
	);
}

// Trending Article Section - Background Image.
$wp_customize->add_setting(
	'explore_blog_trending_article_background_image',
	array(
		'sanitize_callback' => 'explore_blog_sanitize_image',
	)
);

$wp_customize->add_control(
	new WP_Customize_Image_Control(
		$wp_customize,
		'explore_blog_trending_article_background_image',
		array(
			'label'           => esc_html__( 'Background Image', 'explore-blog' ),
			'section'         => 'explore_blog_trending_article_section',
			'settings'        => 'explore_blog_trending_article_background_image',
			'active_callback' => 'explore_blog_is_trending_article_section_enabled',
		)
	)
);

// Trending Article Section - Section Subtitle.
$wp_customize->add_setting(
	'explore_blog_trending_article_subtitle',
	array(
		'default'           => __( 'Trending Articles', 'explore-blog' ),
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	'explore_blog_trending_article_subtitle',
	array(
		'label'           => esc_html__( 'Section Subtitle', 'explore-blog' ),
		'section'         => 'explore_blog_trending_article_section',
		'settings'        => 'explore_blog_trending_article_subtitle',
		'type'            => 'text',
		'active_callback' => 'explore_blog_is_trending_article_section_enabled',
	)
);

// Trending Article Section - Section Title.
$wp_customize->add_setting(
	'explore_blog_trending_article_title',
	array(
		'default'           => __( 'Discover the Stories', 'explore-blog' ),
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	'explore_blog_trending_article_title',
	array(
		'label'           => esc_html__( 'Section Title', 'explore-blog' ),
		'section'         => 'explore_blog_trending_article_section',
		'settings'        => 'explore_blog_trending_article_title',
		'type'            => 'text',
		'active_callback' => 'explore_blog_is_trending_article_section_enabled',
	)
);

// Trending Article Section - Post Button Label.
$wp_customize->add_setting(
	'explore_blog_trending_article_post_button_label',
	array(
		'default'           => __( 'Read More', 'explore-blog' ),
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	'explore_blog_trending_article_post_button_label',
	array(
		'label'           => esc_html__( 'Post Button Label', 'explore-blog' ),
		'section'         => 'explore_blog_trending_article_section',
		'settings'        => 'explore_blog_trending_article_post_button_label',
		'type'            => 'text',
		'active_callback' => 'explore_blog_is_trending_article_section_enabled',
	)
);

// Trending Article Section - Content Type.
$wp_customize->add_setting(
	'explore_blog_trending_article_content_type',
	array(
		'default'           => 'post',
		'sanitize_callback' => 'explore_blog_sanitize_select',
	)
);

$wp_customize->add_control(
	'explore_blog_trending_article_content_type',
	array(
		'label'           => esc_html__( 'Select Content Type', 'explore-blog' ),
		'section'         => 'explore_blog_trending_article_section',
		'settings'        => 'explore_blog_trending_article_content_type',
		'type'            => 'select',
		'active_callback' => 'explore_blog_is_trending_article_section_enabled',
		'choices'         => explore_blog_get_trending_article_content_type_choices(),
	)
);

for ( $i = 1; $i <= 5; $i++ ) {
	// Trending Article Section - Select Post.
	$wp_customize->add_setting(
		'explore_blog_trending_article_content_post_' . $i,
		array(
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'explore_blog_trending_article_content_post_' . $i,
		array(
			'label'           => sprintf( esc_html__( 'Select Post %d', 'explore-blog' ), $i ),
			'section'         => 'explore_blog_trending_article_section',
			'settings'        => 'explore_blog_trending_article_content_post_' . $i,
			'active_callback' => 'explore_blog_is_trending_article_section_and_content_type_post_enabled',
			'type'            => 'select',
			'choices'         => explore_blog_get_post_choices(),
		)
	);

	// Trending Article Section - Select Trip.
	$wp_customize->add_setting(
		'explore_blog_trending_article_content_trip_' . $i,
		array(
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		'explore_blog_trending_article_content_trip_' . $i,
		array(
			'label'           => sprintf( esc_html__( 'Select Trip %d', 'explore-blog' ), $i ),
			'section'         => 'explore_blog_trending_article_section',
			'settings'        => 'explore_blog_trending_article_content_trip_' . $i,
			'active_callback' => 'explore_blog_is_trending_article_section_and_content_type_trip_enabled',
			'type'            => 'select',
			'choices'         => explore_blog_get_trip_choices(),
		)
	);

}

// Trending Article Section - Select Category.
$wp_customize->add_setting(
	'explore_blog_trending_article_content_category',
	array(
		'sanitize_callback' => 'explore_blog_sanitize_select',
	)
);

$wp_customize->add_control(
	'explore_blog_trending_article_content_category',
	array(
		'label'           => esc_html__( 'Select Category', 'explore-blog' ),
		'section'         => 'explore_blog_trending_article_section',
		'settings'        => 'explore_blog_trending_article_content_category',
		'active_callback' => 'explore_blog_is_trending_article_section_and_content_type_category_enabled',
		'type'            => 'select',
		'choices'         => explore_blog_get_post_cat_choices(),
	)
);

// Trending Article Section - View All Button Label.
$wp_customize->add_setting(
	'explore_blog_trending_article_button_label',
	array(
		'default'           => __( 'View all', 'explore-blog' ),
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	'explore_blog_trending_article_button_label',
	array(
		'label'           => esc_html__( 'Button Label', 'explore-blog' ),
		'section'         => 'explore_blog_trending_article_section',
		'settings'        => 'explore_blog_trending_article_button_label',
		'type'            => 'text',
		'active_callback' => 'explore_blog_is_trending_article_section_enabled',
	)
);

// Trending Article Section - View All Button Link.
$wp_customize->add_setting(
	'explore_blog_trending_article_button_link',
	array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	)
);

$wp_customize->add_control(
	'explore_blog_trending_article_button_link',
	array(
		'label'           => esc_html__( 'Button Link', 'explore-blog' ),
		'section'         => 'explore_blog_trending_article_section',
		'settings'        => 'explore_blog_trending_article_button_link',
		'type'            => 'url',
		'active_callback' => 'explore_blog_is_trending_article_section_enabled',
	)
);
