<?php
require_once("../../_config/config.php");
require_once("../../include/functions.php");
require_once("../common.php");

if(isset($post['login'])) {
	$admin_id = $_SESSION['admin_id'];
	$sms_code=real_escape_string($post['sms_code']);

	if($sms_code == "") {
		$error_msg = "Enter SMS Verify Code";
		$_SESSION['error_msg']=$error_msg;
		setRedirect(ADMIN_URL.'sms_verify.php');
	}

	if($admin_id == '' || $admin_id<=0) {
		$error_msg = "Something went wrong so please try again";
		$_SESSION['error_msg']=$error_msg;
		setRedirect(ADMIN_URL);
	}

	$query="SELECT * FROM admin WHERE sms_verify_code!='' AND sms_verify_code = '".$sms_code."' AND id = '".$admin_id."'";
	$res=mysqli_query($db,$query);
	$checkUser=mysqli_num_rows($res);
	if($checkUser > 0) {
		$query=mysqli_query($db,"SELECT * FROM admin WHERE id = '".$admin_id."'");
		$user_data=mysqli_fetch_assoc($query);
		if($user_data['status'] == '0') {
			$error_msg='Your account is not activated so please contact with support team.';
			$_SESSION['error_msg']=$error_msg;
			setRedirect(ADMIN_URL);
		} else {
			$_SESSION['admin_username'] = $user_data['username'];
			$_SESSION['is_admin'] = 1;
			$_SESSION['admin_id']=$user_data['id'];
			$_SESSION['admin_type']=$user_data['type'];
			
			$login_auth_token = $user_data['auth_token'];
			$_SESSION['auth_token']=$login_auth_token;

			$year_time_for_cookie = time() + 172800;
			setcookie('admin_sms_verified', 'yes', $year_time_for_cookie, "/");
			setcookie('admin_sms_verified_id', $user_data['id'], $year_time_for_cookie, "/");
					
			unset($_SESSION['is_sms_verify']);
			setRedirect(ADMIN_URL.'dashboard.php');
		}
	} else {
		$error_msg='Please enter correct verify code.';
		$_SESSION['error_msg']=$error_msg;
		setRedirect(ADMIN_URL.'sms_verify.php');
	}
} elseif(isset($post['cancel'])) {
	unset($_SESSION['is_sms_verify']);
	unset($_SESSION['admin_id']);
	setRedirect(ADMIN_URL);
} else {
	setRedirect(ADMIN_URL);
}
exit(); ?>
