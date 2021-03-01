<?php
require_once("../admin/_config/config.php");
require_once("../admin/include/functions.php");
require_once("common.php");

$email = $_POST['email'];
if($email!="") {
	$response = array();

	$is_exist_data = false;
	$query=mysqli_query($db,"SELECT * FROM `users` WHERE status='1'");
	while($user_data = mysqli_fetch_assoc($query)) {
		$paypal_address = '';
		$payment_method_details = json_decode($user_data['payment_method_details'],true);
		$paypal_address = $payment_method_details['data']['paypal']['paypal_address'];
		if($paypal_address!="" && $paypal_address == $email) {
			$is_exist_data = true;
		}
	}

	if($is_exist_data) {
		$response['msg'] = 'This email address already exist in system.<br>Please click <a class="paypal_address_login" href="javascript:void(0);"><strong>here</strong></a> &nbsp; to login OR change paypal';
		$response['exist'] = true;
	} else {
		$response['msg'] = "";
		$response['exist'] = false;
	}
} else {
	$response['msg'] = "";
	$response['exist'] = false;
}
echo json_encode($response);
?>