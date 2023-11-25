<?php
if ( ! get_theme_mod( 'explore_blog_enable_counter_section', false ) ) {
	return;
}

$section_content                     = array();
$section_content['subtitle']         = get_theme_mod( 'explore_blog_counter_subtitle', '' );
$section_content['title']            = get_theme_mod( 'explore_blog_counter_title', '' );
$section_content['background_image'] = get_theme_mod( 'explore_blog_counter_background_image' );

$section_content = apply_filters( 'explore_blog_counter_section_content', $section_content );

explore_blog_render_counter_section( $section_content );

/**
 * Render Counter Section
 */
function explore_blog_render_counter_section( $section_content ) {
	?>
	<section id="explore_blog_counter_section" class="frontpage-section has-background counter-section counter-style-1">
		<?php
		if ( is_customize_preview() ) :
			explore_blog_section_link( 'explore_blog_counter_section' );
		endif;
		?>
		<?php if ( ! empty( $section_content['background_image'] ) ) { ?>
			<div class="counter-background-img">
				<img src="<?php echo esc_url( $section_content['background_image'] ); ?>" alt="<?php esc_attr_e( 'counter-bg-image', 'explore-blog' ); ?>">
			</div>
		<?php } ?>
		<div class="ascendoor-wrapper">
			<div class="counter-details">
				<?php if ( ! empty( $section_content['subtitle'] || $section_content['title'] ) ) : ?>
					<div class="section-header-subtitle">
						<h4 class="section-subtitle"><?php echo esc_html( $section_content['subtitle'] ); ?></h4>
						<h3 class="section-title"><?php echo esc_html( $section_content['title'] ); ?></h3>
					</div>
				<?php endif; ?>
				<div class="section-body">
					<div class="counter-wrapper">
						<?php
						for ( $i = 1; $i <= 4; $i++ ) {
							$icon         = get_theme_mod( 'explore_blog_counter_icon_' . $i );
							$label        = get_theme_mod( 'explore_blog_counter_label_' . $i );
							$value        = get_theme_mod( 'explore_blog_counter_value_' . $i );
							$value_suffix = get_theme_mod( 'explore_blog_counter_value_suffix_' . $i );
							?>
							<div class="counter-single">
								<?php if ( ! empty( $icon ) ) { ?>
									<div class="counter-img">
										<img src="<?php echo esc_url( $icon ); ?>" alt="<?php echo esc_attr( $label ); ?>">
									</div>
								<?php } ?>
								<div class="counter-txt">
									<h3>
										<span class="count"><?php echo absint( $value ); ?></span><?php echo esc_html( $value_suffix ); ?>
									</h3>
									<p><?php echo esc_html( $label ); ?></p>
								</div>
							</div>
							<?php
						}
						?>
					</div>      
				</div>
			</div>
		</div>
	</section>
	<?php
}
