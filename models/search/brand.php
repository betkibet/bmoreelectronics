<?php
//Get model data list based on brandID
function get_model_data_list($brand_id) {
	global $db;
	$response = array();
	$query=mysqli_query($db,"SELECT m.*, d.title AS device_title, d.sef_url, b.title AS brand_title FROM mobile AS m LEFT JOIN devices AS d ON d.id=m.device_id LEFT JOIN brand AS b ON b.id=m.brand_id LEFT JOIN categories AS c ON c.id=m.cat_id WHERE m.published=1 AND b.id='".$brand_id."' ORDER BY m.id DESC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($model_list=mysqli_fetch_assoc($query)) {
			$response[] = $model_list;
		}
	}
	return $response;
}

function get_num_of_model_data_exist($device_id) {
	global $db;
	
	$sql_whr = "";
	$sql_whr = "AND m.device_id='".$device_id."'";
	$model_query=mysqli_query($db,"SELECT m.*, d.title AS device_title, d.sef_url AS device_sef_url, b.title AS brand_title FROM mobile AS m LEFT JOIN devices AS d ON d.id=m.device_id LEFT JOIN brand AS b ON b.id=m.brand_id WHERE m.published=1 ".$sql_whr."");
	$model_num_of_rows = mysqli_num_rows($model_query);
	return $model_num_of_rows;
}

//Get device data list based on brandID
function get_brand_devices_data_list($brand_id) {
	global $db;
	$response = array();
	//$query=mysqli_query($db,"SELECT d.*, b.title AS brand_title, b.sef_url AS brand_sef_url FROM devices AS d LEFT JOIN brand AS b ON b.id=d.brand_id WHERE d.published=1 AND d.brand_id='".$brand_id."' AND b.id='".$brand_id."' ORDER BY d.ordering ASC");
	$query=mysqli_query($db,"SELECT d.*, b.title AS brand_title, b.sef_url AS brand_sef_url FROM devices AS d LEFT JOIN mobile AS m ON m.device_id=d.id LEFT JOIN brand AS b ON b.id=m.brand_id WHERE d.published=1 AND m.brand_id='".$brand_id."' AND b.id='".$brand_id."' GROUP BY m.device_id ORDER BY d.ordering ASC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($device_list=mysqli_fetch_assoc($query)) {
			$num_of_models = 0;
			$num_of_models = get_num_of_model_data_exist($device_list['id']);
			if($num_of_models>0) {
				$device_list['num_of_models'] = $num_of_models;
				$response[] = $device_list;
			}
		}
	}
	return $response;
}

function get_cat_brand_devices_data_list($cat_id,$brand_id) {
	global $db;
	$response = array();
	$query=mysqli_query($db,"SELECT d.*, b.title AS brand_title, b.sef_url AS brand_sef_url FROM devices AS d LEFT JOIN mobile AS m ON m.device_id=d.id LEFT JOIN brand AS b ON b.id=m.brand_id WHERE d.published=1 AND m.cat_id='".$cat_id."' AND m.brand_id='".$brand_id."' AND b.id='".$brand_id."' GROUP BY m.device_id ORDER BY d.ordering ASC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($device_list=mysqli_fetch_assoc($query)) {
			$num_of_models = 0;
			$num_of_models = get_num_of_model_data_exist($device_list['id']);
			if($num_of_models>0) {
				$device_list['num_of_models'] = $num_of_models;
				$response[] = $device_list;
			}
		}
	}
	return $response;
}

//Get model data list based on brandID
function get_c_b_d_model_data_list($brand_id, $cat_id, $device_id = 0) {
	global $db;
	$response = array();
	
	$sql_whr = "";
	if($device_id>0) {
		 $sql_whr .= " AND m.device_id='".$device_id."'";
	}
	if($cat_id>0) {
		 $sql_whr .= " AND m.cat_id='".$cat_id."'";
	}
	$query=mysqli_query($db,"SELECT m.*, d.title AS device_title, d.sef_url, b.title AS brand_title FROM mobile AS m LEFT JOIN devices AS d ON d.id=m.device_id LEFT JOIN brand AS b ON b.id=m.brand_id LEFT JOIN categories AS c ON c.id=m.cat_id WHERE m.published=1 AND m.brand_id='".$brand_id."' ".$sql_whr." ORDER BY m.id DESC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($model_list=mysqli_fetch_assoc($query)) {
			$response[] = $model_list;
		}
	}
	return $response;
}
?>

