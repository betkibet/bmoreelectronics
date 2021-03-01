<?php
error_reporting(E_ERROR | E_PARSE);
date_default_timezone_set("UTC");

$CP_ROOT_PATH = dirname(dirname(__FILE__));

define('CP_ROOT_PATH', $CP_ROOT_PATH);
require(CP_ROOT_PATH."/admin/_config/connect_db.php");
require(CP_ROOT_PATH."/admin/_config/common.php");
require(CP_ROOT_PATH."/admin/include/functions.php");

$price_is_reduced_order_item_status_id = get_order_status_data('order_item_status','price-is-reduced')['data']['id'];
$price_is_reduced_order_status_id = get_order_status_data('order_status','price-is-reduced')['data']['id'];

$website_url = rtrim($general_setting_data['website'],'/');
$website_url = $website_url.'/';
define('SITE_URL',$website_url);

$admin_user_data = get_admin_user_data();
$template_data = get_template_data('customer_not_accepted_order_offer_after_2_days');

error_log("Executed Offer Accept Script");

wh_log("Executed Offer Accept Script");
function wh_log($msg) {
	$logfile = 'logs/cron_'.date("Y-m-d-H-i-s").'.log';
	file_put_contents($logfile,date("Y-m-d H:i:s")." | ".$msg."\n",FILE_APPEND);
}

echo '<pre>';
$past_date = date('Y-m-d',strtotime('-2 day'));
echo 'Date of 2 day past:- '.$past_date;

$query = "SELECT i.* FROM order_items AS i WHERE i.status='".$price_is_reduced_order_item_status_id."'";
$i_query=mysqli_query($db,$query);
$order_item_num_of_rows = mysqli_num_rows($i_query);
if($order_item_num_of_rows>0) {
	while($order_item_data=mysqli_fetch_assoc($i_query)) {
		$order_id = $order_item_data['order_id'];
		$item_id = $order_item_data['id'];
		//$order_data = get_order_data($order_id);
		
		$order_item_status_data = get_order_status_data('order_item_status','',$order_item_data['status'])['data'];
		
		$os_query = mysqli_query($db,"SELECT * FROM order_status_log WHERE item_id = '".$item_id."' AND item_status='".$price_is_reduced_order_item_status_id."' AND DATE_FORMAT(date,'%Y-%m-%d')='".$past_date."' GROUP BY item_id ORDER BY id DESC");
		$order_status_data = mysqli_fetch_assoc($os_query);
		if(!empty($order_status_data)) {
			//print_r($order_status_data);
			
			$unsubscribe_token = get_big_unique_id();
			$unsubscribe_link = SITE_URL."unsubscribe/".$unsubscribe_token;
			
			$order_data = get_order_data($order_id);
			
			$s_order_item_data = get_order_item($item_id, 'email');
			$order_item_name = $s_order_item_data['device_type'];
			
			$patterns = array(
				'{$logo}',
				'{$admin_logo}',
				'{$admin_email}',
				'{$admin_phone}',
				'{$admin_username}',
				'{$admin_site_url}',
				'{$admin_panel_name}',
				'{$from_name}',
				'{$from_email}',
				'{$site_name}',
				'{$site_url}',
				'{$customer_fname}',
				'{$customer_lname}',
				'{$customer_fullname}',
				'{$customer_phone}',
				'{$customer_email}',
				'{$billing_address1}',
				'{$billing_address2}',
				'{$billing_city}',
				'{$billing_state}',
				'{$customer_country}',
				'{$billing_postcode}',
				'{$order_id}',
				'{$order_payment_method}',
				'{$order_date}',
				'{$order_approved_date}',
				'{$order_expire_date}',
				'{$order_status}',
				'{$order_sales_pack}',
				'{$current_date_time}',
				'{$order_item_list}',
				'{$company_name}',
				'{$company_address}',
				'{$company_city}',
				'{$company_state}',
				'{$company_postcode}',
				'{$company_country}',
				'{$item_names_list}',
				'{$dollars_spent_order}',
				'{$unsubscribe_link}',
				'{$shipping_fname}',
				'{$shipping_lname}',
				'{$shipping_company_name}',
				'{$shipping_address1}',
				'{$shipping_address2}',
				'{$shipping_city}',
				'{$shipping_state}',
				'{$shipping_postcode}',
				'{$shipping_phone}',
				'{$order_item_id}',
				'{$order_item_status}',
				'{$order_item_name}');
		
			$replacements = array(
				$logo,
				$admin_logo,
				$admin_user_data['email'],
				$general_setting_data['phone'],
				$admin_user_data['username'],
				ADMIN_URL,
				$general_setting_data['admin_panel_name'],
				$general_setting_data['from_name'],
				$general_setting_data['from_email'],
				$general_setting_data['site_name'],
				SITE_URL,
				$order_data['first_name'],
				$order_data['last_name'],
				$order_data['name'],
				$order_data['phone'],
				$order_data['email'],
				$order_data['address'],
				$order_data['address2'],
				$order_data['city'],
				$order_data['state'],
				$order_data['country'],
				$order_data['postcode'],
				$order_data['order_id'],
				$order_data['payment_method'],
				$order_data['order_date'],
				date('m/d/Y',strtotime($order_data['approved_date'])),
				date('m/d/Y',strtotime($order_data['expire_date'])),
				replace_us_to_space($order_data['order_status_name']),
				replace_us_to_space($order_data['sales_pack']),
				date('Y-m-d H:i'),
				$order_item_body,
				$company_name,
				$company_address,
				$company_city,
				$company_state,
				$company_zipcode,
				$company_country,
				$item_names_list,
				amount_fomat($total),
				$unsubscribe_link,
				$order_data['shipping_first_name'],
				$order_data['shipping_last_name'],
				$order_data['shipping_company_name'],
				$order_data['shipping_address'],
				$order_data['shipping_address2'],
				$order_data['shipping_city'],
				$order_data['shipping_state'],
				$order_data['shipping_postcode'],
				$order_data['shipping_phone'],
				'#'.$order_item_data['order_item_id'],
				replace_us_to_space($order_item_status_data['name']),
				$order_item_name);

			//START email send to customer
			if(!empty($template_data)) {
				echo '<br>Reminder sent of this order('.$order_id.') item ID:'.$order_item_data['order_item_id'];

				$email_subject = str_replace($patterns,$replacements,$template_data['subject']);
				$email_body_text = str_replace($patterns,$replacements,$template_data['content']);
				
				send_email($order_data['email'], $email_subject, $email_body_text, FROM_NAME, FROM_EMAIL);
	
				$unsubsc_data_arr = array('user_id'=>$order_data['user_id'],
									'token'=>$unsubscribe_token);
				unsubscribe_user_tokens($unsubsc_data_arr);

				//START sms send to customer
				/*if($template_data['sms_status']=='1') {
					$from_number = '+'.$general_setting_data['twilio_long_code'];
					$to_number = '+'.$order_data['phone'];
					if($from_number && $account_sid && $auth_token) {
						$sms_body_text = str_replace($patterns,$replacements,$template_data['sms_content']);
						
						try {
							$sms_api->messages->create(
								$to_number,
								array(
									'from' => $from_number,
									'body' => $sms_body_text
								)
							);
						} catch(Services_Twilio_RestException $e) {
							$sms_error_msg = $e->getMessage();
							error_log($sms_error_msg);
						}
					}
				}*/ //END sms send to customer
			} //END email send to customer
			
		}
	}
} else {
	echo '<br>Criteria not matched.';
}
exit;
?>