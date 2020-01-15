<?php
require_once("../admin/_config/config.php");
require_once("../admin/include/functions.php");

$date = date('Y-m-d');
$promo_code = $_REQUEST['promo_code'];
$amt = $_REQUEST['amt'];
$user_id = $_REQUEST['user_id'];
$order_id = $_REQUEST['order_id'];
if($promo_code!="" && $user_id!='' && $order_id!='') {
	$response = array();
	$query=mysqli_query($db,"SELECT * FROM `promocode` WHERE LOWER(promocode)='".strtolower($promo_code)."' AND ((never_expire='1' AND from_date <= '".$date."') OR (never_expire!='1' AND from_date <= '".$date."' AND to_date>='".$date."')) AND status='1'");
	$promo_code_data = mysqli_fetch_assoc($query);

	$is_allow_code_from_same_cust = true;
	if($promo_code_data['multiple_act_by_same_cust']=='1' && $promo_code_data['multi_act_by_same_cust_qty']>0) {
		$query=mysqli_query($db,"SELECT COUNT(*) AS multiple_act_by_same_cust FROM `orders` WHERE promocode_id='".$promo_code_data['id']."' AND user_id='".$user_id."'");
		$act_by_same_cust_data = mysqli_fetch_assoc($query);
		if($act_by_same_cust_data['multiple_act_by_same_cust']>$promo_code_data['multi_act_by_same_cust_qty']) {
			$is_allow_code_from_same_cust = false;
		}
	}

	$is_allow_code_from_cust = true;
	if($promo_code_data['act_by_cust']>0) {
		$query=mysqli_query($db,"SELECT COUNT(*) AS act_by_cust FROM `orders` WHERE promocode_id='".$promo_code_data['id']."'");
		$act_by_cust_data = mysqli_fetch_assoc($query);
		if($act_by_cust_data['act_by_cust']>$promo_code_data['act_by_cust']) {
			$is_allow_code_from_cust = false;
		}
	}

	$response['promo_code_data'] = $promo_code_data;
	$response['act_by_same_cust_data'] = $act_by_same_cust_data;
	$response['act_by_cust_data'] = $act_by_cust_data;
	$response['is_allow_code_from_same_cust'] = $is_allow_code_from_same_cust;
	$response['is_allow_code_from_cust'] = $is_allow_code_from_cust;

	if(!empty($promo_code_data) && $is_allow_code_from_same_cust && $is_allow_code_from_cust) {
		$discount = $promo_code_data['discount'];
		$response['discount_type'] = $promo_code_data['discount_type'];
		if($promo_code_data['discount_type']=="flat") {
			$discount_of_amt = $discount;
			$total = ($amt+$discount);
		} elseif($promo_code_data['discount_type']=="percentage") {
			$discount_of_amt = (($amt*$discount) / 100);
			$total = ($amt+$discount_of_amt);
		}
		$response['coupon_type'] = $promo_code_data['discount_type'];
		$response['percentage_amt'] = $discount;
		$response['discount_of_amt'] = amount_fomat($discount_of_amt);
		$response['total'] = amount_fomat($total);
		
		$response['promocode_id'] = $promo_code_data['id'];
		$response['promocode_value'] = $promo_code_data['promocode'];

		$response['mode'] = 'applied';
	} else {
		$response['msg'] = "This promo code has expired or not allowed.";
		$response['mode'] = 'expired';
	}
	echo json_encode($response);
}
?>