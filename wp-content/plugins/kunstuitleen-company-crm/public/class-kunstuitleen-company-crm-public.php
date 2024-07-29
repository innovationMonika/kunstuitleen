<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://sohamsolution.com/
 * @since      1.0.0
 *
 * @package    Kunstuitleen_Company_Crm
 * @subpackage Kunstuitleen_Company_Crm/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Kunstuitleen_Company_Crm
 * @subpackage Kunstuitleen_Company_Crm/public
 * @author     Ravi Yadav <ravisws123@gmail.com>
 */
class Kunstuitleen_Company_Crm_Public {

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
		 * defined in Kunstuitleen_Company_Crm_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Kunstuitleen_Company_Crm_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		$Kunstuitleen_My_Account = $kunstuitleen_get_query_vars = '';
        $Kunstuitleen_My_Account = new Kunstuitleen_My_Account; 
        $kunstuitleen_get_query_vars = $Kunstuitleen_My_Account->kunstuitleen_get_query_vars();
        wp_enqueue_style( 'kunstuitleen-company-crm-select-min', plugin_dir_url( __FILE__ ) . 'css/kunstuitleen-company-crm-select.min.css', array(), $this->version, 'all' );
        wp_enqueue_style( 'kunstuitleen-company-crm-public', plugin_dir_url( __FILE__ ) . 'css/kunstuitleen-company-crm-public.css', array(), $this->version, 'all' );
        wp_enqueue_style( 'kunstuitleen-my-account-common', plugin_dir_url( __FILE__ ) . 'css/kunstuitleen-my-account-common.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'kunstuitleen-my-account-account-overview', plugin_dir_url( __FILE__ ) . 'css/kunstuitleen-my-account-account-overview.css', array(), $this->version, 'all' );
        switch( $kunstuitleen_get_query_vars ) :
        	case 'account-overview':
                wp_enqueue_style( 'kunstuitleen-my-account-account-overview', plugin_dir_url( __FILE__ ) . 'css/kunstuitleen-my-account-account-overview.css', array(), $this->version, 'all' );
            break;
            case 'my-artworks':
                wp_enqueue_style( 'kunstuitleen-my-account-my-artworks', plugin_dir_url( __FILE__ ) . 'css/kunstuitleen-my-account-my-artworks.css', array(), $this->version, 'all' );
            break;
            case 'my-credits':
                wp_enqueue_style( 'kunstuitleen-my-account-my-credits', plugin_dir_url( __FILE__ ) . 'css/kunstuitleen-my-account-my-credits.css', array(), $this->version, 'all' );
            break;
            case 'my-purchase-invoicecs':                
                wp_enqueue_style( 'kunstuitleen-my-account-my-purchase-invoices', plugin_dir_url( __FILE__ ) . 'css/kunstuitleen-my-account-my-purchase-invoices.css', array(), $this->version, 'all' );
            break;
            case 'my-rental-invoices':
                wp_enqueue_style( 'kunstuitleen-my-account-my-rental-invoices', plugin_dir_url( __FILE__ ) . 'css/kunstuitleen-my-account-my-rental-invoices.css', array(), $this->version, 'all' );
            break;
            case 'my-details':
                wp_enqueue_style( 'kunstuitleen-my-account-company-details', plugin_dir_url( __FILE__ ) . 'css/kunstuitleen-my-account-company-details.css', array(), $this->version, 'all' );		
		
				wp_enqueue_style( 'kunstuitleen-my-account-payment-details', plugin_dir_url( __FILE__ ) . 'css/kunstuitleen-my-account-payment-details.css', array(), $this->version, 'all' );
				wp_enqueue_style( 'kunstuitleen-my-account-edit-account', plugin_dir_url( __FILE__ ) . 'css/kunstuitleen-my-account-edit-account.css', array(), $this->version, 'all' );
            break;                
        endswitch;		
		//wp_enqueue_style( 'kunstuitleen-my-account-account-management', plugin_dir_url( __FILE__ ) . 'css/kunstuitleen-my-account-account-management.css', array(), $this->version, 'all' );
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
		 * defined in Kunstuitleen_Company_Crm_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Kunstuitleen_Company_Crm_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( 'kunstuitleen-company-crm-select', plugin_dir_url( __FILE__ ) . 'js/kunstuitleen-company-crm-select.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/kunstuitleen-company-crm-public.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->plugin_name, 'kunstuitleen_company_crm_public_ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );

	}

}
