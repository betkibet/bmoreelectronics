<?php
require_once("../../admin/_config/config.php");
require_once("../../admin/include/functions.php");
require_once("../../include/custom_js.php");
require_once("../common.php");

$req_model_id = $post['model_id'];
if($req_model_id>0) {
//Fetching data from model
require_once('../../models/model.php');

//Get data from models/model.php, get_single_model_data function
$model_data = get_single_model_data($req_model_id);
$meta_title = $model_data['meta_title'];
$meta_desc = $model_data['meta_desc'];
$meta_keywords = $model_data['meta_keywords'];

$fields_cat_type = $model_data['fields_cat_type'];
$category_data = get_category_data($model_data['cat_id']);

$edit_item_id = $_GET['item_id'];
$order_item_data = array();
if($edit_item_id>0) {
	$order_item_data = get_order_item($edit_item_id,'');
	$order_item_data = $order_item_data['data'];
}

$fld_id_array = array();
$opt_name_array = array();

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
$fields_data_array[] = array('title'=>$category_data['network_title'],'tooltip'=>$category_data['tooltip_network'],'type'=>'network','input-type'=>'radio','data'=>$network_items_array,'class'=>'network');

$connectivity_items_array = get_models_connectivity_data($req_model_id);
$fields_data_array[] = array('title'=>$category_data['connectivity_title'],'tooltip'=>$category_data['tooltip_connectivity'],'type'=>'connectivity','input-type'=>'radio','data'=>$connectivity_items_array);

$case_size_items_array = get_models_case_size_data($req_model_id);
$fields_data_array[] = array('title'=>$category_data['case_size_title'],'tooltip'=>$category_data['tooltip_case_size'],'type'=>'case_size','input-type'=>'radio','data'=>$case_size_items_array);

$model_items_array = get_models_model_data($req_model_id);
$fields_data_array[] = array('title'=>$category_data['model_title'],'tooltip'=>$category_data['tooltip_model'],'type'=>'model','input-type'=>'radio','data'=>$model_items_array,'class'=>'model');

$processor_items_array = get_models_processor_data($req_model_id);
$fields_data_array[] = array('title'=>$category_data['processor_title'],'tooltip'=>$category_data['tooltip_processor'],'type'=>'processor','input-type'=>'radio','data'=>$processor_items_array);

$ram_items_array = get_models_ram_data($req_model_id);
$fields_data_array[] = array('title'=>$category_data['ram_title'],'tooltip'=>$category_data['tooltip_ram'],'type'=>'ram','input-type'=>'radio','data'=>$ram_items_array);

$storage_items_array = get_models_storage_data($req_model_id);
$fields_data_array[] = array('title'=>$category_data['storage_title'],'tooltip'=>$category_data['tooltip_storage'],'type'=>'storage','input-type'=>'radio','data'=>$storage_items_array,'class'=>'storage');

$graphics_card_items_array = get_models_graphics_card_data($req_model_id);
$fields_data_array[] = array('title'=>$category_data['graphics_card_title'],'tooltip'=>$category_data['tooltip_graphics_card'],'type'=>'graphics_card','input-type'=>'radio','data'=>$graphics_card_items_array);

$condition_items_array = get_models_condition_data($req_model_id);
$fields_data_array[] = array('title'=>$category_data['condition_title'],'tooltip'=>$category_data['tooltip_condition'],'type'=>'condition','input-type'=>'radio','data'=>$condition_items_array,'class'=>'condition');

/*$watchtype_items_array = get_models_watchtype_data($req_model_id);
$fields_data_array[] = array('title'=>$category_data['type_title'],'tooltip'=>$category_data['tooltip_watchtype'],'type'=>'watchtype','input-type'=>'radio','data'=>$watchtype_items_array);

$case_material_items_array = get_models_case_material_data($req_model_id);
$fields_data_array[] = array('title'=>$category_data['case_material_title'],'tooltip'=>$category_data['tooltip_case_material'],'type'=>'case_material','input-type'=>'radio','data'=>$case_material_items_array);*/

$band_included_items_array = get_models_band_included_data($req_model_id);
$fields_data_array[] = array('title'=>$category_data['band_included_title'],'tooltip'=>$category_data['tooltip_band_included'],'type'=>'band_included','input-type'=>'checkbox','data'=>$band_included_items_array);

$accessories_items_array = get_models_accessories_data($req_model_id);
$fields_data_array[] = array('title'=>$category_data['accessories_title'],'tooltip'=>$category_data['tooltip_accessories'],'type'=>'accessories','input-type'=>'checkbox','data'=>$accessories_items_array,'class'=>'accessories');

/*echo '<pre>';
print_r($fields_data_array);
exit;*/
?>

<?php /*?><script src="<?=SITE_URL?>js/apr/front.js"></script><?php */?>

  <section id="model_details" class="pb-0">

    <div class="container-fluid">

      <div class="row">

        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

          <div class="block phone-details position-relative clearfix pb-0">

            <div class="card">

				<?php 

				if($model_upto_price>0) {

				echo '<h6 class="btn btn-primary upto-price-button rounded-pill">Up to '.amount_fomat($model_upto_price).'</h6>';

				}
				echo '<h3>Sell your '.$model_data['title'].':</h3>'; ?>

              <div class="row">

                <div class="col-md-12">
  <div id="device-prop-area">
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
		
		<div class="<?=(isset($fields_data['class'])?$fields_data['class']:'')?>" data-row_type="<?=$fields_input_type?>" data-required="<?=$required_field?>">
								<div class="h4">
									<?=$fields_data['title']?>
									
									<?php
									if($fields_data['tooltip']!="" && $tooltips_of_model_fields == '1') {
										$tooltips_data_array[] = array('tooltip'=>$fields_data['tooltip'], 'id'=>'p'.$fields_name, 'name'=>$fields_data['title']); ?>
										<span class="tips" data-toggle="modal" data-target="#info_popup<?='p'.$fields_name?>"><i class="fa fa-info-circle"></i></span>
									<?php
									} ?>:
								</div>
								<div class="storage-options">
									<?php
									if($fields_data['type'] == "storage") { ?>
										<div class="radio_select_buttons">
											<?php
											foreach($fields_data['data'] as $f_d => $f_data) {
												$storage_size = $f_data['storage_size'].$f_data['storage_size_postfix'];
									
												$checked = '';
												if(isset($item_name_array['storage']['opt_data']['0']['opt_name']) && $storage_size == $item_name_array['storage']['opt_data']['0']['opt_name']) {
													$checked = 'checked';
												} ?>
												<div class="custom-control custom-radio custom-control-inline">
													<?php 
													if(isset($f_data['tooltip']) && $f_data['tooltip']!="" && $tooltips_of_model_fields == '1') {
														$tooltips_data_array[] = array('tooltip'=>$f_data['tooltip'], 'id'=>$f_data['id'], 'name'=>$storage_size); ?>
														<p class="text-center mb-0"><span class="tooltip-text" data-toggle="modal" data-target="#info_popup<?=$f_data['id']?>"><i class="fa fa-info-circle" aria-hidden="true"></i></span></p>
													<?php
													} ?>
													
													<input class="custom-control-input" name="storage" value="<?=$storage_size?>" <?=$checked?> type="radio" id="<?=$f_data['id']?>" data-default="0" />
													<label class="custom-control-label" for="<?=$f_data['id']?>">
														<?php
														if(isset($f_data['icon']) && $f_data['icon']!="" && $icons_of_model_fields == '1') {
															echo '<img src="/images/'.$f_data['icon'].'" id="'.$f_data['id'].'" />';
														} ?>
														<?='<span>'.$storage_size.'</span>'?>
													</label>
												</div>
											<?php
											} ?>
										</div>
									<?php
									}
									elseif($fields_data['type'] == "condition") { ?>
										<div class="radio_select_buttons">
											<?php
											foreach($fields_data['data'] as $f_d => $f_data) {
												$condition_name = $f_data['condition_name'];
									
												$checked = '';
												if(isset($item_name_array['condition']['opt_data']['0']['opt_name']) && $condition_name == $item_name_array['condition']['opt_data']['0']['opt_name']) {
													$checked = 'checked';
												} ?>
												<div class="custom-control custom-radio custom-control-inline">
													<?php 
													if($f_data['condition_terms']!="" && $tooltips_of_model_fields == '1') {
														$tooltips_data_array[] = array('tooltip'=>$f_data['condition_terms'], 'id'=>$f_data['id'], 'name'=>$condition_name); ?>
														<p class="text-center mb-0"><span class="tooltip-text" data-toggle="modal" data-target="#info_popup<?=$f_data['id']?>"><i class="fa fa-info-circle" aria-hidden="true"></i></span></p>
													<?php
													} ?>
													<input class="custom-control-input clk_condition" name="condition" value="<?=$condition_name?>" <?=$checked?> type="radio" id="<?=$f_data['id']?>" data-default="0" />
													<label class="custom-control-label" for="<?=$f_data['id']?>">
														<?php
														if(isset($f_data['icon']) && $f_data['icon']!="" && $icons_of_model_fields == '1') {
															echo '<img src="/images/'.$f_data['icon'].'" id="'.$f_data['id'].'" />';
														} ?>
														<?='<span>'.$condition_name.'</span>'?>
													</label>
												</div>
											<?php
											} ?>
										</div>
										<!--<span class="d-none">&nbsp;</span>-->
										<?php
										/*foreach($fields_data['data'] as $f_t_k => $f_t_data) {
											if(trim($f_t_data['condition_terms'])) { ?>
												<div class="condition-description clearfix" id="condition_term-<?=$f_t_data['id']?>">
													<?=$f_t_data['condition_terms']?>
												</div>
											<?php
											}
										}*/
									} elseif($fields_data['type'] == "network") { ?>
										<div class="radio_select_buttons">
											<?php
											foreach($fields_data['data'] as $f_d => $f_data) {
												$network_name = $f_data['network_name'];
									
												$checked = '';
												if(isset($item_name_array['network']['opt_data']['0']['opt_name']) && $network_name == $item_name_array['network']['opt_data']['0']['opt_name']) {
													$checked = 'checked';
												} ?>
												<div class="custom-control custom-radio custom-control-inline">
													<?php 
													if(isset($f_data['tooltip']) && $f_data['tooltip']!="" && $tooltips_of_model_fields == '1') {
														$tooltips_data_array[] = array('tooltip'=>$f_data['tooltip'], 'id'=>$f_data['id'], 'name'=>$network_name); ?>
														<p class="text-center mb-0"><span class="tooltip-text" data-toggle="modal" data-target="#info_popup<?=$f_data['id']?>"><i class="fa fa-info-circle" aria-hidden="true"></i></span></p>
													<?php
													} ?>
													<input class="custom-control-input" name="network" value="<?=$network_name?>" <?=$checked?> type="radio" id="<?=$f_data['id']?>" data-default="0" />
													<label class="custom-control-label" for="<?=$f_data['id']?>">
														<?php
														if($f_data['network_icon']!="" && $icons_of_model_fields == '1') {
															echo '<img src="/images/network/'.$f_data['network_icon'].'" id="'.$f_data['id'].'" />';
														} ?>
														<?='<span>'.$network_name.'</span>'?>
													</label>
												</div>
											<?php
											} ?>
										</div>
									<?php
									} elseif($fields_data['type'] == "connectivity") { ?>
										<div class="radio_select_buttons">
											<?php
											foreach($fields_data['data'] as $f_d => $f_data) {
												$connectivity_name = $f_data['connectivity_name'];
									
												$checked = '';
												if(isset($item_name_array['connectivity']['opt_data']['0']['opt_name']) && $connectivity_name == $item_name_array['connectivity']['opt_data']['0']['opt_name']) {
													$checked = 'checked';
												} ?>
												<div class="custom-control custom-radio custom-control-inline">
													<?php 
													if(isset($f_data['tooltip']) && $f_data['tooltip']!="" && $tooltips_of_model_fields == '1') {
														$tooltips_data_array[] = array('tooltip'=>$f_data['tooltip'], 'id'=>$f_data['id'], 'name'=>$connectivity_name); ?>
														<p class="text-center mb-0"><span class="tooltip-text" data-toggle="modal" data-target="#info_popup<?=$f_data['id']?>"><i class="fa fa-info-circle" aria-hidden="true"></i></span></p>
													<?php
													} ?>
													<input class="custom-control-input" name="connectivity" value="<?=$connectivity_name?>" <?=$checked?> type="radio" id="<?=$f_data['id']?>" data-default="0" />
													<label class="custom-control-label" for="<?=$f_data['id']?>">
														<?php
														if(isset($f_data['icon']) && $f_data['icon']!="" && $icons_of_model_fields == '1') {
															echo '<img src="/images/'.$f_data['icon'].'" id="'.$f_data['id'].'" />';
														} ?>
														<?='<span>'.$connectivity_name.'</span>'?>
													</label>
												</div>
											<?php
											} ?>
										</div>
									<?php
									} elseif($fields_data['type'] == "case_size") { ?>
										<div class="radio_select_buttons">
											<?php
											foreach($fields_data['data'] as $f_d => $f_data) {
												$case_size_name = $f_data['case_size'];
									
												$checked = '';
												if(isset($item_name_array['case_size']['opt_data']['0']['opt_name']) && $case_size_name == $item_name_array['case_size']['opt_data']['0']['opt_name']) {
													$checked = 'checked';
												} ?>
												<div class="custom-control custom-radio custom-control-inline">
													<?php 
													if(isset($f_data['tooltip']) && $f_data['tooltip']!="" && $tooltips_of_model_fields == '1') {
														$tooltips_data_array[] = array('tooltip'=>$f_data['tooltip'], 'id'=>$f_data['id'], 'name'=>$case_size_name); ?>
														<p class="text-center mb-0"><span class="tooltip-text" data-toggle="modal" data-target="#info_popup<?=$f_data['id']?>"><i class="fa fa-info-circle" aria-hidden="true"></i></span></p>
													<?php
													} ?>
													<input class="custom-control-input" name="case_size" value="<?=$case_size_name?>" <?=$checked?> type="radio" id="<?=$f_data['id']?>" data-default="0" />
													<label class="custom-control-label" for="<?=$f_data['id']?>">
														<?php
														if(isset($f_data['icon']) && $f_data['icon']!="" && $icons_of_model_fields == '1') {
															echo '<img src="/images/'.$f_data['icon'].'" id="'.$f_data['id'].'" />';
														} ?>
														<?='<span>'.$case_size_name.'</span>'?>
													</label>
												</div>
											<?php
											} ?>
										</div>
									<?php
									} elseif($fields_data['type'] == "model") { ?>
										<div class="radio_select_buttons">
											<?php
											foreach($fields_data['data'] as $f_d => $f_data) {
												$model_name = $f_data['model_name'];
									
												$checked = '';
												if(isset($item_name_array['model']['opt_data']['0']['opt_name']) && $model_name == $item_name_array['model']['opt_data']['0']['opt_name']) {
													$checked = 'checked';
												} ?>
												<div class="custom-control custom-radio custom-control-inline">
													<?php 
													if(isset($f_data['tooltip']) && $f_data['tooltip']!="" && $tooltips_of_model_fields == '1') {
														$tooltips_data_array[] = array('tooltip'=>$f_data['tooltip'], 'id'=>$f_data['id'], 'name'=>$model_name); ?>
														<p class="text-center mb-0"><span class="tooltip-text" data-toggle="modal" data-target="#info_popup<?=$f_data['id']?>"><i class="fa fa-info-circle" aria-hidden="true"></i></span></p>
													<?php
													} ?>
													<input class="custom-control-input" name="model" value="<?=$model_name?>" <?=$checked?> type="radio" id="<?=$f_data['id']?>" data-default="0" />
													<label class="custom-control-label" for="<?=$f_data['id']?>">
														<?php
														if(isset($f_data['icon']) && $f_data['icon']!="" && $icons_of_model_fields == '1') {
															echo '<img src="/images/'.$f_data['icon'].'" id="'.$f_data['id'].'" />';
														} ?>
														<?='<span>'.$model_name.'</span>'?>
													</label>
												</div>
											<?php
											} ?>
										</div>
									<?php
									} elseif($fields_data['type'] == "processor") { ?>
										<div class="radio_select_buttons">
											<?php
											foreach($fields_data['data'] as $f_d => $f_data) {
												$processor_name = $f_data['processor_name'];
									
												$checked = '';
												if(isset($item_name_array['processor']['opt_data']['0']['opt_name']) && $processor_name == $item_name_array['processor']['opt_data']['0']['opt_name']) {
													$checked = 'checked';
												} ?>
												<div class="custom-control custom-radio custom-control-inline">
													<?php 
													if(isset($f_data['tooltip']) && $f_data['tooltip']!="" && $tooltips_of_model_fields == '1') {
														$tooltips_data_array[] = array('tooltip'=>$f_data['tooltip'], 'id'=>$f_data['id'], 'name'=>$processor_name); ?>
														<p class="text-center mb-0"><span class="tooltip-text" data-toggle="modal" data-target="#info_popup<?=$f_data['id']?>"><i class="fa fa-info-circle" aria-hidden="true"></i></span></p>
													<?php
													} ?>
													<input class="custom-control-input" name="processor" value="<?=$processor_name?>" <?=$checked?> type="radio" id="<?=$f_data['id']?>" data-default="0" />
													<label class="custom-control-label" for="<?=$f_data['id']?>">
														<?php
														if(isset($f_data['icon']) && $f_data['icon']!="" && $icons_of_model_fields == '1') {
															echo '<img src="/images/'.$f_data['icon'].'" id="'.$f_data['id'].'" />';
														} ?>
														<?='<span>'.$processor_name.'</span>'?>
													</label>
												</div>
											<?php
											} ?>
										</div>
									<?php
									}
									elseif($fields_data['type'] == "ram") { ?>
										<div class="radio_select_buttons">
											<?php
											foreach($fields_data['data'] as $f_d => $f_data) {
												$ram_size = $f_data['ram_size'].$f_data['ram_size_postfix'];
									
												$checked = '';
												if(isset($item_name_array['ram']['opt_data']['0']['opt_name']) && $ram_size == $item_name_array['ram']['opt_data']['0']['opt_name']) {
													$checked = 'checked';
												} ?>
												<div class="custom-control custom-radio custom-control-inline">
													<?php 
													if(isset($f_data['tooltip']) && $f_data['tooltip']!="" && $tooltips_of_model_fields == '1') {
														$tooltips_data_array[] = array('tooltip'=>$f_data['tooltip'], 'id'=>$f_data['id'], 'name'=>$ram_size); ?>
														<p class="text-center mb-0"><span class="tooltip-text" data-toggle="modal" data-target="#info_popup<?=$f_data['id']?>"><i class="fa fa-info-circle" aria-hidden="true"></i></span></p>
													<?php
													} ?>
													<input class="custom-control-input" name="ram" value="<?=$ram_size?>" <?=$checked?> type="radio" id="<?=$f_data['id']?>" data-default="0" />
													<label class="custom-control-label" for="<?=$f_data['id']?>">
														<?php
														if(isset($f_data['icon']) && $f_data['icon']!="" && $icons_of_model_fields == '1') {
															echo '<img src="/images/'.$f_data['icon'].'" id="'.$f_data['id'].'" />';
														} ?>
														<?='<span>'.$ram_size.'</span>'?>
													</label>
												</div>
											<?php
											} ?>
										</div>
									<?php
									}
									elseif($fields_data['type'] == "graphics_card") { ?>
										<div class="radio_select_buttons">
											<?php
											foreach($fields_data['data'] as $f_d => $f_data) {
												$graphics_card_name = $f_data['graphics_card_name'];

												$checked = '';
												if(isset($item_name_array['case_size']['opt_data']['0']['opt_name']) && $graphics_card_name == $item_name_array['graphics_card']['opt_data']['0']['opt_name']) {
													$checked = 'checked';
												} ?>
												<div class="custom-control custom-radio custom-control-inline">
													<?php 
													if(isset($f_data['tooltip']) && $f_data['tooltip']!="" && $tooltips_of_model_fields == '1') {
														$tooltips_data_array[] = array('tooltip'=>$f_data['tooltip'], 'id'=>$f_data['id'], 'name'=>$graphics_card_name); ?>
														<p class="text-center mb-0"><span class="tooltip-text" data-toggle="modal" data-target="#info_popup<?=$f_data['id']?>"><i class="fa fa-info-circle" aria-hidden="true"></i></span></p>
													<?php
													} ?>
													<input class="custom-control-input" name="graphics_card" value="<?=$graphics_card_name?>" <?=$checked?> type="radio" id="<?=$f_data['id']?>" data-default="0" />
													<label class="custom-control-label" for="<?=$f_data['id']?>">
														<?php
														if(isset($f_data['icon']) && $f_data['icon']!="" && $icons_of_model_fields == '1') {
															echo '<img src="/images/'.$f_data['icon'].'" id="'.$f_data['id'].'" />';
														} ?>
														<?='<span>'.$graphics_card_name.'</span>'?>
													</label>
												</div>
											<?php
											} ?>
										</div>
									<?php
									}
									elseif($fields_data['type']=="band_included") { ?>
										<div class="checkboxes">
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
											<div class="custom-control custom-radio custom-control-inline">
												<?php
												if(isset($f_data['tooltip']) && $f_data['tooltip']!="" && $tooltips_of_model_fields == '1') {
													$tooltips_data_array[] = array('tooltip'=>$f_data['tooltip'], 'id'=>$f_data['id'], 'name'=>$chk_lab); ?>
													<span class="tooltip-text" data-toggle="modal" data-target="#info_popup<?=$f_data['id']?>"><i class="fa fa-info-circle"></i></span>
												<?php
												} ?>
												<input class="custom-control-input" name="band_included[]" id="<?=$chk_lab?>" <?=$checked?> value="<?=$chk_lab.':'.$f_data['id']?>" type="checkbox" data-default="0">
												<label class="custom-control-label" for="<?=$chk_lab?>">
													<?php
													if(isset($f_data['icon']) && $f_data['icon']!="" && $icons_of_model_fields == '1') {
														echo '<img src="/images/'.$f_data['icon'].'" width="50px" id="'.$f_data['id'].'" />';
													} ?>
													<?='<span>'.$chk_lab.'</span>'?>
												</label>
												
												<?php 
												if(isset($f_data['icon']) && $f_data['icon']!="" && $icons_of_model_fields == '1') {
													echo '<img src="/images/'.$f_data['icon'].'" width="30px" id="'.$f_data['id'].'" />';
												} ?>
											</div>
										<?php
										} ?>
										</div>
									<?php
									}
									elseif($fields_data['type']=="accessories") { ?>
										<div class="checkboxes">
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
											<div class="custom-control custom-radio custom-control-inline">
												<?php
												if(isset($f_data['tooltip']) && $f_data['tooltip']!="" && $tooltips_of_model_fields == '1') {
													$tooltips_data_array[] = array('tooltip'=>$f_data['tooltip'], 'id'=>$f_data['id'], 'name'=>$chk_lab); ?>
													<span class="tooltip-text" data-toggle="modal" data-target="#info_popup<?=$f_data['id']?>"><i class="fa fa-info-circle" aria-hidden="true"></i></span>
												<?php
												} ?>
												<input class="custom-control-input" name="accessories[]" id="<?=$chk_lab?>" <?=$checked?> value="<?=$chk_lab.':'.$f_data['id']?>" type="checkbox" data-default="0">
												<label class="custom-control-label" for="<?=$chk_lab?>">
													<?php
													if(isset($f_data['icon']) && $f_data['icon']!="" && $icons_of_model_fields == '1') {
														echo '<img src="/images/'.$f_data['icon'].'" width="50px" id="'.$f_data['id'].'" />';
													} ?>
													<?='<span>'.$chk_lab.'</span>'?>
												</label>
											</div>
										<?php
										} ?>
										</div>
									<?php
									} ?>
									<span class="validation-msg"></span>
								</div>
							</div>
		<?php
		$fid++;
		$last_field_id = $fields_name;
		}
	} ?>
  </div>
                 </div>

              </div>

            </div>

          </div>

		  

		  <div class="block condition-tab clearfix condition-section position-relative mobile-shadow-none">	

			<div class="row">

				<div class="col-md-12 col-lg-12 show-price text-center">

					<h4 class="price-total show_final_amt">$0<span>.00</span></h4>

					<h4 class="price-total apr-spining-icon" style="display:none;"></h4>

					<p><button type="button" class="btn btn-lg btn-primary get_paid_fields" id="quantity-section">Get Paid</button></p>

				</div>

			</div>

		  </div>

          

        </div>

      </div>

    </div>

  </section>

