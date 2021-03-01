<?php
include("_config/config.php");
include("include/functions.php");
is_allowed_ip();
check_admin_staff_auth();

//Set pagination limit
if(!isset($_SESSION['pagination_limit'])) {
	$_SESSION['pagination_limit'] = $page_list_limit;
}

if(isset($_REQUEST['pagination_limit']) && $_REQUEST['pagination_limit']>0) {
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

if(!isset($post['id'])) {
	$post['id'] = "";
}
if(!isset($post['filter_by'])) {
	$post['filter_by'] = "";
}
if(!isset($post['oid_shorting'])) {
	$post['oid_shorting'] = "";
}
if(!isset($post['title_shorting'])) {
	$post['title_shorting'] = "";
}
if(!isset($post['cat_id'])) {
	$post['cat_id'] = "";
}
if(!isset($post['brand_id'])) {
	$post['brand_id'] = "";
}
if(!isset($post['device_id'])) {
	$post['device_id'] = "";
}
if(!isset($post['id_shorting'])) {
	$post['id_shorting'] = "";
}
if(!isset($post['field_type'])) {
	$post['field_type'] = "";
}
if(!isset($post['user_id'])) {
	$post['user_id'] = "";
}
if(!isset($post['contractor_id'])) {
	$post['contractor_id'] = "";
}
if(!isset($post['status'])) {
	$post['status'] = "";
}
if(!isset($post['from_date'])) {
	$post['from_date'] = "";
}
if(!isset($post['to_date'])) {
	$post['to_date'] = "";
}
if(!isset($post['date_shorting'])) {
	$post['date_shorting'] = "";
}
if(!isset($post['qty_shorting'])) {
	$post['qty_shorting'] = "";
}
if(!isset($post['price_shorting'])) {
	$post['price_shorting'] = "";
}
if(!isset($post['payment_paid_batch_id'])) {
	$post['payment_paid_batch_id'] = "";
}
if(!isset($post['is_payment_sent'])) {
	$post['is_payment_sent'] = "";
}
if(!isset($post['pmethod_shorting'])) {
	$post['pmethod_shorting'] = "";
}
if(!isset($post['position'])) {
	$post['position'] = "";
}
if(!isset($post['menu_name'])) {
	$post['menu_name'] = "";
}
if(!isset($post['order_id'])) {
	$post['order_id'] = "";
}
if(!isset($post['p'])) {
	$post['p'] = "";
}
if(!isset($post['slug'])) {
	$post['slug'] = "";
}
if(!isset($post['name_shorting'])) {
	$post['name_shorting'] = "";
}
if(!isset($_GET['order_mode'])) {
	$_GET['order_mode'] = "";
}
if(!isset($post['fields_type'])) {
	$post['fields_type'] = "";
}

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
	/*if($admin_type=="admin") {
		$access_file_name_array = array('general_settings','staff','home_settings');
		if(in_array($file_name,$access_file_name_array)) {
			header('Location: profile.php');
			exit;
		}
	}*/

	$emp_g_query=mysqli_query($db,"SELECT eg.* FROM staff_groups AS eg WHERE eg.id='".$loggedin_user_data['group_id']."'");
	$staff_groups_data=mysqli_fetch_assoc($emp_g_query);

	if($admin_type=="super_admin") {
		$staff_permissions_data = json_decode('{"order_view":"1","order_add":"1","order_edit":"1","order_delete":"1","model_view":"1","model_add":"1","model_edit":"1","model_delete":"1","device_view":"1","device_add":"1","device_edit":"1","device_delete":"1","brand_view":"1","brand_add":"1","brand_edit":"1","brand_delete":"1","category_view":"1","category_add":"1","category_edit":"1","category_delete":"1","customer_view":"1","customer_add":"1","customer_edit":"1","customer_delete":"1","page_view":"1","page_add":"1","page_edit":"1","page_delete":"1","menu_view":"1","menu_add":"1","menu_edit":"1","menu_delete":"1","form_view":"1","form_add":"1","form_edit":"1","form_delete":"1","blog_view":"1","blog_add":"1","blog_edit":"1","blog_delete":"1","faq_view":"1","faq_add":"1","faq_edit":"1","faq_delete":"1","promocode_view":"1","promocode_add":"1","promocode_edit":"1","promocode_delete":"1","emailtmpl_view":"1","emailtmpl_add":"1","emailtmpl_edit":"1","emailtmpl_delete":"1"}', true);
	} else {
		$access_file_name_array = array('general_settings','staff');
		if(in_array($file_name,$access_file_name_array)) {
			header('Location: profile.php');
			exit;
		}
		$staff_permissions_data = json_decode($staff_groups_data['permissions'], true);
	}

	$prms_order_view = isset($staff_permissions_data['order_view'])?$staff_permissions_data['order_view']:'';
	$prms_order_add = isset($staff_permissions_data['order_add'])?$staff_permissions_data['order_add']:'';
	$prms_order_edit = isset($staff_permissions_data['order_edit'])?$staff_permissions_data['order_edit']:'';
	$prms_order_delete = isset($staff_permissions_data['order_delete'])?$staff_permissions_data['order_delete']:'';
	$prms_order_invoice = isset($staff_permissions_data['order_invoice'])?$staff_permissions_data['order_invoice']:'';
	$prms_model_view = isset($staff_permissions_data['model_view'])?$staff_permissions_data['model_view']:'';
	$prms_model_add = isset($staff_permissions_data['model_add'])?$staff_permissions_data['model_add']:'';
	$prms_model_edit = isset($staff_permissions_data['model_edit'])?$staff_permissions_data['model_edit']:'';
	$prms_model_delete = isset($staff_permissions_data['model_delete'])?$staff_permissions_data['model_delete']:'';
	$prms_device_view = isset($staff_permissions_data['device_view'])?$staff_permissions_data['device_view']:'';
	$prms_device_add = isset($staff_permissions_data['device_add'])?$staff_permissions_data['device_add']:'';
	$prms_device_edit = isset($staff_permissions_data['device_edit'])?$staff_permissions_data['device_edit']:'';
	$prms_device_delete = isset($staff_permissions_data['device_delete'])?$staff_permissions_data['device_delete']:'';
	$prms_brand_view = isset($staff_permissions_data['brand_view'])?$staff_permissions_data['brand_view']:'';
	$prms_brand_add = isset($staff_permissions_data['brand_add'])?$staff_permissions_data['brand_add']:'';
	$prms_brand_edit = isset($staff_permissions_data['brand_edit'])?$staff_permissions_data['brand_edit']:'';
	$prms_brand_delete = isset($staff_permissions_data['brand_delete'])?$staff_permissions_data['brand_delete']:'';
	$prms_category_view = isset($staff_permissions_data['category_view'])?$staff_permissions_data['category_view']:'';
	$prms_category_add = isset($staff_permissions_data['category_add'])?$staff_permissions_data['category_add']:'';
	$prms_category_edit = isset($staff_permissions_data['category_edit'])?$staff_permissions_data['category_edit']:'';
	$prms_category_delete = isset($staff_permissions_data['category_delete'])?$staff_permissions_data['category_delete']:'';
	$prms_customer_view = isset($staff_permissions_data['customer_view'])?$staff_permissions_data['customer_view']:'';
	$prms_customer_add = isset($staff_permissions_data['customer_add'])?$staff_permissions_data['customer_add']:'';
	$prms_customer_edit = isset($staff_permissions_data['customer_edit'])?$staff_permissions_data['customer_edit']:'';
	$prms_customer_delete = isset($staff_permissions_data['customer_delete'])?$staff_permissions_data['customer_delete']:'';
	$prms_page_view = isset($staff_permissions_data['page_view'])?$staff_permissions_data['page_view']:'';
	$prms_page_add = isset($staff_permissions_data['page_add'])?$staff_permissions_data['page_add']:'';
	$prms_page_edit = isset($staff_permissions_data['page_edit'])?$staff_permissions_data['page_edit']:'';
	$prms_page_delete = isset($staff_permissions_data['page_delete'])?$staff_permissions_data['page_delete']:'';
	$prms_menu_view = isset($staff_permissions_data['menu_view'])?$staff_permissions_data['menu_view']:'';
	$prms_menu_add = isset($staff_permissions_data['menu_add'])?$staff_permissions_data['menu_add']:'';
	$prms_menu_edit = isset($staff_permissions_data['menu_edit'])?$staff_permissions_data['menu_edit']:'';
	$prms_menu_delete = isset($staff_permissions_data['menu_delete'])?$staff_permissions_data['menu_delete']:'';
	$prms_form_view = isset($staff_permissions_data['form_view'])?$staff_permissions_data['form_view']:'';
	$prms_form_add = isset($staff_permissions_data['form_add'])?$staff_permissions_data['form_add']:'';
	$prms_form_edit = isset($staff_permissions_data['form_edit'])?$staff_permissions_data['form_edit']:'';
	$prms_form_delete = isset($staff_permissions_data['form_delete'])?$staff_permissions_data['form_delete']:'';
	$prms_blog_view = isset($staff_permissions_data['blog_view'])?$staff_permissions_data['blog_view']:'';
	$prms_blog_add = isset($staff_permissions_data['blog_add'])?$staff_permissions_data['blog_add']:'';
	$prms_blog_edit = isset($staff_permissions_data['blog_edit'])?$staff_permissions_data['blog_edit']:'';
	$prms_blog_delete = isset($staff_permissions_data['blog_delete'])?$staff_permissions_data['blog_delete']:'';
	$prms_faq_view = isset($staff_permissions_data['faq_view'])?$staff_permissions_data['faq_view']:'';
	$prms_faq_add = isset($staff_permissions_data['faq_add'])?$staff_permissions_data['faq_add']:'';
	$prms_faq_edit = isset($staff_permissions_data['faq_edit'])?$staff_permissions_data['faq_edit']:'';
	$prms_faq_delete = isset($staff_permissions_data['faq_delete'])?$staff_permissions_data['faq_delete']:'';
	$prms_promocode_view = isset($staff_permissions_data['promocode_view'])?$staff_permissions_data['promocode_view']:'';
	$prms_promocode_add = isset($staff_permissions_data['promocode_add'])?$staff_permissions_data['promocode_add']:'';
	$prms_promocode_edit = isset($staff_permissions_data['promocode_edit'])?$staff_permissions_data['promocode_edit']:'';
	$prms_promocode_delete = isset($staff_permissions_data['promocode_delete'])?$staff_permissions_data['promocode_delete']:'';
	$prms_emailtmpl_view = isset($staff_permissions_data['emailtmpl_view'])?$staff_permissions_data['emailtmpl_view']:'';
	$prms_emailtmpl_add = isset($staff_permissions_data['emailtmpl_add'])?$staff_permissions_data['emailtmpl_add']:'';
	$prms_emailtmpl_edit = isset($staff_permissions_data['emailtmpl_edit'])?$staff_permissions_data['emailtmpl_edit']:'';
	$prms_emailtmpl_delete = isset($staff_permissions_data['emailtmpl_delete'])?$staff_permissions_data['emailtmpl_delete']:'';
	
	$access_file_name_array = array();
	if($prms_order_view!='1') {
		$access_file_name_array[] = 'orders';
		$access_file_name_array[] = 'edit_order';
	}
	if($prms_category_view!='1') {
		$access_file_name_array[] = 'device_categories';
	}
	if($prms_brand_view!='1') {
		$access_file_name_array[] = 'brand';
	}
	if($prms_device_view!='1') {
		$access_file_name_array[] = 'device';
	}
	if($prms_model_view!='1') {
		$access_file_name_array[] = 'mobile';
		$access_file_name_array[] = 'groups';
	}
	if($prms_customer_view!='1') {
		$access_file_name_array[] = 'users';
	}
	if($prms_page_view!='1') {
		$access_file_name_array[] = 'page';
	}
	if($prms_menu_view!='1') {
		$access_file_name_array[] = 'menu';
	}
	if($prms_form_view!='1') {
		$access_file_name_array[] = 'contact';
		$access_file_name_array[] = 'review';
		$access_file_name_array[] = 'bulk_order';
		$access_file_name_array[] = 'affiliate';
		$access_file_name_array[] = 'newsletter';
	}
	if($prms_blog_view!='1') {
		$access_file_name_array[] = 'blog';
	}
	if($prms_faq_view!='1') {
		$access_file_name_array[] = 'faqs';
	}
	if($prms_promocode_view!='1') {
		$access_file_name_array[] = 'promocode';
	}
	if($prms_emailtmpl_view!='1') {
		$access_file_name_array[] = 'email_template';
	}
	
	if($file_name!="" && in_array($file_name,$access_file_name_array)) {
		header('Location: profile.php');
		exit;
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

	<?php
	if($favicon_icon) {
		echo '<link rel="shortcut icon" href="'.SITE_URL.'images/'.$favicon_icon.'" />';
	} ?>
	
<script src="assets/vendors/base/vendors.bundle.js" type="text/javascript"></script>
<script src="assets/demo/default/base/scripts.bundle.js" type="text/javascript"></script>
<script src="js/jscolor.js" type="text/javascript"></script>
</head>

<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">
