<?php
$file_name="brand";

//Header section
require_once("include/header.php");

if(isset($_POST['search'])) {
	$_SESSION['brand_filter_data'] = array('filter_by'=>$post['filter_by']);
	setRedirect(ADMIN_URL.'brand.php');
}

if(isset($_GET['clear'])) {
	unset($_SESSION['brand_filter_data']);
	setRedirect(ADMIN_URL.'brand.php');
}

if(isset($_SESSION['brand_filter_data'])) {
	$brand_filter_data = $_SESSION['brand_filter_data'];
	$post['filter_by'] = $brand_filter_data['filter_by'];
}

$filter_by = "";
if($post['filter_by']) {
	$filter_by .= " AND title LIKE '%".$post['filter_by']."%'";
}

$order_by = "";
if($post['oid_shorting']) {
	$order_by .= " ORDER BY ordering ".$post['oid_shorting'];
} elseif($post['title_shorting']) {
	$order_by .= " ORDER BY title ".$post['title_shorting'];
} else {
	$order_by .= " ORDER BY ordering ASC";
}

//Get num of brands for pagination
$brand_p_query=mysqli_query($db,"SELECT COUNT(*) AS num_of_brands FROM brand WHERE 1 ".$filter_by."");
$brand_p_data = mysqli_fetch_assoc($brand_p_query);
$pages->set_total($brand_p_data['num_of_brands']);

//Fetch brands data
$query=mysqli_query($db,"SELECT * FROM brand WHERE 1 ".$filter_by." ".$order_by." ".$pages->get_limit()."");

$url_params_array = array(
	'oid_shorting' => $post['oid_shorting'],
	'title_shorting' => $post['title_shorting'],
	'filter_by' => $post['filter_by']
);

unset($url_params_array['oid_shorting']);
unset($url_params_array['title_shorting']);

$url_params = http_build_query($url_params_array);
$url_params = ($url_params?'&'.$url_params:'');

$shorting_label = 'Select to sort by this column';

//Template file
require_once("views/brand/brand.php");

//Footer section
// require_once("include/footer.php"); ?>
