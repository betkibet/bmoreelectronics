<?php
$file_name="custom_page";

//Header section
require_once("include/header.php");

if(isset($_POST['search'])) {
	$_SESSION['custom_page_filter_data'] = array('filter_by'=>$post['filter_by']);
	setRedirect(ADMIN_URL.'custom_page.php');
}

if(isset($_GET['clear'])) {
	unset($_SESSION['custom_page_filter_data']);
	setRedirect(ADMIN_URL.'custom_page.php');
}

if(isset($_SESSION['custom_page_filter_data'])) {
	$custom_page_filter_data = $_SESSION['custom_page_filter_data'];
	$post['filter_by'] = $custom_page_filter_data['filter_by'];
}

$order_by = "";
$filter_by = "";

if($post['filter_by']) {
	$filter_by .= " AND title LIKE '%".$post['filter_by']."%'";
}

if($post['id_shorting']) {
	$order_by .= " ORDER BY id ".$post['id_shorting'];
} elseif($post['title_shorting']) {
	$order_by .= " ORDER BY title ".$post['title_shorting'];
} else {
	$order_by .= " ORDER BY id ASC";
}

//Fetch data list of pages
$page_p_query = mysqli_query($db,"SELECT COUNT(*) AS num_of_pages FROM pages WHERE type!='inbuild' ".$filter_by."");
$page_p_data = mysqli_fetch_assoc($page_p_query);
$pages->set_total($page_p_data['num_of_pages']);

$query = mysqli_query($db,"SELECT * FROM pages WHERE type!='inbuild' ".$filter_by." ".$order_by." ".$pages->get_limit()."");
//ORDER BY type DESC, id ASC

function saved_inbuild_page_data($slug) {
	global $db;
	$i_query=mysqli_query($db,"SELECT * FROM pages WHERE slug='".$slug."'");
	$saved_inbuild_page_data=mysqli_fetch_assoc($i_query);
	return $saved_inbuild_page_data;
}

//Array of inbuild pages so we can set fix condition of those pages
$inbuild_page_array = array(
	array('name'=>'Home','title'=>'Home','slug'=>'home','url'=>''),
	array('name'=>'Reviews','title'=>'Reviews','slug'=>'reviews','url'=>'reviews'),
	array('name'=>'Affiliates','title'=>'Affiliates','slug'=>'affiliates','url'=>'affiliates'),
	array('name'=>'Contact us','title'=>'Contact us','slug'=>'contact','url'=>'contact'),
	array('name'=>'Signup','title'=>'Signup','slug'=>'signup','url'=>'signup'),
	array('name'=>'Login','title'=>'Login','slug'=>'login','url'=>'login'),
	array('name'=>'Blog','title'=>'Blog','slug'=>'blog','url'=>'blog'),
	array('name'=>'Terms & Conditions','title'=>'Terms & Conditions','slug'=>'terms-and-conditions','url'=>'terms-and-conditions'),
	array('name'=>'Review Form','title'=>'Review Form','slug'=>'review-form','url'=>'review-form'),
	array('name'=>'Bulk Order Form','title'=>'Bulk Order Form','slug'=>'bulk-order-form','url'=>'bulk-order-form'),
	array('name'=>'Order Track','title'=>'Order Track','slug'=>'order-track','url'=>'order-track'),
	array('name'=>'Instant Sell Model','title'=>'Instant Sell Model','slug'=>'instant-sell-model','url'=>'instant-sell-model'),
	array('name'=>'Offers','title'=>'Offers','slug'=>'offers','url'=>'offers')
);

foreach($inbuild_page_array as $inbuild_page_data) {
	$inbuild_page_slug[] = $inbuild_page_data['slug'];
}

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
require_once("views/page/custom_page.php"); ?>
