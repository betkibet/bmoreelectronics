<?php
function _dt_parse($dt) {
	return isset($dt)?htmlentities($dt):'';
}

function _dt_parse_array($dt_arr) {
	if(!empty($dt_arr)) {
		array_walk_recursive($dt_arr, function(&$v) {
			$v = isset($v)?htmlentities($v):'';
		});
	}
	return $dt_arr;
}

function get_all_get_params()
{
	$output = "";
	$parameter = "";
	if(!empty($_GET)) {
		$output = "?"; 
		$firstRun = true; 
		foreach($_GET as $key=>$val) { 
			if($key != $parameter && $key!="p") { 
				if(!$firstRun) { 
					$output .= "&"; 
				} else { 
					$firstRun = false; 
				} 
				$output .= $key."=".$val;
			} 
		}
	}
	return $output;
}

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

	$csrf_token_array = (isset($_SESSION[$form.'_csrf_token'])?$_SESSION[$form.'_csrf_token']:'');
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

function get_order_status_data($table, $slug = "", $id = 0) {
	global $db;
	$resp_arr = array();
	$order_status_data_list = array();

	$mysql_q = "";
	if($table) {
		if($slug!="" || $id>0) {
			if($slug!="") {
				$mysql_q .= " AND slug='".$slug."'";
			} elseif($id>0) {
				$mysql_q .= " AND id='".$id."'";
			}
			
			$os_query = mysqli_query($db,"SELECT * FROM ".$table." WHERE status = '1' ".$mysql_q."");
			$order_status_data = mysqli_fetch_assoc($os_query);
			$resp_arr['data'] = $order_status_data;
		} else {
			$os_query = mysqli_query($db,"SELECT * FROM ".$table." WHERE status = '1' ".$mysql_q."");
			while($order_status_data = mysqli_fetch_assoc($os_query)) {
				$order_status_data_list[] = $order_status_data;
			}
			$resp_arr['list'] = $order_status_data_list;
		}
	}		
	return $resp_arr;
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
    $path['call_utf8'] = substr(urldecode((isset($request_path[0])?$request_path[0]:'')), strlen($path['base']) + 1);
    $path['call'] = utf8_decode($path['call_utf8']);
    if ($path['call'] == basename($_SERVER['PHP_SELF'])) {
      $path['call'] = '';
    }
    $path['call_parts'] = explode('/', $path['call']);

    $path['query_utf8'] = urldecode((isset($request_path[1])?$request_path[1]:''));
    $path['query'] = utf8_decode(urldecode((isset($request_path[1])?$request_path[1]:'')));
    $vars = explode('&', $path['query']);
    foreach($vars as $var) {
      $t = explode('=', $var);
      $path['query_vars'][$t[0]] = (isset($t[1])?$t[1]:'');
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

function get_demand_pickup_zipcodes_settings() {
	global $db;
	$q=mysqli_query($db,'SELECT * FROM demand_pickup_zipcodes ORDER BY id DESC');
	return mysqli_fetch_assoc($q);
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

//Get user data based on contractorID
function get_contractor_data($contractor_id) {
	global $db;
	$query=mysqli_query($db,"SELECT c.* FROM contractors AS c WHERE c.id='".$contractor_id."'");
	return mysqli_fetch_assoc($query);
}

//Get order data based on orderID
function get_order_data($order_id, $email = "", $access_token = "") {
	global $db;
	
	$mysql_q = "";
	if($access_token!="") {
		$mysql_q .= " AND o.access_token='".$access_token."'";
	}
	elseif($email!="") {
		$mysql_q .= " AND u.email='".$email."'";
	}
	
	//$u_query=mysqli_query($db,"SELECT u.*, o.*, o.date AS order_date, o.status AS order_status, os.name AS order_status_name FROM users AS u RIGHT JOIN orders AS o ON o.user_id=u.id LEFT JOIN order_status AS os ON os.id=o.status WHERE o.order_id='".$order_id."'".$mysql_q."");
	//$u_query=mysqli_query($db,"SELECT u.*, o.*, o.date AS order_date, o.`update_date` AS order_update_date, o.status AS order_status, os.name AS order_status_name, os.slug AS order_status_slug FROM users AS u RIGHT JOIN orders AS o ON o.user_id=u.id LEFT JOIN order_status AS os ON os.id=o.status WHERE o.order_id='".$order_id."'".$mysql_q."");
	//return mysqli_fetch_assoc($u_query);
	$u_query=mysqli_query($db,"SELECT u.*, u.note AS customer_note, o.*, o.date AS order_date, o.`update_date` AS order_update_date, o.status AS order_status, os.name AS order_status_name, os.slug AS order_status_slug, l.name as location_name, l.address as location_address, l.country as location_country, l.state as location_state, l.city as location_city, l.zipcode as location_zipcode FROM users AS u RIGHT JOIN orders AS o ON o.user_id=u.id LEFT JOIN locations AS l ON l.id=o.store_location_id LEFT JOIN order_status AS os ON os.id=o.status WHERE o.order_id='".$order_id."'".$mysql_q."");
	return mysqli_fetch_assoc($u_query);
}

function get_order_qty_by_order_id($order_id) {
	global $db;

	$return_array = array();
	$oi_query = mysqli_query($db,"SELECT SUM(oi.quantity) AS quantity FROM order_items AS oi WHERE oi.order_id='".$order_id."'");
	$order_items_data = mysqli_fetch_assoc($oi_query);
	$return_array['items_quantity'] = $order_items_data['quantity'];
	return $return_array;
}

function get_order_list($stat_period = '', $stat_date = '') {
	global $db;
	
	$today_date = date("Y-m-d");
	$mysql_q = "";
	if($stat_date != "") {
		$exp_from_date=explode("/",$stat_date);
		$from_date=$exp_from_date[2].'-'.$exp_from_date[0].'-'.$exp_from_date[1];
		$mysql_q .= " AND date<='".$today_date."' AND date>='".$from_date."'";
	} elseif($stat_period == "last_month") {
		$minus_month = date("Y-m-d",strtotime('-1 month'));
		$mysql_q .= " AND date<='".$today_date."' AND date>='".$minus_month."'";
	} elseif($stat_period == "3_month") {
		$minus_month = date("Y-m-d",strtotime('-3 month'));
		$mysql_q .= " AND date<='".$today_date."' AND date>='".$minus_month."'";
	} elseif($stat_period == "6_month") {
		$minus_month = date("Y-m-d",strtotime('-6 month'));
		$mysql_q .= " AND date<='".$today_date."' AND date>='".$minus_month."'";
	} elseif($stat_period == "9_month") {
		$minus_month = date("Y-m-d",strtotime('-9 month'));
		$mysql_q .= " AND date<='".$today_date."' AND date>='".$minus_month."'";
	}
	
	$return_array = array();
	$order_query = mysqli_query($db,"SELECT COUNT(*) AS num_of_orders FROM orders WHERE status!='partial'");
	$order_data = mysqli_fetch_assoc($order_query);
	$return_array['num_of_orders'] = $order_data['num_of_orders'];
	
	$order_items_query = mysqli_query($db,"SELECT * FROM orders WHERE status!='partial'".$mysql_q." ORDER BY order_id DESC");
	while($order_dt = mysqli_fetch_assoc($order_items_query)) {
		$oi_query = mysqli_query($db,"SELECT SUM(oi.quantity) AS quantity FROM order_items AS oi WHERE oi.order_id='".$order_dt['order_id']."'");
		$order_items_data = mysqli_fetch_assoc($oi_query);
		$order_dt['items_quantity'] = $order_items_data['quantity'];
		$order_data_arr[] = $order_dt;
	}
	$return_array['order_list'] = $order_data_arr;
	return $return_array;
}

function get_order_list_by_user_id($user_id, $stat_period = '', $page_list_limit = 0, $is_pagination = 0) {
	global $db;
	
	$today_date = date("Y-m-d");
	$mysql_q = "";
	if($stat_period == "last_month") {
		$minus_month = date("Y-m-d",strtotime('-1 month'));
		$mysql_q .= " AND o.date<='".$today_date."' AND o.date>='".$minus_month."'";
	} elseif($stat_period == "3_month") {
		$minus_month = date("Y-m-d",strtotime('-3 month'));
		$mysql_q .= " AND o.date<='".$today_date."' AND o.date>='".$minus_month."'";
	} elseif($stat_period == "6_month") {
		$minus_month = date("Y-m-d",strtotime('-6 month'));
		$mysql_q .= " AND o.date<='".$today_date."' AND o.date>='".$minus_month."'";
	} elseif($stat_period == "9_month") {
		$minus_month = date("Y-m-d",strtotime('-9 month'));
		$mysql_q .= " AND o.date<='".$today_date."' AND o.date>='".$minus_month."'";
	}

	$return_array = array();
	$order_data_arr = array();
	
	$order_query = mysqli_query($db,"SELECT COUNT(*) AS num_of_orders FROM orders AS o WHERE o.user_id='".$user_id."' AND o.user_id>0");
	$order_data = mysqli_fetch_assoc($order_query);
	$return_array['num_of_orders'] = $order_data['num_of_orders'];

	if($is_pagination == '1') {
		global $pagination;
		$pagination->set_total($order_data['num_of_orders']);
		
		$order_items_query = mysqli_query($db,"SELECT o.*, os.name AS order_status_name FROM orders AS o LEFT JOIN order_status AS os ON os.id=o.status WHERE o.user_id='".$user_id."'".$mysql_q." AND o.user_id>0 ORDER BY o.date DESC ".$pagination->get_limit()."");
		while($order_dt = mysqli_fetch_assoc($order_items_query)) {
			$oi_query = mysqli_query($db,"SELECT SUM(oi.quantity) AS quantity FROM order_items AS oi WHERE oi.order_id='".$order_dt['order_id']."'");
			$order_items_data = mysqli_fetch_assoc($oi_query);
			$order_dt['items_quantity'] = $order_items_data['quantity'];
			$order_data_arr[] = $order_dt;
		}
	} else {
		$order_items_query = mysqli_query($db,"SELECT o.*, os.name AS order_status_name FROM orders AS o LEFT JOIN order_status AS os ON os.id=o.status WHERE o.user_id='".$user_id."'".$mysql_q." AND o.user_id>0 ORDER BY o.date DESC");
		while($order_dt = mysqli_fetch_assoc($order_items_query)) {
			$oi_query = mysqli_query($db,"SELECT SUM(oi.quantity) AS quantity FROM order_items AS oi WHERE oi.order_id='".$order_dt['order_id']."'");
			$order_items_data = mysqli_fetch_assoc($oi_query);
			$order_dt['items_quantity'] = $order_items_data['quantity'];
			$order_data_arr[] = $order_dt;
		}
	}
	$return_array['order_list'] = $order_data_arr;
	return $return_array;
}

//Get order price based on orderID
function get_order_price($order_id) {
	global $db;
	$query=mysqli_query($db,"SELECT SUM(price) AS sum_of_orders FROM order_items WHERE order_id='".$order_id."'");
	$data=mysqli_fetch_assoc($query);
	return $data['sum_of_orders'];
}

//Get contractor list
function get_contractor_list() {
	global $db;
	$response_array = array();
	$c_query=mysqli_query($db,"SELECT c.* FROM contractors AS c ORDER BY c.id ASC");
	$num_of_rows = mysqli_num_rows($c_query);
	if($num_of_rows>0) {
		while($contractor_data=mysqli_fetch_assoc($c_query)) {
			$response_array[] = $contractor_data;
		}
	}
	return $response_array;
}

//Get contractor list
function get_contractor_users_list($contractor_id) {
	global $db;
	$response_array = array();
	$query = mysqli_query($db,"SELECT u.* FROM users AS u ORDER BY u.id ASC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($user_data=mysqli_fetch_assoc($query)) {
			$order_query = mysqli_query($db,"SELECT o.*, u.first_name, u.last_name, p.shop_name as aflt_shop_name, os.name AS order_status_name, ca.contractor_id, ca.order_id, ca.amount as c_amount FROM orders AS o LEFT JOIN users AS u ON u.id=o.user_id LEFT JOIN affiliate AS p ON p.id=o.affiliate_id LEFT JOIN order_status AS os ON os.id=o.status LEFT JOIN contractor_orders AS ca ON o.order_id=ca.order_id WHERE o.status!='partial' AND ca.contractor_id='".$contractor_id."' AND u.id='".$user_data['id']."'");
			$num_of_o_rows = mysqli_num_rows($order_query);
			if($num_of_o_rows>0) {
				$response_array[] = $user_data;
			} elseif($user_data['contractor_id'] > 0 && $user_data['contractor_id']==$contractor_id) {
				$response_array[] = $user_data;
			}
		}
	}
	return $response_array;
}

//Get order item list data based on orderID
function get_order_item_list($order_id) {
	global $db;
	$response_array = array();
	//$query=mysqli_query($db,"SELECT oi.*, oi.status AS item_status, o.`payment_method`, o.`date`, o.`approved_date`, o.`expire_date`, o.`status`, o.`sales_pack`, o.`note`, d.title AS device_title, m.title AS model_title, m.model_img, os.name AS order_status_name, ois.name AS order_item_status_name FROM order_items AS oi LEFT JOIN orders AS o ON o.order_id=oi.order_id LEFT JOIN devices AS d ON d.id=oi.device_id LEFT JOIN mobile AS m ON m.id=oi.model_id LEFT JOIN order_status AS os ON os.id=o.status LEFT JOIN order_item_status AS ois ON ois.id=oi.status WHERE oi.order_id='".$order_id."' ORDER BY oi.id DESC");
	$query=mysqli_query($db,"SELECT oi.*, oi.status AS item_status, o.`payment_method`, o.`date`, o.`update_date` AS order_update_date, o.`approved_date`, o.`expire_date`, o.`status`, o.`sales_pack`, o.`note`, d.title AS device_title, m.title AS model_title, m.model_img, d.device_img, d.device_icon, c.image AS cat_image, c.cart_image AS cat_cart_image, os.name AS order_status_name, ois.name AS order_item_status_name FROM order_items AS oi LEFT JOIN orders AS o ON o.order_id=oi.order_id LEFT JOIN devices AS d ON d.id=oi.device_id LEFT JOIN mobile AS m ON m.id=oi.model_id LEFT JOIN categories AS c ON m.cat_id=c.id LEFT JOIN order_status AS os ON os.id=o.status LEFT JOIN order_item_status AS ois ON ois.id=oi.status WHERE oi.order_id='".$order_id."' ORDER BY oi.id ASC");
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
	$order_query=mysqli_query($db,"SELECT oi.*, oi.status AS item_status, o.`payment_method`, o.`date`, o.`approved_date`, o.`expire_date`, o.`status`, o.`sales_pack`, o.`note`, d.title AS device_title, m.title AS model_title FROM order_items AS oi LEFT JOIN orders AS o ON o.order_id=oi.order_id LEFT JOIN devices AS d ON d.id=oi.device_id LEFT JOIN mobile AS m ON m.id=oi.model_id WHERE oi.id='".$item_id."'");
	$data = mysqli_fetch_assoc($order_query);

	$items_name = "";
	$items_name2 = "";
	
	$item_name_array = json_decode($data['item_name'],true);
	if(!empty($item_name_array)) {
		/*foreach($item_name_array as $item_name_data) {
			$items_name .= '<strong>'.str_replace("_"," ",$item_name_data['fld_name']).':</strong> ';
			$items_opt_name = "";
			foreach($item_name_data['opt_data'] as $opt_data) {
				$items_opt_name .= $opt_data['opt_name'].', ';
				$items_opt_name_arr[] = $opt_data['opt_name'];
			}
			$items_name .= rtrim($items_opt_name,', ');
			$items_name .= '<br>';		
		}*/

		$items_name .= '<table class="table table-borderless child device-info-table device-info-table-'.$data['id'].'"><tr>';
			$opt_n = 0;
			$items_opt_name2 = "";
			foreach($item_name_array as $item_name_data) {
				foreach($item_name_data['opt_data'] as $opt_data) {
					$items_opt_name2 .= $opt_data['opt_name'].', ';
					if($opt_n%3==0) {
						$items_name .= '</tr><tr><td>'.$opt_data['opt_name'].'</td>';
					} else {
						$items_name .= '<td>'.$opt_data['opt_name'].'</td>';
					}
					$opt_n++;
				}
			}
		$items_name .= '</tr></table>';
		$items_name2 .= rtrim($items_opt_name2,', ');
	}

	$image_name_array = json_decode($data['images'],true);
	if(!empty($image_name_array)) {
		foreach($image_name_array as $image_name_data) {
			if($image_name_data['img_name']) {
				$items_name .= '<strong>'.str_replace("_"," ",$image_name_data['fld_name']).':</strong> ';
				$items_name .= '<img src="'.SITE_URL.'images/order/'.$image_name_data['img_name'].'" width="25">';
				$items_name .= '<br>';
			}
		}
	}

	$response_array = array();
	if($data['item_name']) {
		if($type == "general") {
			$response_array['device_type'] = $data['model_title'].'<br>'.$items_name;
		} elseif($type == "rev_ord_list") {
			$response_array['device_type'] = $items_name;
		} elseif($type == "list") {
			$response_array['device_type'] = $data['model_title'].'<br>'.$items_name;
		} elseif($type == "email") {
			$response_array['device_type'] = $data['model_title'].'<br>'.$items_name2;
		} elseif($type == "print") {
			$response_array['device_type'] = $data['model_title'].'<br>'.$items_name2;
		}
	}
	
	/*$items_name = "";
	$item_name_array = json_decode($data['item_name'],true);
	if(!empty($item_name_array)) {
		foreach($item_name_array as $item_name_data) {
			$items_name .= '<span class="text-muted">'.str_replace("_"," ",$item_name_data['fld_name']).':</span> ';
			$items_opt_name = "";
			foreach($item_name_data['opt_data'] as $opt_data) {
				$items_opt_name .= $opt_data['opt_name'].', ';
			}
			$items_name .= rtrim($items_opt_name,', ');
			//$items_name .= '<br>';
			$items_name .= '&nbsp;&nbsp;';		
		}
	}
	
	$image_name_array = json_decode($data['images'],true);
	if(!empty($image_name_array)) {
		foreach($image_name_array as $image_name_data) {
			if($image_name_data['img_name']) {
				$items_name .= '<span class="text-muted">'.str_replace("_"," ",$image_name_data['fld_name']).':</span> ';
				$items_name .= '<img src="'.SITE_URL.'images/order/'.$image_name_data['img_name'].'" width="25">';
				//$items_name .= '<br>';
				$items_name .= '&nbsp;&nbsp;';
			}
		}
	}
	
	$print_items_name = "";
	if($type == "print") {
		$print_item_name_array = json_decode($data['item_name'],true);
		if(!empty($print_item_name_array)) {
			$print_items_name .= '<table class="table table-borderless child device-info-table device-info-table-'.$data['id'].'"><tr>';
				$print_opt_n = 0;
				foreach($print_item_name_array as $print_item_name_data) {
					foreach($print_item_name_data['opt_data'] as $opt_data) {
						if($print_opt_n%3==0) {
							$print_items_name .= '</tr><tr><td>'.$opt_data['opt_name'].'</td>';
						} else {
							$print_items_name .= '<td>'.$opt_data['opt_name'].'</td>';
						}
						$print_opt_n++;
					}
				}
			$print_items_name .= '</tr></table>';
		}
	
		$image_name_array = json_decode($data['images'],true);
		if(!empty($image_name_array)) {
			foreach($image_name_array as $image_name_data) {
				if($image_name_data['img_name']) {
					$print_items_name .= '<strong>'.str_replace("_"," ",$image_name_data['fld_name']).':</strong> ';
					$print_items_name .= '<img src="'.SITE_URL.'images/order/'.$image_name_data['img_name'].'" width="25">';
					$print_items_name .= '<br>';
				}
			}
		}
	}

	$response_array = array();
	if($data['item_name']) {
		if($type == "general") {
			$response_array['device_type'] = $data['model_title'].'<br>'.$items_name;
		} elseif($type == "rev_ord_list") {
			$response_array['device_type'] = $items_name;
		} elseif($type == "list") {
			$response_array['device_type'] = $data['model_title'].'<br>'.$items_name;
		} elseif($type == "email") {
			$response_array['device_type'] = $data['model_title'].'<br>'.$items_name;
		} elseif($type == "print") {
			$response_array['device_type'] = $data['model_title'].'<br>'.$print_items_name;
		}
	}*/
	$response_array['data'] = $data;
	return $response_array;
}

function save_order_status_log($data) {
	global $db;
	$order_id = $data['order_id'];
	$item_id = (!empty($data['item_id'])?$data['item_id']:'');
	$order_status = (!empty($data['order_status'])?$data['order_status']:'');
	$item_status = (!empty($data['item_status'])?$data['item_status']:'');
	$item_price = (!empty($data['item_price'])?$data['item_price']:'');
	$date = date("Y-m-d H:i:s");
	$leadsource = (!empty($data['leadsource'])?$data['leadsource']:'');
	if(!empty($data)) {
		mysqli_query($db,'INSERT INTO order_status_log(order_id, item_id, order_status, item_status, item_price, date) values("'.$order_id.'","'.$item_id.'","'.$order_status.'","'.$item_status.'","'.$item_price.'","'.$date.'")');
		$saved_id = mysqli_insert_id($db);
		
		if(trim($leadsource)) {
			mysqli_query($db,"UPDATE `order_status_log` SET `leadsource`='".$leadsource."' WHERE id='".$saved_id."'");
		}
	
		return $saved_id;
	} else {
		return '';
	}
}

function get_order_payment_status_log($order_id) {
	global $db;
	$resp_arr = array();
	
	$o_query = mysqli_query($db,"SELECT * FROM orders WHERE order_id='".$order_id."'");
	$order_data = mysqli_fetch_assoc($o_query);
	
	$os_query = mysqli_query($db,"SELECT osl.*, oi.order_item_id FROM order_status_log AS osl LEFT JOIN order_items AS oi ON oi.id=osl.item_id WHERE osl.order_id='".$order_id."'");
	while($order_status_data = mysqli_fetch_assoc($os_query)) {
		$order_status_data['log_type'] = 'order';
		$order_status_data['shipment_id'] = $order_data['shipment_id'];
		$order_status_data['shipment_tracking_code'] = $order_data['shipment_tracking_code'];
		$order_status_data['payment_method'] = $order_data['payment_method'];
		$resp_arr[] = $order_status_data;
	}
	$op_query = mysqli_query($db,"SELECT opl.*, oi.order_item_id FROM order_payment_log AS opl LEFT JOIN order_items AS oi ON oi.id=opl.item_id WHERE opl.order_id='".$order_id."'");
	while($order_payment_data = mysqli_fetch_assoc($op_query)) {
		$order_payment_data['log_type'] = 'payment';
		$resp_arr[] = $order_payment_data;
	}
	
	foreach($resp_arr as $key => $resp_data) {
		$date[$key] = $resp_data['date'];
	}
	@array_multisort($date,SORT_DESC, $resp_arr);			
	return $resp_arr;
}

function get_item_price_of_prev_history($item_id) {
	global $db;

	//$query = mysqli_query($db,"SELECT * FROM order_status_log WHERE item_id = '".$item_id."' AND item_price!='' ORDER BY id DESC LIMIT 1,2");
	$query = mysqli_query($db,"SELECT * FROM order_items_price WHERE item_id = '".$item_id."' AND price!='' ORDER BY id DESC LIMIT 1,2");
	$order_status_log_data = mysqli_fetch_assoc($query);
	$return_dt['prev_price'] = $order_status_log_data['price'];
	return $return_dt;
}

function save_inbox_mail_sms($data) {
	global $db;

	$template_id = $data['template_id'];
	$staff_id = $data['staff_id'];
	$user_id = $data['user_id'];
	$order_id = $data['order_id'];
	$from_email = $data['from_email'];
	$to_email = $data['to_email'];
	$subject = real_escape_string($data['subject']);
	$body = real_escape_string($data['body']);
	$sms_phone = $data['sms_phone'];
	$sms_content = $data['sms_content'];
	$date = $data['date'];
	$leadsource = $data['leadsource'];
	$form_type = $data['form_type'];

	if($body!="" && $from_email!="" && $to_email!="") {
		$query=mysqli_query($db,'INSERT INTO inbox_mail_sms(template_id, staff_id, user_id, order_id, from_email, to_email, subject, body, sms_phone, sms_content, date, visitor_ip, leadsource, form_type) values("'.$template_id.'","'.$staff_id.'","'.$user_id.'","'.$order_id.'","'.$from_email.'","'.$to_email.'","'.$subject.'","'.$body.'","'.$sms_phone.'","'.$sms_content.'","'.$date.'","'.USER_IP.'","'.$leadsource.'","'.$form_type.'")');
		$saved_storage_ids = mysqli_insert_id($db);
		return $saved_storage_ids;
	} else {
		return '';
	}
}

function unsubscribe_user_tokens($unsubsc_data_arr) {
	global $db;
	$user_id = $unsubsc_data_arr['user_id'];
	$unsubscribe_token = $unsubsc_data_arr['token'];
	mysqli_query($db,"INSERT INTO unsubscribe_user_tokens(user_id, token, date) VALUES('".$user_id."','".$unsubscribe_token."','".date('Y-m-d H:i:s')."')");
}

//Send email as SMTP or PHP mail based on admin email settings
function send_email($to, $subject, $message, $from_name, $from_email, $attachment_data = array(), $reply_to_data=array()) {
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

	$reply_to_name = $from_name;
	$reply_to_email = $from_email;
	if(!empty($reply_to_data)){
		$reply_to_name = $reply_to_data['name']?$reply_to_data['name']:$reply_to_name;
		$reply_to_email = $reply_to_data['email']?$reply_to_data['email']:$reply_to_email;
	}

	global $company_address;
	global $company_city;
	global $company_state;
	global $company_zipcode;
	global $company_country;
	global $copyright;
	global $other_settings;
	global $email_logo_width;
	global $email_logo_height;

	$header_bg_color = ($other_settings['header_bg_color']?"#".$other_settings['header_bg_color']:"#126de5");
	$header_text_color = ($other_settings['header_text_color']?"#".$other_settings['header_text_color']:"#ffffff");
	$footer_bg_color = ($other_settings['footer_bg_color']?"#".$other_settings['footer_bg_color']:"#242b3d");
	$footer_text_color = ($other_settings['footer_text_color']?"#".$other_settings['footer_text_color']:"#a0a3ab");

	$logo_email_url = SITE_URL.'images/'.$general_setting_detail['logo_email'];
	
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
                    $email_html .= '<p style="margin-top: 0px;margin-bottom: 0px;"><a class="o_text-white" href="'.SITE_URL.'" style="text-decoration: none;outline: none;color: '.$header_text_color.';"><img src="'.$logo_email_url.'" width="'.$email_logo_width.'" height="'.$email_logo_height.'" style="max-width: 136px;-ms-interpolation-mode: bicubic;vertical-align: middle;border: 0;line-height: 100%;height: auto;outline: none;text-decoration: none;"></a></p>';
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
		$mail = new SendGrid\Mail\Mail();
		$mail->setFrom($from_email, $from_name);
		$mail->setSubject($subject);
		$mail->addTo($to, $subject);
		if($reply_to_email) {
			$mail->setReplyTo($reply_to_email);
		}
		$mail->addContent("text/html", $message);
		
		/*$from = new SendGrid\Email($from_name, $from_email);
		$subject = $subject;
		$to = new SendGrid\Email($subject, $to);

		//Send message as html
		$content = new SendGrid\Content("text/html", $email_html);
		
		$mail = new SendGrid\Mail($from, $subject, $to, $content);*/
		
		if(!empty($attachment_data['basename'])) {
			$i = 1;
			foreach($attachment_data['basename'] as $f_key=>$basename) {
				$att_objt = 'att'.$i;
				$file_mime_type = mime_content_type(CP_ROOT_PATH.'/'.$attachment_data['folder'][$f_key].'/'.$basename);
				$att_objt = new SendGrid\Attachment();
				$att_objt->setContent(base64_encode(file_get_contents(CP_ROOT_PATH.'/'.$attachment_data['folder'][$f_key].'/'.$basename, false, $arrContextOptions)));
				$att_objt->setType($file_mime_type);
				$att_objt->setFilename($basename);
				$att_objt->setDisposition("attachment");
				$mail->addAttachment($att_objt);
				$i++;
			}
		}
		
		$apiKey = $email_api_key;
		$sg = new \SendGrid($apiKey);

		$response = $sg->client->mail()->send()->post($mail);
		return '1';
	} elseif($mailer_type == "smtp" && $smtp_host && $smtp_port) {
		$mail = new PHPMailer(true);
		
		try {
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
					$mail->SMTPSecure = 'ssl';
				}
				if($smtp_security=="tls") {
					$mail->SMTPSecure = 'tls';
				}
				//$mail->From = $smtp_username;
			}
	
			$mail->From = $from_email;
			$mail->FromName = $from_name;
			$mail->AddAddress($to);
			$mail->AddReplyTo($reply_to_email, $reply_to_name);
			//$mail->WordWrap = 50;
	
			if(!empty($attachment_data['basename'])) {
				foreach($attachment_data['basename'] as $f_key=>$basename) {
					if($basename) {
						$mail->AddAttachment(CP_ROOT_PATH.'/'.$attachment_data['folder'][$f_key].'/'.$basename, $basename);
					}
				}
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
		} catch(phpmailerException $e) {
		  //echo $e->errorMessage(); //Pretty error messages from PHPMailer
		} catch(Exception $e) {
		  //echo $e->getMessage(); //Boring error messages from anything else!
		}
	} else {
		$mail = new PHPMailer(true);
		
		try {
			$mail->Timeout = 30;
			$mail->From = $from_email;
			$mail->FromName = $from_name;
			$mail->AddAddress($to);
			$mail->AddReplyTo($reply_to_email, $reply_to_name);
			//$mail->WordWrap = 50;
	
			if(!empty($attachment_data['basename'])) {
				foreach($attachment_data['basename'] as $f_key=>$basename) {
					if($basename) {
						$mail->AddAttachment(CP_ROOT_PATH.'/'.$attachment_data['folder'][$f_key].'/'.$basename, $basename);
					}
				}
			}
	
			$mail->IsHTML(true);
	
			$mail->Subject = $subject;
			$mail->Body    = $email_html;
	
			if(!$mail->Send()) {
				error_log("SMTP Mailer Error:".$mail->ErrorInfo);
				return '0';
			} else {
				$logfile = 'website_email_'.date("Y-m-d H:i:s").'.log';
				file_put_contents($logfile,date("Y-m-d H:i:s")." | ".print_r($mail,true)."\n",FILE_APPEND);
				return '1';
			}
		} catch(phpmailerException $e) {
		  //echo $e->errorMessage(); //Pretty error messages from PHPMailer
		} catch(Exception $e) {
		  //echo $e->getMessage(); //Boring error messages from anything else!
		}
	}
}

