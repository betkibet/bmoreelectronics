<?php
$file_name="archive_orders";

//Header section
require_once("include/header.php");

if(isset($_POST['search'])) {
	$_SESSION['archive_o_filter_data'] = array('filter_by'=>$post['filter_by'],'from_date'=>$post['from_date'],'to_date'=>$post['to_date'],'status'=>$post['status'],'is_payment_sent'=>$post['is_payment_sent'],'payment_paid_batch_id'=>$post['payment_paid_batch_id']);
	setRedirect(ADMIN_URL.'archive_orders.php');
}

if(isset($_GET['clear'])) {
	unset($_SESSION['archive_o_filter_data']);
	setRedirect(ADMIN_URL.'archive_orders.php');
}

if(isset($_SESSION['archive_o_filter_data'])) {
	$model_filter_data = $_SESSION['archive_o_filter_data'];
	$post['filter_by'] = $model_filter_data['filter_by'];
	$post['from_date'] = $model_filter_data['from_date'];
	$post['to_date'] = $model_filter_data['to_date'];
	$post['status'] = $model_filter_data['status'];
	$post['is_payment_sent'] = $model_filter_data['is_payment_sent'];
	$post['payment_paid_batch_id'] = $model_filter_data['payment_paid_batch_id'];
}

//Filter by
$filter_by = "";
if($post['payment_paid_batch_id']!='') {
	$filter_by .= " AND o.payment_paid_batch_id='".$post['payment_paid_batch_id']."'";
}

if($post['is_payment_sent']!='') {
	$filter_by .= " AND o.is_payment_sent='".$post['is_payment_sent']."'";
}

if($post['filter_by']) {
	$filter_by .= " AND (o.order_id LIKE '%".$post['filter_by']."%' OR o.id LIKE '%".$post['filter_by']."%'  OR u.name LIKE '%".$post['filter_by']."%' OR u.email LIKE '%".$post['filter_by']."%' OR u.phone LIKE '%".$post['filter_by']."%' OR u.username LIKE '%".$post['filter_by']."%')";
}

if($post['user_id']) {
	$filter_by .= " AND o.user_id='".$post['user_id']."'";
}

if($post['contractor_id']) {
	$filter_by .= " AND ca.contractor_id='".$post['contractor_id']."'";
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

$order_by = "";
if($post['oid_shorting']) {
	$order_by .= " ORDER BY o.order_id ".$post['oid_shorting'];
} elseif($post['date_shorting']) {
	$order_by .= " ORDER BY o.date ".$post['date_shorting'];
} else {
	$order_by .= " ORDER BY o.id DESC";
}

//Get num of orders for pagination
$order_p_query=mysqli_query($db,"SELECT COUNT(*) AS num_of_orders, o.order_id, u.first_name, u.last_name, ca.contractor_id FROM orders AS o LEFT JOIN users AS u ON u.id=o.user_id LEFT JOIN contractor_orders AS ca ON o.order_id=ca.order_id WHERE o.status!='partial' AND o.is_trash='1' ".$filter_by);
$order_p_data = mysqli_fetch_assoc($order_p_query);
$pages->set_total($order_p_data['num_of_orders']);

//Fetch list of order
$order_query=mysqli_query($db,"SELECT o.*, u.first_name, u.last_name, p.shop_name as aflt_shop_name, os.name AS order_status_name, c.name as contractor_name, ca.contractor_id FROM orders AS o LEFT JOIN users AS u ON u.id=o.user_id LEFT JOIN affiliate AS p ON p.id=o.affiliate_id LEFT JOIN order_status AS os ON os.id=o.status LEFT JOIN contractor_orders AS ca ON o.order_id=ca.order_id LEFT JOIN contractors AS c ON ca.contractor_id=c.id WHERE o.status!='partial' AND o.is_trash='1' ".$filter_by." ".$order_by." ".$pages->get_limit());

$order_paid_batch_q=mysqli_query($db,"SELECT o.*, u.first_name, u.last_name FROM orders AS o LEFT JOIN users AS u ON u.id=o.user_id WHERE o.status!='partial' AND o.is_trash='1' AND o.payment_paid_batch_id!='' GROUP BY o.payment_paid_batch_id ORDER BY o.date DESC");

$url_params_array = array(
	'oid_shorting' => $post['oid_shorting'],
	'date_shorting' => $post['date_shorting'],
	'filter_by' => $post['filter_by'],
	'from_date' => $post['from_date'],
	'to_date' => $post['to_date'],
	'status' => $post['status']
);

unset($url_params_array['oid_shorting']);
unset($url_params_array['date_shorting']);

$url_params = http_build_query($url_params_array);
$url_params = ($url_params?'&'.$url_params:'');

$shorting_label = 'Select to sort by this column';

$order_status_list = get_order_status_data('order_status')['list'];
//$order_item_status_list = get_order_status_data('order_item_status')['list'];

//Template file
require_once("views/order/archive_orders.php"); ?>
