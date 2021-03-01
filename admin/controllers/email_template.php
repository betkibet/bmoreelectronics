<?php 
require_once("../_config/config.php");
require_once("../include/functions.php");
require_once("common.php");
check_admin_staff_auth();

if(isset($post['p_id'])) {
	$query=mysqli_query($db,'UPDATE mail_templates SET status="'.$post['status'].'" WHERE id="'.$post['p_id'].'"');
	if($query=="1"){
		if($post['status']==1)
			$msg="Successfully Published.";
		elseif($post['status']==0)
			$msg="Successfully Unpublished.";
			
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong delete failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'email_templates.php');
} elseif(isset($post['d_id'])) {
	$query=mysqli_query($db,"DELETE FROM mail_templates WHERE id='".$post['d_id']."' AND is_fixed='0'");
	if($query=="1") {
		$msg="Record successfully removed.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong delete failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'email_templates.php');
} elseif(isset($post['update'])) {
	$check_entry=mysqli_query($db,"SELECT id FROM mail_templates WHERE id='".$post['id']."' ");
	$is_data=mysqli_num_rows($check_entry);

	$type = real_escape_string($post['type']);
	$content = real_escape_string($post['content']);
	$subject = real_escape_string($post['subject']);
	$sms_status = $post['sms_status'];
	$sms_content = real_escape_string($post['sms_content']);
	$status = $post['status'];
	$is_fixed = $post['is_fixed'];
	if($is_fixed == '0' && $is_fixed != '1') {
		$updt_q_params = ', type="'.$type.'"';
	}

	if($is_data == "") {
		$query=mysqli_query($db,'INSERT INTO mail_templates(type, content, subject, sms_status, sms_content, status, is_fixed) values("'.$type.'","'.$content.'","'.$subject.'","'.$sms_status.'","'.$sms_content.'","'.$status.'","'.$is_fixed.'")');
		$msg = 'Email template has been successfully saved.';
		$_SESSION['success_msg']=$msg;
		setRedirect(ADMIN_URL.'email_templates.php');
	} else {
		mysqli_query($db,'UPDATE mail_templates SET content="'.$content.'", subject="'.$subject.'", sms_status="'.$sms_status.'", sms_content="'.$sms_content.'", status="'.$status.'"'.$updt_q_params.' WHERE id="'.$post['id'].'"');
		$msg = 'Email template has been successfully updated.';
		$_SESSION['success_msg']=$msg;
		setRedirect(ADMIN_URL.'edit_email_template.php?id='.$post['id']);
	}
} else {
	setRedirect(ADMIN_URL.'email_templates.php');
}
exit();
?>