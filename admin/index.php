<?php
//Header section
require_once("include/login/header.php");

//If already logged in then it will redirect to profile page
if(!empty($_SESSION['is_admin']) && $_SESSION['admin_username']!="") {
	setRedirect(ADMIN_URL.'profile.php');
	exit();
}

$cookie_data = $_COOKIE;
if(isset($cookie_data['admin_ck_remember_me']) && $cookie_data['admin_ck_remember_me'] == '1' && isset($cookie_data['admin_ck_username']) && $cookie_data['admin_ck_username']!="" && isset($cookie_data['admin_ck_password']) && $cookie_data['admin_ck_password']!="") {
	$year = time() + 172800;
	setcookie('admin_ck_username', $cookie_data['admin_ck_username'], $year, "/");
	setcookie('admin_ck_password', $cookie_data['admin_ck_password'], $year, "/");
	setcookie('admin_ck_remember_me', '1', $year, "/");
}

if(empty($cookie_data['admin_ck_username'])) {
	$cookie_data['admin_ck_username'] = "";
}

if(empty($cookie_data['admin_ck_password'])) {
	$cookie_data['admin_ck_password'] = "";
}

if(empty($cookie_data['admin_ck_remember_me'])) {
	$cookie_data['admin_ck_remember_me'] = "";
}

//Template file
require_once("views/admin_user/login.php");

//Footer section
require_once("include/login/footer.php"); ?>
