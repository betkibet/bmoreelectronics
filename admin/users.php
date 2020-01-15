<?php
$file_name="users";

//Header section
require_once("include/header.php");

//Filter by users based on username, email, name, first name, last name & phone
if($post['filter_by']) {
	$filter_by = " AND (username LIKE '%".real_escape_string($post['filter_by'])."%' OR email LIKE '%".real_escape_string($post['filter_by'])."%'  OR name LIKE '%".real_escape_string($post['filter_by'])."%' OR first_name LIKE '%".real_escape_string($post['filter_by'])."%' OR last_name LIKE '%".real_escape_string($post['filter_by'])."%' OR phone LIKE '%".real_escape_string($post['filter_by'])."%')";
}

//Get num of users for pagination
$user_p_query=mysqli_query($db,"SELECT COUNT(*) AS num_of_orders FROM users WHERE 1 ".$filter_by." ORDER BY id DESC");
$user_p_data = mysqli_fetch_assoc($user_p_query);
$pages->set_total($user_p_data['num_of_orders']);

//Fetch user list
$user_query=mysqli_query($db,"SELECT * FROM users WHERE 1 ".$filter_by." ORDER BY id DESC ".$pages->get_limit()."");

//Template file
require_once("views/user/users.php");

//Footer section
// include("include/footer.php"); ?>
