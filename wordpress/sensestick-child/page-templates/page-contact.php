<?php
/**
 * Template Name: SENSESTICK Contact
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
