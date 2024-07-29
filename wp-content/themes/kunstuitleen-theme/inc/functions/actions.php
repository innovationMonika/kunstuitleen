<?php

/*
 * Web variant
 * Options: Thuis/Werk
 */
 
function safe_get( $var ){
    if(isset($_GET) && isset($_GET[$var]) && !empty($_GET[$var])){
        return esc_html( $_GET[$var] );
    }
}

function safe_request( $var ){
    if(isset($_REQUEST)){
    return esc_html( $_REQUEST[$var] );
    }
}
 
function get_web_variant(){
    if(isset($_COOKIE)){
    return esc_html($_COOKIE['kunstuitleenVariant']);
    }
}

function get_cookie_value( $var ){
    
    $cookie_decoded = '';
    if(isset($_COOKIE) && isset($_COOKIE[$var])){
        $cookie             = $_COOKIE[$var]; 
        $cookie_stripped    = stripslashes($cookie);
        $cookie_decoded     = json_decode($cookie_stripped, true);
    }              
    return $cookie_decoded;
}

function getPostParent(){
    global $post;
    
    if( $post->post_parent ):
    	$ancestors=get_post_ancestors($post->ID);
    	$root=count($ancestors)-1;
    	$parent = $ancestors[$root];
    else:
    	$parent = $post->ID;
    endif;
    
    return $parent;
}

add_action( 'wp', 'set_web_variant' );

    function set_web_variant() {
        
        global $post;
        
        $parent = getPostParent();
        
        $cookieWebVariant = get_web_variant();
        $webVariant = basename(get_permalink($parent));
        
        if( !$cookieWebVariant ):
            
            if( !empty( $_GET['contractnr'] ) ):
                $webVariant = 'werk';
            else:
                $webVariant = 'thuis';
            endif;
        endif;
        
        $webVariant = ( $webVariant === preg_replace('#^https?://#', '', get_bloginfo('url')) ? 'thuis' : $webVariant );
         
        if( $webVariant == 'thuis' || $webVariant == 'werk' ){   
            if( $webVariant != $cookieWebVariant){
    
                setcookie("kunstuitleenVariant", $webVariant, time()+3600*24*365, '/');
                
                if( !empty( $_SERVER['QUERY_STRING'] ) ): 
                    wp_redirect( get_permalink( $post->ID).'?'.$_SERVER['QUERY_STRING'] );
                else:
                    wp_redirect( get_permalink($post->ID) );
                endif;
                
                exit;
            }
        } 
    } 


function is_landingspage(){
    
    if( get_the_ID() == 285816 || 
        get_the_ID() == 285791 ||
        is_singular( 'preselect_collection' ) || 
        is_page_template( 'page-templates/page-collectie-voorselectie.php' ) || 
        is_page_template( 'page-templates/page-favorieten-voorselectie.php' ) || 
        is_page_template( 'page-templates/page-favorieten-bevestigen-voorselectie.php' )
    ){
        return true;
    }
    
    return false;
    
}

function get_favorieten(){
    
    $cookieWebVariant = get_web_variant();
    
    if( 
        is_singular( 'preselect_collection' ) || 
        is_page_template( 'page-templates/page-collectie-voorselectie.php' ) ||  
        is_page_template( 'page-templates/page-favorieten-voorselectie.php' ) || 
        is_page_template( 'page-templates/page-favorieten-bevestigen-voorselectie.php' ) 
    ){
        $preselect_client = get_preselect_client();
        $cookie = $_COOKIE['favorieten-preselect-'.$preselect_client['client_code']];
        $cookie = stripslashes($cookie); 
        $favorieten = json_decode($cookie, true);
    } else {
        if(isset($_COOKIE['favorieten'.$cookieWebVariant]) && !empty($_COOKIE['favorieten'.$cookieWebVariant])){
            $cookie = $_COOKIE['favorieten'.$cookieWebVariant]; 
            $cookie = stripslashes($cookie); 
            $favorieten = json_decode($cookie, true); 
        }
    }
    
    if( !empty($favorieten) ){
        return $favorieten;    
    } else {
        return [];
    }
    
    
}

/*
 *  Art filters
 */
 
function createFilter($filter, $single, $exclude = []) { 

    $createFilter = '<select name="' . $filter . '" class="custom_term">';
        $createFilter .= '<option value="">Kies een ' . $single . '</option>';
        
     //   $filteritems = get_terms($single, array('hide_empty' => false, 'exclude' => $exclude));
        $filteritems = get_terms( array(
            'taxonomy' => $single,
            'hide_empty' => false,
            'exclude' => $exclude
        ) );
        foreach($filteritems as $filteritem):
            if( isset($_GET[$filter]) && $filteritem->slug == $_GET[$filter] ):
                $createFilter .= '<option value="' . $filteritem->slug . '" selected="selected">' . $filteritem->name . '</option>';
            else:
                $createFilter .= '<option value="' . $filteritem->slug . '">' . $filteritem->name . '</option>';
            endif;
        endforeach;
        
    $createFilter .= '</select>';
    
    echo $createFilter;
}

