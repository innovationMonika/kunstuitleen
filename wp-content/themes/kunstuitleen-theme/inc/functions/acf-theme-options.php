<?php
    
    //add theme-options
    if( function_exists('acf_add_options_page') ) {
        
        
        acf_add_options_page(array(
            'page_title'    => 'Thema Options',
            'menu_title'    => 'Thema Options',
            'menu_slug'     => 'theme-options',
            'capability'    => 'edit_posts',
            'parent_slug'   => '',
            'position'      => '3.3.3',
            'icon_url'      => false,
        ));
        
        acf_add_options_sub_page(array(
            'page_title'    => 'Algemeen',
            'menu_title'    => 'Algemeen',
            'menu_slug'     => 'theme-options-algemeen',
            'capability'    => 'edit_posts',
            'parent_slug'   => 'theme-options',
            'position'      => false,
            'icon_url'      => false,
        ));
        
        acf_add_options_sub_page(array(
            'page_title'    => 'Collectie',
            'menu_title'    => 'Collectie',
            'menu_slug'     => 'theme-options-collectie',
            'capability'    => 'edit_posts',
            'parent_slug'   => 'theme-options',
            'position'      => false,
            'icon_url'      => false,
        ));
        
        acf_add_options_sub_page(array(
            'page_title'    => 'Kunst kadobon',
            'menu_title'    => 'Kadobon',
            'menu_slug'     => 'theme-options-kadobon',
            'capability'    => 'edit_posts',
            'parent_slug'   => 'theme-options',
            'position'      => false,
            'icon_url'      => false,
        ));
        
        acf_add_options_sub_page(array(
            'page_title'    => 'Helpboxen (?)',
            'menu_title'    => 'Helpboxen',
            'menu_slug'     => 'theme-options-helpbox',
            'capability'    => 'edit_posts',
            'parent_slug'   => 'theme-options',
            'position'      => false,
            'icon_url'      => false,
        ));
        
        acf_add_options_sub_page(array(
            'page_title'    => 'Popup',
            'menu_title'    => 'Popup',
            'menu_slug'     => 'theme-options-popup',
            'capability'    => 'edit_posts',
            'parent_slug'   => 'theme-options',
            'position'      => false,
            'icon_url'      => false,
        ));
        
        
        acf_add_options_sub_page(array(
            'page_title'    => 'Footer',
            'menu_title'    => 'Footer',
            'menu_slug'     => 'theme-options-footer',
            'capability'    => 'edit_posts',
            'parent_slug'   => 'theme-options',
            'position'      => false,
            'icon_url'      => false,
        ));
        
    }
    
    
    /*
        ADMIN COLUMNS
    */
    
    
    // ADD NEW COLUMN
    add_filter('manage_preselect_collection_posts_columns', 'v2008_c_head');
        function v2008_c_head($defaults) {
        	$column_name = 'preselect_customer_id'; //column slug
        	$column_heading = 'Voorselectie klant ( ID )';//column heading
        	$defaults[$column_name] = $column_heading;
        	return $defaults;
        }
     
    // SHOW THE COLUMN CONTENT
    add_action('manage_preselect_collection_posts_custom_column', 'v2008_c_content', 10, 2);
        function v2008_c_content($name, $post_ID) {
            $column_name = 'preselect_customer_id'; //column slug	
            $column_field = 'preselect_art_customer'; //field slug	
            if ($name == $column_name) {
                $post_meta = get_post_meta($post_ID,$column_field,true);
                $get_post_by_meta = get_post($post_meta, 'OBJECT');
                if ($post_meta && $get_post_by_meta) {
                    echo '<a href="' . get_edit_post_link($post_meta) . '">'.$get_post_by_meta->post_title.'</a>';
                }
            }
        }
    
    // ADD STYLING FOR COLUMN
    add_filter('admin_head', 'v2008_c_style');
        function v2008_c_style(){
        	$column_name = 'preselect_customer_id';//column slug	
        	echo "<style>.column-$column_name{width:10%;}</style>";
        }

    /* FIELD CHANGES */


    /* Readonly fields */
    //add_filter('acf/load_field/name=preselect_client_name', 'disable_acf_load_field');    
    /*
    add_filter('acf/load_field/name=preselect_client_filter_waarde', 'disable_acf_load_field');
    add_filter('acf/load_field/name=preselect_client_filter_stijl', 'disable_acf_load_field');
    add_filter('acf/load_field/name=preselect_client_filter_orientatie', 'disable_acf_load_field');
    add_filter('acf/load_field/name=preselect_client_filter_formaat', 'disable_acf_load_field');
    add_filter('acf/load_field/name=preselect_client_filter_techniek', 'disable_acf_load_field');
    */
        function disable_acf_load_field( $field ) {
            $field['readonly'] = 1;
            return $field;
        }
  
?>