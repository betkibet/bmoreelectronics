<?php
$file_name="mobile";

//Header section
require_once("include/header.php");

if(isset($_POST['search'])) {
	$_SESSION['model_filter_data'] = array('filter_by'=>$post['filter_by'],'cat_id'=>$post['cat_id'],'brand_id'=>$post['brand_id'],'device_id'=>$post['device_id'],'fields_type'=>$post['fields_type']);
	setRedirect(ADMIN_URL.'mobile.php');
}

if(isset($_GET['clear'])) {
	unset($_SESSION['model_filter_data']);
	setRedirect(ADMIN_URL.'mobile.php');
}

if(isset($_SESSION['model_filter_data'])) {
	$model_filter_data = $_SESSION['model_filter_data'];
	$post['filter_by'] = $model_filter_data['filter_by'];
	$post['cat_id'] = $model_filter_data['cat_id'];
	$post['brand_id'] = $model_filter_data['brand_id'];
	$post['device_id'] = $model_filter_data['device_id'];
	$post['fields_type'] = $model_filter_data['fields_type'];
}

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

if($post['field_type']) {
	$filter_by .= " AND c.fields_type = '".$post['field_type']."'";
}

$order_by = "";
if($post['id_shorting']) {
	$order_by .= " ORDER BY m.id ".$post['id_shorting'];
} elseif($post['oid_shorting']) {
	$order_by .= " ORDER BY m.ordering ".$post['oid_shorting'];
} elseif($post['title_shorting']) {
	$order_by .= " ORDER BY m.title ".$post['title_shorting'];
} else {
	$order_by .= " ORDER BY m.id ASC";
}

//Get num of mobile (model) for pagination
$mobile_p_query=mysqli_query($db,"SELECT COUNT(*) AS num_of_models FROM mobile AS m WHERE 1 ".$filter_by."");
$mobile_p_data = mysqli_fetch_assoc($mobile_p_query);
$pages->set_total($mobile_p_data['num_of_models']);

//Fetch mobile (model) with assigned device
$query=mysqli_query($db,"SELECT m.*, d.title AS device_title, d.sef_url, b.title AS brand_title, c.title AS cat_title, c.fields_type FROM mobile AS m LEFT JOIN devices AS d ON d.id=m.device_id LEFT JOIN brand AS b ON b.id=m.brand_id LEFT JOIN categories AS c ON c.id=m.cat_id WHERE 1 ".$filter_by." ".$order_by." ".$pages->get_limit());

//Fetch device list
$devices_data=mysqli_query($db,'SELECT * FROM devices WHERE published=1');

//Fetch list of published brand
$brands_data=mysqli_query($db,'SELECT * FROM brand WHERE published=1');

//Fetch list of published category
$categories_data=mysqli_query($db,'SELECT * FROM categories WHERE published=1');

$url_params_array = array(
	'id_shorting' => $post['id_shorting'],
	'oid_shorting' => $post['oid_shorting'],
	'title_shorting' => $post['title_shorting'],
	'field_type' => $post['field_type'],
	'filter_by' => $post['filter_by'],
	'cat_id' => $post['cat_id'],
	'brand_id' => $post['brand_id'],
	'device_id' => $post['device_id']
);

unset($url_params_array['id_shorting']);
unset($url_params_array['oid_shorting']);
unset($url_params_array['title_shorting']);

$url_params = http_build_query($url_params_array);
$url_params = ($url_params?'&'.$url_params:'');

$shorting_label = 'Select to sort by this column';

//Template file
require_once("views/mobile/mobile.php"); ?>
