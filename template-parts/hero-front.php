<?php
/**
 * Front page header and hero image
 *
 * @package    WordPress/ClassicPress
 * @subpackage Monica_Mixes_Theme
 * @since      1.0.0
 */

// Get custom fields if ACF Pro is active.
if ( class_exists( 'acf_pro' ) ) {
	$acf_heading = get_field( 'mixes_front_hero_heading' );
	$acf_content = get_field( 'mixes_front_hero_content' );
} else {
	$acf_heading = null;
	$acf_content = null;
}

/**
 * Hero heading text.
 *
 * Follow along as Monica Perez explores craft cocktail recipes and provides entertaining video demonstrations. And join us in lively conversation.
 *
 * @since 1.0.0
 */
if ( $acf_heading ) {
	$heading_text = $acf_heading;
} else {
	$heading_text = __( 'Welcome to Monica Mixes!', 'mixes-theme' );
}

if ( $acf_content ) {
	$content_text = $acf_content;
} else {
	$content_text = __( 'Follow along as Monica Perez explores craft cocktail recipes and provides entertaining video demonstrations.', 'mixes-theme' );
}

?>

<div class="site-header-image" role="presentation">
	<figure>
		<?php
		if ( has_header_image() ) {
			the_header_image_tag();
		} else {
			echo sprintf(
				'<img src="%1s" alt="%2s" width="2048" height="878" />',
				get_theme_file_uri( '/assets/images/default-header.jpg' ),
				get_bloginfo( 'name' ) . __( 'header image', 'mixes-theme' )
			);
		} ?>
		<figcaption>
			<header class="hero-header">
				<h2><?php echo $heading_text; ?></h2>
				<p><?php echo $content_text; ?></p>
			</header>
		</figcaption>
	</figure>
</div>