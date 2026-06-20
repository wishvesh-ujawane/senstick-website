<?php
/**
 * SENSESTICK Child Theme — bootstrap.
 *
 * Loads the parent stylesheet, registers CPTs + taxonomies in code (so they
 * exist regardless of which admin plugins are active), and points ACF at the
 * version-controlled acf-json/ directory for two-way sync.
 *
 * Reasoning for code-registered CPTs (deviation from CPT UI as the sole
 * source): the registrations live in the repo and survive plugin churn. CPT
 * UI may still be installed for ad-hoc admin tasks, but it is not authoritative.
 *
 * @package SENSESTICK
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'SENSESTICK_CHILD_VERSION', '0.1.0' );
define( 'SENSESTICK_CHILD_DIR', get_stylesheet_directory() );
define( 'SENSESTICK_CHILD_URI', get_stylesheet_directory_uri() );

/**
 * Enqueue parent + child stylesheets.
 */
add_action(
	'wp_enqueue_scripts',
	function () {
		wp_enqueue_style(
			'hello-elementor-parent',
			get_template_directory_uri() . '/style.css',
			array(),
			null
		);

		wp_enqueue_style(
			'sensestick-child',
			SENSESTICK_CHILD_URI . '/style.css',
			array( 'hello-elementor-parent' ),
			SENSESTICK_CHILD_VERSION
		);
	},
	20
);

/**
 * Tell ACF to load and save field groups from the version-controlled
 * acf-json/ directory inside this theme. Any change made in the WP admin
 * is written back to JSON automatically (two-way sync).
 */
add_filter(
	'acf/settings/save_json',
	function () {
		return SENSESTICK_CHILD_DIR . '/acf-json';
	}
);

add_filter(
	'acf/settings/load_json',
	function ( $paths ) {
		// Replace the default core path so the only source of truth is this theme.
		unset( $paths[0] );
		$paths[] = SENSESTICK_CHILD_DIR . '/acf-json';
		return $paths;
	}
);

require_once SENSESTICK_CHILD_DIR . '/inc/theme-setup.php';
require_once SENSESTICK_CHILD_DIR . '/inc/cpts.php';
require_once SENSESTICK_CHILD_DIR . '/inc/taxonomies.php';