//Get amount format, its prefix of amount or postfix of amount
function amount_fomat($amount) {
	global $db;
	$gs_query=mysqli_query($db,'SELECT * FROM general_setting ORDER BY id DESC');
	$general_setting_data=mysqli_fetch_assoc($gs_query);

	$currency = @explode(",",$general_setting_data['currency']);
	$is_space_between_currency_symbol = $general_setting_data['is_space_between_currency_symbol'];
	$thousand_separator = $general_setting_data['thousand_separator'];
	$decimal_separator = $general_setting_data['decimal_separator'];
	$decimal_number = $general_setting_data['decimal_number'];

	$symbol_space = "";
	if($is_space_between_currency_symbol == '1') {
		$symbol_space = " ";
	} else {
		$symbol_space = "";
	}

	if($general_setting_data['disp_currency']=="prefix") {
		//return $currency[1].number_format($amount, 2, '.', '');
		return $currency[1].$symbol_space.number_format($amount, $decimal_number, $decimal_separator, $thousand_separator);
	} elseif($general_setting_data['disp_currency']=="postfix") {
		//return number_format($amount, 2, '.', '').$currency[1];
		return number_format($amount, $decimal_number, $decimal_separator, $thousand_separator).$symbol_space.$currency[1];
	}
}

function amount_format_without_sign($amount) {
	global $db;
	$gs_query=mysqli_query($db,'SELECT thousand_separator, decimal_separator, decimal_number FROM general_setting ORDER BY id DESC');
	$general_setting_data=mysqli_fetch_assoc($gs_query);

	$thousand_separator = $general_setting_data['thousand_separator'];
	$decimal_separator = $general_setting_data['decimal_separator'];
	$decimal_number = $general_setting_data['decimal_number'];

	return number_format($amount, $decimal_number, $decimal_separator, $thousand_separator);
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
	$msg = (isset($_SESSION['msg'])?$_SESSION['msg']:'');
	if(empty($msg)) {
		$msg = array('msg'=>'','type'=>'');
	}

	$resp = array();
	$resp_msg = '';
	/*if($msg['type']) {
		$resp_msg = '<section class="system-message">';
			// $resp_msg .= '<div class="container-fluid text-center">';
				// $resp_msg .= '<div class="row">';
				$resp_msg .= '<div class="alert alert-'.$msg['type'].' alert-dismissable">';
					$resp_msg .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
					$resp_msg .= $msg['msg'];
				$resp_msg .= '</div>';
				// $resp_msg .= '</div>';
			// $resp_msg .= '</div>';
		$resp_msg .= '</section>';
	}*/
	if($msg['type']) {
		$resp_msg = '<div class="system-message">';
			$resp_msg .= '<div class="container-fluid text-center">';
				$resp_msg .= '<div class="row"><div class="col-md-12"><div class="block mb-0 pb-0">';
				// $resp_msg .= '<div class="mb-0 alert alert-'.$msg['type'].' alert-dismissable">';
				$resp_msg .= '<div class="mb-0 alert">';
					$resp_msg .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true"><img src="'.SITE_URL.'images/payment/close.png" alt=""></button>';
					$resp_msg .= $msg['msg'];
				$resp_msg .= '</div>';
				$resp_msg .= '</div></div></div>';
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

	$query = mysqli_query($db,"SELECT m.*, p.title AS p_title, p.url AS p_url, p.is_custom_url AS p_is_custom_url, p.slug AS page_slug FROM menus AS m LEFT JOIN pages AS p ON p.id=m.page_id WHERE m.status='1' AND parent='0' ".$sql_params." ORDER BY m.ordering ASC");
	while($page_data = mysqli_fetch_assoc($query)) {
		$page_data['submenu'] = array();
		$s_query = mysqli_query($db,"SELECT m.*, p.title AS p_title, p.url AS p_url, p.is_custom_url AS p_is_custom_url, p.slug AS page_slug FROM menus AS m LEFT JOIN pages AS p ON p.id=m.page_id WHERE m.status='1' AND parent='".$page_data['id']."' ".$sql_params." ORDER BY m.ordering ASC");
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

function get_inbuild_page_data($slug) {
	global $db;
	if(trim($slug)) {
		$resp_arr = array();
		$query=mysqli_query($db,"SELECT * FROM pages WHERE slug='".trim($slug)."'");
		$page_data=mysqli_fetch_assoc($query);
		$resp_arr['data'] = $page_data;
		return $resp_arr;
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
	$basket_item_data = array();

	$order_basket_count = 0;
	$order_basket_query=mysqli_query($db,"SELECT SUM(quantity) as total_qty, SUM(price) AS sum_of_orders FROM order_items WHERE order_id='".$order_id."'");
	$order_basket_data = mysqli_fetch_assoc($order_basket_query);
	$order_basket_count = intval($order_basket_data['total_qty']);
	$sum_of_orders = $order_basket_data['sum_of_orders'];
	
	$order_item_q=mysqli_query($db,"SELECT oi.*, o.status, d.title AS device_title, d.sef_url, m.title AS model_title, m.model_img, m.sef_url AS model_sef_url FROM order_items AS oi LEFT JOIN orders AS o ON o.order_id=oi.order_id LEFT JOIN devices AS d ON d.id=oi.device_id LEFT JOIN mobile AS m ON m.id=oi.model_id WHERE o.order_id='".$order_id."' AND o.status='partial' ORDER BY oi.id DESC");
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
	$query=mysqli_query($db,"SELECT * FROM devices WHERE published=1 AND popular_device=1 ORDER BY ordering ASC");
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
	$query=mysqli_query($db,"SELECT d.* FROM devices AS d WHERE d.published=1 ORDER BY d.ordering ASC");
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
	$query=mysqli_query($db,"SELECT m.*, m.sef_url AS model_sef_url, m.title AS model_title, d.title AS device_title, d.sef_url, d.device_img, b.title AS brand_title FROM mobile AS m LEFT JOIN devices AS d ON d.id=m.device_id LEFT JOIN brand AS b ON b.id=m.brand_id WHERE m.published=1 AND m.top_seller='1' ORDER BY m.ordering ASC LIMIT ".$top_seller_limit);
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($device_data=mysqli_fetch_assoc($query)) {
			$response[] = $device_data;
		}
	}
	return $response;
}

function get_f_device_data_list() {
	global $db;
	$response = array();
	$query=mysqli_query($db,"SELECT d.* FROM devices AS d WHERE d.published=1 AND d.models_show_in_footer=1 ORDER BY d.ordering ASC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($device_data=mysqli_fetch_assoc($query)) {
			$response[] = $device_data;
		}
	}
	return $response;
}

function get_f_model_data_list($device_id) {
	global $db;
	$response = array();

	$sql_whr = "";
	//if($device_id>0) {
	$sql_whr = "AND m.device_id='".$device_id."'";
	//}
	
	$model_query=mysqli_query($db,"SELECT m.*, d.title AS device_title, d.sef_url AS device_sef_url, b.title AS brand_title FROM mobile AS m LEFT JOIN devices AS d ON d.id=m.device_id LEFT JOIN brand AS b ON b.id=m.brand_id WHERE m.published=1 ".$sql_whr." ORDER BY m.ordering DESC LIMIT 10");
	$model_num_of_rows = mysqli_num_rows($model_query);
	if($model_num_of_rows>0) {
		while($model_list=mysqli_fetch_assoc($model_query)) {
			$response[] = $model_list;
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
		$query = mysqli_query($db,"SELECT * FROM brand WHERE published=1 ".$mysql_params." ORDER BY ordering ASC");
		$response = mysqli_fetch_assoc($query);
	} else {
		$query = mysqli_query($db,"SELECT * FROM brand WHERE published=1 ".$mysql_params." ORDER BY ordering ASC");
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
	$query=mysqli_query($db,"SELECT m.*, d.title AS device_title, d.device_img, d.sef_url, b.title AS brand_title, b.id AS brand_id FROM mobile AS m LEFT JOIN devices AS d ON d.id=m.device_id LEFT JOIN brand AS b ON b.id=m.brand_id ORDER BY m.ordering ASC");
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
	//$query=mysqli_query($db,"SELECT d.id AS device_id, d.id AS d_device_id, d.meta_title AS d_meta_title, d.meta_desc AS d_meta_desc, d.meta_keywords AS d_meta_keywords, d.sef_url, d.title AS device_title, d.sub_title AS device_sub_title, d.short_description, d.description, d.device_img, m.* FROM devices AS d LEFT JOIN mobile AS m ON d.id=m.device_id WHERE d.sef_url='".$sef_url."' AND d.published=1");
	//$query=mysqli_query($db,"SELECT m.*, m.sef_url AS model_sef_url, d.id AS device_id, d.id AS d_device_id, d.meta_title AS d_meta_title, d.meta_desc AS d_meta_desc, d.meta_keywords AS d_meta_keywords, d.sef_url, d.title AS device_title, d.sub_title AS device_sub_title, d.short_description, d.description, d.device_img FROM devices AS d LEFT JOIN mobile AS m ON d.id=m.device_id WHERE d.sef_url='".$sef_url."' AND d.published=1");
	$query=mysqli_query($db,"SELECT d.id AS device_id, d.sef_url AS device_sef_url, d.id AS d_device_id, d.meta_title AS d_meta_title, d.meta_desc AS d_meta_desc, d.meta_keywords AS d_meta_keywords, d.sef_url, d.title AS device_title, d.sub_title AS device_sub_title, d.short_description, d.description, d.device_img, m.* FROM devices AS d LEFT JOIN mobile AS m ON d.id=m.device_id WHERE d.sef_url='".$sef_url."' AND d.published=1");
	$num_of_device = mysqli_num_rows($query);
	$device_single_data=mysqli_fetch_assoc($query);
	$response['num_of_device'] = $num_of_device;
	$response['is_mobile_menu'] = $num_of_device;
	$response['device_single_data'] = $device_single_data;
	return $response;
}

function get_device_single_data_by_id($id) {
	global $db;
	$query=mysqli_query($db,"SELECT d.* FROM devices AS d WHERE d.id='".$id."' AND d.published=1 ORDER BY d.ordering ASC");
	return mysqli_fetch_assoc($query);
}

function get_cat_single_data_by_sef_url($sef_url) {
	global $db;
	$response = array();
	$query = mysqli_query($db,"SELECT c.* FROM categories AS c WHERE c.sef_url='".$sef_url."' AND c.published=1");
	$num_of_cat = mysqli_num_rows($query);
	$cat_single_data = mysqli_fetch_assoc($query);
	$response['num_of_category'] = $num_of_cat;
	$response['category_single_data'] = $cat_single_data;
	return $response;
}

function get_mobile_single_data_by_url_id($sef_url) {
	global $db;
	$response = array();
	$query = mysqli_query($db,"SELECT m.* FROM mobile AS m WHERE m.sef_url='".$sef_url."' AND m.sef_url!='' AND m.published=1");
	$num_of_model = mysqli_num_rows($query);
	$model_data = mysqli_fetch_assoc($query);
	$response['num_of_model'] = $num_of_model;
	$response['model_data'] = $model_data;
	return $response;
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
	$query=mysqli_query($db,"SELECT * FROM categories WHERE published='".$status."' ORDER BY ordering ASC");
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

function get_service_hours_data_html($location_id) {
	global $db;
	$query=mysqli_query($db,"SELECT * FROM service_hours WHERE location_id='".$location_id."' AND location_id>0");
	$service_hours_data=mysqli_fetch_assoc($query);

	$service_hours_info = "";
	if(!empty($service_hours_data)) {
		$open_time=json_decode($service_hours_data['open_time'],true);
		$close_time=json_decode($service_hours_data['close_time'],true);
		$closed = json_decode($service_hours_data['is_close'],true);

		$service_hours_k_array = array();
		$service_hours_array = array();
		if($open_time > 0) {
			foreach($open_time as $time_k => $time_v) {
				switch($time_k) {
					case "sunday":
						$day_order=7;
						break;
					case "monday":
						$day_order=1;
						break;
					case "tuesday":
						$day_order=2;
						break;
					case "wednesday":
						$day_order=3;
						break;
					case "thursday":
						$day_order=4;
						break;
					case "friday":
						$day_order=5;
						break;
					case "saturday":
						$day_order=6;
						break;
				}
				if(!@array_key_exists($time_k, $closed)) {
					if($time_v!="" && $close_time[$time_k]!="") {
						$service_hours_k_array[$time_k] = '<span class="nomargin"><b>'.ucfirst(substr($time_k,0,3)).': </b><a class="shop-time" href="javascript:void(0)" class="time_box"> '.$time_v.' - '.$close_time[$time_k].'<i class="fa fa-chevron-down"></i><i class="fa fa-chevron-up"></i></a></span>';
						$service_hours_array[$day_order] = '<span class="nomargin"><b>'.ucfirst(substr($time_k,0,3)).': </b>'.$time_v.' - '.$close_time[$time_k].'</span>';
					}
				}
			}
		}
		
		if(isset($closed) && count($closed) > 0) {
			foreach($closed as $time_k => $time_v) {
				if($time_k!='' && $time_v!='') {
					switch($time_k) {
						case "sunday":
							$day_order=7;
							break;
						case "monday":
							$day_order=1;
							break;
						case "tuesday":
							$day_order=2;
							break;
						case "wednesday":
							$day_order=3;
							break;
						case "thursday":
							$day_order=4;
							break;
						case "friday":
							$day_order=5;
							break;
						case "saturday":
							$day_order=6;
							break;
					}
					$service_hours_k_array[$time_k] = '<span class="sun nomargin"><b>'.ucfirst(substr($time_k,0,3)).': </b><a class="shop-time" href="javascript:void(0)" class="time_box"> Closed<i class="fa fa-chevron-down"></i><i class="fa fa-chevron-up"></i></a></span>';
					$service_hours_array[$day_order] = '<span class="sun nomargin"><b>'.ucfirst(substr($time_k,0,3)).': </b>Closed</span>';
				}
			}
		}

		if(!empty($service_hours_array)) {
			ksort($service_hours_array);
			//$service_hours_info .= '<p>'.$service_hours_k_array[$current_day_name].'</p>';
			//$service_hours_info .= '<div class="time_block">';
				foreach($service_hours_array as $time_k => $time_v) {
					$service_hours_info .= '<div class="col-md-4">'.$time_v.'</div>';
				}
			//$service_hours_info .= '</div>';
		}
	}
	$service_hours_data['service_hours_info'] = $service_hours_info;
	return $service_hours_data;
}

function check_sef_url_validation($sef_url, $id, $table_nm) {
	global $db;
	$response = array();

	$response['valid'] = true;

	$brand_sql_params = "";
	$device_sql_params = "";
	$category_sql_params = "";
	$page_sql_params = "";
	if($table_nm == "brand") {
		$brand_sql_params .= " AND id!='".$id."'";
	}
	if($table_nm == "devices") {
		$device_sql_params .= " AND id!='".$id."'";
	}
	if($table_nm == "category") {
		$category_sql_params .= " AND id!='".$id."'";
	}
	if($table_nm == "pages") {
		$page_sql_params .= " AND id!='".$id."'";
	}

	$qry = mysqli_query($db,"SELECT * FROM brand WHERE sef_url='".$sef_url."' AND sef_url!=''".$brand_sql_params);
	$num_of_brand = mysqli_num_rows($qry);
	if($num_of_brand>0) {
		$response['valid'] = false;
	}
	
	$qry_d = mysqli_query($db,"SELECT * FROM devices WHERE sef_url='".$sef_url."' AND sef_url!=''".$device_sql_params);
	$num_of_device = mysqli_num_rows($qry_d);
	if($num_of_device>0) {
		$response['valid'] = false;
	}
	
	$qry_c = mysqli_query($db,"SELECT * FROM categories WHERE sef_url='".$sef_url."' AND sef_url!=''".$category_sql_params);
	$num_of_category = mysqli_num_rows($qry_c);
	if($num_of_category>0) {
		$response['valid'] = false;
	}
	
	$qry_p = mysqli_query($db,"SELECT * FROM pages WHERE url='".$sef_url."' AND url!=''".$page_sql_params);
	$num_of_page = mysqli_num_rows($qry_p);
	if($num_of_page>0) {
		$response['valid'] = false;
	}
	
	return $response;
}

function get_affiliate_data_by_store_name($shop_name) {
	global $db;
	$response = array();
	$query=mysqli_query($db,"SELECT * FROM affiliate WHERE status='1' AND shop_name='".$shop_name."'");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		$response = mysqli_fetch_assoc($query);
	}
	return $response;
}

function get_affiliate_data_by_id($id) {
	global $db;
	$response = array();
	$query=mysqli_query($db,"SELECT * FROM affiliate WHERE id='".$id."'");
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

function timeZoneConvert($fromTime, $fromTimezone, $toTimezone,$format = 'Y-m-d H:i:s') {
	// create timeZone object , with fromtimeZone
	$from = new DateTimeZone($fromTimezone);
	// create timeZone object , with totimeZone
	$to = new DateTimeZone($toTimezone);
	// read give time into ,fromtimeZone
	$orgTime = new DateTime($fromTime, $from);
	// fromte input date to ISO 8601 date (added in PHP 5). the create new date time object
	$toTime = new DateTime($orgTime->format("c"));
	// set target time zone to $toTme ojbect.
	$toTime->setTimezone($to);
	// return reuslt.
	return $toTime->format($format);
}

function format_date($date) {
	$data=get_general_setting_data();
	$date_format=$data['date_format'];
	$date=timeZoneConvert($date, 'UTC', TIMEZONE,'Y-m-d H:i:s');
	return date($date_format,strtotime($date));
}

function format_time($date){
	$data=get_general_setting_data();
	$time_format=$data['time_format'];
	$_format="H:i";
	if($time_format=="12_hour"){
		$_format="g:i a";
	}
	$date=timeZoneConvert($date, 'UTC', TIMEZONE,'Y-m-d H:i:s');
	return date($_format,strtotime($date));
}

function time_zonelist(){
    $return = array();
    $timezone_identifiers_list = timezone_identifiers_list();
    foreach($timezone_identifiers_list as $timezone_identifier){
        $date_time_zone = new DateTimeZone($timezone_identifier);
        $date_time = new DateTime('now', $date_time_zone);
        $hours = floor($date_time_zone->getOffset($date_time) / 3600);
        $mins = floor(($date_time_zone->getOffset($date_time) - ($hours*3600)) / 60);
        $hours = 'GMT' . ($hours < 0 ? $hours : '+'.$hours);
        $mins = ($mins > 0 ? $mins : '0'.$mins);
        $text = str_replace("_"," ",$timezone_identifier);
		
		$array=array();
		$array['display']=$text.' ('.$hours.':'.$mins.')';
		$array['value']=$timezone_identifier;
        $return[] =$array; 
    }
    return $return;
}

function get_date_format_list(){
    $return = array();

	$return[] = array('display'=>'m/d/Y ex. '.date('m/d/Y'),'value'=>'m/d/Y');
	$return[] = array('display'=>'d-m-Y ex. '.date('d-m-Y'),'value'=>'d-m-Y');
	$return[] = array('display'=>'M/d/Y ex. '.date('M/d/Y'),'value'=>'M/d/Y');
	$return[] = array('display'=>'d-M-Y ex. '.date('d-M-Y'),'value'=>'d-M-Y');

	$return[] = array('display'=>'m/d/y ex. '.date('m/d/y'),'value'=>'m/d/y');
	$return[] = array('display'=>'d-m-y ex. '.date('d-m-y'),'value'=>'d-m-y');
	$return[] = array('display'=>'M/d/y ex. '.date('M/d/y'),'value'=>'M/d/y');
	$return[] = array('display'=>'d-M-y ex. '.date('d-M-y'),'value'=>'d-M-y');

    return $return;
}

function get_unique_id_on_load() {
	return md5(uniqid());
}

function get_big_unique_id() {
	return md5(date("YmdHis").uniqid()).rand(0000000000,9999999999);
}

function is_allowed_ip(){
	global $db;
	$gs_query=mysqli_query($db,'SELECT * FROM general_setting ORDER BY id DESC');
	$general_setting_data = mysqli_fetch_assoc($gs_query);

	$is_ip_restriction = $general_setting_data['is_ip_restriction'];
	$allowed_ip = $general_setting_data['allowed_ip'];
	
	$allowed_ip_array=explode(',',$allowed_ip);
	$final_allowed_ip_array = array_map('trim',$allowed_ip_array);

	if($is_ip_restriction && $is_ip_restriction=='1'){
		if(!in_array(USER_IP,$final_allowed_ip_array)){
			setRedirect(ADMIN_URL.'unauthorized.php');
		}
	}
}

function admin_staff_logout_redirect() {
	unset($_SESSION['admin_username']);
	unset($_SESSION['is_admin']);
	unset($_SESSION['admin_id']);
	unset($_SESSION['admin_type']);
	unset($_SESSION['auth_token']);
	
	unset($_COOKIE['username']);
	unset($_COOKIE['password']);
	unset($_COOKIE['remember_me']);

	$year = time() - 172800;
	setcookie('username', '', $year, "/");
	setcookie('password', '', $year, "/");
	setcookie('remember_me', '', $year, "/");

	setRedirect(ADMIN_URL);
}

function check_admin_staff_auth($type = "") {
	global $db;
	$auth_token = isset($_SESSION['auth_token'])?$_SESSION['auth_token']:'';
	if($auth_token!="") {
		$query = mysqli_query($db,"SELECT * FROM admin WHERE auth_token!='' AND auth_token = '".$auth_token."'");
		$checkUser=mysqli_num_rows($query);
		if($checkUser > 0) {
			$user_data=mysqli_fetch_assoc($query);
			if($user_data['status'] == '0') {
				$error_msg='Your account is not activated so please contact with support team.';
				if($type=="ajax") {
					$response['message'] = $error_msg;
					$response['status'] = "fail";
					echo json_encode($response);
					exit;
				} else {
					$_SESSION['error_msg']=$error_msg;
					admin_staff_logout_redirect();
					exit;
				}
			}
		} elseif($checkUser <= 0) {
			$error_msg='Your username/password is changed so please login with new password. OR Your account is removed so please contact with support team.';
			if($type=="ajax") {
				$response['message'] = $error_msg;
				$response['status'] = "fail";
				echo json_encode($response);
				exit;
			} else {
				$_SESSION['error_msg']=$error_msg;
				admin_staff_logout_redirect();
				exit;
			}
		} 
	} else {
		$error_msg='Direct access denied';
		if($type=="ajax") {
			$response['message'] = $error_msg;
			$response['status'] = "fail";
			echo json_encode($response);
			exit;
		} else {
			$_SESSION['error_msg']=$error_msg;
			setRedirect(ADMIN_URL);
			exit;
		}
	}
}

function contractor_staff_logout_redirect() {
	unset($_SESSION['contractor_username']);
	unset($_SESSION['is_contractor']);
	unset($_SESSION['contractor_id']);
	unset($_SESSION['contractor_type']);
	unset($_SESSION['contractor_auth_token']);
	
	unset($_COOKIE['username']);
	unset($_COOKIE['password']);
	unset($_COOKIE['remember_me']);

	$year = time() - 172800;
	setcookie('username', '', $year, "/");
	setcookie('password', '', $year, "/");
	setcookie('remember_me', '', $year, "/");

	setRedirect(CONTRACTOR_URL);
}

function check_contractor_staff_auth($type = "") {
	global $db;
	$auth_token = isset($_SESSION['contractor_auth_token'])?$_SESSION['contractor_auth_token']:'';
	if($auth_token!="") {
		$query = mysqli_query($db,"SELECT * FROM contractors WHERE auth_token!='' AND auth_token = '".$auth_token."'");
		$checkUser=mysqli_num_rows($query);
		if($checkUser > 0) {
			$user_data=mysqli_fetch_assoc($query);
			if($user_data['status'] == '0') {
				$error_msg='Your account is not activated so please contact with support team.';
				if($type=="ajax") {
					$response['message'] = $error_msg;
					$response['status'] = "fail";
					echo json_encode($response);
					exit;
				} else {
					$_SESSION['error_msg']=$error_msg;
					contractor_staff_logout_redirect();
					exit;
				}
			}
		} elseif($checkUser <= 0) {
			$error_msg='Your username/password is changed so please login with new password. OR Your account is removed so please contact with support team.';
			if($type=="ajax") {
				$response['message'] = $error_msg;
				$response['status'] = "fail";
				echo json_encode($response);
				exit;
			} else {
				$_SESSION['error_msg']=$error_msg;
				contractor_staff_logout_redirect();
				exit;
			}
		} 
	} else {
		$error_msg='Direct access denied';
		if($type=="ajax") {
			$response['message'] = $error_msg;
			$response['status'] = "fail";
			echo json_encode($response);
			exit;
		} else {
			$_SESSION['error_msg']=$error_msg;
			setRedirect(CONTRACTOR_URL);
			exit;
		}
	}
}

function replace_us_to_space($content) {
	return ucwords(str_replace("_"," ",$content));
}

function replace_us_to_space_pmt_mthd($content) {
	global $cheque_check_label;
	return ucwords(str_replace(array("_", "cheque"),array(" ", $cheque_check_label),$content));
}

function pre($s){
	echo '<pre>';
	print_r($s);
	echo '</pre>';
}

function get_models_storage_data($model_id) {
	global $db;
	$response = array();
	$query=mysqli_query($db,"SELECT * FROM models_storage WHERE model_id='".$model_id."' ORDER BY id ASC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($data=mysqli_fetch_assoc($query)) {
			$response[] = $data;
		}
	}
	return $response;
}

function get_models_condition_data($model_id) {
	global $db;
	$response = array();
	$query=mysqli_query($db,"SELECT * FROM models_condition WHERE model_id='".$model_id."' ORDER BY id ASC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($data=mysqli_fetch_assoc($query)) {
			$response[] = $data;
		}
	}
	return $response;
}

function get_models_networks_data($model_id) {
	global $db;
	$response = array();
	$query=mysqli_query($db,"SELECT * FROM models_networks WHERE model_id='".$model_id."' ORDER BY id ASC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($data=mysqli_fetch_assoc($query)) {
			$response[] = $data;
		}
	}
	return $response;
}

function get_models_connectivity_data($model_id) {
	global $db;
	$response = array();
	$query=mysqli_query($db,"SELECT * FROM models_connectivity WHERE model_id='".$model_id."' ORDER BY id ASC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($data=mysqli_fetch_assoc($query)) {
			$response[] = $data;
		}
	}
	return $response;
}

function get_models_model_data($model_id) {
	global $db;
	$response = array();
	$query=mysqli_query($db,"SELECT * FROM models_model WHERE model_id='".$model_id."' ORDER BY id ASC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($data=mysqli_fetch_assoc($query)) {
			$response[] = $data;
		}
	}
	return $response;
}

