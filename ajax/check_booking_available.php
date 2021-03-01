<?php
require_once("../admin/_config/config.php");
require_once("../admin/include/functions.php");
require_once("common.php");

$time = $post['time'];
if($time) {
	$shipping_method = $post['shipping_method'];

	$date = $post['date'];
	if($date) {
		$exp_date = explode("/",$date);
		$appt_date = $exp_date['2'].'-'.$exp_date['0'].'-'.$exp_date['1'];
	}

	$o_mysql_params = "";
	$location_id = $post['location_id'];
	if($location_id>0) {
		$query=mysqli_query($db,"SELECT * FROM locations WHERE published=1 AND id='".$location_id."'");
		$location_data=mysqli_fetch_assoc($query);
		$lctn_allowed_num_of_booking_per_time_slot = trim($location_data['allowed_num_of_booking_per_time_slot']);
		$lctn_num_of_booking_per_time_slot = trim($location_data['num_of_booking_per_time_slot']);
		if(count($location_data)>0 && $lctn_allowed_num_of_booking_per_time_slot == '1' && $lctn_num_of_booking_per_time_slot>0) {
			$allowed_num_of_booking_per_time_slot = $lctn_allowed_num_of_booking_per_time_slot;
			$num_of_booking_per_time_slot = $lctn_num_of_booking_per_time_slot;
			$o_mysql_params .= " AND store_location_id='".$location_id."'";
		}
	}

	$response = array();
	$q = mysqli_query($db,"SELECT * FROM orders WHERE sales_pack='".$shipping_method."' AND store_date='".$appt_date."' AND store_time='".$time."'".$o_mysql_params."");
	$num_of_appointments = mysqli_num_rows($q);
	if($num_of_appointments>0 
		&& $allowed_num_of_booking_per_time_slot == '1' 
		&& $num_of_booking_per_time_slot>0 
		&& ($num_of_booking_per_time_slot<=$num_of_appointments)) 
	{
		$response['num_of_appointments'] = $num_of_appointments;
		$response['msg'] = "You are not able to booking in this time. so you can please try different time.";
		$response['booking_allow'] = false;
	} else {
		$response['num_of_appointments'] = 0;
		$response['msg'] = "";
		$response['booking_allow'] = true;
	}
	echo json_encode($response);
}
?>