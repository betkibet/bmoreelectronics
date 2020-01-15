<?php
$file_name="general_settings";

//Header section
require_once("include/header.php");

//Fetch general settings data
$query=mysqli_query($db,'SELECT * FROM general_setting ORDER BY id DESC');
$general_setting_data=mysqli_fetch_assoc($query);
$display_terms = (array)json_decode($general_setting_data['display_terms']);
$currency = @explode(",",$general_setting_data['currency']);
$payment_option = (array)json_decode($general_setting_data['payment_option']);
$sales_pack = (array)json_decode($general_setting_data['sales_pack']);
$shipping_option = (array)json_decode($general_setting_data['shipping_option']);
$page_list_limit = $general_setting_data['page_list_limit'];
$captcha_settings = (array)json_decode($general_setting_data['captcha_settings']);
$other_settings = (array)json_decode($general_setting_data['other_settings']);

//Template file
require_once("views/general_settings.php");

//Footer section
// require_once("include/footer.php"); ?>

