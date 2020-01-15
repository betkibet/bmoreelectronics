<?php
require_once("../admin/_config/config.php");
require_once("../admin/include/functions.php");

unset($_SESSION['login_user']);
unset($_SESSION['user_id']);
setRedirect(SITE_URL);
exit();
?>