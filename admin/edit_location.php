<?php 
$file_name="location";

//Header section
require_once("include/header.php");
 
error_reporting(E_ERROR | E_PARSE);

$id = $post['id'];

//Fetch signle editable location data
$get_behand_data=mysqli_query($db,'SELECT * FROM locations WHERE id="'.$id.'"');
$location_data=mysqli_fetch_assoc($get_behand_data);

$query=mysqli_query($db,"SELECT * FROM service_hours WHERE location_id='".$location_data['id']."'");
$service_hours_data=mysqli_fetch_assoc($query);
$open_time=json_decode($service_hours_data['open_time']);
$close_time=json_decode($service_hours_data['close_time']);
$closed=json_decode($service_hours_data['is_close']);

if(isset($_SESSION['location_prefill_data'])) {
	$order_status_data = $_SESSION['location_prefill_data'];
	unset($_SESSION['location_prefill_data']);
}

//Template file
require_once("views/location/edit_location.php");

//Footer section
require_once("include/footer.php"); ?>
