<?php 
require_once("../_config/config.php");
require_once("../include/functions.php");
require_once("common.php");
check_admin_staff_auth();

if(isset($post['general_setting'])) {
	$admin_panel_name=real_escape_string($post['admin_panel_name']);
	$from_name=real_escape_string($post['from_name']);
	$from_email=real_escape_string($post['from_email']);
	$slogan=real_escape_string($post['slogan']);
	$website=real_escape_string($post['website']);
	$phone=real_escape_string($post['phone']);
	$email=real_escape_string($post['email']);
	$fb_link=real_escape_string($post['fb_link']);
	$twitter_link=real_escape_string($post['twitter_link']);
	$linkedin_link=real_escape_string($post['linkedin_link']);
	$instagram_link=real_escape_string($post['instagram_link']);
	$copyright=real_escape_string($post['copyright']);
	$company_name=real_escape_string($post['company_name']);
	$company_address=real_escape_string($post['company_address']);
	$company_city=real_escape_string($post['company_city']);
	$company_state=real_escape_string($post['company_state']);
	$company_country=real_escape_string($post['company_country']);
	$company_zipcode=real_escape_string($post['company_zipcode']);
	$company_phone=real_escape_string($post['company_phone']);
	$order_prefix=$post['order_prefix'];
	$currency=$post['currency'];
	$disp_currency=$post['disp_currency'];
	$terms=real_escape_string($post['terms']);
	$terms_status=$post['terms_status'];
	$promocode_section=$post['promocode_section'];
	$top_seller_limit=$post['top_seller_limit'];
	$fb_page_url=real_escape_string($post['fb_page_url']);
	$display_terms=json_encode($post['display_terms']);
	$social_login=$post['social_login'];
	$social_login_option=$post['social_login_option'];
	$google_client_id=$post['google_client_id'];
	$google_client_secret=$post['google_client_secret'];
	$fb_app_id=$post['fb_app_id'];
	$fb_app_secret=$post['fb_app_secret'];
	$mailer_type=$post['mailer_type'];
	$smtp_host=real_escape_string($post['smtp_host']);
	$smtp_port=real_escape_string($post['smtp_port']);
	$smtp_security=$post['smtp_security'];
	$smtp_username=real_escape_string($post['smtp_username']);
	$smtp_password=real_escape_string($post['smtp_password']);
	$verification = $post['verification'];
	$site_name = real_escape_string($post['site_name']);
	$missing_product_section = $post['missing_product_section'];
	$sms_sending_status = real_escape_string($post['sms_sending_status']);
	$twilio_ac_sid = real_escape_string($post['twilio_ac_sid']);
	$twilio_ac_token = real_escape_string($post['twilio_ac_token']);
	$twilio_long_code = real_escape_string($post['twilio_long_code']);
	$twilio_long_code = preg_replace("/[^\d]/", "", $twilio_long_code);
	if($twilio_ac_sid == "" || $twilio_ac_token == "" || $twilio_long_code == "") {
		$sms_sending_status = 0;
	}
	$page_list_limit = real_escape_string($post['page_list_limit']);
	$blog_recent_posts = real_escape_string($post['blog_recent_posts']);
	$blog_categories = real_escape_string($post['blog_categories']);
	$blog_rm_words_limit = real_escape_string($post['blog_rm_words_limit']);
	$home_slider = real_escape_string($post['home_slider']);
	$custom_js_code = real_escape_string($post['custom_js_code']);
	$after_body_js_code = real_escape_string($post['after_body_js_code']);
	$before_body_js_code = real_escape_string($post['before_body_js_code']);
	$email_api_username = real_escape_string($post['email_api_username']);
	$email_api_password = real_escape_string($post['email_api_password']);
	$shipping_api = $post['shipping_api'];
	$shipment_generated_by_cust = ($post['shipment_generated_by_cust']?'1':'0');
	$shipping_api_key = real_escape_string($post['shipping_api_key']);
	$shipping_api_secret = real_escape_string($post['shipping_api_secret']);
	$shipping_parcel_length = $post['shipping_parcel_length'];
	$shipping_parcel_width = $post['shipping_parcel_width'];
	$shipping_parcel_height = $post['shipping_parcel_height'];
	$shipping_parcel_weight = $post['shipping_parcel_weight'];
	$default_carrier_account = $post['default_carrier_account'];
	$carrier_account_id = $post['carrier_account_id'];
	$email_api_key = $post['email_api_key'];
	$company_email = $post['company_email'];
	$is_ip_restriction = $post['is_ip_restriction'];
	$allowed_ip = $post['allowed_ip'];
	$allow_sms_verify_of_admin_staff_login = $post['allow_sms_verify_of_admin_staff_login'];
	$allow_offer_popup = $post['allow_offer_popup'];
	$offer_popup_title = $post['offer_popup_title'];
	$offer_popup_content = $post['offer_popup_content'];
	$is_space_between_currency_symbol = $post['is_space_between_currency_symbol'];
	$thousand_separator = real_escape_string($post['thousand_separator']);
	$decimal_separator = real_escape_string($post['decimal_separator']);
	$decimal_number = $post['decimal_number'];
	$time_format = $post['time_format'];
	$date_format = $post['date_format'];
	$timezone = real_escape_string($post['timezone']);
	$sales_confirmation_pdf_content=real_escape_string($post['sales_confirmation_pdf_content']);
	
	if(count($post['payment_option'])=='1') {
		if($payment_option['bank']=="bank")
			$default_payment_option='bank';
		elseif($payment_option['paypal']=="paypal")
			$default_payment_option='paypal';
		elseif($payment_option['cheque']=="cheque")
			$default_payment_option='cheque';
		elseif($payment_option['venmo']=="venmo")
			$default_payment_option='venmo';
		elseif($payment_option['zelle']=="zelle")
			$default_payment_option='zelle';
		elseif($payment_option['amazon_gcard']=="amazon_gcard")
			$default_payment_option='amazon_gcard';
		elseif($payment_option['cash']=="cash")
			$default_payment_option='cash';
		elseif($payment_option['cash_app']=="cash_app")
			$default_payment_option='cash_app';
		elseif($payment_option['apple_pay']=="apple_pay")
			$default_payment_option='apple_pay';
		elseif($payment_option['google_pay']=="google_pay")
			$default_payment_option='google_pay';
		elseif($payment_option['coinbase']=="coinbase")
			$default_payment_option='coinbase';
		elseif($payment_option['facebook_pay']=="facebook_pay")
			$default_payment_option='facebook_pay';
	} else {
		$default_payment_option=$post['default_payment_option'];
	}

	$shipping_option_image_arr = array('post_me_a_prepaid_label_image','use_my_own_courier_image','we_come_for_you_image','store_image','starbucks_image','print_a_prepaid_label_image');
	foreach($shipping_option_image_arr as $soi_k=>$soi_v) {
		if($post['shipping_option'][$soi_v.'_rm'] == '1') {
			unlink('../../images/'.$post['shipping_option'][$soi_v.'_old']);
		} else {
			if($_FILES['shipping_option']['name'][$soi_v]) {
				$shipping_option_ext = pathinfo($_FILES['shipping_option']['name'][$soi_v],PATHINFO_EXTENSION);
				if($shipping_option_ext=="png" || $shipping_option_ext=="jpg" || $shipping_option_ext=="jpeg" || $shipping_option_ext=="gif" || $shipping_option_ext=="svg") {
					$shipping_option_tmp_name = $_FILES['shipping_option']['tmp_name'][$soi_v];
					$shipping_option_name = date("His").'_'.$soi_v.'.'.$shipping_option_ext;
					move_uploaded_file($shipping_option_tmp_name,'../../images/'.$shipping_option_name);
					$post['shipping_option'][$soi_v] = $shipping_option_name;
				} else {
					$msg="Logo must be png, jpg, jpeg, gif, svg";
					$_SESSION['success_msg']=$msg;
					setRedirect(ADMIN_URL.'general_settings.php');
					exit();
				}
			} else {
				$post['shipping_option'][$soi_v] = $post['shipping_option'][$soi_v.'_old'];
			}
		}
	}
	
	$payment_option=json_encode($post['payment_option']);
	$sales_pack=json_encode($post['sales_pack']);
	$shipping_option=json_encode($post['shipping_option']);
	$captcha_settings=json_encode($post['captcha_settings']);
	$payment_instruction=real_escape_string(json_encode($post['payment_instruction']));
	$success_page_content='';//real_escape_string(json_encode($post['success_page_content']));
	
	if($default_carrier_account == "usps") {
		$post['other_settings']['shipping_api_service'] = $post['shipping_api_usps_service'];
		$post['other_settings']['shipping_api_package'] = $post['shipping_api_usps_package'];
	}
	if($default_carrier_account == "ups") {
		$post['other_settings']['shipping_api_service'] = $post['shipping_api_ups_service'];
		$post['other_settings']['shipping_api_package'] = $post['shipping_api_ups_package'];
	}
	if($default_carrier_account == "fedex") {
		$post['other_settings']['shipping_api_service'] = $post['shipping_api_fedex_service'];
		$post['other_settings']['shipping_api_package'] = $post['shipping_api_fedex_package'];
	}
	if($default_carrier_account == "dhl") {
		$post['other_settings']['shipping_api_service'] = $post['shipping_api_dhl_service'];
		$post['other_settings']['shipping_api_package'] = $post['shipping_api_dhl_package'];
	}
	
	$other_settings = real_escape_string(json_encode($post['other_settings']));
	$theme_settings = json_encode($post['theme_settings']);

$theme_settings_arr = $post['theme_settings'];
//echo '<pre>';
//print_r($theme_settings_arr);
//exit;

$main_background_color = $theme_settings_arr['main_background_color'];
$main_background_text_color = $theme_settings_arr['main_background_text_color'];
$primary_color = $theme_settings_arr['primary_color'];
$primary_text_color = $theme_settings_arr['primary_text_color'];
$secondary_color = $theme_settings_arr['secondary_color'];
$secondary_text_color = $theme_settings_arr['secondary_text_color'];
$tertiary_color = $theme_settings_arr['tertiary_color'];
$tertiary_text_color = $theme_settings_arr['tertiary_text_color'];
$primary_hover_color = $theme_settings_arr['primary_hover_color'];
$primary_text_hover_color = $theme_settings_arr['primary_text_hover_color'];
$secondary_hover_color = $theme_settings_arr['secondary_hover_color'];
$secondary_text_hover_color = $theme_settings_arr['secondary_text_hover_color'];
$tertiary_hover_color = $theme_settings_arr['tertiary_hover_color'];
$tertiary_text_hover_color = $theme_settings_arr['tertiary_text_hover_color'];
$header_calltoaction_button_color = $theme_settings_arr['header_calltoaction_button_color'];
$header_calltoaction_button_text_color = $theme_settings_arr['header_calltoaction_button_text_color'];
$header_calltoaction_button_hover_color = $theme_settings_arr['header_calltoaction_button_hover_color'];
$header_calltoaction_button_text_hover_color = $theme_settings_arr['header_calltoaction_button_text_hover_color'];
$menu_color = $theme_settings_arr['menu_color'];
$menu_hover_color = $theme_settings_arr['menu_hover_color'];
$sub_menu_color = $theme_settings_arr['sub_menu_color'];
$sub_menu_hover_color = $theme_settings_arr['sub_menu_hover_color'];
$sub_menu_background_color = $theme_settings_arr['sub_menu_background_color'];
$footer_background_color = $theme_settings_arr['footer_background_color'];
$footer_text_color = $theme_settings_arr['footer_text_color'];
$footer_text_hover_color = $theme_settings_arr['footer_text_hover_color'];
$social_icons_background_color = $theme_settings_arr['social_icons_background_color'];
$social_icons_background_hover_color = $theme_settings_arr['social_icons_background_hover_color'];
$social_icons_text_color = $theme_settings_arr['social_icons_text_color'];
$heading_title_color = $theme_settings_arr['heading_title_color'];

$custom_css_params = '--sticky_header_background_color : #FFFFFF;
';

$constant_txt = ':root {
'.$custom_css_params.'
--main_background_color : #'.$main_background_color.';
--main_background_text_color : #'.$main_background_text_color.';
--primary_color : #'.$primary_color.';
--primary_text_color : #'.$primary_text_color.';
--secondary_color : #'.$secondary_color.';
--secondary_text_color : #'.$secondary_text_color.';
--tertiary_color : #'.$tertiary_color.';
--tertiary_text_color : #'.$tertiary_text_color.';
--primary_hover_color : #'.$primary_hover_color.';
--primary_text_hover_color : #'.$primary_text_hover_color.';
--secondary_hover_color : #'.$secondary_hover_color.';
--secondary_text_hover_color : #'.$secondary_text_hover_color.';
--tertiary_hover_color : #'.$tertiary_hover_color.';
--tertiary_text_hover_color : #'.$tertiary_text_hover_color.';
--header_calltoaction_button_color : #'.$header_calltoaction_button_color.';
--header_calltoaction_button_text_color : #'.$header_calltoaction_button_text_color.';
--header_calltoaction_button_hover_color : #'.$header_calltoaction_button_hover_color.';
--header_calltoaction_button_text_hover_color : #'.$header_calltoaction_button_text_hover_color.';
--menu_color : #'.$menu_color.';
--menu_hover_color : #'.$menu_hover_color.';
--sub_menu_color : #'.$sub_menu_color.';
--sub_menu_hover_color : #'.$sub_menu_hover_color.';
--sub_menu_background_color : #'.$sub_menu_background_color.';
--footer_background_color : #'.$footer_background_color.';
--footer_text_color : #'.$footer_text_color.';
--social_icons_background_color : #'.$social_icons_background_color.';
--social_icons_background_hover_color : #'.$social_icons_background_hover_color.';
--social_icons_text_color : #'.$social_icons_text_color.';
--heading_title_color : #'.$heading_title_color.';
}';
if($constant_txt!="") {
	$write_constant_txt_file = fopen("../../css/constant.css", "w") or die("Unable to open constant.css file! Please contact with developer team");
	fwrite($write_constant_txt_file, $constant_txt);
	fclose($write_constant_txt_file);
}

	if($_FILES['xml_file']['name']) {
		$xml_file_ext = pathinfo($_FILES['xml_file']['name'],PATHINFO_EXTENSION);
		if($xml_file_ext=="xml") {
			$xml_file_tmp_name=$_FILES['xml_file']['tmp_name'];
			$sitemap_name='sitemap.'.$xml_file_ext;
			move_uploaded_file($xml_file_tmp_name,'../../'.$sitemap_name);
		} else {
			$msg="File type must be xml";
			$_SESSION['success_msg']=$msg;
			setRedirect(ADMIN_URL.'general_settings.php');
			exit();
		}
	}
	
	if($_FILES['admin_logo']['name']) {
		$admin_logo_ext = pathinfo($_FILES['admin_logo']['name'],PATHINFO_EXTENSION);
		if($admin_logo_ext=="png" || $admin_logo_ext=="jpg" || $admin_logo_ext=="jpeg" || $admin_logo_ext=="gif" || $admin_logo_ext=="svg") {
			$admin_logo_tmp_name=$_FILES['admin_logo']['tmp_name'];
			$admin_logo_name='admin_logo.'.$admin_logo_ext;
			$admin_logo_update=', admin_logo="'.$admin_logo_name.'"';
			move_uploaded_file($admin_logo_tmp_name,'../../images/'.$admin_logo_name);
		} else {
			$msg="Logo must be png, jpg, jpeg, gif, svg";
			$_SESSION['success_msg']=$msg;
			setRedirect(ADMIN_URL.'general_settings.php');
			exit();
		}
	}
	
	if($_FILES['logo']['name']) {
		$logo_ext = pathinfo($_FILES['logo']['name'],PATHINFO_EXTENSION);
		if($logo_ext=="png" || $logo_ext=="jpg" || $logo_ext=="jpeg" || $logo_ext=="gif" || $logo_ext=="svg") {
			$logo_tmp_name=$_FILES['logo']['tmp_name'];
			$logo_name='logo.'.$logo_ext;
			$logo_update=', logo="'.$logo_name.'"';
			move_uploaded_file($logo_tmp_name,'../../images/'.$logo_name);
		} else {
			$msg="Logo must be png, jpg, jpeg, gif, svg";
			$_SESSION['success_msg']=$msg;
			setRedirect(ADMIN_URL.'general_settings.php');
			exit();
		}
	}

	if($_FILES['logo_fixed']['name']) {
		$logo_fixed_ext = pathinfo($_FILES['logo_fixed']['name'],PATHINFO_EXTENSION);
		if($logo_fixed_ext=="png" || $logo_fixed_ext=="jpg" || $logo_fixed_ext=="jpeg" || $logo_fixed_ext=="gif" || $logo_fixed_ext=="svg") {
			$logo_fixed_tmp_name=$_FILES['logo_fixed']['tmp_name'];
			$logo_fixed_name='logo_fixed.'.$logo_fixed_ext;
			$logo_fixed_update=', logo_fixed="'.$logo_fixed_name.'"';
			move_uploaded_file($logo_fixed_tmp_name,'../../images/'.$logo_fixed_name);
		} else {
			$msg="Logo (fixed) must be png, jpg, jpeg, gif, svg";
			$_SESSION['success_msg']=$msg;
			setRedirect(ADMIN_URL.'general_settings.php');
			exit();
		}
	}
	
	if($_FILES['footer_logo']['name']) {
		$footer_logo_ext = pathinfo($_FILES['footer_logo']['name'],PATHINFO_EXTENSION);
		if($footer_logo_ext=="png" || $footer_logo_ext=="jpg" || $footer_logo_ext=="jpeg" || $footer_logo_ext=="gif" || $footer_logo_ext=="svg") {
			$footer_logo_tmp_name=$_FILES['footer_logo']['tmp_name'];
			$footer_logo_name='footer_logo.'.$footer_logo_ext;
			$footer_logo_update=', footer_logo="'.$footer_logo_name.'"';
			move_uploaded_file($footer_logo_tmp_name,'../../images/'.$footer_logo_name);
		} else {
			$msg="Footer logo must be png, jpg, jpeg, gif, svg";
			$_SESSION['success_msg']=$msg;
			setRedirect(ADMIN_URL.'general_settings.php');
			exit();
		}
	}
	
	if($_FILES['logo_email']['name']) {
		$logo_email_ext = pathinfo($_FILES['logo_email']['name'],PATHINFO_EXTENSION);
		if($logo_email_ext=="png" || $logo_email_ext=="jpg" || $logo_email_ext=="jpeg" || $logo_email_ext=="gif") {
			$logo_email_tmp_name=$_FILES['logo_email']['tmp_name'];
			$logo_email_name='logo_email.'.$logo_email_ext;
			$logo_email_update=', logo_email="'.$logo_email_name.'"';
			move_uploaded_file($logo_email_tmp_name,'../../images/'.$logo_email_name);
		} else {
			$msg="Logo (email) must be png, jpg, jpeg, gif";
			$_SESSION['success_msg']=$msg;
			setRedirect(ADMIN_URL.'general_settings.php');
			exit();
		}
	}

	if($_FILES['favicon_icon']['name']) {
		$favicon_icon_ext = pathinfo($_FILES['favicon_icon']['name'],PATHINFO_EXTENSION);
		if($favicon_icon_ext=="ico") {
			$favicon_icon_tmp_name=$_FILES['favicon_icon']['tmp_name'];
			$favicon_icon_name='favicon.ico';
			$favicon_icon_update=', favicon_icon="'.$favicon_icon_name.'"';
			move_uploaded_file($favicon_icon_tmp_name,'../../images/'.$favicon_icon_name);
		} else {
			$msg="Favicon type must be ico";
			$_SESSION['error_msg']=$msg;
			setRedirect(ADMIN_URL."general_settings.php");
			exit();
		}
	}
	
	if($general_setting_data['id']!='') {
		$query=mysqli_query($db,"UPDATE general_setting SET admin_panel_name='".$admin_panel_name."', from_name='".$from_name."', from_email='".$from_email."' ".$logo_update." ".$favicon_icon_update." ".$admin_logo_update." ".$logo_fixed_update." ".$logo_email_update." ".$footer_logo_update.", slogan='".$slogan."', phone='".$phone."', email='".$email."', fb_link='".$fb_link."', twitter_link='".$twitter_link."', linkedin_link='".$linkedin_link."', instagram_link='".$instagram_link."', copyright='".$copyright."', website='".$website."', company_name='".$company_name."', company_address='".$company_address."', company_city='".$company_city."', company_state='".$company_state."', company_country='".$company_country."', company_zipcode='".$company_zipcode."', company_phone='".$company_phone."',order_prefix='".$order_prefix."', currency='".$currency."', disp_currency='".$disp_currency."', payment_option='".$payment_option."', payment_instruction='".$payment_instruction."', default_payment_option='".$default_payment_option."', sales_pack='".$sales_pack."', shipping_option='".$shipping_option."', terms='".$terms."', terms_status='".$terms_status."', display_terms='".$display_terms."', promocode_section='".$promocode_section."', top_seller_limit='".$top_seller_limit."', fb_page_url='".$fb_page_url."', social_login='".$social_login."', social_login_option='".$social_login_option."', google_client_id='".$google_client_id."', google_client_secret='".$google_client_secret."', fb_app_id='".$fb_app_id."', fb_app_secret='".$fb_app_secret."', mailer_type='".$mailer_type."', smtp_host='".$smtp_host."', smtp_port='".$smtp_port."', smtp_security='".$smtp_security."', smtp_username='".$smtp_username."', smtp_password='".$smtp_password."', verification='".$verification."', sms_sending_status='".$sms_sending_status."', twilio_ac_sid='".$twilio_ac_sid."', twilio_ac_token='".$twilio_ac_token."', twilio_long_code='".$twilio_long_code."', site_name='".$site_name."', missing_product_section='".$missing_product_section."', page_list_limit='".$page_list_limit."', blog_recent_posts='".$blog_recent_posts."', blog_categories='".$blog_categories."', blog_rm_words_limit='".$blog_rm_words_limit."', home_slider='".$home_slider."', custom_js_code='".$custom_js_code."', after_body_js_code='".$after_body_js_code."', before_body_js_code='".$before_body_js_code."', email_api_username='".$email_api_username."', email_api_password='".$email_api_password."', shipping_api='".$shipping_api."', shipment_generated_by_cust='".$shipment_generated_by_cust."', shipping_api_key='".$shipping_api_key."', shipping_api_secret='".$shipping_api_secret."'   , shipping_parcel_length='".$shipping_parcel_length."', shipping_parcel_width='".$shipping_parcel_width."', shipping_parcel_height='".$shipping_parcel_height."', shipping_parcel_weight='".$shipping_parcel_weight."', email_api_key='".$email_api_key."', company_email='".$company_email."', default_carrier_account='".$default_carrier_account."', carrier_account_id='".$carrier_account_id."', captcha_settings='".$captcha_settings."', other_settings='".$other_settings."', theme_settings='".$theme_settings."', time_format='".$time_format."', date_format='".$date_format."', timezone='".$timezone."', allow_offer_popup='".$allow_offer_popup."', offer_popup_title='".$offer_popup_title."', offer_popup_content='".$offer_popup_content."', is_space_between_currency_symbol='".$is_space_between_currency_symbol."', thousand_separator='".$thousand_separator."', decimal_separator='".$decimal_separator."', decimal_number='".$decimal_number."', is_ip_restriction='".$is_ip_restriction."', allowed_ip='".$allowed_ip."', allow_sms_verify_of_admin_staff_login='".$allow_sms_verify_of_admin_staff_login."', sales_confirmation_pdf_content='".$sales_confirmation_pdf_content."', success_page_content='".$success_page_content."'");
	} else {
		$msg='Sorry! something wrong in database so please insert one dummy row in mysql general_setting table because we have only update settings.';
		$_SESSION['error_msg']=$msg;
	}
	if($query=="1") {
		$msg="General settings has been successfully saved.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong updation failed.';
		$_SESSION['error_msg']=$msg;
	}
} elseif($post['r_logo_id']) {
	$q=mysqli_query($db,'SELECT logo FROM general_setting WHERE id="'.$post['r_logo_id'].'"');
	$data=mysqli_fetch_assoc($q);

	$del_logo=mysqli_query($db,'UPDATE general_setting SET logo="" WHERE id='.$post['r_logo_id']);
	if($data['logo']!="")
		unlink('../../images/'.$data['logo']);

	$msg="Logo successfully removed.";
	$_SESSION['success_msg']=$msg;
} elseif($post['r_a_logo_id']) {
	$q = mysqli_query($db,'SELECT admin_logo FROM general_setting WHERE id="'.$post['r_a_logo_id'].'"');
	$data = mysqli_fetch_assoc($q);

	$del_logo = mysqli_query($db,'UPDATE general_setting SET admin_logo="" WHERE id='.$post['r_a_logo_id']);
	if($data['admin_logo']!="")
		unlink('../../images/'.$data['admin_logo']);

	$msg="Logo successfully removed.";
	$_SESSION['success_msg']=$msg;
} elseif($post['r_logo_fixed_id']) {
	$q = mysqli_query($db,'SELECT logo_fixed FROM general_setting WHERE id="'.$post['r_logo_fixed_id'].'"');
	$data = mysqli_fetch_assoc($q);

	$del_logo = mysqli_query($db,'UPDATE general_setting SET logo_fixed="" WHERE id='.$post['r_logo_fixed_id']);
	if($data['logo_fixed']!="")
		unlink('../../images/'.$data['logo_fixed']);

	$msg="Logo successfully removed.";
	$_SESSION['success_msg']=$msg;
} elseif($post['r_footer_logo_id']) {
	$q = mysqli_query($db,'SELECT footer_logo FROM general_setting WHERE id="'.$post['r_footer_logo_id'].'"');
	$data = mysqli_fetch_assoc($q);

	$del_logo = mysqli_query($db,'UPDATE general_setting SET footer_logo="" WHERE id='.$post['r_footer_logo_id']);
	if($data['footer_logo']!="")
		unlink('../../images/'.$data['footer_logo']);

	$msg="Footer logo successfully removed.";
	$_SESSION['success_msg']=$msg;
} elseif($post['r_logo_email_id']) {
	$q = mysqli_query($db,'SELECT logo_email FROM general_setting WHERE id="'.$post['r_logo_email_id'].'"');
	$data = mysqli_fetch_assoc($q);

	$del_logo = mysqli_query($db,'UPDATE general_setting SET logo_email="" WHERE id='.$post['r_logo_email_id']);
	if($data['logo_email']!="")
		unlink('../../images/'.$data['logo_email']);

	$msg="Logo successfully removed.";
	$_SESSION['success_msg']=$msg;
} elseif($post['r_favicon_id']) {
	$q = mysqli_query($db,'SELECT favicon_icon FROM general_setting WHERE id="'.$post['r_favicon_id'].'"');
	$data = mysqli_fetch_assoc($q);

	mysqli_query($db,'UPDATE general_setting SET favicon_icon="" WHERE id='.$post['r_favicon_id']);
	if($data['favicon_icon']!="")
		unlink('../../images/'.$data['favicon_icon']);

	$msg="Favicon successfully removed.";
	$_SESSION['success_msg']=$msg;
} elseif($post['r_sitemap']) {
	unlink('../../sitemap.xml');

	$msg="Sitemap successfully removed.";
	$_SESSION['success_msg']=$msg;
}
setRedirect(ADMIN_URL.'general_settings.php');
exit();
?>