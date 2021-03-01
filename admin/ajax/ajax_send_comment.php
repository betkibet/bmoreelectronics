<?php
require_once("../_config/config.php");
require_once("../include/functions.php");
require_once("common.php");
check_admin_staff_auth("ajax");

$response = array();

$post = $_REQUEST;
$contractor_id = $post['contractor_id'];
$order_id = $post['order_id'];
$comment=real_escape_string($post['comment']);
$c_status=$post['c_status'];
$date = date("Y-m-d H:i:s");

if($comment=="" && $c_status=="") {
	$response['message'] = "Please fill up mandatory fields.";
	$response['status'] = "fail";
} else {			
	if($order_id!="" && $comment!="") {
		$c_query = mysqli_query($db,"INSERT INTO comments(`order_id`, `contractor_id`, `comment`, `order_status`, `thread_type`, `date`) VALUES('".$order_id."','".$contractor_id."','".$comment."','".$c_status."','admin','".$date."')");
		if($c_query == '1') {
			$response['message'] = "You have successfully send";
			$response['status'] = "success";
			$response['is_comment'] = "yes";
			$response['comments'] = $comment;
			$response['date'] = format_date($date).' '.format_time($date); //date("m/d/y h:i:s a",strtotime($date));
			
			if($c_status>0) {
				mysqli_query($db,"UPDATE orders SET `status`='".$c_status."' WHERE order_id='".$order_id."'");

				$order_status_query=mysqli_query($db,"SELECT * FROM order_status WHERE id='".$c_status."'");
				$order_status_data = mysqli_fetch_assoc($order_status_query);
				$response['status_id'] = $order_status_data['id'];
				$response['status_name'] = ($order_status_data['name']!=""?$order_status_data['name']:'');
			} else {
				$response['status_id'] = '';
				$response['status_name'] = '';
			}
		} else {
			$response['message'] = "Something went wrong!!!";
			$response['status'] = "fail";
		}
	}
}

echo json_encode($response);
exit;
?>