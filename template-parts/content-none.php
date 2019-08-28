<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @package    WordPress/ClassicPress
 * @subpackage Monica_Mixes_Theme
 * @since      1.0.0
 */

?>

<section class="no-results not-found">
	<header class="page-header">
		<h1 class="page-title"><?php esc_html_e( 'Nothing Found', 'mixes-theme' ); ?></h1>
	</header>

	<div class="page-content" itemprop="articleBody">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) :

			printf(
				'<p>' . wp_kses(
					__( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'mixes-theme' ),
					[
						'a' => [
							'href' => [],
						],
					]
				) . '</p>',
				esc_url( admin_url( 'post-new.php' ) )
			);

		elseif ( is_search() ) : ?>

			<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'mixes-theme' ); ?></p>

			<div class="entry-content search-page-content" itemprop="articleBody">
				<?php if ( is_active_sidebar( 'search-page' ) ) {
					dynamic_sidebar( 'search-page' );
				} ?>
			</div>

		<?php else : ?>

			<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'mixes-theme' ); ?></p>

			<div class="entry-content search-page-content" itemprop="articleBody">
				<?php if ( is_active_sidebar( 'search-page' ) ) {
					dynamic_sidebar( 'search-page' );
				} ?>
			</div>

		<?php endif; ?>
	</div>
</section>
