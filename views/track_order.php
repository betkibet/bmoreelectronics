<?php
$meta_title = "Track Order";
$active_menu = "track_order";

//Header section
include("include/header.php");

//If direct access then it will redirect to home page
if($user_id<=0) {
	setRedirect(SITE_URL);
	exit();
} elseif($user_data['status'] == '0' || empty($user_data)) {
	$is_include = 1;
	require_once('controllers/logout.php');

	$msg='Your account is inactive or removed by shop owner so please contact with support team OR re-create account.';
	setRedirectWithMsg(SITE_URL,$msg,'warning');
	exit();
}

$csrf_token = generateFormToken('order_track');

$order_id = $_SESSION['track_order_id'];
$order_data = get_order_data($order_id);
if($order_id!="") {
	unset($_SESSION['track_order_id']);
}

//Get order item list based on orderID, path of this function (get_order_item_list) admin/include/functions.php
$order_item_list = get_order_item_list($order_id);
$order_num_of_rows = count($order_item_list);

//Get order price based on orderID, path of this function (get_order_price) admin/include/functions.php
$sum_of_orders=get_order_price($order_id);

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

$order_status = $order_data['status'];
$act_parcel_shipped = false;
$act_device_checked = false;
$act_order_paid = false;
if($order_status == "shipped" || $order_status == "delivered" || $order_status == "shipment_problem") {
	$act_parcel_shipped = true;
} elseif($order_status == "processing" || $order_status == "approved" || $order_status == "counter_offer" || $order_status == "offer_accepted" || $order_status == "offer_declined") {
	$act_parcel_shipped = true;
	$act_device_checked = true;
} elseif($order_status == "returned_to_sender" || $order_status == "completed" || $order_status == "expired") {
	$act_parcel_shipped = true;
	$act_device_checked = true;
	$act_order_paid = true;
}

$quantity_array = array();
if($order_num_of_rows>0) {
	foreach($order_item_list as $order_item_list_data) {
		$quantity_array[] = $order_item_list_data['quantity'];
	}
} ?>

  <section>
    <div class="container-fluid">
      <div class="row">
       <div class="col-md-12">
          <div class="block setting-page py-0 clearfix">
            <div class="row">
              <div class="col-md-5 left-menu col-lg-4 col-xl-3">
				<?php require_once('views/account_menu.php');?>
			  </div>
              <div class="col-12 col-sm-12 col-md-5 col-lg-8 col-xl-9 right-content">
			    <?php
				$html = '';
			  	if(empty($order_data)) { ?>
                <div class="block heading page-heading">
                  <div class="text-center">
                    <h3>Track your order</h3>
                  </div>
                </div>
				<?php
				} else {
					$html .= '<div class="block heading page-heading">
					  <div class="d-flex justify-content-center">
						<h3>Order #'.$order_id.'</h3>
					  </div>
					</div>';
				} ?>
                <div class="block">
				  <?php
			  	  if(!empty($order_data)) {
					$html .= '<div class="order-progress-bar clearfix">
						<span class="shipped '.($act_parcel_shipped?'active':'').'"></span>
						<span class="checked '.($act_device_checked?'active':'').'"></span>
						<span class="paid '.($act_device_checked?'active':'').'"></span>
					  </div>
					  <div class="order-status text-center">
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
					  <table id="ac_table_id" class="display d-none d-md-block d-lg-block">
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
								<td>'.$order_id.'</td>
								<td>'.format_date($order_data['order_date']).'</td>
								<td>'.array_sum($quantity_array).'</td>
								<td>'.($order_data['order_update_date']!='0000-00-00 00:00:00'?format_date($order_data['order_update_date']):'No updates yet').'</td>
								<td>'.replace_us_to_space($order_status).' '.amount_fomat($total_of_order).'</td>
							</tr>
						</tbody>
					  </table>';
					echo $html;
				  } else { ?>
                  <form action="<?=SITE_URL?>controllers/order_track.php" method="post" class="form-inline track-order needs-validation justify-content-center" novalidate>
                    <input type="text" class="form-control" name="order_id" id="order_id" placeholder=" Enter order #, ex. Mn6HklO" required>
                    <button type="submit" class="btn btn-primary btn-lg rounded-pill">Track it</button>
					<input type="hidden" name="submit_form" id="submit_form" />
					<input type="hidden" name="csrf_token" value="<?=$csrf_token?>">
                  </form>
				  <?php
				  } ?>
                </div>
              </div>
            </div>
          </div>
       </div>
      </div>
    </div>
  </section>