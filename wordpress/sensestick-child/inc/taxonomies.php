<?php
/**
 * Custom taxonomies.
 *
 * @package SENSESTICK
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action(
	'init',
	function () {
		// Resource Type — applied to `resource` ------------------------------
		register_taxonomy(
			'resource_type',
			array( 'resource' ),
			array(
				'label'             => __( 'Resource Type', 'sensestick' ),
				'hierarchical'      => true,
				'public'            => true,
				'show_admin_column' => true,
				'show_in_rest'      => true,
				'rewrite'           => array( 'slug' => 'resources/type' ),
			)
		);

		// Download Category — applied to `download` --------------------------
		register_taxonomy(
			'download_category',
			array( 'download' ),
			array(
				'label'             => __( 'Download Category', 'sensestick' ),
				'hierarchical'      => true,
				'public'            => false,
				'show_ui'           => true,
				'show_admin_column' => true,
				'show_in_rest'      => true,
				'rewrite'           => false,
			)
		);

		// Download Type — applied to `download` ------------------------------
		register_taxonomy(
			'download_type',
			array( 'download' ),
			array(
				'label'             => __( 'Download Type', 'sensestick' ),
				'hierarchical'      => true,
				'public'            => false,
				'show_ui'           => true,
				'show_admin_column' => true,
				'show_in_rest'      => true,
				'rewrite'           => false,
			)
		);
	}
);

/**
 * Seed the canonical terms on theme switch so a fresh install matches the plan.
 * Idempotent: skips terms that already exist.
 */
add_action(
	'after_switch_theme',
	function () {
		$seed = array(
			'resource_type' => array(
				'Tutorial',
				'Use Case',
				'User Guide',
				'Spreadsheet Integration',
				'Installation Guide',
			),
			'download_category' => array(
				'Temperature Family',
				'Microsoft Excel',
				'Google Sheets',
				'LibreOffice Calc',
				'ONLYOFFICE Spreadsheet',
				'Tutorials',
				'Use Cases',
			),
			'download_type' => array(
				'Datasheet',
				'Brochure',
				'Software',
				'User Guide PDF',
				'Installation Guide PDF',
				'Certificate',
			),
		);

		foreach ( $seed as $taxonomy => $terms ) {
			foreach ( $terms as $term ) {
				if ( ! term_exists( $term, $taxonomy ) ) {
					wp_insert_term( $term, $taxonomy );
				}
			}
		}
	}
);
