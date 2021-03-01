<?php
$file_name="general_settings";

//Header section
require_once("include/header.php");

//Fetch general settings data
$query=mysqli_query($db,'SELECT * FROM general_setting ORDER BY id DESC');
$general_setting_data=mysqli_fetch_assoc($query);
$display_terms = json_decode($general_setting_data['display_terms'],true);
$currency = @explode(",",$general_setting_data['currency']);
$payment_option = json_decode($general_setting_data['payment_option'],true);
$payment_instruction = json_decode($general_setting_data['payment_instruction'],true);
$success_page_content = json_decode($general_setting_data['success_page_content'],true);
$sales_pack = json_decode($general_setting_data['sales_pack'],true);
$shipping_option = json_decode($general_setting_data['shipping_option'],true);
$page_list_limit = $general_setting_data['page_list_limit'];
$captcha_settings = json_decode($general_setting_data['captcha_settings'],true);
$other_settings = json_decode($general_setting_data['other_settings'],true);
$theme_settings = json_decode($general_setting_data['theme_settings'],true);

$theme_settings_fields_arr = array('main_background_color','main_background_text_color','primary_color','primary_text_color','secondary_color','secondary_text_color','tertiary_color','tertiary_text_color','primary_hover_color','primary_text_hover_color','secondary_hover_color','secondary_text_hover_color','tertiary_hover_color','tertiary_text_hover_color','header_calltoaction_button_color','header_calltoaction_button_text_color','header_calltoaction_button_hover_color','header_calltoaction_button_text_hover_color','menu_color','menu_hover_color','footer_background_color','footer_text_color','footer_text_hover_color','social_icons_background_color','social_icons_background_hover_color','social_icons_text_color','heading_title_color','sub_menu_color','sub_menu_hover_color','sub_menu_background_color');
foreach($theme_settings_fields_arr as $theme_settings_fields_k=>$theme_settings_fields_v) {
	if(empty($theme_settings[$theme_settings_fields_v])) {
		$theme_settings[$theme_settings_fields_v] = '';
	}
}

if(empty($payment_instruction['bank'])) {
	$payment_instruction['bank'] = '';
}
if(empty($payment_instruction['paypal'])) {
	$payment_instruction['paypal'] = '';
}
if(empty($payment_instruction['cheque'])) {
	$payment_instruction['cheque'] = '';
}
if(empty($payment_instruction['venmo'])) {
	$payment_instruction['venmo'] = '';
}
if(empty($payment_instruction['zelle'])) {
	$payment_instruction['zelle'] = '';
}
if(empty($payment_instruction['amazon_gcard'])) {
	$payment_instruction['amazon_gcard'] = '';
}
if(empty($payment_instruction['cash'])) {
	$payment_instruction['cash'] = '';
}
if(empty($payment_instruction['cash_app'])) {
	$payment_instruction['cash_app'] = '';
}
if(empty($payment_instruction['apple_pay'])) {
	$payment_instruction['apple_pay'] = '';
}
if(empty($payment_instruction['google_pay'])) {
	$payment_instruction['google_pay'] = '';
}
if(empty($payment_instruction['coinbase'])) {
	$payment_instruction['coinbase'] = '';
}
if(empty($payment_instruction['facebook_pay'])) {
	$payment_instruction['facebook_pay'] = '';
}

if(empty($payment_option['bank'])) {
	$payment_option['bank'] = '';
}
if(empty($payment_option['paypal'])) {
	$payment_option['paypal'] = '';
}
if(empty($payment_option['cheque'])) {
	$payment_option['cheque'] = '';
}
if(empty($payment_option['venmo'])) {
	$payment_option['venmo'] = '';
}
if(empty($payment_option['zelle'])) {
	$payment_option['zelle'] = '';
}
if(empty($payment_option['amazon_gcard'])) {
	$payment_option['amazon_gcard'] = '';
}
if(empty($payment_option['cash'])) {
	$payment_option['cash'] = '';
}
if(empty($payment_option['cash_app'])) {
	$payment_option['cash_app'] = '';
}
if(empty($payment_option['apple_pay'])) {
	$payment_option['apple_pay'] = '';
}
if(empty($payment_option['google_pay'])) {
	$payment_option['google_pay'] = '';
}
if(empty($payment_option['coinbase'])) {
	$payment_option['coinbase'] = '';
}
if(empty($payment_option['facebook_pay'])) {
	$payment_option['facebook_pay'] = '';
}

