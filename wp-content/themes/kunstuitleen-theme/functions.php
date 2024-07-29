<?php
  
    add_action( 'after_setup_theme', 'gotopeople_setup' );

    if ( ! function_exists( 'gotopeople_setup' ) ):
    	function gotopeople_setup() {
    		register_nav_menus( array( 
        		    'primary' => __( 'Werk Menu', 'gotopeople' ), 
        		    'primary-thuis' => __( 'Thuis Menu', 'gotopeople' ), 
        		    'landingspage' => __( 'Landingspage Menu', 'gotopeople' ),
        		    'werk-voorselectie' => __( 'Werk: Voorselectie', 'gotopeople' )
                )
            );
    		add_theme_support( 'post-thumbnails' );
    	}
    endif;

    // Shiny Editor style
    add_editor_style('css/editor-style.css');

    // HEADER
    $args = array(
    	'width'         => 1920,
    	'height'        => 1500,
    	'default-image' => get_template_directory_uri() . '/static/images/portal-header.png',
    );
    add_theme_support( 'custom-header', $args );
    
    // Custom Image Sizes
    add_image_size( 'responsive_full', 1170, 9999, false);
    add_image_size( 'responsive', 768, 9999, false );
    add_image_size( 'square', 768, 768, true ); // Cropped
    add_image_size( 'page_header', 1420, 130, true ); // Cropped
    add_image_size( 'referentie', 465, 275, true ); // Cropped
    add_image_size( 'referentie_author', 125, 125, true ); // Cropped
    add_image_size( 'one_column_image', 1170, 350, true ); // Cropped   
    add_image_size( 'home_header', 1420, 560, true ); // Cropped       
    add_image_size( 'black_column_image', 750, 463, true ); // Cropped       
    add_image_size( 'black_column_image_2nd', 555, 360, true ); // Cropped       
    
    
    
    add_image_size( 'portal', 768, 450, true ); // Cropped    


/* ACF Theme options */
require_once('inc/functions/acf-theme-options.php');

/* Theme actions */
require_once('inc/functions/actions.php');

/* Theme filters */
require_once('inc/functions/filters.php');

/* Custom Post Types */
require_once('inc/functions/post-types.php');

/* Custom Taxonomies */
require_once('inc/functions/taxonomies.php');

/* Shortcodes */
require_once('inc/functions/shortcodes.php');

/* FORMIDABLE ( PLUGIN ) */
require_once('inc/functions/formidable.php');

/* AJAX */
require_once('inc/functions/ajax/blog.php');
require_once('inc/functions/ajax/collectie.php');
require_once('inc/functions/ajax/kunstenaars.php');

