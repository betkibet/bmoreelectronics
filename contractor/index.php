<?php
//Header section
require_once("include/login/header.php");

//If already logged in then it will redirect to profile page
if(!empty($_SESSION['is_contractor']) && $_SESSION['contractor_username']!="") {
	setRedirect(CONTRACTOR_URL.'profile.php');
	exit();
}

$cookie_data = $_COOKIE;
if(isset($cookie_data['remember_me']) && $cookie_data['remember_me'] == '1' && $cookie_data['username']!="" && $cookie_data['password']!="") {
	$year = time() + 172800;
	setcookie('username', $cookie_data['username'], $year, "/");
	setcookie('password', $cookie_data['password'], $year, "/");
	setcookie('remember_me', '1', $year, "/");
}

if(empty($cookie_data['username'])) {
	$cookie_data['username'] = "";
}

if(empty($cookie_data['password'])) {
	$cookie_data['password'] = "";
}

if(empty($cookie_data['remember_me'])) {
	$cookie_data['remember_me'] = "";
}

//Template file
require_once("views/admin_user/login.php");

//Footer section
require_once("include/login/footer.php"); ?>
