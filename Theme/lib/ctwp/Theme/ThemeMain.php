<?php
namespace CTWP\Theme;

if ( ! defined( 'ABSPATH' ) ) {
	die;
}

class ThemeMain {

	public function __construct() {

		// Actions
		//-----------------------------------------------------------------------------
		add_action( 'after_setup_theme', array( $this, 'after_setup_theme' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'include_styles_and_scripts' ) );

		// Filters
		//-----------------------------------------------------------------------------
		add_filter( 'nav_menu_css_class', array( $this, 'active_nav_class' ), 10, 2 );
		add_filter( 'acf/settings/path', array( $this, 'acf_settings_path' ) );
		add_filter( 'acf/settings/dir', array( $this, 'acf_settings_dir' ) );

		// Common
		//-----------------------------------------------------------------------------
		if ( Config::getValue( 'X_Feature_ShowAcfAdmin' ) == false ) {
			add_filter( 'acf/settings/show_admin', '__return_false' );
		}

		// Remove generator meta from html output
		remove_action( 'wp_head', 'wp_generator' );

		if(function_exists('CTWP_TF_on_theme_init')) {
			call_user_func('CTWP_TF_on_theme_init');
		}
	}


	/**
	 * Action for after_setup_theme
	 * Initialize TextDomain, add theme support, register nav menus...
	 *
	 * @throws \CTWP\Framework\Exceptions\ConfigValueNotFoundException
	 */
	public function after_setup_theme() {
		load_theme_textdomain( Config::getValue( 'Theme_TextDomain' ), get_template_directory() . '/lang' );

		if ( Config::getValue( 'Theme_Feature_TitleTag' ) ) {
			add_theme_support( 'title-tag' );
		}
		if ( Config::getValue( 'Theme_Feature_Html5' ) ) {
			add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
		}

		if ( function_exists( 'CTWP_TF_after_setup_theme' ) ) {
			call_user_func( 'CTWP_TF_after_setup_theme' );
		}
	}


	/**
	 * Action for wp_enqueue_scripts
	 */
	public function include_styles_and_scripts() {
		if ( function_exists( 'CTWP_TF_include_style_and_scripts' ) ) {
			call_user_func( 'CTWP_TF_include_style_and_scripts' );
		}
	}

	/**
	 * Filter for nav_menu_css_class
	 * adding class "active" to active links
	 *
	 * @param $classes
	 * @param $item
	 *
	 * @return array
	 */
	public function active_nav_class( $classes, $item ) {
		if ( in_array( 'current-menu-item', $classes ) ) {
			$classes[] = 'active ';
		}

		return $classes;
	}


	//region ACF Settings

	/**
	 * Filter for acf/settings/path
	 * returns local acf path
	 *
	 * @param $path
	 *
	 * @return string
	 */
	public function acf_settings_path( $path ) {
		$path = get_stylesheet_directory() . '/lib/acfpro/';

		return $path;
	}

	/**
	 * Filter for acf/settings/dir
	 * returns local acf directory
	 *
	 * @param $dir
	 *
	 * @return string
	 */
	public function acf_settings_dir( $dir ) {
		$dir = get_stylesheet_directory_uri() . '/lib/acfpro/';

		return $dir;
	}


	//endregion
}
