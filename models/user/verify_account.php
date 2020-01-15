<?php
$user_id = trim($url_second_param);
$get_userdata=mysqli_query($db,"SELECT * FROM users WHERE MD5(id)='".$user_id."'");
$user_data=mysqli_fetch_assoc($get_userdata);
if(!$user_id || empty($user_data) && $user_data['status'] == '0') {
	setRedirect($signup_link);
	exit();
} elseif(!empty($user_data) && $user_data['status'] == '1') {
	setRedirect($login_link);
	exit();
} ?>