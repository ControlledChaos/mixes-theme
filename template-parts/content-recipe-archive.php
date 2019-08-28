<?php
/**
 * Template part for displaying posts
 *
 * @package    WordPress/ClassicPress
 * @subpackage Monica_Mixes_Theme
 * @since      1.0.0
 */

// Conditional page title markup.
if ( is_singular() && ! has_post_thumbnail() ) {
	$title = sprintf(
		'<h1 class="entry-title">%1s</h1>',
		get_the_title()
	);
	$title .= sprintf(
		'<h3 class="entry-title">%1s <span class="taxonomy-heading-links">%2s</span></h3>',
		__( 'Recipe Type:', 'mixes-theme' ),
		get_the_term_list( $post->ID, 'recipe_type', '', ', ' )
	);
} elseif ( is_singular() ) {
	$title = sprintf(
		'<h3 class="entry-title">%1s <span class="taxonomy-heading-links">%2s</span></h3>',
		__( 'Recipe Type:', 'mixes-theme' ),
		get_the_term_list( $post->ID, 'recipe_type', '', ', ' )
	);
} else {
	$title = sprintf(
		'<h2 class="entry-title"><a href="%1s" rel="bookmark">%2s</a></h2>',
		esc_attr( esc_url( get_permalink() ) ),
		get_the_title()
	);
}

// Get featured image data.
$image_size   = 'video-sm';
$image_src    = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), $image_size );
$image_srcset = wp_get_attachment_image_srcset( get_post_thumbnail_id( $post->ID ), $image_size );

// If a featured image has been set.
if ( ! empty( $image_src ) ) {
	$src = $image_src[0];

// Fallback image URI.
} else {
	$src = get_theme_file_uri( '/assets/images/video-grid-image-placeholder.jpg' );
}

// Get the summary if ACF Pro is active.
if ( class_exists( 'acf_pro' ) ) {
	$summary = get_field( 'recipe_summary' );
	if ( ! empty( $summary ) ) {
		$summary = $summary;
	} else {
		$summary = $summary = get_the_excerpt();
	}

// Get the excerpt if ACF Pro is not active.
} else {
	$summary = get_the_excerpt();
}

?>

<article id="recipe-<?php the_ID(); ?>" <?php post_class(); ?> role="article">
	<li>
		<article id="recipe-<?php the_ID(); ?>" <?php post_class(); ?> role="article">
			<a href="<?php the_permalink(); ?>">
				<figure>
					<img class="intro-image" src="<?php echo esc_url( $src ); ?>" srcset="<?php echo esc_attr( $image_srcset ); ?>" sizes="(max-width: 640px) 360px, (max-width: 1024px) 640px, 640px" width="640" height="360" />
					<figcaption>
						<h3><?php the_title(); ?></h3>
					</figcaption>
				</figure>
			</a>
			<p class="posts-grid-summary"><?php echo wp_trim_words( $summary, 35, '&hellip;' ); ?></p>
		</article>
	</li>
</article>
