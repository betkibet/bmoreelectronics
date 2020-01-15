<?php 
require_once("../../_config/config.php");
require_once("../../include/functions.php");

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

		$upt_query = mysqli_query($db,"UPDATE admin SET password='".md5($new_password)."', pass_change_token='' WHERE id='".$uid."' ");
		if($upt_query==1) {
			$body = '<!DOCTYPE html><html><body>
			<h4 align="left">Hello Admin</h4>
			<p>You have successfully reset your password.</p>
				<table>
					<tr>
						<th>New Password:</th><td>'.$new_password.'</td>
					</tr>
				</table>
				<p>Please Click <a href="'.ADMIN_URL.'">Here</a> and login.</p>
			</body></html>';
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