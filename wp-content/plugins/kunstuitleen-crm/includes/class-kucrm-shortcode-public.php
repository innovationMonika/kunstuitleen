<?php

use Pronamic\WordPress\Http\Request;

class kucrm_Shortcode
{

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
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

        // Create shortcode
        add_shortcode('kucrm-login-form', array(
            $this,
            'kucrm_login_shortcode'
        ));
        add_shortcode('kucrm-register-form', array(
            $this,
            'kucrm_register_shortcode'
        ));
        add_shortcode('kucrm-password-lost-form', array(
            $this,
            'kucrm_password_lost_form'
        ));
        add_shortcode('kucrm-reset-password-form', array(
            $this,
            'kucrm_reset_password_form'
        ));

        // ajax call
        add_action('wp_ajax_kucrm_ajaxregister', array(
            $this,
            'kucrm_ajaxregister_custom_ajax_registration'
        ));
        add_action('wp_ajax_kucrm_update_password', array(
            $this,
            'kucrm_update_password'
        ));
        add_action('wp_ajax_nopriv_kucrm_update_password', array(
            $this,
            'kucrm_update_password'
        ));
        add_action('wp_ajax_nopriv_kucrm_ajaxregister', array(
            $this,
            'kucrm_ajaxregister_custom_ajax_registration'
        ));

        add_action('wp_ajax_kucrm_ajaxlogin', array(
            $this,
            'kucrm_custom_ajax_login'
        ));
        add_action('wp_ajax_nopriv_kucrm_ajaxlogin', array(
            $this,
            'kucrm_custom_ajax_login'
        ));

        /* add_action( 'wp_ajax_kucrm_ajax_resetpassword',  array($this, 'kucrm_ajax_resetpassword' ));*/
        add_action('wp_ajax_nopriv_kucrm_ajax_resetpassword', array(
            $this,
            'kucrm_ajax_resetpassword'
        ));

        add_action('wp_ajax_nopriv_kucrm_ajax_update_password', array(
            $this,
            'kucrm_ajax_update_password'
        ));
        add_action('wp_ajax_kucrm_ajax_update_password', array(
            $this,
            'kucrm_ajax_update_password'
        ));

        // hook lost password
        add_action('login_form_lostpassword', array(
            $this,
            'kucrm_do_password_lost'
        ));

