<?php
include("../admin/_config/config.php");
include("../admin/include/functions.php");

define('CLIENT_ID',$google_client_id);
define('CLIENT_SECRET',$google_client_secret);
define('REDIRECT_URI',SITE_URL.'social/social.php?google');
define('APPROVAL_PROMPT','auto');
define('ACCESS_TYPE','offline');

//For facebook
define('APP_ID',$fb_app_id);
define('APP_SECRET',$fb_app_secret);
?>