<?php 
$file_name="view_emailsms_history";

//Header section
require_once("include/header.php");
 
$id = $post['id'];

//Fetch signle editable brand data
$query=mysqli_query($db,'SELECT * FROM inbox_mail_sms WHERE id="'.$id.'"');
$inbox_mail_sms_data=mysqli_fetch_assoc($query);
//$inbox_mail_sms_data = _dt_parse_array($inbox_mail_sms_data);

//Template file
require_once("views/view_emailsms_history.php");

//Footer section
require_once("include/footer.php"); ?>
