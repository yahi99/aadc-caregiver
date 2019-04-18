<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package _s
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function _s_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', '_s_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function _s_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', '_s_pingback_header' );

// Include custom navwalker
	require_once('bs4navwalker.php');

	// This theme uses wp_nav_menu() in three locations.
		register_nav_menus( array(
			'top' => esc_html__( 'Top', '_s' ),
			'primary' => esc_html__( 'Primary', '_s' ),
			'footer' => esc_html__( 'Footer', '_s' ),
		) );

// REMOVE WP EMOJI
	remove_action('wp_head', 'print_emoji_detection_script', 7);
	remove_action('wp_print_styles', 'print_emoji_styles');

	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );

	add_filter( 'emoji_svg_url', '__return_false' );

// REMOVE WP EMBED
	function my_deregister_scripts(){
	  wp_deregister_script( 'wp-embed' );
	}
	add_action( 'wp_footer', 'my_deregister_scripts' );




/* =Clean up the WordPress head
------------------------------------------------- */

// remove header links
add_action('init', 'tjnz_head_cleanup');
function tjnz_head_cleanup() {
    remove_action( 'wp_head', 'feed_links_extra', 3 );                      // Category Feeds
    remove_action( 'wp_head', 'feed_links', 2 );                            // Post and Comment Feeds
    remove_action( 'wp_head', 'rsd_link' );                                 // EditURI link
    remove_action( 'wp_head', 'wlwmanifest_link' );                         // Windows Live Writer
    remove_action( 'wp_head', 'index_rel_link' );                           // index link
    remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );              // previous link
    remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );               // start link
    remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );   // Links for Adjacent Posts
    remove_action( 'wp_head', 'wp_generator' );                             // WP version
}

// remove WP comment styles
add_filter( 'show_recent_comments_widget_style', '__return_false', 99 );

// remove WP version from RSS
	add_filter('the_generator', 'tjnz_rss_version');
	function tjnz_rss_version() { return ''; }

// remove Search
function fb_filter_query( $query, $error = true ) {

	if ( is_search() ) {
		$query->is_search = false;
		$query->query_vars[s] = false;
		$query->query[s] = false;

		// to error
		if ( $error == true )
			$query->is_404 = true;
	}
}

add_action( 'parse_query', 'fb_filter_query' );
add_filter( 'get_search_form', create_function( '$a', "return null;" ) );
