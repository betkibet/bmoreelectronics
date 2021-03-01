<?php
$file_name="review";

//Header section
require_once("include/header.php");

$id = $post['id'];
if($id<=0 && $prms_form_add!='1') {
	setRedirect(ADMIN_URL.'profile.php');
	exit();
} elseif($id>0 && $prms_form_edit!='1') {
	setRedirect(ADMIN_URL.'profile.php');
	exit();
}

//Fetch signle editable brand data
$query=mysqli_query($db,'SELECT * FROM reviews WHERE id="'.$id.'"');
$review_data=mysqli_fetch_assoc($query);
$review_data = _dt_parse_array($review_data);

//Template file
require_once("views/add_edit_review.php"); ?>

