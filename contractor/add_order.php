<?php
$file_name="add_order";

//Header section
require_once("include/header.php");

if($prms_order_add!='1') {
	setRedirect(ADMIN_URL.'profile.php');
	exit();
}

$contractor_users_list = get_contractor_users_list($admin_l_id);
/*echo '<pre>';
print_r($contractor_users_list);
exit;*/

//Template file
require_once("views/order/add_order.php"); ?>
