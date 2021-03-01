<?php
//Redirect http to https url with 301
if(empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off") {
    $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('HTTP/1.1 301 Moved Permanently');
    header('Location:' . $redirect);
    exit();
}

// Basic config, general files
require_once("../admin/_config/config.php");
error_reporting(E_ERROR | E_PARSE);

define('chatbot_folder_nm','external/');
define('amount_sign_with_prefix',$amount_sign_with_prefix);
define('amount_sign_with_postfix',$amount_sign_with_postfix);

$page = '';
if(isset($_GET['page'])) {
    $page = $_GET['page'];
}

// get list of categories
$type = isset($_GET['type']) ? $_GET['type'] : '';
if($type && $type == 'list') {
    $list = get_categories_list($db, $page);

    $data['version'] = 'v2';
    $data['content'] = [
        'messages'=>[
            0=>[
                'type'=>'text',
                'text'=>$page?'More...':'Which device type do you have? Please select a choice from below. ',
                'buttons'=>[],
            ],
        ],
        'actions'=>[],
        'quick_replies'=>$list
    ];

    header('HTTP/1.1 200 OK');
    header("Content-type: application/json; charset=UTF-8");
    echo json_encode($data);
    exit;
}

// get list of brands
if(isset($_GET['cat_id']) && !isset($_GET['brand_id'])) {
	$cat = $_GET['cat_id'];

    $list = get_brands_list($db, $cat, $page);
    $name = get_category_name_by_id($db, $cat);

    $data['version'] = 'v2';
    $data['content'] = [
        'messages'=>[
            0=>[
                'type'=>'text',
                'text'=>$page?'More...':'Which brand is your '.$name,
            ],
        ],
        'actions'=>[],
        'quick_replies'=>$list
    ]; 
    
	header('HTTP/1.1 200 OK');
    header("Content-type: application/json; charset=UTF-8");
    echo json_encode($data);
    exit;
}

// get list of models
if(isset($_GET['cat_id']) && isset($_GET['brand_id'])) {
    $cat = $_GET['cat_id'];
    $brand = $_GET['brand_id'];

    $list = get_models_list($db, $cat, $brand, $page);
    $name = get_brand_name_by_id($db, $brand);

    $data['version'] = 'v2';
    $data['content'] = [
        'messages'=>[
            0=>[
                'type'=>'text',
                'text'=>$page?'More...':'Which model is your '.$name,
                'buttons'=>[],
            ],
        ],
        'actions'=>[],
        'quick_replies'=>$list
    ];

    header('HTTP/1.1 200 OK');
    header("Content-type: application/json; charset=UTF-8");
    echo json_encode($data);
    exit;
}

if(isset($_GET['model'])) {
    $model_id = $_GET['model'];
	$fields_id = (isset($_GET['fields_id'])?$_GET['fields_id']:'');
//error_log($fields_id);
    $model_data = get_model_by_id($db, $model_id);
	$fields_cat_type = $model_data->fields_cat_type;
	
	$model_fields_data = get_model_fields_data($db, $model_id, $page, $fields_cat_type, $fields_id);
	$list = $model_fields_data['res'];
	$text_msg = $model_fields_data['text_msg'];

    if($list) {
        $data['version'] = 'v2';
        $data['content'] = [
            'messages'=>[
                0=>[
                    'type'=>'text',
                    'text'=>$page?'More...':$text_msg,
                    'buttons'=>[],
                ],
            ],
            'actions'=>[],
            'quick_replies'=>$list
        ];

        header('HTTP/1.1 200 OK');
        header("Content-type: application/json; charset=UTF-8");
        echo json_encode($data);
        exit;
    } else {
        get_instant_fields_sell_info($db, $model_id, $fields_id, $page, $fields_cat_type);
    } 
}

