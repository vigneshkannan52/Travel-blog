<?php
if ( ! get_theme_mod( 'explore_blog_enable_banner_section', false ) ) {
	return;
}

$section_content     = $grid_section_content = array();
$post_count          = get_theme_mod( 'explore_blog_banner_slide_count', 3 );
$banner_content_type = get_theme_mod( 'explore_blog_banner_content_type', 'post' );

switch ( $banner_content_type ) {
	case 'post': // Post.
		$content_ids = array();
		for ( $i = 1; $i <= $post_count; $i++ ) {
			$content_post_id = get_theme_mod( 'explore_blog_banner_content_post_' . $i );
			if ( ! empty( $content_post_id ) ) {
				$content_ids[] = $content_post_id;
			}
		}

		$args = array(
			'post_type'      => 'post',
			'posts_per_page' => $post_count,
		);
		if ( ! empty( array_filter( $content_ids ) ) ) {
			$args['post__in'] = array_filter( $content_ids );
			$args['orderby']  = 'post__in';
		} else {
			$args['orderby'] = 'date';
		}

		break;

	case 'itineraries': // Trip.
		if ( ! class_exists( 'WP_Travel' ) ) {
			return;
		}

		$content_ids = array();
		for ( $i = 1; $i <= $post_count; $i++ ) {
			$content_post_id = get_theme_mod( 'explore_blog_banner_content_trip_' . $i );
			if ( ! empty( $content_post_id ) ) {
				$content_ids[] = $content_post_id;
			}
		}

		$args = array(
			'post_type'      => 'itineraries',
			'posts_per_page' => $post_count,
		);
		if ( ! empty( array_filter( $content_ids ) ) ) {
			$args['post__in'] = array_filter( $content_ids );
			$args['orderby']  = 'post__in';
		} else {
			$args['orderby'] = 'date';
		}

		break;

	default:
		break;
}

$query = new WP_Query( $args );
if ( $query->have_posts() ) :
	$i = 1;
	while ( $query->have_posts() ) :
		$query->the_post();
		$data['id']            = get_the_ID();
		$data['title']         = get_the_title();
		$data['permalink']     = get_the_permalink();
		$data['thumbnail_url'] = get_the_post_thumbnail_url( get_the_ID(), 'full' );
		$data['subtitle']      = get_theme_mod( 'explore_blog_banner_subtitle_' . $i, '' );
		array_push( $section_content, $data );
		$i++;
	endwhile;
	wp_reset_postdata();
endif;

$section_content = apply_filters( 'explore_blog_banner_section_content', $section_content );

explore_blog_render_banner_section( $section_content );

/**
 * Render Banner Section
 */
function explore_blog_render_banner_section( $section_content ) {
	?>

	<?php
	$button_label = get_theme_mod( 'explore_blog_banner_button_label', __( 'Explore Now', 'explore-blog' ) );
	$post_count   = get_theme_mod( 'explore_blog_banner_slide_count', 3 );
	$single_post  = $post_count === 1 ? ' ' : 'banner-multiple-post';
	?>
	<section id="explore_blog_banner_section" class="main-banner-section banner-caption-center banner-section-style-1 <?php echo esc_attr( $single_post ); ?>">
		<?php
		if ( is_customize_preview() ) :
			explore_blog_section_link( 'explore_blog_banner_section' );
		endif;
		?>
		<div class="main-banner-slider">
			<div class="swiper-container swiper">
				<div class="swiper-wrapper">
					<?php foreach ( $section_content as $content ) : ?>
						<div class="swiper-slide">
							<div class="banner-slider-single slide-bg-image" data-swiper-parallax="100%" style='background-image:url("<?php echo esc_url( $content['thumbnail_url'] ); ?>")'>
								<div class="banner-slider-detail">
									<div class="ascendoor-wrapper">
										<div class="banner-slider-detail-inside">
											<p data-swiper-parallax="-300"><?php echo esc_html( $content['subtitle'] ); ?></p>
											<h3 data-swiper-parallax="-200" class="banner-head-title"><?php echo esc_html( $content['title'] ); ?></h3>
											<?php if ( ! empty( $button_label ) ) : ?>
												<div data-swiper-parallax="-100" class="ascendoor-button banner-slider-btn">
													<a href="<?php echo esc_url( $content['permalink'] ); ?>"><?php echo esc_html( $button_label ); ?></a>
												</div>
											<?php endif; ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
				<div class="swiper-button-next banner-style-1" style='background-image:url("")'></div>
				<div class="swiper-button-prev banner-style-1" style='background-image:url("")'></div>
			</div>    
		</div>   
	</section>

	<?php

}
