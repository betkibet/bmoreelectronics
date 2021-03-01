<?php
require_once("common.php");

if($is_include == '1') {
	unset($_SESSION['login_user']);
	unset($_SESSION['user_id']);
	unset($_SESSION['guest_user_id']);
} else {
	require_once("../admin/_config/config.php");
	require_once("../admin/include/functions.php");

	unset($_SESSION['login_user']);
	unset($_SESSION['user_id']);
	unset($_SESSION['guest_user_id']);

	//$msg="Logged out successfully.";
	//setRedirectWithMsg(SITE_URL,$msg,'success');	
	setRedirect(SITE_URL);
	exit();
}
?>