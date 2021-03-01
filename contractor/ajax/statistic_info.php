<?php
require_once("../../admin/_config/config.php");
require_once("../../admin/include/functions.php");
require_once("common.php");

$completed_order_status_id = get_order_status_data('order_status','completed')['data']['id'];
$returned_order_item_status_id = get_order_status_data('order_item_status','returned')['data']['id'];
$paid_order_item_status_id = get_order_status_data('order_item_status','paid')['data']['id'];

$stat_period = $_POST['stat_period'];
$stat_date = $_POST['stat_date'];

$total_paid_array = array();
$total_order_array = array();
$total_devices_array = array();
$total_paid_devices_array = array();
$total_returned_devices_array = array();

$order_dlist = get_order_list($stat_period, $stat_date);
$order_data_list = $order_dlist['order_list'];
if(count($order_data_list)>0) {
	foreach($order_data_list as $order_data) {
		$order_id = $order_data['order_id'];
		$sum_of_orders = get_order_price($order_id);
		$order_item_list = get_order_item_list($order_id);

		/*$paid_amount_arr = array();
		$order_payment_status_list = get_order_payment_status_log($order_id);
		if(!empty($order_payment_status_list)) {
			foreach($order_payment_status_list as $order_payment_status_data) {
				$hsty_item_id = $order_payment_status_data['item_id'];
				$log_type = $order_payment_status_data['log_type'];
				if($log_type == "payment" && $order_payment_status_data['paid_amount']>0) {
					$paid_amount_arr[$hsty_item_id] = $order_payment_status_data['paid_amount'];
				}
			}
		}*/

		if($order_data['promocode_id']>0 && $order_data['promocode_amt']>0) {
			$promocode_amt = $order_data['promocode_amt'];
			$total_of_order = $sum_of_orders+$order_data['promocode_amt'];
		} else {
			$total_of_order = $sum_of_orders;
		}
		
		$express_service = $order_data['express_service'];
		$express_service_price = $order_data['express_service_price'];
		$shipping_insurance = $order_data['shipping_insurance'];
		$shipping_insurance_per = $order_data['shipping_insurance_per'];

		$f_express_service_price = 0;
		$f_shipping_insurance_price = 0;
		if($express_service == '1') {
			$f_express_service_price = $express_service_price;
		}
		if($shipping_insurance == '1') {
			$f_shipping_insurance_price = ($sum_of_orders*$shipping_insurance_per/100);
		}
		
		if($f_express_service_price>0 || $f_shipping_insurance_price>0) {
			$total_of_order = ($total_of_order - $f_express_service_price - $f_shipping_insurance_price);
		}

		if($order_data['status'] == $completed_order_status_id) {
			$total_paid_array[] = $total_of_order;
		}

		//$total_paid_array[] = $total_of_order;
		$total_order_array[] = $total_of_order;

		foreach($order_item_list as $order_item_list_data) {
			//$paid_item_amount = $paid_amount_arr[$order_item_list_data['id']];

			$total_devices_array[] = $order_item_list_data['id'];
			if($order_item_list_data['item_status'] == $paid_order_item_status_id) {
				//$total_paid_array[] = $paid_item_amount;//$order_item_list_data['price'];
				$total_paid_devices_array[] = $order_item_list_data['id'];
			}
			if($order_item_list_data['item_status'] == $returned_order_item_status_id) {
				$total_returned_devices_array[] = $order_item_list_data['id'];
			}
		}
	}
}

//$bonus_data = get_bonus_data_info();
//$user_orders_qty = $bonus_data['total_quantity'];
//$bonus_percentage = $bonus_data['bonus_data']['percentage'];
//$bonus_paid_device = $bonus_data['bonus_data']['paid_device'];

$total_paid_amount = (int)array_sum($total_paid_array);
$total_orders = count($total_order_array);
$total_devices = count($total_devices_array);
$total_paid_devices = count($total_paid_devices_array);
$total_returned_devices = count($total_returned_devices_array);
?>

<div class="m-list-timeline__item">
	<span class="m-list-timeline__badge m-list-timeline__badge--success"></span>
	<span class="m-list-timeline__text"><span class="m-badge m-badge--success m-badge--wide">Total paid</span></span>
	<span class="m-list-timeline__time"><span class="m-nav__link-badge"><a href="paid_orders.php" class="m-badge m-badge--success m-badge--wide"><?=$total_paid_amount?></a></span></span>
</div>

<div class="m-list-timeline__item">
	<span class="m-list-timeline__badge m-list-timeline__badge--success"></span>
	<span class="m-list-timeline__text"><span class="m-badge m-badge--success m-badge--wide">Total orders</span></span>
	<span class="m-list-timeline__time"><span class="m-nav__link-badge"><a href="orders.php" class="m-badge m-badge--success m-badge--wide"><?=$total_orders?></a></span></span>
</div>

<div class="m-list-timeline__item">
	<span class="m-list-timeline__badge m-list-timeline__badge--success"></span>
	<span class="m-list-timeline__text"><span class="m-badge m-badge--success m-badge--wide">Total devices</span></span>
	<span class="m-list-timeline__time"><span class="m-nav__link-badge"><a href="#" class="m-badge m-badge--success m-badge--wide"><?=$total_devices?></a></span></span>
</div>

<div class="m-list-timeline__item">
	<span class="m-list-timeline__badge m-list-timeline__badge--success"></span>
	<span class="m-list-timeline__text"><span class="m-badge m-badge--success m-badge--wide">Paid devices</span></span>
	<span class="m-list-timeline__time"><span class="m-nav__link-badge"><a href="#" class="m-badge m-badge--success m-badge--wide"><?=$total_paid_devices?></a></span></span>
</div>

<?php /*?><div class="m-list-timeline__item">
	<span class="m-list-timeline__badge m-list-timeline__badge--success"></span>
	<span class="m-list-timeline__text"><span class="m-badge m-badge--success m-badge--wide">Devices returned</span></span>
	<span class="m-list-timeline__time"><span class="m-nav__link-badge"><a href="#" class="m-badge m-badge--success m-badge--wide"><?=$total_returned_devices?></a></span></span>
</div>

<div class="m-list-timeline__item">
	<span class="m-list-timeline__badge m-list-timeline__badge--success"></span>
	<span class="m-list-timeline__text"><span class="m-badge m-badge--success m-badge--wide">Bonus rate</span></span>
	<span class="m-list-timeline__time"><span class="m-nav__link-badge"><a href="bonus.php" class="m-badge m-badge--success m-badge--wide"><?=($bonus_percentage>0?$bonus_percentage.'%':'0%')?></a></span></span>
</div>
<?php */?>