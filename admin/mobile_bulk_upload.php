<?php
$file_name="mobile_bulk_upload";

//Header section
require_once("include/header.php");

//Filter by users based on title, device
$filter_by = "";
if($post['filter_by']) {
	$filter_by .= " AND m.title LIKE '%".real_escape_string($post['filter_by'])."%'";
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
$query=mysqli_query($db,"SELECT b.id, a.title, b.carrier_title, b.storage_capacity, b.offer_new, b.offer_mint, b.offer_fair, b.offer_broken, b.offer_damaged
FROM mobile a, reference_prices b WHERE a.id = b.mobile_id");

//Fetch device list
$devices_data=mysqli_query($db,'SELECT * FROM devices WHERE published=1');

//Fetch list of published brand
$brands_data=mysqli_query($db,'SELECT * FROM brand WHERE published=1');

//Fetch list of published category
$categories_data=mysqli_query($db,'SELECT * FROM categories WHERE published=1');

//Template file
require_once("views/mobile/mobile_bulk_upload.php");

//Footer section
//include("include/footer.php"); ?>
