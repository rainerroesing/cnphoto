<?php


namespace CTWP\Theme;
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

class TemplateManager {

	private static $registered_templates = array();

	public static function RegisterTemplate( $name, $filename ) {
		self::$registered_templates[ $name ] = $filename;
	}

	public static function IncludeTemplate( $name ) {
		if ( ! defined( 'CTWP_CF_TemplatePath' ) ) {
			throw new \Exception( 'Template path is not defined' );
		}

		if ( self::$registered_templates[ $name ] ) {
			include constant( 'CTWP_CF_TemplatePath' ) . self::$registered_templates[ $name ];
		}
	}
}