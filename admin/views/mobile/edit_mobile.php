<script>
function check_form(a){
	if(a.device_id.value.trim()==""){
		alert('Please select device');
		a.device_id.focus();
		a.device_id.value='';
		return false;
	}
	if(a.title.value.trim()==""){
		alert('Please enter title');
		a.title.focus();
		a.title.value='';
		return false;
	}
	if(a.price.value.trim()==""){
		alert('Please enter base price');
		a.price.focus();
		a.price.value='';
		return false;
	}
	if(a.tooltip_device.value.trim()==""){
		alert('Please enter tooltip of device');
		a.tooltip_device.focus();
		a.tooltip_device.value='';
		return false;
	}

	<?php
	if($mobile_data['model_img']=="") { ?>
	var str_image = a.model_img.value.trim();
	if(str_image == "") {
		alert('Please select image');
		return false;
	}
	<?php
	} ?>
}

function checkFile(fieldObj) {
	if(fieldObj.files.length == 0) {
		return false;
	}

    var id = fieldObj.id;
	var str  = fieldObj.value;
	var FileExt = str.substr(str.lastIndexOf('.')+1);
	var FileExt = FileExt.toLowerCase();
	var FileSize = fieldObj.files[0].size;
	var FileSizeMB = (FileSize/10485760).toFixed(2);

	if((FileExt != "gif" && FileExt != "png" && FileExt != "jpg" && FileExt != "jpeg")){
	    var error = "Please make sure your file is in png | jpg | jpeg | gif format.\n\n";
	    alert(error);
		document.getElementById(id).value = '';
	    return false;
	}
}

jQuery(document).ready(function ($) {
	$("#storage_plus_icon").on( "click", function(e) {
		var uniqueId = Math.random();
		var uniqueId = uniqueId.toString().split('.');

		var append_data='<div id="'+uniqueId[1]+'" style="margin-top:5px;">';
			 append_data+='<div class="controls"><input type="text" class="input-large" id="storage_size[]" name="storage_size[]" placeholder="Storage Sizes"> ';
			 append_data+='<div class="input-prepend input-append"><?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?><input type="number" class="input-small" id="storage_price[]" name="storage_price[]" placeholder="Price"><?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?></div>';
			 append_data+='&nbsp;<a href="javascript:void(0);" class="remove_storage_item" id="rm_'+uniqueId[1]+'"><i class="icon-remove-sign"></i></a>';
			 append_data+='</div>';
		 append_data+='</div>';
		$('#add_storage_item').append(append_data);
		remove_storage_item();
	});

	$("#colors_plus_icon").on( "click", function(e) {
		var uniqueId = Math.random();
		var uniqueId = uniqueId.toString().split('.');

		var append_data='<div id="'+uniqueId[1]+'" style="margin-top:5px;">';
			 append_data+='<div class="controls"><input type="text" class="input-large" id="color_name[]" name="color_name[]" placeholder="Name"> ';
			 append_data+='<div class="input-prepend input-append"><?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?><input type="number" class="input-small" id="color_price[]" name="color_price[]" placeholder="Price"><?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?></div>';
			 append_data+='&nbsp;<a href="javascript:void(0);" class="remove_colors_item" id="rm_'+uniqueId[1]+'"><i class="icon-remove-sign"></i></a>';
			 append_data+='</div>';
		 append_data+='</div>';
		$('#add_colors_item').append(append_data);
		remove_colors_item();
	});

	$("#miscellaneous_plus_icon").on( "click", function(e) {
		var uniqueId = Math.random();
		var uniqueId = uniqueId.toString().split('.');

		var append_data='<div id="'+uniqueId[1]+'" style="margin-top:5px;">';
			 append_data+='<div class="controls"><input type="text" class="input-large" id="miscellaneous_name[]" name="miscellaneous_name[]" placeholder="Name"> ';
			 append_data+='<div class="input-prepend input-append"><?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?><input type="number" class="input-small" id="miscellaneous_price[]" name="miscellaneous_price[]" placeholder="Price"><?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?></div>';
			 append_data+='&nbsp;<a href="javascript:void(0);" class="remove_miscellaneous_item" id="rm_'+uniqueId[1]+'"><i class="icon-remove-sign"></i></a>';
			 append_data+='</div>';
		 append_data+='</div>';
		$('#add_miscellaneous_item').append(append_data);
		remove_miscellaneous_item();
	});

	$("#accessories_plus_icon").on( "click", function(e) {
		var uniqueId = Math.random();
		var uniqueId = uniqueId.toString().split('.');

		var append_data='<div id="'+uniqueId[1]+'" style="margin-top:5px;">';
			 append_data+='<div class="controls"><input type="text" class="input-large" id="accessories_name[]" name="accessories_name[]" placeholder="Name"> ';
			 append_data+='<div class="input-prepend input-append"><?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?><input type="number" class="input-small" id="accessories_price[]" name="accessories_price[]" placeholder="Price"><?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?></div>';
			 append_data+='&nbsp;<a href="javascript:void(0);" class="remove_accessories_item" id="rm_'+uniqueId[1]+'"><i class="icon-remove-sign"></i></a>';
			 append_data+='</div>';
		 append_data+='</div>';
		$('#add_accessories_item').append(append_data);
		remove_accessories_item();
	});
});

