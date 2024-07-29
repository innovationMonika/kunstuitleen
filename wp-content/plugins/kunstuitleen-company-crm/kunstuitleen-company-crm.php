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
 * @package           Kunstuitleen_Company_Crm
 *
 * @wordpress-plugin
 * Plugin Name:       Kunstuitleen Company Crm
 * Plugin URI:        https://sohamsolution.com/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Ravi Yadav
 * Author URI:        https://sohamsolution.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       kunstuitleen-company-crm
 * Domain Path:       /languages
 */
define('KUCRM_COMPANY_URL', plugin_dir_url(__FILE__));

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'KUNSTUITLEEN_COMPANY_CRM_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-kunstuitleen-company-crm-activator.php
 */
function activate_kunstuitleen_company_crm() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-kunstuitleen-company-crm-activator.php';
	Kunstuitleen_Company_Crm_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-kunstuitleen-company-crm-deactivator.php
 */
function deactivate_kunstuitleen_company_crm() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-kunstuitleen-company-crm-deactivator.php';
	Kunstuitleen_Company_Crm_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_kunstuitleen_company_crm' );
register_deactivation_hook( __FILE__, 'deactivate_kunstuitleen_company_crm' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-kunstuitleen-company-crm.php';
require plugin_dir_path( __FILE__ ) . 'includes/class-kunstuitleen-myaccount.php';
$obj = new Kunstuitleen_My_Account;
require plugin_dir_path( __FILE__ ) . 'includes/class-kunstuitleen-database.php';
$obj = new Kunstuitleen_Database;

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_kunstuitleen_company_crm() {

	$plugin = new Kunstuitleen_Company_Crm();
	$plugin->run();

}

/* include shordtcode file for register form */

require plugin_dir_path( __FILE__ ) . 'includes/class-kunstuitleen-company-crm-shortcode-public.php';
$obj = new kucrm_company_Shortcode('Kunstuitleen Company Crm', '1.0.0');


run_kunstuitleen_company_crm();
