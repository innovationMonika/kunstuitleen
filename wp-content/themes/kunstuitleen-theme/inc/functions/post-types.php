<?php 
    
add_action( 'init', 'g2p_register_my_cpts' );
    function g2p_register_my_cpts() {
    	
    	$labels = array(
    		"name" => "Collectie",
    		"singular_name" => "Kunstwerk",
    		"add_new" => "Nieuw kunstwerk",
    		"add_new_item" => "Nieuw kunstwerk",
    		"new_item" => "Nieuw kunstwerk",
    		);
    
    	$args = array(
    		"labels"                => $labels,
    		"description"           => "",
    		"public"                => true,
    		"show_ui"               => true,
    		"has_archive"           => false,
    		"show_in_menu"          => true,
    		"exclude_from_search"   => false,
    		"capability_type"       => "post",
    		"map_meta_cap"          => true,
    		"menu_icon"             => "dashicons-art",
    		"hierarchical"          => false,
    		"rewrite"               => array( "slug" => "collectie", "with_front" => true ),
    		"query_var"             => true,
            "show_in_rest"          => true,
    		"supports"              => array( "title", "editor", "revisions", "thumbnail", "author", "page-attributes", "post-formats" ),		
    	);

    	register_post_type( "collectie", $args );
    	
    	$labels = array(
    		"name" => "Amsterdam Art Center",
    		"singular_name" => "Onderdeel",
    		"add_new" => "Nieuw onderdeel",
    		"add_new_item" => "Nieuw onderdeel",
    		"new_item" => "Nieuw onderdeel",
    		);
    
    	$args = array(
    		"labels"                => $labels,
    		"description"           => "",
    		"public"                => false,
    		"show_ui"               => true,
    		"has_archive"           => false,
    		"show_in_menu"          => true,
    		"exclude_from_search"   => true,
    		"capability_type"       => "post",
    		"map_meta_cap"          => true,
    		"menu_icon"             => "dashicons-building",
    		"hierarchical"          => false,
    		"rewrite"               => array( "slug" => "amsterdamartcenter", "with_front" => true ),
    		"query_var"             => true,
            "show_in_rest"          => true,
    		"supports"              => array( "title", "editor", "revisions", "thumbnail", "author", "page-attributes", "post-formats" ),		
    	);

    	register_post_type( "amsterdamartcenter", $args );
    	
    	$labels = array(
    		"name" => "Referenties",
    		"singular_name" => "Referentie",
    		"add_new" => "Nieuw referentie",
    		"add_new_item" => "Nieuw referentie",
    		"new_item" => "Nieuw referentie",
    		);
    
    	$args = array(
    		"labels"                => $labels,
    		"description"           => "",
    		"public"                => false,
    		"show_ui"               => true,
    		"has_archive"           => false,
    		"show_in_menu"          => true,
    		"exclude_from_search"   => true,
    		"capability_type"       => "post",
    		"map_meta_cap"          => true,
    		"menu_icon"             => "dashicons-admin-comments",
    		"hierarchical"          => false,
    		"rewrite"               => array( "slug" => "referentie", "with_front" => true ),
    		"query_var"             => true,
            "show_in_rest"          => true,
    		"supports"              => array( "title", "editor", "revisions", "thumbnail", "author", "page-attributes", "post-formats" ),		
    	);

    	register_post_type( "referentie", $args );
        
        
    	$labels = array(
    		"name" => "Kunstenaars",
    		"singular_name" => "Kunstenaar",
    		"add_new" => "Nieuwe kunstenaar",
    		"add_new_item" => "Nieuwe kunstenaar",
    		"new_item" => "Nieuwe kunstenaar",
    		);
    
    	$args = array(
    		"labels"                => $labels,
    		"description"           => "",
    		"public"                => true,
    		"show_ui"               => true,
    		"has_archive"           => false,
    		"show_in_menu"          => true,
    		"exclude_from_search"   => false,
    		"capability_type"       => "post",
    		"map_meta_cap"          => true,
    		"menu_icon"             => "dashicons-admin-appearance",
    		"hierarchical"          => false,
    		"rewrite"               => array( "slug" => "kunstenaar", "with_front" => true ),
    		"query_var"             => true,
            "show_in_rest"          => true,
    		"supports"              => array( "title", "editor", "revisions", "thumbnail", "author", "page-attributes", "post-formats" ),		
    	);
    	register_post_type( "kunstenaar", $args );
    	
    	
    	$labels = array(
    		"name" => "Voorselectie: Klanten",
    		"singular_name" => "Klant",
    		"add_new" => "Nieuwe klant",
    		"add_new_item" => "Nieuwe klant",
    		"new_item" => "Nieuwe klant",
    		);
    
    	$args = array(
    		"labels"                => $labels,
    		"description"           => "",
    		"public"                => false,
    		"show_ui"               => true,
    		"has_archive"           => false,
    		"show_in_menu"          => true,
    		"exclude_from_search"   => true,
    		"capability_type"       => "post",
    		"map_meta_cap"          => true,
    		"menu_icon"             => "dashicons-admin-users",
    		"hierarchical"          => false,
    		"rewrite"               => array( "slug" => "preselection-customer", "with_front" => true ),
    		"query_var"             => true,
            "show_in_rest"          => true,
    		"supports"              => array( "title", "revisions", "author", "page-attributes", "post-formats" ),		
    	);
    	register_post_type( "preselect_customer", $args );
    	
    	
    	
    	$labels = array(
    		"name" => "Voorselectie: Collectie",
    		"singular_name" => "Kunstwerk",
    		"add_new" => "Nieuw kunstwerk",
    		"add_new_item" => "Nieuw kunstwerk",
    		"new_item" => "Nieuw kunstwerk",
    		);
    
    	$args = array(
    		"labels"                => $labels,
    		"description"           => "",
    		"public"                => true,
    		"show_ui"               => true,
    		"has_archive"           => false,
    		"show_in_menu"          => true,
    		"exclude_from_search"   => true,
    		"capability_type"       => "post",
    		"map_meta_cap"          => true,
    		"menu_icon"             => "dashicons-art",
    		"hierarchical"          => false,
    		"rewrite"               => array( "slug" => "preselection-collection", "with_front" => true ),
    		"query_var"             => true,
            "show_in_rest"          => true,
    		"supports"              => array( "title", "revisions", "author", "page-attributes", "post-formats" ),		
    	);

    	register_post_type( "preselect_collection", $args );
    
    
    // End of g2p_register_my_cpts()
    }
?>