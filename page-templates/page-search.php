<?php
/**
 * The template for displaying the seach page
 *
 * Template Name: Search Page
 * Template Post Type: post, page
 * Description: For displaying widgets on the custom search page.
 *
 * @package    WordPress/ClassicPress
 * @subpackage Monica_Mixes_Theme
 * @since      1.0.0
 */

get_header(); ?>

	<div id="primary" class="content-area search-page">
		<main id="main" class="site-main" itemscope itemprop="mainContentOfPage">

		<?php while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', 'search-page' );

		endwhile; // End of the loop.
		?>

		</main>
	</div>

<?php
get_footer();