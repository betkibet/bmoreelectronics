<?php
//error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
error_reporting(E_ERROR | E_WARNING | E_PARSE);

//$folder_name = ""; //Production configuration
$folder_name = "bmoreelectronics"; //Local Configuration
$folder_name = ($folder_name?"/".$folder_name:"");
$host_scheme = ($_SERVER['REQUEST_SCHEME']?$_SERVER['REQUEST_SCHEME']:"http");

define('CP_ROOT_PATH', $_SERVER['DOCUMENT_ROOT'].$folder_name);
define('SITE_URL',$host_scheme.'://'.$_SERVER['HTTP_HOST'].$folder_name.'/');
define('ADMIN_URL',SITE_URL.'admin/');

require(CP_ROOT_PATH."/admin/_config/connect_db.php");
require(CP_ROOT_PATH."/admin/_config/common.php");

$return_url = '';
if(isset($_SERVER['HTTP_REFERER'])) {
	$return_url = $_SERVER['HTTP_REFERER'];
}
$post = $_REQUEST;
?>