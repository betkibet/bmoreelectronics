<?php
$file_name="system_page";

//Header section
require_once("include/header.php");

$id = $post['id'];

if($id<=0 && $prms_page_add!='1') {
	setRedirect(ADMIN_URL.'profile.php');
	exit();
} elseif($id>0 && $prms_page_edit!='1') {
	setRedirect(ADMIN_URL.'profile.php');
	exit();
}

//Fetch single page data based on page id
$query=mysqli_query($db,'SELECT * FROM pages WHERE id="'.$id.'"');
$page_data=mysqli_fetch_assoc($query);
$page_data = _dt_parse_array($page_data);
$exp_position=(array)json_decode((isset($page_data['position'])?$page_data['position']:''));
$menu_name = isset($page_data['menu_name'])?$page_data['menu_name']:'';
$title = isset($page_data['title'])?$page_data['title']:'';
$url = isset($page_data['url'])?$page_data['url']:'';
$finl_url = ($url?$url:'');

//Fetch device list
$devices_data=mysqli_query($db,'SELECT * FROM devices WHERE published=1');

//Template file
require_once("views/page/edit_system_page.php"); ?>

