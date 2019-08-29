<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @package    WordPress/ClassicPress
 * @subpackage Monica_Mixes_Theme
 * @since      1.0.0
 */

if ( is_home() && ! is_front_page() ) {
    $canonical = get_permalink( get_option( 'page_for_posts' ) );
} elseif ( is_archive() ) {
    $canonical = get_permalink( get_option( 'page_for_posts' ) );
} else {
    $canonical = get_permalink();
}

/**
 * Set up site title inner HTML and text
 *
 * Returns a conditional element, h1 if front page.
 *
 * @since 1.0.0
 */
if ( is_front_page() ) {
	$site_title = sprintf(
		'<h1 class="site-title"><span class="title-span-one">%1s</span> <span class="title-span-two">%2s</span></h1>',
		__( 'Monica', 'mixes-theme' ),
		__( 'Mixes', 'mixes-theme' )
	);
} else {
	$site_title = sprintf(
		'<p class="site-title"><a href="%1s" rel="home"><span class="title-span-one">%2s</span> <span class="title-span-two">%3s</span></a></p>',
		esc_attr( esc_url( home_url( '/' ) ) ),
		__( 'Monica', 'mixes-theme' ),
		__( 'Mixes', 'mixes-theme' )
	);
}

/**
 * Set up site description
 *
 * Returns null if no description is available.
 *
 * @since 1.0.0
 */
if ( get_bloginfo( 'description' ) || is_customize_preview() ) {
	$site_description = sprintf(
		'<p class="site-description">%1s</p>',
		get_bloginfo( 'description', 'display' )
	);
} else {
	$site_description = null;
}

?>
<!doctype html>
<?php do_action( 'before_html' ); ?>
<html <?php language_attributes(); ?> class="no-js">
<head id="<?php echo get_bloginfo( 'wpurl' ); ?>" data-template-set="<?php echo get_template(); ?>">
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<!--[if IE ]>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<![endif]-->
	<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
	<link rel="profile" href="https://gmpg.org/xfn/11" />
	<?php if ( is_singular() && pings_open() ) {
		echo sprintf( '<link rel="pingback" href="%s" />', get_bloginfo( 'pingback_url' ) );
	} ?>
	<link href="<?php echo $canonical; ?>" rel="canonical" />
	<?php if ( is_search() ) { echo '<meta name="robots" content="noindex,nofollow" />'; } ?>

	<!-- Prefetch font URLs -->
	<link rel="dns-prefetch" href="//fonts.adobe.com" />
	<link rel="dns-prefetch" href="//fonts.google.com" />
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site" itemscope="itemscope" itemtype="<?php Mixes\Tags\site_schema(); ?>">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'mixes-theme' ); ?></a>
	<nav id="site-navigation" class="main-navigation" role="directory" itemscope itemtype="http://schema.org/SiteNavigationElement">
		<div class="menu-toggle-wrap">
			<button id="menu-toggle-button" class="menu-toggle" aria-controls="main-menu" aria-expanded="false">
				<!-- Start open menu icon -->
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="theme-icon menu-icon menu-open-icon"><path d="M16 132h416c8.837 0 16-7.163 16-16V76c0-8.837-7.163-16-16-16H16C7.163 60 0 67.163 0 76v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16z"/></svg>
				<!-- End open menu icon -->
				<!-- Start close menu icon -->
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 352 512" class="theme-icon menu-icon menu-close-icon"><path d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z"/></svg>
				<!-- Start close menu icon -->
				<span><?php esc_html_e( 'Menu', 'mixes-theme' ); ?></span>
			</button>
		</div>
		<?php
		wp_nav_menu( [
			'theme_location' => 'main',
			'menu_id'        => 'main-menu',
			'container'      => false
		] );
		?>
	</nav>
	<header id="masthead" class="site-header" role="banner" itemscope="itemscope" itemtype="http://schema.org/Organization">
		<?php get_template_part( 'template-parts/site-branding' ); ?>
		<?php echo $site_description; ?>
		<?php
		if ( is_front_page() ) {
			get_template_part( 'template-parts/hero', 'front' );
		} elseif ( is_singular( 'recipe' ) ) {
			get_template_part( 'template-parts/hero', 'recipe' );
		} else {
			get_template_part( 'template-parts/hero' );
		} ?>
	</header>

	<div id="content" class="site-content">
