<?php
/**
 * Template part for displaying page content in page-search.php
 *
 * @package    WordPress/ClassicPress
 * @subpackage Monica_Mixes_Theme
 * @since      1.0.0
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article">
	<div class="entry-content search-page-content" itemprop="articleBody">
		<?php if ( is_active_sidebar( 'search-page' ) ) {
			dynamic_sidebar( 'search-page' );
		} ?>
	</div>
</article>
