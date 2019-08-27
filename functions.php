<?php
/**
 * Monica Mixes theme functions
 *
 * @package    WordPress/ClassicPress
 * @subpackage Monica_Mixes_Theme
 * @author     Greg Sweet <greg@ccdzine.com>
 * @copyright  Copyright (c) Greg Sweet
 * @link       https://github.com/ControlledChaos/mixes-theme
 * @license    http://www.gnu.org/licenses/gpl-3.0.html
 * @since      1.0.0
 */

// Namespace specificity for theme functions & filters.
namespace Mixes\Functions;

// Restrict direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Get plugins path to check for active plugins.
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

/**
 * Monica Mixes theme functions class
 *
 * @since  1.0.0
 * @access public
 */
final class Functions {

	/**
	 * Return the instance of the class
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {

			$instance = new self;

			// Theme dependencies.
			$instance->dependencies();

		}

		return $instance;
	}

	/**
	 * Constructor magic method
	 *
	 * @since  1.0.0
	 * @access public
	 * @return self
	 */
	public function __construct() {

		// Add theme settings page to the admin menu.
		add_action( 'admin_menu', [ $this, 'settings_page' ] );

		// Swap html 'no-js' class with 'js'.
		add_action( 'wp_head', [ $this, 'js_detect' ], 0 );

		// Theme setup.
		add_action( 'after_setup_theme', [ $this, 'setup' ] );

		// Register widgets.
        add_action( 'widgets_init', [ $this, 'widgets' ] );

		// Disable custom colors in the editor.
		add_action( 'after_setup_theme', [ $this, 'editor_custom_color' ] );

		// Remove unpopular meta tags.
		add_action( 'init', [ $this, 'head_cleanup' ] );

		// Frontend scripts.
		add_action( 'wp_enqueue_scripts', [ $this, 'frontend_scripts' ] );

		// Admin scripts.
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_scripts' ] );

		// Frontend styles.
		add_action( 'wp_enqueue_scripts', [ $this, 'frontend_styles' ] );

		/**
		 * Admin styles.
		 *
		 * Call late to override plugin styles.
		 */
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_styles' ], 99 );

		// Login styles.
		add_action( 'login_enqueue_scripts', [ $this, 'login_styles' ] );

		// jQuery UI fallback for HTML5 Contact Form 7 form fields.
		add_filter( 'wpcf7_support_html5_fallback', '__return_true' );

		// Set featured image metabox text.
		add_filter( 'admin_post_thumbnail_html', [ $this, 'set_featured_image_text' ] );

		// Add post types to category archives.
		add_filter( 'pre_get_posts', [ $this, 'query_post_type' ] );

		// Remove prepend text from archive titles.
		add_filter( 'get_the_archive_title', [ $this, 'archive_title' ] );

		// Remove the user admin color scheme picker.
		remove_action( 'admin_color_scheme_picker', 'admin_color_scheme_picker' );

	}

	/**
	 * Add a page for theme settings
	 *
	 * Only works if ACF Pro is active.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
    public function settings_page() {

		if ( class_exists( 'acf_pro' ) ) {

			// Page arguments.
			$settings = [
				'page_title' => __( 'Theme Settings', 'mixes-theme' ),
				'menu_title' => __( 'Theme Settings', 'mixes-theme' ),
				'menu_slug'  => 'mixes-theme-settings',
				'parent'     => 'themes.php',
				'capability' => 'manage_options'
			];

			// Add the settings page.
			acf_add_options_page( $settings );
		}

	}

	/**
	 * Theme dependencies
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function dependencies() {

		// Get ACF fields.
		require get_theme_file_path( '/includes/acf-fields.php' );

		// Get template tags.
		require get_theme_file_path( '/includes/template-tags.php' );

		// Get template functions
		require get_theme_file_path( '/includes/template-functions.php' );

		// Get theme customizer functions.
		require get_theme_file_path( '/includes/customizer.php' );

	}

	/**
	 * JS Replace
	 *
	 * Replaces 'no-js' class with 'js' in the <html> element
	 * when JavaScript is detected.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function js_detect() {

		echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";

	}

	/**
	 * Theme setup
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function setup() {

		/**
		 * Load domain for translation
		 *
		 * @since 1.0.0
		 */
		load_theme_textdomain( 'mixes-theme' );

		/**
		 * Add theme support
		 *
		 * @since 1.0.0
		 */

		// Browser title tag support.
		add_theme_support( 'title-tag' );

		// RSS feed links support.
		add_theme_support( 'automatic-feed-links' );

		// HTML 5 tags support.
		add_theme_support( 'html5', [
			'search-form',
			'comment-form',
			'comment-list',
			'gscreenery',
			'caption'
		 ] );

