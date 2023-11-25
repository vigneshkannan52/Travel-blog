<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
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
			<?php
			if ( 'post' === get_post_type() ) :
				setup_postdata( get_post() );
				?>
				<div class="entry-meta">
					<?php
					$hide_date   = get_theme_mod( 'explore_blog_post_hide_date', false );
					$hide_author = get_theme_mod( 'explore_blog_post_hide_author', false );

					if ( ! $hide_date ) {
						explore_blog_posted_on();
					}
					if ( ! $hide_author ) {
						explore_blog_posted_by();
					}
					?>
				</div><!-- .entry-meta -->
				<?php
			endif;
			?>
		</section>

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', 'single' );

			do_action( 'explore_blog_post_navigation' );

			if ( is_singular( 'post' ) ) {
				$related_posts_label = get_theme_mod( 'explore_blog_post_related_post_label', __( 'Related Posts', 'explore-blog' ) );
				$cat_content_id      = get_the_category( $post->ID )[0]->term_id;
				$args                = array(
					'cat'            => $cat_content_id,
					'posts_per_page' => 3,
					'post__not_in'   => array( $post->ID ),
					'orderby'        => 'rand',
				);
				$query               = new WP_Query( $args );

				if ( $query->have_posts() ) :
					?>
					<div class="related-posts">
						<?php
						if ( get_theme_mod( 'explore_blog_post_hide_related_posts', false ) === false ) :
							?>
							<h2><?php echo esc_html( $related_posts_label ); ?></h2>
							<div class="row">
								<?php
								while ( $query->have_posts() ) :
									$query->the_post();
									?>
									<div>
										<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
											<?php explore_blog_post_thumbnail(); ?>
											<header class="entry-header">
												<?php the_title( '<h5 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h5>' ); ?>
											</header><!-- .entry-header -->
											<div class="entry-content">
												<?php the_excerpt(); ?>
											</div><!-- .entry-content -->
										</article>
									</div>
									<?php
								endwhile;
								wp_reset_postdata();
								?>
							</div>
							<?php
						endif;
						?>
					</div>
					<?php
				endif;
			}

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
