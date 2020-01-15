<?php
require_once("../../_config/config.php");
require_once("../../include/functions.php");

if(isset($post['login'])) {
	$message=array();
	//Validation for if username entered or not
	if(isset($post['username']) && !empty($post['username'])){
		$username=real_escape_string($post['username']);
	} else {
		$message[]='Please enter username';
	}
	
	//Validation for if password entered or not
	if(isset($post['password']) && !empty($post['password'])){
		$password=real_escape_string($post['password']);
	} else {
		$message[]='Please enter password';
	}
	
	$error_msg = '';
	$countError=count($message);
	if($countError > 0){
		 for($i=0;$i<$countError;$i++){
			$error_msg .= $message[$i].'<br/>';
		 }
		 $_SESSION['error_msg']=$error_msg;
		 setRedirect(ADMIN_URL.'index.php');
	} else {
		$remember_me = $_POST['remember_me'];
		
		//Check if login details match or not
		$query="SELECT * FROM admin WHERE username = '".$username."' AND password = '".md5($password)."'";
		$res=mysqli_query($db,$query);
		$checkUser=mysqli_num_rows($res);
		if($checkUser > 0){
			$query=mysqli_query($db,"SELECT * FROM admin WHERE username = '".$username."'");
			$user_data=mysqli_fetch_assoc($query);
			if($user_data['status'] == '0') {
				$error_msg='This user is not active so please contact with support team.';
				$_SESSION['error_msg']=$error_msg;
				setRedirect(ADMIN_URL.'index.php');
			} else {
				
				if($remember_me=='1') {
					$year = time() + 172800;
					setcookie('username', $username, $year, "/");
					setcookie('password', $password, $year, "/");
					setcookie('remember_me', $remember_me, $year, "/");
				}
	
				if(!$remember_me) {
					$year = time() - 172800;
					setcookie('username', '', $year, "/");
					setcookie('password', '', $year, "/");
					setcookie('remember_me', '', $year, "/");
				}
				
				$_SESSION['admin_username'] = $username;
				$_SESSION['is_admin'] = 1;
				$_SESSION['admin_id'] = $user_data['id'];
				$_SESSION['admin_type'] = $user_data['type'];
				setRedirect(ADMIN_URL.'profile.php');
			}
		} else {
			$error_msg='please enter correct login details';
			$_SESSION['error_msg']=$error_msg;
			setRedirect(ADMIN_URL.'index.php');
		}
	}
} else {
	setRedirect(ADMIN_URL.'index.php');
}
exit(); ?>
