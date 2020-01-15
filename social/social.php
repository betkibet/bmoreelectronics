<?php
require_once('config.php');

//For Google
require_once 'lib/google/Google_Client.php';
require_once 'lib/google/Google_Oauth2Service.php';

function facebook(){
	require_once 'lib/php-graph-sdk-5.x/src/Facebook/autoload.php'; //change path as needed
	$fb = new \Facebook\Facebook([
	  'app_id' => APP_ID,
	  'app_secret' => APP_SECRET,
	  'default_graph_version' => 'v2.10',
	  //'default_access_token' => '{access-token}', //optional
	]);

	$helper = $fb->getRedirectLoginHelper();
	$permissions = ['email','public_profile']; //optional
	$loginUrl = $helper->getLoginUrl(SITE_URL.'social/success-fb.php?facebook=1', $permissions);
	header('Location: '.$loginUrl);
}

function google($db){
	$client = new Google_Client();
	$client->setApplicationName("Sell Device");
	$client->setClientId(CLIENT_ID);
	$client->setClientSecret(CLIENT_SECRET);
	$client->setRedirectUri(REDIRECT_URI);
	$client->setApprovalPrompt(APPROVAL_PROMPT);
	$client->setAccessType(ACCESS_TYPE);
	$oauth2 = new Google_Oauth2Service($client);
	if(isset($_GET['code'])) {
		$client->authenticate($_GET['code']);
		//$_SESSION['token'] = $client->getAccessToken();
	}
	if(isset($_SESSION['token'])) {
		//$client->setAccessToken($_SESSION['token']);
	}
	if(isset($_REQUEST['error'])) {
		echo '<script type="text/javascript">window.close();</script>'; exit;
	}
	if($client->getAccessToken()) {
		$user = $oauth2->userinfo->get();

		$query="SELECT * FROM users WHERE username = '".$user['email']."'";
		$res=mysqli_query($db,$query);
		$checkUser=mysqli_num_rows($res);
		if($checkUser > 0){
			$fetch_userdata=mysqli_fetch_assoc($res);
			$_SESSION['login_user'] = $fetch_userdata['username'];
			$_SESSION['user_id']=$fetch_userdata['id'];
		} else {
			$query=mysqli_query($db,"INSERT INTO `users`(`name`, `first_name`, `last_name`, `email`, `username`, `status`, `date`, leadsource) VALUES('".$user['name']."', '".$user['given_name']."','".$user['family_name']."','".$user['email']."','".$user['email']."','1','".date('Y-m-d H:i:s')."', 'social')");
			if($query=="1") {
				$query="SELECT * FROM users WHERE username = '".$user['email']."'";
				$res=mysqli_query($db,$query);
				$checkUser=mysqli_num_rows($res);
				$fetch_userdata=mysqli_fetch_assoc($res);
				$_SESSION['login_user'] = $fetch_userdata['username'];
				$_SESSION['user_id']=$fetch_userdata['id'];
			}
		}
	} else {
	  $authUrl = $client->createAuthUrl();
	  header('Location: '.$authUrl);
	}
}

if(isset($_GET['facebook'])){
	facebook();
}
if(isset($_GET['google'])){
	google($db);
}
?>

<!-- after authentication close the popup -->
<script type="text/javascript">
window.close();
</script>