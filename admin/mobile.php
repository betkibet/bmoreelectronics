<?php
$file_name="mobile";

//Header section
require_once("include/header.php");

//Filter by users based on title, device
$filter_by = "";
if($post['filter_by']) {
	$filter_by .= " AND (m.title LIKE '%".real_escape_string($post['filter_by'])."%')";
}

if($post['cat_id']) {
	$filter_by .= " AND m.cat_id = '".$post['cat_id']."'";
}

if($post['brand_id']) {
	$filter_by .= " AND m.brand_id = '".$post['brand_id']."'";
}

if($post['device_id']) {
	$filter_by .= " AND m.device_id = '".$post['device_id']."'";
}

//Get num of mobile (model) for pagination
$mobile_p_query=mysqli_query($db,"SELECT COUNT(*) AS num_of_models FROM mobile WHERE 1 ".$filter_by."");
$mobile_p_data = mysqli_fetch_assoc($mobile_p_query);
$pages->set_total($mobile_p_data['num_of_models']);

//Fetch mobile (model) with assigned device
$query=mysqli_query($db,"SELECT m.*, d.title AS device_title, d.sef_url, b.title AS brand_title, c.title AS cat_title FROM mobile AS m LEFT JOIN devices AS d ON d.id=m.device_id LEFT JOIN brand AS b ON b.id=m.brand_id LEFT JOIN categories AS c ON c.id=m.cat_id WHERE 1 ".$filter_by." ".$pages->get_limit()."");

//Fetch device list
$devices_data=mysqli_query($db,'SELECT * FROM devices WHERE published=1');

//Fetch list of published brand
$brands_data=mysqli_query($db,'SELECT * FROM brand WHERE published=1');

//Fetch list of published category
$categories_data=mysqli_query($db,'SELECT * FROM categories WHERE published=1');

//Template file
require_once("views/mobile/mobile.php");

//Footer section
//include("include/footer.php"); ?>
