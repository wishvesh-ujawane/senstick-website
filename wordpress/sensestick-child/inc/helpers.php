<?php
/**
 * SENSESTICK — template/data helpers.
 *
 * Small, focused functions used by Elementor dynamic-tag callbacks, shortcodes,
 * and (where unavoidable) inline PHP in template parts. Each helper is null-safe
 * and returns a primitive or array — no echoes.
 *
 * @package SENSESTICK
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get the Industries page WP_Post object, or null if it has not been seeded.
 *
 * Cached for the duration of the request.
 *
 * @return WP_Post|null
 */
function ss_get_industries_page() {
	static $cached = false;

	if ( false !== $cached ) {
		return $cached;
	}

	$page    = get_page_by_path( 'industries' );
	$cached  = ( $page instanceof WP_Post ) ? $page : null;

	return $cached;
}

/**
 * Return all rows from the Industries page `industries` repeater.
 *
 * Each row shape:
 *   icon (array|false), title (string), body (string),
 *   learn_more_link (string), featured_on_home (bool), featured_on_about (bool)
 *
 * @return array<int, array<string, mixed>>
 */
function ss_get_industries() {
	if ( ! function_exists( 'get_field' ) ) {
		return array();
	}

	$page = ss_get_industries_page();
	if ( ! $page ) {
		return array();
	}

	$rows = get_field( 'industries', $page->ID );
	return is_array( $rows ) ? $rows : array();
}

/**
 * Filter industries by feature flag.
 *
 * @param string $flag Either 'home' or 'about'.
 * @param int    $limit Optional. Cap the result count.
 * @return array<int, array<string, mixed>>
 */
function ss_get_featured_industries( $flag = 'home', $limit = 0 ) {
	$field = 'featured_on_' . ( 'about' === $flag ? 'about' : 'home' );
	$rows  = array_values(
		array_filter(
			ss_get_industries(),
			static function ( $row ) use ( $field ) {
				return ! empty( $row[ $field ] );
			}
		)
	);

	if ( $limit > 0 ) {
		$rows = array_slice( $rows, 0, $limit );
	}

	return $rows;
}

/**
 * Convert a byte count to a human-readable string (1.8 MB, 240 KB, etc.).
 *
 * @param int|float|string $bytes
 * @param int              $precision
 * @return string
 */
function ss_format_filesize( $bytes, $precision = 1 ) {
	$bytes = (float) $bytes;
	if ( $bytes <= 0 ) {
		return '';
	}

	$units = array( 'B', 'KB', 'MB', 'GB', 'TB' );
	$pow   = (int) floor( log( $bytes, 1024 ) );
	$pow   = max( 0, min( $pow, count( $units ) - 1 ) );
	$value = $bytes / ( 1024 ** $pow );

	return number_format_i18n( $value, $precision ) . ' ' . $units[ $pow ];
}

/**
 * Get human-readable size for an ACF file array (return_format=array).
 *
 * @param array<string, mixed>|null $file
 * @return string
 */
function ss_acf_filesize( $file ) {
	if ( ! is_array( $file ) ) {
		return '';
	}

	$bytes = isset( $file['filesize'] ) ? (int) $file['filesize'] : 0;
	if ( $bytes <= 0 && ! empty( $file['url'] ) ) {
		$path = wp_parse_url( $file['url'], PHP_URL_PATH );
		if ( $path ) {
			$abs = ABSPATH . ltrim( str_replace( wp_parse_url( site_url(), PHP_URL_PATH ) ?? '', '', $path ), '/' );
			if ( file_exists( $abs ) ) {
				$bytes = (int) filesize( $abs );
			}
		}
	}

	return ss_format_filesize( $bytes );
}

/**
 * Extract a file extension label (PDF / ZIP / EXE) from an ACF file array.
 *
 * @param array<string, mixed>|null $file
 * @return string
 */
function ss_acf_file_ext( $file ) {
	if ( ! is_array( $file ) || empty( $file['filename'] ) ) {
		return '';
	}
	$ext = pathinfo( $file['filename'], PATHINFO_EXTENSION );
	return $ext ? strtoupper( $ext ) : '';
}

/**
 * Render a simple breadcrumb trail.
 *
 * Elementor Pro ships a breadcrumb widget; this is a CMS-safe fallback used
 * only on templates that have not been wired through Elementor yet.
 *
 * @param array<int, array{label:string, url?:string}> $items
 * @return string HTML.
 */
function ss_render_breadcrumb( array $items ) {
	if ( empty( $items ) ) {
		return '';
	}

	$parts = array();
	$last  = count( $items ) - 1;

	foreach ( $items as $i => $item ) {
		$label = isset( $item['label'] ) ? esc_html( $item['label'] ) : '';
		if ( '' === $label ) {
			continue;
		}
		if ( $i < $last && ! empty( $item['url'] ) ) {
			$parts[] = '<a href="' . esc_url( $item['url'] ) . '">' . $label . '</a>';
		} else {
			$parts[] = '<span aria-current="page">' . $label . '</span>';
		}
	}

	return '<nav class="ss-breadcrumb" aria-label="Breadcrumb">' . implode( ' <span class="ss-breadcrumb__sep" aria-hidden="true">&rsaquo;</span> ', $parts ) . '</nav>';
}

/**
 * Get downloads in a category, ordered by date desc.
 *
 * @param string $category_slug
 * @param int    $limit
 * @return WP_Post[]
 */
function ss_get_downloads_by_category( $category_slug, $limit = -1 ) {
	if ( '' === $category_slug ) {
		return array();
	}

	$query = new WP_Query(
		array(
			'post_type'      => 'download',
			'post_status'    => 'publish',
			'posts_per_page' => $limit,
			'orderby'        => 'date',
			'order'          => 'DESC',
			'tax_query'      => array(
				array(
					'taxonomy' => 'download_category',
					'field'    => 'slug',
					'terms'    => $category_slug,
				),
			),
			'no_found_rows'  => true,
		)
	);

	return $query->posts;
}

/**
 * Resolve a download's file array (ACF) for use in templates.
 *
 * @param int $download_id
 * @return array<string, mixed>|null
 */
function ss_get_download_file( $download_id ) {
	if ( ! function_exists( 'get_field' ) ) {
		return null;
	}
	$file = get_field( 'file', $download_id );
	return is_array( $file ) ? $file : null;
}
