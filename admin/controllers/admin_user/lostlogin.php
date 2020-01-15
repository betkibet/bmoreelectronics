<?php 
require_once("../../_config/config.php");
require_once("../../include/functions.php");

if(isset($post['reset'])) {
	$message=array();
	if(isset($post['email']) && !empty($post['email'])) {
		$email=real_escape_string($post['email']);
		$query=mysqli_query($db,"SELECT * FROM admin WHERE email='".$email."'");
		$get_userdata_row=mysqli_fetch_assoc($query);
		if($get_userdata_row['id']!="") {
			$uid=$get_userdata_row['id'];
			$admin_username=$get_userdata_row['username'];
			$token=md5($email.time());
			$to = $email;
			$subject = "Reset Password & Get Admin Username";
			
			$upt_query = mysqli_query($db,"UPDATE admin SET pass_change_token='".$token."' WHERE id='".$uid."'");
			if($upt_query==1) {
				$body = '<!DOCTYPE html><html><body>
				<h4 align="left">Hello Admin</h4>
				<p>Please click below link for reset password. If you don\'t send password change request then ignore it.</p>
					<table>
						<tr>
							<th>Email:</th><td>'.$email.'</td>
						</tr>
						<tr>
							<th>User name:</th><td>'.$admin_username.'</td>
						</tr>
					</table>
					<p>Please Click <a href="'.ADMIN_URL.'confirm_password_reset.php?t='.$token.'">Here</a>.</p>
				</body></html>';
				send_email($to,$subject,$body,FROM_NAME,FROM_EMAIL);

				$success_msg='We have sent you password reset link. Please check your email.';
				$_SESSION['success_msg']=$success_msg;
				setRedirect(ADMIN_URL);
			} else {
				$_SESSION['error_msg']='Sorry, something went wrong';
				setRedirect(ADMIN_URL);
			}
		} else {
			$error_msg='Sorry email not found in our system.';
			$_SESSION['error_msg']=$error_msg;
			setRedirect(ADMIN_URL);
		}
	} else {
		$error_msg='Please enter email';
		$_SESSION['error_msg']=$error_msg;
		setRedirect(ADMIN_URL);
	}
} else {
	setRedirect(ADMIN_URL);
}
exit(); ?>
