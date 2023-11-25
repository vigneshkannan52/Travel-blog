<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Explore_Blog
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php $image = get_the_post_thumbnail_url( get_the_ID() ); ?>
	<meta property="og:image" content="<?php echo esc_url( $image ); ?>">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	<div id="page" class="site">
		<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'explore-blog' ); ?></a>
		<div id="loader">
			<div class="loader-container">
				<div id="preloader" class="loader-1">
					<div class="dot"></div>
				</div>
			</div>
		</div><!-- #loader -->
		<header id="masthead" class="site-header">
			<div class="header-main-wrapper">
				<?php
				if ( get_theme_mod( 'explore_blog_enable_topbar', false ) == true ) {
					$hide_topbar = get_theme_mod( 'explore_blog_hide_topbar_on_responsive_device', false );
					?>
					<div class="top-header-part <?php echo esc_attr( $hide_topbar === true ? 'no-topbar' : '' ); ?>">
						<div class="ascendoor-wrapper">
							<button type="button" class="top-header-button">
								<i class="fas fa-angle-down"></i>
							</button>
							<div class="top-header-part-wrapper">	
								<div class="top-header-left-part">
									<div class="social-icons-part">
										<?php
										if ( has_nav_menu( 'social' ) ) {
											wp_nav_menu(
												array(
													'menu_class'  => 'menu social-links',
													'link_before' => '<span class="screen-reader-text">',
													'link_after'  => '</span>',
													'theme_location' => 'social',
												)
											);
										}
										?>
									</div>
									<?php
									$contact_number = ! empty( get_theme_mod( 'explore_blog_contact_number', '' ) ) ? get_theme_mod( 'explore_blog_contact_number' ) : '';
									$email          = ! empty( get_theme_mod( 'explore_blog_email_address', '' ) ) ? get_theme_mod( 'explore_blog_email_address' ) : '';
									?>
									<ul class="top-header-contact">
										<?php if ( ! empty( $contact_number ) ) { ?>
											<li class="header-contact-inner">
												<a href="tel:<?php echo esc_attr( $contact_number ); ?>"><i class="fas fa-phone-alt"></i><?php echo esc_html( $contact_number ); ?></a>
											</li>
											<?php
										}
										if ( ! empty( $email ) ) {
											?>
											<li class="header-contact-inner email-address">
												<a href="mailto:<?php echo esc_attr( $email ); ?>"><i class="far fa-envelope"></i><?php echo esc_html( $email ); ?></a>
											</li>
										<?php } ?>
									</ul>
								</div>
								<div class="top-header-right-part">
									<div class="top-header-navigation-part">
										<?php
										if ( has_nav_menu( 'top-bar' ) ) {
											wp_nav_menu(
												array(
													'menu_class'  => 'menu',
													'theme_location' => 'top-bar',
												)
											);
										}
										?>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>
				<div class="bottom-header-outer-wrapper">
					<div class="bottom-header-part">
						<div class="ascendoor-wrapper">
							<div class="bottom-header-part-wrapper">
								<div class="site-branding">
									<?php if ( has_custom_logo() ) { ?>
										<div class="site-logo">
											<?php the_custom_logo(); ?>
										</div>
									<?php } ?>
									<div class="site-identity">
										<?php
										if ( is_front_page() && is_home() ) :
											?>
										<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
											<?php
										else :
											?>
											<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
											<?php
										endif;
										$explore_blog_description = get_bloginfo( 'description', 'display' );
										if ( $explore_blog_description || is_customize_preview() ) :
											?>
											<p class="site-description"><?php echo $explore_blog_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
										<?php endif; ?>	
									</div>		
								</div><!-- .site-branding -->
								<div class="navigation-part">
									<nav id="site-navigation" class="main-navigation">
										<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
											<span></span>
											<span></span>
											<span></span>
										</button>
										<div class="main-navigation-links">
											<?php
											wp_nav_menu(
												array(
													'theme_location' => 'primary',
													'menu_id' => 'primary-menu',
												)
											);
											?>
										</div>	
									</nav><!-- #site-navigation -->

									<div class="header-search">
										<div class="header-search-wrap">
											<a href="#" title="Search" class="header-search-icon">
												<i class="fa fa-search"></i>
											</a>
											<div class="header-search-form">
												<?php get_search_form(); ?>
											</div>
										</div>
									</div>
								</div>	
							</div>	
						</div>	
					</div>	
				</div>
			</div>	
		</header><!-- #masthead -->
		<?php if ( ! is_front_page() || is_home() ) { ?>
			<div id="content" class="site-content ascendoor-wrapper">
				<div class="ascendoor-page">
				<?php } ?>
