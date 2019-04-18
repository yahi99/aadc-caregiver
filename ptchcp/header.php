<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package _s
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="profile" href="https://gmpg.org/xfn/11">
	<link rel='dns-prefetch' href='//code.jquery.com' />

	<link rel="apple-touch-icon" sizes="180x180" href="<?=get_site_url();?>/favicon/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?=get_site_url();?>/favicon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?=get_site_url();?>/favicon/favicon-16x16.png">
	<link rel="manifest" href="<?=get_site_url();?>/favicon/site.webmanifest">
	<link rel="mask-icon" href="<?=get_site_url();?>/favicon/safari-pinned-tab.svg" color="#5bbad5">
	<meta name="msapplication-TileColor" content="#da532c">
	<meta name="theme-color" content="#ffffff">


	<?php wp_head(); ?>

	<script>
		var doc = document.documentElement;
		doc.setAttribute('data-useragent', navigator.userAgent);
	</script>

</head>

<body <?php body_class(); ?>>


	<!--[if lte IE 9]>
	  <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
	<![endif]-->
	<p class="browserupgrade ie10">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
	
	<!-- CC -->
	<div role="dialog" aria-live="polite" aria-label="cookieconsent" aria-describedby="cookieconsent:desc" id="cc-banner"><!--googleoff: all--><span id="cookieconsent:desc" class="cc-message">This website uses cookies to ensure you get the best experience on our website. <a aria-label="learn more about cookies" tabindex="0" class="cc-link" href="<?=get_site_url();?>/terms-of-use/#cookies" target="_blank">Learn more</a></span><div class="cc-compliance"><a aria-label="dismiss cookie message" role="button" tabindex="0" id="cc-dismiss" class="cc-btn btn btn-secondary">Got it!</a></div><!--googleon: all--></div>
	
	<a class="sr-only sr-only-focusable" href="#content"><?php esc_html_e( 'Skip to content', '_s' ); ?></a>
	
	<!-- Preloader -->
	<div id="preloader" style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; background-color: #fff; z-index: 1090;">
		<?php if ( is_front_page() ) : ?>
	  		<div id="status" style="width: 100px; height: 100px; position: absolute; left: 50%; top: 50%; background-image: url('<?=get_template_directory_uri();?>/assets/css/images/preloader.svg'); background-repeat: no-repeat; background-position: center; margin: -50px 0 0 -50px;">&nbsp;</div>
	  	<?php endif; ?>
	</div>

	<header id="masthead" class="site-header">
		<div id="utility">
			<div class="container">
				<div class="inner">
					<!--<div> dynamic_sidebar( 'utility-text' ); </div>-->
					<div>
						<?php
							wp_nav_menu( array(
								'menu'            => 'Top',
								'theme_location' => 'top',
								'container'       => 'ul',
								'menu_class'     => 'nav',
								'menu_id'         => false,
								'depth'          => 1,
								'fallback_cb'     => 'bs4navwalker::fallback',
								'walker'          => new bs4navwalker()
							) );
						?>
					</div>
				</div>
			</div>
		</div>

		<div id="site-branding">
			<div class="container">
				<?php the_custom_logo(); ?>
				<nav role="navigation">
					<button type="button" class="menu-toggle" aria-label="Toggle navigation">
						<span></span>
						<span></span>
						<span></span>
						<span></span>
					</button>
					<div id="menu-container">
						<span class="primary-gradient-block"></span>
						<?php
							wp_nav_menu( array(
								'menu'            => 'Primary',
								'theme_location' => 'primary',
								'container'       => 'ul',
								'menu_class'     => 'nav',
								'menu_id'         => false,
								'depth'          => 2,
								'fallback_cb'     => 'bs4navwalker::fallback',
								'walker'          => new bs4navwalker()
							) );
						?>
					</div>
				</nav>	
			</div>
			<span class="primary-gradient-block"></span>
		</div><!-- .site-branding -->

		<?php if ( ! is_front_page() ) : ?>
			<span></span>
		<?php endif; ?>

		
	</header><!-- #masthead -->

	<div id="content" class="site-content">
