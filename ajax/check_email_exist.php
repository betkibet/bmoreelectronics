<?php
require_once("../admin/_config/config.php");
require_once("../admin/include/functions.php");
require_once("common.php");

$email = $_POST['email'];
$token = $_POST['token'];
$user_id = $_POST['user_id'];
if($email!="" && $token!="") {
	$login_link = SITE_URL.get_inbuild_page_url('login');
	$response = array();
	$query=mysqli_query($db,"SELECT * FROM `users` WHERE email='".$email."' AND email!='' AND status='1' AND user_type='user'");
	$user_data = mysqli_fetch_assoc($query);

	if(!empty($user_data) && $user_id!=$user_data['id']) {
		$response['msg'] = 'Email address been already been registered.<br>Please click <a href="'.$login_link.'"><strong>here</strong></a> to login';
		$response['exist'] = true;
	} else {
		$response['msg'] = "";
		$response['exist'] = false;
	}
	echo json_encode($response);
}
?>