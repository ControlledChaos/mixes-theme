<?php
/**
 * Template part for displaying results in search pages
 *
 * This is for recipe post types if
 * Advanced Custom Fields is active.
 *
 * @package    WordPress/ClassicPress
 * @subpackage Monica_Mixes_Theme
 * @since      1.0.0
 */

/**
 * Fields registered by Advanced Custom Fields
 *
 * @since  1.0.0
 */
$summary     = get_field( 'recipe_summary' );
$description = get_field( 'recipe_description' );

// Set up a recipe excerpt.
if ( $summary && $description ) {
	$excerpt = sprintf(
		'<p>%1s</p><p>%2s</p>',
		$summary,
		wp_trim_words( $description, 55, '&hellip;' )
	);
} else {
	$excerpt = sprintf(
		'<p>%1s</p><p>%2s</p>',
		$summary,
		wp_trim_words( get_the_excerpt(), 35, '&hellip;' )
	);
}

// Read more arrow.
if ( is_rtl() ) {
	$more_icon = null;
} else {
	$more_icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M190.5 66.9l22.2-22.2c9.4-9.4 24.6-9.4 33.9 0L441 239c9.4 9.4 9.4 24.6 0 33.9L246.6 467.3c-9.4 9.4-24.6 9.4-33.9 0l-22.2-22.2c-9.5-9.5-9.3-25 .4-34.3L311.4 296H24c-13.3 0-24-10.7-24-24v-32c0-13.3 10.7-24 24-24h287.4L190.9 101.2c-9.8-9.3-10-24.8-.4-34.3z"/></svg>';
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article">
	<header class="entry-header">
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

		<?php if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php
			Mixes\Tags\posted_on();
			Mixes\Tags\posted_by();
			?>
		</div>
		<?php endif; ?>
	</header>

	<?php Mixes\Tags\post_thumbnail(); ?>

	<div class="entry-summary recipe-summary recipe-summary-search">
		<?php echo $excerpt; ?>
		<?php echo sprintf(
			'<p><a href="%1s" class="read-more search-read-more">%2s %3s</a></p>',
			esc_url( get_permalink() ),
			esc_html__( 'Read this recipe', 'mixes-theme' ),
			$more_icon
		); ?>
	</div>

	<footer class="entry-footer">
		<?php Mixes\Tags\entry_footer(); ?>
	</footer>
</article>
