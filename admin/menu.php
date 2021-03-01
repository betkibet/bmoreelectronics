<?php
$file_name="menu";

//Header section
require_once("include/header.php");

if(isset($_GET['position']) && $_GET['position']) {
	$_SESSION['menu_filter_data'] = array('position'=>$_GET['position']);
	//setRedirect(ADMIN_URL.'menu.php');
}

if(isset($_POST['search'])) {
	$_SESSION['menu_filter_data'] = array('position'=>$post['position']);
	setRedirect(ADMIN_URL.'menu.php');
}

if(isset($_GET['clear'])) {
	unset($_SESSION['menu_filter_data']);
	setRedirect(ADMIN_URL.'menu.php');
}

if(isset($_SESSION['menu_filter_data'])) {
	$menu_filter_data = $_SESSION['menu_filter_data'];
	$post['position'] = $menu_filter_data['position'];
}

$menu_position = $post['position'];

//Fetch data list of pages
$menu_p_query = mysqli_query($db,"SELECT COUNT(*) AS num_of_menus FROM menus WHERE position='".$menu_position."'");
$menu_p_data = mysqli_fetch_assoc($menu_p_query);
$pages->set_total($menu_p_data['num_of_menus']);

$query = mysqli_query($db,"SELECT m.*, p.title AS page_title, p.url AS page_url FROM menus AS m LEFT JOIN pages AS p ON p.id=m.page_id WHERE m.position='".$menu_position."' ORDER BY m.ordering ASC ".$pages->get_limit()."");

function get_parent_menu_data($id) {
	global $db;
	$query = mysqli_query($db,"SELECT m.*, p.title AS page_title, p.url AS page_url FROM menus AS m LEFT JOIN pages AS p ON p.id=m.page_id WHERE m.id='".$id."'");
	$parent_data = mysqli_fetch_assoc($query);
	return $parent_data;
}

//Template file
require_once("views/menu/menu.php"); ?>
