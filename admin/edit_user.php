<?php
$file_name="users";

//Header section
require_once("include/header.php");

$id = $post['id'];

//Fetch single user data based user id
$user_data = get_user_data($id);
/*if(empty($user_data)) {
	setRedirect(ADMIN_URL.'users.php');
	exit();
}*/

//Template file
require_once("views/user/edit_user.php");

//Footer section
// include("include/footer.php"); ?>
