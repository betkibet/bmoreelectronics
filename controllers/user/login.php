<?php
require_once("../../admin/_config/config.php");
require_once("../../admin/include/functions.php");

if(isset($post['submit_form'])) {

	$valid_csrf_token = verifyFormToken('login');
	if($valid_csrf_token!='1') {
		writeHackLog('login');
		$msg = "Invalid Token";
		setRedirectWithMsg($return_url,$msg,'warning');
		exit();
	}

	if($login_form_captcha == '1') {
		$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$captcha_secret."&response=".$post['g-recaptcha-response']);
		$response = json_decode($response, true);
		if($response["success"] !== true) {
			$msg = "Invalid captcha";
			setRedirectWithMsg($return_url,$msg,'warning');
			exit();
		}
	}
	
	$query="SELECT * FROM users WHERE username = '".$post['username']."' AND password != ''";
    $res=mysqli_query($db,$query);
	$fetch_userdata=mysqli_fetch_assoc($res);
    $checkUser=mysqli_num_rows($res);
	if($checkUser > 0 && $fetch_userdata['status'] == '0') {
	 	$msg='Sorry, your email address has not been verified yet. To re-send verification use the sign-up form.';
		setRedirectWithMsg($return_url,$msg,'warning');
		exit();
    } elseif($checkUser > 0 && $fetch_userdata['status'] == '1' && $fetch_userdata['password'] == md5($post['password'])) {
		$_SESSION['login_user'] = $fetch_userdata['username'];
		$_SESSION['user_id']=$fetch_userdata['id'];

		$redirect_url = SITE_URL.'account';
		$msg = 'YOU HAVE SUCCESSFULLY LOGGED IN';

		//Get basket items data, count & sum of order
		$order_id = $_SESSION['order_id'];
		if($order_id!="") {
			$basket_item_count_sum_data = get_basket_item_count_sum($order_id);
			if($basket_item_count_sum_data['basket_item_count']>0) {
				//$msg = 'YOU HAVE SUCCESSFULLY LOGGED IN';
				//$order_data = get_order_data($order_id);
				$redirect_url = SITE_URL.'revieworder';
			}
		}

		setRedirectWithMsg($redirect_url,$msg,'success');
		exit();
    } else {
		$msg='Please enter correct login details';
		setRedirectWithMsg($return_url,$msg,'warning');
		exit();
    }
} else {
	$msg='Direct access denied';
	setRedirectWithMsg(SITE_URL,$msg,'danger');
	exit();
} ?>
