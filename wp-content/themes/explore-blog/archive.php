<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Explore_Blog
 */

get_header();

$column_layout = get_theme_mod( 'explore_blog_archive_grid_column', 'column-2' );

?>

<main id="primary" class="site-main">
	<section class="header-banner">
		<?php do_action( 'explore_blog_breadcrumb' ); ?>
		<header class="page-header">
			<?php
			the_archive_title( '<h1 class="page-title">', '</h1>' );
			the_archive_description( '<div class="archive-description">', '</div>' );
			?>
		</header><!-- .page-header -->
	</section>
	<div class="archive-layout grid-style <?php echo esc_attr( $column_layout ); ?>">
		<?php if ( have_posts() ) : ?>
			<?php
			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				/*
				* Include the Post-Type-specific template for the content.
				* If you want to override this in a child theme, then include a file
				* called content-___.php (where ___ is the Post Type name) and that will be used instead.
				*/
				get_template_part( 'template-parts/content', get_post_type() );
		endwhile;
			?>
	</div>
			<?php
			do_action( 'explore_blog_posts_pagination' );
	else :
		get_template_part( 'template-parts/content', 'none' );
	endif;
	?>
</main><!-- #main -->

<?php
if ( explore_blog_is_sidebar_enabled() ) {
	get_sidebar();
}

get_footer();
