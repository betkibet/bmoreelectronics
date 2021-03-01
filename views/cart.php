<?php
$meta_title = "Review Order";

//Header section
include("include/header.php");

//Fetching data from model
require_once('models/model.php');

//Selected default payment method from mobile detail page
$select_payment_method = isset($_SESSION['payment_method'])?$_SESSION['payment_method']:'';
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

//Review order section
if($order_num_of_rows>0) {
	//Include review order view
	require_once('views/cart/cart.php');
} 

//If your sales basket is empty section
else {
	//Include empty sales basket view
	require_once('views/cart/empty_basket.php');
} ?>
