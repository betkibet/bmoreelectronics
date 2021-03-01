<?php 
$file_name="faqs_groups";

//Header section
require_once("include/header.php");

//Get num of faqs for pagination
$faq_p_query=mysqli_query($db,"SELECT COUNT(*) AS num_of_faq FROM faqs_groups");
$faq_p_data = mysqli_fetch_assoc($faq_p_query);
$pages->set_total($faq_p_data['num_of_faq']);

//Fetch faqs data
//$query=mysqli_query($db,"SELECT fg.*, c.title AS cat_title FROM faqs_groups AS fg LEFT JOIN categories AS c ON c.id=fg.cat_id ".$pages->get_limit()."");
$query = mysqli_query($db,"SELECT fg.* FROM faqs_groups AS fg ".$pages->get_limit()."");

function get_faq_group_cats_nm($cat_ids) {
	global $db;
	$cat_nm = '';
	if(trim($cat_ids)) {
		$query = mysqli_query($db,"SELECT c.title AS cat_title FROM categories AS c WHERE c.id IN(".$cat_ids.")");
		while($cat_data = mysqli_fetch_assoc($query)) {
			$cat_nm .= $cat_data['cat_title'].', ';
		}
	}
	return rtrim($cat_nm,', ');
}

//Template file
require_once("views/faq/faqs_groups.php");

//Footer section
require_once("include/footer.php"); ?>
