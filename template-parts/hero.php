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
?>

<div class="site-header-image" role="presentation">
	<figure>
		<?php
		if ( is_singular( [ 'post', 'recipe' ] ) && has_post_thumbnail() ) {
			echo sprintf(
				'<img src="%1s" alt="%2s" width="2048" height="1152" />',
				esc_attr( esc_url( $src ) ),
				get_the_title()
			);
		} elseif ( is_singular( [ 'post', 'recipe' ] ) ) {
			echo '';
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
			</header>
		</figcaption>
	</figure>
</div>