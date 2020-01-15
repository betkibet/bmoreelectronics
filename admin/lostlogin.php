<?php
//Header section
require_once("include/login/header.php");

if(!empty($_SESSION['is_admin']) && $_SESSION['username']!="")
	setRedirect(ADMIN_URL.'profile.php');

//Template file
require_once("views/admin_user/lostlogin.php");

//Footer section
require_once("include/login/footer.php"); ?>
