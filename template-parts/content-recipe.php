<?php
/**
 * Template part for displaying posts
 *
 * @package    WordPress/ClassicPress
 * @subpackage Monica_Mixes_Theme
 * @since      1.0.0
 */

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
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article">
	<header class="entry-header">
		<?php echo $title; ?>
	</header>
	<div class="entry-content" itemprop="articleBody">
		<?php
		the_content( sprintf(
			wp_kses(
				__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'mixes-theme' ),
				[
					'span' => [
						'class' => [],
					],
				]
			),
			get_the_title()
		) );

		wp_link_pages( [
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'mixes-theme' ),
			'after'  => '</div>',
		] );
		?>
	</div>

	<footer class="entry-footer">
		<?php Mixes\Tags\entry_footer(); ?>
	</footer>
</article>
