<?php
$file_name="demand_pickup_zipcodes";

//Header section
require_once("include/header.php");

//Fetch category list
$query = mysqli_query($db,"SELECT * FROM demand_pickup_zipcodes ORDER BY id DESC");
$zipcodes_data = mysqli_fetch_assoc($query);
$zipcodes_data = _dt_parse_array($zipcodes_data);

//Template file
require_once("views/settings/demand_pickup_zipcodes.php"); ?>
