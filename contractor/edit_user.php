<?php
$file_name="users";

//Header section
require_once("include/header.php");

$id = $post['id'];
if($id<=0 && $prms_customer_add!='1') {
	setRedirect(CONTRACTOR_URL.'profile.php');
	exit();
} elseif($id>0 && $prms_customer_edit!='1') {
	setRedirect(CONTRACTOR_URL.'profile.php');
	exit();
}

//Fetch single user data based user id
$user_data = get_user_data($id);
$user_data = _dt_parse_array($user_data);
/*if(empty($user_data)) {
	setRedirect(CONTRACTOR_URL.'users.php');
	exit();
}*/

//Template file
require_once("views/user/edit_user.php"); ?>
