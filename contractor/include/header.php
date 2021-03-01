<?php
include("_config/config.php");
require_once(CP_ROOT_PATH."/admin/include/functions.php");
is_allowed_ip();
check_contractor_staff_auth();

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
if(empty($_SESSION['is_contractor']) || empty($_SESSION['contractor_username'])) {
    setRedirect(CONTRACTOR_URL);
	exit();
} else {
	$admin_l_id = $_SESSION['contractor_id'];
	$contractor_type = $_SESSION['contractor_type'];

	$query=mysqli_query($db,"SELECT * FROM contractors WHERE id = '".$admin_l_id."'");
	$loggedin_user_data = mysqli_fetch_assoc($query);
	$loggedin_user_name = $loggedin_user_data['name'];

	//START access level based on loggedin user
	$staff_permissions_data = json_decode($loggedin_user_data['permissions'], true);

	$prms_order_view = 1;//isset($staff_permissions_data['order_view'])?$staff_permissions_data['order_view']:'';
	$prms_order_add = isset($staff_permissions_data['order_add'])?$staff_permissions_data['order_add']:'';
	$prms_order_edit = 1;//isset($staff_permissions_data['order_edit'])?$staff_permissions_data['order_edit']:'';
	$prms_order_delete = isset($staff_permissions_data['order_delete'])?$staff_permissions_data['order_delete']:'';
	$prms_order_edit_price = isset($staff_permissions_data['order_edit_price'])?$staff_permissions_data['order_edit_price']:'';
	$prms_order_add_item = isset($staff_permissions_data['order_add_item'])?$staff_permissions_data['order_add_item']:'';
	$prms_order_edit_item = isset($staff_permissions_data['order_edit_item'])?$staff_permissions_data['order_edit_item']:'';
	$prms_order_delete_item = isset($staff_permissions_data['order_delete_item'])?$staff_permissions_data['order_delete_item']:'';
	$prms_order_edit_shipping_label = isset($staff_permissions_data['order_edit_shipping_label'])?$staff_permissions_data['order_edit_shipping_label']:'';
	$prms_customer_view = isset($staff_permissions_data['customer_view'])?$staff_permissions_data['customer_view']:'';
	$prms_customer_add = isset($staff_permissions_data['customer_add'])?$staff_permissions_data['customer_add']:'';
	$prms_customer_edit = isset($staff_permissions_data['customer_edit'])?$staff_permissions_data['customer_edit']:'';
	$prms_customer_delete = isset($staff_permissions_data['customer_delete'])?$staff_permissions_data['customer_delete']:'';

	$access_file_name_array = array();
	if($prms_order_view!='1') {
		$access_file_name_array[] = 'archive_orders';
		$access_file_name_array[] = 'awaiting_orders';
		$access_file_name_array[] = 'orders';
		$access_file_name_array[] = 'paid_orders';
		$access_file_name_array[] = 'edit_order';
	}
	if($prms_customer_view!='1') {
		$access_file_name_array[] = 'users';
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
<title><?=ucfirst(str_replace('_',' ',$file_name))?> | Contractor Panel</title>

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