function get_model_fields_data($db, $model_id, $page, $fields_cat_type, $fields_id) {
	$field_name_arr = array();
	$dt_field_type = '';
	$text_msg = '';

	error_log('Selected Field: '.$fields_id);
	$fields_id_arr = explode('-',$fields_id);
	if(!empty($fields_id_arr) && trim($fields_id)) {
		foreach($fields_id_arr as $fields_id_dt) {
			$fields_id_sub_arr = explode(':',$fields_id_dt);
			if(!empty($fields_id_sub_arr[0]) && !empty($fields_id_sub_arr[1])) {
				$field_name = $fields_id_sub_arr[0];
				$field_id = $fields_id_sub_arr[1];
				$field_name_arr[] = $fields_id_sub_arr[0];
			}
		}
	}

	if(empty($field_name_arr)) {
		if($fields_cat_type == "mobile") {
			$dt_field_type = 'network';
			$text_msg = 'Network';
			$sql = 'SELECT * FROM models_networks WHERE model_id='.$model_id.' ORDER BY id ASC';
		} elseif($fields_cat_type == "tablet" || $fields_cat_type == "watch") {
			$dt_field_type = 'connectivity';
			$text_msg = 'Connectivity';
			$sql = 'SELECT * FROM models_connectivity WHERE model_id='.$model_id.' ORDER BY id ASC';
		} elseif($fields_cat_type == "laptop" || $fields_cat_type == "other") {
			$dt_field_type = 'model';
			$text_msg = 'Model';
			$sql = 'SELECT * FROM models_model WHERE model_id='.$model_id.' ORDER BY id ASC';
		}
	} elseif(!in_array('network',$field_name_arr) && $fields_cat_type == "mobile") {
		$dt_field_type = 'network';
		$text_msg = 'Network';
		$sql = 'SELECT * FROM models_networks WHERE model_id='.$model_id.' ORDER BY id ASC';
	} elseif(!in_array('connectivity',$field_name_arr) && ($fields_cat_type == "tablet" || $fields_cat_type == "watch")) {
		$dt_field_type = 'connectivity';
		$text_msg = 'Connectivity';
		$sql = 'SELECT * FROM models_connectivity WHERE model_id='.$model_id.' ORDER BY id ASC';
	} elseif(!in_array('case_size',$field_name_arr) && $fields_cat_type == "watch") {
		$dt_field_type = 'case_size';
		$text_msg = 'Case Size';
		$sql = 'SELECT * FROM models_case_size WHERE model_id='.$model_id.' ORDER BY id ASC';
	} elseif(!in_array('model',$field_name_arr) && ($fields_cat_type == "laptop" || $fields_cat_type == "watch" || $fields_cat_type == "other")) {
		$dt_field_type = 'model';
		$text_msg = 'Model';
		$sql = 'SELECT * FROM models_model WHERE model_id='.$model_id.' ORDER BY id ASC';
	} elseif(!in_array('processor',$field_name_arr) && $fields_cat_type == "laptop") {
		$dt_field_type = 'processor';
		$text_msg = 'Processor';
		$sql = 'SELECT * FROM models_processor WHERE model_id='.$model_id.' ORDER BY id ASC';
	} elseif(!in_array('ram',$field_name_arr) && $fields_cat_type == "laptop") {
		$dt_field_type = 'ram';
		$text_msg = 'Ram';
		$sql = 'SELECT * FROM models_ram WHERE model_id='.$model_id.' ORDER BY id ASC';
	} elseif(!in_array('storage',$field_name_arr) && ($fields_cat_type == "mobile" || $fields_cat_type == "tablet" || $fields_cat_type == "laptop")) {
		$dt_field_type = 'storage';
		$text_msg = 'Storage';
		$sql = 'SELECT * FROM models_storage WHERE model_id='.$model_id.' ORDER BY id ASC';
	} elseif(!in_array('graphics_card',$field_name_arr) && $fields_cat_type == "laptop") {
		$dt_field_type = 'graphics_card';
		$text_msg = 'Graphics Card';
		$sql = 'SELECT * FROM models_graphics_card WHERE model_id='.$model_id.' ORDER BY id ASC';
	} elseif(!in_array('condition',$field_name_arr)) {
		$dt_field_type = 'condition';
		$text_msg = 'Condition';
		$sql = 'SELECT * FROM models_condition WHERE model_id='.$model_id.' ORDER BY id ASC';
	} elseif(!in_array('band_included',$field_name_arr) && $fields_cat_type == "watch") {
		$dt_field_type = 'band_included';
		$text_msg = 'Band Included';
		$sql = 'SELECT * FROM models_band_included WHERE model_id='.$model_id.' ORDER BY id ASC';
	} elseif(!in_array('accessories',$field_name_arr)) {
		$dt_field_type = 'accessories';
		$text_msg = 'Accessories';
		$sql = 'SELECT * FROM models_accessories WHERE model_id='.$model_id.' ORDER BY id ASC';
	}

	error_log('Field Type: '.$dt_field_type);
	if($dt_field_type) {
		if($page) {
			$results_per_page = 9;
			$start_from = ($page-1) * $results_per_page;
			$sql .= ' LIMIT '.$start_from.', '.$results_per_page;
		} else {
			$sql .= ' LIMIT 9';
		}
		$result = mysqli_query($db, $sql);
	
		$res = [];
	
		if($page && $page != 1 && mysqli_num_rows($result) == 0 ) {
			$npage = $page && $page > 1?$page-1:1;
			$prev = [
				'type'=>'dynamic_block_callback',
				'caption'=> 'See previous',
				'url'=> SITE_URL.chatbot_folder_nm.'manychatbotapi.php?model='.$model_id.'&page='.$npage,
				'method'=>'GET',
			];
			array_push($res, $prev);
		} elseif($page && $page != 1 && mysqli_num_rows($result) > 0 && mysqli_num_rows($result) == 9) {
			$npage = $page && $page > 1?$page-1:1;
			$prev = [
				'type'=>'dynamic_block_callback',
				'caption'=> 'See previous',
				'url'=> SITE_URL.chatbot_folder_nm.'manychatbotapi.php?model='.$model_id.'&page='.$npage,
				'method'=>'GET',
			];
			array_push($res, $prev);
		}
	
		if(mysqli_num_rows($result) > 0) {
			// Output data of each row
			while($row = mysqli_fetch_assoc($result)) {
				
				$l_field_id = '';
				$caption_name = '';
				if($dt_field_type == "network") {
					$l_field_id = '-network:'.$row['id'];
					$caption_name = $row['network_name'];
				} elseif($dt_field_type == "storage") {
					$l_field_id = '-storage:'.$row['id'];
					$caption_name = $row['storage_size'].$row['storage_size_postfix'];
				} elseif($dt_field_type == "condition") {
					$l_field_id = '-condition:'.$row['id'];
					$caption_name = $row['condition_name'];
				} elseif($dt_field_type == "band_included") {
					$l_field_id = '-band_included:'.$row['id'];
					$caption_name = $row['band_included_name'];
				} elseif($dt_field_type == "accessories") {
					$l_field_id = '-accessories:'.$row['id'];
					$caption_name = $row['accessories_name'];
				} elseif($dt_field_type == "connectivity") {
					$l_field_id = '-connectivity:'.$row['id'];
					$caption_name = $row['connectivity_name'];
				} elseif($dt_field_type == "model") {
					$l_field_id = '-model:'.$row['id'];
					$caption_name = $row['model_name'];
				} elseif($dt_field_type == "processor") {
					$l_field_id = '-processor:'.$row['id'];
					$caption_name = $row['processor_name'];
				} elseif($dt_field_type == "case_size") {
					$l_field_id = '-case_size:'.$row['id'];
					$caption_name = $row['case_size'];
				} elseif($dt_field_type == "ram") {
					$l_field_id = '-ram:'.$row['id'];
					$caption_name = $row['ram_size'].$row['ram_size_postfix'];
				} elseif($dt_field_type == "graphics_card") {
					$l_field_id = '-graphics_card:'.$row['id'];
					$caption_name = $row['graphics_card_name'];
				}
				
				$f_fields_id = $fields_id.$l_field_id;
				error_log('f_fields_id:'.$f_fields_id);
				$res[] = [
					'type'=>'dynamic_block_callback',
					'caption'=> $caption_name,
					'url'=> SITE_URL.chatbot_folder_nm.'manychatbotapi.php?field2=1&model='.$model_id.'&fields_id='.$f_fields_id,
					'method'=>'GET',
				];
			}
		}
	
		if(mysqli_num_rows($result) > 0 && mysqli_num_rows($result) == 9) {
			$npage = $page?$page+1:2;
			$more = [
				'type'=>'dynamic_block_callback',
				'caption'=> 'More',
				'url'=> SITE_URL.chatbot_folder_nm.'manychatbotapi.php?model='.$model_id.'&page='.$npage,
				'method'=>'GET',
			];
			array_push($res, $more);
		} elseif($page && mysqli_num_rows($result) > 0 && mysqli_num_rows($result) < 9) {
			$npage = $page && $page > 1?$page-1:1;
			$prev = [
				'type'=>'dynamic_block_callback',
				'caption'=> 'See previous',
				'url'=> SITE_URL.chatbot_folder_nm.'manychatbotapi.php?model='.$model_id.'&page='.$npage,
				'method'=>'GET',
			];
			array_push($res, $prev);
		}

		$resp_arr = array();
		if($res) {
			$resp_arr['res'] = $res;
			$resp_arr['dt_field_type'] = $dt_field_type;
			$resp_arr['text_msg'] = $text_msg;
			return $resp_arr;
		}
	}
    return [];
}

