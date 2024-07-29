<?php

/**
 * Fired during plugin activation
 *
 * @link       https://sohamsolution.com/
 * @since      1.0.0
 *
 * @package    Kunstuitleen_Company_Crm
 * @subpackage Kunstuitleen_Company_Crm/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Kunstuitleen_Company_Crm
 * @subpackage Kunstuitleen_Company_Crm/includes
 * @author     Ravi Yadav <ravisws123@gmail.com>
 */
class Kunstuitleen_Company_Crm_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
        flush_rewrite_rules();
        //flush_rewrite_rules(true);
	}
    /**
     * Kunstuitleen company details table
     */
    public function kunstuitleen_company_details_table(){
        global $wpdb;
        $company_details_info = '';
        $charset_collate = $wpdb->get_charset_collate();
        $company_details_info = $wpdb->prefix . 'company_details';
        /*$edcalculator_info_sql .= "CREATE TABLE IF NOT EXISTS $company_details_info (
                            `id` int(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,                            
                            `company_name` text NOT NULL,
                            `postal_code` text NOT NULL,
                            `house_number` text NOT NULL,
                            `addition` text NOT NULL,
                            `mailing_address` text NOT NULL,
                            `phone_number` int(10) NOT NULL,
                            `parent_company` text NOT NULL,
                            `invoice_email` text NOT NULL,
                            `status` int(10) NOT NULL,
                            `company_owner_name` text NOT NULL,
                            `company_owner_id` int(10) NOT NULL,                            
                            `registration_date` date NOT NULL
                          ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";*/
        $company_details_info_sql .= "CREATE TABLE IF NOT EXISTS $company_details_info (
                                        `id` int(10) UNSIGNED NOT NULL,
                                        `company_name` text NOT NULL,
                                        `postal_code` text NOT NULL,
                                        `house_number` text NOT NULL,
                                        `addition` text NOT NULL,
                                        `mailing_address` text NOT NULL,
                                        `phone_number` int(10) NOT NULL,
                                        `parent_company` text NOT NULL,
                                        `invoice_email` text NOT NULL,
                                        `status` int(10) NOT NULL,
                                        `company_owner_name` text NOT NULL,
                                        `company_owner_id` int(10) NOT NULL,
                                        `registration_date` datetime NOT NULL
                                      ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $company_details_info_sql );
    }

}