if(empty($other_settings['top_right_menu'])) {
	$other_settings['top_right_menu'] = '';
}
if(empty($other_settings['header_menu'])) {
	$other_settings['header_menu'] = '';
}
if(empty($other_settings['footer_menu_column1'])) {
	$other_settings['footer_menu_column1'] = '';
}
if(empty($other_settings['footer_menu_column2'])) {
	$other_settings['footer_menu_column2'] = '';
}
if(empty($other_settings['footer_menu_column3'])) {
	$other_settings['footer_menu_column3'] = '';
}
if(empty($other_settings['copyright_menu'])) {
	$other_settings['copyright_menu'] = '';
}
if(empty($other_settings['footer_menu_column1_title'])) {
	$other_settings['footer_menu_column1_title'] = '';
}
if(empty($other_settings['footer_menu_column2_title'])) {
	$other_settings['footer_menu_column2_title'] = '';
}
if(empty($other_settings['footer_menu_column3_title'])) {
	$other_settings['footer_menu_column3_title'] = '';
}
if(empty($other_settings['allow_guest_user_order'])) {
	$other_settings['allow_guest_user_order'] = '';
}
if(empty($other_settings['show_cust_delivery_note'])) {
	$other_settings['show_cust_delivery_note'] = '';
}
if(empty($other_settings['show_cust_order_form'])) {
	$other_settings['show_cust_order_form'] = '';
}
if(empty($other_settings['show_cust_sales_confirmation'])) {
	$other_settings['show_cust_sales_confirmation'] = '';
}

if(empty($sales_pack['free'])) {
	$sales_pack['free'] = '';
}
if(empty($sales_pack['own'])) {
	$sales_pack['own'] = '';
}

if(empty($shipping_option['post_me_a_prepaid_label'])) {
	$shipping_option['post_me_a_prepaid_label'] = '';
}
if(empty($shipping_option['print_a_prepaid_label'])) {
	$shipping_option['print_a_prepaid_label'] = '';
}
if(empty($shipping_option['use_my_own_courier'])) {
	$shipping_option['use_my_own_courier'] = '';
}
if(empty($shipping_option['we_come_for_you'])) {
	$shipping_option['we_come_for_you'] = '';
}
if(empty($shipping_option['store'])) {
	$shipping_option['store'] = '';
}
if(empty($shipping_option['starbucks'])) {
	$shipping_option['starbucks'] = '';
}


if(empty($shipping_option['post_me_a_prepaid_label_order'])) {
	$shipping_option['post_me_a_prepaid_label_order'] = '';
}
if(empty($shipping_option['print_a_prepaid_label_order'])) {
	$shipping_option['print_a_prepaid_label_order'] = '';
}
if(empty($shipping_option['use_my_own_courier_order'])) {
	$shipping_option['use_my_own_courier_order'] = '';
}
if(empty($shipping_option['we_come_for_you_order'])) {
	$shipping_option['we_come_for_you_order'] = '';
}
if(empty($shipping_option['store_order'])) {
	$shipping_option['store_order'] = '';
}
if(empty($shipping_option['starbucks_order'])) {
	$shipping_option['starbucks_order'] = '';
}

if(empty($shipping_option['post_me_a_prepaid_label_image'])) {
	$shipping_option['post_me_a_prepaid_label_image'] = '';
}
if(empty($shipping_option['print_a_prepaid_label_image'])) {
	$shipping_option['print_a_prepaid_label_image'] = '';
}
if(empty($shipping_option['use_my_own_courier_image'])) {
	$shipping_option['use_my_own_courier_image'] = '';
}
if(empty($shipping_option['we_come_for_you_image'])) {
	$shipping_option['we_come_for_you_image'] = '';
}
if(empty($shipping_option['store_image'])) {
	$shipping_option['store_image'] = '';
}
if(empty($shipping_option['starbucks_image'])) {
	$shipping_option['starbucks_image'] = '';
}

if(empty($shipping_option['post_me_a_prepaid_label_image_rm'])) {
	$shipping_option['post_me_a_prepaid_label_image_rm'] = '';
}
if(empty($shipping_option['print_a_prepaid_label_image_rm'])) {
	$shipping_option['print_a_prepaid_label_image_rm'] = '';
}
if(empty($shipping_option['use_my_own_courier_image_rm'])) {
	$shipping_option['use_my_own_courier_image_rm'] = '';
}
if(empty($shipping_option['we_come_for_you_image_rm'])) {
	$shipping_option['we_come_for_you_image_rm'] = '';
}
if(empty($shipping_option['store_image_rm'])) {
	$shipping_option['store_image_rm'] = '';
}
if(empty($shipping_option['starbucks_image_rm'])) {
	$shipping_option['starbucks_image_rm'] = '';
}

if(empty($display_terms['ac_creation'])) {
	$display_terms['ac_creation'] = '';
}
if(empty($display_terms['confirm_sale'])) {
	$display_terms['confirm_sale'] = '';
}

if(empty($display_terms['ac_creation'])) {
	$display_terms['ac_creation'] = '';
}
if(empty($display_terms['confirm_sale'])) {
	$display_terms['confirm_sale'] = '';
}

if(empty($captcha_settings['contact_form'])) {
	$captcha_settings['contact_form'] = '';
}
if(empty($captcha_settings['write_review_form'])) {
	$captcha_settings['write_review_form'] = '';
}
if(empty($captcha_settings['bulk_order_form'])) {
	$captcha_settings['bulk_order_form'] = '';
}
if(empty($captcha_settings['affiliate_form'])) {
	$captcha_settings['affiliate_form'] = '';
}
if(empty($captcha_settings['appt_form'])) {
	$captcha_settings['appt_form'] = '';
}
if(empty($captcha_settings['login_form'])) {
	$captcha_settings['login_form'] = '';
}

