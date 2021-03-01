<?php
require_once("../admin/_config/config.php");
require_once("../admin/include/functions.php");
require_once("common.php");

$initial_order_status_dt = get_order_status_data('order_status','waiting-shipment')['data'];
$initial_order_status_id = $initial_order_status_dt['id'];
$initial_order_status_name = $initial_order_status_dt['id'];

$initial_order_item_status_id = get_order_status_data('order_item_status','waiting-shipment')['data']['id'];

$affiliate_url = SITE_URL.get_inbuild_page_url('affiliates');

if(isset($post['sell_this_device'])) {
	$post = $_POST;
	//echo '<pre>';
	//print_r($post);
	//exit;

	$valid_csrf_token = verifyFormToken('affiliate_shop');
	if($valid_csrf_token!='1') {
		writeHackLog('affiliate_shop');
		$msg = "Invalid Token";
		setRedirectWithMsg($return_url,$msg,'warning');
		exit();
	}

	$device_id = $post['device_id'];
	$quantity = $post['quantity'];
	$req_model_id = $post['model_id'];

	$first_name = $post['first_name'];
	$last_name = $post['last_name'];
	$phone = preg_replace("/[^\d]/", "", $post['phone']);
	$phone_c_code = $post['phone_c_code'];
	$email = $post['email'];

	$payment_method = $post['payment_method'];

	$act_name = $post['act_name'];
	$act_number = $post['act_number'];
	$act_short_code = $post['act_short_code'];
	$paypal_address = $post['paypal_address'];
	$venmo_address = $post['venmo_address'];
	$zelle_address = $post['zelle_address'];
	$amazon_gcard_address = $post['amazon_gcard_address'];
	$cash_app_address = $post['cash_app_address'];
	$apple_pay_address = $post['apple_pay_address'];
	$google_pay_address = $post['google_pay_address'];
	$coinbase_address = $post['coinbase_address'];
	$facebook_pay_address = $post['facebook_pay_address'];

	$payment_method_details_arr = array();
	if($payment_method == "bank") {
		$payment_method_details_arr = array('account_holder_name'=>$act_name,'account_number'=>$act_number,'short_code'=>$act_short_code);
	} elseif($payment_method == "paypal") {
		$payment_method_details_arr = array('paypal_address'=>$paypal_address);
	} elseif($payment_method == "venmo") {
		$payment_method_details_arr = array('venmo_address'=>$venmo_address);
	} elseif($payment_method == "zelle") {
		$payment_method_details_arr = array('zelle_address'=>$zelle_address);
	} elseif($payment_method == "amazon_gcard") {
		$payment_method_details_arr = array('amazon_gcard_address'=>$amazon_gcard_address);
	} elseif($payment_method == "cash_app") {
		$payment_method_details_arr = array('cash_app_address'=>$cash_app_address);
	} elseif($payment_method == "apple_pay") {
		$payment_method_details_arr = array('apple_pay_address'=>$apple_pay_address);
	} elseif($payment_method == "google_pay") {
		$payment_method_details_arr = array('google_pay_address'=>$google_pay_address);
	} elseif($payment_method == "coinbase") {
		$payment_method_details_arr = array('coinbase_address'=>$coinbase_address);
	} elseif($payment_method == "facebook_pay") {
		$payment_method_details_arr = array('facebook_pay_address'=>$facebook_pay_address);
	} elseif($payment_method == "cash") {
		$cash_phone = preg_replace("/[^\d]/", "", $post['f_cash_phone']);
		$payment_method_details_arr = array('cash_name'=>$post['cash_name'],'cash_phone'=>$cash_phone);
	}
	$payment_method_details = json_encode($payment_method_details_arr);

	$shipping_method = $post['shipping_method'];
	$billing_first_name = $post['billing_first_name'];
	$billing_last_name = $post['billing_last_name'];
	$billing_company_name = $post['billing_company_name'];
	$billing_address = $post['billing_address'];
	$billing_address2 = $post['billing_address2'];
	$billing_city = $post['billing_city'];
	$billing_state = $post['billing_state'];
	$billing_postcode = $post['billing_postcode'];
	$billing_country = $company_country;
	$billing_phone = $post['billing_phone'];
	$billing_phone_c_code = $post['billing_phone_c_code'];
	$quantity = $post['quantity'];
	$affiliate_id = $post['affiliate_id'];
	$affiliate_shop_name = $post['affiliate_shop_name'];

	$sales_pack = isset($post['shipping_method'])?$post['shipping_method']:'';
	$store_location_id = isset($post['location_id'])?$post['location_id']:'';
	$store_date = isset($post['date'])?$post['date']:'';
	$store_time = isset($post['time_slot'])?$post['time_slot']:'';
	
	if($store_date) {
		$expl_store_date = explode("/",$store_date);
		$store_date = $expl_store_date[2].'-'.$expl_store_date[0].'-'.$expl_store_date[1];
	}
	
	$name = real_escape_string($first_name).' '.real_escape_string($last_name);

	$items_array = array();
	
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
	
	/*foreach($post as $key=>$val) {
		if($key=="payment_method" || $key=="quantity" || $key=="sell_this_device" || $key=="device_id" || $key=="payment_amt" || $key=="req_model_id" || $key=="req_storage" || $key=="id" || $key=="PHPSESSID" || $key=="base_price" || $key=="device_id" || $key=="model_id" || $key=="account_type" || $key=="first_name" || $key=="last_name" || $key=="birth_date" || $key=="company_name" || $key=="vat_number" || $key=="address" || $key=="city" || $key=="postcode" || $key=="country" || $key=="phone" || $key=="other_phone" || $key=="email" || $key=="payment_method" || $key=="act_name" || $key=="act_number" || $key=="act_short_code" || $key=="paypal_address" || $key=="shipping_method" || $key=="same_as_billing_address" || $key=="billing_first_name" || $key=="billing_last_name" || $key=="billing_company_name" || $key=="billing_address" || $key=="billing_city" || $key=="billing_postcode" || $key=="billing_country" || $key=="chk_newsletter_promotions" || $key=="terms_and_conditions" || $key=="affiliate_id" || $key=="affiliate_shop_name" || $key=="csrf_token" || $key=="venmo_email_address" || $key=="zelle_email_address" || $key=="amazon_gcard_email_address" || $key=="phone_c_code" || $key=="billing_phone" || $key=="billing_phone_c_code" || $key=="billing_state" || $key=="billing_address2") {
			continue;
		}

		$exp_key = explode(":",$key);
		$exp_val = explode(":",$val);

		$pf_q = "SELECT * FROM product_fields WHERE id = '".$exp_key[1]."'";
		$exe_pro_fld = mysqli_query($db,$pf_q);
		$product_fields_data = mysqli_fetch_assoc($exe_pro_fld);

		if(is_array($val) && $key!="files") {
			$radio_items_array = array();
			foreach($val as $val_k => $val_d) {
				$exp_val_d = explode(":",$val_d);
				$radio_items_array[] = array('opt_id'=>$exp_val_d[1],'opt_name'=>$exp_val_d[0]);
			}
			if(!empty($radio_items_array)) {
				$items_array[$exp_key[1]] = array('fld_name'=>str_replace("_"," ",$exp_key[0]),'fld_type'=>$product_fields_data['input_type'],'opt_data'=>$radio_items_array);
			}
		} else {
			if($exp_val[0]) {
				$items_array[$exp_key[1]] = array('fld_name'=>str_replace("_"," ",$exp_key[0]),'fld_type'=>$product_fields_data['input_type'],'opt_data'=>array(array('opt_id'=>$exp_val[1],'opt_name'=>$exp_val[0])));
			}
		}
	}*/
	$order_items = json_encode($items_array);
	//print_r($items_array);
	//exit;

	$datetime = date('Y-m-d H:i:s');
	if($quantity>0) {
		//$order_id = $order_prefix.date('s').rand(100000,999999);

		$f_order_prefix = ($order_prefix>0?$order_prefix:0);

		$last_o_query = mysqli_query($db,"SELECT * FROM orders ORDER BY id DESC");
		$last_order_data = mysqli_fetch_assoc($last_o_query);
		
		$current_datetime_with_timezone = timeZoneConvert(date('Y-m-d H:i:s'), 'UTC', TIMEZONE,'Y-m-d H:i:s');
		$order_number_datetime_format =  date($order_number_datetime_format,strtotime($current_datetime_with_timezone));
		
		$exp_order_id = explode("-",$last_order_data['order_id']);
		$order_id_last_digits = $exp_order_id[3];
		if($last_order_data['order_id']!="" && $order_id_last_digits>=$f_order_prefix) {
			$order_id = date('y-m-d-',strtotime($order_number_datetime_format)).($order_id_last_digits+1);
		} elseif($last_order_data['order_id']=="" || $order_id_last_digits<$f_order_prefix) {
			$order_id = date('y-m-d-',strtotime($order_number_datetime_format)).$f_order_prefix;
		} else {
			$order_id = date('y-m-d-',strtotime($order_number_datetime_format)).rand(100000,999999);
		}
		
		mysqli_query($db,"INSERT INTO `orders`(`order_id`, `date`, `status`, `order_type`, `affiliate_id`) VALUES('".$order_id."','".$datetime."','partial','affiliate','".$affiliate_id."')");

		$edit_item_id = 0;
		$img_item_query = mysqli_query($db,"SELECT oi.* FROM order_items AS oi WHERE oi.id='".$edit_item_id."'");
		$img_item_data = mysqli_fetch_assoc($img_item_query);
		$svd_files_array = json_decode($img_item_data['images'],true);

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
		//echo $item_price = ($quantity_price * $quantity);
		$item_price = $quantity_price;
		$quantity_price = ($quantity_price / $quantity);
		
		/*$u_e_q=mysqli_query($db,"SELECT * FROM users WHERE email='".$email."' AND user_type='user'");
		$exist_user_data=mysqli_fetch_assoc($u_e_q);
		$user_id = $exist_user_data['id'];
		if(!empty($exist_user_data)) {
			$u_query=mysqli_query($db,"UPDATE `users` SET `name`='".$name."',`first_name`='".real_escape_string($first_name)."',`last_name`='".real_escape_string($last_name)."',`phone`='".$phone."',`email`='".$email."',`address`='".real_escape_string($address)."',`address2`='".real_escape_string($address2)."',`city`='".real_escape_string($city)."',`state`='".real_escape_string($state)."',`postcode`='".real_escape_string($postcode)."',`username`='".$email."',`update_date`='".$datetime."',`other_phone`='".real_escape_string($other_phone)."',`vat_number`='".real_escape_string($vat_number)."',`company_name`='".real_escape_string($company_name)."',birth_date='".$birth_date."',`country`='".real_escape_string($country)."' WHERE id='".$user_id."'");
		} else {
			$u_query=mysqli_query($db,"INSERT INTO `users`(`name`, `first_name`, `last_name`, `phone`, `email`, `address`, `address2`, `city`, `state`, `postcode`, `username`, `status`, `date`, `other_phone`, `vat_number`, `company_name`, birth_date, country, user_type) VALUES('".$name."', '".real_escape_string($first_name)."','".real_escape_string($last_name)."','".$phone."','".$email."','".real_escape_string($address)."','".real_escape_string($address2)."','".real_escape_string($city)."','".real_escape_string($state)."','".real_escape_string($postcode)."','".$email."','1','".$datetime."','".real_escape_string($other_phone)."','".real_escape_string($vat_number)."','".real_escape_string($company_name)."','".$birth_date."','".$country."','user')");
			$user_id = mysqli_insert_id($db);
		}*/

		mysqli_query($db,"INSERT INTO `users`(`name`, `first_name`, `last_name`, `company_name`, `phone`, `country_code`, `email`, `username`, `status`, `date`, user_type) VALUES('".$name."', '".real_escape_string($first_name)."','".real_escape_string($last_name)."','".real_escape_string($billing_company_name)."','".$phone."','".$phone_c_code."','".$email."','".$email."','1','".$datetime."','affiliate')");
		$user_id = mysqli_insert_id($db);

		mysqli_query($db,"INSERT INTO `order_items`(`device_id`, `model_id`, `order_id`, `item_name`, `images`, `price`, `quantity`, `quantity_price`, status) VALUES('".$device_id."','".$req_model_id."','".$order_id."','".real_escape_string($order_items)."','".$json_files."','".$item_price."','".$quantity."','".$quantity_price."','".$initial_order_item_status_id."')");
	}

	if($user_id>0) {
		$u_d_q = mysqli_query($db,'SELECT * FROM users WHERE id="'.$user_id.'"');
		$user_data = mysqli_fetch_assoc($u_d_q);

		$is_order_full_data_upt = false;
		//START post shipment by easypost API
		if($shipping_method == "print_a_prepaid_label" && $shipping_api == "easypost" && $shipping_option['print_a_prepaid_label'] == "print_a_prepaid_label" && $shipping_api_key != "") {
			try {
				require_once("../libraries/easypost-php-master/lib/easypost.php");
				\EasyPost\EasyPost::setApiKey($shipping_api_key);
		
				//create To address
				$to_address_params = array(
					"verify"  =>  array("delivery"),
					//'name' => $company_name,
					'company' => $company_name,
					'street1' => $company_address,
					'city' => $company_city,
					'state' => $company_state,
					'zip' => $company_zipcode,
					'country' => $company_country,
					'phone' => substr(preg_replace("/[^\d]/", "", $company_phone), -10),
					'email' => $site_email
				);
				//create From address
				$from_address_params = array(
					"verify"  =>  array("delivery"),
					'name' => $billing_first_name.' '.$billing_last_name,
					'street1' => $billing_address,
					'street2' => $billing_address2,
					'city' => $billing_city,
					'state' => $billing_state,
					'zip' => $billing_postcode,
					'country' => $company_country,
					'phone' => substr(preg_replace("/[^\d]/", "", $billing_phone), -10),
					'email' => $user_data['email']
				);

				$to_address = \EasyPost\Address::create($to_address_params);
				$from_address = \EasyPost\Address::create($from_address_params);

				$parcel_param_array = array(
				  "length" => $shipping_parcel_length,
				  "width" => $shipping_parcel_width,
				  "height" => $shipping_parcel_height,
				  "weight" => $shipping_parcel_weight
				);

				if($shipping_predefined_package!="") {
					$parcel_param_array['predefined_package'] = $shipping_predefined_package;
				}
				
				$parcel_info = \EasyPost\Parcel::create($parcel_param_array);
				
				if($to_address->verifications->delivery->success == '1' && $from_address->verifications->delivery->success == '1') {
					$shipment = \EasyPost\Shipment::create(array(
					  "to_address" => $to_address,
					  "from_address" => $from_address,
					  "parcel" => $parcel_info,
					  "carrier_accounts" => array($carrier_account_id),
					  "options" => array(
						  "label_size" => '4x6',
						  //"label_size" => '8.5x11',
						  //"print_custom_1" => "Instructions, Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.",
						  //"print_custom_2" => "test 2",
						  //"print_custom_3" => "test 3",
					  )
					));
					
					/*$shipment_rate_id = '';
					if(!empty($shipment->rates)) {
						foreach($shipment->rates as $rate_data) {
							if($rate_data->service == "Ground") {
								$shipment_rate_id = $rate_data->id;
							}
						}
					}
					if($shipment_rate_id!="") {
						$shipment->buy(array('rate' => array('id' => $shipment_rate_id)));
					} else {
						$shipment->buy(array(
						  'rate' => $shipment->lowest_rate(),
						));
					}*/
		
					//$shipment->buy(array('rate' => array('id' => $shipment_rate_id)));
					/*$shipment->buy(array(
					  'rate' => $shipment->lowest_rate(),
					));*/
		
					$shipment_rate_id = '';
					if(!empty($shipment->rates)) {
						foreach($shipment->rates as $rate_data) {
							if($rate_data->service == $shipping_api_service) {
								$shipment_rate_id = $rate_data->id;
							}
						}
					}
					if($shipment_rate_id!="") {
						$shipment->buy(array('rate' => array('id' => $shipment_rate_id)));
					} else {
						$shipment->buy(array(
						  'rate' => $shipment->lowest_rate(),
						));
					}
					
					$shipment->label(array(
					  'file_format' => 'PDF'
					));
		
					$shipment_id = $shipment->id;
					$shipment_tracking_code = $shipment->tracker->tracking_code;
					$shipment_label_url = $shipment->postage_label->label_url;
					$is_order_full_data_upt = true;
				} else {
					error_log("Error: Shipping address wrong...");
					//$msg='Unable to create shipment, one or more parameters were invalid.';
					//setRedirectWithMsg($affiliate_url.'/?shop='.$affiliate_shop_name,$msg,'error');
					//exit();

					//not need if this return validtion use...
					$is_order_full_data_upt = true;
				}
			} catch(\EasyPost\Error $e) {
				$shipment_error = "Error: ".$e->getHttpStatus().":".$e->getMessage();
				error_log("Error: ".$e->getHttpStatus().":".$e->getMessage());
		
				//$msg='Unable to create shipment, one or more parameters were invalid.';
				//setRedirectWithMsg($affiliate_url.'/?shop='.$affiliate_shop_name,$msg,'error');
				//exit();
				
				//not need if this return validtion use...
				$is_order_full_data_upt = true;
			}
		} else {
			$shipping_api = '';
			$shipment_id = '';
			$shipment_tracking_code = '';
			$shipment_label_url = '';
			$is_order_full_data_upt = true;
		} //END post shipment by easypost API

		if($is_order_full_data_upt == true) {
			$expire_date = ",expire_date='".date("Y-m-d H:i:s",strtotime($datetime." +".$order_expired_days." day"))."'";

			$access_token = get_big_unique_id();
			$upt_order_query = mysqli_query($db,"UPDATE `orders` SET `access_token`='".$access_token."', `payment_method`='".$payment_method."',`payment_method_details`='".$payment_method_details."', `user_id`='".$user_id."', `status`='".$initial_order_status_id."', approved_date='".$datetime."', `date`='".$datetime."', sales_pack='".$shipping_method."', shipping_first_name='".$billing_first_name."', shipping_last_name='".$billing_last_name."', shipping_company_name='".$billing_company_name."', shipping_address1='".$billing_address."', shipping_address2='".$billing_address2."', shipping_city='".$billing_city."', shipping_state='".$shipping_state."', shipping_state='".$shipping_state."', shipping_postcode='".$billing_postcode."', shipping_country='".$billing_country."', shipping_api='".$shipping_api."', shipment_id='".$shipment_id."', shipment_tracking_code='".$shipment_tracking_code."', shipment_label_url='".$shipment_label_url."', shipping_phone='".$billing_phone."', shipping_country_code='".$billing_phone_c_code."', `store_location_id`='".$store_location_id."', `store_date`='".$store_date."', `store_time`='".$store_time."'".$approved_date.$expire_date." WHERE order_id='".$order_id."'");
			if($upt_order_query == '1') {

				//Get order price based on orderID, path of this function (get_order_price) admin/include/functions.php
				$sum_of_orders = get_order_price($order_id);

				$sell_order_total = ($sum_of_orders>0?$sum_of_orders:'');

				//START append order items to block
				//Get order item list based on orderID, path of this function (get_order_item_list) admin/include/functions.php
				$order_item_list = get_order_item_list($order_id);
				foreach($order_item_list as $order_item_list_data) {
					//path of this function (get_order_item) admin/include/functions.php
					$order_item_data = get_order_item($order_item_list_data['id'],'email');
	
					$order_list .= '<table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">';
					  $order_list .= '<tbody>';
						$order_list .= '<tr>';
						  $order_list .= '<td class="o_bg-light o_px-xs" align="center" style="background-color: #dbe5ea;padding-left: 8px;padding-right: 8px;">';
							$order_list .= '<table class="o_block-lg" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 800px;margin: 0 auto;">';
							  $order_list .= '<tbody>';
								$order_list .= '<tr>';
								  $order_list .= '<td class="o_re o_bg-white o_px o_pt" align="center" style="font-size: 0;vertical-align: top;background-color: #ffffff;padding-left: 16px;padding-right: 16px;padding-top: 16px;">';
									$order_list .= '<div class="o_col o_col-3 o_col-full" style="display: inline-block;vertical-align: top;width: 100%;max-width: 300px;">';
									  $order_list .= '<div class="o_px-xs o_sans o_text-xs o_left" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 14px;line-height: 21px;text-align: left;padding-left: 8px;padding-right: 8px;">';
										$order_list .= '<p class="o_text o_text-secondary" style="font-size: 16px;line-height: 24px;color: #424651;margin-top: 0px;margin-bottom: 0px;"><strong>'.$order_item_list_data['device_title'].'</strong></p>';
										$order_list .= '<p class="o_text-light" style="color: #82899a;margin-top: 0px;margin-bottom: 0px;">'.$order_item_data['device_type'].'</p>';
									  $order_list .= '</div>';
									$order_list .= '</div>';
									$order_list .= '<div class="o_col o_col-1 o_col-full" style="display: inline-block;vertical-align: top;width: 100%;max-width: 100px;">';
									  $order_list .= '<div class="o_px-xs o_sans o_text o_center o_xs-left" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;text-align: center;padding-left: 8px;padding-right: 8px;">';
										$order_list .= '<p class="o_text-secondary" style="color: #424651;margin-top: 0px;margin-bottom: 0px;"><span class="o_hide-lg" style="display: none;font-size: 0;max-height: 0;width: 0;line-height: 0;overflow: hidden;mso-hide: all;visibility: hidden;">Quantity:&nbsp; </span>'.$order_item_list_data['quantity'].'</p>';
									  $order_list .= '</div>';
									$order_list .= '</div>';
									$order_list .= '<div class="o_col o_col-1 o_col-full" style="display: inline-block;vertical-align: top;width: 100%;max-width: 100px;">';
									  $order_list .= '<div class="o_px-xs o_sans o_text o_right o_xs-left" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;text-align: right;padding-left: 8px;padding-right: 8px;">';
										  $order_list .= '<p class="o_text-secondary" style="color: #424651;margin-top: 0px;margin-bottom: 0px;"><span class="o_hide-lg" style="display: none;font-size: 0;max-height: 0;width: 0;line-height: 0;overflow: hidden;mso-hide: all;visibility: hidden;">Price:&nbsp; </span>'.amount_fomat($order_item_list_data['price']).'</p>';
									  $order_list .= '</div>';
									$order_list .= '</div>';
									$order_list .= '<div class="o_px-xs" style="padding-left: 8px;padding-right: 8px;">';
									  $order_list .= '<table cellspacing="0" cellpadding="0" border="0" role="presentation">';
										$order_list .= '<tbody>';
										  $order_list .= '<tr>';
											$order_list .= '<td width="584" class="o_re o_bb-light" style="font-size: 16px;line-height: 16px;height: 16px;vertical-align: top;border-bottom: 1px solid #d3dce0;">&nbsp; </td>';
										  $order_list .= '</tr>';
										$order_list .= '</tbody>';
									  $order_list .= '</table>';
									$order_list .= '</div>';
								  $order_list .= '</td>';
								$order_list .= '</tr>';
							  $order_list .= '</tbody>';
							$order_list .= '</table>';
						  $order_list .= '</td>';
						$order_list .= '</tr>';
					  $order_list .= '</tbody>';
					$order_list .= '</table>';
				} //END append order items to block
				
				$visitor_body .= '<table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">';
				  $visitor_body .= '<tbody>';
					$visitor_body .= '<tr>';
					  $visitor_body .= '<td class="o_bg-light o_px-xs" align="center" style="background-color: #dbe5ea;padding-left: 8px;padding-right: 8px;">';
						$visitor_body .= '<table class="o_block-lg" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 800px;margin: 0 auto;">';
						  $visitor_body .= '<tbody>';
							$visitor_body .= '<tr>';
							  $visitor_body .= '<td class="o_re o_bg-white o_px o_pt-xs o_hide-xs" align="center" style="font-size: 0;vertical-align: top;background-color: #ffffff;padding-left: 16px;padding-right: 16px;padding-top: 8px;">';
								$visitor_body .= '<div class="o_col o_col-3" style="display: inline-block;vertical-align: top;width: 100%;max-width: 300px;">';
								  $visitor_body .= '<div class="o_px-xs o_sans o_text-xs o_left" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 14px;line-height: 21px;text-align: left;padding-left: 8px;padding-right: 8px;">';
									$visitor_body .= '<p class="o_text-light" style="color: #82899a;margin-top: 0px;margin-bottom: 0px;">Item(s)</p>';
								  $visitor_body .= '</div>';
								$visitor_body .= '</div>';
								$visitor_body .= '<div class="o_col o_col-1" style="display: inline-block;vertical-align: top;width: 100%;max-width: 100px;">';
								  $visitor_body .= '<div class="o_px-xs o_sans o_text-xs o_center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 14px;line-height: 21px;text-align: center;padding-left: 8px;padding-right: 8px;">';
									$visitor_body .= '<p class="o_text-light" style="color: #82899a;margin-top: 0px;margin-bottom: 0px;">Qty</p>';
								  $visitor_body .= '</div>';
								$visitor_body .= '</div>';
								$visitor_body .= '<div class="o_col o_col-1" style="display: inline-block;vertical-align: top;width: 100%;max-width: 100px;">';
								  $visitor_body .= '<div class="o_px-xs o_sans o_text-xs o_right" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 14px;line-height: 21px;text-align: right;padding-left: 8px;padding-right: 8px;">';
									$visitor_body .= '<p class="o_text-light" style="color: #82899a;margin-top: 0px;margin-bottom: 0px;">Price</p>';
								  $visitor_body .= '</div>';
								$visitor_body .= '</div>';
								$visitor_body .= '<div class="o_px-xs" style="padding-left: 8px;padding-right: 8px;">';
								  $visitor_body .= '<table cellspacing="0" cellpadding="0" border="0" role="presentation">';
									$visitor_body .= '<tbody>';
									  $visitor_body .= '<tr>';
										$visitor_body .= '<td width="584" class="o_re o_bb-light" style="font-size: 9px;line-height: 9px;height: 9px;vertical-align: top;border-bottom: 1px solid #d3dce0;">&nbsp; </td>';
									  $visitor_body .= '</tr>';
									$visitor_body .= '</tbody>';
								  $visitor_body .= '</table>';
								$visitor_body .= '</div>';
							  $visitor_body .= '</td>';
							$visitor_body .= '</tr>';
						  $visitor_body .= '</tbody>';
						$visitor_body .= '</table>';
					  $visitor_body .= '</td>';
					$visitor_body .= '</tr>';
				  $visitor_body .= '</tbody>';
				$visitor_body .= '</table>';
				$visitor_body .= $order_list;
				$visitor_body .= '<table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">';
				  $visitor_body .= '<tbody>';
					$visitor_body .= '<tr>';
					  $visitor_body .= '<td class="o_bg-light o_px-xs" align="center" style="background-color: #dbe5ea;padding-left: 8px;padding-right: 8px;">';
						$visitor_body .= '<table class="o_block-lg" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 800px;margin: 0 auto;">';
						  $visitor_body .= '<tbody>';
							$visitor_body .= '<tr>';
							  $visitor_body .= '<td class="o_re o_bg-white o_px-md o_py" align="center" style="font-size: 0;vertical-align: top;background-color: #ffffff;padding-left: 24px;padding-right: 24px;padding-top: 16px;padding-bottom: 16px;">';
								$visitor_body .= '<div class="o_col-6s o_right" style="max-width: 584px;text-align: right;">';
								  $visitor_body .= '<table class="o_right" role="presentation" cellspacing="0" cellpadding="0" border="0" style="text-align: right;margin-left: auto;margin-right: 0;">';
									$visitor_body .= '<tbody>';
									  $visitor_body .= '<tr>';
										$visitor_body .= '<td width="284" align="left">';
										  $visitor_body .= '<table width="100%" role="presentation" cellspacing="0" cellpadding="0" border="0">';
											$visitor_body .= '<tbody>';
											  $visitor_body .= '<tr>';
												$visitor_body .= '<td width="50%" class="o_pt-xs" align="left" style="padding-top: 8px;">';
												  $visitor_body .= '<p class="o_sans o_text o_text-secondary" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;color: #424651;">Sell Order Total</p>';
												$visitor_body .= '</td>';
												$visitor_body .= '<td width="50%" class="o_pt-xs" align="right" style="padding-top: 8px;">';
												  $visitor_body .= '<p class="o_sans o_text o_text-secondary" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;color: #424651;">'.amount_fomat($sell_order_total).'</p>';
												$visitor_body .= '</td>';
											  $visitor_body .= '</tr>';
											  
											  if($is_promocode_exist) {
											  $total = ($sell_order_total+$promocode_amt);
											  $visitor_body .= '<tr>';
												$visitor_body .= '<td width="50%" class="o_pt-xs" align="left" style="padding-top: 8px;">';
												  $visitor_body .= '<p class="o_sans o_text o_text-secondary" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;color: #424651;">'.$discount_amt_label.'</p>';
												$visitor_body .= '</td>';
												$visitor_body .= '<td width="50%" class="o_pt-xs" align="right" style="padding-top: 8px;">';
												  $visitor_body .= '<p class="o_sans o_text o_text-secondary" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;color: #424651;">'.amount_fomat($promocode_amt).'</p>';
												$visitor_body .= '</td>';
											  $visitor_body .= '</tr>';
											  $visitor_body .= '<tr>';
												$visitor_body .= '<td class="o_pt o_bb-light" style="border-bottom: 1px solid #d3dce0;padding-top: 16px;">&nbsp; </td>';
												$visitor_body .= '<td class="o_pt o_bb-light" style="border-bottom: 1px solid #d3dce0;padding-top: 16px;">&nbsp; </td>';
											  $visitor_body .= '</tr>';
											  $visitor_body .= '<tr>';
												$visitor_body .= '<td width="50%" class="o_pt" align="left" style="padding-top: 16px;">';
												  $visitor_body .= '<p class="o_sans o_text o_text-secondary" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;color: #424651;"><strong>Total</strong></p>';
												$visitor_body .= '</td>';
												$visitor_body .= '<td width="50%" class="o_pt" align="right" style="padding-top: 16px;">';
												  $visitor_body .= '<p class="o_sans o_text o_text-primary" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;color: #126de5;"><strong>'.amount_fomat($total).'</strong></p>';
												$visitor_body .= '</td>';
											  $visitor_body .= '</tr>';
											  }
											  
											$visitor_body .= '</tbody>';
										  $visitor_body .= '</table>';
										$visitor_body .= '</td>';
									  $visitor_body .= '</tr>';
									$visitor_body .= '</tbody>';
								  $visitor_body .= '</table>';
								$visitor_body .= '</div>';
							  $visitor_body .= '</td>';
							$visitor_body .= '</tr>';
						  $visitor_body .= '</tbody>';
	
						$visitor_body .= '</table>';
					  $visitor_body .= '</td>';
					$visitor_body .= '</tr>';
				  $visitor_body .= '</tbody>';
				$visitor_body .= '</table>';
				
				$email_to_customer_tmpl_nm = "new_order_email_to_customer";
				$template_data = get_template_data($email_to_customer_tmpl_nm);
			
				$template_data_for_admin = get_template_data('new_order_email_to_admin');
				$order_data = get_order_data($order_id);
				
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
					'{$customer_fname}',
					'{$customer_lname}',
					'{$customer_fullname}',
					'{$customer_phone}',
					'{$customer_email}',
					'{$billing_address1}',
					'{$billing_address2}',
					'{$billing_city}',
					'{$billing_state}',
					'{$customer_country}',
					'{$billing_postcode}',
					'{$order_id}',
					'{$order_payment_method}',
					'{$order_date}',
					'{$order_approved_date}',
					'{$order_expire_date}',
					'{$order_status}',
					'{$order_sales_pack}',
					'{$current_date_time}',
					'{$order_item_list}',
					'{$company_name}',
					'{$company_address}',
					'{$company_city}',
					'{$company_state}',
					'{$company_postcode}',
					'{$company_country}',
					'{$shipping_fname}',
					'{$shipping_lname}',
					'{$shipping_company_name}',
					'{$shipping_address1}',
					'{$shipping_address2}',
					'{$shipping_city}',
					'{$shipping_state}',
					'{$shipping_postcode}',
					'{$shipping_phone}',
					'{$store_location_name}',
					'{$store_location_address}',
					'{$store_date}',
					'{$store_time}');
	
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
					$user_data['first_name'],
					$user_data['last_name'],
					$user_data['name'],
					$user_data['phone'],
					$user_data['email'],
					$billing_address,
					$billing_address2,
					$billing_city,
					$billing_state,
					$billing_country,
					$billing_postcode,
					$order_data['order_id'],
					replace_us_to_space_pmt_mthd($order_data['payment_method']),
					$order_data['order_date'],
					$order_data['approved_date'],
					$order_data['expire_date'],
					replace_us_to_space($initial_order_status_name),
					replace_us_to_space($order_data['sales_pack']),
					format_date(date('Y-m-d H:i')).' '.format_time(date('Y-m-d H:i')),
					$visitor_body,
					$company_name,
					$company_address,
					$company_city,
					$company_state,
					$company_zipcode,
					$company_country,
					$billing_first_name,
					$billing_last_name,
					$billing_company_name,
					$billing_address,
					$billing_address2,
					$billing_city,
					$billing_state,
					$billing_postcode,
					$billing_phone,
					($order_data['location_name']?$order_data['location_name']:'No Data'),
					($order_data['location_name']?$order_data['location_address'].', '.$order_data['location_city'].', '.$order_data['location_state'].', '.$order_data['location_zipcode'].', '.$order_data['location_country']:'No Data'),
					($order_data['store_date']&&$order_data['store_date']!='0000-00-00'?format_date($order_data['store_date']):''),
					($order_data['store_time']?format_time($order_data['store_time']):''));

//START for generate barcode
$barcode_img_nm = "barcode_".date("YmdHis").".png";
$get_barcode_data = file_get_contents(SITE_URL.'libraries/barcode.php?text='.$order_id.'&codetype=code128&orientation=horizontal&size=30&print=false');
file_put_contents('../images/barcode/'.$barcode_img_nm, $get_barcode_data);
$barcode_img_path = '<img src="'.SITE_URL.'images/barcode/'.$barcode_img_nm.'"/>';
//END for generate barcode

$html = <<<EOF
<!-- EXAMPLE OF CSS STYLE -->
<style>
table,td{
  margin:0;
  padding:0;
}
.small-text{
  font-size:12px;
  text-align:center;
}
.block{
  width:45%;
}
.block-border{
  border:1px dashed #ddd;
}
.divider{
  width:10%;
}
.hdivider{
  height:0px;
}
.title{
  font-size:20px;
  font-weight:bold;
}
</style>
EOF;
					
$html.='
<table cell-padding="0" cell-spacing="0" border="0;" width="100%" style="padding:15px 15px 15px 15px;font-size:12px;">
	<tbody>
	  <tr>
		<td colspan="2"><h2 style="font-size:18px;">'.$company_name.' Packing Slip</h2></td>
		<td><img width="210" src="'.SITE_URL.'images/'.$general_setting_data['logo'].'"></td>
	  </tr>
	  <tr>
		<td>
			<dl>
				<dt>'.$billing_first_name.' '.$billing_last_name.'</dt>
				<dt>'.$billing_address.' '.$billing_address2.'</dt>
				<dt>'.$billing_city.', '.$billing_state.' '.$billing_postcode.'</dt>
			</dl>
		</td>
		<td>&nbsp;</td>
		<td>
			<dl>
				<dt>'.$barcode_img_path.'</dt>
				<dt><strong>Order Number:</strong> #'.$order_id.'</dt>
				<dt><strong>Date Of Offer:</strong> '.format_date($order_data['order_date']).'</dt>
				<dt><strong>Payment Method:</strong> '.$order_data['payment_method'].'</dt>
			</dl>
		</td>
	  </tr>
	</tbody>
</table>
<table cell-padding="0" cell-spacing="0" border="0;" width="100%" style="padding:10px 10px 10px 10px;">';

	foreach($order_item_list as $order_item_list_data) {
		//path of this function (get_order_item) admin/include/functions.php
		$order_item_data = get_order_item($order_item_list_data['id'],'email');
		$order_list_pdf .= '<tr>
			<td bgcolor="#ddd" width="10%" style="padding:15px;">'.($n=$n+1).'</td>
			<td bgcolor="#ddd" width="50%" style="padding:15px;">'.$order_item_list_data['device_title'].'<br>'.$order_item_data['device_type'].'</td>
			<td bgcolor="#ddd" width="20%" style="padding:15px;text-align:center;">'.$order_item_list_data['quantity'].'</td>';
			if($hide_device_order_valuation_price!='1') {
			$order_list_pdf .= '<td bgcolor="#ddd" width="20%" style="padding:15px;text-align:right;">'.amount_fomat($order_item_list_data['price']).'</td>';
			}
		$order_list_pdf .= '</tr>';
	} //END append order items to block
	
	$html .= '
		<tr>
			<td width="10%" bgcolor="#e0f2f7" style="padding:15px;"><strong>Line</strong></td>
			<td width="50%" bgcolor="#e0f2f7" style="padding:15px;"><strong>Product Details</strong></td>
			<td width="20%" bgcolor="#e0f2f7" style="padding:15px;text-align:center;"><strong>Quantity</strong></td>';
			if($hide_device_order_valuation_price!='1') {
			$html .= '<td width="20%" bgcolor="#e0f2f7" style="padding:15px;text-align:right;"><strong>Subtotal</strong></td>';
			}
		$html .= '</tr>';
	$html .= '<tbody>'.$order_list_pdf;
		if($hide_device_order_valuation_price!='1') {
		$html .= '<tr>
			<td>&nbsp;</td>
			<td colspan="2" style="text-align:right;"><strong>Sell Order Total:</strong></td>
			<td style="text-align:right;">'.($sum_of_orders>0?amount_fomat($sum_of_orders):'').'</td>
		</tr>';
		if($is_promocode_exist || $f_express_service_price>0 || $f_shipping_insurance_price>0) {
		  $total = ($sell_order_total+$promocode_amt);
		  if($is_promocode_exist) {
			$html .= '<tr>
				<td>&nbsp;</td>
				<td colspan="2" style="text-align:right;"><strong>'.$discount_amt_label.'</strong></td>
				<td style="text-align:right;">'.amount_fomat($promocode_amt).'</td>
			</tr>';
		  }
		  if($f_express_service_price) {
			$html .= '<tr>
				<td>&nbsp;</td>
				<td colspan="2" style="text-align:right;"><strong>Expedited Service</strong></td>
				<td style="text-align:right;">-'.amount_fomat($f_express_service_price).'</td>
			</tr>';
		  }
		  if($f_shipping_insurance_price) {
			$html .= '<tr>
				<td>&nbsp;</td>
				<td colspan="2" style="text-align:right;"><strong>Shipping Insurance</strong></td>
				<td style="text-align:right;">-'.amount_fomat($f_shipping_insurance_price).'</td>
			</tr>';
		  }
			$html .= '<tr>
				<td>&nbsp;</td>
				<td colspan="2" style="text-align:right;"><strong>Total:</strong></td>
				<td style="text-align:right;">'.amount_fomat(($total - $f_express_service_price - $f_shipping_insurance_price)).'</td>
			</tr>';
		}
		}
	$html .= '</tbody>';
 
	$html.='</tbody>
</table>';

$html.='<table cell-padding="0" cell-spacing="0" border="0;" width="100%" style="padding:10px 10px 10px 10px;">';
	$html.='<tbody>';
		$html .= '<tr>
			<td>Please include in your satchel<br>
			&nbsp;&nbsp;&nbsp;1. Device(s) Selected<br>
			&nbsp;&nbsp;&nbsp;2. Copy of packing list<br>
			&nbsp;&nbsp;&nbsp;3. Copy of Photo I.D (if not uploaded)<br><br>
			Please Reset Lock codes, or supply your user Lock code:……………………<br>
			Please send your device(s) within '.$order_expired_days.' days<br></td>
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

$file_folder='pdf';
$file_folder_path = CP_ROOT_PATH.'/'.$file_folder;
if(!file_exists($file_folder_path))
	mkdir($file_folder_path, 0777);

//$pdf_name='order-'.date('Y-m-d-H-i-s').'.pdf';
$pdf_name='order-'.$order_id.'.pdf';
$pdf->Output($file_folder_path.'/'.$pdf_name, 'F');
//echo SITE_URL.$file_folder.'/'.$pdf_name;
//exit;

				//START email send to customer
				if(!empty($template_data)) {
					$shipment_basename_label_url = basename($shipment_label_url);
					$label_copy_to_our_srvr = copy($shipment_label_url,'../shipment_labels/'.$shipment_basename_label_url);
					
					$email_subject = str_replace($patterns,$replacements,$template_data['subject']);
					$email_body_text = str_replace($patterns,$replacements,$template_data['content']);

					//$attachment_data['basename'] = $shipment_basename_label_url;
					//$attachment_data['folder'] = 'shipment_labels';
					$attachment_data['basename'] = array($shipment_basename_label_url,$pdf_name);
					$attachment_data['folder'] = array('shipment_labels','pdf');
					send_email($user_data['email'], $email_subject, $email_body_text, FROM_NAME, FROM_EMAIL, $attachment_data);
		
					//START sms send to customer
					if($template_data['sms_status']=='1' && $sms_sending_status=='1') {
						$from_number = '+'.$general_setting_data['twilio_long_code'];
						$to_number = '+'.$user_data['country_code'].$user_data['phone'];
						if($from_number && $account_sid && $auth_token) {
							$sms_body_text = str_replace($patterns,$replacements,$template_data['sms_content']);
							
							try {
								$sms_api->messages->create(
									$to_number,
									array(
										'from' => $from_number,
										'body' => $sms_body_text
									)
								);
							} catch(Exception $e) {
								$sms_error_msg = $e->getMessage();
								error_log($sms_error_msg);
							}
							
							/*try {
								$sms = $sms_api->account->messages->sendMessage($from_number, $to_number, $sms_body_text, $image, array('StatusCallback'=>''));
							} catch(Exception $e) {
								$sms_error_msg = $e->getMessage();
								error_log($sms_error_msg);
							}*/
						}
					} //END sms send to customer
				} //END email send to customer

				//START email send to admin
				if(!empty($template_data_for_admin)) {
					$email_subject_for_admin = str_replace($patterns,$replacements,$template_data_for_admin['subject']);
					$email_body_text_for_admin = str_replace($patterns,$replacements,$template_data_for_admin['content']);
					//send_email($admin_user_data['email'], $email_subject_for_admin, $email_body_text_for_admin, $user_data['name'], $user_data['email']);

					$reply_to_data = array();
					$reply_to_data['name'] = $user_data['name'];
					$reply_to_data['email'] = $user_data['email'];
					send_email($admin_user_data['email'], $email_subject_for_admin, $email_body_text_for_admin, FROM_NAME, FROM_EMAIL, array(), $reply_to_data);
				} //END email send to admin

				//Change session order_id to tmp_order_id & unset order_id session, it will use on only order-completion page.
				$_SESSION['affiliate_tmp_order_id'] = $order_id;
		
				$msg = "Your sell order (#".$order_id.") is almost complete.";
				setRedirectWithMsg(SITE_URL.'affiliate-order-complete',$msg,'success');
			} else {
				$msg='Sorry, something went wrong';
				setRedirectWithMsg($affiliate_url.'/?shop='.$affiliate_shop_name,$msg,'error');
			}
		} else {
			$msg='Sorry, something went wrong';
			setRedirectWithMsg($affiliate_url.'/?shop='.$affiliate_shop_name,$msg,'error');
		}
		exit();
	} else {
		setRedirect($affiliate_url.'/?shop='.$affiliate_shop_name);
		exit();
	}
} else {
	$msg='Direct access denied';
	setRedirectWithMsg(SITE_URL,$msg,'danger');
	exit();
} ?>