function get_models_graphics_card_data($model_id) {
	global $db;
	$response = array();
	$query=mysqli_query($db,"SELECT * FROM models_graphics_card WHERE model_id='".$model_id."' ORDER BY id ASC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($data=mysqli_fetch_assoc($query)) {
			$response[] = $data;
		}
	}
	return $response;
}

function get_models_watchtype_data($model_id) {
	global $db;
	$response = array();
	$query=mysqli_query($db,"SELECT * FROM models_watchtype WHERE model_id='".$model_id."' ORDER BY id ASC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($data=mysqli_fetch_assoc($query)) {
			$response[] = $data;
		}
	}
	return $response;
}

function get_models_case_material_data($model_id) {
	global $db;
	$response = array();
	$query=mysqli_query($db,"SELECT * FROM models_case_material WHERE model_id='".$model_id."' ORDER BY id ASC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($data=mysqli_fetch_assoc($query)) {
			$response[] = $data;
		}
	}
	return $response;
}

function get_models_case_size_data($model_id) {
	global $db;
	$response = array();
	$query=mysqli_query($db,"SELECT * FROM models_case_size WHERE model_id='".$model_id."' ORDER BY id ASC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($data=mysqli_fetch_assoc($query)) {
			$response[] = $data;
		}
	}
	return $response;
}