function get_instant_fields_sell_info($db, $model_id, $fields_id, $page, $fields_cat_type) {
    error_log($model_id.' = '.$fields_id.' = '.$page.' = '.$fields_cat_type);
	$model_data = get_model_by_id($db, $model_id);
	
	$model_image = '';
	$f_device_nm = '';

	if($model_data->model_img) {
		$m_image_path = SITE_URL.'images/mobile/'.trim($model_data->model_img);
		if($m_image_path != '') {
			$model_image = $m_image_path;
		}
	}

	$field_name_arr = array();
	$field_id_arr = array();
	$fields_id_arr = explode('-',$fields_id);
	if(!empty($fields_id_arr) && trim($fields_id)) {
		foreach($fields_id_arr as $fields_id_dt) {
			$fields_id_sub_arr = explode(':',$fields_id_dt);
			if(!empty($fields_id_sub_arr[0]) && !empty($fields_id_sub_arr[1])) {
				//$field_name_arr[] = $fields_id_sub_arr[0];
				$field_id_arr[$fields_id_sub_arr[0]] = $fields_id_sub_arr[1];
			}
		}
	}

	error_log(json_encode($field_id_arr));

	if(!empty($field_id_arr)) {
		$model_fields_dt = array();
		$condition_id = $field_id_arr['condition'];
		$network_id = $field_id_arr['network'];
		$storage_id = $field_id_arr['storage'];
		$connectivity_id = $field_id_arr['connectivity'];
		$model_fld_id = $field_id_arr['model'];
		$processor_id = $field_id_arr['processor'];
		$case_size_id = $field_id_arr['case_size'];
		$ram_id = $field_id_arr['ram'];
		$graphics_card_id = $field_id_arr['graphics_card'];
		$band_included_id = $field_id_arr['band_included'];
		$accessories_id = $field_id_arr['accessories'];
	
		$n_q = mysqli_query($db,"SELECT * FROM models_networks WHERE model_id='".$model_id."' AND id='".$network_id."'");
		$models_networks_data = mysqli_fetch_assoc($n_q);
		$model_fields_dt['network'] = $models_networks_data['network_name'];
		
		$s_q = mysqli_query($db,"SELECT * FROM models_storage WHERE model_id='".$model_id."' AND id='".$storage_id."'");
		$models_storage_data = mysqli_fetch_assoc($s_q);
		$model_fields_dt['storage'] = $models_storage_data['storage_size'].$models_storage_data['storage_size_postfix'];
		
		$c_q = mysqli_query($db,"SELECT * FROM models_connectivity WHERE model_id='".$model_id."' AND id='".$connectivity_id."'");
		$models_connectivity_data = mysqli_fetch_assoc($c_q);
		$model_fields_dt['connectivity'] = $models_connectivity_data['connectivity_name'];
		
		$cnd_q = mysqli_query($db,"SELECT * FROM models_condition WHERE model_id='".$model_id."' AND id='".$condition_id."'");
		$models_condition_data = mysqli_fetch_assoc($cnd_q);
		$model_fields_dt['condition'] = $models_condition_data['condition_name'];
		
		$mdl_q = mysqli_query($db,"SELECT * FROM models_model WHERE model_id='".$model_id."' AND id='".$model_fld_id."'");
		$models_model_data = mysqli_fetch_assoc($mdl_q);
		$model_fields_dt['model'] = $models_model_data['model_name'];
		
		$cs_q = mysqli_query($db,"SELECT * FROM models_case_size WHERE model_id='".$model_id."' AND id='".$case_size_id."'");
		$models_case_size_data = mysqli_fetch_assoc($cs_q);
		$model_fields_dt['case_size'] = $models_case_size_data['case_size'];
		
		$rm_q = mysqli_query($db,"SELECT * FROM models_ram WHERE model_id='".$model_id."' AND id='".$ram_id."'");
		$models_ram_data = mysqli_fetch_assoc($rm_q);
		$model_fields_dt['ram'] = $models_ram_data['ram_size'].$models_ram_data['ram_size_postfix'];
		
		$gc_q = mysqli_query($db,"SELECT * FROM models_graphics_card WHERE model_id='".$model_id."' AND id='".$graphics_card_id."'");
		$models_graphics_card_data = mysqli_fetch_assoc($gc_q);
		$model_fields_dt['graphics_card'] = $models_graphics_card_data['graphics_card_name'];
		
		$prc_q = mysqli_query($db,"SELECT * FROM models_processor WHERE model_id='".$model_id."' AND id='".$processor_id."'");
		$models_processor_data = mysqli_fetch_assoc($prc_q);
		$model_fields_dt['processor'] = $models_processor_data['processor_name'];
		
		$bi_q = mysqli_query($db,"SELECT * FROM models_band_included WHERE model_id='".$model_id."' AND id='".$band_included_id."'");
		$models_band_included_data = mysqli_fetch_assoc($bi_q);
		$model_fields_dt['band_included'] = $models_band_included_data['band_included_name'];
	
		$acce_q = mysqli_query($db,"SELECT * FROM models_accessories WHERE model_id='".$model_id."' AND id='".$accessories_id."'");
		$models_accessories_data = mysqli_fetch_assoc($acce_q);
		$model_fields_dt['accessories'] = $models_accessories_data['accessories_name'];
	
		//error_log($fields_cat_type.'kkk'.json_encode($model_fields_dt));
	
		$device_nm = '';
		if($fields_cat_type == "mobile") {
			$storage = ($model_fields_dt['storage']?$model_fields_dt['storage']:"N/A");
			$network = ($model_fields_dt['network']?$model_fields_dt['network']:"N/A");
			if($condition_id && $storage && $network) {
			    //error_log("SELECT * FROM model_catalog WHERE model_id='".$model_id."' AND network='".$network."' AND storage='".$storage."'");
				$mc_query=mysqli_query($db,"SELECT * FROM model_catalog WHERE model_id='".$model_id."' AND network='".$network."' AND storage='".$storage."'");
				$model_catalog_data=mysqli_fetch_assoc($mc_query);
			}
		}
		elseif($fields_cat_type == "tablet") {
			$storage = ($model_fields_dt['storage']?$model_fields_dt['storage']:"N/A");
			$connectivity = ($model_fields_dt['connectivity']?$model_fields_dt['connectivity']:"N/A");
			if($condition_id && $storage && $connectivity) {
				$mc_query=mysqli_query($db,"SELECT * FROM model_catalog WHERE model_id='".$model_id."' AND connectivity='".$connectivity."' AND storage='".$storage."'");
				$model_catalog_data=mysqli_fetch_assoc($mc_query);
			}
		}
		elseif($fields_cat_type == "watch") {
			$connectivity = ($model_fields_dt['connectivity']?$model_fields_dt['connectivity']:"N/A");
			$case_size = ($model_fields_dt['case_size']?$model_fields_dt['case_size']:"N/A");
			$model = ($model_fields_dt['model']?$model_fields_dt['model']:"N/A");
			if($condition_id && $connectivity && $case_size && $model) {
				$mc_query=mysqli_query($db,"SELECT * FROM model_catalog WHERE model_id='".$model_id."' AND model='".$model."' AND connectivity='".$connectivity."' AND case_size='".$case_size."'");
				$model_catalog_data=mysqli_fetch_assoc($mc_query);
			}
		}
		elseif($fields_cat_type == "laptop") {
			$storage = ($model_fields_dt['storage']?$model_fields_dt['storage']:"N/A");
			$processor = ($model_fields_dt['processor']?$model_fields_dt['processor']:"N/A");
			$model = ($model_fields_dt['model']?$model_fields_dt['model']:"N/A");
			$ram = ($model_fields_dt['ram']?$model_fields_dt['ram']:"N/A");
			$graphics_card = ($model_fields_dt['graphics_card']?$model_fields_dt['graphics_card']:"N/A");
			if($condition_id && $storage && $processor && $model && $ram && $graphics_card) {
				$mc_query=mysqli_query($db,"SELECT * FROM model_catalog WHERE model_id='".$model_id."' AND processor='".$processor."' AND storage='".$storage."' AND model='".$model."' AND ram='".$ram."' AND graphics_card='".$graphics_card."'");
				$model_catalog_data=mysqli_fetch_assoc($mc_query);
			}
		}
		elseif($fields_cat_type == "other") {
			$model = ($model_fields_dt['model']?$model_fields_dt['model']:"N/A");
			if($condition_id && $model) {
				$mc_query=mysqli_query($db,"SELECT * FROM model_catalog WHERE model_id='".$model_id."' AND model='".$model."'");
				$model_catalog_data=mysqli_fetch_assoc($mc_query);
			}
		}
		
		$final_model_amt = 0;
		if($model_catalog_data['conditions']) {
			$ps_condition_items_array = json_decode($model_catalog_data['conditions'],true);
			if($ps_condition_items_array[$model_fields_dt['condition']]) {
				$final_model_amt = $ps_condition_items_array[$model_fields_dt['condition']];
			}
		}
		
		if(!empty($models_band_included_data) && $models_band_included_data['band_included_price'] > 0) {
			$final_model_amt += $models_band_included_data['band_included_price'];
		}
		if(!empty($models_accessories_data) && $models_accessories_data['accessories_price'] > 0) {
			$final_model_amt += $models_accessories_data['accessories_price'];
		}
		
		if($final_model_amt > 0) {
			$device_nm .= ', Price: '.amount_sign_with_prefix.$final_model_amt.amount_sign_with_postfix;
		}

		if($model_fields_dt['network']) {
			$device_nm .= ', Network: '.$model_fields_dt['network'];
		}
		if($model_fields_dt['connectivity']) {
			$device_nm .= ', Connectivity: '.$model_fields_dt['connectivity'];
		}
		if($model_fields_dt['case_size']) {
			$device_nm .= ', Case Size: '.$model_fields_dt['case_size'];
		}
		if($model_fields_dt['model']) {
			$device_nm .= ', Model: '.$model_fields_dt['model'];
		}
		if($model_fields_dt['processor']) {
			$device_nm .= ', Processor: '.$model_fields_dt['processor'];
		}
		if($model_fields_dt['ram']) {
			$device_nm .= ', Ram: '.$model_fields_dt['ram'];
		}
		if($model_fields_dt['storage']) {
			$device_nm .= ', Storage: '.$model_fields_dt['storage'];
		}
		if($model_fields_dt['graphics_card']) {
			$device_nm .= ', Graphics Card: '.$model_fields_dt['graphics_card'];
		}
		if($model_fields_dt['condition']) {
			$device_nm .= ', Condition: '.$model_fields_dt['condition'];
		}
		if($model_fields_dt['band_included']) {
			$device_nm .= ', Band Included: '.$model_fields_dt['band_included'];
		}
		if($model_fields_dt['accessories']) {
			$device_nm .= ', Accessories: '.$model_fields_dt['accessories'];
		}
		$f_device_nm = $device_nm;
		$f_device_nm = strip_tags($f_device_nm);
		$f_device_nm = ltrim($f_device_nm,', ');
		
		$btn_caption = 'Sell Now';
		$btn_url = SITE_URL.'controllers/model.php?model_id='.$model_data->id.'&price='.$final_model_amt.'&fields_id='.$fields_id.'&external_fb_chatbot_sell_device=yes';
	} else {
		$btn_caption = 'Sell Now';
		$btn_url = SITE_URL.$model_details_page_slug.$model_data->sef_url;
	}

    $data['version'] = 'v2';
    $data['content'] = [
        'messages'=>[
            0=>[
                'type'=>'cards',
                'elements'=>[
                    0=>[
                        'title'=>$model_data->title,
                        'subtitle'=>$f_device_nm,
                        'image_url'=>$model_image,
                        'action_url'=>'#',
                        'buttons'=>[
                            0=>[
                                'type'=>'url',
                                'caption'=>$btn_caption,
                                'url'=>$btn_url,
                            ]
                        ]
                    ]
                ],
                "image_aspect_ratio"=> "horizontal",
            ],
        ],
        'actions'=>[],
        'quick_replies'=>[
            0=>[
                'type'=>'dynamic_block_callback',
                'caption'=> 'Start again',
                'url'=> SITE_URL.chatbot_folder_nm.'manychatbotapi.php?type=list',
                'method'=>'GET',
            ]
        ]
    ];
    header('HTTP/1.1 200 OK');
    header("Content-type: application/json; charset=UTF-8");
    echo json_encode($data);
    exit;
}


