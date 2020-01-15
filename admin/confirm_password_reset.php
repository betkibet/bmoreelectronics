<?php
//Header section
require_once("include/login/header.php");

//If already logged in then it will redirect to profile page
if(!empty($_SESSION['is_admin']) && $_SESSION['username']!="") {
	setRedirect(ADMIN_URL.'profile.php');
	exit();
}

if($post['t']=="") {
	setRedirect(ADMIN_URL.'index.php');
	exit();
}

//Now check password change token
$check_token_query=mysqli_query($db,"SELECT id,email from admin WHERE pass_change_token='".trim($post['t'])."' ");
$check_token_data=mysqli_fetch_assoc($check_token_query);
if(empty($check_token_data)){
	$_SESSION['error_msg']='Sorry password reset token not matched';
	setRedirect(ADMIN_URL.'index.php');
	exit();
} //END

//Template file
require_once("views/admin_user/confirm_password_reset.php");

//Footer section
require_once("include/login/footer.php"); ?>
