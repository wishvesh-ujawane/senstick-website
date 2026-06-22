<?php
/**
 * Template Name: SENSESTICK Book a Demo
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