// Functions list started...
function get_categories_list($db, $page) {
    $sql = 'SELECT * FROM `categories` where published = 1 ORDER BY ordering ASC';
    if($page) {
        $results_per_page = 10;
        $start_from = ($page-1) * $results_per_page;
        $sql .= ' LIMIT '.$start_from.', '.$results_per_page;
    }else {
        $sql .= ' LIMIT 10';
    }
    $result = mysqli_query($db, $sql);

    $res = [];
     
    if(mysqli_num_rows($result) > 0) {
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $res[] = [
                'type'=>'dynamic_block_callback',
                'caption'=> ucfirst($row['title']),
                'url'=> SITE_URL.chatbot_folder_nm.'manychatbotapi.php?cat_id='.$row['id'],
                'method'=>'GET',
            ];
        }
    }
    
    if(mysqli_num_rows($result) > 0 && mysqli_num_rows($result) == 10) {
        $npage = $page?$page+1:2;
        $more = [
            'type'=>'dynamic_block_callback',
            'caption'=> 'More',
            'url'=> SITE_URL.chatbot_folder_nm.'manychatbotapi.php?type=list&page='.$npage,
            'method'=>'GET',
        ];
        array_push($res, $more);
    } elseif($page && mysqli_num_rows($result) > 0 && mysqli_num_rows($result) < 10) {
        $npage = $page && $page > 1?$page-1:1;
        $prev = [
            'type'=>'dynamic_block_callback',
            'caption'=> 'See previous',
            'url'=> SITE_URL.chatbot_folder_nm.'manychatbotapi.php?type=list&page='.$npage,
            'method'=>'GET',
        ];
        array_push($res, $prev);
    }
    
    if($res) {
        return $res;
    }
    return [];
}

