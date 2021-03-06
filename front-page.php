<?php
/**
 * The static front page template
 *
 * @package    WordPress/ClassicPress
 * @subpackage Monica_Mixes_Theme
 * @since      1.0.0
 */

get_header(); ?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main" itemscope itemprop="mainContentOfPage">
		<?php while ( have_posts() ) :
			the_post();
			get_template_part( 'template-parts/content', 'front-page' );
		endwhile;
		?>
		</main>
	</div>
<?php
get_footer();