<?php
require_once("../admin/_config/config.php");
require_once("../admin/include/functions.php");
require_once("common.php");

$initial_order_item_status_id = get_order_status_data('order_item_status','waiting-shipment')['data']['id'];

if(isset($post['missing_product'])) {

	$valid_csrf_token = verifyFormToken('missing_product_form');
	if($valid_csrf_token!='1') {
		writeHackLog('missing_product_form');
		$msg = "Invalid Token";
		setRedirectWithMsg($return_url,$msg,'warning');
		exit();
	}

	$name=real_escape_string($post['name']);
	$phone=preg_replace("/[^\d]/", "", real_escape_string($post['phone']));
	$email=real_escape_string($post['email']);
	$item_name=real_escape_string($post['item_name']);
	$subject='';
	$message=real_escape_string($post['message']);
	
	if($missing_product_form_captcha == '1') {
		$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$captcha_secret."&response=".$post['g-recaptcha-response']);
		$response = json_decode($response, true);
		if($response["success"] !== true) {
			$msg = "Invalid captcha";
			setRedirectWithMsg($return_url,$msg,'warning');
			exit();
		}
	}
	
	if($name && $phone && $email && $item_name) {
		$query=mysqli_query($db,"INSERT INTO contact(name, phone, email, item_name, subject, message, date, type) values('".$name."','".$phone."','".$email."','".$item_name."','".$subject."','".$message."','".date('Y-m-d H:i:s')."', 'quote')");
		$last_insert_id = mysqli_insert_id($db);
		if($query=="1") {
			$template_data = get_template_data('quote_request_form_alert');
			
			//Get admin user data
			$admin_user_data = get_admin_user_data();
			
			$patterns = array(
				'{$logo}',
				'{$admin_logo}',
				'{$admin_email}',
				'{$admin_username}',
				'{$admin_site_url}',
				'{$admin_panel_name}',
				'{$from_name}',
				'{$from_email}',
				'{$site_name}',
				'{$site_url}',
				'{$customer_fullname}',
				'{$customer_phone}',
				'{$customer_email}',
				'{$current_date_time}',
				'{$form_subject}',
				'{$form_message}',
				'{$item_name}');

			$replacements = array(
				$logo,
				$admin_logo,
				$admin_user_data['email'],
				$admin_user_data['username'],
				ADMIN_URL,
				$general_setting_data['admin_panel_name'],
				$general_setting_data['from_name'],
				$general_setting_data['from_email'],
				$general_setting_data['site_name'],
				SITE_URL,
				$post['name'],
				$phone,
				$post['email'],
				format_date(date('Y-m-d H:i')).' '.format_time(date('Y-m-d H:i')),
				$post['subject'],
				$post['message'],
				$post['item_name']);

			if(!empty($template_data)) {
				$email_subject = str_replace($patterns,$replacements,$template_data['subject']);
				$email_body_text = str_replace($patterns,$replacements,$template_data['content']);
				//send_email($admin_user_data['email'], $email_subject, $email_body_text, $post['name'], $post['email']);
				
				$reply_to_data = array();
				$reply_to_data['name'] = $post['name'];
				$reply_to_data['email'] = $post['email'];
				send_email($admin_user_data['email'], $email_subject, $email_body_text, FROM_NAME, FROM_EMAIL, array(), $reply_to_data);
			}

			$msg="Thank you for quote request. We'll contact you shortly.";
			setRedirectWithMsg($return_url,$msg,'success');
		} else {
			$msg='Sorry! something wrong updation failed.';
			setRedirectWithMsg($return_url,$msg,'danger');
		}
	} else {
		$msg='please fill in all required fields.';
		setRedirectWithMsg($return_url,$msg,'warning');
	}
	exit();
} elseif(isset($post['sell_this_device'])) {

	$valid_csrf_token = verifyFormToken('model_details');
	if($valid_csrf_token!='1') {
		writeHackLog('model_details');
		$msg = "Invalid Token";
		setRedirectWithMsg($return_url,$msg,'warning');
		exit();
	}

	$post = $_POST;
	$edit_item_id = $post['edit_item_id'];
	$quantity = $post['quantity'];
	$req_model_id = $post['req_model_id'];

	//echo '<pre>';
	//print_r($post);
	//exit;

	//Fetching data from model
	require_once('../models/model.php');

	$model_data = get_single_model_data($req_model_id);
	$category_data = get_category_data($model_data['cat_id']);
	
	$items_array = array();
	
	if($post['network']) {
		$radio_items_array = array();
		$radio_items_array[] = array('opt_id'=>'','opt_name'=>$post['network']);
		$items_array['network'] = array('fld_name'=>str_replace("_"," ",$category_data['network_title']),'opt_data'=>$radio_items_array);
	}
	if($post['connectivity']) {
		$radio_items_array = array();
		$radio_items_array[] = array('opt_id'=>'','opt_name'=>$post['connectivity']);
		$items_array['connectivity'] = array('fld_name'=>str_replace("_"," ",$category_data['connectivity_title']),'opt_data'=>$radio_items_array);
	}
	if($post['case_size']) {
		$radio_items_array = array();
		$radio_items_array[] = array('opt_id'=>'','opt_name'=>$post['case_size']);
		$items_array['case_size'] = array('fld_name'=>str_replace("_"," ",$category_data['case_size_title']),'opt_data'=>$radio_items_array);
	}
	if($post['model']) {
		$radio_items_array = array();
		$radio_items_array[] = array('opt_id'=>'','opt_name'=>$post['model']);
		$items_array['model'] = array('fld_name'=>str_replace("_"," ",$category_data['model_title']),'opt_data'=>$radio_items_array);
	}
	if($post['processor']) {
		$radio_items_array = array();
		$radio_items_array[] = array('opt_id'=>'','opt_name'=>$post['processor']);
		$items_array['processor'] = array('fld_name'=>str_replace("_"," ",$category_data['processor_title']),'opt_data'=>$radio_items_array);
	}
	if($post['ram']) {
		$radio_items_array = array();
		$radio_items_array[] = array('opt_id'=>'','opt_name'=>$post['ram']);
		$items_array['ram'] = array('fld_name'=>str_replace("_"," ",$category_data['ram_title']),'opt_data'=>$radio_items_array);
	}
	if($post['storage']) {
		$radio_items_array = array();
		$radio_items_array[] = array('opt_id'=>'','opt_name'=>$post['storage']);
		$items_array['storage'] = array('fld_name'=>str_replace("_"," ",$category_data['storage_title']),'opt_data'=>$radio_items_array);
	}
	if($post['graphics_card']) {
		$radio_items_array = array();
		$radio_items_array[] = array('opt_id'=>'','opt_name'=>$post['graphics_card']);
		$items_array['graphics_card'] = array('fld_name'=>str_replace("_"," ",$category_data['graphics_card_title']),'opt_data'=>$radio_items_array);
	}
	if($post['condition']) {
		$radio_items_array = array();
		$radio_items_array[] = array('opt_id'=>'','opt_name'=>$post['condition']);
		$items_array['condition'] = array('fld_name'=>str_replace("_"," ",$category_data['condition_title']),'opt_data'=>$radio_items_array);
	}
	
	if(!empty($post['band_included'])) {
		$radio_items_array = array();
		foreach($post['band_included'] as $acc_k=>$acc_v) {
			$exp_acc_v = explode(":",$acc_v);
			$radio_items_array[] = array('opt_id'=>$exp_acc_v[1],'opt_name'=>$exp_acc_v[0]);
		}
		$items_array['band_included'] = array('fld_name'=>str_replace("_"," ",$category_data['band_included_title']),'opt_data'=>$radio_items_array);
	}
	
	if(!empty($post['accessories'])) {
		$radio_items_array = array();
		foreach($post['accessories'] as $acc_k=>$acc_v) {
			$exp_acc_v = explode(":",$acc_v);
			$radio_items_array[] = array('opt_id'=>$exp_acc_v[1],'opt_name'=>$exp_acc_v[0]);
		}
		$items_array['accessories'] = array('fld_name'=>str_replace("_"," ",$category_data['accessories_title']),'opt_data'=>$radio_items_array);
	}
	
	$order_items = json_encode($items_array);

	if($quantity>0) {
		$_SESSION['payment_method'] = $post['payment_method'];

		$order_id = $_SESSION['order_id'];
		if($order_id=="") {
			//$_SESSION['order_id'] = $order_prefix.date('s').rand(100000,999999);

			$f_order_prefix = ($order_prefix>0?$order_prefix:0);

			$last_o_query = mysqli_query($db,"SELECT * FROM orders ORDER BY id DESC");
			$last_order_data = mysqli_fetch_assoc($last_o_query);
			
			$current_datetime_with_timezone = timeZoneConvert(date('Y-m-d H:i:s'), 'UTC', TIMEZONE,'Y-m-d H:i:s');
			$order_number_datetime_format =  date($order_number_datetime_format,strtotime($current_datetime_with_timezone));
			
			$exp_order_id = explode("-",$last_order_data['order_id']);
			$order_id_last_digits = $exp_order_id[3];
			if($last_order_data['order_id']!="" && $order_id_last_digits>=$f_order_prefix) {
				$_SESSION['order_id'] = date('y-m-d-',strtotime($order_number_datetime_format)).($order_id_last_digits+1);
			} elseif($last_order_data['order_id']=="" || $order_id_last_digits<$f_order_prefix) {
				$_SESSION['order_id'] = date('y-m-d-',strtotime($order_number_datetime_format)).$f_order_prefix;
			} else {
				$_SESSION['order_id'] = date('y-m-d-',strtotime($order_number_datetime_format)).rand(100000,999999);
			}

			$order_id = $_SESSION['order_id'];
			mysqli_query($db,"INSERT INTO `orders`(`order_id`, `payment_method`, `date`, `status`, order_type) VALUES('".$order_id."','".$post['payment_method']."','".date('Y-m-d H:i:s')."','partial','website')");
		}

		$img_item_query = mysqli_query($db,"SELECT oi.* FROM order_items AS oi WHERE oi.id='".$edit_item_id."'");
		$img_item_data = mysqli_fetch_assoc($img_item_query);
		$svd_files_array = json_decode($img_item_data['images'],true);

		/*//START upload images
		$files_data = $_FILES;
		$json_files = "";
		$files_array = array();
		if(isset($files_data) && count($files_data)>0) {
			if(!file_exists('../images/order/'))
				mkdir('../images/order/',0777);

			foreach($_FILES as $key=>$val){
				$target_dir = "../images/order/";
				$filename = basename($files_data[$key]["name"]);
				$imageFileType = strtolower(pathinfo($filename,PATHINFO_EXTENSION));
				
				$exp_key = explode(":",$key);
				$exp_val = explode(":",$val);
		
				if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
					
				}

				$filename = date("YmdHis").rand(1111,9999).".".$imageFileType;
				$target_file = $target_dir.$filename;
	
				if(move_uploaded_file($files_data[$key]["tmp_name"], $target_file)) {
					$files_array[$exp_key[1]] = array('fld_name'=>str_replace("_"," ",$exp_key[0]),'img_name'=>$filename);
				}
			}
			if(count($files_array)>0) {
				if(!empty($svd_files_array)) {
					$f_files_array = array_replace($svd_files_array,$files_array);
				} else {
					$f_files_array = $files_array;
				}
				$json_files = json_encode($f_files_array);
				$upd_json_files = ", `images`='".$json_files."'";
			}
		} //END upload images*/

		$quantity_price = $post['payment_amt'];
		//echo $item_price = ($quantity_price * $quantity);
		$item_price = $quantity_price;
		$quantity_price = ($quantity_price / $quantity);

		$order_item_ids = $_SESSION['order_item_ids'];
		if(empty($order_item_ids))
			$order_item_ids = array();

		if($edit_item_id>0) {
			$query=mysqli_query($db,"UPDATE `order_items` SET `device_id`='".$post['device_id']."', `model_id`='".$req_model_id."', `order_id`='".$order_id."', `item_name`='".real_escape_string($order_items)."', `price`='".$item_price."', `quantity`='".$quantity."', `quantity_price`='".$quantity_price."'".$upd_json_files." WHERE id='".$edit_item_id."'");
			mysqli_query($db,"INSERT INTO `order_items_price`(`price`, `item_id`, `date`) VALUES('".$item_price."','".$edit_item_id."','".date('Y-m-d H:i:s')."')");
		} else {
			$is_updated_in_existing_item = false;
			/*if(!empty($order_item_ids)) {
				$req_item_nm_array = $order_items;
				$order_item_query=mysqli_query($db,"SELECT oi.* FROM order_items AS oi WHERE oi.id IN('".implode("','",$order_item_ids)."')");
				$order_item_num_of_rows = mysqli_num_rows($order_item_query);
				if($order_item_num_of_rows>0) {
					while($order_item_data=mysqli_fetch_assoc($order_item_query)) {
						$saved_item_nm_array = $order_item_data['item_name'];
						if($req_item_nm_array == $saved_item_nm_array && $req_model_id == $order_item_data['model_id']) {
							$is_updated_in_existing_item = true;
							$upt_svd_item_price = ($item_price+$order_item_data['price']);
							$upt_svd_item_qty = ($quantity+$order_item_data['quantity']);
							mysqli_query($db,"UPDATE `order_items` SET price='".$upt_svd_item_price."', quantity='".$upt_svd_item_qty."', quantity_price='".$quantity_price."' WHERE id='".$order_item_data['id']."'");
						}
					}
				}
			}*/

			if(!$is_updated_in_existing_item) {
				$query=mysqli_query($db,"INSERT INTO `order_items`(`device_id`, `model_id`, `order_id`, `item_name`, `images`, `price`, `quantity`, `quantity_price`, status) VALUES('".$post['device_id']."','".$req_model_id."','".$order_id."','".real_escape_string($order_items)."','".$json_files."','".$item_price."','".$quantity."','".$quantity_price."','".$initial_order_item_status_id."')");
				$last_insert_id = mysqli_insert_id($db);
				if($query=="1") {
					mysqli_query($db,"INSERT INTO `order_items_price`(`price`, `item_id`, `date`) VALUES('".$item_price."','".$last_insert_id."','".date('Y-m-d H:i:s')."')");
					
					array_push($order_item_ids,$last_insert_id);
					$_SESSION['order_item_ids']=$order_item_ids;
				}
			}
		}

		//START logic for promocode
		$date = date('Y-m-d');
		$sum_of_orders = get_order_price($order_id);
		$order_data = get_order_data($order_id);
		$promocode_id = $order_data['promocode_id'];
		$promo_code = $order_data['promocode'];
		if($promocode_id!='' && $promo_code!="" && $sum_of_orders>0) {
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
					$total = ($sum_of_orders+$discount);
					$discount_amt_with_format = amount_fomat($discount_of_amt);
				} elseif($promo_code_data['discount_type']=="percentage") {
					$discount_of_amt = (($sum_of_orders*$discount) / 100);
					$total = ($sum_of_orders+$discount_of_amt);
					$discount_amt_with_format = amount_fomat($discount_of_amt);
				}
				$is_promocode_exist = true;
			}
		}

		mysqli_query($db,"UPDATE `orders` SET promocode_id='".$promocode_id."', promocode='".$promo_code."', promocode_amt='".$discount_of_amt."', discount_type='".$promo_code_data['discount_type']."', discount='".$discount."' WHERE order_id='".$order_id."'");
	    //END logic for promocode
	}

	setRedirect(SITE_URL.'cart');
	exit();
}
elseif(isset($_POST['sell_my_device_new'])){
	
	/*$valid_csrf_token = verifyFormToken('model_details');
	if($valid_csrf_token!='1') {
		writeHackLog('model_details');
		$msg = "Invalid Token";
		setRedirectWithMsg($return_url,$msg,'warning');
		exit();
	}*/

	$post = $_POST;
	$edit_item_id = $post['edit_item_id'];
	$quantity = $post['quantity'];
	$req_model_id = $post['model_id'];

	//echo '<pre>';
	//print_r($post);
	//exit;

	//Fetching data from model
	require_once('../models/model.php');

	$model_data = get_single_model_data($req_model_id);
	$category_data = get_category_data($model_data['cat_id']);
	
	$items_array = array();
	
	if($post['network']) {
		$radio_items_array = array();
		$radio_items_array[] = array('opt_id'=>'','opt_name'=>$post['network']);
		$items_array['network'] = array('fld_name'=>str_replace("_"," ",$category_data['network_title']),'opt_data'=>$radio_items_array);
	}
	if($post['connectivity']) {
		$radio_items_array = array();
		$radio_items_array[] = array('opt_id'=>'','opt_name'=>$post['connectivity']);
		$items_array['connectivity'] = array('fld_name'=>str_replace("_"," ",$category_data['connectivity_title']),'opt_data'=>$radio_items_array);
	}
	if($post['case_size']) {
		$radio_items_array = array();
		$radio_items_array[] = array('opt_id'=>'','opt_name'=>$post['case_size']);
		$items_array['case_size'] = array('fld_name'=>str_replace("_"," ",$category_data['case_size_title']),'opt_data'=>$radio_items_array);
	}
	if($post['model']) {
		$radio_items_array = array();
		$radio_items_array[] = array('opt_id'=>'','opt_name'=>$post['model']);
		$items_array['model'] = array('fld_name'=>str_replace("_"," ",$category_data['model_title']),'opt_data'=>$radio_items_array);
	}
	if($post['processor']) {
		$radio_items_array = array();
		$radio_items_array[] = array('opt_id'=>'','opt_name'=>$post['processor']);
		$items_array['processor'] = array('fld_name'=>str_replace("_"," ",$category_data['processor_title']),'opt_data'=>$radio_items_array);
	}
	if($post['ram']) {
		$radio_items_array = array();
		$radio_items_array[] = array('opt_id'=>'','opt_name'=>$post['ram']);
		$items_array['ram'] = array('fld_name'=>str_replace("_"," ",$category_data['ram_title']),'opt_data'=>$radio_items_array);
	}
	if($post['storage']) {
		$radio_items_array = array();
		$radio_items_array[] = array('opt_id'=>'','opt_name'=>$post['storage']);
		$items_array['storage'] = array('fld_name'=>str_replace("_"," ",$category_data['storage_title']),'opt_data'=>$radio_items_array);
	}
	if($post['graphics_card']) {
		$radio_items_array = array();
		$radio_items_array[] = array('opt_id'=>'','opt_name'=>$post['graphics_card']);
		$items_array['graphics_card'] = array('fld_name'=>str_replace("_"," ",$category_data['graphics_card_title']),'opt_data'=>$radio_items_array);
	}
	if($post['condition']) {
		$radio_items_array = array();
		$radio_items_array[] = array('opt_id'=>'','opt_name'=>$post['condition']);
		$items_array['condition'] = array('fld_name'=>str_replace("_"," ",$category_data['condition_title']),'opt_data'=>$radio_items_array);
	}
	
	if(!empty($post['band_included'])) {
		$radio_items_array = array();
		foreach($post['band_included'] as $acc_k=>$acc_v) {
			$exp_acc_v = explode(":",$acc_v);
			$radio_items_array[] = array('opt_id'=>$exp_acc_v[1],'opt_name'=>$exp_acc_v[0]);
		}
		$items_array['band_included'] = array('fld_name'=>str_replace("_"," ",$category_data['band_included_title']),'opt_data'=>$radio_items_array);
	}
	
	if(!empty($post['accessories'])) {
		$radio_items_array = array();
		foreach($post['accessories'] as $acc_k=>$acc_v) {
			$exp_acc_v = explode(":",$acc_v);
			$radio_items_array[] = array('opt_id'=>$exp_acc_v[1],'opt_name'=>$exp_acc_v[0]);
		}
		$items_array['accessories'] = array('fld_name'=>str_replace("_"," ",$category_data['accessories_title']),'opt_data'=>$radio_items_array);
	}
	$order_items = json_encode($items_array);
	//print_r($items_array);
	//exit;
	
	if($quantity>0) {
		$order_id = $_SESSION['order_id'];
		if($order_id=="") {
			//$_SESSION['order_id'] = $order_prefix.date('s').rand(100000,999999);

			$f_order_prefix = ($order_prefix>0?$order_prefix:0);

			$last_o_query = mysqli_query($db,"SELECT * FROM orders ORDER BY id DESC");
			$last_order_data = mysqli_fetch_assoc($last_o_query);
			
			$current_datetime_with_timezone = timeZoneConvert(date('Y-m-d H:i:s'), 'UTC', TIMEZONE,'Y-m-d H:i:s');
			$order_number_datetime_format =  date($order_number_datetime_format,strtotime($current_datetime_with_timezone));
			
			$exp_order_id = explode("-",$last_order_data['order_id']);
			$order_id_last_digits = $exp_order_id[3];
			if($last_order_data['order_id']!="" && $order_id_last_digits>=$f_order_prefix) {
				$_SESSION['order_id'] = date('y-m-d-',strtotime($order_number_datetime_format)).($order_id_last_digits+1);
			} elseif($last_order_data['order_id']=="" || $order_id_last_digits<$f_order_prefix) {
				$_SESSION['order_id'] = date('y-m-d-',strtotime($order_number_datetime_format)).$f_order_prefix;
			} else {
				$_SESSION['order_id'] = date('y-m-d-',strtotime($order_number_datetime_format)).rand(100000,999999);
			}

			$order_id = $_SESSION['order_id'];
			mysqli_query($db,"INSERT INTO `orders`(`order_id`,`date`, `status`, order_type) VALUES('".$order_id."','".date('Y-m-d H:i:s')."','partial','website_sell_instant')");
		}

		/*$order_id = $_SESSION['order_id'];
		if($order_id=="") {
			$_SESSION['order_id'] = $order_prefix.date('s').rand(100000,999999);
			$order_id = $_SESSION['order_id'];
			mysqli_query($db,"INSERT INTO `orders`(`order_id`,`date`, `status`) VALUES('".$order_id."','".date('Y-m-d H:i:s')."','partial')");
		}*/

		//START upload images
		$files_data = $_FILES;
		$json_files = "";
		$files_array = array();
		if(isset($files_data) && count($files_data)>0) {
			if(!file_exists('../images/order/'))
				mkdir('../images/order/',0777);

			foreach($_FILES as $key=>$val){
				$target_dir = "../images/order/";
				$filename = basename($files_data[$key]["name"]);
				$imageFileType = strtolower(pathinfo($filename,PATHINFO_EXTENSION));
				
				$exp_key = explode(":",$key);
				$exp_val = explode(":",$val);
		
				if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
					
				}

				$filename = date("YmdHis").rand(1111,9999).".".$imageFileType;
				$target_file = $target_dir.$filename;
	
				if(move_uploaded_file($files_data[$key]["tmp_name"], $target_file)) {
					$files_array[$exp_key[1]] = array('fld_name'=>str_replace("_"," ",$exp_key[0]),'img_name'=>$filename);
				}
			}
			if(count($files_array)>0) {
				if(!empty($svd_files_array)) {
					$f_files_array = array_replace($svd_files_array,$files_array);
				} else {
					$f_files_array = $files_array;
				}
				$json_files = json_encode($f_files_array);
				$upd_json_files = ", `images`='".$json_files."'";
			}
		} //END upload images

		$quantity_price = $post['payment_amt'];
		$item_price = ($quantity_price * $quantity);
		
		$order_item_ids = $_SESSION['order_item_ids'];
		if(empty($order_item_ids))
			$order_item_ids = array();
			
		$is_updated_in_existing_item = false;
		if(!empty($order_item_ids)) {
			$req_item_nm_array = $order_items;
			$order_item_query=mysqli_query($db,"SELECT oi.* FROM order_items AS oi WHERE oi.id IN('".implode("','",$order_item_ids)."')");
			$order_item_num_of_rows = mysqli_num_rows($order_item_query);
			if($order_item_num_of_rows>0) {
				while($order_item_data=mysqli_fetch_assoc($order_item_query)) {
					$saved_item_nm_array = $order_item_data['item_name'];
					if($req_item_nm_array == $saved_item_nm_array && $req_model_id == $order_item_data['model_id']) {
						$is_updated_in_existing_item = true;
						$upt_svd_item_price = ($item_price+$order_item_data['price']);
						$upt_svd_item_qty = ($quantity+$order_item_data['quantity']);
						mysqli_query($db,"UPDATE `order_items` SET price='".$upt_svd_item_price."', quantity='".$upt_svd_item_qty."', quantity_price='".$quantity_price."' WHERE id='".$order_item_data['id']."'");
					}
				}
			}
		}

		if(!$is_updated_in_existing_item) {
			$query=mysqli_query($db,"INSERT INTO `order_items`(`device_id`, `model_id`, `order_id`, `item_name`, `images`, `price`, `quantity`, `quantity_price`, status) VALUES('".$post['device_id']."','".$req_model_id."','".$order_id."','".real_escape_string($order_items)."','".$json_files."','".$item_price."','".$quantity."','".$quantity_price."','".$initial_order_item_status_id."')");
			$last_insert_id = mysqli_insert_id($db);
			if($query=="1") {
				mysqli_query($db,"INSERT INTO `order_items_price`(`price`, `item_id`, `date`) VALUES('".$item_price."','".$last_insert_id."','".date('Y-m-d H:i:s')."')");

				array_push($order_item_ids,$last_insert_id);
				$_SESSION['order_item_ids']=$order_item_ids;
			}
		}
		
	}

	setRedirect(SITE_URL.'cart');
	exit();
} elseif(isset($_GET['external_fb_chatbot_sell_device'])) {
	/*if($_SERVER['HTTP_SEC_FETCH_SITE']!='cross-site') {
		$msg='Direct access denied';
		setRedirectWithMsg(SITE_URL,$msg,'danger');
		exit();
	}*/

	$post = $_GET;
	$edit_item_id = $post['edit_item_id'];
	$quantity = 1;//$post['quantity'];
	$model_id = $post['model_id'];
	$fields_id = $post['fields_id'];

	//echo '<pre>';
	//print_r($post);
	//exit;

	$field_name_arr = array();
	$field_id_arr = array();
	$fields_id_arr = explode('-',$fields_id);
	if(!empty($fields_id_arr) && trim($fields_id)) {
		foreach($fields_id_arr as $fields_id_dt) {
			$fields_id_sub_arr = explode(':',$fields_id_dt);
			if(!empty($fields_id_sub_arr[0]) && !empty($fields_id_sub_arr[1])) {
				//$field_name_arr[] = $fields_id_sub_arr[0];
				$field_id_arr[$fields_id_sub_arr[0]] = $fields_id_sub_arr[1];
			}
		}
	}

	$model_fields_dt = array();
	$condition_id = $field_id_arr['condition'];
	$network_id = $field_id_arr['network'];
	$storage_id = $field_id_arr['storage'];
	$connectivity_id = $field_id_arr['connectivity'];
	$model_fld_id = $field_id_arr['model'];
	$processor_id = $field_id_arr['processor'];
	$case_size_id = $field_id_arr['case_size'];
	$ram_id = $field_id_arr['ram'];
	$graphics_card_id = $field_id_arr['graphics_card'];
	$band_included_id = $field_id_arr['band_included'];
	$accessories_id = $field_id_arr['accessories'];

	$n_q = mysqli_query($db,"SELECT * FROM models_networks WHERE model_id='".$model_id."' AND id='".$network_id."'");
	$models_networks_data = mysqli_fetch_assoc($n_q);
	$model_fields_dt['network'] = $models_networks_data['network_name'];
	
	$s_q = mysqli_query($db,"SELECT * FROM models_storage WHERE model_id='".$model_id."' AND id='".$storage_id."'");
	$models_storage_data = mysqli_fetch_assoc($s_q);
	$model_fields_dt['storage'] = $models_storage_data['storage_size'].$models_storage_data['storage_size_postfix'];
	
	$c_q = mysqli_query($db,"SELECT * FROM models_connectivity WHERE model_id='".$model_id."' AND id='".$connectivity_id."'");
	$models_storage_data = mysqli_fetch_assoc($c_q);
	$model_fields_dt['connectivity'] = $models_storage_data['connectivity_name'];
	
	$cnd_q = mysqli_query($db,"SELECT * FROM models_condition WHERE model_id='".$model_id."' AND id='".$condition_id."'");
	$models_condition_data = mysqli_fetch_assoc($cnd_q);
	$model_fields_dt['condition'] = $models_condition_data['condition_name'];
	
	$mdl_q = mysqli_query($db,"SELECT * FROM models_model WHERE model_id='".$model_id."' AND id='".$model_fld_id."'");
	$models_model_data = mysqli_fetch_assoc($mdl_q);
	$model_fields_dt['model'] = $models_model_data['model_name'];
	
	$cs_q = mysqli_query($db,"SELECT * FROM models_case_size WHERE model_id='".$model_id."' AND id='".$case_size_id."'");
	$models_case_size_data = mysqli_fetch_assoc($cs_q);
	$model_fields_dt['case_size'] = $models_case_size_data['case_size'];
	
	$rm_q = mysqli_query($db,"SELECT * FROM models_ram WHERE model_id='".$model_id."' AND id='".$ram_id."'");
	$models_ram_data = mysqli_fetch_assoc($rm_q);
	$model_fields_dt['ram'] = $models_ram_data['ram_size'].$models_ram_data['ram_size_postfix'];
	
	$gc_q = mysqli_query($db,"SELECT * FROM models_graphics_card WHERE model_id='".$model_id."' AND id='".$graphics_card_id."'");
	$models_graphics_card_data = mysqli_fetch_assoc($gc_q);
	$model_fields_dt['graphics_card'] = $models_graphics_card_data['graphics_card_name'];
	
	$prc_q = mysqli_query($db,"SELECT * FROM models_processor WHERE model_id='".$model_id."' AND id='".$processor_id."'");
	$models_processor_data = mysqli_fetch_assoc($prc_q);
	$model_fields_dt['processor'] = $models_processor_data['processor_name'];
	
	$bi_q = mysqli_query($db,"SELECT * FROM models_band_included WHERE model_id='".$model_id."' AND id='".$band_included_id."'");
	$models_band_included_data = mysqli_fetch_assoc($bi_q);
	$model_fields_dt['band_included'] = $models_band_included_data['band_included_name'];
	
	$acce_q = mysqli_query($db,"SELECT * FROM models_accessories WHERE model_id='".$model_id."' AND id='".$accessories_id."'");
	$models_accessories_data = mysqli_fetch_assoc($acce_q);
	$model_fields_dt['accessories'] = $models_accessories_data['accessories_name'];

	//print_r($model_fields_dt);
	//exit;

	//Fetching data from model
	require_once('../models/model.php');

	$model_data = get_single_model_data($model_id);
	$device_id = $model_data['device_id'];
	$category_data = get_category_data($model_data['cat_id']);
	
	$items_array = array();

	if($model_fields_dt['network']) {
		$radio_items_array = array();
		$radio_items_array[] = array('opt_id'=>'','opt_name'=>$model_fields_dt['network']);
		$items_array['network'] = array('fld_name'=>str_replace("_"," ",$category_data['network_title']),'opt_data'=>$radio_items_array);
	}
	if($model_fields_dt['connectivity']) {
		$radio_items_array = array();
		$radio_items_array[] = array('opt_id'=>'','opt_name'=>$model_fields_dt['connectivity']);
		$items_array['connectivity'] = array('fld_name'=>str_replace("_"," ",$category_data['connectivity_title']),'opt_data'=>$radio_items_array);
	}
	if($model_fields_dt['case_size']) {
		$radio_items_array = array();
		$radio_items_array[] = array('opt_id'=>'','opt_name'=>$model_fields_dt['case_size']);
		$items_array['case_size'] = array('fld_name'=>str_replace("_"," ",$category_data['case_size_title']),'opt_data'=>$radio_items_array);
	}
	if($model_fields_dt['model']) {
		$radio_items_array = array();
		$radio_items_array[] = array('opt_id'=>'','opt_name'=>$model_fields_dt['model']);
		$items_array['model'] = array('fld_name'=>str_replace("_"," ",$category_data['model_title']),'opt_data'=>$radio_items_array);
	}
	if($model_fields_dt['processor']) {
		$radio_items_array = array();
		$radio_items_array[] = array('opt_id'=>'','opt_name'=>$model_fields_dt['processor']);
		$items_array['processor'] = array('fld_name'=>str_replace("_"," ",$category_data['processor_title']),'opt_data'=>$radio_items_array);
	}
	if($model_fields_dt['ram']) {
		$radio_items_array = array();
		$radio_items_array[] = array('opt_id'=>'','opt_name'=>$model_fields_dt['ram']);
		$items_array['ram'] = array('fld_name'=>str_replace("_"," ",$category_data['ram_title']),'opt_data'=>$radio_items_array);
	}
	if($model_fields_dt['storage']) {
		$radio_items_array = array();
		$radio_items_array[] = array('opt_id'=>'','opt_name'=>$model_fields_dt['storage']);
		$items_array['storage'] = array('fld_name'=>str_replace("_"," ",$category_data['storage_title']),'opt_data'=>$radio_items_array);
	}
	if($model_fields_dt['graphics_card']) {
		$radio_items_array = array();
		$radio_items_array[] = array('opt_id'=>'','opt_name'=>$model_fields_dt['graphics_card']);
		$items_array['graphics_card'] = array('fld_name'=>str_replace("_"," ",$category_data['graphics_card_title']),'opt_data'=>$radio_items_array);
	}
	if($model_fields_dt['condition']) {
		$radio_items_array = array();
		$radio_items_array[] = array('opt_id'=>'','opt_name'=>$model_fields_dt['condition']);
		$items_array['condition'] = array('fld_name'=>str_replace("_"," ",$category_data['condition_title']),'opt_data'=>$radio_items_array);
	}
	if(!empty($model_fields_dt['band_included'])) {
		$radio_items_array = array();
		$radio_items_array[] = array('opt_id'=>$band_included_id,'opt_name'=>$model_fields_dt['band_included']);
		$items_array['band_included'] = array('fld_name'=>str_replace("_"," ",$category_data['band_included_title']),'opt_data'=>$radio_items_array);
	}
	if(!empty($model_fields_dt['accessories'])) {
		$radio_items_array = array();
		$radio_items_array[] = array('opt_id'=>$accessories_id,'opt_name'=>$model_fields_dt['accessories']);
		$items_array['accessories'] = array('fld_name'=>str_replace("_"," ",$category_data['accessories_title']),'opt_data'=>$radio_items_array);
	}

	$order_items = json_encode($items_array);

	if($quantity>0) {
		$order_id = $_SESSION['order_id'];
		if($order_id=="") {
			$f_order_prefix = ($order_prefix>0?$order_prefix:0);

			$last_o_query = mysqli_query($db,"SELECT * FROM orders ORDER BY id DESC");
			$last_order_data = mysqli_fetch_assoc($last_o_query);
			
			$current_datetime_with_timezone = timeZoneConvert(date('Y-m-d H:i:s'), 'UTC', TIMEZONE,'Y-m-d H:i:s');
			$order_number_datetime_format =  date($order_number_datetime_format,strtotime($current_datetime_with_timezone));
			
			$exp_order_id = explode("-",$last_order_data['order_id']);
			$order_id_last_digits = $exp_order_id[3];
			if($last_order_data['order_id']!="" && $order_id_last_digits>=$f_order_prefix) {
				$_SESSION['order_id'] = date('y-m-d-',strtotime($order_number_datetime_format)).($order_id_last_digits+1);
			} elseif($last_order_data['order_id']=="" || $order_id_last_digits<$f_order_prefix) {
				$_SESSION['order_id'] = date('y-m-d-',strtotime($order_number_datetime_format)).$f_order_prefix;
			} else {
				$_SESSION['order_id'] = date('y-m-d-',strtotime($order_number_datetime_format)).rand(100000,999999);
			}

			$order_id = $_SESSION['order_id'];
			mysqli_query($db,"INSERT INTO `orders`(`order_id`, `payment_method`, `date`, `status`, order_type) VALUES('".$order_id."','".$post['payment_method']."','".date('Y-m-d H:i:s')."','partial','website')");
		}

		$img_item_query = mysqli_query($db,"SELECT oi.* FROM order_items AS oi WHERE oi.id='".$edit_item_id."'");
		$img_item_data = mysqli_fetch_assoc($img_item_query);
		$svd_files_array = json_decode($img_item_data['images'],true);

		$quantity_price = $post['price'];
		$item_price = $quantity_price;
		$quantity_price = ($quantity_price / $quantity);

		$order_item_ids = $_SESSION['order_item_ids'];
		if(empty($order_item_ids))
			$order_item_ids = array();

		if($edit_item_id>0) {
			$query=mysqli_query($db,"UPDATE `order_items` SET `device_id`='".$device_id."', `model_id`='".$model_id."', `order_id`='".$order_id."', `item_name`='".real_escape_string($order_items)."', `price`='".$item_price."', `quantity`='".$quantity."', `quantity_price`='".$quantity_price."'".$upd_json_files." WHERE id='".$edit_item_id."'");
			mysqli_query($db,"INSERT INTO `order_items_price`(`price`, `item_id`, `date`) VALUES('".$item_price."','".$edit_item_id."','".date('Y-m-d H:i:s')."')");
		} else {
			$is_updated_in_existing_item = false;
			/*if(!empty($order_item_ids)) {
				$req_item_nm_array = $order_items;
				$order_item_query=mysqli_query($db,"SELECT oi.* FROM order_items AS oi WHERE oi.id IN('".implode("','",$order_item_ids)."')");
				$order_item_num_of_rows = mysqli_num_rows($order_item_query);
				if($order_item_num_of_rows>0) {
					while($order_item_data=mysqli_fetch_assoc($order_item_query)) {
						$saved_item_nm_array = $order_item_data['item_name'];
						if($req_item_nm_array == $saved_item_nm_array && $model_id == $order_item_data['model_id']) {
							$is_updated_in_existing_item = true;
							$upt_svd_item_price = ($item_price+$order_item_data['price']);
							$upt_svd_item_qty = ($quantity+$order_item_data['quantity']);
							mysqli_query($db,"UPDATE `order_items` SET price='".$upt_svd_item_price."', quantity='".$upt_svd_item_qty."', quantity_price='".$quantity_price."' WHERE id='".$order_item_data['id']."'");
						}
					}
				}
			}*/

			if(!$is_updated_in_existing_item) {
				$query=mysqli_query($db,"INSERT INTO `order_items`(`device_id`, `model_id`, `order_id`, `item_name`, `images`, `price`, `quantity`, `quantity_price`, status) VALUES('".$device_id."','".$model_id."','".$order_id."','".real_escape_string($order_items)."','".$json_files."','".$item_price."','".$quantity."','".$quantity_price."','".$initial_order_item_status_id."')");
				$last_insert_id = mysqli_insert_id($db);
				if($query=="1") {
					mysqli_query($db,"INSERT INTO `order_items_price`(`price`, `item_id`, `date`) VALUES('".$item_price."','".$last_insert_id."','".date('Y-m-d H:i:s')."')");
					
					array_push($order_item_ids,$last_insert_id);
					$_SESSION['order_item_ids']=$order_item_ids;
				}
			}
		}

		//START logic for promocode
		$date = date('Y-m-d');
		$sum_of_orders = get_order_price($order_id);
		$order_data = get_order_data($order_id);
		$promocode_id = $order_data['promocode_id'];
		$promo_code = $order_data['promocode'];
		if($promocode_id!='' && $promo_code!="" && $sum_of_orders>0) {
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
					$total = ($sum_of_orders+$discount);
					$discount_amt_with_format = amount_fomat($discount_of_amt);
				} elseif($promo_code_data['discount_type']=="percentage") {
					$discount_of_amt = (($sum_of_orders*$discount) / 100);
					$total = ($sum_of_orders+$discount_of_amt);
					$discount_amt_with_format = amount_fomat($discount_of_amt);
				}
				$is_promocode_exist = true;
			}
		}

		mysqli_query($db,"UPDATE `orders` SET promocode_id='".$promocode_id."', promocode='".$promo_code."', promocode_amt='".$discount_of_amt."', discount_type='".$promo_code_data['discount_type']."', discount='".$discount."' WHERE order_id='".$order_id."'");
	    //END logic for promocode
	}

	setRedirect(SITE_URL.'cart');
	exit();
} else {
	$msg='Direct access denied';
	setRedirectWithMsg(SITE_URL,$msg,'danger');
	exit();
} ?>