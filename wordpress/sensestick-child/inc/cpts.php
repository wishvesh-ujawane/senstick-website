<?php
/**
 * Custom Post Types.
 *
 * @package SENSESTICK
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action(
	'init',
	function () {
		// Product Family ------------------------------------------------------
		register_post_type(
			'product_family',
			array(
				'label'        => __( 'Product Families', 'sensestick' ),
				'labels'       => array(
					'name'          => __( 'Product Families', 'sensestick' ),
					'singular_name' => __( 'Product Family', 'sensestick' ),
					'add_new_item'  => __( 'Add New Product Family', 'sensestick' ),
					'edit_item'     => __( 'Edit Product Family', 'sensestick' ),
				),
				'public'       => true,
				'menu_icon'    => 'dashicons-products',
				'has_archive'  => false,
				'rewrite'      => array( 'slug' => 'products', 'with_front' => false ),
				'supports'     => array( 'title', 'editor', 'thumbnail', 'revisions' ),
				'show_in_rest' => true,
			)
		);

		// Resource ------------------------------------------------------------
		register_post_type(
			'resource',
			array(
				'label'        => __( 'Resources', 'sensestick' ),
				'labels'       => array(
					'name'          => __( 'Resources', 'sensestick' ),
					'singular_name' => __( 'Resource', 'sensestick' ),
					'add_new_item'  => __( 'Add New Resource', 'sensestick' ),
					'edit_item'     => __( 'Edit Resource', 'sensestick' ),
				),
				'public'       => true,
				'menu_icon'    => 'dashicons-media-document',
				'has_archive'  => true,
				'rewrite'      => array( 'slug' => 'resources', 'with_front' => false ),
				'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions' ),
				'show_in_rest' => true,
			)
		);

		// Download ------------------------------------------------------------
		register_post_type(
			'download',
			array(
				'label'        => __( 'Downloads', 'sensestick' ),
				'labels'       => array(
					'name'          => __( 'Downloads', 'sensestick' ),
					'singular_name' => __( 'Download', 'sensestick' ),
					'add_new_item'  => __( 'Add New Download', 'sensestick' ),
					'edit_item'     => __( 'Edit Download', 'sensestick' ),
				),
				'public'             => true,
				'publicly_queryable' => false,
				'exclude_from_search' => true,
				'menu_icon'          => 'dashicons-download',
				'has_archive'        => false,
				'rewrite'            => false,
				'supports'           => array( 'title', 'revisions' ),
				'show_in_rest'       => true,
			)
		);
	}
);
