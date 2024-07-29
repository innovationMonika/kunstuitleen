<?php
    
/*
add_filter('frm_email_value', 'frm_email_val', 15, 3);
    function frm_email_val($value, $meta, $entry){
        if($meta->field_id == 72){ // Werk
            
            $organisatie = $_POST['item_meta'][76];
            $uniekecode = $_POST['item_meta'][71];
            
            $filename = str_replace(' ', '_', strtolower($organisatie));
            $filename = preg_replace('/[^A-Za-z0-9\-\_]/', '', $filename).'_'.$uniekecode;
                   
            $value = get_bloginfo('template_url').'/'.'offertes/'.$filename.'.pdf'; //change the value here
            //$value = 'PDF komt hier...';
        }
        
        if($meta->field_id == 93){ // Thuis
            
            $organisatie = $_POST['item_meta'][99];
            $uniekecode = $_POST['item_meta'][92];
            
            $filename = str_replace(' ', '_', strtolower($organisatie));
            $filename = preg_replace('/[^A-Za-z0-9\-\_]/', '', $filename).'_'.$uniekecode;
             
            $value = get_bloginfo('template_url').'/'.'offertes/'.$filename.'.pdf'; //change the value here
            //$value = 'PDF komt hier...';
        }
      return $value;
    }
*/

// Kunst kadobon: persoonlijk bericht
add_filter('frm_validate_field_entry', 'my_custom_validation', 10, 3);
    function my_custom_validation($errors, $posted_field, $posted_value){
        
        if ( $posted_field->id == 148 && $posted_value != '' ){ //change 25 to the ID of the field to validate
            
            //check the $posted_value here
            $words = explode(' ', $posted_value); //separate at each space
            $count = count($words); //count each word
            // $count = strlen($posted_value); //uncomment this line to count characters instead of words
            //
            //uncomment the next two lines create a minimum value and error message
            //if($count < 100) //change "100" to fit your minimum limit //$errors['field'. $posted_field->id] = 'That is not long enough.';
            		
            //comment the next two lines if you only want a minimum value and error message
            if($count > 200) //change "300" to fit your maximum limit
               $errors['field'. $posted_field->id] = 'Persoonlijk bericht is te lang.';
    
        }
        return $errors;
    }

add_filter('frm_redirect_url', 'frm_redirect_url', 9, 3);
function frm_redirect_url($url, $form, $params){
    
    if($form->id == 6):
        $url = get_permalink(69574) . '?entry_id=' . $_POST['item_key'] . '&email=' . $_POST['item_meta']['78'];
    elseif($form->id == 9):
        $url = get_permalink(122297) . '?entry_id=' . $_POST['item_key'] . '&email=' . $_POST['item_meta']['102'];
    elseif($form->id == 12):
        $url = get_permalink(285816) . '?entry_id=' . $_POST['item_key'] . '&email=' . $_POST['item_meta']['121'];
    endif;
    
    return $url;
}

add_filter('frm_validate_field_entry', 'require_minimum_checkbox_number', 10, 3);
    function require_minimum_checkbox_number( $errors, $field, $posted_value ){
      if ( $field->id == 122 ) {
        
        $client_code = $_POST['item_meta']['123'];
        //$client_id = $_POST['item_meta']['124'];
        $cookie_name = 'favorieten-preselect-'.$client_code;
        $cookie = $_COOKIE[$cookie_name]; $cookie = stripslashes($cookie); $favorieten = json_decode($cookie, true);
        
        
        $already_chosen = false;
        $selection_already_chosen = array();
        
        foreach($favorieten as $key => $selectie):
            if( get_field('preselect_art_already_chosen', $selectie) == 'true' ):
                $already_chosen = true;
                $selection_already_chosen[] = '<li>'.get_the_title($selectie).' - '.get_field('art_kunstenaar_name', $selectie).'</li>';
                
                unset($favorieten[$key]);
                
            endif;
        endforeach;
        
        if( $already_chosen == true || empty($favorieten) ):
            
            // Change cookie selection
            setcookie($cookie_name, json_encode($favorieten), time()+3600*24*30, '/');
            
            $error_message = '<div class="preselect-error">';
            if( $already_chosen == true ): 
                $error_message .= 'De volgende kunstwerken zijn verwijderd uit de selectie omdat deze al zijn gereserveerd door een collega: <br/>';
                $error_message .= '<ul>'.join('', $selection_already_chosen).'</ul>';
            endif;
            if( empty($favorieten) ): 
                $error_message .= '<strong>Er zijn geen kunstwerken '.( $already_chosen == true ? 'meer ' : '').'binnen de selectie.<br/><a href="' . get_permalink(285780) . '">Ga terug naar het overzicht</a>.</strong>';    
            endif;
            $error_message .= '</div>';
            
            $errors['field' . $field->id] = $error_message;
        endif; 
      }
      return $errors;
    }


