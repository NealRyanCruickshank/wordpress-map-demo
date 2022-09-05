<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              codeinfinity.co.za
 * @since             1.0.0
 * @package           Ci_Osm_Location
 *
 * @wordpress-plugin
 * Plugin Name:       Code Infinity OSM Location selector
 * Plugin URI:        codeinfinity.co.za
 * Description:       Allows location management and view display
 * Version:           1.0.0
 * Author:            Neal Ryan Cruickshank
 * Author URI:        codeinfinity.co.za
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ci-osm-location
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'CI_OSM_LOCATION_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-ci-osm-location-activator.php
 */
function activate_ci_osm_location() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ci-osm-location-activator.php';
	Ci_Osm_Location_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-ci-osm-location-deactivator.php
 */
function deactivate_ci_osm_location() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ci-osm-location-deactivator.php';
	Ci_Osm_Location_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_ci_osm_location' );
register_deactivation_hook( __FILE__, 'deactivate_ci_osm_location' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-ci-osm-location.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_ci_osm_location() {

	$plugin = new Ci_Osm_Location();
	$plugin->run();

}
run_ci_osm_location();
