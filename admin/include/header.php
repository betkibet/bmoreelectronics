<?php
include("_config/config.php");
include("include/functions.php");

//Set pagination limit
if($_REQUEST['pagination_limit']>0) {
	$pagination_limit = $_REQUEST['pagination_limit'];
	$page_list_limit = $pagination_limit;
	$_SESSION['pagination_limit'] = $pagination_limit;

	$pg_url_params = "";
	if(isset($_REQUEST['position'])) {
		$pg_url_params .= "?position=".$_REQUEST['position'];
	}

	setRedirect(SITE_URL.ltrim($_SERVER['SCRIPT_NAME'],'/').$pg_url_params);
	exit();
} elseif($_SESSION['pagination_limit']>0) {
	$page_list_limit = $_SESSION['pagination_limit'];
}

//Get library for pagination
include("libraries/pagination/class.paginator.php");
$pages = new Paginator($page_list_limit,'p');

//If session expired then it will redirect to login page
if(empty($_SESSION['is_admin']) || empty($_SESSION['admin_username'])) {
    setRedirect(ADMIN_URL);
	exit();
} else {
	$admin_l_id = $_SESSION['admin_id'];
	$admin_type = $_SESSION['admin_type'];

	$query=mysqli_query($db,"SELECT * FROM admin WHERE id = '".$admin_l_id."'");
	$loggedin_user_data = mysqli_fetch_assoc($query);
	$loggedin_user_name = $loggedin_user_data['name'];

	//START access level based on loggedin user
	if($admin_type=="admin") {
		$access_file_name_array = array('general_settings','staff','home_settings');
		if(in_array($file_name,$access_file_name_array)) {
			header('Location: profile.php');
			exit;
		}
	} //END access level based on loggedin user
} ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="description" content="Admin Panel" />
<title><?=ucfirst(str_replace('_',' ',$file_name))?> | Admin Panel</title>
<!--begin::Web font -->
<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
<script>
WebFont.load({
  google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
  active: function() {
      sessionStorage.fonts = true;
  }
});
</script>

<link href="assets/vendors/base/vendors.bundle.css" rel="stylesheet" type="text/css" />
<link href="assets/demo/default/base/style.bundle.css" rel="stylesheet" type="text/css" />
<link href="assets/vendors/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
<link href="css/custom.css" rel="stylesheet" type="text/css" />
<!--end::Base Styles -->

<link rel="stylesheet" href="../css/intlTelInput.css">
<style>
.hide{display:none;}
.intl-tel-input {position:relative;display:block;}
</style>

<!-- jQuery TagsInput Styles -->
<!-- <link rel='stylesheet' type='text/css' href='css/plugins/jquery.tagsinput.css'> -->

<!-- jQuery prettyCheckable Styles -->
<!-- <link rel='stylesheet' type='text/css' href='css/plugins/prettyCheckable.css'> -->

<!-- jQuery jWYSIWYG Styles -->
<!-- <link rel='stylesheet' type='text/css' href='css/plugins/jquery.jwysiwyg.css'> -->

<!-- Bootstrap wysihtml5 Styles -->
<!-- <link rel='stylesheet' type='text/css' href='css/plugins/bootstrap-wysihtml5.css'> -->

<!-- Date range picker Styles -->
<!-- <link rel='stylesheet' type='text/css' href='css/plugins/daterangepicker.css'> -->

<!-- Bootstrap Timepicker Styles -->
<!-- <link rel='stylesheet' type='text/css' href='css/plugins/bootstrap-timepicker.css'> -->

<!-- Styles -->
<!-- <link rel='stylesheet' type='text/css' href='css/sangoma-red.css'> -->

<!-- <link rel="stylesheet" href="../css/intlTelInput.css"> -->

<!-- NEW ADDED -->
<!-- <link href="css/icons.css" rel="stylesheet" type="text/css" /> -->

<!-- <link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet"> -->

<!-- JS Libs -->
<!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="js/libs/jquery.js"><\/script>')</script>

<script src="js/libs/modernizr.js"></script>
<script src="js/libs/selectivizr.js"></script>

<script>
$(document).ready(function(){

	// Tooltips
	$('[title]').tooltip({
		placement: 'top',
		container: 'body'
	});

	// Tabs
	$('.demoTabs a').click(function (e) {
		e.preventDefault();
		$(this).tab('show');
	})

});
</script> -->

<script src="assets/vendors/base/vendors.bundle.js" type="text/javascript"></script>
<script src="assets/demo/default/base/scripts.bundle.js" type="text/javascript"></script>
<script src="js/jscolor.js" type="text/javascript"></script>
</head>

<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">
