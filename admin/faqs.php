<?php 
$file_name="faqs";

//Header section
require_once("include/header.php");

//Get num of faqs for pagination
$faq_p_query=mysqli_query($db,"SELECT COUNT(*) AS num_of_faq FROM faqs");
$faq_p_data = mysqli_fetch_assoc($faq_p_query);
$pages->set_total($faq_p_data['num_of_faq']);

//Fetch faqs data
$query=mysqli_query($db,"SELECT f.*, fq.title as group_title FROM faqs AS f LEFT JOIN faqs_groups AS fq ON fq.id=f.group_id ".$pages->get_limit()."");

//Template file
require_once("views/faq/faqs.php");

//Footer section
require_once("include/footer.php"); ?>
