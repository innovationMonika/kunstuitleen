<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://sohamsolution.com/
 * @since      1.0.0
 *
 * @package    Kunstuitleen_Crm
 * @subpackage Kunstuitleen_Crm/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Kunstuitleen_Crm
 * @subpackage Kunstuitleen_Crm/admin
 * @author     Ravi Yadav <ravisws123@gmail.com>
 */
class Kunstuitleen_Crm_Admin {

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
		 add_action( 'restrict_manage_users',  array($this, 'kucrm_restrict_manage_users' ));

	  // ajax call for update user status
	  add_action( 'wp_ajax_kucrm_user_status_update_ajax',  array($this, 'kucrm_user_status_update_ajax' ));
      add_action( 'wp_ajax_nopriv_kucrm_user_status_update_ajax',  array($this, 'kucrm_user_status_update_ajax' ));
       // filter user table status
      add_filter( 'user_contactmethods', array( $this,'crm_user_status_methods'), 10, 1 );
	  add_filter( 'manage_users_columns', array( $this,'kucrm_new_modify_user_table' ));
      add_filter( 'manage_users_custom_column', array( $this,'kucrm_new_modify_user_table_row'), 10, 3 );

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
		 * defined in Kunstuitleen_Crm_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Kunstuitleen_Crm_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/kunstuitleen-crm-admin.css', array(), $this->version, 'all' );

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
		 * defined in Kunstuitleen_Crm_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Kunstuitleen_Crm_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/kunstuitleen-crm-admin.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->plugin_name, 'kucrm_ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );

	}

 // function user table status

     function crm_user_status_methods( $contactmethods ) {
        $contactmethods['crm_user_status'] = 'Status';
        return $contactmethods;
    }

    function kucrm_new_modify_user_table( $column ) {
        $column['crm_user_status'] = 'Status';
        return $column;
    }

    function kucrm_new_modify_user_table_row( $val, $column_name, $user_id ) {
        switch ($column_name) {
            case 'crm_user_status' :
                $user_status = get_user_meta(  $user_id, 'crm_user_status', true );
                if($user_status == 0 && $user_status != ''){
                   return 'Pending';
                }elseif($user_status == 1 && $user_status != ''){
                	return 'Approved';
                }
                //return get_the_author_meta( 'crm_user_status', $user_id );
            default:
        }
        return $val;
    }

    public function kucrm_restrict_manage_users()
    {
        global $wp_roles;
        $which = '';
        $id = 'bottom' === $which ? 'new_role2' : 'new_role';
        $button_id = 'bottom' === $which ? 'changeit2' : 'changeit';
?>
                <label class="screen-reader-text" for="<?php echo $id; ?>"><?php _e('Change role to&hellip;'); ?></label><span class="user_export_diff">|</span>
                <select id="crm_user_status" style="float: none;" name="user_roles[]" class="wc-enhanced-select">
                	<option value=""><?php echo esc_html__('Select'); ?></option>
                    <option value="0"><?php echo esc_html__('Pending'); ?></option>
                    <option value="1"><?php echo esc_html__('Approved'); ?></option>
                  
                </select>
                <a href="javascript:void(0)"  class="button" id="btnQueryString"> <?php echo esc_html__('Change Status', 'sws-user-list') ?> </a>
                <span class="user_export_diff">|</span>
      
         <?php
    }
    
    // function for user status update
    public function kucrm_user_status_update_ajax(){
         if($_POST) {
               $ids_array = $_POST['ids_arr'];
               $crm_user_status = $_POST['crm_user_status'];

               foreach ($ids_array as $key => $user_id) {
               update_user_meta( $user_id, 'crm_user_status',  $crm_user_status);
               }
                echo json_encode(array('status'=>true, 'message'=>__('Change Status')));

            }
    wp_die();
    }

}
