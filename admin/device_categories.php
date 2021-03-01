<?php
$file_name="device_categories";

//Header section
require_once("include/header.php");

if(isset($_POST['search'])) {
	$_SESSION['category_filter_data'] = array('filter_by'=>$post['filter_by']);
	setRedirect(ADMIN_URL.'device_categories.php');
}

if(isset($_GET['clear'])) {
	unset($_SESSION['category_filter_data']);
	setRedirect(ADMIN_URL.'device_categories.php');
}

if(isset($_SESSION['category_filter_data'])) {
	$category_filter_data = $_SESSION['category_filter_data'];
	$post['filter_by'] = $category_filter_data['filter_by'];
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

//Get num of categories for pagination
$category_p_query=mysqli_query($db,"SELECT COUNT(*) AS num_of_categories FROM categories WHERE 1 ".$filter_by."");
$category_p_data = mysqli_fetch_assoc($category_p_query);
$pages->set_total($category_p_data['num_of_categories']);

//Fetch categories data
$query=mysqli_query($db,"SELECT * FROM categories WHERE 1 ".$filter_by." ".$order_by." ".$pages->get_limit()."");

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
require_once("views/categories/categories.php"); ?>
