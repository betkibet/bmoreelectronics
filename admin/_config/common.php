<?php
$admin_query=mysqli_query($db,"SELECT username, email FROM admin WHERE type='super_admin' ORDER BY id DESC");
$admin_detail=mysqli_fetch_assoc($admin_query);

$gs_query=mysqli_query($db,'SELECT * FROM general_setting ORDER BY id DESC');
$general_setting_data=mysqli_fetch_assoc($gs_query);

$custom_js_code = $general_setting_data['custom_js_code'];
$company_name = $general_setting_data['company_name'];
$company_address = $general_setting_data['company_address'];
$company_city = $general_setting_data['company_city'];
$company_state = $general_setting_data['company_state'];
$company_country = $general_setting_data['company_country'];
$company_zipcode = $general_setting_data['company_zipcode'];
$company_phone = $general_setting_data['company_phone'];
$other_settings = json_decode($general_setting_data['other_settings'],true);

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

$currency = @explode(",",$general_setting_data['currency']);
$currency_symbol = $currency[1];
if($general_setting_data['disp_currency']=="prefix")
	$amount_sign_with_prefix = $currency_symbol;
elseif($general_setting_data['disp_currency']=="postfix")
	$amount_sign_with_postfix = $currency_symbol;

$choosed_payment_option = (array)json_decode($general_setting_data['payment_option']);
$default_payment_option = ($general_setting_data['default_payment_option']?$general_setting_data['default_payment_option']:"bank");
$order_prefix = $general_setting_data['order_prefix'];
$display_terms_array = (array)json_decode($general_setting_data['display_terms']);
$choosed_sales_pack_array = (array)json_decode($general_setting_data['sales_pack']);

$page_list_limit = ($general_setting_data['page_list_limit']>5?$general_setting_data['page_list_limit']:5);
$blog_recent_posts = trim($general_setting_data['blog_recent_posts']);
$blog_categories = trim($general_setting_data['blog_categories']);
$blog_rm_words_limit = trim($general_setting_data['blog_rm_words_limit']);

define('ADMIN_PANEL_NAME',$general_setting_data['admin_panel_name']);
define('SITE_NAME',$general_setting_data['site_name']);
define('FROM_EMAIL',$general_setting_data['from_email']);
define('FROM_NAME',$general_setting_data['from_name']);

$logo_url = "";
$logo_fixed_url = "";
if($general_setting_data['logo']) {
	$logo_url = SITE_URL.'images/'.$general_setting_data['logo'];
}
if($general_setting_data['logo']) {
	$logo_fixed_url = SITE_URL.'images/'.$general_setting_data['logo_fixed'];
}
$site_phone = $general_setting_data['phone'];
$site_email = $general_setting_data['email'];
$website = $general_setting_data['website'];
$copyright = $general_setting_data['copyright'];
$theme_color_type = "green";//$general_setting_data['theme_option'];

$logo = '<img src="'.$logo_url.'" width="200">';
$logo_fixed = '<img src="'.$logo_fixed_url.'" width="200">';
$admin_logo = '<img src="'.SITE_URL.'images/'.$general_setting_data['admin_logo'].'" width="119">';
		
//START for footer social
$socials_link = '';
$fb_link = trim($general_setting_data['fb_link']);
$twitter_link = trim($general_setting_data['twitter_link']);
$linkedin_link = trim($general_setting_data['linkedin_link']);
if($fb_link) {
	$socials_link .= '<li class="fb"><a href="'.$fb_link.'"><i class="fab fa-facebook-square"></i></a></li>';
}
if($twitter_link) {
	$socials_link .= '<li class="twt"><a href="'.$twitter_link.'"><i class="fab fa-twitter-square"></i></a></li>';
}
if($linkedin_link) {
	$socials_link .= '<li class="lnkin"><a href="'.$linkedin_link.'"><i class="fab fa-linkedin"></i></a></li>';
} //END for footer social

$shipping_api = trim($general_setting_data['shipping_api']);
$shipment_generated_by_cust = trim($general_setting_data['shipment_generated_by_cust']);
$shipping_api_key = trim($general_setting_data['shipping_api_key']);
$shipping_api_secret = trim($general_setting_data['shipping_api_secret']);
$default_carrier_account = trim($general_setting_data['default_carrier_account']);
$carrier_account_id = trim($general_setting_data['carrier_account_id']);

$shipping_predefined_package = "";
if($carrier_account_id!="") {
	if($default_carrier_account == "usps") {
		$shipping_predefined_package = "SmallFlatRateBox";  //SmallFlatRateBox, MediumFlatRateBox, LargeFlatRateBox ...
	} elseif($default_carrier_account == "ups") {
		$shipping_predefined_package = "SmallExpressBox";  //SmallExpressBox, MediumExpressBox, LargeExpressBox ...
	} elseif($default_carrier_account == "fedex") {
		$shipping_predefined_package = "FedExSmallBox";  //FedExSmallBox, FedExMediumBox, FedExLargeBox, FedExExtraLargeBox ...
	} elseif($default_carrier_account == "dhl") {
		$shipping_predefined_package = "JumboBox";  //JumboBox, JuniorJumboBox ...
	}
}

$shipping_parcel_lg = trim($general_setting_data['shipping_parcel_length']);
$shipping_parcel_wd = trim($general_setting_data['shipping_parcel_width']);
$shipping_parcel_hg = trim($general_setting_data['shipping_parcel_height']);
$shipping_parcel_wg = trim($general_setting_data['shipping_parcel_weight']);

$shipping_parcel_length = ($shipping_parcel_lg?$shipping_parcel_lg:'20.2');
$shipping_parcel_width = ($shipping_parcel_wd?$shipping_parcel_wd:'10.9');
$shipping_parcel_height = ($shipping_parcel_hg?$shipping_parcel_hg:'5');
$shipping_parcel_weight = ($shipping_parcel_wg?$shipping_parcel_wg:'65.9');

$captcha_settings = (array)json_decode($general_setting_data['captcha_settings']);
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
	$contact_form_captcha = $captcha_settings['contact_form'];
	$write_review_form_captcha = $captcha_settings['write_review_form'];
	$bulk_order_form_captcha = $captcha_settings['bulk_order_form'];
	$affiliate_form_captcha = $captcha_settings['affiliate_form'];
	//$appt_form_captcha = $captcha_settings['appt_form'];
	$login_form_captcha = $captcha_settings['login_form'];
	$signup_form_captcha = $captcha_settings['signup_form'];
	//$contractor_form_captcha = $captcha_settings['contractor_form'];
	$order_track_form_captcha = $captcha_settings['order_track_form'];
	$newsletter_form_captcha = $captcha_settings['newsletter_form'];
	$missing_product_form_captcha = $captcha_settings['missing_product_form'];
	$imei_number_based_search_form_captcha = $captcha_settings['imei_number_based_search_form'];
}

$countries_list = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");

//Library of SMTP method based send email
require(CP_ROOT_PATH."/libraries/PHPMailer/class.phpmailer.php");
require(CP_ROOT_PATH."/libraries/twilio/Services/Twilio.php");
require(CP_ROOT_PATH."/libraries/sendgrid-php/vendor/autoload.php");
require(CP_ROOT_PATH."/libraries/fa_icon_list/fa_icon_list.php");

$account_sid = $general_setting_data['twilio_ac_sid'];
$auth_token = $general_setting_data['twilio_ac_token'];
$sms_api = new Services_Twilio($account_sid, $auth_token);
?>