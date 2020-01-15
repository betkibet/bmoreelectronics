<?php
//Create slug for sef url
function createSlug($str)
{
    if($str !== mb_convert_encoding( mb_convert_encoding($str, 'UTF-32', 'UTF-8'), 'UTF-8', 'UTF-32') )
        $str = mb_convert_encoding($str, 'UTF-8', mb_detect_encoding($str));
    $str = htmlentities($str, ENT_NOQUOTES, 'UTF-8');
    $str = preg_replace('`&([a-z]{1,2})(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig);`i', '\\1', $str);
    $str = html_entity_decode($str, ENT_NOQUOTES, 'UTF-8');
    $str = preg_replace(array('`[^a-z0-9]`i','`[-]+`'), '-', $str);
    $str = strtolower( trim($str, '-') );
    return $str;
}

function generateFormToken($form) {
	$token = md5(uniqid(microtime(),true)).md5(rand(00000,11111));

	$csrf_token_array = $_SESSION[$form.'_csrf_token'];
	if(empty($csrf_token_array))
		$csrf_token_array = array();

	array_push($csrf_token_array,$token);
	$_SESSION[$form.'_csrf_token'] = $csrf_token_array;
	return $token;
}

function verifyFormToken($form) {
	$csrf_token_array = $_SESSION[$form.'_csrf_token'];

	if(empty($csrf_token_array)) { 
		return false;
    }

	if(!isset($_POST['csrf_token'])) {
		return false;
    }

	if(!in_array($_POST['csrf_token'],$csrf_token_array)) {
		return false;
    }
	
	if(($key = array_search($_POST['csrf_token'], $csrf_token_array)) !== false) {
		unset($csrf_token_array[$key]);
	}
	$_SESSION[$form.'_csrf_token'] = $csrf_token_array;
	
	return true;
}

function writeHackLog($form) {
	$host = gethostbyaddr(USER_IP);
	$date = date("d M Y");

	$logging = 'There was a hacking attempt on your '.$form.' form, Date of Attack: '.$date.', IP-Adress: '.USER_IP.', Host of Attacker: '.$host;
	if($handle = fopen(CP_ROOT_PATH.'/hacklog.log', 'a')) {
		fputs($handle, $logging);
		fclose($handle);
	}
}

//Parse sef url/path
function parse_path() {
  $path = array();
  if(isset($_SERVER['REQUEST_URI'])) {
    $request_path = explode('?', $_SERVER['REQUEST_URI']);

    $path['base'] = rtrim(dirname($_SERVER['SCRIPT_NAME']), '\/');
    $path['call_utf8'] = substr(urldecode($request_path[0]), strlen($path['base']) + 1);
    $path['call'] = utf8_decode($path['call_utf8']);
    if ($path['call'] == basename($_SERVER['PHP_SELF'])) {
      $path['call'] = '';
    }
    $path['call_parts'] = explode('/', $path['call']);

    $path['query_utf8'] = urldecode($request_path[1]);
    $path['query'] = utf8_decode(urldecode($request_path[1]));
    $vars = explode('&', $path['query']);
    foreach($vars as $var) {
      $t = explode('=', $var);
      $path['query_vars'][$t[0]] = $t[1];
    }
  }
return $path;
}

//Get email template data based on template type
function get_template_data($template_type) {
	global $db;
	$templatedata_query=mysqli_query($db,'SELECT * FROM mail_templates WHERE type="'.$template_type.'"');
	return mysqli_fetch_assoc($templatedata_query);
}

//Get general settings
function get_general_setting_data() {
	global $db;
	$gs_query=mysqli_query($db,'SELECT * FROM general_setting ORDER BY id DESC');
	return mysqli_fetch_assoc($gs_query);
}

//Get admin user data
function get_admin_user_data() {
	global $db;
	$query=mysqli_query($db,"SELECT * FROM admin WHERE type='super_admin' ORDER BY id DESC");
	return mysqli_fetch_assoc($query);
}

//Get user data based on userID
function get_user_data($user_id) {
	global $db;
	$u_query=mysqli_query($db,"SELECT u.* FROM users AS u WHERE u.id='".$user_id."'");
	return mysqli_fetch_assoc($u_query);
}

//Get order data based on orderID
function get_order_data($order_id, $email = "") {
	global $db;
	
	$mysql_q = "";
	if($email!="") {
		$mysql_q .= " OR u.email='".$email."'";
	}
	
	$u_query=mysqli_query($db,"SELECT u.*, o.*, o.date AS order_date, o.status AS order_status FROM users AS u RIGHT JOIN orders AS o ON o.user_id=u.id WHERE o.order_id='".$order_id."'".$mysql_q."");
	return mysqli_fetch_assoc($u_query);
}

