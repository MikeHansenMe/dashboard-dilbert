<?php
/*
Plugin Name: Dashboard Dilbert
Description: This plugin adds a dashboard widget with the most recent Dilbert comic strip.
Version: 0.1
Author: Mike Hansen
Author URI: http://mikehansen.me?utm_campaign=plugin&utm_source=dashboard_dilbert&utm_medium=plugin_author
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

function dd_add_widget() {
	wp_add_dashboard_widget(
		'dashboard-dilbert',
		'Dashboard Dilbert',
		'dd_display_strip'
	);
}
add_action( 'wp_dashboard_setup', 'dd_add_widget' );

function dd_display_strip() {
	$rss = fetch_feed( 'http://www.comicsyndicate.org/Feed/Dilbert' );
	if ( ! is_wp_error( $rss ) ) {
		$maxitems = $rss->get_item_quantity( 1 );
		$strips = $rss->get_items( 0, $maxitems );
		$allowed_html = array(
			'a' => array(
				'href' => array(),
				'title' => array(),
				'style' => array()
			),
			'img' => array(
				'src' => array()
			),
			'div' => array(
				'style' => array()
			),
			'br' => array()
		);
		echo wp_kses( $strips[0]->get_content(), $allowed_html );
	}
}

function dd_style() {
	?>
<style type='text/css'>#dashboard-dilbert img{ max-width: 100%;}</style>
	<?php
}
add_action( 'admin_head-index.php', 'dd_style' );
