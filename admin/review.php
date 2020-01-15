<?php
$file_name="review";

//Header section
require_once("include/header.php");

//Get num of reviews for pagination
$user_p_query=mysqli_query($db,"SELECT COUNT(*) AS num_of_orders FROM reviews");
$user_p_data = mysqli_fetch_assoc($user_p_query);
$pages->set_total($user_p_data['num_of_orders']);

//Fetch list of reviews
$query=mysqli_query($db,"SELECT * FROM reviews ORDER BY id DESC ".$pages->get_limit()."");

//Template file
require_once("views/review.php");

//Footer section
// require_once("include/footer.php"); ?>
