<?php
require_once("../admin/_config/config.php");
require_once("../admin/include/functions.php");
require_once("common.php");

$response = array();

$user_id = $_SESSION['user_id'];
$guest_user_id = $_SESSION['guest_user_id'];
$order_id = $_SESSION['order_id'];
if(($user_id>0 || $guest_user_id>0) && $order_id) {

	if($user_id>0) {
		$user_data = get_user_data($user_id);
	} elseif($guest_user_id>0) {
		$user_data = get_user_data($guest_user_id);
	}
	
	$datetime = date('Y-m-d H:i:s');
	$save_as_primary_address = $post['save_as_primary_address'];
	$shipping_first_name = real_escape_string($post['shipping_first_name']);
	$shipping_last_name = real_escape_string($post['shipping_last_name']);
	$shipping_company_name = real_escape_string($post['shipping_company_name']);
	$shipping_address = real_escape_string($post['shipping_address']);
	$shipping_address2 = real_escape_string($post['shipping_address2']);
	$shipping_city = real_escape_string($post['shipping_city']);
	$shipping_state = real_escape_string($post['shipping_state']);
	$shipping_country = $company_country;
	$shipping_postcode = $post['shipping_postcode'];
	$shipping_phone = $post['shipping_phone'];
	$shipping_phone_c_code = $post['shipping_phone_c_code'];
	
	$sales_pack = isset($post['shipping_method'])?$post['shipping_method']:'';
	$store_location_id = isset($post['location_id'])?$post['location_id']:'';
	$store_date = isset($post['date'])?$post['date']:'';
	$store_time = isset($post['time_slot'])?$post['time_slot']:'';
	
	if($store_date) {
		$expl_store_date = explode("/",$store_date);
		$store_date = $expl_store_date[2].'-'.$expl_store_date[0].'-'.$expl_store_date[1];
	}
	
	if($user_data['first_name'] == '' || $user_data['last_name'] == '') {
		mysqli_query($db,"UPDATE `users` SET `first_name`='".$shipping_first_name."',`last_name`='".$shipping_last_name."',`name`='".$shipping_first_name." ".$shipping_last_name."',`company_name`='".$shipping_company_name."' WHERE id='".$user_id."' OR id='".$guest_user_id."'");
	}

	if($save_as_primary_address == '1' && $user_id>0) {
		mysqli_query($db,"UPDATE `users` SET `address`='".$shipping_address."',`address2`='".$shipping_address2."',`city`='".$shipping_city."',`state`='".$shipping_state."',`country`='".$company_country."',`postcode`='".$shipping_postcode."',`phone`='".$shipping_phone."',`country_code`='".$shipping_phone_c_code."' WHERE id='".$user_id."'");
	}/* elseif($guest_user_id>0) {
		mysqli_query($db,"UPDATE `users` SET `first_name`='".$shipping_first_name."',`last_name`='".$shipping_last_name."',`name`='".$shipping_first_name." ".$shipping_last_name."' WHERE id='".$guest_user_id."'");
	}*/

	$q = mysqli_query($db,"UPDATE `orders` SET `shipping_first_name`='".$shipping_first_name."',`shipping_last_name`='".$shipping_last_name."',`shipping_company_name`='".$shipping_company_name."',`shipping_address1`='".$shipping_address."',`shipping_address2`='".$shipping_address2."',`shipping_city`='".$shipping_city."',`shipping_state`='".$shipping_state."',`shipping_country`='".$shipping_country."',`shipping_postcode`='".$shipping_postcode."',`shipping_phone`='".$shipping_phone."',`shipping_country_code`='".$shipping_phone_c_code."',`sales_pack`='".$sales_pack."',`store_location_id`='".$store_location_id."',`store_date`='".$store_date."',`store_time`='".$store_time."' WHERE order_id='".$order_id."'");
	if($q == '1') {
		$response['success'] = true;
	} else {
		$response['success'] = false;
	}
} else {
	$response['success'] = false;
}

echo json_encode($response);
?>