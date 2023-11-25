<?php
/**
 * Front Page Options
 *
 * @package Explore_BLog
 */

$wp_customize->add_panel(
	'explore_blog_front_page_options',
	array(
		'title'    => esc_html__( 'Front Page Options', 'explore-blog' ),
		'priority' => 130,
	)
);

// Banner Section.
require get_template_directory() . '/inc/customizer/front-page-options/banner.php';

// Brands Section.
require get_template_directory() . '/inc/customizer/front-page-options/brands.php';

// About Us Section.
require get_template_directory() . '/inc/customizer/front-page-options/about.php';

// Trending Article Section.
require get_template_directory() . '/inc/customizer/front-page-options/trending-article.php';

// Counter Section.
require get_template_directory() . '/inc/customizer/front-page-options/counter.php';

// Travel Diaries Section.
require get_template_directory() . '/inc/customizer/front-page-options/travel-diaries.php';

// Categories Section.
require get_template_directory() . '/inc/customizer/front-page-options/categories.php';