//Get order price based on orderID
function get_order_price($order_id) {
	global $db;
	$query=mysqli_query($db,"SELECT SUM(price) AS sum_of_orders FROM order_items WHERE order_id='".$order_id."'");
	$data=mysqli_fetch_assoc($query);
	return $data['sum_of_orders'];
}

//Get order item list data based on orderID
function get_order_item_list($order_id) {
	global $db;
	$response_array = array();
	$query=mysqli_query($db,"SELECT oi.*, o.`payment_method`, o.`date`, o.`approved_date`, o.`expire_date`, o.`status`, o.`sales_pack`, o.`paypal_address`, o.`chk_name`, o.`chk_street_address`, o.`chk_street_address_2`, o.`chk_city`, o.`chk_state`, o.`chk_zip_code`, o.`act_name`, o.`act_number`, o.`act_short_code`, o.`note`, d.title AS device_title, m.title AS model_title, m.model_img FROM order_items AS oi LEFT JOIN orders AS o ON o.order_id=oi.order_id LEFT JOIN devices AS d ON d.id=oi.device_id LEFT JOIN mobile AS m ON m.id=oi.model_id WHERE oi.order_id='".$order_id."' ORDER BY oi.id DESC");
	/*AND o.status='partial'*/
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($order_item_data=mysqli_fetch_assoc($query)) {
			$response_array[] = $order_item_data;
		}
	}
	return $response_array;
}

//Get order item device type, condition based on item id
function get_order_item($item_id, $type) {
	global $db;
	$order_query=mysqli_query($db,"SELECT oi.*, o.`payment_method`, o.`date`, o.`approved_date`, o.`expire_date`, o.`status`, o.`sales_pack`, o.`paypal_address`, o.`chk_name`, o.`chk_street_address`, o.`chk_street_address_2`, o.`chk_city`, o.`chk_state`, o.`chk_zip_code`, o.`act_name`, o.`act_number`, o.`act_short_code`, o.`note`, d.title AS device_title, m.title AS model_title FROM order_items AS oi LEFT JOIN orders AS o ON o.order_id=oi.order_id LEFT JOIN devices AS d ON d.id=oi.device_id LEFT JOIN mobile AS m ON m.id=oi.model_id WHERE oi.id='".$item_id."'");
	$data = mysqli_fetch_assoc($order_query);

	$response_array = array();
	if($data['item_name']) {
		if($type == "general") {
			$response_array['device_type'] = $data['model_title'].'<br>'.str_replace("::","<br>",$data['item_name']);
		} elseif($type == "list") {
			$response_array['device_type'] = $data['model_title'].'<br>'.str_replace("::","<br>",$data['item_name']);
		} elseif($type == "email") {
			$response_array['device_type'] = $data['model_title'].'<br>'.str_replace("::","<br>",$data['item_name']);
		} elseif($type == "print") {
			$response_array['device_type'] = $data['model_title'].'<br>'.str_replace("::","<br>",$data['item_name']);
		}
	}
	return $response_array;
}

