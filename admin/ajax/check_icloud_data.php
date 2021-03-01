<?php
require_once("../_config/config.php");
require_once("../include/functions.php");
require_once("common.php");
check_admin_staff_auth("ajax");

$response = array();

$item_id = $post['item_id'];
$imei_number = $post['imei_number'];
$date = date("Y-m-d H:i:s");

if($item_id == "") {
	exit;
} else {
	mysqli_query($db,"UPDATE `order_items` SET `imei_number`='".$imei_number."' WHERE id='".$item_id."'");

	$query=mysqli_query($db,"SELECT * FROM order_items WHERE id='".$item_id."'");
	$order_items_data=mysqli_fetch_assoc($query);
	if($order_items_data['imei_number']!="") {
		$imei_serial_number = trim($order_items_data['imei_number']);
		if($imei_serial_number!="" && $imei_api_key!="") {
			//$proimei_url = "https://proimei.info/en/prepaid/api/".$imei_api_key."/".$imei_serial_number."/fmip";
			$proimei_url = "https://sickw.com/api.php?format=json&key=".$imei_api_key."&imei=".$imei_serial_number."&service=103";
			$proimei_data = get_data_using_curl($proimei_url);
			//print_r($proimei_data);
			$icloud_status = $proimei_data['iCloud Status'];

			$html = $proimei_data['result'];
			/*$html .= "<b>Model Description</b>:".$proimei_data['Model Description'];
			$html .= "<br><b>Model</b>:".$proimei_data['Model'];
			$html .= "<br><b>IMEI</b>:".$proimei_data['IMEI'];
			$html .= "<br><b>MEID</b>:".$proimei_data['MEID'];
			$html .= "<br><b>Serial</b>:".$proimei_data['Serial'];
			$html .= "<br><b>iCloud Lock</b>:".$proimei_data['iCloud Lock'];
			$html .= "<br><b>iCloud Status</b>:".$proimei_data['iCloud Status'];
			$html .= "<br><b>Purchase Country</b>:".$proimei_data['Purchase Country'];
			$html .= "<br><b>Coverage Status</b>:".$proimei_data['Coverage Status'];
			$html .= "<br><b>Estimated Purchase Date</b>:".$proimei_data['Estimated Purchase Date'];
			$html .= "<br><b>Sim-Lock</b>:".$proimei_data['Sim-Lock'];*/
		}

		if($proimei_data['error']!="") {
			$response['message'] = "<br>Error: ".$proimei_data['error'];
			$response['status'] = "fail";
			$response['icloud_status'] = "error";
			$response['html'] = '';
		} else {
			mysqli_query($db,"UPDATE `order_items` SET `device_check_info`='".$html."' WHERE id='".$item_id."'");
			//mysqli_query($db,"UPDATE `inventory` SET `imei_number`='".$imei_number."', `device_check_info`='".$html."' WHERE item_id='".$item_id."'");
			
			$response['message'] = "You have successfully received";
			$response['status'] = "success";
			$response['icloud_status'] = $icloud_status;
			$response['html'] = $html;
		}
	} else {
		$response['message'] = "Something went wrong!!!";
		$response['status'] = "fail";
	}
}

echo json_encode($response);
exit;
?>