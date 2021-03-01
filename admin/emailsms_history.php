<?php
$file_name="emailsms_history";

//Header section
require_once("include/header.php");

if(isset($_POST['search'])) {
	$_SESSION['emailsms_hist_filter_data'] = array('filter_by'=>$post['filter_by'],'order_id'=>$post['order_id']);
	setRedirect(ADMIN_URL.'emailsms_history.php');
}

if(isset($_GET['clear'])) {
	unset($_SESSION['emailsms_hist_filter_data']);
	setRedirect(ADMIN_URL.'emailsms_history.php');
}

if(isset($_SESSION['emailsms_hist_filter_data'])) {
	$emailsms_hist_filter_data = $_SESSION['emailsms_hist_filter_data'];
	$post['filter_by'] = $emailsms_hist_filter_data['filter_by'];
	$post['order_id'] = $emailsms_hist_filter_data['order_id'];
}

//Filter by
$filter_by = "";
if($post['filter_by']) {
	$filter_by .= " AND (order_id LIKE '%".$post['filter_by']."' OR to_email LIKE '%".$post['filter_by']."'  OR sms_phone LIKE '%".$post['filter_by']."')";
}
if($post['order_id']) {
	$filter_by .= " AND order_id = '".$post['order_id']."'";
}

//Get num of contact/request quote submitted form for pagination
$user_p_query=mysqli_query($db,"SELECT COUNT(*) AS num_of_orders FROM inbox_mail_sms WHERE 1  ".$filter_by."");
$user_p_data = mysqli_fetch_assoc($user_p_query);
$pages->set_total($user_p_data['num_of_orders']);

//Fetch list of contact/request quote submitted form
$query=mysqli_query($db,"SELECT * FROM inbox_mail_sms WHERE  1 ".$filter_by." ORDER BY id DESC ".$pages->get_limit()."");

//Fetch list of order
$order_query=mysqli_query($db,"SELECT o.*, u.first_name, u.last_name FROM orders AS o LEFT JOIN users AS u ON u.id=o.user_id WHERE o.status!='partial' GROUP BY o.order_id ORDER BY o.date DESC");

//Template file
require_once("views/emailsms_history.php");

//Footer section
require_once("include/footer.php"); ?>