//Send email as SMTP or PHP mail based on admin email settings
function send_email($to, $subject, $message, $from_name, $from_email, $attachment_data = array()) {
	global $db;
	$get_gsdata=mysqli_query($db,'SELECT * FROM general_setting ORDER BY id DESC');
	$general_setting_detail=mysqli_fetch_assoc($get_gsdata);
	$mailer_type = $general_setting_detail['mailer_type'];
	$smtp_host = $general_setting_detail['smtp_host'];
	$smtp_port = $general_setting_detail['smtp_port'];
	$smtp_security = $general_setting_detail['smtp_security'];
	$smtp_auth = $general_setting_detail['smtp_auth'];
	$smtp_username = $general_setting_detail['smtp_username'];
	$smtp_password = $general_setting_detail['smtp_password'];
	$email_api_key = $general_setting_detail['email_api_key'];
	//$email_api_username = $general_setting_detail['email_api_username'];
	//$email_api_password = $general_setting_detail['email_api_password'];

	global $company_address;
	global $company_city;
	global $company_state;
	global $company_zipcode;
	global $company_country;
	global $copyright;
	global $other_settings;

	$header_bg_color = ($other_settings['header_bg_color']?"#".$other_settings['header_bg_color']:"#126de5");
	$header_text_color = ($other_settings['header_text_color']?"#".$other_settings['header_text_color']:"#ffffff");
	$footer_bg_color = ($other_settings['footer_bg_color']?"#".$other_settings['footer_bg_color']:"#242b3d");
	$footer_text_color = ($other_settings['footer_text_color']?"#".$other_settings['footer_text_color']:"#a0a3ab");

	$logo_fixed_url = SITE_URL.'images/'.$general_setting_detail['logo_fixed'];
	
	$contact_link = SITE_URL.get_inbuild_page_url('contact');
	$blog_link = SITE_URL.get_inbuild_page_url('blog');
	
    $email_html = '';
	$email_html .= '<table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">';
      $email_html .= '<tbody>';
        $email_html .= '<tr>';
          $email_html .= '<td class="o_bg-light o_px-xs o_pt-lg o_xs-pt-xs" align="center" style="background-color: #dbe5ea;padding-left: 8px;padding-right: 8px;padding-top: 32px;">';
            $email_html .= '<table class="o_block-xs" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 800px;margin: 0 auto;">';
              $email_html .= '<tbody>';
                $email_html .= '<tr>';
                  $email_html .= '<td class="o_bg-primary o_px o_py-md o_br-t o_sans o_text" align="center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 16px;line-height: 24px;background-color: '.$header_bg_color.';border-radius: 4px 4px 0px 0px;padding-left: 16px;padding-right: 16px;padding-top: 24px;padding-bottom: 24px;">';
                    $email_html .= '<p style="margin-top: 0px;margin-bottom: 0px;"><a class="o_text-white" href="'.SITE_URL.'" style="text-decoration: none;outline: none;color: '.$header_text_color.';"><img src="'.$logo_fixed_url.'" width="136" height="36" alt="SimpleApp" style="max-width: 136px;-ms-interpolation-mode: bicubic;vertical-align: middle;border: 0;line-height: 100%;height: auto;outline: none;text-decoration: none;"></a></p>';
                  $email_html .= '</td>';
                $email_html .= '</tr>';
              $email_html .= '</tbody>';
            $email_html .= '</table>';
          $email_html .= '</td>';
        $email_html .= '</tr>';
      $email_html .= '</tbody>';
    $email_html .= '</table>';
	$email_html .= $message;

    $email_html .= '<table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">';
      $email_html .= '<tbody>';
        $email_html .= '<tr>';
          $email_html .= '<td class="o_bg-light o_px-xs o_pb-lg o_xs-pb-xs" align="center" style="background-color: #dbe5ea;padding-left: 8px;padding-right: 8px;padding-bottom: 32px;">';
            $email_html .= '<table class="o_block-xs" width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation" style="max-width: 800px;margin: 0 auto;">';
              $email_html .= '<tbody>';
                $email_html .= '<tr>';
                  $email_html .= '<td class=" o_bg-dark o_px-md o_py-lg o_br-b o_sans o_text-xs o_text-dark_light" align="center" style="font-family: Helvetica, Arial, sans-serif;margin-top: 0px;margin-bottom: 0px;font-size: 14px;line-height: 21px;background-color: '.$footer_bg_color.';color: '.$footer_text_color.';border-radius: 0px 0px 4px 4px;padding-left: 24px;padding-right: 24px;padding-top: 32px;padding-bottom: 32px;">';
                    $email_html .= '<p class="o_mb-xs" style="margin-top: 0px;margin-bottom: 8px;">'.$copyright.'</p>';
                    $email_html .= '<p class="o_mb-xs" style="margin-top: 0px;margin-bottom:0px;">'.$company_address.', '.$company_city.', '.$company_state.' '.$company_zipcode.($company_country?', '.$company_country:'').'</p>';
                    /*$email_html .= '<p class="o_mb-lg" style="margin-top: 0px;">
                      <a class="o_text-dark_light o_underline" href="'.$contact_link.'" style="text-decoration: underline;outline: none;color: #a0a3ab;">Help Center</a> <span class="o_hide-xs">&nbsp; &nbsp;</span><br class="o_hide-lg" style="display: none;font-size: 0;max-height: 0;width: 0;line-height: 0;overflow: hidden;mso-hide: all;visibility: hidden;">
                      <a class="o_text-dark_light o_underline" href="'.$blog_link.'" style="text-decoration: underline;outline: none;color: #a0a3ab;">Blog</a>
                    </p>';*/
                  $email_html .= '</td>';
                $email_html .= '</tr>';
              $email_html .= '</tbody>';
            $email_html .= '</table>';
            //$email_html .= '<div class="o_hide-xs" style="font-size: 64px; line-height: 64px; height: 64px;">&nbsp; </div>';
          $email_html .= '</td>';
        $email_html .= '</tr>';
      $email_html .= '</tbody>';
    $email_html .= '</table>';

	//echo $email_html;
	//return;

	if($mailer_type == "sendgrid" && $email_api_key) {
		$from = new SendGrid\Email($from_name, $from_email);
		$subject = $subject;
		$to = new SendGrid\Email($subject, $to);
		
		//Send message as text
		//$content = new SendGrid\Content("text/plain", "and easy to do anywhere, even with PHP");

		//Send message as html
		$content = new SendGrid\Content("text/html", $email_html);
		
		$mail = new SendGrid\Mail($from, $subject, $to, $content);
		
		$apiKey = $email_api_key;
		$sg = new \SendGrid($apiKey);

		$response = $sg->client->mail()->send()->post($mail);
		return '1';
	} elseif($mailer_type == "smtp" && $smtp_host && $smtp_port) {
		$mail = new PHPMailer();

		$mail->Timeout = 30;
		$mail->Host = $smtp_host;
		$mail->Port = ($smtp_port==""?"25":$smtp_port);
		if($smtp_username && $smtp_password) {
			$mail->IsSMTP(); 
			//$mail->SMTPDebug  = 2;
			$mail->SMTPAuth = true;
			$mail->Username = $smtp_username;
			$mail->Password = $smtp_password;
			if($smtp_security=="ssl") {
				$mail->SMTPSecure = 'tls';
			}
			//$mail->From = $smtp_username;
		}

		$mail->From = $from_email;
		$mail->FromName = $from_name;
		$mail->AddAddress($to);
		$mail->AddReplyTo($from_email, $from_name);
		//$mail->WordWrap = 50;

		if($attachment_data['basename']!="") {
			$mail->AddAttachment(CP_ROOT_PATH.'/'.$attachment_data['folder'].'/'.$attachment_data['basename'], $attachment_data['basename']);
		}

		$mail->IsHTML(true);

		$mail->Subject = $subject;
		$mail->Body    = $email_html;

		if(!$mail->Send()) {
			error_log("SMTP Mailer Error:".$mail->ErrorInfo);
			return '0';
		} else {
			return '1';
		}
	} else {
		$mail = new PHPMailer();

		$mail->Timeout = 30;
		$mail->From = $from_email;
		$mail->FromName = $from_name;
		$mail->AddAddress($to);
		$mail->AddReplyTo($from_email, $from_name);
		//$mail->WordWrap = 50;

		if($attachment_data['basename']!="") {
			$mail->AddAttachment(CP_ROOT_PATH.'/'.$attachment_data['folder'].'/'.$attachment_data['basename'], $attachment_data['basename']);
		}

		$mail->IsHTML(true);

		$mail->Subject = $subject;
		$mail->Body    = $email_html;

		if(!$mail->Send()) {
			error_log("SMTP Mailer Error:".$mail->ErrorInfo);
			return '0';
		} else {
			return '1';
		}
	}
}

