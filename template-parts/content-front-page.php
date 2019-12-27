<?php
/**
 * Template part for displaying front page content in front-page.php
 *
 * @package    WordPress/ClassicPress
 * @subpackage Monica_Mixes_Theme
 * @since      1.0.0
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article">
	<div class="entry-content" itemprop="articleBody">
		<?php
		// Get the featured recipies grid if ACF Pro is active.
		if ( class_exists( 'acf_pro' ) ) {
			get_template_part( 'template-parts/grid', 'featured-recipes' );
		} ?>
		<section class="posts-grid recent-recipes recent-recipes-front">
			<header>
				<h2><?php _e( 'Recent Recipes', 'mixes-theme' ); ?></h2>
			</header>
			<?php
			// Get the recent recipes grid.
			get_template_part( 'template-parts/grid', 'recent-recipes' ); ?>
		</section>
		<?php
		// Get the recent posts grid.
		get_template_part( 'template-parts/grid', 'recent-posts' ); ?>
	</div>
</article>
