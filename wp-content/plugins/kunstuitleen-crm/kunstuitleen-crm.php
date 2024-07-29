<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://sohamsolution.com/
 * @since             1.0.0
 * @package           Kunstuitleen_Crm
 *
 * @wordpress-plugin
 * Plugin Name:       Kunstuitleen Crm
 * Plugin URI:        https://sohamsolution.com/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Ravi Yadav
 * Author URI:        https://sohamsolution.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       kunstuitleen-crm
 * Domain Path:       /languages
 */

define('KUCRM_URL', plugin_dir_url(__FILE__));

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'KUNSTUITLEEN_CRM_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-kunstuitleen-crm-activator.php
 */
function activate_kunstuitleen_crm() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-kunstuitleen-crm-activator.php';
	Kunstuitleen_Crm_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-kunstuitleen-crm-deactivator.php
 */
function deactivate_kunstuitleen_crm() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-kunstuitleen-crm-deactivator.php';
	Kunstuitleen_Crm_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_kunstuitleen_crm' );
register_deactivation_hook( __FILE__, 'deactivate_kunstuitleen_crm' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-kunstuitleen-crm.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_kunstuitleen_crm() {

	$plugin = new Kunstuitleen_Crm();
	$plugin->run();

}

/* include shordtcode file for register form */

require plugin_dir_path( __FILE__ ) . 'includes/class-kucrm-shortcode-public.php';
$obj = new kucrm_Shortcode('Kunstuitleen Crm', '1.0.0');

require plugin_dir_path( __FILE__ ) . 'includes/class-kucrm-api.php';
$obj_api = new kucrm_api('Kunstuitleen Crm', '1.0.0');

run_kunstuitleen_crm();
