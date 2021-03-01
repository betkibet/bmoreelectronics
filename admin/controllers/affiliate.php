<?php 
require_once("../_config/config.php");
require_once("../include/functions.php");
require_once("common.php");
check_admin_staff_auth();

if(isset($post['d_id'])) {	
	$query=mysqli_query($db,'DELETE FROM affiliate WHERE id="'.$post['d_id'].'" ');
	if($query=="1") {
		$msg="Record successfully removed.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong Delete failed.';
		$_SESSION['error_msg']=$msg;
	}
} elseif(isset($post['bulk_remove'])) {
	$ids_array = $post['ids'];
	if(!empty($ids_array)) {
		$removed_idd = array();
		foreach(explode(",",$ids_array) as $id_k=>$id_v) {
			$removed_idd[] = $id_v;
			$query=mysqli_query($db,'DELETE FROM affiliate WHERE id="'.$id_v.'"');
		}
	}

	if($query=='1') {
		$msg = count($removed_idd)." Record(s) successfully removed.";
		if(count($removed_idd)=='1')
			$msg = "Record successfully removed.";
	
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong updation failed.';
		$_SESSION['error_msg']=$msg;
	}
} elseif(isset($post['p_id'])) {
	$query=mysqli_query($db,'UPDATE affiliate SET status="'.$post['published'].'" WHERE id="'.$post['p_id'].'"');
	if($query=="1"){
		if($post['published']==1) {
			$msg="Successfully Published.";
		} elseif($post['published']==0) {
			$msg="Successfully Unpublished.";
		}
		
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong Delete failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'affiliate.php');
} elseif(isset($post['update'])) {
	$prefill_data_arr = array('name'=>$post['name'],'phone'=>$post['phone'],'email'=>$post['email'],'company'=>$post['company'],'web_address'=>$post['web_address'],'message'=>$post['message']);

	$name=real_escape_string($post['name']);
	$phone=preg_replace("/[^\d]/", "", real_escape_string($post['cell_phone']));
	$email=real_escape_string($post['email']);
	$company=real_escape_string($post['company']);
	$web_address=real_escape_string($post['web_address']);
	$subject=real_escape_string($post['subject']);
	$message=real_escape_string($post['message']);
	$shop_name=real_escape_string($post['shop_name']);
	$status=real_escape_string($post['status']);
	
	$exist_aflt_q=mysqli_query($db,"SELECT * FROM affiliate WHERE shop_name='".$shop_name."' AND id!='".$post['id']."'");
	$exist_aflt_data=mysqli_fetch_assoc($exist_aflt_q);
	if(!empty($exist_aflt_data)) {
		$_SESSION['affiliate_prefill_data'] = $prefill_data_arr;
		$msg='Shop name already used. so please use another shop name.';
		$_SESSION['error_msg']=$msg;
		setRedirect(ADMIN_URL.'edit_affiliate.php?id='.$post['id']);
		exit();
	}

	if($post['id']) {
		$query=mysqli_query($db,"UPDATE affiliate SET name='".$name."', phone='".$phone."', email='".$email."', company='".$company."', web_address='".$web_address."', subject='".$subject."', message='".$message."', update_date='".date('Y-m-d H:i:s')."', shop_name='".$shop_name."', status='".$status."' WHERE id='".$post['id']."'");
		if($query=="1") {
			$msg="Affiliate has been successfully updated.";
			$_SESSION['success_msg']=$msg;
		} else {
			$msg='Sorry! something wrong updation failed.';
			$_SESSION['error_msg']=$msg;
		}
		setRedirect(ADMIN_URL.'edit_affiliate.php?id='.$post['id']);
	} else {
		$query=mysqli_query($db,"INSERT INTO affiliate(name, phone, email, company, web_address, subject, message, date, shop_name, status) VALUES('".$name."','".$phone."','".$email."','".$company."','".$web_address."','".$subject."','".$message."','".date('Y-m-d H:i:s')."','".$shop_name."','".$status."')");
		if($query=="1") {
			$last_id = mysqli_insert_id($db);
			$msg="Affiliate has been successfully added.";
			$_SESSION['success_msg']=$msg;
			setRedirect(ADMIN_URL.'edit_affiliate.php?id='.$last_id);
		} else {
			$msg='Sorry! something wrong updation failed.';
			$_SESSION['error_msg']=$msg;
			setRedirect(ADMIN_URL.'edit_affiliate.php');
		}
	}
	exit();
}
setRedirect(ADMIN_URL.'affiliate.php');
exit();
?>