<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://sohamsolution.com/
 * @since      1.0.0
 *
 * @package    Kunstuitleen_Company_Crm
 * @subpackage Kunstuitleen_Company_Crm/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Kunstuitleen_Company_Crm
 * @subpackage Kunstuitleen_Company_Crm/includes
 * @author     Ravi Yadav <ravisws123@gmail.com>
 */
class Kunstuitleen_Company_Crm_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
        flush_rewrite_rules();
        //flush_rewrite_rules(true);
	}

}
