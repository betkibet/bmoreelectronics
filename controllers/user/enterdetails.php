<?php
require_once("../../admin/_config/config.php");
require_once("../../admin/include/functions.php");

$user_id = $_SESSION['user_id'];
$order_id=$_SESSION['order_id'];

//Get basket items data, count & sum of order
$basket_item_count_sum_data = get_basket_item_count_sum($order_id);

if(!$order_id || $basket_item_count_sum_data['basket_item_count']<=0) {
	setRedirect(SITE_URL.'revieworder');
	exit();
}

if(isset($post['submit_form'])) {
	
	$valid_csrf_token = verifyFormToken('enterdetails');
	if($valid_csrf_token!='1') {
		writeHackLog('enterdetails');
		$msg = "Invalid Token";
		setRedirectWithMsg($return_url,$msg,'warning');
		exit();
	}
	
	$email = real_escape_string($post['email']);
	$phone = preg_replace("/[^\d]/", "", real_escape_string($post['phone']));
	$name = real_escape_string($post['first_name']).' '.real_escape_string($post['last_name']);
	if($post['password']) {
		$password = md5($post['password']);
		$updt_password = ",`password`='".$password."'";
	}

	//START If already loggedin then update infor to existing userID
	if($user_id>0) {
		mysqli_query($db,"UPDATE `users` SET `name`='".$name."', `first_name`='".real_escape_string($post['first_name'])."',`last_name`='".real_escape_string($post['last_name'])."',`phone`='".$phone."',`email`='".$email."',`address`='".real_escape_string($post['address'])."',`address2`='".real_escape_string($post['address2'])."',`city`='".real_escape_string($post['city'])."',`state`='".real_escape_string($post['state'])."',country='".real_escape_string($post['country'])."',`postcode`='".real_escape_string($post['postcode'])."',`username`='".$email."'".$updt_password.",`status`='1',`date`='".date('Y-m-d H:i:s')."' WHERE id='".$user_id."'");
		setRedirect(SITE_URL.'revieworder?action=confirm');
		exit();
	} //END If already loggedin then update infor to existing userID

	$random_number = mt_rand(100000, 999999);
	$verification_type = "none";
	$verification_code = "";
	$is_verification = false;
	$status = 1;
	if($general_setting_data['verification']=="email" || $general_setting_data['verification']=="sms") {
		$verification_type = $general_setting_data['verification'];
		$verification_code = $random_number;
		$is_verification = true;
		$status = 0;
	}

	//START If not loggedin but this account exist then update infor to existing email based
	$get_userdata=mysqli_query($db,'SELECT * FROM users WHERE email="'.$post['email'].'"');
	$get_userdata_row=mysqli_fetch_assoc($get_userdata);
	$user_id=$get_userdata_row['id'];
	if(!empty($get_userdata_row) && $get_userdata_row['status']=='1') {
		mysqli_query($db,"UPDATE `users` SET `name`='".$name."', `first_name`='".real_escape_string($post['first_name'])."',`last_name`='".real_escape_string($post['last_name'])."',`phone`='".$phone."',`email`='".$email."',`address`='".real_escape_string($post['address'])."',`address2`='".real_escape_string($post['address2'])."',`city`='".real_escape_string($post['city'])."',`state`='".real_escape_string($post['state'])."',country='".real_escape_string($post['country'])."',`postcode`='".real_escape_string($post['postcode'])."',`username`='".$email."'".$updt_password.",`status`='1',`date`='".date('Y-m-d H:i:s')."' WHERE id='".$user_id."'");
		$_SESSION['login_user'] = $email;
		$_SESSION['user_id']=$get_userdata_row['id'];
		setRedirect(SITE_URL.'revieworder?action=confirm');
		exit();
	} //END If not loggedin but this account exist then update infor to existing email based
	elseif(!empty($get_userdata_row) && $get_userdata_row['status']=='0') {
		mysqli_query($db,"UPDATE `users` SET `name`='".$name."',`first_name`='".real_escape_string($post['first_name'])."',`last_name`='".real_escape_string($post['last_name'])."',`phone`='".$phone."',`email`='".$email."',`address`='".real_escape_string($post['address'])."',`address2`='".real_escape_string($post['address2'])."',`city`='".real_escape_string($post['city'])."',`state`='".real_escape_string($post['state'])."',`postcode`='".real_escape_string($post['postcode'])."',`username`='".$email."',password='".$password."',status='".$status."',`update_date`='".date('Y-m-d H:i:s')."',`verification_type`='".$verification_type."',`verification_code`='".$verification_code."' WHERE id='".$user_id."'");
		if($is_verification) {
			$template_data_for_email = get_template_data('signup_verification_for_email');
			$user_data = get_user_data($user_id);

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
				'{$current_date_time}',
				'{$verification_code}',
				'{$verification_link}',
				'{$admin_phone}');

			$verification_link = SITE_URL.'verify_account/'.md5($user_id);
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
				date('Y-m-d H:i'),
				$verification_code,
				$verification_link,
				$admin_user_data['phone']);

			//START email send to customer
			if(!empty($template_data_for_email) && $verification_type=="email") {
				$email_subject = str_replace($patterns,$replacements,$template_data_for_email['subject']);
				$email_body_text = str_replace($patterns,$replacements,$template_data_for_email['content']);

				send_email($user_data['email'], $email_subject, $email_body_text, FROM_NAME, FROM_EMAIL);
			} //END email send to customer

			//START sms send to customer
			if(!empty($template_data_for_email) && $verification_type=="sms" && $sms_sending_status=='1') {
				$from_number = '+'.$general_setting_data['twilio_long_code'];
				$to_number = '+'.$phone;
				if($from_number && $account_sid && $auth_token) {
					$sms_body_text = str_replace($patterns,$replacements,$template_data_for_email['sms_content']);
					try {
						$sms = $sms_api->account->messages->sendMessage($from_number, $to_number, $sms_body_text, $image, array('StatusCallback'=>''));
					} catch(Services_Twilio_RestException $e) {
						$sms_error_msg = $e->getMessage();
						error_log($sms_error_msg);
					}
				}
			} //END sms send to customer
			setRedirect(SITE_URL.'verify_step3/'.md5($user_id));
			exit();
		} else {
			$_SESSION['login_user'] = $username;
			$_SESSION['user_id']=$user_id;
			setRedirect(SITE_URL.'revieworder?action=confirm');
			exit();
		}
	} else {
		$query=mysqli_query($db,"INSERT INTO `users`(`name`, `first_name`, `last_name`, `phone`, `email`, `address`, `address2`, `city`, `state`, `postcode`, `username`, `password`, `status`, `date`, verification_type, verification_code) VALUES('".$name."', '".real_escape_string($post['first_name'])."','".real_escape_string($post['last_name'])."','".$phone."','".$email."','".real_escape_string($post['address'])."','".real_escape_string($post['address2'])."','".real_escape_string($post['city'])."','".real_escape_string($post['state'])."','".real_escape_string($post['postcode'])."','".$email."','".$password."','".$status."','".date('Y-m-d H:i:s')."','".$verification_type."','".$verification_code."')");
		if($query=="1") {
			$user_id = mysqli_insert_id($db);
			if($is_verification) {
				$template_data_for_email = get_template_data('signup_verification_for_email');
				$user_data = get_user_data($user_id);

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
					'{$current_date_time}',
					'{$verification_code}',
					'{$verification_link}',
					'{$admin_phone}');

				$verification_link = SITE_URL.'verify_account/'.md5($user_id);
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
					date('Y-m-d H:i'),
					$verification_code,
					$verification_link,
					$admin_user_data['phone']);

				//START email send to customer
				if(!empty($template_data_for_email) && $verification_type=="email") {
					$email_subject = str_replace($patterns,$replacements,$template_data_for_email['subject']);
					$email_body_text = str_replace($patterns,$replacements,$template_data_for_email['content']);

					send_email($user_data['email'], $email_subject, $email_body_text, FROM_NAME, FROM_EMAIL);
				} //END email send to customer

				//START sms send to customer
				if(!empty($template_data_for_email) && $verification_type=="sms" && $sms_sending_status=='1') {
					$from_number = '+'.$general_setting_data['twilio_long_code'];
					$to_number = '+'.$phone;
					if($from_number && $account_sid && $auth_token) {
						$sms_body_text = str_replace($patterns,$replacements,$template_data_for_email['sms_content']);
						try {
							$sms = $sms_api->account->messages->sendMessage($from_number, $to_number, $sms_body_text, $image, array('StatusCallback'=>''));
						} catch(Services_Twilio_RestException $e) {
							$sms_error_msg = $e->getMessage();
							error_log($sms_error_msg);
						}
					}
				} //END sms send to customer

				setRedirect(SITE_URL.'verify_step3/'.md5($user_id));
				exit();
			} else {
				$_SESSION['login_user'] = $username;
				$_SESSION['user_id']=$user_id;
				setRedirect(SITE_URL.'revieworder?action=confirm');
				exit();
			}
		}
	}
} else {
	$msg='Direct access denied';
	setRedirectWithMsg(SITE_URL,$msg,'danger');
	exit();
} ?>
