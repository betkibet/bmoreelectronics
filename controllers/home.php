<?php
require_once("../admin/_config/config.php");
require_once("../admin/include/functions.php");

if(isset($post['submit_quote'])) {
	if($post['quote_make']!="" && $post['quote_device']!="" && $post['quote_model']!="") {
		setRedirect($post['quote_model']);
		exit();
	}
} else {
	$msg='Direct access denied';
	setRedirectWithMsg(SITE_URL,$msg,'danger');
	exit();
}
?>
