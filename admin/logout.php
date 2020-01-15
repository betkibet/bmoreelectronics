<?php
session_start();

unset($_SESSION['is_admin']);
unset($_SESSION['admin_username']);

unset($_COOKIE['username']);
unset($_COOKIE['password']);
unset($_COOKIE['remember_me']);

$year = time() - 172800;
setcookie('username', '', $year, "/");
setcookie('password', '', $year, "/");
setcookie('remember_me', '', $year, "/");

header('location: index.php');
exit();
?>