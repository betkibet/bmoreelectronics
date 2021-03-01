<?php
$file_name="menu";

//Header section
require_once("include/header.php");

$menu_position = $post['position'];
$id = $post['id'];

if($id<=0 && $prms_menu_add!='1') {
	setRedirect(ADMIN_URL.'profile.php');
	exit();
} elseif($id>0 && $prms_menu_edit!='1') {
	setRedirect(ADMIN_URL.'profile.php');
	exit();
}

//Fetch single page data based on page id
$query=mysqli_query($db,'SELECT * FROM menus WHERE id="'.$id.'"');
$menu_data=mysqli_fetch_assoc($query);
$menu_data = _dt_parse_array($menu_data);

//Template file
require_once("views/menu/edit_menu.php"); ?>
