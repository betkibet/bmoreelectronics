<?php
$file_name="promocode";

//Header section
require_once("include/header.php");

$id = $post['id'];

//Fetch single promocode data based on promocode id
$query="SELECT * FROM promocode WHERE id='".$id."'";
$result=mysqli_query($db,$query);
$promocode_data=mysqli_fetch_array($result);

//Template file
require_once("views/promocode/edit_promocode.php");

//Footer section
// include("include/footer.php"); ?>
