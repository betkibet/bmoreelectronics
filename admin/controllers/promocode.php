<?php 
require_once("../_config/config.php");
require_once("../include/functions.php");

if(isset($post['r_id'])) {
	$id = $post['r_id'];
	if($id) {
		$query="DELETE FROM promocode WHERE id='".$id."'";
		mysqli_query($db,$query);
		$msg="promocode has been successfully removed";
		$_SESSION['success_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'promocode.php');
} elseif(isset($post['add'])) {
	$name=real_escape_string($post['name']);
	$promocode=real_escape_string($post['promocode']);
	$description=real_escape_string($post['description']);
	$never_expire=real_escape_string($post['never_expire']);
	$discount_type=real_escape_string($post['discount_type']);
	$multiple_act_by_same_cust=real_escape_string($post['multiple_act_by_same_cust']);
	$multi_act_by_same_cust_qty=real_escape_string($post['multi_act_by_same_cust_qty']);
	$act_by_cust=real_escape_string($post['act_by_cust']);

	/*$exp_from_date=explode("/",$post['from_date']);
	$from_date=$exp_from_date[2].'-'.$exp_from_date[0].'-'.$exp_from_date[1];

	$exp_to_date=explode("/",$post['to_date']);
	$to_date=$exp_to_date[2].'-'.$exp_to_date[0].'-'.$exp_to_date[1];*/
	
	$from_date = $post['from_date'];
	$to_date = $post['to_date'];
	
	if($from_date!='' && $to_date!='' && $from_date>$to_date) {
		$msg="Expire date must be greater than of equal to from date";
		$_SESSION['error_msg']=$msg;
		setRedirect(ADMIN_URL.'add_promocode.php');
		exit();	
	}
	
	$discount=real_escape_string($post['discount']);
	$status=$post['status'];
	if($promocode && $description && $from_date && $to_date && $discount) {
		$query="SELECT * FROM promocode WHERE LOWER(promocode)='".strtolower($promocode)."'";
		$result=mysqli_query($db,$query);
		$exist_promocode_data=mysqli_num_rows($result);
		if($exist_promocode_data>0) {
			$msg="This promocode already exist so please try another";
			$_SESSION['success_msg']=$msg;
			setRedirect(ADMIN_URL.'add_promocode.php');
			exit();
		}
		
		if($_FILES['image']['name']) {
			if(!file_exists('../../images/promocodes/'))
				mkdir('../../images/promocodes/',0777);
	
			$image_ext = pathinfo($_FILES['image']['name'],PATHINFO_EXTENSION);
			if($image_ext=="png" || $image_ext=="jpg" || $image_ext=="jpeg" || $image_ext=="gif") {
				$image_tmp_name=$_FILES['image']['tmp_name'];
				$image_name=date('YmdHis').'.'.$image_ext;
				move_uploaded_file($image_tmp_name,'../../images/promocodes/'.$image_name);
			} else {
				$msg="Image type must be png, jpg, jpeg, gif";
				$_SESSION['success_msg']=$msg;
				setRedirect(ADMIN_URL.'add_promocode.php');
				exit();
			}
		}
		
		$query="INSERT promocode(name, promocode, description, image, `from_date`, `to_date`, discount, status, never_expire, discount_type, multiple_act_by_same_cust, multi_act_by_same_cust_qty, act_by_cust) VALUES('".$name."','".$promocode."','".$description."','".$image_name."','".$from_date."','".$to_date."','".$discount."','".$status."','".$never_expire."','".$discount_type."','".$multiple_act_by_same_cust."','".$multi_act_by_same_cust_qty."','".$act_by_cust."')";
		mysqli_query($db,$query);
		$msg="promocode has been successfully saved";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg="Please enter valid information";
		$_SESSION['success_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'promocode.php');
} elseif(isset($post['edit'])) {
	$id = $post['id'];
	$name=real_escape_string($post['name']);
	$promocode=real_escape_string($post['promocode']);
	$description=real_escape_string($post['description']);
	$never_expire=intval($post['never_expire']);
	$discount_type=real_escape_string($post['discount_type']);
	$multiple_act_by_same_cust=intval($post['multiple_act_by_same_cust']);
	
	$multi_act_by_same_cust_qty=real_escape_string($post['multi_act_by_same_cust_qty']);
	$act_by_cust=real_escape_string($post['act_by_cust']);

	/*$exp_from_date=explode("/",$post['from_date']);
	$from_date=$exp_from_date[2].'-'.$exp_from_date[0].'-'.$exp_from_date[1];

	$exp_to_date=explode("/",$post['to_date']);
	$to_date=$exp_to_date[2].'-'.$exp_to_date[0].'-'.$exp_to_date[1];*/
	
	$from_date = $post['from_date'];
	$to_date = $post['to_date'];
	
	if($from_date!='' && $to_date!='' && $from_date>$to_date) {
		$msg="Expire date must be greater than of equal to from date";
		$_SESSION['error_msg']=$msg;
		setRedirect(ADMIN_URL.'edit_promocode.php?id='.$id);
		exit();
	}

	$discount=real_escape_string($post['discount']);
	$status=$post['status'];
	if($promocode && $description && $from_date && $to_date && $discount) {
		$query="SELECT * FROM promocode WHERE LOWER(promocode)='".strtolower($promocode)."' AND id!='".$id."'";
		$result=mysqli_query($db,$query);
		$exist_promocode_data=mysqli_fetch_assoc($result);
		if(!empty($exist_promocode_data)>0) {
			$msg="This promocode already exist so please try another";
			$_SESSION['success_msg']=$msg;
			setRedirect(ADMIN_URL.'edit_promocode.php?id='.$id);
			exit();
		}

		if($_FILES['image']['name']) {
			if(!file_exists('../../images/promocodes/'))
				mkdir('../../images/promocodes/',0777);
	
			$image_ext = pathinfo($_FILES['image']['name'],PATHINFO_EXTENSION);
			if($image_ext=="png" || $image_ext=="jpg" || $image_ext=="jpeg" || $image_ext=="gif") {
				if($post['old_image']!="")
					unlink('../../images/promocodes/'.$post['old_image']);
	
				$image_tmp_name=$_FILES['image']['tmp_name'];
				$image_name=date('YmdHis').'.'.$image_ext;
				$imageupdate=", image='".$image_name."'";
				move_uploaded_file($image_tmp_name,'../../images/promocodes/'.$image_name);
			} else {
				$msg="Image type must be png, jpg, jpeg, gif";
				$_SESSION['success_msg']=$msg;
				if($id) {
					setRedirect(ADMIN_URL.'edit_promocode.php?id='.$id);
				} else {
					setRedirect(ADMIN_URL.'edit_promocode.php');
				}
				exit();
			}
		}

		$query="UPDATE promocode SET name='".$name."', promocode='".$promocode."', description='".$description."'".$imageupdate.", `from_date`='".$from_date."', `to_date`='".$to_date."', discount='".$discount."', status='".$status."', never_expire='".$never_expire."', discount_type='".$discount_type."', multiple_act_by_same_cust='".$multiple_act_by_same_cust."', multi_act_by_same_cust_qty='".$multi_act_by_same_cust_qty."', act_by_cust='".$act_by_cust."' WHERE id='".$id."'";
		mysqli_query($db,$query);
		$msg="promocode has been successfully updated";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg="Please enter valid information";
		$_SESSION['success_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'edit_promocode.php?id='.$id);
} elseif($post['r_img_id']) {
	$prm_q=mysqli_query($db,'SELECT image FROM promocode WHERE id="'.$post['r_img_id'].'"');
	$promocode_data=mysqli_fetch_assoc($prm_q);

	mysqli_query($db,'UPDATE promocode SET image="" WHERE id='.$post['r_img_id']);
	if($promocode_data['image']!="")
		unlink('../../images/promocodes/'.$promocode_data['image']);

	setRedirect(ADMIN_URL.'edit_promocode.php?id='.$post['id']);
} else {
	setRedirect(ADMIN_URL.'promocode.php');
}
exit();
?>
