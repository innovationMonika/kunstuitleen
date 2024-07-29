<?php
class kucrm_company_Shortcode{

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

      // Create shortcode
      
	  add_shortcode( 'kucrm-company-user-register-form', array( $this, 'kucrm_company_user_register_form' ) );
     
      

      
       // ajax call
      add_action( 'wp_ajax_kucrm_company_ajaxregister',  array($this, 'kucrm_company_ajaxregister' ));
     // add_action( 'wp_ajax_nopriv_kucrm_company_ajaxregister',  array($this, 'kucrm_company_ajaxregister' ));

      // filter for email html support
      add_filter( 'wp_mail_content_type',array( $this,'kucrm_company_email_set_content_type') );
        
	}


    // email html support funcation
    function kucrm_company_email_set_content_type(){
    return "text/html";
    }

  /* register shortcode */
	public function kucrm_company_user_register_form(){
       $edit_user_id = '';
       $edit_user_id = $_GET['id'];
       if ($edit_user_id) {
          $edit_user_data = get_userdata( $edit_user_id );
            if ( $edit_user_data === false ) {
                //user id does not exist
            } else {
               //echo '<pre>'; print_r($edit_user_data);
             $edit_user_email = $edit_user_data->user_login;
             $first_name =  get_user_meta( $edit_user_id,  'first_name', true );
             $last_name =  get_user_meta( $edit_user_id,  'last_name', true );
             $phone = get_user_meta( $edit_user_id,  'phone', true );
             $department = get_user_meta( $edit_user_id,  'department', true );
             $email = get_user_meta( $edit_user_id,  'nickname', true );
             $search_value = get_user_meta( $edit_user_id,  'search_value', true );
            }
       }
            if ($email) {
                $read_only = 'readonly';
                $display_none = 'style=display:none';
            }
             $output .= '<form role="form" class="kucrm_company_register_form">
   <div class="form-group">
       <div class="row">
         <div class="col-md-6">
      <label for="vooornaam" class="h4 mr-jonas"><strong>Vooornaam *</strong></label>
      <input type="text" class="form-control" name="vooornaam" value="'.$first_name.'" required>
   </div>
    <div class="col-md-6">
      <label for="achternaam" class="h4 mr-jonas"><strong>Achternaam *</strong></label>
      <input type="text" class="form-control" name="achternaam" value="'.$last_name.'" required>
   </div>
   </div>
   </div>
    
    <div class="form-group">
       <div class="row">
         <div class="col-md-4">
      <label for="telefoonnummer" class="h4 mr-jonas"><strong>Telefoonnummer *</strong></label>
      <input type="tel" class="form-control" name="telefoonnummer" value="'.$phone.'" required>
   </div>
   </div>
   </div>
    <div class="form-group">
       <div class="row">
         <div class="col-md-6">
      <label for="afdeling" class="h4 mr-jonas"><strong>Afdeling</strong></label>
      <input type="text" class="form-control" name="afdeling" value="'.$department.'">
   </div>
   </div>
   </div>
   <div class="form-group">
       <div class="row">
         <div class="col-md-6">
      <label for="emailadres" class="h4 mr-jonas"><strong>Email *</strong></label>
      <input type="email" class="form-control" name="emailadres" value="'.$email.'" '.$read_only.' required>
   </div>
   </div>
   </div>
   <div class="form-group"  '.$display_none.'>
       <div class="row">
         <div class="col-md-6">
      <label for="email_bevestigen" class="h4 mr-jonas"><strong>Email bevestigen *</strong></label>
      <input type="email" class="form-control" name="email_bevestigen" value="'.$email.'" '.$read_only.' required>
   </div>
   </div>
   </div>';
    //$output .= ' <div class="form-group"> <div class="row"> <div class="col-md-6"> <label for="wachtwoord" class="h4 mr-jonas"><strong>wachtwoord *</strong></label> <input type="password" class="form-control" name="wachtwoord" required> </div></div></div>';
    $output .= '<div class="form-group">
       <div class="row">
         <div class="col-md-6">
      <label for="uitzoekwaarde" class="h4 mr-jonas"><strong>Uitzoekwaarde *</strong></label>
      <select name="maandbedragen">
      <option value="Kunstwerken tot € 30 per maand ( waarvan 50% spaartegoed )">Kunstwerken tot € 30 per maand ( waarvan 50% spaartegoed )</option>
      <option value="Kunstwerken van € 30 tot 60 per maand ( waarvan 50% spaartegoed )">Kunstwerken van € 30 tot 60 per maand ( waarvan 50% spaartegoed )</option>
      <option value="Kunstwerken vanaf € 60 per maand ( waarvan 50% spaartegoed )">Kunstwerken vanaf € 60 per maand ( waarvan 50% spaartegoed )</option></select>
   </div>
   </div>
    <input type="hidden" name="user_type" class="form-control"  value="employee">
    <input type="hidden" name="user_parent" class="form-control"  value="'.get_current_user_id().'">';
    if( !empty( $edit_user_data ) ) :
        $output .= '<input type="hidden" name="user_myaccount_update" class="form-control"  value="update">';
        $output .= '<input type="hidden" name="user_id" class="form-control"  value="' . esc_attr( $edit_user_id ) . '">';
    endif;
   $output .= '</div>

  
   <button type="button" class="btn btn-primary mr-jonas h4">Terug</button>
   <button type="button" class="btn btn-default mr-jonas h4 company_user_register">Wijzinging van gegevens doorgeven</button>
   <img src="'.KUCRM_COMPANY_URL.'public/images/loading.gif" class="kucrm_company_loader" style="display:none;">
             <div style="display:none" class="kucrm_company_signup_error_msg"><div class="alert"></div> </div>
</form>';
		
		 return $output;
		 wp_die();
	}

  /* Register ajax function */
    public function kucrm_company_ajaxregister()
        {   

            if ($_POST) {
                //$this->username   = $_POST['reg_uname'];
                $this->first_name   = $_POST['reg_fname'];
                $this->last_name  = $_POST['reg_lname'];
                $this->phone   = $_POST['reg_phone'];
                $this->department   = $_POST['reg_department'];
                $this->email = $_POST['reg_email'];
                $this->confirm_email = $_POST['reg_con_email'];
                $this->password = wp_generate_password(8);
                // $this->password = $_POST['reg_wachtwoord'];
                $this->search_value = $_POST['reg_search_value'];
                $this->user_type      = $_POST['reg_user_type'];
                $this->user_parent      = $_POST['reg_user_parent'];
                $this->user_myaccount_update = $_POST['user_myaccount_update'];
                $this->userid = $_POST['user_id'];
    
            }
            
            $userdata = array(
                            'user_login'  => esc_attr($this->email),
                            'user_email'  => esc_attr($this->email),
                            'user_pass'   => esc_attr($this->password),
                            'first_name'  => esc_attr($this->first_name),
                            'last_name'   => esc_attr($this->last_name),
                           
                        );            
            if (is_wp_error($this->company_validation( $_POST )) && empty( $this->user_myaccount_update ) ) {
                echo json_encode(array('loggedin'=>false, 'message'=> $this->company_validation()->get_error_message() ));
            }elseif( !is_wp_error($this->company_validation( $_POST )) && !empty( $this->user_myaccount_update ) ) {
               update_user_meta( $this->userid, 'first_name', $this->first_name  ); 
               update_user_meta( $this->userid, 'last_name', $this->last_name  ); 
               //update_user_meta( $register_user, 'user_parent', $this->user_parent  ); 
               update_user_meta( $this->userid, 'department',  $this->department  );
               update_user_meta( $this->userid, 'search_value',  $this->search_value  );
               update_user_meta( $this->userid, 'phone',  $this->phone );
               update_user_meta( $this->userid, 'user_parent',  $this->user_parent );
               echo json_encode(array('loggedin'=>true, 'message'=> 'Your data has been successfully updated.' ));
            } 
            else {                
                $register_user = wp_insert_user($userdata);
                
               update_user_meta( $register_user, 'user_type', $this->user_type  ); 
               //update_user_meta( $register_user, 'user_parent', $this->user_parent  ); 
               update_user_meta( $register_user, 'department',  $this->department  );
               update_user_meta( $register_user, 'search_value',  $this->search_value  );
               update_user_meta( $register_user, 'phone',  $this->phone );
               update_user_meta( $register_user, 'user_parent',  $this->user_parent );

               update_user_meta( $register_user, 'crm_user_status',  0 );

                if (!is_wp_error($register_user)) {
                    echo json_encode(array('loggedin'=>true, 'message'=> 'Registration completed.' ));
                    $user_data = get_userdata($register_user);
                    $user_email = $user_data->user_email;
                    
                    //$str = 'This is an encoded string';
                    $encode_email = base64_encode($user_email);
                    $time = time();
                    update_user_meta( $register_user, 'password_reset_time', $time );

                     $headers = array('Content-Type: text/html; charset=UTF-8');
                     $subject = 'Mail for Email and Password.';
                     $message = '<p>Hello,</p><p>hallo je bent geregistreerd als nieuw account.</p><p>Uw e-mail-ID is:'.$this->email.'</p><p>Wachtwoord is:'.$this->password.'</p><p>If Wil je de pas wijzigen klik dan op deze link.</p><a href="'.esc_url(get_site_url().'/reset-password/?token='.$encode_email.'_'.$time).'" target="_blank">'.get_site_url().'/reset-password?token='.$encode_email.'_'.$time.' </a>'; 
                    $sent = wp_mail( $user_email,  $subject, $message, $headers);
                    var_dump($send);
                     if($sent) {
                           echo 'Send';
                      }
                      else  {
                        echo 'Not send';
                      }
                } else {
                    echo json_encode(array('loggedin'=>false, 'message'=> $register_user->get_error_message() ));                    
                }
            }
            die();
        }


        // Register validations
        public function company_validation( $args )
        {

            if ( empty($this->phone) || empty($this->password) || empty($this->email) || empty($this->confirm_email) || empty($this->first_name) || empty($this->last_name) ) {
                return new WP_Error('field', 'Required form field is missing.');
            }
            /*if (strlen($this->username) < 4) {
                return new WP_Error('username_length', 'Username too short. At least 4 characters is required.');
            }*/
           
            /*if(!preg_match('/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/', $this->phone))
            {
              return new WP_Error('phone_validation', 'Phone is not valid.');
            }*/
            if(!preg_match("/^[0-9]{10}$/",  $this->phone)) {
              return new WP_Error('phone_validation', 'Phone is not valid.');
            }
            if (!is_email($this->email)) {
                return new WP_Error('email_invalid', 'Email is not valid');
            }
            if (!is_email($this->confirm_email)) {
                return new WP_Error('confirm_email_invalid', 'Confirm Email is not valid');
            }
            if (($this->email) != ($this->confirm_email)) {
                return new WP_Error('email_match_invalid', 'Email and Confirm not match');
            }
            
            if (email_exists($this->email) && empty( $args['user_myaccount_update'] ) ) {
                return new WP_Error('email', 'Email Already in use');
            }
       
            if (strlen($this->password) < 8) {
                return new WP_Error('password', 'Password length must be greater than 8.');
            }
            

          /*  if (!empty($website)) {
                if (!filter_var($this->website, FILTER_VALIDATE_URL)) {
                    return new WP_Error('website', 'Website is not a valid URL');
                }
            }*/
/*
            $details = array(
                            //'Username'   => $this->username,
                            'First Name' => $this->first_name,
                            'Last Name'  => $this->last_name,
                        );

            foreach ($details as $field => $detail) {
                if (!validate_username($detail)) {
                    return new WP_Error('name_invalid', 'Sorry, the "' . $field . '" you entered is not valid');
                }
            }*/
        }



       

}

function kucrm_get_users_by_company( $company_id = 0) {
        $args = array(
    'meta_query' => array(
        'relation' => 'OR',
            array(
                'key'     => 'user_parent',
                'value'   => $company_id,
                'compare' => '='
            )
    )
 );
$user_query = new WP_User_Query( $args );
$users_all_data = array(); 
    if ( ! empty( $user_query->get_results() ) ) {
        foreach ( $user_query->get_results() as $user ) {
            $department = get_user_meta($user->id,'department', true);
            $search_value = get_user_meta($user->id,'search_value', true);
             $users_all_data[] = array(
                               'id' => $user->id,
                               'email' =>$user->user_email,
                               'display_name' =>$user->display_name,
                               'user_status' =>$user->user_status,
                               'department' =>$department,
                               'search_value' =>$search_value,
                               );
    }

}
return $users_all_data;
      }
?>