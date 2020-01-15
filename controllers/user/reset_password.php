<?php 
require_once("../../admin/_config/config.php");
require_once("../../admin/include/functions.php");

if(trim($post['t'])=="") {
	setRedirect(SITE_URL);
}

//Now check password change token
$check_token_query=mysqli_query($db,"SELECT * FROM users WHERE token='".trim($post['t'])."'");
$check_token_data=mysqli_fetch_assoc($check_token_query);
if(empty($check_token_data)){
	$msg='Sorry password reset token not matched';
	setRedirectWithMsg(SITE_URL,$msg,'warning');
	exit();
} //END

if(isset($post['reset'])) {
	$new_password=$post['new_password'];
	$confirm_password=$post['confirm_password'];
	if($new_password=="") {
		$msg='Please enter new password.';
		setRedirectWithMsg($return_url,$msg,'warning');
		exit();
	} elseif($confirm_password=="") {
		$msg='Please enter confirm password.';
		setRedirectWithMsg($return_url,$msg,'warning');
		exit();
	} elseif($new_password!=$confirm_password) {
		$msg='New password and confirm password not matched.';
		setRedirectWithMsg($return_url,$msg,'warning');
		exit();
	} else {
		mysqli_query($db,"UPDATE users SET token='', password='".md5($new_password)."' WHERE id='".$check_token_data['id']."' ");
		$msg="Your have successfully reset your password.";
		$login_link = SITE_URL.get_inbuild_page_url('login');
		setRedirectWithMsg($login_link,$msg,'success');
		exit();
	}
} else {
	$msg='Direct access denied';
	setRedirectWithMsg(SITE_URL,$msg,'danger');
	exit();
} ?>