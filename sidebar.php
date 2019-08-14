<?php
/**
 * The sidebar containing the main widget area
 *
 * @package    WordPress/ClassicPress
 * @subpackage Monica_Mixes_Theme
 * @since      1.0.0
 */

?>

<aside id="secondary" class="widget-area">
	<?php
		if ( is_active_sidebar( 'sidebar' ) ) :

		dynamic_sidebar( 'sidebar' );

		else : ?>

    	<?php get_search_form(); ?>

    	<h3><?php _e( 'Archives', 'mixes-theme' ); ?></h3>
    	<ul>
    		<?php wp_get_archives( 'type=monthly' ); ?>
		</ul>

		<?php the_widget(
			'WP_Widget_Categories',
			null,
			[
				'before_title' => '<h3>',
				'after_title' => '</h3>'
			]
		); ?>

    	<h3><?php _e( 'Meta', 'mixes-theme' ); ?></h3>
    	<ul>
			<?php wp_register(); ?>
			<?php if ( is_user_logged_in() ) : ?>
			<li>
				<a href="<?php echo get_edit_user_link(); ?>"><?php _e( 'Your Profile', 'mixes-theme' ); ?></a>
			</li>
			<?php endif; ?>
    		<li><?php wp_loginout(); ?></li>
			<?php wp_meta(); ?>
    	</ul>

    	<h3><?php _e( 'Subscribe', 'mixes-theme' ); ?></h3>
    	<ul>
    		<li><a href="<?php bloginfo( 'rss2_url' ); ?>"><?php _e( 'Entries RSS', 'mixes-theme' ); ?></a></li>
    		<li><a href="<?php bloginfo( 'comments_rss2_url' ); ?>"><?php _e( 'Comments RSS', 'mixes-theme' ); ?></a></li>
    	</ul>

	<?php endif; ?>
</aside>
