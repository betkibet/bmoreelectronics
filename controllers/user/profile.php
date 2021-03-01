<?php
require_once("../../admin/_config/config.php");
require_once("../../admin/include/functions.php");
require_once("../common.php");

$user_id = $_SESSION['user_id'];
if($user_id<=0) {
	setRedirect(SITE_URL);
	exit();
}

if(isset($post['submit_form'])) {
	$first_name = real_escape_string($post['first_name']);
	$last_name = real_escape_string($post['last_name']);
	$email = real_escape_string($post['email']);
	$phone = preg_replace("/[^\d]/", "", $post['cell_phone']);
	$name = $first_name.' '.$last_name;
	$unsubscribe = $post['unsubscribe'];
	
	$company_name = real_escape_string($post['company_name']);
	$phone_c_code = $post['phone_c_code'];
	//$shipping_first_name = real_escape_string($post['shipping_first_name']);
	//$shipping_last_name = real_escape_string($post['shipping_last_name']);
	//$shipping_company_name = real_escape_string($post['shipping_company_name']);
	//$shipping_phone = preg_replace("/[^\d]/", "", $post['shipping_phone']);
	//$shipping_phone_c_code = $post['shipping_phone_c_code'];
	$use_shipping_adddress_prefilled = $post['use_shipping_adddress_prefilled'];
	$use_payment_method_prefilled = $post['use_payment_method_prefilled'];
	$email_preference_alert = $post['email_preference_alert'];
	$payment_method_details = real_escape_string(json_encode(array('my_payment_option'=>$post['payment_method'], 'data'=>$post['data'])));
	
	$valid_csrf_token = verifyFormToken('profile');
	if($valid_csrf_token!='1') {
		writeHackLog('profile');
		$msg = "Invalid Token";
		setRedirectWithMsg($return_url,$msg,'warning');
		exit();
	}
	
	if($first_name && $last_name && $email && $phone) {
		$get_userdata=mysqli_query($db,'SELECT * FROM users WHERE email="'.$email.'" AND id!="'.$post['id'].'" AND user_type="user"');
		$user_data=mysqli_fetch_assoc($get_userdata);
		if(!empty($user_data)) {
			$msg='This email address already used so please use different email address.';
			setRedirectWithMsg($return_url,$msg,'warning');
			exit();
		}

		if($_FILES['image']['name']) {
			if(!file_exists('../../images/avatar/'))
				mkdir('../../images/avatar/',0777);

			$image_ext = pathinfo($_FILES['image']['name'],PATHINFO_EXTENSION);
			if($image_ext=="png" || $image_ext=="jpg" || $image_ext=="jpeg" || $image_ext=="gif") {
				if($post['old_image']!="")
					unlink('../../images/avatar/'.$post['old_image']);

				$image_tmp_name=$_FILES['image']['tmp_name'];
				$image_name=date('YmdHis').'.'.$image_ext;
				$imageupdate=", image='".$image_name."'";
				move_uploaded_file($image_tmp_name,'../../images/avatar/'.$image_name);
			} else {
				$msg = "Image type must be png, jpg, jpeg, gif";
				setRedirect($return_url,$msg,'danger');
				exit();
			}
		}
		
				//,`shipping_first_name`='".$shipping_first_name."',`shipping_last_name`='".$shipping_last_name."',`shipping_company_name`='".$shipping_company_name."',`shipping_phone`='".$shipping_phone."',`shipping_country_code`='".$shipping_phone_c_code."'
		$query=mysqli_query($db,"UPDATE `users` SET `unsubscribe`='".$unsubscribe."',`name`='".$name."',`first_name`='".$first_name."',`last_name`='".$last_name."',`phone`='".$phone."',`email`='".$email."',`address`='".real_escape_string($post['address'])."',`address2`='".real_escape_string($post['address2'])."',`city`='".real_escape_string($post['city'])."',`state`='".real_escape_string($post['state'])."',`postcode`='".real_escape_string($post['postcode'])."',`username`='".$email."',`update_date`='".date('Y-m-d H:i:s')."',`company_name`='".$company_name."',`country_code`='".$phone_c_code."',`use_shipping_adddress_prefilled`='".$use_shipping_adddress_prefilled."',`use_payment_method_prefilled`='".$use_payment_method_prefilled."',`email_preference_alert`='".$email_preference_alert."',`payment_method_details`='".$payment_method_details."'".$imageupdate." WHERE id='".$post['id']."'");
		if($query=="1") {
			
			if($post['profl_password']!="" && $post['profl_password']==$post['profl_password2']) {
				$query=mysqli_query($db,"UPDATE `users` SET `password`='".md5($post['profl_password'])."' WHERE id='".$post['id']."'");
				if($query=="1") {
					unset($_SESSION['login_user']);
					unset($_SESSION['user_id']);
					$msg = 'Password has been successfully changed';
					setRedirectWithMsg($return_url,$msg,'success');
					exit();
				}
			} elseif($post['profl_password']!="") {
				$msg = 'New password and confirm password not matched.';
				setRedirectWithMsg($return_url,$msg,'warning');
				exit();
			}
			
			$msg = 'Customer profile has been successfully updated';
			setRedirectWithMsg($return_url,$msg,'success');
			exit();
		} else {
			$msg = 'Something went wrong! Updation failed so please try again OR contact with support team.';
			setRedirectWithMsg($return_url,$msg,'warning');
			exit();
		}
	}
} elseif($post['remove_av_id']) {
	$query=mysqli_query($db,'SELECT image FROM users WHERE id="'.$post['remove_av_id'].'"');
	$user_data=mysqli_fetch_assoc($query);

	$del_logo=mysqli_query($db,'UPDATE users SET image="" WHERE id='.$post['remove_av_id']);
	if($user_data['image']!="")
		unlink('../../images/avatar/'.$user_data['image']);

	$msg = 'Avatar has been successfully updated';
	setRedirectWithMsg($return_url,$msg,'success');
	exit();
} else {
	$msg='Direct access denied';
	setRedirectWithMsg(SITE_URL,$msg,'danger');
	exit();
} ?>