function createFilterPreselect($filter, $single, $filter_id) { 

    $createFilter = '<select name="' . $filter . '">';
        $createFilter .= '<option value="">Kies een ' . $single . '</option>';
        
        $filteritems = get_the_terms( $filter_id, $single );
        //$filteritems = get_terms($single, array('hide_empty' => false);
        foreach($filteritems as $filteritem):
            if( $filteritem->slug == $_GET[$filter] ):
                $createFilter .= '<option value="' . $filteritem->slug . '" selected="selected">' . $filteritem->name . '</option>';
            else:
                $createFilter .= '<option value="' . $filteritem->slug . '">' . $filteritem->name . '</option>';
            endif;
        endforeach;
        
    $createFilter .= '</select>';
    
    echo $createFilter;
}

    
add_action( 'wp_mail_failed', 'onMailError', 10, 1 );
function onMailError( $wp_error ) {
    error_log('<pre>'.print_r($wp_error,true).'</pre>');
} 



/* 
 * VOORSELECTIE 
 * (preselect)
 */

function get_preselect_client(){
    
    if( is_landingspage() ){
            
        $preselect_contract_nr = $_COOKIE['werk-klant-contractnr'];
        $preselect_client = get_page_by_title($preselect_contract_nr, 'OBJECT', 'preselect_customer');
        return array('client_code' => $preselect_contract_nr, 'client_id' => $preselect_client->ID);
    }
    
    return false;
    
}


add_action( 'delete_connected_preselect_art', 'delete_preselect_art', 10, 1 );
    function delete_preselect_art( $deleted_post_id ) {
        
        if( empty($deleted_post_id)):
            die('No deleted Post ID given.');
        endif;
        
        error_log(' -- Started: deleting preselect_art for client id: ' . $deleted_post_id . ' -- ');

        // Get connected preselect_art and remove it
        $args = array( 
            'post_type' => 'preselect_collection', 
            'posts_per_page' => '-1',
            'meta_query' => array(
        	'relation' => 'OR', // Optional, defaults to "AND"
            	array(
            		'key'     => 'preselect_art_customer',
            		'value'   => $deleted_post_id,
            		'compare' => 'LIKE'
            	)
        	)
        );
         
        $connected_preselect_art = get_posts( $args );
      
        foreach( $connected_preselect_art as $delete_preselect_art ):
            wp_delete_post( $delete_preselect_art->ID, true );
        endforeach;
        
        error_log(' -- Done: deleting preselect_art for client id: ' . $deleted_post_id . ' -- ');
    }


add_action( 'wp_trash_post', 'before_delete_preselect_client' );
    function before_delete_preselect_client( $post_id ){
        
        // We check if the global post type isn't ours and just return
        global $post_type;   
        
        if ( $post_type != 'preselect_customer' ) return;
        
        error_log(' -- Scheduled: delete preselect_art for client id: ' . get_the_title($post_id) . ' with post id: ' . $post_id . ' -- ');
        wp_schedule_single_event( time(), 'delete_connected_preselect_art', array( $post_id ) );
    }


add_action( 'sync_client', 'sync_preselection_client', 10, 3 );
    function sync_preselection_client( $client_code, $client_id, $post_url ) {
        
        if( empty($client_code) ):
            die('Geen klantcode gedefineerd!');
        endif;
        
        include_once( ABSPATH . 'sync-cli/sync-preselection-client.php' );
        include_once( ABSPATH . 'sync-cli/sync-classes.php' );
        
        $client = new sync_preselection_client($client_code);
        $sync_client_data = $client->sync_client_data();
        $sync_client_data = $client->sync_preselection_art();
    
        // SEND EMAIL
        $to = 'rosa@kunstuitleen.nl';
        $headers[] = 'From: Kunstuitleen <niels@go2people.nl>';
        //$headers[] = 'Cc: Niels Lust <niels@go2people.nl>';
        //$headers[] = 'Cc: iluvwp@wordpress.org'; // note you can just use a simple email address
        $headers[] = 'Content-Type: text/html; charset=UTF-8';
        
    	$subject = 'Voorselectie klant: ' . $client_code . ' is gesynchroniseerd';
    	
    	$message = 'Beste Rosa,<br/><br/>';
    	$message .= 'De synchronisatie voor contractnr: ' . $client_code . ' is zojuist ( '.date_i18n('d/m/Y h:i:s a', time()).' ) afgerond. <br/>';
    	$message .= 'CLIENT ID: '.$client_code.': ' . $post_url . '<br/><br/>';
    	$message .= 'Kunstuitleen - Go2People';
    	// TODO $message: voorselectie url + parameters client_code
    	
    	// Actually Send the email
    	wp_mail( $to, $subject, $message, $headers);
    }

