<?php 
require_once("../../_config/config.php");
require_once("../../../admin/include/functions.php");
require_once("../common.php");
check_contractor_staff_auth();

$initial_order_status_dt = get_order_status_data('order_status','waiting-shipment')['data'];
$initial_order_status_id = $initial_order_status_dt['id'];
$initial_order_status_name = $initial_order_status_dt['id'];

$initial_order_item_status_id = get_order_status_data('order_item_status','waiting-shipment')['data']['id'];

$order_id = $post['order_id'];
$order_data_before_saved = get_order_data($order_id);

if(isset($post['create_shipment'])) {
	$order_id = $post['order_id'];
	if($order_id=="") {
		$msg='Sorry! something wrong!!';
		$_SESSION['error_msg']=$msg;
		setRedirect(CONTRACTOR_URL.'edit_order.php?order_id='.$order_id.'&order_mode='.$post['order_mode']);
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
			setRedirect(CONTRACTOR_URL.'edit_order.php?order_id='.$order_id.'&order_mode='.$post['order_mode']);
			exit();
		}
		
		if($from_address->verifications->delivery->success != '1') {
			$msg='Customer address invalid so first please enter currect address & try again';
			$_SESSION['error_msg']=$msg;
			setRedirect(CONTRACTOR_URL.'edit_order.php?order_id='.$order_id.'&order_mode='.$post['order_mode']);
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
			CONTRACTOR_URL,
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
			replace_us_to_space($order_data['order_status_name']),
			$order_data['sales_pack'],
			format_date(date('Y-m-d H:i')).' '.format_time(date('Y-m-d H:i')));
	
		//START email send to customer
		$shipment_label_email_to_customer = get_template_data('shipment_label_email_to_customer');
		if(!empty($shipment_label_email_to_customer)) {
			$email_subject = str_replace($patterns,$replacements,$shipment_label_email_to_customer['subject']);
			$email_body_text = str_replace($patterns,$replacements,$shipment_label_email_to_customer['content']);

			$attachment_data['basename'] = array($shipment_basename_label_url);
			$attachment_data['folder'] = array('shipment_labels');
			send_email($order_data['email'], $email_subject, $email_body_text, FROM_NAME, FROM_EMAIL, $attachment_data);
			$msg = "Shipment successfully created & Shipment email send to customer.";
		} else { //END email send to customer
			$msg = "Shipment successfully created.";
		}
	} else {
		$msg = "Shipment not created so please contact with developer team";
	}
	
	$_SESSION['success_msg']=$msg;
	setRedirect(CONTRACTOR_URL.'edit_order.php?order_id='.$order_id.'&order_mode='.$post['order_mode']);
	exit();
} elseif(isset($post['d_id'])) {
	$query=mysqli_query($db,"UPDATE orders SET is_trash='1' WHERE order_id='".$post['d_id']."'");
	//$query=mysqli_query($db,'DELETE FROM orders WHERE order_id="'.$post['d_id'].'"');
	if($query=="1"){
		//mysqli_query($db,'DELETE FROM order_items WHERE order_id="'.$post['d_id'].'"');
		//mysqli_query($db,'DELETE FROM order_messaging WHERE order_id="'.$post['d_id'].'"');
		//mysqli_query($db,'DELETE FROM contractor_orders WHERE order_id="'.$post['d_id'].'"');
		$msg="Order successfully removed.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong delete failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(CONTRACTOR_URL.'archive_orders.php');
	exit();
} elseif(isset($post['bulk_remove'])) {
	$ids_array = $post['ids'];
	if(!empty($ids_array)) {
		$removed_idd = array();
		foreach(explode(",",$ids_array) as $id_k=>$id_v) {
			$removed_idd[] = $id_v;
			$query=mysqli_query($db,"UPDATE orders SET is_trash='1' WHERE order_id='".$id_v."'");
			//$query=mysqli_query($db,'DELETE FROM orders WHERE order_id="'.$id_v.'" ');
			if($query=='1') {
				//mysqli_query($db,'DELETE FROM order_items WHERE order_id="'.$id_v.'"');
				//mysqli_query($db,'DELETE FROM order_messaging WHERE order_id="'.$id_v.'"');
				//mysqli_query($db,'DELETE FROM contractor_orders WHERE order_id="'.$id_v.'"');
			}
		}
	}

	$msg = count($removed_idd)." Order(s) successfully removed.";
	if(count($removed_idd)=='1')
		$msg = "Order successfully removed.";

	$_SESSION['success_msg']=$msg;
	setRedirect(CONTRACTOR_URL.'archive_orders.php');
	exit();
} elseif(isset($post['a_id'])) {
	$query=mysqli_query($db,"UPDATE orders SET is_trash='1' WHERE order_id='".$post['a_id']."'");
	if($query=="1"){
		$msg="Order successfully archived.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong delete failed.';
		$_SESSION['error_msg']=$msg;
	}
	
	if($post['order_mode'] == "unpaid") {
		setRedirect(CONTRACTOR_URL.'orders.php');
	} elseif($post['order_mode'] == "awaiting") {
		setRedirect(CONTRACTOR_URL.'awaiting_orders.php');
	} elseif($post['order_mode'] == "archive") {
		setRedirect(CONTRACTOR_URL.'archive_orders.php');
	} elseif($post['order_mode'] == "imei") {
		setRedirect(CONTRACTOR_URL.'search_by_imei_orders.php');
	} elseif($post['order_mode'] == "abandone") {
		setRedirect(CONTRACTOR_URL.'abandone_orders.php');
	} else {
		setRedirect(CONTRACTOR_URL.'paid_orders.php');
	}
	exit();
} elseif(isset($post['bulk_archive'])) {
	$ids_array = $post['ids'];
	if(!empty($ids_array)) {
		$removed_idd = array();
		foreach(explode(",",$ids_array) as $id_k=>$id_v) {
			$removed_idd[] = $id_v;
			$query=mysqli_query($db,"UPDATE orders SET is_trash='1' WHERE order_id='".$id_v."'");
			if($query=='1') {
			}
		}
	}

	$msg = count($removed_idd)." Order(s) successfully archived.";
	if(count($removed_idd)=='1')
		$msg = "Order successfully archived.";

	$_SESSION['success_msg']=$msg;
	if($post['order_mode'] == "unpaid") {
		setRedirect(CONTRACTOR_URL.'orders.php');
	} elseif($post['order_mode'] == "awaiting") {
		setRedirect(CONTRACTOR_URL.'awaiting_orders.php');
	} elseif($post['order_mode'] == "archive") {
		setRedirect(CONTRACTOR_URL.'archive_orders.php');
	} elseif($post['order_mode'] == "abandone") {
		setRedirect(CONTRACTOR_URL.'abandone_orders.php');
	} elseif($post['order_mode'] == "imei") {
		setRedirect(CONTRACTOR_URL.'search_by_imei_orders.php');
	} else {
		setRedirect(CONTRACTOR_URL.'paid_orders.php');
	}
	exit();
} elseif(isset($post['u_id'])) {
	$query=mysqli_query($db,"UPDATE orders SET is_trash='0' WHERE order_id='".$post['u_id']."'");
	if($query=="1"){
		$msg="Order successfully undone.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong delete failed.';
		$_SESSION['error_msg']=$msg;
	}
	
	setRedirect(CONTRACTOR_URL.'archive_orders.php');
	exit();
} elseif(isset($post['bulk_undo'])) {
	$ids_array = $post['ids'];
	if(!empty($ids_array)) {
		$removed_idd = array();
		foreach(explode(",",$ids_array) as $id_k=>$id_v) {
			$removed_idd[] = $id_v;
			$query=mysqli_query($db,"UPDATE orders SET is_trash='0' WHERE order_id='".$id_v."'");
			if($query=='1') {
			}
		}
	}

	$msg = count($removed_idd)." Order(s) successfully undone.";
	if(count($removed_idd)=='1')
		$msg = "Order successfully undone.";

	$_SESSION['success_msg']=$msg;
	setRedirect(CONTRACTOR_URL.'archive_orders.php');
	exit();
} elseif(isset($post['bulk_set_paid'])) {
	$completed_order_status_id = get_order_status_data('order_status','completed')['data']['id'];

	$ids_array = $post['ids'];
	if(!empty($ids_array)) {
		$payment_paid_batch_id = date("dHmi").rand(0000,9999);
		$removed_idd = array();
		$is_any_order_status_not_completed = "no";
		foreach(explode(",",$ids_array) as $id_k=>$id_v) {
			$removed_idd[] = $id_v;
			
			$mysql_payment_paid_batch_id = "";
			
			$order_data_before_saved = get_order_data($id_v);
			if($order_data_before_saved['is_payment_sent']!='1') {
				$mysql_payment_paid_batch_id = ", payment_paid_batch_id='".$payment_paid_batch_id."'";
			}
		
			if($order_data_before_saved['status'] != $completed_order_status_id) {
				$is_any_order_status_not_completed = "yes";
			}

			$query=mysqli_query($db,"UPDATE orders SET is_payment_sent='1', payment_sent_date='".date("Y-m-d H:i:s")."'".$mysql_payment_paid_batch_id." WHERE order_id='".$id_v."' AND status='".$completed_order_status_id."'");
			/*if($query == '1' && $order_data_before_saved['is_payment_sent']!='1') {
				$template_data = get_template_data('order_payment_status_paid_alert_email_to_customer');
				$general_setting_data = get_general_setting_data();
				$admin_user_data = get_admin_user_data();

				$sum_of_orders=get_order_price($order_id);
				if($order_data_before_saved['promocode_id']>0 && $order_data_before_saved['promocode_amt']>0) {
					$total_of_order = $sum_of_orders+$order_data_before_saved['promocode_amt'];
				} else {
					$total_of_order = $sum_of_orders;
				}
			
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
					'{$order_total}');
		
				$replacements = array(
					$logo,
					$admin_logo,
					$admin_user_data['email'],
					$admin_user_data['username'],
					CONTRACTOR_URL,
					$general_setting_data['admin_panel_name'],
					$general_setting_data['from_name'],
					$general_setting_data['from_email'],
					$general_setting_data['site_name'],
					SITE_URL,
					$order_data_before_saved['first_name'],
					$order_data_before_saved['last_name'],
					$order_data_before_saved['name'],
					$order_data_before_saved['phone'],
					$order_data_before_saved['email'],
					$order_data_before_saved['address'],
					$order_data_before_saved['address2'],
					$order_data_before_saved['city'],
					$order_data_before_saved['state'],
					$order_data_before_saved['country'],
					$order_data_before_saved['postcode'],
					$order_data_before_saved['company_name'],
					$order_data_before_saved['order_id'],
					$order_data_before_saved['payment_method'],
					$order_data_before_saved['order_date'],
					$order_data_before_saved['approved_date'],
					$order_data_before_saved['expire_date'],
					replace_us_to_space($order_data_before_saved['order_status_name']),
					$order_data_before_saved['sales_pack'],
					format_date(date('Y-m-d H:i')).' '.format_time(date('Y-m-d H:i'),
					amount_fomat($total_of_order))
				);
	
				if(!empty($template_data) && $order_data_before_saved['email']!="") {
					$email_subject = str_replace($patterns,$replacements,$template_data['subject']);
					$email_body_text = str_replace($patterns,$replacements,$template_data['content']);
					send_email($order_data_before_saved['email'], $email_subject, $email_body_text, FROM_NAME, FROM_EMAIL);
				}
			}*/
		}
	}
	
	if($is_any_order_status_not_completed == "yes") {
		$msg = "Some Order(s) status is not completed so first please mark as completed.";
		if(count($removed_idd)=='1')
			$msg = "Order status is not completed so first please mark as completed.";
	} else {
		$msg = count($removed_idd)." Order(s) payment status successfully paid.";
		if(count($removed_idd)=='1')
			$msg = "Order payment status successfully paid.";
	}
	
	$_SESSION['success_msg']=$msg;
	if($post['order_mode'] == "unpaid") {
		setRedirect(CONTRACTOR_URL.'orders.php');
	} elseif($post['order_mode'] == "awaiting") {
		setRedirect(CONTRACTOR_URL.'awaiting_orders.php');
	} elseif($post['order_mode'] == "archive") {
		setRedirect(CONTRACTOR_URL.'archive_orders.php');
	} elseif($post['order_mode'] == "abandone") {
		setRedirect(CONTRACTOR_URL.'abandone_orders.php');
	} elseif($post['order_mode'] == "imei") {
		setRedirect(CONTRACTOR_URL.'search_by_imei_orders.php');
	} else {
		setRedirect(CONTRACTOR_URL.'paid_orders.php');
	}
	exit();
} elseif(isset($post['update'])) {
	$note=real_escape_string($post['note']);
	$status=real_escape_string($post['status']);

	$offer_accepted_order_status_id = get_order_status_data('order_status','offer-accepted')['data']['id'];
	$offer_rejected_order_status_id = get_order_status_data('order_status','offer-rejected')['data']['id'];

	if($status==$offer_accepted_order_status_id) {
		$offer_status=', offer_status="'.$status.'"';
	} elseif($status==$offer_rejected_order_status_id) {
		$offer_status=', offer_status="'.$status.'"';
	}

	if($order_id) {
		$data_q = mysqli_query($db,"SELECT * FROM orders WHERE order_id='".$order_id."'");
		$saved_ord_data = mysqli_fetch_assoc($data_q);
		if($status!="" && $saved_ord_data['status']!=$status) {
			$order_status_log_arr = array('order_id'=>$order_id,
										'item_id'=>'',
										'order_status'=>$status,
										'item_status'=>''
									);
			save_order_status_log($order_status_log_arr);
		}

		if($_FILES['image']['name']) {
			$image_ext = pathinfo($_FILES['image']['name'],PATHINFO_EXTENSION);
			if($image_ext=="png" || $image_ext=="jpg" || $image_ext=="jpeg" || $image_ext=="gif") {
				$image_tmp_name=$_FILES['image']['tmp_name'];
				$image_nm='o_f_a_'.date('YmdHis').'.'.$image_ext;
				$image_url = SITE_URL.'images/order/'.$image_nm;
				move_uploaded_file($image_tmp_name,'../../../images/order/'.$image_nm);
			} else {
				$msg="Image type must be png, jpg, jpeg, gif";
				$_SESSION['success_msg']=$msg;
				setRedirect(CONTRACTOR_URL.'edit_order.php?order_id='.$post['order_id'].'&order_mode='.$post['order_mode']);
				exit();
			}
		}

		$query=mysqli_query($db,'UPDATE orders SET status="'.$status.'", note="'.$note.'"'.$approved_date.$expire_date.$offer_status.' WHERE order_id="'.$order_id.'"');
		if($query=="1") {
			if($order_data_before_saved['unsubscribe'] == '0') {
				//Get order price based on orderID, path of this function (get_order_price) admin/include/functions.php
				$sum_of_orders=get_order_price($order_id);
				
				if($order_data_before_saved['promocode_id']>0 && $order_data_before_saved['promocode_amt']>0) {
					$promocode_amt = $order_data_before_saved['promocode_amt'];
					$discount_amt_label = "Surcharge:";
					if($order_data_before_saved['discount_type']=="percentage")
						$discount_amt_label = "Surcharge (".$order_data_before_saved['discount']."% of Initial Quote):";
					 
					$total_of_order = $sum_of_orders;
					$is_promocode_exist = true;
				} else {
					$total_of_order = $sum_of_orders;
				}
				
				$total = $total_of_order;
				if($is_promocode_exist) {
					$total = ($total_of_order+$promocode_amt);
				}
				
				$template_data = get_template_data('admin_reply_from_order');
				$general_setting_data = get_general_setting_data();
				$admin_user_data = get_admin_user_data();
				$order_data = get_order_data($order_id);
				
				$unsubscribe_token = get_big_unique_id();
				$unsubscribe_link = SITE_URL."unsubscribe/".$unsubscribe_token;
				
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
					'{$customer_company_name}',
					'{$order_id}',
					'{$order_payment_method}',
					'{$order_date}',
					'{$order_approved_date}',
					'{$order_expire_date}',
					'{$order_status}',
					'{$order_sales_pack}',
					'{$current_date_time}',
					'{$shipping_fname}',
					'{$shipping_lname}',
					'{$shipping_company_name}',
					'{$shipping_address1}',
					'{$shipping_address2}',
					'{$shipping_city}',
					'{$shipping_state}',
					'{$shipping_postcode}',
					'{$shipping_phone}',
					'{$dollars_spent_order}',
					'{$unsubscribe_link}');

				$replacements = array(
					$logo,
					$admin_logo,
					$admin_user_data['email'],
					$admin_user_data['username'],
					CONTRACTOR_URL,
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
					replace_us_to_space($order_data['order_status_name']),
					$order_data['sales_pack'],
					date('Y-m-d H:i'),
					$order_data['shipping_first_name'],
					$order_data['shipping_last_name'],
					$order_data['shipping_company_name'],
					$order_data['shipping_address'],
					$order_data['shipping_address2'],
					$order_data['shipping_city'],
					$order_data['shipping_state'],
					$order_data['shipping_postcode'],
					$order_data['shipping_phone'],
					amount_fomat($total),
					$unsubscribe_link);

				if(!empty($template_data)) {
					$attachment_data['basename'] = $image_nm;
					$attachment_data['folder'] = 'images/order';
	
					$email_subject = str_replace($patterns,$replacements,$template_data['subject']);
					$email_body_text = str_replace($patterns,$replacements,$post['note']);
					send_email($order_data['email'], $email_subject, $email_body_text, FROM_NAME, FROM_EMAIL, $attachment_data);

					$unsubsc_data_arr = array('user_id'=>$order_data['user_id'],
									'token'=>$unsubscribe_token);
					unsubscribe_user_tokens($unsubsc_data_arr);

					//START sms send to customer
					if($template_data['sms_status']=='1' && $sms_sending_status=='1') {
						$from_number = '+'.$general_setting_data['twilio_long_code'];
						$to_number = '+'.$order_data['phone'];
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
								$sms = $sms_api->account->messages->sendMessage($from_number, $to_number, $sms_body_text, $image_url, array('StatusCallback'=>''));
							} catch(Exception $e) {
								echo $sms_error_msg = $e->getMessage();
								error_log($sms_error_msg);
							}*/
						}
					} //END sms send to customer

					//START Save data in inbox_mail_sms table
					$inbox_mail_sms_data = array("template_id" => $template_data['id'],
							"staff_id" => $_SESSION['admin_id'],
							"user_id" => $order_data['user_id'],
							"order_id" => $order_data['order_id'],
							"from_email" => FROM_EMAIL,
							"to_email" => $order_data['email'],
							"subject" => $email_subject,
							"body" => $email_body_text,
							"sms_phone" => $to_number,
							"sms_content" => $sms_body_text,
							"date" => date("Y-m-d H:i:s"),
							"leadsource" => 'website',
							"form_type" => 'change_order_status');
					
					save_inbox_mail_sms($inbox_mail_sms_data);
					//END Save data in inbox_mail_sms table

				}
			}
			
			$msg="Order has been successfully updated.";
			$_SESSION['success_msg']=$msg;
		} else {
			$msg='Sorry! something wrong updation failed.';
			$_SESSION['error_msg']=$msg;
		}
		setRedirect(CONTRACTOR_URL.'edit_order.php?order_id='.$post['order_id'].'&order_mode='.$post['order_mode']);
		exit();
	}
} elseif(isset($post['save'])) {
	$order_id = $post['order_id'];
	$item_id = $post['item_id'];
	$transaction_id=real_escape_string($post['transaction_id']);
	$check_number=real_escape_string($post['check_number']);
	$bank_name=real_escape_string($post['bank_name']);
	$is_payment_sent = $post['is_payment_sent'];
	$payment_paid_amount=real_escape_string($post['payment_paid_amount']);
	$payment_paid_method=real_escape_string($post['payment_paid_method']);
	$payment_paid_date=real_escape_string($post['payment_paid_date']);
	$payment_paid_note=real_escape_string($post['payment_paid_note']);

	$exp_payment_paid_date = explode("/",$payment_paid_date);
	$payment_paid_date = $exp_payment_paid_date['2'].'-'.$exp_payment_paid_date['0'].'-'.$exp_payment_paid_date['1'];

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
			setRedirect(CONTRACTOR_URL.'edit_order.php?order_id='.$order_id.'&order_mode='.$post['order_mode']);
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
			setRedirect(CONTRACTOR_URL.'edit_order.php?order_id='.$order_id.'&order_mode='.$post['order_mode']);
			exit();
		}
	}

	mysqli_query($db,"INSERT INTO order_payment_log(order_id, item_id, transaction_id, paid_amount, payment_date, payment_receipt, additional_note, cheque_photo, check_number, bank_name, date) values('".$order_id."','".$item_id."','".$transaction_id."','".$payment_paid_amount."','".$payment_paid_date."','".$payment_receipt."','".$payment_paid_note."','".$cheque_photo."','".$check_number."','".$bank_name."','".date('Y-m-d H:i:s')."')");

	$query = mysqli_query($db,'UPDATE orders SET transaction_id="'.$transaction_id.'", check_number="'.$check_number.'", bank_name="'.$bank_name.'", is_payment_sent="'.$is_payment_sent.'", payment_paid_amount="'.$payment_paid_amount.'", payment_paid_method="'.$payment_paid_method.'", payment_paid_date="'.$payment_paid_date.'", payment_paid_note="'.$payment_paid_note.'" '.$img_payment_receipt.$img_cheque_photo.' WHERE order_id="'.$order_id.'"');
	if($query=="1") {
		$msg="Successfully saved.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong updation failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(CONTRACTOR_URL.'edit_order.php?order_id='.$order_id.'&order_mode='.$post['order_mode']);
	exit();
} elseif($post['d_p_i_id']) {
	if($post['mode']=="payment_receipt") {
		mysqli_query($db,"UPDATE orders SET payment_receipt='' WHERE order_id='".$post['d_p_i_id']."'");
	} elseif($post['mode']=="cheque_photo") {
		mysqli_query($db,"UPDATE orders SET cheque_photo='' WHERE order_id='".$post['d_p_i_id']."'");
	}
	
	setRedirect(CONTRACTOR_URL.'edit_order.php?order_id='.$post['d_p_i_id'].'&order_mode='.$post['order_mode']);
	exit();
} elseif(isset($post['sell_this_device'])) {
	$post = $_POST;
	//echo '<pre>';
	//print_r($post);
	//exit;

	$user_id = $post['user_id'];
	$order_id = $post['order_id'];
	$quantity = $post['quantity'];
	$req_model_id = $post['req_model_id'];
	$edit_item_id = $post['edit_item_id'];

	//Fetching data from model
	require_once('../../../models/model.php');

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

	/*$order_items_array = array();
	foreach($post as $key=>$val) {
		if($key=="oe_brand_id" || $key=="quantity" || $key=="sell_this_device" || $key=="oe_device_id" || $key=="oe_model_id" || $key=="payment_amt" || $key=="req_model_id" || $key=="device_id" || $key=="id" || $key=="PHPSESSID" || $key=="base_price" || $key=="edit_item_id" || $key=="order_id" || $key=="user_id") {
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
			$items_array[$exp_key[1]] = array('fld_name'=>str_replace("_"," ",$exp_key[0]),'fld_type'=>$product_fields_data['input_type'],'opt_data'=>$radio_items_array);
		} else {
			$items_array[$exp_key[1]] = array('fld_name'=>str_replace("_"," ",$exp_key[0]),'fld_type'=>$product_fields_data['input_type'],'opt_data'=>array(array('opt_id'=>$exp_val[1],'opt_name'=>$exp_val[0])));
		}
	}*/
	$order_items = json_encode($items_array);

	//if($quantity>0 && $order_id!="" && $edit_item_id>0) {
	if($quantity>0) {
		
		if($order_id=="") {
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
			
			$access_token = get_big_unique_id();
			mysqli_query($db,"INSERT INTO `orders`(`order_id`, `date`, `status`, `order_type`, `access_token`, expire_date) VALUES('".$order_id."','".date('Y-m-d H:i:s')."','".$initial_order_status_id."','admin','".$access_token."','".date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s")." +".$order_expired_days." day"))."')");

			$order_status_log_arr = array('order_id'=>$order_id,
										'item_id'=>'',
										'order_status'=>$initial_order_status_id,
										'item_status'=>''
									);
			save_order_status_log($order_status_log_arr);
			
			//START to assign contractor
			$admin_l_id = $_SESSION['contractor_id'];
			$ca_query=mysqli_query($db,"SELECT * FROM contractor_orders WHERE order_id='".$order_id."'");
			$contractor_appt_data = mysqli_fetch_assoc($ca_query);
			if(!empty($contractor_appt_data)) {
				$query=mysqli_query($db,"UPDATE contractor_orders SET contractor_id='".$admin_l_id."' WHERE order_id='".$order_id."'");
			} else {
				$query=mysqli_query($db,"INSERT INTO contractor_orders(contractor_id, date, order_id) VALUES('".$admin_l_id."','".date('Y-m-d H:i:s')."','".$order_id."')");
			} //END to assign contractor
		}

		$quantity_price = $post['payment_amt'];
		$item_price = ($quantity_price * $quantity);
		//$item_price = $quantity_price;

		$img_item_query = mysqli_query($db,"SELECT oi.* FROM order_items AS oi WHERE oi.id='".$edit_item_id."'");
		$img_item_data = mysqli_fetch_assoc($img_item_query);
		$svd_files_array = json_decode($img_item_data['images'],true);

		/*//START upload images
		$files_data = $_FILES;
		$json_files = "";
		$images_prm = "";
		$files_array = array();
		if(isset($files_data) && count($files_data)>0) {
			if(!file_exists('../../../images/order/'))
				mkdir('../../../images/order/',0777);

			foreach($_FILES as $key=>$val){
				$target_dir = "../../../images/order/";
				$filename = basename($files_data[$key]["name"]);
				$imageFileType = strtolower(pathinfo($filename,PATHINFO_EXTENSION));
				
				$exp_key = explode(":",$key);
				$exp_val = explode(":",$val);
				
				if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
					
				}

				$filename = date("YmdHis").rand(1111,9999).".".$imageFileType;
				$target_file = $target_dir.$filename;
	
				if(move_uploaded_file($files_data[$key]["tmp_name"], $target_file)) {
					//$files_array[$key] = $filename;
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

		if($edit_item_id>0) {
			$query = mysqli_query($db,"UPDATE `order_items` SET `device_id`='".$post['oe_device_id']."', `model_id`='".$req_model_id."', `price`='".$item_price."', `quantity`='".$quantity."', `quantity_price`='".$quantity_price."', `item_name`='".real_escape_string($order_items)."'".$upd_json_files." WHERE id='".$edit_item_id."'");
			
			mysqli_query($db,"INSERT INTO `order_items_price`(`price`, `item_id`, `date`) VALUES('".$item_price."','".$edit_item_id."','".date('Y-m-d H:i:s')."')");
		} else {
			$is_updated_in_existing_item = false;
			/*if(!empty($order_item_ids)) {
				$req_item_nm_array = $order_items;
				$order_item_query=mysqli_query($db,"SELECT oi.* FROM order_items AS oi WHERE oi.order_id='".$order_id."'");
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
				$query=mysqli_query($db,"INSERT INTO `order_items`(`device_id`, `model_id`, `order_id`, `item_name`, `images`, `price`, `quantity`, `quantity_price`, status) VALUES('".$post['oe_device_id']."','".$req_model_id."','".$order_id."','".real_escape_string($order_items)."','".$json_files."','".$item_price."','".$quantity."','".$quantity_price."','".$initial_order_item_status_id."')");
				$last_insert_id = mysqli_insert_id($db);
				mysqli_query($db,"INSERT INTO `order_items_price`(`price`, `item_id`, `date`) VALUES('".$item_price."','".$last_insert_id."','".date('Y-m-d H:i:s')."')");
			}

			if($user_id>0) {
				$user_data = get_user_data($user_id);

				$shipping_first_name = $user_data['first_name'];
				$shipping_last_name = $user_data['last_name'];
				$shipping_company_name = $user_data['company_name'];
				$shipping_address = $user_data['address'];
				$shipping_address2 = $user_data['address2'];
				$shipping_city = $user_data['city'];
				$shipping_state = $user_data['state'];
				$shipping_country = $user_data['country'];
				$shipping_postcode = $user_data['postcode'];
				$shipping_phone = $user_data['phone'];
				$shipping_phone_c_code = $user_data['country_code'];

				$payment_method_details = json_decode($user_data['payment_method_details'],true);
				$paypal_address = $payment_method_details['data']['paypal']['paypal_address'];
				$payment_method_details_arr = array('email_address'=>$paypal_address);
				$payment_method_details = json_encode($payment_method_details_arr);
				
				mysqli_query($db,"UPDATE `orders` SET `user_id`='".$user_id."',`shipping_first_name`='".$shipping_first_name."',`shipping_last_name`='".$shipping_last_name."',`shipping_company_name`='".$shipping_company_name."',`shipping_address1`='".$shipping_address."',`shipping_address2`='".$shipping_address2."',`shipping_city`='".$shipping_city."',`shipping_state`='".$shipping_state."',`shipping_country`='".$shipping_country."',`shipping_postcode`='".$shipping_postcode."',`shipping_phone`='".$shipping_phone."',`shipping_country_code`='".$shipping_phone_c_code."',`payment_method`='paypal',`payment_method_details`='".$payment_method_details."' WHERE order_id='".$order_id."'");
			}
		}

		$order_data = get_order_data($order_id);
		$sum_of_orders = get_order_price($order_id);
		if($order_data['discount_type'] == "percentage") {
			$discount = $order_data['discount'];
			$item_promo_total = ($sum_of_orders * $discount / 100);
			mysqli_query($db,"UPDATE `orders` SET `promocode_amt`='".$item_promo_total."' WHERE order_id='".$order_id."'");
		}
		
		$express_service = $order_data['express_service'];
		$express_service_price = $order_data['express_service_price'];
		$shipping_insurance = $order_data['shipping_insurance'];
		$shipping_insurance_per = $order_data['shipping_insurance_per'];
		
		$f_express_service_price = 0;
		$f_shipping_insurance_price = 0;
		if($express_service == '1') {
			mysqli_query($db,"UPDATE `orders` SET `express_service_price`='".$express_service_price."' WHERE order_id='".$order_id."'");
		}
		if($shipping_insurance == '1') {
			$f_shipping_insurance_price = ($sum_of_orders*$shipping_insurance_per/100);
			mysqli_query($db,"UPDATE `orders` SET `shipping_insurance_price`='".$f_shipping_insurance_price."', `shipping_insurance_per`='".$shipping_insurance_per."' WHERE order_id='".$order_id."'");
		}
		
		//Save Item ID of Order
		$i_f_query = mysqli_query($db,"SELECT oi.* FROM order_items AS oi WHERE oi.order_id='".$order_id."' ORDER BY oi.id ASC");
		while($order_item_data=mysqli_fetch_assoc($i_f_query)) {
			$itm_n = $itm_n+1;
			$order_item_id = $order_id.'/'.$itm_n;
			mysqli_query($db,"UPDATE `order_items` SET `order_item_id`='".$order_item_id."' WHERE id='".$order_item_data['id']."'");
		}
		
	}

	setRedirect(CONTRACTOR_URL.'edit_order.php?order_id='.$order_id.'&order_mode='.$post['order_mode']);
	exit();
} elseif(isset($post['update_order'])) {
	$order_id = $post['order_id'];
	foreach($post['status'] as $s_key => $status) {
		$item_status_name = '';
		$order_item_status_dt = get_order_status_data('order_item_status','',$status)['data'];
		$item_status_name = $order_item_status_dt['name'];
		$item_status_slug = $order_item_status_dt['slug'];

		$imageupdate = '';
		/*if($_FILES['image']['name'][$s_key]) {
			if(!file_exists('../../../images/order/items/'))
				mkdir('../../../images/order/items/',0777);

			$image_ext = pathinfo($_FILES['image']['name'][$s_key],PATHINFO_EXTENSION);
			if($image_ext=="png" || $image_ext=="jpg" || $image_ext=="jpeg" || $image_ext=="gif") {
				if($post['old_image'][$s_key]!="")
					unlink('../../../images/order/items/'.$post['old_image'][$s_key]);
	
				$image_tmp_name=$_FILES['image']['tmp_name'][$s_key];
				$image_name=date('YmdHis').'.'.$image_ext;
				$imageupdate=", image='".$image_name."'";
				move_uploaded_file($image_tmp_name,'../../../images/order/items/'.$image_name);
			} else {
				$msg="Image type must be png, jpg, jpeg, gif";
				$_SESSION['success_msg']=$msg;
				setRedirect(CONTRACTOR_URL.'edit_order.php?order_id='.$post['order_id']);
				exit();
			}
		}*/

		$price = $post['price'][$s_key];

		$data_q = mysqli_query($db,"SELECT oi.*, oi.status AS item_status, o.`status` AS order_status, o.`sales_pack`, o.promocode_id, o.promocode_amt FROM order_items AS oi LEFT JOIN orders AS o ON o.order_id=oi.order_id WHERE oi.id='".$s_key."'");
		$saved_item_data = mysqli_fetch_assoc($data_q);
		if($status!="" && $saved_item_data['status']!=$status) {
			mysqli_query($db,'UPDATE orders SET update_date="'.date("Y-m-d H:i:s").'" WHERE order_id="'.$order_id.'"');

			$order_status_log_arr = array('order_id'=>$order_id,
										'item_id'=>$s_key,
										'order_status'=>'',
										'item_status'=>$status,
										'item_price'=>$price
									);
			save_order_status_log($order_status_log_arr);
		}
		if($saved_item_data['price']>0 && $saved_item_data['price']!=$price) {
			mysqli_query($db,"INSERT INTO `order_items_price`(`price`, `item_id`, `date`) VALUES('".$price."','".$s_key."','".date('Y-m-d H:i:s')."')");
		}

		$imei_number = $post['imei_number'][$s_key];
		$query=mysqli_query($db,"UPDATE `order_items` SET `status`='".$status."', `price`='".$price."', `imei_number`='".$imei_number."'".$imageupdate." WHERE id='".$s_key."'");

		if($status!="" && $saved_item_data['status']!=$status) {
			$offer_accept_link = "";
			$offer_reject_link = "";
			$order_item_offer_token = get_big_unique_id();

			$price_is_reduced_order_item_status_id = get_order_status_data('order_item_status','price-is-reduced')['data']['id'];
			if($status == $price_is_reduced_order_item_status_id) {
				mysqli_query($db,"INSERT INTO `order_items_offer_token`(`item_id`, `token`) VALUES('".$s_key."','".$order_item_offer_token."')");
				$offer_accept_link = SITE_URL.'offer-status/'.$order_item_offer_token.'/accepted';
				$offer_reject_link = SITE_URL.'offer-status/'.$order_item_offer_token.'/rejected';
			}
			$order_item_tmpl_nm = 'order_item_status_'.str_replace('-','_',$item_status_slug).'_from_admin';
			$template_data = get_template_data($order_item_tmpl_nm);
			$general_setting_data = get_general_setting_data();
			$admin_user_data = get_admin_user_data();
			$order_data = get_order_data($order_id);

			$unsubscribe_token = get_big_unique_id();
			$unsubscribe_link = SITE_URL."unsubscribe/".$unsubscribe_token;
			
			$order_item_data = get_order_item($s_key, 'email');
			$order_item_name = $order_item_data['device_type'];
			
			$exp_order_item_id = explode('/',$saved_item_data['order_item_id']);
			
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
				'{$customer_company_name}',
				'{$order_id}',
				'{$order_payment_method}',
				'{$order_date}',
				'{$order_approved_date}',
				'{$order_expire_date}',
				'{$order_status}',
				'{$order_sales_pack}',
				'{$current_date_time}',
				'{$shipping_fname}',
				'{$shipping_lname}',
				'{$shipping_company_name}',
				'{$shipping_address1}',
				'{$shipping_address2}',
				'{$shipping_city}',
				'{$shipping_state}',
				'{$shipping_postcode}',
				'{$shipping_phone}',
				'{$dollars_spent_order}',
				'{$unsubscribe_link}',
				'{$order_item_id}',
				'{$order_item_status}',
				'{$order_item_name}',
				'{$order_item_prev_price}',
				'{$order_item_current_price}',
				'{$offer_accept_link}',
				'{$offer_reject_link}');
	
			$replacements = array(
				$logo,
				$admin_logo,
				$admin_user_data['email'],
				$admin_user_data['username'],
				CONTRACTOR_URL,
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
				replace_us_to_space($order_data['order_status_name']),
				$order_data['sales_pack'],
				date('Y-m-d H:i'),
				$order_data['shipping_first_name'],
				$order_data['shipping_last_name'],
				$order_data['shipping_company_name'],
				$order_data['shipping_address'],
				$order_data['shipping_address2'],
				$order_data['shipping_city'],
				$order_data['shipping_state'],
				$order_data['shipping_postcode'],
				$order_data['shipping_phone'],
				amount_fomat($total),
				$unsubscribe_link,
				'#'.$saved_item_data['id'],
				replace_us_to_space($item_status_name),
				$order_item_name,
				amount_fomat($saved_item_data['price']),
				amount_fomat($price),
				$offer_accept_link,
				$offer_reject_link);

			if(!empty($template_data)) {
				$attachment_data['basename'] = $image_nm;
				$attachment_data['folder'] = 'images/order';

				$email_subject = str_replace($patterns,$replacements,$template_data['subject']);
				$email_body_text = str_replace($patterns,$replacements,$template_data['content']);

				send_email($order_data['email'], $email_subject, $email_body_text, FROM_NAME, FROM_EMAIL, $attachment_data);

				$unsubsc_data_arr = array('user_id'=>$order_data['user_id'],
								'token'=>$unsubscribe_token);
				unsubscribe_user_tokens($unsubsc_data_arr);

				//START sms send to customer
				if($template_data['sms_status']=='1' && $sms_sending_status=='1') {
					$from_number = '+'.$general_setting_data['twilio_long_code'];
					$to_number = '+'.$order_data['phone'];
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
							$sms = $sms_api->account->messages->sendMessage($from_number, $to_number, $sms_body_text, $image_url, array('StatusCallback'=>''));
						} catch(Exception $e) {
							echo $sms_error_msg = $e->getMessage();
							error_log($sms_error_msg);
						}*/
					}
				} //END sms send to customer
			}
		}
	}	
	if($query == '1') {
		
		$order_data = get_order_data($order_id);
		$sum_of_orders = get_order_price($order_id);
		if($order_data['discount_type'] == "percentage") {
			$discount = $order_data['discount'];
			$item_promo_total = ($sum_of_orders * $discount / 100);
			mysqli_query($db,"UPDATE `orders` SET `promocode_amt`='".$item_promo_total."' WHERE order_id='".$order_id."'");
		}
		
		$express_service = $order_data['express_service'];
		$express_service_price = $order_data['express_service_price'];
		$shipping_insurance = $order_data['shipping_insurance'];
		$shipping_insurance_per = $order_data['shipping_insurance_per'];
		
		$f_express_service_price = 0;
		$f_shipping_insurance_price = 0;
		if($express_service == '1') {
			mysqli_query($db,"UPDATE `orders` SET `express_service_price`='".$express_service_price."' WHERE order_id='".$order_id."'");
		}
		if($shipping_insurance == '1') {
			$f_shipping_insurance_price = ($sum_of_orders*$shipping_insurance_per/100);
			mysqli_query($db,"UPDATE `orders` SET `shipping_insurance_price`='".$f_shipping_insurance_price."', `shipping_insurance_per`='".$shipping_insurance_per."' WHERE order_id='".$order_id."'");
		}
		
		$msg="Order has been successfully updated.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong updation failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(CONTRACTOR_URL.'edit_order.php?order_id='.$post['order_id'].'&order_mode='.$post['order_mode']);
	exit();
} elseif(isset($post['add_item_media'])) {
	$item_icon_array = array();
	if(!empty($_FILES['item_image']['name'])) {	
		foreach($_FILES['item_image']['name'] as $i_key=>$i_value) {
			if(trim($i_value)) {
				if(!file_exists('../../../images/order/items/'))
					mkdir('../../../images/order/items/',0777);
					
				$item_image_ext = pathinfo($i_value,PATHINFO_EXTENSION);
				if($item_image_ext=="png" || $item_image_ext=="jpg" || $item_image_ext=="jpeg" || $item_image_ext=="gif") {
					$item_image_tmp_name=$_FILES['item_image']['tmp_name'][$i_key];
					$item_icon=$i_key.date('YmdHis').'.'.$item_image_ext;
					move_uploaded_file($item_image_tmp_name,'../../../images/order/items/'.$item_icon);
				}
				$item_icon_array[] = $item_icon;
			}
		}
	}

	$order_id = $post['order_id'];
	$media_item_id = $post['media_item_id'];	

	$data_q = mysqli_query($db,"SELECT * FROM order_items WHERE id='".$media_item_id."'");
	$saved_item_data = mysqli_fetch_assoc($data_q);

	$images_from_shop = "";
	$videos_from_shop = "";
	if(!empty($post['item_video'])) {
		$s_item_videos_array = json_decode($saved_item_data['videos_from_shop'],true);
		if(!empty($s_item_videos_array)) {
			$videos_from_shop = json_encode(array_merge($post['item_video'],$s_item_videos_array));
		} else {
			$videos_from_shop = json_encode($post['item_video']);
		}
		$query = mysqli_query($db,"UPDATE `order_items` SET `videos_from_shop`='".$videos_from_shop."' WHERE id='".$media_item_id."'");
	}
	if(!empty($item_icon_array)) {
		$s_item_images_array = json_decode($saved_item_data['images_from_shop'],true);
		if(!empty($s_item_images_array)) {
			$images_from_shop = json_encode(array_merge($item_icon_array,$s_item_images_array));
		} else {
			$images_from_shop = json_encode($item_icon_array);
		}
		//$images_from_shop = json_encode($item_icon_array);
		$query = mysqli_query($db,"UPDATE `order_items` SET `images_from_shop`='".$images_from_shop."' WHERE id='".$media_item_id."'");
	}
	if($query == '1') {
		$msg="Media successfully updated.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong updation failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(CONTRACTOR_URL.'edit_order.php?order_id='.$post['order_id'].'&order_mode='.$post['order_mode']);
	exit();
} elseif(isset($post['add_item_chk_device'])) {
	//echo '<pre>';
	//print_r($post);
	//exit;
	
	$admin_l_id = $_SESSION['admin_id'];
	$prepare_for_testing = json_encode($post['prepare_for_testing'],true);
	$detailed_testing = json_encode($post['detailed_testing'],true);
	$order_id = $post['order_id'];
	$item_id = $post['chk_device_item_id'];
	
	$oit_q = mysqli_query($db,"SELECT * FROM order_item_testing WHERE item_id='".$item_id."'");
	$order_item_testing_data = mysqli_fetch_assoc($oit_q);
	$order_item_testing_id = $order_item_testing_data['id'];
	if($order_item_testing_id<=0) {
		$query = mysqli_query($db,"INSERT INTO `order_item_testing`(`staff_id`, `contractor_id`, `item_id`, `prepare_for_testing`, `detailed_testing`, `note`) VALUES('".$admin_l_id."','0','".$item_id."','".real_escape_string($prepare_for_testing)."','".real_escape_string($detailed_testing)."','".real_escape_string($post['note'])."')");
		$order_item_testing_id = mysqli_insert_id($db);
	} else {
		$query = mysqli_query($db,"UPDATE `order_item_testing` SET staff_id='".$admin_l_id."',contractor_id='0',prepare_for_testing='".real_escape_string($prepare_for_testing)."',detailed_testing='".real_escape_string($detailed_testing)."',note='".real_escape_string($post['note'])."' WHERE id='".$order_item_testing_id."'");
	}

/*echo '<pre>';
print_r($_FILES);
exit;*/

	$item_icon_array = array();
	if(!empty($_FILES['item_image']['name'])) {
		foreach($_FILES['item_image']['name'] as $i_key=>$i_value) {
			if(trim($i_value)) {
				if(!file_exists('../../../images/order/items/'))
					mkdir('../../../images/order/items/',0777);
					
				$item_image_ext = pathinfo($i_value,PATHINFO_EXTENSION);
				if($item_image_ext=="png" || $item_image_ext=="jpg" || $item_image_ext=="jpeg" || $item_image_ext=="gif") {
					$item_image_tmp_name=$_FILES['item_image']['tmp_name'][$i_key];
					$item_icon=str_replace(" ","_",$i_key).date('YmdHis').'.'.$item_image_ext;
					move_uploaded_file($item_image_tmp_name,'../../../images/order/items/'.$item_icon);
				}
				$item_icon_array[$i_key] = $item_icon;
			}
		}
	}
/*print_r($item_icon_array);
exit;*/

	$data_q = mysqli_query($db,"SELECT * FROM order_item_testing WHERE id='".$order_item_testing_id."'");
	$saved_item_data = mysqli_fetch_assoc($data_q);

	$images = "";
	$videos = "";
	if(!empty($post['item_video'])) {
		$s_item_videos_array = json_decode($saved_item_data['videos'],true);
		if(!empty($s_item_videos_array)) {
			$videos = json_encode(array_merge($post['item_video'],$s_item_videos_array));
		} else {
			$videos = json_encode($post['item_video']);
		}
		$query = mysqli_query($db,"UPDATE `order_item_testing` SET `videos`='".$videos."' WHERE id='".$order_item_testing_id."'");
	}
	if(!empty($item_icon_array)) {
		$s_item_images_array = json_decode($saved_item_data['images'],true);
		if(!empty($s_item_images_array)) {
			$images = json_encode(array_merge($s_item_images_array,$item_icon_array));
		} else {
			$images = json_encode($item_icon_array);
		}
		$query = mysqli_query($db,"UPDATE `order_item_testing` SET `images`='".$images."' WHERE id='".$order_item_testing_id."'");
	}
	if($query == '1') {
		$msg="Data successfully updated.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong updation failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(CONTRACTOR_URL.'edit_order.php?order_id='.$order_id.'&order_mode='.$post['order_mode']);
	exit();
} elseif(isset($post['d_item_img'])) {
	$data_q=mysqli_query($db,'SELECT * FROM order_items WHERE id="'.$post['d_item_img'].'"');
	$data=mysqli_fetch_assoc($data_q);
	$item_images_array = json_decode($data['images_from_shop'],true);
	$images_from_shop = json_encode(array_filter(array_diff($item_images_array,array($post['img']))));
	
	mysqli_query($db,"UPDATE order_items SET images_from_shop='".$images_from_shop."' WHERE id='".$post['d_item_img']."'");
	if($data['d_item_img']!="")
		unlink('../../../images/order/items/'.$post['img']);

	$msg="You have successfully deleted item image.";
	$_SESSION['success_msg']=$msg;

	setRedirect(CONTRACTOR_URL.'edit_order.php?order_id='.$post['order_id'].'&order_mode='.$post['order_mode']);
} elseif(isset($post['d_item_video'])) {
	$data_q=mysqli_query($db,'SELECT * FROM order_items WHERE id="'.$post['d_item_video'].'"');
	$data=mysqli_fetch_assoc($data_q);
	$item_videos_array = json_decode($data['videos_from_shop'],true);
	$videos_from_shop = json_encode(array_filter(array_diff($item_videos_array,array($post['img']))));

	mysqli_query($db,"UPDATE order_items SET videos_from_shop='".$videos_from_shop."' WHERE id='".$post['d_item_video']."'");
	if($data['d_item_video']!="")
		unlink('../../../images/order/items/'.$post['img']);

	$msg="You have successfully deleted item video.";
	$_SESSION['success_msg']=$msg;

	setRedirect(CONTRACTOR_URL.'edit_order.php?order_id='.$post['order_id'].'&order_mode='.$post['order_mode']);
} elseif(isset($post['d_chk_d_img'])) {
	$data_q=mysqli_query($db,'SELECT * FROM order_item_testing WHERE id="'.$post['d_chk_d_img'].'"');
	$data=mysqli_fetch_assoc($data_q);
	$item_images_array = json_decode($data['images'],true);
	$images = json_encode(array_filter(array_diff($item_images_array,array($post['img']))));
	
	mysqli_query($db,"UPDATE order_item_testing SET images='".$images."' WHERE id='".$post['d_chk_d_img']."'");
	if($data['d_chk_d_img']!="")
		unlink('../../../images/order/items/'.$post['img']);

	$msg="You have successfully deleted item image.";
	$_SESSION['success_msg']=$msg;
	$_SESSION['is_opn_check_device_pop'] = "yes";
	$_SESSION['sess_item_id'] = $data['item_id'];

	setRedirect(CONTRACTOR_URL.'edit_order.php?order_id='.$post['order_id'].'&order_mode='.$post['order_mode']);
} elseif(isset($post['d_chk_d_video'])) {
	$data_q=mysqli_query($db,'SELECT * FROM order_item_testing WHERE id="'.$post['d_chk_d_video'].'"');
	$data=mysqli_fetch_assoc($data_q);
	$item_videos_array = json_decode($data['videos'],true);
	$videos = json_encode(array_filter(array_diff($item_videos_array,array($post['img']))));

	mysqli_query($db,"UPDATE order_item_testing SET videos='".$videos."' WHERE id='".$post['d_chk_d_video']."'");
	if($data['d_chk_d_video']!="")
		unlink('../../../images/order/items/'.$post['img']);

	$msg="You have successfully deleted item video.";
	$_SESSION['success_msg']=$msg;
	$_SESSION['is_opn_check_device_pop'] = "yes";
	$_SESSION['sess_item_id'] = $data['item_id'];

	setRedirect(CONTRACTOR_URL.'edit_order.php?order_id='.$post['order_id'].'&order_mode='.$post['order_mode']);
} elseif(isset($post['upd_shipping_method'])) {
	$order_id = $post['order_id'];
	if($order_id) {
		$shipping_method = $post['shipping_method'];
		
		mysqli_query($db,"UPDATE orders SET sales_pack='".$shipping_method."' WHERE order_id='".$order_id."'");
	
		$msg="Sales pack option successfully updated.";
		$_SESSION['success_msg']=$msg;
		setRedirect(CONTRACTOR_URL.'edit_order.php?order_id='.$order_id.'&order_mode='.$post['order_mode']);
	} else {
		if($post['order_mode'] == "unpaid") {
			setRedirect(CONTRACTOR_URL.'orders.php');
		} elseif($post['order_mode'] == "awaiting") {
			setRedirect(CONTRACTOR_URL.'awaiting_orders.php');
		} elseif($post['order_mode'] == "archive") {
			setRedirect(CONTRACTOR_URL.'archive_orders.php');
		} elseif($post['order_mode'] == "abandone") {
			setRedirect(CONTRACTOR_URL.'abandone_orders.php');
		} else {
			setRedirect(CONTRACTOR_URL.'paid_orders.php');
		}
	}
	exit;
} elseif(isset($post['pmt_change'])) {
	$order_id = $post['order_id'];
	if($order_id) {
	
		$act_name = $post['act_name'];
		$act_number = $post['act_number'];
		$act_short_code = $post['act_short_code'];
		$paypal_address = $post['paypal_address'];
		$venmo_email_address = $post['venmo_email_address'];
		$zelle_email_address = $post['zelle_email_address'];
		$amazon_gcard_email_address = $post['amazon_gcard_email_address'];
		$cash_name = $post['cash_name'];
		$cash_phone = $post['cash_phone'];

		$payment_method_details_arr = array();
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
			$payment_method_details_arr = array('cash_name'=>$cash_name,'cash_phone'=>$cash_phone);
		}
		$payment_method_details = json_encode($payment_method_details_arr);

		$upt_order_query = mysqli_query($db,"UPDATE `orders` SET `payment_method`='".$post['payment_method']."', payment_method_details='".real_escape_string($payment_method_details)."' WHERE order_id='".$order_id."'");
		if($upt_order_query=='1') {
			$msg = "You have successfully updated payment method.";
			$_SESSION['success_msg']=$msg;
			setRedirect(CONTRACTOR_URL.'edit_order.php?order_id='.$order_id.'&order_mode='.$post['order_mode']);
		} else {
			$msg = "Something went wrong! Updation failed.";
			$_SESSION['error_msg']=$msg;
			setRedirect(CONTRACTOR_URL.'edit_order.php?order_id='.$order_id.'&order_mode='.$post['order_mode']);
		}
	} else {
		if($post['order_mode'] == "unpaid") {
			setRedirect(CONTRACTOR_URL.'orders.php');
		} elseif($post['order_mode'] == "awaiting") {
			setRedirect(CONTRACTOR_URL.'awaiting_orders.php');
		} elseif($post['order_mode'] == "archive") {
			setRedirect(CONTRACTOR_URL.'archive_orders.php');
		} elseif($post['order_mode'] == "abandone") {
			setRedirect(CONTRACTOR_URL.'abandone_orders.php');
		} else {
			setRedirect(CONTRACTOR_URL.'paid_orders.php');
		}
	}
	exit();
} elseif(isset($post['shipping_change'])) {
	$post = $_POST;
	$order_id = $post['order_id'];
	if($order_id=="") {
		$msg='Sorry! something wrong updation failed. Please try again.';
		$_SESSION['error_msg']=$msg;
		setRedirect(CONTRACTOR_URL.'edit_order.php?order_id='.$order_id.'&order_mode='.$post['order_mode']);
	} else {
		$shipping_first_name = $post['shipping_first_name'];
		$shipping_last_name = $post['shipping_last_name'];
		$shipping_company_name = $post['shipping_company_name'];
		$shipping_address = $post['shipping_address'];
		$shipping_address2 = $post['shipping_address2'];
		$shipping_city = $post['shipping_city'];
		$shipping_state = $post['shipping_state'];
		$shipping_postcode = $post['shipping_postcode'];
		$shipping_phone = $post['shipping_phone'];
		$shipping_phone_c_code = $post['shipping_phone_c_code'];
	
		$query = mysqli_query($db,"UPDATE `orders` SET `shipping_first_name`='".$shipping_first_name."',`shipping_last_name`='".$shipping_last_name."',`shipping_company_name`='".$shipping_company_name."',`shipping_address1`='".$shipping_address."',`shipping_address2`='".$shipping_address2."',`shipping_city`='".$shipping_city."',`shipping_state`='".$shipping_state."',`shipping_postcode`='".$shipping_postcode."',`shipping_phone`='".$shipping_phone."',`shipping_country_code`='".$shipping_phone_c_code."' WHERE order_id='".$order_id."'");
		if($query == '1') {
			$msg="Shipping info successfully saved.";
			$_SESSION['success_msg']=$msg;
		} else {
			$msg='Sorry! something wrong updation failed.';
			$_SESSION['error_msg']=$msg;
		}
		setRedirect(CONTRACTOR_URL.'edit_order.php?order_id='.$order_id.'&order_mode='.$post['order_mode']);
	}
	exit();
} elseif($post['remove_item_id']>0) {
	$remove_item_id = $post['remove_item_id'];
	$order_id = $post['order_id'];
	$query = mysqli_query($db,"DELETE FROM `order_items` WHERE id='".$remove_item_id."'");
	if($query == '1') {
		$order_data = get_order_data($order_id);
		$sum_of_orders = get_order_price($order_id);
		if($order_data['discount_type'] == "percentage") {
			$discount = $order_data['discount'];
			$item_promo_total = ($sum_of_orders * $discount / 100);
			mysqli_query($db,"UPDATE `orders` SET `promocode_amt`='".$item_promo_total."' WHERE order_id='".$order_id."'");
		}
		
		$express_service = $order_data['express_service'];
		$express_service_price = $order_data['express_service_price'];
		$shipping_insurance = $order_data['shipping_insurance'];
		$shipping_insurance_per = $order_data['shipping_insurance_per'];
		
		$f_express_service_price = 0;
		$f_shipping_insurance_price = 0;
		if($express_service == '1') {
			mysqli_query($db,"UPDATE `orders` SET `express_service_price`='".$express_service_price."' WHERE order_id='".$order_id."'");
		}
		if($shipping_insurance == '1') {
			$f_shipping_insurance_price = ($sum_of_orders*$shipping_insurance_per/100);
			mysqli_query($db,"UPDATE `orders` SET `shipping_insurance_price`='".$f_shipping_insurance_price."', `shipping_insurance_per`='".$shipping_insurance_per."' WHERE order_id='".$order_id."'");
		}

		$msg = "Item has been successfully removed.";
		$_SESSION['success_msg'] = $msg;
	} else {
		$msg = "Something went wrong!";
		$_SESSION['success_msg'] = $msg;
	}
	setRedirect(CONTRACTOR_URL.'edit_order.php?order_id='.$order_id.'&order_mode='.$post['order_mode']);
	exit();
} elseif(isset($post['assign_to_contractor'])) {
	$order_id=$post['order_id'];
	$contractor_id=$post['contractor_id'];
	$amount=$post['amount'];
	if($order_id) {
		$ca_query=mysqli_query($db,"SELECT * FROM contractor_orders WHERE order_id='".$order_id."'");
		$contractor_appt_data = mysqli_fetch_assoc($ca_query);
		if(!empty($contractor_appt_data)) {
			$query=mysqli_query($db,"UPDATE contractor_orders SET contractor_id='".$contractor_id."', amount='".$amount."' WHERE order_id='".$order_id."'");
		} else {
			$query=mysqli_query($db,"INSERT INTO contractor_orders(contractor_id, amount, date, order_id) VALUES('".$contractor_id."','".$amount."','".date('Y-m-d H:i:s')."','".$order_id."')");
		}
		if($query=="1") {
			$msg="This order successfully assigned to contractor.";
			$_SESSION['success_msg']=$msg;
		} else {
			$msg='Sorry! something wrong updation/add failed.';
			$_SESSION['error_msg']=$msg;
		}
		setRedirect(CONTRACTOR_URL.'edit_order.php?order_id='.$order_id.'&order_mode='.$post['order_mode']);
		exit();
	}
} else {
	if($post['order_mode'] == "unpaid") {
		setRedirect(CONTRACTOR_URL.'orders.php');
	} elseif($post['order_mode'] == "awaiting") {
		setRedirect(CONTRACTOR_URL.'awaiting_orders.php');
	} elseif($post['order_mode'] == "archive") {
		setRedirect(CONTRACTOR_URL.'archive_orders.php');
	} elseif($post['order_mode'] == "abandone") {
		setRedirect(CONTRACTOR_URL.'abandone_orders.php');
	} else {
		setRedirect(CONTRACTOR_URL.'paid_orders.php');
	}
	exit;
}
?>