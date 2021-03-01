<?php
require_once("../_config/config.php");
require_once("../include/functions.php");
require_once("common.php");

//Url params
$req_model_id=$post['model_id'];
if($req_model_id>0) {

//Fetching data from model
require_once('../../models/model.php');

//Get data from models/model.php, get_single_model_data function
$model_data = get_single_model_data($req_model_id);

$fields_cat_type = $model_data['fields_cat_type'];
$category_data = get_category_data($model_data['cat_id']);

$edit_item_id = $post['item_id'];
$order_item_data = array();
if($edit_item_id>0) {
	$order_item_data = get_order_item($edit_item_id,'');
	$order_item_data = $order_item_data['data'];
}
if($order_item_data['model_id']!=$req_model_id) {
	$order_item_data = array();
}

$fld_id_array = array();
$item_name_array = json_decode($order_item_data['item_name'],true);
if(!empty($item_name_array)) {
	foreach($item_name_array as $ei_k => $item_name_data) {
		$fld_id_array[] = $ei_k;
		$items_opt_name = "";
		foreach($item_name_data['opt_data'] as $opt_data) {
			if($opt_data['opt_id']>0) {
				$items_opt_name .= $opt_data['opt_name'].', ';
				$opt_id_array[] = $opt_data['opt_id'];
			} else {
				$items_opt_name .= $opt_data['opt_name'].', ';
			}
		}
		$opt_name_array[$ei_k] .= rtrim($items_opt_name,', ');		
	}
}

$image_name_array = json_decode($order_item_data['images'],true);
if(!empty($image_name_array)) {
	foreach($image_name_array as $eim_k => $image_name_data) {
		$fld_id_array[] = $eim_k;
		$opt_name_array[$eim_k] = $image_name_data['img_name'];
	}
}

$fields_data_array = array();

$network_items_array = get_models_networks_data($req_model_id);
$fields_data_array[] = array('title'=>$category_data['network_title'],'tooltip'=>$category_data['tooltip_network'],'type'=>'network','input-type'=>'radio','data'=>$network_items_array);

$connectivity_items_array = get_models_connectivity_data($req_model_id);
$fields_data_array[] = array('title'=>$category_data['connectivity_title'],'tooltip'=>$category_data['tooltip_connectivity'],'type'=>'connectivity','input-type'=>'radio','data'=>$connectivity_items_array);

$case_size_items_array = get_models_case_size_data($req_model_id);
$fields_data_array[] = array('title'=>$category_data['case_size_title'],'tooltip'=>$category_data['tooltip_case_size'],'type'=>'case_size','input-type'=>'radio','data'=>$case_size_items_array);

$model_items_array = get_models_model_data($req_model_id);
$fields_data_array[] = array('title'=>$category_data['model_title'],'tooltip'=>$category_data['tooltip_model'],'type'=>'model','input-type'=>'radio','data'=>$model_items_array);

$processor_items_array = get_models_processor_data($req_model_id);
$fields_data_array[] = array('title'=>$category_data['processor_title'],'tooltip'=>$category_data['tooltip_processor'],'type'=>'processor','input-type'=>'radio','data'=>$processor_items_array);

$ram_items_array = get_models_ram_data($req_model_id);
$fields_data_array[] = array('title'=>$category_data['ram_title'],'tooltip'=>$category_data['tooltip_ram'],'type'=>'ram','input-type'=>'radio','data'=>$ram_items_array);

$storage_items_array = get_models_storage_data($req_model_id);
$fields_data_array[] = array('title'=>$category_data['storage_title'],'tooltip'=>$category_data['tooltip_storage'],'type'=>'storage','input-type'=>'radio','data'=>$storage_items_array);

$graphics_card_items_array = get_models_graphics_card_data($req_model_id);
$fields_data_array[] = array('title'=>$category_data['graphics_card_title'],'tooltip'=>$category_data['tooltip_graphics_card'],'type'=>'graphics_card','input-type'=>'radio','data'=>$graphics_card_items_array);

$condition_items_array = get_models_condition_data($req_model_id);
$fields_data_array[] = array('title'=>$category_data['condition_title'],'tooltip'=>$category_data['tooltip_condition'],'type'=>'condition','input-type'=>'radio','data'=>$condition_items_array);

/*$watchtype_items_array = get_models_watchtype_data($req_model_id);
$fields_data_array[] = array('title'=>$category_data['type_title'],'tooltip'=>$category_data['tooltip_watchtype'],'type'=>'watchtype','input-type'=>'radio','data'=>$watchtype_items_array);

$case_material_items_array = get_models_case_material_data($req_model_id);
$fields_data_array[] = array('title'=>$category_data['case_material_title'],'tooltip'=>$category_data['tooltip_case_material'],'type'=>'case_material','input-type'=>'radio','data'=>$case_material_items_array);*/

$band_included_items_array = get_models_band_included_data($req_model_id);
$fields_data_array[] = array('title'=>$category_data['band_included_title'],'tooltip'=>$category_data['tooltip_band_included'],'type'=>'band_included','input-type'=>'checkbox','data'=>$band_included_items_array);

$accessories_items_array = get_models_accessories_data($req_model_id);
$fields_data_array[] = array('title'=>$category_data['accessories_title'],'tooltip'=>$category_data['tooltip_accessories'],'type'=>'accessories','input-type'=>'checkbox','data'=>$accessories_items_array);

require_once("../../include/custom_js.php");
?>

<link href="css/edit-order.css?u=<?=unique_id()?>" rel="stylesheet" type="text/css" />
<script src="<?=SITE_URL?>js/front.js"></script>

<div class="row phone-details">
	<div class="col-md-12">
		<h3><strong><?=$model_data['title']?></strong></h3>
		<h4><strong><span class="show_final_amt"><?=amount_format_without_sign($total_price)?></span></strong></h4>

		<input type="hidden" name="base_price" value="<?=$price?>" />
		<div class="modern-text" id="device-prop-area">
			<?php
			$tooltips_data_array = array();
			
			$fid=1;

			foreach($fields_data_array as $fields_data) {
				if(!empty($fields_data['data'])) {
				$fields_name = $fields_data['type'];
				$fields_input_type = $fields_data['input-type'];
				
				$nn = $nn+1;
				$last_next_button = "";
				if($no_of_fields == $nn) {
					$last_next_button = "yes";
				}

				if($edit_item_id > 0) {
					$class = "selected";
				} elseif(in_array($fields_name,$fld_id_array)) {
					$class = "selected";
				} elseif($fid==1) {
					$class = "opened";
				} else {
					$class = "disabled";
				} ?>

				<div class="modern-text__row capacity-base-row modern-block__row <?=$class?> clearfix" data-row_type="<?=$fields_input_type?>" data-required="1">
					<span class="modern-text__area">
						<span class="modern-text__num">
							<b class="modern-num"><?=$fid?></b>
							<b data-toggle="tooltip" title="Edit" class="modern-selected needhelp"></b>
						</span>
						<span class="modern-text__title">
							<?=$fields_data['title']?>
						</span>
						<?php
						/*if($fields_data['tooltip']!="" && $tooltips_of_model_fields == '1') {
							$tooltips_data_array[] = array('tooltip'=>$fields_data['tooltip'], 'id'=>'p'.$fields_name, 'name'=>$fields_data['title']); ?>
							<span class="tips" data-toggle="modal" data-target="#info_popup<?='p'.$fields_name?>">?</span>
						<?php
						}*/ ?>
					</span>
					<div id="capacities" class="modern-block__content block-content-base">
						<?php
						if($fields_data['type'] == "storage") { ?>
							<div class="option_value_outer radio_select_buttons clearfix">
								<?php
								foreach($fields_data['data'] as $f_d => $f_data) {
								
									$storage_size = $f_data['storage_size'].$f_data['storage_size_postfix'];

									$checked = '';
									$sel_class = "";
									$tab_sel_class = "false";
									$tab_sel__content_class = "";
									
									if($storage_size == $item_name_array['storage']['opt_data']['0']['opt_name']) {
										$checked = 'checked';
										$sel_class = "sel";
										$tab_sel_class = "true";
										$tab_sel__content_class = "active";
									} ?>
									<span class="options_values">
										<?php 
										if($f_data['tooltip']!="" && $tooltips_of_model_fields == '1') {
											$tooltips_data_array[] = array('tooltip'=>$f_data['tooltip'], 'id'=>$f_data['id'], 'name'=>$storage_size); ?>
											<p class="text-center mb-0"><span class="tooltip-text" data-toggle="modal" data-target="#info_popup<?=$f_data['id']?>"><i class="fa fa-info-circle" aria-hidden="true"></i></span></p>
										<?php
										} ?>
										<button data-issubmit="<?=$last_next_button?>" class="capacity-row btn btn-outline-info btn-sm <?=$sel_class?> radio_btn" type="button" href="#<?=$fid.'_'.$oid?>_tab" data-toggle="tab" aria-expanded="<?=$tab_sel_class?>" data-input-type="<?=$fields_input_type?>">
										<?php
										if($f_data['icon']!="" && $icons_of_model_fields == '1') {
											echo '<img src="/images/'.$f_data['icon'].'" width="50px" id="'.$f_data['id'].'" /><br />';
										}
										echo $storage_size; ?></button>
										<input class="radioele" name="storage" value="<?=$storage_size?>" <?=$checked?> type="radio" style="display:none;" data-default="0" />
									</span>
								<?php
								$oid++;
								} ?>
							</div>
							<span class="text-danger"></span>
						<?php
						}
						elseif($fields_data['type'] == "condition") { ?>
							<div class="option_value_outer radio_select_buttons clearfix">
								<?php
								foreach($fields_data['data'] as $f_d => $f_data) {
								
									$condition_name = $f_data['condition_name'];

									$checked = '';
									$sel_class = "";
									$tab_sel_class = "false";
									$tab_sel__content_class = "";
									
									if($condition_name == $item_name_array['condition']['opt_data']['0']['opt_name']) {
										$checked = 'checked';
										$sel_class = "sel";
										$tab_sel_class = "true";
										$tab_sel__content_class = "active";
									} ?>
									<span class="options_values">
										<?php 
										if($f_data['tooltip']!="" && $tooltips_of_model_fields == '1') {
											$tooltips_data_array[] = array('tooltip'=>$f_data['tooltip'], 'id'=>$f_data['id'], 'name'=>$condition_name); ?>
											<p class="text-center mb-0"><span class="tooltip-text" data-toggle="modal" data-target="#info_popup<?=$f_data['id']?>"><i class="fa fa-info-circle" aria-hidden="true"></i></span></p>
										<?php
										} ?>
										<button data-issubmit="<?=$last_next_button?>" class="capacity-row btn btn-outline-info btn-sm <?=$sel_class?> radio_btn" type="button" href="#<?=$fid.'_'.$oid?>_tab" data-toggle="tab" aria-expanded="<?=$tab_sel_class?>" data-input-type="<?=$fields_input_type?>">
										<?php
										if($f_data['icon']!="" && $icons_of_model_fields == '1') {
											echo '<img src="/images/'.$f_data['icon'].'" width="50px" id="'.$f_data['id'].'" /><br />';
										}
										echo $condition_name; ?></button>
										<input class="radioele" name="condition" value="<?=$condition_name?>" <?=$checked?> type="radio" style="display:none;" data-default="0" />
									</span>
								<?php
								$oid++;
								} ?>
							</div>
							<span class="text-danger"></span>
						<?php
						} elseif($fields_data['type'] == "network") { ?>
							<div class="option_value_outer radio_select_buttons clearfix">
								<?php
								foreach($fields_data['data'] as $f_d => $f_data) {
								
									$network_name = $f_data['network_name'];

									$checked = '';
									$sel_class = "";
									$tab_sel_class = "false";
									$tab_sel__content_class = "";
									
									if($network_name == $item_name_array['network']['opt_data']['0']['opt_name']) {
										$checked = 'checked';
										$sel_class = "sel";
										$tab_sel_class = "true";
										$tab_sel__content_class = "active";
									} ?>
									<span class="options_values">
										<?php 
										if($f_data['tooltip']!="" && $tooltips_of_model_fields == '1') {
											$tooltips_data_array[] = array('tooltip'=>$f_data['tooltip'], 'id'=>$f_data['id'], 'name'=>$network_name); ?>
											<p class="text-center mb-0"><span class="tooltip-text" data-toggle="modal" data-target="#info_popup<?=$f_data['id']?>"><i class="fa fa-info-circle" aria-hidden="true"></i></span></p>
										<?php
										} ?>
										<button data-issubmit="<?=$last_next_button?>" class="capacity-row btn btn-outline-info btn-sm <?=$sel_class?> radio_btn" type="button" href="#<?=$fid.'_'.$oid?>_tab" data-toggle="tab" aria-expanded="<?=$tab_sel_class?>" data-input-type="<?=$fields_input_type?>">
										<?php
										if($f_data['network_icon']!="" && $icons_of_model_fields == '1') {
											echo '<img src="'.SITE_URL.'images/network/'.$f_data['network_icon'].'" width="50px" id="'.$f_data['id'].'" /><br />';
										}
										echo $network_name; ?></button>
										<input class="radioele" name="network" value="<?=$network_name?>" <?=$checked?> type="radio" style="display:none;" data-default="0" />
									</span>
								<?php
								$oid++;
								} ?>
							</div>
							<span class="text-danger"></span>
						<?php
						} elseif($fields_data['type'] == "connectivity") { ?>
							<div class="option_value_outer radio_select_buttons clearfix">
								<?php
								foreach($fields_data['data'] as $f_d => $f_data) {
								
									$connectivity_name = $f_data['connectivity_name'];

									$checked = '';
									$sel_class = "";
									$tab_sel_class = "false";
									$tab_sel__content_class = "";
									
									if($connectivity_name == $item_name_array['connectivity']['opt_data']['0']['opt_name']) {
										$checked = 'checked';
										$sel_class = "sel";
										$tab_sel_class = "true";
										$tab_sel__content_class = "active";
									} ?>
									<span class="options_values">
										<?php 
										if($f_data['tooltip']!="" && $tooltips_of_model_fields == '1') {
											$tooltips_data_array[] = array('tooltip'=>$f_data['tooltip'], 'id'=>$f_data['id'], 'name'=>$connectivity_name); ?>
											<p class="text-center mb-0"><span class="tooltip-text" data-toggle="modal" data-target="#info_popup<?=$f_data['id']?>"><i class="fa fa-info-circle" aria-hidden="true"></i></span></p>
										<?php
										} ?>
										<button data-issubmit="<?=$last_next_button?>" class="capacity-row btn btn-outline-info btn-sm <?=$sel_class?> radio_btn" type="button" href="#<?=$fid.'_'.$oid?>_tab" data-toggle="tab" aria-expanded="<?=$tab_sel_class?>" data-input-type="<?=$fields_input_type?>">
										<?php
										if($f_data['icon']!="" && $icons_of_model_fields == '1') {
											echo '<img src="/images/'.$f_data['icon'].'" width="50px" id="'.$f_data['id'].'" /><br />';
										}
										echo $connectivity_name; ?></button>
										<input class="radioele" name="connectivity" value="<?=$connectivity_name?>" <?=$checked?> type="radio" style="display:none;" data-default="0" />
									</span>
								<?php
								$oid++;
								} ?>
							</div>
							<span class="text-danger"></span>
						<?php
						} elseif($fields_data['type'] == "case_size") { ?>
							<div class="option_value_outer radio_select_buttons clearfix">
								<?php
								foreach($fields_data['data'] as $f_d => $f_data) {
								
									$case_size_name = $f_data['case_size'];

									$checked = '';
									$sel_class = "";
									$tab_sel_class = "false";
									$tab_sel__content_class = "";
									
									if($case_size_name == $item_name_array['case_size']['opt_data']['0']['opt_name']) {
										$checked = 'checked';
										$sel_class = "sel";
										$tab_sel_class = "true";
										$tab_sel__content_class = "active";
									} ?>
									<span class="options_values">
										<?php 
										if($f_data['tooltip']!="" && $tooltips_of_model_fields == '1') {
											$tooltips_data_array[] = array('tooltip'=>$f_data['tooltip'], 'id'=>$f_data['id'], 'name'=>$case_size_name); ?>
											<p class="text-center mb-0"><span class="tooltip-text" data-toggle="modal" data-target="#info_popup<?=$f_data['id']?>"><i class="fa fa-info-circle" aria-hidden="true"></i></span></p>
										<?php
										} ?>
										<button data-issubmit="<?=$last_next_button?>" class="capacity-row btn btn-outline-info btn-sm <?=$sel_class?> radio_btn" type="button" href="#<?=$fid.'_'.$oid?>_tab" data-toggle="tab" aria-expanded="<?=$tab_sel_class?>" data-input-type="<?=$fields_input_type?>">
										<?php
										if($f_data['icon']!="" && $icons_of_model_fields == '1') {
											echo '<img src="/images/'.$f_data['icon'].'" width="50px" id="'.$f_data['id'].'" /><br />';
										}
										echo $case_size_name; ?></button>
										<input class="radioele" name="case_size" value="<?=$case_size_name?>" <?=$checked?> type="radio" style="display:none;" data-default="0" />
									</span>
								<?php
								$oid++;
								} ?>
							</div>
							<span class="text-danger"></span>
						<?php
						} elseif($fields_data['type'] == "model") { ?>
							<div class="option_value_outer radio_select_buttons clearfix">
								<?php
								foreach($fields_data['data'] as $f_d => $f_data) {
								
									$model_name = $f_data['model_name'];

									$checked = '';
									$sel_class = "";
									$tab_sel_class = "false";
									$tab_sel__content_class = "";
									
									if($model_name == $item_name_array['model']['opt_data']['0']['opt_name']) {
										$checked = 'checked';
										$sel_class = "sel";
										$tab_sel_class = "true";
										$tab_sel__content_class = "active";
									} ?>
									<span class="options_values">
										<?php 
										if($f_data['tooltip']!="" && $tooltips_of_model_fields == '1') {
											$tooltips_data_array[] = array('tooltip'=>$f_data['tooltip'], 'id'=>$f_data['id'], 'name'=>$model_name); ?>
											<p class="text-center mb-0"><span class="tooltip-text" data-toggle="modal" data-target="#info_popup<?=$f_data['id']?>"><i class="fa fa-info-circle" aria-hidden="true"></i></span></p>
										<?php
										} ?>
										<button data-issubmit="<?=$last_next_button?>" class="capacity-row btn btn-outline-info btn-sm <?=$sel_class?> radio_btn" type="button" href="#<?=$fid.'_'.$oid?>_tab" data-toggle="tab" aria-expanded="<?=$tab_sel_class?>" data-input-type="<?=$fields_input_type?>">
										<?php
										if($f_data['icon']!="" && $icons_of_model_fields == '1') {
											echo '<img src="/images/'.$f_data['icon'].'" width="50px" id="'.$f_data['id'].'" /><br />';
										}
										echo $model_name; ?></button>
										<input class="radioele" name="model" value="<?=$model_name?>" <?=$checked?> type="radio" style="display:none;" data-default="0" />
									</span>
								<?php
								$oid++;
								} ?>
							</div>
							<span class="text-danger"></span>
						<?php
						} elseif($fields_data['type'] == "processor") { ?>
							<div class="option_value_outer radio_select_buttons clearfix">
								<?php
								foreach($fields_data['data'] as $f_d => $f_data) {
								
									$processor_name = $f_data['processor_name'];

									$checked = '';
									$sel_class = "";
									$tab_sel_class = "false";
									$tab_sel__content_class = "";
									
									if($processor_name == $item_name_array['processor']['opt_data']['0']['opt_name']) {
										$checked = 'checked';
										$sel_class = "sel";
										$tab_sel_class = "true";
										$tab_sel__content_class = "active";
									} ?>
									<span class="options_values">
										<?php 
										if($f_data['tooltip']!="" && $tooltips_of_model_fields == '1') {
											$tooltips_data_array[] = array('tooltip'=>$f_data['tooltip'], 'id'=>$f_data['id'], 'name'=>$processor_name); ?>
											<p class="text-center mb-0"><span class="tooltip-text" data-toggle="modal" data-target="#info_popup<?=$f_data['id']?>"><i class="fa fa-info-circle" aria-hidden="true"></i></span></p>
										<?php
										} ?>
										<button data-issubmit="<?=$last_next_button?>" class="capacity-row btn btn-outline-info btn-sm <?=$sel_class?> radio_btn" type="button" href="#<?=$fid.'_'.$oid?>_tab" data-toggle="tab" aria-expanded="<?=$tab_sel_class?>" data-input-type="<?=$fields_input_type?>">
										<?php
										if($f_data['icon']!="" && $icons_of_model_fields == '1') {
											echo '<img src="/images/'.$f_data['icon'].'" width="50px" id="'.$f_data['id'].'" /><br />';
										}
										echo $processor_name; ?></button>
										<input class="radioele" name="processor" value="<?=$processor_name?>" <?=$checked?> type="radio" style="display:none;" data-default="0" />
									</span>
								<?php
								$oid++;
								} ?>
							</div>
							<span class="text-danger"></span>
						<?php
						}
						elseif($fields_data['type'] == "ram") { ?>
							<div class="option_value_outer radio_select_buttons clearfix">
								<?php
								foreach($fields_data['data'] as $f_d => $f_data) {
								
									$ram_size = $f_data['ram_size'].$f_data['ram_size_postfix'];

									$checked = '';
									$sel_class = "";
									$tab_sel_class = "false";
									$tab_sel__content_class = "";
									
									if($ram_size == $item_name_array['ram']['opt_data']['0']['opt_name']) {
										$checked = 'checked';
										$sel_class = "sel";
										$tab_sel_class = "true";
										$tab_sel__content_class = "active";
									} ?>
									<span class="options_values">
										<?php 
										if($f_data['tooltip']!="" && $tooltips_of_model_fields == '1') {
											$tooltips_data_array[] = array('tooltip'=>$f_data['tooltip'], 'id'=>$f_data['id'], 'name'=>$ram_size); ?>
											<p class="text-center mb-0"><span class="tooltip-text" data-toggle="modal" data-target="#info_popup<?=$f_data['id']?>"><i class="fa fa-info-circle" aria-hidden="true"></i></span></p>
										<?php
										} ?>
										<button data-issubmit="<?=$last_next_button?>" class="capacity-row btn btn-outline-info btn-sm <?=$sel_class?> radio_btn" type="button" href="#<?=$fid.'_'.$oid?>_tab" data-toggle="tab" aria-expanded="<?=$tab_sel_class?>" data-input-type="<?=$fields_input_type?>">
										<?php
										if($f_data['icon']!="" && $icons_of_model_fields == '1') {
											echo '<img src="/images/'.$f_data['icon'].'" width="50px" id="'.$f_data['id'].'" /><br />';
										}
										echo $ram_size; ?></button>
										<input class="radioele" name="ram" value="<?=$ram_size?>" <?=$checked?> type="radio" style="display:none;" data-default="0" />
									</span>
								<?php
								$oid++;
								} ?>
							</div>
							<span class="text-danger"></span>
						<?php
						}
						elseif($fields_data['type'] == "graphics_card") { ?>
							<div class="option_value_outer radio_select_buttons clearfix">
								<?php
								foreach($fields_data['data'] as $f_d => $f_data) {
								
									$graphics_card_name = $f_data['graphics_card_name'];

									$checked = '';
									$sel_class = "";
									$tab_sel_class = "false";
									$tab_sel__content_class = "";
									
									if($graphics_card_name == $item_name_array['graphics_card']['opt_data']['0']['opt_name']) {
										$checked = 'checked';
										$sel_class = "sel";
										$tab_sel_class = "true";
										$tab_sel__content_class = "active";
									} ?>
									<span class="options_values">
										<?php 
										if($f_data['tooltip']!="" && $tooltips_of_model_fields == '1') {
											$tooltips_data_array[] = array('tooltip'=>$f_data['tooltip'], 'id'=>$f_data['id'], 'name'=>$graphics_card_name); ?>
											<p class="text-center mb-0"><span class="tooltip-text" data-toggle="modal" data-target="#info_popup<?=$f_data['id']?>"><i class="fa fa-info-circle" aria-hidden="true"></i></span></p>
										<?php
										} ?>
										<button data-issubmit="<?=$last_next_button?>" class="capacity-row btn btn-outline-info btn-sm <?=$sel_class?> radio_btn" type="button" href="#<?=$fid.'_'.$oid?>_tab" data-toggle="tab" aria-expanded="<?=$tab_sel_class?>" data-input-type="<?=$fields_input_type?>">
										<?php
										if($f_data['icon']!="" && $icons_of_model_fields == '1') {
											echo '<img src="/images/'.$f_data['icon'].'" width="50px" id="'.$f_data['id'].'" /><br />';
										}
										echo $graphics_card_name; ?></button>
										<input class="radioele" name="graphics_card" value="<?=$graphics_card_name?>" <?=$checked?> type="radio" style="display:none;" data-default="0" />
									</span>
								<?php
								$oid++;
								} ?>
							</div>
							<span class="text-danger"></span>
						<?php
						}
						elseif($fields_data['type']=="band_included") {
							$oid=1; ?>
							<div class="form-group checkboxes">
							<?php
							$bni_opt_id_array = array();
							if(!empty($item_name_array['band_included']['opt_data'])) {
								foreach($item_name_array['band_included']['opt_data'] as $opt_data) {
									if($opt_data['opt_id']>0) {
										$bni_opt_id_array[] = $opt_data['opt_id'];
									}
								}
							}
							
							foreach($fields_data['data'] as $f_d => $f_data) {
							
								$checked = '';
								$chk_lab = $f_data['band_included_name'];
								$chk_id = $f_data['id'];
								
								if(in_array($f_data['id'],$bni_opt_id_array)) {
									$checked = 'checked';
								} ?>
								<span class="options_values form-group form-group-checkbox">
									<?php
									if($f_data['tooltip']!="" && $tooltips_of_model_fields == '1') {
										$tooltips_data_array[] = array('tooltip'=>$f_data['tooltip'], 'id'=>$f_data['id'], 'name'=>$chk_lab); ?>
										<span class="tooltip-text" data-toggle="modal" data-target="#info_popup<?=$f_data['id']?>"><i class="fa fa-info-circle" aria-hidden="true"></i></span>
									<?php
									} ?>
									<div class="checkbox checkbox-success">
										<label class="m-checkbox" for="<?=$chk_lab?>"><input class="checkboxele" name="band_included[]" id="<?=$chk_lab?>" <?=$checked?> value="<?=$chk_lab.':'.$f_data['id']?>" type="checkbox" data-default="0">
											<span class="checkmark"></span><?=$chk_lab?>
										</label>
									</div>
									<?php 
									if($f_data['icon']!="" && $icons_of_model_fields == '1') {
										echo '<img src="/images/'.$f_data['icon'].'" width="30px" id="'.$f_data['id'].'" />';
									}
									?>
								</span>
							<?php
							} ?>
							</div>
							<a href="#" class="capacity-row btn btn-sm btn-primary m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air" data-issubmit="<?=$last_next_button?>">Next</a>
							<span class="text-danger"></span>
						<?php
						}
						elseif($fields_data['type']=="accessories") {
							$oid=1; ?>
							<div class="form-group checkboxes">
							<?php
							$acc_opt_id_array = array();
							if(!empty($item_name_array['accessories']['opt_data'])) {
								foreach($item_name_array['accessories']['opt_data'] as $opt_data) {
									if($opt_data['opt_id']>0) {
										$acc_opt_id_array[] = $opt_data['opt_id'];
									}
								}
							}

							foreach($fields_data['data'] as $f_d => $f_data) {
							
								$checked = '';
								$chk_lab = $f_data['accessories_name'];
								$chk_id = $f_data['id'];

								if(in_array($f_data['id'],$acc_opt_id_array)) {
									$checked = 'checked';
								} ?>
								<span class="options_values form-group form-group-checkbox">
									<?php
									if($f_data['tooltip']!="" && $tooltips_of_model_fields == '1') {
										$tooltips_data_array[] = array('tooltip'=>$f_data['tooltip'], 'id'=>$f_data['id'], 'name'=>$chk_lab); ?>
										<span class="tooltip-text" data-toggle="modal" data-target="#info_popup<?=$f_data['id']?>"><i class="fa fa-info-circle" aria-hidden="true"></i></span>
									<?php
									} ?>
									<div class="checkbox checkbox-success">
										<label class="m-checkbox" for="<?=$chk_lab?>"><input class="checkboxele" name="accessories[]" id="<?=$chk_lab?>" <?=$checked?> value="<?=$chk_lab.':'.$f_data['id']?>" type="checkbox" data-default="0">
											<span class="checkmark"></span><?=$chk_lab?>
										</label>
									</div>
									<?php 
									if($f_data['icon']!="" && $icons_of_model_fields == '1') {
										echo '<img src="/images/'.$f_data['icon'].'" width="30px" id="'.$f_data['id'].'" />';
									}
									?>
								</span>
							<?php
							} ?>
							</div>
							<a href="#" class="capacity-row btn btn-sm btn-primary m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air" data-issubmit="<?=$last_next_button?>">Next</a>
							<span class="text-danger"></span>
						<?php
						} ?>
					</div>
					<div class="modern-block__selected">
						<span class="mobile-block">Capacity: </span>
						<span class="current-item">
							<?=$opt_name_array[$fields_name]?>
						</span>
					</div>
					<div class="modern-disabled"></div>
				</div>
				<?php
				$fid++;
				$last_field_id = $fields_name;
				}
			} ?>
			<br />
			<div class="device-get-price clearfix">
				<button type="button" class="btn btn-secondary" onClick="backFeild()">Back</button>
				<button type="submit" class="btn btn-primary arrow" id="quantity-section" <?=($opt_name_array[$last_field_id]?'style="display:block;"':'style="display:none;"')?>><?=($edit_item_id>0?'Update':'Save')?></button>
			</div>
		</div>
	</div>
	
	<span class="show_final_amt_val" style="display:none;"><?=$total_price?></span>

	<input type="hidden" name="sell_this_device" value="yes">
	<input type="hidden" name="quantity" id="quantity" value="<?=($order_item_data['quantity']>0?$order_item_data['quantity']:1)?>"/>
	<input type="hidden" name="device_id" id="device_id" value="<?=$model_data['device_id']?>"/>
	<input type="hidden" name="payment_amt" id="payment_amt" value="<?=$total_price?>"/>
	<input type="hidden" name="req_model_id" id="req_model_id" value="<?=$req_model_id?>"/>
	<input id="total_price_org" value="<?=$price?>" type="hidden" />
	<input name="id" type="hidden" value="<?=$req_model_id?>" />
	<input type="hidden" name="fields_cat_type" value="<?=$fields_cat_type?>">

	<?php
	if($edit_item_id>0) {
		echo '<input type="hidden" name="edit_item_id" id="edit_item_id" value="'.$edit_item_id.'"/>';
	} ?>
</div>
<?php
} ?>

<script>
var tpj=jQuery;

function get_price() {
	tpj.ajax({
		type: 'POST',
		url: '<?=SITE_URL?>ajax/get_model_price.php',
		data: tpj('#model_details_form').serialize(),
		success: function(data) {
			if(data!="") {
				var resp_data = JSON.parse(data);

				var total_price = resp_data.payment_amt;

				var _t_price=formatMoney(total_price);
				var f_price=format_amount(_t_price);
				
				tpj(".showhide_total_section").show();
				
				tpj(".show_final_amt").html(f_price);
				tpj(".show_final_amt_val").html(total_price);
				
				//tpj('#get-price-btn').removeAttr("disabled");
			}
		}
	});
}

tpj(document).ready(function($) {
	$('#device-prop-area .radio_select_buttons, #device-prop-area .checkboxes').bind('click keyup', function(event) {
		$(".show_final_amt").html('<i class="fa fa-spinner fa-spin" style="font-size:24px;margin-top:10px;"></i>');

		setTimeout(function() {
			get_price();
		}, 500);
	});
});

get_price();
</script>