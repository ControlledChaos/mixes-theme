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
if ( ! class_exists( 'acf_pro' ) ) {
	return;
}

/**
 * Add a page for theme settings
 *
 * Only works if ACF Pro is active.
 *
 * @since  1.0.0
 * @access public
 * @return mixed Returns the ACF form fields.
 */
if ( function_exists( 'acf_add_local_field_group' ) ) :

	acf_add_local_field_group( [
		'key'    => 'group_5d5414b1350d5',
		'title'  => 'Theme Settings',
		'fields' => [
			[
				'key'               => 'field_5d55764db5fd6',
				'label'             => 'Images',
				'name'              => '',
				'type'              => 'tab',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => [
					'width' => '',
					'class' => '',
					'id'    => '',
				],
				'acfe_permissions'  => '',
				'placement'         => 'top',
				'endpoint'          => 0,
			],
			[
				'key'               => 'field_5d54152b938a9',
				'label'             => 'Header Icon Images',
				'name'              => 'mixes_theme_header_icons',
				'type'              => 'gallery',
				'instructions'      => 'Images must be exactly 512px by 512px square.',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => [
					'width' => '',
					'class' => '',
					'id'    => '',
				],
				'acfe_permissions'  => '',
				'return_format'     => 'url',
				'preview_size'      => 'thumbnail',
				'insert'            => 'append',
				'library'           => 'all',
				'min'               => '',
				'max'               => '',
				'min_width'         => 512,
				'min_height'        => 512,
				'min_size'          => '',
				'max_width'         => 512,
				'max_height'        => 512,
				'max_size'          => '',
				'mime_types'        => '',
				'acfe_validate'     => '',
				'acfe_update'       => '',
			],
		],
		'location' => [
			[
				[
					'param'    => 'options_page',
					'operator' => '==',
					'value'    => 'mixes-theme-settings',
				],
			],
		],
		'menu_order'            => 0,
		'position'              => 'acf_after_title',
		'style'                 => 'seamless',
		'label_placement'       => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen'        => '',
		'active'                => true,
		'description'           => 'Settings for the Monica Mixes theme.',
		'acfe_display_title'    => '',
		'acfe_autosync'         => '',
		'acfe_permissions'      => '',
		'acfe_note'             => '',
		'acfe_meta'             => '',
	] );

endif;