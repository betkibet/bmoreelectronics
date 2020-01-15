<?php
$file_name="device";

//Header section
require_once("include/header.php");

$filter_by = "";

if($post['filter_by']) {
	$filter_by .= " AND title LIKE '%".$post['filter_by']."%'";
}

//Get num of devices for pagination
$devices_p_query=mysqli_query($db,"SELECT COUNT(*) AS num_of_devices FROM devices WHERE 1 ".$filter_by."");
$devices_p_data = mysqli_fetch_assoc($devices_p_query);
$pages->set_total($devices_p_data['num_of_devices']);

//Fetch devices data
//$query=mysqli_query($db,"SELECT d.*, b.title AS brand_title FROM devices AS d LEFT JOIN brand AS b ON b.id=d.brand_id ".$pages->get_limit()."");
$query=mysqli_query($db,"SELECT d.* FROM devices AS d WHERE 1 ".$filter_by." ".$pages->get_limit()."");

//Template file
require_once("views/device/device.php");

//Footer section
// include("include/footer.php"); ?>
