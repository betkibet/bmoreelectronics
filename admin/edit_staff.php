<?php
$file_name="staff";

//Header section
require_once("include/header.php");

$id = $post['id'];

$staff_groups_query=mysqli_query($db,"SELECT * FROM staff_groups WHERE status='1'");

//Fetch signle editable admin data
$get_behand_data=mysqli_query($db,'SELECT * FROM admin WHERE id="'.$id.'"');
$admin_data=mysqli_fetch_assoc($get_behand_data);

//Template file
require_once("views/staff/edit_staff.php");

//Footer section
// require_once("include/footer.php"); ?>
