<?php
require_once("../../admin/_config/config.php");
require_once("../../admin/include/functions.php");
require_once("../common.php");

$initial_order_status_dt = get_order_status_data('order_status','waiting-shipment')['data'];
$initial_order_status_id = $initial_order_status_dt['id'];
$initial_order_status_name = $initial_order_status_dt['id'];

$user_id = $_SESSION['user_id'];
$guest_user_id = $_SESSION['guest_user_id'];
$order_id = $_SESSION['order_id'];

//If direct access then it will redirect to home page
if($user_id<=0 && $guest_user_id<=0) {
	setRedirect(SITE_URL);
	exit();
}

$order_data = get_order_data($order_id);

$order_item_ids = $_SESSION['order_item_ids'];
if(empty($order_item_ids))
	$order_item_ids = array();

//Get order price based on orderID, path of this function (get_order_price) admin/include/functions.php
$sum_of_orders = get_order_price($order_id);

if(isset($post['confirm_sale'])) {
	$num_of_item = $post['num_of_item'];
	if($num_of_item!=count($order_item_ids)) {
		$msg='Items in cart seems changed, Please re-varify.';
		setRedirectWithMsg(SITE_URL.'cart',$msg,'warning');
		exit();
	}

	if($user_id>0 || $guest_user_id>0) {

		if($user_id>0) {
			$user_data = get_user_data($user_id);
		} elseif($guest_user_id>0) {
			$user_data = get_user_data($guest_user_id);
		}

		$datetime = date('Y-m-d H:i:s');
		$date = date('Y-m-d');

		$act_name = $post['act_name'];
		$act_number = $post['act_number'];
		$act_short_code = $post['act_short_code'];
		$paypal_address = $post['paypal_address'];
		$venmo_email_address = $post['venmo_email_address'];
		$zelle_email_address = $post['zelle_email_address'];
		$amazon_gcard_email_address = $post['amazon_gcard_email_address'];

		/*$payment_method_details_arr = array();
		$payment_method = $post['payment_method'];
		if($payment_method == "bank") {
			$payment_method_details_arr = array('account_holder_name'=>$act_name,'account_number'=>$act_number,'short_code'=>$act_short_code);
		} elseif($payment_method == "paypal") {
			$payment_method_details_arr = array('email_address'=>$paypal_address);
		} elseif($payment_method == "venmo") {
			$payment_method_details_arr = array('email_address'=>$venmo_email_address);
		} elseif($payment_method == "zelle") {
			$payment_method_details_arr = array('email_address'=>$zelle_email_address);
		} elseif($payment_method == "amazon_gcard") {
			$payment_method_details_arr = array('email_address'=>$amazon_gcard_email_address);
		} elseif($payment_method == "cash") {
			$cash_phone = preg_replace("/[^\d]/", "", $post['f_cash_phone']);
			$payment_method_details_arr = array('cash_name'=>$post['cash_name'],'cash_phone'=>$cash_phone);
		}
		$payment_method_details = json_encode($payment_method_details_arr);*/
		
		$payment_method = $order_data['payment_method'];
		$shipping_method = $order_data['sales_pack'];
		
		//$save_as_primary_address = $order_data['save_as_primary_address'];
		$shipping_first_name = $order_data['shipping_first_name'];
		$shipping_last_name = $order_data['shipping_last_name'];
		$shipping_company_name = $order_data['shipping_company_name'];
		$shipping_address = $order_data['shipping_address1'];
		$shipping_address2 = $order_data['shipping_address2'];
		$shipping_city = $order_data['shipping_city'];
		$shipping_state = $order_data['shipping_state'];
		$shipping_country = $company_country;
		$shipping_postcode = $order_data['shipping_postcode'];
		$shipping_phone = $order_data['shipping_phone'];
		$shipping_phone_c_code = $order_data['shipping_country_code'];
		
		if($user_id>0) {
			/*mysqli_query($db,"UPDATE `users` SET `address`='".$shipping_address."',`address2`='".$shipping_address2."',`city`='".$shipping_city."',`state`='".$shipping_state."',`country`='".$company_country."',`postcode`='".$shipping_postcode."' WHERE id='".$user_id."'");
			$address = $shipping_address;
			$address2 = $shipping_address2;
			$city = $shipping_city;
			$state = $shipping_state;
			$country = $company_country;
			$postcode = $shipping_postcode;
		} else {*/
			$address = $user_data['address'];
			$address2 = $user_data['address2'];
			$city = $user_data['city'];
			$state = $user_data['state'];
			$country = $user_data['country'];
			$postcode = $user_data['postcode'];
			$customer_phone = $user_data['phone'];
			if($address == "" || $city == "" || $state == "") {
				$address = $shipping_address;
				$address2 = $shipping_address2;
				$city = $shipping_city;
				$state = $shipping_state;
				$country = $company_country;
				$postcode = $shipping_postcode;
				$customer_phone = $shipping_phone;
			}
		}
		
		/*if($save_as_primary_address == '1' && $user_id>0) {
			mysqli_query($db,"UPDATE `users` SET `address`='".$shipping_address."',`address2`='".$shipping_address2."',`city`='".$shipping_city."',`state`='".$shipping_state."',`country`='".$company_country."',`postcode`='".$shipping_postcode."' WHERE id='".$user_id."'");
			
			$address = $shipping_address;
			$address2 = $shipping_address2;
			$city = $shipping_city;
			$state = $shipping_state;
			$country = $company_country;
			$postcode = $shipping_postcode;
		}*/
		if($guest_user_id > 0) {
			$user_id = $guest_user_id;

			$address = $shipping_address;
			$address2 = $shipping_address2;
			$city = $shipping_city;
			$state = $shipping_state;
			$country = $company_country;
			$postcode = $shipping_postcode;
			$customer_phone = $shipping_phone;
		}
		
		//START post shipment by easypost API
		if($shipping_method == "print_a_prepaid_label" && $shipping_api == "easypost" && $shipping_option['print_a_prepaid_label'] == "print_a_prepaid_label" && $shipping_api_key != "") {
			try {
				require_once("../../libraries/easypost-php-master/lib/easypost.php");
				\EasyPost\EasyPost::setApiKey($shipping_api_key);

				//create To address
				$to_address_params = array(
					"verify"  =>  array("delivery"),
					//'name' => $company_name,
					'company' => $company_name,
					'street1' => $company_address,
					'city' => $company_city,
					//'state' => $company_state,
					'zip' => $company_zipcode,
					'country' => $company_country,
					'phone' => substr(preg_replace("/[^\d]/", "",$company_phone), -10),
					'email' => $site_email
				);

				//create From address
				$from_address_params = array(
					"verify"  =>  array("delivery"),
					'name' => $shipping_first_name.' '.$shipping_last_name,
					'street1' => $shipping_address,
					'street2' => $shipping_address2,
					'city' => $shipping_city,
					'state' => $shipping_state,
					'zip' => $shipping_postcode,
					'country' => $company_country,
					'phone' => substr(preg_replace("/[^\d]/", "",$shipping_phone), -10),
					'email' => $user_data['email']
				);

				$to_address = \EasyPost\Address::create($to_address_params);
				$from_address = \EasyPost\Address::create($from_address_params);
				
				if($to_address->verifications->delivery->success != '1') {
					$msg = 'Shop address invalid so you are not able to place your order. please try again after sometimes OR contact with support team.';
					//setRedirectWithMsg(SITE_URL.'cart',$msg,'warning');
					//exit();
				}
				
				if($from_address->verifications->delivery->success != '1') {
					$msg = 'Customer address invalid so please enter currect address & try again';
					//setRedirectWithMsg(SITE_URL.'cart',$msg,'warning');
					//exit();
				}
				
				$parcel_param_array = array(
				  "length" => $shipping_parcel_length,
				  "width" => $shipping_parcel_width,
				  "height" => $shipping_parcel_height,
				  "weight" => $shipping_parcel_weight
				);
				
				if($shipping_api_package!="") {
					$parcel_param_array['predefined_package'] = $shipping_api_package;
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
		
					//$shipment->buy(array('rate' => array('id' => $shipment->rates[2]->id)));
					/*$shipment->buy(array(
					  'rate' => $shipment->lowest_rate()
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
					$shipment_label_url = $shipment->postage_label->label_pdf_url;
					
					mysqli_query($db,"UPDATE `orders` SET shipping_api='".$shipping_api."', shipment_id='".$shipment_id."', shipment_tracking_code='".$shipment_tracking_code."', shipment_label_url='".$shipment_label_url."' WHERE order_id='".$order_id."'");
				}
			} catch(\EasyPost\Error $e) {
				$shipment_error = "Error: ".$e->getHttpStatus().":".$e->getMessage();
				error_log("Error: ".$e->getHttpStatus().":".$e->getMessage());

				//$msg = 'Unable to create shipment, one or more parameters were invalid.';
				//setRedirectWithMsg(SITE_URL.'cart',$msg,'warning');
				//exit();
			}
		} //END post shipment by easypost API
		
		$approved_date = "";//",approved_date='".$datetime."'";
		$expire_date = ",expire_date='".date("Y-m-d H:i:s",strtotime($datetime." +".$order_expired_days." day"))."'";

		$access_token = get_big_unique_id();
		//$upt_order_query = mysqli_query($db,"UPDATE `orders` SET `access_token`='".$access_token."', `user_id`='".$user_id."', `status`='".$initial_order_status_id."', `date`='".$datetime."', sales_pack='".$shipping_method."',`payment_method`='".$payment_method."',`payment_method_details`='".$payment_method_details."'".$approved_date.$expire_date." WHERE order_id='".$order_id."'");
		$upt_order_query = mysqli_query($db,"UPDATE `orders` SET `access_token`='".$access_token."', `user_id`='".$user_id."', `status`='".$initial_order_status_id."', `date`='".$datetime."', sales_pack='".$shipping_method."'".$approved_date.$expire_date." WHERE order_id='".$order_id."'");
		if($upt_order_query == '1') {
			
			//START logic for promocode
			$promocode_id = $order_data['promocode_id'];
			$promo_code = $order_data['promocode'];
			if($promocode_id!='' && $promo_code!="" && $sum_of_orders>0) {
				$query=mysqli_query($db,"SELECT * FROM `promocode` WHERE LOWER(promocode)='".strtolower($promo_code)."' AND ((never_expire='1' AND from_date <= '".$date."') OR (never_expire!='1' AND from_date <= '".$date."' AND to_date>='".$date."'))");
				$promo_code_data = mysqli_fetch_assoc($query);
				
				if($promo_code_data['multiple_act_by_same_cust']!='1') {
					$promo_code_data['multiple_act_by_same_cust'] = 1;
					$promo_code_data['multi_act_by_same_cust_qty'] = 1;
				}

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
					// If success promocode...
				} else {
					mysqli_query($db,"UPDATE `orders` SET promocode_id='', promocode='', promocode_amt='', discount_type='', discount='' WHERE order_id='".$order_id."'");
					$_SESSION['promocode_sys_msg'] = "Your promocode not applied to your order because its usage limit reached.";
				}
			} //END logic for promocode
			
			$order_data = get_order_data($order_id);
			$sell_order_total = ($sum_of_orders>0?$sum_of_orders:'');
			$is_promocode_exist = false;
			if($order_data['promocode_id']>0 && $order_data['promocode_amt']>0) {
				$promocode_amt = $order_data['promocode_amt'];
				$discount_amt_label = "Promocode:";
				if($order_data['discount_type']=="percentage")
					$discount_amt_label = "Promocode (".$order_data['discount']."% of Initial Quote):";
			
				$is_promocode_exist = true;
			}
			
			$bonus_amount = 0;
			$bonus_data = get_bonus_data_info_by_user($user_id);
			$bonus_percentage = $bonus_data['bonus_data']['percentage'];
			if($user_id>0 && $bonus_percentage>0) {
				$bonus_amount = ($sum_of_orders * $bonus_percentage / 100);
			}
			
			//START append order items to block
			//Get order item list based on orderID, path of this function (get_order_item_list) admin/include/functions.php
			$order_item_list = get_order_item_list($order_id);
			foreach($order_item_list as $order_item_list_data) {
				//path of this function (get_order_item) admin/include/functions.php
				$order_item_data = get_order_item($order_item_list_data['id'],'email');
				
				$itm_n = $itm_n+1;
				$order_item_id = $order_id.'/'.$itm_n;
				mysqli_query($db,"UPDATE `order_items` SET `order_item_id`='".$order_item_id."' WHERE id='".$order_item_list_data['id']."'");

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
										  
										  if($is_promocode_exist || $bonus_amount) {
										  $total = ($sell_order_total+$promocode_amt+$bonus_amount);
										  if($is_promocode_exist) {
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
										  }
										  if($bonus_amount>0) {
										  $visitor_body .= '<tr>';
											$visitor_body .= '<td width="50%" class="o_pt-xs" align="left" style="padding-top: 8px;">';
											  $visitor_body .= '<p class="o_sans o_text o_text-secondary" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;color: #424651;">Bonus ('.$bonus_percentage.'%)</p>';
											$visitor_body .= '</td>';
											$visitor_body .= '<td width="50%" class="o_pt-xs" align="right" style="padding-top: 8px;">';
											  $visitor_body .= '<p class="o_sans o_text o_text-secondary" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;color: #424651;">'.amount_fomat($bonus_amount).'</p>';
											$visitor_body .= '</td>';
										  $visitor_body .= '</tr>';
										  $visitor_body .= '<tr>';
											$visitor_body .= '<td class="o_pt o_bb-light" style="border-bottom: 1px solid #d3dce0;padding-top: 16px;">&nbsp; </td>';
											$visitor_body .= '<td class="o_pt o_bb-light" style="border-bottom: 1px solid #d3dce0;padding-top: 16px;">&nbsp; </td>';
										  $visitor_body .= '</tr>';
										  }
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
				'{$order_instruction}',
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
				$customer_phone,
				$user_data['email'],
				$address,
				$address2,
				$city,
				$state,
				$country,
				$postcode,
				$order_data['order_id'],
				replace_us_to_space_pmt_mthd($payment_method),
				$order_data['order_date'],
				$order_data['approved_date'],
				$order_data['expire_date'],
				replace_us_to_space($initial_order_status_name),
				replace_us_to_space($order_data['sales_pack']),
				format_date(date('Y-m-d H:i')).' '.format_time(date('Y-m-d H:i')),
				$visitor_body,
				$order_data['instruction'],
				$company_name,
				$company_address,
				$company_city,
				$company_state,
				$company_zipcode,
				$company_country,
				$shipping_first_name,
				$shipping_last_name,
				$shipping_company_name,
				$shipping_address,
				$shipping_address2,
				$shipping_city,
				$shipping_state,
				$shipping_postcode,
				$shipping_phone,
				($order_data['location_name']?$order_data['location_name']:'No Data'),
				($order_data['location_name']?$order_data['location_address'].', '.$order_data['location_city'].', '.$order_data['location_state'].', '.$order_data['location_zipcode'].', '.$order_data['location_country']:'No Data'),
				($order_data['store_date']&&$order_data['store_date']!='0000-00-00'?format_date($order_data['store_date']):''),
				($order_data['store_time']?format_time($order_data['store_time']):''));

//START for generate barcode
$barcode_img_nm = "barcode_".date("YmdHis").".png";
$get_barcode_data = file_get_contents(SITE_URL.'libraries/barcode.php?text='.$order_id.'&codetype=code128&orientation=horizontal&size=30&print=false');
file_put_contents('../../images/barcode/'.$barcode_img_nm, $get_barcode_data);
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
		<td><img width="210" src="'.($general_setting_data['logo']?SITE_URL.'images/'.$general_setting_data['logo']:'').'"></td>
	  </tr>
	  <tr>
		<td>
			<dl>
				<dt>'.$user_data['name'].'</dt>
				<dt>'.$address.' '.$address2.'</dt>
				<dt>'.$city.', '.$state.' '.$postcode.'</dt>
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
					<td style="text-align:right;">'.amount_fomat($sell_order_total).'</td>
				</tr>';
				if($is_promocode_exist || $bonus_amount) {
				  $total = ($sell_order_total+$promocode_amt+$bonus_amount);
				  if($is_promocode_exist) {
					$html .= '<tr>
						<td>&nbsp;</td>
						<td colspan="2" style="text-align:right;"><strong>'.$discount_amt_label.'</strong></td>
						<td style="text-align:right;">'.amount_fomat($promocode_amt).'</td>
					</tr>';
				  }
				  if($bonus_amount>0) {
					$html .= '<tr>
						<td>&nbsp;</td>
						<td colspan="2" style="text-align:right;"><strong>Bonus ('.$bonus_percentage.'%):</strong></td>
						<td style="text-align:right;">'.amount_fomat($bonus_amount).'</td>
					</tr>';
				  }
					$html .= '<tr>
						<td>&nbsp;</td>
						<td colspan="2" style="text-align:right;"><strong>Total:</strong></td>
						<td style="text-align:right;">'.amount_fomat($total).'</td>
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
				$label_copy_to_our_srvr = copy($shipment_label_url,'../../shipment_labels/'.$shipment_basename_label_url);
				
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
					$to_number = '+'.$shipping_phone_c_code.$shipping_phone;
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
						} catch(Services_Twilio_RestException $e) {
							$sms_error_msg = $e->getMessage();
							error_log($sms_error_msg);
						}*/
					}
				} //END sms send to customer

				//START Save data in inbox_mail_sms table
				$inbox_mail_sms_data = array("template_id" => $template_data['id'],
						"staff_id" => '',
						"user_id" => $user_id,
						"order_id" => $order_id,
						"from_email" => FROM_EMAIL,
						"to_email" => $user_data['email'],
						"subject" => $email_subject,
						"body" => $email_body_text,
						"sms_phone" => $to_number,
						"sms_content" => $sms_body_text,
						"date" => $datetime,
						"leadsource" => 'website',
						"form_type" => 'confirm_order');
				save_inbox_mail_sms($inbox_mail_sms_data);
				//END Save data in inbox_mail_sms table
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


			if($order_id) {
				$order_status_log_arr = array('order_id'=>$order_id,
											'item_id'=>'',
											'order_status'=>$initial_order_status_id,
											'item_status'=>''
										);
				save_order_status_log($order_status_log_arr);
			}
			
			$order_data = get_order_data($order_id);
			$items_quantity = get_order_qty_by_order_id($order_id)['items_quantity'];
			if($order_data['promocode_id']>0 && $order_data['promocode_amt']>0) {
				$promocode_amt = $order_data['promocode_amt'];
				$total_of_order = $sum_of_orders+$order_data['promocode_amt'];
			} else {
				$total_of_order = $sum_of_orders;
			}
			mysqli_query($db,"UPDATE `orders` SET `total_qty`='".$items_quantity."', `total_price`='".$total_of_order."' WHERE order_id='".$order_id."'");

			//If order confirmed then final data saved/updated of order & unset all session items
			unset($_SESSION['order_item_ids']);

			//Change session order_id to tmp_order_id & unset order_id session, it will use on only order-completion page.
			$_SESSION['tmp_order_id'] = $order_id;
			unset($_SESSION['order_id']);
			unset($_SESSION['guest_user_id']);

			$msg = "Your sell order (#".$order_id.") is almost complete.";

			$demand_pickup_zipcodes_settings = get_demand_pickup_zipcodes_settings();
			if($shipping_method == "we_come_for_you" && trim($demand_pickup_zipcodes_settings['url'])) {
				setRedirect($demand_pickup_zipcodes_settings['url']);
			} else {
				setRedirectWithMsg(SITE_URL.'order-completion',$msg,'success');
			}
		} else {
			$msg='Sorry, something went wrong so please try again.';
			setRedirectWithMsg(SITE_URL.'cart',$msg,'error');
		}
		exit();
	} else {
		$msg='Sorry, something went wrong so please try again.';
		setRedirectWithMsg(SITE_URL.'cart',$msg,'warning');
		exit();
	}
} else {
	$msg='Direct access denied';
	setRedirectWithMsg(SITE_URL,$msg,'danger');
	exit();
} ?>