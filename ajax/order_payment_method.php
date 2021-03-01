<?php
require_once("../admin/_config/config.php");
require_once("../admin/include/functions.php");
require_once("common.php");

$user_id = $_SESSION['user_id'];
$guest_user_id = $_SESSION['guest_user_id'];
$order_id = $_SESSION['order_id'];

$response = array();
if(($user_id>0 || $guest_user_id>0) && $order_id) {

	if($user_id>0) {
		$user_data = get_user_data($user_id);
	} elseif($guest_user_id>0) {
		$user_data = get_user_data($guest_user_id);
	}

	$act_name = $post['act_name'];
	$act_number = $post['act_number'];
	$act_short_code = $post['act_short_code'];
	$paypal_address = $post['paypal_address'];
	$venmo_address = $post['venmo_address'];
	$zelle_address = $post['zelle_address'];
	$amazon_gcard_address = $post['amazon_gcard_address'];
	$cash_app_address = $post['cash_app_address'];
	$apple_pay_address = $post['apple_pay_address'];
	$google_pay_address = $post['google_pay_address'];
	$coinbase_address = $post['coinbase_address'];
	$facebook_pay_address = $post['facebook_pay_address'];

	$payment_method_details_arr = array();
	$payment_method = $post['payment_method'];
	$_SESSION['payment_method'] = $payment_method;
	if($payment_method == "bank") {
		$payment_method_details_arr = array('account_holder_name'=>$act_name,'account_number'=>$act_number,'short_code'=>$act_short_code);
	} elseif($payment_method == "paypal") {
		$payment_method_details_arr = array('paypal_address'=>$paypal_address);
	} elseif($payment_method == "venmo") {
		$payment_method_details_arr = array('venmo_address'=>$venmo_address);
	} elseif($payment_method == "zelle") {
		$payment_method_details_arr = array('zelle_address'=>$zelle_address);
	} elseif($payment_method == "amazon_gcard") {
		$payment_method_details_arr = array('amazon_gcard_address'=>$amazon_gcard_address);
	} elseif($payment_method == "cash_app") {
		$payment_method_details_arr = array('cash_app_address'=>$cash_app_address);
	} elseif($payment_method == "apple_pay") {
		$payment_method_details_arr = array('apple_pay_address'=>$apple_pay_address);
	} elseif($payment_method == "google_pay") {
		$payment_method_details_arr = array('google_pay_address'=>$google_pay_address);
	} elseif($payment_method == "coinbase") {
		$payment_method_details_arr = array('coinbase_address'=>$coinbase_address);
	} elseif($payment_method == "facebook_pay") {
		$payment_method_details_arr = array('facebook_pay_address'=>$facebook_pay_address);
	} elseif($payment_method == "cash") {
		$cash_phone = preg_replace("/[^\d]/", "", $post['f_cash_phone']);
		$payment_method_details_arr = array('cash_name'=>$post['cash_name'],'cash_phone'=>$cash_phone);
	}
	$payment_method_details = json_encode($payment_method_details_arr);

	$q = mysqli_query($db,"UPDATE `orders` SET `payment_method`='".$payment_method."',`payment_method_details`='".$payment_method_details."' WHERE order_id='".$order_id."'");
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