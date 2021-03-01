<?php
$meta_title = "View Order";
$active_menu = "account";

//Header section
include("include/header.php");

//Get order batch data, path of this function (get_order_data) admin/include/functions.php
$order_detail = get_order_data($order_id, $email = "", $access_token);
if(empty($order_detail)) {
	$msg='Direct access denied';
	setRedirectWithMsg(SITE_URL,$msg,'warning');
	exit();
}

//Get order price based on orderID, path of this function (get_order_price) admin/include/functions.php
$sum_of_orders = get_order_price($order_id);

//Get order item list based on orderID, path of this function (get_order_item_list) admin/include/functions.php
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
$sum_of_paid_order = array_sum($paid_amount_arr);

$promocode_amt = 0;
$discount_amt_label = "";
if($order_detail['promocode_id']>0 && $order_detail['promocode_amt']>0) {
	$promocode_amt = $order_detail['promocode_amt'];
	//$discount_paid_amt_label = "Promocode";
	$discount_amt_label = "";
	if($order_detail['discount_type']=="percentage") {
		//$discount_paid_amt_label = "Promocode (".$order_detail['discount']."% of Initial Quote)";
		$discount_amt_label = " (".$order_detail['discount']."%)";
	}

	$total_of_order = $sum_of_orders+$order_detail['promocode_amt'];
	//$total_of_paid_order = $sum_of_paid_order+$order_detail['promocode_amt'];
	$is_promocode_exist = true;
} else {
	$total_of_order = $sum_of_orders;
	//$total_of_paid_order = $sum_of_paid_order;
}
$bonus_percentage = $order_detail['bonus_percentage'];
$bonus_amount = $order_detail['bonus_amount'];
		
