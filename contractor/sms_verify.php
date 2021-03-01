<?php
//Header section
require_once("include/login/header.php");

//If already logged in then it will redirect to profile page
if(!empty($_SESSION['is_contractor']) && $_SESSION['contractor_username']!="") {
	setRedirect(CONTRACTOR_URL.'profile.php');
	exit();
} elseif(empty($_SESSION['is_sms_verify'])) {
	setRedirect(CONTRACTOR_URL);
	exit();
}

//Template file
require_once("views/admin_user/sms_verify.php");

//Footer section
require_once("include/login/footer.php"); ?>