//Get amount format, its prefix of amount or postfix of amount
function amount_fomat($amount) {
	global $db;
	$gs_query=mysqli_query($db,'SELECT currency, disp_currency FROM general_setting ORDER BY id DESC');
	$general_setting_data=mysqli_fetch_assoc($gs_query);
	$currency = @explode(",",$general_setting_data['currency']);
	if($general_setting_data['disp_currency']=="prefix")
		return $currency[1].number_format($amount, 2, '.', '');
	elseif($general_setting_data['disp_currency']=="postfix")
		return number_format($amount, 2, '.', '').$currency[1];
}

function amount_format_without_sign($amount) {
	global $db;
	$gs_query=mysqli_query($db,'SELECT currency, disp_currency FROM general_setting ORDER BY id DESC');
	$general_setting_data=mysqli_fetch_assoc($gs_query);
	//$currency = @explode(",",$general_setting_data['currency']);
	if($general_setting_data['disp_currency']=="prefix")
		return number_format($amount, 2, '.', '');
	elseif($general_setting_data['disp_currency']=="postfix")
		return number_format($amount, 2, '.', '');
}

//Escape string of mysql query
function real_escape_string($data) {
	global $db;
	return mysqli_real_escape_string($db,trim($data));
}

//Set redirect without message
function setRedirect($url) {
	header("HTTP/1.1 301 Moved Permanently");
	header('Location:'.$url);
	return true;
}

