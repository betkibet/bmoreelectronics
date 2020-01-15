<?php
/*if(empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off"){
    $redirect = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    header('HTTP/1.1 301 Moved Permanently');
    header('Location:'.$redirect);
    exit();
} */

require_once("admin/_config/config.php");
require_once("admin/include/functions.php");
require_once("libraries/pagination/class.paginator.php");

//START inbuild page url/link
$sell_my_mobile_link = SITE_URL.get_inbuild_page_url('sell-my-mobile');
$contact_link = SITE_URL.get_inbuild_page_url('contact');
$signup_link = SITE_URL.get_inbuild_page_url('signup');
$login_link = SITE_URL.get_inbuild_page_url('login');
$reviews_link = SITE_URL.get_inbuild_page_url('reviews');
$review_form_link = SITE_URL.get_inbuild_page_url('review-form');
//END inbuild page url/link

$request_uri = $_SERVER['REQUEST_URI'];
$user_id = $_SESSION['user_id'];
$order_id=$_SESSION['order_id'];
$order_item_ids = $_SESSION['order_item_ids'];
if(empty($order_item_ids)) {
	$order_item_ids = array();
}

//Get admin user data
$admin_user_data = get_admin_user_data();

//Get user data based on userID
$user_data = get_user_data($user_id);

//Get basket items data, count & sum of order
$basket_item_count_sum_data = get_basket_item_count_sum($order_id);

//START get url params
$path_info = parse_path();
$url_first_param = $path_info['call_parts'][0];
$url_second_param=$path_info['call_parts'][1];
$url_third_param=$path_info['call_parts'][2];
$url_four_param=$path_info['call_parts'][3];
//END get url params

//START for get custom/inbuild page menu list
$p_query=mysqli_query($db,"SELECT p.*, m.id AS menu_id, m.url AS menu_url, m.menu_name FROM pages AS p LEFT JOIN menus AS m ON m.page_id=p.id WHERE p.published='1' AND p.url='".$url_first_param."' ORDER BY p.id, m.id ASC");
if($url_first_param=="") {
	$p_query=mysqli_query($db,"SELECT p.*, m.id AS menu_id, m.url AS menu_url, m.menu_name FROM pages AS p LEFT JOIN menus AS m ON m.page_id=p.id WHERE p.published='1' AND p.slug='home' ORDER BY p.id, m.id ASC");
}

$active_page_data=mysqli_fetch_assoc($p_query);
if($active_page_data['menu_id']<=0) {
	$active_page_data['menu_name'] = $active_page_data['title'];
}

$is_custom_or_inbuild_page = mysqli_num_rows($p_query);
if($is_custom_or_inbuild_page>0) {
	$page_url = $active_page_data['url'];
	$meta_title = $active_page_data['meta_title'];
	$meta_desc = $active_page_data['meta_desc'];
	$meta_keywords = $active_page_data['meta_keywords'];

	$inbuild_page_array = array('home','affiliates','contact','reviews','signup','login','terms-and-conditions','review-form','bulk-order-form','order-track','offers', 'instant-sell-model');
	if(in_array($active_page_data['slug'],$inbuild_page_array)) {
		include("include/header.php");
		include 'views/'.str_replace('-','_',$active_page_data['slug']).'.php';
	} elseif($active_page_data['cat_id']) {
		$category_id = $active_page_data['cat_id'];
		if($category_id == "all") {
			include 'views/device_categories.php';
		} else {
			include 'views/device_category_brands.php';
		}
	} elseif($active_page_data['brand_id']) {
		$brand_id = $active_page_data['brand_id'];
		if($brand_id == "all") {
			include 'views/device_brands.php';
		} else {
			include 'views/brand.php';
		}
	} elseif($active_page_data['device_id']) {
		$devices_id = $active_page_data['device_id'];
		if($devices_id == "all") {
			include 'views/devices.php';
		} else {
			include("include/header.php");
			include 'views/models.php';
		}
	} elseif($active_page_data['slug']=="blog") {
		include("include/header.php");
		$blog_url = trim($url_second_param);
		if($blog_url) {
			include 'views/blog/blog_view.php';
		} else {
			include 'views/blog/blog.php';
		}
	} else {
		include("include/header.php");
		include 'views/page.php';
	}
} //END for get custom/inbuild page menu list
else
{
	$other_single_page_array = array('revieworder', 'enterdetails', 'lost_password', 'reset_password', 'place_order', 'profile', 'account', 'view_order', 'change-password', 'search', 'order_offer', 'verify_step3', 'verify_account', 'apr', 'apr-order-complete', 'brand');

	//START for mobile models, mobile model detail page
	$device_single_data_resp = get_device_single_data($url_first_param);
	$brand_single_data_resp = get_brand_single_data_by_sef_url($url_second_param);
	if($brand_single_data_resp['num_of_brand']>0 && $device_single_data_resp['num_of_device']>0 && $url_first_param!="brand" && $url_second_param!="") {
		include 'views/device_brand.php';
	} elseif($brand_single_data_resp['num_of_brand']>0 && $url_first_param=="brand" && $url_second_param!="" && $url_third_param=="") {
		include 'views/brand.php';
	} elseif($brand_single_data_resp['num_of_brand']>0 && $url_first_param=="brand" && $url_second_param!="" && $url_third_param!="") {
		include 'views/brand_device.php';
	} elseif($device_single_data_resp['num_of_device']>0 && $url_third_param=="") {
		include 'views/models.php';
	} elseif($device_single_data_resp['num_of_device']>0 && $url_third_param!="") {
		include 'views/model_details.php';
	} //END for mobile models, mobile model detail page

	//START for other menu
	elseif(in_array($url_first_param,$other_single_page_array)) {
		include 'views/'.str_replace('-','_',$url_first_param).'.php';
	} elseif($url_first_param=="device-brand" && $url_second_param!='') {
		$brand_id=$url_second_param;
		$cat_id=$url_third_param;
		$device_id=$url_four_param;
		include 'views/device_brand_models.php';
	} elseif($url_first_param=="device-category" && $url_second_param!='') {
		$category_id = $url_second_param;
		include 'views/device_category_brands.php';
	} elseif($url_first_param=="category") {
		include 'views/blog/cat_view.php';
	} elseif($url_first_param=="offer-status") {
		include 'controllers/offer_status.php';
	} else {
		setRedirect(SITE_URL,$msg);
		exit();
	} //END for other menu
}

if($url_first_param == 'apr' || $url_first_param == 'apr-order-complete') {
//No footer...
} else {
include("include/footer.php");
}
?>