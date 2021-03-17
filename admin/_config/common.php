<?php
$admin_query=mysqli_query($db,"SELECT username, email FROM admin WHERE type='super_admin' ORDER BY id DESC");
$admin_detail=mysqli_fetch_assoc($admin_query);

$gs_query=mysqli_query($db,'SELECT * FROM general_setting ORDER BY id DESC');
$general_setting_data=mysqli_fetch_assoc($gs_query);

$model_details_page_slug = "product/";
//$model_details_page_slug = "";

//Below variable is to display hint text in setting for order prefix field
$order_number_datetime_format_lbl = "M/D/Y";

//Below is actual format of date of prefix order number
$order_number_datetime_format = 'm-d-y';

$backend_paypal_payment_mode = "test"; //Value will be "test" OR "live"
$custom_js_code = $general_setting_data['custom_js_code'];
$after_body_js_code = $general_setting_data['after_body_js_code'];
$before_body_js_code = $general_setting_data['before_body_js_code'];
$favicon_icon = $general_setting_data['favicon_icon'];
$company_name = $general_setting_data['company_name'];
$company_address = $general_setting_data['company_address'];
$company_city = $general_setting_data['company_city'];
$company_state = $general_setting_data['company_state'];
$company_country = $general_setting_data['company_country'];
$phone_country_short_code = $general_setting_data['company_country'];
$company_zipcode = $general_setting_data['company_zipcode'];
$company_phone = $general_setting_data['company_phone'];
$company_email = $general_setting_data['company_email'];
$other_settings = json_decode($general_setting_data['other_settings'],true);
define('TIMEZONE',$general_setting_data['timezone']);

$contractor_concept = 1;

$order_expiring_days = ($other_settings['order_expiring_days']?$other_settings['order_expiring_days']:0);
$order_expired_days = ($other_settings['order_expired_days']?$other_settings['order_expired_days']:0);

$amount_sign = '&#163;';
$top_seller_limit = ($general_setting_data['top_seller_limit']>0?$general_setting_data['top_seller_limit']:0);
$fb_page_url = trim($general_setting_data['fb_page_url']);

$social_login = trim($general_setting_data['social_login']);
$social_login_option = trim($general_setting_data['social_login_option']);
$google_client_id = trim($general_setting_data['google_client_id']);
$google_client_secret = trim($general_setting_data['google_client_secret']);
$fb_app_id = trim($general_setting_data['fb_app_id']);
$fb_app_secret = trim($general_setting_data['fb_app_secret']);

$sms_sending_status = trim($general_setting_data['sms_sending_status']);

$amount_sign_with_prefix = '';
$amount_sign_with_postfix = '';

$disp_currency = $general_setting_data['disp_currency'];
$currency = @explode(",",$general_setting_data['currency']);
$currency_symbol = $currency[1];
if($disp_currency=="prefix")
	$amount_sign_with_prefix = $currency_symbol;
elseif($disp_currency=="postfix")
	$amount_sign_with_postfix = $currency_symbol;

$choosed_payment_option = json_decode($general_setting_data['payment_option'],true);
if(empty($choosed_payment_option['bank'])) {
	$choosed_payment_option['bank'] = "";
}
if(empty($choosed_payment_option['cheque'])) {
	$choosed_payment_option['cheque'] = "";
}
if(empty($choosed_payment_option['paypal'])) {
	$choosed_payment_option['paypal'] = "";
}
if(empty($choosed_payment_option['venmo'])) {
	$choosed_payment_option['venmo'] = "";
}
if(empty($choosed_payment_option['zelle'])) {
	$choosed_payment_option['zelle'] = "";
}
if(empty($choosed_payment_option['amazon_gcard'])) {
	$choosed_payment_option['amazon_gcard'] = "";
}
if(empty($choosed_payment_option['cash'])) {
	$choosed_payment_option['cash'] = "";
}
if(empty($choosed_payment_option['cash_app'])) {
	$choosed_payment_option['cash_app'] = '';
}
if(empty($choosed_payment_option['apple_pay'])) {
	$choosed_payment_option['apple_pay'] = '';
}
if(empty($choosed_payment_option['google_pay'])) {
	$choosed_payment_option['google_pay'] = '';
}
if(empty($choosed_payment_option['coinbase'])) {
	$choosed_payment_option['coinbase'] = '';
}
if(empty($choosed_payment_option['facebook_pay'])) {
	$choosed_payment_option['facebook_pay'] = '';
}

