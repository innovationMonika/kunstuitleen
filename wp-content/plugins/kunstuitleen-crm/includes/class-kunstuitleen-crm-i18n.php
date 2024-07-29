<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://sohamsolution.com/
 * @since      1.0.0
 *
 * @package    Kunstuitleen_Crm
 * @subpackage Kunstuitleen_Crm/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Kunstuitleen_Crm
 * @subpackage Kunstuitleen_Crm/includes
 * @author     Ravi Yadav <ravisws123@gmail.com>
 */
class Kunstuitleen_Crm_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'kunstuitleen-crm',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
