<?php


namespace CTWP\Theme;


class CustomizeAdmin {

	public function __construct() {

		add_action( 'admin_bar_menu', array( $this, 'remove_adminbar_items' ), 999 );
		add_action( 'admin_head', array( $this, 'remove_admin_logo' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'custom_admin_theme' ) );
		add_action( 'admin_menu', array( $this, 'remove_menu_items' ) );

		add_filter( 'http_request_args', array( $this, 'prefix_disable_wporg_request' ), 5, 2 );
		add_filter( 'admin_footer_text', array( $this, 'change_dashboard_footer' ) );

		if ( Config::getValue( 'X_Feature_ShowOptions' ) ) {
			// add website options page
			if ( function_exists( 'acf_add_options_page' ) ) {
				acf_add_options_page( array(
					'page_title' => 'Website Optionen',
					'menu_title' => 'Optionen',
					'menu_slug'  => 'ctwp-web-settings',
					'capability' => 'edit_posts',
					'redirect'   => false,
				) );
			}
		}
	}

	/**
	 * Action for admin_bar_menu
	 * removes some items from admin bar
	 *
	 * @param $wp_admin_bar
	 */
	public function remove_adminbar_items( $wp_admin_bar ) {
		$wp_admin_bar->remove_node( 'wp-logo' );
		$wp_admin_bar->remove_node( 'comments' );
		$wp_admin_bar->remove_node( 'new-content' );
	}

	/**
	 * Action for admin_head
	 * removes the admin logo
	 */
	public function remove_admin_logo() {
		echo '
				<style type="text/css">
				#wpadminbar #wp-admin-bar-wp-logo > a {
					display:none;
				}
				</style>
			';
	}

	/**
	 * Action for admin_enqueue_scripts
	 * adds a custom stylesheet for the admin area
	 */
	public function custom_admin_theme() {
		if ( get_field( 'option_admin_useCustomColors', 'options' ) ) {
			wp_enqueue_style( 'ctwp-admin-theme', get_stylesheet_directory_uri() . '/admin/css/admin-color-scheme.css' );
		}
	}


	/**
	 * Filter for http_request_args
	 * disables WP update check for this theme
	 *
	 * @param $r
	 * @param $url
	 *
	 * @return mixed
	 */
	public function prefix_disable_wporg_request( $r, $url ) {

		// If it's not a theme update request, bail.
		if ( 0 !== strpos( $url, 'https://api.wordpress.org/themes/update-check/1.1/' ) ) {
			return $r;
		}

		// Decode the JSON response
		$themes = json_decode( $r['body']['themes'] );

		// Remove the active parent and child themes from the check
		$parent = get_option( 'template' );
		$child  = get_option( 'stylesheet' );
		unset( $themes->themes->$parent );
		unset( $themes->themes->$child );

		// Encode the updated JSON response
		$r['body']['themes'] = json_encode( $themes );

		return $r;
	}


	/**
	 * Filter for admin_footer_text
	 * Changes the footer in the admin backend
	 */
	public function change_dashboard_footer() {
		echo 'Realisiert von <a href="http://www.creova-studios.de" target="_blank">Creova Studios</a> | powered by <a href="http://www.wordpress.org" target="_blank">WordPress</a>';
	}


	/**
	 * Action for admin_menu
	 * removes some menu items
	 */
	public function remove_menu_items() {
		//remove_menu_page( 'edit.php' );
		remove_menu_page( 'edit-comments.php' );
		//remove_menu_page( 'tools.php' );
	}
}