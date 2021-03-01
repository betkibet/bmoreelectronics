<?php
require_once("../../admin/_config/config.php");
require_once("../../admin/include/functions.php");
require_once("../common.php");

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
	$cancelled_order_status_id = get_order_status_data('order_status','cancelled')['data']['id'];
	$query = mysqli_query($db,"UPDATE orders SET status='".$cancelled_order_status_id."', cancelled_by='customer' WHERE user_id='".$user_id."' AND order_id='".$order_id."'");
	if($query == '1') {
		$msg='You have successfully cancelled your order.';
		setRedirectWithMsg($return_url,$msg,'success');
	} else {
		$msg='Sorry, something went wrong';
		setRedirectWithMsg($return_url,$msg,'error');
	}
	exit();
} elseif($mode=="offer_accepted") {
	$t = $post['t'];
	$item_id = $post['item_id'];

	$q = mysqli_query($db,"SELECT * FROM orders WHERE access_token='".$t."' AND access_token!=''");
	$order_data = mysqli_fetch_assoc($q);
	if(empty($order_data)) {
		$msg='Direct access denied';
		setRedirectWithMsg($return_url,$msg,'warning');
		exit();
	}
	
	$price_is_accepted_order_item_status_id = get_order_status_data('order_item_status','price-is-accepted')['data']['id'];
	$order_id = $order_data['order_id'];
	$upd_q = mysqli_query($db,"UPDATE `order_items` SET `status`='".$price_is_accepted_order_item_status_id."' WHERE id='".$item_id."'");
	if($upd_q == '1') {
		$order_status_log_arr = array('order_id'=>$order_id,
								'item_id'=>$item_id,
								'order_status'=>'',
								'item_status'=>$price_is_accepted_order_item_status_id,
								'leadsource'=>'customer'
							);
		save_order_status_log($order_status_log_arr);

		$msg = "You have successfully accepted your offer.";
		setRedirectWithMsg($return_url,$msg,'success');
	} else {
		$msg = "Sorry, something went wrong";
		setRedirectWithMsg($return_url,$msg,'error');
	}
	exit();
} elseif($mode=="offer_rejected") {
	$t = $post['t'];
	$item_id = $post['item_id'];

	$q = mysqli_query($db,"SELECT * FROM orders WHERE access_token='".$t."' AND access_token!=''");
	$order_data = mysqli_fetch_assoc($q);
	if(empty($order_data)) {
		$msg='Direct access denied';
		setRedirectWithMsg($return_url,$msg,'warning');
		exit();
	}
	
	$price_is_declined_order_item_status_id = get_order_status_data('order_item_status','price-is-declined')['data']['id'];
	$order_id = $order_data['order_id'];
	$upd_q = mysqli_query($db,"UPDATE `order_items` SET `status`='".$price_is_declined_order_item_status_id."' WHERE id='".$item_id."'");
	if($upd_q == '1') {
		$order_status_log_arr = array('order_id'=>$order_id,
								'item_id'=>$item_id,
								'order_status'=>'',
								'item_status'=>$price_is_declined_order_item_status_id,
								'leadsource'=>'customer'
							);
		save_order_status_log($order_status_log_arr);

		$msg = "Your offer is rejected.";
		setRedirectWithMsg($return_url,$msg,'success');
	} else {
		$msg = "Sorry, something went wrong";
		setRedirectWithMsg($return_url,$msg,'error');
	}
	exit();
} else {
	$msg='Direct access denied';
	setRedirectWithMsg(SITE_URL,$msg,'danger');
	exit();
} ?>
