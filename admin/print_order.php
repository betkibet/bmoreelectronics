<?php
//Header section
include("include/header.php"); 

$order_id = $post['order_id'];

//Get order batch data, path of this function (get_order_data) admin/include/functions.php
$order_data = get_order_data($order_id);

//Get order price based on orderID, path of this function (get_order_price) admin/include/functions.php
$sum_of_orders=get_order_price($order_id);

//Get order item list based on orderID, path of this function (get_order_item_list) admin/include/functions.php
$order_item_list = get_order_item_list($order_id);
$order_num_of_rows = count($order_item_list);

//Order data gathering
if($order_data['promocode_id']>0 && $order_data['promocode_amt']>0) {
	$promocode_amt = $order_data['promocode_amt'];
	$discount_amt_label = "Surcharge:";
	if($order_data['discount_type']=="percentage")
		$discount_amt_label = "Surcharge (".$order_data['discount']."% of Initial Quote):";
	 
	$total_of_order = $sum_of_orders+$order_data['promocode_amt'];
	$is_promocode_exist = true;
} else {
	$total_of_order = $sum_of_orders;
}

//Template file
require_once("views/print_order.php");

//Footer section
require_once("include/footer.php"); ?>