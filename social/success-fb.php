<?php
require_once('config.php');

require_once 'lib/php-graph-sdk-5.x/src/Facebook/autoload.php'; // change path as needed
$fb = new \Facebook\Facebook([
  'app_id' => APP_ID,
  'app_secret' => APP_SECRET,
  'default_graph_version' => 'v2.10',
  //'default_access_token' => '{access-token}', // optional
]);

$helper = $fb->getRedirectLoginHelper();
try {
	$accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
	echo 'Graph returned an error: ' . $e->getMessage();
	exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
	echo 'Facebook SDK returned an error: ' . $e->getMessage();
	exit;
}

if(!isset($accessToken)) {
	if($helper->getError()) {
	  header('HTTP/1.0 401 Unauthorized');
	  echo "Error: " . $helper->getError() . "\n";
	  echo "Error Code: " . $helper->getErrorCode() . "\n";
	  echo "Error Reason: " . $helper->getErrorReason() . "\n";
	  echo "Error Description: " . $helper->getErrorDescription() . "\n";
	} else {
	  header('HTTP/1.0 400 Bad Request');
	  echo 'Bad request';
	}
	exit;
}

try {
	$response = $fb->get('/me?fields=id,name,first_name,middle_name,last_name,email,gender,hometown', $accessToken);
	
	$user = $response->getGraphUser();
	$query="SELECT * FROM users WHERE username = '".$user['email']."'";
	$res=mysqli_query($db,$query);
	$checkUser=mysqli_num_rows($res);
	if($checkUser > 0){
		$fetch_userdata=mysqli_fetch_assoc($res);
		$_SESSION['login_user'] = $fetch_userdata['username'];
		$_SESSION['user_id']=$fetch_userdata['id'];
	} else {
		$query=mysqli_query($db,"INSERT INTO `users`(`name`, `first_name`, `last_name`, `email`, `username`, `status`, `date`,leadsource) VALUES('".$user['name']."', '".$user['first_name']."','".$user['last_name']."','".$user['email']."','".$user['email']."','1','".date('Y-m-d H:i:s')."','social')");
		if($query=="1") {
			$query="SELECT * FROM users WHERE username = '".$user['email']."'";
			$res=mysqli_query($db,$query);
			$checkUser=mysqli_num_rows($res);
			$fetch_userdata=mysqli_fetch_assoc($res);

			$_SESSION['login_user'] = $fetch_userdata['username'];
			$_SESSION['user_id']=$fetch_userdata['id'];
		}
	}
} catch(Facebook\Exceptions\FacebookResponseException $e) {
	echo 'Graph returned an error: ' . $e->getMessage();
	exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
	echo 'Facebook SDK returned an error: ' . $e->getMessage();
	exit;
}
?>

<!-- after authentication close the popup -->
<script type="text/javascript">
window.close();
</script>