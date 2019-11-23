<?php
/**
 * The template for displaying search results pages
 *
 * @package    WordPress/ClassicPress
 * @subpackage Monica_Mixes_Theme
 * @since      1.0.0
 */

get_header(); ?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main" itemscope itemprop="mainContentOfPage">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<?php echo sprintf(
					'<p class="page-title">%1s %2s</p>',
					__( 'Search Results for:', 'mixes-theme' ),
					get_search_query()
				); ?>
			</header>

			<?php while ( have_posts() ) : the_post();

				if ( class_exists( 'acf_pro' ) && 'recipe' == get_post_type() ) {
					get_template_part( 'template-parts/content-search-recipe', 'acf' );
				} elseif ( is_singular( 'recipe' ) ) {
						get_template_part( 'template-parts/content-search-recipe', 'no-acf' );
				} else {
					get_template_part( 'template-parts/content', 'search' );
				}

			endwhile;

			Mixes\Tags\posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

		</main>
	</section>

<?php
get_sidebar();
get_footer();
