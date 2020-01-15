<?php
require_once("../admin/_config/config.php");
require_once("../admin/include/functions.php");

if(isset($post['missing_product'])) {

	$valid_csrf_token = verifyFormToken('missing_product_form');
	if($valid_csrf_token!='1') {
		writeHackLog('missing_product_form');
		$msg = "Invalid Token";
		setRedirectWithMsg($return_url,$msg,'warning');
		exit();
	}

	$name=real_escape_string($post['name']);
	$phone=preg_replace("/[^\d]/", "", real_escape_string($post['phone']));
	$email=real_escape_string($post['email']);
	$item_name=real_escape_string($post['item_name']);
	$subject='';
	$message=real_escape_string($post['message']);
	
	if($missing_product_form_captcha == '1') {
		$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$captcha_secret."&response=".$post['g-recaptcha-response']);
		$response = json_decode($response, true);
		if($response["success"] !== true) {
			$msg = "Invalid captcha";
			setRedirectWithMsg($return_url,$msg,'warning');
			exit();
		}
	}
	
	if($name && $phone && $email && $item_name) {
		$query=mysqli_query($db,"INSERT INTO contact(name, phone, email, item_name, subject, message, date, type) values('".$name."','".$phone."','".$email."','".$item_name."','".$subject."','".$message."','".date('Y-m-d H:i:s')."', 'quote')");
		$last_insert_id = mysqli_insert_id($db);
		if($query=="1") {
			$template_data = get_template_data('quote_request_form_alert');

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
				'{$customer_fullname}',
				'{$customer_phone}',
				'{$customer_email}',
				'{$current_date_time}',
				'{$form_subject}',
				'{$form_message}',
				'{$item_name}');

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
				$post['name'],
				$phone,
				$post['email'],
				date('Y-m-d H:i'),
				$post['subject'],
				$post['message'],
				$post['item_name']);

			if(!empty($template_data)) {
				$email_subject = str_replace($patterns,$replacements,$template_data['subject']);
				$email_body_text = str_replace($patterns,$replacements,$template_data['content']);
				send_email($admin_user_data['email'], $email_subject, $email_body_text, $post['name'], $post['email']);
			}

			$msg="Thank you for quote request. We'll contact you shortly.";
			setRedirectWithMsg($return_url,$msg,'success');
		} else {
			$msg='Sorry! something wrong updation failed.';
			setRedirectWithMsg($return_url,$msg,'danger');
		}
	} else {
		$msg='please fill in all required fields.';
		setRedirectWithMsg($return_url,$msg,'warning');
	}
	exit();
} elseif(isset($post['sell_this_device'])) {
	
	$valid_csrf_token = verifyFormToken('model_details');
	if($valid_csrf_token!='1') {
		writeHackLog('model_details');
		$msg = "Invalid Token";
		setRedirectWithMsg($return_url,$msg,'warning');
		exit();
	}
	
	$post = $_POST;
	$order_items_array = array();
	foreach($post as $key=>$val) {
		if(is_array($val) && $key!="files") {
			$val = implode(", ",$val);
		}

		if($key=="payment_method" || $key=="quantity" || $key=="sell_this_device" || $key=="device_id" || $key=="payment_amt" || $key=="req_model_id" || $key=="req_storage" || $key=="id" || $key=="PHPSESSID" || $key=="base_price" || $key=="csrf_token") {
			continue;
		}
		if(trim($val)) {
			$order_items_array[] = str_replace("_"," ",$key).": ".$val;
		}
	}
	$order_items = implode("::",$order_items_array);
	
	$quantity = $post['quantity'];
	$req_model_id = $post['req_model_id'];
	$req_storage = $post['req_storage'];
	if($quantity>0) {
		$_SESSION['payment_method'] = $post['payment_method'];
		$order_id = $_SESSION['order_id'];
		if($order_id=="") {
			$_SESSION['order_id'] = $order_prefix.date('s').rand(100000,999999);
			$order_id = $_SESSION['order_id'];
			mysqli_query($db,"INSERT INTO `orders`(`order_id`, `payment_method`, `date`, `status`) VALUES('".$order_id."','".$post['payment_method']."','".date('Y-m-d H:i:s')."','partial')");
		}

		//START upload images
		$files_data = $_FILES;
		$json_files = "";
		$files_array = array();
		if(isset($files_data) && count($files_data)>0) {
			if(!file_exists('../images/order/'))
				mkdir('../images/order/',0777);

			foreach($_FILES as $key=>$val){
				$target_dir = "../images/order/";
				$filename = basename($files_data[$key]["name"]);
				$imageFileType = strtolower(pathinfo($filename,PATHINFO_EXTENSION));
	
				if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
					
				}

				$filename = date("YmdHis").rand(1111,9999).".".$imageFileType;
				$target_file = $target_dir.$filename;
	
				if(move_uploaded_file($files_data[$key]["tmp_name"], $target_file)) {
					$files_array[$key] = $filename;
				}
			}
			$json_files = json_encode($files_array);
		} //END upload images

		$quantity_price = $post['payment_amt'];
		$item_price = ($quantity_price * $quantity);

		$order_item_ids = $_SESSION['order_item_ids'];
		if(empty($order_item_ids))
			$order_item_ids = array();

		$is_updated_in_existing_item = false;
		if(!empty($order_item_ids)) {
			$req_item_nm_array = $order_items;
			$order_item_query=mysqli_query($db,"SELECT oi.* FROM order_items AS oi WHERE oi.id IN('".implode("','",$order_item_ids)."')");
			$order_item_num_of_rows = mysqli_num_rows($order_item_query);
			if($order_item_num_of_rows>0) {
				while($order_item_data=mysqli_fetch_assoc($order_item_query)) {
					$saved_item_nm_array = $order_item_data['item_name'];
					if($req_item_nm_array == $saved_item_nm_array) {
						$is_updated_in_existing_item = true;
						$upt_svd_item_price = ($item_price+$order_item_data['price']);
						$upt_svd_item_qty = ($quantity+$order_item_data['quantity']);
						mysqli_query($db,"UPDATE `order_items` SET price='".$upt_svd_item_price."', quantity='".$upt_svd_item_qty."', quantity_price='".$quantity_price."' WHERE id='".$order_item_data['id']."'");
					}
				}
			}
		}

		if(!$is_updated_in_existing_item) {
			$query=mysqli_query($db,"INSERT INTO `order_items`(`device_id`, `model_id`, `order_id`, `storage`, `condition`, `network`, `color`, `accessories`, `miscellaneous`, `item_name`, `images`, `price`, `quantity`, `quantity_price`) VALUES('".$post['device_id']."','".$req_model_id."','".$order_id."','".real_escape_string($req_storage)."','".real_escape_string($condition[0])."','".real_escape_string($network[0])."','".real_escape_string($color[0])."','".real_escape_string($accessories)."','".real_escape_string($miscellaneous)."','".real_escape_string($order_items)."','".$json_files."','".$item_price."','".$quantity."','".$quantity_price."')");
			$last_insert_id = mysqli_insert_id($db);
			if($query=="1") {
				array_push($order_item_ids,$last_insert_id);
				$_SESSION['order_item_ids']=$order_item_ids;
			}
		}
	}

	setRedirect(SITE_URL.'revieworder');
	exit();
} 

