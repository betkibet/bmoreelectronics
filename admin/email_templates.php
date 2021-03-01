<?php 
$file_name="email_template";

//Header section
require_once("include/header.php");

//Get fixed template type with respective template constants
require_once("include/template_type_with_constants.php");

$mysql_params = "";
if($post['filter_by'] == "to_admin") {
	$mysql_params = " AND type IN('customer_reply_from_offer','new_order_email_to_admin','contact_form_alert','review_form_alert','bulk_order_form_alert','quote_request_form_alert','affiliate_form_alert','newsletter_form_alert')";
}
elseif($post['filter_by'] == "to_customer") {
	$mysql_params = " AND type IN('admin_reply_from_order','admin_reply_from_offer','reset_password','new_order_email_to_customer_send_me_label','new_order_email_to_customer_courier_collection','new_order_email_to_customer_own_method','signup_verification_for_email','customer_profile_edit_from_admin','review_thank_you_email_to_customer','bulk_order_thank_you_email_to_customer','order_expiring','order_expired','shipment_label_email_to_customer','newsletter_thank_you_email_to_customer','order_item_status_waiting_shipment_from_admin','order_item_status_absent_from_admin','order_item_status_checked_from_admin','order_item_status_price_is_reduced_from_admin','order_item_status_price_is_accepted_from_admin','order_item_status_price_is_declined_from_admin','order_item_status_returned_from_admin','order_item_status_paid_from_admin')";
}
elseif($post['filter_by'] != "") {
	$mysql_params = " AND type='".$post['filter_by']."'";
}

$tmpl_p_query=mysqli_query($db,"SELECT COUNT(*) AS num_of_records FROM mail_templates WHERE 1 ".$mysql_params."");
$tmpl_p_data = mysqli_fetch_assoc($tmpl_p_query);
$pages->set_total($tmpl_p_data['num_of_records']);

//Fetch data list of saved mail templates
$query="SELECT * FROM mail_templates WHERE 1 ".$mysql_params." ORDER BY id ASC ".$pages->get_limit();
$result = mysqli_query($db,$query);

//Gather mail template data from fixed type (template_type_with_constants.php)
$already_added_template_type = array();
$get_already_added_template_type_query = mysqli_query($db,"SELECT type FROM mail_templates WHERE 1 ".$mysql_params."");
while($get_already_added_template_type_row=mysqli_fetch_assoc($get_already_added_template_type_query)) {
	$already_added_template_type[$get_already_added_template_type_row['type']] = $get_already_added_template_type_row['type'];
}
$template_type_final_array = array_diff_key($template_type_array, $already_added_template_type);
$num_of_rows = mysqli_num_rows($result);

$order_status_list = get_order_status_data('order_status')['list'];
//$order_item_status_list = get_order_status_data('order_item_status')['list'];

//Template file
require_once("views/email_template/email_templates.php");

//Footer section
require_once("include/footer.php"); ?>
