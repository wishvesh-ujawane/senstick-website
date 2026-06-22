<?php
/**
 * Canonical-page seeder.
 *
 * On theme activation, ensures all 8 user-visible pages exist in WP with the
 * correct slug, title, and page template. Idempotent: existing pages are not
 * overwritten — only their page_template and title are aligned if missing.
 *
 * After seeding, the front page is set to the Home page and posts page disabled.
 *
 * @package SENSESTICK
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Definition of all canonical pages. Order matches the Figma site map.
 *
 * @return array<int, array{slug:string, title:string, template:string}>
 */
function ss_canonical_pages() {
	return array(
		array( 'slug' => 'home',            'title' => 'Home',             'template' => 'page-templates/page-home.php' ),
		array( 'slug' => 'getting-started', 'title' => 'Getting Started',  'template' => 'page-templates/page-getting-started.php' ),
		array( 'slug' => 'industries',      'title' => 'Industries',       'template' => 'page-templates/page-industries.php' ),
		array( 'slug' => 'downloads',       'title' => 'Downloads',        'template' => 'page-templates/page-downloads.php' ),
		array( 'slug' => 'about',           'title' => 'About SENSESTICK', 'template' => 'page-templates/page-about.php' ),
		array( 'slug' => 'contact',         'title' => 'Contact Us',       'template' => 'page-templates/page-contact.php' ),
		array( 'slug' => 'book-a-demo',     'title' => 'Book a Demo',      'template' => 'page-templates/page-book-demo.php' ),
	);
}

add_action(
	'after_switch_theme',
	function () {
		foreach ( ss_canonical_pages() as $def ) {
			$existing = get_page_by_path( $def['slug'] );

			if ( $existing instanceof WP_Post ) {
				// Align page template if missing.
				$current = get_page_template_slug( $existing->ID );
				if ( '' === $current ) {
					update_post_meta( $existing->ID, '_wp_page_template', $def['template'] );
				}
				continue;
			}

			$page_id = wp_insert_post(
				array(
					'post_title'   => $def['title'],
					'post_name'    => $def['slug'],
					'post_status'  => 'publish',
					'post_type'    => 'page',
					'post_content' => '',
					'meta_input'   => array(
						'_wp_page_template' => $def['template'],
					),
				),
				true
			);

			if ( is_wp_error( $page_id ) ) {
				continue;
			}
		}

		// Set Home page as the front page and disable the posts page.
		$home = get_page_by_path( 'home' );
		if ( $home instanceof WP_Post ) {
			update_option( 'show_on_front', 'page' );
			update_option( 'page_on_front', $home->ID );
			update_option( 'page_for_posts', 0 );
		}
	}
);
