<?php
$file_name="categories";

//Header section
require_once("include/header.php");

$id = $post['id'];

if($id<=0 && $prms_blog_add!='1') {
	setRedirect(ADMIN_URL.'profile.php');
	exit();
} elseif($id>0 && $prms_blog_edit!='1') {
	setRedirect(ADMIN_URL.'profile.php');
	exit();
}

//Fetch single data of category based on category id, If already added
$query=mysqli_query($db,'SELECT catID, catTitle FROM blog_cats WHERE catID="'.$id.'"');
$page_data=mysqli_fetch_assoc($query);
$page_data = _dt_parse_array($page_data);

//Template file
require_once("views/blog/addedit_blogcategory.php"); ?>

