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
				<?php the_archive_title( '<h1 class="page-title">', '</h1>' ); ?>
			</header>
			<div class="recipe-archive-content">
				<section class="recipe-search recipe-archive-search">
					<?php if ( is_active_sidebar( 'recipe-search' ) ) {
						dynamic_sidebar( 'recipe-search' );
					} ?>
				</section>
				<section class="posts-grid recipe-archive-grid">
					<ul class="posts-grid-list">
					<?php while ( have_posts() ) : ?>
						<?php the_post();
						get_template_part( 'template-parts/content', 'recipe-archive' ); ?>

					<?php endwhile; ?>
					</ul>
				</section>
			</div>

			<?php Mixes\Tags\posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>

		</main>
	</div>

<?php
// get_sidebar();
get_footer();