//Set redirect with message, show message based on type (success, info, warning, danger)
function setRedirectWithMsg($url,$msg,$type) {
	header("HTTP/1.1 301 Moved Permanently");
	$_SESSION['msg'] = array('msg'=>$msg,'type'=>$type);
	header('Location:'.$url);
	return true;
}

//For show confirmations message
function getConfirmMessage() {
	//success, info, warning, danger
	//$_SESSION['msg'] = array('msg'=>"Unable to create shipment, one or more parameters were invalid.",'type'=>"success");
	$msg = $_SESSION['msg'];
	$resp = array();
	if($msg['type']) {
		$resp_msg = '<div class="system-message">';
			$resp_msg .= '<div class="container-fluid text-center">';
				$resp_msg .= '<div class="row">';
				$resp_msg .= '<div class="alert alert-'.$msg['type'].' alert-dismissable">';
					$resp_msg .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
					$resp_msg .= $msg['msg'];
				$resp_msg .= '</div>';
				$resp_msg .= '</div>';
			$resp_msg .= '</div>';
		$resp_msg .= '</div>';
	}
	$resp['msg'] = $resp_msg;
	unset($_SESSION['msg']);
	return $resp;
}

//For get page list based on menu position type
function get_page_list($type) {
	global $db;
	$page_data_array = array();
	if(trim($type)) {
		$query=mysqli_query($db,"SELECT * FROM pages WHERE published='1' ORDER BY id ASC");
		while($page_data=mysqli_fetch_assoc($query)) {
			$exp_position=(array)json_decode($page_data['position']);
			if($type==$exp_position[$type]) {
				$page_data_array[] = $page_data;
			}
		}
	}
	return $page_data_array;
}

//For get menu list based on menu position
function get_menu_list($position) {
	global $db;
	$menu_data_array = array();

	$sql_params = "";
	if(trim($position)) {
		$sql_params .= "AND m.position='".$position."'";	
	}

	$query = mysqli_query($db,"SELECT m.*, p.title AS p_title, p.url AS p_url, p.is_custom_url AS p_is_custom_url FROM menus AS m LEFT JOIN pages AS p ON p.id=m.page_id WHERE m.status='1' AND parent='0' ".$sql_params." ORDER BY m.ordering ASC");
	while($page_data = mysqli_fetch_assoc($query)) {
		$page_data['submenu'] = array();
		$s_query = mysqli_query($db,"SELECT m.*, p.title AS p_title, p.url AS p_url, p.is_custom_url AS p_is_custom_url FROM menus AS m LEFT JOIN pages AS p ON p.id=m.page_id WHERE m.status='1' AND parent='".$page_data['id']."' ".$sql_params." ORDER BY m.ordering ASC");
		while($s_page_data = mysqli_fetch_assoc($s_query)) {
			$page_data['submenu'][] = $s_page_data;
		}
		$menu_data_array[] = $page_data;
	}
	return $menu_data_array;
}

//For get inbuild page url
function get_inbuild_page_url($slug) {
	global $db;
	if(trim($slug)) {
		$query=mysqli_query($db,"SELECT * FROM pages WHERE slug='".trim($slug)."'");
		$page_data=mysqli_fetch_assoc($query);
		return $page_data['url'];
	}
}

//For get small content based on words limit of string
function limit_words($string, $word_limit) {
    $words = explode(" ",$string);
    return implode(" ",array_splice($words,0,$word_limit));
}

//Get basket item count & sum of order
function get_basket_item_count_sum($order_id) {
	global $db;
	$response = array();
	$order_basket_count = 0;
	$order_basket_query=mysqli_query($db,"SELECT SUM(quantity) as total_qty, SUM(price) AS sum_of_orders FROM order_items WHERE order_id='".$order_id."'");
	$order_basket_data = mysqli_fetch_assoc($order_basket_query);
	$order_basket_count = intval($order_basket_data['total_qty']);
	$sum_of_orders = $order_basket_data['sum_of_orders'];
	
	$order_item_q=mysqli_query($db,"SELECT oi.*, o.status, d.title AS device_title, d.sef_url, m.title AS model_title, m.model_img FROM order_items AS oi LEFT JOIN orders AS o ON o.order_id=oi.order_id LEFT JOIN devices AS d ON d.id=oi.device_id LEFT JOIN mobile AS m ON m.id=oi.model_id WHERE o.order_id='".$order_id."' AND o.status='partial' ORDER BY oi.id DESC");
	$order_num_of_rows = mysqli_num_rows($order_item_q);
	if($order_num_of_rows>0) {
		while($order_item_data=mysqli_fetch_assoc($order_item_q)) {
			$basket_item_data[] = $order_item_data;
		}
	}
	
	$response['basket_item_count'] = $order_basket_count;
	$response['basket_item_sum'] = $sum_of_orders;
	$response['basket_item_data'] = $basket_item_data;
	return $response;
}

