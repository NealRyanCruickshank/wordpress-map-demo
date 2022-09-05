<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       codeinfinity.co.za
 * @since      1.0.0
 *
 * @package    Ci_Osm_Location
 * @subpackage Ci_Osm_Location/admin/partials
 */

?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">
    <h1>CI-OSM Locations</h1>
    <?php
    // Let see if we have a caching notice to show
    $admin_notice = get_option('ci_osm_locator_admin_notice');
    if($admin_notice) {
        // We have the notice from the DB, let's remove it.
        delete_option( 'ci-osm-locator-options' );
        // Call the notice message
        $this->admin_notice($admin_notice);
    }
    if ( isset( $_GET['settings-updated'] ) && $_GET['settings-updated'] ){
        $this->admin_notice("Your settings have been updated!");
    }
    ?>
    <form method="POST" action="options.php">

        <?php
        settings_fields('ci-osm-locator-options');
        do_settings_sections('ci-osm-locator-options');
        submit_button();
        ?>
    </form>
</div>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
