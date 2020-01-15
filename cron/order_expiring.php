<?php
require_once("../admin/_config/config.php");
require_once("../admin/include/functions.php");

$general_setting_data = get_general_setting_data();
$admin_user_data = get_admin_user_data();
$template_data = get_template_data('order_expiring');

echo '<pre>';
$future_date = date('Y-m-d',strtotime('+7 day'));
//$future_date = date('Y-m-d',strtotime('-0 day'));
echo 'Date of order expiring:- '.$future_date;
$query = "SELECT o.*, u.*, u.id AS user_id FROM orders AS o LEFT JOIN users AS u ON u.id=o.user_id WHERE o.status IN('awaiting_delivery') AND DATE_FORMAT(o.expire_date,'%Y-%m-%d')='".$future_date."' ORDER BY o.id DESC";
$m_query=mysqli_query($db,$query);
$order_num_of_rows = mysqli_num_rows($m_query);
if($order_num_of_rows>0) {
	while($order_data=mysqli_fetch_assoc($m_query)) {
		$order_id = $order_data['order_id'];
		
		$order_items_list = '';
		$order_item_body = '';
		$patterns = array();
		$replacements = array();
		
		//Get order price based on orderID, path of this function (get_order_price) admin/include/functions.php
		$sum_of_orders=get_order_price($order_id);
		
		if($order_data['promocode_id']>0 && $order_data['promocode_amt']>0) {
			$promocode_amt = $order_data['promocode_amt'];
			$discount_amt_label = "Surcharge:";
			if($order_data['discount_type']=="percentage")
				$discount_amt_label = "Surcharge (".$order_data['discount']."% of Initial Quote):";
			 
			$total_of_order = $sum_of_orders;
			$is_promocode_exist = true;
		} else {
			$total_of_order = $sum_of_orders;
		}

		//START append order items to block
		//Get order item list based on orderID, path of this function (get_order_item_list) admin/include/functions.php
		$order_item_list = get_order_item_list($order_id);
		foreach($order_item_list as $order_item_list_data) {
			//path of this function (get_order_item) admin/include/functions.php
			$order_item_data = get_order_item($order_item_list_data['id'],'email');
			
			$order_items_list .= '<table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">';
			  $order_items_list .= '<tbody>';
				$order_items_list .= '<tr>';
				  $order_items_list .= '<td class="o_bg-light o_px-xs" align="center" style="background-color: #dbe5ea;padding-left: 8px;padding-right: 8px;">';
					$order_items_list .= '<table class="o_block-lg" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 800px;margin: 0 auto;">';
					  $order_items_list .= '<tbody>';
						$order_items_list .= '<tr>';
						  $order_items_list .= '<td class="o_re o_bg-white o_px o_pt" align="center" style="font-size: 0;vertical-align: top;background-color: #ffffff;padding-left: 16px;padding-right: 16px;padding-top: 16px;">';
							$order_items_list .= '<div class="o_col o_col-3 o_col-full" style="display: inline-block;vertical-align: top;width: 100%;max-width: 300px;">';
							  $order_items_list .= '<div class="o_px-xs o_sans o_text-xs o_left" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 14px;line-height: 21px;text-align: left;padding-left: 8px;padding-right: 8px;">';
								$order_items_list .= '<p class="o_text o_text-secondary" style="font-size: 16px;line-height: 24px;color: #424651;margin-top: 0px;margin-bottom: 0px;"><strong>'.$order_item_list_data['device_title'].'</strong></p>';
								$order_items_list .= '<p class="o_text-light" style="color: #82899a;margin-top: 0px;margin-bottom: 0px;">'.$order_item_data['device_type'].'</p>';
							  $order_items_list .= '</div>';
							$order_items_list .= '</div>';
							$order_items_list .= '<div class="o_col o_col-1 o_col-full" style="display: inline-block;vertical-align: top;width: 100%;max-width: 100px;">';
							  $order_items_list .= '<div class="o_px-xs o_sans o_text o_center o_xs-left" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;text-align: center;padding-left: 8px;padding-right: 8px;">';
								$order_items_list .= '<p class="o_text-secondary" style="color: #424651;margin-top: 0px;margin-bottom: 0px;"><span class="o_hide-lg" style="display: none;font-size: 0;max-height: 0;width: 0;line-height: 0;overflow: hidden;mso-hide: all;visibility: hidden;">Quantity:&nbsp; </span>'.$order_item_list_data['quantity'].'</p>';
							  $order_items_list .= '</div>';
							$order_items_list .= '</div>';
							$order_items_list .= '<div class="o_col o_col-1 o_col-full" style="display: inline-block;vertical-align: top;width: 100%;max-width: 100px;">';
							  $order_items_list .= '<div class="o_px-xs o_sans o_text o_right o_xs-left" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;text-align: right;padding-left: 8px;padding-right: 8px;">';
								  $order_items_list .= '<p class="o_text-secondary" style="color: #424651;margin-top: 0px;margin-bottom: 0px;"><span class="o_hide-lg" style="display: none;font-size: 0;max-height: 0;width: 0;line-height: 0;overflow: hidden;mso-hide: all;visibility: hidden;">Price:&nbsp; </span>'.amount_fomat($order_item_list_data['price']).'</p>';
							  $order_items_list .= '</div>';
							$order_items_list .= '</div>';
							$order_items_list .= '<div class="o_px-xs" style="padding-left: 8px;padding-right: 8px;">';
							  $order_items_list .= '<table cellspacing="0" cellpadding="0" border="0" role="presentation">';
								$order_items_list .= '<tbody>';
								  $order_items_list .= '<tr>';
									$order_items_list .= '<td width="584" class="o_re o_bb-light" style="font-size: 16px;line-height: 16px;height: 16px;vertical-align: top;border-bottom: 1px solid #d3dce0;">&nbsp; </td>';
								  $order_items_list .= '</tr>';
								$order_items_list .= '</tbody>';
							  $order_items_list .= '</table>';
							$order_items_list .= '</div>';
						  $order_items_list .= '</td>';
						$order_items_list .= '</tr>';
					  $order_items_list .= '</tbody>';
					$order_items_list .= '</table>';
				  $order_items_list .= '</td>';
				$order_items_list .= '</tr>';
			  $order_items_list .= '</tbody>';
			$order_items_list .= '</table>';
		}
		
		$order_item_body .= '<table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">';
		  $order_item_body .= '<tbody>';
			$order_item_body .= '<tr>';
			  $order_item_body .= '<td class="o_bg-light o_px-xs" align="center" style="background-color: #dbe5ea;padding-left: 8px;padding-right: 8px;">';
				$order_item_body .= '<table class="o_block-lg" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 800px;margin: 0 auto;">';
				  $order_item_body .= '<tbody>';
					$order_item_body .= '<tr>';
					  $order_item_body .= '<td class="o_re o_bg-white o_px o_pt-xs o_hide-xs" align="center" style="font-size: 0;vertical-align: top;background-color: #ffffff;padding-left: 16px;padding-right: 16px;padding-top: 8px;">';
						$order_item_body .= '<div class="o_col o_col-3" style="display: inline-block;vertical-align: top;width: 100%;max-width: 300px;">';
						  $order_item_body .= '<div class="o_px-xs o_sans o_text-xs o_left" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 14px;line-height: 21px;text-align: left;padding-left: 8px;padding-right: 8px;">';
							$order_item_body .= '<p class="o_text-light" style="color: #82899a;margin-top: 0px;margin-bottom: 0px;">Item(s)</p>';
						  $order_item_body .= '</div>';
						$order_item_body .= '</div>';
						$order_item_body .= '<div class="o_col o_col-1" style="display: inline-block;vertical-align: top;width: 100%;max-width: 100px;">';
						  $order_item_body .= '<div class="o_px-xs o_sans o_text-xs o_center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 14px;line-height: 21px;text-align: center;padding-left: 8px;padding-right: 8px;">';
							$order_item_body .= '<p class="o_text-light" style="color: #82899a;margin-top: 0px;margin-bottom: 0px;">Qty</p>';
						  $order_item_body .= '</div>';
						$order_item_body .= '</div>';
						$order_item_body .= '<div class="o_col o_col-1" style="display: inline-block;vertical-align: top;width: 100%;max-width: 100px;">';
						  $order_item_body .= '<div class="o_px-xs o_sans o_text-xs o_right" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 14px;line-height: 21px;text-align: right;padding-left: 8px;padding-right: 8px;">';
							$order_item_body .= '<p class="o_text-light" style="color: #82899a;margin-top: 0px;margin-bottom: 0px;">Price</p>';
						  $order_item_body .= '</div>';
						$order_item_body .= '</div>';
						$order_item_body .= '<div class="o_px-xs" style="padding-left: 8px;padding-right: 8px;">';
						  $order_item_body .= '<table cellspacing="0" cellpadding="0" border="0" role="presentation">';
							$order_item_body .= '<tbody>';
							  $order_item_body .= '<tr>';
								$order_item_body .= '<td width="584" class="o_re o_bb-light" style="font-size: 9px;line-height: 9px;height: 9px;vertical-align: top;border-bottom: 1px solid #d3dce0;">&nbsp; </td>';
							  $order_item_body .= '</tr>';
							$order_item_body .= '</tbody>';
						  $order_item_body .= '</table>';
						$order_item_body .= '</div>';
					  $order_item_body .= '</td>';
					$order_item_body .= '</tr>';
				  $order_item_body .= '</tbody>';
				$order_item_body .= '</table>';
			  $order_item_body .= '</td>';
			$order_item_body .= '</tr>';
		  $order_item_body .= '</tbody>';
		$order_item_body .= '</table>';
		$order_item_body .= $order_items_list;
	
		$order_item_body .= '<table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">';
		  $order_item_body .= '<tbody>';
			$order_item_body .= '<tr>';
			  $order_item_body .= '<td class="o_bg-light o_px-xs" align="center" style="background-color: #dbe5ea;padding-left: 8px;padding-right: 8px;">';
				$order_item_body .= '<table class="o_block-lg" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 800px;margin: 0 auto;">';
				  $order_item_body .= '<tbody>';
					$order_item_body .= '<tr>';
					  $order_item_body .= '<td class="o_re o_bg-white o_px-md o_py" align="center" style="font-size: 0;vertical-align: top;background-color: #ffffff;padding-left: 24px;padding-right: 24px;padding-top: 16px;padding-bottom: 16px;">';
						$order_item_body .= '<div class="o_col-6s o_right" style="max-width: 584px;text-align: right;">';
						  $order_item_body .= '<table class="o_right" role="presentation" cellspacing="0" cellpadding="0" border="0" style="text-align: right;margin-left: auto;margin-right: 0;">';
							$order_item_body .= '<tbody>';
							  $order_item_body .= '<tr>';
								$order_item_body .= '<td width="284" align="left">';
								  $order_item_body .= '<table width="100%" role="presentation" cellspacing="0" cellpadding="0" border="0">';
									$order_item_body .= '<tbody>';
									  $order_item_body .= '<tr>';
										$order_item_body .= '<td width="50%" class="o_pt-xs" align="left" style="padding-top: 8px;">';
										  $order_item_body .= '<p class="o_sans o_text o_text-secondary" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;color: #424651;">Sell Order Total</p>';
										$order_item_body .= '</td>';
										$order_item_body .= '<td width="50%" class="o_pt-xs" align="right" style="padding-top: 8px;">';
										  $order_item_body .= '<p class="o_sans o_text o_text-secondary" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;color: #424651;">'.($sum_of_orders>0?amount_fomat($sum_of_orders):'').'</p>';
										$order_item_body .= '</td>';
									  $order_item_body .= '</tr>';
									  
									  if($is_promocode_exist) {
									  $total = ($total_of_order+$promocode_amt);
									  $order_item_body .= '<tr>';
										$order_item_body .= '<td width="50%" class="o_pt-xs" align="left" style="padding-top: 8px;">';
										  $order_item_body .= '<p class="o_sans o_text o_text-secondary" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;color: #424651;">'.$discount_amt_label.'</p>';
										$order_item_body .= '</td>';
										$order_item_body .= '<td width="50%" class="o_pt-xs" align="right" style="padding-top: 8px;">';
										  $order_item_body .= '<p class="o_sans o_text o_text-secondary" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;color: #424651;">'.amount_fomat($promocode_amt).'</p>';
										$order_item_body .= '</td>';
									  $order_item_body .= '</tr>';
									  $order_item_body .= '<tr>';
										$order_item_body .= '<td class="o_pt o_bb-light" style="border-bottom: 1px solid #d3dce0;padding-top: 16px;">&nbsp; </td>';
										$order_item_body .= '<td class="o_pt o_bb-light" style="border-bottom: 1px solid #d3dce0;padding-top: 16px;">&nbsp; </td>';
									  $order_item_body .= '</tr>';
									  $order_item_body .= '<tr>';
										$order_item_body .= '<td width="50%" class="o_pt" align="left" style="padding-top: 16px;">';
										  $order_item_body .= '<p class="o_sans o_text o_text-secondary" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;color: #424651;"><strong>Total</strong></p>';
										$order_item_body .= '</td>';
										$order_item_body .= '<td width="50%" class="o_pt" align="right" style="padding-top: 16px;">';
										  $order_item_body .= '<p class="o_sans o_text o_text-primary" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;color: #126de5;"><strong>'.amount_fomat($total).'</strong></p>';
										$order_item_body .= '</td>';
									  $order_item_body .= '</tr>';
									  }
									  
									$order_item_body .= '</tbody>';
								  $order_item_body .= '</table>';
								$order_item_body .= '</td>';
							  $order_item_body .= '</tr>';
							$order_item_body .= '</tbody>';
						  $order_item_body .= '</table>';
						$order_item_body .= '</div>';
					  $order_item_body .= '</td>';
					$order_item_body .= '</tr>';
				  $order_item_body .= '</tbody>';
				$order_item_body .= '</table>';
			  $order_item_body .= '</td>';
			$order_item_body .= '</tr>';
		  $order_item_body .= '</tbody>';
		$order_item_body .= '</table>';
		//END append order items to block

		$order_data = get_order_data($order_id);

		$patterns = array(
			'{$logo}',
			'{$admin_logo}',
			'{$admin_email}',
			'{$admin_phone}',
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
			$general_setting_data['phone'],
			$admin_user_data['username'],
			ADMIN_URL,
			$general_setting_data['admin_panel_name'],
			$general_setting_data['from_name'],
			$general_setting_data['from_email'],
			$general_setting_data['site_name'],
			SITE_URL,
			$order_data['first_name'],
			$order_data['last_name'],
			$order_data['name'],
			$order_data['phone'],
			$order_data['email'],
			$order_data['address'],
			$order_data['address2'],
			$order_data['city'],
			$order_data['state'],
			$order_data['country'],
			$order_data['postcode'],
			$order_data['order_id'],
			$order_data['payment_method'],
			$order_data['order_date'],
			date('m/d/Y',strtotime($order_data['approved_date'])),
			date('m/d/Y',strtotime($order_data['expire_date'])),
			ucwords(str_replace("_"," ",$order_data['order_status'])),
			ucwords(str_replace("_"," ",$order_data['sales_pack'])),
			date('Y-m-d H:i'),
			$order_item_body,
			$company_name,
			$company_address,
			$company_city,
			$company_state,
			$company_zipcode,
			$company_country);

		//START email send to customer
		if(!empty($template_data)) {
			$email_subject = str_replace($patterns,$replacements,$template_data['subject']);
			$email_body_text = str_replace($patterns,$replacements,$template_data['content']);
			send_email($order_data['email'], $email_subject, $email_body_text, FROM_NAME, FROM_EMAIL);

			//START sms send to customer
			if($template_data['sms_status']=='1') {
				$from_number = '+'.$general_setting_data['twilio_long_code'];
				$to_number = '+'.$order_data['phone'];
				if($from_number && $account_sid && $auth_token) {
					$sms_body_text = str_replace($patterns,$replacements,$template_data['sms_content']);
					try {
						$sms = $sms_api->account->messages->sendMessage($from_number, $to_number, $sms_body_text, $image, array('StatusCallback'=>''));
					} catch(Services_Twilio_RestException $e) {
						echo 'Error: '.$sms_error_msg = $e->getMessage();
						error_log($sms_error_msg);
					}
				}
			} //END sms send to customer
		} //END email send to customer
	}
} else {
	echo '<br>Criteria not matched.';
}
exit;
?>