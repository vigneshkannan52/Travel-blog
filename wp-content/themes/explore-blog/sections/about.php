<?php

if ( ! get_theme_mod( 'explore_blog_enable_about_section', false ) ) {
	return;
}

$content_id   = $section_content = array();
$content_type = get_theme_mod( 'explore_blog_about_content_type', 'post' );
if ( in_array( $content_type, array( 'post', 'page' ) ) ) {

	if ( 'post' === $content_type ) {
		$content_id[] = get_theme_mod( 'explore_blog_about_content_post' );
	} else {
		$content_id[] = get_theme_mod( 'explore_blog_about_content_page' );
	}
	$args = array(
		'post_type'           => $content_type,
		'posts_per_page'      => absint( 1 ),
		'ignore_sticky_posts' => true,
	);
	if ( ! empty( array_filter( $content_id ) ) ) {
		$args['post__in'] = array_filter( $content_id );
		$args['orderby']  = 'post__in';
	} else {
		$args['orderby'] = 'date';
	}

	$args = apply_filters( 'explore_blog_about_section_content', $args );

	explore_blog_render_about_section( $args );
}

/**
 * Render About Us Section
 */

function explore_blog_render_about_section( $args ) {
	$query = new WP_Query( $args );
	if ( $query->have_posts() ) :
		$section_subtitle = get_theme_mod( 'explore_blog_about_subtitle', __( 'LIFE IS WONDERFUL', 'explore-blog' ) );
		$button_label     = get_theme_mod( 'explore_blog_about_button_label', __( 'About Us', 'explore-blog' ) );
		while ( $query->have_posts() ) :
			$query->the_post();
			?>
			<section id="explore_blog_about_section" class="frontpage-section text-image-section grey-background about-style-1 about-image-left">
				<?php
				if ( is_customize_preview() ) :
					explore_blog_section_link( 'explore_blog_about_section' );
				endif;
				?>
				<div class="ascendoor-wrapper">
					<div class="text-image-section-wrapper">
						<div class="text-image-section-image">
							<?php the_post_thumbnail( 'post-thumbnail' ); ?>
						</div>  
						<div class="text-image-section-text section-header-subtitle">
							<h4  class="section-subtitle"><?php echo esc_html( $section_subtitle ); ?></h4>
							<h3 class="section-title"><?php the_title(); ?></h3>
							<p class="description"><?php echo wp_kses_post( wp_trim_words( get_the_content(), 50 ) ); ?></p>
							<div class="ascendoor-button ascendoor-bordered-button">
								<a href="<?php the_permalink(); ?>"><?php echo esc_html( $button_label ); ?></a>
							</div>
						</div> 
					</div>
				</div>
			</section>
			<?php
		endwhile;
		wp_reset_postdata();
	endif;
}
