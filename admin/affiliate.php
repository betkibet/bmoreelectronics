<?php
$file_name="affiliate";

//Header section
require_once("include/header.php");

//Get num of affiliate submitted form for pagination
$user_p_query=mysqli_query($db,"SELECT COUNT(*) AS num_of_orders FROM affiliate");
$user_p_data = mysqli_fetch_assoc($user_p_query);
$pages->set_total($user_p_data['num_of_orders']);

//Fetch list of affiliate submitted form
$query=mysqli_query($db,"SELECT * FROM affiliate ORDER BY id DESC ".$pages->get_limit()."");

//Template file
require_once("views/affiliate.php");

//Footer section
// require_once("include/footer.php"); ?>