jQuery(document).ready(function ($) {
	$("#condition_plus_icon").on( "click", function(e) {
		var uniqueId = Math.random();
		var uniqueId = uniqueId.toString().split('.');

		var append_data='<div class="row" id="'+uniqueId[1]+'" style="margin-top:5px;">';
			append_data+='<div class="span1.5">';
				append_data+='<div class="control-group">';
					append_data+='<label class="control-label" for="input">Name</label>';
					append_data+='<div class="controls">';
						 append_data+='<input type="text" class="input-small" id="condition_name[]" name="condition_name[]" placeholder="Name">';
					append_data+='</div>';
				append_data+='</div>';
			append_data+='</div>';
			append_data+='<div class="span1.5">';
				append_data+='<div class="control-group">';
					append_data+='<label class="control-label" for="input">Price</label>';
					append_data+='<div class="controls">';
						 append_data+='<div class="input-prepend input-append"><?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?><input type="number" class="input-small" id="condition_price[]" name="condition_price[]" placeholder="Price"><?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?></div>';
					append_data+='</div>';
				append_data+='</div>';
			append_data+='</div>';
			append_data+='<div class="span2">';
				append_data+='<div class="control-group">';
					append_data+='<label class="control-label" for="input">Terms</label>';
					append_data+='<div class="controls">';
						 append_data+='<textarea class="form-control span2" name="condition_terms[]" id="condition_terms[]" placeholder="Terms"></textarea>';
					append_data+='</div>';
				append_data+='</div>';
			append_data+='</div>';
			append_data+='<div class="span1.5">';
				append_data+='<div class="control-group">';
					append_data+='<label class="control-label" for="input">Network</label>';
					append_data+='<div class="controls">';
						 append_data+='<select class="span2" name="disabled_network[]" id="disabled_network[]">';
							append_data+='<option value="1">Enabled</option>';
							append_data+='<option value="0">Disabled</option>';
						append_data+='</select>';
						append_data+='&nbsp;<a href="javascript:void(0);" class="remove_condition_item" id="rm_'+uniqueId[1]+'"><i class="icon-remove-sign"></i></a>';
					append_data+='</div>';
				append_data+='</div>';
			append_data+='</div>';
		append_data+='</div>';

		$('#add_condition_item').append(append_data);
		remove_condition_item();
	});
});

