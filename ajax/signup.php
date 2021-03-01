<?php
require_once("../admin/_config/config.php");
require_once("../admin/include/functions.php");
require_once("common.php");

$response = array();
$post = $_POST;
$login_link = SITE_URL.get_inbuild_page_url('login');
if(isset($post['submit_form'])) {
	if($post['email']) {
		$datetime = date('Y-m-d H:i:s');
		$is_guest = $post['is_guest'];
		$email = real_escape_string($post['email']);
		$signup_cell_phone = ($post['signup_cell_phone']?$post['signup_cell_phone']:$post['cell_phone']);
		$signup_phone_c_code = ($post['signup_phone_c_code']?$post['signup_phone_c_code']:$post['phone_c_code']);
		$phone = preg_replace("/[^\d]/", "", real_escape_string($signup_cell_phone));
		$password = md5($post['password']);
		$name = real_escape_string($post['first_name']).' '.real_escape_string($post['last_name']);

		/*$valid_csrf_token = verifyFormToken('signup');
		if($valid_csrf_token!='1') {
			writeHackLog('signup');
			$msg = "Invalid Token";
			$response = array('msg'=>$msg, 'status'=>'invalid');
			echo json_encode($response);
			exit();
		}*/

		if($signup_form_captcha == '1') {
			$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$captcha_secret."&response=".$post['g-recaptcha-response']);
			$response = json_decode($response, true);
			if($response["success"] !== true) {
				$msg = '<div class="alert alert-warning alert-dismissable">Invalid captcha</div>';
				$response = array('msg'=>$msg, 'status'=>'invalid');
				echo json_encode($response);
				exit();
			}
		}

		if($is_guest == '1') {
			$guest_user_id = $_SESSION['guest_user_id'];
			if($guest_user_id>0) {
				mysqli_query($db,"UPDATE `users` SET `name`='".$name."',`first_name`='".$first_name."',`last_name`='".$last_name."',`phone`='".$phone."',`country_code`='".$phone_c_code."',`email`='".$email."',`username`='".$email."',status='1',`update_date`='".$datetime."',`user_type`='guest' WHERE id='".$guest_user_id."'");
			} else {
				mysqli_query($db,"INSERT INTO `users`(`name`, `first_name`, `last_name`, `phone`, `country_code`, `email`, `username`, `status`, `date`, `user_type`) VALUES('".$name."', '".$first_name."','".$last_name."','".$phone."','".$phone_c_code."','".$email."','".$email."','1','".$datetime."','guest')");
				$guest_user_id = mysqli_insert_id($db);
			}
			$_SESSION['guest_user_id']=$guest_user_id;
			$_SESSION['open_shipping_popup'] = true;
			
			$msg = '<div class="alert alert-success alert-dismissable">Your account is successfully created</div>';
			$response = array('msg'=>$msg, 'status'=>'success_guest');
			echo json_encode($response);
			exit();
		} else {
			
			$exist_u_q=mysqli_query($db,"SELECT * FROM users WHERE email='".$post['email']."' AND user_type='user'");
			$exist_user_data=mysqli_fetch_assoc($exist_u_q);
			$user_id = $exist_user_data['id'];
			if(!empty($exist_user_data) && $exist_user_data['status']=='1') {
				$msg='Email address already used. Sign-in or try another email.';
				$response = array('msg'=>'<div class="alert alert-info alert-dismissable">'.$msg.'</div>', 'status'=>'invalid');
				echo json_encode($response);
				exit();
			}
	
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
			
			if(!empty($exist_user_data) && $exist_user_data['status']=='0') {
				$query=mysqli_query($db,"UPDATE `users` SET `name`='".$name."',`first_name`='".real_escape_string($post['first_name'])."',`last_name`='".real_escape_string($post['last_name'])."',`phone`='".$phone."',`country_code`='".$signup_phone_c_code."',`email`='".$email."',`username`='".$email."',password='".$password."',status='".$status."',`update_date`='".$datetime."',`verification_type`='".$verification_type."',`verification_code`='".$verification_code."' WHERE id='".$user_id."'");
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
						'{$billing_address1}',
						'{$billing_address2}',
						'{$billing_city}',
						'{$billing_state}',
						'{$customer_country}',
						'{$billing_postcode}',
						'{$current_date_time}',
						'{$verification_code}',
						'{$verification_link}',
						'{$admin_phone}');
	
					$verification_link = SITE_URL.'verify_account/'.md5($user_id).'/'.$verification_code;
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
						format_date(date('Y-m-d H:i')).' '.format_time(date('Y-m-d H:i')),
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
						if($from_number && $account_sid && $auth_token && $phone) {
							$sms_body_text = str_replace($patterns,$replacements,$template_data_for_email['sms_content']);
							try {
								$sms = $sms_api->account->messages->sendMessage($from_number, $to_number, $sms_body_text, $image, array('StatusCallback'=>''));
							} catch(Services_Twilio_RestException $e) {
								$sms_error_msg = $e->getMessage();
								error_log($sms_error_msg);
							}
						}
					} //END sms send to customer
	
					$msg='<div class="alert alert-success alert-dismissable">You have successfully re-send verification code.</div>';
					$response = array('msg'=>$msg, 'status'=>'resend', 'user_id'=>$user_id);
				} else {
					$msg='<div class="alert alert-success alert-dismissable">Your account is successfully created</div>';
					$response = array('msg'=>$msg, 'status'=>'success');
				}
				echo json_encode($response);
				exit();
			} else {
				$query=mysqli_query($db,"INSERT INTO `users`(`name`, `first_name`, `last_name`, `phone`, country_code, `email`, `username`, `password`, `status`, `date`, verification_type, verification_code) VALUES('".$name."', '".real_escape_string($post['first_name'])."','".real_escape_string($post['last_name'])."','".$phone."','".$signup_phone_c_code."','".$email."','".$email."','".$password."','".$status."','".$datetime."','".$verification_type."','".$verification_code."')");
				if($query=="1") {
					if($is_verification) {
						$user_id = mysqli_insert_id($db);

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
							'{$billing_address1}',
							'{$billing_address2}',
							'{$billing_city}',
							'{$billing_state}',
							'{$customer_country}',
							'{$billing_postcode}',
							'{$current_date_time}',
							'{$verification_code}',
							'{$verification_link}',
							'{$admin_phone}');

						$verification_link = SITE_URL.'verify_account/'.md5($user_id).'/'.$verification_code;
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
							if($from_number && $account_sid && $auth_token && $phone) {
								$sms_body_text = str_replace($patterns,$replacements,$template_data_for_email['sms_content']);
								try {
									$sms = $sms_api->account->messages->sendMessage($from_number, $to_number, $sms_body_text, $image, array('StatusCallback'=>''));
								} catch(Services_Twilio_RestException $e) {
									$sms_error_msg = $e->getMessage();
									error_log($sms_error_msg);
								}
							}
						} //END sms send to customer
	
						$msg='<div class="alert alert-success alert-dismissable">You have successfully send verification code.</div>';
						$response = array('msg'=>$msg, 'status'=>'resend', 'user_id'=>$user_id);
					} else {
						$msg='<div class="alert alert-success alert-dismissable">Your account is successfully created</div>';
						$response = array('msg'=>$msg, 'status'=>'success');
					}
					echo json_encode($response);
					exit();
				} else {
					$msg='<div class="alert alert-error alert-dismissable">Something went wrong! User creation failed so please try again or contact with server guys.</div>';
					$response = array('msg'=>$msg, 'status'=>'invalid');
					echo json_encode($response);
					exit();
				}
			}
		}
	} else {
		$msg='<div class="alert alert-warning alert-dismissable">Please fill mandatory fields</div>';
		$response = array('msg'=>$msg, 'status'=>'invalid');
		echo json_encode($response);
		exit();
	}
} else {
	$msg='<div class="alert alert-error alert-dismissable">Direct access denied</div>';
	$response = array('msg'=>$msg, 'status'=>'invalid');
	echo json_encode($response);
	exit();
} ?>