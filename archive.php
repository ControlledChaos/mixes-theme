<?php
/**
 * The template for displaying archive pages
 *
 * @package    WordPress/ClassicPress
 * @subpackage Monica_Mixes_Theme
 * @since      1.0.0
 */

get_header(); ?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main" itemscope itemprop="mainContentOfPage">

		<?php if ( have_posts() ) : ?>
			<header class="page-header">
				<?php echo sprintf(
					'<p class="page-title">%1s %2s</p>',
					__( 'You are exploring:', 'mixes-theme' ),
					get_the_archive_title()
				); ?>
			</header>

			<?php while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/content', get_post_type() );

			endwhile;

			Mixes\Tags\posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>

		</main>
	</div>
<?php
get_sidebar();
get_footer();