<?php
require_once("../common.php");

$user_id=$url_second_param;
$verification_code=$url_third_param;

if($user_id == '' || $verification_code == '') {
	$msg='Direct access denied';
	setRedirectWithMsg(SITE_URL,$msg,'danger');
} else {
	$u_q=mysqli_query($db,"SELECT * FROM users WHERE MD5(id)='".$user_id."' AND verification_code='".$verification_code."' AND verification_code!=''");
	$user_data=mysqli_fetch_assoc($u_q);
	if(empty($user_data)) {
		$msg='You have wrong verification link. so please check from latest email you received or please contact with support team.';
		setRedirectWithMsg(SITE_URL,$msg,'warning');
	} else {
		mysqli_query($db,"UPDATE `users` SET status='1', verification_code='' WHERE MD5(id)='".$user_id."'");
		$msg='Success! You have verified your email address. You can please login now.';
		setRedirectWithMsg(SITE_URL,$msg,'success');
	}
}
exit();
?>