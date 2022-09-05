<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       codeinfinity.co.za
 * @since      1.0.0
 *
 * @package    Ci_Osm_Location
 * @subpackage Ci_Osm_Location/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Ci_Osm_Location
 * @subpackage Ci_Osm_Location/public
 * @author     Neal Ryan Cruickshank <neal@codeinfinity.co.za>
 */
class Ci_Osm_Location_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

        //Check if the plugin is enabled
        if(get_option('ci_osm_locator_plugin_status')[0] !=='selected'){
            $this->public_notice("Please enable the CI OSM Location Plugin to use this functionality");
            exit();
        }
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ci_Osm_Location_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ci_Osm_Location_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ci-osm-location-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ci_Osm_Location_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ci_Osm_Location_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ci-osm-location-public.js', array( 'jquery' ), $this->version, false );

	}

    public function public_notice($message) { ?>
        <div class="notice notice-success is-dismissible">
        <p><?php echo($message); ?></p>
        </div><?php
    }


}
