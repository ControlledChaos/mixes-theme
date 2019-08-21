<?php
/**
 * Template part for displaying a grid of recent recipe posts.
 *
 * @package    WordPress/ClassicPress
 * @subpackage Monica_Mixes_Theme
 * @since      1.0.0
 */

$args = [
	'post_type'              => [ 'recipe' ],
	'nopaging'               => true,
	'posts_per_page'         => '9',
	'ignore_sticky_posts'    => false,
	'order'                  => 'DESC',
	'orderby'                => 'date',
];

$query = new WP_Query( $args );

if ( $query->have_posts() ) : ?>
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
		<li>
			<figure>
				<a href="<?php the_permalink(); ?>">
					<img class="intro-image" src="<?php echo esc_url( $src ); ?>" srcset="<?php echo esc_attr( $image_srcset ); ?>" sizes="(max-width: 640px) 360px, (max-width: 1024px) 640px, 640px" width="640" height="360" />
					<figcaption>
						<h3><?php the_title(); ?></h3>
					</figcaption>
				</a>
			</figure>
			<p class="posts-grid-summary"><?php echo wp_trim_words( $summary, 35, '&hellip;' ); ?></p>
			<p class="posts-grid-link"><a href="<?php the_permalink(); ?>">
				<?php _e( 'View Recipe', 'mixes-theme' ); ?>
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M190.5 66.9l22.2-22.2c9.4-9.4 24.6-9.4 33.9 0L441 239c9.4 9.4 9.4 24.6 0 33.9L246.6 467.3c-9.4 9.4-24.6 9.4-33.9 0l-22.2-22.2c-9.5-9.5-9.3-25 .4-34.3L311.4 296H24c-13.3 0-24-10.7-24-24v-32c0-13.3 10.7-24 24-24h287.4L190.9 101.2c-9.8-9.3-10-24.8-.4-34.3z"/></svg>
			</a></p>
		</li>
	<?php endwhile; wp_reset_postdata(); ?>
</ul>
<?php else : ?>
<p><?php _e( 'Sorry, no recipes are available at this time. Please check back with us soon!', 'mixes-theme' ); ?></p>
<?php endif; ?>