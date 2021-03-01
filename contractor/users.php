<?php
$file_name="users";

//Header section
require_once("include/header.php");

if(isset($_POST['search'])) {
	$_SESSION['user_filter_data'] = array('filter_by'=>$post['filter_by']);
	setRedirect(CONTRACTOR_URL.'users.php');
}

if(isset($_GET['clear'])) {
	unset($_SESSION['user_filter_data']);
	setRedirect(CONTRACTOR_URL.'users.php');
}

if(isset($_SESSION['user_filter_data'])) {
	$model_filter_data = $_SESSION['user_filter_data'];
	$post['filter_by'] = $model_filter_data['filter_by'];
}

//Filter by users based on username, email, name, first name, last name & phone
$filter_by = "";
if($post['filter_by']) {
	$filter_by = " AND (username LIKE '%".real_escape_string($post['filter_by'])."%' OR email LIKE '%".real_escape_string($post['filter_by'])."%'  OR name LIKE '%".real_escape_string($post['filter_by'])."%' OR first_name LIKE '%".real_escape_string($post['filter_by'])."%' OR last_name LIKE '%".real_escape_string($post['filter_by'])."%' OR phone LIKE '%".real_escape_string($post['filter_by'])."%')";
}

//Get num of users for pagination
$user_p_query=mysqli_query($db,"SELECT COUNT(*) AS num_of_orders FROM users WHERE 1 ".$filter_by." ORDER BY id DESC");
$user_p_data = mysqli_fetch_assoc($user_p_query);
$pages->set_total($user_p_data['num_of_orders']);

//Fetch user list
//$user_query=mysqli_query($db,"SELECT * FROM users WHERE 1 ".$filter_by." ORDER BY id DESC ".$pages->get_limit()."");
$user_query = mysqli_query($db,"SELECT u.* FROM users AS u LEFT JOIN orders AS o ON o.user_id=u.id LEFT JOIN contractor_orders AS ca ON ca.order_id=o.order_id WHERE (ca.contractor_id='".$admin_l_id."' OR u.contractor_id='".$admin_l_id."') GROUP BY u.id ".$pages->get_limit()."");

//$user_query = mysqli_query($db,"SELECT u.* FROM users AS u LEFT JOIN orders AS o ON o.user_id=u.id LEFT JOIN contractor_orders AS ca ON ca.order_id=o.order_id WHERE o.status!='partial' AND (ca.contractor_id='".$admin_l_id."' OR u.contractor_id>0) GROUP BY o.user_id");

//$user_query = mysqli_query($db,"SELECT u.*, p.shop_name as aflt_shop_name, os.name AS order_status_name, ca.contractor_id, ca.order_id, ca.amount as c_amount FROM orders AS o LEFT JOIN users AS u ON u.id=o.user_id LEFT JOIN affiliate AS p ON p.id=o.affiliate_id LEFT JOIN order_status AS os ON os.id=o.status LEFT JOIN contractor_orders AS ca ON o.order_id=ca.order_id WHERE o.status!='partial' AND ca.contractor_id='".$admin_l_id."'");

//$contractor_users_list = get_contractor_users_list($admin_l_id);

//Template file
require_once("views/user/users.php"); ?>
