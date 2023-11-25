<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Explore_Blog
 */

get_header();
?>

	<main id="primary" class="site-main">
		<section class="header-banner">
				<?php do_action( 'explore_blog_breadcrumb' ); ?>
				<header class="entry-header">
					<h1 class="entry-title"><?php echo esc_html( $post->post_title ); ?></h1>
				</header>
		</section>

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', 'page' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>

	</main><!-- #main -->

<?php
if ( explore_blog_is_sidebar_enabled() ) {
	get_sidebar();
}
get_footer();