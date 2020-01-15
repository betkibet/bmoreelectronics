<?php 
require_once("../_config/config.php");
require_once("../include/functions.php");

if(isset($post['d_id'])) {
	$query=mysqli_query($db,'DELETE FROM admin WHERE id="'.$post['d_id'].'" ');
	if($query=="1"){
		$msg="Staff successfully removed.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong Delete failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'staff.php');
} elseif(isset($post['bulk_remove'])) {
	$ids_array = $post['ids'];
	if(!empty($ids_array)) {
		$removed_idd = array();
		foreach(explode(",",$ids_array) as $id_k=>$id_v) {
			$removed_idd[] = $id_v;
			$query=mysqli_query($db,'DELETE FROM admin WHERE id="'.$id_v.'"');
		}
	}

	if($query=='1') {
		$msg = count($removed_idd)." Staff(s) successfully removed.";
		if(count($removed_idd)=='1')
			$msg = "Staff successfully removed.";
	
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong updation failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'staff.php');
	exit();
} elseif(isset($post['p_id'])) {
	$query=mysqli_query($db,'UPDATE admin SET status="'.$post['status'].'" WHERE id="'.$post['p_id'].'"');
	if($query=="1"){
		if($post['published']==1)
			$msg="Successfully Published.";
		elseif($post['published']==0)
			$msg="Successfully Unpublished.";
			
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong Delete failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'staff.php');
} elseif(isset($post['update'])) {
	$username=real_escape_string($post['username']);
	$password=real_escape_string($post['password']);
	$email=real_escape_string($post['email']);
	$type=real_escape_string($post['type']);
	$status=real_escape_string($post['status']);
	if($password)
			$upd_password = ",`password`='".md5($password)."'";

	if($post['id']>0) {
		$get_userdata=mysqli_query($db,'SELECT * FROM admin WHERE username="'.$post['username'].'" AND id!="'.$post['id'].'"');
		$get_userdata_row=mysqli_fetch_assoc($get_userdata);
		if(!empty($get_userdata_row)) {
			$msg='This username already exist so please use different username.';
			$_SESSION['error_msg']=$msg;
			setRedirect(ADMIN_URL.'edit_staff.php?id='.$post['id']);
			exit();
		}

		$get_userdata=mysqli_query($db,'SELECT * FROM admin WHERE email="'.$post['email'].'" AND id!="'.$post['id'].'"');
		$get_userdata_row=mysqli_fetch_assoc($get_userdata);
		if(!empty($get_userdata_row)) {
			$msg='This email address already exist so please use different email address.';
			$_SESSION['error_msg']=$msg;
			setRedirect(ADMIN_URL.'edit_staff.php?id='.$post['id']);
			exit();
		}

		$query=mysqli_query($db,"UPDATE `admin` SET `username`='".$username."'".$upd_password.",`email`='".$email."',`type`='admin',`status`='".$status."',`updated_date`='".date('Y-m-d H:i:s')."' WHERE id='".$post['id']."'");
		if($query=="1") {
			$msg="Staff has been successfully updated.";
			$_SESSION['success_msg']=$msg;
		} else {
			$msg='Sorry! something wrong updation failed.';
			$_SESSION['error_msg']=$msg;
		}
		setRedirect(ADMIN_URL.'edit_staff.php?id='.$post['id']);
	} else {
		$get_userdata=mysqli_query($db,'SELECT * FROM admin WHERE username="'.$post['username'].'"');
		$get_userdata_row=mysqli_fetch_assoc($get_userdata);
		if(!empty($get_userdata_row)) {
			$msg='This username already exist so please use different username.';
			$_SESSION['error_msg']=$msg;
			setRedirect(ADMIN_URL.'edit_staff.php');
			exit();
		}
		
		$get_userdata=mysqli_query($db,'SELECT * FROM admin WHERE email="'.$post['email'].'"');
		$get_userdata_row=mysqli_fetch_assoc($get_userdata);
		if(!empty($get_userdata_row)) {
			$msg='This email address already exist so please use different email address.';
			$_SESSION['error_msg']=$msg;
			setRedirect(ADMIN_URL.'edit_staff.php');
			exit();
		}
		
		if($password == "") {
			$msg='Please enter password';
			$_SESSION['error_msg']=$msg;
			setRedirect(ADMIN_URL.'edit_staff.php');
		}
		
		$query=mysqli_query($db,"INSERT INTO `admin`(`username`, password, `email`, `type`, `status`, `added_date`) VALUES('".$username."','".md5($password)."','".$email."','admin','".$status."','".date('Y-m-d H:i:s')."')");
		if($query=="1") {
			$msg="Staff has been successfully added.";
			$_SESSION['success_msg']=$msg;
		} else {
			$msg='Sorry! something wrong add failed.';
			$_SESSION['error_msg']=$msg;
		}
		setRedirect(ADMIN_URL.'staff.php');
	}
} else {
	setRedirect(ADMIN_URL.'staff.php');
}
exit(); ?>