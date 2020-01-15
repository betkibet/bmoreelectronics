<?php 
require_once("../_config/config.php");
require_once("../include/functions.php");

if(isset($post['d_id'])) {
	$query=mysqli_query($db,'DELETE FROM menus WHERE id="'.$post['d_id'].'"');
	if($query=="1"){
		$msg="Menu has been successfully removed.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong delete failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'menu.php'.($post['position']?'?position='.$post['position']:''));
} elseif(isset($post['p_id'])) {
	$query=mysqli_query($db,'UPDATE menus SET status="'.$post['published'].'" WHERE id="'.$post['p_id'].'"');
	if($query=="1"){
		if($post['status']==1)
			$msg="Menu has been successfully published.";
		elseif($post['status']==0)
			$msg="Menu has been successfully unpublished.";
			
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong delete failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'menu.php'.($post['position']?'?position='.$post['position']:''));
} elseif(isset($post['add_edit'])) {
	$id = $post['id'];
	$page_id=$post['page_id'];
	
	$is_custom_url=$post['is_custom_url'];
	if($is_custom_url == '1') {
		$url=real_escape_string($post['url']);
	} else {
		$url=createSlug(real_escape_string($post['url']));
	}
	
	$is_open_new_window=$post['is_open_new_window'];
	$menu_name=$post['menu_name'];
	$css_menu_class=$post['css_menu_class'];
	$css_menu_fa_icon=$post['css_menu_fa_icon'];
	$parent=real_escape_string($post['parent']);
	$ordering=real_escape_string($post['ordering']);
	$status=real_escape_string($post['status']);
	$date = date('Y-m-d H:i:s');
	$position=$post['position'];

	$qry=mysqli_query($db,"SELECT * FROM menus WHERE url='".$url."' AND url!='' AND id!='".$id."'");
	$exist_data=mysqli_fetch_assoc($qry);
	if(!empty($exist_data)) {
		$msg='This sef url already exist so please use other.';
		$_SESSION['error_msg']=$msg;
		if($id) {
			setRedirect(ADMIN_URL.'edit_menu.php?id='.$id.($post['position']?'&position='.$post['position']:''));
		} else {
			setRedirect(ADMIN_URL.'edit_menu.php'.($post['position']?'?position='.$post['position']:''));
		}
		exit();
	}
		
	if($id) {
		$query=mysqli_query($db,"UPDATE `menus` SET `page_id`='".$page_id."',`url`='".$url."',`is_custom_url`='".$is_custom_url."',`is_open_new_window`='".$is_open_new_window."',`menu_name`='".$menu_name."',`css_menu_class`='".$css_menu_class."',`css_menu_fa_icon`='".$css_menu_fa_icon."',`parent`='".$parent."',`position`='".$position."',`ordering`='".$ordering."',`status`='".$status."',`updated_date`='".$date."' WHERE id='".$id."'");
		if($query=="1") {
			$msg="Menu has been successfully updated.";
			$_SESSION['success_msg']=$msg;
		} else {
			$msg='Sorry! something wrong updation failed.';
			$_SESSION['error_msg']=$msg;
		}
		setRedirect(ADMIN_URL.'edit_menu.php?id='.$id.($post['position']?'&position='.$post['position']:''));
	} else {
		$query=mysqli_query($db,"INSERT INTO menus(`page_id`,`url`,`is_custom_url`,`is_open_new_window`,`menu_name`,`css_menu_class`,`css_menu_fa_icon`,`parent`,`position`,`ordering`,`status`,`added_date`) values('".$page_id."','".$url."','".$is_custom_url."','".$is_open_new_window."','".$menu_name."','".$css_menu_class."','".$css_menu_fa_icon."','".$parent."','".$position."','".$ordering."','".$status."','".$date."')");
		if($query=="1") {
			$msg="Menu has been successfully added.";
			$_SESSION['success_msg']=$msg;
			setRedirect(ADMIN_URL.'menu.php'.($post['position']?'?position='.$post['position']:''));
		} else {
			$msg='Sorry! something wrong save failed.';
			$_SESSION['error_msg']=$msg;
			setRedirect(ADMIN_URL.'edit_menu.php'.($post['position']?'?position='.$post['position']:''));
		}
	}
} else if(isset($post['sbt_order'])) {
	foreach($post['ordering'] as $ordering_key => $ordering_val) {
		if($ordering_val>0) {
			$query = mysqli_query($db,"UPDATE menus SET ordering='".$ordering_val."' WHERE id='".$ordering_key."'");
		}
	}
	if($query=="1") {
		$msg="Order(s) successfully saved.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong updation failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'menu.php'.($post['position']?'?position='.$post['position']:''));
} else {
	setRedirect(ADMIN_URL.'menu.php'.($post['position']?'?position='.$post['position']:''));
}
exit();
?>