//Get popular device data, it will show only 3 popular device
function get_popular_device_data() {
	global $db;
	$response = array();
	$query=mysqli_query($db,"SELECT * FROM devices WHERE published=1 AND popular_device=1");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($device_data=mysqli_fetch_assoc($query)) {
			$response[] = $device_data;
		}
	}
	return $response;
}

//Get device data list
function get_device_data_list() {
	global $db;
	$response = array();
	//$query=mysqli_query($db,"SELECT d.*, b.title AS brand_title FROM devices AS d LEFT JOIN brand AS b ON b.id=d.brand_id WHERE d.published=1");
	$query=mysqli_query($db,"SELECT d.* FROM devices AS d WHERE d.published=1");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($device_data=mysqli_fetch_assoc($query)) {
			$response[] = $device_data;
		}
	}
	return $response;
}

//Get top seller data list
function get_top_seller_data_list($top_seller_limit) {
	global $db;
	$response = array();
	$query=mysqli_query($db,"SELECT m.*, m.title AS model_title, d.title AS device_title, d.sef_url, d.device_img, b.title AS brand_title FROM mobile AS m LEFT JOIN devices AS d ON d.id=m.device_id LEFT JOIN brand AS b ON b.id=m.brand_id WHERE m.published=1 AND m.top_seller='1' LIMIT ".$top_seller_limit."");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($device_data=mysqli_fetch_assoc($query)) {
			$response[] = $device_data;
		}
	}
	return $response;
}

//Get popular device data, it will show only 3 popular device
function get_brand_data($id = 0) {
	global $db;
	$response = array();
	$mysql_params = "";
	if($id>0) {
		$mysql_params .= " AND id='".$id."'";
		$query = mysqli_query($db,"SELECT * FROM brand WHERE published=1 ".$mysql_params."");
		$response = mysqli_fetch_assoc($query);
	} else {
		$query = mysqli_query($db,"SELECT * FROM brand WHERE published=1 ".$mysql_params."");
		$num_of_rows = mysqli_num_rows($query);
		if($num_of_rows>0) {
			while($device_data = mysqli_fetch_assoc($query)) {
				$response[] = $device_data;
			}
		}
	}
	return $response;
}

function get_single_brand_data($id) {
	global $db;
	$response = array();
	$query=mysqli_query($db,"SELECT * FROM brand WHERE published=1 AND id='".$id."'");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		$device_data=mysqli_fetch_assoc($query);
		$response = $device_data;
	}
	return $response;
}

//For all searchbox related autocomplete data
function autocomplete_data_search() {
	global $db;
	$response = array();
	$list_of_model = '';
	$query=mysqli_query($db,"SELECT m.*, d.title AS device_title, d.device_img, d.sef_url, b.title AS brand_title, b.id AS brand_id FROM mobile AS m LEFT JOIN devices AS d ON d.id=m.device_id LEFT JOIN brand AS b ON b.id=m.brand_id ORDER BY m.id DESC");
	while($search_data=mysqli_fetch_assoc($query)) {
		if($search_data['brand_title']) {
			$quote_mk_list[$search_data['brand_id']] = $search_data['brand_title'];
		}

		$name = $search_data['brand_title'].' '.$search_data['title'];
		$url = SITE_URL.$search_data['sef_url'].'/'.createSlug($search_data['title']).'/'.$search_data['id'];
		$list_of_model .= "{value:'".$name."', url:'".$url."'},";

		/*$ts_storage_list = json_decode($top_search_data['storage']);
		foreach($ts_storage_list as $ts_storage) {
			$quote_mk_list[$top_search_data['brand_id']] = $top_search_data['brand_title'];
					
			$name = $top_search_data['brand_title'].' '.$top_search_data['title'].' '.$ts_storage->storage_size;
			$url = SITE_URL.$top_search_data['sef_url'].'/'.createSlug($top_search_data['title']).'/'.$top_search_data['id'].'/'.$ts_storage->storage_size;
			$list_of_model .= "{value:'".$name."', url:'".$url."'},";
		}*/
	}
	$response['list_of_model'] = $list_of_model;
	$response['quote_mk_list'] = $quote_mk_list;
	return $response;
}

