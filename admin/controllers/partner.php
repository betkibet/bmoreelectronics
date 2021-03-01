<?php 
require_once("../_config/config.php");
require_once("../include/functions.php");
require_once("common.php");
check_admin_staff_auth();

if(isset($post['d_id'])) {
	$query=mysqli_query($db,'DELETE FROM partners WHERE id="'.$post['d_id'].'" ');
	if($query=="1"){
		$msg="Record successfully removed.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong delete failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'partners.php');
} elseif(isset($post['bulk_remove'])) {
	$ids_array = $post['ids'];
	if(!empty($ids_array)) {
		$removed_idd = array();
		foreach(explode(",",$ids_array) as $id_k=>$id_v) {
			$removed_idd[] = $id_v;
			$query=mysqli_query($db,'DELETE FROM partners WHERE id="'.$id_v.'"');
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
	setRedirect(ADMIN_URL.'partners.php');
} elseif(isset($post['p_id'])) {
	$query=mysqli_query($db,'UPDATE partners SET status="'.$post['status'].'" WHERE id="'.$post['p_id'].'"');
	if($query=="1"){
		if($post['status']==1)
			$msg="Successfully Published.";
		elseif($post['status']==0)
			$msg="Successfully Unpublished.";

		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong Delete failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'partners.php');
} elseif(isset($post['update'])) {
	
	$name=real_escape_string($post['name']);
	$email=real_escape_string($post['email']);
	$store_name=real_escape_string($post['store_name']);
	$status = $post['status'];

	if($post['id']) {
		
		$get_userdata=mysqli_query($db,'SELECT * FROM partners WHERE store_name="'.$store_name.'" AND id!="'.$post['id'].'"');
		$get_userdata_row=mysqli_fetch_assoc($get_userdata);
		if(!empty($get_userdata_row)) {
			$msg='This partner already used so please use different partner.';
			$_SESSION['error_msg']=$msg;
			setRedirect(ADMIN_URL.'edit_partner.php?id='.$post['id']);
			exit();
		}
		
		$query=mysqli_query($db,'UPDATE partners SET name="'.$name.'", email="'.$email.'", store_name="'.$store_name.'", status="'.$status.'" WHERE id="'.$post['id'].'"');
		if($query=="1") {
			$msg="Partner has been successfully updated.";
			$_SESSION['success_msg']=$msg;
		} else {
			$msg='Sorry! something wrong updation failed.';
			$_SESSION['error_msg']=$msg;
		}
		setRedirect(ADMIN_URL.'edit_partner.php?id='.$post['id']);
	} else {
		$query=mysqli_query($db,'INSERT INTO partners(name, email, store_name, status) values("'.$name.'","'.$email.'","'.$store_name.'","'.$status.'")');
		if($query=="1") {
			$last_id = mysqli_insert_id($db);
			$msg="Partner has been successfully added.";
			$_SESSION['success_msg']=$msg;
			setRedirect(ADMIN_URL.'edit_partner.php?id='.$last_id);
		} else {
			$msg='Sorry! something wrong updation failed.';
			$_SESSION['error_msg']=$msg;
			setRedirect(ADMIN_URL.'edit_partner.php');
		}
	}
} elseif(isset($post['sbt_order'])) {
	foreach($post['ordering'] as $ordering_key => $ordering_val) {
		if($ordering_val>0) {
			$query = mysqli_query($db,"UPDATE partners SET ordering='".$ordering_val."' WHERE id='".$ordering_key."'");
		}
	}
	if($query=="1") {
		$msg="Order(s) successfully saved.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong updation failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'partners.php');
} elseif(isset($post['r_img_id'])) {
	$get_behand_data=mysqli_query($db,'SELECT image FROM partners WHERE id="'.$post['r_img_id'].'"');
	$brand_data=mysqli_fetch_assoc($get_behand_data);

	$del_logo=mysqli_query($db,'UPDATE partners SET image="" WHERE id='.$post['r_img_id']);
	if($brand_data['image']!="")
		unlink('../../images/partners/'.$brand_data['image']);

	setRedirect(ADMIN_URL.'edit_partner.php?id='.$post['id']);
} else {
	setRedirect(ADMIN_URL.'partners.php');
}
exit();
?>