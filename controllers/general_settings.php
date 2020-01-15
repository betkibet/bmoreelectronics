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
	
	if(count($post['payment_option'])=='1') {
		if($payment_option['bank']=="bank")
			$default_payment_option='bank';
		elseif($payment_option['paypal']=="paypal")
			$default_payment_option='paypal';
		elseif($payment_option['cheque']=="cheque")
			$default_payment_option='cheque';
	} else {
		$default_payment_option=$post['default_payment_option'];
	}
	
	$payment_option=json_encode($post['payment_option']);
	$sales_pack=json_encode($post['sales_pack']);
	$shipping_option=json_encode($post['shipping_option']);
	
	if($_FILES['logo']['name']) {
		$logo_ext = pathinfo($_FILES['logo']['name'],PATHINFO_EXTENSION);
		if($logo_ext=="png" || $logo_ext=="jpg" || $logo_ext=="jpeg" || $logo_ext=="gif") {
			$logo_tmp_name=$_FILES['logo']['tmp_name'];
			$logo_name='logo.'.$logo_ext;
			$logo_update=', logo="'.$logo_name.'"';
			move_uploaded_file($logo_tmp_name,'../../images/'.$logo_name);
		} else {
			$msg="Header image type must be png, jpg, jpeg, gif";
			$_SESSION['success_msg']=$msg;
			setRedirect(ADMIN_URL.'general_settings.php');
			exit();
		}
	}

	if($general_setting_data['id']!='') {
		$query=mysqli_query($db,"UPDATE general_setting SET admin_panel_name='".$admin_panel_name."', from_name='".$from_name."', from_email='".$from_email."' ".$logo_update.", slogan='".$slogan."', phone='".$phone."', email='".$email."', fb_link='".$fb_link."', twitter_link='".$twitter_link."', linkedin_link='".$linkedin_link."', copyright='".$copyright."', website='".$website."', company_name='".$company_name."', company_address='".$company_address."', company_city='".$company_city."', company_state='".$company_state."', company_country='".$company_country."', company_zipcode='".$company_zipcode."', company_phone='".$company_phone."',order_prefix='".$order_prefix."', currency='".$currency."', disp_currency='".$disp_currency."', payment_option='".$payment_option."', default_payment_option='".$default_payment_option."', sales_pack='".$sales_pack."', shipping_option='".$shipping_option."', terms='".$terms."', terms_status='".$terms_status."', display_terms='".$display_terms."', promocode_section='".$promocode_section."', top_seller_limit='".$top_seller_limit."', fb_page_url='".$fb_page_url."', social_login='".$social_login."', social_login_option='".$social_login_option."', google_client_id='".$google_client_id."', google_client_secret='".$google_client_secret."', fb_app_id='".$fb_app_id."', fb_app_secret='".$fb_app_secret."', mailer_type='".$mailer_type."', smtp_host='".$smtp_host."', smtp_port='".$smtp_port."', smtp_security='".$smtp_security."', smtp_username='".$smtp_username."', smtp_password='".$smtp_password."', verification='".$verification."', sms_sending_status='".$sms_sending_status."', twilio_ac_sid='".$twilio_ac_sid."', twilio_ac_token='".$twilio_ac_token."', twilio_long_code='".$twilio_long_code."', site_name='".$site_name."', missing_product_section='".$missing_product_section."', page_list_limit='".$page_list_limit."', blog_recent_posts='".$blog_recent_posts."', blog_categories='".$blog_categories."', blog_rm_words_limit='".$blog_rm_words_limit."', home_slider='".$home_slider."'");
	} else {
		$query=mysqli_query($db,'INSERT INTO general_setting(admin_panel_name, from_name ,from_email, logo, slogan, phone, email, fb_link, twitter_link, linkedin_link, copyright, website, company_name, company_address, company_city, company_state, company_country, company_zipcode, company_phone, order_prefix, currency, disp_currency, payment_option, default_payment_option, sales_pack, shipping_option, terms, terms_status, display_terms, promocode_section, top_seller_limit, fb_page_url  , social_login, social_login_option, google_client_id, google_client_secret, fb_app_id, fb_app_secret, mailer_type, smtp_host, smtp_port, smtp_security, smtp_username, smtp_password, verification, sms_sending_status, twilio_ac_sid, twilio_ac_token, twilio_long_code, site_name, missing_product_section, page_list_limit, blog_recent_posts, blog_categories, blog_rm_words_limit, home_slider) VALUES("'.$admin_panel_name.'","'.$from_name.'","'.$from_email.'", "'.$logo_name.'", "'.$slogan.'","'.$phone.'","'.$email.'","'.$fb_link.'","'.$twitter_link.'","'.$linkedin_link.'","'.$copyright.'","'.$website.'","'.$company_name.'","'.$company_address.'","'.$company_city.'","'.$company_state.'","'.$company_country.'","'.$company_zipcode.'","'.$company_phone.'","'.$order_prefix.'","'.$currency.'","'.$disp_currency.'","'.$payment_option.'","'.$default_payment_option.'","'.$sales_pack.'","'.$shipping_option.'","'.$terms.'","'.$terms_status.'","'.$display_terms.'", "'.$promocode_section.'", "'.$top_seller_limit.'", "'.$fb_page_url.'"   , "'.$social_login.'", "'.$social_login_option.'", "'.$google_client_id.'", "'.$google_client_secret.'", "'.$fb_app_id.'", "'.$fb_app_secret.'", "'.$mailer_type.'", "'.$smtp_host.'", "'.$smtp_port.'", "'.$smtp_security.'", "'.$smtp_username.'", "'.$smtp_password.'", "'.$verification.'", "'.$sms_sending_status.'", "'.$twilio_ac_sid.'", "'.$twilio_ac_token.'", "'.$twilio_long_code.'", "'.$site_name.'", "'.$missing_product_section.'", "'.$page_list_limit.'", "'.$blog_recent_posts.'", "'.$blog_categories.'", "'.$blog_rm_words_limit.'", "'.$home_slider.'")');
	}
	if($query=="1") {
		$msg="General settings has been successfully saved.";
		$_SESSION['success_msg']=$msg;
	} else {
		$msg='Sorry! something wrong updation failed.';
		$_SESSION['error_msg']=$msg;
	}
} elseif($post['r_logo_id']) {
	$get_logodata=mysqli_query($db,'SELECT logo FROM general_setting WHERE id="'.$post['r_logo_id'].'"');
	$get_logodata_row=mysqli_fetch_assoc($get_logodata);

	$del_logo=mysqli_query($db,'UPDATE general_setting SET logo="" WHERE id='.$post['r_logo_id']);
	if($get_logodata_row['logo']!="")
		unlink('../../images/'.$get_logodata_row['logo']);

	$msg="Logo successfully removed.";
	$_SESSION['success_msg']=$msg;
}
setRedirect(ADMIN_URL.'general_settings.php');
exit();
?>