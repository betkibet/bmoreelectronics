<?php
$url_user_id = trim($url_second_param);
$exist_user_q=mysqli_query($db,"SELECT * FROM users WHERE MD5(id)='".$url_user_id."'");
$user_data=mysqli_fetch_assoc($exist_user_q);
if(!empty($user_data) && $user_data['status'] == '1') {
	setRedirect($login_link);
	exit();
} elseif(empty($user_data)) {
	$msg='Direct access denied';
	setRedirectWithMsg($signup_link,$msg,'danger');
	exit();
} ?>