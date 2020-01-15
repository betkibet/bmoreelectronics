<?php
require_once("../../admin/_config/config.php");
require_once("../../admin/include/functions.php");

$user_id=$_SESSION['user_id'];
$order_id=$_REQUEST['order_id'];

//Get order batch data, path of this function (get_order_data) admin/include/functions.php
$order_detail = get_order_data($order_id);

//If direct access then it will redirect to home page
if($user_id<=0) {
	setRedirect(SITE_URL);
	exit();
}

//Get order price based on orderID, path of this function (get_order_price) admin/include/functions.php
$sum_of_orders=get_order_price($order_id);

//Get order item list based on orderID, path of this function (get_order_item_list) admin/include/functions.php
$order_item_list = get_order_item_list($order_id);

if($order_detail['promocode_id']>0 && $order_detail['promocode_amt']>0) {
	$promocode_amt = $order_detail['promocode_amt'];
	$discount_amt_label = "Surcharge:";
	if($order_detail['discount_type']=="percentage")
		$discount_amt_label = "Surcharge (".$order_detail['discount']."% of Initial Quote):";

	$total_of_order = $sum_of_orders+$order_detail['promocode_amt'];
	$is_promocode_exist = true;
} else {
	$total_of_order = $sum_of_orders;
}
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Print Order</title>
<link rel="stylesheet" type="text/css" title="stylesheet" href="<?=SITE_URL?>css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" title="stylesheet" href="<?=SITE_URL?>css/style.css">
<link rel="stylesheet" type="text/css" title="stylesheet" href="<?=SITE_URL?>css/print.css" media="print,screen">
<script src="<?=SITE_URL?>js/jquery.min.js" type="text/javascript"></script>
</head>
<body>
  <section class="print">
    <div class="container">
      <div class="row hide_button">
        <div class="col-md-6">
          <input name="cancelButton" type="button" value="Back to My Account" id="cancelButton" class="btn btn-general" onClick="parent.location='<?=SITE_URL?>account'" />
        </div>
        <div class="col-md-6">
          <input name="checkout" type="button" value="Print Order" id="checkoutButton" class="btn btn-general pull-right" onClick="javascript:printit()" />
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
           <table>
             <tr>
               <td class="divider" style="height:10px;"></td>
             </tr>
           </table>
        </div>
      </div>
		  <div class="row">
  			<div class="col-md-12">
          <table class="table table-address">
            <tr>
              <td class="block content-block">
                  <p><strong><?=$order_detail['first_name'].' '.$order_detail['last_name']?></strong><br />
                  <?=$order_detail['address']?><br />
                  <?=$order_detail['address2']?><br />
                  <?=$order_detail['city']?><br />
                  <?=$order_detail['state']?><br />
                  <?=$order_detail['postcode']?><br />
                  <?=($order_detail['country']?'<br />'.$order_detail['country']:'')?>
                  <?=$order_detail['phone']?></p>
              </td>
              <td class="divider"></td>
              <td class="block content-block">
			  	  <img width="100" src="<?=SITE_URL?>images/<?=$general_setting_data['logo']?>">
                  <p><strong><?=$general_setting_data['company_name']?></strong><br />
                  <?=$general_setting_data['company_address']?><br />
                  <?=$general_setting_data['company_city']?><br />
                  <?=$general_setting_data['company_state']?><br />
                  <?=$general_setting_data['company_zipcode']?><br />
                  <?=$general_setting_data['company_country']?><br />
                  <?=$general_setting_data['company_phone']?></p>
                </td>
            </tr>
			<tr>
      </tr>
          </table>
          <div class="alert alert-warning">
            <p>IMPORTANT: Please enclose this delivery note with your mobile phone(s)/device(s) into the <?=$general_setting_data['site_name']?> FREEPOST bag.</p>
          </div>
          <table class="table table-bordered">
            <tr>
              <td align="left" valign="middle"><strong>Order No: </strong><?=$order_id?></td>
          	  <td align="left" valign="middle"><strong>Order Status: </strong><?=ucwords(str_replace('_',' ',$order_detail['status']))?></td>
              <td align="left" valign="middle"><strong>Order Date: </strong><?=date("m-d-Y",strtotime($order_detail['date']))?></td>
              <td align="left" valign="middle"><strong>Approved Date: </strong><?=($order_detail['approved_date']=="0000-00-00 00:00:00"?'--':date("m-d-Y",strtotime($order_detail['approved_date'])))?></td>
              <td align="left" valign="middle"><strong> Expires Date: </strong><?=($order_detail['expire_date']!="0000-00-00 00:00:00"?date("m-d-Y",strtotime($order_detail['expire_date'])):'--')?></td>
              <td align="left" valign="middle"><strong>Payment Method: </strong><?=ucfirst($order_detail['payment_method'])?></td>
            </tr>
          </table>
          <div class="sell-item-table clearfix">
            <table class="table">
              <tr>
              	<td width="2%" align="left" valign="middle"><strong>#</strong></td>
                <td width="68%" align="left" valign="middle"><strong>Handset/Device Type</strong></td>
            	<td width="20%" align="left" valign="middle"><strong>Qty</strong></td>
                <td width="10%" align="left" valign="middle"><strong>Price</strong></td>
              </tr>
              <?php
              foreach($order_item_list as $order_item_list_data) {
              $order_item_data = get_order_item($order_item_list_data['id'],'print'); ?>
				<tr>
				   <td class="divider" colspan="4" style="height:10px;"></td>
				</tr>
				<tr>
				   <td width="2%" align="left" valign="middle"><?=$n=$n+1?></td>
				   <td width="68%" align="left" valign="middle"><?=$order_item_list_data['device_title'].' - '.$order_item_data['device_type']?></td>
				   <td width="20%" align="left" valign="middle"><?=$order_item_list_data['quantity']?></td>
				   <td width="10%" align="left" valign="middle"><?=amount_fomat($order_item_list_data['price'])?></td>
				</tr>
              <?php
              } ?>
            </table>
          </div>
          <div class="sell-item-table-total">
            <div class="pull-right">
              <div class="button-row text-right clearfix">
                <div class="btn">Sell Order Total:</div>
				<div class="btn btn-price"><strong><?=($sum_of_orders>0?amount_fomat($sum_of_orders):'')?></strong></div>
              </div>
              <?php
              if($promocode_amt>0) { ?>
				  <div class="button-row text-right clearfix">
					<div class="btn"><strong><?=$discount_amt_label?></strong></div>
					<div class="btn btn-price"><strong><?=amount_fomat($promocode_amt)?></strong></div>
				  </div>
				  <div class="button-row text-right clearfix">
					<div class="btn"><strong>Total:</strong></div>
					<div class="btn btn-grand-total btn-price"><strong><?=amount_fomat($total_of_order)?></strong></div>
				  </div>
              <?php
              } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</body>
</html>

<script type="text/javascript">
function printit(){
	jQuery('.hide_button').hide();
	if(window.print) {
		window.print() ;
	}

	if(window.close) {
		jQuery('.hide_button').show();
	}
}
</script>
