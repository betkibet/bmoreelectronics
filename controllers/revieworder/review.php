<?php
require_once("../../admin/_config/config.php");
require_once("../../admin/include/functions.php");

$user_id = $_SESSION['user_id'];
$order_id=$_SESSION['order_id'];

//Get user data based on userID
$user_data = get_user_data($user_id);

if(isset($post['rorder_id']) && $post['rorder_id']!='') {
	$query=mysqli_query($db,"DELETE FROM `order_items` WHERE id='".$post['rorder_id']."'");
	$get_order_id_array = $order_item_ids;
	$arr = array_diff($get_order_id_array,array($post['rorder_id']));
	$_SESSION['order_item_ids'] = $arr;
	setRedirect(SITE_URL.'revieworder');
	exit();
} elseif(isset($post['complete_sale']) || isset($post['update_cart'])) {
	$_SESSION['payment_method']=$post['payment_method'];
	$upt_order_query = mysqli_query($db,"UPDATE `orders` SET `payment_method`='".$post['payment_method']."', paypal_address='".real_escape_string($post['paypal_address'])."', chk_name='".real_escape_string($post['chk_name'])."', chk_street_address='".real_escape_string($post['chk_street_address'])."', chk_street_address_2='".real_escape_string($post['chk_street_address_2'])."', chk_city='".real_escape_string($post['chk_city'])."', chk_state='".real_escape_string($post['chk_state'])."', chk_zip_code='".real_escape_string($post['chk_zip_code'])."', act_name='".real_escape_string($post['act_name'])."', act_number='".real_escape_string($post['act_number'])."', act_short_code='".real_escape_string($post['act_short_code'])."', zelle_address='".real_escape_string($post['zelle_address'])."', cashapp_address='".real_escape_string($post['cashapp_address'])."', venmo_address='".real_escape_string($post['venmo_address'])."', google_pay_address='".real_escape_string($post['google_pay_address'])."', other_name_of_method='".real_escape_string($post['other_name_of_method'])."', other_account_details='".real_escape_string($post['other_account_details'])."' WHERE order_id='".$order_id."'");
	foreach($post['qty'] as $key=>$qty_dt) {
		$req_quantity = 0;
		$req_quantity = $post['qty'][$key];
		if($req_quantity>0) {
			$item_query=mysqli_query($db,"SELECT * FROM order_items WHERE id='".$key."'");
			$item_data=mysqli_fetch_assoc($item_query);
			if($req_quantity>0 && $item_data['quantity']<$req_quantity) {
				$upt_quantity = ($req_quantity-$item_data['quantity']);
				$item_price = ($item_data['price']+($item_data['quantity_price'] * $upt_quantity));
				$upt_order_item_query=mysqli_query($db,"UPDATE `order_items` SET price='".$item_price."',quantity='".$req_quantity."' WHERE id='".$key."'");
			} elseif($req_quantity>0 && $item_data['quantity']>$req_quantity) {
				$upt_quantity = ($item_data['quantity']-$req_quantity);
				$item_price = ($item_data['price']-($item_data['quantity_price'] * $upt_quantity));
				$upt_order_item_query=mysqli_query($db,"UPDATE `order_items` SET price='".$item_price."',quantity='".$req_quantity."' WHERE id='".$key."'");
			}
		}
	}

	if($upt_order_query=='1') {
		//If already logged in with all fields filled then it will redirect to confirm order page, otherwise redirect to enterdetails page.
		if($post['form_submit_type']=="update_cart") {
			setRedirect(SITE_URL.'revieworder');
		} elseif($user_id>0 && $user_data['phone']!="" && $user_data['address']!="" && $user_data['status']=='1') {
			$msg = "Please confirm your sale";
			setRedirectWithMsg(SITE_URL.'revieworder?action=confirm',$msg,'success');
		} else {
			setRedirect(SITE_URL.'enterdetails');
		}
		exit();
	}
} else {
	$msg='Direct access denied';
	setRedirectWithMsg(SITE_URL,$msg,'danger');
	exit();
}  ?>
