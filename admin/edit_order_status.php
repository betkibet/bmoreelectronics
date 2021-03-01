<?php 
$file_name="order_status";

//Header section
require_once("include/header.php");

$id = $post['id'];

if($id<=0 && $prms_order_add!='1') {
	setRedirect(ADMIN_URL.'profile.php');
	exit();
} elseif($id>0 && $prms_order_edit!='1') {
	setRedirect(ADMIN_URL.'profile.php');
	exit();
}

//Fetch signle editable order_status data
$q=mysqli_query($db,'SELECT * FROM order_status WHERE id="'.$id.'"');
$order_status_data=mysqli_fetch_assoc($q);
$order_status_data = _dt_parse_array($order_status_data);

if(isset($_SESSION['order_status_prefill_data'])) {
	$order_status_data = $_SESSION['order_status_prefill_data'];
	unset($_SESSION['order_status_prefill_data']);
}

//Template file
require_once("views/status/edit_order_status.php"); ?>

