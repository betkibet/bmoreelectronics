<?php 
$file_name="staff_group";

//Header section
require_once("include/header.php");
 
$id = $post['id'];

//Fetch signle editable appt_ticket_status data
$appt_q=mysqli_query($db,'SELECT * FROM staff_groups WHERE id="'.$id.'"');
$staff_group_data=mysqli_fetch_assoc($appt_q);
$permissions_array = json_decode($staff_group_data['permissions'], true);

//Template file
require_once("views/staff_group/edit_staff_group.php");

//Footer section
require_once("include/footer.php"); ?>
