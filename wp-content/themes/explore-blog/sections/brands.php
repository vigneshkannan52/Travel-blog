<?php

if ( ! get_theme_mod( 'explore_blog_enable_brands_section', false ) ) {
	return;
}

$section_content = array();
$section_content = apply_filters( 'explore_blog_brands_section_content', $section_content );

explore_blog_render_brands_section( $section_content );

/**
 * Render Brands Section
 */
function explore_blog_render_brands_section( $section_content ) {
	?>
	<section id="explore_blog_brands_section" class="frontpage-section brands-section">
		<?php
		if ( is_customize_preview() ) :
			explore_blog_section_link( 'explore_blog_brands_section' );
		endif;
		?>
		<div class="ascendoor-wrapper">
			<div class="brands-slider-wrap">
				<div class="brands-slider-wrapper swiper">
					<div class="swiper-wrapper">
						<?php
						for ( $i = 1; $i <= 6; $i++ ) {
							$logo     = get_theme_mod( 'explore_blog_brands_logo_' . $i );
							$logo_url = get_theme_mod( 'explore_blog_brands_logo_url_' . $i );
							$logo_url = ! empty( $logo_url ) ? $logo_url : '#';
							if ( ! empty( $logo ) ) {
								?>
								<div class="swiper-slide">
									<div class="brands-single">
										<a href="<?php echo esc_url( $logo_url ); ?>">
											<img src="<?php echo esc_url( $logo ); ?>" alt="<?php esc_attr_e( 'brands-logo', 'explore-blog' ); ?>">
										</a>
									</div>
								</div>
								<?php
							}
						}
						?>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php
}
