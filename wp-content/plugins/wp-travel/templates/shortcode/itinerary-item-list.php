<?php
/**
 * Itinerary Item List Shortcode Contnet Template
 *
 * This template can be overridden by copying it to yourtheme/wp-travel/shortcode/itinerary-item.php.
 *
 * HOWEVER, on occasion wp-travel will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see     http://docs.wensolutions.com/document/template-structure/
 * @author  WenSolutions
 * @package WP_Travel
 * @since   1.0.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


if ( post_password_required() ) {
	echo get_the_password_form();
	return;
}

$enable_sale = WP_Travel_Helpers_Trips::is_sale_enabled( array( 'trip_id' => get_the_ID() ) );
$group_size  = wptravel_get_group_size( get_the_ID() );
$start_date  = get_post_meta( get_the_ID(), 'wp_travel_start_date', true );
$end_date    = get_post_meta( get_the_ID(), 'wp_travel_end_date', true );
?>
<article class="wp-travel-default-article">
	<div class="wp-travel-article-image-wrap">
		<a href="<?php the_permalink(); ?>">
			<?php echo wptravel_get_post_thumbnail( get_the_ID() ); ?>
		</a>
		<?php if ( $enable_sale ) : ?>
		<div class="wp-travel-offer">
			<span><?php esc_html_e( 'Offer', 'wp-travel' ); ?></span>
		</div>
		<?php endif; ?>
	</div>
	<div class="wp-travel-entry-content-wrapper">
		<div class="description-left">
		
				
			<header class="entry-header">
			<?php do_action( 'wp_travel_before_item_title', get_the_ID() ); ?>
			<?php wptravel_do_deprecated_action( 'wp_tarvel_before_archive_title', array( get_the_ID() ), '2.0.4', 'wp_travel_before_item_title' ); ?>
				<h2 class="entry-title">
					<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				</h2>
				<?php do_action( 'wp_travel_after_archive_title', get_the_ID() ); ?>
			</header><!-- .entry-header -->
			<div class="entry-content">
				<?php the_excerpt(); ?>

			</div>
			<div class="wp-travel-average-review">
			<?php wptravel_trip_rating( get_the_ID() ); ?>
				<?php $count = (int) wptravel_get_review_count(); ?>						
			</div>
			<span class="wp-travel-review-text"> (
				<?php
				/* translators: 1: number of reviews. */
				$wptravel_review_text = _n( '%d Review', '%d Reviews', $count, 'wp-travel' );
				printf( $wptravel_review_text, number_format_i18n( $count ) ); //@phpcs:ignore
				?>
				)</span>
			<div class="entry-meta">
				<div class="category-list-items">
					<span class="post-category">
						<?php $terms = get_the_terms( get_the_ID(), 'itinerary_types' ); ?>
						<?php if ( is_array( $terms ) && count( $terms ) > 0 ) : ?>
							<i class="wt-icon wt-icon-folder" aria-hidden="true"></i>
							<?php
							$first_term = array_shift( $terms );
							$term_name  = $first_term->name;
							$term_link  = get_term_link( $first_term->term_id, 'itinerary_types' );
							?>
							<a href="<?php echo esc_url( $term_link, 'wp-travel' ); ?>" rel="tag">
								<?php echo esc_html( $term_name ); ?>
							</a>
							
							<?php if ( count( $terms ) > 0 ) : ?>
							<div class="wp-travel-caret">
								<i class="wt-icon wt-icon-caret-down"></i>

								<div class="sub-category-menu">
									<?php foreach ( $terms as $term ) : ?>
										<?php
											$term_name = $term->name;
											$term_link = get_term_link( $term->term_id, 'itinerary_types' );
										?>
										<a href="<?php echo esc_url( $term_link, 'wp-travel' ); ?>">
											<?php echo esc_html( $term_name ); ?>
										</a>
									<?php endforeach; ?>
								</div>
							</div>
							<?php endif; ?>
							
						<?php endif; ?>
					</span>
				</div>
				<div class="travel-info">
					<i class="wt-icon wt-icon-child" aria-hidden="true"></i>
					<span class="value"><?php printf( '%s', $group_size ); ?></span>
				</div>
				
				<div class="travel-info">
					<?php wptravel_get_trip_duration( get_the_ID() ); ?>
				</div>
			</div>
		</div>
		<div class="description-right">
			<?php wptravel_trip_price( get_the_ID(), true ); ?>
			<div class="wp-travel-explore">
				<a class="" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Explore', 'wp-travel' ); ?></a>
			</div>
		</div>
	</div>
</article>
