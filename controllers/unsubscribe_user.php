<?php
require_once("common.php");

if($url_second_param) {
	$q = mysqli_query($db,"SELECT * FROM unsubscribe_user_tokens WHERE token='".$url_second_param."' AND token!=''");
	$unsubscribe_user_token_data = mysqli_fetch_assoc($q);
	if(!empty($unsubscribe_user_token_data)) {
		$query = mysqli_query($db,"UPDATE `users` SET `unsubscribe`='1' WHERE id='".$unsubscribe_user_token_data['user_id']."'");
		if($query=='1') {
			mysqli_query($db,"DELETE FROM `unsubscribe_user_tokens` WHERE token='".$url_second_param."'");
			$msg = "You have successfully unsubscribed. You will not receive automated email now.";
			setRedirectWithMsg(SITE_URL,$msg,'success');
		} else {
			$msg = "Sorry, something went wrong";
			setRedirectWithMsg(SITE_URL,$msg,'error');
		}
	} else {
		$msg='Token not found in our system.';
		setRedirectWithMsg(SITE_URL,$msg,'danger');
	}
	exit;
} else {
	$msg='Direct access denied.';
	setRedirectWithMsg(SITE_URL,$msg,'danger');
}
exit();
?>