function get_models_color_data($model_id) {
	global $db;
	$response = array();
	$query=mysqli_query($db,"SELECT * FROM models_color WHERE model_id='".$model_id."' ORDER BY id ASC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($data=mysqli_fetch_assoc($query)) {
			$response[] = $data;
		}
	}
	return $response;
}

function get_models_accessories_data($model_id, $ids = array()) {
	global $db;
	$response = array();
	
	$mysql_q_params = "";
	if(count($ids)>0) {
		$mysql_q_params = " AND id IN('".implode("','",$ids)."')";
	}
	
	$query=mysqli_query($db,"SELECT * FROM models_accessories WHERE model_id='".$model_id."'".$mysql_q_params." ORDER BY id ASC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($data=mysqli_fetch_assoc($query)) {
			$response[] = $data;
		}
	}
	return $response;
}

function get_models_band_included_data($model_id, $ids = array()) {
	global $db;
	$response = array();

	$mysql_q_params = "";
	if(count($ids)>0) {
		$mysql_q_params = " AND id IN('".implode("','",$ids)."')";
	}

	$query=mysqli_query($db,"SELECT * FROM models_band_included WHERE model_id='".$model_id."'".$mysql_q_params." ORDER BY id ASC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($data=mysqli_fetch_assoc($query)) {
			$response[] = $data;
		}
	}
	return $response;
}

