<?php 
require_once("../_config/config.php");
require_once("../include/functions.php");

if(isset($post['d_id'])) {	
	$query=mysqli_query($db,'DELETE FROM reviews WHERE id="'.$post['d_id'].'" ');
	if($query=="1") {
		$msg="Record successfully removed.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong delete failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'review.php');
} elseif(isset($post['bulk_remove'])) {
	$ids_array = $post['ids'];
	if(!empty($ids_array)) {
		$removed_idd = array();
		foreach(explode(",",$ids_array) as $id_k=>$id_v) {
			$removed_idd[] = $id_v;
			$query=mysqli_query($db,'DELETE FROM reviews WHERE id="'.$id_v.'"');
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
	setRedirect(ADMIN_URL.'review.php');
} elseif(isset($post['active_id'])) {
	$query=mysqli_query($db,"UPDATE reviews SET status='1' WHERE id='".$post['active_id']."'");
	if($query=="1") {
		$msg="Review successfully Activated.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong delete failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'review.php');
} elseif(isset($post['inactive_id'])) {
	$query=mysqli_query($db,"UPDATE reviews SET status='0' WHERE id='".$post['inactive_id']."'");
	if($query=="1") {
		$msg="Review successfully Inactivated.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong delete failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'review.php');
} elseif($post['r_img_id']) {
	$query=mysqli_query($db,'SELECT photo FROM reviews WHERE id="'.$post['r_img_id'].'"');
	$review_data=mysqli_fetch_assoc($query);

	$del_logo=mysqli_query($db,'UPDATE reviews SET photo="" WHERE id='.$post['r_img_id']);
	if($review_data['photo']!="")
		unlink('../../images/review/'.$review_data['photo']);

	setRedirect(ADMIN_URL.'add_edit_review.php?id='.$post['id']);
} elseif(isset($post['add_update'])) {
	$name=real_escape_string($post['name']);
	$email=real_escape_string($post['email']);
	$country=real_escape_string($post['country']);
	$state=real_escape_string($post['state']);
	$city=real_escape_string($post['city']);
	$stars=real_escape_string($post['stars']);
	$title=real_escape_string($post['title']);
	$content=real_escape_string($post['content']);
	$status=$post['status'];

	$exp_date=explode("/",$post['date']);
	$date = $exp_date[2].'-'.$exp_date[0].'-'.$exp_date[1];

	if($_FILES['image']['name']) {
		if(!file_exists('../../images/review/'))
			mkdir('../../images/review/',0777);

		$image_ext = pathinfo($_FILES['image']['name'],PATHINFO_EXTENSION);
		if($image_ext=="png" || $image_ext=="jpg" || $image_ext=="jpeg" || $image_ext=="gif") {
			if($post['old_image']!="")
				unlink('../../images/review/'.$post['old_image']);

			$image_tmp_name=$_FILES['image']['tmp_name'];
			$image_name=date('YmdHis').'.'.$image_ext;
			$imageupdate=', photo="'.$image_name.'"';
			move_uploaded_file($image_tmp_name,'../../images/review/'.$image_name);
		} else {
			$msg="Image type must be png, jpg, jpeg, gif";
			$_SESSION['success_msg']=$msg;
			if($post['id']) {
				setRedirect(ADMIN_URL.'add_edit_review.php?id='.$post['id']);
			} else {
				setRedirect(ADMIN_URL.'add_edit_review.php');
			}
			exit();
		}
	}

	if($post['id']) {
		$query=mysqli_query($db,'UPDATE reviews SET name="'.$name.'", email="'.$email.'", country="'.$country.'", state="'.$state.'", city="'.$city.'", stars="'.$stars.'", title="'.$title.'", content="'.$content.'", status="'.$status.'"'.$imageupdate.' WHERE id="'.$post['id'].'"');
		if($query=="1") {
			$msg="Review has been successfully updated.";
			$_SESSION['success_msg']=$msg;
		} else {
			$msg='Sorry! something wrong updation failed.';
			$_SESSION['error_msg']=$msg;
		}
		setRedirect(ADMIN_URL.'add_edit_review.php?id='.$post['id']);
	} else {
		$query=mysqli_query($db,"INSERT INTO reviews(name, email, country, state, city, stars, title, content, date, status, photo) VALUES('".$name."','".$email."','".$country."','".$state."','".$city."','".$stars."','".$title."','".$content."','".date('Y-m-d H:i:s')."','".$status."','".$image_name."')");
		if($query=="1") {
			$msg="Review has been successfully added.";
			$_SESSION['success_msg']=$msg;
			setRedirect(ADMIN_URL.'review.php');
		} else {
			$msg='Sorry! something wrong updation failed.';
			$_SESSION['error_msg']=$msg;
			setRedirect(ADMIN_URL.'add_edit_review.php');
		}
	}
}
exit();
?>