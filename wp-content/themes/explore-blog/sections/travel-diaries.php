<?php
if ( ! get_theme_mod( 'explore_blog_enable_travel_diaries_section', false ) ) {
	return;
}
$section_content      = array();
$travel_diaries_count = get_theme_mod( 'explore_blog_travel_diaries_posts_count', 3 );
$content_type         = get_theme_mod( 'explore_blog_travel_diaries_content_type', 'post' );

switch ( $content_type ) {

	case 'post': // Post.
		$content_ids = array();
		for ( $i = 1; $i <= $travel_diaries_count; $i++ ) {
			$content_post_id = get_theme_mod( 'explore_blog_travel_diaries_content_post_' . $i );
			if ( ! empty( $content_post_id ) ) {
				$content_ids[] = $content_post_id;
			}
		}
		$args = array(
			'post_type'      => 'post',
			'posts_per_page' => $travel_diaries_count,
		);
		if ( ! empty( array_filter( $content_ids ) ) ) {
			$args['post__in'] = array_filter( $content_ids );
			$args['orderby']  = 'post__in';
		} else {
			$args['orderby'] = 'date';
		}
		break;

	case 'category': // Category.
		$content_ids = ! empty( get_theme_mod( 'explore_blog_travel_diaries_content_category' ) ) ? get_theme_mod( 'explore_blog_travel_diaries_content_category' ) : '';
		$args        = array(
			'post_type'           => 'post',
			'posts_per_page'      => absint( $travel_diaries_count ),
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
		$data['excerpt']       = get_the_excerpt();
		$data['permalink']     = get_the_permalink();
		$data['date']          = get_the_date();
		$data['thumbnail_url'] = get_the_post_thumbnail_url( get_the_ID(), 'post-thumbnail' );
		array_push( $section_content, $data );
	endwhile;
	wp_reset_postdata();
endif;

$section_content = apply_filters( 'explore_blog_travel_diaries_section_content', $section_content );

explore_blog_render_travel_diaries_section( $section_content );

/**
 * Render Travel Diaries Section
 */
function explore_blog_render_travel_diaries_section( $section_content ) {

	$travel_diaries_subtitle    = get_theme_mod( 'explore_blog_travel_diaries_subtitle', __( 'Life is a Journey', 'explore-blog' ) );
	$travel_diaries_title       = get_theme_mod( 'explore_blog_travel_diaries_title', __( 'Travel Diaries', 'explore-blog' ) );
	$travel_diaries_post_button = get_theme_mod( 'explore_blog_travel_diaries_post_button_label', __( 'Read More', 'explore-blog' ) );
	$travel_diaries_button      = get_theme_mod( 'explore_blog_travel_diaries_button_label', __( 'Explore All Diaries', 'explore-blog' ) );
	$travel_diaries_link        = get_theme_mod( 'explore_blog_travel_diaries_button_link' );
	$travel_diaries_link        = ! empty( $travel_diaries_link ) ? $travel_diaries_link : '';
	?>

	<section id="explore_blog_travel_diaries_section" class="frontpage-section travel-diaries-section grey-background travel-diary-style-2">
		<?php
		if ( is_customize_preview() ) :
			explore_blog_section_link( 'explore_blog_travel_diaries_section' );
		endif;
		?>
		<div class="ascendoor-wrapper">
			<?php if ( ! empty( $travel_diaries_subtitle || $travel_diaries_title ) ) : ?>
				<div class="section-header-subtitle">
					<h4 class="section-subtitle"><?php echo esc_html( $travel_diaries_subtitle ); ?></h4>
					<h3 class="section-title"><?php echo esc_html( $travel_diaries_title ); ?></h3>
				</div>
			<?php endif; ?>
			<div class="section-body">
				<div class="travel-diaries-section-style-2-wrapper">
					<?php foreach ( $section_content as $content ) : ?>
						<div class="travel-diary-single">
							<?php if ( ! empty( $content['thumbnail_url'] ) ) : ?>
								<div class="travel-diary-img">
									<a href="<?php echo esc_url( $content['permalink'] ); ?>">
										<img src="<?php echo esc_url( $content['thumbnail_url'] ); ?>" alt="<?php echo esc_html( $content['title'] ); ?>">
									</a>
								</div>
							<?php endif; ?>
							<div class="travel-diary-detail">
								<?php if ( get_theme_mod( 'explore_blog_post_hide_date', false ) === false ) { ?>
									<div class="travel-diary-meta">
										<?php echo esc_html( $content['date'] ); ?>
									</div>
								<?php } ?>
								<h3 class="travel-diary-title">
									<a href="<?php echo esc_url( $content['permalink'] ); ?>">
										<?php echo esc_html( $content['title'] ); ?>
									</a>
								</h3>
								<?php if ( ! empty( $travel_diaries_post_button ) ) : ?>
									<div class="readmore ascendoor-button ascendoor-button-noborder-noalternate">
										<a href="<?php echo esc_url( $content['permalink'] ); ?>"><?php echo esc_html( $travel_diaries_post_button ); ?></a>
									</div>
								<?php endif; ?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
				<?php if ( ! empty( $travel_diaries_button ) ) : ?>
					<div class="ascendoor-bottom-button ascendoor-button">
						<a href="<?php echo esc_url( $travel_diaries_link ); ?>"><?php echo esc_html( $travel_diaries_button ); ?></a>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</section>

	<?php

}