function get_models_miscellaneous_data($model_id) {
	global $db;
	$response = array();
	$query=mysqli_query($db,"SELECT * FROM models_miscellaneous WHERE model_id='".$model_id."' ORDER BY id ASC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($data=mysqli_fetch_assoc($query)) {
			$response[] = $data;
		}
	}
	return $response;
}

function get_models_processor_data($model_id, $ids = array()) {
	global $db;
	$response = array();
	
	$mysql_q_params = "";
	if(count($ids)>0) {
		$mysql_q_params = " AND id IN('".implode("','",$ids)."')";
	}
	
	$query=mysqli_query($db,"SELECT * FROM models_processor WHERE model_id='".$model_id."'".$mysql_q_params." ORDER BY id ASC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($data=mysqli_fetch_assoc($query)) {
			$response[] = $data;
		}
	}
	return $response;
}

function get_models_ram_data($model_id, $ids = array()) {
	global $db;
	$response = array();
	
	$mysql_q_params = "";
	if(count($ids)>0) {
		$mysql_q_params = " AND id IN('".implode("','",$ids)."')";
	}
	
	$query=mysqli_query($db,"SELECT * FROM models_ram WHERE model_id='".$model_id."'".$mysql_q_params." ORDER BY id ASC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($data=mysqli_fetch_assoc($query)) {
			$response[] = $data;
		}
	}
	return $response;
}

