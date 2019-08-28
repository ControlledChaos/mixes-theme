<?php
/**
 * The template for displaying the footer
 *
 * @package    WordPress/ClassicPress
 * @subpackage Monica_Mixes_Theme
 * @since      1.0.0
 */

// Get the site name.
$site_name = esc_attr( get_bloginfo( 'name' ) );

// Copyright HTML.
$copyright = sprintf(
	'<p class="copyright-text" itemscope="itemscope" itemtype="http://schema.org/CreativeWork">&copy; <span class="screen-reader-text">%1s</span><span itemprop="copyrightYear">%2s</span> <span itemprop="copyrightHolder">%3s.</span> %4s.</p>',
	esc_html__( 'Copyright ', 'mixes-theme' ),
	get_the_time( 'Y' ),
	$site_name,
	esc_html__( 'All rights reserved', 'mixes-theme' )
); ?>

	</div><!-- #content -->
</div><!-- #page -->

<footer id="colophon" class="site-footer">
	<div class="footer-menu">
		<?php
		wp_nav_menu( [
			'theme_location' => 'footer',
			'menu_id'        => 'footer-menu',
			'menu_class'     => 'footer-wrapper',
			'fallback_cb'    => null
		] );
		?>
	</div>
	<div class="footer-copyright">
		<div class="footer-wrapper">
			<?php echo $copyright; ?>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>

</body>
</html>