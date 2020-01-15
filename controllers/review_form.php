<?php
require_once("../admin/_config/config.php");
require_once("../admin/include/functions.php");

if(isset($post['submit_form'])) {
	$name=real_escape_string($post['name']);
	$email=real_escape_string($post['email']);
	$country=real_escape_string($post['country']);
	$state=real_escape_string($post['state']);
	$city=real_escape_string($post['city']);
	$rating=real_escape_string($post['rating']);
	$title=real_escape_string($post['title']);
	$content=real_escape_string($post['content']);
	
	$valid_csrf_token = verifyFormToken('review');
	if($valid_csrf_token!='1') {
		writeHackLog('review');
		$msg = "Invalid Token";
		setRedirectWithMsg($return_url,$msg,'warning');
		exit();
	}
		
	if($write_review_form_captcha == '1') {
		$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$captcha_secret."&response=".$post['g-recaptcha-response']);
		$response = json_decode($response, true);
		if($response["success"] !== true) {
			$msg = "Invalid captcha";
			setRedirectWithMsg($return_url,$msg,'warning');
			exit();
		}
	}
	
	if($name && $state && $email && $city && $rating && $title && $content) {

		if($_FILES['image']['name']) {
			if(!file_exists('../images/review/'))
				mkdir('../images/review/',0777);

			$image_ext = pathinfo($_FILES['image']['name'],PATHINFO_EXTENSION);
			if($image_ext=="png" || $image_ext=="jpg" || $image_ext=="jpeg" || $image_ext=="gif") {
				if($post['old_image']!="")
					unlink('../images/review/'.$post['old_image']);

				$image_tmp_name=$_FILES['image']['tmp_name'];
				$image_name=date('YmdHis').'.'.$image_ext;
				$imageupdate=', photo="'.$image_name.'"';
				move_uploaded_file($image_tmp_name,'../images/review/'.$image_name);
			} else {
				$msg="Image type must be png, jpg, jpeg, gif";
				setRedirectWithMsg($return_url,$msg,'danger');
				exit();
			}
		}

		$query=mysqli_query($db,"INSERT INTO reviews(name, email, country, state, city, stars, title, content, date, photo) VALUES('".$name."','".$email."','".$country."','".$state."','".$city."','".$rating."','".$title."','".$content."','".date('Y-m-d H:i:s')."','".$image_name."')");
		$last_insert_id = mysqli_insert_id($db);
		if($query=="1") {
			$template_data = get_template_data('review_form_alert');
			$template_data_to_customer = get_template_data('review_thank_you_email_to_customer');

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
				'{$stars}',
				'{$form_title}',
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
				$post['rating'],
				$post['title'],
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

			$msg="Thank you for submitting a review of our business.";
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