function get_brand_single_data_by_id($id) {
	global $db;
	$response = array();
	$query = mysqli_query($db,"SELECT b.* FROM brand AS b WHERE b.id='".$id."' AND b.published=1");
	$num_of_brand = mysqli_num_rows($query);
	$brand_single_data = mysqli_fetch_assoc($query);
	$response['brand_single_data'] = $brand_single_data;
	return $response;
}

function get_brand_single_data_by_sef_url($sef_url) {
	global $db;
	$response = array();
	$query = mysqli_query($db,"SELECT b.* FROM brand AS b WHERE b.sef_url='".$sef_url."' AND b.published=1");
	$num_of_brand = mysqli_num_rows($query);
	$brand_single_data = mysqli_fetch_assoc($query);
	$response['num_of_brand'] = $num_of_brand;
	$response['brand_single_data'] = $brand_single_data;
	return $response;
}

//Check if mobile menu & get data of single device based on url
function get_device_single_data($sef_url) {
	global $db;
	$response = array();
	$query=mysqli_query($db,"SELECT d.id AS device_id, d.id AS d_device_id, d.meta_title AS d_meta_title, d.meta_desc AS d_meta_desc, d.meta_keywords AS d_meta_keywords, d.sef_url, d.title AS device_title, d.sub_title AS device_sub_title, d.short_description, d.description, d.device_img, m.* FROM devices AS d LEFT JOIN mobile AS m ON d.id=m.device_id WHERE d.sef_url='".$sef_url."' AND d.published=1");
	$num_of_device = mysqli_num_rows($query);
	$device_single_data=mysqli_fetch_assoc($query);
	$response['num_of_device'] = $num_of_device;
	$response['is_mobile_menu'] = $num_of_device;
	$response['device_single_data'] = $device_single_data;
	return $response;
}

function get_device_single_data_by_id($id) {
	global $db;
	$query=mysqli_query($db,"SELECT d.* FROM devices AS d WHERE d.id='".$id."' AND d.published=1");
	return mysqli_fetch_assoc($query);
}

//save default status of order when we place order with choose option (print, free)
function save_default_status_when_place_order($args) {
	global $db;
	
	$q_params_for_prnt_order = "";
	
	if($args['sales_pack']=="print") {
		$q_params_for_prnt_order .= ", approved_date='".$args['approved_date']."', expire_date='".$args['expire_date']."'";
	}
	
	if($args['shipping_api']!="" && $args['shipment_id']!="") {
		$q_params_for_prnt_order .= ", shipping_api='".$args['shipping_api']."', shipment_id='".$args['shipment_id']."', shipment_tracking_code='".$args['shipment_tracking_code']."', shipment_label_url='".$args['shipment_label_url']."'";
	}
	
	if($args['order_id'] && $args['status']) {
		$query = mysqli_query($db,"UPDATE `orders` SET `status`='".$args['status']."', `sales_pack`='".$args['sales_pack']."'".$q_params_for_prnt_order." WHERE order_id='".$args['order_id']."'");
	}
	return $query;
}

function save_shipment_response_data($args) {
	global $db;
	if($args['order_id']) {
		$query = mysqli_query($db,"UPDATE `orders` SET shipping_api='".$args['shipping_api']."', shipment_id='".$args['shipment_id']."', shipment_tracking_code='".$args['shipment_tracking_code']."', shipment_label_url='".$args['shipment_label_url']."' WHERE order_id='".$args['order_id']."'");
	}
	return $query;
}

//Get order messaging data list based on orderID
function get_order_messaging_data_list($order_id) {
	global $db;
	$response = array();
	$query=mysqli_query($db,"SELECT * FROM order_messaging WHERE order_id='".$order_id."' ORDER BY id DESC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($order_messaging_dt=mysqli_fetch_assoc($query)) {
			$response[] = $order_messaging_dt;
		}
	}
	return $response;
}

//Get active review list
function get_review_list_data($status = 1, $limit = 0) {
	global $db;

	$sql_limit = "";
	if($limit>0) {
		$sql_limit = "LIMIT ".$limit;
	}

	$response = array();
	$query=mysqli_query($db,"SELECT * FROM reviews WHERE status='".$status."' ORDER BY id DESC ".$sql_limit."");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($review_data=mysqli_fetch_assoc($query)) {
			$response[] = $review_data;
		}
	}
	return $response;
}

