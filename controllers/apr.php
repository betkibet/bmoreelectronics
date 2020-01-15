<?php
require_once("../admin/_config/config.php");
require_once("../admin/include/functions.php");

if(isset($post['sell_this_device'])) {
	$post = $_POST;
	
	$valid_csrf_token = verifyFormToken('apr');
	if($valid_csrf_token!='1') {
		writeHackLog('apr');
		$msg = "Invalid Token";
		setRedirectWithMsg($return_url,$msg,'warning');
		exit();
	}
	
	$device_id = $post['device_id'];
	$req_model_id = $post['model_id'];
	$account_type = $post['account_type'];
	$first_name = $post['first_name'];
	$last_name = $post['last_name'];

	$birth_date = "";
	$company_name = "";
	$vat_number = "";
	$billing_company_name = "";
	if($account_type == "company") {
		$company_name = $post['company_name'];
		$vat_number = $post['vat_number'];
		$billing_company_name = $post['billing_company_name'];
	} else {
		$exp_birth_date = explode("/",$post['birth_date']);
		$birth_date = $exp_birth_date[2].'-'.$exp_birth_date[0].'-'.$exp_birth_date[1];
	}

	$address = $post['address'];
	$city = $post['city'];
	$postcode = $post['postcode'];
	$country = $post['country'];
	$phone = $post['phone'];
	$other_phone = $post['other_phone'];
	$email = $post['email'];
	$payment_method = $post['payment_method'];
	$act_name = $post['act_name'];
	$act_number = $post['act_number'];
	$act_short_code = $post['act_short_code'];
	$chk_name = $post['chk_name'];
	$chk_street_address = $post['chk_street_address'];
	$chk_street_address_2 = $post['chk_street_address_2'];
	$chk_city = $post['chk_city'];
	$chk_state = $post['chk_state'];
	$chk_zip_code = $post['chk_zip_code'];
	$paypal_address = $post['paypal_address'];
	$shipping_method = $post['shipping_method'];
	$same_as_billing_address = $post['same_as_billing_address'];
	$billing_first_name = $post['billing_first_name'];
	$billing_last_name = $post['billing_last_name'];
	$billing_address = $post['billing_address'];
	$billing_city = $post['billing_city'];
	$billing_postcode = $post['billing_postcode'];
	$billing_country = $post['billing_country'];
	$quantity = $post['quantity'];
	$partner_id = $post['partner_id'];
	$partner_store_name = $post['partner_store_name'];

	$phone = preg_replace("/[^\d]/", "", real_escape_string($phone));
	$name = real_escape_string($first_name).' '.real_escape_string($first_name);
		
	$order_items_array = array();
	foreach($post as $key=>$val) {
		if(is_array($val) && $key!="files") {
			$val = implode(", ",$val);
		}

		if($key=="payment_method" || $key=="quantity" || $key=="sell_this_device" || $key=="device_id" || $key=="payment_amt" || $key=="req_model_id" || $key=="req_storage" || $key=="id" || $key=="PHPSESSID" || $key=="base_price" || $key=="device_id" || $key=="model_id" || $key=="account_type" || $key=="first_name" || $key=="last_name" || $key=="birth_date" || $key=="company_name" || $key=="vat_number" || $key=="address" || $key=="city" || $key=="postcode" || $key=="country" || $key=="phone" || $key=="other_phone" || $key=="email" || $key=="payment_method" || $key=="act_name" || $key=="act_number" || $key=="act_short_code" || $key=="chk_name" || $key=="chk_street_address" || $key=="chk_street_address_2" || $key=="chk_city" || $key=="chk_state" || $key=="chk_zip_code" || $key=="paypal_address" || $key=="shipping_method" || $key=="same_as_billing_address" || $key=="billing_first_name" || $key=="billing_last_name" || $key=="billing_company_name" || $key=="billing_address" || $key=="billing_city" || $key=="billing_postcode" || $key=="billing_country" || $key=="chk_newsletter_promotions" || $key=="terms_and_conditions" || $key=="partner_id" || $key=="partner_store_name" || $key=="csrf_token") {
			continue;
		}
		if(trim($val)) {
			$order_items_array[] = str_replace("_"," ",$key).": ".$val;
		}
	}
	$order_items = implode("::",$order_items_array);

	if($quantity>0) {
		$order_id = $order_prefix.date('s').rand(100000,999999);
		mysqli_query($db,"INSERT INTO `orders`(`order_id`, `date`, `status`, `order_type`, `partner_id`) VALUES('".$order_id."','".date('Y-m-d H:i:s')."','partial','apr','".$partner_id."')");
		
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
	
				if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
					
				}
	
				$filename = date("YmdHis").rand(1111,9999).".".$imageFileType;
				$target_file = $target_dir.$filename;
	
				if(move_uploaded_file($files_data[$key]["tmp_name"], $target_file)) {
					$files_array[$key] = $filename;
				}
			}
			$json_files = json_encode($files_array);
		} //END upload images
	
		$quantity_price = $post['payment_amt'];
		$item_price = ($quantity_price * $quantity);
		
		$u_e_q=mysqli_query($db,'SELECT * FROM users WHERE email="'.$email.'"');
		$exist_user_data=mysqli_fetch_assoc($u_e_q);
		$user_id = $exist_user_data['id'];
		if(!empty($exist_user_data)) {
			$u_query=mysqli_query($db,"UPDATE `users` SET `name`='".$name."',`first_name`='".real_escape_string($first_name)."',`last_name`='".real_escape_string($last_name)."',`phone`='".$phone."',`email`='".$email."',`address`='".real_escape_string($address)."',`address2`='".real_escape_string($address2)."',`city`='".real_escape_string($city)."',`state`='".real_escape_string($state)."',`postcode`='".real_escape_string($postcode)."',`username`='".$email."',status='1',`update_date`='".date('Y-m-d H:i:s')."',`other_phone`='".real_escape_string($other_phone)."',`vat_number`='".real_escape_string($vat_number)."',`company_name`='".real_escape_string($company_name)."',birth_date='".$birth_date."',`country`='".real_escape_string($country)."' WHERE id='".$user_id."'");
		} else {
			$u_query=mysqli_query($db,"INSERT INTO `users`(`name`, `first_name`, `last_name`, `phone`, `email`, `address`, `address2`, `city`, `state`, `postcode`, `username`, `status`, `date`, `other_phone`, `vat_number`, `company_name`, birth_date, country) VALUES('".$name."', '".real_escape_string($first_name)."','".real_escape_string($last_name)."','".$phone."','".$email."','".real_escape_string($address)."','".real_escape_string($address2)."','".real_escape_string($city)."','".real_escape_string($state)."','".real_escape_string($postcode)."','".$email."','1','".date('Y-m-d H:i:s')."','".real_escape_string($other_phone)."','".real_escape_string($vat_number)."','".real_escape_string($company_name)."','".$birth_date."','".$country."')");
			$user_id = mysqli_insert_id($db);
		}

		$o_query=mysqli_query($db,"INSERT INTO `order_items`(`device_id`, `model_id`, `order_id`, `storage`, `condition`, `network`, `color`, `accessories`, `miscellaneous`, `item_name`, `images`, `price`, `quantity`, `quantity_price`) VALUES('".$device_id."','".$req_model_id."','".$order_id."','".real_escape_string($req_storage)."','".real_escape_string($condition[0])."','".real_escape_string($network[0])."','".real_escape_string($color[0])."','".real_escape_string($accessories)."','".real_escape_string($miscellaneous)."','".real_escape_string($order_items)."','".$json_files."','".$item_price."','".$quantity."','".$quantity_price."')");
	}

	if($user_id>0) {
		$u_d_q = mysqli_query($db,'SELECT * FROM users WHERE id="'.$user_id.'"');
		$user_data = mysqli_fetch_assoc($u_d_q);

		$is_order_full_data_upt = false;
		//START post shipment by easypost API
		if($shipping_api == "easypost" && $shipment_generated_by_cust == '1' && $shipping_api_key != "") {
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
					'phone' => $company_phone,
					'email' => $site_email
				);
				//create From address
				$from_address_params = array(
					"verify"  =>  array("delivery"),
					'name' => $name,
					'street1' => $address,
					//'street2' => $user_data['address2'],
					'city' => $city,
					//'state' => $user_data['state'],
					'zip' => $postcode,
					'country' => $company_country,
					'phone' => substr($user_data['phone'], -10),
					'email' => $user_data['email']
				);
		
				$to_address = \EasyPost\Address::create($to_address_params);
				$from_address = \EasyPost\Address::create($from_address_params);
				//print_r($to_address);
				//print_r($from_address);
				
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
					$shipment->buy(array(
					  'rate' => $shipment->lowest_rate(),
					));
		
					$shipment->label(array(
					  'file_format' => 'PDF'
					));
		
					$shipment_id = $shipment->id;
					$shipment_tracking_code = $shipment->tracker->tracking_code;
					$shipment_label_url = $shipment->postage_label->label_url;
					$is_order_full_data_upt = true;
				} else {
					$msg='Unable to create shipment, one or more parameters were invalid.';
					setRedirectWithMsg(SITE_URL.'apr/?apr='.$partner_store_name,$msg,'error');
					exit();
				}
			} catch(\EasyPost\Error $e) {
				$shipment_error = "Error: ".$e->getHttpStatus().":".$e->getMessage();
				error_log("Error: ".$e->getHttpStatus().":".$e->getMessage());
		
				$msg='Unable to create shipment, one or more parameters were invalid.';
				setRedirectWithMsg(SITE_URL.'apr/?apr='.$partner_store_name,$msg,'error');
				exit();
			}
		} else {
			$shipping_api = '';
			$shipment_id = '';
			$shipment_tracking_code = '';
			$shipment_label_url = '';
			$is_order_full_data_upt = true;
		} //END post shipment by easypost API
			
		if($is_order_full_data_upt == true) {
			$upt_order_query = mysqli_query($db,"UPDATE `orders` SET `payment_method`='".$payment_method."', paypal_address='".real_escape_string($paypal_address)."', chk_name='".real_escape_string($chk_name)."', chk_street_address='".real_escape_string($chk_street_address)."', chk_street_address_2='".real_escape_string($chk_street_address_2)."', chk_city='".real_escape_string($chk_city)."', chk_state='".real_escape_string($chk_state)."', chk_zip_code='".real_escape_string($chk_zip_code)."', act_name='".real_escape_string($act_name)."', act_number='".real_escape_string($act_number)."', act_short_code='".real_escape_string($act_short_code)."', `user_id`='".$user_id."', `status`='unconfirmed', `date`='".date('Y-m-d H:i:s')."', promocode_id='".$promocode_id."', promocode='".$promo_code."', promocode_amt='".$discount_of_amt."', discount_type='".$promo_code_data['discount_type']."', discount='".$discount."', sales_pack='".$shipping_method."', billing_first_name='".$billing_first_name."', billing_last_name='".$billing_last_name."', billing_company_name='".$billing_company_name."', billing_address='".$billing_address."', billing_city='".$billing_city."', billing_postcode='".$billing_postcode."', billing_country='".$billing_country."', shipping_api='".$shipping_api."', shipment_id='".$shipment_id."', shipment_tracking_code='".$shipment_tracking_code."', shipment_label_url='".$shipment_label_url."' WHERE order_id='".$order_id."'");
			if($upt_order_query == '1') {
				
				//Get order price based on orderID, path of this function (get_order_price) admin/include/functions.php
				$sum_of_orders = get_order_price($order_id);

				//START append order items to block
				//Get order item list based on orderID, path of this function (get_order_item_list) admin/include/functions.php
				$order_item_list = get_order_item_list($order_id);
				foreach($order_item_list as $order_item_list_data) {
					//path of this function (get_order_item) admin/include/functions.php
					$order_item_data = get_order_item($order_item_list_data['id'],'email');
					$order_list .= '<tr>
						<td bgcolor="#ddd" width="60%" style="padding:15px;">'.$order_item_list_data['device_title'].' - '.$order_item_data['device_type'].'</td>
						<td bgcolor="#ddd" width="20%" style="padding:15px;text-align:center;">'.$order_item_list_data['quantity'].'</td>
						<td bgcolor="#ddd" width="20%" style="padding:15px;text-align:right;">'.amount_fomat($order_item_list_data['price']).'</td>
					</tr>
					<tr>
						<td style="padding:1px;"></td>
					</tr>';
				} //END append order items to block
	
				$visitor_body .= '<table width="650" cellpadding="0" cellspacing="0">';
					$visitor_body .= '
						<tr>
							<td style="padding:10px;"></td>
						</tr>
						<tr>
							<td width="60%" bgcolor="#e0f2f7" style="padding:15px;"><strong>Handset/Device Type</strong></td>
							<td width="20%" bgcolor="#e0f2f7" style="padding:15px;text-align:center;"><strong>Quantity</strong></td>
							<td width="20%" bgcolor="#e0f2f7" style="padding:15px;text-align:right;"><strong>Subtotal</strong></td>
						</tr>
						<tr>
							<td style="padding:0px;"></td>
						</tr>';
					$visitor_body .= '<tbody>'.$order_list;
						$visitor_body .= '<tr>
							<td></td>
							<td style="padding:5px;text-align:right;"><strong>Sell Order Total:</strong></td>
							<td style="padding:5px;text-align:right;">'.($sum_of_orders>0?amount_fomat($sum_of_orders):'').'</td>
						</tr>';
						if($is_promocode_exist) {
							$visitor_body .= '<tr>
								<td></td>
								<td style="padding:5px;text-align:right;"><strong>'.$discount_amt_label.'</strong></td>
								<td style="padding:5px;text-align:right;">'.$discount_amt_with_format.'</td>
							</tr>
							<tr>
								<td></td>
								<td style="padding:5px;text-align:right;"><strong>Total:</strong></td>
								<td style="padding:5px;text-align:right;">'.amount_fomat($total).'</td>
							</tr>';
						}
					$visitor_body .= '</tbody>';
				$visitor_body .= '</table>';
				
				$email_to_customer_tmpl_nm = "new_order_email_to_customer";
				/*if($shipping_method=="send_me_label") {
					$email_to_customer_tmpl_nm = "new_order_email_to_customer_send_me_label";
				} elseif($shipping_method=="own_courier") {
					$email_to_customer_tmpl_nm = "new_order_email_to_customer_courier_collection";
				}*/
			
				$template_data = get_template_data($email_to_customer_tmpl_nm);
				
				$template_data_for_admin = get_template_data('new_order_email_to_admin');
				$order_data = get_order_data($order_id);
		
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
					'{$customer_address_line1}',
					'{$customer_address_line2}',
					'{$customer_city}',
					'{$customer_state}',
					'{$customer_country}',
					'{$customer_postcode}',
					'{$order_id}',
					'{$order_payment_method}',
					'{$order_date}',
					'{$order_approved_date}',
					'{$order_expire_date}',
					'{$order_status}',
					'{$order_sales_pack}',
					'{$current_date_time}',
					'{$order_item_list}');
		
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
					$user_data['address'],
					$user_data['address2'],
					$user_data['city'],
					$user_data['state'],
					$user_data['country'],
					$user_data['postcode'],
					$order_data['order_id'],
					$order_data['payment_method'],
					$order_data['order_date'],
					$order_data['approved_date'],
					$order_data['expire_date'],
					ucwords(str_replace("_"," ",$order_data['order_status'])),
					$order_data['sales_pack'],
					date('Y-m-d H:i'),
					$visitor_body);
		
				//START email send to customer
				if(!empty($template_data)) {
					$shipment_basename_label_url = basename($shipment_label_url);
					$label_copy_to_our_srvr = copy($shipment_label_url,'../shipment_labels/'.$shipment_basename_label_url);
					
					$email_subject = str_replace($patterns,$replacements,$template_data['subject']);
					$email_body_text = str_replace($patterns,$replacements,$template_data['content']);
					
					$attachment_data['basename'] = $shipment_basename_label_url;
					$attachment_data['folder'] = 'shipment_labels';
					send_email($user_data['email'], $email_subject, $email_body_text, FROM_NAME, FROM_EMAIL, $attachment_data);
		
					//START sms send to customer
					if($template_data['sms_status']=='1') {
						$from_number = '+'.$general_setting_data['twilio_long_code'];
						$to_number = '+'.$user_data['phone'];
						if($from_number && $account_sid && $auth_token) {
							$sms_body_text = str_replace($patterns,$replacements,$template_data['sms_content']);
							try {
								$sms = $sms_api->account->messages->sendMessage($from_number, $to_number, $sms_body_text, $image, array('StatusCallback'=>''));
							} catch(Services_Twilio_RestException $e) {
								$sms_error_msg = $e->getMessage();
								error_log($sms_error_msg);
							}
						}
					} //END sms send to customer
				} //END email send to customer
		
				//START email send to admin
				if(!empty($template_data_for_admin)) {
					$email_subject_for_admin = str_replace($patterns,$replacements,$template_data_for_admin['subject']);
					$email_body_text_for_admin = str_replace($patterns,$replacements,$template_data_for_admin['content']);
					send_email($admin_user_data['email'], $email_subject_for_admin, $email_body_text_for_admin, $user_data['name'], $user_data['email']);
				} //END email send to admin
		
				//Change session order_id to tmp_order_id & unset order_id session, it will use on only place_order page.
				$_SESSION['apr_tmp_order_id'] = $order_id;
		
				$msg = "Your sell order (#".$order_id.") is almost complete.";
				setRedirectWithMsg(SITE_URL.'apr-order-complete',$msg,'success');
			} else {
				$msg='Sorry, something went wrong';
				setRedirectWithMsg(SITE_URL.'apr/?apr='.$partner_store_name,$msg,'error');
			}
		} else {
			$msg='Sorry, something went wrong';
			setRedirectWithMsg(SITE_URL.'apr/?apr='.$partner_store_name,$msg,'error');
		}
		exit();
	} else {
		setRedirect(SITE_URL.'apr/?apr='.$partner_store_name);
		exit();
	}
} else {
	$msg='Direct access denied';
	setRedirectWithMsg(SITE_URL,$msg,'danger');
	exit();
} ?>