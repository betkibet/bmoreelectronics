<?php
require_once("../admin/_config/config.php");
require_once("../admin/include/functions.php");

if(isset($post['submit_form'])) {
	
	$valid_csrf_token = verifyFormToken('bulk_order');
	if($valid_csrf_token!='1') {
		writeHackLog('bulk_order');
		$msg = "Invalid Token";
		setRedirectWithMsg($return_url,$msg,'warning');
		exit();
	}
	
	if($bulk_order_form_captcha == '1') {
		$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$captcha_secret."&response=".$post['g-recaptcha-response']);
		$response = json_decode($response, true);
		if($response["success"] !== true) {
			$msg = "Invalid captcha";
			setRedirectWithMsg($return_url,$msg,'warning');
			exit();
		}
	}
	
	$name=real_escape_string($post['name']);
	$email=real_escape_string($post['email']);
	$country=real_escape_string($post['country']);
	$state=real_escape_string($post['state']);
	$city=real_escape_string($post['city']);
	$zip_code=real_escape_string($post['zip_code']);
	$company_name=real_escape_string($post['company_name']);
	$content=real_escape_string($post['content']);
	$imp_devices=implode(", ",$post['devices']);
	if($name && $state && $email && $city && $zip_code && $company_name && $content) {
		$query=mysqli_query($db,"INSERT INTO bulk_order_form(name, email, country, state, city, zip_code, devices, company_name, content, date) VALUES('".$name."','".$email."','".$country."','".$state."','".$city."','".$zip_code."','".$imp_devices."','".$company_name."','".$content."','".date('Y-m-d H:i:s')."')");
		$last_insert_id = mysqli_insert_id($db);
		if($query=="1") {
			$template_data = get_template_data('bulk_order_form_alert');
			$template_data_to_customer = get_template_data('bulk_order_thank_you_email_to_customer');

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
				'{$customer_email}',
				'{$country}',
				'{$state}',
				'{$city}',
				'{$zip_code}',
				'{$company_name}',
				'{$devices}',
				'{$form_message}');

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
				$post['email'],
				$post['country'],
				$post['state'],
				$post['city'],
				$post['zip_code'],
				$post['company_name'],
				$imp_devices,
				$post['content']);

			if(!empty($template_data)) {
				$email_subject = str_replace($patterns,$replacements,$template_data['subject']);
				$email_body_text = str_replace($patterns,$replacements,$template_data['content']);
				send_email($admin_user_data['email'], $email_subject, $email_body_text, $post['name'], $post['email']);
			}

			//START email send to customer
			if(!empty($template_data_to_customer)) {
				$email_subject = str_replace($patterns,$replacements,$template_data_to_customer['subject']);
				$email_body_text = str_replace($patterns,$replacements,$template_data_to_customer['content']);
				send_email($post['email'], $email_subject, $email_body_text, FROM_NAME, FROM_EMAIL);
			} //END email send to customer

			$msg="Thank you contacting us for bulk order. We'll contact you shortly.";
			setRedirectWithMsg($return_url,$msg,'success');
		} else {
			$msg='Sorry, something went wrong';
			setRedirectWithMsg($return_url,$msg,'danger');
		}	
	} else {
		$msg='Please fill in all required fields.';
		setRedirectWithMsg($return_url,$msg,'warning');
	}
	exit();
} else {
	$msg='Direct access denied';
	setRedirectWithMsg(SITE_URL,$msg,'danger');
	exit();
} ?>