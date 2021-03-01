<?php
require_once("../../admin/_config/config.php");
require_once("../../admin/include/functions.php");
require_once("../common.php");

$user_id = $_SESSION['user_id'];
$order_id = $_SESSION['order_id'];

//Get user data based on userID
$user_data = get_user_data($user_id);

//Get order price based on orderID, path of this function (get_order_price) admin/include/functions.php
$sum_of_orders = get_order_price($order_id);

if(isset($post['empty_cart'])) {
	$order_id = $_SESSION['order_id'];
	$query = mysqli_query($db,"SELECT * FROM `order_items` WHERE order_id='".$order_id."'");
	while($order_items_data = mysqli_fetch_assoc($query)) {
		mysqli_query($db,"DELETE FROM `order_items` WHERE id='".$order_items_data['id']."'");
		$order_i_id_array = $order_item_ids;
		$arr = array_diff($order_i_id_array,array($order_items_data['id']));
		$_SESSION['order_item_ids'] = $arr;
	}
	setRedirect(SITE_URL.'cart');
	exit();
} elseif(isset($post['rorder_id']) && $post['rorder_id']!='') {
	$query=mysqli_query($db,"DELETE FROM `order_items` WHERE id='".$post['rorder_id']."'");
	$get_order_id_array = $order_item_ids;
	$arr = array_diff($get_order_id_array,array($post['rorder_id']));
	$_SESSION['order_item_ids'] = $arr;
	setRedirect(SITE_URL.'cart');
	exit();
} elseif(isset($post['update_cart'])) {
	if(!empty($post['imei_number'])) {
		foreach($post['imei_number'] as $imei_key=>$imei_vl) {
			mysqli_query($db,"UPDATE `order_items` SET imei_number='".$imei_vl."' WHERE id='".$imei_key."'");
		}
	}
	setRedirect(SITE_URL.'cart');
	exit();
} elseif(isset($post['complete_sale'])) {
	//START logic for promocode
	$date = date('Y-m-d');
	$amt = $sum_of_orders;
	$promocode_id = $post['promocode_id'];
	$promo_code = $post['promo_code'];
	if($promocode_id!='' && $promo_code!="" && $amt>0) {
		$query=mysqli_query($db,"SELECT * FROM `promocode` WHERE LOWER(promocode)='".strtolower($promo_code)."' AND ((never_expire='1' AND from_date <= '".$date."') OR (never_expire!='1' AND from_date <= '".$date."' AND to_date>='".$date."'))");
		$promo_code_data = mysqli_fetch_assoc($query);

		$is_allow_code_from_same_cust = true;
		if($promo_code_data['multiple_act_by_same_cust']=='1' && $promo_code_data['multi_act_by_same_cust_qty']>0 && $user_id>0) {
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
		} else {
			$msg = "This promo code has expired or not allowed.";
			setRedirectWithMsg(SITE_URL.'cart',$msg,'info');
			exit();
		}
	} //END logic for promocode

	$upt_order_query = mysqli_query($db,"UPDATE `orders` SET promocode_id='".$promocode_id."', promocode='".$promo_code."', promocode_amt='".$discount_of_amt."', discount_type='".$promo_code_data['discount_type']."', discount='".$discount."' WHERE order_id='".$order_id."'");
	if($upt_order_query=='1') {
		//If already logged in with all fields filled then it will redirect to confirm order page, otherwise redirect to enterdetails page.
		/*if($post['form_submit_type']=="update_cart") {
			$msg = "You have successfully update cart.";
			setRedirectWithMsg(SITE_URL.'cart',$msg,'success');
		} elseif($user_id>0 && $user_data['phone']!="" && $user_data['address']!="" && $user_data['status']=='1') {
			$msg = "Please confirm your sale";
			setRedirectWithMsg(SITE_URL.'cart?action=confirm',$msg,'success');
		} else {
			setRedirect(SITE_URL.'enterdetails');
		}*/

		//$msg='You have successfully completed review order.';
		//setRedirectWithMsg(SITE_URL.'enterdetails',$msg,'success');
		setRedirect(SITE_URL.'enterdetails');
		exit();
	}
} else {
	$msg='Direct access denied';
	setRedirectWithMsg(SITE_URL,$msg,'danger');
	exit();
}  ?>
