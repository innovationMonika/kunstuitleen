<?php

add_action("wp_ajax_getBlogItems", "g2p_get_blog_items"); //For logged in users ( wp_ajax_{action} )
add_action("wp_ajax_nopriv_getBlogItems", "g2p_get_blog_items"); //For not logged in users ( wp_ajax_nopriv_{action} )

    function g2p_get_blog_items() {
        
        ob_clean();
        
        $paged = $_REQUEST['page'];
        
        $args = array(
            'post_type' => 'post', 
            'orderby' => 'date name',
            'order' => 'DESC', 
            'posts_per_page' => get_option('posts_per_page'),
            'paged' => $paged,
        );
            
        $the_query = new WP_Query($args);
        
        if ( $the_query->have_posts() ) {	while ( $the_query->have_posts() ) { $the_query->the_post();

            include( locate_template( 'inc/blog-item.php', false, false ));

        } /* endwhile */ } /* endif */ wp_reset_postdata(); /* Restore original Post Data */

        wp_die(); // this is required to terminate immediately and return a proper response
    }