add_filter('frm_pre_create_entry', 'add_favorites_pdf_to_entry');
function add_favorites_pdf_to_entry($values){
  
    if ( $values['form_id'] == 6 ) { //change 5 to your form id
        
        $organisatie = $values['item_meta'][76];
        $unieke_code = $values['item_meta'][71];
        
        //$filename = str_replace(' ', '_', strtolower($organisatie));
        //$filename = preg_replace('/[^A-Za-z0-9\-\_]/', '', $filename).'_'.$unieke_code;
        $file_name = sanitize_title($organisatie).'_'.$unieke_code;
               
        $pdf_url = wp_upload_dir()['baseurl'].'/'.'offertes/'.date('Y').'/'.date('m').'/'.$file_name.'.pdf'; //change the value here
        
        $values['item_meta'][72] = $pdf_url;

    }
    
    if ( $values['form_id'] == 9 ) { //change 5 to your form id
        
        $organisatie = $values['item_meta'][99];
        $unieke_code = $values['item_meta'][92];
        
        //$filename = str_replace(' ', '_', strtolower($organisatie));
        //$filename = preg_replace('/[^A-Za-z0-9\-\_]/', '', $filename).'_'.$unieke_code;
        $file_name = sanitize_title($organisatie).'_'.$unieke_code;
               
        $pdf_url = wp_upload_dir()['baseurl'].'/'.'offertes/'.date('Y').'/'.date('m').'/'.$file_name.'.pdf'; //change the value here
        
        $values['item_meta'][93] = $pdf_url;
        

    }
    
    if ( $values['form_id'] == 12 ) { //change 5 to your form id
        
        $client_code = $values['item_meta'][123];
        $client_id = $values['item_meta'][124];
        $client_name = get_field('preselect_client_name', $client_code);
        $organisatie = $client_name;
        $unieke_code = $values['item_meta'][92];
        
        $file_name = sanitize_title($organisatie).'_'.$unieke_code;
               
        $pdf_url = wp_upload_dir()['baseurl'].'/'.'offertes/'.date('Y').'/'.date('m').'/'.$file_name.'.pdf'; //change the value here
        
        $values['item_meta'][115] = $pdf_url;
        
        /* CHANGE COLLECTION STATUS AND REMOVE COOKIE */
            // Get the selection from cookie
            $cookie_name = 'favorieten-preselect-'.$client_code;
            $cookie = $_COOKIE[$cookie_name]; $cookie = stripslashes($cookie); $favorieten = json_decode($cookie, true);
            
            // Foreach selection, set the already_chosen meta true
            foreach( $favorieten as $selectie ):
                update_post_meta( $selectie, 'preselect_art_already_chosen', 'true' ); 
            endforeach;
            
        /*  Remove the cookie */
        setcookie($cookie_name, '', time()+3600*24*30, '/');  
        
        /* UPDATE CLIENT ( CLIENT_ID/CLIENT_CODE ) */
            $entry_values = array(
                //'preselect_entry_id' => $values['entry_id'],
                'preselect_entry_name' => $values['item_meta'][117].' '.$values['item_meta'][118],
                'preselect_entry_email' => $values['item_meta'][121],
                'preselect_entry_kamernr' => $values['item_meta'][119],
                'preselect_entry_etagenr' => $values['item_meta'][120],
                'preselect_entry_opmerkingen' => $values['item_meta'][122],
                'preselect_entry_selection' => $favorieten,
            );
            
            add_row( 'preselect_entry', $entry_values, $client_id );
        
        
        
    }
    
    if ( $values['form_id'] == 17 ) { //change 5 to your form id
        
        $bonnummer_prefix = get_field('kadobon_bonnummer_prefix', 'option');
        $bonnummer_nummer = ( !empty(get_field('kadobon_bonnummer_nummer', 'option')) ? intval(get_field('kadobon_bonnummer_nummer', 'option')) : 0) + 1;
            
            // Update entry field: bonnummer
            $values['item_meta'][150] = $bonnummer_prefix . $bonnummer_nummer;
            
            // Update ACF theme option: kadobon_bonnummer_nummer
            update_field('kadobon_bonnummer_nummer', $bonnummer_nummer, 'option');        
                   
    }
    
    return $values;
}