function get_brands_list($db, $cat_id, $page) {
    $sql = "SELECT b.* FROM `mobile` as m LEFT JOIN brand as b ON b.id = m.brand_id WHERE m.cat_id = '".$cat_id."' AND m.brand_id > 0 AND b.published=1 GROUP BY b.id ORDER BY b.ordering ASC";
    if($page) {
        $results_per_page = 10;
        $start_from = ($page-1) * $results_per_page;
        $sql .= ' LIMIT '.$start_from.', '.$results_per_page;
    }else {
        $sql .= ' LIMIT 10';
    }

    $result = mysqli_query($db, $sql);
    $res = [];
     
    if(mysqli_num_rows($result) > 0) {
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $n = get_brand_name_by_id($db, $row['id']);
            $res[] = [
                'type'=>'dynamic_block_callback',
                'caption'=> $n,
                'url'=> SITE_URL.chatbot_folder_nm.'manychatbotapi.php?cat_id='.$cat_id.'&brand_id='.$row['id'],
                'method'=>'GET',
            ];
        }
    }

    if(mysqli_num_rows($result) > 0 && mysqli_num_rows($result) == 10) {
        $npage = $page?$page+1:2;
        $more = [
            'type'=>'dynamic_block_callback',
            'caption'=> 'More',
            'url'=> SITE_URL.chatbot_folder_nm.'manychatbotapi.php?cat_id='.$cat_id.'&page='.$npage,
            'method'=>'GET',
        ];
        array_push($res, $more);
    } elseif($page && mysqli_num_rows($result) > 0 && mysqli_num_rows($result) < 10) {
        $npage = $page && $page > 1?$page-1:1;
        $prev = [
            'type'=>'dynamic_block_callback',
            'caption'=> 'See previous',
            'url'=> SITE_URL.chatbot_folder_nm.'manychatbotapi.php?cat_id='.$cat_id.'&page='.$npage,
            'method'=>'GET',
        ];
        array_push($res, $prev);
    }
    
    if($res) {
        return $res;
    }
    return [];
}

