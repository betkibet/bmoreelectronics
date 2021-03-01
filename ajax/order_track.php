<?php
require_once("../admin/_config/config.php");
require_once("../admin/include/functions.php");
require_once("common.php");

$response = array();

$track_order_id = $_POST['track_order_id'];
if($track_order_id) {

	/*$valid_csrf_token = verifyFormToken('order_track');
	if($valid_csrf_token!='1') {
		writeHackLog('order_track');
		//$msg = "Invalid Token";
		//setRedirectWithMsg($return_url,$msg,'warning');
		$response['html'] = '';
		$response['msg'] = 'Invalid Token';
		$response['error'] = 'not_found';
		echo json_encode($response);
		exit();
	}*/

	/*if($order_track_form_captcha == '1') {
		$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$captcha_secret."&response=".$post['g-recaptcha-response']);
		$response = json_decode($response, true);
		if($response["success"] !== true) {
			$_SESSION['error_message'] = "Invalid captcha";
			//setRedirectWithMsg($return_url,$msg,'warning');
			setRedirect($return_url);
			exit();
		}
	}*/

	$order_data = get_order_data($track_order_id);
	if(empty($order_data)) {
		$response['html'] = '';
		$response['msg'] = 'Please enter correct email or order';
		$response['error'] = 'not_found';
	} else {

		$order_data = get_order_data($track_order_id);

		//Get order item list based on orderID, path of this function (get_order_item_list) admin/include/functions.php
		$order_item_list = get_order_item_list($track_order_id);
		$order_num_of_rows = count($order_item_list);

		//Get order price based on orderID, path of this function (get_order_price) admin/include/functions.php
		$sum_of_orders=get_order_price($track_order_id);
		
		$paid_amount_arr = array();
		$order_payment_status_list = get_order_payment_status_log($track_order_id);
		if(!empty($order_payment_status_list)) {
			foreach($order_payment_status_list as $order_payment_status_data) {
				$hsty_item_id = $order_payment_status_data['item_id'];
				$log_type = $order_payment_status_data['log_type'];
				if($log_type == "payment" && $order_payment_status_data['paid_amount']>0) {
					$paid_amount_arr[$hsty_item_id] = $order_payment_status_data['paid_amount'];
				}
			}
		}
		$sum_of_paid_order = array_sum($paid_amount_arr);

		//Order data gathering
		if($order_data['promocode_id']>0 && $order_data['promocode_amt']>0) {
			$promocode_amt = $order_data['promocode_amt'];
			$discount_amt_label = "Surcharge";
			if($order_data['discount_type']=="percentage")
				$discount_amt_label = "Surcharge (".$order_data['discount']."% of Initial Quote):";
			 
			$total_of_order = $sum_of_orders+$order_data['promocode_amt'];
		} else {
			$total_of_order = $sum_of_orders;
		}

		$order_status = $order_data['order_status_name'];
		$order_status_slug = $order_data['order_status_slug'];
		$act_parcel_shipped = false;
		$act_device_checked = false;
		$act_order_paid = false;
		if($order_status_slug == "shipped" || $order_status_slug == "delivered" || $order_status_slug == "shipment_problem") {
			$act_parcel_shipped = true;
		} elseif($order_status_slug == "processing" || $order_status_slug == "approved" || $order_status_slug == "counter_offer" || $order_status_slug == "offer_accepted" || $order_status_slug == "offer_declined") {
			$act_parcel_shipped = true;
			$act_device_checked = true;
		} elseif($order_status_slug == "returned_to_sender" || $order_status_slug == "completed" || $order_status_slug == "expired") {
			$act_parcel_shipped = true;
			$act_device_checked = true;
			$act_order_paid = true;
		}

		$quantity_array = array();
		if($order_num_of_rows>0) {
			foreach($order_item_list as $order_item_list_data) {
				$quantity_array[] = $order_item_list_data['quantity'];
			}
		}
		
		$html = '<div class="modal-header">
		  <h5 class="modal-title">Order #'.$track_order_id.'</h5>
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<img src="images/payment/close.png" alt="">
		  </button>
		</div>
		<div class="modal-body pt-3 text-center">
		  <div class="order-progress-bar clearfix">
			<span class="shipped '.($act_parcel_shipped?'active':'').'"></span>
			<span class="checked '.($act_device_checked?'active':'').'"></span>
			<span class="paid '.($act_device_checked?'active':'').'"></span>
		  </div>
		  <div class="order-status">
			<div class="shipped '.($act_parcel_shipped?'active':'').'">
			  <img src="images/icons/shipped.png" alt="">
			  <span>Parcel is shipped</span>
			</div>
			<div class="checked '.($act_device_checked?'active':'').'">
			  <img src="images/icons/chcked.png" alt="">
			  <span>Device(s) checked</span>
			</div>
			<div class="paid '.($act_device_checked?'active':'').'">
			  <img src="images/icons/paid.png" alt="">
			  <span>Order Paid</span>
			</div>
			</div>
			<div class="d-none d-md-block d-lg-block w-100">
		  <table id="table_id" class="display">
			<thead>
			  <tr>
				<th>ID</th>
				<th>Date</th>
				<th>Devices QTY</th>
				<th>Last update</th>
				<th>Status</th>
			  </tr>
			</thead>
			<tbody>
				<tr>
					<td>'.$track_order_id.'</td>
					<td>'.format_date($order_data['order_date']).'</td>
					<td>'.array_sum($quantity_array).'</td>
					<td>'.($order_data['order_update_date']!='0000-00-00 00:00:00'?format_date($order_data['order_update_date']):'No updates yet').'</td>
					<td>'.replace_us_to_space($order_status).' '.($order_status == "completed"?amount_fomat($sum_of_paid_order):'').'</td>
				</tr>
			</tbody>
			</table>
			</div>';
		  if($_SESSION['user_id']<=0) {
		  $html .= '<a class="link-text order_track_login" href="javascript:void(0);">For more information, <span>log in</span></a>';
		  }
		$html .= '</div>
		</div>';

		$response['html'] = $html;
		$response['msg'] = 'Successfully found your order';
		$response['error'] = 'found';
	}
} else {
	$response['html'] = '';
	$response['msg'] = '';
	$response['error'] = true;
}
echo json_encode($response);
exit();
?>