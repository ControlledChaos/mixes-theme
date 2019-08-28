<?php
/**
 * Template part for displaying posts on index pages.
 *
 * @package    WordPress/ClassicPress
 * @subpackage Monica_Mixes_Theme
 * @since      1.0.0
 */

// Title tag.
$title = sprintf(
	'<h2 class="entry-title"><a href="%1s">%2s</a></h2>',
	esc_url( get_permalink() ),
	get_the_title()
);

// Get the excerpt.
$summary = get_the_excerpt();

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

?>
<li>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article">
		<figure>
			<a href="<?php the_permalink(); ?>">
				<img class="intro-image" src="<?php echo esc_attr( esc_url( $src ) ); ?>" srcset="<?php echo esc_attr( $image_srcset ); ?>" sizes="(max-width: 640px) 360px, (max-width: 1024px) 640px, 640px" width="640" height="360" />
				<figcaption>
					<h3><?php the_title(); ?></h3>
				</figcaption>
			</a>
		</figure>
		<p class="posts-grid-summary">
			<?php
			// Not using the link above, set to null instead.
			echo wp_trim_words( $summary, 18, null ); ?>
		</p>
	</article>
</li>