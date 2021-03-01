<?php
$meta_keywords = "";
$meta_desc = "";
$meta_title = "";

//Get admin user data
$admin_user_data = get_admin_user_data();

//START inbuild page url/link
$sell_my_mobile_link = SITE_URL.get_inbuild_page_url('sell-my-mobile');
$contact_link = SITE_URL.get_inbuild_page_url('contact');
$signup_link = SITE_URL.get_inbuild_page_url('signup');
$login_link = SITE_URL.get_inbuild_page_url('login');
$reviews_link = SITE_URL.get_inbuild_page_url('reviews');
$review_form_link = SITE_URL.get_inbuild_page_url('review-form');
//END inbuild page url/link

$request_uri = $_SERVER['REQUEST_URI'];

$user_id = 0;
$user_full_name = '';
$user_first_name = '';
$user_last_name = '';
$user_email = '';
$user_phone = '';

if(isset($_SESSION['user_id'])) {
	$user_id = $_SESSION['user_id'];
	
	//Get user data based on userID
	$user_data = get_user_data($user_id);
	$user_full_name = $user_data['name'];
	$user_first_name = $user_data['first_name'];
	$user_last_name = $user_data['last_name'];
	$user_email = $user_data['email'];
	$user_phone = $user_data['phone'];
}

$guest_user_id = 0;
if(isset($_SESSION['guest_user_id'])) {
	$guest_user_id = $_SESSION['guest_user_id'];

	//Get user data based on guest userID
	$guest_user_data = get_user_data($guest_user_id);
	$user_full_name = $guest_user_data['name'];
	$user_first_name = $guest_user_data['first_name'];
	$user_last_name = $guest_user_data['last_name'];
	$user_email = $guest_user_data['email'];
	$user_phone = $guest_user_data['phone'];
}

$order_id = '';
if(isset($_SESSION['order_id'])) {
	$order_id = $_SESSION['order_id'];

	//Get basket items data, count & sum of order
	$basket_item_count_sum_data = get_basket_item_count_sum($order_id);
}

$order_item_ids = array();
if(isset($_SESSION['order_item_ids'])) {
	$order_item_ids = $_SESSION['order_item_ids'];
}

//Get user data based on userID
$user_data = get_user_data($user_id);

//Get user data based on userID
$guest_user_data = get_user_data($guest_user_id);

//Get basket items data, count & sum of order
$basket_item_count_sum_data = get_basket_item_count_sum($order_id);
?>