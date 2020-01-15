<?php 
require_once("../_config/config.php");
require_once("../include/functions.php");

if(isset($post['d_id'])) {
	$sql_cus_fld = "select id from custom_fields where custom_group_id in (".$post['d_id'].")";
	$exe_cus_fld = mysqli_query($db,$sql_cus_fld);
	$no_of_fields = mysqli_num_rows($exe_cus_fld);
	if($no_of_fields>0){
		while($row_cus_fld = mysqli_fetch_assoc($exe_cus_fld)){
			$sql_cus_opt = "delete from custom_options where field_id = '".$row_cus_fld['id']."'";
			$exe_cus_opt = mysqli_query($db,$sql_cus_opt);
		}
		mysqli_query($db,"delete from custom_fields where custom_group_id in (".$post['d_id'].")");
	}
	
	$sql = "delete from custom_group where id in (".$post['d_id'].")";
    $query = mysqli_query($db,$sql);
	if($query=="1") {
		$msg="Record successfully removed.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong delete failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'custom_fields.php');
} elseif(isset($post['bulk_remove'])) {
	$ids_array = $post['ids'];
	if(!empty($ids_array)) {
		$removed_idd = array();
		foreach(explode(",",$ids_array) as $id_k=>$id_v) {
			$removed_idd[] = $id_v;

			$sql_cus_fld = "select id from custom_fields where custom_group_id in (".$id_v.")";
			$exe_cus_fld = mysqli_query($db,$sql_cus_fld);
			$no_of_fields = mysqli_num_rows($exe_cus_fld);
			if($no_of_fields>0){
				while($row_cus_fld = mysqli_fetch_assoc($exe_cus_fld)){
					$sql_cus_opt = "delete from custom_options where field_id = '".$row_cus_fld['id']."'";
					$exe_cus_opt = mysqli_query($db,$sql_cus_opt);
				}
				mysqli_query($db,"delete from custom_fields where custom_group_id in (".$id_v.")");
			}

			$sql = "delete from custom_group where id in (".$id_v.")";
			$query = mysqli_query($db,$sql);
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
	setRedirect(ADMIN_URL.'custom_fields.php');
} elseif(isset($post['p_id'])) {
	$query=mysqli_query($db,'UPDATE groups SET published="'.$post['published'].'" WHERE id="'.$post['p_id'].'"');
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
	setRedirect(ADMIN_URL.'custom_fields.php');
} else {
	setRedirect(ADMIN_URL.'custom_fields.php');
}
exit();
?>