$payment_instruction = json_decode($general_setting_data['payment_instruction'],true);
if(empty($payment_instruction['bank'])) {
	$payment_instruction['bank'] = "";
}
if(empty($payment_instruction['cheque'])) {
	$payment_instruction['cheque'] = "";
}
if(empty($payment_instruction['paypal'])) {
	$payment_instruction['paypal'] = "";
}
if(empty($payment_instruction['venmo'])) {
	$payment_instruction['venmo'] = "";
}
if(empty($payment_instruction['zelle'])) {
	$payment_instruction['zelle'] = "";
}
if(empty($payment_instruction['amazon_gcard'])) {
	$payment_instruction['amazon_gcard'] = "";
}
if(empty($payment_instruction['cash'])) {
	$payment_instruction['cash'] = "";
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

$shipping_option = json_decode($general_setting_data['shipping_option'],true);
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

$shipping_option_ordr_arr = array();
$soal_n = 0;
$shipping_option_arr_list = array('post_me_a_prepaid_label','use_my_own_courier','we_come_for_you','store','starbucks','print_a_prepaid_label');
foreach($shipping_option_arr_list as $soal_k=>$soal_v) {
	$soal_n=$soal_n+1;
	$shipping_option_ordr_indx = (!empty($shipping_option[$soal_v.'_order'])?$shipping_option[$soal_v.'_order']:$soal_n);
	$shipping_option_ordr_arr[$shipping_option_ordr_indx] = $soal_v;
}
ksort($shipping_option_ordr_arr);

$default_payment_option = ($general_setting_data['default_payment_option']?$general_setting_data['default_payment_option']:"bank");
$order_prefix = $general_setting_data['order_prefix'];

$display_terms_array = json_decode($general_setting_data['display_terms'],true);
if(empty($display_terms_array['ac_creation'])) {
	$display_terms_array['ac_creation'] = 0;
}
if(empty($display_terms_array['confirm_sale'])) {
	$display_terms_array['confirm_sale'] = 0;
}

$choosed_sales_pack_array = json_decode($general_setting_data['sales_pack'],true);

$page_list_limit = ($general_setting_data['page_list_limit']>5?$general_setting_data['page_list_limit']:5);
$blog_recent_posts = trim($general_setting_data['blog_recent_posts']);
$blog_categories = trim($general_setting_data['blog_categories']);
$blog_rm_words_limit = trim($general_setting_data['blog_rm_words_limit']);

define('ADMIN_PANEL_NAME',$general_setting_data['admin_panel_name']);
define('SITE_NAME',$general_setting_data['site_name']);
define('FROM_EMAIL',$general_setting_data['from_email']);
define('FROM_NAME',$general_setting_data['from_name']);

$allow_sms_verify_of_admin_staff_login = $general_setting_data['allow_sms_verify_of_admin_staff_login'];
$is_space_between_currency_symbol = $general_setting_data['is_space_between_currency_symbol'];
$thousand_separator = $general_setting_data['thousand_separator'];
$decimal_separator = $general_setting_data['decimal_separator'];
$decimal_number = $general_setting_data['decimal_number'];

// Offer popup related
$offer_popup_delay_time_in_ms = 0;
$offer_popup_delay_time = 1;
if($offer_popup_delay_time > 0) {
	$offer_popup_delay_time_in_ms = ($offer_popup_delay_time * 1000);
}
$allow_offer_popup = $general_setting_data['allow_offer_popup'];
$offer_popup_title = $general_setting_data['offer_popup_title'];
$offer_popup_content = $general_setting_data['offer_popup_content'];

$order_expiring_days = ($other_settings['order_expiring_days']?$other_settings['order_expiring_days']:0);
$order_expired_days = ($other_settings['order_expired_days']?$other_settings['order_expired_days']:0);

$newslettter_section = '';
if(isset($other_settings['newslettter_section'])) {
	$newslettter_section = $other_settings['newslettter_section'];
}

$text_field_of_model_fields = '';
if(isset($other_settings['text_field_of_model_fields'])) {
	$text_field_of_model_fields = $other_settings['text_field_of_model_fields'];
}

$text_area_of_model_fields = '';
if(isset($other_settings['text_area_of_model_fields'])) {
	$text_area_of_model_fields = $other_settings['text_area_of_model_fields'];
}

$calendar_of_model_fields = '';
if(isset($other_settings['calendar_of_model_fields'])) {
	$calendar_of_model_fields = $other_settings['calendar_of_model_fields'];
}

$file_upload_of_model_fields = '';
if(isset($other_settings['file_upload_of_model_fields'])) {
	$file_upload_of_model_fields = $other_settings['file_upload_of_model_fields'];
}

$tooltips_of_model_fields = '';
if(isset($other_settings['tooltips_of_model_fields'])) {
	$tooltips_of_model_fields = $other_settings['tooltips_of_model_fields'];
}

$icons_of_model_fields = '';
if(isset($other_settings['icons_of_model_fields'])) {
	$icons_of_model_fields = $other_settings['icons_of_model_fields'];
}

$show_instant_price_on_model_criteria_selections = '';
if(isset($other_settings['show_instant_price_on_model_criteria_selections'])) {
	$show_instant_price_on_model_criteria_selections = $other_settings['show_instant_price_on_model_criteria_selections'];
}

$allow_guest_user_order = '';
if(isset($other_settings['allow_guest_user_order'])) {
	$allow_guest_user_order = $other_settings['allow_guest_user_order'];
}

$cheque_check_label = ($other_settings['cheque_check_label']?$other_settings['cheque_check_label']:"Check");

$service_hours_status = $other_settings['service_hours_status'];

$maintainance_mode = '';
if(isset($other_settings['maintainance_mode'])) {
	$maintainance_mode = $other_settings['maintainance_mode'];
}

$show_cust_delivery_note = '';
if(isset($other_settings['show_cust_delivery_note'])) {
	$show_cust_delivery_note = $other_settings['show_cust_delivery_note'];
}

$show_cust_order_form = '';
if(isset($other_settings['show_cust_order_form'])) {
	$show_cust_order_form = $other_settings['show_cust_order_form'];
}

$show_cust_sales_confirmation = '';
if(isset($other_settings['show_cust_sales_confirmation'])) {
	$show_cust_sales_confirmation = $other_settings['show_cust_sales_confirmation'];
}
$hide_device_order_valuation_price = 0;

$imei_api_key = '';
if(isset($other_settings['imei_api_key'])) {
	$imei_api_key = $other_settings['imei_api_key'];
}

$map_key = '';
if(isset($other_settings['map_key'])) {
	$map_key = $other_settings['map_key'];
}

$admin_logo_width = !empty($other_settings['admin_logo_width'])?$other_settings['admin_logo_width']:'';
$logo_width = !empty($other_settings['logo_width'])?$other_settings['logo_width']:'';
$fixed_logo_width = !empty($other_settings['fixed_logo_width'])?$other_settings['fixed_logo_width']:'';
$footer_logo_width = !empty($other_settings['footer_logo_width'])?$other_settings['footer_logo_width']:'';
$email_logo_width = !empty($other_settings['email_logo_width'])?$other_settings['email_logo_width']:'';

$admin_logo_height = !empty($other_settings['admin_logo_height'])?$other_settings['admin_logo_height']:'';
$logo_height = !empty($other_settings['logo_height'])?$other_settings['logo_height']:'';
$fixed_logo_height = !empty($other_settings['fixed_logo_height'])?$other_settings['fixed_logo_height']:'';
$footer_logo_height = !empty($other_settings['footer_logo_height'])?$other_settings['footer_logo_height']:'';
$email_logo_height = !empty($other_settings['email_logo_height'])?$other_settings['email_logo_height']:'';

$logo_url = "";
$logo_fixed_url = "";
$footer_logo_url = "";
if($general_setting_data['logo']) {
	$logo_url = SITE_URL.'images/'.$general_setting_data['logo'];
}
if($general_setting_data['logo']) {
	$logo_fixed_url = SITE_URL.'images/'.$general_setting_data['logo_fixed'];
}
if($general_setting_data['footer_logo']) {
	$footer_logo_url = SITE_URL.'images/'.$general_setting_data['footer_logo'];
}
$site_phone = $general_setting_data['phone'];
$site_email = $general_setting_data['email'];
$website = $general_setting_data['website'];
$copyright = $general_setting_data['copyright'];
$theme_color_type = "green";//$general_setting_data['theme_option'];

$logo = '<img src="'.$logo_url.'" width="'.$logo_width.'">';
$logo_fixed = '<img src="'.$logo_fixed_url.'" width="'.$fixed_logo_width.'">';

$admin_logo = '';
if($general_setting_data['admin_logo']) {
	$admin_logo = '<img src="'.SITE_URL.'images/'.$general_setting_data['admin_logo'].'" width="'.$admin_logo_width.'" height="'.$admin_logo_height.'">';
}

//START for footer social
$socials_link = '';
$fb_link = trim($general_setting_data['fb_link']);
$twitter_link = trim($general_setting_data['twitter_link']);
$linkedin_link = trim($general_setting_data['linkedin_link']);
$instagram_link = trim($general_setting_data['instagram_link']);
if($fb_link) {
	$socials_link .= '<li class="list-inline-item"><a class="border-0" href="'.$fb_link.'" target="_blank"><i class="fab fa-facebook-f"></i></a></li>';
}
if($twitter_link) {
	$socials_link .= '<li class="list-inline-item"><a class="border-0" href="'.$twitter_link.'" target="_blank"><i class="fab fa-twitter"></i></a></li>';
}
if($linkedin_link) {
	$socials_link .= '<li class="list-inline-item"><a class="border-0" href="'.$linkedin_link.'" target="_blank"><i class="fab fa-linkedin-in"></i></a></li>';
}
if($instagram_link) {
	$socials_link .= '<li class="list-inline-item"><a class="border-0" href="'.$instagram_link.'" target="_blank"><i class="fab fa-instagram"></i></a></li>';
} //END for footer social

$shipping_api = trim($general_setting_data['shipping_api']);
$shipment_generated_by_cust = trim($general_setting_data['shipment_generated_by_cust']);
$shipping_api_key = trim($general_setting_data['shipping_api_key']);
$shipping_api_secret = trim($general_setting_data['shipping_api_secret']);
$default_carrier_account = trim($general_setting_data['default_carrier_account']);
$carrier_account_id = trim($general_setting_data['carrier_account_id']);

$shipping_api_service = '';
if(isset($other_settings['shipping_api_service'])) {
	$shipping_api_service = $other_settings['shipping_api_service'];
}

$shipping_api_package = '';
if(isset($other_settings['shipping_api_package'])) {
	$shipping_api_package = $other_settings['shipping_api_package'];
}

$sales_confirmation_pdf_content = '';
if(isset($general_setting_data['sales_confirmation_pdf_content'])) {
	$sales_confirmation_pdf_content = $general_setting_data['sales_confirmation_pdf_content'];
}

$shipping_parcel_lg = trim($general_setting_data['shipping_parcel_length']);
$shipping_parcel_wd = trim($general_setting_data['shipping_parcel_width']);
$shipping_parcel_hg = trim($general_setting_data['shipping_parcel_height']);
$shipping_parcel_wg = trim($general_setting_data['shipping_parcel_weight']);

$shipping_parcel_length = ($shipping_parcel_lg?$shipping_parcel_lg:'20.2');
$shipping_parcel_width = ($shipping_parcel_wd?$shipping_parcel_wd:'10.9');
$shipping_parcel_height = ($shipping_parcel_hg?$shipping_parcel_hg:'5');
$shipping_parcel_weight = ($shipping_parcel_wg?$shipping_parcel_wg:'65.9');

$captcha_settings = json_decode($general_setting_data['captcha_settings'],true);
$contact_form_captcha = '0';
$write_review_form_captcha = '0';
$bulk_order_form_captcha = '0';
$affiliate_form_captcha = '0';
//$appt_form_captcha = '0';
$login_form_captcha = '0';
$signup_form_captcha = '0';
//$contractor_form_captcha = '0';
$order_track_form_captcha = '0';
$newsletter_form_captcha = '0';
$missing_product_form_captcha = '0';
$imei_number_based_search_form_captcha = '0';
$captcha_key = $captcha_settings['captcha_key'];
$captcha_secret = $captcha_settings['captcha_secret'];
if($captcha_key!="" && $captcha_secret!="") {
	$contact_form_captcha = isset($captcha_settings['contact_form'])?$captcha_settings['contact_form']:0;
	$write_review_form_captcha = isset($captcha_settings['write_review_form'])?$captcha_settings['write_review_form']:0;
	$bulk_order_form_captcha = isset($captcha_settings['bulk_order_form'])?$captcha_settings['bulk_order_form']:0;
	$affiliate_form_captcha = isset($captcha_settings['affiliate_form'])?$captcha_settings['affiliate_form']:0;
	//$appt_form_captcha = $captcha_settings['appt_form'];
	$login_form_captcha = isset($captcha_settings['login_form'])?$captcha_settings['login_form']:0;
	$signup_form_captcha = isset($captcha_settings['signup_form'])?$captcha_settings['signup_form']:0;
	//$contractor_form_captcha = $captcha_settings['contractor_form'];
	$order_track_form_captcha = isset($captcha_settings['order_track_form'])?$captcha_settings['order_track_form']:0;
	$newsletter_form_captcha = isset($captcha_settings['newsletter_form'])?$captcha_settings['newsletter_form']:0;
	$missing_product_form_captcha = isset($captcha_settings['missing_product_form'])?$captcha_settings['missing_product_form']:0;
	$imei_number_based_search_form_captcha = isset($captcha_settings['imei_number_based_search_form'])?$captcha_settings['imei_number_based_search_form']:0;
}

$is_act_top_right_menu = '';
if(isset($other_settings['top_right_menu'])) {
	$is_act_top_right_menu = $other_settings['top_right_menu'];
}

$is_act_header_menu = '';
if(isset($other_settings['header_menu'])) {
	$is_act_header_menu = $other_settings['header_menu'];
}

$is_act_footer_menu_column1 = '';
if(isset($other_settings['footer_menu_column1'])) {
	$is_act_footer_menu_column1 = $other_settings['footer_menu_column1'];
}

$is_act_footer_menu_column2 = '';
if(isset($other_settings['footer_menu_column2'])) {
	$is_act_footer_menu_column2 = $other_settings['footer_menu_column2'];
}

$is_act_footer_menu_column3 = '';
if(isset($other_settings['footer_menu_column3'])) {
	$is_act_footer_menu_column3 = $other_settings['footer_menu_column3'];
}

$is_act_copyright_menu = '';
if(isset($other_settings['copyright_menu'])) {
	$is_act_copyright_menu = $other_settings['copyright_menu'];
}

$footer_menu_column1_title = '';
if(isset($other_settings['footer_menu_column1_title'])) {
	$footer_menu_column1_title = $other_settings['footer_menu_column1_title'];
}

$footer_menu_column2_title = '';
if(isset($other_settings['footer_menu_column2_title'])) {
	$footer_menu_column2_title = $other_settings['footer_menu_column2_title'];
}

$footer_menu_column3_title = '';
if(isset($other_settings['footer_menu_column3_title'])) {
	$footer_menu_column3_title = $other_settings['footer_menu_column3_title'];
}

if(empty($choosed_payment_option['cheque'])) {
	$choosed_payment_option['cheque'] = "";
}

$top_seller_mode = "";

$countries_list = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");

$comp_countries_list = json_decode('[ [ "Afghanistan (‫افغانستان‬‎)", "af", "93" ], [ "Albania (Shqipëri)", "al", "355" ], [ "Algeria (‫الجزائر‬‎)", "dz", "213" ], [ "American Samoa", "as", "1684" ], [ "Andorra", "ad", "376" ], [ "Angola", "ao", "244" ], [ "Anguilla", "ai", "1264" ], [ "Antigua and Barbuda", "ag", "1268" ], [ "Argentina", "ar", "54" ], [ "Armenia (Հայաստան)", "am", "374" ], [ "Aruba", "aw", "297" ], [ "Australia", "au", "61", 0 ], [ "Austria (Österreich)", "at", "43" ], [ "Azerbaijan (Azərbaycan)", "az", "994" ], [ "Bahamas", "bs", "1242" ], [ "Bahrain (‫البحرين‬‎)", "bh", "973" ], [ "Bangladesh (বাংলাদেশ)", "bd", "880" ], [ "Barbados", "bb", "1246" ], [ "Belarus (Беларусь)", "by", "375" ], [ "Belgium (België)", "be", "32" ], [ "Belize", "bz", "501" ], [ "Benin (Bénin)", "bj", "229" ], [ "Bermuda", "bm", "1441" ], [ "Bhutan (འབྲུག)", "bt", "975" ], [ "Bolivia", "bo", "591" ], [ "Bosnia and Herzegovina (Босна и Херцеговина)", "ba", "387" ], [ "Botswana", "bw", "267" ], [ "Brazil (Brasil)", "br", "55" ], [ "British Indian Ocean Territory", "io", "246" ], [ "British Virgin Islands", "vg", "1284" ], [ "Brunei", "bn", "673" ], [ "Bulgaria (България)", "bg", "359" ], [ "Burkina Faso", "bf", "226" ], [ "Burundi (Uburundi)", "bi", "257" ], [ "Cambodia (កម្ពុជា)", "kh", "855" ], [ "Cameroon (Cameroun)", "cm", "237" ], [ "Canada", "ca", "1", 1, [ "204", "226", "236", "249", "250", "289", "306", "343", "365", "387", "403", "416", "418", "431", "437", "438", "450", "506", "514", "519", "548", "579", "581", "587", "604", "613", "639", "647", "672", "705", "709", "742", "778", "780", "782", "807", "819", "825", "867", "873", "902", "905" ] ], [ "Cape Verde (Kabu Verdi)", "cv", "238" ], [ "Caribbean Netherlands", "bq", "599", 1 ], [ "Cayman Islands", "ky", "1345" ], [ "Central African Republic (République centrafricaine)", "cf", "236" ], [ "Chad (Tchad)", "td", "235" ], [ "Chile", "cl", "56" ], [ "China (中国)", "cn", "86" ], [ "Christmas Island", "cx", "61", 2 ], [ "Cocos (Keeling) Islands", "cc", "61", 1 ], [ "Colombia", "co", "57" ], [ "Comoros (‫جزر القمر‬‎)", "km", "269" ], [ "Congo (DRC) (Jamhuri ya Kidemokrasia ya Kongo)", "cd", "243" ], [ "Congo (Republic) (Congo-Brazzaville)", "cg", "242" ], [ "Cook Islands", "ck", "682" ], [ "Costa Rica", "cr", "506" ], [ "Côte d’Ivoire", "ci", "225" ], [ "Croatia (Hrvatska)", "hr", "385" ], [ "Cuba", "cu", "53" ], [ "Curaçao", "cw", "599", 0 ], [ "Cyprus (Κύπρος)", "cy", "357" ], [ "Czech Republic (Česká republika)", "cz", "420" ], [ "Denmark (Danmark)", "dk", "45" ], [ "Djibouti", "dj", "253" ], [ "Dominica", "dm", "1767" ], [ "Dominican Republic (República Dominicana)", "do", "1", 2, [ "809", "829", "849" ] ], [ "Ecuador", "ec", "593" ], [ "Egypt (‫مصر‬‎)", "eg", "20" ], [ "El Salvador", "sv", "503" ], [ "Equatorial Guinea (Guinea Ecuatorial)", "gq", "240" ], [ "Eritrea", "er", "291" ], [ "Estonia (Eesti)", "ee", "372" ], [ "Ethiopia", "et", "251" ], [ "Falkland Islands (Islas Malvinas)", "fk", "500" ], [ "Faroe Islands (Føroyar)", "fo", "298" ], [ "Fiji", "fj", "679" ], [ "Finland (Suomi)", "fi", "358", 0 ], [ "France", "fr", "33" ], [ "French Guiana (Guyane française)", "gf", "594" ], [ "French Polynesia (Polynésie française)", "pf", "689" ], [ "Gabon", "ga", "241" ], [ "Gambia", "gm", "220" ], [ "Georgia (საქართველო)", "ge", "995" ], [ "Germany (Deutschland)", "de", "49" ], [ "Ghana (Gaana)", "gh", "233" ], [ "Gibraltar", "gi", "350" ], [ "Greece (Ελλάδα)", "gr", "30" ], [ "Greenland (Kalaallit Nunaat)", "gl", "299" ], [ "Grenada", "gd", "1473" ], [ "Guadeloupe", "gp", "590", 0 ], [ "Guam", "gu", "1671" ], [ "Guatemala", "gt", "502" ], [ "Guernsey", "gg", "44", 1 ], [ "Guinea (Guinée)", "gn", "224" ], [ "Guinea-Bissau (Guiné Bissau)", "gw", "245" ], [ "Guyana", "gy", "592" ], [ "Haiti", "ht", "509" ], [ "Honduras", "hn", "504" ], [ "Hong Kong (香港)", "hk", "852" ], [ "Hungary (Magyarország)", "hu", "36" ], [ "Iceland (Ísland)", "is", "354" ], [ "India (भारत)", "in", "91" ], [ "Indonesia", "id", "62" ], [ "Iran (‫ایران‬‎)", "ir", "98" ], [ "Iraq (‫العراق‬‎)", "iq", "964" ], [ "Ireland", "ie", "353" ], [ "Isle of Man", "im", "44", 2 ], [ "Israel (‫ישראל‬‎)", "il", "972" ], [ "Italy (Italia)", "it", "39", 0 ], [ "Jamaica", "jm", "1876" ], [ "Japan (日本)", "jp", "81" ], [ "Jersey", "je", "44", 3 ], [ "Jordan (‫الأردن‬‎)", "jo", "962" ], [ "Kazakhstan (Казахстан)", "kz", "7", 1 ], [ "Kenya", "ke", "254" ], [ "Kiribati", "ki", "686" ], [ "Kosovo", "xk", "383" ], [ "Kuwait (‫الكويت‬‎)", "kw", "965" ], [ "Kyrgyzstan (Кыргызстан)", "kg", "996" ], [ "Laos (ລາວ)", "la", "856" ], [ "Latvia (Latvija)", "lv", "371" ], [ "Lebanon (‫لبنان‬‎)", "lb", "961" ], [ "Lesotho", "ls", "266" ], [ "Liberia", "lr", "231" ], [ "Libya (‫ليبيا‬‎)", "ly", "218" ], [ "Liechtenstein", "li", "423" ], [ "Lithuania (Lietuva)", "lt", "370" ], [ "Luxembourg", "lu", "352" ], [ "Macau (澳門)", "mo", "853" ], [ "Macedonia (FYROM) (Македонија)", "mk", "389" ], [ "Madagascar (Madagasikara)", "mg", "261" ], [ "Malawi", "mw", "265" ], [ "Malaysia", "my", "60" ], [ "Maldives", "mv", "960" ], [ "Mali", "ml", "223" ], [ "Malta", "mt", "356" ], [ "Marshall Islands", "mh", "692" ], [ "Martinique", "mq", "596" ], [ "Mauritania (‫موريتانيا‬‎)", "mr", "222" ], [ "Mauritius (Moris)", "mu", "230" ], [ "Mayotte", "yt", "262", 1 ], [ "Mexico (México)", "mx", "52" ], [ "Micronesia", "fm", "691" ], [ "Moldova (Republica Moldova)", "md", "373" ], [ "Monaco", "mc", "377" ], [ "Mongolia (Монгол)", "mn", "976" ], [ "Montenegro (Crna Gora)", "me", "382" ], [ "Montserrat", "ms", "1664" ], [ "Morocco (‫المغرب‬‎)", "ma", "212", 0 ], [ "Mozambique (Moçambique)", "mz", "258" ], [ "Myanmar (Burma) (မြန်မာ)", "mm", "95" ], [ "Namibia (Namibië)", "na", "264" ], [ "Nauru", "nr", "674" ], [ "Nepal (नेपाल)", "np", "977" ], [ "Netherlands (Nederland)", "nl", "31" ], [ "New Caledonia (Nouvelle-Calédonie)", "nc", "687" ], [ "New Zealand", "nz", "64" ], [ "Nicaragua", "ni", "505" ], [ "Niger (Nijar)", "ne", "227" ], [ "Nigeria", "ng", "234" ], [ "Niue", "nu", "683" ], [ "Norfolk Island", "nf", "672" ], [ "North Korea (조선 민주주의 인민 공화국)", "kp", "850" ], [ "Northern Mariana Islands", "mp", "1670" ], [ "Norway (Norge)", "no", "47", 0 ], [ "Oman (‫عُمان‬‎)", "om", "968" ], [ "Pakistan (‫پاکستان‬‎)", "pk", "92" ], [ "Palau", "pw", "680" ], [ "Palestine (‫فلسطين‬‎)", "ps", "970" ], [ "Panama (Panamá)", "pa", "507" ], [ "Papua New Guinea", "pg", "675" ], [ "Paraguay", "py", "595" ], [ "Peru (Perú)", "pe", "51" ], [ "Philippines", "ph", "63" ], [ "Poland (Polska)", "pl", "48" ], [ "Portugal", "pt", "351" ], [ "Puerto Rico", "pr", "1", 3, [ "787", "939" ] ], [ "Qatar (‫قطر‬‎)", "qa", "974" ], [ "Réunion (La Réunion)", "re", "262", 0 ], [ "Romania (România)", "ro", "40" ], [ "Russia (Россия)", "ru", "7", 0 ], [ "Rwanda", "rw", "250" ], [ "Saint Barthélemy", "bl", "590", 1 ], [ "Saint Helena", "sh", "290" ], [ "Saint Kitts and Nevis", "kn", "1869" ], [ "Saint Lucia", "lc", "1758" ], [ "Saint Martin (Saint-Martin (partie française))", "mf", "590", 2 ], [ "Saint Pierre and Miquelon (Saint-Pierre-et-Miquelon)", "pm", "508" ], [ "Saint Vincent and the Grenadines", "vc", "1784" ], [ "Samoa", "ws", "685" ], [ "San Marino", "sm", "378" ], [ "São Tomé and Príncipe (São Tomé e Príncipe)", "st", "239" ], [ "Saudi Arabia (‫المملكة العربية السعودية‬‎)", "sa", "966" ], [ "Senegal (Sénégal)", "sn", "221" ], [ "Serbia (Србија)", "rs", "381" ], [ "Seychelles", "sc", "248" ], [ "Sierra Leone", "sl", "232" ], [ "Singapore", "sg", "65" ], [ "Sint Maarten", "sx", "1721" ], [ "Slovakia (Slovensko)", "sk", "421" ], [ "Slovenia (Slovenija)", "si", "386" ], [ "Solomon Islands", "sb", "677" ], [ "Somalia (Soomaaliya)", "so", "252" ], [ "South Africa", "za", "27" ], [ "South Korea (대한민국)", "kr", "82" ], [ "South Sudan (‫جنوب السودان‬‎)", "ss", "211" ], [ "Spain (España)", "es", "34" ], [ "Sri Lanka (ශ්‍රී ලංකාව)", "lk", "94" ], [ "Sudan (‫السودان‬‎)", "sd", "249" ], [ "Suriname", "sr", "597" ], [ "Svalbard and Jan Mayen", "sj", "47", 1 ], [ "Swaziland", "sz", "268" ], [ "Sweden (Sverige)", "se", "46" ], [ "Switzerland (Schweiz)", "ch", "41" ], [ "Syria (‫سوريا‬‎)", "sy", "963" ], [ "Taiwan (台灣)", "tw", "886" ], [ "Tajikistan", "tj", "992" ], [ "Tanzania", "tz", "255" ], [ "Thailand (ไทย)", "th", "66" ], [ "Timor-Leste", "tl", "670" ], [ "Togo", "tg", "228" ], [ "Tokelau", "tk", "690" ], [ "Tonga", "to", "676" ], [ "Trinidad and Tobago", "tt", "1868" ], [ "Tunisia (‫تونس‬‎)", "tn", "216" ], [ "Turkey (Türkiye)", "tr", "90" ], [ "Turkmenistan", "tm", "993" ], [ "Turks and Caicos Islands", "tc", "1649" ], [ "Tuvalu", "tv", "688" ], [ "U.S. Virgin Islands", "vi", "1340" ], [ "Uganda", "ug", "256" ], [ "Ukraine (Україна)", "ua", "380" ], [ "United Arab Emirates (‫الإمارات العربية المتحدة‬‎)", "ae", "971" ], [ "United Kingdom", "gb", "44", 0 ], [ "United States", "us", "1", 0 ], [ "Uruguay", "uy", "598" ], [ "Uzbekistan (Oʻzbekiston)", "uz", "998" ], [ "Vanuatu", "vu", "678" ], [ "Vatican City (Città del Vaticano)", "va", "39", 1 ], [ "Venezuela", "ve", "58" ], [ "Vietnam (Việt Nam)", "vn", "84" ], [ "Wallis and Futuna (Wallis-et-Futuna)", "wf", "681" ], [ "Western Sahara (‫الصحراء الغربية‬‎)", "eh", "212", 1 ], [ "Yemen (‫اليمن‬‎)", "ye", "967" ], [ "Zambia", "zm", "260" ], [ "Zimbabwe", "zw", "263" ], [ "Åland Islands", "ax", "358", 1 ] ]');

//Library of SMTP method based send email
require(CP_ROOT_PATH."/libraries/PHPMailer/class.phpmailer.php");
//require(CP_ROOT_PATH."/libraries/twilio/Services/Twilio.php");
require(CP_ROOT_PATH."/libraries/twilio/new/src/Twilio/autoload.php");
require(CP_ROOT_PATH."/libraries/sendgrid-php-new/vendor/autoload.php");
require(CP_ROOT_PATH."/libraries/fa_icon_list/fa_icon_list.php");

$account_sid = $general_setting_data['twilio_ac_sid'];
$auth_token = $general_setting_data['twilio_ac_token'];
//$sms_api = new Services_Twilio($account_sid, $auth_token);

use Twilio\Rest\Client;
if($account_sid && $auth_token) {
	try {
		$sms_api = new Client($account_sid, $auth_token);
	} catch(Exception $e) {
		$sms_error_msg = $e->getMessage();
		error_log("Error: Twilio ".$sms_error_msg);
	}
}
?>