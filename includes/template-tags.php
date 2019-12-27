<?php
/**
 * Template tags
 *
 * @package    WordPress/ClassicPress
 * @subpackage Monica_Mixes_Theme
 * @since      1.0.0
 */

// Namespace specificity for theme functions & filters.
namespace Mixes\Tags;

// Restrict direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Check if WordPress is 5.0 or greater.
 *
 * @since  1.0.0
 * @access public
 * @return bool Returns true if the WordPress version is 5.0 or greater.
 */
function theme_new_cms() {

	// Get the WordPress version.
	$version = get_bloginfo( 'version' );

	if ( $version >= 5.0 ) {
		return true;
	} else {
		return false;
	}

}

/**
 * Check if the CMS is ClassicPress.
 *
 * @since  1.0.0
 * @access public
 * @return bool Returns true if ClassicPress is running.
 */
function theme_classicpress() {

	if ( function_exists( 'classicpress_version' ) ) {
		return true;
	} else {
		return false;
	}

}

/**
 * Check for Advanced Custom Fields
 *
 * @since  1.0.0
 * @access public
 * @return bool Returns true if the ACF free or Pro plugin is active.
 */
function theme_acf() {

	if ( class_exists( 'acf' ) ) {
		return true;
	} else {
		return false;
	}

}

/**
 * Check for Advanced Custom Fields Pro
 *
 * @since  1.0.0
 * @access public
 * @return bool Returns true if the ACF Pro plugin is active.
 */
function theme_acf_pro() {

	if ( class_exists( 'acf_pro' ) ) {
		return true;
	} else {
		return false;
	}

}

/**
 * Check for Advanced Custom Fields options page
 *
 * @since  1.0.0
 * @access public
 * @return bool Returns true if ACF 4.0 free plus the
 *              Options Page addon or Pro plugin is active.
 */
function theme_acf_options() {

	if ( class_exists( 'acf_pro' ) ) {
		return true;
	} elseif ( ( class_exists( 'acf' ) && class_exists( 'acf_options_page' ) ) ) {
		return true;
	} else {
		return false;
	}

}

/**
 * Conditional Schema attributes for `<div id="page"`
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function site_schema() {

	// Change page slugs and template names as needed.
	if ( is_singular( 'recipe' ) ) {
		$itemtype = esc_attr( 'Recipe' );
	} elseif ( is_page( 'about' ) || is_page( 'about-us' ) || is_page_template( 'page-about.php' ) || is_page_template( 'about.php' ) ) {
		$itemtype = esc_attr( 'AboutPage' );
	} elseif ( is_page( 'contact' ) || is_page( 'contact-us' ) || is_page_template( 'page-contact.php' ) || is_page_template( 'contact.php' ) ) {
		$itemtype = esc_attr( 'ContactPage' );
	} elseif ( is_page( 'faq' ) || is_page( 'faqs' ) || is_page_template( 'page-faq.php' ) || is_page_template( 'faq.php' ) ) {
		$itemtype = esc_attr( 'QAPage' );
	} elseif ( is_page( 'cart' ) || is_page( 'shopping-cart' ) || is_page( 'checkout' ) || is_page_template( 'cart.php' ) || is_page_template( 'checkout.php' ) ) {
		$itemtype = esc_attr( 'CheckoutPage' );
	} elseif ( is_front_page() || is_page() ) {
		$itemtype = esc_attr( 'WebPage' );
	} elseif ( is_author() || is_plugin_active( 'buddypress/bp-loader.php' ) && bp_is_home() || is_plugin_active( 'bbpress/bbpress.php' ) && bbp_is_user_home() ) {
		$itemtype = esc_attr( 'ProfilePage' );
	} elseif ( is_search() ) {
		$itemtype = esc_attr( 'SearchResultsPage' );
	} else {
		$itemtype = esc_attr( 'Blog' );
	}

	echo $itemtype;

}

/**
 * Print HTML with meta information for the current post-date/time
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function posted_on() {

	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( DATE_W3C ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( DATE_W3C ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		/* translators: %s: post date. */
		esc_html_x( '%s', 'post date', 'mixes-theme' ),
		'<a href="' . esc_url( get_month_link( get_post_time( 'Y' ), get_post_time( 'm' ) ) ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.

}

