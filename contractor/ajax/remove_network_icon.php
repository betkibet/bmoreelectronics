<?php
require_once("../../admin/_config/config.php");
require_once("../../admin/include/functions.php");
require_once("common.php");
check_contractor_staff_auth("ajax");

$response = array();
$field_id = $post['field_id'];
if($field_id == "") {
	exit;
} else {
	$query = mysqli_query($db,"UPDATE `models_networks` SET `network_icon`='' WHERE id='".$field_id."'");
	if($query=='1') {
		$response['message'] = "Icon successfully removed";
		$response['status'] = "success";
	} else {
		$response['message'] = "Something went wrong!!!";
		$response['status'] = "fail";
	}
}

echo json_encode($response);
exit;
?>