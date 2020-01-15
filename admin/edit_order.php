<?php
$file_name="orders";

//Header section
require_once("include/header.php");

$order_id = $post['order_id'];

//Fetch order data based on order id
$order_data_before_saved = get_order_data($order_id);

if(!$order_id || empty($order_data_before_saved)) {
	setRedirect(ADMIN_URL.'orders.php');
	exit();
}

//Get order item list based on orderID, path of this function (get_order_item_list) admin/include/functions.php
$order_item_list = get_order_item_list($order_id);
$order_num_of_rows = count($order_item_list);

//Get order price based on orderID, path of this function (get_order_price) admin/include/functions.php
$sum_of_orders=get_order_price($order_id);

//Order data gathering
if($order_data_before_saved['promocode_id']>0 && $order_data_before_saved['promocode_amt']>0) {
	$promocode_amt = $order_data_before_saved['promocode_amt'];
	$discount_amt_label = "Surcharge:";
	if($order_data_before_saved['discount_type']=="percentage")
		$discount_amt_label = "Surcharge (".$order_data_before_saved['discount']."% of Initial Quote):";

	$total_of_order = $sum_of_orders+$order_data_before_saved['promocode_amt'];
} else {
	$total_of_order = $sum_of_orders;
}

$template_data = get_template_data('admin_reply_from_order');
$general_setting_data = get_general_setting_data();
$admin_user_data = get_admin_user_data();
$order_data = get_order_data($order_id);

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
	'{$customer_address_line1}',
	'{$customer_address_line2}',
	'{$customer_city}',
	'{$customer_state}',
	'{$customer_country}',
	'{$customer_postcode}',
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

//Template file
require_once("views/order/edit_order.php");

//Footer section
// include("include/footer.php"); ?>
