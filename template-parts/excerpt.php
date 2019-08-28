<?php
/**
 * Template part for displaying post excerpts
 *
 * @package    WordPress/ClassicPress
 * @subpackage Monica_Mixes_Theme
 * @since      1.0.0
 */

// Linked title markup.
$title = sprintf(
	'<h2 class="entry-title"><a href="%1s">%2s</a></h2>',
	esc_url( get_permalink() ),
	get_the_title()
);

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article">
	<header class="entry-header">
		<?php echo $title; ?>

		<?php if ( get_post_type() == 'post' ) : ?>
			<div class="entry-meta">
				<?php Mixes\Tags\posted_on(); ?>
			</div>
		<?php endif; ?>
	</header>
	<div class="entry-excerpt" itemprop="articleBody">
		<?php Mixes\Tags\post_thumbnail(); ?>
		<?php the_excerpt(); ?>
	</div>
</article>