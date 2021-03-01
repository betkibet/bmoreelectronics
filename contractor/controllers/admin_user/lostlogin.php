<?php 
require_once("../../_config/config.php");
require_once(CP_ROOT_PATH."/admin/include/functions.php");
require_once("../common.php");

if(isset($post['reset'])) {
	$message=array();
	if(isset($post['email']) && !empty($post['email'])) {
		$email=real_escape_string($post['email']);
		$query=mysqli_query($db,"SELECT * FROM contractors WHERE email='".$email."'");
		$get_userdata_row=mysqli_fetch_assoc($query);
		if($get_userdata_row['id']!="") {
			$uid=$get_userdata_row['id'];
			$contractor_username=$get_userdata_row['username'];
			$token=md5($email.time());
			$to = $email;
			$subject = "Reset Password & Get Admin Username";
			
			$upt_query = mysqli_query($db,"UPDATE contractors SET pass_change_token='".$token."' WHERE id='".$uid."'");
			if($upt_query==1) {
				$body = '<table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
						  <tbody>
							<tr>
							  <td class="o_bg-light o_px-xs" align="center" style="background-color: #dbe5ea;padding-left: 8px;padding-right: 8px;">
								<table class="o_block-xs" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 800px;margin: 0 auto;">
								  <tbody>
									<tr>
									  <td class="o_bg-white o_px-md o_py o_sans o_text o_text-secondary" align="center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;background-color: #ffffff;color: #424651;padding-left: 24px;padding-right: 24px;padding-top: 16px;padding-bottom: 16px;">
										<h4 style="font-family: Helvetica, Arial, sans-serif;font-weight: bold;margin-top: 0px;margin-bottom: 8px;color: #242b3d;font-size: 18px;line-height: 23px;">Hello, '.$contractor_username.'</h4>
										<p style="margin-top: 0px;margin-bottom: 0px;">Please click below link for reset password. If you don\'t send password change request then ignore it.<br><b>Email:</b>'.$email.'<br><b>User Name:</b>'.$contractor_username.'</p>
										<p style="margin-top: 0px;margin-bottom: 0px;">Please click <a href="'.CONTRACTOR_URL.'confirm_password_reset.php?t='.$token.'">Here</a> to reset your password.</p>
										<p style="margin-top: 8px;margin-bottom: 0px;">Regards</p>
									  </td>
									</tr>
								  </tbody>
								</table>
							  </td>
							</tr>
						  </tbody>
						</table>';
				send_email($to,$subject,$body,FROM_NAME,FROM_EMAIL);

				$success_msg='We have sent you password reset link. Please check your email.';
				$_SESSION['success_msg']=$success_msg;
				setRedirect(CONTRACTOR_URL);
			} else {
				$_SESSION['error_msg']='Sorry, something went wrong';
				setRedirect(CONTRACTOR_URL);
			}
		} else {
			$error_msg='Sorry email not found in our system.';
			$_SESSION['error_msg']=$error_msg;
			setRedirect(CONTRACTOR_URL);
		}
	} else {
		$error_msg='Please enter email';
		$_SESSION['error_msg']=$error_msg;
		setRedirect(CONTRACTOR_URL);
	}
} else {
	setRedirect(CONTRACTOR_URL);
}
exit(); ?>
