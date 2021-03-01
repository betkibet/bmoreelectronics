<?php
require_once("../../admin/_config/config.php");
require_once("../../admin/include/functions.php");
require_once("common.php");

$field_type = $_REQUEST['field_type'];
$cat_id = $_REQUEST['cat_id'];
$fields_cat_type = $_REQUEST['fields_cat_type'];

if($cat_id>0) {
	$storage_items_array = get_category_storage_data($cat_id);
	$condition_items_array = get_category_condition_data($cat_id);
	$network_items_array = get_category_networks_data($cat_id);
	$connectivity_items_array = get_category_connectivity_data($cat_id);
	$watchtype_items_array = get_category_watchtype_data($cat_id);
	$case_material_items_array = get_category_case_material_data($cat_id);
	$case_size_items_array = get_category_case_size_data($cat_id);
	$accessories_items_array = get_category_accessories_data($cat_id);
	$band_included_items_array = get_category_band_included_data($cat_id);
	$processor_items_array = get_category_processor_data($cat_id);
	$ram_items_array = get_category_ram_data($cat_id);
	$model_items_array = get_category_model_data($cat_id);
	$graphics_card_items_array = get_category_graphics_card_data($cat_id);

	if($field_type == "tabs") {
		if($fields_cat_type == "mobile") { ?>
			<li class="nav-item m-tabs__item"><a href="#tab1" data-toggle="tab" class="nav-link m-tabs__link active show">Basic</a></li>
			<li class="nav-item m-tabs__item"><a href="#tab8" data-toggle="tab" class="nav-link m-tabs__link">Metadata</a></li>
			<li class="nav-item m-tabs__item"><a href="#tab4" data-toggle="tab" class="nav-link m-tabs__link">Carrier</a></li>
			<li class="nav-item m-tabs__item"><a href="#tab2" data-toggle="tab" class="nav-link m-tabs__link">Storage</a></li>
			<li class="nav-item m-tabs__item"><a href="#tab3" data-toggle="tab" class="nav-link m-tabs__link">Condition</a></li>
			<li class="nav-item m-tabs__item"><a href="#tab12" data-toggle="tab" class="nav-link m-tabs__link">Accessories</a></li>
		<?php
		}
		if($fields_cat_type == "tablet") { ?>
			<li class="active"><a href="#tab1" data-toggle="tab" class="nav-link m-tabs__link active show">Basic</a></li>
			<li class="nav-item m-tabs__item"><a href="#tab8" data-toggle="tab" class="nav-link m-tabs__link">Metadata</a></li>
			<li class="nav-item m-tabs__item"><a href="#tab5" data-toggle="tab" class="nav-link m-tabs__link">Connectivity</a></li>
			<li class="nav-item m-tabs__item"><a href="#tab2" data-toggle="tab" class="nav-link m-tabs__link">Storage</a></li>
			<li class="nav-item m-tabs__item"><a href="#tab3" data-toggle="tab" class="nav-link m-tabs__link">Condition</a></li>
			<li class="nav-item m-tabs__item"><a href="#tab12" data-toggle="tab" class="nav-link m-tabs__link">Accessories</a></li>
		<?php
		}
		if($fields_cat_type == "watch") { ?>
			<li class="active"><a href="#tab1" data-toggle="tab" class="nav-link m-tabs__link active show">Basic</a></li>
			<li class="nav-item m-tabs__item"><a href="#tab8" data-toggle="tab" class="nav-link m-tabs__link">Metadata</a></li>
			<li class="nav-item m-tabs__item"><a href="#tab5" data-toggle="tab" class="nav-link m-tabs__link">Connectivity</a></li>
			<li class="nav-item m-tabs__item"><a href="#tab6" data-toggle="tab" class="nav-link m-tabs__link">Size</a></li>
			<li class="nav-item m-tabs__item"><a href="#tab19" data-toggle="tab" class="nav-link m-tabs__link">Model</a></li>
			<li class="nav-item m-tabs__item"><a href="#tab3" data-toggle="tab" class="nav-link m-tabs__link">Condition</a></li>
			<li class="nav-item m-tabs__item"><a href="#tab18" data-toggle="tab" class="nav-link m-tabs__link">Band Included</a></li>
			<li class="nav-item m-tabs__item"><a href="#tab12" data-toggle="tab" class="nav-link m-tabs__link">Accessories</a></li>
		<?php
		}
		if($fields_cat_type == "laptop") { ?>
			<li class="active"><a href="#tab1" data-toggle="tab" class="nav-link m-tabs__link active show">Basic</a></li>
			<li class="nav-item m-tabs__item"><a href="#tab8" data-toggle="tab" class="nav-link m-tabs__link">Metadata</a></li>
			<li class="nav-item m-tabs__item"><a href="#tab19" data-toggle="tab" class="nav-link m-tabs__link">Model</a></li>
			<li class="nav-item m-tabs__item"><a href="#tab16" data-toggle="tab" class="nav-link m-tabs__link">Processor</a></li>
			<li class="nav-item m-tabs__item"><a href="#tab17" data-toggle="tab" class="nav-link m-tabs__link">RAM</a></li>
			<li class="nav-item m-tabs__item"><a href="#tab2" data-toggle="tab" class="nav-link m-tabs__link">Storage</a></li>
			<li class="nav-item m-tabs__item"><a href="#tab20" data-toggle="tab" class="nav-link m-tabs__link">Graphics Card</a></li>
			<li class="nav-item m-tabs__item"><a href="#tab3" data-toggle="tab" class="nav-link m-tabs__link">Condition</a></li>
			<li class="nav-item m-tabs__item"><a href="#tab12" data-toggle="tab" class="nav-link m-tabs__link">Accessories</a></li>
		<?php
		}
		if($fields_cat_type == "other") { ?>
			<li class="active"><a href="#tab1" data-toggle="tab" class="nav-link m-tabs__link active show">Basic</a></li>
			<li class="nav-item m-tabs__item"><a href="#tab8" data-toggle="tab" class="nav-link m-tabs__link">Metadata</a></li>
			<li class="nav-item m-tabs__item"><a href="#tab19" data-toggle="tab" class="nav-link m-tabs__link">Model</a></li>
			<li class="nav-item m-tabs__item"><a href="#tab3" data-toggle="tab" class="nav-link m-tabs__link">Condition</a></li>
			<li class="nav-item m-tabs__item"><a href="#tab12" data-toggle="tab" class="nav-link m-tabs__link">Accessories</a></li>
		<?php
		}
	}
	
	if($field_type == "storage" && ($fields_cat_type=="mobile" || $fields_cat_type=="tablet" || $fields_cat_type=="laptop")) { ?>
		<div class="form-controls">
		<?php
		if(!empty($storage_items_array)) {
			foreach($storage_items_array as $key=>$storage_item) {
				$storage_id = $storage_item['id']; ?>
				<div class="row" id="<?=$key?>" style="margin-top:5px;">
					<div class="col-5">
					<input type="text" class="form-control m-input" id="storage_size[]" name="storage_size[]" value="<?=html_entities($storage_item['storage_size'])?>" placeholder="Storage Sizes">
					</div>
					<div class="col-2">
					<select class="form-control m-input" name="storage_size_postfix[]" id="storage_size_postfix[]" style="width:70px;">
						<option value="GB" <?php if($storage_item['storage_size_postfix']=='GB'){echo 'selected="selected"';}?>>GB</option>
						<option value="TB" <?php if($storage_item['storage_size_postfix']=='TB'){echo 'selected="selected"';}?>>TB</option>
						<option value="MB" <?php if($storage_item['storage_size_postfix']=='MB'){echo 'selected="selected"';}?>>MB</option>
					</select>
					</div>
					<?php
					if($top_seller_mode == "storage_specific") { ?>
					<div class="col-3">
					<select class="form-control m-input" name="top_seller[]" id="top_seller[]" style="width:100px;">
						<option value=""> - Top Seller - </option>
						<option value="1" <?php if($storage_item['top_seller']=='1'){echo 'selected="selected"';}?>>ON</option>
						<option value="0" <?php if($storage_item['top_seller']=='0'){echo 'selected="selected"';}?>>OFF</option>
					</select>
					</div>
					<?php
					} ?>
					<div class="col-1">
					<a href="javascript:void(0);" class="remove_storage_item" id="rm_<?=$key?>"><i class="la la-trash trash"></i></a>
					</div>
				</div>
				<script>remove_storage_item();</script>
			<?php
			}
		} ?>
		</div>
	<?php
	}
	
	if($field_type == "condition" && ($fields_cat_type=="mobile" || $fields_cat_type=="tablet" || $fields_cat_type=="watch" || $fields_cat_type=="laptop" || $fields_cat_type == "other")) {
		if(!empty($condition_items_array)) {
			foreach($condition_items_array as $c_key=>$condition_data) {
				$condition_id = $condition_data['id']; ?>
		
				<div class="row" id="cnd<?=$c_key?>" style="margin-top:5px;">
					<div class="col-5">
						<div class="control-group">
							<label class="control-label" for="input">Name</label>
							<div class="controls">
								 <input type="text" class="form-control m-input" id="condition_name[]" name="condition_name[]" value="<?=html_entities($condition_data['condition_name'])?>" placeholder="Name">
							</div>
						</div>
					</div>
					
					<div class="col-6">
						<div class="control-group">
							<label class="control-label" for="input">Terms</label>
							<div class="controls">
								 <textarea class="form-control m-input" name="condition_terms[]" id="condition_terms[]" placeholder="Terms"><?=$condition_data['condition_terms']?></textarea>
							</div>
						</div>
					</div>
					
					<div class="col-1">
						<div class="control-group">
							<label class="control-label" for="input">&nbsp;</label>
							<div class="controls">
								<a href="javascript:void(0);" class="remove_condition_item" id="rm_cnd<?=$c_key?>"><i class="la la-trash trash"></i></a>
							</div>
						</div>
					</div>
				</div>
				<script>remove_condition_item();</script>
			<?php
			}
		}
	}
	
	if($field_type == "network" && ($fields_cat_type=="mobile")) {
		if(!empty($network_items_array)) {
			foreach($network_items_array as $n_key=>$network_data) {
				$network_id = $network_data['id']; ?>
				<div class="row" id="nvk<?=$n_key?>">
					<div class="col-5">
						<div class="control-group">
							<label class="control-label" for="input">Name</label>
							<div class="controls">
								 <input type="text" class="form-control m-input" id="network_name[]" name="network_name[]" value="<?=html_entities($network_data['network_name'])?>" placeholder="Name">
							</div>
						</div>
					</div>

					<div class="col-5">
						<div class="control-group">
							<label class="control-label" for="input">Icon</label>
							<div class="controls">
								 <input type="file" name="network_icon[]" id="network_icon[]" style="width:95px;"/>
								 <input type="hidden" name="old_network_icon[]" id="old_network_icon[]" value="<?=$network_data['network_icon']?>"/>
							</div>
						</div>
					</div>
					
					<div class="col-1">
						<div class="form-group m-form__group">
							<label>&nbsp;</label>
							<?php
						    if($network_data['network_icon']) { ?>
							  <img src="../images/network/<?=$network_data['network_icon']?>" width="25" height="25"/>
						    <?php
						    } ?>
						</div>
					</div>
					<div class="col-1">
						<div class="form-group m-form__group">
							<label>&nbsp; </label>
							<a href="javascript:void(0);" class="remove_network_item" id="rm_nvk<?=$n_key?>"><i class="la la-trash trash"></i></a>
						</div>
					</div>
				</div>
				<script>remove_network_item();</script>
			<?php
			}
		}
	}

	if($field_type == "connectivity" && ($fields_cat_type=="tablet" || $fields_cat_type=="watch")) {
	?>
		<div class="form-controls">
		<?php
		if(!empty($connectivity_items_array)) {
			foreach($connectivity_items_array as $key=>$connectivity_item) {
				$connectivity_id = $connectivity_item['id']; ?>
				<div class="row" id="clr<?=$key?>" style="margin-top:5px;">
					<div class="col-6">
						<input type="text" class="form-control m-input" id="connectivity_name[<?=$connectivity_id?>]" name="connectivity_name[<?=$connectivity_id?>]" value="<?=$connectivity_item['connectivity_name']?>" placeholder="Name">
					</div>
					<div class="col-1">
						<a href="javascript:void(0);" class="remove_connectivity_item" id="rm_clr<?=$key?>"><i class="la la-trash trash"></i></a>
					</div>
				</div>
				<script>remove_connectivity_item();</script>
			<?php
			}
		} ?>
		</div>
	<?php
	}
	
	if($field_type == "model" && ($fields_cat_type=="laptop" || $fields_cat_type=="watch" || $fields_cat_type == "other")) {
	?>
		<div class="form-controls">
		<?php
		if(!empty($model_items_array)) {
			foreach($model_items_array as $key=>$model_item) {
				$model_id = $model_item['id']; ?>
				<div class="row" id="ml<?=$key?>" style="margin-top:5px;">
					<div class="col-6">
						<input type="text" class="form-control m-input" id="model_name[<?=$model_id?>]" name="model_name[<?=$model_id?>]" value="<?=$model_item['model_name']?>" placeholder="Name">
					</div>
					<div class="col-1">
						<a href="javascript:void(0);" class="remove_model_item" id="rm_ml<?=$key?>"><i class="la la-trash trash"></i></a>
					</div>
				</div>
				<script>remove_model_item();</script>
			<?php
			}
		} ?>
		</div>
	<?php
	}
	
	if($field_type == "graphics_card" && $fields_cat_type=="laptop") {
	?>
		<div class="form-controls">
		<?php
		if(!empty($graphics_card_items_array)) {
			foreach($graphics_card_items_array as $key=>$graphics_card_item) {
				$graphics_card_id = $graphics_card_item['id']; ?>
				<div class="row" id="gc<?=$key?>" style="margin-top:5px;">
					<div class="col-6">
						<input type="text" class="form-control m-input" id="graphics_card_name[<?=$graphics_card_id?>]" name="graphics_card_name[<?=$graphics_card_id?>]" value="<?=$graphics_card_item['graphics_card_name']?>" placeholder="Name">
					</div>
					<div class="col-1">
						<a href="javascript:void(0);" class="remove_graphics_card_item" id="rm_gc<?=$key?>"><i class="la la-trash trash"></i></a>
					</div>
				</div>
				<script>remove_graphics_card_item();</script>
			<?php
			}
		} ?>
		</div>
	<?php
	}
	
	if($field_type == "accessories" && ($fields_cat_type=="mobile" || $fields_cat_type=="tablet" || $fields_cat_type=="watch" || $fields_cat_type=="laptop" || $fields_cat_type == "other")) {
	?>
		<div class="form-controls">
		<?php
		if(!empty($accessories_items_array)) {
			foreach($accessories_items_array as $key=>$accessories_item) {
				$accessories_id = $accessories_item['id']; ?>
				<div class="row" id="accssr<?=$key?>" style="margin-top:5px;">
					<div class="col-6">
						<input type="text" class="form-control m-input" id="accessories_name[]" name="accessories_name[]" value="<?=html_entities($accessories_item['accessories_name'])?>" placeholder="Name">
					</div>
					<div class="col-3">
						<input type="number" class="form-control m-input" id="accessories_price[]" name="accessories_price[]" value="<?=$accessories_item['accessories_price']?>" placeholder="Price">
					</div>
					<div class="col-1">
						<a href="javascript:void(0);" class="remove_accessories_item" id="rm_accssr<?=$key?>"><i class="la la-trash trash"></i></a>
					</div>
				</div>
				<script>remove_accessories_item();</script>
			<?php
			}
		} ?>
		</div>
	<?php
	}
	
	if($field_type == "band_included" && $fields_cat_type=="watch") { ?>
		<div class="form-controls">
		<?php
		if(!empty($band_included_items_array)) {
			foreach($band_included_items_array as $key=>$band_included_item) {
				$band_included_id = $band_included_item['id']; ?>
				<div class="row" id="bndinc<?=$key?>" style="margin-top:5px;">
					<div class="col-6">
						<input type="text" class="form-control m-input" id="band_included_name[]" name="band_included_name[]" value="<?=html_entities($band_included_item['band_included_name'])?>" placeholder="Name">
					</div>
					<div class="col-3">
						<input type="number" class="form-control m-input" id="band_included_price[]" name="band_included_price[]" value="<?=$band_included_item['band_included_price']?>" placeholder="Price">
					</div>
					<div class="col-1">
						<a href="javascript:void(0);" class="remove_band_included_item" id="rm_bndinc<?=$key?>"><i class="la la-trash trash"></i></a>
					</div>
				</div>
				<script>remove_band_included_item();</script>
			<?php
			}
		} ?>
		</div>
	<?php
	}
	
	if($field_type == "processor" && $fields_cat_type=="laptop") {
	?>
		<div class="form-controls">
		<?php
		if(!empty($processor_items_array)) {
			foreach($processor_items_array as $key=>$processor_item) {
				$processor_id = $processor_item['id']; ?>
				<div class="row" id="prcr<?=$key?>" style="margin-top:5px;">
					<div class="col-6">
					<input type="text" class="form-control m-input" id="processor_name[]" name="processor_name[]" value="<?=html_entities($processor_item['processor_name'])?>" placeholder="Name">
					</div>
					<?php /*?><div class="input-prepend input-append">
						<?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?>
						<input type="number" class="form-control m-input" id="processor_price[]" name="processor_price[]" value="<?=$processor_item['processor_price']?>" placeholder="Price">
						<?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?>
					</div><?php */?>
					<div class="col-1">
					<a href="javascript:void(0);" class="remove_processor_item" id="rm_prcr<?=$key?>"><i class="la la-trash trash"></i></a>
					</div>
				</div>
				<script>remove_processor_item();</script>
			<?php
			}
		} ?>
		</div>
	<?php
	}

	if($field_type == "ram" && $fields_cat_type=="laptop") {
	?>
		<div class="form-controls">
		<?php
		if(!empty($ram_items_array)) {
			foreach($ram_items_array as $key=>$ram_item) {
				$ram_id = $ram_item['id']; ?>
				<div class="row" id="ram<?=$key?>" style="margin-top:5px;">
					<div class="col-6">
					<input type="text" class="form-control m-input" id="ram_size[]" name="ram_size[]" value="<?=html_entities($ram_item['ram_size'])?>" placeholder="Ram Size">
					</div>
					<div class="col-3">
					<select class="form-control m-input" name="ram_size_postfix[]" id="ram_size_postfix[]" style="width:70px;">
						<option value="GB" <?php if($ram_item['ram_size_postfix']=='GB'){echo 'selected="selected"';}?>>GB</option>
						<option value="TB" <?php if($ram_item['ram_size_postfix']=='TB'){echo 'selected="selected"';}?>>TB</option>
						<option value="MB" <?php if($ram_item['ram_size_postfix']=='MB'){echo 'selected="selected"';}?>>MB</option>
					</select>
					</div>
					<?php /*?><div class="input-prepend input-append">
						<?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?>
						<input type="number" class="form-control m-input" id="ram_price[]" name="ram_price[]" value="<?=$ram_item['ram_price']?>" placeholder="Price">
						<?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?>
					</div><?php */?>
					<div class="col-1">
					<a href="javascript:void(0);" class="remove_ram_item" id="rm_ram<?=$key?>"><i class="la la-trash trash"></i></a>
					</div>
				</div>
				<script>remove_ram_item();</script>
			<?php
			}
		} ?>
		</div>
	<?php
	}
	
	if($field_type == "watchtype" && $fields_cat_type=="watch") {
	?>
		<div class="form-controls">
		<?php
		if(!empty($watchtype_items_array)) {
			foreach($watchtype_items_array as $key=>$watchtype_item) {
				$watchtype_id = $watchtype_item['id']; ?>
				<div class="row" id="accssr<?=$key?>" style="margin-top:5px;">
					<div class="col-6">
					<input type="text" class="form-control m-input" id="watchtype_name[<?=$watchtype_id?>]" name="watchtype_name[<?=$watchtype_id?>]" value="<?=html_entities($watchtype_item['watchtype_name'])?>" placeholder="Name">
					</div>
					<div class="col-1">
					<a href="javascript:void(0);" class="remove_watchtype_item" id="rm_accssr<?=$key?>"><i class="la la-trash trash"></i></a>
					</div>
				</div>
				<script>remove_watchtype_item();</script>
			<?php
			}
		} ?>
		</div>
	<?php
	}
	
	if($field_type == "case_material" && $fields_cat_type=="watch") {
	?>
		<div class="form-controls">
		<?php
		if(!empty($case_material_items_array)) {
			foreach($case_material_items_array as $key=>$case_material_item) {
				$case_material_id = $case_material_item['id']; ?>
				<div class="row" id="accssr<?=$key?>" style="margin-top:5px;">
					<div class="col-6">
					<input type="text" class="form-control m-input" id="case_material_name[<?=$case_material_id?>]" name="case_material_name[<?=$case_material_id?>]" value="<?=html_entities($case_material_item['case_material_name'])?>" placeholder="Name">
					</div>
					<div class="col-1">
					<a href="javascript:void(0);" class="remove_case_material_item" id="rm_accssr<?=$key?>"><i class="la la-trash trash"></i></a>
					</div>
				</div>
				<script>remove_case_material_item();</script>
			<?php
			}
		} ?>
		</div>
	<?php
	}

	if($field_type == "case_size" && $fields_cat_type=="watch") {
	?>
		<div class="form-controls">
		<?php
		if(!empty($case_size_items_array)) {
			foreach($case_size_items_array as $key=>$case_size_item) {
				$case_size_id = $case_size_item['id']; ?>
				<div class="row" id="cssz<?=$key?>" style="margin-top:5px;">
					<div class="col-6">
					<input type="text" class="form-control m-input" id="case_size[<?=$case_size_id?>]" name="case_size[<?=$case_size_id?>]" value="<?=html_entities($case_size_item['case_size'])?>" placeholder="Case Size">
					</div>
					<div class="col-1">
					<a href="javascript:void(0);" class="remove_case_size_item" id="rm_cssz<?=$key?>"><i class="la la-trash trash"></i></a>
					</div>
				</div>
				<script>remove_case_size_item();</script>
			<?php
			}
		} ?>
		</div>
	<?php
	}
} ?>
