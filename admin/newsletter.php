<?php 
$file_name="newsletter";

//Header section
require_once("include/header.php");

//Get num of newsletters submitted form for pagination
$user_p_query=mysqli_query($db,"SELECT COUNT(*) AS num_of_records FROM newsletters");
$user_p_data = mysqli_fetch_assoc($user_p_query);
$pages->set_total($user_p_data['num_of_records']);

//Fetch list of newsletters submitted form 
$query=mysqli_query($db,"SELECT * FROM newsletters ORDER BY id DESC ".$pages->get_limit()."");

$n_l_query=mysqli_query($db,"SELECT * FROM newsletters WHERE status='1' ORDER BY id ASC");

$template_data = get_template_data('newsletter_email_to_bulk_customer');
$general_setting_data = get_general_setting_data();
$admin_user_data = get_admin_user_data();

$patterns = array(
	'{$logo}',
	'{$admin_logo}',
	'{$admin_email}',
	'{$admin_username}',
	'{$admin_site_url}',
	'{$admin_panel_name}',
	'{$from_name}',
	'{$from_email}',
	'{$site_name}',
	'{$site_url}',
	'{$current_date_time}');

$replacements = array(
	$logo,
	$admin_logo,
	$admin_user_data['email'],
	$admin_user_data['username'],
	ADMIN_URL,
	$general_setting_data['admin_panel_name'],
	$general_setting_data['from_name'],
	$general_setting_data['from_email'],
	$general_setting_data['site_name'],
	SITE_URL,
	format_date(date('Y-m-d H:i')).' '.format_time(date('Y-m-d H:i')));

$email_subject = str_replace($patterns,$replacements,$template_data['subject']);
$email_body_text = str_replace($patterns,$replacements,$template_data['content']);

//Template file
require_once("views/newsletter.php");

//Footer section
require_once("include/footer.php"); ?>