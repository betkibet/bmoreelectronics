<?php
//Get model data list based on deviceID
function get_model_data_list($device_id, $devices_id, $cat_id) {
	global $db;
	$response = array();

	$sql_whr = "";
	if($device_id>0) {
		 $sql_whr = "AND m.device_id='".$device_id."'";
	}
	elseif($devices_id>0) {
		 $sql_whr = "AND m.device_id IN(".$devices_id.")";
	}
	elseif($cat_id>0) {
		 $sql_whr = "AND m.cat_id='".$cat_id."'";
	}
	
	$model_query=mysqli_query($db,"SELECT m.*, d.title AS device_title, d.sef_url AS device_sef_url, b.title AS brand_title FROM mobile AS m LEFT JOIN devices AS d ON d.id=m.device_id LEFT JOIN brand AS b ON b.id=m.brand_id WHERE m.published=1 ".$sql_whr." ORDER BY m.id DESC");
	$model_num_of_rows = mysqli_num_rows($model_query);
	if($model_num_of_rows>0) {
		while($model_list=mysqli_fetch_assoc($model_query)) {
			$response[] = $model_list;
		}
	}
	return $response;
}

function get_single_model_data($req_model_id) {
	global $db;
	$response = array();
	$query=mysqli_query($db,"SELECT m.*, d.title AS device_title, d.sef_url, b.sef_url AS brand_sef_url, b.title AS brand_title FROM mobile AS m LEFT JOIN devices AS d ON d.id=m.device_id LEFT JOIN brand AS b ON b.id=m.brand_id LEFT JOIN categories AS c ON c.id=m.cat_id WHERE m.id='".$req_model_id."'");
	$response = mysqli_fetch_assoc($query);
	return $response;
}

function get_device_brands_data_list($device_id, $devices_id = '') {
	global $db;
	$response = array();

	$sql_whr = "";
	if($device_id>0) {
		 $sql_whr = "AND m.device_id='".$device_id."'";
	} elseif(trim($devices_id)!='') {
		 $sql_whr = "AND m.device_id IN(".$devices_id.")";
	}

	$model_query=mysqli_query($db,"SELECT m.*, d.title AS device_title, d.sef_url AS device_sef_url, b.title AS brand_title, b.sef_url AS brand_sef_url, b.image AS brand_img FROM mobile AS m LEFT JOIN devices AS d ON d.id=m.device_id LEFT JOIN brand AS b ON b.id=m.brand_id WHERE m.published=1 AND m.brand_id>0 ".$sql_whr." GROUP BY m.brand_id ORDER BY m.id DESC");
	$model_num_of_rows = mysqli_num_rows($model_query);
	if($model_num_of_rows>0) {
		while($model_list=mysqli_fetch_assoc($model_query)) {
			$response[] = $model_list;
		}
	}
	return $response;
}

function get_device_brand_models_data_list($device_id, $brand_id) {
	global $db;
	$response = array();

	$sql_whr = "";
	if($device_id>0) {
		 $sql_whr .= "AND m.device_id='".$device_id."'";
	}
	if($brand_id>0) {
		 $sql_whr .= "AND m.brand_id='".$brand_id."'";
	}

	$model_query=mysqli_query($db,"SELECT m.*, d.title AS device_title, d.sef_url AS device_sef_url, b.title AS brand_title FROM mobile AS m LEFT JOIN devices AS d ON d.id=m.device_id LEFT JOIN brand AS b ON b.id=m.brand_id LEFT JOIN categories AS c ON c.id=m.cat_id WHERE m.published=1 ".$sql_whr." ORDER BY m.id DESC");
	$model_num_of_rows = mysqli_num_rows($model_query);
	if($model_num_of_rows>0) {
		while($model_list=mysqli_fetch_assoc($model_query)) {
			$response[] = $model_list;
		}
	}
	return $response;
}

function get_brand_device_models_data_list($brand_id, $device_id) {
	global $db;
	$response = array();

	$sql_whr = "";
	if($brand_id>0) {
		 //$sql_whr .= "AND d.brand_id='".$brand_id."'";
		 $sql_whr .= "AND m.brand_id='".$brand_id."'";
	}
	if($device_id>0) {
		 $sql_whr .= "AND m.device_id='".$device_id."'";
	}

	//$model_query=mysqli_query($db,"SELECT m.*, d.title AS device_title, d.sef_url AS device_sef_url, b.title AS brand_title FROM mobile AS m LEFT JOIN devices AS d ON d.id=m.device_id LEFT JOIN brand AS b ON b.id=d.brand_id WHERE m.published=1 ".$sql_whr." ORDER BY m.id DESC");
	$model_query=mysqli_query($db,"SELECT m.*, d.title AS device_title, d.sef_url AS device_sef_url, b.title AS brand_title FROM mobile AS m LEFT JOIN devices AS d ON d.id=m.device_id LEFT JOIN brand AS b ON b.id=m.brand_id LEFT JOIN categories AS c ON c.id=m.cat_id WHERE m.published=1 ".$sql_whr." ORDER BY m.id DESC");
	$model_num_of_rows = mysqli_num_rows($model_query);
	if($model_num_of_rows>0) {
		while($model_list=mysqli_fetch_assoc($model_query)) {
			$response[] = $model_list;
		}
	}
	return $response;
}
?>

