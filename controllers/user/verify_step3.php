<?php
require_once("../../admin/_config/config.php");
require_once("../../admin/include/functions.php");

$user_id = $post['user_id'];
if(isset($post['submit_form'])) {
	$valid_csrf_token = verifyFormToken('verify_step3_1');
	if($valid_csrf_token!='1') {
		writeHackLog('verify_step3_1');
		$msg = "Invalid Token";
		setRedirectWithMsg($return_url,$msg,'warning');
		exit();
	}
	
	$get_userdata=mysqli_query($db,"SELECT * FROM users WHERE MD5(id)='".$user_id."' AND verification_code='".$post['verification_code']."' AND verification_code!=''");
	$user_data=mysqli_fetch_assoc($get_userdata);
	if(empty($user_data)) {
		$msg='You have entered wrong verification code.';
		setRedirectWithMsg($return_url,$msg,'warning');
	} else {
		mysqli_query($db,"UPDATE `users` SET status='1', verification_code='' WHERE MD5(id)='".$user_id."'");
		$msg='Success! You have verified your email address.';
		
		$_SESSION['login_user'] = $user_data['username'];
		$_SESSION['user_id']=$user_data['id'];
		setRedirectWithMsg(SITE_URL.'revieworder?action=confirm',$msg,'success');
	}
	exit();
} elseif(isset($post['resend_veri'])) {
	$valid_csrf_token = verifyFormToken('verify_step3_2');
	if($valid_csrf_token!='1') {
		writeHackLog('verify_step3_2');
		$msg = "Invalid Token";
		setRedirectWithMsg($return_url,$msg,'warning');
		exit();
	}

	$get_userdata=mysqli_query($db,"SELECT * FROM users WHERE MD5(id)='".$user_id."'");
	$user_data=mysqli_fetch_assoc($get_userdata);
	$user_id=$user_data['id'];
	
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

	if(!empty($user_data) && $user_data['status']=='0') {
		mysqli_query($db,"UPDATE `users` SET `verification_type`='".$verification_type."',`verification_code`='".$verification_code."' WHERE id='".$user_id."'");

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
	
		$verification_link = SITE_URL.'/verify_step3/'.md5($user_id);
		$replacements = array(
			$logo,
			$admin_logo,
			$admin_user_data['email'],
			$admin_user_data['username'],
			ADMIN_URL,
			$general_setting_data['admin_panel_name'],
			$general_setting_data['from_name'],
			$general_setting_data['from_email'],
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
			$to_number = '+'.$user_data['phone'];
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
	}
} else {
	$msg='Direct access denied';
	setRedirectWithMsg(SITE_URL,$msg,'danger');
	exit();
} ?>