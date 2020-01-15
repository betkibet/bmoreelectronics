<?php
//If already loggedin and try to access reset password page, it will redirect to account
if($user_id>0) {
	setRedirect(SITE_URL.'account');
	exit();
}

//If try to direct access with blank token then it will redirect to home page
elseif(trim($post['t'])=="") {
	$msg='Direct access denied';
	setRedirectWithMsg(SITE_URL,$msg,'danger');
	exit();
}

//Now check password change token
$check_token_query=mysqli_query($db,"SELECT * FROM users WHERE token='".trim($post['t'])."'");
$check_token_data=mysqli_fetch_assoc($check_token_query);
if(empty($check_token_data)){
	$msg='Sorry password reset token not matched';
	setRedirectWithMsg(SITE_URL,$msg,'warning');
	exit();
} //END ?>