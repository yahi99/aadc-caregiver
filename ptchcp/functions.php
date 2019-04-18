<?php
/**
 * _s functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package _s
 */

if ( ! function_exists( '_s_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function _s_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on _s, use a find and replace
		 * to change '_s' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( '_s', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		add_image_size( 'hd size', 1600, 9999 );
		add_image_size( 'hd 2x size', 2048, 9999 );

		add_filter('wp_generate_attachment_metadata','replace_uploaded_image');

		function replace_uploaded_image($image_data)
		{
		    // if there is no large image : return
		    if ( !isset($image_data['sizes']['hd 2x size']) )
		        return $image_data;

		    // paths to the uploaded image and the large image
		    $upload_dir              = wp_upload_dir();
		    $uploaded_image_location = $upload_dir['basedir'] . '/' . $image_data['file'];
		    $large_image_location    = $upload_dir['path'] . '/' . $image_data['sizes']['hd 2x size']['file'];

		    // delete the uploaded image
		    unlink($uploaded_image_location);

		    // rename the large image
		    rename($large_image_location, $uploaded_image_location);

		    // update image metadata and return them
		    $image_data['width']  = $image_data['sizes']['large']['width'];
		    $image_data['height'] = $image_data['sizes']['large']['height'];
		    unset($image_data['sizes']['hd 2x size']);

		    return $image_data;
		}

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );



		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Add support for full and wide align images.
		add_theme_support( 'align-wide' );

		// Add support for editor styles.
		add_theme_support( 'editor-styles' );

		// Enqueue editor styles.
		add_editor_style( 'style-editor.css' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );

		// Add support for responsive embedded content.
		add_theme_support( 'responsive-embeds' );
	}
endif;
add_action( 'after_setup_theme', '_s_setup' );


/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function _s_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( '_s_content_width', 640 );
}
add_action( 'after_setup_theme', '_s_content_width', 0 );

/**
 * Add crossorigin="anonymous" and integrity= to CDN JS.
 */
add_filter( 'script_loader_tag', 'add_attribs_to_scripts', 10, 3 );
function add_attribs_to_scripts( $tag, $handle, $src ) {

// The handles of the enqueued scripts we want to defer
$jquery = array(
    'jquery-3'
);

if ( in_array( $handle, $jquery ) ) {
    return '<script type="text/javascript" src="' . $src . '" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>' . "\n";
}
return $tag;
}

/**
 * Enqueue scripts and styles.
 */
function _s_scripts() {
	wp_dequeue_style( 'wp-block-library' );
	wp_enqueue_style( '_s-style', get_stylesheet_uri() );

	wp_enqueue_script( 'js-cookie', get_template_directory_uri() . '/js/js.cookie.min.js', array(), '1.0', true );
	wp_enqueue_script( 'cookie-settings', get_template_directory_uri() . '/js/cookie-settings.js', array(), '1.0', true );
	wp_enqueue_script('jquery-3', 'https://code.jquery.com/jquery-3.3.1.min.js', array(), '3.2.1', true);
	wp_enqueue_script( 'ptc-global', get_template_directory_uri() . '/js/global.js', array(), '1.0', true );
	wp_enqueue_script( '_s-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if(is_page()){ //Check if we are viewing a page
	global $wp_query;

        //Check which template is assigned to current page we are looking at
        $template_name = get_post_meta( $wp_query->post->ID, '_wp_page_template', true );
		if($template_name == 'pageWithTabset.php'){
			wp_enqueue_style( 'tabs-style', get_template_directory_uri() . '/assets/css/tabs.css', true );
			wp_enqueue_script('tabs', get_template_directory_uri() . '/js/tabs.js', array(), '1.0', true );
		}
	}

	if(is_page()){ //Check if we are viewing a page
	global $wp_query;

        //Check which template is assigned to current page we are looking at
        $template_name = get_post_meta( $wp_query->post->ID, '_wp_page_template', true );
		if($template_name == 'form.php'){
			wp_enqueue_style( 'forms-style', get_template_directory_uri() . '/assets/css/forms.css', true );
			wp_enqueue_script('forms', get_template_directory_uri() . '/js/forms.min.js', array(), '1.0', true );
		}
	}

	if(is_page()){ //Check if we are viewing a page
	global $wp_query;

        //Check which template is assigned to current page we are looking at
        $template_name = get_post_meta( $wp_query->post->ID, '_wp_page_template', true );
		if($template_name == 'site-map.php'){
			wp_enqueue_style( 'site-map', get_template_directory_uri() . '/assets/css/site-map.css', true );
		}
	}
}
add_action( 'wp_enqueue_scripts', '_s_scripts' );


// Add backend styles for Gutenberg.
add_action( 'enqueue_block_editor_assets', 's_add_gutenberg_assets' );

/**
 * Load Gutenberg stylesheet.
 */
function s_add_gutenberg_assets() {
	// Load the theme styles within Gutenberg.
	wp_enqueue_style( 's-gutenberg', get_theme_file_uri( '/assets/css/s-editor-style.css' ), false );
}

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}


// ACF WYSIWYG
add_filter( 'acf/fields/wysiwyg/toolbars' , 'my_toolbars'  );
function my_toolbars( $toolbars )
{
	// Uncomment to view format of $toolbars
	/*
	echo '< pre >';
		print_r($toolbars);
	echo '< /pre >';
	die;
	*/

	// Add a new toolbar called "Very Simple"
	// - this toolbar has only 1 row of buttons
	$toolbars['Very Simple' ] = array();
	$toolbars['Very Simple' ][1] = array('bold' , 'italic' );

	// Edit the "Full" toolbar and remove 'code'
	// - delet from array code from http://stackoverflow.com/questions/7225070/php-array-delete-by-value-not-key
	if( ($key = array_search('code' , $toolbars['Full' ][2])) !== false )
	{
	    unset( $toolbars['Full' ][2][$key] );
	}

	// remove the 'Basic' toolbar completely
	unset( $toolbars['Basic' ] );

	// return $toolbars - IMPORTANT!
	return $toolbars;
}

// LAZY BLOCKS

