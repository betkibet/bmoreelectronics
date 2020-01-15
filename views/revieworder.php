<?php
//Header section
include("include/header.php");

//Selected default payment method from mobile detail page
$select_payment_method = trim($_SESSION['payment_method']);
if($select_payment_method!="") {
	$default_payment_option = $select_payment_method;
}

//Get order price based on orderID, path of this function (get_order_price) admin/include/functions.php
$sum_of_orders=get_order_price($order_id);

//Get order item list based on orderID, path of this function (get_order_item_list) admin/include/functions.php
$order_item_list = get_order_item_list($order_id);
$order_num_of_rows = count($order_item_list);

//Get order batch data, path of this function (get_order_data) admin/include/functions.php
$order_data = get_order_data($order_id);

//Confirm order section
if($post['action']=="confirm") {
	if($user_id<=0) {
		$msg='Direct access denied. You must need to login';
		setRedirectWithMsg(SITE_URL,$msg,'danger');
		exit();
	}
	
	//Include confirm review order view
	require_once('views/revieworder/confirm.php');
}

//Review order section
elseif($order_num_of_rows>0) {
	//Include review order view
	require_once('views/revieworder/review.php');
} 

//If your sales basket is empty section
else {
	//Include empty sales basket view
	require_once('views/revieworder/empty_basket.php');
} ?>
