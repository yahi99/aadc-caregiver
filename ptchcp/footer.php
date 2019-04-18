<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package _s
 */

?>
	<?php
	$link = get_field('next_page_url');

	if( $link ): 
		$link_url = $link['url'];
		$link_title = $link['title'];
		$link_target = $link['target'] ? $link['target'] : '_self';
	?>
	
	<section id="next-page">
		<span class="primary-gradient-block"></span>
			<div class="container">
				<div>
					<a class="btn" href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>"><?php echo esc_html($link_title); ?></a>
				</div>
				<?php dynamic_sidebar( 'next-page-image' ); ?>
			</div>
		<span class="primary-gradient-block"></span>
	</section>

	<?php endif; ?>

	<?php if( get_field('references') ): ?>
		<section id="references">
			<div class="container">
				<?php the_field('references'); ?>
			</div>
		</section>
	<?php endif; ?>


	<!-- External Modal -->
	<div id="interstitialModal" class="modal" aria-hidden="true">
	  	<div class="modal-dialog">
		    <div class="modal-body">
		     	<?php dynamic_sidebar( 'interstitial-modalexternal-link' ); ?>
			</div>
	  	</div>
	</div>


	

	</div><!-- #content -->

	<footer id="colophon">
		<div class="container">
			<div class="inner">
				<?php dynamic_sidebar( 'footer' ); ?>

				<div class="footer-content-wrapper">
					<?php
						wp_nav_menu( array(
							'menu'            => 'Footer',
							'theme_location' => 'footer',
							'container'       => 'ul',
							'menu_class'     => 'nav',
							'menu_id'         => false,
							'depth'          => 1,
							'fallback_cb'     => 'bs4navwalker::fallback',
							'walker'          => new bs4navwalker()
						) );
					?>
					The information on this site is not intended to make a diagnosis.<br />
					&copy;<?php echo date("Y"); ?> PTC Therapeutics. All rights reserved. &nbsp;<span class="nowrap">MAT-AADC-0246</span>&nbsp;&nbsp;04/19
				</div>



			</div>
		</div>
	</footer><!-- #colophon -->

<?php wp_footer(); ?>

</body>
</html>
