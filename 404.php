<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package    WordPress/ClassicPress
 * @subpackage Monica_Mixes_Theme
 * @since      1.0.0
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" itemscope itemprop="mainContentOfPage">

			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'mixes-theme' ); ?></h1>
				</header>

				<div class="page-content">
					<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the search forms below.', 'mixes-theme' ); ?></p>
					<div class="entry-content search-page-content" itemprop="articleBody">
						<?php if ( is_active_sidebar( 'search-page' ) ) {
							dynamic_sidebar( 'search-page' );
						} ?>
					</div>
				</div>
			</section>

		</main>
	</div>

<?php get_footer();