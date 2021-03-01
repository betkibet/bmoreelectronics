<?php
require_once("../../_config/config.php");
require_once(CP_ROOT_PATH."/admin/include/functions.php");
require_once("../common.php");

if(isset($post['login'])) {
	$contractor_id = $_SESSION['contractor_id'];
	$sms_code=real_escape_string($post['sms_code']);

	if($sms_code == "") {
		$error_msg = "Enter SMS Verify Code";
		$_SESSION['error_msg']=$error_msg;
		setRedirect(CONTRACTOR_URL.'sms_verify.php');
	}

	if($contractor_id == '' || $contractor_id<=0) {
		$error_msg = "Something went wrong so please try again";
		$_SESSION['error_msg']=$error_msg;
		setRedirect(CONTRACTOR_URL);
	}

	$query="SELECT * FROM contractors WHERE sms_verify_code!='' AND sms_verify_code = '".$sms_code."' AND id = '".$contractor_id."'";
	$res=mysqli_query($db,$query);
	$checkUser=mysqli_num_rows($res);
	if($checkUser > 0) {
		$query=mysqli_query($db,"SELECT * FROM contractors WHERE id = '".$contractor_id."'");
		$user_data=mysqli_fetch_assoc($query);
		if($user_data['status'] == '0') {
			$error_msg='Your account is not activated so please contact with support team.';
			$_SESSION['error_msg']=$error_msg;
			setRedirect(CONTRACTOR_URL);
		} else {
			$_SESSION['contractor_username'] = $user_data['username'];
			$_SESSION['is_contractor'] = 1;
			$_SESSION['contractor_id']=$user_data['id'];
			$_SESSION['contractor_type']=$user_data['type'];
			
			$login_contractor_auth_token = $user_data['contractor_auth_token'];
			$_SESSION['contractor_auth_token']=$login_contractor_auth_token;

			$year_time_for_cookie = time() + 172800;
			setcookie('admin_sms_verified', 'yes', $year_time_for_cookie, "/");
			setcookie('admin_sms_verified_id', $user_data['id'], $year_time_for_cookie, "/");
					
			unset($_SESSION['is_sms_verify']);
			setRedirect(CONTRACTOR_URL.'dashboard.php');
		}
	} else {
		$error_msg='Please enter correct verify code.';
		$_SESSION['error_msg']=$error_msg;
		setRedirect(CONTRACTOR_URL.'sms_verify.php');
	}
} elseif(isset($post['cancel'])) {
	unset($_SESSION['is_sms_verify']);
	unset($_SESSION['contractor_id']);
	setRedirect(CONTRACTOR_URL);
} else {
	setRedirect(CONTRACTOR_URL);
}
exit(); ?>
