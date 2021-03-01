<?php 
require_once("../../_config/config.php");
require_once("../../include/functions.php");
require_once("../common.php");
check_admin_staff_auth();

if(isset($post['update'])) {
	$username=real_escape_string($post['username']);
	$email=real_escape_string($post['email']);
	$phone = preg_replace("/[^\d]/", "", $post['phone']);
	$password=real_escape_string($post['password']);
	if($password!="") {
		$update_password = ',password ="'.md5($password).'"';
	}

	$query=mysqli_query($db,'UPDATE admin SET username="'.$username.'", email="'.$email.'", phone="'.$phone.'" '.$update_password.' WHERE id="'.$post['id'].'" ');
	if($query=="1"){
		if($password!="") {
			$login_auth_token = get_big_unique_id();
			mysqli_query($db,'UPDATE admin SET auth_token="'.$login_auth_token.'" WHERE id="'.$post['id'].'"');
		} else {
			$msg="Your profile has been successfully updated.";
			$_SESSION['admin_username']=$username;
			$_SESSION['success_msg']=$msg;
		}
		
		setRedirect(ADMIN_URL.'profile.php');
	} else {
		$msg='Sorry! something wrong updation failed.';
		$_SESSION['error_msg']=$msg;
		setRedirect(ADMIN_URL.'profile.php');
	}
} else {
	setRedirect(ADMIN_URL.'profile.php');
}
exit(); ?>