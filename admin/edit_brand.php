<?php 
$file_name="brand";

//Header section
require_once("include/header.php");
 
$id = $post['id'];

if($id<=0 && $prms_brand_add!='1') {
	setRedirect(ADMIN_URL.'profile.php');
	exit();
} elseif($id>0 && $prms_brand_edit!='1') {
	setRedirect(ADMIN_URL.'profile.php');
	exit();
}

//Fetch signle editable brand data
$q=mysqli_query($db,'SELECT * FROM brand WHERE id="'.$id.'"');
$brand_data=mysqli_fetch_assoc($q);
$brand_data = _dt_parse_array($brand_data);

//Template file
require_once("views/brand/edit_brand.php"); ?>