		/**
		 * Color arguments
		 *
		 * Match the following HEX codes with SASS color variables.
		 *
		 * @see assets/css/_variables.scss
		 */
		$color_args = [
			[
				'name'  => __( 'Text', 'mixes-theme' ),
				'slug'  => 'mixes-text',
				'color' => '#333333',
			],
			[
				'name'  => __( 'Light Gray', 'mixes-theme' ),
				'slug'  => 'mixes-light-gray',
				'color' => '#888888',
			],
			[
				'name'  => __( 'Pale Gray', 'mixes-theme' ),
				'slug'  => 'mixes-pale-gray',
				'color' => '#cccccc',
			],
			[
				'name'  => __( 'White', 'mixes-theme' ),
				'slug'  => 'mixes-white',
				'color' => '#ffffff',
			],
			[
				'name'  => __( 'Error Red', 'mixes-theme' ),
				'slug'  => 'mixes-error',
				'color' => '#dc3232',
			],
			[
				'name'  => __( 'Warning Yellow', 'mixes-theme' ),
				'slug'  => 'mixes-warning',
				'color' => '#ffb900',
			],
			[
				'name'  => __( 'Success Green', 'mixes-theme' ),
				'slug'  => 'mixes-success',
				'color' => '#46b450',
			]
		];

		// Apply a filter to editor arguments.
		$colors = apply_filters( 'mixes_editor_colors', $color_args );

		// Add color support.
		add_theme_support( 'editor-color-palette', $colors );

		add_theme_support( 'align-wide' );

		// Customizer widget refresh support.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Featured image support.
		add_theme_support( 'post-thumbnails' );

		/**
		 * Add image sizes.
		 *
		 * Three sizes per aspect ratio so that WordPress
		 * will use srcset for responsive images.
		 *
		 * @since 1.0.0
		 */
		set_post_thumbnail_size( 2048, 1152, [ 'center', 'center' ] );

		// Featured images, post thumbnail size.
		add_image_size( __( 'featured-image', 'mixes-theme' ), 2048, 1152, true );

		// 16:9 HD Video.
		add_image_size( __( 'video', 'mixes-theme' ), 1280, 720, true );
		add_image_size( __( 'video-md', 'mixes-theme' ), 960, 540, true );
		add_image_size( __( 'video-sm', 'mixes-theme' ), 640, 360, true );

		// 21:9 Cinemascope.
		add_image_size( __( 'banner', 'mixes-theme' ), 1280, 549, true );
		add_image_size( __( 'banner-md', 'mixes-theme' ), 960, 411, true );
		add_image_size( __( 'banner-sm', 'mixes-theme' ), 640, 274, true );

		/**
		 * Custom header for the front page.
		 */
		add_theme_support( 'custom-header', apply_filters( 'mixes_custom_header_args', [
			'default-image'          => get_parent_theme_file_uri( '/assets/images/header.jpg' ),
			'width'                  => 2048,
			'height'                 => 1152,
			'flex-width'             => true,
			'flex-height'            => true,
			'video'                  => false,
			'uploads'                => true,
			'random-default'         => true,
			'header-text'            => false,
			'default-text-color'     => null,
			'wp-head-callback'       => null,
			'admin-head-callback'    => null,
			'admin-preview-callback' => null
		] ) );

		register_default_headers( [
			'default-header-01' => [
				'url'           => '%s/assets/images/default-header-01.jpg',
				'thumbnail_url' => '%s/assets/images/default-header-01.jpg',
				'description'   => __( 'Default Header Image 01', 'mixes-theme' ),
			],
			'default-header-02' => [
				'url'           => '%s/assets/images/default-header-02.jpg',
				'thumbnail_url' => '%s/assets/images/default-header-02.jpg',
				'description'   => __( 'Default Header Image 02', 'mixes-theme' ),
			],
			'default-header-03' => [
				'url'           => '%s/assets/images/default-header-03.jpg',
				'thumbnail_url' => '%s/assets/images/default-header-03.jpg',
				'description'   => __( 'Default Header Image 03', 'mixes-theme' ),
			],
			'default-header-04' => [
				'url'           => '%s/assets/images/default-header-04.jpg',
				'thumbnail_url' => '%s/assets/images/default-header-04.jpg',
				'description'   => __( 'Default Header Image 04', 'mixes-theme' ),
			],
			'default-header-05' => [
				'url'           => '%s/assets/images/default-header-05.jpg',
				'thumbnail_url' => '%s/assets/images/default-header-05.jpg',
				'description'   => __( 'Default Header Image 05', 'mixes-theme' ),
			]
		] );

		/**
		 * Custom logo support
		 *
		 * @since 1.0.0
		 */

		// Logo arguments.
		$logo_args = [
			'width'       => 180,
			'height'      => 180,
			'flex-width'  => true,
			'flex-height' => true
		];

		// Apply a filter to logo arguments.
		$logo = apply_filters( 'mixes_header_image', $logo_args );

