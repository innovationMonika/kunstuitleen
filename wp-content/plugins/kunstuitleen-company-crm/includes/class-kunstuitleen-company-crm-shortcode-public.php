<?php
class kucrm_company_Shortcode
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
        /**
         * Add action create kucrm company user register form
         */
        add_shortcode('kucrm-company-user-register-form', array(
            $this,
            'kucrm_company_user_register_form'
        ));
        add_shortcode('kucrm-company-rent-agreement-inventory',
            array($this, 'kucrm_company_rent_agreement_inventory'));

        add_shortcode('kucrm-account-password-update', array(
            $this,
            'kucrm_account_password_update'
        ));
        /**
         * Ajax call
         */
        add_action('wp_ajax_kucrm_company_ajaxregister', array(
            $this,
            'kucrm_company_ajaxregister'
        ));
        add_action('wp_ajax_kucrm_update_password', array(
            $this,
            'kucrm_update_password'
        ));
        add_action('wp_ajax_nopriv_kucrm_company_ajaxregister', array(
            $this,
            'kucrm_company_ajaxregister'
        ));

        add_filter('wp_mail_content_type', array(
            $this,
            'kucrm_company_email_set_content_type'
        ));

    }

    /**
     * Email html support funcation
     */
    public function kucrm_company_email_set_content_type()
    {
        return "text/html";
    }

    /**
     * Kunstuitleen get previous page url
     *
     * @since    1.0.0
     */
    public function kunstuitleen_get_previous_page_url()
    {
        $output = '';
        if (isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER'])):
            $output = $_SERVER['HTTP_REFERER'];
        else:
            $output = '#';
        endif;
        return $output;
    }

    /**
     * register shortcode
     */
    public function kucrm_company_rent_agreement_inventory(){
        $inventory_id=$_GET['id'];
        $inventoryData=getRentInventory($inventory_id);
        $inventoryData = json_decode($inventoryData, true);
        $output='';
        ob_start();
        $output .= '<div class="my-inventory">
        <div class="modal fade modal-dialog-center" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                        <div class="modal-dialog" id="modalScroll" style="width:80%;height:100%;">
                                        <div class="modal-content" style="margin-left: 80px;">
                                            <div class="modal-header" style="margin-top: 5px;">
                                            </div>
                                            <div class="modal-body" style="text-align: center; padding: 10px;">
                                                <img id="large-image" src="" alt="Inventory" /> 
                                            </div>
                                            <div class="modal-footer" style="margin-bottom: 10px;"></div>
                                        </div>
                                        </div>
                                    </div>
        <div class="row">
                        <label class="h4 roboto title_heading"><strong>Mijn huidige kunstwerken</strong></label>
                    </div>';
                    if(count($inventoryData)>0){
                        foreach($inventoryData as $inventory){
                            $output .='<div class="row content d-lg-flex my-details mt-2  my-details_group">
                            <div class="col-md-6 img-view">
                                <div class="my-details_img">
                                <button type="button" id="small-image" style="border: none !important;" class="btn btn-default btn-lg btn-block image-model" data-toggle="modal" data-target="#myModal">
                                <img class="img-responsive" style="max-height:200px;margin:auto;" id="small-image-src" src="https://k-crm.agile-steps.com/'.$inventory["image"].'">
                                </button>  
                                </div>
                            </div>
                            <div class="col-md-6 border" style="border-right:none;text-align:center;">
                                <div class="row m0">
                                <label class="h4 roboto" style="font-family: "Cinzel";font-size: 24px;">'.$inventory["name"].'</label>
                                </div>
                                <div class="row m0">
                                <label class="" style="font-family: "MrJones-Book", sans-serif;font-size: 14px;">'.$inventory["artist_name"].'</label>
                                </div>
                                <div class="row m0">
                                <label class="" style="font-family: "MrJones-Book", sans-serif;font-size: 14px;">
                                <span style="font-style: italic;">Lijstformaat: </span>'.$inventory["frame_size"].'</label>
                                </div>
                            <div class="row m0">
                                <div class="row m0">
                                <label class="" style="font-family: "MrJones-Book", sans-serif;font-size: 14px;">
                                <span style="font-style: italic;">Direct kopen: € </span>'.$inventory["gallery_price"].'</label>
                                    
                                </div>
                                <label class="" style="font-family: "MrJones-Book", sans-serif;font-size: 14px;">
                                <span style="font-style: italic;">Verhuurprijs: € </span>'.$inventory["rent_price"].'</label>
                                </div>
                                <div class="row m0">
                                <label class="" style="font-family: "MrJones-Book", sans-serif;font-size: 14px;">
                                <span style="font-style: italic;">Huur vanaf: </span>'.date('d-m-Y', strtotime($inventory["start_date"])).'</label>
                                </div>';
                                if($inventory["end_date"]!=""){
                                    $output .='<div class="row m0">
                                    <label class="" style="font-family: "MrJones-Book", sans-serif;font-size: 14px;">
                                <span style="font-style: italic;">Huur tot: </span>'.date("d-m-Y", strtotime($inventory["end_date"])).'</label>
                                    
                                </div>';
                                }
                                $output .='
                            </div>
                        </div>';
                        }
                    }
                    else{
                        $output .='
                        <div class="row content d-lg-flex my-details mt-2  my-details_group">
                            <div class="col-md-12">
                                <div class="row m0">
                                    <label class="h4 roboto"><strong>You have not rented any artworks yet.</strong></label>
                                </div>
                            </div>';
                    }
        return $output;
        wp_die();

    }
    public function kucrm_account_password_update(){
        $prev_url = $this->kunstuitleen_get_previous_page_url();
        $output='';
        ob_start();

        $output .= '<form role="form" class="kucrm_account_password_update" id="kucrm-company-register-form">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-8">
                                        <label for="old_password" class="h4 roboto"><strong>' . esc_html__( 'Huidig wachtwoord *', 'kunstuitleen-company-crm' ) . ' </strong></label>
                                        <input type="password" class="form-control" name="old_password" value="' . esc_attr( $oldPassword ) . '" required>
                                    </div>
                                    <div class="col-md-8">
                                        <label for="new_password" class="h4 roboto"><strong>' . esc_html__( 'Nieuw wachtwoord *', 'kunstuitleen-company-crm' ) . '</strong></label>
                                        <input type="password" class="form-control" name="new_password" value="' . esc_attr( $newPassword ) . '" required>
                                    </div>
                                    <div class="col-md-8">
                                        <label for="c_new_password" class="h4 roboto"><strong>' . esc_html__( 'Nieuw wachtwoord bevestigen *', 'kunstuitleen-company-crm' ) . '</strong></label>
                                        <input type="password" class="form-control" name="c_new_password" value="' . esc_attr( $confirmNewPassword ) . '" required>
                                    </div>
                                    <div class="col-md-8">
                                    <button class="roboto h4 kucrm_update_password mt-3" type="button" style="color:white; background-color:#607FF2 !important; border:none;height: 48px !important; width: 112px; border-radius: 4px;">Aanpassen</button>
                                    <a href="' . esc_url($prev_url) . '" class="roboto h4 mt-3 password-cancel" style="color:#607FF2; border: solid 2px #607FF2;height: 48px !important; width: 112px; padding:11px; border-radius: 4px;margin-left:10px;">' . esc_html__( 'Annuleren', 'kunstuitleen-company-crm' ) . '</a>
                                    </div>
                                </div>
                            </div>';
                $output .= '<!---- <button type="button" class="btn btn-default roboto h4 ucrm_update_password">Wijzinging van gegevens doorgeven</button>--->
                            <img src="' . KUCRM_COMPANY_URL . 'public/images/loading.gif" class="kucrm_company_loader" style="display:none;"> 
                            <div style="display:none" class="kucrm_response_msg alert alert-error"  id="alertErrorMessage">
                            </div>
                            <div style="display:none" class="kucrm_response_msg alert alert-success"  id="alertSuccessMessage">
                            </div>
                        </form>';

        return $output;
        wp_die();
    }

    public function kucrm_update_password(){
            return json_encode(array('status'=>'success'));
    }


    public function kucrm_company_user_register_form()
    {
        $prev_url = $get_user_id = $wp_get_current_user = $edit_user_id = $kunstuitleen_my_account = $kunstuitleen_get_query_vars = $kunstuitleen_get_query_var_child = '';
        $edit_user_data = $edit_user_email = $first_name = $last_name = $phone = $department = $email = $search_value = '';       
        $prev_url = $this->kunstuitleen_get_previous_page_url();
        $kunstuitleen_my_account = new Kunstuitleen_My_Account;
        $kunstuitleen_get_query_vars = $kunstuitleen_my_account->kunstuitleen_get_query_vars();
        $kunstuitleen_get_query_var_child = $kunstuitleen_my_account->kunstuitleen_get_query_var_child( $kunstuitleen_get_query_vars ); 
        $get_user_id = base64_decode( $_GET['id'] );        
        if( is_user_logged_in() && empty( $get_user_id ) && $kunstuitleen_get_query_var_child != 'create-new-account' ) :
            $wp_get_current_user = wp_get_current_user();
            if( in_array( 'company', $wp_get_current_user->roles ) || in_array( 'administrator', $wp_get_current_user->roles ) || in_array( 'subscriber', $wp_get_current_user->roles ) ) :
                $edit_user_id = $wp_get_current_user->ID;
            endif;
        elseif( is_user_logged_in() && empty( $edit_user_id ) && $kunstuitleen_get_query_var_child != 'create-new-account' ) :
            $edit_user_id = base64_decode( $_GET['id'] );
        endif;
        if( $edit_user_id ){
            $edit_user_data = get_userdata( $edit_user_id );
            if( !empty( $edit_user_data ) ){
                $edit_user_email = $edit_user_data->user_login;
                $first_name =  get_user_meta( $edit_user_id,  'first_name', true );
                $last_name =  get_user_meta( $edit_user_id,  'last_name', true );
                $phone = get_user_meta( $edit_user_id,  'phone', true );
                $department = get_user_meta( $edit_user_id,  'department', true );
                $email = get_user_meta( $edit_user_id,  'nickname', true );
                $search_value = get_user_meta( $edit_user_id,  'search_value', true ); 
            }            
        }
        if( $email ){
            $read_only = 'readonly';
            $display_none = 'style=display:none';
        }
        ob_start();
        $output .= '<form role="form" class="kucrm_company_register_form" id="kucrm-company-register-form">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="reg_fname" class="h4 roboto"><strong>' . esc_html__( 'Vooornaam *', 'kunstuitleen-company-crm' ) . ' </strong></label>
                                        <input type="text" class="form-control" name="reg_fname" value="' . esc_attr( $first_name ) . '" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="reg_lname" class="h4 roboto"><strong>' . esc_html__( 'Achternaam *', 'kunstuitleen-company-crm' ) . '</strong></label>
                                        <input type="text" class="form-control" name="reg_lname" value="' . esc_attr( $last_name ) . '" required>
                                    </div>
                                </div>
                            </div>    
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="reg_phone" class="h4 roboto"><strong>' . esc_html__( 'Telefoonnummer *', 'kunstuitleen-company-crm' ) . '</strong></label>
                                        <input type="tel" class="form-control" name="reg_phone" value="' . esc_attr( $phone ) . '" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="reg_department" class="h4 roboto"><strong>' . esc_html__( 'Department', 'kunstuitleen-company-crm' ) . '</strong></label>
                                        <input type="text" class="form-control" name="reg_department" value="' . esc_attr( $department ) . '">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="reg_email" class="h4 roboto"><strong>' . esc_html__( 'Email *', 'kunstuitleen-company-crm' ) . '</strong></label>
                                        <input type="email" class="form-control" name="reg_email" value="' . esc_attr( $email ) . '" ' . esc_attr( $read_only ) . ' required>
                                    </div>
                                </div>
                            </div>
                            <!--<div class="form-group"  ' . $display_none . '>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="email_bevestigen" class="h4 roboto"><strong>' . esc_html__( 'Email bevestigen *', 'kunstuitleen-company-crm' ) . '</strong></label>
                                        <input type="email" class="form-control" name="email_bevestigen" value="' . esc_attr( $email ) . '" ' . esc_attr( $read_only ) . ' required>
                                    </div>
                                </div>
                            </div>-->
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="uitzoekwaarde" class="h4 roboto"><strong>' . esc_html__( 'Uitzoekwaarde *', 'kunstuitleen-company-crm' ) . '</strong></label>  ';
                                                $output .= kucrm_createFilter('maandbedragen', 'waarde', '', $search_value);
                                                $output .= ob_get_clean();
                                                $output .= '</div>
                                </div>
                                <input type="hidden" name="reg_user_type" class="form-control"  value="employee">
                                <input type="hidden" name="reg_user_parent" class="form-control"  value="' . esc_attr( get_current_user_id() ) . '">';
                                if (!empty($edit_user_data)):
                                    $output .= '<input type="hidden" name="user_myaccount_update" class="form-control"  value="update">';
                                    $output .= '<input type="hidden" name="user_id" class="form-control"  value="' . esc_attr( $edit_user_id ) . '">';
                                endif;
                $output .= '</div>
                            <a href="' . esc_url($prev_url) . '" class="btn btn-primary roboto h4">' . esc_html__( 'Terug', 'kunstuitleen-company-crm' ) . '</a>
                            <!--<button type="button" class="btn btn-primary roboto h4">Terug</button>-->
                            <button type="button" class="btn btn-default roboto h4 company_user_register">Wijzinging van gegevens doorgeven</button>
                            <img src="' . KUCRM_COMPANY_URL . 'public/images/loading.gif" class="kucrm_company_loader" style="display:none;">
                            <div style="display:none" class="kucrm_company_signup_error_msg"><div class="alert"></div></div>
                        </form>';

        return $output;
        wp_die();
    }

    /**
     * Register ajax function 
     */
    public function kucrm_company_ajaxregister(){ 
    $all_fileds = $check = $userdata = $register_user = '';         
    if ($_POST) {                
        $this->first_name = $_POST['reg_fname'];
        $this->last_name  = $_POST['reg_lname'];
        $this->phone = $_POST['reg_phone'];
        $this->department = $_POST['reg_department'];
        $this->email = $_POST['reg_email'];
        //$this->confirm_email = $_POST['reg_con_email'];
        $this->password = wp_generate_password(8);                
        $this->search_value = $_POST['reg_search_value'];
        $this->user_type = $_POST['reg_user_type'];
        $this->user_parent = $_POST['reg_user_parent'];
        $this->user_myaccount_update = $_POST['user_myaccount_update'];
        $this->userid = $_POST['user_id'];    
    }
    $all_fileds = array('reg_fname', 'reg_lname', 'reg_phone', 'reg_department', 'reg_email', 'reg_search_value', 'reg_user_type', 'reg_user_parent', 'user_myaccount_update', 'user_id'); 
    $check = $this->kunstuitleen_user_validation( $_POST, $all_fileds, $this->user_myaccount_update );
    if( is_array( $check ) && !empty( $check ) ) :
        echo json_encode( $check );
    else :
        if( !empty( $this->user_myaccount_update ) && !empty( $this->userid ) ) :
            update_user_meta( $this->userid, 'first_name', $this->first_name  ); 
            update_user_meta( $this->userid, 'last_name', $this->last_name  ); 
            update_user_meta( $this->userid, 'department',  $this->department  );
            update_user_meta( $this->userid, 'search_value',  $this->search_value  );
            update_user_meta( $this->userid, 'phone',  $this->phone );
            echo json_encode( array( 'status' => 'success', 'message' => 'Your data has been successfully updated.' ) );
        else:
            $userdata = array(
                        'user_login'  => esc_attr( $this->email ),
                        'user_email'  => esc_attr( $this->email ),
                        'user_pass'   => esc_attr( $this->password ),
                        'first_name'  => esc_attr( $this->first_name ),
                        'last_name'   => esc_attr( $this->last_name ),                       
                        ); 
            $register_user = wp_insert_user( $userdata );
            update_user_meta( $register_user, 'user_type', $this->user_type  );                
            update_user_meta( $register_user, 'department',  $this->department  );
            update_user_meta( $register_user, 'search_value',  $this->search_value  );
            update_user_meta( $register_user, 'phone',  $this->phone );
            update_user_meta( $register_user, 'user_parent',  $this->user_parent );
            update_user_meta( $register_user, 'crm_user_status',  0 ); 
            if( !is_wp_error( $register_user ) ) :
                $user_data = get_userdata( $register_user );
                $user_email = $user_data->user_email;
                $encode_email = base64_encode($user_email);
                $time = time();
                $urlparts = parse_url(home_url());
                $domain = $urlparts['host'];
                update_user_meta( $register_user, 'password_reset_time', $time );
                $headers[] = 'From:' . "<wordpress@".$domain.">";
                $headers[] = "MIME-Version: 1.0";
                $headers[] = "Content-Type: text/html; charset=iso-8859-1";
                $subject = esc_html__( 'Mail for Email and Password.', 'kunstuitleen-company-crm' );
                $message = '<p>Hello,</p><p>hallo je bent geregistreerd als nieuw account.</p><p>Uw e-mail-ID is:'.$user_email.'</p><p>Wachtwoord is:'.$this->password.'</p><p>If Wil je de pas wijzigen klik dan op deze link.</p><a href="'.esc_url(get_site_url().'/reset-password/?token='.$encode_email.'_'.$time).'" target="_blank">'. esc_html__( 'Verifiëren
', 'kunstuitleen-company-crm' ).' </a>'; 
                $sent = wp_mail( $user_email,  $subject, $message, $headers );                 
                echo json_encode( array( 'status' => 'success', 'message'=> esc_html__( 'U heeft met succes een nieuwe gebruiker toegevoegd.', 'kunstuitleen-company-crm' ) ) );
            else :
                echo json_encode( array( 'status' => 'error', 'message'=> $register_user->get_error_message() ) );
            endif;
        endif;
    endif;
    wp_die();
    }

    /**
     * Kunstuitleen user validation
     */
    public function kunstuitleen_user_validation( $form_data, $all_fileds, $extra ){
        $output = '';
        $error = 0;
        $data = array();
        if( !empty( $form_data ) ) :
            foreach( $form_data as $form_key => $form_val ) :
                if( in_array( $form_key, $all_fileds ) && !empty( $form_val ) ) :                     
                    switch( $form_key ) :
                        case 'reg_fname':
                        case 'reg_lname':
                                $data[] = array( 'status' => 'success', 'field_key' => $form_key, 'message' => '' );  
                        break;
                        //case 'reg_department':
                        case 'reg_search_value':
                                $data[] = array( 'status' => 'success', 'field_key' => $form_key, 'message' => '' );                          
                        break;
                        case 'reg_phone':
                            if( !preg_match("/^[0-9]+$/", $form_val) ) :
                                $data[] = array( 'status' => 'error', 'field_key' => $form_key, 'message' => esc_html__( 'Voer het nummer in.', 'kunstuitleen-company-crm' ) );
                                $error = 1;
                            elseif( !preg_match("/^[0-9]{10}$/",  $form_val) ) :
                                $data[] = array( 'status' => 'error', 'field_key' => $form_key, 'message' => esc_html__( 'Voer een 10-cijferig nummer in.', 'kunstuitleen-company-crm' ) );
                                $error = 1;
                            else :
                                $data[] = array( 'status' => 'success', 'field_key' => $form_key, 'message' => '' );
                            endif;                                                     
                        break;
                        case 'reg_email':
                        //case 'reg_con_email': 
                            if( !is_email( $form_val ) ) :
                                $data[] = array( 'status' => 'error', 'field_key' => $form_key, 'message' => esc_html__( 'Vul alstublieft een geldig e-mailadres in.', 'kunstuitleen-company-crm' ) );
                                $error = 1;                                
                            elseif( email_exists( $form_val ) && empty( $extra ) ) :
                                $data[] = array( 'status' => 'error', 'field_key' => $form_key, 'message' => esc_html__( 'Email is al in gebruik.', 'kunstuitleen-company-crm' ) );
                                $error = 1;
                            elseif( is_email( $form_val ) ) :
                                $data[] = array( 'status' => 'success', 'field_key' => $form_key, 'message' => '' );
                            endif;                           
                        break;                  
                    endswitch;
                elseif( in_array( $form_key, $all_fileds ) && empty( $form_val ) ) :
                    switch( $form_key ) :
                        case 'reg_fname': 
                                $data[] = array( 'status' => 'error', 'field_key' => $form_key, 'message' => esc_html__( 'Vul a.u.b. de voornaam in.', 'kunstuitleen-company-crm' ) );
                                $error = 1;
                        break;
                        case 'reg_lname': 
                                $data[] = array( 'status' => 'error', 'field_key' => $form_key, 'message' => esc_html__( 'Vul a.u.b. achternaam in.', 'kunstuitleen-company-crm' ) );
                                $error = 1;
                        break;
                        case 'reg_phone': 
                                $data[] = array( 'status' => 'error', 'field_key' => $form_key, 'message' => esc_html__( 'Voer het telefoonnummer in.', 'kunstuitleen-company-crm' ) );
                                $error = 1;
                        break;
                        /*case 'reg_department': 
                                $data[] = array( 'status' => 'error', 'field_key' => $form_key, 'message' => esc_html__( 'Please enter last name.', 'kunstuitleen-company-crm' ) );
                                $error = 1;
                        break;*/
                        case 'reg_email': 
                                $data[] = array( 'status' => 'error', 'field_key' => $form_key, 'message' => esc_html__( 'Voer e-mailadres in.', 'kunstuitleen-company-crm' ) );
                                $error = 1;
                        break; 
                        //case 'reg_con_email': 
                                $data[] = array( 'status' => 'error', 'field_key' => $form_key, 'message' => esc_html__( 'Voer het bevestigingse-mailadres in.', 'kunstuitleen-company-crm' ) );
                                $error = 1;
                        break;
                        case 'reg_search_value': 
                                $data[] = array( 'status' => 'error', 'field_key' => $form_key, 'message' => esc_html__( 'Selecteer een waarde.', 'kunstuitleen-company-crm' ) );
                                $error = 1;
                        break;
                    endswitch;
                endif;    
            endforeach;
            if( $error == 1 ) :
                $output = $data;
            endif;
        endif;
        return $output;
    }

    /**
     * Register validations
     */
    public function company_validation($args)
    {
        if (empty($this->phone) || empty($this->email) || empty($this->confirm_email) || empty($this->first_name) || empty($this->last_name))
        {

            return new WP_Error('informatie_field', 'Vereiste informatie ontbreekt');

        }
        if (!preg_match("/^[0-9]{10}$/", $this->phone))
        {
            return new WP_Error('phone_validation', 'Telefoonnummer is niet geldig');
        }
        if (!is_email($this->email))
        {
            return new WP_Error('email_invalid', 'Email is niet geldig');
        }
        if (!is_email($this->confirm_email))
        {
            return new WP_Error('confirm_email_invalid', 'Bevestig e-mail is niet geldig');
        }
        if (($this->email) != ($this->confirm_email))
        {
            return new WP_Error('email_match_invalid', 'E-mail en bevestig e-mail komen niet overeen');
        }

        if (email_exists($this->email) && empty($args['user_myaccount_update']))
        {
            return new WP_Error('email', 'Email is al in gebruik');
        }

        if (strlen($this->password) < 8)
        {
            return new WP_Error('password', 'Wachtwoordlengte moet groter zijn dan 8.');
        }
    }
}

/**
 * Kucrm get users by company
 */
function kucrm_get_users_by_company($company_id = 0)
{
    $args = array(
        'meta_query' => array(
            'relation' => 'OR',
            array(
                'key' => 'user_parent',
                'value' => $company_id,
                'compare' => '='
            )
        )
    );
    $user_query = new WP_User_Query($args);
    $users_all_data = array();
    if (!empty($user_query->get_results()))
    {
        foreach ($user_query->get_results() as $user)
        {
            $department = get_user_meta($user->id, 'department', true);
            $search_value = get_user_meta($user->id, 'search_value', true);
            $users_all_data[] = array(
                'id' => $user->id,
                'email' => $user->user_email,
                'full_name' =>$user->first_name . ' ' .$user->last_name,
                'user_status' => $user->user_status,
                'department' => $department,
                'search_value' => $search_value,
                'roles' => $user->roles,
            );
        }

    }
    return $users_all_data;
}
function kucrm_createFilter($filter, $single, $exclude = [], $selected = '') {       
    $createFilter = '<select id="reg_search_value" name="' . $filter . '[]"  multiple="multiple">';
    $filteritems = get_terms( $single, array( 'hide_empty' => false, 'exclude' => $exclude ) );
    //$createFilter .= '<option value="">' . esc_html__( 'Kies een ' ) . esc_html( $single ) . '</option>';   
    if( !empty( $filteritems ) ) : 
        foreach ($filteritems as $filteritem ) :        
            if( is_array( $selected ) && in_array( $filteritem->term_id, $selected ) ) :
                $createFilter .= '<option value="' . $filteritem->term_id . '" selected="selected">' . $filteritem->name . '</option>';
            else:
                $createFilter .= '<option value="' . $filteritem->term_id . '">' . $filteritem->name . '</option>';
            endif;
        endforeach;
    endif;
    $createFilter .= '</select>';

    echo $createFilter;
}
?>
