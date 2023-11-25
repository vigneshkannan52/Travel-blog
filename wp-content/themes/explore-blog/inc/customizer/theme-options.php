<?php
/**
 * Theme Options
 *
 * @package Explore_Blog
 */

$wp_customize->add_panel(
	'explore_blog_theme_options',
	array(
		'title'    => esc_html__( 'Theme Options', 'explore-blog' ),
		'priority' => 130,
	)
);

// Header Options.
require get_template_directory() . '/inc/customizer/theme-options/header-options.php';

// Breadcrumb Options.
require get_template_directory() . '/inc/customizer/theme-options/breadcrumb.php';

// Typography.
require get_template_directory() . '/inc/customizer/theme-options/typography.php';

// Excerpt.
require get_template_directory() . '/inc/customizer/theme-options/excerpt.php';

// Archive Layout.
require get_template_directory() . '/inc/customizer/theme-options/archive-layout.php';

// Layout.
require get_template_directory() . '/inc/customizer/theme-options/sidebar-layout.php';

// Post Options.
require get_template_directory() . '/inc/customizer/theme-options/post-options.php';

// Pagination.
require get_template_directory() . '/inc/customizer/theme-options/pagination.php';

// Footer Options.
require get_template_directory() . '/inc/customizer/theme-options/footer-options.php';
