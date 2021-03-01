<?php
$file_name="promocode";

//Header section
require_once("include/header.php");

$id = $post['id'];
if($id<=0 && $prms_promocode_add!='1') {
	setRedirect(ADMIN_URL.'profile.php');
	exit();
} elseif($id>0 && $prms_promocode_edit!='1') {
	setRedirect(ADMIN_URL.'profile.php');
	exit();
}

//Fetch single promocode data based on promocode id
$query="SELECT * FROM promocode WHERE id='".$id."'";
$result=mysqli_query($db,$query);
$promocode_data=mysqli_fetch_array($result);
$promocode_data = _dt_parse_array($promocode_data);

//Template file
require_once("views/promocode/edit_promocode.php"); ?>
