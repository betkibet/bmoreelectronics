<?php
$file_name="device_categories";

//Header section
require_once("include/header.php");

$id = $post['id'];

//Fetch signle editable brand data
$get_behand_data=mysqli_query($db,'SELECT * FROM categories WHERE id="'.$id.'"');
$brand_data=mysqli_fetch_assoc($get_behand_data);

//Template file
require_once("views/categories/edit_category.php");

//Footer section
// require_once("include/footer.php"); ?>
