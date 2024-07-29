<?php
    
    /* Create match ( AJAX LOADING ) */
    add_action("wp_ajax_collectiePage", "g2p_get_collectie_page"); //For logged in users ( wp_ajax_{action} )
    add_action("wp_ajax_nopriv_collectiePage", "g2p_get_collectie_page"); //For not logged in users ( wp_ajax_nopriv_{action} )

        function g2p_get_collectie_page() {
            
            ob_clean();
            
            // Vars
            $cookieWebVariant = get_web_variant();
            $preselect_client = get_preselect_client();
            $currentPage = safe_request('page');
            
            // Query-args
            $args = array(
                'post_type'         => 'collectie', 
                'meta_key'          => 'art_inkoopdat', 
                'orderby'           => 'menu_order meta_value',
                'order'             => 'DESC', 
                'posts_per_page'    => 12,
                'paged'             => $currentPage,
            );

            
            // Extra args
            if( !empty( safe_request('wp_post_type') ) ):
                $args['post_type'] = safe_request('wp_post_type');
            endif;
            
            
            if( !empty( safe_request('c') ) ):
                $args['s'] = safe_request('c');
            endif;
            
        
            if( safe_request('consignatie') ):
                if( !array_key_exists('meta_query', $args) ): $args['meta_query'] = array('relation' => 'AND'); endif;
                
                $args['meta_query'][] = array(
        			'key'     => 'art_consignatie',
        			'value'   => safe_request('consignatie'),
            	);
            	
            endif;
            
            if( safe_request('kunstenaars') ):
                
                if( !array_key_exists('meta_query', $args) ): $args['meta_query'] = array('relation' => 'AND'); endif;
                
                $args['meta_query'][] = array(
        			'key'     => 'art_kunstenaar',
        			'value'   => array(strstr(safe_request('kunstenaars'), '_', true)),
        			'compare' => 'IN',
            	);
            	
            endif;
            
            if( safe_request('kunstenaars') ):
                
                if( !array_key_exists('meta_query', $args) ): $args['meta_query'] = array('relation' => 'AND'); endif;
                
                $args['meta_query'][] = array(
        			'key'     => 'art_kunstenaar',
        			'value'   => array(strstr(safe_request('kunstenaars'), '_', true)),
        			'compare' => 'IN',
            	);
            	
            endif;
            
            // TODO
            
            $taxes = [
                'stijl'         => 'stijlen',
                'orientatie'    => 'orientaties',
                'waarde'        => 'waarden',
                'formaat'       => 'formaten',
                'techniek'      => 'technieken',
                'maandbedrag'   => 'maandbedragen',
            ];
            
            foreach( $taxes as $key => $var ):
            
                if( safe_request($var) ):
                
                    if( !array_key_exists('tax_query', $args) ): $args['tax_query'] = array('relation' => 'AND'); endif;
                    
                    $args['tax_query'][] = [
                        'taxonomy' => $key,
                			'field'    => 'slug',
                			'terms'    => safe_request($var),
                    ];
                    
                endif;
            
            endforeach;
            
            
            if( safe_get('preselect_client_id') ){
                
                if( !array_key_exists('meta_query', $args) ): $args['meta_query'] = array('relation' => 'AND'); endif;

                $args['meta_query'][] = array(
                    'key' => 'preselect_art_already_chosen', // name of custom field
            		'value' => 'false', // Array of values
            		'compare' => '='
                );
                
                $args['meta_query'][] = array(
            		'key' => 'preselect_art_customer', // name of custom field
            		'value' => safe_get('preselect_client_id'), // Array of values
            		'compare' => '='
            	);
            	
            } else {
            
                // IF no waarden is selected, exclude waarde: r & x & s
                if( empty( safe_request('waarden') ) ):
                    
                    if( !array_key_exists('tax_query', $args) ): $args['tax_query'] = array('relation' => 'AND'); endif;
                    
                    $args['tax_query'][] = [
            			'taxonomy' => 'waarde',
            			'field'    => 'slug',
            			'terms'    => array( 'r', 'x', 's' ),
                        'operator' => 'NOT IN',
                    ];
                
                endif; 
            }
            
            // the Query            
            $the_query = new WP_Query($args);
            
            if ( $the_query->have_posts() ) {
                while ( $the_query->have_posts() ) { $the_query->the_post();  
                    include( locate_template( 'inc/art.php', false, false )); 
                } wp_reset_postdata(); /* Restore original Post Data */
                
                include( locate_template( 'inc/art-ad.php', false, false ));
            }

            wp_die(); // this is required to terminate immediately and return a proper response
        }