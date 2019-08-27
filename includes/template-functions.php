<?php
/**
 * Template functions
 *
 * @package    WordPress/ClassicPress
 * @subpackage Monica_Mixes_Theme
 * @since      1.0.0
 */

// Namespace specificity for theme functions & filters.
namespace Mixes\Includes;

// Restrict direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Body classes
 *
 * Adds custom classes to the array of body classes.
 *
 * @since  1.0.0
 * @access public
 * @param array $classes Classes for the body element
 * @return array
 */
function body_classes( $classes ) {

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! ( is_active_sidebar( 'sidebar' ) || is_page_template( 'no-sidebar.php' ) ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;

}
add_filter( 'body_class', 'Mixes\Includes\body_classes' );

/**
 * Pingback header
 *
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 *
 * @since  1.0.0
 * @access public
 * @return string Returns the pinkback link.
 */
function pingback_header() {

	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}

}
add_action( 'wp_head', 'Mixes\Includes\pingback_header' );

/**
 * Random logo
 *
 * Displays a random logo image from the gallery on
 * the theme settings page.
 *
 * Requires Advanced Custom Fields Pro to be active.
 * Falls back first to the logo in the Customizer,
 * then to a theme default file.
 *
 * Set the ACF gallery to return the URL of images.
 *
 * Use in a template as `<?php Mixes\Includes\random_logo(); ?>`
 *
 * @since  1.0.0
 * @access public
 * @return string Returns the logo markup.
 */
function random_logo() {

	// Set up the random image if ACF Pro is active.
	if ( class_exists( 'acf_pro' ) ) :

		/**
		 * Get fields from the theme options page.
		 *
		 * If the gallery is not on an options page,
		 * for example on the front page edit screen,
		 * then remove the `option` parameter.
		 */
		$images = get_field( 'mixes_theme_header_icons', 'option' );

		// Shuffle the order of the gallery, if any images.
		if ( $images ) {
			$random = shuffle( $images );
		} else {
			$random = null;
		}

		// Count the number of images in the gallery.
		$count = count( $images );

		// If there is only one image, return that image.
		if ( ! empty( $random ) && 1 == $count ) {
			$image = $images[0];

		// If there are more than one image, return a random image.
		} elseif ( is_array( $images ) && ! empty( $images ) && ! empty( $random ) ) {
			$image = $images[$random];

		// If there are no images in the gallery but one set in the customizer.
		} elseif ( has_custom_logo() ) {
			$logo_id  = get_theme_mod( 'custom_logo' );
			$logo_src = wp_get_attachment_image_src( $logo_id , 'full' );
			$image    = $logo_src[0];

		// Otherwise return the theme default logo image.
		} else {
			$image = get_theme_file_uri( '/assets/images/logos/monica-mixes-icon-default.jpg' );
		}

	// If ACF Pro is not active.
	else :

		// If a logo is set in the customizer, get that image.
		if ( has_custom_logo() ) {
			$logo_id  = get_theme_mod( 'custom_logo' );
			$logo_src = wp_get_attachment_image_src( $logo_id , 'full' );
			$image    = $logo_src[0];

		// Otherwise return the theme default logo image.
		} else {
			$image = get_theme_file_uri( '/assets/images/logos/monica-mixes-icon-default.jpg' );
		}

	endif;

	// The logo image markup with link to home page.
	$logo = sprintf(
		'<a class="logo-link" href="%1s"><img class="custom-logo" src="%2s" alt="%3s" /></a>',
		site_url(),
		$image,
		esc_attr( __( 'Monica Mixes logo', 'mixes-theme' ) )
	);

	// Return the logo markup.
	echo $logo;

}