<?php 
require_once("../_config/config.php");
require_once("../include/functions.php");
require_once("common.php");
check_admin_staff_auth();

if(isset($post['d_id'])) {
	$query=mysqli_query($db,'DELETE FROM locations WHERE id="'.$post['d_id'].'" ');
	if($query=="1") {
		$msg="Record successfully removed.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong delete failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'location.php');
} elseif(isset($post['bulk_remove'])) {
	$ids_array = $post['ids'];
	if(!empty($ids_array)) {
		$removed_idd = array();
		foreach(explode(",",$ids_array) as $id_k=>$id_v) {
			$removed_idd[] = $id_v;
			$query=mysqli_query($db,'DELETE FROM locations WHERE id="'.$id_v.'"');
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
	setRedirect(ADMIN_URL.'location.php');
} elseif(isset($post['p_id'])) {
	$query=mysqli_query($db,'UPDATE locations SET published="'.$post['published'].'" WHERE id="'.$post['p_id'].'"');
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
	setRedirect(ADMIN_URL.'location.php');
} elseif(isset($post['update'])) {
	$name=real_escape_string($post['name']);
	$address=real_escape_string($post['address']);
	$country=real_escape_string($post['country']);
	$state=real_escape_string($post['state']);
	$city=real_escape_string($post['city']);
	$zipcode=real_escape_string($post['zipcode']);
	$email=real_escape_string($post['email']);
	$cc_email=real_escape_string($post['cc_email']);
	$phone=real_escape_string($post['phone']);
	$start_time=real_escape_string($post['start_time']);
	$end_time=real_escape_string($post['end_time']);
	$time_interval=real_escape_string($post['time_interval']);
	$published = $post['published'];
	$google_cal_api = $post['google_cal_api'];
	$is_show_in_store_shipping = $post['is_show_in_store_shipping'];
	$is_show_in_starbucks_shipping = $post['is_show_in_starbucks_shipping'];
	$shipping_type = $post['shipping_type'];
	$show_appt_datetime_selection_in_place_order = $post['show_appt_datetime_selection_in_place_order'];
	$show_working_hours_in_place_order = $post['show_working_hours_in_place_order'];
	
	if($post['id']>0) {
		$return_url = ADMIN_URL.'edit_location.php?id='.$post['id'];
	} else {
		$return_url = ADMIN_URL.'edit_location.php';
	}
	
	$h_start_time = date("H",strtotime($start_time));
	$h_end_time = date("H",strtotime($end_time));
	if($start_time!="" && $end_time!="" && ($h_start_time>=$h_end_time)) {
		$msg="Appt. end time must me greater than Appt. start time";
		$_SESSION['error_msg']=$msg;
		setRedirect($return_url);
		exit();
	}
		
	$allowed_num_of_booking_per_time_slot=$post['allowed_num_of_booking_per_time_slot'];
	$num_of_booking_per_time_slot=$post['num_of_booking_per_time_slot'];
	
	$customer_address=$address.' '.$city.' '.$state.' '.$zipcode;
	$customer_address = str_replace(" ", "+", $customer_address);
	//$json = file_get_contents("https://maps.google.com/maps/api/geocode/json?address=$customer_address&sensor=false&key=".$map_key);
	$json = get_curl_data("https://maps.google.com/maps/api/geocode/json?address=$customer_address&sensor=false&key=".$map_key);
	$json = json_decode($json);
	$lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
	$long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};

	$company_lat='';
	$company_lng='';
	if(!empty($long))
		$company_lng=$long;
		
	if(!empty($lat))
		$company_lat=$lat;

	function save_location_data($location_id,$post) {
		global $db;
		
		$open_time = json_encode($post['open_time']);
		$close_time = json_encode($post['close_time']);
		$is_close = json_encode($post['closed']);

		$query=mysqli_query($db,"SELECT * FROM service_hours WHERE location_id='".$location_id."'");
		$service_hours_data=mysqli_fetch_assoc($query);
		if(empty($service_hours_data)) {
			mysqli_query($db,"INSERT INTO service_hours(location_id, open_time, close_time, is_close) VALUES('".$location_id."','".$open_time."','".$close_time."','".$is_close."')");
		} else {
			mysqli_query($db,"UPDATE service_hours SET open_time='".$open_time."', close_time='".$close_time."', is_close='".$is_close."' WHERE location_id='".$location_id."'");
		}
	}

	if($post['id']>0) {
		$query=mysqli_query($db,"UPDATE locations SET name='".$name."', address='".$address."', country='".$country."', state='".$state."', city='".$city."', zipcode='".$zipcode."', email='".$email."', cc_email='".$cc_email."', phone='".$phone."', start_time='".$start_time."', end_time='".$end_time."', time_interval='".$time_interval."', updated_date='".date('Y-m-d H:i:s')."', published='".$published."', google_cal_api='".$google_cal_api."', lat='".$company_lat."', lng='".$company_lng."', allowed_num_of_booking_per_time_slot='".$allowed_num_of_booking_per_time_slot."', num_of_booking_per_time_slot='".$num_of_booking_per_time_slot."', is_show_in_store_shipping='".$is_show_in_store_shipping."', is_show_in_starbucks_shipping='".$is_show_in_starbucks_shipping."', shipping_type='".$shipping_type."', show_appt_datetime_selection_in_place_order='".$show_appt_datetime_selection_in_place_order."', show_working_hours_in_place_order='".$show_working_hours_in_place_order."' WHERE id='".$post['id']."'");
		if($query=="1") {
			$location_id = $post['id'];
			save_location_data($location_id,$post);
			
			$msg="Location has been successfully updated.";
			$_SESSION['success_msg']=$msg;
		} else {
			$msg='Sorry! something wrong updation failed.';
			$_SESSION['error_msg']=$msg;
		}
		setRedirect($return_url);
	} else {
		$query=mysqli_query($db,"INSERT INTO locations(name, address, country, state, city, zipcode, email, cc_email, phone, start_time, end_time, time_interval, added_date, published, google_cal_api, lat, lng, allowed_num_of_booking_per_time_slot, num_of_booking_per_time_slot, is_show_in_store_shipping, is_show_in_starbucks_shipping, shipping_type, show_appt_datetime_selection_in_place_order, show_working_hours_in_place_order) VALUES('".$name."','".$address."','".$country."','".$state."','".$city."','".$zipcode."','".$email."','".$cc_email."','".$phone."','".$start_time."','".$end_time."','".$time_interval."','".date('Y-m-d H:i:s')."','".$published."', '".$google_cal_api."', '".$company_lat."', '".$company_lng."', '".$allowed_num_of_booking_per_time_slot."', '".$num_of_booking_per_time_slot."', '".$is_show_in_store_shipping."', '".$is_show_in_starbucks_shipping."', '".$shipping_type."', '".$show_appt_datetime_selection_in_place_order."', '".$show_working_hours_in_place_order."')");
		if($query=="1") {
			$location_id = mysqli_insert_id($db);
			save_location_data($location_id,$post);
			
			$msg="Location has been successfully added.";
			$_SESSION['success_msg']=$msg;
			setRedirect(ADMIN_URL.'location.php');
		} else {
			$msg='Sorry! something wrong updation failed.';
			$_SESSION['error_msg']=$msg;
			setRedirect($return_url);
		}
	}
} elseif(isset($post['sbt_order'])) {
	foreach($post['ordering'] as $ordering_key => $ordering_val) {
		if($ordering_val>0) {
			$query = mysqli_query($db,"UPDATE locations SET ordering='".$ordering_val."' WHERE id='".$ordering_key."'");
		}
	}
	if($query=="1") {
		$msg="Order(s) successfully saved.";
		$_SESSION['success_msg']=$msg;
	} else {
		$_SESSION['location_prefill_data'] = $location_prefill_data;
		$msg='Sorry! something wrong updation failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'location.php');
} else {
	setRedirect(ADMIN_URL.'location.php');
}
exit();
?>