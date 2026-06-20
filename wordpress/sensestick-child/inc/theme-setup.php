<?php
/**
 * Theme supports + image sizes.
 *
 * @package SENSESTICK
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action(
	'after_setup_theme',
	function () {
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );

		// Match plan: media sizes (thumb 300, medium 600, large 1200).
		add_image_size( 'ss-card-16x9', 600, 338, true );
		add_image_size( 'ss-hero-product', 1200, 900, false );
		add_image_size( 'ss-thumb-square', 300, 300, true );

		register_nav_menus(
			array(
				'primary' => __( 'Primary Menu', 'sensestick' ),
				'footer'  => __( 'Footer Menu', 'sensestick' ),
			)
		);
	}
);