// Scripts in footer
add_action( 'wp_enqueue_scripts', 'theme_name_scripts' );
    function theme_name_scripts() {
        
        // Vars
        $cookieWebVariant   = get_web_variant();
        $version            = '3.1.2';
        
        /*
         * Styles		
         */
        
        wp_enqueue_style( 'google-font-cinzel', 'https://fonts.googleapis.com/css?family=Cinzel:400,700', array(), '1.0.0', 'all' );         
        wp_enqueue_style( 'font-mrjonesbook', get_template_directory_uri() . '/static/fonts/mrjonesbook.css', array(), '1.0.0', 'all' );
        
        if( is_page_template( 'page-templates/page-home.php' ) || is_page_template( 'page-templates-thuis/page-home-thuis.php' ) ){
            wp_enqueue_style( 'slick', get_template_directory_uri() . '/static/css/slick.css', array(), '1.3.11', 'all' );
        }
        
        if( is_page_template( 'page-templates-thuis/page-collectie-thuis.php' ) || is_page_template( 'page-templates/page-collectie.php' ) || is_page_template( 'page-templates/page-favorieten.php' ) || is_singular('kunstenaar') || is_page_template( 'page-templates/page-collectie-voorselectie.php' ) ){
            wp_enqueue_style( 'chosen', get_template_directory_uri() . '/static/css/chosen.min.css', array(), '1.3.11', 'all' );
        }
        
        
		
		wp_enqueue_style( 'nivo-lightbox', get_template_directory_uri() . '/static/nivo-lightbox/nivo-lightbox.css', array(), '1.1.0', 'all' );
		wp_enqueue_style( 'nivo-lightbox-theme', get_template_directory_uri() . '/static/nivo-lightbox/themes/default/default.css', array(), '1.1.0', 'all' );
		
		
		wp_enqueue_style( 'bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css', array(), '3.2.0', 'all' );
		wp_enqueue_style( 'font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css', array(), '4.5.0', 'all' );
		
		wp_enqueue_style( 'custom-forms', get_template_directory_uri() . '/static/css/forms.css', array(), $version, 'all' );
		wp_enqueue_style( 'custom-nav', get_template_directory_uri() . '/static/css/nav.css', array(), $version, 'all' );
		
		wp_enqueue_style( 'custom-style', get_stylesheet_uri(), array(), $version, 'all' );
		
		wp_enqueue_style( 'custom-theme', get_template_directory_uri() . '/static/css/' . $cookieWebVariant . '.css', array(), $version, 'all' );
		

        /*
         * Scripts
         */

    	wp_dequeue_script('jquery');
    	wp_enqueue_script('jqueryscript', get_template_directory_uri() . '/static/js/jquery-2.2.1.min.js', array(), '2.2.1', true );
    	
    	
    	wp_enqueue_script('jscookie', get_template_directory_uri() . '/static/js/js.cookie.js', array('jquery'), '2.0.0', true );
    	
    	wp_enqueue_script('flexnav', get_template_directory_uri() . '/static/js/jquery.flexnav.min.js', array('jquery'), '1.0.0', true );
    	
    	wp_enqueue_script( 'nivolightbox', get_template_directory_uri() . '/static/nivo-lightbox/nivo-lightbox.min.js', array('jquery'), '1.0.0', true );
    	//wp_enqueue_script( 'lazyload', get_template_directory_uri() . '/js/jquery.lazyload.min.js', array(), '1.0.0', true );
    	
    	if( is_page_template( 'page-templates/page-home.php' ) || is_page_template( 'page-templates-thuis/page-home-thuis.php' ) ){
        	
        	wp_enqueue_script('modernizr-video', get_template_directory_uri() . '/static/js/modernizr-video.js', array('jquery'), '1.0.0', true );
    	    //wp_enqueue_script( 'jquerymigrate', '//code.jquery.com/jquery-migrate-1.2.1.min.js', array(), '1.0.0', true );
    	    wp_enqueue_script( 'slick', '//cdn.jsdelivr.net/jquery.slick/1.3.11/slick.min.js', array('jquery'), '1.3.11', true );
    	}
    	
    	
    	if( is_page_template( 'page-templates-thuis/page-collectie-thuis.php' ) || is_page_template( 'page-templates/page-collectie.php' ) || is_page_template( 'page-templates/page-favorieten.php' ) || is_singular('kunstenaar') || is_page_template( 'page-templates/page-collectie-voorselectie.php' ) ){   
    	    wp_enqueue_script('masonry', get_template_directory_uri() . '/static/js/masonry.min.js', array('jquery'), '2.0.0', true );
    	    wp_enqueue_script('chosenJS', get_template_directory_uri() . '/static/js/chosen.min.js', array('jquery'), '1.5.1', true );
        }
    	
    	if( is_singular( 'collectie') || 
            is_singular( 'preselect_collection') || 
            is_singular('kunstenaar') ||
            is_page_template( 'page-templates-thuis/page-collectie-thuis.php' ) || 
            is_page_template( 'page-templates/page-collectie.php' ) || 
            is_page_template( 'page-templates/page-favorieten.php' ) || 
            is_page_template( 'page-templates/page-favorieten-bevestigen.php' ) || 
            is_page_template( 'page-templates/page-collectie-voorselectie.php' ) || 
            is_page_template( 'page-templates/page-favorieten-voorselectie.php' )
        ){
    	    wp_enqueue_script('jqueryui', get_template_directory_uri() . '/static/js/jquery-ui.js', array('jquery'), '2.1.1', true );
    	    wp_enqueue_script('collectiejs', get_template_directory_uri() . '/static/js/collectie.js', array('jquery'), $version, true );
    	}
    	
    	if( is_home() ){
    	    wp_enqueue_script('ajaxblogitems', get_template_directory_uri() . '/static/js/blog-items.js', array('jquery'), $version, true );
    	}
    	
    	if( basename( get_page_template() ) == 'page-contact.php' ){
        	wp_enqueue_script( 'googlemapsjs', 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&key=AIzaSyAMyHd4kZV4LdPSFLrOHb1ma9yT9pSCQPs', array('jquery'), '1.0.0', true );
        	wp_enqueue_script('googlemaps', get_template_directory_uri() . '/static/js/googlemaps.js', array('jquery'), $version, true );
        }
        
        if( is_page_template( 'page-templates/page-kunstenaars.php' ) ){   
    	    wp_enqueue_script('kunstenaarsjs', get_template_directory_uri() . '/static/js/kunstenaar.js', array('jquery'), $version, true );
        }
    	
    	if( is_page_template( 'page-templates/page-collectie-voorselectie.php' ) ):
            wp_enqueue_script('countdownjs', get_template_directory_uri() . '/static/js/jquery.countdown.min.js', array('jquery'), '2.2.0', true );	
            wp_enqueue_script('preselectionjs', get_template_directory_uri() . '/static/js/voorselectie.js', array('jquery'), $version, true );	
    	endif;
    	
    	wp_enqueue_script('ownscripts', get_template_directory_uri() . '/static/js/scripts.js', array('jquery'), $version, true );
    	//wp_enqueue_script('bootstrapscripts', get_template_directory_uri() . '/js/bootstrap.min.js', array(), '1.0.0', true );
    	wp_enqueue_script('bootstrap-js', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js', array('jquery'), '1.1', true );
    	
        
        /*
         * PHP vars to JS 
         */

    	$js_favorieten = get_favorieten();
    	$js_favorieten_refresh = false;
    	
        if( !empty($js_favorieten) ){
            foreach( $js_favorieten as $key => $favoriet ){ 
                if ( FALSE === get_post_status( $favoriet ) ) {
                    unset($js_favorieten[$key]); 
                    $js_favorieten_refresh = true;
                }
            }
        }
    	
    	wp_localize_script(
    		'ownscripts',
    		'myLocalized',
    		array(
        		'ajaxurl'   => admin_url( 'admin-ajax.php' ),
    			'inc'       => trailingslashit( get_template_directory_uri() ) . 'inc/',
    			'images'    => trailingslashit( get_template_directory_uri() ) . 'static/images/',
    			'settings'  => [
        			'webVariant'    => get_web_variant(),
        			'landingspage'  => is_landingspage(),
        			'preselect'     => ( get_preselect_client() ? get_preselect_client() : false ),
        			'favorieten'    => [
            			'list'      => $js_favorieten,
            			'refresh'   => $js_favorieten_refresh,
        			]
    			]
            )
    	);
    	
    }
?>
