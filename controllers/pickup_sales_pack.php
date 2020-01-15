<?php
require_once("../admin/_config/config.php");
require_once("../admin/include/functions.php");

if(isset($post['submit_form'])) {
	$order_id=$post['order_id'];
	$exp_pickup_date=explode("/",$post['pickup_date']);
	$pickup_date = $exp_pickup_date[2].'-'.$exp_pickup_date[0].'-'.$exp_pickup_date[1];
	$pickup_time=$post['pickup_time'];
	$address=real_escape_string($post['address']);
	$address2=real_escape_string($post['address2']);
	$city=real_escape_string($post['city']);
	$state=real_escape_string($post['state']);
	$postcode=real_escape_string($post['postcode']);
	
	if($order_id && $pickup_date && $pickup_time && $address && $city && $state && $postcode) {
		if($order_id) {
			$order_data = get_order_data($order_id);
			if(empty($order_data)) {
				$msg='This order number is not exist in our system so please contact our support guys.';
				setRedirectWithMsg($return_url,$msg,'warning');
				exit();
			}
		}

		$query=mysqli_query($db,"UPDATE orders SET pickup_date='".$pickup_date."', pickup_time='".$pickup_time."', pickup_address='".$address."', pickup_address2='".$address2."', pickup_city='".$city."', pickup_state='".$state."', pickup_postcode='".$postcode."' WHERE order_id='".$order_id."' AND order_id!=''");
		$last_insert_id = mysqli_insert_id($db);
		if($query=="1") {
			$msg="Your pickup informations successfully saved.";
			setRedirectWithMsg($return_url,$msg,'success');
		} else {
			$msg='Sorry, something went wrong';
			setRedirectWithMsg($return_url,$msg,'danger');
		}
	} else {
		$msg='Please fill in all required fields.';
		setRedirectWithMsg($return_url,$msg,'warning');
	}
	exit();
} else {
	$msg='Direct access denied';
	setRedirectWithMsg(SITE_URL,$msg,'danger');
	exit();
} ?>