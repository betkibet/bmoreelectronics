<?php
require_once("../../admin/_config/config.php");
require_once("../../admin/include/functions.php");

$order_id = $_GET['order_id'];
$access_token = $_GET['access_token'];
if($access_token == "") {
	$msg='Direct access denied';
	setRedirectWithMsg(SITE_URL,$msg,'warning');
	exit();
}

//Get order batch data, path of this function (get_order_data) admin/include/functions.php
$order_detail = get_order_data($order_id, $email = "", $access_token);
if(empty($order_detail)) {
	$msg='Direct access denied';
	setRedirectWithMsg(SITE_URL,$msg,'warning');
	exit();
}

//Get order price based on orderID, path of this function (get_order_price) admin/include/functions.php
$sum_of_orders = get_order_price($order_id);
$sell_order_total = ($sum_of_orders>0?$sum_of_orders:'');

//Get order item list based on orderID, path of this function (get_order_item_list) admin/include/functions.php
$order_item_list = get_order_item_list($order_id);

$promocode_amt = 0;
$discount_amt_label = '';
$is_promocode_exist = false;
if($order_detail['promocode_id']>0 && $order_detail['promocode_amt']>0) {
	$promocode_amt = $order_detail['promocode_amt'];
	$discount_amt_label = "Promocode:";
	if($order_detail['discount_type']=="percentage")
		$discount_amt_label = "Promocode (".$order_detail['discount']."% of Initial Quote):";

	$total_of_order = $sum_of_orders+$order_detail['promocode_amt'];
	$is_promocode_exist = true;
} else {
	$total_of_order = $sum_of_orders;
}

$bonus_amount = 0;
$bonus_percentage = $order_detail['bonus_percentage'];
$bonus_amount = $order_detail['bonus_amount'];

$admin_user_data = get_admin_user_data();
?>

<!DOCTYPE HTML>
<html class="landing-1 default-style">
<head>

<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="x-ua-compatible" content="IE=edge" >
<title>Print Order</title>

<!-- Jquery Data Table -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="<?=SITE_URL?>css/style.css">
  
<link rel="stylesheet" href="<?=SITE_URL?>css/intlTelInput.css">

<link rel="stylesheet" href="<?=SITE_URL?>css/bootstrapValidator.min.css">
<link rel="stylesheet" href="<?=SITE_URL?>css/custom.css">

