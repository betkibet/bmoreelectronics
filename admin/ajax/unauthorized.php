<?php
require_once("../_config/config.php");
require_once("../include/functions.php");
require_once("common.php");

$response = array();

$post = $_REQUEST;
$email = real_escape_string($post['email']);
$password = real_escape_string($post['password']);
$token=real_escape_string($post['token']);
if($email=="" || $password=="") {
	$response['message'] = "Please fill up mandatory fields.";
	$response['status'] = false;
} else {
	if($token!="") {
		$ck_q = mysqli_query($db,"SELECT * FROM admin WHERE email='".$email."' AND password='".md5($password)."' AND unauthorized_token='".$token."' AND type='super_admin'");
		$admin_user_data = mysqli_fetch_assoc($ck_q);		
		if(!empty($admin_user_data)) {
			$saved_allowed_ip = $general_setting_data['allowed_ip'];
			if($saved_allowed_ip!="") {
				$allowed_ip = $saved_allowed_ip.','.USER_IP;
			} else {
				$allowed_ip = USER_IP;
			}

			if(trim($admin_user_data['auth_token'])=="") {
				$login_auth_token = get_big_unique_id();
				mysqli_query($db,'UPDATE admin SET auth_token="'.$login_auth_token.'" WHERE id="'.$admin_user_data['id'].'"');
			} else {
				$login_auth_token = $admin_user_data['auth_token'];
			}

			$g_query = mysqli_query($db,"UPDATE general_setting SET `allowed_ip`='".$allowed_ip."' WHERE id='1'");
			if($g_query == '1') {
				$_SESSION['admin_username'] = $admin_user_data['username'];
				$_SESSION['is_admin'] = 1;
				$_SESSION['admin_id']=$admin_user_data['id'];
				$_SESSION['admin_type']=$admin_user_data['type'];
				$_SESSION['auth_token']=$login_auth_token;

				$response['message'] = "You have successfully verified.";
				$response['status'] = true;
				$response['token_status'] = 'verified';
			} else {
				$response['message'] = "Something went wrong!!!";
				$response['status'] = false;
				$response['token_status'] = '';
			}
		} else {
			$response['message'] = "Please enter correct token";
			$response['status'] = false;
			$response['token_status'] = '';
		}
	} else {
		$ck_q = mysqli_query($db,"SELECT * FROM admin WHERE email='".$email."' AND password='".md5($password)."' AND type='super_admin'");
		$admin_user_data = mysqli_fetch_assoc($ck_q);		
		if(!empty($admin_user_data)) {
			$unauthorized_token = md5(date("YmdHis").uniqid());
			$c_query = mysqli_query($db,"UPDATE admin SET `unauthorized_token`='".$unauthorized_token."' WHERE id='".$admin_user_data['id']."'");
			if($c_query == '1') {
				$subject = "Token received from unauthorized page";
				$body = '<table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
						  <tbody>
							<tr>
							  <td class="o_bg-light o_px-xs" align="center" style="background-color: #dbe5ea;padding-left: 8px;padding-right: 8px;">
								<table class="o_block-xs" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 800px;margin: 0 auto;">
								  <tbody>
									<tr>
									  <td class="o_bg-white o_px-md o_py o_sans o_text o_text-secondary" align="center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;background-color: #ffffff;color: #424651;padding-left: 24px;padding-right: 24px;padding-top: 16px;padding-bottom: 16px;">
										<h4 style="font-family: Helvetica, Arial, sans-serif;font-weight: bold;margin-top: 0px;margin-bottom: 8px;color: #242b3d;font-size: 18px;line-height: 23px;">Hello, '.$admin_user_data['username'].'</h4>
										<p style="margin-top: 0px;margin-bottom: 0px;">Please see below is your token from unauthorized page<br>Token:'.$unauthorized_token.'</p>
										<p style="margin-top: 8px;margin-bottom: 0px;">Regards</p>
									  </td>
									</tr>
								  </tbody>
								</table>
							  </td>
							</tr>
						  </tbody>
						</table>';
				send_email($email, $subject, $body, FROM_NAME, FROM_EMAIL);
				
				$response['message'] = "Access token successfully send to your registered email. please verify";
				$response['status'] = true;
				$response['token_status'] = '';
			} else {
				$response['message'] = "Something went wrong!!!";
				$response['status'] = false;
				$response['token_status'] = '';
			}
		} else {
			$response['message'] = "Please enter correct details";
			$response['status'] = false;
			$response['token_status'] = '';
		}
	}
}

echo json_encode($response);
exit;
?>