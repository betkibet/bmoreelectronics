<?php
$csrf_token = generateFormToken('model_details');

//Url params
$req_model_id=$mobile_single_data_resp['model_data']['id'];

//Fetching data from model
require_once('models/model.php');

//Get data from models/model.php, get_single_model_data function
$model_data = get_single_model_data($req_model_id);
$meta_title = $model_data['meta_title'];
$meta_desc = $model_data['meta_desc'];
$meta_keywords = $model_data['meta_keywords'];

$fields_cat_type = $model_data['fields_cat_type'];
$category_data = get_category_data($model_data['cat_id']);

//Header section
include("include/header.php");

$edit_item_id = isset($_GET['item_id'])?$_GET['item_id']:'';
$order_item_data = array();
if($edit_item_id>0) {
	$order_item_data = get_order_item($edit_item_id,'');
	$order_item_data = $order_item_data['data'];
}

$fld_id_array = array();
$opt_name_array = array();

$item_name_array = json_decode((isset($order_item_data['item_name'])?$order_item_data['item_name']:''),true);
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
		@$opt_name_array[$ei_k] .= rtrim($items_opt_name,', ');		
	}
}

$image_name_array = json_decode((isset($order_item_data['images'])?$order_item_data['images']:''),true);
if(!empty($image_name_array)) {
	foreach($image_name_array as $eim_k => $image_name_data) {
		$fld_id_array[] = $eim_k;
		$opt_name_array[$eim_k] = $image_name_data['img_name'];
	}
}

$fields_data_array = array();

$network_items_array = get_models_networks_data($req_model_id);
$fields_data_array[] = array('title'=>$category_data['network_title'],'tooltip'=>$category_data['tooltip_network'],'type'=>'network','input-type'=>'radio','data'=>$network_items_array,'class'=>'network','required_field'=>$category_data['required_network']);

$connectivity_items_array = get_models_connectivity_data($req_model_id);
$fields_data_array[] = array('title'=>$category_data['connectivity_title'],'tooltip'=>$category_data['tooltip_connectivity'],'type'=>'connectivity','input-type'=>'radio','data'=>$connectivity_items_array,'required_field'=>$category_data['required_connectivity']);

$case_size_items_array = get_models_case_size_data($req_model_id);
$fields_data_array[] = array('title'=>$category_data['case_size_title'],'tooltip'=>$category_data['tooltip_case_size'],'type'=>'case_size','input-type'=>'radio','data'=>$case_size_items_array,'required_field'=>$category_data['required_case_size']);

$model_items_array = get_models_model_data($req_model_id);
$fields_data_array[] = array('title'=>$category_data['model_title'],'tooltip'=>$category_data['tooltip_model'],'type'=>'model','input-type'=>'radio','data'=>$model_items_array,'class'=>'model','required_field'=>$category_data['required_model']);

$processor_items_array = get_models_processor_data($req_model_id);
$fields_data_array[] = array('title'=>$category_data['processor_title'],'tooltip'=>$category_data['tooltip_processor'],'type'=>'processor','input-type'=>'radio','data'=>$processor_items_array,'required_field'=>$category_data['required_processor']);

$ram_items_array = get_models_ram_data($req_model_id);
$fields_data_array[] = array('title'=>$category_data['ram_title'],'tooltip'=>$category_data['tooltip_ram'],'type'=>'ram','input-type'=>'radio','data'=>$ram_items_array,'required_field'=>$category_data['required_ram']);

$storage_items_array = get_models_storage_data($req_model_id);
$fields_data_array[] = array('title'=>$category_data['storage_title'],'tooltip'=>$category_data['tooltip_storage'],'type'=>'storage','input-type'=>'radio','data'=>$storage_items_array,'class'=>'storage','required_field'=>$category_data['required_storage']);

$graphics_card_items_array = get_models_graphics_card_data($req_model_id);
$fields_data_array[] = array('title'=>$category_data['graphics_card_title'],'tooltip'=>$category_data['tooltip_graphics_card'],'type'=>'graphics_card','input-type'=>'radio','data'=>$graphics_card_items_array,'required_field'=>$category_data['required_graphics_card']);

