<?php
$file_name="device";

//Header section
require_once("include/header.php");

if(isset($_POST['search'])) {
	$_SESSION['device_filter_data'] = array('filter_by'=>$post['filter_by']);
	setRedirect(ADMIN_URL.'device.php');
}

if(isset($_GET['clear'])) {
	unset($_SESSION['device_filter_data']);
	setRedirect(ADMIN_URL.'device.php');
}

if(isset($_SESSION['device_filter_data'])) {
	$device_filter_data = $_SESSION['device_filter_data'];
	$post['filter_by'] = $device_filter_data['filter_by'];
}

$filter_by = "";
if($post['filter_by']) {
	$filter_by .= " AND d.title LIKE '%".$post['filter_by']."%'";
}

$order_by = "";
if($post['oid_shorting']) {
	$order_by .= " ORDER BY d.ordering ".$post['oid_shorting'];
} elseif($post['title_shorting']) {
	$order_by .= " ORDER BY d.title ".$post['title_shorting'];
} else {
	$order_by .= " ORDER BY d.ordering ASC";
}

//Get num of devices for pagination
$devices_p_query=mysqli_query($db,"SELECT COUNT(*) AS num_of_devices FROM devices AS d WHERE 1 ".$filter_by."");
$devices_p_data = mysqli_fetch_assoc($devices_p_query);
$pages->set_total($devices_p_data['num_of_devices']);

//Fetch devices data
$query=mysqli_query($db,"SELECT d.* FROM devices AS d WHERE 1 ".$filter_by." ".$order_by." ".$pages->get_limit()."");

$url_params_array = array(
	'oid_shorting' => $post['oid_shorting'],
	'title_shorting' => $post['title_shorting'],
	'filter_by' => $post['filter_by']
);

unset($url_params_array['oid_shorting']);
unset($url_params_array['title_shorting']);

$url_params = http_build_query($url_params_array);
$url_params = ($url_params?'&'.$url_params:'');

$shorting_label = 'Select to sort by this column';

//Template file
require_once("views/device/device.php"); ?>