        // filter for email html support
        add_filter('wp_mail_content_type', array(
            $this,
            'kucrm_email_set_content_type'
        ));
    }

    // email html support funcation
    function kucrm_email_set_content_type()
    {
        return "text/html";
    }

    /* register shortcode */
    public function kucrm_register_shortcode($atts)
    {
        $atts = shortcode_atts(array(
            'user_type' => 'private'
        ), $atts, 'kucrm-register-form');
        $output = '';
        if (is_user_logged_in()) {
            $output .= '<a class="kucrm_logout_btn" href="' . wp_logout_url(get_site_url()) . '">' . esc_html__('Uitloggen') . '</a>';
            return $output;
        }
        $output .= '
      <form class="kucrm_register_form">
        
         <div class="form-group">
         
            <input type="text" name="vooornaam" class="form-control"  placeholder="Vooornaam*">
         </div>
         <div class="form-group">
            <input type="text"  name="achternaam"  class="form-control"  placeholder="Achternaam*">
         </div>
         <div class="form-group">
            <input type="text"  name="straatnaam"  class="form-control"  placeholder="Straatnaam*">
         </div>
         <div class="form-group">
            <input type="text"  name="postcode"  class="form-control"  placeholder="Postcode*">
         </div>
         <div class="form-group">
            <input type="text"  name="woonplaats"  class="form-control"  placeholder="Woonplaats*">
         </div>
         ';
         
        if ($atts['user_type'] == 'company') {

            $output .= '<div class="form-group"><input type="text"  name="organisatie" class="form-control"  placeholder="Organisatie*"></div>
         <input type="hidden" name="user_type" class="form-control"  value="company">
            <input type="hidden" name="user_parent" class="form-control"  value="1">';
        } else {
            $output .= '<div class="form-group">
            <input type="hidden" name="user_type" class="form-control"  value="private">
            <input type="hidden" name="user_parent" class="form-control"  value="0">
         </div>';
        }
        $output .= '<div class="form-group">
            <input type="text" name="telefoonnummer" class="form-control"  placeholder="Telefoonnummer*">
         </div>
         <div class="form-group">
            <input type="email" name="emailadres" class="form-control"  placeholder="Emailadres*">
         </div>
          <div class="form-group">
            <input type="password" name="wachtwoord" class="form-control"  placeholder="Wachtwoord*">
         </div> 
         <div class="form-group">
            <input type="password" name="bevestig_wachtwoord" class="form-control"  placeholder="Bevestig Wachtwoord*">
         </div> 
         
         <button type="button" class="btn btn-info btn-block btn-round sign-up-complete crm_signup_btn">' . esc_html__('Account aanvragen', 'kunstuitleen-crm') . '</button>
         <div><img src="' . KUCRM_URL . 'public/images/loading.gif" class="kucrm_loader" style="display:none;"></div>
             <div style="display:none" class="kucrm_signup_error_msg"><div class="alert"></div> </div>
      </form>
      ';

        return $output;
    }

    /* Login form Shortcode */

    function kucrm_login_shortcode()
    {
        if (is_user_logged_in()) {
            //$output .=  '<p>'.esc_html__( 'your are already logged in.' ).'</p>';
            $output .= '<a class="kucrm_logout_btn" href="' . wp_logout_url(get_site_url()) . '">' . esc_html__('Uitloggen', 'kunstuitleen-crm') . '</a>';
            return $output;
        }

        $output = '<div class="kucrm-login-from-wrap">
                            <form class="forms login kucrm_login_form" method="post" >
                                <div class="form-group">
               <input type="email" name="kucrm_user_login" class="form-control"  placeholder="' . esc_html__('Jouw e-mailadres...', 'kunstuitleen-crm') . '">
            </div>
            <div class="form-group">
               <input type="password" name="kucrm_user_password" class="form-control"  placeholder="' . esc_html__('Je wachtwoord...', 'kunstuitleen-crm') . '">
            </div>
            <div class="row text-right forget-pass">
               <a class="mr-jonas" type="button" style="cursor: pointer;">' . esc_html__('Wachtwoord vergeten ?', 'kunstuitleen-crm') . '</a>
            </div>
            <button type="button" class="btn btn-info btn-block btn-round kucrm_login_btn">' . esc_html__('Log in', 'kunstuitleen-crm') . '</button>
             <div>
                 <img src="' . KUCRM_URL . 'public/images/loading.gif" class="kucrm_loader" style="display:none;">
             </div>
             <div style="display:none" class="kucrm_response_msg">
                 <div class="alert"></div>
             </div>
            
         </form></div>';
        return $output;
    }

    // password reset form
    public function kucrm_password_lost_form($attributes, $content = null)
    {
        // Parse shortcode attributes
        $default_attributes = array(
            'show_title' => false
        );
        $attributes = shortcode_atts($default_attributes, $attributes);
        $output = '';
        if (is_user_logged_in()) {
            // $output .=  '<p>'.esc_html__( 'your are already logged in.' ).'</p>';
            $output .= '<a class="kucrm_logout_btn" href="' . wp_logout_url(get_site_url()) . '">' . esc_html__('Uitloggen') . '</a>';
            return $output;
        } else {

            $output .= '<form class="lostpasswordform" method="post">
                            <div class="form-group">
                                <input type="text" name="user_login" placeholder="' . esc_html__('Voer e-mail of gebruikersnaam in.', 'kunstuitleen-crm') . '">
                            </div>
                            <p class="lostpassword-submit">
                                <input type="submit" name="submit" class="lostpassword-button btn btn-info btn-block btn-round confirm" value="' . esc_html__('Wachtwoord opnieuw instellen') . '"/>
                            </p>
                            <div>
                                <img src="' . KUCRM_URL . 'public/images/loading.gif" class="kucrm_loader" style="display:none;">
                            </div>
                            <div style="display:none" class="kucrm_response_msg">
                                <div class="alert"></div>
                            </div>
                        </form>';
            return $output;
        }
    }

    public function kucrm_update_password(){
        //get current user id
        $current_user = wp_get_current_user();
        $user_id = $current_user->ID;
        //get password
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];
        //check if password is correct
        if(wp_check_password($current_password, $current_user->data->user_pass, $current_user->ID)){
            //check if new password is equal to confirm password
            if($new_password == $confirm_password){
                //update password
                wp_set_password($new_password, $user_id);
                //return success message
                echo json_encode(array('status' => 'success', 'message' => esc_html__('Wachtwoord is succesvol gewijzigd.', 'kunstuitleen-crm')));
            }else{
                //return error message
                echo json_encode(array('status' => 'error', 'message' => esc_html__('De nieuwe wachtwoorden komen niet overeen.', 'kunstuitleen-crm')));
            }
        }else{
            echo json_encode(array('status' => 'error', 'message' => esc_html__('Het huidige wachtwoord is onjuist.', 'kunstuitleen-crm')));
        }

       wp_die();
}



    //  Reset password form
    public function kucrm_reset_password_form()
    {
        //$_GET['token'] = 'YXNkcmVyd2Vhc2RAeW9wbWFpbC5jb20=_1626789371';
        if (isset($_GET['token']) && !empty($_GET['token']) && !is_user_logged_in()) {
            $token = $_GET['token'];

            $encode_data = explode("_", $token);
            $encode_email = $encode_data['0'];
            $time = absint($encode_data['1']);
            $email = base64_decode($encode_email);
            $user = get_user_by('email', $email);
            $userId = $user->ID;
            $password_reset_time = absint(get_user_meta($userId, 'password_reset_time', true));

            if ($time == $password_reset_time) {
                $output .= '<form class="update_password_form" method="post">
             <div class="form-group">
            <input type="text" name="new_password" id="new_password" placeholder="New Password">
            <input type="text" name="confirm_password" id="confirm_password" placeholder="Confirm Password">
            <input type="hidden" name="user_id" value="' . $userId . '">
            
         </div>
        <p class="update_password_submit">
            <input type="submit" name="submit" class="update_password_button btn btn-info btn-block btn-round confirm"
                   value="' . esc_html__('Vernieuw wachtwoord') . '"/>
        </p>
        <div>
             <img src="' . KUCRM_URL . 'public/images/loading.gif" class="kucrm_loader" style="display:none;">
        </div>
        <div style="display:none" class="kucrm_response_msg">
            <div class="alert"></div>
        </div>
    </form>';

                return $output;
            }
        }
    }

    //  update password  funcation
    public function kucrm_ajax_update_password()
    {
        if ($_POST) {
            $new_password = $_POST['new_password'];
            $confirm_password = $_POST['confirm_password'];
            $user_id = $_POST['user_id'];
        }
        if (empty($new_password) || empty($confirm_password)) {
            echo json_encode(array(
                'loggedin' => false,
                'message' => __('Wachtwoord mag niet leeg zijn.')
            ));
        } elseif (strlen($new_password) < 8 && strlen($confirm_password) < 8) {
            echo json_encode(array(
                'loggedin' => false,
                'message' => __('Wachtwoordlengte moet groter zijn dan 8.')
            ));
        } elseif ($new_password != $confirm_password) {
            echo json_encode(array(
                'loggedin' => false,
                'message' => __('Nieuw wachtwoord en bevestig wachtwoord komen niet overeen')
            ));
        } else {
            echo json_encode(array(
                'loggedin' => true,
                'message' => __('Uw wachtwoord is bijgewerkt.')
            ));
            wp_set_password($new_password, $user_id);
        }
        wp_die();
    }
    //  password reset funcation
    public function kucrm_ajax_resetpassword()
    {

        if ($_POST) {
            $email_user = trim($_POST['username']);

            if (email_exists($email_user)) {

                $user = get_user_by('email', $email_user);
                $userId = $user->ID;
            } elseif (username_exists($email_user)) {
                $user = get_userdatabylogin($email_user);
                $userId = $user->ID;
            } elseif (empty($email_user)) {
                echo json_encode(array(
                    'loggedin' => false,
                    'message' => __('Voer gebruikersnaam of e-mailadres in.')
                ));
                wp_die();
            } else {
                echo json_encode(array(
                    'loggedin' => false,
                    'message' => __('Gebruiker bestaat niet')
                ));
                wp_die();
            }
            echo json_encode(array(
                'loggedin' => true,
                'message' => __('E-mail voor wachtwoordherstel verzonden')
            ));

            $user_data = get_userdata($userId);
            $user_email = $user_data->user_email;
            $user_name = $user_data->display_name;
            $encode_email = base64_encode($user_email);
            $time = time();
            update_user_meta($userId, 'password_reset_time', $time);
            $headers[] = 'From:' . "testing@gmail.com";
            $headers[] = "MIME-Version: 1.0";
            $headers[] = "Content-Type: text/html; charset=iso-8859-1";
            $subject = 'Mail for password reset';
            $message = '<p>' . esc_html__('Hallo,', 'kunstuitleen-crm') . '</p><p>' . esc_html__('klik op deze link om je wachtwoord te wijzigen', 'kunstuitleen-crm') . '</p><a href="' . esc_url(get_site_url() . '/reset-password/?token=' . $encode_email . '_' . $time) . '" target="_blank"> ' . esc_html__('Wachtwoord opnieuw instellen 
', 'kunstuitleen-crm') . ' </a>';

            $sent = wp_mail($user_email, $subject, $message, $headers);

            /*if($sent) {
            echo 'send';
            }else{
            echo 'not send';
            }*/
        }

        die();
    }

    // User login code.
    function kucrm_custom_ajax_login()
    {
        if ($_POST) {

            $login_data = array();
            $login_data['user_login'] = trim($_POST['username']);
            $login_data['user_password'] = trim($_POST['password']);
            $login_data['remember'] = true;

            if (email_exists($_POST['username'])) {
                $user = get_user_by('email', $_POST['username']);
                $userId = $user->ID;
                $user_status = get_user_meta($userId, 'crm_user_status', true);
                if ($user_status == 1) {
                    $user_signon = wp_signon($login_data, false);
                    if (is_wp_error($user_signon)) {
                        echo json_encode(array(
                            'loggedin' => false,
                            'message' => __('Verkeerde gebruikersnaam of wachtwoord')
                        ));
                    } else {
                        echo json_encode(array(
                            'loggedin' => true,
                            'message' => __('Login succesvol, uw wordt doorgestuurd...'),
                            'redirect_url' => home_url('/kunstuitleen-my-account/'),
                        ));
                    }
                } else {
                    echo json_encode(array(
                        'loggedin' => false,
                        'message' => __('U bent niet goedgekeurd door de beheerder.')
                    ));
                }
            } else {
                echo json_encode(array(
                    'loggedin' => false,
                    'message' => __('This email id not exist.')
                ));
            }
        }
        die();
    }

    /* Register ajax function */
    public function kucrm_ajaxregister_custom_ajax_registration()
    {
        if ($_POST) {
            $this->email = $_POST['emailadres'];
            $this->password = $_POST['wachtwoord'];
            if ($_POST['organisatie'] == 'test') :
                $this->company = '';
            else :
                $this->company = $_POST['organisatie'];
            endif;
            $this->confirm_password = $_POST['bevestig_wachtwoord'];
            $this->first_name = $_POST['vooornaam'];
            $this->last_name = $_POST['achternaam'];
            $this->street_name= $_POST['straatnaam'];
            $this->postcode= $_POST['postcode'];
            $this->city= $_POST['woonplaats'];
            $this->phone = $_POST['telefoonnummer'];
            $this->user_type = $_POST['reg_user_type'];
            $this->user_parent = $_POST['reg_user_parent'];
        }
        if (isset($this->company) && !empty($this->company)) {
            $userdata = array(
                'user_login' => esc_attr($this->email),
                'user_email' => esc_attr($this->email),
                'user_pass' => esc_attr($this->password),
                'user_confirm_password' => esc_attr($this->confirm_password),
                'first_name' => esc_attr($this->first_name),
                'last_name' => esc_attr($this->last_name),
                'street_name' => esc_attr($this->street_name),
                'postcode' => esc_attr($this->postcode),
                'city' => esc_attr($this->city),
                'role' => 'company'

            );
        } else {
            $userdata = array(
                'user_login' => esc_attr($this->email),
                'user_email' => esc_attr($this->email),
                'user_pass' => esc_attr($this->password),
                'user_confirm_password' => esc_attr($this->confirm_password),
                'first_name' => esc_attr($this->first_name),
                'last_name' => esc_attr($this->last_name),
                'street_name' => esc_attr($this->street_name),
                'postcode' => esc_attr($this->postcode),
                'city' => esc_attr($this->city)
            );
        }
        /* if ( isset($this->company) && empty($this->company)  ) {
                   $userdata['role'] = 'company';
            }else{
                $userdata['role'] = 'subscriber';
            }*/
        $all_fileds = array(
            'vooornaam',
            'achternaam',
            'organisatie',
            'straatnaam',
            'postcode',
            'woonplaats',
            'telefoonnummer',
            'emailadres',
            'wachtwoord',
            'bevestig_wachtwoord'
        );
        $data = array();
        $error = 0;
        if (!empty($_POST)) :
            foreach ($_POST as $form_key => $form_val) :
                if (in_array($form_key, $all_fileds) && !empty($form_val)) :
                    switch ($form_key):
                        case 'telefoonnummer':
                            if (!preg_match("/^[0-9]{10}$/", $form_val)) :
                                $data[] = array('status' => 'error', 'field_key' => $form_key, 'message' => esc_html__('Telefoonnummer is niet geldig', 'kunstuitleen-crm'));
                                $error = 1;
                            else :
                                $data[] = array('status' => 'success', 'field_key' => $form_key, 'message' => '');
                            endif;

                            break;
                        case 'emailadres':
                            if (!is_email($form_val)) :
                                $data[] = array('status' => 'error', 'field_key' => $form_key, 'message' => esc_html__('Email is niet geldig', 'kunstuitleen-crm'));
                                $error = 1;
                            elseif (email_exists($form_val)) :
                                $data[] = array('status' => 'error', 'field_key' => $form_key, 'message' => esc_html__('Email is al in gebruik', 'kunstuitleen-crm'));
                                $error = 1;
                            else :
                                $data[] = array('status' => 'success', 'field_key' => $form_key, 'message' => '');
                            endif;

                            break;
                        case 'wachtwoord':
                            if (strlen($this->password) < 8) :
                                $data[] = array('status' => 'error', 'field_key' => $form_key, 'message' => esc_html__('Wachtwoordlengte moet groter zijn dan 8', 'kunstuitleen-crm'));
                                $error = 1;
                            else :
                                $data[] = array('status' => 'success', 'field_key' => $form_key, 'message' => '');
                            endif;
                            break;
                        case 'bevestig_wachtwoord':
                            if (strlen($this->confirm_password) < 8) :
                                $data[] = array('status' => 'error', 'field_key' => $form_key, 'message' => esc_html__('Confirm Wachtwoordlengte moet groter zijn dan 8', 'kunstuitleen-crm'));
                                $error = 1;
                            elseif ($this->password != $this->confirm_password) :
                                $data[] = array('status' => 'error', 'message' => esc_html__('Wachtwoord en bevestig wachtwoord komen niet overeen', 'kunstuitleen-crm'));
                                $error = 1;
                            else :
                                $data[] = array('status' => 'success', 'field_key' => $form_key, 'message' => '');
                            endif;

                            break;
                    endswitch;
                elseif (in_array($form_key, $all_fileds) && empty($form_val)) :
                    switch ($form_key):
                        case 'vooornaam':
                            $data[] = array('status' => 'error', 'field_key' => $form_key, 'message' => esc_html__('Vul a.u.b. de voornaam in', 'kunstuitleen-crm'));
                            $error = 1;
                            break;
                        case 'achternaam':
                            $data[] = array('status' => 'error', 'field_key' => $form_key, 'message' => esc_html__('Vul a.u.b. achternaam in.', 'kunstuitleen-crm'));
                            $error = 1;
                            break;
                        case 'organisatie':
                            $data[] = array('status' => 'error', 'field_key' => $form_key, 'message' => esc_html__('Vul a.u.b. de naam van de organisatie in', 'kunstuitleen-crm'));
                            $error = 1;

                            break;
                        case 'telefoonnummer':
                            $data[] = array('status' => 'error', 'field_key' => $form_key, 'message' => esc_html__('Voer uw telefoonnummer in', 'kunstuitleen-crm'));
                            $error = 1;
                            break;
                        case 'emailadres':
                            $data[] = array('status' => 'error', 'field_key' => $form_key, 'message' => esc_html__('Voer de e-mailnaam in', 'kunstuitleen-crm'));
                            break;
                        case 'wachtwoord':
                            $data[] = array('status' => 'error', 'field_key' => $form_key, 'message' => esc_html__('Voer wachtwoord in alstublieft', 'kunstuitleen-crm'));
                            $error = 1;
                            break;
                        case 'bevestig_wachtwoord':
                            $data[] = array('status' => 'error', 'field_key' => $form_key, 'message' => esc_html__('Voer het bevestigingswachtwoord in', 'kunstuitleen-crm'));
                            $error = 1;
                            break;
                        case 'straatnaam':
                            $data[] = array('status' => 'error', 'field_key' => $form_key, 'message' => esc_html__('Voer de straatnaam in', 'kunstuitleen-crm'));
                            $error = 1;
                            break;
                        case 'postcode':
                            $data[] = array('status' => 'error', 'field_key' => $form_key, 'message' => esc_html__('Voer de postcode in', 'kunstuitleen-crm'));
                            $error = 1;
                            break;
                        case 'woonplaats':
                            $data[] = array('status' => 'error', 'field_key' => $form_key, 'message' => esc_html__('Voer de woonplaats in', 'kunstuitleen-crm'));
                            $error = 1;
                            break;
                    endswitch;

                endif;
            endforeach;
            if ($error == 0) :
                $register_user = wp_insert_user($userdata);
                update_user_meta($register_user, 'user_type', $this->user_type);
                update_user_meta($register_user, 'user_parent', $this->user_parent);
                update_user_meta($register_user, 'phone',  $this->phone);
                update_user_meta($register_user, 'street', $this->street_name);
                update_user_meta($register_user, 'postcode', $this->postcode);
                update_user_meta($register_user, 'city', $this->city);
                update_user_meta($register_user, 'crm_user_status',  0);

                if ($this->user_type == 'private') {
                    update_user_meta($register_user, 'relation_id',  0);
                    $register_data=array('first_name'=>$this->first_name,'last_name'=>$this->last_name,'email_address'=>$this->email,'street_name'=>$this->street_name,'postcode'=>$this->postcode,'city'=>$this->city,'telephone_number'=>$this->phone,'type'=>'Home','date'=>date('Y-m-d'));
                } else if ($this->user_type == 'company') {
                    update_user_meta($register_user, 'company_id',  0);
                    $register_data=array('first_name'=>$this->first_name,'last_name'=>$this->last_name,'email_address'=>$this->email,'company_name'=>$this->company,'street_name'=>$this->street_name,'postcode'=>$this->postcode,'city'=>$this->city,'telephone_number'=>$this->phone,'type'=>'Work','date'=>date('Y-m-d'));
                }
                $result=$this->create_account_request($register_data);
                $result = json_decode($result, true);
                $status = $result['status'];
                $account_id=$result['account_id'];
                if($status==1){
                update_user_meta($register_user, 'account_id',  $account_id);
                }
                if (!is_wp_error($register_user)) :
                    if (isset($this->company) && !empty($this->company)) :
                        $Kunstuitleen_Database = $table = $column = $format = $compny_id = '';
                        $Kunstuitleen_Database = new Kunstuitleen_Database;
                        $table = 'company_details';
                        $column = array(
                            'company_name'       => $this->company,
                            'status'             => 0,
                            'company_owner_name' => $this->first_name . ' ' . $this->last_name,
                            'company_owner_id'   => $register_user,
                            'registration_date'  => date('Y-m-d H:i:s'),
                        );
                        $format = array('%s', '%d', '%s', '%d', '%s');
                        $compny_id = $Kunstuitleen_Database->kunstuitleen_insert($table, $column, $format);
                        update_user_meta($register_user, 'company', $this->company);
                    endif;
                    echo json_encode(array('status' => 'success', 'message' => esc_html__('Registratie compleet', 'kunstuitleen-crm')));
                else :
                    echo json_encode(array('status' => 'error', 'message' => $register_user->get_error_message()));
                endif;
            else :
                echo json_encode($data);
            endif;
        endif;

        die();
    }
    public function create_account_request($data)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://k-crm.agile-steps.com/api/create-account-request'); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
}
