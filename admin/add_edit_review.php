<?php

$file_name="review";



//Header section

require_once("include/header.php");



$id = $post['id'];



//Fetch signle editable brand data

$query=mysqli_query($db,'SELECT * FROM reviews WHERE id="'.$id.'"');

$review_data=mysqli_fetch_assoc($query);



//Template file

require_once("views/add_edit_review.php");



//Footer section

// require_once("include/footer.php"); ?>

