<?php 
require_once("../_config/config.php");
require_once("../include/functions.php");

if(isset($post['update'])) {
	$check_entry=mysqli_query($db,"SELECT id FROM mail_templates where id='".$post['id']."' ");
	$is_data=mysqli_num_rows($check_entry);

	$type = real_escape_string($post['type']);
	$content = real_escape_string($post['content']);
	$subject = real_escape_string($post['subject']);
	$sms_status = $post['sms_status'];
	$sms_content = real_escape_string($post['sms_content']);
	$status = $post['status'];
	
	if($is_data == "") {
		$query=mysqli_query($db,'INSERT into mail_templates(type, content, subject, sms_status, sms_content, status) values("'.$type.'","'.$content.'","'.$subject.'","'.$sms_status.'","'.$sms_content.'","'.$status.'")');
		$msg = 'Email template has been successfully saved.';
		$_SESSION['success_msg']=$msg;
		setRedirect(ADMIN_URL.'email_templates.php');
	} else {
		mysqli_query($db,'UPDATE mail_templates SET content="'.$content.'", subject="'.$subject.'", sms_status="'.$sms_status.'", sms_content="'.$sms_content.'", status="'.$status.'" WHERE id="'.$post['id'].'"');
		$msg = 'Email template has been successfully updated.';
		$_SESSION['success_msg']=$msg;
		setRedirect(ADMIN_URL.'edit_email_template.php?id='.$post['id']);
	}
} else {
	setRedirect(ADMIN_URL.'email_templates.php');
}
exit();
?>
