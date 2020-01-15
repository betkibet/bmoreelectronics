<?php 
$file_name="promocode";

//Header section
require_once("include/header.php");

$pcode_p_query=mysqli_query($db,"SELECT COUNT(*) AS num_of_records FROM promocode");
$pcode_p_data = mysqli_fetch_assoc($pcode_p_query);
$pages->set_total($pcode_p_data['num_of_records']);

//Fetch promocode list
$query = "SELECT * FROM promocode ORDER BY to_date ASC ".$pages->get_limit()."";
$result=mysqli_query($db,$query);
				
//Template file
require_once("views/promocode/promocode.php");

//Footer section
include("include/footer.php"); ?>