<span class="show_final_amt_val" style="display:none;"><?=$total_price?></span>

<input type="hidden" name="quantity" id="quantity" value="1"/>
<input type="hidden" name="sell_this_device" value="yes">
<input type="hidden" name="payment_amt" id="payment_amt" value="<?=$total_price?>"/>
<input id="total_price_org" value="<?=$price?>" type="hidden" />
<input type="hidden" name="fields_cat_type" value="<?=$fields_cat_type?>">
<input type="hidden" name="device_id" id="device_id" value="<?=$model_data['device_id']?>"/>

<script>
var tpj=jQuery;

function checkdata() {
	tpj("#payment_amt").val(tpj(".show_final_amt_val").html());

	var is_return = true;
	tpj('.custom-control-input').each(function(index) {
		var is_required = tpj(this).parent().parent().parent().parent().parent().attr("data-required");
		var is_checked = tpj(this).parent().parent().find("input:checked").length;
		if(is_required=="1") {
			if(is_checked == 0) {
				is_return = false;
				tpj(this).parent().parent().next().html("Please choose an option");
				return false;
			}
		}
	});

	if(is_return == false) {
		return false;
	} else {
		return true;
	}
}

function get_price() {
	tpj.ajax({
		type: 'POST',
		url: '<?=SITE_URL?>ajax/get_model_price.php',
		data: tpj('#apr_form').serialize(),
		success: function(data) {
			if(data!="") {
				var resp_data = JSON.parse(data);

				var total_price = resp_data.payment_amt;

				var _t_price=formatMoney(total_price);
				var f_price=format_amount(_t_price);
				
				<?php
				if($show_instant_price_on_model_criteria_selections!='1') { ?>
				tpj(".showhide_f_total_secn").hide();
				<?php
				} else { ?>
				if(total_price && total_price>0) {
					tpj(".showhide_f_total_secn").show();
				} else {
					tpj(".showhide_f_total_secn").hide();
				}
				<?php
				} ?>
				
				tpj(".show_final_amt").html(f_price);
				tpj(".show_final_amt_val").html(total_price);
				
				tpj(".device_nm").html(resp_data.device_nm);
				if(resp_data.device_nm) {
					$('.clear-fields').show();
				}
				//tpj('#get-price-btn').removeAttr("disabled");
			}
		}
	});
}

