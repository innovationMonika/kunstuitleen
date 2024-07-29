<?php

add_action("wp_ajax_getArtists", "g2p_get_kunstenaars"); //For logged in users ( wp_ajax_{action} )
add_action("wp_ajax_nopriv_getArtists", "g2p_get_kunstenaars"); //For not logged in users ( wp_ajax_nopriv_{action} )

    function g2p_get_kunstenaars() {
        
        ob_clean();
        
        $paged = $_REQUEST['page'];
        $sm = 0;
        $mdlg = 0;

        $args = array(
            'post_type' => 'kunstenaar', 
            'orderby' => 'name',
            's' => $_GET['c'],
            'order' => 'ASC', 
            'posts_per_page' => 12,
            'paged' => $paged,
            'meta_query' => array(
        		array(
        			'key'     => 'kunstenaar_kunstkunstenaar',
        			'value'   => 'false',
        			'compare' => '!=',
        		),
            ),
        );
        
        // Extra args
        if( !empty( $_REQUEST['c'] ) ):
            $args['s'] = $_REQUES['c'];
        endif;
                
        
        $the_query = new WP_Query($args);
        
        if ( $the_query->have_posts() ) {	while ( $the_query->have_posts() ) { $the_query->the_post(); $sm++; $mdlg++;
        
            include( locate_template( 'inc/kunstenaar.php', false, false ));
            
            if( $sm == 3 ): echo '<br class="clear hidden-xs hidden-md hidden-lg" />'; $sm = 0; endif;
            if( $mdlg == 4 ): echo '<br class="clear hidden-xs hidden-sm" />'; $mdlg = 0; endif;
                                
        } /* endwhile */ } /* endif */ wp_reset_postdata(); /* Restore original Post Data */ 

        wp_die(); // this is required to terminate immediately and return a proper response
    }