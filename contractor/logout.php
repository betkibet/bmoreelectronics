<?php 
session_start();

unset($_SESSION['contractor_username']);
unset($_SESSION['is_contractor']);
unset($_SESSION['contractor_id']);
unset($_SESSION['contractor_type']);
unset($_SESSION['auth_token']);

unset($_COOKIE['username']);
unset($_COOKIE['password']);
unset($_COOKIE['remember_me']);

$year = time() - 172800;
setcookie('username', '', $year, "/");
setcookie('password', '', $year, "/");
setcookie('remember_me', '', $year, "/");

foreach($_SESSION as $s_k=>$s_v) {
	if(preg_match("/_filter_data/i",$s_k)) {
		unset($_SESSION[$s_k]);
	}
}

header('location: index.php');
exit();
?>