if(!empty($order_detail) && $order_detail['user_type'] == "guest") {
	//Guest related print code here...
} elseif(!empty($order_detail)) {
	//If direct access then it will redirect to home page
	if($user_id<=0) {
		$msg='Direct access denied';
		setRedirectWithMsg(SITE_URL,$msg,'warning');
		exit();
	} elseif($user_data['status'] == '0' || empty($user_data)) {
		$is_include = 1;
		require_once('controllers/logout.php');
	
		$msg='Your account is inactive or removed by shop owner so please contact with support team OR re-create account.';
		setRedirectWithMsg(SITE_URL,$msg,'warning');
		exit();
	}

	if($user_id!=$order_detail['user_id']) {
		setRedirect(SITE_URL);
		exit();
	}
	
	$order_status = $order_detail['order_status_name'];
	$order_status_slug = $order_detail['order_status_slug'];
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
	
	$payment_method_details = json_decode($order_detail['payment_method_details'],true);
	
	$shipment_label_d_url = '';
	$shipment_label_url = $order_detail['shipment_label_url'];
	if($order_detail['sales_pack']=="own_print_label" && $shipment_label_url!="") {
		$shipment_label_d_url = SITE_URL.'controllers/download.php?download_link='.$shipment_label_url;
	} ?>

  <section id="showCategory" class="pb-0">
    <div class="container-fluid">
      <div class="block setting-page py-0 clearfix">
        <div class="row">
          <div class="col-md-5 left-menu col-lg-4 col-xl-3">
            <?php require_once('views/account_menu.php');?>
          </div>
          <div class="col-12 right-content col-sm-12 col-md-5 col-lg-8 col-xl-9">
            <div class="block heading page-heading">
              <div class="d-flex justify-content-center">
                <h3>Order #<?=$order_id?></h3>
              </div>
            </div>
            <div class="block pl-lg-0">
              <div class="order-progress-bar clearfix">
                <span class="shipped <?=($act_parcel_shipped?'active':'')?>"></span>
                <span class="checked <?=($act_device_checked?'active':'')?>"></span>
                <span class="paid <?=($act_order_paid?'active':'')?>"></span>
              </div>
              <div class="order-status text-center">
                <div class="shipped <?=($act_parcel_shipped?'active':'')?>">
                  <img src="<?=SITE_URL?>images/icons/shipped.png" alt="">
                  <span>Parcel is shipped</span>
                </div>
                <div class="checked <?=($act_device_checked?'active':'')?>">
                  <img src="<?=SITE_URL?>images/icons/chcked.png" alt="">
                  <span>Device(s) checked</span>
                </div>
                <div class="paid <?=($act_order_paid?'active':'')?>">
                  <img src="<?=SITE_URL?>images/icons/paid.png" alt="">
                  <span>Order Paid</span>
                </div>
              </div>
              <table id="ac_nopage_table_id" class="display order-details">
                <thead>
                  <tr>
                    <th class="no-sort">ID</th>
                    <th class="no-sort">Date<span></span></th>
                    <th class="no-sort">Devices QTY<span></span></th>
                    <th class="no-sort">Last update<span></span></th>
                    <th class="no-sort">Status</th>
                    <th class="d-md-none no-sort"></th>
                  </tr>
                </thead>
                <tbody>
				  <?php
				  $quantity_array = array();
				  $order_num_of_rows = count($order_item_list);
				  if($order_num_of_rows>0) {
					foreach($order_item_list as $order_item_list_data) {
						$quantity_array[] = $order_item_list_data['quantity'];
					}
				  } ?>
                  <tr>
                    <td><span>ID</span><?=$order_id?></td>
                    <td><span>Date</span><?=format_date($order_detail['order_date'])?></td>
                    <td><span>Devices QTY</span><?=array_sum($quantity_array)?></td>
                    <td><span>Last update</span><?=($order_detail['order_update_date']!='0000-00-00 00:00:00'?format_date($order_detail['order_update_date']):'No updates yet')?></td>
                    <td><span>Status</span><?=replace_us_to_space($order_status)?> <?=($order_status_slug == "completed"?amount_fomat($sum_of_paid_order):'')?></td>
					<td></td>
                  </tr>
				  <?php
				  /*if($order_status_slug == "completed") {
					  if($is_promocode_exist || $bonus_amount) {
						$total = ($total_of_paid_order+$promocode_amt+$bonus_amount);
						if($is_promocode_exist) { ?>
						  <tr>
							<td></td>
							<td colspan="3"><?=$discount_paid_amt_label?></td>
							<td><?=amount_fomat($promocode_amt)?></td>
							<td></td>
						  </tr>
						<?php
						}
						if($bonus_amount>0) { ?>
						  <tr>
							<td></td>
							<td colspan="3">Bonus (<?=$bonus_percentage?>%)</td>
							<td><?=amount_fomat($bonus_amount)?></td>
							<td></td>
						  </tr>
						<?php
						} ?>
						<tr>
							<td></td>
							<td colspan="3">Total</td>
							<td><?=amount_fomat($total)?></td>
							<td></td>
						</tr>
					  <?php
					  }
				  }*/ ?>
                </tbody>
              </table>
              <div class="table d-block d-md-none">
                <div class="tr clearfix">
                  <div class="td head"><span>ID</span><?=$order_id?></div>
                  <div class="td"><span>Date</span><?=format_date($order_detail['order_date'])?></div>
                  <div class="td"><span>Devices QTY</span><?=array_sum($quantity_array)?></div>
                  <div class="td"><span>Last update</span><?=($order_detail['order_update_date']!='0000-00-00 00:00:00'?format_date($order_detail['order_update_date']):'No updates yet')?></div>
                  <div class="td"><span>Status</span><span class="text-danger d-block"><?=replace_us_to_space($order_status)?> <?=($order_status_slug == "completed"?amount_fomat($sum_of_paid_order):'')?></span></div>
				  <?php
				  /*if($order_status_slug == "completed") {
					  if($is_promocode_exist || $bonus_amount) {
						$total = ($total_of_paid_order+$promocode_amt+$bonus_amount);
						if($is_promocode_exist) { ?>
						  <div class="td"><span><?=$discount_paid_amt_label?></span><span class="text-danger d-block"><?=amount_fomat($promocode_amt)?></span></div>
						<?php
						}
						if($bonus_amount>0) { ?>
						  <div class="td"><span>Bonus (<?=$bonus_percentage?>%)</span><span class="text-danger d-block"><?=amount_fomat($bonus_amount)?></span></div>
						<?php
						} ?>
						<div class="td"><span>Total</span><span class="text-danger d-block"><?=amount_fomat($total)?></span></div>
					  <?php
					  }
				  }*/ ?>
                </div>
              </div>
            </div>
            <div class="block order-info-box">
              <div class="card">
                <div class="card-body">
				  <?php
				  if($order_detail['payment_method'] == "paypal") { ?>
                  <p>PayPal address for payments - <a href="javascript:void(0);"><?=$payment_method_details['email_address']?></a></p>
				  <?php
				  } ?>
                  <p>Order USPS tracking <a href="https://tools.usps.com/go/TrackConfirmAction?qtc_tLabels1=<?=$order_detail['shipment_tracking_code']?>" target="_blank"><?=($order_detail['shipment_tracking_code']?'#'.$order_detail['shipment_tracking_code']:'No data')?></a><?=($order_detail['shipment_tracking_code']?'&nbsp; <a href="'.$shipment_label_d_url.'">Download label</a>':'')?></p>
				  
				  <?php
				  if($show_cust_delivery_note == '1') { ?>
				  <a class="btn btn-primary btn-lg rounded-pill mb-2 mb-md-0" href="javascript:open_window('<?=SITE_URL?>views/print/print_delivery_note.php?order_id=<?=$order_id.'&access_token='.$access_token?>')">Delivery Note <i class="ion ion-md-download"></i></a>
				  <?php
				  }
				  if($show_cust_order_form == '1') { ?>
				  <a class="btn btn-primary btn-lg rounded-pill mb-2 mb-md-0" href="<?=SITE_URL?>pdf/order-<?=$order_id?>.pdf" target="_blank">Order Form <i class="ion ion-md-download"></i></a>
				  <?php
				  }
				  if($show_cust_sales_confirmation == '1') { ?>
				  <a class="btn btn-primary btn-lg rounded-pill mb-2 mb-md-0" href="<?=SITE_URL?>views/print/sales_confirmation.php?order_id=<?=$order_id.'&access_token='.$access_token?>" target="_blank">Sales Confirmation <i class="ion ion-md-download"></i></a>
				  <?php
				  } ?>
				  
                </div>
              </div>
            </div>
            <div class="block order-detail-page">
              <h3>Ordered Device(s)</h3>
              <table class="table table-borderless parent">
                <tr>
                  <th class="sl">No</th>
                  <th class="description">Name description</th>
                  <th class="price">Price</th>
                  <th class="action mobile-action-show">Status</th>
                </tr>
				<?php
				$price_is_reduced_order_item_status_id = get_order_status_data('order_item_status','price-is-reduced')['data']['id'];
				
				$o_n = 1;
				foreach($order_item_list as $order_item_list_data) {
				$order_item_data = get_order_item($order_item_list_data['id'],'print');
				$exp_order_item_id = explode('/',$order_item_list_data['order_item_id']); ?>
                <tr>
                  <td class="sl"><?=/*$order_item_list_data['order_item_id']*/$exp_order_item_id[1]?></td>
                  <td class="description item-description-<?=$order_item_list_data['id']?>">
                    <h6><?=$order_item_list_data['model_title']?></h6>
                    <a class="d-block d-md-none d-lg-none device-info" data-id="<?=$order_item_list_data['id']?>" href="javascript:void(0)">more info</a>
					<?=$order_item_data['device_type']?>
					<?php
					$item_images_array = json_decode($order_item_list_data['images_from_shop'],true);
					if(!empty($item_images_array)) {
						foreach($item_images_array as $ii_k=>$ii_v) {
							if($ii_v) {
								$ii_k_n=$ii_k_n+1; ?>
								<a class="attachment-btn" target="_blank" href="<?=SITE_URL?>images/order/items/<?=$ii_v?>"><img src="<?=SITE_URL?>images/icons/image-icon.png" alt="Photo-0<?=$ii_k_n?>"><?=$ii_k_n?></a>
							<?php
							}
						}
					}
					$item_videos_array = json_decode($order_item_list_data['videos_from_shop'],true);
					if(!empty($item_videos_array)) {
						foreach($item_videos_array as $iv_k=>$iv_v) {
							if($iv_v) {
								$iv_k_n=$iv_k_n+1; ?>
								<a class="attachment-btn" target="_blank" href="<?=$iv_v?>"><img src="<?=SITE_URL?>images/icons/video-icon.png" alt="Video-0<?=$iv_k_n?>"><?=$iv_k_n?></a>
							<?php
							}
						}
					} ?>
                  </td>
                  <td class="price">
				    <?php
					echo amount_fomat($order_item_list_data['price']);
					if($order_item_list_data['item_status'] == $price_is_reduced_order_item_status_id) {
						$item_prev_price_dt = get_item_price_of_prev_history($order_item_list_data['id']);
						echo '<small><br>Was '.amount_fomat($item_prev_price_dt['prev_price']).'</small>';
					} ?>
				  </td>
                  <td class="action mobile-action-show">
				  	<?php
					if($order_item_list_data['item_status'] == $price_is_reduced_order_item_status_id) { ?>
						<a href="<?=SITE_URL?>controllers/order/order.php?t=<?=$access_token?>&item_id=<?=$order_item_list_data['id']?>&mode=offer_accepted" class="text-success">Accept</a>&nbsp;/&nbsp;<a href="<?=SITE_URL?>controllers/order/order.php?t=<?=$access_token?>&item_id=<?=$order_item_list_data['id']?>&mode=offer_rejected" class="text-danger">Decline</a><br />
					<?php
					} ?>
				  	<span class="text-success"><?=replace_us_to_space($order_item_list_data['order_item_status_name'])?></span>
				  </td>
                </tr>
				<?php
				$o_n++;
				} ?>
              </table>
            </div>
			
			<?php
			$paid_order_item_status_id = get_order_status_data('order_item_status','paid')['data']['id'];
			
			$paid_order_item_list = array();
			foreach($order_item_list as $order_item_list_data) {
				if($order_item_list_data['item_status'] == $paid_order_item_status_id) {
					$paid_order_item_list[] = $order_item_list_data;
				}
			}
			if(!empty($paid_order_item_list)) { ?>
				<div class="block order-summary">
				  <table class="table">
					<tr>
					  <th></th>
					  <th colspan="2">Paid devices: </th>
					</tr>
					<?php
					$paid_total_amt_array = array();
					$o_n = 1;
					$paid_device_avail = false;
					foreach($paid_order_item_list as $paid_order_item_list_data) {
						$paid_device_avail = true;
						$paid_item_amount = @$paid_amount_arr[$paid_order_item_list_data['id']];
						$paid_total_amt_array[] = $paid_item_amount;
						$order_item_data = get_order_item($paid_order_item_list_data['id'],'print'); ?>
						<tr>
						  <td class="sl"><?=$o_n?></td>
						  <td><?=$paid_order_item_list_data['model_title']?></td>
						  <td><?=amount_fomat($paid_item_amount)?></td>
						</tr>
						<?php
						$o_n++;
					}
					if(!empty($paid_total_amt_array)) { ?>
						<tr>
						  <td colspan="3" class="device-total">
							<?php
							if($order_detail['payment_method'] == "paypal") { ?>
								= <?=amount_fomat(array_sum($paid_total_amt_array))?> by PayPal to <a href="javascript:void(0);"><?=$payment_method_details['email_address']?></a>
							<?php
							} else { ?>
								= <?=amount_fomat(array_sum($paid_total_amt_array))?> by <?=replace_us_to_space($order_detail['payment_method'])?>
							<?php
							} ?>
						  </td>
						</tr>
						
						<?php
						if($promocode_amt>0) { ?>
						<tr>
						  <td colspan="3" class="device-total">
							 <b>Promocode:</b> <?=$order_detail['promocode'].$discount_amt_label.' on paid device'?>
						  </td>
						</tr>
						<?php
						}
					} ?>
				  </table>
				</div>
			<?php
			} ?>
			
            <div class="block tracking-update">
              <h3>Order status updates</h3>
              <table class="table">
			    <?php
				$order_payment_status_list = get_order_payment_status_log($order_id);
				foreach($order_payment_status_list as $order_payment_status_data) {
					$log_type = $order_payment_status_data['log_type'];
					$order_status = isset($order_payment_status_data['order_status'])?$order_payment_status_data['order_status']:'';
					$item_status = isset($order_payment_status_data['item_status'])?$order_payment_status_data['item_status']:'';
					$status_log_date = format_date($order_payment_status_data['date']).' '.format_time($order_payment_status_data['date']);
					$item_id = $order_payment_status_data['item_id'];
					$exp_order_item_id = explode('/',$order_payment_status_data['order_item_id']);
					$shipment_tracking_code = isset($order_payment_status_data['shipment_tracking_code'])?$order_payment_status_data['shipment_tracking_code']:'';
						
					$oh_const_patterns = array(
						'{$status_log_date}',
						'{$shipment_tracking_code}',
						'{$company_name}',
						'{$item_id}'
					);
					
					$oh_const_replacements = array(
						$status_log_date,
						($shipment_tracking_code?'# '.$shipment_tracking_code:''),
						$company_name,
						($order_payment_status_data['item_id']>0?$order_payment_status_data['item_id']:'')
					);
					
					/*if($order_status == "waiting_shipment") {
						$shipment_tracking_code = $order_payment_status_data['shipment_tracking_code']; ?>
						<tr>
						  <td><?=$status_log_date?> - order created with USPS tracking <?=($shipment_tracking_code?'# '.$shipment_tracking_code:'')?></td>
						</tr>
					<?php
					}
					elseif($order_status == "shipped") { ?>
						<tr>
						  <td><?=$status_log_date?> - shipped to <?=$company_name?></td>
						</tr>
					<?php
					}
					elseif($order_status == "delivered") { ?>
						<tr>
						  <td><?=$status_log_date?> - <?=$company_name?> received the parcel</td>
						</tr>
					<?php
					}
					elseif($item_status == "checked") { ?>
						<tr>
						  <td>
							<?=$status_log_date?> - <?=$company_name?> checked device #<?=$exp_order_item_id[1]?>
						  </td>
						</tr>
					<?php
					}
					elseif($order_status == "absent") { ?>
						<tr>
						  <td>
							<?=$status_log_date?> - Device #<?=$exp_order_item_id[1]?> is <span class="text-danger">ABSENT</span>
						  </td>
						</tr>
					<?php
					}
					else*/if($log_type == "payment") { ?>
					<tr>
					  <td>
					    <?php
						echo $status_log_date?> - <?=$company_name?> paid <?=amount_fomat($order_payment_status_data['paid_amount'])?> by <?=replace_us_to_space($order_detail['payment_method'])?> for device #<?=$exp_order_item_id[1].($order_payment_status_data['transaction_id']?', transaction id: '.$order_payment_status_data['transaction_id']:'');
						$payment_receipt_array = json_decode($order_payment_status_data['payment_receipt'],true);
						if(!empty($payment_receipt_array)) {
							echo '<br>';
							$pr_v_n = 1;
							foreach($payment_receipt_array as $pr_k=>$pr_v) {
								if($pr_v) {
									$pr_v_n = $pr_v_n+1; ?>
									<a class="attachment-btn" target="_blank" href="<?=SITE_URL?>images/order/payment/<?=$pr_v?>"><img src="<?=SITE_URL?>images/icons/image-icon.png" alt="Photo-0<?=$pr_v_n?>"> Photo-0<?=$pr_v_n?></a>
								<?php
								}
							}
						}
						if($order_payment_status_data['cheque_photo']) { ?>
							<a class="attachment-btn" target="_blank" href="<?=SITE_URL?>images/order/payment/<?=$order_payment_status_data['cheque_photo']?>"><img src="<?=SITE_URL?>images/icons/image-icon.png" alt="Photo-0<?=$pr_v_n+1?>"> Photo-0<?=$pr_v_n+1?></a>
						<?php
						} ?>
					  </td>
					</tr>
					<?php
					} elseif($order_status > 0) {
						$order_status_data_for_hist = get_order_status_data('order_status',"",$order_status)['data'];
						if($order_status_data_for_hist['text_in_order_history']) {
							$order_status_data_for_hist['text_in_order_history'] = str_replace($oh_const_patterns, $oh_const_replacements, $order_status_data_for_hist['text_in_order_history']); ?>
							<tr>
							  <td>
								<?=$order_status_data_for_hist['text_in_order_history']?>
							  </td>
							</tr>
						<?php
						} else { ?>
							<tr>
							  <td>
								<?=$status_log_date?> - <?=$company_name?> <?=replace_us_to_space($order_status_data_for_hist['name'])?> the order
							  </td>
							</tr>
						<?php
						}
					} elseif($item_status > 0) {
						$order_item_status_data_for_hist = get_order_status_data('order_item_status',"",$item_status)['data'];
						if($order_item_status_data_for_hist['text_in_order_history']) {
							$order_item_status_data_for_hist['text_in_order_history'] = str_replace($oh_const_patterns, $oh_const_replacements, $order_item_status_data_for_hist['text_in_order_history']); ?>
							<tr>
							  <td>
								<span class="d-none d-md-block"><?=$order_item_status_data_for_hist['text_in_order_history']?></span>
								<span class="d-lg-none"><?=$order_item_status_data_for_hist['text_in_order_history']?></span>
							  </td>
							</tr>
						<?php
						} else { ?>
							<tr>
							  <td>
								<span class="d-none d-md-block"><?=$status_log_date?> - <?=$company_name?> <?=replace_us_to_space($order_item_status_data_for_hist['name'])?> for device #<?=$item_id?></span>
								<span class="d-lg-none"><?=$status_log_date?> - <?=$company_name?> <?=replace_us_to_space($order_item_status_data_for_hist['name'])?> for device #<?=$item_id?></span>
							  </td>
							</tr>
						<?php
						}
					}
				} ?>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

<script language="javascript" type="text/javascript">
function open_window(url) {
	apply = window.open(url,"Loading",'toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=1000,height=800');
}
</script>
<?php
} ?>