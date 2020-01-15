<?php
$file_name="blog";

//Header section
require_once("include/header.php");

$id = $post['id'];

//Fetch single data of category based on category id, If already added
$query=mysqli_query($db,'SELECT catID, catTitle FROM blog_cats WHERE catID="'.$id.'"');
$page_data=mysqli_fetch_assoc($query);

//Template file
require_once("views/blog/add-category.php");

//Footer section
// require_once("include/footer.php"); ?>
