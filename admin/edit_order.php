<?php
$file_name="edit_order";

//Header section
require_once("include/header.php");

if(!isset($post['order_mode'])) {
	$post['order_mode'] = "";
}

$order_id = $post['order_id'];

//Fetch order data based on order id
$order_data_before_saved = get_order_data($order_id);
//$order_data_before_saved = _dt_parse_array($order_data_before_saved);

if(!$order_id || empty($order_data_before_saved)) {
	setRedirect(ADMIN_URL.'orders.php');
	exit();
}

if($prms_order_edit!='1') {
	setRedirect(ADMIN_URL.'profile.php');
	exit();
}

//Get order item list based on orderID, path of this function (get_order_item_list) admin/include/functions.php
$order_item_list = get_order_item_list($order_id);
$order_num_of_rows = count($order_item_list);

//Get order price based on orderID, path of this function (get_order_price) admin/include/functions.php
$sum_of_orders=get_order_price($order_id);

//Order data gathering
$promocode_amt = 0;
$discount_amt_label = "";
if($order_data_before_saved['promocode_id']>0 && $order_data_before_saved['promocode_amt']>0) {
	$promocode_amt = $order_data_before_saved['promocode_amt'];
	$discount_amt_label = "Surcharge:";
	if($order_data_before_saved['discount_type']=="percentage")
		$discount_amt_label = "Surcharge (".$order_data_before_saved['discount']."% of Initial Quote):";

	$total_of_order = $sum_of_orders+$order_data_before_saved['promocode_amt'];
} else {
	$total_of_order = $sum_of_orders;
}

$express_service = $order_data_before_saved['express_service'];
$express_service_price = $order_data_before_saved['express_service_price'];
$shipping_insurance = $order_data_before_saved['shipping_insurance'];
$shipping_insurance_per = $order_data_before_saved['shipping_insurance_per'];

$f_express_service_price = 0;
$f_shipping_insurance_price = 0;
if($express_service == '1') {
	$f_express_service_price = $express_service_price;
}
if($shipping_insurance == '1') {
	$f_shipping_insurance_price = ($sum_of_orders*$shipping_insurance_per/100);
}

if($f_express_service_price>0 || $f_shipping_insurance_price>0) {
	$total_of_order = ($total_of_order - $f_express_service_price - $f_shipping_insurance_price);
}

$template_data = get_template_data('admin_reply_from_order');
$general_setting_data = get_general_setting_data();
$admin_user_data = get_admin_user_data();
$order_data = get_order_data($order_id);

$order_status_list = get_order_status_data('order_status')['list'];
$order_item_status_list = get_order_status_data('order_item_status')['list'];

$patterns = array(
	'{$logo}',
	'{$admin_logo}',
	'{$admin_email}',
	'{$admin_username}',
	'{$admin_site_url}',
	'{$admin_panel_name}',
	'{$from_name}',
	'{$from_email}',
	'{$site_url}',
	'{$customer_fname}',
	'{$customer_lname}',
	'{$customer_fullname}',
	'{$customer_phone}',
	'{$customer_email}',
	'{$billing_address1}',
	'{$billing_address2}',
	'{$billing_city}',
	'{$billing_state}',
	'{$customer_country}',
	'{$billing_postcode}',
	'{$customer_company_name}',
	'{$order_id}',
	'{$order_payment_method}',
	'{$order_date}',
	'{$order_approved_date}',
	'{$order_expire_date}',
	'{$order_sales_pack}',
	'{$current_date_time}');

$replacements = array(
	$logo,
	$admin_logo,
	$admin_user_data['email'],
	$admin_user_data['username'],
	ADMIN_URL,
	$general_setting_data['admin_panel_name'],
	$general_setting_data['from_name'],
	$general_setting_data['from_email'],
	SITE_URL,
	$order_data['first_name'],
	$order_data['last_name'],
	$order_data['name'],
	$order_data['phone'],
	$order_data['email'],
	$order_data['address'],
	$order_data['address2'],
	$order_data['city'],
	$order_data['state'],
	$order_data['country'],
	$order_data['postcode'],
	$order_data['company_name'],
	$order_data['order_id'],
	$order_data['payment_method'],
	$order_data['order_date'],
	$order_data['approved_date'],
	$order_data['expire_date'],
	$order_data['sales_pack'],
	date('Y-m-d H:i'));

$email_subject = str_replace($patterns,$replacements,$template_data['subject']);
$email_body_text = str_replace($patterns,$replacements,$template_data['content']);

$ac_query=mysqli_query($db,"SELECT c.*, ca.contractor_id, ca.order_id, ca.amount FROM contractors AS c LEFT JOIN contractor_orders AS ca ON ca.contractor_id=c.id WHERE ca.order_id='".$order_id."'");
$assigned_contractor_data = mysqli_fetch_assoc($ac_query);

$comment_query=mysqli_query($db,"SELECT c.*, aps.name AS status_name FROM comments AS c LEFT JOIN order_status AS aps ON aps.id=c.order_status WHERE c.order_id='".$order_id."' ORDER BY c.id DESC");
$num_of_comment = mysqli_num_rows($comment_query);

//Template file
require_once("views/order/edit_order.php"); ?>
