<?php
$file_name="affiliate";

//Header section
require_once("include/header.php");

$affiliate_id = $post['id'];

//Fetch single user data based user id
$affiliate_data = get_affiliate_data_by_id($affiliate_id);
if(empty($affiliate_data)) {
	//setRedirect(ADMIN_URL.'affiliates.php');
	//exit();
}

if(isset($_SESSION['affiliate_prefill_data'])) {
	$affiliate_data = $_SESSION['affiliate_prefill_data'];
	unset($_SESSION['affiliate_prefill_data']);
}

if(!isset($affiliate_data['name'])) {
	$affiliate_data['name'] = "";
}
if(!isset($affiliate_data['email'])) {
	$affiliate_data['email'] = "";
}
if(!isset($affiliate_data['company'])) {
	$affiliate_data['company'] = "";
}
if(!isset($affiliate_data['web_address'])) {
	$affiliate_data['web_address'] = "";
}
if(!isset($affiliate_data['message'])) {
	$affiliate_data['message'] = "";
}
if(!isset($affiliate_data['status'])) {
	$affiliate_data['status'] = "";
}
if(!isset($affiliate_data['shop_name'])) {
	$affiliate_data['shop_name'] = "";
}
if(!isset($affiliate_data['id'])) {
	$affiliate_data['id'] = "";
}
if(!isset($affiliate_data['phone'])) {
	$affiliate_data['phone'] = "";
}

//Template file
require_once("views/edit_affiliate.php"); ?>