jQuery(document).ready(function ($) {
	$("#network_plus_icon").on( "click", function(e) {
		var uniqueId = Math.random();
		var uniqueId = uniqueId.toString().split('.');

		var append_data='<div class="row" id="rmn'+uniqueId[1]+'">';
			append_data+='<div class="span1.5">';
				append_data+='<div class="control-group">';
					append_data+='<label class="control-label" for="input">Name</label>';
					append_data+='<div class="controls">';
						 append_data+='<input type="text" class="input-medium" id="network_name[]" name="network_name[]" value="<?=$network_data->network_name?>" placeholder="Name">';
					append_data+='</div>';
				append_data+='</div>';
			append_data+='</div>';
			append_data+='<div class="span1.5">';
				append_data+='<div class="control-group">';
					append_data+='<label class="control-label" for="input">Price</label>';
					append_data+='<div class="controls">';
						 append_data+='<div class="input-prepend input-append"><?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?><input type="number" class="input-small" id="network_price[]" name="network_price[]" value="<?=$network_data->network_price?>" style="width:50px;" placeholder="Price"><?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?></div>';
					append_data+='</div>';
				append_data+='</div>';
			append_data+='</div>';
			append_data+='<div class="span1.5">';
				append_data+='<div class="control-group">';
					append_data+='<label class="control-label" for="input">Price Change On Unlock</label>';
					append_data+='<div class="controls">';
						 append_data+='<select class="span1" name="change_unlock[]" id="change_unlock[]">';
							append_data+='<option value="1">Yes</option>';
							append_data+='<option value="0">No</option>';
						append_data+='</select>';
					append_data+='</div>';
				append_data+='</div>';
			append_data+='</div>';
			append_data+='<div class="span1.5">';
				append_data+='<div class="control-group">';
					append_data+='<label class="control-label" for="input">Most Popular</label>';
					append_data+='<div class="controls">';
						 append_data+='<select class="span1" name="most_popular[]" id="most_popular[]">';
							append_data+='<option value="yes">Yes</option>';
							append_data+='<option value="no">No</option>';
						append_data+='</select>';
					append_data+='</div>';
				append_data+='</div>';
			append_data+='</div>';
		append_data+='</div>';

		$('#add_network_item').append(append_data);
		remove_network_item();
	});
});

function remove_storage_item() {
	$(".remove_storage_item").on("click", function(e) {
		var uniqueId = $(this).attr('id').toString().split('_');
		$('#'+uniqueId[1]).remove();
	});
}

function remove_condition_item() {
	$(".remove_condition_item").on( "click", function(e) {
		var uniqueId = $(this).attr('id').toString().split('_');
		$('#'+uniqueId[1]).remove();
	});
}

function remove_network_item() {
	$(".remove_network_item").on( "click", function(e) {
		var uniqueId = $(this).attr('id').toString().split('_');
		$('#'+uniqueId[1]).remove();
	});
}

function remove_colors_item() {
	$(".remove_colors_item").on("click", function(e) {
		var uniqueId = $(this).attr('id').toString().split('_');
		$('#'+uniqueId[1]).remove();
	});
}

function remove_accessories_item() {
	$(".remove_accessories_item").on("click", function(e) {
		var uniqueId = $(this).attr('id').toString().split('_');
		$('#'+uniqueId[1]).remove();
	});
}

function remove_miscellaneous_item() {
	$(".remove_miscellaneous_item").on("click", function(e) {
		var uniqueId = $(this).attr('id').toString().split('_');
		$('#'+uniqueId[1]).remove();
	});
}
</script>

