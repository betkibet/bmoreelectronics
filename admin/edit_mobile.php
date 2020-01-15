<?php
$file_name="mobile";

//Header section
require_once("include/header.php");

$id = $post['id'];

//Fetch signle editable mobile(model) data
$mobile_data_q=mysqli_query($db,'SELECT * FROM mobile WHERE id="'.$id.'"');
$mobile_data=mysqli_fetch_assoc($mobile_data_q);

//Fetch device list
$devices_data=mysqli_query($db,'SELECT * FROM devices WHERE published=1');

//Template file
require_once("views/mobile/edit_mobile.php");

//Footer section
//include("include/footer.php"); ?>