else if(isset($_POST['sell_my_device_new'])){
	
	$valid_csrf_token = verifyFormToken('model_details');
	if($valid_csrf_token!='1') {
		writeHackLog('model_details');
		$msg = "Invalid Token";
		setRedirectWithMsg($return_url,$msg,'warning');
		exit();
	}
	
	$post = $_POST;
	$order_items_array = array();
	foreach($post as $key=>$val) {
		if(is_array($val) && $key!="files") {
			$val = implode(", ",$val);
		}

		if($key=="device_category_id" || $key=="quantity" || $key=="sell_my_device_new" || $key=="brand_id" || $key=="model_id" || $key=="base_price" || $key=="payment_amt" || $key=="id" || $key=="PHPSESSID" || $key=="device_id" || $key=="csrf_token") {
			continue;
		}
		if(trim($val)) {
			$order_items_array[] = str_replace("_"," ",$key).": ".$val;
		}
	}
	$order_items = implode("::",$order_items_array);
	
	$quantity = $post['quantity'];
	$req_model_id = $post['model_id'];
	if($quantity>0) {
		$order_id = $_SESSION['order_id'];
		if($order_id=="") {
			$_SESSION['order_id'] = $order_prefix.date('s').rand(100000,999999);
			$order_id = $_SESSION['order_id'];
			mysqli_query($db,"INSERT INTO `orders`(`order_id`,`date`, `status`) VALUES('".$order_id."','".date('Y-m-d H:i:s')."','partial')");
		}

		//START upload images
		$files_data = $_FILES;
		$json_files = "";
		$files_array = array();
		if(isset($files_data) && count($files_data)>0) {
			if(!file_exists('../images/order/'))
				mkdir('../images/order/',0777);

			foreach($_FILES as $key=>$val){
				$target_dir = "../images/order/";
				$filename = basename($files_data[$key]["name"]);
				$imageFileType = strtolower(pathinfo($filename,PATHINFO_EXTENSION));
	
				if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
					
				}

				$filename = date("YmdHis").rand(1111,9999).".".$imageFileType;
				$target_file = $target_dir.$filename;
	
				if(move_uploaded_file($files_data[$key]["tmp_name"], $target_file)) {
					$files_array[$key] = $filename;
				}
			}
			$json_files = json_encode($files_array);
		} //END upload images

		$quantity_price = $post['payment_amt'];
		$item_price = ($quantity_price * $quantity);
		
		$q="INSERT INTO `order_items`(`device_id`, `model_id`, `order_id`, `item_name`, `images`, `price`, `quantity`, `quantity_price`) VALUES('".$post['device_id']."','".$req_model_id."','".$order_id."','".real_escape_string($order_items)."','".$json_files."','".$item_price."','".$quantity."','".$quantity_price."')";
		
		$query=mysqli_query($db,$q);
		$last_insert_id = mysqli_insert_id($db);
		if($query=="1") {
			array_push($order_item_ids,$last_insert_id);
			$_SESSION['order_item_ids']=$order_item_ids;
		}
		
	}

	setRedirect(SITE_URL.'revieworder');
	exit();
}
else {
	$msg='Direct access denied';
	setRedirectWithMsg(SITE_URL,$msg,'danger');
	exit();
} ?>