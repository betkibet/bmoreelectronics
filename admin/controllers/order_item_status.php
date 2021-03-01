<?php 
require_once("../_config/config.php");
require_once("../include/functions.php");
require_once("common.php");
check_admin_staff_auth();

if(isset($post['d_id'])) {
	//$order_item_status_q=mysqli_query($db,'SELECT * FROM order_item_status WHERE id="'.$post['d_id'].'"');
	//$order_item_status_data=mysqli_fetch_assoc($order_item_status_q);

	$query=mysqli_query($db,'DELETE FROM order_item_status WHERE id="'.$post['d_id'].'" ');
	if($query=="1") {
		$msg="Record successfully removed.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong delete failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'order_item_status.php');
} elseif(isset($post['bulk_remove'])) {
	$ids_array = $post['ids'];
	if(!empty($ids_array)) {
		$removed_idd = array();
		foreach(explode(",",$ids_array) as $id_k=>$id_v) {
			$removed_idd[] = $id_v;

			//$order_item_status_q=mysqli_query($db,'SELECT image FROM order_item_status WHERE id="'.$id_v.'"');
			//$order_item_status_data=mysqli_fetch_assoc($order_item_status_q);

			$query=mysqli_query($db,'DELETE FROM order_item_status WHERE id="'.$id_v.'"');
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
	setRedirect(ADMIN_URL.'order_item_status.php');
} elseif(isset($post['p_id'])) {
	$query=mysqli_query($db,'UPDATE order_item_status SET status="'.$post['published'].'" WHERE id="'.$post['p_id'].'"');
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
	setRedirect(ADMIN_URL.'order_item_status.php');
} elseif(isset($post['update'])) {
	$id=$post['id'];
	$slug=createSlug($post['slug']);
	$name=real_escape_string($post['name']);
	$description=real_escape_string($post['description']);
	$color=real_escape_string($post['color']);
	$status = $post['status'];
	$text_in_order_history=real_escape_string($post['text_in_order_history']);
	
	$order_item_status_prefill_data = array('id'=>$id,
								'slug'=>$post['slug'],
								'name'=>$post['name'],
								'description'=>$post['description'],
								'color'=>$post['color'],
								'status'=>$post['status']
								);

	//Check Valid Slug
	$qry = mysqli_query($db,"SELECT * FROM order_item_status WHERE slug='".$slug."' AND slug!='' AND id!='".$id."'");
	$num_of_order_item_status = mysqli_num_rows($qry);
	if($num_of_order_item_status>0) {
		$_SESSION['order_item_status_prefill_data'] = $order_item_status_prefill_data;

		$msg="This slug already exist so please use different slug & try again.";
		$_SESSION['error_msg']=$msg;
		if($id) {
			setRedirect(ADMIN_URL.'edit_order_item_status.php?id='.$id);
		} else {
			setRedirect(ADMIN_URL.'edit_order_item_status.php');
		}
		exit();
	}

	if($id) {
		$query=mysqli_query($db,'UPDATE order_item_status SET slug="'.$slug.'", name="'.$name.'", description="'.$description.'", color="'.$color.'", status="'.$status.'", text_in_order_history="'.$text_in_order_history.'" WHERE id="'.$id.'"');
		if($query=="1") {
			$msg="Status has been successfully updated.";
			$_SESSION['success_msg']=$msg;
		} else {
			$_SESSION['order_item_status_prefill_data'] = $order_item_status_prefill_data;
			$msg='Sorry! something wrong updation failed.';
			$_SESSION['error_msg']=$msg;
		}
		setRedirect(ADMIN_URL.'edit_order_item_status.php?id='.$id);
	} else {
		$query=mysqli_query($db,'INSERT INTO order_item_status(slug, name, description, color, status, text_in_order_history) values("'.$slug.'","'.$name.'","'.$description.'", "'.$color.'", "'.$status.'", "'.$text_in_order_history.'")');
		if($query=="1") {
			$msg="Status has been successfully added.";
			$_SESSION['success_msg']=$msg;
			setRedirect(ADMIN_URL.'order_item_status.php');
		} else {
			$_SESSION['order_item_status_prefill_data'] = $order_item_status_prefill_data;
			$msg='Sorry! something wrong updation failed.';
			$_SESSION['error_msg']=$msg;
			setRedirect(ADMIN_URL.'edit_order_item_status.php');
		}
	}
} elseif(isset($post['sbt_order'])) {
	foreach($post['ordering'] as $ordering_key => $ordering_val) {
		if($ordering_val>0) {
			$query = mysqli_query($db,"UPDATE order_item_status SET ordering='".$ordering_val."' WHERE id='".$ordering_key."'");
		}
	}
	if($query=="1") {
		$msg="Order(s) successfully saved.";
		$_SESSION['success_msg']=$msg;
	} else {
		$_SESSION['order_item_status_prefill_data'] = $order_item_status_prefill_data;
		$msg='Sorry! something wrong updation failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'order_item_status.php');
} else {
	setRedirect(ADMIN_URL.'order_item_status.php');
}
exit();
?>