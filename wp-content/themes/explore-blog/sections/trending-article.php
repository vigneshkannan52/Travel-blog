<?php
if ( ! get_theme_mod( 'explore_blog_enable_trending_article_section', false ) ) {
	return;
}
$section_content = array();
$content_type    = get_theme_mod( 'explore_blog_trending_article_content_type', 'post' );

switch ( $content_type ) {

	case 'post': // Post.
		$content_ids = array();
		for ( $i = 1; $i <= 5; $i++ ) {
			$content_post_id = get_theme_mod( 'explore_blog_trending_article_content_post_' . $i );
			if ( ! empty( $content_post_id ) ) {
				$content_ids[] = $content_post_id;
			}
		}
		$args = array(
			'post_type'      => 'post',
			'posts_per_page' => 5,
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
		for ( $i = 1; $i <= 5; $i++ ) {
			$content_post_id = get_theme_mod( 'explore_blog_trending_article_content_trip_' . $i );
			if ( ! empty( $content_post_id ) ) {
				$content_ids[] = $content_post_id;
			}
		}
		$args = array(
			'post_type'      => 'itineraries',
			'posts_per_page' => 5,
		);
		if ( ! empty( array_filter( $content_ids ) ) ) {
			$args['post__in'] = array_filter( $content_ids );
			$args['orderby']  = 'post__in';
		} else {
			$args['orderby'] = 'date';
		}

		break;

	case 'category':
		$content_ids = ! empty( get_theme_mod( 'explore_blog_trending_article_content_category' ) ) ? get_theme_mod( 'explore_blog_trending_article_content_category' ) : '';
		$args        = array(
			'post_type'           => 'post',
			'posts_per_page'      => absint( 5 ),
			'cat'                 => absint( $content_ids ),
			'ignore_sticky_posts' => true,
		);

		break;

	default:
		break;
}

$query = new WP_Query( $args );
if ( $query->have_posts() ) :
	while ( $query->have_posts() ) :
		$query->the_post();
		$data['id']            = get_the_ID();
		$data['title']         = get_the_title();
		$data['content']       = wp_trim_words( get_the_content(), 15 );
		$data['permalink']     = get_the_permalink();
		$data['date']          = get_the_date();
		$data['thumbnail_url'] = get_the_post_thumbnail_url( get_the_ID(), 'post-thumbnail' );
		array_push( $section_content, $data );
	endwhile;
	wp_reset_postdata();
endif;

$section_content = apply_filters( 'explore_blog_trending_article_section_content', $section_content );

explore_blog_render_trending_article_section( $section_content );

/**
 * Render Trending Article Section
 */
function explore_blog_render_trending_article_section( $section_content ) {

	?>

	<?php
	$section_background_image     = get_theme_mod( 'explore_blog_trending_article_background_image', '' );
	$trending_article_subtitle    = get_theme_mod( 'explore_blog_trending_article_subtitle', __( 'Trending Articles', 'explore-blog' ) );
	$trending_article_title       = get_theme_mod( 'explore_blog_trending_article_title', __( 'Discover the Stories', 'explore-blog' ) );
	$trending_article_post_button = get_theme_mod( 'explore_blog_trending_article_post_button_label', __( 'Read More', 'explore-blog' ) );
	$trending_article_button      = get_theme_mod( 'explore_blog_trending_article_button_label', __( 'View all', 'explore-blog' ) );
	$trending_article_link        = get_theme_mod( 'explore_blog_trending_article_button_link' );
	$trending_article_link        = ! empty( $trending_article_link ) ? $trending_article_link : '#';
	?>

	<section id="explore_blog_trending_article_section" class="frontpage-section trending-article-section trending-article-style-1 has-background">
		<?php
		if ( is_customize_preview() ) :
			explore_blog_section_link( 'explore_blog_trending_article_section' );
		endif;
		?>
		<?php if ( ! empty( $section_background_image ) ) : ?>
			<div class="trending-background-image">
				<img src="<?php echo esc_url( $section_background_image ); ?>">
			</div>
		<?php endif; ?>
		<div class="ascendoor-wrapper">
			<div class="section-header-subtitle">
				<?php if ( ! empty( $trending_article_subtitle || $trending_article_title ) ) : ?>
					<h4 class="section-subtitle"><?php echo esc_html( $trending_article_subtitle ); ?></h4>
					<h3 class="section-title"><?php echo esc_html( $trending_article_title ); ?></h3>
				<?php endif; ?>
				<div class="swiper-button-next trending-article-navigation"></div>
				<div class="swiper-button-prev trending-article-navigation"></div>
			</div>
		</div><!-- .ascendoor-wrapper end -->
		<div class="section-body">
			<div class="trending-slider-wrap">
				<div class="trending-article-wrapper swiper">
					<div class="swiper-wrapper">
						<?php
						foreach ( $section_content as $content ) :
							$content_type = get_theme_mod( 'explore_blog_trending_article_content_type', 'post' );
							$taxonomies   = 'category';
							if ( $content_type === 'itineraries' ) {
								$taxonomies = 'travel_locations';
							}
							?>
							<div class="swiper-slide">
								<div class="trending-single">
									<div class="trending-img">
										<?php if ( ! empty( $content['thumbnail_url'] ) ) : ?>
											<a href="<?php echo esc_url( $content['permalink'] ); ?>">
												<img src="<?php echo esc_url( $content['thumbnail_url'] ); ?>" alt="<?php echo esc_attr( $content['title'] ); ?>">
											</a>
										<?php endif ?>
									</div>
									<div class="trending-detail">
										<?php if ( get_theme_mod( 'explore_blog_post_hide_category', false ) === false ) : ?>
											<div class="ascendoor-cat-links">
												<?php
												$terms = get_the_terms( $content['id'], $taxonomies );
												if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
													?>
													<a href="<?php echo esc_url( get_term_link( $terms[0]->term_id, $taxonomies ) ); ?>"><?php echo esc_html( $terms[0]->name ); ?></a>
													<?php
												}
												?>
											</div>
											<?php
										endif;
										if ( get_theme_mod( 'explore_blog_post_hide_date', false ) === false ) {
											?>
											<div class="trending-meta">
												<?php echo esc_html( $content['date'] ); ?>
											</div>
										<?php } ?>
										<h3 class="trending-title">
											<a href="<?php echo esc_url( $content['permalink'] ); ?>"><?php echo esc_html( $content['title'] ); ?></a>
										</h3>
										<div class="trending-description">
											<?php echo wp_kses_post( $content['content'] ); ?>
										</div>
										<?php if ( ! empty( $trending_article_post_button ) ) : ?>
											<div class="ascendoor-button ascendoor-button-noborder-noalternate">
												<a href="<?php echo esc_url( $content['permalink'] ); ?>"><?php echo esc_html( $trending_article_post_button ); ?></a>
											</div>
										<?php endif; ?>
									</div>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
					<div class="swiper-pagination"></div>
				</div>
			</div>

			<?php if ( ! empty( $trending_article_button ) ) { ?>
				<div class="ascendoor-bottom-button ascendoor-button">
					<a href="<?php echo esc_url( $trending_article_link ); ?>"><?php echo esc_html( $trending_article_button ); ?></a>
				</div>
			<?php } ?>
		</div>
	</section>

	<?php

}
