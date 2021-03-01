<?php 
require_once("../../_config/config.php");
require_once("../../include/functions.php");
require_once("../common.php");

if(isset($post['reset'])) {
	$new_password=$post['new_password'];
	$confirm_password=$post['confirm_password'];
	$uid=$post['uid'];
	
	if($new_password=="") {
		$_SESSION['error_msg']='Please enter new password.';
		setRedirect(ADMIN_URL.'confirm_password_reset.php');
		exit();
	} elseif($confirm_password=="") {
		$_SESSION['error_msg']='Please enter confirm password.';
		setRedirect(ADMIN_URL.'confirm_password_reset.php');
		exit();
	} elseif($new_password!=$confirm_password) {
		$_SESSION['error_msg']='New password and confirm password not matched.';
		setRedirect(ADMIN_URL.'confirm_password_reset.php');
		exit();
	} else {
		$admin_data_query = mysqli_query($db,"SELECT * FROM admin WHERE id='".$uid."'");
		$admin_data = mysqli_fetch_assoc($admin_data_query);
		
		$to = $admin_data['email'];
		$subject = "Password Reset Successfully";

		$patterns = array('{$user_company_name}',
				'{$user_type}',
				'{$password_reset_link}',
				'{$signature}',
				'{$admin_company_name}',
				'{$admin_company_phone}',
				'{$site_url}',
				'{$admin_site_url}');

		$replacements = array(
				'',
				'',
				'',
				signature,
				admin_company_name,
				admin_company_phone,
				SITE_URL,
				ADMIN_URL);
		
		$login_auth_token = get_big_unique_id();
		$upt_query = mysqli_query($db,"UPDATE admin SET password='".md5($new_password)."', pass_change_token='', auth_token='".$login_auth_token."' WHERE id='".$uid."' ");
		if($upt_query==1) {
			$body = '<table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
					  <tbody>
						<tr>
						  <td class="o_bg-light o_px-xs" align="center" style="background-color: #dbe5ea;padding-left: 8px;padding-right: 8px;">
							<table class="o_block-xs" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 800px;margin: 0 auto;">
							  <tbody>
								<tr>
								  <td class="o_bg-white o_px-md o_py o_sans o_text o_text-secondary" align="center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;background-color: #ffffff;color: #424651;padding-left: 24px;padding-right: 24px;padding-top: 16px;padding-bottom: 16px;">
									<h4 style="font-family: Helvetica, Arial, sans-serif;font-weight: bold;margin-top: 0px;margin-bottom: 8px;color: #242b3d;font-size: 18px;line-height: 23px;">Hello, '.$admin_data['username'].'</h4>
									<p style="margin-top: 0px;margin-bottom: 0px;">You have successfully reset your password.<br><b>New Password:</b> '.$new_password.'</p>
									<p style="margin-top: 0px;margin-bottom: 0px;">Please Click <a href="'.ADMIN_URL.'">Here</a> and login.</p>
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

			$_SESSION['success_msg']="Your have successfully reset your password.";
			setRedirect(ADMIN_URL.'index.php');
		} else {
			$_SESSION['error_msg']='Sorry, something went wrong';
			setRedirect(ADMIN_URL.'confirm_password_reset.php');
		}
		exit();
	}
} else {
	setRedirect(ADMIN_URL.'index.php');
}
exit(); ?>