/****** CREATE PDF BASED ON FIELDS AND SEND AS ATTACHMENT ******/
add_filter('frm_notification_attachment', 'add_my_attachment', 30, 3);
    function add_my_attachment($attachments, $form, $args){

        /*
         *  Proefplaatsing PDF's
         */

        $email_keys = [
            123589, // Thuis: Klant
            123590, // Thuis: Kunstuitleen
            123587, // Werk: Klant
            123585, // Werk: Kunstuitleen
            285811, // Werk: Voorselectie - Kunstuitleen
        ];

        //$args['entry'] includes the entry object
        if ( in_array($args['email_key'], $email_keys) ){

            // Vars
            $cookieWebVariant = get_web_variant();

            if( $cookieWebVariant == 'werk' || $args['email_key'] == 285811 ): // Werk
                $emailaddress = get_field( "contact_email", 'option' );
                $organisatieOrWoonplaats = 'Organisatie';
            else: // thuis
                $emailaddress = get_field( "contact_email_thuis", 'option' );
                $organisatieOrWoonplaats = 'Woonplaats';
            endif;
            
            $post_type = 'collectie';
            
            if ( $args['email_key'] == 123589 || $args['email_key'] == 123590 ){ // Thuis
        
                $voornaam = $_POST['item_meta'][95];
                $achternaam = $_POST['item_meta'][96];
                $organisatie = $_POST['item_meta'][99]; // Woonplaats
                $telefoonnummer = $_POST['item_meta'][101];
                $email = $_POST['item_meta'][102];
                $bericht = $_POST['item_meta'][103];
                
                $uniekecode = $_POST['item_meta'][92];
                
                $footer_client_contact_labels = 'Naam:<br/>'.$organisatieOrWoonplaats.':<br/>Telefoonnummer:<br/>E-mailadres:';
                $footer_client_contact_data = $voornaam.' '.$achternaam.'<br/>'.$organisatie.'<br/>'.$telefoonnummer.'<br/>'.$email;
            }
            
            if ( $args['email_key'] == 123587 || $args['email_key'] == 123585 ){ // Werk
        
                $voornaam = $_POST['item_meta'][74];
                $achternaam = $_POST['item_meta'][75];
                $organisatie = $_POST['item_meta'][76];
                $telefoonnummer = $_POST['item_meta'][77];
                $email = $_POST['item_meta'][78];
                $bericht = $_POST['item_meta'][79];
                
                $uniekecode = $_POST['item_meta'][71];
                
                $footer_client_contact_labels = 'Naam:<br/>'.$organisatieOrWoonplaats.':<br/>Telefoonnummer:<br/>E-mailadres:';
                $footer_client_contact_data = $voornaam.' '.$achternaam.'<br/>'.$organisatie.'<br/>'.$telefoonnummer.'<br/>'.$email;
            }

            if ( $args['email_key'] == 285811 ){ // Werk: Voorselectie
                
                $post_type = 'preselect_collection';
                
                $voornaam = $_POST['item_meta'][117];
                $achternaam = $_POST['item_meta'][118];
                $email = $_POST['item_meta'][121];
        
                $kamer_nr = $_POST['item_meta'][119];
                $etage_nr = $_POST['item_meta'][120];
                
                $bericht = $_POST['item_meta'][122];
                
                $uniekecode = $_POST['item_meta'][114];
                $client_code = $_POST['item_meta'][123];
                $client_id = $_POST['item_meta'][124];
                
                $client_name = get_field('preselect_client_name', $client_id);
                $organisatie = $client_name;
                
                $footer_client_contact_labels = 'Naam:<br/>Bedrijf:<br/>E-mailadres:<br/>Kamer-nr:<br/>Etage-nr:';
                $footer_client_contact_data = $voornaam.' '.$achternaam.'<br/>'.$client_name.'<br/>'.$email.'<br/>'.$kamer_nr.'<br/>'.$etage_nr;
                
            }
            
            // Get all Price Values as letters
            $waardes = get_terms('waarde', array('hide_empty' => false));
            foreach($waardes as $waarde){
                ${'waarde_'.$waarde->slug} = 0;
            }
            
            //For each favorite art, check the Price Value and update it with +1
            if( $args['email_key'] == 285811 ): $cookie_name = 'favorieten-preselect-'.$client_code; else: $cookie_name = 'favorieten'.$cookieWebVariant; endif;
            $cookie = $_COOKIE[$cookie_name]; $cookie = stripslashes($cookie); $favorieten = json_decode($cookie, true);
            foreach($favorieten as $favoriet){
                $favWaarde = get_the_terms($favoriet, 'waarde');
                ${'waarde_'.$favWaarde[0]->slug}++;
            }
            
            // Include the template - HTML   
            $filename = sanitize_title($organisatie).'_'.$uniekecode;
            $file_location = wp_upload_dir()['basedir'] . '/offertes/'.date('Y').'/'.date('m').'/'.$filename.'.pdf';
            
            if( file_exists($file_location) ){
                
                $attachments[] = $file_location;
            } else {
                
                require_once ABSPATH . '/vendor/autoload.php';
                
                ob_start();
                    include( locate_template( 'inc/functions/formidable/pdf-favorites.php', false, false ));        
                    $html = ob_get_clean(); // gets content, discards buffer
                ob_end_clean();
                
                
                $mpdf = new \Mpdf\Mpdf();
                
                $mpdf->SetTitle("Kunstuitleen - Favorieten");
                $mpdf->SetAuthor("Kunstuitleen");
                $mpdf->SetDisplayMode('fullpage');
                
                $mpdf->WriteHTML($html);
                
                $mpdf->SetHTMLFooter('<div style="background-color:#000;color:#FFF;font-size: 9pt; text-align: center; padding: 5mm; ">
                    <div style="border-bottom:1px solid #FFF;padding-bottom:5mm;">
                        <table width="100%">
                            <tr>
                                <td colspan="3" style="color:#FFF;font-size:26pt;font-family:Palatino, serif;text-transform:uppercase;">
                                    Uw gegevens
                                </td>
                            </tr>
                            <tr>
                                <td style="color:#FFF;font-style:italic;line-height:12pt;" width="20%">
                                    '.$footer_client_contact_labels.'
                                </td>
                                <td style="color:#FFF;line-height:12pt;" width="30%">
                                    '.$footer_client_contact_data.'
                                </td>
                                <td style="color:#FFF;line-height:12pt;" width="50%">
                                    <span style="font-style:italic;">Bericht:</span><br/>'.$test.substr($bericht,0,185).'...
                                </td>
                            </tr>
                        </table>
                    </div><br/>
                    KUNSTUITLEEN.NL  |  Donauweg 23  |  1043 AJ Amsterdam  |  +31 (0) 20 624 11 24  |  ' . $emailaddress . '
                </div>');
                
                // Create date ( year/month ) folders inside wp-content/uploads/offertes
                if ( wp_mkdir_p( wp_upload_dir()['basedir'] . '/offertes/'.date('Y').'/'.date('m') ) ):
                    $mpdf->Output( wp_upload_dir()['basedir'] . '/offertes/'.date('Y').'/'.date('m').'/'.$filename.'.pdf' ,'F'); //SAVE TO SERVER
                    $attachments[] = wp_upload_dir()['basedir'] . '/offertes/'.date('Y').'/'.date('m').'/'.$filename.'.pdf'; //set the ABSOLUTE path to the image here
                endif;
            }
            
        }
        
        /*
         * Thuis: Kunst kadobon
         */
         
        if ( $args['email_key'] == 536811 || $args['email_key'] == 536813 ) {
            
            $entry = $args['entry']->metas;
                
            $kadobon = [
                'web_variant' => $entry[159],
                'bonnummer' => $entry[150],
                'end_date'  => date('j F Y', strtotime('+1 year')),
                'price'     => intval($entry[144]),
                'message'   => apply_filters('the_content', $entry[148]),
                'filename'  => 'kunstuitleen-kadobon-' . $entry[150]
            ];
            
            
            $file_location = wp_upload_dir()['basedir'] . '/kadobon/'.date('Y').'/'.date('m').'/'.$kadobon['filename'].'.pdf';
            
            if( file_exists($file_location) ){
                
                $attachments[] = $file_location;
            } else {
            
                //require_once ABSPATH . '/vendor/autoload.php';
                require_once ABSPATH . '/vendor/autoload.php';
                
                // Custom Vars
                $path = ABSPATH;
                $url = get_bloginfo('url');
                //$url = 'https://kunstuitleen-test.wp3.go2people.nl/';
                
                $customFontDir = $path . 'wp-content/themes/kunstuitleen/inc/functions/formidable/fonts/';

                // MPDF Vars
                $defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
                $fontDirs = $defaultConfig['fontDir'];
                
                $defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
                $fontData = $defaultFontConfig['fontdata'];
                
                $mpdf = new \Mpdf\Mpdf([
                    'mode' => 'utf-8', 
                    'format' => 'A4-L',
                    'fontDir' => array_merge($fontDirs, [ $customFontDir ]),
                    'fontdata' => $fontData + [
                        'mrjonesbook' => [
                            'R' => 'MrJonesBook.ttf',
                            'I' => 'MrJonesBookItalic.ttf',
                        ],
                        'nikaia' => [
                            'R' => 'Nikaia.ttf',
                            'I' => 'Nikaiaitalic.ttf',
                        ]
                    ],
                    'default_font' => 'mrjonesbook'
                ]);
                
                $mpdf->AddFontDirectory($customFontDir);
                
                $mpdf->SetTitle("Kunstuitleen - Kunst kadobon");
                $mpdf->SetAuthor("Kunstuitleen");
                $mpdf->SetDisplayMode('fullpage');
                
                ob_start();
                    //include( locate_template( 'inc/functions/formidable/pdf-kadobon.php', false, false ));        
                    include( locate_template( 'inc/functions/formidable/pdf-kadobon.php', false, false ) );
                    $html = ob_get_clean(); // gets content, discards buffer
                ob_end_clean();
                
                $mpdf->WriteHTML($html);
                
                // Create date ( year/month ) folders inside wp-content/uploads/offertes
                if ( wp_mkdir_p( wp_upload_dir()['basedir'] . '/kadobon/'.date('Y').'/'.date('m') ) ):
                    $mpdf->Output( $file_location ,'F'); //SAVE TO SERVER
                    $attachments[] = $file_location; //set the ABSOLUTE path to the image here
                endif;
            
            }
            
        }
    
        return $attachments;
    }


add_filter('frm_get_default_value', function( $new_value, $field, $is_default ) {


    if ( $field->id == 159 && $is_default ) { //change 25 to the ID of the field

        // Vars
        $new_value = get_web_variant();
    }

    return $new_value;
}, 10, 3);



?>