<?php 
require_once("../_config/config.php");
require_once("../include/functions.php");
require_once("common.php");
check_admin_staff_auth();

if(isset($post['d_id'])) {
	$query=mysqli_query($db,'DELETE FROM faqs WHERE id="'.$post['d_id'].'"');
	if($query=="1"){
		$msg="Record successfully removed.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong delete failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'faqs.php');
} elseif(isset($post['bulk_remove'])) {
	$ids_array = $post['ids'];
	if(!empty($ids_array)) {
		$removed_idd = array();
		foreach(explode(",",$ids_array) as $id_k=>$id_v) {
			$query=mysqli_query($db,'DELETE FROM faqs WHERE id="'.$id_v.'"');
			
			$faq_q=mysqli_query($db,'SELECT * FROM faqs WHERE id="'.$id_v.'"');
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
	setRedirect(ADMIN_URL.'faqs.php');
} elseif(isset($post['p_id'])) {
	$query=mysqli_query($db,'UPDATE faqs SET status="'.$post['status'].'" WHERE id="'.$post['p_id'].'"');
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
	setRedirect(ADMIN_URL.'faqs.php');
} elseif(isset($post['update'])) {
	$group_id = $post['group_id'];
	$title=real_escape_string($post['title']);
	$description=real_escape_string($post['description']);
	$status = $post['status'];
	$is_show_in_home_page = $post['is_show_in_home_page'];
	$date = date("Y-m-d H:i:s");

	if($post['id']) {
		$query=mysqli_query($db,'UPDATE faqs SET group_id="'.$group_id.'", title="'.$title.'", description="'.$description.'", added_date="'.$date.'", status="'.$status.'", is_show_in_home_page="'.$is_show_in_home_page.'" WHERE id="'.$post['id'].'"');
		if($query=="1") {
			$msg="Faq has been successfully updated.";
			$_SESSION['success_msg']=$msg;
		} else {
			$msg='Sorry! something wrong updation failed.';
			$_SESSION['error_msg']=$msg;
		}
		setRedirect(ADMIN_URL.'edit_faq.php?id='.$post['id']);
	} else {
		$query=mysqli_query($db,'INSERT INTO faqs(group_id, title, description, updated_date, status, is_show_in_home_page) values("'.$group_id.'","'.$title.'","'.$description.'","'.$date.'","'.$status.'","'.$is_show_in_home_page.'")');
		if($query=="1") {
			$msg="Faq has been successfully added.";
			$_SESSION['success_msg']=$msg;
			setRedirect(ADMIN_URL.'faqs.php');
		} else {
			$msg='Sorry! something wrong updation failed.';
			$_SESSION['error_msg']=$msg;
			setRedirect(ADMIN_URL.'edit_faq.php');
		}
	}
} elseif(isset($post['sbt_order'])) {
	foreach($post['ordering'] as $ordering_key => $ordering_val) {
		if($ordering_val>0) {
			$query = mysqli_query($db,"UPDATE faqs SET ordering='".$ordering_val."' WHERE id='".$ordering_key."'");
		}
	}
	if($query=="1") {
		$msg="Order(s) successfully saved.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong updation failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'faqs.php');
} else {
	setRedirect(ADMIN_URL.'faqs.php');
}
exit();
?>