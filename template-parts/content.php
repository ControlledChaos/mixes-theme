<?php
/**
 * Template part for displaying posts
 *
 * @package    WordPress/ClassicPress
 * @subpackage Monica_Mixes_Theme
 * @since      1.0.0
 */

$title = sprintf(
	'<h1 class="entry-title">%1s</h1>',
	get_the_title()
);

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article">
	<header class="entry-header">
		<?php echo $title; ?>

		<?php if ( is_singular( [ 'post', 'recipe' ] ) ) : ?>
			<div class="entry-meta">
				<?php Mixes\Tags\posted_on(); ?>
			</div>
		<?php endif; ?>
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
