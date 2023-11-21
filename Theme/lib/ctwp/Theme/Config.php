<?php


namespace CTWP\Theme;


use CTWP\Framework\Exceptions\ConfigValueNotFoundException;

final class Config {

	//-----------------------------------------------------------------------------
	// Default Configuration
	//-----------------------------------------------------------------------------

	private static $defaultConfig = array(
		'Theme_Feature_Html5'    => true,
		'Theme_Feature_TitleTag' => true,
		'X_Feature_ShowAcfAdmin' => false,
		'X_Feature_ShowOptions'  => false,
	);

	//-----------------------------------------------------------------------------

	/**
	 * @param $name
	 *
	 * @return bool|string|integer|object|array
	 * @throws ConfigValueNotFoundException
	 */
	public static function getValue( $name ) {

		if ( defined( "CTWP_CF_" . $name ) ) {
			return constant( "CTWP_CF_" . $name );
		}

		if ( in_array( $name, self::$defaultConfig ) ) {
			return self::$defaultConfig[ $name ];
		} else {
			throw new ConfigValueNotFoundException( "Config value $name not found." );
		}

	}

}