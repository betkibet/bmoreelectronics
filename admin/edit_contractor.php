<?php
$file_name="contractors";

//Header section
require_once("include/header.php");

$id = $post['id'];
if($id<=0 && $prms_customer_add!='1') {
	setRedirect(ADMIN_URL.'profile.php');
	exit();
} elseif($id>0 && $prms_customer_edit!='1') {
	setRedirect(ADMIN_URL.'profile.php');
	exit();
}

//Fetch single contractor data based contractor id
$contractor_data = get_contractor_data($id);
$permissions_array = json_decode($contractor_data['permissions'], true);
$contractor_data = _dt_parse_array($contractor_data);
/*if(empty($contractor_data)) {
	setRedirect(ADMIN_URL.'contractors.php');
	exit();
}*/


//Template file
require_once("views/contractor/edit_contractor.php"); ?>
