<?php
$file_name="bulk_order";

//Header section
require_once("include/header.php");

//Get num of bulk order request for pagination
$user_p_query=mysqli_query($db,"SELECT COUNT(*) AS num_of_orders FROM bulk_order_form");
$user_p_data = mysqli_fetch_assoc($user_p_query);
$pages->set_total($user_p_data['num_of_orders']);

//Fetch list of bulk order request
$query=mysqli_query($db,"SELECT * FROM bulk_order_form ORDER BY id DESC ".$pages->get_limit()."");

//Template file
require_once("views/bulk_order.php");

//Footer section
// require_once("include/footer.php"); ?>
