<?php 
require_once("../_config/config.php");
require_once("../include/functions.php");

if(isset($post['d_id'])) {	
	$query=mysqli_query($db,'DELETE FROM reviews WHERE id="'.$post['d_id'].'" ');
	if($query=="1") {
		$msg="Record successfully removed.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong delete failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'review.php');
	exit();
}
if(isset($post['active_id'])) {
	$query=mysqli_query($db,"UPDATE reviews SET status='1' WHERE id='".$post['active_id']."'");
	if($query=="1") {
		$msg="Review successfully Activated.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong delete failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'review.php');
	exit();
}
if(isset($post['inactive_id'])) {
	$query=mysqli_query($db,"UPDATE reviews SET status='0' WHERE id='".$post['inactive_id']."'");
	if($query=="1") {
		$msg="Review successfully Inactivated.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong delete failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'review.php');
	exit();
} 
if(isset($post['add_update'])) {
	$name=real_escape_string($post['name']);
	$email=real_escape_string($post['email']);
	$country=real_escape_string($post['country']);
	$state=real_escape_string($post['state']);
	$city=real_escape_string($post['city']);
	$stars=real_escape_string($post['stars']);
	$title=real_escape_string($post['title']);
	$content=real_escape_string($post['content']);
	$status=$post['status'];

	if($post['id']) {
		$query=mysqli_query($db,'UPDATE reviews SET name="'.$name.'", email="'.$email.'", country="'.$country.'", state="'.$state.'", city="'.$city.'", stars="'.$stars.'", title="'.$title.'", content="'.$content.'", status="'.$status.'" WHERE id="'.$post['id'].'"');
		if($query=="1") {
			$msg="Review has been successfully updated.";
			$_SESSION['success_msg']=$msg;
		} else {
			$msg='Sorry! something wrong updation failed.';
			$_SESSION['error_msg']=$msg;
		}
		setRedirect(ADMIN_URL.'add_edit_review.php?id='.$post['id']);
	} else {
		$query=mysqli_query($db,"INSERT INTO reviews(name, email, country, state, city, stars, title, content, date, status) VALUES('".$name."','".$email."','".$country."','".$state."','".$city."','".$stars."','".$title."','".$content."','".date('Y-m-d H:i:s')."','".$status."')");
		if($query=="1") {
			$msg="Review has been successfully added.";
			$_SESSION['success_msg']=$msg;
			setRedirect(ADMIN_URL.'review.php');
		} else {
			$msg='Sorry! something wrong updation failed.';
			$_SESSION['error_msg']=$msg;
			setRedirect(ADMIN_URL.'add_edit_review.php');
		}
	}
	exit();
}
?>
