<?php 
ini_set('memory_limit', '512M');
ob_start();
session_start();

$host = 'localhost'; 
$db_user = 'bmoreelectronics_bmore'; //Production Configuration
//$db_user = 'root'; //Local Configuration
$db_password = 'Password@1@1'; //Production Configuration
//$db_password = 'Kitalale@2010'; //Local Configuration
//$db_name = 'buybackpowerswif_buyback';
$db_name = 'bmoreelectronics_bmoreelectronics';

$db = mysqli_connect($host,$db_user,$db_password,$db_name) or die('Unable to connect to the database');
?>