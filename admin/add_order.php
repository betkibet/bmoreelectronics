<?php
$file_name="edit_order";

//Header section
require_once("include/header.php");

if($prms_order_add!='1') {
	setRedirect(ADMIN_URL.'profile.php');
	exit();
}

$u_q = mysqli_query($db,"SELECT * FROM users WHERE status='1' ORDER BY name ASC");

//Template file
require_once("views/order/add_order.php");

//Footer section
// include("include/footer.php"); ?>
