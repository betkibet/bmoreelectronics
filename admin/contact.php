<?php
$file_name="contact";

//Header section
require_once("include/header.php");

//Get num of contact/request quote submitted form for pagination
$user_p_query=mysqli_query($db,"SELECT COUNT(*) AS num_of_orders FROM contact");
$user_p_data = mysqli_fetch_assoc($user_p_query);
$pages->set_total($user_p_data['num_of_orders']);

//Fetch list of contact/request quote submitted form
$query=mysqli_query($db,"SELECT * FROM contact ORDER BY id DESC ".$pages->get_limit()."");

//Template file
require_once("views/contact.php");

//Footer section
// require_once("include/footer.php"); ?>
