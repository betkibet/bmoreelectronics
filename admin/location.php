<?php 
$file_name="location";

//Header section
require_once("include/header.php");

if(isset($_POST['search'])) {
	$_SESSION['location_filter_data'] = array('filter_by'=>$post['filter_by']);
	setRedirect(ADMIN_URL.'location.php');
}

if(isset($_GET['clear'])) {
	unset($_SESSION['location_filter_data']);
	setRedirect(ADMIN_URL.'location.php');
}

if(isset($_SESSION['location_filter_data'])) {
	$location_filter_data = $_SESSION['location_filter_data'];
	$post['filter_by'] = $location_filter_data['filter_by'];
}

$filter_by = "";
if($post['filter_by']) {
	$filter_by .= " AND name LIKE '%".$post['filter_by']."%'";
}

$order_by = "";
if($post['oid_shorting']) {
	$order_by .= " ORDER BY ordering ".$post['oid_shorting'];
} elseif($post['name_shorting']) {
	$order_by .= " ORDER BY name ".$post['name_shorting'];
} else {
	$order_by .= " ORDER BY id ASC";
}

//Get num of locations for pagination
$location_p_query=mysqli_query($db,"SELECT COUNT(*) AS num_of_locations FROM locations WHERE 1 ".$filter_by."");
$location_p_data = mysqli_fetch_assoc($location_p_query);
$pages->set_total($location_p_data['num_of_locations']);

//Fetch locations data
$query=mysqli_query($db,"SELECT * FROM locations WHERE 1 ".$filter_by." ".$order_by." ".$pages->get_limit()."");

$url_params_array = array(
	'oid_shorting' => $post['oid_shorting'],
	'name_shorting' => $post['name_shorting'],
	'filter_by' => $post['filter_by']
);

unset($url_params_array['oid_shorting']);
unset($url_params_array['name_shorting']);

$url_params = http_build_query($url_params_array);
$url_params = ($url_params?'&'.$url_params:'');

$shorting_label = 'Select to sort by this column';

//Template file
require_once("views/location/location.php");

//Footer section
require_once("include/footer.php"); ?>