if ( function_exists( 'lazyblocks' ) ) :

    lazyblocks()->add_block( array(
        'id' => 1445,
        'title' => 'Button Download',
        'icon' => '',
        'keywords' => array(
        ),
        'slug' => 'lazyblock/button-download',
        'description' => '',
        'category' => 'common',
        'category_label' => 'common',
        'supports' => array(
            'customClassName' => true,
            'anchor' => false,
            'align' => array(
                0 => 'wide',
                1 => 'full',
            ),
            'html' => false,
            'multiple' => true,
            'inserter' => true,
        ),
        'controls' => array(
            'control_bd49914e66' => array(
                'sort' => '',
                'child_of' => '',
                'label' => 'Label',
                'name' => 'label',
                'type' => 'text',
                'allow_null' => 'false',
                'min' => '',
                'max' => '',
                'step' => '',
                'date_time_picker' => 'date_time',
                'multiline' => 'false',
                'default' => '',
                'checked' => 'false',
                'placeholder' => '',
                'help' => '',
                'placement' => 'content',
                'save_in_meta' => 'false',
                'save_in_meta_name' => '',
            ),
            'control_d9795447e0' => array(
                'sort' => '',
                'child_of' => '',
                'label' => 'File Name',
                'name' => 'file_name',
                'type' => 'text',
                'allow_null' => 'false',
                'min' => '',
                'max' => '',
                'step' => '',
                'date_time_picker' => 'date_time',
                'multiline' => 'false',
                'default' => '',
                'checked' => 'false',
                'placeholder' => '',
                'help' => 'No spaces, use -',
                'placement' => 'content',
                'save_in_meta' => 'false',
                'save_in_meta_name' => '',
            ),
        ),
        'code' => array(
            'editor_html' => '',
            'editor_callback' => '',
            'editor_css' => '',
            'frontend_html' => '<div class="container download">
    <a class="btn btn-outline-primary" target="_blank" href="/files/{{file_name}}">{{label}} <i class="demo-icon icon-download-alt"></i></a>
    </div>',
            'frontend_callback' => '',
            'frontend_css' => '',
        ),
        'condition' => array(
        ),
    ) );

    lazyblocks()->add_block( array(
        'id' => 1438,
        'title' => 'Button Right Arrow',
        'icon' => '',
        'keywords' => array(
        ),
        'slug' => 'lazyblock/button-right-arrow',
        'description' => '',
        'category' => 'layout',
        'category_label' => 'layout',
        'supports' => array(
            'customClassName' => true,
            'anchor' => false,
            'align' => array(
                0 => 'wide',
                1 => 'full',
            ),
            'html' => false,
            'multiple' => true,
            'inserter' => true,
        ),
        'controls' => array(
            'control_dd3b3a49f3' => array(
                'sort' => '1',
                'child_of' => '',
                'label' => 'Button Label',
                'name' => 'button_label',
                'type' => 'text',
                'allow_null' => 'false',
                'min' => '',
                'max' => '',
                'step' => '',
                'date_time_picker' => 'date_time',
                'multiline' => 'false',
                'default' => '',
                'checked' => 'false',
                'placeholder' => '',
                'help' => '',
                'placement' => 'content',
                'save_in_meta' => 'false',
                'save_in_meta_name' => '',
            ),
            'control_66eab74688' => array(
                'sort' => '2',
                'child_of' => '',
                'label' => 'URL',
                'name' => 'url',
                'type' => 'url',
                'allow_null' => 'false',
                'min' => '',
                'max' => '',
                'step' => '',
                'date_time_picker' => 'date_time',
                'multiline' => 'false',
                'default' => '',
                'checked' => 'false',
                'placeholder' => '',
                'help' => '',
                'placement' => 'content',
                'save_in_meta' => 'false',
                'save_in_meta_name' => '',
            ),
            'control_6d2af04d64' => array(
                'sort' => '',
                'child_of' => '',
                'label' => 'Target',
                'name' => 'target',
                'type' => 'select',
                'choices' => array(
                    array(
                        'value' => '_self',
                        'label' => 'Open in same window',
                    ),
                    array(
                        'value' => '_blank',
                        'label' => 'Open in new window',
                    ),
                ),
                'allow_null' => 'false',
                'min' => '',
                'max' => '',
                'step' => '',
                'date_time_picker' => 'date_time',
                'multiline' => 'false',
                'default' => '_self',
                'checked' => 'false',
                'placeholder' => '',
                'help' => '',
                'placement' => 'content',
                'save_in_meta' => 'false',
                'save_in_meta_name' => '',
            ),
        ),
        'code' => array(
            'editor_html' => '',
            'editor_callback' => '',
            'editor_css' => '',
            'frontend_html' => '<a class="btn btn-primary right-arrow" target="{{target}}" href="{{url}}">{{button_label}}</a>',
            'frontend_callback' => '',
            'frontend_css' => '',
        ),
        'condition' => array(
        ),
    ) );

    lazyblocks()->add_block( array(
        'id' => 1336,
        'title' => 'Centered Blue Header',
        'icon' => '',
        'keywords' => array(
        ),
        'slug' => 'lazyblock/centered-blue-header',
        'description' => '',
        'category' => 'layout',
        'category_label' => 'layout',
        'supports' => array(
            'customClassName' => true,
            'anchor' => false,
            'align' => array(
                0 => 'wide',
                1 => 'full',
            ),
            'html' => false,
            'multiple' => true,
            'inserter' => true,
        ),
        'controls' => array(
            'control_940b9b4f71' => array(
                'sort' => '',
                'child_of' => '',
                'label' => '',
                'name' => 'headline',
                'type' => 'rich_text',
                'allow_null' => 'false',
                'min' => '',
                'max' => '',
                'step' => '',
                'date_time_picker' => 'date_time',
                'multiline' => 'false',
                'default' => '',
                'checked' => 'false',
                'placeholder' => '',
                'help' => '',
                'placement' => 'content',
                'save_in_meta' => 'false',
                'save_in_meta_name' => '',
            ),
            'control_2628204deb' => array(
                'sort' => '',
                'child_of' => '',
                'label' => 'Tag Selection',
                'name' => 'tag_selection',
                'type' => 'select',
                'choices' => array(
                    array(
                        'value' => 'h2',
                        'label' => 'H2',
                    ),
                    array(
                        'value' => 'h3',
                        'label' => 'H3',
                    ),
                    array(
                        'value' => 'h4',
                        'label' => 'H4',
                    ),
                    array(
                        'value' => 'h5',
                        'label' => 'H5',
                    ),
                    array(
                        'value' => 'h6',
                        'label' => 'H6',
                    ),
                    array(
                        'value' => 'p',
                        'label' => 'P',
                    ),
                ),
                'allow_null' => 'false',
                'min' => '',
                'max' => '',
                'step' => '',
                'date_time_picker' => 'date_time',
                'multiline' => 'false',
                'default' => 'p',
                'checked' => 'false',
                'placeholder' => '',
                'help' => '',
                'placement' => 'content',
                'save_in_meta' => 'false',
                'save_in_meta_name' => '',
            ),
        ),
        'code' => array(
            'editor_html' => '',
            'editor_callback' => '',
            'editor_css' => '',
            'frontend_html' => '<{{tag_selection}} class="centered-blue-header">{{{headline}}}</{{tag_selection}}>',
            'frontend_callback' => '',
            'frontend_css' => '',
        ),
        'condition' => array(
        ),
    ) );

    lazyblocks()->add_block( array(
        'id' => 1067,
        'title' => 'Disclaimer',
        'icon' => '',
        'keywords' => array(
        ),
        'slug' => 'lazyblock/disclaimer',
        'description' => '',
        'category' => 'formatting',
        'category_label' => 'formatting',
        'supports' => array(
            'customClassName' => true,
            'anchor' => false,
            'align' => array(
                0 => 'wide',
                1 => 'full',
            ),
            'html' => false,
            'multiple' => true,
            'inserter' => true,
        ),
        'controls' => array(
            'control_dcf8194d23' => array(
                'sort' => '',
                'child_of' => '',
                'label' => '',
                'name' => 'copy',
                'type' => 'text',
                'allow_null' => 'false',
                'min' => '',
                'max' => '',
                'step' => '',
                'date_time_picker' => 'date_time',
                'multiline' => 'false',
                'default' => '',
                'checked' => 'false',
                'placeholder' => '',
                'help' => '',
                'placement' => 'content',
                'save_in_meta' => 'false',
                'save_in_meta_name' => '',
            ),
        ),
        'code' => array(
            'editor_html' => '',
            'editor_callback' => '',
            'editor_css' => '',
            'frontend_html' => '<p class="disclaimer">{{copy}}</p>',
            'frontend_callback' => '',
            'frontend_css' => '',
        ),
        'condition' => array(
        ),
    ) );

    lazyblocks()->add_block( array(
        'id' => 1063,
        'title' => 'Tabset Header',
        'icon' => '',
        'keywords' => array(
        ),
        'slug' => 'lazyblock/tabset-header',
        'description' => '',
        'category' => 'formatting',
        'category_label' => 'formatting',
        'supports' => array(
            'customClassName' => true,
            'anchor' => false,
            'align' => array(
                0 => 'wide',
                1 => 'full',
            ),
            'html' => false,
            'multiple' => true,
            'inserter' => true,
        ),
        'controls' => array(
            'control_f38971408b' => array(
                'sort' => '',
                'child_of' => '',
                'label' => '',
                'name' => 'title',
                'type' => 'rich_text',
                'allow_null' => 'false',
                'min' => '',
                'max' => '',
                'step' => '',
                'date_time_picker' => 'date_time',
                'multiline' => 'false',
                'default' => '',
                'checked' => 'false',
                'placeholder' => '',
                'help' => '',
                'placement' => 'content',
                'save_in_meta' => 'false',
                'save_in_meta_name' => '',
            ),
        ),
        'code' => array(
            'editor_html' => '',
            'editor_callback' => '',
            'editor_css' => '',
            'frontend_html' => '<div class="container tab-heading">
    {{title}}
    </div>',
            'frontend_callback' => '',
            'frontend_css' => '',
        ),
        'condition' => array(
        ),
    ) );

    lazyblocks()->add_block( array(
        'id' => 893,
        'title' => 'Media Object',
        'icon' => '',
        'keywords' => array(
        ),
        'slug' => 'lazyblock/media-object',
        'description' => '',
        'category' => 'layout',
        'category_label' => 'layout',
        'supports' => array(
            'customClassName' => true,
            'anchor' => false,
            'align' => array(
                0 => 'wide',
                1 => 'full',
            ),
            'html' => false,
            'multiple' => true,
            'inserter' => true,
        ),
        'controls' => array(
            'control_3b596f4682' => array(
                'sort' => '1',
                'child_of' => '',
                'label' => 'Image',
                'name' => 'image',
                'type' => 'image',
                'allow_null' => 'false',
                'min' => '',
                'max' => '',
                'step' => '',
                'date_time_picker' => 'date_time',
                'multiline' => 'false',
                'default' => '',
                'checked' => 'false',
                'placeholder' => '',
                'help' => '',
                'placement' => 'content',
                'save_in_meta' => 'false',
                'save_in_meta_name' => '',
            ),
            'control_872ba64085' => array(
                'sort' => '2',
                'child_of' => '',
                'label' => 'Image Alignment',
                'name' => 'alignment',
                'type' => 'select',
                'choices' => array(
                    array(
                        'value' => 'top',
                        'label' => 'Top',
                    ),
                    array(
                        'value' => 'middle',
                        'label' => 'Middle',
                    ),
                    array(
                        'value' => 'bottom',
                        'label' => 'Bottom',
                    ),
                ),
                'allow_null' => 'false',
                'min' => '',
                'max' => '',
                'step' => '',
                'date_time_picker' => 'date_time',
                'multiline' => 'false',
                'default' => 'top',
                'checked' => 'false',
                'placeholder' => '',
                'help' => '',
                'placement' => 'content',
                'save_in_meta' => 'false',
                'save_in_meta_name' => '',
            ),
            'control_d0f90044d1' => array(
                'sort' => '3',
                'child_of' => '',
                'label' => 'Body Content',
                'name' => 'container',
                'type' => 'inner_blocks',
                'allow_null' => 'false',
                'min' => '',
                'max' => '',
                'step' => '',
                'date_time_picker' => 'date_time',
                'multiline' => 'false',
                'default' => '',
                'checked' => 'false',
                'placeholder' => '',
                'help' => '',
                'placement' => 'content',
                'save_in_meta' => 'false',
                'save_in_meta_name' => '',
            ),
            'control_9d4a774aec' => array(
                'sort' => '',
                'child_of' => '',
                'label' => 'Body Alignment',
                'name' => 'body_alignment',
                'type' => 'select',
                'choices' => array(
                    array(
                        'value' => 'top',
                        'label' => 'Top',
                    ),
                    array(
                        'value' => 'middle',
                        'label' => 'Middle',
                    ),
                    array(
                        'value' => 'bottom',
                        'label' => 'Bottom',
                    ),
                ),
                'allow_null' => 'false',
                'min' => '',
                'max' => '',
                'step' => '',
                'date_time_picker' => 'date_time',
                'multiline' => 'false',
                'default' => 'top',
                'checked' => 'false',
                'placeholder' => '',
                'help' => '',
                'placement' => 'content',
                'save_in_meta' => 'false',
                'save_in_meta_name' => '',
            ),
        ),
        'code' => array(
            'editor_html' => '',
            'editor_callback' => '',
            'editor_css' => '',
            'frontend_html' => '<div class="media">
    <img class="{{alignment}}" src="{{image.url}}" alt="{{image.alt}}">
    <div class="media-body {{body_alignment}}">
    {{{container}}}
    </div>
    </div>',
            'frontend_callback' => '',
            'frontend_css' => '',
        ),
        'condition' => array(
        ),
    ) );

    lazyblocks()->add_block( array(
        'id' => 834,
        'title' => 'Tabset Item 2',
        'icon' => '',
        'keywords' => array(
        ),
        'slug' => 'lazyblock/tab-item-two',
        'description' => '',
        'category' => 'layout',
        'category_label' => 'layout',
        'supports' => array(
            'customClassName' => true,
            'anchor' => false,
            'align' => array(
                0 => 'wide',
                1 => 'full',
            ),
            'html' => false,
            'multiple' => true,
            'inserter' => true,
        ),
        'controls' => array(
            'control_766b004020' => array(
                'sort' => '',
                'child_of' => '',
                'label' => '',
                'name' => 'container',
                'type' => 'inner_blocks',
                'allow_null' => 'false',
                'min' => '',
                'max' => '',
                'step' => '',
                'date_time_picker' => 'date_time',
                'multiline' => 'false',
                'default' => '',
                'checked' => 'false',
                'placeholder' => '',
                'help' => '',
                'placement' => 'content',
                'save_in_meta' => 'false',
                'save_in_meta_name' => '',
            ),
        ),
        'code' => array(
            'editor_html' => '',
            'editor_callback' => '',
            'editor_css' => '',
            'frontend_html' => '<div id="tab-1" class="tab-content">{{{container}}}</div>',
            'frontend_callback' => '',
            'frontend_css' => '',
        ),
        'condition' => array(
        ),
    ) );

    lazyblocks()->add_block( array(
        'id' => 829,
        'title' => 'Tabset Item 1',
        'icon' => '',
        'keywords' => array(
        ),
        'slug' => 'lazyblock/tab-item-one',
        'description' => '',
        'category' => 'layout',
        'category_label' => 'layout',
        'supports' => array(
            'customClassName' => true,
            'anchor' => false,
            'align' => array(
                0 => 'wide',
                1 => 'full',
            ),
            'html' => false,
            'multiple' => true,
            'inserter' => true,
        ),
        'controls' => array(
            'control_eceab74545' => array(
                'sort' => '',
                'child_of' => '',
                'label' => '',
                'name' => 'container',
                'type' => 'inner_blocks',
                'allow_null' => 'false',
                'min' => '',
                'max' => '',
                'step' => '',
                'date_time_picker' => 'date_time',
                'multiline' => 'false',
                'default' => '',
                'checked' => 'false',
                'placeholder' => '',
                'help' => '',
                'placement' => 'content',
                'save_in_meta' => 'false',
                'save_in_meta_name' => '',
            ),
        ),
        'code' => array(
            'editor_html' => '',
            'editor_callback' => '',
            'editor_css' => '',
            'frontend_html' => '<div id="tab-0" class="tab-content current">{{{container}}}</div>',
            'frontend_callback' => '',
            'frontend_css' => '',
        ),
        'condition' => array(
        ),
    ) );

    lazyblocks()->add_block( array(
        'id' => 810,
        'title' => 'Tabset Menu',
        'icon' => '',
        'keywords' => array(
        ),
        'slug' => 'lazyblock/tabset',
        'description' => '',
        'category' => 'layout',
        'category_label' => 'layout',
        'supports' => array(
            'customClassName' => true,
            'anchor' => false,
            'align' => array(
                0 => 'wide',
                1 => 'full',
            ),
            'html' => false,
            'multiple' => true,
            'inserter' => true,
        ),
        'controls' => array(
            'control_75cafe4363' => array(
                'sort' => '',
                'child_of' => '',
                'label' => '',
                'name' => 'repeater',
                'type' => 'repeater',
                'allow_null' => 'false',
                'min' => '',
                'max' => '',
                'step' => '',
                'date_time_picker' => 'date_time',
                'multiline' => 'false',
                'default' => '',
                'checked' => 'false',
                'placeholder' => '',
                'help' => '',
                'placement' => 'content',
                'save_in_meta' => 'false',
                'save_in_meta_name' => '',
            ),
            'control_713adb4a86' => array(
                'sort' => '',
                'child_of' => 'control_75cafe4363',
                'label' => 'Tab Name',
                'name' => 'tab_name',
                'type' => 'text',
                'allow_null' => 'false',
                'min' => '',
                'max' => '',
                'step' => '',
                'date_time_picker' => 'date_time',
                'multiline' => 'false',
                'default' => '',
                'checked' => 'false',
                'placeholder' => '',
                'help' => '',
                'placement' => 'content',
                'save_in_meta' => 'false',
                'save_in_meta_name' => '',
            ),
        ),
        'code' => array(
            'editor_html' => '',
            'editor_callback' => '',
            'editor_css' => '',
            'frontend_html' => '<ul class="tabs">
    {{#each repeater}}
    <li class="tab-link" data-tab="tab-{{@index}}">{{tab_name}}</li>
    {{/each}}
    </ul>



    ',
            'frontend_callback' => '',
            'frontend_css' => '',
        ),
        'condition' => array(
        ),
    ) );

    lazyblocks()->add_block( array(
        'id' => 678,
        'title' => 'Headline Box',
        'icon' => '',
        'keywords' => array(
        ),
        'slug' => 'lazyblock/boxed-header',
        'description' => '',
        'category' => 'formatting',
        'category_label' => 'formatting',
        'supports' => array(
            'customClassName' => true,
            'anchor' => false,
            'align' => array(
                0 => 'wide',
                1 => 'full',
            ),
            'html' => false,
            'multiple' => true,
            'inserter' => true,
        ),
        'controls' => array(
            'control_9e18ec499c' => array(
                'sort' => '',
                'child_of' => '',
                'label' => '',
                'name' => 'text',
                'type' => 'rich_text',
                'allow_null' => 'false',
                'min' => '',
                'max' => '',
                'step' => '',
                'date_time_picker' => 'date_time',
                'multiline' => 'false',
                'default' => '',
                'checked' => 'false',
                'placeholder' => '',
                'help' => 'Select HTML tag below, will not effect appearance.',
                'placement' => 'content',
                'save_in_meta' => 'false',
                'save_in_meta_name' => '',
            ),
            'control_6ce82b4150' => array(
                'sort' => '',
                'child_of' => '',
                'label' => 'Tag Selection',
                'name' => 'tag_selection',
                'type' => 'select',
                'choices' => array(
                    array(
                        'value' => 'h2',
                        'label' => 'H2',
                    ),
                    array(
                        'value' => 'h3',
                        'label' => 'H3',
                    ),
                    array(
                        'value' => 'h4',
                        'label' => 'H4',
                    ),
                    array(
                        'value' => 'h5',
                        'label' => 'H5',
                    ),
                    array(
                        'value' => 'h6',
                        'label' => 'H6',
                    ),
                    array(
                        'value' => 'p',
                        'label' => 'P',
                    ),
                ),
                'allow_null' => 'false',
                'min' => '',
                'max' => '',
                'step' => '',
                'date_time_picker' => 'date_time',
                'multiline' => 'false',
                'default' => 'p',
                'checked' => 'false',
                'placeholder' => '',
                'help' => '',
                'placement' => 'content',
                'save_in_meta' => 'false',
                'save_in_meta_name' => '',
            ),
            'control_d01b2b4521' => array(
                'sort' => '',
                'child_of' => '',
                'label' => 'Background Color',
                'name' => 'background_color',
                'type' => 'select',
                'choices' => array(
                    array(
                        'value' => 'dark',
                        'label' => 'Dark',
                    ),
                    array(
                        'value' => 'mid',
                        'label' => 'Mid',
                    ),
                    array(
                        'value' => 'white',
                        'label' => 'White',
                    ),
                ),
                'allow_null' => 'false',
                'min' => '',
                'max' => '',
                'step' => '',
                'date_time_picker' => 'date_time',
                'multiline' => 'false',
                'default' => 'dark',
                'checked' => 'false',
                'placeholder' => '',
                'help' => '',
                'placement' => 'content',
                'save_in_meta' => 'false',
                'save_in_meta_name' => '',
            ),
        ),
        'code' => array(
            'editor_html' => '',
            'editor_callback' => '',
            'editor_css' => '',
            'frontend_html' => '<div class="boxed-header {{background_color}}">
    <div class="container">
    <{{tag_selection}} class="content">{{{text}}}</{{tag_selection}}>
    </div>
    </div>',
            'frontend_callback' => '',
            'frontend_css' => '',
        ),
        'condition' => array(
        ),
    ) );

    lazyblocks()->add_block( array(
        'id' => 670,
        'title' => 'Paragraph',
        'icon' => '',
        'keywords' => array(
        ),
        'slug' => 'lazyblock/paragraph',
        'description' => '',
        'category' => 'formatting',
        'category_label' => 'formatting',
        'supports' => array(
            'customClassName' => true,
            'anchor' => false,
            'align' => array(
                0 => 'wide',
                1 => 'full',
            ),
            'html' => false,
            'multiple' => true,
            'inserter' => true,
        ),
        'controls' => array(
            'control_861a114a70' => array(
                'sort' => '',
                'child_of' => '',
                'label' => '',
                'name' => 'paragraph',
                'type' => 'rich_text',
                'allow_null' => 'false',
                'min' => '',
                'max' => '',
                'step' => '',
                'date_time_picker' => 'date_time',
                'multiline' => 'true',
                'default' => '',
                'checked' => 'false',
                'placeholder' => '',
                'help' => '',
                'placement' => 'content',
                'save_in_meta' => 'false',
                'save_in_meta_name' => '',
            ),
        ),
        'code' => array(
            'editor_html' => '',
            'editor_callback' => '',
            'editor_css' => '',
            'frontend_html' => '{{{paragraph}}}',
            'frontend_callback' => '',
            'frontend_css' => '',
        ),
        'condition' => array(
        ),
    ) );

    lazyblocks()->add_block( array(
        'id' => 654,
        'title' => 'H3 Heading',
        'icon' => '',
        'keywords' => array(
        ),
        'slug' => 'lazyblock/h3',
        'description' => '',
        'category' => 'formatting',
        'category_label' => 'formatting',
        'supports' => array(
            'customClassName' => true,
            'anchor' => false,
            'align' => array(
                0 => 'wide',
                1 => 'full',
            ),
            'html' => false,
            'multiple' => true,
            'inserter' => true,
        ),
        'controls' => array(
            'control_131a414b17' => array(
                'sort' => '',
                'child_of' => '',
                'label' => '',
                'name' => 'h3',
                'type' => 'rich_text',
                'allow_null' => 'false',
                'min' => '',
                'max' => '',
                'step' => '',
                'date_time_picker' => 'date_time',
                'multiline' => 'false',
                'default' => '',
                'checked' => 'false',
                'placeholder' => '',
                'help' => '',
                'placement' => 'content',
                'save_in_meta' => 'false',
                'save_in_meta_name' => '',
            ),
        ),
        'code' => array(
            'editor_html' => '',
            'editor_callback' => '',
            'editor_css' => '',
            'frontend_html' => '<h3>{{{h3}}}</h3>',
            'frontend_callback' => '',
            'frontend_css' => '',
        ),
        'condition' => array(
        ),
    ) );

    lazyblocks()->add_block( array(
        'id' => 649,
        'title' => 'H2 Heading',
        'icon' => '',
        'keywords' => array(
        ),
        'slug' => 'lazyblock/h2',
        'description' => '',
        'category' => 'formatting',
        'category_label' => 'formatting',
        'supports' => array(
            'customClassName' => true,
            'anchor' => false,
            'align' => array(
                0 => 'wide',
                1 => 'full',
            ),
            'html' => false,
            'multiple' => true,
            'inserter' => true,
        ),
        'controls' => array(
            'control_4f1959455e' => array(
                'sort' => '',
                'child_of' => '',
                'label' => '',
                'name' => 'h2',
                'type' => 'rich_text',
                'allow_null' => 'false',
                'min' => '',
                'max' => '',
                'step' => '',
                'date_time_picker' => 'date_time',
                'multiline' => 'false',
                'default' => '',
                'checked' => 'false',
                'placeholder' => '',
                'help' => '',
                'placement' => 'content',
                'save_in_meta' => 'false',
                'save_in_meta_name' => '',
            ),
        ),
        'code' => array(
            'editor_html' => '',
            'editor_callback' => '',
            'editor_css' => '',
            'frontend_html' => '<h2>{{{h2}}}</h2>',
            'frontend_callback' => '',
            'frontend_css' => '',
        ),
        'condition' => array(
        ),
    ) );

    lazyblocks()->add_block( array(
        'id' => 638,
        'title' => 'H1 Initial Header',
        'icon' => '',
        'keywords' => array(
        ),
        'slug' => 'lazyblock/initial-header',
        'description' => '',
        'category' => 'formatting',
        'category_label' => 'formatting',
        'supports' => array(
            'customClassName' => true,
            'anchor' => false,
            'align' => array(
                0 => 'wide',
                1 => 'full',
            ),
            'html' => false,
            'multiple' => true,
            'inserter' => true,
        ),
        'controls' => array(
            'control_f14a554dac' => array(
                'sort' => '',
                'child_of' => '',
                'label' => '',
                'name' => 'h1',
                'type' => 'rich_text',
                'allow_null' => 'false',
                'min' => '',
                'max' => '',
                'step' => '',
                'date_time_picker' => 'date_time',
                'multiline' => 'false',
                'default' => '',
                'checked' => 'false',
                'placeholder' => '',
                'help' => '',
                'placement' => 'content',
                'save_in_meta' => 'false',
                'save_in_meta_name' => '',
            ),
        ),
        'code' => array(
            'editor_html' => '',
            'editor_callback' => '',
            'editor_css' => '',
            'frontend_html' => '<header class="entry-header">
    <h1>{{{h1}}}</h1>
    </header>',
            'frontend_callback' => '',
            'frontend_css' => '',
        ),
        'condition' => array(
        ),
    ) );

    lazyblocks()->add_block( array(
        'id' => 447,
        'title' => 'Spellout',
        'icon' => '',
        'keywords' => array(
        ),
        'slug' => 'lazyblock/spellout',
        'description' => '',
        'category' => 'formatting',
        'category_label' => 'formatting',
        'supports' => array(
            'customClassName' => true,
            'anchor' => false,
            'align' => array(
                0 => 'wide',
                1 => 'full',
            ),
            'html' => false,
            'multiple' => true,
            'inserter' => true,
        ),
        'controls' => array(
            'control_ddd9fd4c3a' => array(
                'sort' => '',
                'child_of' => '',
                'label' => '',
                'name' => 'spellout',
                'type' => 'text',
                'allow_null' => 'false',
                'min' => '',
                'max' => '',
                'step' => '',
                'date_time_picker' => 'date_time',
                'multiline' => 'false',
                'default' => '',
                'checked' => 'false',
                'placeholder' => '',
                'help' => '',
                'placement' => 'content',
                'save_in_meta' => 'false',
                'save_in_meta_name' => '',
            ),
        ),
        'code' => array(
            'editor_html' => '',
            'editor_callback' => '',
            'editor_css' => '',
            'frontend_html' => '<p class="spellout">{{spellout}}</p>',
            'frontend_callback' => '',
            'frontend_css' => '',
        ),
        'condition' => array(
        ),
    ) );

    lazyblocks()->add_block( array(
        'id' => 411,
        'title' => 'Footnote Section',
        'icon' => '',
        'keywords' => array(
        ),
        'slug' => 'lazyblock/footnote',
        'description' => '',
        'category' => 'formatting',
        'category_label' => 'formatting',
        'supports' => array(
            'customClassName' => true,
            'anchor' => false,
            'align' => array(
                0 => 'wide',
                1 => 'full',
            ),
            'html' => false,
            'multiple' => true,
            'inserter' => true,
        ),
        'controls' => array(
            'control_0fcab8412e' => array(
                'sort' => '1',
                'child_of' => '',
                'label' => '',
                'name' => 'container',
                'type' => 'inner_blocks',
                'allow_null' => 'false',
                'min' => '',
                'max' => '',
                'step' => '',
                'date_time_picker' => 'date_time',
                'multiline' => 'false',
                'default' => '',
                'checked' => 'false',
                'placeholder' => '',
                'help' => '',
                'placement' => 'nowhere',
                'save_in_meta' => 'false',
                'save_in_meta_name' => '',
            ),
            'control_c339e344ac' => array(
                'sort' => '2',
                'child_of' => '',
                'label' => '',
                'name' => 'repeater',
                'type' => 'repeater',
                'allow_null' => 'false',
                'min' => '',
                'max' => '',
                'step' => '',
                'date_time_picker' => 'date_time',
                'multiline' => 'false',
                'default' => '',
                'checked' => 'false',
                'placeholder' => '',
                'help' => '',
                'placement' => 'content',
                'save_in_meta' => 'false',
                'save_in_meta_name' => '',
            ),
            'control_ed28ec4ea5' => array(
                'sort' => '3',
                'child_of' => 'control_c339e344ac',
                'label' => 'Footnote',
                'name' => 'footnote',
                'type' => 'rich_text',
                'allow_null' => 'false',
                'min' => '',
                'max' => '',
                'step' => '',
                'date_time_picker' => 'date_time',
                'multiline' => 'false',
                'default' => '',
                'checked' => 'false',
                'placeholder' => '',
                'help' => '',
                'placement' => 'content',
                'save_in_meta' => 'false',
                'save_in_meta_name' => '',
            ),
        ),
        'code' => array(
            'editor_html' => '',
            'editor_callback' => '',
            'editor_css' => '',
            'frontend_html' => '{{{container}}}
    <ol class="letters">
    {{#each repeater}}
    <li>{{{footnote}}}</li>
    {{/each}}
    </ol>',
            'frontend_callback' => '',
            'frontend_css' => '',
        ),
        'condition' => array(
        ),
    ) );

    lazyblocks()->add_block( array(
        'id' => 322,
        'title' => 'Fixed Spacer',
        'icon' => '',
        'keywords' => array(
        ),
        'slug' => 'lazyblock/fixed-spacer',
        'description' => 'White fluid separator.',
        'category' => 'layout',
        'category_label' => 'layout',
        'supports' => array(
            'customClassName' => true,
            'anchor' => false,
            'align' => array(
                0 => 'wide',
                1 => 'full',
            ),
            'html' => false,
            'multiple' => true,
            'inserter' => true,
        ),
        'controls' => array(
        ),
        'code' => array(
            'editor_html' => '',
            'editor_callback' => '',
            'editor_css' => '',
            'frontend_html' => '<span class="fixed-spacer"></span>',
            'frontend_callback' => '',
            'frontend_css' => '',
        ),
        'condition' => array(
        ),
    ) );

    lazyblocks()->add_block( array(
        'id' => 314,
        'title' => 'Front Billboard',
        'icon' => '',
        'keywords' => array(
        ),
        'slug' => 'lazyblock/front-billboard',
        'description' => 'Large billboard area on homepage.',
        'category' => 'layout',
        'category_label' => 'layout',
        'supports' => array(
            'customClassName' => true,
            'anchor' => false,
            'align' => array(
                0 => 'wide',
                1 => 'full',
            ),
            'html' => false,
            'multiple' => true,
            'inserter' => true,
        ),
        'controls' => array(
            'control_594a5346cc' => array(
                'sort' => '1',
                'child_of' => '',
                'label' => '',
                'name' => 'container',
                'type' => 'inner_blocks',
                'allow_null' => 'false',
                'min' => '',
                'max' => '',
                'step' => '',
                'date_time_picker' => 'date_time',
                'multiline' => 'false',
                'default' => '',
                'checked' => 'false',
                'placeholder' => '',
                'help' => '',
                'placement' => 'nowhere',
                'save_in_meta' => 'false',
                'save_in_meta_name' => '',
            ),
            'control_25384a4e65' => array(
                'sort' => '2',
                'child_of' => '',
                'label' => 'Headline',
                'name' => 'headline',
                'type' => 'text',
                'allow_null' => 'false',
                'min' => '',
                'max' => '',
                'step' => '',
                'date_time_picker' => 'date_time',
                'multiline' => 'false',
                'default' => '',
                'checked' => 'false',
                'placeholder' => '',
                'help' => 'Select HTML tag below, will not effect appearance.',
                'placement' => 'content',
                'save_in_meta' => 'false',
                'save_in_meta_name' => '',
            ),
            'control_f5eb824e4d' => array(
                'sort' => '3',
                'child_of' => '',
                'label' => 'Tag Selection',
                'name' => 'tag_selection',
                'type' => 'select',
                'choices' => array(
                    array(
                        'value' => 'h1',
                        'label' => 'H1',
                    ),
                    array(
                        'value' => 'h2',
                        'label' => 'H2',
                    ),
                ),
                'allow_null' => 'false',
                'min' => '',
                'max' => '',
                'step' => '',
                'date_time_picker' => 'date_time',
                'multiline' => 'false',
                'default' => 'h1',
                'checked' => 'false',
                'placeholder' => '',
                'help' => '',
                'placement' => 'content',
                'save_in_meta' => 'false',
                'save_in_meta_name' => '',
            ),
            'control_d599ff4651' => array(
                'sort' => '4',
                'child_of' => '',
                'label' => 'Subhead',
                'name' => 'subhead',
                'type' => 'text',
                'allow_null' => 'false',
                'min' => '',
                'max' => '',
                'step' => '',
                'date_time_picker' => 'date_time',
                'multiline' => 'false',
                'default' => '',
                'checked' => 'false',
                'placeholder' => '',
                'help' => '',
                'placement' => 'content',
                'save_in_meta' => 'false',
                'save_in_meta_name' => '',
            ),
            'control_fba9ac4de0' => array(
                'sort' => '5',
                'child_of' => '',
                'label' => 'Tag Selection',
                'name' => 'tag_selection_2',
                'type' => 'select',
                'choices' => array(
                    array(
                        'value' => 'h1',
                        'label' => 'H1',
                    ),
                    array(
                        'value' => 'h2',
                        'label' => 'H2',
                    ),
                    array(
                        'value' => 'h3',
                        'label' => 'H3',
                    ),
                ),
                'allow_null' => 'false',
                'min' => '',
                'max' => '',
                'step' => '',
                'date_time_picker' => 'date_time',
                'multiline' => 'false',
                'default' => '',
                'checked' => 'false',
                'placeholder' => '',
                'help' => '',
                'placement' => 'content',
                'save_in_meta' => 'false',
                'save_in_meta_name' => '',
            ),
            'control_2b08514725' => array(
                'sort' => '6',
                'child_of' => '',
                'label' => 'Body',
                'name' => 'body',
                'type' => 'rich_text',
                'allow_null' => 'false',
                'min' => '',
                'max' => '',
                'step' => '',
                'date_time_picker' => 'date_time',
                'multiline' => 'false',
                'default' => '',
                'checked' => 'false',
                'placeholder' => '',
                'help' => 'Use Bold in (WYSIWYG) to keep a word from breaking, will not effect appearance.',
                'placement' => 'content',
                'save_in_meta' => 'false',
                'save_in_meta_name' => '',
            ),
            'control_97c9ce4984' => array(
                'sort' => '7',
                'child_of' => '',
                'label' => 'CTA Button',
                'name' => 'cta_button',
                'type' => 'text',
                'allow_null' => 'false',
                'min' => '',
                'max' => '',
                'step' => '',
                'date_time_picker' => 'date_time',
                'multiline' => 'false',
                'default' => '',
                'checked' => 'false',
                'placeholder' => '',
                'help' => '',
                'placement' => 'content',
                'save_in_meta' => 'false',
                'save_in_meta_name' => '',
            ),
            'control_789ba545e4' => array(
                'sort' => '8',
                'child_of' => '',
                'label' => 'CTA Link',
                'name' => 'cta_link',
                'type' => 'url',
                'allow_null' => 'false',
                'min' => '',
                'max' => '',
                'step' => '',
                'date_time_picker' => 'date_time',
                'multiline' => 'false',
                'default' => '',
                'checked' => 'false',
                'placeholder' => '',
                'help' => '',
                'placement' => 'content',
                'save_in_meta' => 'false',
                'save_in_meta_name' => '',
            ),
        ),
        'code' => array(
            'editor_html' => '',
            'editor_callback' => '',
            'editor_css' => '',
            'frontend_html' => '<div id="billboard">
    <div>
    {{{container}}}
    <{{tag_selection}} class="headline">{{headline}}</{{tag_selection}}>
    {{#if subhead}}
    <{{tag_selection_2}} class="subhead">{{subhead}}</{{tag_selection}}>
    {{/if}}
    <p>{{{body}}}</p>
    {{#if cta_button}}
    <a class="btn btn-primary right-arrow" href="{{cta_link}}">{{cta_button}}</a>
    {{/if}}
    </div>
    </div>',
            'frontend_callback' => '',
            'frontend_css' => '',
        ),
        'condition' => array(
        ),
    ) );

    lazyblocks()->add_block( array(
        'id' => 261,
        'title' => 'Text Left - CTA',
        'icon' => '',
        'keywords' => array(
        ),
        'slug' => 'lazyblock/text-left-cta',
        'description' => '',
        'category' => 'layout',
        'category_label' => 'layout',
        'supports' => array(
            'customClassName' => true,
            'anchor' => false,
            'align' => array(
                0 => 'wide',
                1 => 'full',
            ),
            'html' => false,
            'multiple' => true,
            'inserter' => true,
        ),
        'controls' => array(
            'control_f5593f4a0c' => array(
                'sort' => '1',
                'child_of' => '',
                'label' => '',
                'name' => 'container',
                'type' => 'inner_blocks',
                'allow_null' => 'false',
                'min' => '',
                'max' => '',
                'step' => '',
                'date_time_picker' => 'date_time',
                'multiline' => 'false',
                'default' => '',
                'checked' => 'false',
                'placeholder' => '',
                'help' => '',
                'placement' => 'nowhere',
                'save_in_meta' => 'false',
                'save_in_meta_name' => '',
            ),
            'control_5148c5408f' => array(
                'sort' => '2',
                'child_of' => '',
                'label' => 'Headline',
                'name' => 'headline',
                'type' => 'text',
                'allow_null' => 'false',
                'min' => '',
                'max' => '',
                'step' => '',
                'date_time_picker' => 'date_time',
                'multiline' => 'false',
                'default' => '',
                'checked' => 'false',
                'placeholder' => '',
                'help' => 'Select HTML tag below, will not effect appearance.',
                'placement' => 'content',
                'save_in_meta' => 'false',
                'save_in_meta_name' => '',
            ),
            'control_dc1a044be6' => array(
                'sort' => '3',
                'child_of' => '',
                'label' => 'Tag Selection',
                'name' => 'tag_selection',
                'type' => 'select',
                'choices' => array(
                    array(
                        'value' => 'h2',
                        'label' => 'H2',
                    ),
                    array(
                        'value' => 'h3',
                        'label' => 'H3',
                    ),
                    array(
                        'value' => 'h4',
                        'label' => 'H4',
                    ),
                    array(
                        'value' => 'h5',
                        'label' => 'H5',
                    ),
                    array(
                        'value' => 'h6',
                        'label' => 'H6',
                    ),
                ),
                'allow_null' => 'false',
                'min' => '',
                'max' => '',
                'step' => '',
                'date_time_picker' => 'date_time',
                'multiline' => 'false',
                'default' => 'h3',
                'checked' => 'false',
                'placeholder' => '',
                'help' => '',
                'placement' => 'content',
                'save_in_meta' => 'false',
                'save_in_meta_name' => '',
            ),
            'control_15d90f4c72' => array(
                'sort' => '4',
                'child_of' => '',
                'label' => 'Body',
                'name' => 'body',
                'type' => 'text',
                'allow_null' => 'false',
                'min' => '',
                'max' => '',
                'step' => '',
                'date_time_picker' => 'date_time',
                'multiline' => 'false',
                'default' => '',
                'checked' => 'false',
                'placeholder' => '',
                'help' => '',
                'placement' => 'content',
                'save_in_meta' => 'false',
                'save_in_meta_name' => '',
            ),
            'control_623baf44d4' => array(
                'sort' => '5',
                'child_of' => '',
                'label' => 'CTA Button',
                'name' => 'cta_button',
                'type' => 'text',
                'allow_null' => 'false',
                'min' => '',
                'max' => '',
                'step' => '',
                'date_time_picker' => 'date_time',
                'multiline' => 'false',
                'default' => '',
                'checked' => 'false',
                'placeholder' => '',
                'help' => '',
                'placement' => 'content',
                'save_in_meta' => 'false',
                'save_in_meta_name' => '',
            ),
            'control_91f9064126' => array(
                'sort' => '6',
                'child_of' => '',
                'label' => 'CTA Link',
                'name' => 'cta_link',
                'type' => 'url',
                'allow_null' => 'false',
                'min' => '',
                'max' => '',
                'step' => '',
                'date_time_picker' => 'date_time',
                'multiline' => 'false',
                'default' => '',
                'checked' => 'false',
                'placeholder' => '',
                'help' => '',
                'placement' => 'content',
                'save_in_meta' => 'false',
                'save_in_meta_name' => '',
            ),
        ),
        'code' => array(
            'editor_html' => '',
            'editor_callback' => '',
            'editor_css' => '',
            'frontend_html' => '<div>
    {{{container}}}
    <{{tag_selection}} class="headline">{{headline}}</{{tag_selection}}>
    <p>{{body}}</p>
    {{#if cta_button}}
    <a class="btn btn-outline-secondary right-arrow" href="{{cta_link}}">{{cta_button}}</a>
    {{/if}}
    </div>',
            'frontend_callback' => '',
            'frontend_css' => '',
        ),
        'condition' => array(
        ),
    ) );

    lazyblocks()->add_block( array(
        'id' => 225,
        'title' => 'Radius Box with Image and Text',
        'icon' => '',
        'keywords' => array(
        ),
        'slug' => 'lazyblock/radius-box-image-text',
        'description' => '',
        'category' => 'layout',
        'category_label' => 'layout',
        'supports' => array(
            'customClassName' => false,
            'anchor' => false,
            'align' => array(
                0 => 'wide',
                1 => 'full',
            ),
            'html' => false,
            'multiple' => true,
            'inserter' => true,
        ),
        'controls' => array(
            'control_88eb074658' => array(
                'sort' => '1',
                'child_of' => '',
                'label' => 'Container',
                'name' => 'container',
                'type' => 'inner_blocks',
                'allow_null' => 'false',
                'min' => '',
                'max' => '',
                'step' => '',
                'date_time_picker' => 'date_time',
                'multiline' => 'false',
                'default' => '',
                'checked' => 'false',
                'placeholder' => '',
                'help' => '',
                'placement' => 'nowhere',
                'save_in_meta' => 'false',
                'save_in_meta_name' => '',
            ),
            'control_6eba5142cd' => array(
                'sort' => '2',
                'child_of' => '',
                'label' => 'Image',
                'name' => 'image',
                'type' => 'image',
                'allow_null' => 'false',
                'min' => '',
                'max' => '',
                'step' => '',
                'date_time_picker' => 'date_time',
                'multiline' => 'false',
                'default' => '',
                'checked' => 'false',
                'placeholder' => '',
                'help' => '',
                'placement' => 'content',
                'save_in_meta' => 'false',
                'save_in_meta_name' => '',
            ),
            'control_9d2b824732' => array(
                'sort' => '3',
                'child_of' => '',
                'label' => 'Headline',
                'name' => 'headline',
                'type' => 'rich_text',
                'allow_null' => 'false',
                'min' => '',
                'max' => '',
                'step' => '',
                'date_time_picker' => 'date_time',
                'multiline' => 'false',
                'default' => '',
                'checked' => 'false',
                'placeholder' => '',
                'help' => 'Select HTML tag below, will not effect appearance.',
                'placement' => 'content',
                'save_in_meta' => 'false',
                'save_in_meta_name' => '',
            ),
            'control_e3bbc94c12' => array(
                'sort' => '4',
                'child_of' => '',
                'label' => 'Tag Selection',
                'name' => 'tag_selection',
                'type' => 'select',
                'choices' => array(
                    array(
                        'value' => 'h2',
                        'label' => 'H2',
                    ),
                    array(
                        'value' => 'h3',
                        'label' => 'H3',
                    ),
                    array(
                        'value' => 'h4',
                        'label' => 'H4',
                    ),
                    array(
                        'value' => 'h5',
                        'label' => 'H5',
                    ),
                    array(
                        'value' => 'h6',
                        'label' => 'H6',
                    ),
                ),
                'allow_null' => 'false',
                'min' => '',
                'max' => '',
                'step' => '',
                'date_time_picker' => 'date_time',
                'multiline' => 'false',
                'default' => 'h2',
                'checked' => 'false',
                'placeholder' => '',
                'help' => '',
                'placement' => 'content',
                'save_in_meta' => 'false',
                'save_in_meta_name' => '',
            ),
            'control_bd68be4955' => array(
                'sort' => '',
                'child_of' => '',
                'label' => 'Body',
                'name' => 'body',
                'type' => 'textarea',
                'allow_null' => 'false',
                'min' => '',
                'max' => '',
                'step' => '',
                'date_time_picker' => 'date_time',
                'multiline' => 'false',
                'default' => '',
                'checked' => 'false',
                'placeholder' => '',
                'help' => '',
                'placement' => 'content',
                'save_in_meta' => 'false',
                'save_in_meta_name' => '',
            ),
            'control_4448fa402c' => array(
                'sort' => '',
                'child_of' => '',
                'label' => 'CTA Button',
                'name' => 'cta_button',
                'type' => 'text',
                'allow_null' => 'false',
                'min' => '',
                'max' => '',
                'step' => '',
                'date_time_picker' => 'date_time',
                'multiline' => 'false',
                'default' => '',
                'checked' => 'false',
                'placeholder' => '',
                'help' => '',
                'placement' => 'content',
                'save_in_meta' => 'false',
                'save_in_meta_name' => '',
            ),
            'control_eb397341ab' => array(
                'sort' => '',
                'child_of' => '',
                'label' => 'CTA Link',
                'name' => 'cta_link',
                'type' => 'url',
                'allow_null' => 'false',
                'min' => '',
                'max' => '',
                'step' => '',
                'date_time_picker' => 'date_time',
                'multiline' => 'false',
                'default' => '',
                'checked' => 'false',
                'placeholder' => '',
                'help' => '',
                'placement' => 'content',
                'save_in_meta' => 'false',
                'save_in_meta_name' => '',
            ),
        ),
        'code' => array(
            'editor_html' => '',
            'editor_callback' => '',
            'editor_css' => '',
            'frontend_html' => '<div class="radius-box-image-text">
    {{{container}}}
    <img src="{{image.url}}" alt="{{image.alt}}">
    <{{tag_selection}} class="headline">{{{headline}}}</{{tag_selection}}>
    <p>{{body}}</p>
    {{#if cta_button}}
    <a class="btn btn-outline-secondary right-arrow" href="{{cta_link}}">{{cta_button}}</a>
    {{/if}}
    </div>

    ',
            'frontend_callback' => '',
            'frontend_css' => '',
        ),
        'condition' => array(
        ),
    ) );

    lazyblocks()->add_block( array(
        'id' => 205,
        'title' => 'Container',
        'icon' => '',
        'keywords' => array(
        ),
        'slug' => 'lazyblock/container',
        'description' => 'Outer container that keeps columns in the content grid area.',
        'category' => 'layout',
        'category_label' => 'layout',
        'supports' => array(
            'customClassName' => true,
            'anchor' => false,
            'align' => array(
                0 => 'wide',
                1 => 'full',
            ),
            'html' => false,
            'multiple' => true,
            'inserter' => true,
        ),
        'controls' => array(
            'control_69fbe043b1' => array(
                'sort' => '',
                'child_of' => '',
                'label' => '',
                'name' => 'container',
                'type' => 'inner_blocks',
                'allow_null' => 'false',
                'min' => '',
                'max' => '',
                'step' => '',
                'date_time_picker' => 'date_time',
                'multiline' => 'false',
                'default' => '',
                'checked' => 'false',
                'placeholder' => '',
                'help' => '',
                'placement' => 'content',
                'save_in_meta' => 'false',
                'save_in_meta_name' => '',
            ),
            'control_df68d541a3' => array(
                'sort' => '',
                'child_of' => '',
                'label' => 'Container Type',
                'name' => 'container_type',
                'type' => 'select',
                'choices' => array(
                    array(
                        'value' => 'container',
                        'label' => 'Container',
                    ),
                    array(
                        'value' => 'container padding',
                        'label' => 'Container Padding',
                    ),
                    array(
                        'value' => 'container last',
                        'label' => 'Last or only Container in Page',
                    ),
                    array(
                        'value' => 'rounded-box',
                        'label' => 'Rounded Box',
                    ),
                    array(
                        'value' => 'fluid-container',
                        'label' => 'Fluid Container',
                    ),
                    array(
                        'value' => 'fluid-container image right',
                        'label' => 'Fluid Container Image Right',
                    ),
                    array(
                        'value' => 'table-container',
                        'label' => 'Table Container',
                    ),
                    array(
                        'value' => 'table-container background',
                        'label' => 'Table Container on Fluid Background',
                    ),
                    array(
                        'value' => 'table-container background full',
                        'label' => 'Table Full Container on Fluid Background',
                    ),
                ),
                'allow_null' => 'false',
                'min' => '',
                'max' => '',
                'step' => '',
                'date_time_picker' => 'date_time',
                'multiline' => 'false',
                'default' => 'container',
                'checked' => 'false',
                'placeholder' => '',
                'help' => '',
                'placement' => 'content',
                'save_in_meta' => 'false',
                'save_in_meta_name' => '',
            ),
        ),
        'code' => array(
            'editor_html' => '',
            'editor_callback' => '',
            'editor_css' => '',
            'frontend_html' => '<div class="{{container_type}}">{{{container}}}</div>',
            'frontend_callback' => '',
            'frontend_css' => '',
        ),
        'condition' => array(
        ),
    ) );

endif;
