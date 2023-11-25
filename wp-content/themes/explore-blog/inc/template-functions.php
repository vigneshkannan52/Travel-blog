<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Explore_Blog
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function explore_blog_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	$classes[] = explore_blog_sidebar_layout();

	return $classes;
}
add_filter( 'body_class', 'explore_blog_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function explore_blog_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'explore_blog_pingback_header' );

/**
 * Get all posts for customizer Post content type.
 */
function explore_blog_get_post_choices() {
	$choices = array( '' => esc_html__( '--Select--', 'explore-blog' ) );
	$args    = array( 'numberposts' => -1 );
	$posts   = get_posts( $args );

	foreach ( $posts as $post ) {
		$id             = $post->ID;
		$title          = $post->post_title;
		$choices[ $id ] = $title;
	}

	return $choices;
}

/**
 * Get all pages for customizer Page content type.
 */
function explore_blog_get_page_choices() {
	$choices = array( '' => esc_html__( '--Select--', 'explore-blog' ) );
	$pages   = get_pages();

	foreach ( $pages as $page ) {
		$choices[ $page->ID ] = $page->post_title;
	}

	return $choices;
}

/**
 * Get all categories for customizer Category content type.
 */
function explore_blog_get_post_cat_choices() {
	$choices = array( '' => esc_html__( '--Select--', 'explore-blog' ) );
	$cats    = get_categories();

	foreach ( $cats as $cat ) {
		$choices[ $cat->term_id ] = $cat->name;
	}

	return $choices;
}

/**
 * Get all trips for customizer Trip content type.
 */
function explore_blog_get_trip_choices() {
	$choices = array( '' => esc_html__( '--Select--', 'explore-blog' ) );
	$posts   = get_posts(
		array(
			'post_type'   => 'itineraries',
			'numberposts' => -1,
		)
	);
	foreach ( $posts as $post ) {
		$choices[ $post->ID ] = $post->post_title;
	}
	return $choices;
}

/**
 * Get list for Banner content type choices
 */
function explore_blog_get_banner_content_type_choices() {
	$banner_choices = array(
		'post' => esc_html__( 'Post', 'explore-blog' ),
	);

	if ( class_exists( 'WP_Travel' ) ) {
		$banner_choices = array_merge(
			$banner_choices,
			array(
				'itineraries' => esc_html__( 'Trip', 'explore-blog' ),
			)
		);
	}

	return $banner_choices;
}

/**
 * Get list for Trending Article content type choices
 */
function explore_blog_get_trending_article_content_type_choices() {
	$trending_article_choices = array(
		'post'     => esc_html__( 'Post', 'explore-blog' ),
		'category' => esc_html__( 'Category', 'explore-blog' ),
	);

	if ( class_exists( 'WP_Travel' ) ) {
		$trending_article_choices = array_merge(
			$trending_article_choices,
			array(
				'itineraries' => esc_html__( 'Trip', 'explore-blog' ),
			)
		);
	}

	return $trending_article_choices;
}

if ( ! function_exists( 'explore_blog_excerpt_length' ) ) :
	/**
	 * Excerpt length.
	 */
	function explore_blog_excerpt_length( $length ) {
		if ( is_admin() ) {
			return $length;
		}

		return get_theme_mod( 'explore_blog_excerpt_length', 20 );
	}
endif;
add_filter( 'excerpt_length', 'explore_blog_excerpt_length', 999 );

if ( ! function_exists( 'explore_blog_excerpt_more' ) ) :
	/**
	 * Excerpt more.
	 */
	function explore_blog_excerpt_more( $more ) {
		if ( is_admin() ) {
			return $more;
		}

		return '&hellip;';
	}
endif;
add_filter( 'excerpt_more', 'explore_blog_excerpt_more' );

if ( ! function_exists( 'explore_blog_sidebar_layout' ) ) {
	/**
	 * Get sidebar layout.
	 */
	function explore_blog_sidebar_layout() {
		$sidebar_position      = get_theme_mod( 'explore_blog_sidebar_position', 'right-sidebar' );
		$sidebar_position_post = get_theme_mod( 'explore_blog_post_sidebar_position', 'right-sidebar' );
		$sidebar_position_page = get_theme_mod( 'explore_blog_page_sidebar_position', 'right-sidebar' );

		if ( is_single() ) {
			$sidebar_position = $sidebar_position_post;
		} elseif ( is_page() ) {
			$sidebar_position = $sidebar_position_page;
		}

		return $sidebar_position;
	}
}

if ( ! function_exists( 'explore_blog_is_sidebar_enabled' ) ) {
	/**
	 * Check if sidebar is enabled.
	 */
	function explore_blog_is_sidebar_enabled() {
		$sidebar_position      = get_theme_mod( 'explore_blog_sidebar_position', 'right-sidebar' );
		$sidebar_position_post = get_theme_mod( 'explore_blog_post_sidebar_position', 'right-sidebar' );
		$sidebar_position_page = get_theme_mod( 'explore_blog_page_sidebar_position', 'right-sidebar' );

		$sidebar_enabled = true;
		if ( is_home() || is_archive() || is_search() ) {
			if ( 'no-sidebar' === $sidebar_position ) {
				$sidebar_enabled = false;
			}
		} elseif ( is_single() ) {
			if ( 'no-sidebar' === $sidebar_position || 'no-sidebar' === $sidebar_position_post ) {
				$sidebar_enabled = false;
			}
		} elseif ( is_page() ) {
			if ( 'no-sidebar' === $sidebar_position || 'no-sidebar' === $sidebar_position_page ) {
				$sidebar_enabled = false;
			}
		}
		return $sidebar_enabled;
	}
}

if ( ! function_exists( 'explore_blog_get_homepage_sections ' ) ) {
	/**
	 * Returns homepage sections.
	 */
	function explore_blog_get_homepage_sections() {
		$sections = array(
			'banner'           => esc_html__( 'Banner Section', 'explore-blog' ),
			'brands'           => esc_html__( 'Brands Section', 'explore-blog' ),
			'about'            => esc_html__( 'About Section', 'explore-blog' ),
			'trending-article' => esc_html__( 'Trending Article Section', 'explore-blog' ),
			'counter'          => esc_html__( 'Counter Section', 'explore-blog' ),
			'travel-diaries'   => esc_html__( 'Travel Diaries Section', 'explore-blog' ),
			'categories'       => esc_html__( 'Categories Section', 'explore-blog' ),
		);
		return $sections;
	}
}

function explore_blog_section_link( $section_id ) {
	$section_name      = str_replace( 'explore_blog_', ' ', $section_id );
	$section_name      = str_replace( '_', ' ', $section_name );
	$starting_notation = '#';
	?>
	<span class="section-link">
		<span class="section-link-title"><?php echo esc_html( $section_name ); ?></span>
	</span>
	<style type="text/css">
		<?php echo $starting_notation . $section_id; ?>:hover .section-link {
			visibility: visible;
		}
	</style>
	<?php
}

function explore_blog_section_link_css() {
	if ( is_customize_preview() ) {
		?>
		<style type="text/css">
			.section-link {
				visibility: hidden;
				background-color: black;
				position: relative;
				top: 80px;
				z-index: 99;
				left: 40px;
				color: #fff;
				text-align: center;
				font-size: 20px;
				border-radius: 10px;
				padding: 20px 10px;
				text-transform: capitalize;
			}
			.section-link-title {
				padding: 0 10px;
			}
		</style>
		<?php
	}
}
add_action( 'wp_head', 'explore_blog_section_link_css' );

/**
 * Breadcrumb.
 */
function explore_blog_breadcrumb( $args = array() ) {
	if ( ! get_theme_mod( 'explore_blog_enable_breadcrumb', true ) ) {
		return;
	}

	$args = array(
		'show_on_front' => false,
		'show_title'    => true,
		'show_browse'   => false,
	);
	breadcrumb_trail( $args );
}
add_action( 'explore_blog_breadcrumb', 'explore_blog_breadcrumb', 10 );

/**
 * Add separator for breadcrumb trail.
 */
function explore_blog_breadcrumb_trail_print_styles() {
	$breadcrumb_separator = get_theme_mod( 'explore_blog_breadcrumb_separator', '/' );

	$style = '
	.trail-items li::after {
		content: "' . esc_attr( $breadcrumb_separator ) . '";
	}';

	$style = apply_filters( 'explore_blog_breadcrumb_trail_inline_style', trim( str_replace( array( "\r", "\n", "\t", '  ' ), '', $style ) ) );

	if ( $style ) {
		echo "\n" . '<style type="text/css" id="breadcrumb-trail-css">' . $style . '</style>' . "\n";
	}
}
add_action( 'wp_head', 'explore_blog_breadcrumb_trail_print_styles' );

/**
 * Pagination for archive.
 */
function explore_blog_render_posts_pagination() {
	$is_pagination_enabled = get_theme_mod( 'explore_blog_enable_pagination', true );
	if ( $is_pagination_enabled ) {
		$pagination_type = get_theme_mod( 'explore_blog_pagination_type', 'default' );
		if ( 'default' === $pagination_type ) :
			the_posts_navigation();
		else :
			the_posts_pagination();
		endif;
	}
}
add_action( 'explore_blog_posts_pagination', 'explore_blog_render_posts_pagination', 10 );

/**
 * Pagination for single post.
 */
function explore_blog_render_post_navigation() {
	the_post_navigation(
		array(
			'prev_text' => '<span>&#10229;</span> <span class="nav-title">%title</span>',
			'next_text' => '<span class="nav-title">%title</span> <span>&#10230;</span>',
		)
	);
}
add_action( 'explore_blog_post_navigation', 'explore_blog_render_post_navigation' );

/**
 * Excerpt Length Validation.
 */
if ( ! function_exists( 'explore_blog_validate_excerpt_length' ) ) :
	function explore_blog_validate_excerpt_length( $validity, $value ) {
		$value = intval( $value );
		if ( empty( $value ) || ! is_numeric( $value ) ) {
			$validity->add( 'required', esc_html__( 'You must supply a valid number.', 'explore-blog' ) );
		} elseif ( $value < 1 ) {
			$validity->add( 'min_no_of_words', esc_html__( 'Minimum no of words is 1', 'explore-blog' ) );
		} elseif ( $value > 100 ) {
			$validity->add( 'max_no_of_words', esc_html__( 'Maximum no of words is 100', 'explore-blog' ) );
		}
		return $validity;
	}
endif;

if ( ! function_exists( 'explore_blog_validate_slide_count' ) ) :
	function explore_blog_validate_slide_count( $validity, $value ) {
		$value = intval( $value );
		if ( empty( $value ) || ! is_numeric( $value ) ) {
			$validity->add( 'required', esc_html__( 'You must supply a valid number.', 'explore-blog' ) );
		} elseif ( $value < 1 ) {
			$validity->add( 'min_no_of_posts', esc_html__( 'Minimum no of Post is 1', 'explore-blog' ) );
		} elseif ( $value > 3 ) {
			$validity->add( 'max_no_of_posts', esc_html__( 'Maximum no of Posts is 3', 'explore-blog' ) );
		}
		return $validity;
	}
endif;

if ( ! function_exists( 'explore_blog_validate_diaries_posts_count' ) ) :
	function explore_blog_validate_diaries_posts_count( $validity, $value ) {
		$value = intval( $value );
		if ( empty( $value ) || ! is_numeric( $value ) ) {
			$validity->add( 'required', esc_html__( 'You must supply a valid number.', 'explore-blog' ) );
		} elseif ( $value < 1 ) {
			$validity->add( 'min_no_of_posts', esc_html__( 'Minimum no of Post is 1', 'explore-blog' ) );
		} elseif ( $value > 6 ) {
			$validity->add( 'max_no_of_posts', esc_html__( 'Maximum no of Posts is 6', 'explore-blog' ) );
		}
		return $validity;
	}
endif;

/**
 * Adds footer copyright text.
 */
function explore_blog_output_footer_copyright_content() {
	$theme_data = wp_get_theme();
	$search     = array( '[the-year]', '[site-link]' );
	$replace    = array( date( 'Y' ), '<a href="' . esc_url( home_url( '/' ) ) . '">' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '</a>' );
	/* translators: 1: Year, 2: Site Title with home URL. */
	$copyright_default = sprintf( esc_html_x( 'Copyright &copy; %1$s %2$s', '1: Year, 2: Site Title with home URL', 'explore-blog' ), '[the-year]', '[site-link]' );
	$copyright_text    = get_theme_mod( 'explore_blog_footer_copyright_text', $copyright_default );
	$copyright_text    = str_replace( $search, $replace, $copyright_text );
	$copyright_text   .= esc_html( ' | ' . $theme_data->get( 'Name' ) ) . '&nbsp;' . esc_html__( 'by', 'explore-blog' ) . '&nbsp;<a target="_blank" href="' . esc_url( $theme_data->get( 'AuthorURI' ) ) . '">' . esc_html( ucwords( $theme_data->get( 'Author' ) ) ) . '</a>';
	/* translators: %s: WordPress.org URL */
	$copyright_text .= sprintf( esc_html__( ' | Powered by %s', 'explore-blog' ), '<a href="' . esc_url( __( 'https://wordpress.org/', 'explore-blog' ) ) . '" target="_blank">WordPress</a>. ' );
	?>
	<div class="site-info">
		<span><?php echo wp_kses_post( $copyright_text ); ?></span>					
	</div>
	<?php
}
add_action( 'explore_blog_footer_copyright', 'explore_blog_output_footer_copyright_content' );
