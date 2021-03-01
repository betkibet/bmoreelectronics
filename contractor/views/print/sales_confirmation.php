<?php
require_once("../../../admin/_config/config.php");
require_once("../../../admin/include/functions.php");

if(empty($_SESSION['is_admin']) || empty($_SESSION['admin_username'])) {
    echo 'Direct access not allowed';
	exit();
}

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

//Get order item list based on orderID, path of this function (get_order_item_list) admin/include/functions.php
$order_item_list = get_order_item_list($order_id);

$promocode_amt = 0;
$discount_amt_label = "";
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

$express_service = $order_detail['express_service'];
$express_service_price = $order_detail['express_service_price'];
$shipping_insurance = $order_detail['shipping_insurance'];
$shipping_insurance_per = $order_detail['shipping_insurance_per'];

$f_express_service_price = 0;
$f_shipping_insurance_price = 0;
if($express_service == '1') {
	$f_express_service_price = $express_service_price;
	$total_of_order -= $f_express_service_price;
}
if($shipping_insurance == '1') {
	$f_shipping_insurance_price = ($sum_of_orders * $shipping_insurance_per / 100);
	$total_of_order -= $f_shipping_insurance_price;
}

$html = <<<EOF
<!-- EXAMPLE OF CSS STYLE -->
<style>
table,td{
  margin:0;
  padding:0;
}
.small-text{
  font-size:10px;
  text-align:center;
}
.block{
  width:45%;
}
.block-border{
  border:1px dashed #ddd;
}
.title{
  font-size:20px;
  font-weight:bold;
}
.tbl-border-radius{
border-radius:10px;
}
</style>
EOF;

$html.='
<table cell-padding="0" cell-spacing="0" border="0;" width="100%" style="padding:5px 0px 5px 0px;">
	<tbody>
	  <tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td align="center"><img width="250" src="'.SITE_URL.'images/'.$general_setting_data['logo'].'"></td>
	  </tr>
	  <tr>
		<td colspan="3">
			Hi! '.$order_detail['name'].',<br><br>
			Thank you for Choosing to turn your old mobile into cash with '.SITE_NAME.'.<br>
			We hope you found our online process simple, fast and friendly.
		</td>
	  </tr>
	  <tr style="padding-top:5px;">
		 <td colspan="3"><strong>Your order number is: '.$order_id.'</strong><br>Please quote the above order number in any communications.</td>
	  </tr>
	  <tr style="padding-top:5px;">
		 <td colspan="3"><strong>You have sold the following device (s):</strong></td>
	  </tr>
	</tbody>
</table>

<table cell-padding="0" cell-spacing="0" border="0;" width="100%" style="padding:5px 5px 5px 5px;background-color:#dddddd;" class="tbl-border-radius">
	<tbody>
		<tr>
			<th width="65%"><strong>Handset/Device Type</strong></th>
			<th width="20%"><strong>Quantity</strong></th>
			<th width="15%"><strong>Price</strong></th>
		</tr>';
		
		foreach($order_item_list as $order_item_list_data) {
			$order_item_data = get_order_item($order_item_list_data['id'],'general');
			$html.='<tr>';
				$html.='<td width="65%" valign="middle">'.$order_item_list_data['device_title'].' - '.$order_item_data['device_type'].'</td>';
				$html.='<td width="20%" valign="middle">'.$order_item_list_data['quantity'].'</td>';
				$html.='<td width="15%" valign="middle">'.amount_fomat($order_item_list_data['price']).'</td>';
			$html.='</tr>';
		}
	
		$html.='<tr>
			<td colspan="2" align="right"><strong>Sell Order Total:</strong></td>
			<td><strong>'.($sum_of_orders>0?amount_fomat($sum_of_orders):'').'</strong></td>
		</tr>';
	  
		if($promocode_amt>0 || $f_express_service_price > 0 || $f_shipping_insurance_price > 0) {
		  if($promocode_amt>0) {
		  $html.='<tr>
			<td colspan="2" align="right"><strong>'.$discount_amt_label.'</strong></td>
			<td><strong>'.amount_fomat($promocode_amt).'</strong></td>
		  </tr>';
		  }
		  if($f_express_service_price>0) {
		  $html.='<tr>
			<td colspan="2" align="right"><strong>Expedited Service:</strong></td>
			<td><strong>-'.amount_fomat($f_express_service_price).'</strong></td>
		  </tr>';
		  }
		  if($f_shipping_insurance_price>0) {
		  $html.='<tr>
			<td colspan="2" align="right"><strong>Shipping Insurance</strong></td>
			<td><strong>-'.amount_fomat($f_shipping_insurance_price).'</strong></td>
		  </tr>';
		  }
		  $html.='<tr>
			<td colspan="2" align="right"><strong>Total:</strong></td>
			<td><strong>'.amount_fomat($total_of_order).'</strong></td>
		  </tr>';
		}
$html.='</tbody>
</table>
<table cell-padding="0" cell-spacing="0" border="0;" width="100%" style="padding:10px 0px 2px 0px;">
	<tbody>
		<tr style="padding-top:5px;">
		 <td colspan="3">
		 	The payment method you have chosen is: '.ucfirst($order_detail['payment_method']).'<br><br>
		 	<strong>We have attached the following with this letter:</strong> <br>
			&nbsp;&nbsp;1. Delivery Note - Print and include with your Device(s).<br>
			&nbsp;&nbsp;2. Return Label - Print and attach to outside of a padded envelope/box<br><br>
<strong>The Sooner you send your item(s), the sooner you get paid!</strong><br>

Don&#39;t Delay; your items need to reach to us within '.$order_expired_days.' days or the price we offered you could go
down.<br>
We&#39;ll email you once we received your item and provided, they meet our terms and conditions,
we&#39;ll make payment on the very same day!<br><br>

<strong>Keeping you up to date </strong><br>
To track or view your order progress, simply click My Account and enter your Email and
Password, or contact us at '.$site_email.' or call '.$site_phone.' during business
hours.<br><br>

Regards,<br>
Team '.SITE_NAME.'

		 </td>
	  </tr>
	  <tr>
	  	<td align="center"><img width="250" src="'.SITE_URL.'images/'.$general_setting_data['logo'].'"></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	  </tr>';
$html.='</tbody>
</table>';

//echo $html;
//exit;

require_once(CP_ROOT_PATH.'/libraries/tcpdf/config/tcpdf_config.php');
require_once(CP_ROOT_PATH.'/libraries/tcpdf/tcpdf.php');

// create new PDF document
$pdf = new TCPDF();

// set document information
$pdf->SetCreator($general_setting_data['from_name']);
$pdf->SetAuthor($general_setting_data['from_name']);
$pdf->SetTitle($general_setting_data['from_name']);

$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);

// add a page
$pdf->AddPage();

$pdf->SetFont('dejavusans');

$pdf->writeHtml($html);

ob_end_clean();

$pdf->Output('pdf/free_post_label-'.date('Y-m-d-H-i-s').'.pdf', 'I');
?>