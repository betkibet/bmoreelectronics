<?php 
require_once("../_config/config.php");
require_once("../include/functions.php");

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
	$page_list_limit = real_escape_string($post['page_list_limit']);
	$blog_recent_posts = real_escape_string($post['blog_recent_posts']);
	$blog_categories = real_escape_string($post['blog_categories']);
	$blog_rm_words_limit = real_escape_string($post['blog_rm_words_limit']);
	$home_slider = real_escape_string($post['home_slider']);
	$custom_js_code = real_escape_string($post['custom_js_code']);
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
	
	/*if(count($post['payment_option'])=='1') {
		if($payment_option['bank']=="bank")
			$default_payment_option='bank';
		elseif($payment_option['paypal']=="paypal")
			$default_payment_option='paypal';
		elseif($payment_option['cheque']=="cheque")
			$default_payment_option='cheque';
	} else {*/
		$default_payment_option=$post['default_payment_option'];
	//}
	
	$payment_option=json_encode($post['payment_option']);
	$sales_pack=json_encode($post['sales_pack']);
	$shipping_option=json_encode($post['shipping_option']);
	$captcha_settings=json_encode($post['captcha_settings']);
	$other_settings=json_encode($post['other_settings']);
	
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
		if($admin_logo_ext=="png" || $admin_logo_ext=="jpg" || $admin_logo_ext=="jpeg" || $admin_logo_ext=="gif") {
			$admin_logo_tmp_name=$_FILES['admin_logo']['tmp_name'];
			$admin_logo_name='admin_logo.'.$admin_logo_ext;
			$admin_logo_update=', admin_logo="'.$admin_logo_name.'"';
			move_uploaded_file($admin_logo_tmp_name,'../../images/'.$admin_logo_name);
		} else {
			$msg="Logo must be png, jpg, jpeg, gif";
			$_SESSION['success_msg']=$msg;
			setRedirect(ADMIN_URL.'general_settings.php');
			exit();
		}
	}
	
	if($_FILES['logo']['name']) {
		$logo_ext = pathinfo($_FILES['logo']['name'],PATHINFO_EXTENSION);
		if($logo_ext=="png" || $logo_ext=="jpg" || $logo_ext=="jpeg" || $logo_ext=="gif") {
			$logo_tmp_name=$_FILES['logo']['tmp_name'];
			$logo_name='logo.'.$logo_ext;
			$logo_update=', logo="'.$logo_name.'"';
			move_uploaded_file($logo_tmp_name,'../../images/'.$logo_name);
		} else {
			$msg="Logo must be png, jpg, jpeg, gif";
			$_SESSION['success_msg']=$msg;
			setRedirect(ADMIN_URL.'general_settings.php');
			exit();
		}
	}

	if($_FILES['logo_fixed']['name']) {
		$logo_fixed_ext = pathinfo($_FILES['logo_fixed']['name'],PATHINFO_EXTENSION);
		if($logo_fixed_ext=="png" || $logo_fixed_ext=="jpg" || $logo_fixed_ext=="jpeg" || $logo_fixed_ext=="gif") {
			$logo_fixed_tmp_name=$_FILES['logo_fixed']['tmp_name'];
			$logo_fixed_name='logo_fixed.'.$logo_fixed_ext;
			$logo_fixed_update=', logo_fixed="'.$logo_fixed_name.'"';
			move_uploaded_file($logo_fixed_tmp_name,'../../images/'.$logo_fixed_name);
		} else {
			$msg="Logo (fixed) must be png, jpg, jpeg, gif";
			$_SESSION['success_msg']=$msg;
			setRedirect(ADMIN_URL.'general_settings.php');
			exit();
		}
	}

	if($general_setting_data['id']!='') {
		$query=mysqli_query($db,"UPDATE general_setting SET admin_panel_name='".$admin_panel_name."', from_name='".$from_name."', from_email='".$from_email."' ".$logo_update." ".$admin_logo_update." ".$logo_fixed_update.", slogan='".$slogan."', phone='".$phone."', email='".$email."', fb_link='".$fb_link."', twitter_link='".$twitter_link."', linkedin_link='".$linkedin_link."', copyright='".$copyright."', website='".$website."', company_name='".$company_name."', company_address='".$company_address."', company_city='".$company_city."', company_state='".$company_state."', company_country='".$company_country."', company_zipcode='".$company_zipcode."', company_phone='".$company_phone."',order_prefix='".$order_prefix."', currency='".$currency."', disp_currency='".$disp_currency."', payment_option='".$payment_option."', default_payment_option='".$default_payment_option."', sales_pack='".$sales_pack."', shipping_option='".$shipping_option."', terms='".$terms."', terms_status='".$terms_status."', display_terms='".$display_terms."', promocode_section='".$promocode_section."', top_seller_limit='".$top_seller_limit."', fb_page_url='".$fb_page_url."', social_login='".$social_login."', social_login_option='".$social_login_option."', google_client_id='".$google_client_id."', google_client_secret='".$google_client_secret."', fb_app_id='".$fb_app_id."', fb_app_secret='".$fb_app_secret."', mailer_type='".$mailer_type."', smtp_host='".$smtp_host."', smtp_port='".$smtp_port."', smtp_security='".$smtp_security."', smtp_username='".$smtp_username."', smtp_password='".$smtp_password."', verification='".$verification."', sms_sending_status='".$sms_sending_status."', twilio_ac_sid='".$twilio_ac_sid."', twilio_ac_token='".$twilio_ac_token."', twilio_long_code='".$twilio_long_code."', site_name='".$site_name."', missing_product_section='".$missing_product_section."', page_list_limit='".$page_list_limit."', blog_recent_posts='".$blog_recent_posts."', blog_categories='".$blog_categories."', blog_rm_words_limit='".$blog_rm_words_limit."', home_slider='".$home_slider."', custom_js_code='".$custom_js_code."', email_api_username='".$email_api_username."', email_api_password='".$email_api_password."', shipping_api='".$shipping_api."', shipment_generated_by_cust='".$shipment_generated_by_cust."', shipping_api_key='".$shipping_api_key."', shipping_api_secret='".$shipping_api_secret."'   , shipping_parcel_length='".$shipping_parcel_length."', shipping_parcel_width='".$shipping_parcel_width."', shipping_parcel_height='".$shipping_parcel_height."', shipping_parcel_weight='".$shipping_parcel_weight."', email_api_key='".$email_api_key."', default_carrier_account='".$default_carrier_account."', carrier_account_id='".$carrier_account_id."', captcha_settings='".$captcha_settings."', other_settings='".$other_settings."'");
	} else {
		$query=mysqli_query($db,'INSERT INTO general_setting(admin_panel_name, from_name ,from_email, logo, logo_fixed, slogan, phone, email, fb_link, twitter_link, linkedin_link, copyright, website, company_name, company_address, company_city, company_state, company_country, company_zipcode, company_phone, order_prefix, currency, disp_currency, payment_option, default_payment_option, sales_pack, shipping_option, terms, terms_status, display_terms, promocode_section, top_seller_limit, fb_page_url  , social_login, social_login_option, google_client_id, google_client_secret, fb_app_id, fb_app_secret, mailer_type, smtp_host, smtp_port, smtp_security, smtp_username, smtp_password, verification, sms_sending_status, twilio_ac_sid, twilio_ac_token, twilio_long_code, site_name, missing_product_section, page_list_limit, blog_recent_posts, blog_categories, blog_rm_words_limit, home_slider, custom_js_code, email_api_username, email_api_password, shipping_api, shipment_generated_by_cust, shipping_api_key, shipping_api_secret, shipping_parcel_length, shipping_parcel_width, shipping_parcel_height, shipping_parcel_weight, email_api_key, default_carrier_account, carrier_account_id, captcha_settings, other_settings) VALUES("'.$admin_panel_name.'","'.$from_name.'","'.$from_email.'", "'.$logo_name.'", "'.$logo_fixed_name.'", "'.$slogan.'","'.$phone.'","'.$email.'","'.$fb_link.'","'.$twitter_link.'","'.$linkedin_link.'","'.$copyright.'","'.$website.'","'.$company_name.'","'.$company_address.'","'.$company_city.'","'.$company_state.'","'.$company_country.'","'.$company_zipcode.'","'.$company_phone.'","'.$order_prefix.'","'.$currency.'","'.$disp_currency.'","'.$payment_option.'","'.$default_payment_option.'","'.$sales_pack.'","'.$shipping_option.'","'.$terms.'","'.$terms_status.'","'.$display_terms.'", "'.$promocode_section.'", "'.$top_seller_limit.'", "'.$fb_page_url.'"   , "'.$social_login.'", "'.$social_login_option.'", "'.$google_client_id.'", "'.$google_client_secret.'", "'.$fb_app_id.'", "'.$fb_app_secret.'", "'.$mailer_type.'", "'.$smtp_host.'", "'.$smtp_port.'", "'.$smtp_security.'", "'.$smtp_username.'", "'.$smtp_password.'", "'.$verification.'", "'.$sms_sending_status.'", "'.$twilio_ac_sid.'", "'.$twilio_ac_token.'", "'.$twilio_long_code.'", "'.$site_name.'", "'.$missing_product_section.'", "'.$page_list_limit.'", "'.$blog_recent_posts.'", "'.$blog_categories.'", "'.$blog_rm_words_limit.'", "'.$home_slider.'", "'.$custom_js_code.'", "'.$email_api_username.'", "'.$email_api_password.'", "'.$shipping_api.'", "'.$shipment_generated_by_cust.'", "'.$shipping_api_key.'", "'.$shipping_api_secret.'", "'.$shipping_parcel_length.'", "'.$shipping_parcel_width.'", "'.$shipping_parcel_height.'", "'.$shipping_parcel_weight.'", "'.$email_api_key.'", "'.$default_carrier_account.'", "'.$carrier_account_id.'", "'.$captcha_settings.'", "'.$other_settings.'")');
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
} elseif($post['r_sitemap']) {
	unlink('../../sitemap.xml');

	$msg="Sitemap successfully removed.";
	$_SESSION['success_msg']=$msg;
}
setRedirect(ADMIN_URL.'general_settings.php');
exit();
?>