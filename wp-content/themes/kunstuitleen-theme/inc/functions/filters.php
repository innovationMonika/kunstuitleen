<?php

// ACF
add_filter( 'acf/admin/prevent_escaped_html_notice', '__return_true' );
add_filter( 'acf/the_field/allow_unsafe_html', '__return_true', 10);

/**
 * Yoast SEO: Breadcrumbs
 * For post types, add overview link(s) if overview_id exists
 */

add_filter('collectie_backlink', function(){

    $cookieWebVariant   = get_web_variant();
    $backID = ( $cookieWebVariant == 'werk' ? ( is_singular( 'preselect_collection' ) ? 285780 : 42) : 122258 );
    $backToActiveFilters = get_cookie_value('collectieFilters');

    if( isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] == get_bloginfo('siteurl').'/'.$cookieWebVariant.'/favorieten/' ):
        $backlink = get_permalink(122275); // Favorieten
        $backlinkLabel = 'Terug naar favorieten';
    else:

        // Remove backToActiveFilters, ook via JS (cookie) en gebruik de history.
        // Add op /*/collectie/ pagina (waar ook Masonry actief is) on click art -> detail, history push backto -> redirect to originale value
        if ( isset($_SERVER['HTTP_REFERER']) && strpos( $_SERVER['HTTP_REFERER'], get_permalink($backID) ) !== false ) {
            $backlink = $_SERVER['HTTP_REFERER'];
        } else {
            $backlink = get_permalink($backID) . ( !empty($backToActiveFilters) ? '?' . $backToActiveFilters . '&backto='.get_field('art_inventnr') : '?backto=' . get_field('art_inventnr') );
        }

        $backlinkLabel = 'Terug naar collectie';
    endif;

    return [$backlink, $backlinkLabel];
}, 10, 0);

add_filter( 'wpseo_breadcrumb_links', function( $links ) {

    if( is_singular('collectie') ) {

        $breadcrumb = [];

        $backlinkFilter = apply_filters('collectie_backlink', NULL);

        $breadcrumb[] = array(
            'url' => $backlinkFilter[0],
            'text' => 'Collectie',
        );
        
        array_splice($links, 1, -2, $breadcrumb);
    }
    
    $cookieWebVariant = get_web_variant();
    if (get_web_variant() === 'werk') {
	    $links[0]['url'] .= 'werk/';
    }

    return $links;
});


add_filter( 'enter_title_here', 'wpb_change_title_text' );
    function wpb_change_title_text( $title ){
         $screen = get_current_screen();
         if  ( 'preselect_customer' == $screen->post_type ) {
              $title = 'Voer een contractnummer in';
         }
         return $title;
    }
 

function content_is_more(){
    // Check the content for the more text
    $ismore = @strpos( $post->post_content, '<!--more-->');
    // If there's a match
    if($ismore) : the_content();
    // Else no more tag exists
    else : the_excerpt();
    // End if more
    endif;
}
  
// Attach callback to 'tiny_mce_before_init' 
add_filter( 'tiny_mce_before_init', 'my_mce_before_init_insert_formats' );

    function my_mce_before_init_insert_formats( $init_array ) {  
    	// Define the style_formats array
    	$style_formats = array(  
    		// Each array child is a format with it's own settings
    		
    		array(  
    			'title' => 'H3: Font - MrJonesBook', 
    			'selector' => 'h3',
    			'classes' => 'mrjonesbook',
    			'wrapper' => false,
    			
    		),
    		
    		array(  
    			'title' => 'Intro', 
    			'selector' => 'p',
    			'classes' => 'intro',
    			'wrapper' => true,
    			
    		),
    		
    		array(  
    			'title' => 'Button', 
    			'selector' => 'a',
    			'classes' => 'button-simple',
    			'wrapper' => false,
    			
    		),
    		
    		array(  
    			'title' => 'Formulier', 
    			'block' => 'div',
    			'classes' => 'column black form',
    			'wrapper' => true,
    			
    		),
    		
    	);  
    	// Insert the array, JSON ENCODED, into 'style_formats'
    	$init_array['style_formats'] = json_encode( $style_formats );  
    	
    	return $init_array;  
      
    } 


// Allow SVG upload
add_filter('upload_mimes', 'cc_mime_types');
    function cc_mime_types($mimes) {
      $mimes['svg'] = 'image/svg+xml';
      return $mimes;
    }

// JPEG always 100% quality in WordPress
add_filter( 'jpeg_quality', 'smashing_jpeg_quality' );
    function smashing_jpeg_quality() {
    	return 100;
    }

// Excerpt lenght
add_filter( 'excerpt_length', 'gotopeople_excerpt_length' );
    function gotopeople_excerpt_length( $length ) {
    	return 25;
    }

add_filter('excerpt_more', 'new_excerpt_more');
    function new_excerpt_more( $more ) {
        return '...';
    }

//Embed Video Fix
add_filter('the_content', 'add_secure_video_options', 10);
    function add_secure_video_options($html) {
       if (strpos($html, "<iframe" ) !== false) {
        	$search = array('src="http://www.youtu','src="http://youtu');
    		$replace = array('src="https://www.youtu','src="https://youtu');
    		$html = str_replace($search, $replace, $html);
    
       		return $html;
       } else {
            return $html;
       }
    }

   
?>