<?php
$file_name="home_settings";

//Header section
require_once("include/header.php");

//Get num of brands for pagination
$settings_p_query=mysqli_query($db,"SELECT COUNT(*) AS num_of_settings FROM home_settings");
$settings_p_data = mysqli_fetch_assoc($settings_p_query);
$pages->set_total($settings_p_data['num_of_settings']);

//Fetch brands data
$query=mysqli_query($db,"SELECT * FROM home_settings ORDER BY ordering ASC ".$pages->get_limit()."");

//Template file
require_once("views/settings/home_settings.php");

//Footer section
// require_once("include/footer.php"); ?>
