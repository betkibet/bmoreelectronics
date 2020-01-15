<?php
require_once("../../admin/_config/config.php");
require_once("../../admin/include/functions.php");

$user_id = $_SESSION['user_id'];

//If direct access then it will redirect to home page
if($user_id<=0) {
	$msg='Direct access denied';
	setRedirectWithMsg(SITE_URL,$msg,'danger');
	exit();
}

$order_id = $post['order_id'];
$mode = $post['mode'];

if(isset($order_id) && $mode=="del") {
	$query = mysqli_query($db,"UPDATE orders SET status='cancelled', cancelled_by='customer' WHERE user_id='".$user_id."' AND order_id='".$order_id."'");
	if($query == '1') {
		$msg='You have successfully cancelled your order.';
		setRedirectWithMsg($return_url,$msg,'success');
	} else {
		$msg='Sorry, something went wrong';
		setRedirectWithMsg($return_url,$msg,'error');
	}
	exit();
} else {
	$msg='Direct access denied';
	setRedirectWithMsg(SITE_URL,$msg,'danger');
	exit();
} ?>
