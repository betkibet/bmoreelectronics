<?php
require_once("../../_config/config.php");
require_once("../../include/functions.php");
require_once("../common.php");

$post = $_POST;

if(isset($post['login'])) {
	$message=array();

	//Validation for if username entered or not
	if(isset($post['username']) && !empty($post['username'])){
		$username=real_escape_string($post['username']);
	} else {
		$message[]='Please enter username';
	}
	
	//Validation for if password entered or not
	if(isset($post['password']) && !empty($post['password'])){
		$password=real_escape_string($post['password']);
	} else {
		$message[]='Please enter password';
	}
	
	$error_msg = '';
	$countError=count($message);
	if($countError > 0){
		 for($i=0;$i<$countError;$i++){
			$error_msg .= $message[$i].'<br/>';
		 }
		 $_SESSION['error_msg']=$error_msg;
		 setRedirect(ADMIN_URL.'index.php');
	} else {
		$remember_me = $_POST['remember_me'];
		
		//Check if login details match or not
		$query="SELECT * FROM admin WHERE username = '".$username."' AND password = '".md5($password)."'";
		$res=mysqli_query($db,$query);
		$checkUser=mysqli_num_rows($res);
		if($checkUser > 0){
			$query=mysqli_query($db,"SELECT * FROM admin WHERE username = '".$username."'");
			$user_data=mysqli_fetch_assoc($query);
			if($user_data['status'] == '0') {
				$error_msg='This user is not active so please contact with support team.';
				$_SESSION['error_msg']=$error_msg;
				setRedirect(ADMIN_URL.'index.php');
			} else {
				if(trim($user_data['auth_token'])=="") {
					$login_auth_token = get_big_unique_id();
					mysqli_query($db,'UPDATE admin SET auth_token="'.$login_auth_token.'" WHERE id="'.$user_data['id'].'"');
				} else {
					$login_auth_token = $user_data['auth_token'];
				}
				
				if($remember_me=='1') {
					$year = time() + 172800;
					setcookie('admin_ck_username', $username, $year, "/");
					setcookie('admin_ck_password', $password, $year, "/");
					setcookie('admin_ck_remember_me', $remember_me, $year, "/");
				}
	
				if(!$remember_me) {
					$year = time() - 172800;
					setcookie('admin_ck_username', '', $year, "/");
					setcookie('admin_ck_password', '', $year, "/");
					setcookie('admin_ck_remember_me', '', $year, "/");
				}
				
				$cookie_data = $_COOKIE;
				if($cookie_data['admin_sms_verified']=="yes" && $cookie_data['admin_sms_verified_id']==$user_data['id']) {
					$_SESSION['admin_username'] = $username;
					$_SESSION['is_admin'] = 1;
					$_SESSION['admin_id']=$user_data['id'];
					$_SESSION['admin_type']=$user_data['type'];
					$_SESSION['auth_token']=$login_auth_token;
					setRedirect(ADMIN_URL.'dashboard.php');
				}
				elseif($allow_sms_verify_of_admin_staff_login == '1') {
					$login_verify_code = rand(1111111,9999999);
					$updt_vc_q = mysqli_query($db,'UPDATE admin SET sms_verify_code="'.$login_verify_code.'" WHERE id="'.$user_data['id'].'"');
					if($updt_vc_q == '1') {
						$is_email_send = 0;
						$is_sms_send = 0;

						$subject = "Login verify code received from ".SITE_NAME;
						$body = '<table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
						  <tbody>
							<tr>
							  <td class="o_bg-light o_px-xs" align="center" style="background-color: #dbe5ea;padding-left: 8px;padding-right: 8px;">
								<table class="o_block-xs" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 800px;margin: 0 auto;">
								  <tbody>
									<tr>
									  <td class="o_bg-white o_px-md o_py o_sans o_text o_text-secondary" align="center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;background-color: #ffffff;color: #424651;padding-left: 24px;padding-right: 24px;padding-top: 16px;padding-bottom: 16px;">
										<h4 style="font-family: Helvetica, Arial, sans-serif;font-weight: bold;margin-top: 0px;margin-bottom: 8px;color: #242b3d;font-size: 18px;line-height: 23px;">Hello, '.$username.'</h4>
										<p style="margin-top: 0px;margin-bottom: 0px;">Please see below is your login verify code<br>Login Verify Code:'.$login_verify_code.'</p>
										<p style="margin-top: 8px;margin-bottom: 0px;">Regards</p>
									  </td>
									</tr>
								  </tbody>
								</table>
							  </td>
							</tr>
						  </tbody>
						</table>';
						$is_email_send = send_email($user_data['email'], $subject, $body, FROM_NAME, FROM_EMAIL);

						//START sms send to admin/staff
						$staff_phone = $user_data['phone'];
						if($sms_sending_status=='1' && $staff_phone!="") {
							$from_number = '+'.$general_setting_data['twilio_long_code'];
							$to_number = '+'.$user_phone_country_code.$staff_phone;
							if($from_number && $account_sid && $auth_token) {
								$sms_body_text = "Your ".ADMIN_PANEL_NAME." login verify code is ".$login_verify_code;
								try {
									$sms = $sms_api->account->messages->sendMessage($from_number, $to_number, $sms_body_text, $image, array('StatusCallback'=>''));
									$is_sms_send = 1;
								} catch(Services_Twilio_RestException $e) {
									$sms_error_msg = $e->getMessage();
									error_log($sms_error_msg);
								}
							}
						} //END sms send to admin/staff
						
						if($is_email_send == '1' && $is_sms_send == '1') {
							$success_msg = "Login verify code successfully send to your registered email & phone. please verify";
							$_SESSION['success_msg']=$success_msg;
						} elseif($is_email_send == '1') {
							$success_msg = "Login verify code successfully send to your registered email. please verify";
							$_SESSION['success_msg']=$success_msg;
						} elseif($is_sms_send == '1') {
							$success_msg = "Login verify code successfully send to your registered phone. please verify";
							$_SESSION['success_msg']=$success_msg;
						} else {
							$error_msg = "We can not able to send email/sms of your registered email address & phone so please contact with support team.";
							$_SESSION['error_msg']=$error_msg;
							setRedirect(ADMIN_URL);
							exit();
						}

						$_SESSION['is_sms_verify'] = 1;
						$_SESSION['admin_id'] = $user_data['id'];
						setRedirect(ADMIN_URL.'sms_verify.php');
					} else {
						$error_msg='Something went wrong so please try again.';
						$_SESSION['error_msg']=$error_msg;
						setRedirect(ADMIN_URL);
					}
					exit();
				} else {
					$_SESSION['admin_username'] = $username;
					$_SESSION['is_admin'] = 1;
					$_SESSION['admin_id']=$user_data['id'];
					$_SESSION['admin_type']=$user_data['type'];
					$_SESSION['auth_token']=$login_auth_token;
					setRedirect(ADMIN_URL.'dashboard.php');
				}
			}
		} else {
			$error_msg='please enter correct login details';
			$_SESSION['error_msg']=$error_msg;
			setRedirect(ADMIN_URL.'index.php');
		}
	}
} else {
	setRedirect(ADMIN_URL.'index.php');
}
exit(); ?>
