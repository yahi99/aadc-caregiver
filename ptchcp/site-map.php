<?php /* Template Name: SiteMap */ ?>

<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package _s
 */

get_header();
?>

	<div id="primary" class="content-area">
		<main id="site-map" class="site-main">
			<div class="container last">
				<header class="entry-header">
					<h1>Site map</h1>
				</header>
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
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
//get_sidebar();
get_footer();
