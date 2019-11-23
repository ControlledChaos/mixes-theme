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
if ( is_singular() ) {
	$image_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), $image_size );
} else {
	$image_src = '';
}

// If a featured image has been set.
if ( ! empty( $image_src ) ) {
	$src = $image_src[0];

// Fallback image URI.
} else {
	$src = null;
}

// Get the current user name for the dashboard greeting.
$current_user = wp_get_current_user();
$user_name    = $current_user->display_name;

// Conditional title.
if ( is_post_type_archive( 'recipe' ) ) {
	$title = __( 'Monica Mixes Recipes', 'mixes-theme' );
} elseif ( is_home() || is_post_type_archive( 'post' ) ) {
	$title = get_the_title( get_option( 'page_for_posts', true ) );
} elseif ( is_search() ) {
	$title = __( 'Search Results', 'mixes-theme' );
} elseif ( is_archive() ) {
	$title = get_the_archive_title();
} elseif ( is_singular() ) {
	$title = get_the_title();
} elseif ( is_admin() ) {
	$title = sprintf(
		'<h2>%1s %2s</h2>',
		esc_html__( 'Welcome,', 'mixes-theme' ),
		$user_name
	);
} else {
	$title = get_bloginfo( 'name' );
}

?>
<div class="site-header-image" role="presentation">
	<figure>
		<?php
		if ( ( is_home() || is_archive() ) && has_header_image() ) {
			echo sprintf(
				'<img src="%1s" alt="%2s" width="2048" height="1152" />',
				esc_attr( esc_url( get_header_image() ) ),
				get_the_title( get_option( 'page_for_posts' ) )
			);
		} elseif ( is_singular() && has_post_thumbnail() ) {
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
				<h1><?php echo $title; ?></h1>
			</header>
		</figcaption>
	</figure>
</div>