function get_category_storage_data($cat_id) {
	global $db;
	$response = array();
	$query=mysqli_query($db,"SELECT * FROM category_storage WHERE cat_id='".$cat_id."' ORDER BY id ASC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($data=mysqli_fetch_assoc($query)) {
			$response[] = $data;
		}
	}
	return $response;
}

function get_category_condition_data($cat_id) {
	global $db;
	$response = array();
	$query=mysqli_query($db,"SELECT * FROM category_condition WHERE cat_id='".$cat_id."' ORDER BY id ASC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($data=mysqli_fetch_assoc($query)) {
			$response[] = $data;
		}
	}
	return $response;
}

function get_category_networks_data($cat_id) {
	global $db;
	$response = array();
	$query=mysqli_query($db,"SELECT * FROM category_networks WHERE cat_id='".$cat_id."' ORDER BY id ASC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($data=mysqli_fetch_assoc($query)) {
			$response[] = $data;
		}
	}
	return $response;
}



function get_category_connectivity_data($cat_id) {
	global $db;
	$response = array();
	$query=mysqli_query($db,"SELECT * FROM category_connectivity WHERE cat_id='".$cat_id."' ORDER BY id ASC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($data=mysqli_fetch_assoc($query)) {
			$response[] = $data;
		}
	}
	return $response;
}

