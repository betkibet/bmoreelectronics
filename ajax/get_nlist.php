<?php
require_once("../admin/_config/config.php");
require_once("../admin/include/functions.php");
require_once("common.php");

$method=$post['m'];
if($method=="") {
	echo '<strong>No Data Found</strong>';
} else {
	if($method=="brand_list") {
		$device_category_id = $post['device_category_id'];
		if($device_category_id!='' && $device_category_id>0) {
			$sql_whr = " AND m.cat_id='".$device_category_id."' AND m.brand_id>0";
			$que="SELECT m.*, d.title AS device_title, d.sef_url AS device_sef_url, b.title AS brand_title, b.image AS brand_image, b.description AS brand_desc, b.id AS brand_id FROM mobile AS m LEFT JOIN devices AS d ON d.id=m.device_id LEFT JOIN brand AS b ON b.id=m.brand_id WHERE b.published=1 ".$sql_whr." GROUP BY b.id ORDER BY b.ordering ASC";
			$brand_query=mysqli_query($db,$que);
			$brand_num_of_rows = mysqli_num_rows($brand_query);
			if($brand_num_of_rows>0) {
				echo '<ul class="clearfix">';
				while($brand_data=mysqli_fetch_assoc($brand_query)) {
					$num_query=mysqli_query($db,"SELECT d.id FROM devices AS d LEFT JOIN mobile AS m ON m.device_id=d.id LEFT JOIN brand AS b ON b.id=m.brand_id WHERE d.published=1 AND m.cat_id='".$device_category_id."' AND m.brand_id='".$brand_data['brand_id']."' AND b.id='".$brand_data['brand_id']."' GROUP BY m.device_id ORDER BY d.ordering ASC");
					$num_of_devices = mysqli_num_rows($num_query); ?>
					<li class="custom-control custom-radio custom-control-inline">
						<input type="radio" class="brand_id custom-control-input" name="brand_id" id="brand_id_<?=$brand_data['brand_id']?>" value="<?=$brand_data['brand_id']?>" data-value="<?=$brand_data['brand_title']?>" data-device_list="<?=$num_of_devices?>">
						<label for="brand_id_<?=$brand_data['brand_id']?>" class="custom-control-label">
							<div class="imgbox">
								<?php
								if($brand_data['brand_image']) {
									//$md_img_path = SITE_URL.'libraries/phpthumb.php?src='.SITE_URL.'images/brand/'.$brand_data['brand_image'].'&h=100';
									$md_img_path = SITE_URL.'images/brand/'.$brand_data['brand_image'];
									echo '<img src="'.$md_img_path.'" alt="'.$brand_data['brand_title'].'">';
								} ?>
							</div>
							<div class="btnbox"><?=$brand_data['brand_title']?></div>
						</label>
					</li>								
				<?php
				}
				echo '</ul>';
			} else {
				echo '<strong>Sorry! Brand not exist for this category</strong>';
			}
		}
	}
	elseif($method=="device_list") {
		$brand_id = $post['brand_id'];
		$device_category_id = $post['device_category_id'];
		if($brand_id!='' && $brand_id>0) {
			$que="SELECT d.* FROM devices AS d LEFT JOIN mobile AS m ON m.device_id=d.id LEFT JOIN brand AS b ON b.id=m.brand_id WHERE d.published=1 AND m.cat_id='".$device_category_id."' AND m.brand_id='".$brand_id."' AND b.id='".$brand_id."' GROUP BY m.device_id ORDER BY d.ordering ASC";
			$device_query=mysqli_query($db,$que);
			$device_num_of_rows = mysqli_num_rows($device_query);
			if($device_num_of_rows>0) {
				echo '<ul class="clearfix">';
				while($device_data=mysqli_fetch_assoc($device_query)) { ?>
					<li class="custom-control custom-radio custom-control-inline">
						<input type="radio" class="device_id custom-control-input" name="device_id" id="device_id_<?=$device_data['id']?>" value="<?=$device_data['id']?>" data-value="<?=$device_data['title']?>">
						<label for="device_id_<?=$device_data['id']?>" class="custom-control-label">
							<div class="imgbox">
							<?php
							if($device_data['device_img']) {
								//$md_img_path = SITE_URL.'libraries/phpthumb.php?src='.SITE_URL.'images/device/'.$device_data['device_img'].'&h=100';
								$md_img_path = SITE_URL.'images/device/'.$device_data['device_img'];
								echo '<img src="'.$md_img_path.'" alt="'.$device_data['title'].'">';
							} ?>
							</div>
							<div class="btnbox"><?=$device_data['title']?></div>
						</label>
					</li>								
				<?php
				}
				echo '</ul>';
			} else {
				echo '<strong>Sorry! Devices not exist for this brand</strong>';
			}
		}
	}
	elseif($method=="model_list") {
		$device_id = $post['device_id'];
		$brand_id = $post['brand_id'];
		$device_category_id = $post['device_category_id'];
		if($brand_id!='') {
		
			$mysql_p = "";
			if($device_category_id>0) {
				$mysql_p .= " AND m.cat_id='".$device_category_id."'";
			}

			if($device_id>0) {
				$mysql_p .= " AND m.device_id='".$device_id."'";
			}
			
			$q="SELECT m.*, d.title AS device_title, d.sef_url, b.title AS brand_title FROM mobile AS m LEFT JOIN devices AS d ON d.id=m.device_id LEFT JOIN brand AS b ON b.id=m.brand_id WHERE m.published=1 AND b.id='".$brand_id."' ".$mysql_p." ORDER BY m.ordering ASC";
			$query=mysqli_query($db,$q);
			
			$model_num_of_rows = mysqli_num_rows($query);
			if($model_num_of_rows>0) { ?>
				<ul class="clearfix">
					<?php
					while($model_list=mysqli_fetch_assoc($query)) {
						$md_img_path="";
						if($model_list['model_img']!='') {
							$md_img_path = SITE_URL.'images/mobile/'.trim($model_list['model_img']);
						} ?>
						<li class="custom-control custom-radio custom-control-inline">
							<input type="radio" class="device_model_id custom-control-input" name="model_id" id="model_id_<?=$model_list['id']?>" value="<?=$model_list['id']?>" data-value="<?=$model_list['title']?>" data-model_image="<?=$md_img_path?>">
							<label class="custom-control-label" for="model_id_<?=$model_list['id']?>">
								<div class="imgbox">
								<?php
								if($md_img_path!='') {
									echo '<img src="'.$md_img_path.'" alt="'.$model_list['title'].'" width="100px" height="100px">';
								} ?>
								</div>
								<div class="btnbox"><?=$model_list['title']?></div>
							</label>
						</li>
					<?php
					} ?>
				</ul>
			<?php 
			} else {
				echo '<strong>Sorry! Model not exist for this brand</strong>';
			}
		}
	}
	elseif($method=="get_model_field_list") {
		$model_id=$post['model_id'];
		$query = "SELECT m.*, d.title AS device_title, d.sef_url FROM mobile AS m LEFT JOIN devices AS d ON d.id=m.device_id WHERE m.id='".$model_id."'";
		$stmt=$db->query($query);
		$data=$stmt->fetch_object();
		
		$main_img_path=SITE_URL."images/";
		$img_path=$main_img_path."mobile/";

		if($data->model_img!=''){
			$data->image=$img_path.$data->model_img;
		}
		
		$price = $data->price;
		$total_price = $data->price;

$category_data = get_category_data($data->cat_id);
$fields_cat_type = $category_data['fields_type'];

$fields_data_array = array();

$network_items_array = get_models_networks_data($model_id);
$fields_data_array[] = array('title'=>$category_data['network_title'],'tooltip'=>$category_data['tooltip_network'],'type'=>'network','input-type'=>'radio','data'=>$network_items_array,'class'=>'network');

$connectivity_items_array = get_models_connectivity_data($model_id);
$fields_data_array[] = array('title'=>$category_data['connectivity_title'],'tooltip'=>$category_data['tooltip_connectivity'],'type'=>'connectivity','input-type'=>'radio','data'=>$connectivity_items_array);

$case_size_items_array = get_models_case_size_data($model_id);
$fields_data_array[] = array('title'=>$category_data['case_size_title'],'tooltip'=>$category_data['tooltip_case_size'],'type'=>'case_size','input-type'=>'radio','data'=>$case_size_items_array);

$model_items_array = get_models_model_data($model_id);
$fields_data_array[] = array('title'=>$category_data['model_title'],'tooltip'=>$category_data['tooltip_model'],'type'=>'model','input-type'=>'radio','data'=>$model_items_array,'class'=>'model');

$processor_items_array = get_models_processor_data($model_id);
$fields_data_array[] = array('title'=>$category_data['processor_title'],'tooltip'=>$category_data['tooltip_processor'],'type'=>'processor','input-type'=>'radio','data'=>$processor_items_array);

$ram_items_array = get_models_ram_data($model_id);
$fields_data_array[] = array('title'=>$category_data['ram_title'],'tooltip'=>$category_data['tooltip_ram'],'type'=>'ram','input-type'=>'radio','data'=>$ram_items_array);

$storage_items_array = get_models_storage_data($model_id);
$fields_data_array[] = array('title'=>$category_data['storage_title'],'tooltip'=>$category_data['tooltip_storage'],'type'=>'storage','input-type'=>'radio','data'=>$storage_items_array,'class'=>'storage');

$graphics_card_items_array = get_models_graphics_card_data($model_id);
$fields_data_array[] = array('title'=>$category_data['graphics_card_title'],'tooltip'=>$category_data['tooltip_graphics_card'],'type'=>'graphics_card','input-type'=>'radio','data'=>$graphics_card_items_array);

$condition_items_array = get_models_condition_data($model_id);
$fields_data_array[] = array('title'=>$category_data['condition_title'],'tooltip'=>$category_data['tooltip_condition'],'type'=>'condition','input-type'=>'radio','data'=>$condition_items_array,'class'=>'condition');

/*$watchtype_items_array = get_models_watchtype_data($model_id);
$fields_data_array[] = array('title'=>$category_data['type_title'],'tooltip'=>$category_data['tooltip_watchtype'],'type'=>'watchtype','input-type'=>'radio','data'=>$watchtype_items_array);

$case_material_items_array = get_models_case_material_data($model_id);
$fields_data_array[] = array('title'=>$category_data['case_material_title'],'tooltip'=>$category_data['tooltip_case_material'],'type'=>'case_material','input-type'=>'radio','data'=>$case_material_items_array);*/

$band_included_items_array = get_models_band_included_data($model_id);
$fields_data_array[] = array('title'=>$category_data['band_included_title'],'tooltip'=>$category_data['tooltip_band_included'],'type'=>'band_included','input-type'=>'checkbox','data'=>$band_included_items_array);

$accessories_items_array = get_models_accessories_data($model_id);
$fields_data_array[] = array('title'=>$category_data['accessories_title'],'tooltip'=>$category_data['tooltip_accessories'],'type'=>'accessories','input-type'=>'checkbox','data'=>$accessories_items_array,'class'=>'accessories');

$tooltips_data_array = array();

$fid=1;
$fields_list_data=array();

foreach($fields_data_array as $fields_data) {
	if(!empty($fields_data['data'])) {
		$fields_name = $fields_data['type'];
		$fields_input_type = $fields_data['input-type'];
		
		$field_data = new stdClass();
		$field_data->title = $fields_data['title'];
		$field_data->input_type = $fields_input_type;
		$field_data->is_required = 1;
		$field_data->sort_order = 0;
		$field_data->tooltip = $fields_data['tooltip'];
		$field_data->icon = '';
		$field_data->product_id = $model_id;

		//add _ to space for title 
		//$field_name=str_replace(' ','_',$fields_data['title']);
		//$field_data->field_name=$field_name;
		
		$product_options_list = array();
		if($fields_data['type'] == "storage") {
			$field_data->field_name='storage';
			foreach($fields_data['data'] as $f_d => $f_data) {
				$storage_size = $f_data['storage_size'].$f_data['storage_size_postfix'];
				
				$product_options_data = new stdClass();
				$product_options_data->id = $f_data['id'];
				$product_options_data->label = $storage_size;
				$product_options_data->add_sub = '+';
				$product_options_data->price_type = 1;
				$product_options_data->price = 0;
				$product_options_data->sort_order = 0;
				$product_options_data->is_default = 0;
				$product_options_data->tooltip = $f_data['tooltip'];
				$product_options_data->icon = $f_data['icon'];
				$product_options_data->product_field_id = '';
				$product_options_data->force_zero_price = 0;
				$product_options_data->checked = '';
				$product_options_list[] = $product_options_data;
			}
		}
		elseif($fields_data['type'] == "condition") {
			$field_data->field_name='condition';
			foreach($fields_data['data'] as $f_d => $f_data) {
				$condition_name = $f_data['condition_name'];

				if($f_data['condition_terms'] && $tooltips_of_model_fields == '1') {
					$f_data['condition_terms'] = strip_tags($f_data['condition_terms']);
				} else {
					$f_data['condition_terms'] = "";
				}

				$product_options_data = new stdClass();
				$product_options_data->id = $f_data['id'];
				$product_options_data->label = $condition_name;
				$product_options_data->add_sub = '+';
				$product_options_data->price_type = 1;
				$product_options_data->price = 0;
				$product_options_data->sort_order = 0;
				$product_options_data->is_default = 0;
				$product_options_data->tooltip = $f_data['condition_terms'];
				$product_options_data->icon = $f_data['icon'];
				$product_options_data->product_field_id = '';
				$product_options_data->force_zero_price = 0;
				$product_options_data->checked = '';
				$product_options_list[] = $product_options_data;
			}
		} elseif($fields_data['type'] == "network") {
			$field_data->field_name='network';
			foreach($fields_data['data'] as $f_d => $f_data) {
				$network_name = $f_data['network_name'];
				
				$product_options_data = new stdClass();
				$product_options_data->id = $f_data['id'];
				$product_options_data->label = $network_name;
				$product_options_data->add_sub = '+';
				$product_options_data->price_type = 1;
				$product_options_data->price = 0;
				$product_options_data->sort_order = 0;
				$product_options_data->is_default = 0;
				$product_options_data->tooltip = $f_data['tooltip'];
				$product_options_data->icon = $f_data['network_icon'];
				$product_options_data->product_field_id = '';
				$product_options_data->force_zero_price = 0;
				$product_options_data->checked = '';
				$product_options_list[] = $product_options_data;
			}
		} elseif($fields_data['type'] == "connectivity") {
			$field_data->field_name='connectivity';
			foreach($fields_data['data'] as $f_d => $f_data) {
				$connectivity_name = $f_data['connectivity_name'];
				
				$product_options_data = new stdClass();
				$product_options_data->id = $f_data['id'];
				$product_options_data->label = $connectivity_name;
				$product_options_data->add_sub = '+';
				$product_options_data->price_type = 1;
				$product_options_data->price = 0;
				$product_options_data->sort_order = 0;
				$product_options_data->is_default = 0;
				$product_options_data->tooltip = $f_data['tooltip'];
				$product_options_data->icon = $f_data['icon'];
				$product_options_data->product_field_id = '';
				$product_options_data->force_zero_price = 0;
				$product_options_data->checked = '';
				$product_options_list[] = $product_options_data;
			}
		} elseif($fields_data['type'] == "case_size") {
			$field_data->field_name='case_size';
			foreach($fields_data['data'] as $f_d => $f_data) {
				$case_size_name = $f_data['case_size'];
				
				$product_options_data = new stdClass();
				$product_options_data->id = $f_data['id'];
				$product_options_data->label = $case_size_name;
				$product_options_data->add_sub = '+';
				$product_options_data->price_type = 1;
				$product_options_data->price = 0;
				$product_options_data->sort_order = 0;
				$product_options_data->is_default = 0;
				$product_options_data->tooltip = $f_data['tooltip'];
				$product_options_data->icon = $f_data['icon'];
				$product_options_data->product_field_id = '';
				$product_options_data->force_zero_price = 0;
				$product_options_data->checked = '';
				$product_options_list[] = $product_options_data;
			}
		} elseif($fields_data['type'] == "model") {
			$field_data->field_name='model';
			foreach($fields_data['data'] as $f_d => $f_data) {
				$model_name = $f_data['model_name'];
				
				$product_options_data = new stdClass();
				$product_options_data->id = $f_data['id'];
				$product_options_data->label = $model_name;
				$product_options_data->add_sub = '+';
				$product_options_data->price_type = 1;
				$product_options_data->price = 0;
				$product_options_data->sort_order = 0;
				$product_options_data->is_default = 0;
				$product_options_data->tooltip = $f_data['tooltip'];
				$product_options_data->icon = $f_data['icon'];
				$product_options_data->product_field_id = '';
				$product_options_data->force_zero_price = 0;
				$product_options_data->checked = '';
				$product_options_list[] = $product_options_data;
			}
		} elseif($fields_data['type'] == "processor") {
			$field_data->field_name='processor';
			foreach($fields_data['data'] as $f_d => $f_data) {
				$processor_name = $f_data['processor_name'];
				
				$product_options_data = new stdClass();
				$product_options_data->id = $f_data['id'];
				$product_options_data->label = $processor_name;
				$product_options_data->add_sub = '+';
				$product_options_data->price_type = 1;
				$product_options_data->price = 0;
				$product_options_data->sort_order = 0;
				$product_options_data->is_default = 0;
				$product_options_data->tooltip = $f_data['tooltip'];
				$product_options_data->icon = $f_data['icon'];
				$product_options_data->product_field_id = '';
				$product_options_data->force_zero_price = 0;
				$product_options_data->checked = '';
				$product_options_list[] = $product_options_data;
			}
		}
		elseif($fields_data['type'] == "ram") {
			$field_data->field_name='ram';
			foreach($fields_data['data'] as $f_d => $f_data) {
				$ram_size = $f_data['ram_size'].$f_data['ram_size_postfix'];
				
				$product_options_data = new stdClass();
				$product_options_data->id = $f_data['id'];
				$product_options_data->label = $ram_size;
				$product_options_data->add_sub = '+';
				$product_options_data->price_type = 1;
				$product_options_data->price = 0;
				$product_options_data->sort_order = 0;
				$product_options_data->is_default = 0;
				$product_options_data->tooltip = $f_data['tooltip'];
				$product_options_data->icon = $f_data['icon'];
				$product_options_data->product_field_id = '';
				$product_options_data->force_zero_price = 0;
				$product_options_data->checked = '';
				$product_options_list[] = $product_options_data;
			}
		}
		elseif($fields_data['type'] == "graphics_card") {
			$field_data->field_name='graphics_card';
			foreach($fields_data['data'] as $f_d => $f_data) {
				$graphics_card_name = $f_data['graphics_card_name'];
				
				$product_options_data = new stdClass();
				$product_options_data->id = $f_data['id'];
				$product_options_data->label = $graphics_card_name;
				$product_options_data->add_sub = '+';
				$product_options_data->price_type = 1;
				$product_options_data->price = 0;
				$product_options_data->sort_order = 0;
				$product_options_data->is_default = 0;
				$product_options_data->tooltip = $f_data['tooltip'];
				$product_options_data->icon = $f_data['icon'];
				$product_options_data->product_field_id = '';
				$product_options_data->force_zero_price = 0;
				$product_options_data->checked = '';
				$product_options_list[] = $product_options_data;
			}
		}
		elseif($fields_data['type']=="band_included") {
			$field_data->field_name='band_included';
			foreach($fields_data['data'] as $f_d => $f_data) {
				$checked = '';
				$chk_lab = $f_data['band_included_name'];
				$chk_id = $f_data['id'];
				
				$product_options_data = new stdClass();
				$product_options_data->id = $f_data['id'];
				$product_options_data->label = $chk_lab;
				$product_options_data->add_sub = '+';
				$product_options_data->price_type = 1;
				$product_options_data->price = 0;
				$product_options_data->sort_order = 0;
				$product_options_data->is_default = 0;
				$product_options_data->tooltip = $f_data['tooltip'];
				$product_options_data->icon = $f_data['icon'];
				$product_options_data->product_field_id = '';
				$product_options_data->force_zero_price = 0;
				$product_options_data->checked = '';
				$product_options_list[] = $product_options_data;
			}
		}
		elseif($fields_data['type']=="accessories") {
			$field_data->field_name='accessories';
			foreach($fields_data['data'] as $f_d => $f_data) {
				$checked = '';
				$chk_lab = $f_data['accessories_name'];
				$chk_id = $f_data['id'];
				
				$product_options_data = new stdClass();
				$product_options_data->id = $f_data['id'];
				$product_options_data->label = $chk_lab;
				$product_options_data->add_sub = '+';
				$product_options_data->price_type = 1;
				$product_options_data->price = 0;
				$product_options_data->sort_order = 0;
				$product_options_data->is_default = 0;
				$product_options_data->tooltip = $f_data['tooltip'];
				$product_options_data->icon = $f_data['icon'];
				$product_options_data->product_field_id = '';
				$product_options_data->force_zero_price = 0;
				$product_options_data->checked = '';
				$product_options_list[] = $product_options_data;
			}
		}
		
		$field_data->product_options_list=$product_options_list;
		$fields_list_data[] = $field_data;
	}
}

		$data->fields_list_data=$fields_list_data;
		$data->total_price=$total_price;
		$data->fields_cat_type=$fields_cat_type;

		//echo '<pre>';
		//print_r($data);
		//print_r($fields_list_data);
		//exit;
		//END

		$response["data"] = $data;
		$response["error"] = false;
		$response['status'] = 'success';
		echoResponse(200, $response);
	} else {
		die('Invalid request');
	}
} 

function echoResponse($status_code='',$response='') {
	header('Content-Type: application/json');
    echo json_encode($response);
	http_response_code($status_code);
	exit();
}

function updatePrice_for_model_fields($thisprice='',$add_sub='',$price_type='',$total_price='',$price='') {
	if($price_type==0) {
		$temp_price = ($price*$thisprice)/100;
	} else {
		$temp_price = $thisprice;
	}
	
	if($add_sub=="+") {
		$total_price = $total_price + $temp_price;
	} else {
		$total_price = $total_price - $temp_price;
	}
	return $total_price;
}
?>