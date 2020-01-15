<?php 
require_once("../../_config/config.php");
require_once("../../include/functions.php");

$order_id = $post['order_id'];
$order_data_before_saved = get_order_data($order_id);

if($order_data_before_saved['promocode_id']>0 && $order_data_before_saved['promocode_amt']>0) {
	$promocode_amt = $order_data_before_saved['promocode_amt'];
	$discount_amt_label = "Surcharge:";
	if($order_data_before_saved['discount_type']=="percentage")
		$discount_amt_label = "Surcharge (".$order_data_before_saved['discount']."% of Initial Quote):";

	$is_promocode_exist = true;
}

if(isset($post['update'])) {
	$note=real_escape_string($post['note']);
	$changed_price_of_order_item = $post['price'];
	$status=$post['status'];
	$content=$post['content'];

	mysqli_query($db,"INSERT INTO `order_messaging`(`order_id`, `note`, status, type, `date`) VALUES('".$order_id."','".$note."', '".$order_data_before_saved['status']."','admin','".date('Y-m-d H:i:s')."')");
	$last_msg_id = mysqli_insert_id($db);

	if(!empty($changed_price_of_order_item)) {
		foreach($changed_price_of_order_item as $key=>$value) {
			mysqli_query($db,'UPDATE order_items SET price="'.$value.'" WHERE id="'.$key.'"');
			mysqli_query($db,"INSERT INTO `order_items_history`(`order_item_id`, `msg_id`, `price`, `date`) VALUES('".$key."','".$last_msg_id."','".$post['price'][$key]."','".date('Y-m-d H:i:s')."')");
		}
	}

	$order_sum_query=mysqli_query($db,"SELECT SUM(price) AS sum_of_orders FROM order_items WHERE order_id='".$order_id."'");
	$orders_sum=mysqli_fetch_assoc($order_sum_query);
	$sell_order_total = ($orders_sum['sum_of_orders']>0?$orders_sum['sum_of_orders']:'');
	
	//START append order items to block
	$order_query=mysqli_query($db,"SELECT oi.*, o.`payment_method`, o.`date`, o.`approved_date`, o.`expire_date`, o.`status`, o.`sales_pack`, o.`paypal_address`, o.`chk_name`, o.`chk_street_address`, o.`chk_street_address_2`, o.`chk_city`, o.`chk_state`, o.`chk_zip_code`, o.`act_name`, o.`act_number`, o.`act_short_code`, o.`note`, d.title AS device_title, m.title AS model_title FROM order_items AS oi LEFT JOIN orders AS o ON o.order_id=oi.order_id LEFT JOIN devices AS d ON d.id=oi.device_id LEFT JOIN mobile AS m ON m.id=oi.model_id WHERE o.order_id='".$order_id."' ORDER BY oi.id DESC");
	while($order_data=mysqli_fetch_assoc($order_query)) {
		$order_item_data = get_order_item($order_data['id'],'email');
		
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
							$order_list .= '<p class="o_text o_text-secondary" style="font-size: 16px;line-height: 24px;color: #424651;margin-top: 0px;margin-bottom: 0px;"><strong>'.$order_data['device_title'].'</strong></p>';
							$order_list .= '<p class="o_text-light" style="color: #82899a;margin-top: 0px;margin-bottom: 0px;">'.$order_item_data['device_type'].'</p>';
						  $order_list .= '</div>';
						$order_list .= '</div>';
						$order_list .= '<div class="o_col o_col-1 o_col-full" style="display: inline-block;vertical-align: top;width: 100%;max-width: 100px;">';
						  $order_list .= '<div class="o_px-xs o_sans o_text o_center o_xs-left" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;text-align: center;padding-left: 8px;padding-right: 8px;">';
							$order_list .= '<p class="o_text-secondary" style="color: #424651;margin-top: 0px;margin-bottom: 0px;"><span class="o_hide-lg" style="display: none;font-size: 0;max-height: 0;width: 0;line-height: 0;overflow: hidden;mso-hide: all;visibility: hidden;">Quantity:&nbsp; </span>'.$order_data['quantity'].'</p>';
						  $order_list .= '</div>';
						$order_list .= '</div>';
						$order_list .= '<div class="o_col o_col-1 o_col-full" style="display: inline-block;vertical-align: top;width: 100%;max-width: 100px;">';
						  $order_list .= '<div class="o_px-xs o_sans o_text o_right o_xs-left" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;text-align: right;padding-left: 8px;padding-right: 8px;">';
							  $order_list .= '<p class="o_text-secondary" style="color: #424651;margin-top: 0px;margin-bottom: 0px;"><span class="o_hide-lg" style="display: none;font-size: 0;max-height: 0;width: 0;line-height: 0;overflow: hidden;mso-hide: all;visibility: hidden;">Price:&nbsp; </span><b style="text-decoration: line-through;">'.amount_fomat($post['old_price'][$order_data['id']]).'</b>&nbsp;&nbsp;'.amount_fomat($order_data['price']).'</p>';
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
	}
	
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
	//END append order items to block

	$template_data = get_template_data('admin_reply_from_offer');
	//$template_data_rejected = get_template_data('admin_reply_from_offer_as_rejected');
	$general_setting_data = get_general_setting_data();
	$admin_user_data = get_admin_user_data();
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
		'{$customer_company_name}',
		'{$order_id}',
		'{$order_payment_method}',
		'{$order_date}',
		'{$order_approved_date}',
		'{$order_expire_date}',
		'{$order_status}',
		'{$order_sales_pack}',
		'{$current_date_time}',
		'{$order_note}',
		'{$order_item_list}',
		'{$offer_accept_link}',
		'{$offer_reject_link}',
		'{$company_name}',
		'{$company_address}',
		'{$company_city}',
		'{$company_state}',
		'{$company_postcode}',
		'{$company_country}');

	//$offer_accept_link = '<a href="'.SITE_URL.'offer-status/'.$order_id.'/offer_accepted">ACCEPT OFFER</a>';
	//$offer_reject_link = '<a href="'.SITE_URL.'offer-status/'.$order_id.'/offer_rejected">REJECT OFFER</a>';
	$offer_accept_link = SITE_URL.'offer-status/'.$order_id.'/offer_accepted';
	$offer_reject_link = SITE_URL.'offer-status/'.$order_id.'/offer_rejected';
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
		$order_data['company_name'],
		$order_data['order_id'],
		$order_data['payment_method'],
		$order_data['order_date'],
		$order_data['approved_date'],
		$order_data['expire_date'],
		ucwords(str_replace("_"," ",$order_data['order_status'])),
		$order_data['sales_pack'],
		date('Y-m-d H:i'),
		$post['note'],
		$visitor_body,
		$offer_accept_link,
		$offer_reject_link,
		$company_name,
		$company_address,
		$company_city,
		$company_state,
		$company_zipcode,
		$company_country);
	
	if(!empty($template_data)) {
		$email_subject = str_replace($patterns,$replacements,$template_data['subject']);
		$email_body_text = str_replace($patterns,$replacements,$content);	
		send_email($order_data['email'], $email_subject, $email_body_text, FROM_NAME, FROM_EMAIL);
		
		//START sms send to customer
		if($template_data['sms_status']=='1' && $sms_sending_status=='1') {
			$from_number = '+'.$general_setting_data['twilio_long_code'];
			$to_number = '+'.$order_data['phone'];
			if($from_number && $account_sid && $auth_token) {
				$sms_body_text = str_replace($patterns,$replacements,$template_data['sms_content']);
				try {
					$sms = $sms_api->account->messages->sendMessage($from_number, $to_number, $sms_body_text, $image, array('StatusCallback'=>''));
				} catch(Services_Twilio_RestException $e) {
					echo $sms_error_msg = $e->getMessage();
					error_log($sms_error_msg);
				}
			}
		} //END sms send to customer
	}

	$msg="Successfully Offer send to Customer";
	$_SESSION['success_msg']=$msg;
	setRedirect(ADMIN_URL.'order_offer.php?order_id='.$post['order_id']);
} else {
	setRedirect(ADMIN_URL.'orders.php');
}
exit();
?>
