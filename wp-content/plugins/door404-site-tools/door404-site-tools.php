<?php
/**
 * Plugin Name: Door 404 Site Tools
 * Description: Site-specific presentation and SEO improvements for escaperoom.co.rs.
 * Version: 0.2.1
 * Author: Door 404
 */

defined( 'ABSPATH' ) || exit;

function door404_category_hub_template( $template ) {
	if ( is_category( 'saveti-i-ideje' ) ) {
		$custom_template = plugin_dir_path( __FILE__ ) . 'templates/category-saveti-i-ideje.php';
		if ( is_readable( $custom_template ) ) {
			return $custom_template;
		}
	}
	return $template;
}
add_filter( 'template_include', 'door404_category_hub_template', 99 );

function door404_category_hub_assets() {
	if ( is_category( 'saveti-i-ideje' ) ) {
		wp_enqueue_style( 'door404-category-hub', plugins_url( 'assets/category-hub.css', __FILE__ ), array(), '0.2.1' );
	}
}
add_action( 'wp_enqueue_scripts', 'door404_category_hub_assets', 20 );

function door404_reading_time( $content ) {
	$words = str_word_count( wp_strip_all_tags( $content ) );
	return max( 1, (int) ceil( $words / 200 ) ) . ' min čitanja';
}