		// Add logo support.
		add_theme_support( 'custom-logo', $logo );

		 /**
		 * Set content width.
		 *
		 * @since 1.0.0
		 */
		$mixes_content_width = apply_filters( 'mixes_content_width', 1280 );

		if ( ! isset( $content_width ) ) {
			$content_width = $mixes_content_width;
		}

		/**
		 * Register theme menus.
		 *
		 * @since  1.0.0
		 */
		register_nav_menus( [
			'main'   => __( 'Main Menu', 'mixes-theme' ),
			'footer' => __( 'Footer Menu', 'mixes-theme' ),
			'social' => __( 'Social Menu', 'mixes-theme' )
		] );

		/**
		 * Add stylesheet for the content editor.
		 *
		 * @since 1.0.0
		 */
		add_editor_style( '/assets/css/editor.min.css', [ 'mixes-admin' ], '', 'screen' );

	}

	/**
	 * Register widgets
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function widgets() {

		register_sidebar( [
			'name'          => esc_html__( 'Sidebar', 'mixes-theme' ),
			'id'            => 'sidebar',
			'description'   => esc_html__( 'Add widgets to the right sidebar.', 'mixes-theme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		] );

		register_sidebar( [
			'name'          => esc_html__( 'Search Page', 'mixes-theme' ),
			'id'            => 'search-page',
			'description'   => esc_html__( 'Add widgets to the search page.', 'mixes-theme' ),
			'before_widget' => '<section id="%1$s" class="widget search-page-widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		] );

	}

	/**
	 * Theme support for disabling custom colors in the editor
	 *
	 * @since  1.0.0
	 * @access public
	 * @return bool Returns true for the color picker.
	 */
	public function editor_custom_color() {

		$disable = add_theme_support( 'disable-custom-colors', [] );

		// Apply a filter for conditionally disabling the picker.
		$custom_colors = apply_filters( 'mixes_editor_custom_colors', '__return_false' );

		return $custom_colors;

	}

	/**
	 * Clean up meta tags from the <head>
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function head_cleanup() {

		remove_action( 'wp_head', 'rsd_link' );
		remove_action( 'wp_head', 'wlwmanifest_link' );
		remove_action( 'wp_head', 'wp_generator' );
		remove_action( 'wp_head', 'wp_site_icon', 99 );
	}

	/**
	 * Frontend scripts
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function frontend_scripts() {

		// wp_enqueue_script( 'jquery' );

		wp_enqueue_script( 'test-navigation', get_theme_file_uri( '/assets/js/navigation.min.js' ), [], null, true );

		wp_enqueue_script( 'mixes-theme-skip-link-focus-fix', get_theme_file_uri( '/assets/js/skip-link-focus-fix.min.js' ), [], null, true );

		// Comments scripts.
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

	}

	/**
	 * Admin scripts
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function admin_scripts() {}

	/**
	 * Frontend styles
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function frontend_styles() {

		// Google fonts.
		wp_enqueue_style( 'mixes-google-fonts', 'https://fonts.googleapis.com/css?family=Montserrat:400,400i,500,500i,600,600i,700,700i&display=swap', [], '', 'screen' );

		/**
		 * Theme sylesheet
		 *
		 * This enqueues the minified stylesheet compiled from SASS (.scss) files.
		 * The main stylesheet, in the root directory, only contains the theme header but
		 * it is necessary for theme activation. DO NOT delete the main stylesheet!
		 */
		wp_enqueue_style( 'mixes-theme', get_theme_file_uri( '/assets/css/style.min.css' ), [], '' );

		// Print styles.
		wp_enqueue_style( 'mixes-print', get_theme_file_uri( '/assets/css/print.min.css' ), [], '', 'print' );

	}

	/**
	 * Admin styles
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function admin_styles() {

		// Google fonts.
		wp_enqueue_style( 'mixes-google-fonts', 'https://fonts.googleapis.com/css?family=Montserrat:400,400i,500,500i,600,600i,700,700i&display=swap', [], '', 'screen' );

		// Admin styles.
		wp_enqueue_style( 'mixes-admin', get_theme_file_uri( '/assets/css/admin.min.css' ), [], '' );

	}

	/**
	 * Login styles
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function login_styles() {

		wp_enqueue_style( 'custom-login', get_theme_file_uri( '/assets/css/login.css' ), [], '', 'screen' );

	}

	/**
	 * Set featured image metabox text
	 *
	 * Replaces the text of the "Set featured image" link.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string Returns the text to be added to the metabox.
	 */
	function set_featured_image_text( $content ) {

		return $content = str_replace(

			// Default text.
			__( 'Set featured image' ),

			// New text.
			__( 'Minimum 2048px by 878px', 'mixes-theme' ),
			$content
		);

	}

	/**
	 * Add post types to category archives
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array Returns an array of post types.
	 */
	public function query_post_type( $query ) {

		if ( is_category() ) {

			$post_type = get_query_var( 'post_type' );

			if ( $post_type ) {
				$post_type = $post_type;
			} else {

				// Don't forget nav_menu_item to allow menus to work!
				$post_type = [ 'nav_menu_item', 'post', 'recipe' ];
			}

			// Set post types to the modified query.
			$query->set( 'post_type', $post_type );

			// Return the modified query.
			return $query;
		}
	}

	/**
	 * Filter archive titles
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string Returns the filtered titles.
	 */
	public function archive_title( $title ) {

		// $queried_object = get_queried_object();
		// $this_tax = get_taxonomy( $queried_object->taxonomy );
		// echo $this_tax->labels->singular_name;

		// Get query vars for search & filter pages.
		$term     = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
		$liquor   = get_query_var( 'liquor_type', '' );
		$occasion = get_query_var( 'recipe_occasion', '' );

		if ( is_tax( 'recipe_type', 'cocktail' ) && $liquor ) {
			$recipes = sprintf(
				'<a href="%1s">%2s</a> %3s',
				esc_url( get_term_link( $liquor, 'liquor_type' ) ),
				$liquor,
				__( 'recipes', 'mixes-theme' )
			);
		} elseif ( is_tax( 'recipe_type', 'cocktail' ) ) {
			$recipes = __( 'cocktail recipes', 'mixes-theme' );
		}

		// If a cocktail URL with liquor & occasion parameters.
		if ( is_tax( 'recipe_type', 'cocktail' ) && $liquor && $occasion ) {
			$title = sprintf(
				'%1s %2s %4s <a href="%5s">%6s</a>',
				__( 'The following', 'mixes-theme' ),
				$recipes,
				__( 'are labeled for', 'mixes-theme' ),
				esc_url( get_term_link( $occasion, 'recipe_occasion' ) ),
				$occasion
			);

		// If a cocktail URL with liquor a parameter.
		} elseif ( is_tax( 'recipe_type', 'cocktail' ) && $liquor ) {
			$title = sprintf(
				'%1s <a href="%2s">%3s</a> %4s',
				__( 'The following are', 'mixes-theme' ),
				esc_url( get_term_link( $liquor, 'liquor_type' ) ),
				$liquor,
				__( 'recipes', 'mixes-theme' )
			);

		// If a cocktail URL with occasion a parameter.
		} elseif ( is_tax( 'recipe_type', 'cocktail' ) && $occasion ) {
			$title = sprintf(
				'%1s %2s %3s <a href="%4s">%5s</a>',
				__( 'The following', 'mixes-theme' ),
				$recipes,
				__( 'are labeled for', 'mixes-theme' ),
				esc_url( get_term_link( $occasion, 'recipe_occasion' ) ),
				$occasion
			);

		// If a recipe URL with occasion a parameter.
		} elseif ( ( is_tax( 'recipe_type' ) && $occasion ) || is_tax( 'recipe_occasion' ) ) {
			$title = sprintf(
				'%1s <a href="%2s">%3s</a>',
				esc_html__( 'The following recipes are labeled for', 'mixes-theme' ),
				esc_url( get_term_link( $occasion, 'recipe_occasion' ) ),
				$occasion
			);

		// If a recipe URL with occasion a parameter.
		} elseif ( is_tax( 'liquor_type' ) ) {
			$title = sprintf(
				'%1s %2s',
				esc_html__( 'The following recipes contain', 'mixes-theme' ),
				single_term_title( '', false )
			);

		// If a cocktail archive.
		} elseif ( is_tax( 'recipe_type' ) ) {
		$title = single_term_title( '', false ) . __( ' Recipes', 'mixes-theme' );

		// If is taxonomy archive.
		} elseif ( is_tax() ) {
			$title = single_cat_title( '', false );

		// If is standard category archive.
		} elseif ( is_category() ) {
			$title = single_cat_title( '', false );

		// If is standard tag archive.
		} elseif ( is_tag() ) {
			$title = single_tag_title( '', false );

		} elseif ( is_post_type_archive( 'recipe' ) ) {
            $title = __( 'Explore Recipes', 'mixes-theme' );

		// If is author archive.
		} elseif ( is_author() ) {
			$title = sprintf(
				'%1s <span class="vcard">%2s</span>',
				__( 'Posts by', 'mixes-theme' ),
				get_the_author()
			);
		}

		// Return the ammended title.
    	return $title;

	}

}

/**
 * Get an instance of the Functions class
 *
 * This function is useful for quickly grabbing data
 * used throughout the theme.
 *
 * @since  1.0.0
 * @access public
 * @return object
 */
function mixes_theme() {

	$mixes_theme = Functions::get_instance();

	return $mixes_theme;

}

// Run the Functions class.
mixes_theme();