<?php
$file_name="promocode";

//Header section
require_once("include/header.php");

$id = 0;
if($id<=0 && $prms_promocode_add!='1') {
	setRedirect(ADMIN_URL.'profile.php');
	exit();
}

if(isset($_SESSION['promocode_prefill_data'])) {
	$promocode_data = $_SESSION['promocode_prefill_data'];
	unset($_SESSION['promocode_prefill_data']);
}

//Template file
require_once("views/promocode/add_promocode.php"); ?>

