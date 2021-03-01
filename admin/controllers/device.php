<?php 
require_once("../_config/config.php");
require_once("../include/functions.php");
require_once("common.php");

if(isset($post['c_id'])) {
	$qry=mysqli_query($db,"SELECT * FROM devices WHERE id='".$post['c_id']."'");
	$device_data=mysqli_fetch_assoc($qry);
	$device_data['title'] = $device_data['title'].' - Copy';
	$device_data['published'] = 0;
	$device_data['device_img'] = '';
	$sef_url = createSlug($device_data['title']);
	$device_data['sub_title'] = real_escape_string($device_data['sub_title']);
	$device_data['short_description'] = real_escape_string($device_data['short_description']);
	$device_data['description'] = real_escape_string($device_data['description']);

	$svd_query = mysqli_query($db,"INSERT INTO devices(`sef_url`, `meta_title`, `meta_desc`, `meta_keywords`, `title`, `price`, `device_img`, `device_icon`, `sub_title`, `short_description`, `description`, `popular_device`, `published`, `ordering`) values ('".$sef_url."','".$device_data['meta_title']."','".$device_data['meta_desc']."','".$device_data['meta_keywords']."','".$device_data['title']."','".$device_data['price']."','".$device_data['device_img']."','".$device_data['device_icon']."','".$device_data['sub_title']."','".$device_data['short_description']."','".$device_data['description']."','".$device_data['popular_device']."','".$device_data['published']."','".$device_data['ordering']."')");
	if($svd_query == '1') {
		$last_insert_id = mysqli_insert_id($db);
		$msg="Device has been successfully cloned.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong delete failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'edit_device.php?id='.$last_insert_id);
	exit();
} elseif(isset($post['d_id'])) {
	$device_q=mysqli_query($db,'SELECT device_img FROM devices WHERE id="'.$post['d_id'].'"');
	$device_data=mysqli_fetch_assoc($device_q);
	
	$query=mysqli_query($db,'DELETE FROM devices WHERE id="'.$post['d_id'].'" ');
	if($query=="1"){
		if($device_data['device_img']!="")
			unlink('../../images/device/'.$device_data['device_img']);

		$msg="Record successfully removed.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong delete failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'device.php');
} elseif(isset($post['bulk_remove'])) {
	$ids_array = $post['ids'];
	if(!empty($ids_array)) {
		$removed_idd = array();
		foreach(explode(",",$ids_array) as $id_k=>$id_v) {
			$removed_idd[] = $id_v;

			$device_q=mysqli_query($db,'SELECT device_img FROM devices WHERE id="'.$id_v.'"');
			$device_data=mysqli_fetch_assoc($device_q);
			if($device_data['device_img']!="")
				unlink('../../images/device/'.$device_data['device_img']);

			$query=mysqli_query($db,'DELETE FROM devices WHERE id="'.$id_v.'"');
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
	setRedirect(ADMIN_URL.'device.php');
} elseif(isset($post['p_id'])) {
	$query=mysqli_query($db,'UPDATE devices SET published="'.$post['published'].'" WHERE id="'.$post['p_id'].'"');
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
	setRedirect(ADMIN_URL.'device.php');
} elseif(isset($post['update'])) {
	$title=real_escape_string($post['title']);
	$sub_title=real_escape_string(str_replace("<p><br></p>","",$post['sub_title']));
	$sef_url=createSlug(real_escape_string($post['sef_url']));
	$meta_title=real_escape_string($post['meta_title']);
	$meta_desc=real_escape_string($post['meta_desc']);
	$meta_keywords=real_escape_string($post['meta_keywords']);
	$price=real_escape_string($post['price']);
	$short_description=real_escape_string(str_replace("<p><br></p>","",$post['short_description']));
	$description=real_escape_string(str_replace("<p><br></p>","",$post['description']));
	//$brand_id = $post['brand_id'];
	$published = $post['published'];
	$box_size = $post['box_size'];
	$models_show_in_footer = $post['models_show_in_footer'];
	
	//Check Valid SEF URL
	$is_valid_sef_url_arr = check_sef_url_validation($sef_url, $post['id'], "devices");
	if($is_valid_sef_url_arr['valid']!=true) {
		$msg='This sef url already exist so please use other.';
		$_SESSION['error_msg']=$msg;
		if($post['id']) {
			setRedirect(ADMIN_URL.'edit_device.php?id='.$post['id']);
		} else {
			setRedirect(ADMIN_URL.'edit_device.php');
		}
		exit();
	}
	
	if($_FILES['device_img']['name']) {
		if(!file_exists('../../images/device/'))
			mkdir('../../images/device/',0777);
			
		$image_ext = pathinfo($_FILES['device_img']['name'],PATHINFO_EXTENSION);
		if($image_ext=="png" || $image_ext=="jpg" || $image_ext=="jpeg" || $image_ext=="gif") {
			if($post['old_image']!="")
				unlink('../../images/device/'.$post['old_image']);
		
			$image_tmp_name=$_FILES['device_img']['tmp_name'];
			$image_name=date('YmdHis').'.'.$image_ext;
			$imageupdate=', device_img="'.$image_name.'"';
			move_uploaded_file($image_tmp_name,'../../images/device/'.$image_name);
		} else {
			$msg="Image type must be png, jpg, jpeg, gif, svg";
			$_SESSION['error_msg']=$msg;
			if($post['id']) {
				setRedirect(ADMIN_URL.'edit_device.php?id='.$post['id']);
			} else {
				setRedirect(ADMIN_URL.'edit_device.php');
			}
			exit();
		}
	}
	
	if($_FILES['device_icon']['name']) {
		if(!file_exists('../../images/device/'))
			mkdir('../../images/device/',0777);

		$icon_image_ext = pathinfo($_FILES['device_icon']['name'],PATHINFO_EXTENSION);
		if($icon_image_ext=="png" || $icon_image_ext=="jpg" || $icon_image_ext=="jpeg" || $icon_image_ext=="gif" || $icon_image_ext=="svg") {
			if($post['old_icon']!="")
				unlink('../../images/device/'.$post['old_icon']);

			$icon_image_tmp_name=$_FILES['device_icon']['tmp_name'];
			$icon_image_name='icon_'.date('YmdHis').'.'.$icon_image_ext;
			$icon_image_update=', device_icon="'.$icon_image_name.'"';
			move_uploaded_file($icon_image_tmp_name,'../../images/device/'.$icon_image_name);
		} else {
			$msg="Icon image type must be png, jpg, jpeg, gif, svg";
			$_SESSION['error_msg']=$msg;
			if($post['id']) {
				setRedirect(ADMIN_URL.'edit_device.php?id='.$post['id']);
			} else {
				setRedirect(ADMIN_URL.'edit_device.php');
			}
			exit();
		}
	}

	if($post['id']) {
		//brand_id="'.$brand_id.'", 
		$query=mysqli_query($db,'UPDATE devices SET title="'.$title.'", sub_title="'.$sub_title.'", sef_url="'.$sef_url.'", meta_title="'.$meta_title.'", meta_desc="'.$meta_desc.'", meta_keywords="'.$meta_keywords.'", price="'.$price.'" '.$imageupdate.$icon_image_update.', short_description="'.$short_description.'", description="'.$description.'", popular_device="'.$post['popular_device'].'", published="'.$published.'", box_size="'.$box_size.'", models_show_in_footer="'.$models_show_in_footer.'" WHERE id="'.$post['id'].'"');
		if($query=="1") {
			$msg="Device has been successfully updated.";
			$_SESSION['success_msg']=$msg;
		} else {
			$msg='Sorry! something wrong updation failed.';
			$_SESSION['error_msg']=$msg;
		}
		setRedirect(ADMIN_URL.'edit_device.php?id='.$post['id']);
	} else {
		//brand_id,   "'.$brand_id.'", 
		$query=mysqli_query($db,'INSERT INTO devices(title, sub_title, sef_url, meta_title, meta_desc, meta_keywords, price, device_img, device_icon, short_description, description, popular_device, published, box_size, models_show_in_footer) values("'.$title.'","'.$sub_title.'","'.$sef_url.'","'.$meta_title.'","'.$meta_desc.'","'.$meta_keywords.'","'.$price.'","'.$image_name.'","'.$icon_image_name.'","'.$short_description.'","'.$description.'","'.$post['popular_device'].'","'.$published.'","'.$box_size.'","'.$models_show_in_footer.'")');
		if($query=="1") {
			$msg="Device has been successfully added.";
			$_SESSION['success_msg']=$msg;
			setRedirect(ADMIN_URL.'device.php');
		} else {
			$msg='Sorry! something wrong updation failed.';
			$_SESSION['error_msg']=$msg;
			setRedirect(ADMIN_URL.'edit_device.php');
		}
	}
} elseif(isset($post['r_img_id'])) {
	$q=mysqli_query($db,'SELECT device_img FROM devices WHERE id="'.$post['r_img_id'].'"');
	$device_data=mysqli_fetch_assoc($q);

	mysqli_query($db,'UPDATE devices SET device_img="" WHERE id='.$post['r_img_id']);
	if($device_data['device_img']!="")
		unlink('../../images/device/'.$device_data['device_img']);

	setRedirect(ADMIN_URL.'edit_device.php?id='.$post['id']);
} elseif(isset($post['r_icon_id'])) {
	$q=mysqli_query($db,'SELECT device_icon FROM devices WHERE id="'.$post['r_icon_id'].'"');
	$device_data=mysqli_fetch_assoc($q);

	mysqli_query($db,'UPDATE devices SET device_icon="" WHERE id='.$post['r_icon_id']);
	if($device_data['device_icon']!="")
		unlink('../../images/device/'.$device_data['device_icon']);

	setRedirect(ADMIN_URL.'edit_device.php?id='.$post['id']);
} elseif(isset($post['sbt_order'])) {
	foreach($post['ordering'] as $ordering_key => $ordering_val) {
		if($ordering_val>0) {
			$query = mysqli_query($db,"UPDATE devices SET ordering='".$ordering_val."' WHERE id='".$ordering_key."'");
		}
	}
	if($query=="1") {
		$msg="Order(s) successfully saved.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong updation failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'device.php');
} else {
	setRedirect(ADMIN_URL.'device.php');
}
exit();
?>