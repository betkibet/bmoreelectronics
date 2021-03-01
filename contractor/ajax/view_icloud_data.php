<?php
require_once("../../admin/_config/config.php");
require_once("../../admin/include/functions.php");
require_once("common.php");
check_contractor_staff_auth("ajax");

$response = array();

$item_id = $post['item_id'];
$date = date("Y-m-d H:i:s");

if($item_id == "") {
	exit;
} else {
	$query=mysqli_query($db,"SELECT * FROM order_items WHERE id='".$item_id."'");
	$order_items_data=mysqli_fetch_assoc($query);
	if($order_items_data['device_check_info']!="") {
		$response['message'] = "You have successfully received";
		$response['status'] = "success";
		$response['icloud_status'] = $icloud_status;
		$response['html'] = $order_items_data['device_check_info'];
	} else {
		$response['message'] = "Something went wrong!!!";
		$response['status'] = "fail";
	}
}

echo json_encode($response);
exit;
?>