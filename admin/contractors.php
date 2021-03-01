<?php
$file_name="contractors";

//Header section
require_once("include/header.php");

if(isset($_POST['search'])) {
	$_SESSION['contractor_filter_data'] = array('filter_by'=>$post['filter_by']);
	setRedirect(ADMIN_URL.'contractors.php');
}

if(isset($_GET['clear'])) {
	unset($_SESSION['contractor_filter_data']);
	setRedirect(ADMIN_URL.'contractors.php');
}

if(isset($_SESSION['contractor_filter_data'])) {
	$model_filter_data = $_SESSION['contractor_filter_data'];
	$post['filter_by'] = $model_filter_data['filter_by'];
}

//Filter by contractors based on contractorname, email, name, first name, last name & phone
$filter_by = "";
if($post['filter_by']) {
	$filter_by = " AND (email LIKE '%".real_escape_string($post['filter_by'])."%'  OR name LIKE '%".real_escape_string($post['filter_by'])."%' OR phone LIKE '%".real_escape_string($post['filter_by'])."%')";
}

//Get num of contractors for pagination
$contractor_p_query=mysqli_query($db,"SELECT COUNT(*) AS num_of_orders FROM contractors WHERE 1 ".$filter_by." ORDER BY id DESC");
$contractor_p_data = mysqli_fetch_assoc($contractor_p_query);
$pages->set_total($contractor_p_data['num_of_orders']);

//Fetch contractor list
$contractor_query=mysqli_query($db,"SELECT * FROM contractors WHERE 1 ".$filter_by." ORDER BY id DESC ".$pages->get_limit()."");

//Template file
require_once("views/contractor/contractors.php"); ?>