tpj(document).ready(function($) {
	
	$('.clk_condition').on('click', function() {
		var id = $(this).attr('id');
		$(".condition-description").hide();
		$("#condition_term-"+id).show();
	});

	$('#device-prop-area .radio_select_buttons, #device-prop-area .checkboxes').bind('click keyup', function(event) {
		$(".show_final_amt").html('<i class="fa fa-spinner fa-spin" style="font-size:24px;margin-top:10px;"></i>');
		
		var is_required = $(this).parent().parent().parent().attr("data-required");
		var is_checked = $(this).parent().parent().find("input:checked").length;
		if(is_required=="1") {
			if(is_checked > 0) {
				$(this).next().html("");
			}
		}
		
		setTimeout(function() {
			get_price();
		}, 500);
	});
	
	$('.show-price-popup').on('click', function() {
		$("#ModalPriceShow").modal();
	});
	
	var buttonPlus = $('.q-increase-btn');
	var buttonMin = $('.q-decrease-btn');
	var quantity = $('#quantity');
	
	buttonPlus.click(function() {
		quantity.val(parseInt(quantity.val()) + 1).trigger('input');
		get_price();
	});
	buttonMin.click(function() {
		if(quantity.val()<=1) {
			quantity.val(1).trigger('input');
		} else {
			quantity.val(Math.max(parseInt(quantity.val()) - 1, 0)).trigger('input');
		}
		get_price();
	});
});

get_price();
</script>

<?php
} 

foreach($tooltips_data_array as $tooltips_data) { ?>
	<div class="modal fade common_popup" id="info_popup<?=$tooltips_data['id']?>" role="dialog">
		<div class="modal-dialog small_dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<button type="button" class="close" data-dismiss="modal"><img src="<?=SITE_URL?>images/payment/close.png" alt=""></button>
				<div class="modal-body">
					<h3 class="title"><?=$tooltips_data['name']?></h3>
					<?=$tooltips_data['tooltip']?>
				</div>
			</div>
		</div>
	</div>
<?php
} ?>