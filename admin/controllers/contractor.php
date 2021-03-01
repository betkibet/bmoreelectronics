<?php 
require_once("../_config/config.php");
require_once("../include/functions.php");
require_once("common.php");
check_admin_staff_auth();

if(isset($post['d_id'])) {
	$query=mysqli_query($db,'DELETE FROM contractors WHERE id="'.$post['d_id'].'"');
	if($query=="1"){
		mysqli_query($db,'DELETE FROM contractor_orders WHERE contractor_id="'.$post['d_id'].'"');
		$msg="Contractor successfully removed.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong Delete failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'contractors.php');
} elseif(isset($post['bulk_remove'])) {
	$ids_array = $post['ids'];
	if(!empty($ids_array)) {
		$removed_idd = array();
		foreach(explode(",",$ids_array) as $id_k=>$id_v) {
			$removed_idd[] = $id_v;
			$query=mysqli_query($db,'DELETE FROM contractors WHERE id="'.$id_v.'"');
			if($query=='1') {
				mysqli_query($db,'DELETE FROM contractor_orders WHERE contractor_id="'.$id_v.'"');
			}
		}
	}

	if($query=='1') {
		$msg = count($removed_idd)." Contractor(s) successfully removed.";
		if(count($removed_idd)=='1')
			$msg = "Contractor successfully removed.";
	
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong updation failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'contractors.php');
	exit();
} elseif(isset($post['p_id'])) {
	$query=mysqli_query($db,'UPDATE contractors SET status="'.$post['status'].'" WHERE id="'.$post['p_id'].'"');
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
	setRedirect(ADMIN_URL.'contractors.php');
} elseif(isset($post['update'])) {
	$email=real_escape_string($post['email']);
	$phone = preg_replace("/[^\d]/", "", $post['cell_phone']);
	$phone_c_code = $post['phone_c_code'];
	$password=real_escape_string($post['password']);
	$address=real_escape_string($post['address']);
	$address2=real_escape_string($post['address2']);
	$name=real_escape_string($post['name']);

	if(isset($post['permissions']['order_add'])) {
		$post['permissions']['customer_view'] = 1;
		$post['permissions']['customer_add'] = 1;
		$post['permissions']['customer_edit'] = 1;
	}

	$permissions=json_encode($post['permissions']);
	
	$updt_password = "";
	if($password) {
		$updt_password = ",`password`='".md5($password)."'";
	}
	
	if($post['id']>0) {
		$u_e_q=mysqli_query($db,"SELECT * FROM contractors WHERE email='".$post['email']."' AND id!='".$post['id']."'");
		$exist_contractordata=mysqli_fetch_assoc($u_e_q);
		if(!empty($exist_contractordata)) {
			$msg='This email address already used so please use different email address.';
			$_SESSION['error_msg']=$msg;
			setRedirect(ADMIN_URL.'edit_contractor.php?id='.$post['id']);
			exit();
		}

		$updt_sql_params = "";
		$query = mysqli_query($db,"UPDATE `contractors` SET `name`='".$name."',`phone`='".$phone."',`country_code`='".$phone_c_code."',`email`='".$post['email']."',`address`='".$address."',`address2`='".$address2."',`city`='".$post['city']."',`state`='".$post['state']."',`zip_code`='".$post['zip_code']."',`company_name`='".$post['company_name']."',`country`='".$post['country']."',`update_date`='".date('Y-m-d H:i:s')."',`status`='".$post['status']."', permissions='".$permissions."'".$updt_sql_params.$updt_password." WHERE id='".$post['id']."'");
		if($query=="1") {
			if($password!="") {
				$login_auth_token = get_big_unique_id();
				mysqli_query($db,'UPDATE contractors SET auth_token="'.$login_auth_token.'" WHERE id="'.$post['id'].'"');
			}
		
			$msg="Contractor profile has been successfully updated.";
			$_SESSION['success_msg']=$msg;
		} else {
			$msg='Sorry! something wrong updation failed.';
			$_SESSION['error_msg']=$msg;
		}
		setRedirect(ADMIN_URL.'edit_contractor.php?id='.$post['id']);
	} else {
		$u_e_q = mysqli_query($db,"SELECT * FROM contractors WHERE email='".$post['email']."'");
		$exist_contractordata=mysqli_fetch_assoc($u_e_q);
		if(!empty($exist_contractordata)) {
			$msg='This email address already used so please use different email address.';
			$_SESSION['error_msg']=$msg;
			setRedirect(ADMIN_URL.'edit_contractor.php');
			exit();
		}

		$query = mysqli_query($db,"INSERT INTO `contractors`(`name`,`phone`,`country_code`,`email`,`address`,`address2`,`city`,`state`,`zip_code`,`company_name`,`country`,password,`date`,`status`, permissions)  VALUES('".$name."','".$phone."','".$phone_c_code."','".$post['email']."','".$address."','".$address2."','".$post['city']."','".$post['state']."','".$post['zip_code']."','".$post['company_name']."','".$post['country']."','".md5($password)."','".date('Y-m-d H:i:s')."','".$post['status']."','".$permissions."')");
		if($query=="1") {
			$last_insert_id = mysqli_insert_id($db);
			$msg="Contractor profile has been successfully added.";
			$_SESSION['success_msg']=$msg;
			setRedirect(ADMIN_URL.'edit_contractor.php?id='.$last_insert_id);
		} else {
			$msg='Sorry! something wrong adding failed.';
			$_SESSION['error_msg']=$msg;
			setRedirect(ADMIN_URL.'edit_contractor.php');
		}
		exit();
	}
} else {
	setRedirect(ADMIN_URL.'contractors.php');
}
exit(); ?>