$condition_items_array = get_models_condition_data($req_model_id);
$fields_data_array[] = array('title'=>$category_data['condition_title'],'tooltip'=>$category_data['tooltip_condition'],'type'=>'condition','input-type'=>'radio','data'=>$condition_items_array,'class'=>'condition','required_field'=>$category_data['required_condition']);

/*$watchtype_items_array = get_models_watchtype_data($req_model_id);
$fields_data_array[] = array('title'=>$category_data['type_title'],'tooltip'=>$category_data['tooltip_watchtype'],'type'=>'watchtype','input-type'=>'radio','data'=>$watchtype_items_array);

$case_material_items_array = get_models_case_material_data($req_model_id);
$fields_data_array[] = array('title'=>$category_data['case_material_title'],'tooltip'=>$category_data['tooltip_case_material'],'type'=>'case_material','input-type'=>'radio','data'=>$case_material_items_array);*/

$band_included_items_array = get_models_band_included_data($req_model_id);
$fields_data_array[] = array('title'=>$category_data['band_included_title'],'tooltip'=>$category_data['tooltip_band_included'],'type'=>'band_included','input-type'=>'checkbox','data'=>$band_included_items_array,'required_field'=>$category_data['required_band_included']);

$accessories_items_array = get_models_accessories_data($req_model_id);
$fields_data_array[] = array('title'=>$category_data['accessories_title'],'tooltip'=>$category_data['tooltip_accessories'],'type'=>'accessories','input-type'=>'checkbox','data'=>$accessories_items_array,'class'=>'accessories','required_field'=>$category_data['required_accessories']);

/*echo '<pre>';
print_r($fields_data_array);
exit;*/

$exist_others_pro_fld = 0;
$exist_con_pro_fld = 0;

if(!empty($condition_items_array)) {
	$exist_con_pro_fld = 1;
}
if(!empty($network_items_array) || !empty($connectivity_items_array) || !empty($case_size_items_array) || !empty($model_items_array) || !empty($processor_items_array) || !empty($ram_items_array) || !empty($storage_items_array) || !empty($graphics_card_items_array) || !empty($band_included_items_array) || !empty($accessories_items_array)) {
	$exist_others_pro_fld = 1;
}

$model_upto_price = 0;
$model_upto_price_data = get_model_upto_price($req_model_id,$model_data['price']);
$model_upto_price = $model_upto_price_data['price'];
?>

