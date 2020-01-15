<?php
$file_name="staff";

//Header section
require_once("include/header.php");

//Get num of admins for pagination
$admin_p_query=mysqli_query($db,"SELECT COUNT(*) AS num_of_admins FROM admin WHERE type!='super_admin'");
$admin_p_data = mysqli_fetch_assoc($admin_p_query);
$pages->set_total($admin_p_data['num_of_admins']);

//Fetch admins data
$query=mysqli_query($db,"SELECT * FROM admin WHERE type!='super_admin' ".$pages->get_limit()."");

//Template file
require_once("views/staff/staff.php");

//Footer section
// require_once("include/footer.php"); ?>