function get_category_model_data($cat_id) {
	global $db;
	$response = array();
	$query=mysqli_query($db,"SELECT * FROM category_model WHERE cat_id='".$cat_id."' ORDER BY id ASC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($data=mysqli_fetch_assoc($query)) {
			$response[] = $data;
		}
	}
	return $response;
}

function get_category_graphics_card_data($cat_id) {
	global $db;
	$response = array();
	$query=mysqli_query($db,"SELECT * FROM category_graphics_card WHERE cat_id='".$cat_id."' ORDER BY id ASC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($data=mysqli_fetch_assoc($query)) {
			$response[] = $data;
		}
	}
	return $response;
}

function get_category_watchtype_data($cat_id) {
	global $db;
	$response = array();
	$query=mysqli_query($db,"SELECT * FROM category_watchtype WHERE cat_id='".$cat_id."' ORDER BY id ASC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($data=mysqli_fetch_assoc($query)) {
			$response[] = $data;
		}
	}
	return $response;
}

function get_category_case_material_data($cat_id) {
	global $db;
	$response = array();
	$query=mysqli_query($db,"SELECT * FROM category_case_material WHERE cat_id='".$cat_id."' ORDER BY id ASC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($data=mysqli_fetch_assoc($query)) {
			$response[] = $data;
		}
	}
	return $response;
}

function get_category_case_size_data($cat_id) {
	global $db;
	$response = array();
	$query=mysqli_query($db,"SELECT * FROM category_case_size WHERE cat_id='".$cat_id."' ORDER BY id ASC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($data=mysqli_fetch_assoc($query)) {
			$response[] = $data;
		}
	}
	return $response;
}

function get_category_accessories_data($cat_id) {
	global $db;
	$response = array();
	$query=mysqli_query($db,"SELECT * FROM category_accessories WHERE cat_id='".$cat_id."' ORDER BY id ASC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($data=mysqli_fetch_assoc($query)) {
			$response[] = $data;
		}
	}
	return $response;
}

