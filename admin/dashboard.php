<?php 
$file_name="dashboard";

//Header section
require_once("include/header.php");

$data_list = array();

$user_query=mysqli_query($db,"SELECT COUNT(*) AS num_of_users, status FROM users GROUP BY status");
$num_of_user_rows = mysqli_num_rows($user_query);

$mobile_query=mysqli_query($db,"SELECT * FROM mobile");
$num_of_mobile_rows = mysqli_num_rows($mobile_query);

$device_query=mysqli_query($db,"SELECT * FROM devices");
$num_of_device_rows = mysqli_num_rows($device_query);

$brand_query=mysqli_query($db,"SELECT * FROM brand");
$num_of_brand_rows = mysqli_num_rows($brand_query);

$category_query=mysqli_query($db,"SELECT * FROM categories");
$num_of_category_rows = mysqli_num_rows($category_query);

//User ID, Contractor ID Params Of This Function
$order_reports_data = get_order_reports(0, 0);
$num_of_order_rows = $order_reports_data['num_of_order_rows'];
$num_of_awaiting_orders = $order_reports_data['num_of_awaiting_orders'];
$num_of_unpaid_orders = $order_reports_data['num_of_unpaid_orders'];
$num_of_paid_orders = $order_reports_data['num_of_paid_orders'];
$num_of_archive_orders = $order_reports_data['num_of_archive_orders'];

//Template file
require_once("views/dashboard.php");

//Footer section
require_once("include/footer.php"); ?>
