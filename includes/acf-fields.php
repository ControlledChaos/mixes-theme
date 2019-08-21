<?php
/**
 * Theme-specific ACF fields
 *
 * @package    WordPress/ClassicPress
 * @subpackage Monica_Mixes_Theme
 * @since      1.0.0
 */

// Namespace specificity for theme functions & filters.
namespace Mixes\Includes;

// Restrict direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Bail if ACF Pro is not active.
if ( class_exists( 'acf_pro' ) ) {
	return;
}

