<?php

$file_name = "Profile";

require_once("include/header.php");



//Fetch admin details based on current session id

$contractor_id = $_SESSION['contractor_id'];

$get_userdata=mysqli_query($db,'SELECT * FROM contractors WHERE id="'.$contractor_id.'"');

$get_userdata_row=mysqli_fetch_assoc($get_userdata);



//Template file

require_once("views/admin_user/profile.php");



//Footer section

// require_once("include/footer.php"); ?>

