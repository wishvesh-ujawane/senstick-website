<?php
/**
 * Template Name: SENSESTICK Home
 *
 * Thin wrapper — Elementor Pro Theme Builder renders the page body.
 * The template file exists so it can be selected in the admin and so the
 * Home page ACF group binds via `page_template == page-home.php`.
 *
 * @package SENSESTICK
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) {
	the_post();
	the_content();
}

get_footer();
