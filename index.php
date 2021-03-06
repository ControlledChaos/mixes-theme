<?php
/**
 * The main template file
 *
 * @package    WordPress/ClassicPress
 * @subpackage Monica_Mixes_Theme
 * @since      1.0.0
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" itemscope itemprop="mainContentOfPage">

		<?php if ( have_posts() ) :

			if ( is_home() && ! is_front_page() ) :
				?>
				<header>
					<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
				</header>
			<?php endif; ?>
			<section class="posts-grid posts-index-grid">
				<ul class="posts-grid-list">
				<?php while ( have_posts() ) : ?>
					<?php the_post();
					get_template_part( 'template-parts/content', 'index' ); ?>

				<?php endwhile; ?>
				</ul>
			</section>

			<?php Mixes\Tags\posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

		</main>
	</div>

<?php
// get_sidebar();
get_footer();
