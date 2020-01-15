<?php
$file_name="email_template";

//Header section
require_once("include/header.php");

//Fetch single mail template data based on id
$query=mysqli_query($db,'SELECT * FROM mail_templates WHERE id="'.$post['id'].'"');
$template_data=mysqli_fetch_assoc($query);

//get fixed template type with respective template constants
include("include/template_type_with_constants.php");

//Array of allow sms section in mail template
$sms_sec_show_in_tmpl_array = array('admin_reply_from_order','admin_reply_from_offer','new_order_email_to_customer','customer_profile_edit_from_admin','order_expiring','order_expired','signup_verification_for_email');

//Gather mail template data from fixed type (template_type_with_constants.php)
$already_added_template_type = array();
$get_already_added_template_type_query = mysqli_query($db,'SELECT type FROM mail_templates');
while($get_already_added_template_type_row=mysqli_fetch_assoc($get_already_added_template_type_query)) {
	$already_added_template_type[$get_already_added_template_type_row['type']] = $get_already_added_template_type_row['type'];
}
$template_type_final_array = array_diff_key($template_type_array, $already_added_template_type);

if(empty($template_type_final_array) && $post['id']=="") {
	header('Location: email_templates.php');
}

//Template file
require_once("views/email_template/edit_email_template.php");

//Footer section
// require_once("include/footer.php"); ?>
