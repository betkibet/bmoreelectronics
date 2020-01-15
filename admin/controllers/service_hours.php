<?php 
require_once("../_config/config.php");
require_once("../include/functions.php");

if(isset($post['update'])) {

	$officehours_location_id = 0;
	
	$open_time = $post['open_time'];
	foreach($open_time as $key=>$value) {
		$explode_open_time =explode('_',$key);
		if($officehours_location_id == $explode_open_time[1]) { 
			$open_time_list[$explode_open_time[0]] = $value;	
		}
	}
	$open_time = $open_time_list;
	
	$open_time_zone = $post['open_time_zone'];
	foreach($open_time_zone as $key=>$value) {
		$explode_open_time_zone =explode('_',$key);
		if($officehours_location_id == $explode_open_time_zone[1]) { 
			$open_time_zone_list[$explode_open_time_zone[0]] = $value;	
		}
	}
	$open_time_zone = $open_time_zone_list;
	
	$close_time = $post['close_time'];
	foreach($close_time as $key=>$value) {
		$explode_close_time =explode('_',$key);
		if($officehours_location_id == $explode_close_time[1]) { 
			$close_time_list[$explode_close_time[0]] = $value;	
		}
	}
	$close_time = $close_time_list;
	
	$close_time_zone = $post['close_time_zone'];
	foreach($close_time_zone as $key=>$value) {
		$explode_close_time_zone =explode('_',$key);
		if($officehours_location_id == $explode_close_time_zone[1]) { 
			$close_time_zone_list[$explode_close_time_zone[0]] = $value;	
		}
	}
	$close_time_zone = $close_time_zone_list;
	
	$closed = $post['closed'];
	foreach($closed as $key=>$value) {
		$explode_closed =explode('_',$key);
		if($officehours_location_id == $explode_closed[1]) { 
			$closed_list[$explode_closed[0]] = $value;	
		}
	}
	$closed = $closed_list;
	
	$open_time = json_encode($open_time);
	$open_time_zone = json_encode($open_time_zone);
	$close_time = json_encode($close_time);
	$close_time_zone = json_encode($close_time_zone);
	$is_close = json_encode($closed);
	
	/*echo '<pre>';
	print_r($post);
	exit;*/
	
	$query=mysqli_query($db,"UPDATE service_hours SET open_time='".$open_time."', open_time_zone='".$open_time_zone."', close_time='".$close_time."', close_time_zone='".$close_time_zone."', is_close='".$is_close."' ORDER BY id DESC");
	if($query=="1") {
		$msg="Service hours has been successfully updated.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong updation failed.';
		$_SESSION['error_msg']=$msg;
	}
	setRedirect(ADMIN_URL.'service_hours.php');
} else {
	setRedirect(ADMIN_URL.'service_hours.php');
}
exit();
?>