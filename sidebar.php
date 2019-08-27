<?php
/**
 * The sidebar containing the main widget area
 *
 * @package    WordPress/ClassicPress
 * @subpackage Monica_Mixes_Theme
 * @since      1.0.0
 */

?>

<aside id="secondary" class="secondary">
	<?php
		if ( is_active_sidebar( 'sidebar' ) ) {
			dynamic_sidebar( 'sidebar' );
		} ?>
</aside>
