<?php 
require_once("../_config/config.php");
require_once("../include/functions.php");

if(isset($post['d_id'])) {
	$query=mysqli_query($db,'DELETE FROM home_settings WHERE id="'.$post['d_id'].'" AND type!="inbuild"');
	if($query=="1"){
		$msg="Record successfully removed.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong delete failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'home_settings.php');
} elseif(isset($post['bulk_remove'])) {
	$ids_array = $post['ids'];
	if(!empty($ids_array)) {
		$removed_idd = array();
		foreach(explode(",",$ids_array) as $id_k=>$id_v) {
			$removed_idd[] = $id_v;
			$query=mysqli_query($db,'DELETE FROM home_settings WHERE id="'.$id_v.'" AND type!="inbuild"');
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
	setRedirect(ADMIN_URL.'brand.php');
} elseif(isset($post['p_id'])) {
	$query=mysqli_query($db,'UPDATE home_settings SET status="'.$post['published'].'" WHERE id="'.$post['p_id'].'"');
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
	setRedirect(ADMIN_URL.'home_settings.php');
} elseif(isset($post['update'])) {
	$title=real_escape_string($post['title']);
	$sub_title=real_escape_string($post['sub_title']);
	$intro_text=real_escape_string($post['intro_text']);
	$description=real_escape_string($post['description']);
	$section_color=$post['section_color'];
	$show_title=$post['show_title'];
	$show_sub_title=$post['show_sub_title'];
	$show_intro_text=$post['show_intro_text'];
	$show_description=$post['show_description'];
	$show_title=($show_title=='1'?'1':'0');
	$show_sub_title=($show_sub_title=='1'?'1':'0');
	$show_intro_text=($show_intro_text=='1'?'1':'0');
	$show_description=($show_description=='1'?'1':'0');
	$status = $post['status'];

	if($_FILES['section_image']['name']) {
		if(!file_exists('../../images/section/'))
			mkdir('../../images/section/',0777);

		$image_ext = pathinfo($_FILES['section_image']['name'],PATHINFO_EXTENSION);
		if($image_ext=="png" || $image_ext=="jpg" || $image_ext=="jpeg" || $image_ext=="gif") {
			if($post['old_section_image']!="")
				unlink('../../images/section/'.$post['old_section_image']);

			$image_tmp_name=$_FILES['section_image']['tmp_name'];
			$image_name=date('YmdHis').'.'.$image_ext;
			$imageupdate=', section_image="'.$image_name.'"';
			move_uploaded_file($image_tmp_name,'../../images/section/'.$image_name);
		} else {
			$msg="Image type must be png, jpg, jpeg, gif";
			$_SESSION['success_msg']=$msg;
			if($post['id']) {
				setRedirect(ADMIN_URL.'edit_home_settings.php?id='.$post['id']);
			} else {
				setRedirect(ADMIN_URL.'home_settings.php');
			}
			exit();
		}
	}

	if($post['id']) {
		$query=mysqli_query($db,'UPDATE home_settings SET section_color="'.$section_color.'" '.$imageupdate.', title="'.$title.'", sub_title="'.$sub_title.'", intro_text="'.$intro_text.'", description="'.$description.'", status="'.$status.'", show_title="'.$show_title.'", show_sub_title="'.$show_sub_title.'", show_intro_text="'.$show_intro_text.'", show_description="'.$show_description.'" WHERE id="'.$post['id'].'"');
		if($query=="1") {
			$msg="Settings has been successfully updated.";
			$_SESSION['success_msg']=$msg;
		} else {
			$msg='Sorry! something wrong updation failed.';
			$_SESSION['error_msg']=$msg;
		}
		setRedirect(ADMIN_URL.'edit_home_settings.php?id='.$post['id']);
	} else {
		$query=mysqli_query($db,'INSERT INTO home_settings(section_color, section_image, title, sub_title, intro_text, description, status, show_title, show_sub_title, show_intro_text, show_description) values("'.$section_color.'","'.$image_name.'","'.$title.'","'.$sub_title.'","'.$intro_text.'","'.$description.'","'.$status.'","'.$show_title.'","'.$show_sub_title.'","'.$show_intro_text.'","'.$show_description.'")');
		if($query=="1") {
			$msg="Settings has been successfully added.";
			$_SESSION['success_msg']=$msg;
			setRedirect(ADMIN_URL.'home_settings.php');
		} else {
			$msg='Sorry! something wrong updation failed.';
			$_SESSION['error_msg']=$msg;
			setRedirect(ADMIN_URL.'edit_home_settings.php');
		}
	}
} elseif($post['sbt_order']) {
	foreach($post['ordering'] as $ordering_key => $ordering_val) {
		if($ordering_val>0) {
			$query = mysqli_query($db,"UPDATE home_settings SET ordering='".$ordering_val."' WHERE id='".$ordering_key."'");
		}
	}
	if($query=="1") {
		$msg="Order(s) successfully saved.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong updation failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'home_settings.php');
} elseif($post['r_img_id']) {
	$query=mysqli_query($db,'SELECT section_image FROM home_settings WHERE id="'.$post['r_img_id'].'"');
	$home_settings_data=mysqli_fetch_assoc($query);

	mysqli_query($db,'UPDATE home_settings SET section_image="" WHERE id='.$post['r_img_id']);
	if($home_settings_data['section_image']!="")
		unlink('../../images/section/'.$home_settings_data['section_image']);

	setRedirect(ADMIN_URL.'edit_home_settings.php?id='.$post['id']);
} else {
	setRedirect(ADMIN_URL.'home_settings.php');
}
exit();
?>