<?php
require_once("../admin/_config/config.php");
require_once("../admin/include/functions.php");
require_once("common.php");

$postcode = $_POST['postcode'];
if($postcode!="") {
	$response = array();
	
	$demand_pickup_zipcodes_settings = get_demand_pickup_zipcodes_settings();		
	if(!empty($demand_pickup_zipcodes_settings['zipcodes'])) {
		$zip_arr = explode(',',$demand_pickup_zipcodes_settings['zipcodes']);
	}
	
	$is_exist_data = false;
	if(in_array($postcode,$zip_arr)) {
		$is_exist_data = true;
	}

	if($is_exist_data) {
		$response['msg'] = 'Matched';
		$response['exist'] = true;
	} else {
		$response['msg'] = "";
		$response['exist'] = false;
	}
} else {
	$response['msg'] = "";
	$response['exist'] = false;
}
echo json_encode($response);
?>