<form action="<?=SITE_URL?>controllers/model.php" method="post" enctype="multipart/form-data" onSubmit="return checkdata();" id="model_details_form">
  <section  class="pb-0">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
          <div class="block heading page-heading text-center">
		    <?php
			/*if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER']) { ?>
			<a class="btn btn-primary rounded-pill back-button" href="javascript:void(0);" onclick="history.back();">Back</a>
			<?php
			}*/
			echo '<h1>Sell your '.$model_data['title'].':</h1>';
		    if($exist_others_pro_fld > 0) {
            	echo '<h4 class="device-name-dt" style="display:none;"><span class="device-name"></span></h4>';
			} ?>
          </div>

		  <?php
		  if($exist_others_pro_fld <= 0) { ?>
		  <div class="block text-center">
		  	<?php
			if($model_data['model_img']) {
				$md_img_path = SITE_URL.'images/mobile/'.$model_data['model_img']; ?>
            	<img class="single-product-image" src="<?=$md_img_path?>" alt="<?=$model_data['title']?>">
			<?php
			} ?>
          </div>
		  <?php
		  } else { ?>
          <div class="block phone-details position-relative clearfix">
            <div class="card">
				<?php 
				if($model_upto_price>0) {
				echo '<h6 class="btn btn-primary upto-price-button">Up to '.amount_fomat($model_upto_price).'</h6>';
				}?>
              <div class="row center_content">
                <div class="col-md-5 phone-image-block text-center">
					<?php
					if($model_data['model_img']) {
						$md_img_path = SITE_URL.'images/mobile/'.$model_data['model_img']; ?>
						<img class="phone-image" src="<?=$md_img_path?>" alt="<?=$model_data['title']?>">
					<?php
					} ?>
                </div>
                <div class="col-md-7">
					<input type="hidden" name="base_price" />
					<div id="device-prop-area">
					<?php
					$tooltips_data_array = array();

					$fid=1;
					foreach($fields_data_array as $fields_data) {
						if(!empty($fields_data['data'])) {
							if($fields_data['type'] == "condition") {
								continue;
							}

							$fields_name = $fields_data['type'];
							$fields_input_type = $fields_data['input-type'];
							$required_field = ($fields_data['required_field']=='1'?1:0);
						
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
													
													<input class="custom-control-input m-fields-input" name="storage" value="<?=$storage_size?>" <?=$checked?> type="radio" id="<?=$f_data['id']?>" data-default="0" />
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
													<input class="custom-control-input clk_condition m-fields-input" name="condition" value="<?=$condition_name?>" <?=$checked?> type="radio" id="<?=$f_data['id']?>" data-default="0" />
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
													<input class="custom-control-input m-fields-input" name="network" value="<?=$network_name?>" <?=$checked?> type="radio" id="<?=$f_data['id']?>" data-default="0" />
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
													<input class="custom-control-input m-fields-input" name="connectivity" value="<?=$connectivity_name?>" <?=$checked?> type="radio" id="<?=$f_data['id']?>" data-default="0" />
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
													<input class="custom-control-input m-fields-input" name="case_size" value="<?=$case_size_name?>" <?=$checked?> type="radio" id="<?=$f_data['id']?>" data-default="0" />
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
													<input class="custom-control-input m-fields-input" name="model" value="<?=$model_name?>" <?=$checked?> type="radio" id="<?=$f_data['id']?>" data-default="0" />
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
													<input class="custom-control-input m-fields-input" name="processor" value="<?=$processor_name?>" <?=$checked?> type="radio" id="<?=$f_data['id']?>" data-default="0" />
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
													<input class="custom-control-input m-fields-input" name="ram" value="<?=$ram_size?>" <?=$checked?> type="radio" id="<?=$f_data['id']?>" data-default="0" />
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
													<input class="custom-control-input m-fields-input" name="graphics_card" value="<?=$graphics_card_name?>" <?=$checked?> type="radio" id="<?=$f_data['id']?>" data-default="0" />
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
												<input class="custom-control-input m-fields-input" name="band_included[]" id="<?=$chk_lab?>" <?=$checked?> value="<?=$chk_lab.':'.$f_data['id']?>" type="checkbox" data-default="0">
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
												<input class="custom-control-input m-fields-input" name="accessories[]" id="<?=$chk_lab?>" <?=$checked?> value="<?=$chk_lab.':'.$f_data['id']?>" type="checkbox" data-default="0">
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
		  <?php
		  }

		  if($exist_con_pro_fld>0) { ?>
			  <div class="block heading page-heading-second text-center condition-section" <?php if($exist_others_pro_fld>0 && $exist_con_pro_fld>0){echo 'style="display:none;"';}?>>
				<h3>Condition:</h3>
			  </div>
		  <?php
		  } ?>

		<div class="block condition-tab clearfix condition-section position-relative" <?php if($exist_others_pro_fld>0 && $exist_con_pro_fld>0){echo 'style="display:none;"';}?>>
			<?php 
			if($model_upto_price>0 && $exist_others_pro_fld <= 0) {
				echo '<h6 class="btn btn-primary upto-price-button">Up to '.amount_fomat($model_upto_price).'</h6>';
			} ?>
			<div class="row">
				<?php
				$price_section_class = "col-md-12 col-lg-12 show-price text-center";
				if($exist_con_pro_fld>0) { ?>
					<div class="col-md-6 col-lg-3">
						<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
							<?php
							$c_c=1;
							foreach($fields_data_array as $fields_data) {
								if(!empty($fields_data['data'])) {
									if($fields_data['type'] == "condition") {
										$fields_name = $fields_data['type'];
										$fields_input_type = $fields_data['input-type'];
										$required_field = ($fields_data['required_field']=='1'?1:0);
		
										foreach($fields_data['data'] as $f_d => $f_data) {
											$condition_name = $f_data['condition_name'];
											
											$is_cond_active = '';
											if(isset($item_name_array['condition']['opt_data']['0']['opt_name']) && $condition_name == $item_name_array['condition']['opt_data']['0']['opt_name']) {
												$is_cond_active = 'active';
											} elseif($c_c == '1' && $edit_item_id<=0) {
												$is_cond_active = 'active';
											}
					
											if($f_data['condition_terms']!="" && $tooltips_of_model_fields == '1') {
												$cus_opt_tooltips_data_array[] = array('is_cond_active'=>$is_cond_active, 'tooltip'=>$f_data['condition_terms'], 'id'=>$f_data['id'], 'name'=>$condition_name);
											}
										
											if($is_cond_active) {
												$condition_field = '<input type="hidden" name="condition" value="'.$condition_name.'" class="condition_field">';
											} ?>
											<a class="nav-link <?=$is_cond_active?>" id="v-pills-<?=$f_data['id']?>-tab" data-toggle="pill" href="#v-pills-<?=$f_data['id']?>" role="tab" aria-controls="v-pills-<?=$f_data['id']?>" aria-selected="true" data-value="<?=$condition_name?>"><?=$condition_name?></a>
											
											<?php /*?><div class="card">
												<div class="card-header" id="headingOne">
													<h2 class="mb-0">
														<a class="btn btn-link nav-link-mbl <?=($is_cond_active?'':'collapsed')?>" id="v-pills-<?=$f_data['id']?>-tab" data-toggle="collapse" data-target="#collapse<?=$f_data['id']?>" aria-expanded="true" aria-controls="collapse<?=$f_data['id']?>" data-value="<?=$condition_name?>">
															<?=$condition_name?>
														</a>
													</h2>
												</div>
												<div id="collapse<?=$f_data['id']?>" class="collapse <?=($is_cond_active?'show':'')?>" aria-labelledby="headingOne" data-parent="#accordionCondition">
													<div class="card-body">
														<?=$f_data['condition_terms']?>
													</div>
												</div>
											</div><?php */?>
											<?php
											$c_c++;
										}
										echo $condition_field;
									}
								}
							} ?>
						</div>
					</div>
				
				<?php /*?><div class="col-md-12 col-lg-12 d-none d-lg-block">
					<div class="nav nav-pills nav-fill" id="v-pills-tab" role="tablist" aria-orientation="vertical">
						<?php
						$c_c=1;
						foreach($fields_data_array as $fields_data) {
							if(!empty($fields_data['data'])) {
								if($fields_data['type'] == "condition") {
									$fields_name = $fields_data['type'];
									$fields_input_type = $fields_data['input-type'];
									$required_field = ($fields_data['required_field']=='1'?1:0);
											
									foreach($fields_data['data'] as $f_d => $f_data) {
										$condition_name = $f_data['condition_name'];
										
										$is_cond_active = '';
										if(isset($item_name_array['condition']['opt_data']['0']['opt_name']) && $condition_name == $item_name_array['condition']['opt_data']['0']['opt_name']) {
											$is_cond_active = 'active';
										} elseif($c_c == '1' && $edit_item_id<=0) {
											$is_cond_active = 'active';
										}
				
										if($f_data['condition_terms']!="" && $tooltips_of_model_fields == '1') {
											$cus_opt_tooltips_data_array[] = array('is_cond_active'=>$is_cond_active, 'tooltip'=>$f_data['condition_terms'], 'id'=>$f_data['id'], 'name'=>$condition_name);
										}
									
										if($is_cond_active) {
											$condition_field = '<input type="hidden" name="condition" value="'.$condition_name.'" class="condition_field">';
										} ?>
											<a class="nav-item nav-link <?=$is_cond_active?>" id="v-pills-<?=$f_data['id']?>-tab" data-toggle="pill" href="#v-pills-<?=$f_data['id']?>" role="tab" aria-controls="v-pills-<?=$f_data['id']?>" aria-selected="true" data-value="<?=$condition_name?>"><?=$condition_name?></a>
										<?php
										$c_c++;
									}
									echo $condition_field;
								}
							}
						} ?>
					</div>
				</div><?php */?>
				
				<div class="col-md-6 col-lg-5">
                <div class="tab-content" id="v-pills-tabContent">
					<?php
					$c_n = 1;
					foreach($cus_opt_tooltips_data_array as $cus_opt_tooltips_data) { ?>
					  <div class="tab-pane fade <?=($cus_opt_tooltips_data['is_cond_active']?'show active':'')?>" id="v-pills-<?=$cus_opt_tooltips_data['id']?>" role="tabpanel" aria-labelledby="v-pills-<?=$cus_opt_tooltips_data['id']?>-tab">
						<div class="row">
						  <div class="col-md-12">
							<ul>
							  <?=$cus_opt_tooltips_data['tooltip']?>
							</ul>
						  </div>
						</div>
					  </div>
					<?php
					$c_n++;
					} ?>
                </div>
              </div>
				<?php
				$price_section_class = "col-md-12 col-lg-4 show-price text-center";
				} ?>
				<div class="<?=$price_section_class?>">
					<h4 class="price-total show_final_amt">$0<span>.00</span></h4>
					<h4 class="price-total apr-spining-icon" style="display:none;"></h4>
					<p><button type="submit" class="btn btn-lg btn-primary rounded-pill">Get Paid</button></p>
					<p><button type="submit" class="btn btn-lg rounded-pill btn-outline-light accept-btn" name="accept_offer">Accept offer & <br />add another device</button></p>
				</div>
			</div>
		</div>
		<div class="block condition-tab condition-section mt-4 d-lg-none clearfix" <?php if($exist_others_pro_fld>0 && $exist_con_pro_fld>0){echo 'style="display:none;"';}?>>
			<div class="row">
				<div class="col-md-12 show-price d-block d-lg-none text-center">
					<h4 class="price-total show_final_amt">$0<span>.00</span></h4>
					<h4 class="price-total apr-spining-icon" style="display:none;"></h4>
					<p><button type="submit" class="btn btn-lg btn-primary rounded-pill">Get Paid</button></p>
					<p><button type="submit" class="btn btn-lg rounded-pill btn-outline-light accept-btn" name="accept_offer">Accept offer & <br />add another device</button></p>
				</div>
			</div>
		</div>
        </div>
      </div>
    </div>
  </section>

<span class="show_final_amt_val" style="display:none;"></span>

<input type="hidden" name="sell_this_device" value="yes">
<input type="hidden" name="quantity" id="quantity" value="1"/>
<input type="hidden" name="device_id" id="device_id" value="<?=$model_data['device_id']?>"/>
<input type="hidden" name="payment_amt" id="payment_amt"/>
<input type="hidden" name="req_model_id" id="req_model_id" value="<?=$req_model_id?>"/>
<input type="hidden" name="edit_item_id" id="edit_item_id" value="<?=$edit_item_id?>"/>
<input id="total_price_org" type="hidden" />
<input name="id" type="hidden" value="<?=$req_model_id?>" />
<input type="hidden" name="csrf_token" value="<?=$csrf_token?>">
<input type="hidden" name="fields_cat_type" value="<?=$fields_cat_type?>">

<input type="hidden" name="is_condition_appear" id="is_condition_appear" value="0"/>
</form>

<?php
foreach($tooltips_data_array as $tooltips_data) { ?>
	<div class="modal fade common_popup" id="info_popup<?=$tooltips_data['id']?>" role="dialog">
		<div class="modal-dialog small_dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<div class="modal-body">
					<h3 class="title"><?=$tooltips_data['name']?></h3>
					<?=$tooltips_data['tooltip']?>
				</div>
			</div>
		</div>
	</div>
<?php
} ?>

<section class="pt-0 d-none d-md-block">
	<div class="container-fluid">
	  <div class="row">
		<div class="col-md-4">
		  <div class="block why-choose-page">
			<div class="d-table m-auto">
			  <img src="<?=SITE_URL?>images/icons/pay.png">We pay more
			</div>
		  </div>
		</div>
		<div class="col-md-4">
		  <div class="block why-choose-page">
			<div class="d-table m-auto">
			  <img src="<?=SITE_URL?>images/icons/satisfaction.png">Satisfaction guaranteed
			</div>
		  </div>
		</div>
		<div class="col-md-4">
		  <div class="block why-choose-page">
			<div class="d-table m-auto">
			  <img src="<?=SITE_URL?>images/icons/hours.png">24 hour payments
			</div>
		  </div>
		</div>
	  </div>
	</div>
</section>

<?php
if($model_data['cat_id']>0) {
	$faqs_groups_data_html = get_faqs_groups_with_html(array(),$model_data['cat_id'],'model_details');
	if($faqs_groups_data_html['html']!="") { ?>
		<section class="faq_page">
			<div class="container">
				<div class="block setting-page clearfix">
					<div class="wrap model_detail_accordion">
						<?=$faqs_groups_data_html['html']?>
					</div>
				</div>
			</div>
		</section>
	<?php	
	}
} ?>
	
<script>
var tpj=jQuery;

function checkdata() {
	tpj("#payment_amt").val(tpj(".show_final_amt_val").html());

	var is_return = true;
	tpj('.m-fields-input').each(function(index) {
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

function get_price(mode) {
	<?php
	if($exist_others_pro_fld>0 && $exist_con_pro_fld>0) { ?>
	var is_return = true;
	tpj('.m-fields-input').each(function(index) {
		var is_checked = tpj(this).parent().parent().find("input:checked").length;
			if(is_checked == 0) {
				is_return = false;
			}
	});
	console.log('is_return:',is_return);

	if(is_return == false) {
		tpj('#is_condition_appear').val(0);
		tpj('.condition-section').hide();
	} else {
		tpj('#is_condition_appear').val(1);
		
		if(!window.matchMedia("(max-width: 1024px)").matches) {
		 setTimeout(function() {
		 	tpj.scrollTo(tpj('.condition-section'), 1000);
		 }, 200);
		}
		
		tpj('.condition-section').show();
	}
	<?php
	} elseif($exist_con_pro_fld>0) { ?>
		tpj('#is_condition_appear').val(1);
	<?php
	} ?>
	
	tpj.ajax({
		type: 'POST',
		url: '<?=SITE_URL?>ajax/get_model_price.php',
		data: tpj('#model_details_form').serialize(),
		success: function(data) {
			if(data!="") {
				var resp_data = JSON.parse(data);

				var total_price = resp_data.payment_amt;
				var total_price_html = resp_data.payment_amt_html;
				
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
				
				tpj(".show_final_amt").html(total_price_html);
				tpj(".show_final_amt_val").html(total_price);
				
				//tpj(".device_nm").html(resp_data.device_nm);
				if(resp_data.device_nm) {
					tpj('.clear-fields').show();
				}
				//tpj('#get-price-btn').removeAttr("disabled");
				
				if(mode == "click") {
					tpj(".device-name-dt").show();
					tpj(".device-name").html(resp_data.device_nm);
				}
				
				tpj(".show_final_amt").show();
				tpj(".apr-spining-icon").hide();
				tpj(".apr-spining-icon").html('');
			}
		}
	});
}

tpj(document).ready(function($) {
	
	/*$('.clk_condition').on('click', function() {
		var id = $(this).attr('id');
		$(".condition-description").hide();
		$("#condition_term-"+id).show();
	});*/
	
	$('.nav-link, .nav-link-mbl').on('click', function() {
		var name = $(this).attr("data-value");
		$(".condition_field").val(name);
	});
	
	$('#device-prop-area .radio_select_buttons, #device-prop-area .checkboxes, .nav-link, .nav-link-mbl').bind('click keyup', function(event) {
		$(".apr-spining-icon").html('<div class="spining-icon"><i class="fa fa-spinner fa-spin"></i></div>');
		$(".apr-spining-icon").show();
		$(".show_final_amt").hide();
		
		var is_required = $(this).parent().parent().parent().attr("data-required");
		var is_checked = $(this).parent().parent().find("input:checked").length;
		if(is_required=="1") {
			if(is_checked > 0) {
				$(this).next().html("");
			}
		}

		setTimeout(function() {
			get_price('click');
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
		get_price('click');
	});
	buttonMin.click(function() {
		if(quantity.val()<=1) {
			quantity.val(1).trigger('input');
		} else {
			quantity.val(Math.max(parseInt(quantity.val()) - 1, 0)).trigger('input');
		}
		get_price('click');
	});
});

get_price('load');

(function( $ ) {
	$(function() {
	  // More code using $ as alias to jQuery
	  var stickyNavTop = $('.float-section').offset().top;
	  var stickyNav = function () {
		  var scrollTop = $(window).scrollTop();
		  if(scrollTop > stickyNavTop) {
			  $('.float-section').addClass('cloned');
		  } else {
			  $('.float-section').removeClass('cloned');
		  }
	  };
	  stickyNav();
	  $(window).scroll(function () {
		  stickyNav();
	  });

	  //$('[data-toggle="tooltip"]').tooltip();
	});
})(jQuery);
</script>
