<?php
require_once("../../admin/_config/config.php");
require_once("../../admin/include/functions.php");

$user_id = $_SESSION['user_id'];
$order_id = $_SESSION['order_id'];

//If direct access then it will redirect to home page
if($user_id<=0) {
	setRedirect(SITE_URL);
	exit();
}

$order_item_ids = $_SESSION['order_item_ids'];
if(empty($order_item_ids))
	$order_item_ids = array();

//Get order price based on orderID, path of this function (get_order_price) admin/include/functions.php
$sum_of_orders = get_order_price($order_id);

//Get user data based on userID
$user_data = get_user_data($user_id);

if(isset($post['confirm_sale'])) {
	$num_of_item = $post['num_of_item'];
	if($num_of_item!=count($order_item_ids)) {
		setRedirect(SITE_URL.'revieworder');
		exit();
	}

	if($user_id>0) {
		//START logic for promocode
		$date = date('Y-m-d');
		$amt = $sum_of_orders;
		$promocode_id = $post['promocode_id'];
		$promo_code = $post['promo_code'];
		if($promocode_id!='' && $promo_code!="" && $amt>0) {
			$query=mysqli_query($db,"SELECT * FROM `promocode` WHERE LOWER(promocode)='".strtolower($promo_code)."' AND ((never_expire='1' AND from_date <= '".$date."') OR (never_expire!='1' AND from_date <= '".$date."' AND to_date>='".$date."'))");
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
				setRedirectWithMsg(SITE_URL.'revieworder',$msg,'info');
				exit();
			}
		} //END logic for promocode
		
		$shipping_method = $post['shipping_method'];
		
		$upt_order_query = mysqli_query($db,"UPDATE `orders` SET `user_id`='".$user_id."', `status`='unconfirmed', `date`='".date('Y-m-d H:i:s')."', promocode_id='".$promocode_id."', promocode='".$promo_code."', promocode_amt='".$discount_of_amt."', discount_type='".$promo_code_data['discount_type']."', discount='".$discount."', sales_pack='".$shipping_method."' WHERE order_id='".$order_id."'");
		if($upt_order_query == '1') {
			
			//START post shipment by easypost API
			if($shipping_method == "own_print_label" && $shipping_api == "easypost" && $shipment_generated_by_cust == '1' && $shipping_api_key != "") {
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
						'phone' => $company_phone,
						'email' => $site_email
					);
			
					//create From address
					$from_address_params = array(
						"verify"  =>  array("delivery"),
						'name' => $user_data['name'],
						'street1' => $user_data['address'],
						//'street2' => $user_data['address2'],
						'city' => $user_data['city'],
						'state' => $user_data['state'],
						'zip' => $user_data['postcode'],
						'country' => $company_country,
						'phone' => substr($user_data['phone'], -10),
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
			
						//$shipment->buy(array('rate' => array('id' => $shipment->rates[2]->id)));
						$shipment->buy(array(
						  'rate' => $shipment->lowest_rate()
						));
			
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
	
					//$msg='Unable to create shipment, one or more parameters were invalid.';
					//setRedirectWithMsg(SITE_URL.'checkout',$msg,'error');
					//exit();
				}
			} //END post shipment by easypost API
			//exit;

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
											  $visitor_body .= '<p class="o_sans o_text o_text-secondary" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;color: #424651;">'.($sum_of_orders>0?amount_fomat($sum_of_orders):'').'</p>';
											$visitor_body .= '</td>';
										  $visitor_body .= '</tr>';
										  
										  if($is_promocode_exist) {
										  $visitor_body .= '<tr>';
											$visitor_body .= '<td width="50%" class="o_pt-xs" align="left" style="padding-top: 8px;">';
											  $visitor_body .= '<p class="o_sans o_text o_text-secondary" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;color: #424651;">'.$discount_amt_label.'</p>';
											$visitor_body .= '</td>';
											$visitor_body .= '<td width="50%" class="o_pt-xs" align="right" style="padding-top: 8px;">';
											  $visitor_body .= '<p class="o_sans o_text o_text-secondary" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;color: #424651;">'.$discount_amt_with_format.'</p>';
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

			$email_to_customer_tmpl_nm = "new_order_email_to_customer_own_print_label";
			if($shipping_method=="send_me_label") {
				$email_to_customer_tmpl_nm = "new_order_email_to_customer_send_me_label";
			} elseif($shipping_method=="own_courier") {
				$email_to_customer_tmpl_nm = "new_order_email_to_customer_courier_collection";
			}
			
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
				'{$order_item_list}',
				'{$company_name}',
				'{$company_address}',
				'{$company_city}',
				'{$company_state}',
				'{$company_postcode}',
				'{$company_country}');

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
				replace_us_to_space($order_data['payment_method']),
				$order_data['order_date'],
				$order_data['approved_date'],
				$order_data['expire_date'],
				replace_us_to_space($order_data['order_status']),
				replace_us_to_space($order_data['sales_pack']),
				date('Y-m-d H:i'),
				$visitor_body,
				$company_name,
				$company_address,
				$company_city,
				$company_state,
				$company_zipcode,
				$company_country);

			//START email send to customer
			if(!empty($template_data)) {
				$shipment_basename_label_url = basename($shipment_label_url);
				$label_copy_to_our_srvr = copy($shipment_label_url,'../../shipment_labels/'.$shipment_basename_label_url);
				
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

			//If order confirmed then final data saved/updated of order & unset all session items
			unset($_SESSION['order_item_ids']);

			//Change session order_id to tmp_order_id & unset order_id session, it will use on only place_order page.
			$_SESSION['tmp_order_id'] = $order_id;
			unset($_SESSION['order_id']);

			$msg = "Your sell order (#".$order_id.") is almost complete.";
			setRedirectWithMsg(SITE_URL.'place_order',$msg,'success');
		} else {
			$msg='Sorry, something went wrong';
			setRedirectWithMsg(SITE_URL.'revieworder',$msg,'error');
		}
		exit();
	} else {
		setRedirect(SITE_URL.'revieworder');
		exit();
	}
} elseif(isset($post['adr_change'])) {
	$upt_user_query = mysqli_query($db,"UPDATE `users` SET `address`='".real_escape_string($post['address'])."',`address2`='".real_escape_string($post['address2'])."',`city`='".real_escape_string($post['city'])."',`state`='".real_escape_string($post['state'])."',country='".real_escape_string($post['country'])."',`postcode`='".real_escape_string($post['postcode'])."' WHERE id='".$user_id."'");
	if($upt_user_query == '1') {
		$msg = "Shipping address has been successfully updated";
		setRedirectWithMsg(SITE_URL.'revieworder?action=confirm',$msg,'success');
		exit();
	}
} else {
	$msg='Direct access denied';
	setRedirectWithMsg(SITE_URL,$msg,'danger');
	exit();
} ?>