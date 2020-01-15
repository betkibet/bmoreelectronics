<?php
require_once("../admin/_config/config.php");
require_once("../admin/include/functions.php");

if(isset($post['submit_form'])) {
	$name=real_escape_string($post['name']);
	$phone=preg_replace("/[^\d]/", "", real_escape_string($post['phone']));
	$email=real_escape_string($post['email']);
	$company=real_escape_string($post['company']);
	$web_address=real_escape_string($post['web_address']);
	$subject=real_escape_string($post['subject']);
	$message=real_escape_string($post['message']);
	
	$valid_csrf_token = verifyFormToken('affiliate');
	if($valid_csrf_token!='1') {
		writeHackLog('affiliate');
		$msg = "Invalid Token";
		setRedirectWithMsg($return_url,$msg,'warning');
		exit();
	}

	if($affiliate_form_captcha == '1') {
		$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$captcha_secret."&response=".$post['g-recaptcha-response']);
		$response = json_decode($response, true);
		if($response["success"] !== true) {
			$msg = "Invalid captcha";
			setRedirectWithMsg($return_url,$msg,'warning');
			exit();
		}
	}
	
	if($name && $phone && $email) {
		$query=mysqli_query($db,"INSERT INTO affiliate(name, phone, email, company, web_address, subject, message, date) VALUES('".$name."','".$phone."','".$email."','".$company."','".$web_address."','".$subject."','".$message."','".date('Y-m-d H:i:s')."')");
		$last_insert_id = mysqli_insert_id($db);
		if($query=="1") {
			$template_data = get_template_data('affiliate_form_alert');
			
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
				'{$customer_fullname}',
				'{$customer_phone}',
				'{$customer_email}',
				'{$current_date_time}',
				'{$company_name}',
				'{$web_address}',
				'{$form_subject}',
				'{$form_message}',
				'{$item_name}');
	
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
				$post['name'],
				$post['phone'],
				$post['email'],
				date('Y-m-d H:i'),
				$post['company'],
				$post['web_address'],
				$post['subject'],
				$post['message'],
				$post['item_name']);
	
			if(!empty($template_data)) {
				$email_subject = str_replace($patterns,$replacements,$template_data['subject']);
				$email_body_text = str_replace($patterns,$replacements,$template_data['content']);
	
				send_email($admin_user_data['email'], $email_subject, $email_body_text, $post['name'], $post['email']);
			}
	
			$msg="Thank you for submitted affiliate. We'll contact you shortly.";
			setRedirectWithMsg($return_url,$msg,'success');
		} else {
			$msg='Sorry! something wrong updation failed.';
			setRedirectWithMsg($return_url,$msg,'danger');
		}
	} else {
		$msg='please fill in all required fields.';
		setRedirectWithMsg($return_url,$msg,'warning');
	}
	exit();
} else {
	$msg='Direct access denied';
	setRedirectWithMsg(SITE_URL,$msg,'danger');
	exit();
} ?>