/**
 * Prints HTML with meta information for the current author
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function posted_by() {

	$byline = sprintf(
		esc_html_x( 'by %s', 'post author', 'mixes-theme' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo '<span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

}

/**
 * Prints HTML with meta information for the categories, tags and comments
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function entry_footer() {

	// Categories icon.
	$cat_icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M464 128H272l-64-64H48C21.49 64 0 85.49 0 112v288c0 26.51 21.49 48 48 48h416c26.51 0 48-21.49 48-48V176c0-26.51-21.49-48-48-48z"/></svg>';

	// Tags icon.
	$tags_icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path d="M497.941 225.941L286.059 14.059A48 48 0 0 0 252.118 0H48C21.49 0 0 21.49 0 48v204.118a48 48 0 0 0 14.059 33.941l211.882 211.882c18.744 18.745 49.136 18.746 67.882 0l204.118-204.118c18.745-18.745 18.745-49.137 0-67.882zM112 160c-26.51 0-48-21.49-48-48s21.49-48 48-48 48 21.49 48 48-21.49 48-48 48zm513.941 133.823L421.823 497.941c-18.745 18.745-49.137 18.745-67.882 0l-.36-.36L527.64 323.522c16.999-16.999 26.36-39.6 26.36-63.64s-9.362-46.641-26.36-63.64L331.397 0h48.721a48 48 0 0 1 33.941 14.059l211.882 211.882c18.745 18.745 18.745 49.137 0 67.882z"/></svg>';

	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {

		$categories_list = get_the_category_list( esc_html__( ', ', 'mixes-theme' ) );
		if ( $categories_list ) {
			printf(
				'<span class="cat-links" title="%1s"><span class="post-meta-icon">%2s</span><span class="screen-reader-text">%3s</span> %4s</span>',
				esc_html__( 'Posted in', 'mixes-theme' ),
				$cat_icon,
				esc_html__( 'Posted in', 'mixes-theme' ),
				$categories_list
			);
		}

		$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'mixes-theme' ) );

		// Categories and tags separator if both are present.
		if ( $categories_list && $tags_list ) { echo '<span clss="tax-links-separator">|</span>'; }

		if ( $tags_list ) {
			printf(
				'<span class="tags-links" title="%1s"><span class="post-meta-icon">%2s</span><span class="screen-reader-text">%3s</span> %4s</span>',
				esc_html__( 'Tagged', 'mixes-theme' ),
				$tags_icon,
				esc_html__( 'Tagged', 'mixes-theme' ),
				$tags_list
			);
		}

	} elseif ( 'recipe' === get_post_type() ) {

		$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'mixes-theme' ) );

		if ( $tags_list && is_search() ) {
			printf(
				'<span class="tags-links"><span class="post-meta-icon">%1s</span>%2s %3s</span>',
				$tags_icon,
				esc_html__( 'Tagged:', 'mixes-theme' ),
				$tags_list
			);
		} elseif ( $tags_list ) {
			echo sprintf(
				'<h3>%1s</h3>',
				esc_html__( 'Recipe Tags', 'mixes-theme' )
			);
			echo sprintf(
				'<p>%1s</p>',
				esc_html__( 'Search for recipes that have one of the following tags in common with this recipe:', 'mixes-theme' )
			);
			echo sprintf(
				'<p><span class="post-meta-icon">%1s</span><span class="tags-links">%2s</span></p>',
				$tags_icon,
				$tags_list
			);
		}

	}

	if ( ! is_single() && ! post_password_required() && ! is_search() && ( comments_open() || get_comments_number() ) ) {

		echo '<span class="comments-link">';
		comments_popup_link(
			sprintf(
				wp_kses(
					__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'mixes-theme' ),
					[
						'span' => [
							'class' => [],
						],
					]
				),
				get_the_title()
			)
		);
		echo '</span>';
	}

}

/**
 * Displays an optional post thumbnail
 *
 * Wraps the post thumbnail in an anchor element on index views, or a div
 * element when on single views.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function post_thumbnail() {

	if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
		return;
	}

	if ( is_singular() ) :
		?>

		<div class="post-thumbnail">
			<?php the_post_thumbnail(); ?>
		</div>

	<?php else : ?>

	<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
		<?php
		the_post_thumbnail( 'archive-pages', [
			'class' => 'excerpt-thumbnail alignright',
			'alt' => the_title_attribute( [
				'echo' => false,
			] ),
		] );
		?>
	</a>

	<?php
	endif;
}

/**
 * Posts navigation for index and archive pages
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function posts_navigation() {

	// Nav text for recipes.
	if ( is_post_type_archive( 'recipe' ) ) {
		$prev_text = __( 'Previous Recipes', 'mixes-theme' );
		$next_text = __( 'Next Recipes', 'mixes-theme' );

	// Nav text for posts.
	} else {
		$prev_text = __( 'Older Posts', 'mixes-theme' );
		$next_text = __( 'Newer Posts', 'mixes-theme' );
	}

	// Previous icon.
	$prev_icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="theme-icon menu-prev"><path d="M257.5 445.1l-22.2 22.2c-9.4 9.4-24.6 9.4-33.9 0L7 273c-9.4-9.4-9.4-24.6 0-33.9L201.4 44.7c9.4-9.4 24.6-9.4 33.9 0l22.2 22.2c9.5 9.5 9.3 25-.4 34.3L136.6 216H424c13.3 0 24 10.7 24 24v32c0 13.3-10.7 24-24 24H136.6l120.5 114.8c9.8 9.3 10 24.8.4 34.3z"/></svg>';

	// Next icon.
	$next_icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="theme-icon menu-next"><path d="M190.5 66.9l22.2-22.2c9.4-9.4 24.6-9.4 33.9 0L441 239c9.4 9.4 9.4 24.6 0 33.9L246.6 467.3c-9.4 9.4-24.6 9.4-33.9 0l-22.2-22.2c-9.5-9.5-9.3-25 .4-34.3L311.4 296H24c-13.3 0-24-10.7-24-24v-32c0-13.3 10.7-24 24-24h287.4L190.9 101.2c-9.8-9.3-10-24.8-.4-34.3z"/></svg>';

	// Array to return.
	$posts_navigation = the_posts_navigation( [
		'prev_text' => $prev_icon . $prev_text,
		'next_text' => $next_text . $next_icon
	] );

	return $posts_navigation;

}

/**
 * Posts navigation for singular pages
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function post_navigation() {

	// Nav text for recipes.
	if ( is_post_type_archive( 'recipe' ) ) {
		$prev_text = __( 'Previous Recipes', 'mixes-theme' );
		$next_text = __( 'Next Recipes', 'mixes-theme' );

	// Nav text for posts.
	} else {
		$prev_text = __( 'Older Posts', 'mixes-theme' );
		$next_text = __( 'Newer Posts', 'mixes-theme' );
	}

	// Previous icon.
	$prev_icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="theme-icon menu-prev"><path d="M257.5 445.1l-22.2 22.2c-9.4 9.4-24.6 9.4-33.9 0L7 273c-9.4-9.4-9.4-24.6 0-33.9L201.4 44.7c9.4-9.4 24.6-9.4 33.9 0l22.2 22.2c9.5 9.5 9.3 25-.4 34.3L136.6 216H424c13.3 0 24 10.7 24 24v32c0 13.3-10.7 24-24 24H136.6l120.5 114.8c9.8 9.3 10 24.8.4 34.3z"/></svg>';

	// Next icon.
	$next_icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="theme-icon menu-next"><path d="M190.5 66.9l22.2-22.2c9.4-9.4 24.6-9.4 33.9 0L441 239c9.4 9.4 9.4 24.6 0 33.9L246.6 467.3c-9.4 9.4-24.6 9.4-33.9 0l-22.2-22.2c-9.5-9.5-9.3-25 .4-34.3L311.4 296H24c-13.3 0-24-10.7-24-24v-32c0-13.3 10.7-24 24-24h287.4L190.9 101.2c-9.8-9.3-10-24.8-.4-34.3z"/></svg>';

	// Array to return.
	$posts_navigation = the_post_navigation( [
		'prev_text' => $prev_icon . get_the_title(),
		'next_text' => get_the_title() . $next_icon
	] );

	return $posts_navigation;

}