<?php
include("_config/config.php");
require_once(CP_ROOT_PATH."/admin/include/functions.php");
is_allowed_ip(); ?>

<!DOCTYPE html>
<!--[if IE 8]>    <html class="no-js ie8 ie" lang="en"> <![endif]-->
<!--[if IE 9]>    <html class="no-js ie9 ie" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title>Login | Contractor Panel</title>
	<meta name="description" content="">
	<meta name="author" content="Walking Pixels | www.walkingpixels.com">
	<meta name="robots" content="index, follow">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

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
  <!--end::Web font -->

  <!--begin::Base Styles -->
  <link href="assets/vendors/base/vendors.bundle.css" rel="stylesheet" type="text/css" />
  <link href="assets/demo/default/base/style.bundle.css" rel="stylesheet" type="text/css" />
  <!--end::Base Styles -->

	<?php
	if($favicon_icon) {
		echo '<link rel="shortcut icon" href="'.SITE_URL.'images/'.$favicon_icon.'" />';
	} ?>
</head>
<body  class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">