function get_models_list($db, $cat_id, $brand_id, $page) {
    $sql = 'SELECT * FROM `mobile` WHERE cat_id = "'.$cat_id.'" and brand_id = "'.$brand_id.'" AND published = 1 ';
    if($page) {
        $results_per_page = 9;
        $start_from = ($page-1) * $results_per_page;
        $sql .= ' LIMIT '.$start_from.', '.$results_per_page;
    }else {
        $sql .= ' LIMIT 9';
    }
    
    $result = mysqli_query($db, $sql);
    
    $res = [];
    
    if($page && $page != 1 && mysqli_num_rows($result) == 0 ) {
        $npage = $page && $page > 1?$page-1:1;
        $prev = [
            'type'=>'dynamic_block_callback',
            'caption'=> 'See previous',
            'url'=> SITE_URL.chatbot_folder_nm.'manychatbotapi.php?cat_id='.$cat_id.'&brand_id='.$brand_id.'&page='.$npage,
            'method'=>'GET',
        ];
        array_push($res, $prev);
    }
    
    if($page && $page != 1 && mysqli_num_rows($result) > 0 && mysqli_num_rows($result) == 9) {
        $npage = $page && $page > 1?$page-1:1;
        $prev = [
            'type'=>'dynamic_block_callback',
            'caption'=> 'See previous',
            'url'=> SITE_URL.chatbot_folder_nm.'manychatbotapi.php?cat_id='.$cat_id.'&brand_id='.$brand_id.'&page='.$npage,
            'method'=>'GET',
        ];
        array_push($res, $prev);
    }
    
    if(mysqli_num_rows($result) > 0) {
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $res[] = [
                'type'=>'dynamic_block_callback',
                'caption'=> $row['title'],
                'url'=> SITE_URL.chatbot_folder_nm.'manychatbotapi.php?model='.$row['id'],
                'method'=>'GET',
            ];
        }
    }
    
    if(mysqli_num_rows($result) > 0 && mysqli_num_rows($result) == 9) {
        $npage = $page?$page+1:2;
        $more = [
            'type'=>'dynamic_block_callback',
            'caption'=> 'More',
            'url'=> SITE_URL.chatbot_folder_nm.'manychatbotapi.php?cat_id='.$cat_id.'&brand_id='.$brand_id.'&page='.$npage,
            'method'=>'GET',
        ];
        array_push($res, $more);
    } elseif($page && mysqli_num_rows($result) > 0 && mysqli_num_rows($result) < 9) {
        $npage = $page && $page > 1?$page-1:1;
        $prev = [
            'type'=>'dynamic_block_callback',
            'caption'=> 'See previous',
            'url'=> SITE_URL.chatbot_folder_nm.'manychatbotapi.php?cat_id='.$cat_id.'&brand_id='.$brand_id.'&page='.$npage,
            'method'=>'GET',
        ];
        array_push($res, $prev);
    }
    
    if($res) {
        return $res;
    }
    return [];
}

function get_brand_name_by_id($db, $id) {
    $result = mysqli_query($db, "SELECT * FROM `brand` WHERE id = ".$id." ");
    $row = mysqli_fetch_row($result);
    if($row) {
        return $row[1];
    }
}

function get_category_name_by_id($db, $id) {
    $result = mysqli_query($db, "SELECT * FROM `categories` WHERE id = ".$id." ");
    $row = mysqli_fetch_row($result);
    if($row) {
        return $row[1];
    }
}

function get_model_by_id($db, $id) {
    $result = mysqli_query($db, "SELECT m.*, c.fields_type AS fields_cat_type FROM `mobile` AS m LEFT JOIN categories AS c ON c.id=m.cat_id WHERE m.id = ".$id."");
    $row = mysqli_fetch_object($result);
    if($row) {
        return $row;
    }
}
?>