if(empty($captcha_settings['signup_form'])) {
	$captcha_settings['signup_form'] = '';
}
if(empty($captcha_settings['contractor_form'])) {
	$captcha_settings['contractor_form'] = '';
}
if(empty($captcha_settings['order_track_form'])) {
	$captcha_settings['order_track_form'] = '';
}
if(empty($captcha_settings['newsletter_form'])) {
	$captcha_settings['newsletter_form'] = '';
}
if(empty($captcha_settings['missing_product_form'])) {
	$captcha_settings['missing_product_form'] = '';
}
if(empty($captcha_settings['imei_number_based_search_form'])) {
	$captcha_settings['imei_number_based_search_form'] = '';
}

if(empty($other_settings['is_show_reviews_side_bar_menu'])) {
	$other_settings['is_show_reviews_side_bar_menu'] = '';
}
if(empty($other_settings['is_show_write_review_side_bar_menu'])) {
	$other_settings['is_show_write_review_side_bar_menu'] = '';
}
if(empty($other_settings['is_show_contact_us_side_bar_menu'])) {
	$other_settings['is_show_contact_us_side_bar_menu'] = '';
}
if(empty($other_settings['is_show_email_us_side_bar_menu'])) {
	$other_settings['is_show_email_us_side_bar_menu'] = '';
}
if(empty($other_settings['is_show_terms_condition_side_bar_menu'])) {
	$other_settings['is_show_terms_condition_side_bar_menu'] = '';
}
if(empty($other_settings['is_show_privacy_side_bar_menu'])) {
	$other_settings['is_show_privacy_side_bar_menu'] = '';
}
if(empty($other_settings['is_show_track_order_side_bar_menu'])) {
	$other_settings['is_show_track_order_side_bar_menu'] = '';
}
if(empty($other_settings['is_show_faq_side_bar_menu'])) {
	$other_settings['is_show_faq_side_bar_menu'] = '';
}
if(empty($other_settings['is_show_faq_grp'])) {
	$other_settings['is_show_faq_grp'] = '';
}
if(empty($other_settings['is_show_sell_by_category_bottom_menu'])) {
	$other_settings['is_show_sell_by_category_bottom_menu'] = '';
}
if(empty($other_settings['is_show_sell_by_brand_bottom_menu'])) {
	$other_settings['is_show_sell_by_brand_bottom_menu'] = '';
}
if(empty($other_settings['is_show_sell_by_devices_bottom_menu'])) {
	$other_settings['is_show_sell_by_devices_bottom_menu'] = '';
}
if(empty($other_settings['is_show_search_bottom_menu'])) {
	$other_settings['is_show_search_bottom_menu'] = '';
}
if(empty($other_settings['imei_api_key'])) {
	$other_settings['imei_api_key'] = '';
}
if(empty($other_settings['map_key'])) {
	$other_settings['map_key'] = '';
}

if(empty($other_settings['newslettter_section'])) {
	$other_settings['newslettter_section'] = '';
}

if(!isset($other_settings['customer_country_code'])) {
	$other_settings['customer_country_code'] = '';
}
if(!isset($other_settings['order_expiring_days'])) {
	$other_settings['order_expiring_days'] = '';
}
if(!isset($other_settings['order_expired_days'])) {
	$other_settings['order_expired_days'] = '';
}
if(!isset($other_settings['maintainance_mode'])) {
	$other_settings['maintainance_mode'] = '';
}
if(!isset($other_settings['cheque_check_label'])) {
	$other_settings['cheque_check_label'] = '';
}
if(!isset($other_settings['cheque_check_label'])) {
	$other_settings['cheque_check_label'] = '';
}
if(!isset($other_settings['cheque_check_label'])) {
	$other_settings['cheque_check_label'] = '';
}
if(!isset($other_settings['cheque_check_label'])) {
	$other_settings['cheque_check_label'] = '';
}
if(!isset($other_settings['cheque_check_label'])) {
	$other_settings['cheque_check_label'] = '';
}
if(!isset($other_settings['shipping_api_service'])) {
	$other_settings['shipping_api_service'] = '';
}
if(!isset($other_settings['shipping_api_package'])) {
	$other_settings['shipping_api_package'] = '';
}
if(!isset($other_settings['shipping_api_service'])) {
	$other_settings['shipping_api_service'] = '';
}
if(!isset($other_settings['header_bg_color'])) {
	$other_settings['header_bg_color'] = '';
}
if(!isset($other_settings['header_text_color'])) {
	$other_settings['header_text_color'] = '';
}
if(!isset($other_settings['footer_bg_color'])) {
	$other_settings['footer_bg_color'] = '';
}
if(!isset($other_settings['footer_text_color'])) {
	$other_settings['footer_text_color'] = '';
}

//Template file
require_once("views/general_settings.php"); ?>