<script src="<?=SITE_URL?>js/jquery.min.js"></script>
<script src="<?=SITE_URL?>js/jquery.scrollTo.min.js"></script>
</head>
<body class="inner">
  <section>
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="block">
            <div class="row">
              <div class="col-6 col-md-6">
                <a class="btn btn-secondary rounded-pill px-5" onClick="window.close();" href="javascript:void(0);">Close</a>
              </div>
              <div class="col-6 col-md-6 text-right">
                <a class="btn btn-primary rounded-pill text-white px-5" onClick="javascript:printDiv('printablediv')">Print</a>
              </div>
            </div>
          </div>
		  <div id="printablediv">
			  <div class="block">
				<div class="row">
				  <div class="col-md-6">
					<div class="h4">ORDER NO: <strong><?=$order_id?></strong></div>
				  </div>
				  <div class="col-md-3">
					<p class="mb-0"><strong><?=$order_detail['shipping_first_name'].' '.$order_detail['shipping_last_name']?></strong></p>
					<p class="text-muted">
					  <?=$order_detail['shipping_address1']?><br />
					  <?=($order_detail['shipping_address2']?$order_detail['shipping_address2'].'<br />':'')?>
					  <?=$order_detail['shipping_city'].' '.$order_detail['shipping_state'].' '.$order_detail['shipping_postcode']?><br />
					  <?=($order_detail['shipping_country']?$order_detail['shipping_country'].'<br />':'')?>
					  <?=$order_detail['shipping_phone']?>
					</p>
				  </div>
				  <div class="col-md-3">
					 <p>
					  <a href="<?=SITE_URL?>">
						<?php
						if($logo_url) {
							echo '<img src="'.$logo_url.'?uniqid='.unique_id().'" width="119">';
						}
						?>
					  </a>
					</p> 
					<p class="mb-0"><strong><?=$general_setting_data['company_name']?></strong></p>
					<p class="text-muted">
						<?=$general_setting_data['company_address']?><br />
						<?=$general_setting_data['company_city'].' '.$general_setting_data['company_state'].' '.$general_setting_data['company_zipcode']?><br />
						<?=$general_setting_data['company_country']?><br />
						<?=$general_setting_data['company_phone']?>
					</p>
				  </div>
				</div>
				<div class="row">
				  <div class="col-md-3">
					<div class="card text-center mb-3">
					  <div class="card-header">
						<strong>ORDER STATUS</strong>
					  </div>
					  <div class="card-body">
						<div class="text-warning"><?=replace_us_to_space($order_detail['order_status_name'])?></div>
					  </div>
					</div>
				  </div>
				  <div class="col-md-3">
					<div class="card text-center mb-3">
					  <div class="card-header">
						<strong>ORDER DATE</strong>
					  </div>
					  <div class="card-body">
						<?=format_date($order_detail['date'])?>
					  </div>
					</div>
				  </div>
				  <div class="col-md-3">
					<div class="card text-center mb-3">
					  <div class="card-header">
						<strong>APPROVED DATE</strong>
					  </div>
					  <div class="card-body">
						<?=($order_detail['approved_date']=="0000-00-00 00:00:00"?'--':format_date($order_detail['approved_date']))?>
					  </div>
					</div>
				  </div>
				  <div class="col-md-3">
					<div class="card text-center">
					  <div class="card-header">
						<strong>EXPIRES DATE</strong>
					  </div>
					  <div class="card-body">
						<?=($order_detail['expire_date']=="0000-00-00 00:00:00"?'--':format_date($order_detail['expire_date']))?>
					  </div>
					</div>
				  </div>
				</div>
			  </div>
			  <div class="block order-info-box">
				<div class="card">
				  <div class="card-body">
				  	<p>Payment Method: <?=replace_us_to_space_pmt_mthd($order_detail['payment_method'])?></p>
					<?php
					$payment_method_details = json_decode($order_detail['payment_method_details'],true);
					if(!empty($payment_method_details)) {
						echo '<p>';
						foreach($payment_method_details as $k => $v) {
							echo replace_us_to_space($k).': '.$v.'<br>';
						}
						echo '</p>';
					} ?>
					<?php /*?><p>Order USPS tracking <a href="#">#9405509699917057935095</a></p><?php */?>
				  </div>
				</div>
			  </div>
			  
			  <div class="block order-detail-page">
				<h3>Device(s)</h3>
				<table class="table table-cart parent">
				  <tr>
					<th class="sl">No</th>
					<th class="description">Name description</th>
					<th class="quantity">Quantity</th>
					<th class="price">Price</th>
				  </tr>
				  <?php
				  $n_o_i = 0;
				  foreach($order_item_list as $order_item_list_data) {
				  $n_o_i = ($n_o_i+1);
				  $order_item_data = get_order_item($order_item_list_data['id'],'print'); ?>
				  <tr>
					<td class="sl"><?=$n_o_i?></td>
					<td class="description">
					  <h6><?=($order_item_list_data['device_title']?$order_item_list_data['device_title'].' - ':'').$order_item_data['device_type']?></h6>
					</td>
					<td class="price"><?=$order_item_list_data['quantity']?></td>
					<td class="price"><?=amount_fomat($order_item_list_data['price'])?></td>
				  </tr>
				  <?php
				  } ?>
				  
				    <tr>
						<td align="right" colspan="4" class="price">Sell Order Total: <?=($sum_of_orders>0?amount_fomat($sum_of_orders):'')?></td>
					</tr>
					<?php
					if($is_promocode_exist || $bonus_amount) {
		  				$total = ($sell_order_total+$promocode_amt+$bonus_amount);
						if($is_promocode_exist) { ?>
							<tr>
								<td align="right" colspan="4" class="price"><?=$discount_amt_label?> <?=amount_fomat($promocode_amt)?></td>
							</tr>
						<?php
						}
						if($bonus_amount>0) { ?>
							<tr>
								<td align="right" colspan="4" class="price">Bonus (<?=$bonus_percentage?>%): <?= amount_fomat($bonus_amount) ?></td>
							</tr>
						<?php
						} ?>
						<tr>
							<td align="right" colspan="4" class="price">Total: <?=amount_fomat($total)?></td>
						</tr>
					<?php
					} ?>
				  
				</table>
			  </div>

			</div>
        </div>
      </div>
    </div>
  </section>
</body>
</html>

<script language="javascript" type="text/javascript">
function printDiv(divID) {

	var divElements = document.getElementById(divID).innerHTML;
	var oldPage = document.body.innerHTML;

	document.body.innerHTML = divElements;

	//Print Page
	window.print();

	//Restore orignal HTML
	document.body.innerHTML = oldPage;
}
</script>
