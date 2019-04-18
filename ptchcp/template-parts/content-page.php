<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package _s
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="entry-content">
		<?php if ( is_front_page() ) : ?>
			<div class="post-thumbnail position">
				<?php if (has_post_thumbnail( $post->ID ) ): ?>

				<picture>
					<source media="screen and (min-width: 1601px)" srcset="<?php echo get_the_post_thumbnail_url(); ?>">

			        <source media="screen and (min-width: 1200px)" srcset="<?php echo get_the_post_thumbnail_url($post_id, 'hd size'); ?>, <?php echo get_the_post_thumbnail_url(); ?> 2x">

			        <source media="screen and (min-width: 768px)" srcset="<?php echo get_the_post_thumbnail_url($post_id, 'large'); ?>, <?php echo get_the_post_thumbnail_url($post_id, 'hd size'); ?> 2x">

			        <source media="screen and (max-width: 767.98px)" srcset="<?php echo get_the_post_thumbnail_url($post_id, 'large'); ?>">

			        <img src="<?php echo get_the_post_thumbnail_url($post_id, 'large'); ?>" alt="<?php echo get_the_post_thumbnail_caption(); ?>">
			    </picture>

				<?php endif; ?>
				
			</div>
		<?php endif; ?>
		<?php
		the_content();

		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', '_s' ),
			'after'  => '</div>',
		) );
		?>
	</div><!-- .entry-content -->

	<?php if ( get_edit_post_link() ) : ?>
		<footer class="entry-footer">
			<?php
			edit_post_link(
				sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__( 'Edit <span class="screen-reader-text">%s</span>', '_s' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				),
				'<span class="edit-link">',
				'</span>'
			);
			?>
		</footer><!-- .entry-footer -->
	<?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->
