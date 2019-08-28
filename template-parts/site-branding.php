<?php
/**
 * The site title and logo
 *
 * Put in a template part for use on the back end and the front end.
 *
 * @package    WordPress/ClassicPress
 * @subpackage Monica_Mixes_Theme
 * @since      1.0.0
 */

/**
 * Set up site title inner HTML and text
 *
 * Returns a conditional element, h1 if front page.
 *
 * @since 1.0.0
 */
if ( is_front_page() ) {
	$site_title = sprintf(
		'<h1 class="site-title"><span class="title-span-one">%1s</span> <span class="title-span-two">%2s</span></h1>',
		__( 'Monica', 'mixes-theme' ),
		__( 'Mixes', 'mixes-theme' )
	);
} else {
	$site_title = sprintf(
		'<p class="site-title"><a href="%1s" rel="home"><span class="title-span-one">%2s</span> <span class="title-span-two">%3s</span></a></p>',
		esc_attr( esc_url( home_url( '/' ) ) ),
		__( 'Monica', 'mixes-theme' ),
		__( 'Mixes', 'mixes-theme' )
	);
}

?>
<div class="site-branding">

	<?php // Set up the random image if ACF Pro is active.
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
	echo $site_title;
	?>

</div>