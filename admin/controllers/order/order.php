<?php 
require_once("../../_config/config.php");
require_once("../../include/functions.php");

$order_id = $post['order_id'];
$order_data_before_saved = get_order_data($order_id);

if(isset($post['create_shipment'])) {
	$order_id = $post['order_id'];
	if($order_id=="") {
		$msg='Sorry! something wrong!!';
		$_SESSION['error_msg']=$msg;
		setRedirect(ADMIN_URL.'edit_order.php?order_id='.$order_id);
		exit();
	}

	$admin_user_data = get_admin_user_data();
	$order_data = get_order_data($order_id);

	//START post shipment by easypost API
	if($shipping_api == "easypost" && $shipping_api_key != "") {
		require_once("../../../libraries/easypost-php-master/lib/easypost.php");
		\EasyPost\EasyPost::setApiKey($shipping_api_key);

		// create address
		$to_address_params = array(
			"verify"  =>  array("delivery"),
			//'name' => $company_name,
			'company' => $company_name,
			'street1' => $company_address,
			'city' => $company_city,
			//'state' => $company_state,
			'zip' => $company_zipcode,
			'country' => $company_country,
			'phone' => substr($company_phone, -10),
			'email' => $site_email
		);

		// create address
		$from_address_params = array(
			"verify"  =>  array("delivery"),
			'name' => $order_data['name'],
			'street1' => $order_data['address'],
			//'street2' => $order_data['address2'],
			'city' => $order_data['city'],
			//'state' => $order_data['state'],
			'zip' => $order_data['postcode'],
			'country' => $company_country,
			'phone' => substr($order_data['phone'], -10),
			'email' => $order_data['email']
		);
	
		$to_address = \EasyPost\Address::create($to_address_params);
		$from_address = \EasyPost\Address::create($from_address_params);

		if($to_address->verifications->delivery->success != '1') {
			$msg='Company address invalid so first please enter currect address & try again';
			$_SESSION['error_msg']=$msg;
			setRedirect(ADMIN_URL.'edit_order.php?order_id='.$order_id);
			exit();
		}
		
		if($from_address->verifications->delivery->success != '1') {
			$msg='Customer address invalid so first please enter currect address & try again';
			$_SESSION['error_msg']=$msg;
			setRedirect(ADMIN_URL.'edit_order.php?order_id='.$order_id);
			exit();
		}
		
		if($to_address->verifications->delivery->success == '1' && $from_address->verifications->delivery->success == '1') {
			$shipment = \EasyPost\Shipment::create(array(
			  "to_address" => $to_address,
			  "from_address" => $from_address,
			  "parcel" => array(
				"length" => $shipping_parcel_length,
				"width" => $shipping_parcel_width,
				"height" => $shipping_parcel_height,
				"weight" => $shipping_parcel_weight
			  )
			));
	
			//$shipment->buy(array('rate' => array('id' => $shipment->rates[0]->id)));
			$shipment->buy(array(
			  'rate' => $shipment->lowest_rate()
			));

			$shipment->label(array(
			  'file_format' => 'PDF'
			));

			$shipment_id = $shipment->id;
			$shipment_tracking_code = $shipment->tracker->tracking_code;
			$shipment_label_url = $shipment->postage_label->label_pdf_url;
		}

		$req_ordr_params = array('order_id' => $order_id,
				'shipping_api' => $shipping_api,
				'shipment_id' => $shipment_id,
				'shipment_tracking_code' => $shipment_tracking_code,
				'shipment_label_url' => $shipment_label_url,
			);
		$resp_save_default_status = save_shipment_response_data($req_ordr_params);
		
	} //END post shipment by easypost API

	if($shipment_label_url) {
		$shipment_basename_label_url = basename($shipment_label_url);
		$label_copy_to_our_srvr = copy($shipment_label_url,'../../../shipment_labels/'.$shipment_basename_label_url);
				
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
			'{$customer_email}',
			'{$country}',
			'{$state}',
			'{$city}',
			'{$order_id}',
			'{$order_payment_method}',
			'{$order_date}',
			'{$order_approved_date}',
			'{$order_expire_date}',
			'{$order_status}',
			'{$order_sales_pack}',
			'{$current_date_time}');
	
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
			$order_data['name'],
			$order_data['email'],
			$order_data['country'],
			$order_data['state'],
			$order_data['city'],
			$order_data['order_id'],
			$order_data['payment_method'],
			$order_data['order_date'],
			$order_data['approved_date'],
			$order_data['expire_date'],
			ucwords(str_replace("_"," ",$order_data['order_status'])),
			$order_data['sales_pack'],
			date('Y-m-d H:i'));
	
		//START email send to customer
		$shipment_label_email_to_customer = get_template_data('shipment_label_email_to_customer');
		if(!empty($shipment_label_email_to_customer)) {
			$email_subject = str_replace($patterns,$replacements,$shipment_label_email_to_customer['subject']);
			$email_body_text = str_replace($patterns,$replacements,$shipment_label_email_to_customer['content']);

			$attachment_data['basename'] = $shipment_basename_label_url;
			$attachment_data['folder'] = 'shipment_labels';
			send_email($order_data['email'], $email_subject, $email_body_text, FROM_NAME, FROM_EMAIL, $attachment_data);
			$msg = "Shipment successfully created & Shipment email send to customer.";
		} else { //END email send to customer
			$msg = "Shipment successfully created.";
		}
	} else {
		$msg = "Shipment not created so please contact with developer team";
	}
	
	$_SESSION['success_msg']=$msg;
	setRedirect(ADMIN_URL.'edit_order.php?order_id='.$order_id);
	exit();
} elseif(isset($post['d_id'])) {
	$query=mysqli_query($db,'DELETE FROM orders WHERE order_id="'.$post['d_id'].'"');
	if($query=="1"){
		mysqli_query($db,'DELETE FROM order_items WHERE order_id="'.$post['d_id'].'"');
		mysqli_query($db,'DELETE FROM order_messaging WHERE order_id="'.$post['d_id'].'"');
		$msg="Order successfully removed.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong Delete failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'orders.php');
	exit();
} elseif(isset($post['bulk_remove'])) {
	$ids_array = $post['ids'];
	if(!empty($ids_array)) {
		$removed_idd = array();
		foreach(explode(",",$ids_array) as $id_k=>$id_v) {
			$removed_idd[] = $id_v;
			$query=mysqli_query($db,'DELETE FROM orders WHERE order_id="'.$id_v.'" ');
			if($query=='1') {
				mysqli_query($db,'DELETE FROM order_items WHERE order_id="'.$id_v.'"');
				mysqli_query($db,'DELETE FROM order_messaging WHERE order_id="'.$id_v.'"');
			}
		}
	}

	$msg = count($removed_idd)." Order(s) successfully removed.";
	if(count($removed_idd)=='1')
		$msg = "Order successfully removed.";

	$_SESSION['success_msg']=$msg;
	setRedirect(ADMIN_URL.'orders.php');
	exit();
} elseif(isset($post['update'])) {
	$note=real_escape_string($post['note']);
	$status=real_escape_string($post['status']);

	if($status=="awaiting_delivery" && ($order_data_before_saved['status']!="awaiting_delivery" || $order_data_before_saved['approved_date']=="0000-00-00 00:00:00")) {
		$approved_date = ',approved_date="'.date("Y-m-d H:i:s").'"';
		$expire_date = ',expire_date="'.date("Y-m-d H:i:s",strtotime("+14 day")).'"';
	}

	if($status=="offer_accepted")
		$offer_status=', offer_status="'.$status.'"';
	elseif($status=="offer_rejected")
		$offer_status=', offer_status="'.$status.'"';

	if($order_id) {
		$query=mysqli_query($db,'UPDATE orders SET status="'.$status.'", note="'.$note.'"'.$approved_date.$expire_date.$offer_status.' WHERE order_id="'.$order_id.'"');
		if($query=="1") {
			$template_data = get_template_data('admin_reply_from_order');
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
				'{$current_date_time}');

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
				date('Y-m-d H:i'));

			if(!empty($template_data)) {
				$email_subject = str_replace($patterns,$replacements,$template_data['subject']);
				$email_body_text = str_replace($patterns,$replacements,$post['note']);
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

			$msg="Order has been successfully updated.";
			$_SESSION['success_msg']=$msg;
		} else {
			$msg='Sorry! something wrong updation failed.';
			$_SESSION['error_msg']=$msg;
		}
		setRedirect(ADMIN_URL.'edit_order.php?order_id='.$post['order_id']);
		exit();
	}
} elseif(isset($post['save'])) {
	$transaction_id=real_escape_string($post['transaction_id']);
	$check_number=real_escape_string($post['check_number']);
	$bank_name=real_escape_string($post['bank_name']);
	$is_payment_sent = $post['is_payment_sent'];

	if($_FILES['payment_receipt']['name']) {
		$image_ext = pathinfo($_FILES['payment_receipt']['name'],PATHINFO_EXTENSION);
		if($image_ext=="png" || $image_ext=="jpg" || $image_ext=="jpeg" || $image_ext=="gif") {
			$image_tmp_name=$_FILES['payment_receipt']['tmp_name'];
			$payment_receipt='receipt_'.date('YmdHis').'.'.$image_ext;
			$img_payment_receipt=', payment_receipt="'.$payment_receipt.'"';
			move_uploaded_file($image_tmp_name,'../../../images/payment/'.$payment_receipt);
		} else {
			$msg="Image type must be png, jpg, jpeg, gif";
			$_SESSION['success_msg']=$msg;
			setRedirect(ADMIN_URL.'edit_order.php?order_id='.$post['order_id']);
			exit();
		}
	}
	
	if($_FILES['cheque_photo']['name']) {
		$image2_ext = pathinfo($_FILES['cheque_photo']['name'],PATHINFO_EXTENSION);
		if($image2_ext=="png" || $image2_ext=="jpg" || $image2_ext=="jpeg" || $image2_ext=="gif") {
			$image2_tmp_name=$_FILES['cheque_photo']['tmp_name'];
			$cheque_photo='cheque_'.date('YmdHis').'.'.$image2_ext;
			$img_cheque_photo=', cheque_photo="'.$cheque_photo.'"';
			move_uploaded_file($image2_tmp_name,'../../../images/payment/'.$cheque_photo);
		} else {
			$msg="Image type must be png, jpg, jpeg, gif";
			$_SESSION['success_msg']=$msg;
			setRedirect(ADMIN_URL.'edit_order.php?order_id='.$post['order_id']);
			exit();
		}
	}

	$query=mysqli_query($db,'UPDATE orders SET transaction_id="'.$transaction_id.'", check_number="'.$check_number.'", bank_name="'.$bank_name.'", is_payment_sent="'.$is_payment_sent.'" '.$img_payment_receipt.$img_cheque_photo.' WHERE order_id="'.$order_id.'"');
	if($query=="1") {
		$msg="Successfully saved.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong updation failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'edit_order.php?order_id='.$post['order_id']);
	exit();
} elseif($post['d_p_i_id']) {
	if($post['mode']=="payment_receipt") {
		mysqli_query($db,"UPDATE orders SET payment_receipt='' WHERE order_id='".$post['d_p_i_id']."'");
	} elseif($post['mode']=="cheque_photo") {
		mysqli_query($db,"UPDATE orders SET cheque_photo='' WHERE order_id='".$post['d_p_i_id']."'");
	}
	
	setRedirect(ADMIN_URL.'edit_order.php?order_id='.$post['d_p_i_id']);
	exit();
} else {
	setRedirect(ADMIN_URL.'orders.php');
	exit;
}
?>