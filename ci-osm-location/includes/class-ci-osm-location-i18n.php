<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       codeinfinity.co.za
 * @since      1.0.0
 *
 * @package    Ci_Osm_Location
 * @subpackage Ci_Osm_Location/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Ci_Osm_Location
 * @subpackage Ci_Osm_Location/includes
 * @author     Neal Ryan Cruickshank <neal@codeinfinity.co.za>
 */
class Ci_Osm_Location_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'ci-osm-location',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
