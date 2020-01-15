<?php
$file_name="service_hours";

//Header section
require_once("include/header.php");

//Fetch signle editable brand data
$query=mysqli_query($db,"SELECT * FROM service_hours ORDER BY id DESC");
$service_hours_data=mysqli_fetch_assoc($query);

$open_time=json_decode($service_hours_data['open_time']);
$open_time_zone=json_decode($service_hours_data['open_time_zone']);
$close_time=json_decode($service_hours_data['close_time']);
$close_time_zone=json_decode($service_hours_data['close_time_zone']);
$closed=json_decode($service_hours_data['is_close']);

//Template file
require_once("views/settings/service_hours.php");

//Footer section
// require_once("include/footer.php"); ?>
