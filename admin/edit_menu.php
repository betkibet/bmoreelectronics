<?php
$file_name="menu";

//Header section
require_once("include/header.php");

$menu_position = $post['position'];
$id = $post['id'];

//Fetch single page data based on page id
$query=mysqli_query($db,'SELECT * FROM menus WHERE id="'.$id.'"');
$menu_data=mysqli_fetch_assoc($query);

//Template file
require_once("views/menu/edit_menu.php");

//Footer section
// require_once("include/footer.php"); ?>
