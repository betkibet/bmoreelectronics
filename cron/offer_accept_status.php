<?php
error_reporting(E_ERROR | E_PARSE);
date_default_timezone_set("UTC");

$CP_ROOT_PATH = dirname(dirname(__FILE__));

define('CP_ROOT_PATH', $CP_ROOT_PATH);
require(CP_ROOT_PATH."/admin/_config/connect_db.php");
require(CP_ROOT_PATH."/admin/_config/common.php");
require(CP_ROOT_PATH."/admin/include/functions.php");

$price_is_reduced_order_item_status_id = get_order_status_data('order_item_status','price-is-reduced')['data']['id'];
$price_is_accepted_order_item_status_id = get_order_status_data('order_item_status','price-is-accepted')['data']['id'];
//$price_is_declined_order_item_status_id = get_order_status_data('order_item_status','price-is-declined')['data']['id'];

$website_url = rtrim($general_setting_data['website'],'/');
$website_url = $website_url.'/';
define('SITE_URL',$website_url);

$admin_user_data = get_admin_user_data();
$template_data = get_template_data('order_expired');

error_log("Executed Offer Accept Script");

wh_log("Executed Offer Accept Script");
function wh_log($msg) {
	$logfile = 'logs/cron_'.date("Y-m-d-H-i-s").'.log';
	file_put_contents($logfile,date("Y-m-d H:i:s")." | ".$msg."\n",FILE_APPEND);
}

echo '<pre>';
$past_date = date('Y-m-d',strtotime('-6 day'));
echo 'Date of Offer Accept:- '.$past_date;

$query = "SELECT i.* FROM order_items AS i WHERE i.status='".$price_is_reduced_order_item_status_id."'";
$i_query=mysqli_query($db,$query);
$order_item_num_of_rows = mysqli_num_rows($i_query);
if($order_item_num_of_rows>0) {
	while($order_item_data=mysqli_fetch_assoc($i_query)) {
		$order_id = $order_item_data['order_id'];
		$item_id = $order_item_data['id'];

		$os_query = mysqli_query($db,"SELECT * FROM order_status_log WHERE item_id = '".$item_id."' AND item_status='".$price_is_reduced_order_item_status_id."' AND DATE_FORMAT(date,'%Y-%m-%d')='".$past_date."' GROUP BY item_id ORDER BY id DESC");
		$order_status_data = mysqli_fetch_assoc($os_query);
		if(!empty($order_status_data)) {
			//print_r($order_status_data);
			mysqli_query($db,"UPDATE `order_items` SET `status`='".$price_is_accepted_order_item_status_id."' WHERE id='".$item_id."'");
			$order_status_log_arr = array('order_id'=>$order_id,
										'item_id'=>$item_id,
										'order_status'=>'',
										'item_status'=>$price_is_accepted_order_item_status_id,
										'leadsource'=>'customer'
									);
			save_order_status_log($order_status_log_arr);
		}
	}
} else {
	echo '<br>Criteria not matched.';
}
exit;
?>