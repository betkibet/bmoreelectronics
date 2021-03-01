<?php
//error_reporting(E_ERROR | E_PARSE);
error_reporting(E_ALL);

date_default_timezone_set("UTC");

$folder_name = "";
$folder_name = ($folder_name?"/".$folder_name:"");

$host_scheme='http';
$isHttps =(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') || 
    (isset($_SERVER['REQUEST_SCHEME']) && $_SERVER['REQUEST_SCHEME'] === 'https') || 
    (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https');

if(isset($isHttps))
 $host_scheme='https';
 
define('CP_ROOT_PATH', $_SERVER['DOCUMENT_ROOT'].$folder_name);
define('SITE_URL',$host_scheme.'://'.$_SERVER['HTTP_HOST'].$folder_name.'/');
define('ADMIN_URL',SITE_URL.'admin/');
define('CONTRACTOR_URL',SITE_URL.'contractor/');

require(CP_ROOT_PATH."/admin/_config/connect_db.php");
require(CP_ROOT_PATH."/admin/_config/common.php");
require(CP_ROOT_PATH."/admin/_config/constants.php");

$return_url = '';
if(isset($_SERVER['HTTP_REFERER'])) {
	$return_url = $_SERVER['HTTP_REFERER'];
}
$post = $_REQUEST;

if(!empty($_SERVER['HTTP_CLIENT_IP']))
	$user_ip = $_SERVER['HTTP_CLIENT_IP'];
else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
	$user_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
else
	$user_ip = $_SERVER['REMOTE_ADDR'];

define('USER_IP',$user_ip);
?>