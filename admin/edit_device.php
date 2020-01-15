<?php
$file_name="device";

//Header section
require_once("include/header.php");

$id = $post['id'];

//Fetch signle editable device data
$get_behand_data=mysqli_query($db,'SELECT * FROM devices WHERE id="'.$id.'"');
$device_data=mysqli_fetch_assoc($get_behand_data);

//Fetch list of published brand
$brands_data=mysqli_query($db,'SELECT * FROM brand WHERE published=1');

//Template file
require_once("views/device/edit_device.php");

//Footer section
// include("include/footer.php"); ?>
