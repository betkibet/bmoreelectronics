<?php
$file_name="orders";

//Header section
require_once("include/header.php");

//Filter by
if($post['filter_by']) {
	$filter_by = " AND (o.order_id LIKE '%".$post['filter_by']."%' OR o.id LIKE '%".$post['filter_by']."%'  OR u.name LIKE '%".$post['filter_by']."%' OR u.email LIKE '%".$post['filter_by']."%' OR u.phone LIKE '%".$post['filter_by']."%' OR u.username LIKE '%".$post['filter_by']."%')";
}

if($post['user_id']) {
	$filter_by .= " AND o.user_id='".$post['user_id']."'";
}

if($post['status']) {
	$filter_by .= " AND o.status='".$post['status']."'";
}

if($post['from_date'] != "" && $post['to_date'] != "") {
	$exp_from_date = explode("/",$post['from_date']);
	$from_date = $exp_from_date['2'].'-'.$exp_from_date['0'].'-'.$exp_from_date['1'];
	
	$exp_to_date = explode("/",$post['to_date']);
	$to_date = $exp_to_date['2'].'-'.$exp_to_date['0'].'-'.$exp_to_date['1'];
	
	$filter_by .= " AND (DATE_FORMAT(o.date,'%Y-%m-%d')>='".$from_date."' AND DATE_FORMAT(o.date,'%Y-%m-%d')<='".$to_date."')";
} elseif($post['from_date'] != "") {
	$exp_from_date = explode("/",$post['from_date']);
	$from_date = $exp_from_date['2'].'-'.$exp_from_date['0'].'-'.$exp_from_date['1'];
	$filter_by .= " AND DATE_FORMAT(o.date,'%Y-%m-%d')='".$from_date."'";
} elseif($post['to_date'] != "") {
	$exp_to_date = explode("/",$post['to_date']);
	$to_date = $exp_to_date['2'].'-'.$exp_to_date['0'].'-'.$exp_to_date['1'];
	$filter_by .= " AND DATE_FORMAT(o.date,'%Y-%m-%d')='".$to_date."'";
}

//Get num of orders for pagination
$order_p_query=mysqli_query($db,"SELECT COUNT(*) AS num_of_orders, o.order_id, u.first_name, u.last_name FROM orders AS o LEFT JOIN users AS u ON u.id=o.user_id WHERE o.status!='partial' ".$filter_by." ORDER BY o.date DESC");
$order_p_data = mysqli_fetch_assoc($order_p_query);
$pages->set_total($order_p_data['num_of_orders']);

//Fetch list of order
$order_query=mysqli_query($db,"SELECT o.*, u.first_name, u.last_name, p.store_name as p_store_name FROM orders AS o LEFT JOIN users AS u ON u.id=o.user_id LEFT JOIN partners AS p ON p.id=o.partner_id WHERE o.status!='partial' ".$filter_by." ORDER BY o.date DESC ".$pages->get_limit()."");

//Template file
require_once("views/order/orders.php");

//Footer section
// include("include/footer.php"); ?>
