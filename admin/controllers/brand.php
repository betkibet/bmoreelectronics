<?php 
require_once("../_config/config.php");
require_once("../include/functions.php");

if(isset($post['d_id'])) {
	$brand_q=mysqli_query($db,'SELECT image FROM brand WHERE id="'.$post['d_id'].'"');
	$brand_data=mysqli_fetch_assoc($brand_q);
	
	$query=mysqli_query($db,'DELETE FROM brand WHERE id="'.$post['d_id'].'" ');
	if($query=="1"){
		if($brand_data['image']!="")
			unlink('../../images/brand/'.$brand_data['image']);

		$msg="Record successfully removed.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong delete failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'brand.php');
} elseif(isset($post['bulk_remove'])) {
	$ids_array = $post['ids'];
	if(!empty($ids_array)) {
		$removed_idd = array();
		foreach(explode(",",$ids_array) as $id_k=>$id_v) {
			$removed_idd[] = $id_v;

			$brand_q=mysqli_query($db,'SELECT image FROM brand WHERE id="'.$id_v.'"');
			$brand_data=mysqli_fetch_assoc($brand_q);
			if($brand_data['image']!="")
				unlink('../../images/brand/'.$brand_data['image']);

			$query=mysqli_query($db,'DELETE FROM brand WHERE id="'.$id_v.'"');
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
	$query=mysqli_query($db,'UPDATE brand SET published="'.$post['published'].'" WHERE id="'.$post['p_id'].'"');
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
	setRedirect(ADMIN_URL.'brand.php');
} elseif(isset($post['update'])) {
	$title=real_escape_string($post['title']);
	$sub_title=real_escape_string($post['sub_title']);
	$short_description=real_escape_string($post['short_description']);
	$description=real_escape_string($post['description']);
	$published = $post['published'];
	$sef_url=createSlug($title);
	
	if($_FILES['image']['name']) {
		if(!file_exists('../../images/brand/'))
			mkdir('../../images/brand/',0777);

		$image_ext = pathinfo($_FILES['image']['name'],PATHINFO_EXTENSION);
		if($image_ext=="png" || $image_ext=="jpg" || $image_ext=="jpeg" || $image_ext=="gif") {
			if($post['old_image']!="")
				unlink('../../images/brand/'.$post['old_image']);

			$image_tmp_name=$_FILES['image']['tmp_name'];
			$image_name=date('YmdHis').'.'.$image_ext;
			$imageupdate=', image="'.$image_name.'"';
			move_uploaded_file($image_tmp_name,'../../images/brand/'.$image_name);
		} else {
			$msg="Image type must be png, jpg, jpeg, gif";
			$_SESSION['success_msg']=$msg;
			if($post['id']) {
				setRedirect(ADMIN_URL.'edit_brand.php?id='.$post['id']);
			} else {
				setRedirect(ADMIN_URL.'edit_brand.php');
			}
			exit();
		}
	}

	if($post['id']) {
		$query=mysqli_query($db,'UPDATE brand SET title="'.$title.'", sef_url="'.$sef_url.'" '.$imageupdate.', sub_title="'.$sub_title.'", short_description="'.$short_description.'", description="'.$description.'", published="'.$published.'" WHERE id="'.$post['id'].'"');
		if($query=="1") {
			$msg="Brand has been successfully updated.";
			$_SESSION['success_msg']=$msg;
		} else {
			$msg='Sorry! something wrong updation failed.';
			$_SESSION['error_msg']=$msg;
		}
		setRedirect(ADMIN_URL.'edit_brand.php?id='.$post['id']);
	} else {
		$query=mysqli_query($db,'INSERT INTO brand(title, sef_url, image, sub_title, short_description, description, published) values("'.$title.'","'.$sef_url.'","'.$image_name.'", "'.$sub_title.'", "'.$short_description.'","'.$description.'","'.$published.'")');
		if($query=="1") {
			$msg="Brand has been successfully added.";
			$_SESSION['success_msg']=$msg;
			setRedirect(ADMIN_URL.'brand.php');
		} else {
			$msg='Sorry! something wrong updation failed.';
			$_SESSION['error_msg']=$msg;
			setRedirect(ADMIN_URL.'edit_brand.php');
		}
	}
} elseif(isset($post['sbt_order'])) {
	foreach($post['ordering'] as $ordering_key => $ordering_val) {
		if($ordering_val>0) {
			$query = mysqli_query($db,"UPDATE brand SET ordering='".$ordering_val."' WHERE id='".$ordering_key."'");
		}
	}
	if($query=="1") {
		$msg="Order(s) successfully saved.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong updation failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'brand.php');
} elseif(isset($post['r_img_id'])) {
	$get_behand_data=mysqli_query($db,'SELECT image FROM brand WHERE id="'.$post['r_img_id'].'"');
	$brand_data=mysqli_fetch_assoc($get_behand_data);

	$del_logo=mysqli_query($db,'UPDATE brand SET image="" WHERE id='.$post['r_img_id']);
	if($brand_data['image']!="")
		unlink('../../images/brand/'.$brand_data['image']);

	setRedirect(ADMIN_URL.'edit_brand.php?id='.$post['id']);
} else {
	setRedirect(ADMIN_URL.'brand.php');
}
exit();
?>