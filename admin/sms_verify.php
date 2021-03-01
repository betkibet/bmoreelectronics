<?php
//Header section
require_once("include/login/header.php");

//If already logged in then it will redirect to profile page
if(!empty($_SESSION['is_admin']) && $_SESSION['admin_username']!="") {
	setRedirect(ADMIN_URL.'profile.php');
	exit();
} elseif(empty($_SESSION['is_sms_verify'])) {
	setRedirect(ADMIN_URL);
	exit();
}

//Template file
require_once("views/admin_user/sms_verify.php");

//Footer section
require_once("include/login/footer.php"); ?>
