<?php

// g2p_register_my_taxes()
add_action( 'init', 'g2p_register_my_taxes' );
    function g2p_register_my_taxes() {
    
    	$labels = array(
    		"name" => "Referentie - type",
    		"label" => "Referentie - type",
    		);
    
    	$args = array(
    		"labels" => $labels,
    		"hierarchical" => true,
    		"label" => "Referentie - type",
    		"show_ui" => true,
    		"query_var" => true,
    		"rewrite" => array( 'slug' => 'referentie-type', 'with_front' => true ),
    		"show_admin_column" => true,
    	);
    	register_taxonomy( "referentie_type", array( "referentie" ), $args );
            
    	$labels = array(
    		"name" => "Stijlen",
    		"label" => "Stijl",
        );
    
    	$args = array(
    		"labels" => $labels,
    		"hierarchical" => true,
    		"label" => "NAAM",
    		"show_ui" => true,
    		"query_var" => true,
    		"rewrite" => array( 'slug' => 'stijl', 'with_front' => true ),
    		"show_admin_column" => true,
    	);
    	
    	register_taxonomy( "stijl", array( "collectie", "preselect_collection", "preselect_customer" ), $args );
        
    	$labels = array(
    		"name" => "Oriëntaties",
    		"label" => "Oriëntaties",
        );
    
    	$args = array(
    		"labels" => $labels,
    		"hierarchical" => true,
    		"label" => "Oriëntaties",
    		"show_ui" => true,
    		"query_var" => true,
    		"rewrite" => array( 'slug' => 'orientatie', 'with_front' => true ),
    		"show_admin_column" => true,
    	);
    	
    	register_taxonomy( "orientatie", array( "collectie", "preselect_collection", "preselect_customer" ), $args );
        
        $labels = array(
    		"name" => "Waarden",
    		"label" => "Waarde",
        );
    
    	$args = array(
    		"labels" => $labels,
    		"hierarchical" => true,
    		"label" => "Waarden",
    		"show_ui" => true,
    		"query_var" => true,
    		"rewrite" => array( 'slug' => 'waarde', 'with_front' => true ),
    		"show_admin_column" => true,
    	);
    	
    	register_taxonomy( "waarde", array( "collectie", "preselect_collection", "preselect_customer" ), $args );
    	
    	$labels = array(
    		"name" => "Formaten",
    		"label" => "Formaat",
        );
    
    	$args = array(
    		"labels" => $labels,
    		"hierarchical" => true,
    		"label" => "Formaten",
    		"show_ui" => true,
    		"query_var" => true,
    		"rewrite" => array( 'slug' => 'formaat', 'with_front' => true ),
    		"show_admin_column" => true,
    	);
    	
    	register_taxonomy( "formaat", array( "collectie", "preselect_collection", "preselect_customer" ), $args );
    	
    	$labels = array(
    		"name" => "Technieken",
    		"label" => "Techniek",
        );
    
    	$args = array(
    		"labels" => $labels,
    		"hierarchical" => true,
    		"label" => "Technieken",
    		"show_ui" => true,
    		"query_var" => true,
    		"rewrite" => array( 'slug' => 'techniek', 'with_front' => true ),
    		"show_admin_column" => true,
    	);
    	
    	register_taxonomy( "techniek", array( "collectie", "preselect_collection", "preselect_customer" ), $args );
    	
    	$labels = array(
    		"name" => "Maandbedragen",
    		"label" => "Maandbedrag",
        );
    
    	$args = array(
    		"labels" => $labels,
    		"hierarchical" => true,
    		"label" => "Maandbedragen",
    		"show_ui" => true,
    		"query_var" => true,
    		"rewrite" => array( 'slug' => 'maandbedrag', 'with_front' => true ),
    		"show_admin_column" => true,
    	);
    	
    	register_taxonomy( "maandbedrag", array( "collectie", "preselect_collection" ), $args );
        
        
        
    }
    
?>