<?php
$file_name="email_template";

//Header section
require_once("include/header.php");

if($post['id']<=0 && $prms_emailtmpl_add!='1') {
	setRedirect(ADMIN_URL.'profile.php');
	exit();
} elseif($post['id']>0 && $prms_emailtmpl_edit!='1') {
	setRedirect(ADMIN_URL.'profile.php');
	exit();
}

//Fetch single mail template data based on id
$query=mysqli_query($db,'SELECT * FROM mail_templates WHERE id="'.$post['id'].'"');
$template_data=mysqli_fetch_assoc($query);
$template_data = _dt_parse_array($template_data);

//get fixed template type with respective template constants
include("include/template_type_with_constants.php");

//Array of allow sms section in mail template
$sms_sec_show_in_tmpl_array = array('admin_reply_from_order','admin_reply_from_offer','new_order_email_to_customer','customer_profile_edit_from_admin','order_expiring','order_expired','signup_verification_for_email','new_order_email_to_customer_send_me_label','new_order_email_to_customer_courier_collection','new_order_email_to_customer_own_method');

//Gather mail template data from fixed type (template_type_with_constants.php)
$already_added_template_type = array();
$get_already_added_template_type_query = mysqli_query($db,'SELECT type FROM mail_templates');
while($get_already_added_template_type_row=mysqli_fetch_assoc($get_already_added_template_type_query)) {
	$already_added_template_type[$get_already_added_template_type_row['type']] = $get_already_added_template_type_row['type'];
}

$template_type_final_array = array_diff_key($template_type_array, $already_added_template_type);
if(empty($template_type_final_array) && $post['id']=="") {
	//header('Location: email_templates.php');
}

$order_status_list = get_order_status_data('order_status')['list'];
//$order_item_status_list = get_order_status_data('order_item_status')['list'];

if(!isset($template_data['id'])) {
	$template_data['id'] = "";
}
if(!isset($template_data['subject'])) {
	$template_data['subject'] = "";
}
if(!isset($template_data['content'])) {
	$template_data['content'] = "";
}
if(!isset($template_data['sms_status'])) {
	$template_data['sms_status'] = "";
}
if(!isset($template_data['sms_content'])) {
	$template_data['sms_content'] = "";
}
if(!isset($template_data['status'])) {
	$template_data['status'] = "";
}

//Template file
require_once("views/email_template/edit_email_template.php"); ?>

