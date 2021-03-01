<?php
require_once("../admin/_config/config.php");
require_once("../admin/include/functions.php");
require_once("common.php");

$post = $_POST;
$post_order_id = $post['order_id'];
$order_id = $_SESSION['order_id'];

//Get order price based on orderID, path of this function (get_order_price) admin/include/functions.php
$sum_of_orders = get_order_price($order_id);

if($order_id != $post_order_id) {
	echo 'Direct access not allow.';
	exit();
}
elseif($order_id && $post_order_id) {
	//START logic for promocode
	$date = date('Y-m-d');
	$amt = $sum_of_orders;
	$promocode_id = $post['promocode_id'];
	$promo_code = $post['promo_code'];
	if($promocode_id!='' && $promo_code!="" && $amt>0) {
		$query=mysqli_query($db,"SELECT * FROM `promocode` WHERE LOWER(promocode)='".strtolower($promo_code)."' AND ((never_expire='1' AND from_date <= '".$date."') OR (never_expire!='1' AND from_date <= '".$date."' AND to_date>='".$date."')) AND status='1'");
		$promo_code_data = mysqli_fetch_assoc($query);

		$is_allow_code_from_same_cust = true;

		$is_allow_code_from_cust = true;
		if($promo_code_data['act_by_cust']>0) {
			$query=mysqli_query($db,"SELECT COUNT(*) AS act_by_cust FROM `orders` WHERE promocode_id='".$promo_code_data['id']."'");
			$act_by_cust_data = mysqli_fetch_assoc($query);
			if($act_by_cust_data['act_by_cust']>$promo_code_data['act_by_cust']) {
				$is_allow_code_from_cust = false;
			}
		}

		$is_promocode_exist = false;
		if(!empty($promo_code_data) && $is_allow_code_from_same_cust && $is_allow_code_from_cust) {
			$discount = $promo_code_data['discount'];
			if($promo_code_data['discount_type']=="flat") {
				$discount_of_amt = $discount;
				$total = ($amt+$discount);
				$discount_amt_with_format = amount_fomat($discount_of_amt);
				$discount_amt_label = "Surcharge: ";
			} elseif($promo_code_data['discount_type']=="percentage") {
				$discount_of_amt = (($amt*$discount) / 100);
				$total = ($amt+$discount_of_amt);
				$discount_amt_with_format = amount_fomat($discount_of_amt);
				$discount_amt_label = "Surcharge (".$discount."%): ";
			}
			$is_promocode_exist = true;
		}
	} //END logic for promocode

	mysqli_query($db,"UPDATE `orders` SET promocode_id='".$promocode_id."', promocode='".$promo_code."', promocode_amt='".$discount_of_amt."', discount_type='".$promo_code_data['discount_type']."', discount='".$discount."', bonus_percentage='".$post['bonus_percentage']."', bonus_amount='".$post['bonus_amount']."' WHERE order_id='".$order_id."'");
}  ?>
