<?php
/**
 * Active Callbacks
 *
 * @package Explore_Blog
 */

// Topbar Section.
function explore_blog_is_topbar_enabled( $control ) {
	return ( $control->manager->get_setting( 'explore_blog_enable_topbar' )->value() );
}

// Breadcrumb.
function explore_blog_is_breadcrumb_enabled( $control ) {
	return ( $control->manager->get_setting( 'explore_blog_enable_breadcrumb' )->value() );
}

// Pagination.
function explore_blog_is_pagination_enabled( $control ) {
	return ( $control->manager->get_setting( 'explore_blog_enable_pagination' )->value() );
}

// Banner section.
function explore_blog_is_banner_section_enabled( $control ) {
	return ( $control->manager->get_setting( 'explore_blog_enable_banner_section' )->value() );
}
function explore_blog_is_banner_section_and_content_type_post_enabled( $control ) {
	$content_type = $control->manager->get_setting( 'explore_blog_banner_content_type' )->value();
	return ( explore_blog_is_banner_section_enabled( $control ) && ( 'post' === $content_type ) );
}
function explore_blog_is_banner_section_and_content_type_page_enabled( $control ) {
	$content_type = $control->manager->get_setting( 'explore_blog_banner_content_type' )->value();
	return ( explore_blog_is_banner_section_enabled( $control ) && ( 'page' === $content_type ) );
}
function explore_blog_is_banner_section_and_content_type_trip_enabled( $control ) {
	$content_type = $control->manager->get_setting( 'explore_blog_banner_content_type' )->value();
	return ( explore_blog_is_banner_section_enabled( $control ) && ( 'itineraries' === $content_type ) );
}

// Brands Section.
function explore_blog_is_brands_section_enabled( $control ) {
	return ( $control->manager->get_setting( 'explore_blog_enable_brands_section' )->value() );
}

// About section.
function explore_blog_is_about_section_enabled( $control ) {
	return ( $control->manager->get_setting( 'explore_blog_enable_about_section' )->value() );
}
function explore_blog_is_about_section_and_content_type_post_enabled( $control ) {
	$content_type = $control->manager->get_setting( 'explore_blog_about_content_type' )->value();
	return ( explore_blog_is_about_section_enabled( $control ) && ( 'post' === $content_type ) );
}
function explore_blog_is_about_section_and_content_type_page_enabled( $control ) {
	$content_type = $control->manager->get_setting( 'explore_blog_about_content_type' )->value();
	return ( explore_blog_is_about_section_enabled( $control ) && ( 'page' === $content_type ) );
}

// Trending Article Section.
function explore_blog_is_trending_article_section_enabled( $control ) {
	return ( $control->manager->get_setting( 'explore_blog_enable_trending_article_section' )->value() );
}
function explore_blog_is_trending_article_section_and_content_type_post_enabled( $control ) {
	$content_type = $control->manager->get_setting( 'explore_blog_trending_article_content_type' )->value();
	return ( explore_blog_is_trending_article_section_enabled( $control ) && ( 'post' === $content_type ) );
}
function explore_blog_is_trending_article_section_and_content_type_category_enabled( $control ) {
	$content_type = $control->manager->get_setting( 'explore_blog_trending_article_content_type' )->value();
	return ( explore_blog_is_trending_article_section_enabled( $control ) && ( 'category' === $content_type ) );
}
function explore_blog_is_trending_article_section_and_content_type_trip_enabled( $control ) {
	$content_type = $control->manager->get_setting( 'explore_blog_trending_article_content_type' )->value();
	return ( explore_blog_is_trending_article_section_enabled( $control ) && ( 'itineraries' === $content_type ) );
}

// Counter section.
function explore_blog_is_counter_section_enabled( $control ) {
	return ( $control->manager->get_setting( 'explore_blog_enable_counter_section' )->value() );
}

// Travel Diaries Section.
function explore_blog_is_travel_diaries_section_enabled( $control ) {
	return ( $control->manager->get_setting( 'explore_blog_enable_travel_diaries_section' )->value() );
}
function explore_blog_is_travel_diaries_section_and_content_type_post_enabled( $control ) {
	$content_type = $control->manager->get_setting( 'explore_blog_travel_diaries_content_type' )->value();
	return ( explore_blog_is_travel_diaries_section_enabled( $control ) && ( 'post' === $content_type ) );
}
function explore_blog_is_travel_diaries_section_and_content_type_category_enabled( $control ) {
	$content_type = $control->manager->get_setting( 'explore_blog_travel_diaries_content_type' )->value();
	return ( explore_blog_is_travel_diaries_section_enabled( $control ) && ( 'category' === $content_type ) );
}

// Categories section.
function explore_blog_is_categories_section_enabled( $control ) {
	return ( $control->manager->get_setting( 'explore_blog_enable_categories_section' )->value() );
}

// Check if static home page is enabled.
function explore_blog_is_static_homepage_enabled( $control ) {
	return ( 'page' === $control->manager->get_setting( 'show_on_front' )->value() );
}
