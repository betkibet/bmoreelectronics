<?php 
require_once("../_config/config.php");
require_once("../include/functions.php");
require_once("common.php");
check_admin_staff_auth();

if(isset($post['d_id'])) {
	$query=mysqli_query($db,'DELETE FROM faqs_groups WHERE id="'.$post['d_id'].'"');
	if($query=="1"){
		$msg="Record successfully removed.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong delete failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'faqs_groups.php');
} elseif(isset($post['bulk_remove'])) {
	$ids_array = $post['ids'];
	if(!empty($ids_array)) {
		$removed_idd = array();
		foreach(explode(",",$ids_array) as $id_k=>$id_v) {
			$query=mysqli_query($db,'DELETE FROM faqs_groups WHERE id="'.$id_v.'"');
			
			$faq_q=mysqli_query($db,'SELECT * FROM faqs_groups WHERE id="'.$id_v.'"');
			$faq_data=mysqli_fetch_assoc($faq_q);
			if(empty($faq_data)) {
				$removed_idd[] = $id_v;
			}
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
	setRedirect(ADMIN_URL.'faqs_groups.php');
} elseif(isset($post['p_id'])) {
	$query=mysqli_query($db,'UPDATE faqs_groups SET status="'.$post['status'].'" WHERE id="'.$post['p_id'].'"');
	if($query=="1"){
		if($post['published']==1)
			$msg="Successfully Published.";
		elseif($post['published']==0)
			$msg="Successfully Unpublished.";

		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong delete failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'faqs_groups.php');
} elseif(isset($post['update'])) {
	$cat_id = @implode(',',$post['cat_id']);
	$title=real_escape_string($post['title']);
	$status = $post['status'];
	$date = date("Y-m-d H:i:s");
	$show_in_model_list = intval($post['show_in_model_list']);
	$show_in_model_details = intval($post['show_in_model_details']);

	if($post['id']) {
		$query=mysqli_query($db,'UPDATE faqs_groups SET cat_id="'.$cat_id.'", title="'.$title.'", added_date="'.$date.'", status="'.$status.'", show_in_model_list="'.$show_in_model_list.'", show_in_model_details="'.$show_in_model_details.'" WHERE id="'.$post['id'].'"');
		if($query=="1") {
			$msg="Faq group has been successfully updated.";
			$_SESSION['success_msg']=$msg;
		} else {
			$msg='Sorry! something wrong updation failed.';
			$_SESSION['error_msg']=$msg;
		}
		setRedirect(ADMIN_URL.'edit_faq_group.php?id='.$post['id']);
	} else {
		$query=mysqli_query($db,'INSERT INTO faqs_groups(cat_id, title, updated_date, status, show_in_model_list, show_in_model_details) values("'.$cat_id.'","'.$title.'","'.$date.'","'.$status.'","'.$show_in_model_list.'","'.$show_in_model_details.'")');
		if($query=="1") {
			$msg="Faq group has been successfully added.";
			$_SESSION['success_msg']=$msg;
			setRedirect(ADMIN_URL.'faqs_groups.php');
		} else {
			$msg='Sorry! something wrong updation failed.';
			$_SESSION['error_msg']=$msg;
			setRedirect(ADMIN_URL.'edit_faq_group.php');
		}
	}
} elseif(isset($post['sbt_order'])) {
	foreach($post['ordering'] as $ordering_key => $ordering_val) {
		if($ordering_val>0) {
			$query = mysqli_query($db,"UPDATE faqs_groups SET ordering='".$ordering_val."' WHERE id='".$ordering_key."'");
		}
	}
	if($query=="1") {
		$msg="Order(s) successfully saved.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong updation failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'faqs_groups.php');
} else {
	setRedirect(ADMIN_URL.'faqs_groups.php');
}
exit();
?>