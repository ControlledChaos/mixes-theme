<?php
/**
 * Page header and hero image
 *
 * @package    WordPress/ClassicPress
 * @subpackage Monica_Mixes_Theme
 * @since      1.0.0
 */

// Get featured image data.
$image_size   = 'featured-image';
$image_src    = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), $image_size );
$image_srcset = wp_get_attachment_image_srcset( get_post_thumbnail_id( $post->ID ), $image_size );

// If a featured image has been set.
if ( ! empty( $image_src ) ) {
	$src = $image_src[0];

// Fallback image URI.
} else {
	$src = null;
}

// Get the summary if ACF Pro is active.
if ( class_exists( 'acf_pro' ) ) {
	$summary = get_field( 'recipe_summary' );
	if ( ! empty( $summary ) ) {
		$summary = $summary;
	} else {
		$summary = null;
	}

// No summary if ACF Pro is not active.
} else {
	$summary = null;
}

?>
<div class="site-header-image" role="presentation">
	<figure>
		<?php
		if ( has_post_thumbnail() ) {
			echo sprintf(
				'<img src="%1s" alt="%2s" width="2048" height="1152" />',
				esc_attr( esc_url( $src ) ),
				get_the_title()
			);
		} elseif ( has_header_image() ) {
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
				<h1><?php the_title(); ?></h1>
				<p><?php echo $summary; ?></p>
			</header>
		</figcaption>
	</figure>
</div>