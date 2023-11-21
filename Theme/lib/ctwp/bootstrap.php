<?php
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

require_once( 'Theme/Config.php' );
require_once( 'Theme/ThemeMain.php' );
require_once( 'Theme/CustomizeAdmin.php' );

$thememain = new CTWP\Theme\ThemeMain();

require_once( get_stylesheet_directory() . '/lib/acfpro/acf.php' );

$customadmin = new CTWP\Theme\CustomizeAdmin();