<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Explore_Blog
 */

get_header();

$column_layout = get_theme_mod( 'explore_blog_archive_grid_column', 'column-2' );

?>

<main id="primary" class="site-main">

	<?php if ( have_posts() ) : ?>

		<header class="page-header">
			<h1 class="page-title">
				<?php
				/* translators: %s: search query. */
				printf( esc_html__( 'Search Results for: %s', 'explore-blog' ), '<span>' . get_search_query() . '</span>' );
				?>
			</h1>
		</header><!-- .page-header -->
		<div class="archive-layout grid-style <?php echo esc_attr( $column_layout ); ?>">
			<?php
			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				get_template_part( 'template-parts/content', 'search' );

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
