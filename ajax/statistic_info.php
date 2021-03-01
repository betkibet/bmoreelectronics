<?php
require_once("../admin/_config/config.php");
require_once("../admin/include/functions.php");
require_once("common.php");

$returned_order_item_status_id = get_order_status_data('order_item_status','returned')['data']['id'];
$paid_order_item_status_id = get_order_status_data('order_item_status','paid')['data']['id'];

$user_id = $_SESSION['user_id'];
$stat_period = $_POST['stat_period'];

$total_paid_array = array();
$total_order_array = array();
$total_devices_array = array();
$total_paid_devices_array = array();
$total_returned_devices_array = array();

if($user_id>0) {
	$order_dlist = get_order_list_by_user_id($user_id, $stat_period);
	$order_data_list = $order_dlist['order_list'];
	if(count($order_data_list)>0) {
		foreach($order_data_list as $order_data) {
			$order_id = $order_data['order_id'];
			$sum_of_orders = get_order_price($order_id);
			$order_item_list = get_order_item_list($order_id);
			
			$paid_amount_arr = array();
			$order_payment_status_list = get_order_payment_status_log($order_id);
			if(!empty($order_payment_status_list)) {
				foreach($order_payment_status_list as $order_payment_status_data) {
					$hsty_item_id = $order_payment_status_data['item_id'];
					$log_type = $order_payment_status_data['log_type'];
					if($log_type == "payment" && $order_payment_status_data['paid_amount']>0) {
						$paid_amount_arr[$hsty_item_id] = $order_payment_status_data['paid_amount'];
					}
				}
			}

			if($order_data['promocode_id']>0 && $order_data['promocode_amt']>0) {
				$promocode_amt = $order_data['promocode_amt'];
				$total_of_order = $sum_of_orders+$order_data['promocode_amt'];
			} else {
				$total_of_order = $sum_of_orders;
			}

			//$total_paid_array[] = $total_of_order;
			$total_order_array[] = $total_of_order;

			foreach($order_item_list as $order_item_list_data) {
				$paid_item_amount = $paid_amount_arr[$order_item_list_data['id']];

				$total_devices_array[] = $order_item_list_data['id'];
				if($order_item_list_data['item_status'] == $paid_order_item_status_id) {
					$total_paid_array[] = $paid_item_amount;//$order_item_list_data['price'];
					$total_paid_devices_array[] = $order_item_list_data['id'];
				}
				if($order_item_list_data['item_status'] == $returned_order_item_status_id) {
					$total_returned_devices_array[] = $order_item_list_data['id'];
				}
			}
		}
	}
	
	$bonus_data = get_bonus_data_info_by_user($user_id);
	//$user_orders_qty = $bonus_data['total_quantity'];
	$bonus_percentage = $bonus_data['bonus_data']['percentage'];
	$bonus_paid_device = $bonus_data['bonus_data']['paid_device'];
}

$total_paid_amount = (int)array_sum($total_paid_array);
$total_orders = count($total_order_array);
$total_devices = count($total_devices_array);
$total_paid_devices = count($total_paid_devices_array);
$total_returned_devices = count($total_returned_devices_array);
?>

<div class="statistic-roll clearfix">
	<div class="statistic-cell">
	  <p>Total paid</p>
	  <h5><?=$total_paid_amount?></h5>
	</div>
	<div class="statistic-cell">
	  <p>Total orders</p>
	  <h5><?=$total_orders?></h5>
	</div>
	<div class="statistic-cell">
	  <p>Total devices</p>
	  <h5><?=$total_devices?></h5>
	</div>
</div>
<div class="statistic-roll last clearfix">
	<div class="statistic-cell">
	  <p>Paid devices</p>
	  <h5><?=$total_paid_devices?></h5>
	</div>
	<div class="statistic-cell">
	  <p>Devices returned</p>
	  <h5><?=$total_returned_devices?></h5>
	</div>
	<?php /*?><div class="statistic-cell">
	  <p>Bonus rate</p>
	  <h5><?=($bonus_percentage>0?$bonus_percentage.'%':'0%')?></h5>
	</div><?php */?>
</div>