<?php 
$file_name="faqs";

//Header section
require_once("include/header.php");
 
$id = $post['id'];
if($id<=0 && $prms_faq_add!='1') {
	setRedirect(ADMIN_URL.'profile.php');
	exit();
} elseif($id>0 && $prms_faq_edit!='1') {
	setRedirect(ADMIN_URL.'profile.php');
	exit();
}

//Fetch signle editable faqs data
$appt_q=mysqli_query($db,'SELECT * FROM faqs WHERE id="'.$id.'"');
$faq_data=mysqli_fetch_assoc($appt_q);
$faq_data = _dt_parse_array($faq_data);

$faqs_groups_q = mysqli_query($db,'SELECT * FROM faqs_groups ORDER BY ordering ASC');

//Template file
require_once("views/faq/edit_faq.php");

//Footer section
require_once("include/footer.php"); ?>
