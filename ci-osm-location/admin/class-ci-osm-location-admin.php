<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       codeinfinity.co.za
 * @since      1.0.0
 *
 * @package    Ci_Osm_Location
 * @subpackage Ci_Osm_Location/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Ci_Osm_Location
 * @subpackage Ci_Osm_Location/admin
 * @author     Neal Ryan Cruickshank <neal@codeinfinity.co.za>
 */
class Ci_Osm_Location_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

        // Let's add an action to setup the admin menu in the left nav
        add_action( 'admin_menu', array($this, 'add_admin_menu') );

        add_action('admin_init', array($this, 'setup_sections'));
        add_action('admin_init', array($this, 'setup_fields'));
	}

	/**
	 * Register the stylesheets for the admin area.
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

        wp_enqueue_style( $this->plugin_name.'-bootstrap', plugin_dir_url( __FILE__ ) . 'css/bootstrap.min.css', array(), $this->version, 'all' );
        wp_enqueue_style( $this->plugin_name.'-leaflet', "https://unpkg.com/leaflet@1.4.0/dist/leaflet.css", array(), $this->version, 'all' );
        wp_enqueue_style( $this->plugin_name.'-geosearch', "https://unpkg.com/leaflet-geosearch@3.0.0/dist/geosearch.css", array(), $this->version, 'all' );
        wp_enqueue_style( $this->plugin_name.'-font-awesome', "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css", array(), $this->version, 'all' );

        wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ci-osm-location-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

        wp_enqueue_script( $this->plugin_name.'-poppover', "https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js");
        wp_enqueue_script( $this->plugin_name.'-bootstrap', "https://cdn.jsdelivr.net/npm/bootstrap@4.4.0/dist/js/bootstrap.min.js");
        wp_enqueue_script( $this->plugin_name.'-bootstrap-bundle', "https://cdn.jsdelivr.net/npm/bootstrap@4.4.0/dist/js/bootstrap.bundle.min.js");
        wp_enqueue_script( $this->plugin_name.'-bootbox', "https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.3/bootbox.min.js");
        wp_enqueue_script( $this->plugin_name.'-marker-fallback', plugin_dir_url( __FILE__ ) . 'js/marker-fallback.js');
        wp_enqueue_script($this->plugin_name.'-leaflet', plugin_dir_url( __FILE__ ) . 'js/leaflet.js', []);
        wp_enqueue_script($this->plugin_name.'-geosearch', plugin_dir_url( __FILE__ ) . 'js/geosearch.js', array('jquery'), '3', true);
        wp_enqueue_script( $this->plugin_name.'-map', plugin_dir_url( __FILE__ ) . 'js/ci-osm-location-map.js', array('jquery'), $this->version, true );
        wp_enqueue_script( $this->plugin_name.'-admin', plugin_dir_url( __FILE__ ) . 'js/ci-osm-location-admin.js', array('jquery'), $this->version, true );

    }

    public function add_admin_menu() {
        // Main Menu Item
        add_menu_page(
            'OSM Locations',
            'OSM Locations',
            'manage_options',
            'ci-osm-location',
            array($this, 'display_ci_osm_location_plugin_admin_page_two'),
            'dashicons-admin-site-alt2',
            1);

        // Sub Menu Item One
        add_submenu_page(
            'ci-osm-location',
            'Settings',
            'Settings',
            'manage_options',
            'settings/ci-osm-settings',
            array($this, 'display_ci_osm_location_plugin_admin_page')
        );

        // Sub Menu Item Two
        /*
        add_submenu_page(
            'ci-osm-location',
            'Secondary Page',
            'Secondary Page',
            'manage_options',
            'custom-plugin/settings-page-two',
            array($this, 'display_custom_plugin_admin_page_two')
        );
    */

    }

    public function setup_fields() {
        $fields = array(
            array(
                'uid' => 'ci_osm_locator_plugin_locations_api',
                'label' => 'Locations API',
                'section' => 'section_one',
                'type' => 'text',
                'placeholder'=>'',
                'helper' => 'URL',
                'supplemental' => 'The API URL for location data to display on map',
                'default' => 'https://yourapi.endpoint.co.za',
            ),
            array(
                'uid' => 'ci_osm_locator_plugin_locations_api_user',
                'label' => 'API User',
                'section' => 'section_one',
                'type' => 'text',
                'placeholder'=>'',
                'helper' => 'URL',
                'supplemental' => 'Username to access Locations API',
                'default' => 'ci-osm-loc',
            ),
            array(
                'uid' => 'ci_osm_locator_plugin_locations_api_pass',
                'label' => 'API Password',
                'section' => 'section_one',
                'type' => 'password',
                'placeholder'=>'',
                'helper' => 'URL',
                'supplemental' => 'Password to access Locations API',
                'default' => '********',
            ),
            array(
                'uid' => 'ci_osm_locator_plugin_locations_api_key',
                'label' => 'API Key',
                'section' => 'section_one',
                'type' => 'text',
                'placeholder'=>'',
                'helper' => 'URL',
                'supplemental' => 'Location API Key',
                'default' => 'A1CG5G346B55WDC',
            ),
            /*
            array(
                'uid' => 'custom_plugin_radio_example',
                'label' => 'Sample Radio Buttons',
                'placeholder'=>'',
                'section' => 'section_two',
                'type' => 'radio',
                'options' => array(
                    'option1' => 'Option 1',
                    'option2' => 'Option 2',
                    'option3' => 'Option 3',
                    'option4' => 'Option 4',
                    'option5' => 'Option 5',
                ),
                'default' => array()
            ),
            */
        );
        // Lets go through each field in the array and set it up
        foreach( $fields as $field ){
            add_settings_field( $field['uid'], $field['label'], array($this, 'field_callback'), 'ci-osm-locator-options', $field['section'], $field );
            register_setting( 'ci-osm-locator-options', $field['uid'] );
        }
    }

    /**
     * This handles all types of fields for the settings
     *
     * @since    1.0.0
     */
    public function field_callback($arguments) {
        // Set our $value to that of whats in the DB
        $value = get_option( $arguments['uid'] );
        // Only set it to default if we get no value from the DB and a default for the field has been set
        if(!$value) {
            $value = $arguments['default'];
        }
        // Lets do some setup based ont he type of element we are trying to display.
        switch( $arguments['type'] ){
            case 'text':
            case 'password':
            case 'number':
                printf( '<input name="%1$s" id="%1$s" type="%2$s" placeholder="%3$s" value="%4$s" />', $arguments['uid'], $arguments['type'], $arguments['placeholder'], $value );
                break;
            case 'textarea':
                printf( '<textarea name="%1$s" id="%1$s" placeholder="%2$s" rows="5" cols="50">%3$s</textarea>', $arguments['uid'], $arguments['placeholder'], $value );
                break;
            case 'select':
            case 'multiselect':
                if( ! empty ( $arguments['options'] ) && is_array( $arguments['options'] ) ){
                    $attributes = '';
                    $options_markup = '';
                    foreach( $arguments['options'] as $key => $label ){
                        $options_markup .= sprintf( '<option value="%s" %s>%s</option>', $key, selected( $value[ array_search( $key, $value, true ) ], $key, false ), $label );
                    }
                    if( $arguments['type'] === 'multiselect' ){
                        $attributes = ' multiple="multiple" ';
                    }
                    printf( '<select name="%1$s[]" id="%1$s" %2$s>%3$s</select>', $arguments['uid'], $attributes, $options_markup );
                }
                break;
            case 'radio':
            case 'checkbox':
                if( ! empty ( $arguments['options'] ) && is_array( $arguments['options'] ) ){
                    $options_markup = '';
                    $iterator = 0;
                    foreach( $arguments['options'] as $key => $label ){
                        $iterator++;
                        $is_checked = '';
                        // This case handles if there is only one checkbox and we don't have anything saved yet.
                        if(isset($value[ array_search( $key, $value, true ) ])) {
                            $is_checked = checked( $value[ array_search( $key, $value, true ) ], $key, false );
                        } else {
                            $is_checked = "";
                        }
                        // Lets build out the checkbox
                        $options_markup .= sprintf( '<label for="%1$s_%6$s"><input id="%1$s_%6$s" name="%1$s[]" type="%2$s" value="%3$s" %4$s /> %5$s</label><br/>', $arguments['uid'], $arguments['type'], $key, $is_checked, $label, $iterator );
                    }
                    printf( '<fieldset>%s</fieldset>', $options_markup );
                }
                break;
            case 'image':
                // Some code borrowed from: https://mycyberuniverse.com/integration-wordpress-media-uploader-plugin-options-page.html
                $options_markup = '';
                $image = [];
                $image['id'] = '';
                $image['src'] = '';

                // Setting the width and height of the header iamge here
                $width = '1800';
                $height = '1068';

                // Lets get the image src
                $image_attributes = wp_get_attachment_image_src( $value, array( $width, $height ) );
                // Lets check if we have a valid image
                if ( !empty( $image_attributes ) ) {
                    // We have a valid option saved
                    $image['id'] = $value;
                    $image['src'] = $image_attributes[0];
                } else {
                    // Default
                    $image['id'] = '';
                    $image['src'] = $value;
                }

                // Lets build our html for the image upload option
                $options_markup .= '
				<img data-src="' . $image['src'] . '" src="' . $image['src'] . '" width="180px" height="107px" />
				<div>
					<input type="hidden" name="' . $arguments['uid'] . '" id="' . $arguments['uid'] . '" value="' . $image['id'] . '" />
					<button type="submit" class="upload_image_button button">Upload</button>
					<button type="submit" class="remove_image_button button">&times; Delete</button>
				</div>';
                printf('<div class="upload">%s</div>',$options_markup);
                break;
        }
        // If there is helper text, lets show it.
        if( array_key_exists('helper',$arguments) && $helper = $arguments['helper']) {
            printf( '<span class="helper"> %s</span>', $helper );
        }
        // If there is supplemental text lets show it.
        if( array_key_exists('supplemental',$arguments) && $supplemental = $arguments['supplemental'] ){
            printf( '<p class="description">%s</p>', $supplemental );
        }
    }

    /**
     * Setup sections in the settings
     *
     * @since    1.0.0
     */
    public function setup_sections() {
        add_settings_section( 'section_one', 'General Config <hr>', array($this, 'section_callback'), 'ci-osm-locator-options' );
        #add_settings_section( 'section_two', 'Section Two', array($this, 'section_callback'), 'ci-osm-locator-options' );
    }

    /**
     * Callback for each section
     *
     * @since    1.0.0
     */
    public function section_callback( $arguments ) {
        switch( $arguments['id'] ){
            case 'section_one':
                echo '<p>Code infinity OSM Location Selector</p>';
                break;
            case 'section_two':
                echo '<p>Section two! More information on this section can go here.</p>';
                break;
        }
    }

    /**
     * Admin Notice
     *
     * This displays the notice in the admin page for the user
     *
     * @since    1.0.0
     */
    public function admin_notice($message) { ?>
        <div class="notice notice-success is-dismissible">
        <p><?php echo($message); ?></p>
        </div><?php
    }

    /**
     * Menu callbacks
     *
     * Callback events for menu items (Left sidebar navigation)
     *
     * @since    1.0.0
     */
    public function display_ci_osm_location_plugin_admin_page(){
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/ci-osm-location-admin-display.php';
    }

    public function display_ci_osm_location_plugin_admin_page_two(){
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/ci-osm-location-manager-display.php';
    }

}
