<?php
/**
 * Template part for displaying a grid of recent blog posts.
 *
 * @package    WordPress/ClassicPress
 * @subpackage Monica_Mixes_Theme
 * @since      1.0.0
 */

// Post query arguments.
$args = [
	'post_type'              => [ 'post' ],
	'nopaging'               => true,
	'posts_per_page'         => '9',
	'ignore_sticky_posts'    => false,
	'order'                  => 'DESC',
	'orderby'                => 'date',
];

// Get a new instamce of the post query.
$query = new WP_Query( $args );

// Right arrow icon.
$right = '<svg xmlns="http://www.w3.org/2000/svg" class="theme-icon read-more-icon" viewBox="0 0 448 512"><path d="M190.5 66.9l22.2-22.2c9.4-9.4 24.6-9.4 33.9 0L441 239c9.4 9.4 9.4 24.6 0 33.9L246.6 467.3c-9.4 9.4-24.6 9.4-33.9 0l-22.2-22.2c-9.5-9.5-9.3-25 .4-34.3L311.4 296H24c-13.3 0-24-10.7-24-24v-32c0-13.3 10.7-24 24-24h287.4L190.9 101.2c-9.8-9.3-10-24.8-.4-34.3z"/></svg>';

// Left arrow icon.
$left = '<svg xmlns="http://www.w3.org/2000/svg" class="theme-icon read-more-icon" viewBox="0 0 448 512"><path d="M257.5 445.1l-22.2 22.2c-9.4 9.4-24.6 9.4-33.9 0L7 273c-9.4-9.4-9.4-24.6 0-33.9L201.4 44.7c9.4-9.4 24.6-9.4 33.9 0l22.2 22.2c9.5 9.5 9.3 25-.4 34.3L136.6 216H424c13.3 0 24 10.7 24 24v32c0 13.3-10.7 24-24 24H136.6l120.5 114.8c9.8 9.3 10 24.8.4 34.3z"/></svg>';

// If right-to-left language.
if ( is_rtl() ) {
	$more = sprintf(
		' <a class="read-more" href="%1s">%2s %3s</a> ',
		get_permalink(),
		$left,
		__( 'Read more', 'mixes-theme' )
	);
} else {
	$more = sprintf(
		'&hellip; <a class="read-more" href="%1s">%2s %3s</a>',
		get_permalink(),
		__( 'Read more', 'mixes-theme' ),
		$right
	);
}

// Only disply the grid HTML if there are posts available.
if ( $query->have_posts() ) : ?>
<section class="posts-grid recent-posts recent-posts-front">
	<header>
		<h2><?php _e( 'Recent Posts', 'mixes-theme' ); ?></h2>
	</header>
	<ul class="posts-grid-list">
		<?php while ( $query->have_posts() ) : $query->the_post();

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

		// Get the excerpt.
		$summary = get_the_excerpt();
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
		<?php endwhile; wp_reset_postdata(); ?>
	</ul>
</section>
<?php
// End check for podtd.
endif; ?>