add_action( 'save_post', 'preselect_customer_sync_on_save' );
    function preselect_customer_sync_on_save( $post_id ) {
    
    	// If this is just a revision, don't send the email.
    	if ( wp_is_post_revision( $post_id ) )
    		return;
        
        if ( get_post_type() != 'preselect_customer' )
            return;
            
        $client_code = get_the_title( $post_id );
        $post_url = get_permalink( 285780 ).'?contractnr='.$client_code;
        //https://kunstuitleen.wp3.go2people.nl/werk/collecties/voorselectie/?contractnr=1546
        
        // Set up a single scheduled event
        wp_schedule_single_event( time() + 1*60, 'sync_client', array( $client_code, $post_id, $post_url ) );
    	
    }



add_action( 'wp', 'set_voorselectie_contractnr' );

    function set_voorselectie_contractnr() {
        
        global $post;
        
    if( is_page_template( 'page-templates/page-collectie-voorselectie.php' ) || is_singular( 'preselect_collection' ) || is_page_template( 'page-templates/page-favorieten-voorselectie.php' ) || is_page_template( 'page-templates/page-favorieten-bevestigen-voorselectie.php' ) ):

            $preselect_client = get_preselect_client();
            
            if( !empty($preselect_client) && $preselect_client['client_id'] != '' && empty( $_GET['contractnr'] ) ): //If cookie is found retrieve the end date field && contactnr parameter is empty
            
                $cookie = $_COOKIE['favorieten-preselect-'.$preselect_client['client_code']];
                $cookie = stripslashes($cookie); 
                $favorieten = json_decode($cookie, true);
                
                if( get_field('preselect_client_enddate', $preselect_client['client_id']) < date('Ymd') ): //Redirect to "ended page" if end date is reached
                
                    wp_redirect( get_permalink(285791) );
                    exit;
                    
                endif;
                
                if( !empty( $_GET['contractnr'] ) ): //If cookie is found and the parameter is still visible, redirect to "Voorselectie" page so the parameter disappears
                
                    wp_redirect( get_permalink($post->ID) ); 
                    exit;
                    
                endif;
            
            else:
            
                if( !empty( $_GET['contractnr'] ) ): //No cookie found but checks for the parameter and sets the client code cookie if found
                    
                    setcookie("werk-klant-contractnr", $_GET['contractnr'], 0, '/');
                    wp_redirect( get_permalink($post->ID) );
                    exit;
                    
                else: //No cookie and parameter found, redirect to portal screen
                    
                    wp_redirect( get_permalink(2) );
                    exit;
                    
                endif;
                
            endif;
            
        endif;
        
        /* Old code from Niels
        if( !empty($_GET['contractnr']) && is_page_template( 'page-templates/page-collectie-voorselectie.php' ) ):
            setcookie("werk-klant-contractnr", $_GET['contractnr'], 0, '/');
            wp_redirect( get_permalink($post->ID) ); exit;
        endif;
        */
    }
    
/* END: VOORSELECTIE */

// Sidebar / Widgets
add_action( 'widgets_init', 'gotopeople_widgets_init' );
    function gotopeople_widgets_init() {
    
    	register_sidebar( array(
    		'name' => __( 'Main Sidebar', 'gotopeople' ),
    		'id' => 'sidebar-1',
    		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    		'after_widget' => "</aside>",
    		'before_title' => '<h3 class="widget-title">',
    		'after_title' => '</h3>',
    	) );
    
    }

function adtraction_hash($source_address) {

    // convert address to lower case
    $processed_address = strtolower($source_address);

    // trimming leading and trailing spaces
    $processed_address = trim($processed_address);

    // conversion from ISO-8859-1 to UTF-8 (replace "ISO-8859-1" with the source encoding of your string)
    $processed_address = mb_convert_encoding($processed_address, "UTF-8", "ISO-8859-1");
    
    // hash address with MD5 algorithm 
    $processed_address = md5($processed_address);
    
    return $processed_address;
}

add_filter( 'pre_get_posts', 'collectie_cpt_search' );
/**
 * This function modifies the main WordPress query to include an array of
 * post types instead of the default 'post' post type.
 *
 * @param object $query  The original query.
 * @return object $query The amended query.
 */
function collectie_cpt_search( $query ) {

    if ( $query->is_search ) {
        $query->set( 'post_type', array( 'collectie' ) );
    }

    return $query;

}