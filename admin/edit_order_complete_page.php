<?php 
$file_name="order_complete_page";

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

//Fetch signle editable order_complete_page data
$q=mysqli_query($db,'SELECT * FROM order_complete_pages WHERE id="'.$id.'"');
$order_complete_page_data=mysqli_fetch_assoc($q);
//$order_complete_page_data = _dt_parse_array($order_complete_page_data);

$success_page_content = json_decode($order_complete_page_data['content_fields'],true);
if(empty($success_page_content['heading'])) {
	$success_page_content['heading'] = '';
}
if(empty($success_page_content['sub_heading'])) {
	$success_page_content['sub_heading'] = '';
}
if(empty($success_page_content['intro_text'])) {
	$success_page_content['intro_text'] = '';
}
if(empty($success_page_content['step_heading'])) {
	$success_page_content['step_heading'] = '';
}
if(empty($success_page_content['step_sub_heading'])) {
	$success_page_content['step_sub_heading'] = '';
}
if(empty($success_page_content['step1_title'])) {
	$success_page_content['step1_title'] = '';
}
if(empty($success_page_content['step1_instruction'])) {
	$success_page_content['step1_instruction'] = '';
}
if(empty($success_page_content['step2_title'])) {
	$success_page_content['step2_title'] = '';
}
if(empty($success_page_content['step2_instruction'])) {
	$success_page_content['step2_instruction'] = '';
}
if(empty($success_page_content['step3_title'])) {
	$success_page_content['step3_title'] = '';
}
if(empty($success_page_content['step3_instruction'])) {
	$success_page_content['step3_instruction'] = '';
}

if(isset($_SESSION['order_complete_page_prefill_data'])) {
	$order_complete_page_data = $_SESSION['order_complete_page_prefill_data'];
	unset($_SESSION['order_complete_page_prefill_data']);
}

//Template file
require_once("views/order_complete_page/edit_order_complete_page.php"); ?>

