<?php 
require_once("../_config/config.php");
require_once("../include/functions.php");
require_once("common.php");
check_admin_staff_auth();

if(isset($post['d_id'])) {
	$query = mysqli_query($db,'DELETE FROM order_complete_pages WHERE id="'.$post['d_id'].'" ');
	if($query=="1") {
		$msg="Record successfully removed.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong delete failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'order_complete_pages.php');
} elseif(isset($post['bulk_remove'])) {
	$ids_array = $post['ids'];
	if(!empty($ids_array)) {
		$removed_idd = array();
		foreach(explode(",",$ids_array) as $id_k=>$id_v) {
			$removed_idd[] = $id_v;
			$query = mysqli_query($db,'DELETE FROM order_complete_pages WHERE id="'.$id_v.'"');
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
	setRedirect(ADMIN_URL.'order_complete_pages.php');
} elseif(isset($post['p_id'])) {
	$query=mysqli_query($db,'UPDATE order_complete_pages SET status="'.$post['published'].'" WHERE id="'.$post['p_id'].'"');
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
	setRedirect(ADMIN_URL.'order_complete_pages.php');
} elseif(isset($post['update'])) {
	$id=$post['id'];
	$success_page_content=real_escape_string(json_encode($post['success_page_content']));
	$title=real_escape_string($post['title']);
	$status = $post['status'];

	if($id) {
		$query=mysqli_query($db,'UPDATE order_complete_pages SET content_fields="'.$success_page_content.'", status="'.$status.'" WHERE id="'.$id.'"');
		if($query=="1") {
			$msg="Order complete page has been successfully updated.";
			$_SESSION['success_msg']=$msg;
		} else {
			$msg='Sorry! something wrong updation failed.';
			$_SESSION['error_msg']=$msg;
		}
		setRedirect(ADMIN_URL.'edit_order_complete_page.php?id='.$id);
	} else {
		$msg='Sorry! something wrong updation failed.';
		$_SESSION['error_msg']=$msg;
		setRedirect(ADMIN_URL.'order_complete_pages.php');

		/*$query=mysqli_query($db,'INSERT INTO order_complete_pages(content_fields, status) VALUES("'.$success_page_content.'", "'.$status.'")');
		if($query=="1") {
			$msg="Order complete page has been successfully added.";
			$_SESSION['success_msg']=$msg;
			setRedirect(ADMIN_URL.'order_complete_pages.php');
		} else {
			$msg='Sorry! something wrong updation failed.';
			$_SESSION['error_msg']=$msg;
			setRedirect(ADMIN_URL.'edit_order_complete_page.php');
		}*/
	}
} elseif(isset($post['sbt_order'])) {
	foreach($post['ordering'] as $ordering_key => $ordering_val) {
		if($ordering_val>0) {
			$query = mysqli_query($db,"UPDATE order_complete_pages SET ordering='".$ordering_val."' WHERE id='".$ordering_key."'");
		}
	}
	if($query=="1") {
		$msg="Order(s) successfully saved.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong updation failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'order_complete_pages.php');
} else {
	setRedirect(ADMIN_URL.'order_complete_pages.php');
}
exit();
?>