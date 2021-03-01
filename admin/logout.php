<?php 
session_start();

unset($_SESSION['admin_username']);
unset($_SESSION['is_admin']);
unset($_SESSION['admin_id']);
unset($_SESSION['admin_type']);
unset($_SESSION['auth_token']);

unset($_COOKIE['admin_ck_username']);
unset($_COOKIE['admin_ck_password']);
unset($_COOKIE['admin_ck_remember_me']);

$year = time() - 172800;
setcookie('admin_ck_username', '', $year, "/");
setcookie('admin_ck_password', '', $year, "/");
setcookie('admin_ck_remember_me', '', $year, "/");

foreach($_SESSION as $s_k=>$s_v) {
	if(preg_match("/_filter_data/i",$s_k)) {
		unset($_SESSION[$s_k]);
	}
}

header('location: index.php');
exit();
?>
