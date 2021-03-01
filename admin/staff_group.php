<?php 
$file_name="staff_group";

//Header section
require_once("include/header.php");

//Get num of brands for pagination
$status_p_query=mysqli_query($db,"SELECT COUNT(*) AS num_of_grp FROM staff_groups");
$status_p_data = mysqli_fetch_assoc($status_p_query);
$pages->set_total($status_p_data['num_of_grp']);

//Fetch brands data
$query=mysqli_query($db,"SELECT * FROM staff_groups ".$pages->get_limit()."");

//Template file
require_once("views/staff_group/staff_group.php");

//Footer section
require_once("include/footer.php"); ?>
