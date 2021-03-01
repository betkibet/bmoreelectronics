<?php
//Redirect http to https url with 301
if(empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off"){
    $redirect = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    header('HTTP/1.1 301 Moved Permanently');
    header('Location:'.$redirect);
    exit();
}

//Basic config, functions related general files
require_once("admin/_config/config.php");
require_once("admin/include/functions.php");
require_once("include/functions/faq.php");

//Set pagination limit
if(!isset($_SESSION['pagination_limit'])) {
	$_SESSION['pagination_limit'] = $page_list_limit;
}

if(isset($_REQUEST['pagination_limit']) && $_REQUEST['pagination_limit']>0) {
	$pagination_limit = $_REQUEST['pagination_limit'];
	$page_list_limit = $pagination_limit;
	$_SESSION['pagination_limit'] = $pagination_limit;

	$pg_url_output = "";
	$pg_url_params = $pg_url_output;
	
	setRedirect(SITE_URL.ltrim($_SERVER['REDIRECT_URL'],'/').$pg_url_params);
	exit();
} elseif($_SESSION['pagination_limit']>0) {
	$page_list_limit = $_SESSION['pagination_limit'];
}

//Pagination library
require_once("libraries/pagination/class.paginator.php");

//Here some common data like basket item, session vars, url vars etc...
require_once("include/common.php");

if($maintainance_mode == '1' && empty($_SESSION['is_admin'])) {
	require_once("views/maintainance.php");
} else {
	//Here pages, views router related code
	require_once("include/route.php");
	
	//Footer Section
	if((isset($active_page_data['slug']) && $active_page_data['slug'] == "affiliates" && isset($_GET['shop']) && $_GET['shop']!="") || $url_first_param == 'affiliate-order-complete') {
		// No footer...
	} else {
		include("include/footer.php");
	}
}
?>