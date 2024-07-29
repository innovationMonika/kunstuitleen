<?php

// E-act ( Autorespond )
add_shortcode( 'autorespond', 'autorespond_shortcode' );
    function autorespond_shortcode( $atts ){
        
        $eact = '';
        
        switch ($atts['form']) {
            case 364: //Lijstmanager 'Particulier_online inschrijvers_2016'
                $eact = '<form method="post" target="_blank" action="https://www.e-act.nl/ah/action">
    <input type="hidden"  name="admin_id" value="364"/><input type="hidden"  name="trigger_code" value="SUBSCR_1480608986008"/><input type="hidden"  name="confirm" value="false"/><input type="text" name="relation_firstName" placeholder="Voornaam"  /><br/><input  type="text" name="relation_email" placeholder="E-mailadres"  /><br/><input type="submit" name="submit"  title="Aanmelden" value="Aanmelden"/><br/></form>';
            break;
        }
    	
    	return $eact;
    }
    
add_shortcode( 'get', 'shortcode_get' );
    function shortcode_get( $atts ){
        
        $param          = $atts['param'];
        $append         = $atts['append'];
        
        if( !empty($param) ){
            
            if( !empty( safe_get($param) ) ){
                
                return safe_get($param) . $append;
                
            }
            
            return false;
            
        }
        
        return false;
    }
    
add_shortcode( 'helpbox', 'shortcode_helpbox' );
    function shortcode_helpbox( $atts ){
        
        $key            = $atts['key'];
        $helpboxes      = get_field('helpboxes', 'option');
        $helpbox_a_key  = '';
        
        if( !empty($key) && !empty($helpboxes) ){
            
            foreach( $helpboxes as $a_key => $helpbox ){
                if( $helpbox['helpbox_key'] === $key ){ 
                    $helpbox_a_key = $a_key; 
                    
                    $helpbox_html .= '<span class="helpbox-trigger" data-key="' . $key . '"><i class="fa fa-info-circle"></i></span>';   
                    
                    return $helpbox_html;
                    
                    break;
                }
            }
            
            return false;
            
        }
        
        return false;
    }
    
?>