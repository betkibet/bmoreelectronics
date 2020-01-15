<?php 
require_once("../../_config/config.php");
require_once("../../include/functions.php");

if(isset($post['update'])) {
	$username=real_escape_string($post['username']);
	$email=real_escape_string($post['email']);
	$password=real_escape_string($post['password']);
	if($password!=""){
		$update_password = ',password ="'.md5($password).'"';
	}

	$query=mysqli_query($db,'UPDATE admin SET username="'.$username.'", email="'.$email.'" '.$update_password.' WHERE id="'.$post['id'].'" ');
	if($query=="1"){
		$msg="Your profile has been successfully updated.";
		$_SESSION['admin_username']=$username;
		$_SESSION['success_msg']=$msg;
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