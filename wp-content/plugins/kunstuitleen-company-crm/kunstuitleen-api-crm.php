<?php
/** Plugin Name :Custom API **/
add_action('rest_api_init',@function(){
    register_rest_route('wl/v1','get-artists',array(
        'methods'=>'GET',
        'callback'=>@function(){
            $artists = get_posts(array( 
                'post_type'=>'artist',
                'posts_per_page'=>-1
            ));
            return $artists;
        }
    ));
});
?>