function get_category_band_included_data($cat_id) {
	global $db;
	$response = array();
	$query=mysqli_query($db,"SELECT * FROM category_band_included WHERE cat_id='".$cat_id."' ORDER BY id ASC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($data=mysqli_fetch_assoc($query)) {
			$response[] = $data;
		}
	}
	return $response;
}

function get_category_processor_data($cat_id) {
	global $db;
	$response = array();
	$query=mysqli_query($db,"SELECT * FROM category_processor WHERE cat_id='".$cat_id."' ORDER BY id ASC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($data=mysqli_fetch_assoc($query)) {
			$response[] = $data;
		}
	}
	return $response;
}

function get_category_ram_data($cat_id) {
	global $db;
	$response = array();
	$query=mysqli_query($db,"SELECT * FROM category_ram WHERE cat_id='".$cat_id."' ORDER BY id ASC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($data=mysqli_fetch_assoc($query)) {
			$response[] = $data;
		}
	}
	return $response;
}

function html_entities($str) {
	return htmlentities($str);
}

function addslashes_to_html($str) {
	return addslashes($str);
}

function get_review_stars($star, $where = "") {
	$star_class = '<a href="#"><i class="ion ion-md-star"></i></a>';
	if($where == "home") {
		$star_class = '<div class="ui-star filled"><i class="ion ion-md-star"></i><i class="ion ion-md-star"></i></div>';
	}
	
	$rev_html = '';
	if($star == '0.5' || $star == '1') {
		$rev_html = $star_class;
	} elseif($star == '1.5' || $star == '2') {
		$rev_html = str_repeat($star_class,2);
	} elseif($star == '2.5' || $star == '3') {
		$rev_html = str_repeat($star_class,3);
	} elseif($star == '3.5' || $star == '4') {
		$rev_html = str_repeat($star_class,4);
	} elseif($star == '4.5' || $star == '5') {
		$rev_html = str_repeat($star_class,5);
	}
	return $rev_html;
}

function dateDiffInDays($date1, $date2) {
	$diff = strtotime($date2) - strtotime($date1); 
	return abs(round($diff / 86400)); 
}

function get_model_upto_price($model_id, $model_price) {
	$return_array = array();
	$upto_price_arr = array();
	$upto_price_arr[] = ($model_price>0?$model_price:0);

	global $db;

	$upto_price_arr = array();
	$mc_query=mysqli_query($db,"SELECT * FROM model_catalog WHERE model_id='".$model_id."'");
	while($model_catalog_data=mysqli_fetch_assoc($mc_query)) {
		if($model_catalog_data['conditions']) {
			$ps_condition_items_array = json_decode($model_catalog_data['conditions'],true);
			if(!empty($ps_condition_items_array)) {
				foreach($ps_condition_items_array as $con_k=>$con_v) {
					$upto_price_arr[] = $con_v;
				}
			}
		}
	}

	$return_array['price'] = !empty($upto_price_arr)?max($upto_price_arr):0;
	return $return_array;
}

function get_random_mix_token($length)
{
    $token = "";
    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
    $codeAlphabet .= "0123456789";
    $max = strlen($codeAlphabet);

    for($i=0; $i < $length; $i++) {
        $token .= $codeAlphabet[random_int(0, $max-1)];
    }
    return $token;
}

function get_bonus_data_list() {
	global $db;

	$resp_arr = array();
	$b_query = mysqli_query($db,"SELECT * FROM bonus_management WHERE status = '1' ORDER BY percentage DESC");
	while($bonus_data = mysqli_fetch_assoc($b_query)) {
		$resp_arr[] = $bonus_data;
	}
	return $resp_arr;
}

function get_order_reports($user_id = 0, $contractor_id = 0) {
	global $db;
	
	$resp_arr = array();
	
	$mysql_q_params = "";
	if($contractor_id>0) {
		$mysql_q_params .= " AND ca.contractor_id='".$contractor_id."'";
	}
	if($user_id>0) {
		$mysql_q_params .= " AND o.user_id='".$user_id."'";
	}
	
	$query=mysqli_query($db,"SELECT COUNT(*) AS num_of_orders, o.order_id, u.first_name, u.last_name, ca.contractor_id, ca.order_id, ca.amount as c_amount FROM orders AS o LEFT JOIN users AS u ON u.id=o.user_id LEFT JOIN contractor_orders AS ca ON o.order_id=ca.order_id WHERE o.status!='partial'".$mysql_q_params."");
	$num_of_order_rows = mysqli_num_rows($query);
	$resp_arr['num_of_order_rows'] = $num_of_order_rows;
	
	$aw_spmt_order_status_dt = get_order_status_data('order_status','waiting-shipment')['data'];
	$aw_spmt_order_status_id = $aw_spmt_order_status_dt['id'];

	$awaiting_o_q=mysqli_query($db,"SELECT o.*, ca.contractor_id, ca.order_id, ca.amount as c_amount FROM orders AS o LEFT JOIN contractor_orders AS ca ON o.order_id=ca.order_id WHERE o.status!='partial' AND o.is_payment_sent='0' AND o.is_trash='0' AND o.status='".$aw_spmt_order_status_id."'".$mysql_q_params."");
	$num_of_awaiting_orders = mysqli_num_rows($awaiting_o_q);
	$resp_arr['num_of_awaiting_orders'] = $num_of_awaiting_orders;
	
	$unpaid_o_q=mysqli_query($db,"SELECT o.*, ca.contractor_id, ca.order_id, ca.amount as c_amount FROM orders AS o LEFT JOIN contractor_orders AS ca ON o.order_id=ca.order_id WHERE o.status!='partial' AND o.is_payment_sent='0' AND o.is_trash='0' AND o.status!='".$aw_spmt_order_status_id."'".$mysql_q_params."");
	$num_of_unpaid_orders = mysqli_num_rows($unpaid_o_q);
	$resp_arr['num_of_unpaid_orders'] = $num_of_unpaid_orders;
	
	$paid_o_q=mysqli_query($db,"SELECT o.*, ca.contractor_id, ca.order_id, ca.amount as c_amount FROM orders AS o LEFT JOIN contractor_orders AS ca ON o.order_id=ca.order_id WHERE o.status!='partial' AND o.is_payment_sent='1' AND o.is_trash='0'".$mysql_q_params."");
	$num_of_paid_orders = mysqli_num_rows($paid_o_q);
	$resp_arr['num_of_paid_orders'] = $num_of_paid_orders;
	
	$archive_o_q=mysqli_query($db,"SELECT o.*, ca.contractor_id, ca.order_id, ca.amount as c_amount FROM orders AS o LEFT JOIN contractor_orders AS ca ON o.order_id=ca.order_id WHERE o.status!='partial' AND o.is_trash='1'".$mysql_q_params."");
	$num_of_archive_orders = mysqli_num_rows($archive_o_q);
	$resp_arr['num_of_archive_orders'] = $num_of_archive_orders;

	return $resp_arr;
}

function get_bonus_data_info() {
	global $db;

	$query = mysqli_query($db,"SELECT SUM(oi.quantity) AS total_quantity FROM order_items AS oi LEFT JOIN orders AS o ON o.order_id=oi.order_id WHERE o.status!='partial' AND oi.status='paid'");
	$data = mysqli_fetch_assoc($query);
	$total_quantity = $data['total_quantity'];

	$b_query = mysqli_query($db,"SELECT * FROM bonus_management WHERE status = '1' AND paid_device<='".$total_quantity."' ORDER BY percentage DESC");
	$bonus_data = mysqli_fetch_assoc($b_query);

	$return_dt['total_quantity'] = $total_quantity;
	$return_dt['bonus_data'] = $bonus_data;
	return $return_dt;
}

function get_bonus_data_info_by_user($user_id) {
	global $db;

	$query = mysqli_query($db,"SELECT SUM(oi.quantity) AS total_quantity FROM order_items AS oi LEFT JOIN orders AS o ON o.order_id=oi.order_id WHERE o.user_id='".$user_id."' AND o.status!='partial' AND oi.status='paid'");
	$data = mysqli_fetch_assoc($query);
	$total_quantity = $data['total_quantity'];

	$b_query = mysqli_query($db,"SELECT * FROM bonus_management WHERE status = '1' AND paid_device<='".$total_quantity."' ORDER BY percentage DESC");
	$bonus_data = mysqli_fetch_assoc($b_query);

	$return_dt['total_quantity'] = $total_quantity;
	$return_dt['bonus_data'] = $bonus_data;
	return $return_dt;
}

function get_curl_data($url)
{
	$ch = curl_init();
	$timeout = 5;
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);

	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}

function format_time_without_timezone($date) {
	$data=get_general_setting_data();
	$time_format=$data['time_format'];
	$_format="H:i";
	if($time_format=="12_hour") {
		$_format="g:i a";
	}
	return date($_format,strtotime($date));
}

function get_store_location_list($id = '', $shipping_type = "") {
	global $db;
	$response = array();
	$query = mysqli_query($db,"SELECT * FROM locations WHERE published='1' AND (id='".$id."' OR shipping_type='".$shipping_type."') ORDER BY ordering ASC");
	$num_of_rows = mysqli_num_rows($query);
	if($num_of_rows>0) {
		while($review_data = mysqli_fetch_assoc($query)) {
			$response[] = $review_data;
		}
	}
	return $response;
}

//Get order complete page data
function get_order_complete_page_data($type) {
	global $db;
	$query=mysqli_query($db,"SELECT * FROM order_complete_pages WHERE type='".$type."'");
	return mysqli_fetch_assoc($query);
}
?>