<?php
$file_name="home_settings";

//Header section
require_once("include/header.php");

$id = $post['id'];

//Fetch signle editable brand data
$get_settings_data=mysqli_query($db,'SELECT * FROM home_settings WHERE id="'.$id.'"');
$home_settings_data=mysqli_fetch_assoc($get_settings_data);

//Template file
require_once("views/settings/edit_home_settings.php");

//Footer section
// require_once("include/footer.php"); ?>
