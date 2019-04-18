<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package _s
 */

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<div class="container last">
				<header class="entry-header">
					<h1>The page you are looking for is not found </h1>
				</header>

			<p>The page you are looking for does not exist. It may have been moved or removed altogether. Please return to the site’s homepage and see if you can find what you are looking for there.</p>
			<p>&nbsp;</p>
			<a class="btn btn-primary right-arrow" href="<?=get_site_url();?>">Go to Homepage </a>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();



