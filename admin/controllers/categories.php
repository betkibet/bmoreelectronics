<?php 
require_once("../_config/config.php");
require_once("../include/functions.php");

if(isset($post['d_id'])) {
	$brand_q=mysqli_query($db,'SELECT image FROM categories WHERE id="'.$post['d_id'].'"');
	$brand_data=mysqli_fetch_assoc($brand_q);
	
	$query=mysqli_query($db,'DELETE FROM categories WHERE id="'.$post['d_id'].'" ');
	if($query=="1"){
		if($brand_data['image']!="")
			unlink('../../images/categories/'.$brand_data['image']);

		$msg="Delete Successfully.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong Delete failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'device_categories.php');
} elseif(isset($post['p_id'])) {
	$query=mysqli_query($db,'UPDATE categories SET published="'.$post['published'].'" WHERE id="'.$post['p_id'].'"');
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
	setRedirect(ADMIN_URL.'device_categories.php');
} elseif(isset($post['update'])) {
	$title=real_escape_string($post['title']);
	$description=real_escape_string($post['description']);
	$published = $post['published'];
	
	if($_FILES['image']['name']) {
		if(!file_exists('../../images/categories/'))
			mkdir('../../images/categories/',0777);

		$image_ext = pathinfo($_FILES['image']['name'],PATHINFO_EXTENSION);
		if($image_ext=="png" || $image_ext=="jpg" || $image_ext=="jpeg" || $image_ext=="gif") {
			if($post['old_image']!="")
				unlink('../../images/categories/'.$post['old_image']);

			$image_tmp_name=$_FILES['image']['tmp_name'];
			$image_name=date('YmdHis').'.'.$image_ext;
			$imageupdate=', image="'.$image_name.'"';
			move_uploaded_file($image_tmp_name,'../../images/categories/'.$image_name);
		} else {
			$msg="Image type must be png, jpg, jpeg, gif";
			$_SESSION['success_msg']=$msg;
			if($post['id']) {
				setRedirect(ADMIN_URL.'edit_category.php?id='.$post['id']);
			} else {
				setRedirect(ADMIN_URL.'edit_category.php');
			}
			exit();
		}
	}

	if($post['id']) {
		$query=mysqli_query($db,'UPDATE categories SET title="'.$title.'" '.$imageupdate.', description="'.$description.'", published="'.$published.'" WHERE id="'.$post['id'].'"');
		if($query=="1") {
			$msg="Category has been successfully updated.";
			$_SESSION['success_msg']=$msg;
		} else {
			$msg='Sorry! something wrong updation failed.';
			$_SESSION['error_msg']=$msg;
		}
		setRedirect(ADMIN_URL.'edit_category.php?id='.$post['id']);
	} else {
		$query=mysqli_query($db,'INSERT INTO categories(title, image, description, published) values("'.$title.'","'.$image_name.'","'.$description.'","'.$published.'")');
		if($query=="1") {
			$msg="Category has been successfully added.";
			$_SESSION['success_msg']=$msg;
			setRedirect(ADMIN_URL.'device_categories.php');
		} else {
			$msg='Sorry! something wrong updation failed.';
			$_SESSION['error_msg']=$msg;
			setRedirect(ADMIN_URL.'edit_category.php');
		}
	}
} elseif($post['r_img_id']) {
	$get_behand_data=mysqli_query($db,'SELECT image FROM categories WHERE id="'.$post['r_img_id'].'"');
	$brand_data=mysqli_fetch_assoc($get_behand_data);

	$del_logo=mysqli_query($db,'UPDATE categories SET image="" WHERE id='.$post['r_img_id']);
	if($brand_data['image']!="")
		unlink('../../images/categories/'.$brand_data['image']);

	setRedirect(ADMIN_URL.'edit_category.php?id='.$post['id']);
} else {
	setRedirect(ADMIN_URL.'device_categories.php');
}
exit();
?>