<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Explore_Blog
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="travel-post-single">
		<div class="travel-post-img">
			<?php explore_blog_post_thumbnail(); ?>
		</div>
		<div class="travel-post-detail">
			<div class="ascendoor-cat-links">
				<?php explore_blog_categories_list(); ?>
			</div>
			<?php if ( 'post' === get_post_type() ) : ?>
				<div class="travel-meta">
					<?php
					explore_blog_posted_on();
					explore_blog_posted_by();
					?>
				</div><!-- .entry-meta -->
				<?php
				endif;
			if ( is_singular() ) :
				the_title( '<h1 class="entry-title travel-post-title">', '</h1>' );
				else :
					the_title( '<h2 class="entry-title travel-post-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
				endif;

				$button_label = get_theme_mod( 'explore_blog_archive_button_label', __( 'Read More', 'explore-blog' ) );
				?>
				<div class="travel-exverpt">
					<?php the_excerpt(); ?>
				</div><!-- .entry-content -->
				<?php if ( ! empty( $button_label ) ) : ?>
				<div class="ascendoor-button ascendoor-button-noborder-noalternate">
					<a href="<?php the_permalink(); ?>">
						<?php echo esc_html( $button_label ); ?>
					</a>
				</div>
			<?php endif; ?>
		</div>
	</div>
</article><!-- #post-<?php the_ID(); ?> -->
