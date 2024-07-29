<?php
	
	/**
     * Plugin Name: Go2People - Core Functions
     * Description: Core WordPress / theme functions written by Niels Lust - Go2People
     * Author:      Go2People Websites
     * License:     GNU General Public License v3 or later
     * License URI: http://www.gnu.org/licenses/gpl-3.0.html
     */

    // Basic security, prevents file from being loaded directly.
    defined( 'ABSPATH' ) or die( 'Cheatin&#8217; uh?' );
    	
    class G2P_Functions {
    	
    	public function __construct() {
        	
        	add_action( 'admin_notices', array( $this, 'g2p_update_notice' ) );
        	
        	/* Auto update */
            add_filter( 'auto_update_core', '__return_true' );
            add_filter( 'allow_minor_auto_core_updates', '__return_true' );
            add_filter( 'allow_major_auto_core_updates', '__return_true' );
            
            add_filter( 'automatic_updates_is_vcs_checkout', '__return_false', 1 );
            
            add_filter( 'auto_update_plugin', '__return_true' );
            add_filter( 'auto_update_plugin', array( $this, 'auto_update_specific_plugins' ), 10, 2 );
            
            add_filter( 'auto_update_theme', '__return_true' );
            add_filter( 'auto_update_translation', '__return_true' );
            
            //add_filter( 'auto_core_update_send_email', '__return_true' );
            //add_filter( 'automatic_updates_send_debug_email', '__return_true', 1 );
            
        }
    	
        public function g2p_update_notice() { 
        
            global $pagenow;
            
            if ( $pagenow == 'update-core.php' ):
    
                $notice  = '<div class="updated message fade notice"><p>';
                $notice .= '<strong>Let op!</strong> Deze website wordt beheerd en geüpdatet door <a href="https://go2people.nl/" target="_blank">Go2People Websites</a>. Vragen? Neem contact met ons via <a href="mailto:support@go2people.nl">support@go2people.nl</a>';
                $notice .= '</p></div>';   
                
                echo $notice;
                    
            endif;
            
        }
        
        
        public function auto_update_specific_plugins ( $update, $item ) {
            // Array of plugin slugs to always auto-update
            $plugins = array ( 
                'woocommerce',
            );
            if ( in_array( $item->slug, $plugins ) ) {
                return false; // Always update plugins in this array
            } else {
                return $update; // Else, use the normal API response to decide whether to update or not
            }
        }
        
    }
    
    // Instantiate the class
    $G2P_Functions = new G2P_Functions();

?>