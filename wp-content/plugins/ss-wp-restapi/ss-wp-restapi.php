<?php
/*
Plugin Name: Custom Rest API
Plugin URI: http://testdomain.com/
Description: Plugin is for creating custom rest API for internal purpose
Author: kcrm 
Version: 3.2
Author URI: http://testdomain.com
*/


/* custom API function - creating custom route for the API */
add_action('rest_api_init', function () {
	register_rest_route('myapi/v1', '/approveUser/(?P<id>\d+)/(?P<new_id>\d+)', [
		'methods' => 'GET',
		'callback' => 'approve_wp_users',
		'permission_callback' => '__return_true',
	]);
});

add_action('rest_api_init', function () {
	//get json parameter in url
	register_rest_route('myapi/v1', '/updateTopInventory', [
		'methods' => 'POST',
		'callback' => 'update_top_inventory',
		'permission_callback' => '__return_true',
	]);
});

add_action('rest_api_init', function () {
	register_rest_route('myapi/v1', '/users', [
		'methods' => 'GET',
		'callback' => 'get_custom_wp_users',
		'permission_callback' => '__return_true',
	]);
});


function approve_wp_users($data)
{
	$account_id = (int)$data['id'];
	$new_id = (int)$data['new_id'];
	global $wpdb;
	$userdata = $wpdb->get_results("SELECT * FROM `wp_usermeta` where meta_key='account_id' and meta_value=" . $account_id . " limit 1");
	$user_id = $userdata[0]->user_id;
	$type = get_user_meta($user_id, 'user_type', true);
	if ($type == "private") {
		update_user_meta($user_id, 'crm_user_status', 1);
		update_user_meta($user_id, 'relation_id', $new_id);
	} else {
		update_user_meta($user_id, 'crm_user_status', 1);
		update_user_meta($user_id, 'company_id', $new_id);
	}
	return array('status' => 'success');
}
function update_top_inventory($request){
	global $wpdb;
	
	//update wp_posts set menu_order=0 where post_type='collectie';
	$wpdb->query("update wp_posts set menu_order=0 where post_type='collectie'");
	// $top_inventory = $request->get_json_params();
	$top_inventory=$request->get_body();
	// $top_inventory = $top_inventory['top_inventory'];
	// $top_inventory = explode(',',$top_inventory);
	$top_inventory = json_decode($top_inventory);
	$k=count($top_inventory);
	foreach($top_inventory as $key=>$val){
		$wpdb->query("update wp_posts set menu_order=".$k." where post_type='collectie' AND ID=".$val);
		$k--;
	}
	return array('status' => 'success');

}
// Get all projects and assign thumbnail
function get_custom_wp_users($request)
{
	//echo 'LINE24';
	global $wpdb;
	$userdata = $wpdb->get_results("SELECT * FROM `wp_users` ORDER BY ID DESC");

	$userarr =  array();
	$i = 0;
	foreach ($userdata as $userkey => $userval) {
		/*echo '<pre>';
		print_r($userval);
		echo '</pre>';*/

		$first_name = get_user_meta($userval->ID, 'first_name', true);
		$last_name = get_user_meta($userval->ID, 'last_name', true);
		$user_type = get_user_meta($userval->ID, 'user_type', true);
		$phone = get_user_meta($userval->ID, 'phone', true);
		$crm_user_status = get_user_meta($userval->ID, 'crm_user_status', true);

		$userarr[$i]['user_email'] = $userval->user_email;
		$userarr[$i]['first_name'] = $first_name;
		$userarr[$i]['last_name'] = $last_name;
		$userarr[$i]['user_type'] = $user_type;
		$userarr[$i]['phone'] = $phone;
		$userarr[$i]['crm_user_status'] = $crm_user_status;
		$userarr[$i]['user_registered'] = $userval->user_registered;
		$i++;
	}

	return $userarr;
	/*echo '<pre>';
	print_r($userarr);
	echo '</pre>';*/
}
