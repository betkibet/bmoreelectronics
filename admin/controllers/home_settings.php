<?php 
require_once("../_config/config.php");
require_once("../include/functions.php");
require_once("common.php");
check_admin_staff_auth();

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
	if(!empty($post['item_title'])) {	
		foreach($post['item_title'] as $i_key=>$i_value) {
			if(trim($_FILES['item_image']['name'][$i_key])) {
				if(!file_exists('../../images/section/'))
					mkdir('../../images/section/',0777);

				$item_image_ext = pathinfo($_FILES['item_image']['name'][$i_key],PATHINFO_EXTENSION);
				if($item_image_ext=="png" || $item_image_ext=="jpg" || $item_image_ext=="jpeg" || $item_image_ext=="gif") {
					$item_image_tmp_name=$_FILES['item_image']['tmp_name'][$i_key];
					$item_icon=$i_key.date('YmdHis').'.'.$item_image_ext;
					move_uploaded_file($item_image_tmp_name,'../../images/section/'.$item_icon);

					if($post['old_item_image'][$i_key]!="") {
						unlink('../../images/section/'.$post['old_item_image'][$i_key]);
					}
				} else {
					$msg="Image type must be png, jpg, jpeg, gif";
					$_SESSION['success_msg']=$msg;
					if($post['id']) {
						setRedirect(ADMIN_URL.'edit_home_settings.php?id='.$post['id']);
					} else {
						setRedirect(ADMIN_URL.'edit_home_settings.php');
					}
					exit();
				}
			} else {
				$item_icon = $post['old_item_image'][$i_key];
			}
			
			$items[] = array('item_title'=>$i_value,
				'item_sub_title'=>$post['item_sub_title'][$i_key],
				'use_title_as_button'=>$post['use_title_as_button'][$i_key],
				'button_url'=>$post['button_url'][$i_key],
				'item_description'=>$post['item_description'][$i_key],
				'item_icon_type'=>$post['item_icon_type'][$i_key],
				'item_fa_icon'=>$post['item_fa_icon'][$i_key],
				'item_image'=>$item_icon,
				'item_ordering'=>($post['item_ordering'][$i_key]>0?$post['item_ordering'][$i_key]:0));
		}
		$item_data = real_escape_string(json_encode($items));
	}
	
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
	$show_search_model_box=$post['show_search_model_box'];
	$show_search_model_box=($show_search_model_box=='1'?'1':'0');
	$status = $post['status'];

	if($_FILES['section_image']['name']) {
		if(!file_exists('../../images/section/'))
			mkdir('../../images/section/',0777);

		$image_ext = pathinfo($_FILES['section_image']['name'],PATHINFO_EXTENSION);
		if($image_ext=="png" || $image_ext=="jpg" || $image_ext=="jpeg" || $image_ext=="gif" || $image_ext=="mp4" || $image_ext=="3gp" || $image_ext=="mov" || $image_ext=="wmv" || $image_ext=="flv" || $image_ext=="avi") {
			if($post['old_section_image']!="")
				unlink('../../images/section/'.$post['old_section_image']);

			$image_tmp_name=$_FILES['section_image']['tmp_name'];
			$image_name=date('YmdHis').'.'.$image_ext;
			$imageupdate=', section_image="'.$image_name.'"';
			move_uploaded_file($image_tmp_name,'../../images/section/'.$image_name);
		} else {
			$msg="Image type must be png, jpg, jpeg, gif, mp4, 3gp, mov, wmv, flv, avi";
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
		$query=mysqli_query($db,'UPDATE home_settings SET section_color="'.$section_color.'" '.$imageupdate.', title="'.$title.'", sub_title="'.$sub_title.'", intro_text="'.$intro_text.'", description="'.$description.'", status="'.$status.'", show_title="'.$show_title.'", show_sub_title="'.$show_sub_title.'", show_intro_text="'.$show_intro_text.'", show_description="'.$show_description.'", items="'.$item_data.'", show_search_model_box="'.$show_search_model_box.'" WHERE id="'.$post['id'].'"');
		if($query=="1") {
			$msg="Settings has been successfully updated.";
			$_SESSION['success_msg']=$msg;
		} else {
			$msg='Sorry! something wrong updation failed.';
			$_SESSION['error_msg']=$msg;
		}
		setRedirect(ADMIN_URL.'edit_home_settings.php?id='.$post['id']);
	} else {
		$query=mysqli_query($db,'INSERT INTO home_settings(section_color, section_image, title, sub_title, intro_text, description, status, show_title, show_sub_title, show_intro_text, show_description, items, show_search_model_box) values("'.$section_color.'","'.$image_name.'","'.$title.'","'.$sub_title.'","'.$intro_text.'","'.$description.'","'.$status.'","'.$show_title.'","'.$show_sub_title.'","'.$show_intro_text.'","'.$show_description.'","'.$item_data.'","'.$show_search_model_box.'")');
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