//Get active review list
function get_review_list_data_random($status = 1) {
	global $db;

	$review_id_array = array();
	$query1=mysqli_query($db,"SELECT * FROM reviews WHERE status='".$status."'");
	$num_of_rows1 = mysqli_num_rows($query1);
	if($num_of_rows1>0) {
		while($review_data1=mysqli_fetch_assoc($query1)) {
			$review_id_array[] = $review_data1['id'];
		}
	}

	$rrk = array_rand($review_id_array);
    $random_review_id = $review_id_array[$rrk];

	$query=mysqli_query($db,"SELECT * FROM reviews WHERE id='".$random_review_id."'");
	$num_of_rows = mysqli_num_rows($query);
	$review_data=mysqli_fetch_assoc($query);
	return $review_data;
}

//Get active category list
function get_category_data_list($status = 1) {
	global $db;
	$response = array();
	$query=mysqli_query($db,"SELECT * FROM categories WHERE published='".$status."'");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($review_data=mysqli_fetch_assoc($query)) {
			$response[] = $review_data;
		}
	}
	return $response;
}

//Get active category data
function get_category_data($id) {
	global $db;
	$query=mysqli_query($db,"SELECT * FROM categories WHERE published='1' AND id='".$id."'");
	$review_data=mysqli_fetch_assoc($query);
	return $review_data;
}

//Get home page settings
function get_home_page_data($id = 0, $section_name = '') {
	global $db;
	if($id>0 || $section_name!="") {
		$query=mysqli_query($db,"SELECT * FROM home_settings WHERE status='1' AND (id='".$id."' OR (section_name='".$section_name."' AND section_name!=''))");
		$home_settings_data=mysqli_fetch_assoc($query);
		return $home_settings_data;
	} else {
		$response = array();
		$query=mysqli_query($db,"SELECT * FROM home_settings WHERE status='1' AND section_name!='slider' ORDER BY ordering ASC");
		$num_of_rows = mysqli_num_rows($query);
		if($num_of_rows>0) {
			while($home_settings_data=mysqli_fetch_assoc($query)) {
				$response[] = $home_settings_data;
			}
		}
		return $response;
	}
}

function lastwordstrongorspan($str, $type='strong') {
	if($type=='strong') {
		return preg_replace("@^(.*?)([^ ]+)\W?$@","$1<strong>$2</strong>",$str);
	} else {
		return preg_replace("@^(.*?)([^ ]+)\W?$@","$1<span>$2</span>",$str);
	}
}

function unique_id() {
	return date("YmdHis").uniqid();
}

function get_service_hours_data() {
	global $db;
	$query=mysqli_query($db,"SELECT * FROM service_hours ORDER BY id DESC");
	$service_hours_data=mysqli_fetch_assoc($query);
	return $service_hours_data;
}

function get_partner_data_by_store_name($store_name) {
	global $db;
	$response = array();
	$query=mysqli_query($db,"SELECT * FROM partners WHERE status='1' AND store_name='".$store_name."'");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		$response = mysqli_fetch_assoc($query);
	}
	return $response;
}

function get_partner_data_by_id($id) {
	global $db;
	$response = array();
	$query=mysqli_query($db,"SELECT * FROM partners WHERE id='".$id."'");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		$response = mysqli_fetch_assoc($query);
	}
	return $response;
}

function get_data_using_curl($url, $data = array()) {
	//  Initiate curl
	$ch = curl_init();
	// Will return the response, if false it print the response
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	// Set the url
	curl_setopt($ch, CURLOPT_URL,$url);
	// Execute
	$result=curl_exec($ch);
	// Closing
	curl_close($ch);
	
	// Will dump a beauty json :3
	return json_decode($result, true);
}

function get_promocode_list($type = "") {
	global $db;
	$response = array();
	
	$sql_params = "status=1";
	if($type == "future") {
		$sql_params .= " AND (never_expire='1' OR (never_expire='0' AND to_date>='".date("Y-m-d")."'))";
	}
	
	$query=mysqli_query($db,"SELECT * FROM promocode WHERE ".$sql_params." ORDER BY to_date DESC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($promocode_data=mysqli_fetch_assoc($query)) {
			$response[] = $promocode_data;
		}
	}
	return $response;
}

function replace_us_to_space($content) {
	return ucwords(str_replace("_"," ",$content));
}
?>