<?php
require_once("common.php");

if($url_second_param && $url_third_param) {
	$i_data_q = mysqli_query($db,"SELECT it.*, i.order_id, i.status FROM order_items_offer_token AS it LEFT JOIN order_items AS i ON i.id=it.item_id WHERE it.token='".$url_second_param."' AND token!=''");
	$item_token_data = mysqli_fetch_assoc($i_data_q);
	if(!empty($item_token_data)) {
		$price_is_reduced_order_item_status_id = get_order_status_data('order_item_status','price-is-reduced')['data']['id'];
		$price_is_accepted_order_item_status_id = get_order_status_data('order_item_status','price-is-accepted')['data']['id'];
		$price_is_declined_order_item_status_id = get_order_status_data('order_item_status','price-is-declined')['data']['id'];

		$order_id = $item_token_data['order_id'];
		$item_id = $item_token_data['item_id'];
		$item_status = $item_token_data['status'];
		if($item_status == $price_is_reduced_order_item_status_id) {
			if($url_third_param=="accepted") {
				mysqli_query($db,"UPDATE `order_items` SET `status`='".$price_is_accepted_order_item_status_id."' WHERE id='".$item_id."'");
				$order_status_log_arr = array('order_id'=>$order_id,
											'item_id'=>$item_id,
											'order_status'=>'',
											'item_status'=>$price_is_accepted_order_item_status_id,
											'leadsource'=>'customer'
										);
				save_order_status_log($order_status_log_arr);
				
				$msg = "You have successfully accepted your offer.";
				setRedirectWithMsg(SITE_URL,$msg,'success');
			} elseif($url_third_param=="rejected") {
				mysqli_query($db,"UPDATE `order_items` SET `status`='".$price_is_declined_order_item_status_id."' WHERE id='".$item_id."'");
				$order_status_log_arr = array('order_id'=>$order_id,
											'item_id'=>$item_id,
											'order_status'=>'',
											'item_status'=>$price_is_declined_order_item_status_id,
											'leadsource'=>'customer'
										);
				save_order_status_log($order_status_log_arr);
				
				$msg = "Your offer is rejected.";
				setRedirectWithMsg(SITE_URL,$msg,'success');
			} else {
				$msg = "Sorry, something went wrong";
				setRedirectWithMsg(SITE_URL,$msg,'error');
			}
		} else {
			$ls_i_data_q = mysqli_query($db,"SELECT * FROM order_status_log WHERE item_status IN(".$price_is_accepted_order_item_status_id.",".$price_is_declined_order_item_status_id.") AND item_id='".$item_id."' ORDER BY id DESC");
			$order_status_log_accpet_or_declined = mysqli_fetch_assoc($ls_i_data_q);
			if(!empty($order_status_log_accpet_or_declined) && $order_status_log_accpet_or_declined['leadsource']=="customer") {
				$msg = "You have already Accepted / Declined this offer. You can check it in order details in your account or contact our support team.";
			} else {
				$msg = "This offer is already processed. You can check it in order details in your account or contact our support team.";
			}
			setRedirectWithMsg(SITE_URL,$msg,'warning');
		}
	} else {
		$msg = "Sorry, something went wrong";
		setRedirectWithMsg(SITE_URL,$msg,'error');
	}
} else {
	$msg='Direct access denied';
	setRedirectWithMsg(SITE_URL,$msg,'danger');
}
exit();
?>