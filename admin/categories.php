<?php
$file_name="categories";

//Header section
require_once("include/header.php");

$bc_p_query=mysqli_query($db,"SELECT COUNT(*) AS num_of_records FROM blog_cats");
$bc_p_data = mysqli_fetch_assoc($bc_p_query);
$pages->set_total($bc_p_data['num_of_records']);

//Fetch category list
$query = mysqli_query($db,"SELECT catID, catTitle, catSlug FROM blog_cats ORDER BY catTitle DESC ".$pages->get_limit()."");

//Template file
require_once("views/blog/categories.php");

//Footer section
// require_once("include/footer.php"); ?>