<div id="wrapper">
    <header id="header" class="container">
    	<?php include("include/admin_menu.php"); ?>
    </header>

	<section class="container" role="main">
		<div class="row">
            <article class="span12 data-block">
				<header><h2><?=($id?'Edit Mobile Model':'Add Mobile Model')?></h2></header>
                <section class="tab-content">
					<?php include('confirm_message.php');?>
					<form role="form" action="controllers/mobile.php" class="form-inline no-margin" method="post" onSubmit="return check_form(this);" enctype="multipart/form-data">
					<div class="tab-pane active">
						<!-- Second level tabs -->
						<div class="tabbable tabs-left">
							<ul class="nav nav-tabs">
								<li class="active"><a href="#tab1" data-toggle="tab">Basic Description</a></li>
								<li><a href="#tab8" data-toggle="tab">Metadata</a></li>
								<li><a href="#tab2" data-toggle="tab">Storage</a></li>
								<li><a href="#tab3" data-toggle="tab">Condition</a></li>
								<li><a href="#tab4" data-toggle="tab">Network</a></li>
								<li><a href="#tab5" data-toggle="tab">Colors</a></li>
								<li><a href="#tab7" data-toggle="tab">Accessories</a></li>
								<li><a href="#tab6" data-toggle="tab">Miscellaneous</a></li>
							</ul>
							<div class="tab-content">
								<div class="tab-pane active" id="tab1">
                  <div class="row-fluid">
                <div class="span7">

                  <h3>Basic Fields</h3>
									<div class="control-group">
										<label class="control-label" for="input">Select Device</label>
										<div class="controls">
											<select name="device_id" id="device_id">
												<?php
												while($devices_list=mysqli_fetch_assoc($devices_data)) { ?>
													<option value="<?=$devices_list['id']?>" <?php if($devices_list['id']==$mobile_data['device_id']){echo 'selected="selected"';}?>><?=$devices_list['title']?></option>
												<?php
												} ?>
											</select>
										</div>
									</div>

									<div class="control-group">
										<label class="control-label" for="input">Select Category</label>
										<div class="controls">
											<select name="cat_id" id="cat_id">
												<?php
												//Fetch device list
												$categories_data=mysqli_query($db,'SELECT * FROM categories WHERE published=1');
												while($categories_list=mysqli_fetch_assoc($categories_data)) { ?>
													<option value="<?=$categories_list['id']?>" <?php if($categories_list['id']==$mobile_data['cat_id']){echo 'selected="selected"';}?>><?=$categories_list['title']?></option>
												<?php
												} ?>
											</select>
										</div>
									</div>

									<div class="control-group">
										<label class="control-label" for="input">Title</label>
										<div class="controls">
											<input type="text" class="input-large" id="title" value="<?=$mobile_data['title']?>" name="title">
										</div>
									</div>

									<div class="control-group">
										<label class="control-label" for="input">Base Price</label>
										<div class="controls">
											<div class="input-prepend input-append">
												<?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?>
												<input type="number" class="input-small" id="price" value="<?=($mobile_data['price']>0?$mobile_data['price']:'')?>" name="price">
												<?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?>
											</div>
										</div>
									</div>

									<div class="control-group">
										<label class="control-label" for="input">Tooltip of Device</label>
										<div class="controls">
											<textarea class="form-control wysihtml5" name="tooltip_device" rows="5"><?=$mobile_data['tooltip_device']?></textarea>
										</div>
									</div>

									<div class="control-group radio-inline">
										<label class="control-label" for="input">Publish</label>
										<div class="controls">
											<label class="radio custom-radio">
												<input type="radio" id="published" name="published" value="1" <?php if(!$id){echo 'checked="checked"';}?> <?=($mobile_data['published']==1?'checked="checked"':'')?>> Yes
											</label>
											<label class="radio custom-radio">
												<input type="radio" id="published" name="published" value="0" <?=($mobile_data['published']=='0'?'checked="checked"':'')?>> No
											</label>
										</div>
									</div>
									<div class="form-actions">
										<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button>
										<a href="mobile.php" class="btn btn-alt btn-large btn-black">Back</a>
									</div>
								</div>
                <div class="span5">
                  <div class="control-group">
										<label class="control-label" for="optionsCheckbox">Top Seller</label>
										<div class="controls">
											<label class="checkbox custom-checkbox">
												<input type="checkbox" class="input-large" id="top_seller" value="1" name="top_seller" <?php if($mobile_data['top_seller']=='1'){echo 'checked="checked"';}?>>
											</label>
										</div>
									</div>

                  <div class="control-group">
										<label class="control-label" for="fileInput">Model Picture</label>
										<div class="controls">
											<div class="fileupload fileupload-new" data-provides="fileupload">
                                                <div class="input-append">
                                                    <div class="uneditable-input">
                                                        <i class="icon-file fileupload-exists"></i>
                                                        <span class="fileupload-preview"></span>
                                                    </div>
                                                    <span class="btn btn-alt btn-file">
                                                            <span class="fileupload-new">Select Image</span>
                                                            <span class="fileupload-exists">Change</span>
                                                            <input type="file" class="form-control" id="model_img" name="model_img" onChange="checkFile(this);" accept="image/*">
                                                    </span>
                                                    <a href="javascript:void(0);" class="btn btn-alt btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a>
                                                </div>
                                            </div>

											<?php
											if($mobile_data['model_img']!="") { ?>
												<div class="fileupload fileupload-new" data-provides="fileupload">
													<div class="fileupload-new thumbnail"><img src="../images/mobile/<?=$mobile_data['model_img']?>" width="200"></div>
													<div class="fileupload-preview fileupload-exists fileupload-large flexible thumbnail"></div>
													<div>
														<a class="btn btn-alt btn-danger" data-dismiss="fileupload" href="?id=<?=$_REQUEST['id']?>&r_img_id=<?=$mobile_data['id']?>" onclick="return confirm('Are you sure to delete this icon?');">Remove</a>
													</div>
												</div>
												<input type="hidden" id="old_image" name="old_image" value="<?=$mobile_data['model_img']?>">
											<?php
											} ?>

										</div>
									</div>
                </div>
              </div>

								</div>
								<div class="tab-pane" id="tab2">
									<h3>Storage</h3>
									<div class="control-group" id="add_storage_item">
										<div class="form-controls">
										<?php
										$storage_items_array = json_decode($mobile_data['storage']);
										if(!empty($storage_items_array)) {
											foreach($storage_items_array as $key=>$storage_item) {?>
												<div id="<?=$key?>" style="margin-top:5px;">
													<input type="text" class="input-large" id="storage_size[]" name="storage_size[]" value="<?=$storage_item->storage_size?>" placeholder="Storage Sizes">
													<div class="input-prepend input-append">
														<?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?>
														<input type="number" class="input-small" id="storage_price[]" name="storage_price[]" value="<?=$storage_item->storage_price?>" placeholder="Price">
														<?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?>
													</div>
													<a href="javascript:void(0);" class="remove_storage_item" id="rm_<?=$key?>"><i class="icon-remove-sign"></i></a>
												</div>
												<script>remove_storage_item();</script>
											<?php
											}
										} ?>
										</div>
									</div>
									<div class="control-group">
										<div class="controls">
											 <a id="storage_plus_icon" class="btn btn-info btn-alt"><i class="icon-plus"></i> Add</a>
										</div>
									</div>
									<div class="form-actions">
										<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button> <a href="mobile.php" class="btn btn-alt btn-large btn-black">Back</a>
									</div>
								</div>
								<div class="tab-pane" id="tab3">
									<h3>Condition</h3>
									<div class="control-group">
										<label class="control-label" for="input">Tooltip of Condition</label>
										<div class="controls">
											<textarea class="form-control wysihtml5" name="tooltip_condition" rows="5"><?=$mobile_data['tooltip_condition']?></textarea>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label" for="input">Add Conditions</label>
									</div>
									<div class="control-group" id="add_condition_item">
										<?php
										$condition_items_array = json_decode($mobile_data['conditions']);
										if(!empty($condition_items_array)) {
											foreach($condition_items_array as $c_key=>$condition_data) { ?>

												<div class="row" id="cnd<?=$c_key?>" style="margin-top:5px;">
													<div class="span1.5">
														<div class="control-group">
															<label class="control-label" for="input">Name</label>
															<div class="controls">
																 <input type="text" class="input-small" id="condition_name[]" name="condition_name[]" value="<?=$condition_data->condition_name?>" placeholder="Name">
															</div>
														</div>
													</div>
													<div class="span1.5">
														<div class="control-group">
															<label class="control-label" for="input">Price</label>
															<div class="controls">
																<div class="input-prepend input-append">
																 <?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?>
																 <input type="number" class="input-small" id="condition_price[]" name="condition_price[]" value="<?=$condition_data->condition_price?>" placeholder="Price">
																 <?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?>
																 </div>
															</div>
														</div>
													</div>
													<div class="span2">
														<div class="control-group">
															<label class="control-label" for="input">Terms</label>
															<div class="controls">
																 <textarea class="form-control span2" name="condition_terms[]" id="condition_terms[]" placeholder="Terms"><?=$condition_data->condition_terms?></textarea>
															</div>
														</div>
													</div>
													<div class="span1.5">
														<div class="control-group">
															<label class="control-label" for="input">Network</label>
															<div class="controls">
																 <select class="span2" name="disabled_network[]" id="disabled_network[]">
																	<option value="1" <?php if($condition_data->disabled_network=='1'){echo 'selected="selected"';}?>>Enabled</option>
																	<option value="0" <?php if($condition_data->disabled_network=='0'){echo 'selected="selected"';}?>>Disabled</option>
																</select>
																<a href="javascript:void(0);" class="remove_condition_item" id="rm_cnd<?=$c_key?>"><i class="icon-remove-sign"></i></a>
															</div>
														</div>
													</div>

													<?php /*?><div class="span1">
														<div class="control-group">
															<label class="control-label" for="input">&nbsp;</label>
															<div class="controls">
																<a href="javascript:void(0);" class="remove_condition_item" id="rm_cnd<?=$c_key?>"><i class="icon-remove-sign"></i></a>
															</div>
														</div>
													</div><?php */?>
												</div>
												<script>remove_condition_item();</script>
											<?php
											}
										} ?>
									</div>
									<div class="control-group">
										<div class="controls">
											 <a id="condition_plus_icon" class="btn btn-info btn-alt"><i class="icon-plus"></i> Add</a>
										</div>
									</div>
									<div class="form-actions">
										<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button>
										<a href="mobile.php" class="btn btn-alt btn-large btn-black">Back</a>
									</div>
								</div>

								<div class="tab-pane" id="tab4">
									<h3>Network</h3>
									<div class="control-group">
										<label class="control-label" for="input">Tooltip of Network</label>
										<div class="controls">
											<textarea class="form-control wysihtml5" name="tooltip_network" rows="5"><?=$mobile_data['tooltip_network']?></textarea>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label" for="input">Add Networks</label>
									</div>
									<div class="control-group">
										<label class="control-label" for="input">Unlock Price</label>
										<div class="controls">
											 <input type="number" class="input-small" id="unlock_price" name="unlock_price" value="<?=$mobile_data['unlock_price']?>" placeholder="Unlock Price">
										</div>
									</div>

									<div class="control-group" id="add_network_item">
										<?php
										$network_items_array = json_decode($mobile_data['network']);
										if(!empty($network_items_array)) {
										foreach($network_items_array as $n_key=>$network_data) { ?>
											<div class="row" id="rmn<?=$n_key?>">
												<div class="span1.5">
													<div class="control-group">
														<label class="control-label" for="input">Name</label>
														<div class="controls">
															 <input type="text" class="input-medium" id="network_name[]" name="network_name[]" value="<?=$network_data->network_name?>" placeholder="Name">
														</div>
													</div>
												</div>
												<div class="span1.5">
													<div class="control-group">
														<label class="control-label" for="input">Price</label>
														<div class="controls">
															<div class="input-prepend input-append">
															 <?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?>
															 <input type="number" class="input-small" id="network_price[]" name="network_price[]" value="<?=$network_data->network_price?>" style="width:50px;" placeholder="Price">
															 <?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?>
															</div>
														</div>
													</div>
												</div>
												<div class="span1.5">
													<div class="control-group">
														<label class="control-label" for="input">Price Change On Unlock</label>
														<div class="controls">
															 <select class="span1" name="change_unlock[]" id="change_unlock[]">
																<option value="1" <?php if($network_data->change_unlock=='1'){echo 'selected="selected"';}?>>Yes</option>
																<option value="0" <?php if($network_data->change_unlock=='0' || $network_data->change_unlock==''){echo 'selected="selected"';}?>>No</option>
															</select>
														</div>
													</div>
												</div>
												<div class="span1.5">
													<div class="control-group">
														<label class="control-label" for="input">Most Popular</label>
														<div class="controls">
															 <select class="span1" name="most_popular[]" id="most_popular[]">
																<option value="yes" <?php if($network_data->most_popular=='yes'){echo 'selected="selected"';}?>>Yes</option>
																<option value="no" <?php if($network_data->most_popular=='no' || $network_data->most_popular==''){echo 'selected="selected"';}?>>No</option>
															</select>
														</div>
													</div>
												</div>
											</div>
											<script>remove_network_item();</script>
										<?php
										}
										} ?>
									</div>
									<div class="control-group">
										<div class="controls">
											 <a id="network_plus_icon" class="btn btn-info btn-alt"><i class="icon-plus"></i> Add</a>
										</div>
									</div>
									<div class="form-actions">
										<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button>
										<a href="mobile.php" class="btn btn-alt btn-large btn-black">Back</a>
									</div>

								</div>

								<div class="tab-pane" id="tab5">
									<h3>Colors</h3>
									<div class="control-group">
										<label class="control-label" for="input">Tooltip of Colors</label>
										<div class="controls">
											<textarea class="form-control wysihtml5" name="tooltip_colors" rows="5"><?=$mobile_data['tooltip_colors']?></textarea>
										</div>
									</div>
									<div class="control-group" id="add_colors_item">
										<div class="form-controls">
										<?php
										$colors_items_array = json_decode($mobile_data['colors']);
										if(!empty($colors_items_array)) {
											foreach($colors_items_array as $key=>$colors_item) {?>
												<div id="clr<?=$key?>" style="margin-top:5px;">
													<input type="text" class="input-large" id="color_name[]" name="color_name[]" value="<?=$colors_item->color_name?>" placeholder="Name">
													<div class="input-prepend input-append">
														<?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?>
														<input type="number" class="input-small" id="color_price[]" name="color_price[]" value="<?=$colors_item->color_price?>" placeholder="Price">
														<?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?>
													</div>
													<a href="javascript:void(0);" class="remove_colors_item" id="rm_clr<?=$key?>"><i class="icon-remove-sign"></i></a>
												</div>
												<script>remove_colors_item();</script>
											<?php
											}
										} ?>
										</div>
									</div>
									<div class="control-group">
										<div class="controls">
											 <a id="colors_plus_icon" class="btn btn-info btn-alt"><i class="icon-plus"></i> Add</a>
										</div>
									</div>
									<div class="form-actions">
										<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button> <a href="mobile.php" class="btn btn-alt btn-large btn-black">Back</a>
									</div>
								</div>

								<div class="tab-pane" id="tab6">
									<h3>Miscellaneous</h3>
									<div class="control-group">
										<label class="control-label" for="input">Tooltip of Miscellaneous</label>
										<div class="controls">
											<textarea class="form-control wysihtml5" name="tooltip_miscellaneous" rows="5"><?=$mobile_data['tooltip_miscellaneous']?></textarea>
										</div>
									</div>
									<div class="control-group" id="add_miscellaneous_item">
										<div class="form-controls">
										<?php
										$miscellaneous_items_array = json_decode($mobile_data['miscellaneous']);
										if(!empty($miscellaneous_items_array)) {
											foreach($miscellaneous_items_array as $key=>$miscellaneous_item) {?>
												<div id="misc<?=$key?>" style="margin-top:5px;">
													<input type="text" class="input-large" id="miscellaneous_name[]" name="miscellaneous_name[]" value="<?=$miscellaneous_item->miscellaneous_name?>" placeholder="Name">
													<div class="input-prepend input-append">
														<?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?>
														<input type="number" class="input-small" id="miscellaneous_price[]" name="miscellaneous_price[]" value="<?=$miscellaneous_item->miscellaneous_price?>" placeholder="Price">
														<?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?>
													</div>
													<a href="javascript:void(0);" class="remove_miscellaneous_item" id="rm_misc<?=$key?>"><i class="icon-remove-sign"></i></a>
												</div>
												<script>remove_miscellaneous_item();</script>
											<?php
											}
										} ?>
										</div>
									</div>
									<div class="control-group">
										<div class="controls">
											 <a id="miscellaneous_plus_icon" class="btn btn-info btn-alt"><i class="icon-plus"></i> Add</a>
										</div>
									</div>
									<div class="form-actions">
										<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button> <a href="mobile.php" class="btn btn-alt btn-large btn-black">Back</a>
									</div>
								</div>

								<div class="tab-pane" id="tab7">
									<h3>Accessories</h3>
									<div class="control-group">
										<label class="control-label" for="input">Tooltip of Accessories</label>
										<div class="controls">
											<textarea class="form-control wysihtml5" name="tooltip_accessories" rows="5"><?=$mobile_data['tooltip_accessories']?></textarea>
										</div>
									</div>
									<div class="control-group" id="add_accessories_item">
										<div class="form-controls">
										<?php
										$accessories_items_array = json_decode($mobile_data['accessories']);
										if(!empty($accessories_items_array)) {
											foreach($accessories_items_array as $key=>$accessories_item) {?>
												<div id="accssr<?=$key?>" style="margin-top:5px;">
													<input type="text" class="input-large" id="accessories_name[]" name="accessories_name[]" value="<?=$accessories_item->accessories_name?>" placeholder="Name">
													<div class="input-prepend input-append">
														<?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?>
														<input type="number" class="input-small" id="accessories_price[]" name="accessories_price[]" value="<?=$accessories_item->accessories_price?>" placeholder="Price">
														<?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?>
													</div>
													<a href="javascript:void(0);" class="remove_accessories_item" id="rm_accssr<?=$key?>"><i class="icon-remove-sign"></i></a>
												</div>
												<script>remove_accessories_item();</script>
											<?php
											}
										} ?>
										</div>
									</div>
									<div class="control-group">
										<div class="controls">
											 <a id="accessories_plus_icon" class="btn btn-info btn-alt"><i class="icon-plus"></i> Add</a>
										</div>
									</div>
									<div class="form-actions">
										<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button> <a href="mobile.php" class="btn btn-alt btn-large btn-black">Back</a>
									</div>
								</div>

								<div class="tab-pane" id="tab8">
									<h3>Metadata</h3>

									<div class="control-group">
                                        <label class="control-label" for="input">Meta Title</label>
                                        <div class="controls">
											<input type="text" class="input-large" id="meta_title" value="<?=$mobile_data['meta_title']?>" name="meta_title">
                                        </div>
                                    </div>

									<div class="control-group">
                                        <label class="control-label" for="input">Meta Description</label>
                                        <div class="controls">
											<textarea class="form-control" name="meta_desc" rows="4"><?=$mobile_data['meta_desc']?></textarea>
                                        </div>
                                    </div>

									<div class="control-group">
                                        <label class="control-label" for="input">Meta Keywords</label>
                                        <div class="controls">
											<textarea class="form-control" name="meta_keywords" rows="3"><?=$mobile_data['meta_keywords']?></textarea>
                                        </div>
                                    </div>

									<div class="form-actions">
										<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button> <a href="mobile.php" class="btn btn-alt btn-large btn-black">Back</a>
									</div>
								</div>

							</div>
						</div>
						<!-- Second level tabs -->
					</div>
					<input type="hidden" name="id" value="<?=@$mobile_data['id']?>" />
					</form>
                </section>
            </article>
        </div>
    </section>
	<div id="push"></div>
</div>
