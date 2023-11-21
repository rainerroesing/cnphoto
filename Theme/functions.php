<?php
if ( ! defined( 'ABSPATH' ) ) {
	die;
}
include 'lib/ctwp/preload.php';

//-----------------------------------------------------------------------------
// additional theme specific classes

require_once( 'class/CNP/Theme/Top_Menu_Walker.php' );
require_once( 'class/CNP/Theme/GalleryImage_Menu_Walker.php' );
require_once( 'class/CNP/Theme/GalleryVideo_Menu_Walker.php' );
require_once( 'class/CNP/Theme/Footer_Menu_Walker.php' );
require_once( 'class/CNP/Theme/CPT_Item.php' );
require_once( 'class/CNP/Theme/CPT_Album.php' );

// instantiate theme specific classes
$cnp_cpt_item  = new \CNP\Theme\CPT_Item();
$cnp_cpt_album = new \CNP\Theme\CPT_Album();

//-----------------------------------------------------------------------------

//region Theme Settings

define( 'CTWP_CF_Theme_TextDomain', 'cnptheme' );
define( 'CTWP_CF_Theme_Feature_TitleTag', true );
define( 'CTWP_CF_Theme_Feature_Html5', true );
define( 'CTWP_CF_X_Feature_ShowOptions', true );
define( 'CTWP_CF_X_Feature_ShowAcfAdmin', false );

//-----------------------------------------------------------------------------
// Custom Functions


include( '_gallery-functions.php' );

//-----------------------------------------------------------------------------

function CTWP_TF_on_theme_init() {


}

function CTWP_TF_after_setup_theme() {
	register_nav_menus( array(
		'primary' => __( 'Hauptnavigation', defined( 'CTWP_CF_Theme_TextDomain' ) ),
		'footer'  => __( 'Footer', defined( 'CTWP_CF_Theme_TextDomain' ) ),
		'galleryphoto' => __('Galerie / Photo Menü', defined( 'CTWP_CF_Theme_TextDomain' ) ),
		'galleryvideo' => __('Galerie / Video Menü', defined( 'CTWP_CF_Theme_TextDomain' ) ),
	) );
}

function CTWP_TF_include_style_and_scripts() {
	wp_deregister_script( 'jquery' );

	// Add wp_enqueue_style and wp_enqueue_script here...
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.css', array(), "1" );
	wp_enqueue_style( 'fontawesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css', array(), "1" );
	wp_enqueue_style( 'gfonts', 'https://fonts.googleapis.com/css?family=Open+Sans', array(), "1" );
	wp_enqueue_style( 'custom', get_template_directory_uri() . '/css/custom.css', array( "fancybox" ), "1" );
	wp_enqueue_style( 'animate', get_template_directory_uri() . '/css/animate.css', array( "custom" ), "1" );
	wp_enqueue_style( 'fancybox', get_template_directory_uri() . '/css/jquery.fancybox.css', array( "bootstrap" ), "1" );
	wp_enqueue_style( 'fancyboxthumbs', get_template_directory_uri() . '/css/jquery.fancybox-thumbs.css', array( "custom" ), "1" );

	wp_enqueue_script( 'jquery', get_template_directory_uri() . '/components/jquery/dist/jquery.min.js', array(), '1', false );
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array( 'jquery' ), '1', false );
	wp_enqueue_script( 'custom', get_template_directory_uri() . '/js/custom.js', array( 'jquery', 'bootstrap' ), false );
	wp_enqueue_script( 'wow', get_template_directory_uri() . '/js/wow.min.js', array( 'custom' ), false );
	//wp_enqueue_script( 'isotope', get_template_directory_uri() . '/js/isotope.pkgd.min.js', array( 'custom' ), false );
	//wp_enqueue_script( 'imagesloaded', get_template_directory_uri() . '/js/imagesloaded.pkgd.min.js', array( 'custom' ), false );
	wp_enqueue_script( 'fancybox', get_template_directory_uri() . '/js/jquery.fancybox.js', array( 'custom' ), false );
	wp_enqueue_script( 'fancyboxthumbs', get_template_directory_uri() . '/js/jquery.fancybox-thumbs.js', array( 'fancybox' ), false );
	wp_enqueue_script( 'fancyboxmedia', get_template_directory_uri() . '/js/jquery.fancybox-media.js', array( 'fancybox' ), false );
	wp_enqueue_script( 'jquerytouchswipe', get_template_directory_uri() . '/js/jquery.touchSwipe.min.js', array( 'jquery' ), false );

}

// Content Elements Template Definition

define( 'CTWP_CF_TemplatePath', get_template_directory() . "/cetemplates/" );

\CTWP\Theme\TemplateManager::RegisterTemplate( 'clientList', 'clientList.php' );
\CTWP\Theme\TemplateManager::RegisterTemplate( 'headline', 'headline.php' );
\CTWP\Theme\TemplateManager::RegisterTemplate( 'twoColImgText', 'twoColImgText.php' );
//endregion


//-----------------------------------------------------------------------------

include 'lib/ctwp/bootstrap.php';

//-----------------------------------------------------------------------------

include 'fields.php';
