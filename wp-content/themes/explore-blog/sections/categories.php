<?php
if ( ! get_theme_mod( 'explore_blog_enable_categories_section', false ) ) {
	return;
}
$section_content = array();

$content_ids = array();
for ( $i = 1; $i <= 6; $i++ ) {
	$content_post_id = get_theme_mod( 'explore_blog_categories_content_category_' . $i );
	if ( ! empty( $content_post_id ) ) {
		$content_ids[] = $content_post_id;
	}
}

$args = array(
	'taxonomy'   => 'category',
	'number'     => 6,
	'include'    => array_filter( $content_ids ),
	'orderby'    => 'include',
	'hide_empty' => false,
);

$terms = get_terms( $args );

$i = 1;
foreach ( $terms as $value ) {
	$data['title']         = $value->name;
	$data['count']         = $value->count;
	$data['permalink']     = get_term_link( $value->term_id );
	$data['thumbnail_url'] = get_theme_mod( 'explore_blog_category_category_image_' . $i, '' );
	array_push( $section_content, $data );
	$i++;
}

$section_content = apply_filters( 'explore_blog_categories_section_content', $section_content );

explore_blog_render_categories_section( $section_content );

/**
 * Render Categories Section
 */
function explore_blog_render_categories_section( $section_content ) {

	$background_image = get_theme_mod( 'explore_blog_categories_background_image', '' );
	$categories_title = get_theme_mod( 'explore_blog_categories_title', __( 'Categories', 'explore-blog' ) );
	$categories_text  = get_theme_mod( 'explore_blog_categories_text', '' );
	?>

	<section id="explore_blog_categories_section" class="frontpage-section travel-category travel-category-style-2">
		<?php
		if ( is_customize_preview() ) :
			explore_blog_section_link( 'explore_blog_categories_section' );
		endif;
		?>
		<div class="ascendoor-wrapper">
			<div class="ascendoor-section-half">
				<div class="section-header-background-img">
					<?php if ( ! empty( $categories_text || $categories_title ) ) : ?>
						<div class="section-header-subtitle section-header-subtitle-left">
							<h4 class="section-subtitle"><?php echo esc_html( $categories_text ); ?></h4>
							<h3 class="section-title"><?php echo esc_html( $categories_title ); ?></h3>
						</div>
					<?php endif; ?>
					<?php if ( ! empty( $background_image ) ) : ?>
						<img src="<?php echo esc_url( $background_image ); ?>" alt="<?php esc_attr_e( 'Background Image', 'explore-blog' ); ?>">
					<?php endif; ?>
				</div>
				<div class="section-body">
					<div class="travel-category-wrapper">
						<?php
						$i = 1;
						foreach ( $section_content as $content ) :
							?>
							<div class="travel-category-single">
								<?php if ( ! empty( $content['thumbnail_url'] ) ) : ?>
									<div class="travel-category-img">
										<img src="<?php echo esc_url( $content['thumbnail_url'] ); ?>" alt="<?php echo esc_attr( $content['title'] ); ?>">
									</div>
								<?php endif; ?>
								<h3><?php echo esc_html( $content['title'] ); ?></h3>
								<?php
								$count      = absint( $content['count'] );
								$post_count = $count . ( $count <= 1 ? ' post' : ' posts' );
								?>
								<span class="post-count"><?php echo esc_html( $post_count ); ?></span>
								<a href="<?php echo esc_url( $content['permalink'] ); ?>">
								</a>
							</div>
							<?php
							$i++;
						endforeach;
						?>
					</div>      
				</div>
			</div> <!-- .ascendoor-section-half end -->
		</div>
	</section>

	<?php

}
