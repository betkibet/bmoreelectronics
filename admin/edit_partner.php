<?php
$file_name="partners";

//Header section
require_once("include/header.php");

$partner_id = $post['id'];

//Fetch single user data based user id
$partner_data = get_partner_data_by_id($partner_id);
if(empty($partner_data)) {
	//setRedirect(ADMIN_URL.'partners.php');
	//exit();
}

//Template file
require_once("views/partner/edit_partner.php");

//Footer section
// include("include/footer.php"); ?>
