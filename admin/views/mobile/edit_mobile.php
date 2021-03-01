<style type="text/css">
.condition-fields label {margin-bottom:2px !important;font-size:10px !important;}
.network-fields label {margin-bottom:2px !important;font-size:10px !important;}
</style>

<script>
function check_form(a){
	if(a.device_id.value.trim()==""){
		alert('Please select device');
		a.device_id.focus();
		a.device_id.value='';
		return false;
	}
	if(a.cat_id.value.trim()==""){
		alert('Please select category');
		a.cat_id.focus();
		a.cat_id.value='';
		return false;
	}
	if(a.title.value.trim()==""){
		alert('Please enter title');
		a.title.focus();
		a.title.value='';
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
	
	var storage_size = document.getElementsByName('storage_size[]');
	for(var i = 0; i < storage_size.length; i++) {
		if(storage_size[i].value.match(/:/g)) {
			alert("Do not allow : in storage size");
			storage_size[i].focus();
			return false;           
		}
	}
	
	var condition_name = document.getElementsByName('condition_name[]');
	for(var i = 0; i < condition_name.length; i++) {
		if(condition_name[i].value.match(/:/g)) {
			alert("Do not allow : in condition name");
			condition_name[i].focus();
			return false;           
		}
	}
	
	var network_name = document.getElementsByName('network_name[]');
	for(var i = 0; i < network_name.length; i++) {
		if(network_name[i].value.match(/:/g)) {
			alert("Do not allow : in network name");
			network_name[i].focus();
			return false;           
		}
	}
	
	if(jQuery('.summernote').summernote('codeview.isActivated')) {
		jQuery('.summernote').summernote('codeview.deactivate');
	}	
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

function removeImage(id, r_img_id) {
	swal({
		title: "Are you sure you want to delete this icon?",
		showCancelButton: true,
		type: "error",
		confirmButtonText: "OK"
	}).then(function (e) {
		if(e.value) {
			window.location.href = "controllers/mobile.php?id="+id+"&r_img_id="+r_img_id;
		}
	});
}

jQuery(document).ready(function ($) {
	$("#storage_plus_icon").on( "click", function(e) {
		var uniqueId = Math.random();
		var uniqueId = uniqueId.toString().split('.');

		var append_data='<div class="row" id="'+uniqueId[1]+'" style="margin-top:5px;">';
			append_data+='<div class="col-5"><input type="text" class="form-control m-input" id="storage_size[]" name="storage_size[]" placeholder="Storage Size"></div>';
			
			append_data+='<div class="col-3"><select class="form-control m-input" name="storage_size_postfix[]" id="storage_size_postfix[]">';
				append_data+='<option value="GB">GB</option>';
				append_data+='<option value="TB">TB</option>';
				append_data+='<option value="MB">MB</option>';
			append_data+='</select></div>';
			<?php
			if($top_seller_mode == "storage_specific") { ?>
			append_data+='<div class="col-3"><select class="form-control m-input" name="top_seller[]" id="top_seller[]" style="width:100px;">';
				append_data+='<option value=""> - Top Seller - </option>';
				append_data+='<option value="1">ON</option>';
				append_data+='<option value="0">OFF</option>';
			append_data+='</select></div>';
			<?php
			} ?>										
			append_data+='<div class="col-1"><a href="javascript:void(0);" class="remove_storage_item" id="rm_'+uniqueId[1]+'"><i class="la la-trash trash"></i></a></div>';
		 append_data+='</div>';
		$('#add_storage_item').append(append_data);
		remove_storage_item();
	});

	$("#condition_plus_icon").on( "click", function(e) {
		var uniqueId = Math.random();
		var uniqueId = uniqueId.toString().split('.');

		var append_data='<div class="row" id="'+uniqueId[1]+'" style="margin-top:5px;">';
			append_data+='<div class="col-5">';
				append_data+='<div class="form-group m-form__group">';
					append_data+='<label>Name</label>';
					append_data+='<input type="text" class="form-control m-input" id="condition_name[]" name="condition_name[]" placeholder="Name">';
				append_data+='</div>';
			append_data+='</div>';

			append_data+='<div class="col-6">';
				append_data+='<div class="form-group m-form__group">';
					append_data+='<label>Terms</label>';
						 append_data+='<textarea class="form-control" name="condition_terms[]" id="condition_terms[]" placeholder="Terms"></textarea>';
				append_data+='</div>';
			append_data+='</div>';
			append_data+='<div class="col-1">';
				append_data+='<div class="form-group m-form__group">';
					append_data+='<label>&nbsp;</label>';
						append_data+='&nbsp;<a href="javascript:void(0);" class="remove_condition_item" id="rm_'+uniqueId[1]+'"><i class="la la-trash trash"></i></a>';
				append_data+='</div>';
			append_data+='</div>';
		append_data+='</div>';

		$('#add_condition_item').append(append_data);
		remove_condition_item();
	});

	$("#network_plus_icon").on( "click", function(e) {
		var uniqueId = Math.random();
		var uniqueId = uniqueId.toString().split('.');

		var append_data='<div class="row" id="'+uniqueId[1]+'">';
			append_data+='<div class="col-5">';
				append_data+='<div class="form-group m-form__group">';
					append_data+='<label>Name</label>';
						 append_data+='<input type="text" class="form-control m-input" id="network_name[]" name="network_name[]" placeholder="Name">';
				append_data+='</div>';
			append_data+='</div>';

			append_data+='<div class="col-5">';
				append_data+='<div class="form-group m-form__group">';
					append_data+='<label>Icon</label>';
					append_data+='<input type="file" name="network_icon[]" id="network_icon[]" class="form-control m-input"/>';
				append_data+='</div>';
			append_data+='</div>';
			
			append_data+='<div class="col-1">';
				append_data+='<div class="form-group m-form__group">';
					append_data+='<label>&nbsp;</label>';
					append_data+='&nbsp;<a href="javascript:void(0);" class="remove_network_item" id="rm_'+uniqueId[1]+'"><i class="la la-trash trash"></i></a>';
				append_data+='</div>';
			append_data+='</div>';
			
		append_data+='</div>';

		$('#add_network_item').append(append_data);
		remove_network_item();
	});
	
	$("#connectivity_plus_icon").on( "click", function(e) {
		var uniqueId = Math.random();
		var uniqueId = uniqueId.toString().split('.');

		var append_data='<div class="row" id="'+uniqueId[1]+'" style="margin-top:5px;">';
			 append_data+='<div class="col-6"><input type="text" class="form-control m-input" id="connectivity_name[]" name="connectivity_name[]" placeholder="Name"></div>';
			 append_data+='<div class="col-1"><a href="javascript:void(0);" class="remove_connectivity_item" id="rm_'+uniqueId[1]+'"><i class="la la-trash trash"></i></a></div>';
		 append_data+='</div>';
		$('#add_connectivity_item').append(append_data);
		remove_connectivity_item();
	});
	
	$("#model_plus_icon").on( "click", function(e) {
		var uniqueId = Math.random();
		var uniqueId = uniqueId.toString().split('.');

		var append_data='<div class="row" id="'+uniqueId[1]+'" style="margin-top:5px;">';
			 append_data+='<div class="col-6"><input type="text" class="form-control m-input" id="model_name[]" name="model_name[]" placeholder="Name"></div>';
			 append_data+='<div class="col-1"><a href="javascript:void(0);" class="remove_model_item" id="rm_'+uniqueId[1]+'"><i class="la la-trash trash"></i></a></div>';
		 append_data+='</div>';
		$('#add_model_item').append(append_data);
		remove_model_item();
	});
	
	$("#graphics_card_plus_icon").on( "click", function(e) {
		var uniqueId = Math.random();
		var uniqueId = uniqueId.toString().split('.');

		var append_data='<div class="row" id="'+uniqueId[1]+'" style="margin-top:5px;">';
			 append_data+='<div class="col-6"><input type="text" class="form-control m-input" id="graphics_card_name[]" name="graphics_card_name[]" placeholder="Name"></div>';
			 append_data+='<div class="col-1"><a href="javascript:void(0);" class="remove_graphics_card_item" id="rm_'+uniqueId[1]+'"><i class="la la-trash trash"></i></a></div>';
		 append_data+='</div>';
		$('#add_graphics_card_item').append(append_data);
		remove_graphics_card_item();
	});

	$("#case_size_plus_icon").on( "click", function(e) {
		var uniqueId = Math.random();
		var uniqueId = uniqueId.toString().split('.');

		var append_data='<div class="row" id="'+uniqueId[1]+'" style="margin-top:5px;">';
			 append_data+='<div class="col-6"><input type="text" class="form-control m-input" id="case_size[]" name="case_size[]" placeholder="Case Size"></div>';
			 append_data+='<div class="col-1"><a href="javascript:void(0);" class="remove_case_size_item" id="rm_'+uniqueId[1]+'"><i class="la la-trash trash"></i></a></div>';
		 append_data+='</div>';
		$('#add_case_size_item').append(append_data);
		remove_case_size_item();
	});

	$("#watchtype_plus_icon").on( "click", function(e) {
		var uniqueId = Math.random();
		var uniqueId = uniqueId.toString().split('.');

		var append_data='<div class="row" id="'+uniqueId[1]+'" style="margin-top:5px;">';
			 append_data+='<input type="text" class="form-control m-input" id="watchtype_name[]" name="watchtype_name[]" placeholder="Name"> ';
			 append_data+='&nbsp;<a href="javascript:void(0);" class="remove_watchtype_item" id="rm_'+uniqueId[1]+'"><i class="la la-trash trash"></i></a>';
		 append_data+='</div>';
		$('#add_watchtype_item').append(append_data);
		remove_watchtype_item();
	});
	
	$("#case_material_plus_icon").on( "click", function(e) {
		var uniqueId = Math.random();
		var uniqueId = uniqueId.toString().split('.');

		var append_data='<div class="row" id="'+uniqueId[1]+'" style="margin-top:5px;">';
			 append_data+='<input type="text" class="form-control m-input" id="case_material_name[]" name="case_material_name[]" placeholder="Name"> ';
			 append_data+='&nbsp;<a href="javascript:void(0);" class="remove_case_material_item" id="rm_'+uniqueId[1]+'"><i class="la la-trash trash"></i></a>';
		 append_data+='</div>';
		$('#add_case_material_item').append(append_data);
		remove_case_material_item();
	});
	
	$("#accessories_plus_icon").on( "click", function(e) {
		var uniqueId = Math.random();
		var uniqueId = uniqueId.toString().split('.');

		var append_data='<div class="row" id="'+uniqueId[1]+'" style="margin-top:5px;">';
			 append_data+='<div class="col-6"><input type="text" class="form-control m-input" id="accessories_name[]" name="accessories_name[]" placeholder="Name"></div>';
			 append_data+='<div class="col-3"><input type="number" class="form-control m-input" id="accessories_price[]" name="accessories_price[]" placeholder="Price"><?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?></div>';
			 append_data+='<div class="col-1"><a href="javascript:void(0);" class="remove_accessories_item" id="rm_'+uniqueId[1]+'"><i class="la la-trash trash"></i></a></div>';
		 append_data+='</div>';
		$('#add_accessories_item').append(append_data);
		remove_accessories_item();
	});
	
	$("#band_included_plus_icon").on( "click", function(e) {
		var uniqueId = Math.random();
		var uniqueId = uniqueId.toString().split('.');

		var append_data='<div class="row" id="'+uniqueId[1]+'" style="margin-top:5px;">';
			 append_data+='<div class="col-6"><input type="text" class="form-control m-input" id="band_included_name[]" name="band_included_name[]" placeholder="Name"></div>';
			 
			 append_data+='<div class="col-3"><input type="number" class="form-control m-input" id="band_included_price[]" name="band_included_price[]" placeholder="Price"></div>';
			 
			 append_data+='<div class="col-1"><a href="javascript:void(0);" class="remove_band_included_item" id="rm_'+uniqueId[1]+'"><i class="la la-trash trash"></i></a></div>';
		 append_data+='</div>';
		$('#add_band_included_item').append(append_data);
		remove_band_included_item();
	});

	$("#processor_plus_icon").on( "click", function(e) {
		var uniqueId = Math.random();
		var uniqueId = uniqueId.toString().split('.');

		var append_data='<div class="row" id="'+uniqueId[1]+'" style="margin-top:5px;">';
			 append_data+='<div class="col-6"><input type="text" class="form-control m-input" id="processor_name[]" name="processor_name[]" placeholder="Name"></div>';
			 
			 <?php /*?>append_data+='<div class="input-prepend input-append"><?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?><input type="number" class="form-control m-input" id="processor_price[]" name="processor_price[]" placeholder="Price"><?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?></div>';<?php */?>
			 
			 append_data+='<div class="col-1"><a href="javascript:void(0);" class="remove_processor_item" id="rm_'+uniqueId[1]+'"><i class="la la-trash trash"></i></a></div>';
		 append_data+='</div>';
		$('#add_processor_item').append(append_data);
		remove_processor_item();
	});
	
	$("#ram_plus_icon").on( "click", function(e) {
		var uniqueId = Math.random();
		var uniqueId = uniqueId.toString().split('.');

		var append_data='<div class="row" id="'+uniqueId[1]+'" style="margin-top:5px;">';
			 append_data+='<div class="col-5"><input type="text" class="form-control m-input" id="ram_size[]" name="ram_size[]" placeholder="Ram Size"></div>';
			
			 append_data+='<div class="col-3"><select class="form-control m-input" name="ram_size_postfix[]" id="ram_size_postfix[]">';
				append_data+='<option value="GB">GB</option>';
				append_data+='<option value="TB">TB</option>';
				append_data+='<option value="MB">MB</option>';
			 append_data+='</select></div>';
			 
			 <?php /*?>append_data+='<div class="input-prepend input-append"><?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?><input type="number" class="form-control m-input" id="ram_price[]" name="ram_price[]" placeholder="Price"><?=($amount_sign_with_postfix?'<span class="add-on">'.$amount_sign_with_postfix.'</span>':'')?></div>';<?php */?>
			 
			 append_data+='<div class="col-1"><a href="javascript:void(0);" class="remove_ram_item" id="rm_'+uniqueId[1]+'"><i class="la la-trash trash"></i></a></div>';
		 append_data+='</div>';
		$('#add_ram_item').append(append_data);
		remove_ram_item();
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

function remove_connectivity_item() {
	$(".remove_connectivity_item").on("click", function(e) {
		var uniqueId = $(this).attr('id').toString().split('_');
		$('#'+uniqueId[1]).remove();
	});
}

function remove_model_item() {
	$(".remove_model_item").on("click", function(e) {
		var uniqueId = $(this).attr('id').toString().split('_');
		$('#'+uniqueId[1]).remove();
	});
}

function remove_graphics_card_item() {
	$(".remove_graphics_card_item").on("click", function(e) {
		var uniqueId = $(this).attr('id').toString().split('_');
		$('#'+uniqueId[1]).remove();
	});
}

function remove_watchtype_item() {
	$(".remove_watchtype_item").on("click", function(e) {
		var uniqueId = $(this).attr('id').toString().split('_');
		$('#'+uniqueId[1]).remove();
	});
}

function remove_case_material_item() {
	$(".remove_case_material_item").on("click", function(e) {
		var uniqueId = $(this).attr('id').toString().split('_');
		$('#'+uniqueId[1]).remove();
	});
}

function remove_case_size_item() {
	$(".remove_case_size_item").on("click", function(e) {
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

function remove_band_included_item() {
	$(".remove_band_included_item").on("click", function(e) {
		var uniqueId = $(this).attr('id').toString().split('_');
		$('#'+uniqueId[1]).remove();
	});
}

function remove_processor_item() {
	$(".remove_processor_item").on("click", function(e) {
		var uniqueId = $(this).attr('id').toString().split('_');
		$('#'+uniqueId[1]).remove();
	});
}

function remove_ram_item() {
	$(".remove_ram_item").on("click", function(e) {
		var uniqueId = $(this).attr('id').toString().split('_');
		$('#'+uniqueId[1]).remove();
	});
}
</script>

<?php
$fields_cat_type = $mobile_data['fields_type']; ?>


<!-- begin:: Page -->
<div class="m-grid m-grid--hor m-grid--root m-page">
<!-- BEGIN: Header -->
<?php include("include/admin_menu.php"); ?>
<!-- END: Header -->

<!-- begin::Body -->
<div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
  <!-- BEGIN: Left Aside -->
  <?php include("include/navigation.php"); ?>
  <!-- END: Left Aside -->
	<div class="m-grid__item m-grid__item--fluid m-wrapper">

		<div class="m-content">
			<?php include('confirm_message.php'); ?>
			<div class="row">
				<div class="col-lg-12">

					<!--begin::Portlet-->
					<div class="m-portlet">
						<div class="m-portlet__head">
							<div class="m-portlet__head-caption">
								<div class="m-portlet__head-title">
									<span class="m-portlet__head-icon m--hide">
										<i class="la la-gear"></i>
									</span>
									<h3 class="m-portlet__head-text">
										<?php
										if($id!='') {
											if($pricing_tb==1) {
												echo 'Edit Pricing <small><b>For '.$mobile_data['title'].'</b></small>';
											} else {
												echo 'Edit Model';
											}
										} else {
											echo 'Add Model';
										} ?>
									</h3>
								</div>
							</div>
							<div class="m-portlet__head-tools">
								<ul class="m-portlet__nav">
									<?php
									if($id!='') {
										if($pricing_tb==1) { ?>
											<li class="m-portlet__nav-item">
												<a href="edit_mobile.php?id=<?=$id?>" class="btn btn-secondary m-btn m-btn--custom btn-sm"><span>Back</span></a>
											</li>
										<?php
										} else { ?>
											<li class="m-portlet__nav-item">
												<a href="controllers/mobile.php?id=<?=$id?>&action=set_default_fields&fields_type=<?=$fields_cat_type?>" onclick="return confirm('Are you sure you want to reset master options from category, it will delete current model specific options and reset to master options value?');" class="btn btn-accent m-btn m-btn--custom btn-sm"><span>Reset To Master Options</span></a>
											</li>
										<?php
										}
									} ?>
								</ul>
							</div>
						</div>
						
						<form class="m-form" action="controllers/mobile.php" role="form" method="post" onSubmit="return check_form(this);" enctype="multipart/form-data">
							<div class="m-portlet__body">
								<div class="m-form__section m-form__section--first">
								
									<div class="row">
										<?php
										if($pricing_tb!=1) { ?>
										<div class="col-md-2">
											<ul class="nav nav-tabs flex-column nav-pills vartical-tab  m-tabs-line m-tabs-line--success" role="tablist">
												<li class="nav-item m-tabs__item"><a href="#tab1" data-toggle="tab" class="nav-link m-tabs__link active show">Basic</a></li>
												<li class="nav-item m-tabs__item"><a href="#tab8" data-toggle="tab" class="nav-link m-tabs__link">Metadata</a></li>
												<?php
												if($fields_cat_type == "mobile") { ?>
													<li class="nav-item m-tabs__item"><a href="#tab4" data-toggle="tab" class="nav-link m-tabs__link">Carrier</a></li>
													<li class="nav-item m-tabs__item"><a href="#tab2" data-toggle="tab" class="nav-link m-tabs__link">Storage</a></li>
													<li class="nav-item m-tabs__item"><a href="#tab3" data-toggle="tab" class="nav-link m-tabs__link">Condition</a></li>
													<li class="nav-item m-tabs__item"><a href="#tab12" data-toggle="tab" class="nav-link m-tabs__link">Accessories</a></li>
												<?php
												}
												if($fields_cat_type == "tablet") { ?>
													<li class="nav-item m-tabs__item"><a href="#tab5" data-toggle="tab" class="nav-link m-tabs__link">Connectivity</a></li>
													<li class="nav-item m-tabs__item"><a href="#tab2" data-toggle="tab" class="nav-link m-tabs__link">Storage</a></li>
													<li class="nav-item m-tabs__item"><a href="#tab3" data-toggle="tab" class="nav-link m-tabs__link">Condition</a></li>
													<li class="nav-item m-tabs__item"><a href="#tab12" data-toggle="tab" class="nav-link m-tabs__link">Accessories</a></li>
												<?php
												}
												if($fields_cat_type == "watch") { ?>
													<li class="nav-item m-tabs__item"><a href="#tab5" data-toggle="tab" class="nav-link m-tabs__link">Connectivity</a></li>
													<li class="nav-item m-tabs__item"><a href="#tab6" data-toggle="tab" class="nav-link m-tabs__link">Size</a></li>
													<li class="nav-item m-tabs__item"><a href="#tab19" data-toggle="tab" class="nav-link m-tabs__link">Model</a></li>
													<li class="nav-item m-tabs__item"><a href="#tab3" data-toggle="tab" class="nav-link m-tabs__link">Condition</a></li>
													<li class="nav-item m-tabs__item"><a href="#tab18" data-toggle="tab" class="nav-link m-tabs__link">Band Included</a></li>
													<li class="nav-item m-tabs__item"><a href="#tab12" data-toggle="tab" class="nav-link m-tabs__link">Accessories</a></li>
												<?php
												}
												if($fields_cat_type == "laptop") { ?>
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
												<li class="nav-item m-tabs__item"><a href="#tab19" data-toggle="tab" class="nav-link m-tabs__link">Model</a></li>
												<li class="nav-item m-tabs__item"><a href="#tab3" data-toggle="tab" class="nav-link m-tabs__link">Condition</a></li>
												<li class="nav-item m-tabs__item"><a href="#tab12" data-toggle="tab" class="nav-link m-tabs__link">Accessories</a></li>
												<?php
												}
												if($id>0) { ?>
												<?php /*?><li class="nav-item m-tabs__item"><a href="#tab9" data-toggle="tab" class="nav-link m-tabs__link">Pricing</a></li><?php */?>
												<?php /*?><li class="nav-item m-tabs__item"><a href="edit_mobile.php?id=<?=$id?>&pricing=1" class="nav-link m-tabs__link">Pricing</a></li><?php */?>
												<li class="nav-item m-tabs__item"><a href="#" class="nav-link m-tabs__link" onclick="PricingModal();return false;">Pricing</a></li>
												
												<?php
												} ?>
											</ul>
										</div>
										<?php
										} ?>
										
										<div class="col-md-<?=($pricing_tb!=1?10:12)?>">
											<div class="tab-content">
												<?php
												if($pricing_tb!='1') { ?>
												<div class="tab-pane active show" id="tab1" role="tabpanel">
													<div class="m-portlet">
														<div class="m-portlet__body">
															<div class="form-group row">
																<div class="col-lg-4">
																	<label for="cat_id">Select Category</label>
																	<select class="form-control m-input custom-select" <?php if(!$id){echo 'name="cat_id" id="cat_id" onchange="get_cat_custom_fields(this.value);"';}else{echo 'disabled="disabled"';}?>>
																		<option value=""> - Select - </option>
																		<?php
																		//Fetch device list
																		$categories_data=mysqli_query($db,'SELECT * FROM categories WHERE published=1');
																		while($categories_list=mysqli_fetch_assoc($categories_data)) { ?>
																			<option value="<?=$categories_list['id']?>" <?php if($categories_list['id']==$mobile_data['cat_id']){echo 'selected="selected"';}?> data-fields-type="<?=$categories_list['fields_type']?>"><?=$categories_list['title']?></option>
																		<?php
																		} ?>
																	</select>
																	<?php
																	if($id>0) {
																		echo '<input type="hidden" name="cat_id" id="cat_id" value="'.$mobile_data['cat_id'].'" />';
																	} ?>
																</div>
																<div class="col-lg-4">
																	<label for="brand_id">Select Brand</label>
																	<select class="form-control m-input custom-select" name="brand_id" id="brand_id">
																		<option value=""> - Select - </option>
																		<?php
																		while($brands_list=mysqli_fetch_assoc($brands_data)) { ?>
																			<option value="<?=$brands_list['id']?>" <?php if($brands_list['id']==$mobile_data['brand_id']){echo 'selected="selected"';}?>><?=$brands_list['title']?></option>
																		<?php
																		} ?>
																	</select>
																</div>
																<div class="col-lg-4">
																	<label for="device_id">Select Device</label>
																	<select class="form-control m-input custom-select" name="device_id" id="device_id">
																		<option value=""> - Select - </option>
																		<?php
																		//Fetch device list
																		$devices_data=mysqli_query($db,'SELECT * FROM devices WHERE published=1');
																		while($devices_list=mysqli_fetch_assoc($devices_data)) { ?>
																			<option value="<?=$devices_list['id']?>" <?php if($devices_list['id']==$mobile_data['device_id']){echo 'selected="selected"';}?>><?=$devices_list['title']?></option>
																		<?php
																		} ?>
																	</select>
																</div>
															</div>
															<div class="form-group row">
																<div class="col-lg-12">
																	<label for="title">Title</label>
																	<input type="text" class="form-control m-input m-input--square" id="title" value="<?=$mobile_data['title']?>" name="title">
																</div>
																<?php /*?><div class="col-lg-6">
																	<label for="price">Base Price</label>
																	<input type="number" class="form-control m-input m-input--square" id="price" value="<?=($mobile_data['price']>0?$mobile_data['price']:'')?>" name="price">
																</div><?php */?>
															</div>
															
															<?php
															if($tooltips_of_model_fields == '1') { ?>
															<div class="form-group">
																<label for="tooltip_device">Tooltip of Device</label>
																<textarea class="form-control m-input summernote" name="tooltip_device" rows="5"><?=$mobile_data['tooltip_device']?></textarea>
															</div>
															<?php
															} ?>
															
															<div class="form-group row">
																<div class="col-lg-6">
																	<label for="model_img">Model Image</label>
																	<div class="custom-file">
																	<label class="custom-file-label" for="model_img">Choose file</label>
																	<input type="file" class="custom-file-input" id="model_img" name="model_img" onChange="checkFile(this);" accept="image/*">
																	</div>
																	<?php 
																	if($mobile_data['model_img']!="") { ?>
																		<img class="m--margin-top-10" src="../images/mobile/<?=$mobile_data['model_img']?>" width="100">
																		<a class="btn btn-sm btn-danger" href="javascript:void(0);" onclick="removeImage('<?=$mobile_data['id']?>','<?=$mobile_data['id']?>')"><i class="la la-trash"></i> Remove</a>
																		<input type="hidden" id="old_image" name="old_image" value="<?=$mobile_data['model_img']?>">
																	<?php 
																	} ?>
																</div>
															</div>
															
															<div class="form-group">
																<div class="m-checkbox-inline">
																	<label class="m-checkbox">
																		<input type="checkbox" id="top_seller" value="1" name="top_seller" <?php if($mobile_data['top_seller']=='1'){echo 'checked="checked"';}?>>
																		<span></span> Top Seller
																	</label>
																</div>
															</div>
															
															<div class="m-form__group form-group">
																<label for="">
																	Publish :
																</label>
																<div class="m-radio-inline">
																	<label class="m-radio">
																		<input type="radio" id="published" name="published" value="1" <?=($mobile_data['published']==1||$mobile_data['published']==''?'checked="checked"':'')?>>
																		Yes
																		<span></span>
																	</label>
																	<label class="m-radio">
																		<input type="radio"  id="published" name="published" value="0" <?=($mobile_data['published']=='0'?'checked="checked"':'')?>>
																		No
																		<span></span>
																	</label>
																</div>
															</div>
																
															<!--<div class="form-actions">
																<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button> <a href="mobile.php" class="btn btn-alt btn-large btn-black">Back</a>
															</div>-->
														</div>
													</div>
												</div>
												
												<div class="tab-pane" id="tab2">
													<div class="m-portlet">
														<div class="m-portlet__body">
															<!--<h3>Storage</h3>-->
															<div class="form-group m-form__group">
																<label>Add Storage</label>
															</div>
															<div class="form-group m-form__group" id="add_storage_item">
																<div class="form-controls">
																<?php
																if(!empty($storage_items_array)) {
																	foreach($storage_items_array as $key=>$storage_item) {
																		$storage_id = $storage_item['id']; ?>
																		<div class="row" id="<?=$key?>" style="margin-top:5px;">
																			<div class="col-5">
																			<input type="text" class="form-control m-input" id="storage_size[<?=$storage_id?>]" name="storage_size[<?=$storage_id?>]" value="<?=html_entities($storage_item['storage_size'])?>" placeholder="Storage Sizes" readonly="readonly">
																			</div>
																			<div class="col-2">
																			<select class="form-control m-input" name="storage_size_postfix[<?=$storage_id?>]" id="storage_size_postfix[<?=$storage_id?>]" style="width:70px;">
																				<option value="GB" <?php if($storage_item['storage_size_postfix']=='GB'){echo 'selected="selected"';}?>>GB</option>
																				<option value="TB" <?php if($storage_item['storage_size_postfix']=='TB'){echo 'selected="selected"';}?>>TB</option>
																				<option value="MB" <?php if($storage_item['storage_size_postfix']=='MB'){echo 'selected="selected"';}?>>MB</option>
																			</select>
																			</div>
																			<?php
																			if($top_seller_mode == "storage_specific") { ?>
																			<div class="col-3">
																			<select class="form-control m-input" name="top_seller[<?=$storage_id?>]" id="top_seller[<?=$storage_id?>]" style="width:100px;">
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
															</div>
															<!--<div class="form-group m-form__group">
																<a id="storage_plus_icon" class="btn btn-md btn-success"><i class="fa fa-plus"></i> Add</a>
															</div>-->
															<!--<div class="form-actions">
																<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button> <a href="mobile.php" class="btn btn-alt btn-large btn-black">Back</a>
															</div>-->
														</div>
													</div>
												</div>
												<div class="tab-pane" id="tab3">
													<div class="m-portlet">
														<div class="m-portlet__body">
													<!--<h3>Condition</h3>-->
													<div class="form-group m-form__group">
														<label>Add Condition</label>
													</div>
													<div class="form-group m-form__group" id="add_condition_item">
														<?php
														if(!empty($condition_items_array)) {
															foreach($condition_items_array as $c_key=>$condition_data) {
																$condition_id = $condition_data['id']; ?>
				
																<div class="row" id="cnd<?=$c_key?>" style="margin-top:5px;">
																	<div class="col-5">
																		<div class="form-group m-form__group">
																			<label>Name</label>
																			<input type="text" class="form-control m-input" id="condition_name[<?=$condition_id?>]" name="condition_name[<?=$condition_id?>]" value="<?=html_entities($condition_data['condition_name'])?>" placeholder="Name" readonly="readonly">
																		</div>
																	</div>
																	<div class="col-6">
																		<div class="form-group m-form__group">
																			<label>Terms</label>
																			<textarea class="form-control span5" name="condition_terms[<?=$condition_id?>]" id="condition_terms[<?=$condition_id?>]" placeholder="Terms" readonly="readonly"><?=$condition_data['condition_terms']?></textarea>
																		</div>
																	</div>
				
																	<div class="col-1">
																		<div class="form-group m-form__group">
																			<label>&nbsp;</label>
																			<a href="javascript:void(0);" class="remove_condition_item" id="rm_cnd<?=$c_key?>"><i class="la la-trash trash"></i></a>
																		</div>
																	</div>
																</div>
																<script>remove_condition_item();</script>
															<?php
															}
														} ?>
													</div>
													<!--<div class="form-group m-form__group">
															<a id="condition_plus_icon" class="btn btn-md btn-success"><i class="fa fa-plus"></i> Add</a>
													</div>-->
													<!--<div class="form-actions">
														<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button>
														<a href="mobile.php" class="btn btn-alt btn-large btn-black">Back</a>
													</div>-->
													</div>
													</div>
												</div>
				
												<div class="tab-pane" id="tab4">
													<div class="m-portlet">
														<div class="m-portlet__body">
													<!--<h3>Carrier</h3>-->
													<div class="form-group m-form__group">
														<label>Add Carrier</label>
													</div>
				
													<div class="form-group m-form__group network-fields" id="add_network_item">
														<?php
														if(!empty($network_items_array)) {
															foreach($network_items_array as $n_key=>$network_data) {
																$network_id = $network_data['id']; ?>
																<div class="row" id="nvk<?=$n_key?>">
																	<div class="col-5">
																		<div class="form-group m-form__group">
																			<label>Name</label>
																				 <input type="text" class="form-control m-input" id="network_name[<?=$network_id?>]" name="network_name[<?=$network_id?>]" value="<?=html_entities($network_data['network_name'])?>" placeholder="Name" readonly="readonly">
																		</div>
																	</div>
																	<div class="col-5">
																		<div class="form-group m-form__group">
																			<label>Icon</label>
																			 <input type="file" name="network_icon[<?=$network_id?>]" id="network_icon[<?=$network_id?>]" disabled="disabled"/>
																			 <input type="hidden" name="old_network_icon[<?=$network_id?>]" id="old_network_icon[<?=$network_id?>]" value="<?=$network_data['network_icon']?>"/>
																		</div>
																	</div>
																	<div class="col-1">
																		<div class="form-group m-form__group">
																			<label>&nbsp;</label>
																			<?php
																			if($network_data['network_icon']) { ?>
																				<img src="../images/network/<?=$network_data['network_icon']?>" width="25" height="25"/>
																				<a href="javascript:void(0);" class="remove_network_icon" id="network_icon_<?=$network_id?>" data-field_id="<?=$network_id?>"><i class="la la-trash trash"></i></a>
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
														} ?>
													</div>
													<!--<div class="form-group m-form__group">
															 <a id="network_plus_icon" class="btn btn-md btn-success"><i class="fa fa-plus"></i> Add</a>
													</div>-->
													<!--<div class="form-actions">
														<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button>
														<a href="mobile.php" class="btn btn-alt btn-large btn-black">Back</a>
													</div>-->
													</div>
													</div>
												</div>
				
												<div class="tab-pane" id="tab5">
													<div class="m-portlet">
														<div class="m-portlet__body">
															<!--<h3>Connectivity Fields</h3>-->
															<div class="form-group m-form__group">
																<label>Add Connectivity</label>
															</div>
															<div class="form-group m-form__group" id="add_connectivity_item">
																<div class="form-controls">
																<?php
																if(!empty($connectivity_items_array)) {
																	foreach($connectivity_items_array as $key=>$connectivity_item) {
																		$connectivity_id = $connectivity_item['id']; ?>
																		<div class="row" id="clr<?=$key?>" style="margin-top:5px;">
																			<div class="col-6"><input type="text" class="form-control m-input" id="connectivity_name[<?=$connectivity_id?>]" name="connectivity_name[<?=$connectivity_id?>]" value="<?=$connectivity_item['connectivity_name']?>" placeholder="Name" readonly="readonly"></div>
																			<div class="col-1">
																			<a href="javascript:void(0);" class="remove_connectivity_item" id="rm_clr<?=$key?>"><i class="la la-trash trash"></i></a>
																			</div>
																		</div>
																		<script>remove_connectivity_item();</script>
																	<?php
																	}
																} ?>
																</div>
															</div>
															<!--<div class="form-group m-form__group">
																	 <a id="connectivity_plus_icon" class="btn btn-md btn-success"><i class="fa fa-plus"></i> Add</a>
															</div>-->
															<!--<div class="form-actions">
																<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button> <a href="mobile.php" class="btn btn-alt btn-large btn-black">Back</a>
															</div>-->
														</div>
													</div>
												</div>
												
												<div class="tab-pane" id="tab19">
													<div class="m-portlet">
														<div class="m-portlet__body">
															<!--<h3>Model Fields</h3>-->
															<div class="form-group m-form__group">
																<label>Add Model</label>
															</div>
															<div class="form-group m-form__group" id="add_model_item">
																<div class="form-controls">
																<?php
																if(!empty($model_items_array)) {
																	foreach($model_items_array as $key=>$model_item) {
																		$model_id = $model_item['id']; ?>
																		<div class="row" id="ml<?=$key?>" style="margin-top:5px;">
																			<div class="col-6">
																			<input type="text" class="form-control m-input" id="model_name[<?=$model_id?>]" name="model_name[<?=$model_id?>]" value="<?=$model_item['model_name']?>" placeholder="Name" readonly="readonly">
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
															</div>
															<!--<div class="form-group m-form__group">
																	<a id="model_plus_icon" class="btn btn-md btn-success"><i class="fa fa-plus"></i> Add</a>
															</div>-->
															<!--<div class="form-actions">
																<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button> <a href="mobile.php" class="btn btn-alt btn-large btn-black">Back</a>
															</div>-->
														</div>
													</div>
												</div>
												
												<div class="tab-pane" id="tab20">
													<div class="m-portlet">
														<div class="m-portlet__body">
															<!--<h3>Graphics Card Fields</h3>-->
															<div class="form-group m-form__group">
																<label>Add Graphics Card</label>
															</div>
															<div class="form-group m-form__group" id="add_graphics_card_item">
																<div class="form-controls">
																<?php
																if(!empty($graphics_card_items_array)) {
																	foreach($graphics_card_items_array as $key=>$graphics_card_item) {
																		$graphics_card_id = $graphics_card_item['id']; ?>
																		<div class="row" id="gc<?=$key?>" style="margin-top:5px;">
																			<div class="col-6">
																				<input type="text" class="form-control m-input" id="graphics_card_name[<?=$graphics_card_id?>]" name="graphics_card_name[<?=$graphics_card_id?>]" value="<?=$graphics_card_item['graphics_card_name']?>" placeholder="Name" readonly="readonly">
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
															</div>
															<!--<div class="form-group m-form__group">
																	 <a id="graphics_card_plus_icon" class="btn btn-md btn-success"><i class="fa fa-plus"></i> Add</a>
															</div>-->
															<!--<div class="form-actions">
																<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button> <a href="mobile.php" class="btn btn-alt btn-large btn-black">Back</a>
															</div>-->
														</div>
													</div>
												</div>
									
												<div class="tab-pane" id="tab6">
													<div class="m-portlet">
														<div class="m-portlet__body">
															<!--<h3>Case Size Fields</h3>-->
															<div class="form-group m-form__group">
																<label>Add Size</label>
															</div>
															<div class="form-group m-form__group" id="add_case_size_item">
																<div class="form-controls">
																<?php
																if(!empty($case_size_items_array)) {
																	foreach($case_size_items_array as $key=>$case_size_item) {
																		$case_size_id = $case_size_item['id']; ?>
																		<div class="row" id="misc<?=$key?>" style="margin-top:5px;">
																			<div class="col-6">
																			<input type="text" class="form-control m-input" id="case_size[<?=$case_size_id?>]" name="case_size[<?=$case_size_id?>]" value="<?=html_entities($case_size_item['case_size'])?>" placeholder="Case Size" readonly="readonly">
																			</div>
																			<div class="col-1">
																			<a href="javascript:void(0);" class="remove_case_size_item" id="rm_misc<?=$key?>"><i class="la la-trash trash"></i></a>
																			</div>
																		</div>
																		<script>remove_case_size_item();</script>
																	<?php
																	}
																} ?>
																</div>
															</div>
															<!--<div class="form-group m-form__group">
																	 <a id="case_size_plus_icon" class="btn btn-md btn-success"><i class="fa fa-plus"></i> Add</a>
															</div>-->
															<!--<div class="form-actions">
																<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button> <a href="mobile.php" class="btn btn-alt btn-large btn-black">Back</a>
															</div>-->
														</div>
													</div>
												</div>
									
												<div class="tab-pane" id="tab7">
													<div class="m-portlet">
														<div class="m-portlet__body">
															<!--<h3>Type Fields</h3>-->
															<div class="form-group m-form__group">
																<label>Add Type</label>
															</div>
															<div class="form-group m-form__group" id="add_watchtype_item">
																<div class="form-controls">
																<?php
																if(!empty($watchtype_items_array)) {
																	foreach($watchtype_items_array as $key=>$watchtype_item) {
																		$watchtype_id = $watchtype_item['id']; ?>
																		<div id="accssr<?=$key?>" style="margin-top:5px;">
																			<input type="text" class="form-control m-input" id="watchtype_name[<?=$watchtype_id?>]" name="watchtype_name[<?=$watchtype_id?>]" value="<?=html_entities($watchtype_item['watchtype_name'])?>" placeholder="Name" readonly="readonly">
																			<a href="javascript:void(0);" class="remove_watchtype_item" id="rm_accssr<?=$key?>"><i class="la la-trash trash"></i></a>
																		</div>
																		<script>remove_watchtype_item();</script>
																	<?php
																	}
																} ?>
																</div>
															</div>
															<!--<div class="form-group m-form__group">
																	 <a id="watchtype_plus_icon" class="btn btn-md btn-success"><i class="fa fa-plus"></i> Add</a>
															</div>-->
															<!--<div class="form-actions">
																<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button> <a href="mobile.php" class="btn btn-alt btn-large btn-black">Back</a>
															</div>-->
														</div>
													</div>
												</div>
												
												<div class="tab-pane" id="tab10">
													<div class="m-portlet">
														<div class="m-portlet__body">
															<!--<h3>Type Fields</h3>-->
															<div class="form-group m-form__group">
																<label>Add Case Material</label>
															</div>
															<div class="form-group m-form__group" id="add_case_material_item">
																<div class="form-controls">
																<?php
																if(!empty($case_material_items_array)) {
																	foreach($case_material_items_array as $key=>$case_material_item) {
																		$case_material_id = $case_material_item['id']; ?>
																		<div id="accssr<?=$key?>" style="margin-top:5px;">
																			<input type="text" class="form-control m-input" id="case_material_name[<?=$case_material_id?>]" name="case_material_name[<?=$case_material_id?>]" value="<?=html_entities($case_material_item['case_material_name'])?>" placeholder="Name" readonly="readonly">
																			<a href="javascript:void(0);" class="remove_case_material_item" id="rm_accssr<?=$key?>"><i class="la la-trash trash"></i></a>
																		</div>
																		<script>remove_case_material_item();</script>
																	<?php
																	}
																} ?>
																</div>
															</div>
															<!--<div class="form-group m-form__group">
																	 <a id="case_material_plus_icon" class="btn btn-md btn-success"><i class="fa fa-plus"></i> Add</a>
															</div>-->
															<!--<div class="form-actions">
																<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button> <a href="mobile.php" class="btn btn-alt btn-large btn-black">Back</a>
															</div>-->
														</div>
													</div>
												</div>
												
												<div class="tab-pane" id="tab12">
													<div class="m-portlet">
														<div class="m-portlet__body">
															<h4><?=$mobile_data['accessories_title']?></h4>
															<div class="form-group m-form__group">
																<label>Add Accessories</label>
															</div>
															<div class="form-group m-form__group" id="add_accessories_item">
																<div class="form-controls">
																<?php
																if(!empty($accessories_items_array)) {
																	foreach($accessories_items_array as $key=>$accessories_item) {
																		$accessories_id = $accessories_item['id']; ?>
																		<div class="row" id="accssr<?=$key?>" style="margin-top:5px;">
																			<div class="col-6">
																				<input type="text" class="form-control m-input" id="accessories_name[<?=$accessories_id?>]" name="accessories_name[<?=$accessories_id?>]" value="<?=html_entities($accessories_item['accessories_name'])?>" placeholder="Name">
																			</div>
																			<div class="col-3">
																				<input type="number" class="form-control m-input" id="accessories_price[<?=$accessories_id?>]" name="accessories_price[<?=$accessories_id?>]" value="<?=$accessories_item['accessories_price']?>" placeholder="Price">
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
															</div>
															<div class="form-group m-form__group">
																<a id="accessories_plus_icon" class="btn btn-md btn-success"><i class="fa fa-plus"></i> Add</a>
															</div>
															<!--<div class="form-actions">
																<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button> <a href="mobile.php" class="btn btn-alt btn-large btn-black">Back</a>
															</div>-->
														</div>
													</div>
												</div>
												
												<div class="tab-pane" id="tab18">
													<div class="m-portlet">
														<div class="m-portlet__body">
															<h4><?=$mobile_data['band_included_title']?></h4>
															<div class="form-group m-form__group">
																<label>Add Band Included</label>
															</div>
															<div class="form-group m-form__group" id="add_band_included_item">
																<div class="form-controls">
																<?php
																if(!empty($band_included_items_array)) {
																	foreach($band_included_items_array as $key=>$band_included_item) {
																		$band_included_id = $band_included_item['id']; ?>
																		<div class="row" id="bndinc<?=$key?>" style="margin-top:5px;">
																			<div class="col-6">
																			<input type="text" class="form-control m-input" id="band_included_name[<?=$band_included_id?>]" name="band_included_name[<?=$band_included_id?>]" value="<?=html_entities($band_included_item['band_included_name'])?>" placeholder="Name">
																			</div>
																			<div class="col-3">
																				<input type="number" class="form-control m-input" id="band_included_price[<?=$band_included_id?>]" name="band_included_price[<?=$band_included_id?>]" value="<?=$band_included_item['band_included_price']?>" placeholder="Price">
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
															</div>
															<div class="form-group m-form__group">
																<a id="band_included_plus_icon" class="btn btn-md btn-success"><i class="fa fa-plus"></i> Add</a>
															</div>
															<!--<div class="form-actions">
																<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button> <a href="mobile.php" class="btn btn-alt btn-large btn-black">Back</a>
															</div>-->
														</div>
													</div>
												</div>
												
												<div class="tab-pane" id="tab16">
													<div class="m-portlet">
														<div class="m-portlet__body">
															<h4><?=$mobile_data['processor_title']?></h4>
															<div class="form-group m-form__group">
																<label>Add Processor</label>
															</div>
															<div class="form-group m-form__group" id="add_processor_item">
																<div class="form-controls">
																<?php
																if(!empty($processor_items_array)) {
																	foreach($processor_items_array as $key=>$processor_item) {
																		$processor_id = $processor_item['id']; ?>
																		<div class="row" id="prcr<?=$key?>" style="margin-top:5px;">
																			<div class="col-6">
																			<input type="text" class="form-control m-input" id="processor_name[<?=$processor_id?>]" name="processor_name[<?=$processor_id?>]" value="<?=html_entities($processor_item['processor_name'])?>" placeholder="Name" readonly="readonly">
																			</div>
																			<?php /*?><div class="input-prepend input-append">
																				<?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?>
																				<input type="number" class="form-control m-input" id="processor_price[<?=$processor_id?>]" name="processor_price[<?=$processor_id?>]" value="<?=$processor_item['processor_price']?>" placeholder="Price">
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
															</div>
															<!--<div class="form-group m-form__group">
																	<a id="processor_plus_icon" class="btn btn-md btn-success"><i class="fa fa-plus"></i> Add</a>
															</div>-->
															<!--<div class="form-actions">
																<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button> <a href="mobile.php" class="btn btn-alt btn-large btn-black">Back</a>
															</div>-->
														</div>
													</div>
												</div>
				
												<div class="tab-pane" id="tab17">
													<div class="m-portlet">
														<div class="m-portlet__body">
															<h4><?=$mobile_data['ram_title']?></h4>
															<div class="form-group m-form__group">
																<label>Add RAM</label>
															</div>
															<div class="form-group m-form__group" id="add_ram_item">
																<div class="form-controls">
																<?php
																if(!empty($ram_items_array)) {
																	foreach($ram_items_array as $key=>$ram_item) {
																		$ram_id = $ram_item['id']; ?>
																		<div class="row" id="ram<?=$key?>" style="margin-top:5px;">
																			<div class="col-5">
																			<input type="text" class="form-control m-input" id="ram_size[<?=$ram_id?>]" name="ram_size[<?=$ram_id?>]" value="<?=html_entities($ram_item['ram_size'])?>" placeholder="Storage Sizes" readonly="readonly">
																			</div>
																			<div class="col-3">
																			<select class="form-control m-input" name="ram_size_postfix[<?=$ram_id?>]" id="ram_size_postfix[<?=$ram_id?>]" style="width:70px;">
																				<option value="GB" <?php if($ram_item['ram_size_postfix']=='GB'){echo 'selected="selected"';}?>>GB</option>
																				<option value="TB" <?php if($ram_item['ram_size_postfix']=='TB'){echo 'selected="selected"';}?>>TB</option>
																				<option value="MB" <?php if($ram_item['ram_size_postfix']=='MB'){echo 'selected="selected"';}?>>MB</option>
																			</select>
																			</div>
																			<?php /*?><div class="input-prepend input-append">
																				<?=($amount_sign_with_prefix?'<span class="add-on">'.$amount_sign_with_prefix.'</span>':'')?>
																				<input type="number" class="form-control m-input" id="ram_price[<?=$ram_id?>]" name="ram_price[<?=$ram_id?>]" value="<?=$ram_item['ram_price']?>" placeholder="Price">
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
															</div>
															<!--<div class="form-group m-form__group">
																	 <a id="ram_plus_icon" class="btn btn-md btn-success"><i class="fa fa-plus"></i> Add</a>
															</div>-->
															<!--<div class="form-actions">
																<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button> <a href="mobile.php" class="btn btn-alt btn-large btn-black">Back</a>
															</div>-->
														</div>
													</div>
												</div>
												
												<div class="tab-pane" id="tab8">
													<div class="m-portlet">
														<div class="m-portlet__body">
													<h3>Metadata</h3>
				
													<div class="form-group m-form__group">
														<label>Meta Title</label>
														<input type="text" class="form-control m-input" id="meta_title" value="<?=$mobile_data['meta_title']?>" name="meta_title">
													</div>
				
													<div class="form-group m-form__group">
														<label>Meta Description</label>
														<textarea class="form-control" name="meta_desc" rows="4"><?=$mobile_data['meta_desc']?></textarea>
													</div>
				
													<div class="form-group m-form__group">
														<label>Meta Keywords</label>
														<textarea class="form-control" name="meta_keywords" rows="3"><?=$mobile_data['meta_keywords']?></textarea>
													</div>
													
													<div class="form-group m-form__group">
														<label>Meta Canonical Url</label>
														<input type="text" class="form-control m-input" id="meta_canonical_url" value="<?=$mobile_data['meta_canonical_url']?>" name="meta_canonical_url">
													</div>
				
													<!--<div class="form-actions">
														<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button> <a href="mobile.php" class="btn btn-alt btn-large btn-black">Back</a>
													</div>-->
													</div>
													</div>
												</div>
												<?php
												} else {
												echo '<input type="hidden" name="cat_id" id="cat_id" value="'.$mobile_data['cat_id'].'" />'; ?>
												<div class="tab-pane" id="tab9" style="display:block;">
													<div class="m-portlet">
														<div class="m-portlet__body">
													<?php /*?><h3>Pricing</h3><?php */?>
													<div class="form-group m-form__group">
														<?php
														//START for mobile category type
														if($fields_cat_type=="mobile") { ?>
														<table border="0" width="100%" class="table table-bordered table-hover">
															<tr>
																<td>
																	<div class="span1.5">
																		<div class="form-group m-form__group">
																			<strong>ID</strong>
																		</div>
																	</div>
																</td>
																<td>
																	<div class="span1.5">
																		<div class="form-group m-form__group">
																			<strong>Carrier</strong>
																		</div>
																	</div>
																</td>
																<td>
																	<div class="span1.5">
																		<div class="form-group m-form__group">
																			<strong>Storage</strong>
																		</div>
																	</div>
																</td>
																<?php
																$p_condition_items_array = $condition_items_array;
																if(!empty($p_condition_items_array)) {
																	foreach($p_condition_items_array as $p_c_key=>$p_condition_data) { ?>
																		<td>
																		<div class="span1.5">
																			<div class="form-group m-form__group">
																				<strong>Offer<br /><small><?=$p_condition_data['condition_name']?></small></strong>
																			</div>
																		</div>
																		</td>
																	<?php
																	}
																} ?>
															</tr>
				
															<?php
															$pn_p = 0;
															$p_network_items_array = $network_items_array;
															if(empty($p_network_items_array)) {
																$p_network_items_array[] = array("network_name"=>"N/A");
															}
															if(!empty($p_network_items_array)) {
																foreach($p_network_items_array as $p_n_key=>$p_network_data) {
																	$p_storage_items_array = $storage_items_array;
																	if(empty($p_storage_items_array)) {
																		$p_storage_items_array[] = array("storage_size"=>"N/A");
																	}
																	if(!empty($p_storage_items_array)) {
																		foreach($p_storage_items_array as $p_s_key=>$p_storage_item) {
																			$pn_p = ($pn_p+1);
																			$p_storage_size = $p_storage_item['storage_size'].$p_storage_item['storage_size_postfix']; ?>
																			<tr>
																				<td>
																				<div class="span1.5">
																					<div class="form-group m-form__group">
																						<?=$pn_p?>
																					</div>
																				</div>
																				</td>
																				<td>
																				<div class="span1.5">
																					<div class="form-group m-form__group">
																						<?=$p_network_data['network_name']?>
																					</div>
																				</div>
																				</td>
																				<td>
																				<div class="span1.5">
																					<div class="form-group m-form__group">
																						<?=$p_storage_size?>
																					</div>
																				</div>
																				</td>
																				
																				<?php
																				$p_condition_items_array = $condition_items_array;
																				if(!empty($p_condition_items_array)) {
																					foreach($p_condition_items_array as $p_c_key=>$p_condition_data) {
																						$mc_query=mysqli_query($db,"SELECT * FROM model_catalog WHERE model_id='".$mobile_data['id']."' AND network='".$p_network_data['network_name']."' AND storage='".$p_storage_size."'");
																						$model_catalog_data=mysqli_fetch_assoc($mc_query);
																						$ps_condition_items_array = json_decode($model_catalog_data['conditions'],true); ?>
																						<td>
																						<div class="span1.5">
																							<div class="form-group m-form__group">
																								<input type="number" class="form-control m-input" id="p_cond_price[]" name="p_cond_price[<?=$p_network_data['network_name']?>][<?=$p_storage_size?>][<?=$p_condition_data['condition_name']?>]" value="<?=$ps_condition_items_array[$p_condition_data['condition_name']]?>" placeholder="Price" style="padding:.65rem 0.1rem;width:50px;">
																							</div>
																						</div>
																						</td>
																					<?php
																					}
																				} ?>
																			</tr>
																		<?php
																		}
																	}
																}
															} ?>
														</table>
														<?php
														} //END for mobile category type
														
														//START for tablet category type
														elseif($fields_cat_type=="tablet") { ?>
														<table border="0" width="100%" class="table table-bordered table-hover">
															<tr>
																<td>
																	<div class="span1.5">
																		<div class="form-group m-form__group">
																			<strong>ID</strong>
																		</div>
																	</div>
																</td>
																<td>
																	<div class="span1.5">
																		<div class="form-group m-form__group">
																			<strong>Connectivity</strong>
																		</div>
																	</div>
																</td>
																<td>
																	<div class="span1.5">
																		<div class="form-group m-form__group">
																			<strong>Storage</strong>
																		</div>
																	</div>
																</td>
																<?php
																$p_condition_items_array = $condition_items_array;
																if(!empty($p_condition_items_array)) {
																	foreach($p_condition_items_array as $p_c_key=>$p_condition_data) { ?>
																		<td>
																		<div class="span1.5">
																			<div class="form-group m-form__group">
																				<strong>Offer<br /><small><?=$p_condition_data['condition_name']?></small></strong>
																			</div>
																		</div>
																		</td>
																	<?php
																	}
																} ?>
															</tr>
				
															<?php
															$p_connectivity_items_array = $connectivity_items_array;
															if(empty($p_connectivity_items_array)) {
																$p_connectivity_items_array[] = array("connectivity_name"=>"N/A");
															}
															if(!empty($p_connectivity_items_array)) {
																foreach($p_connectivity_items_array as $p_n_key=>$p_connectivity_data) {
																	$p_storage_items_array = $storage_items_array;
																	if(empty($p_storage_items_array)) {
																		$p_storage_items_array[] = array("storage_size"=>"N/A");
																	}
																	if(!empty($p_storage_items_array)) {
																		foreach($p_storage_items_array as $p_s_key=>$p_storage_item) {
																			$pn_p = ($pn_p+1);
																			$p_storage_size = $p_storage_item['storage_size'].$p_storage_item['storage_size_postfix']; ?>
																			<tr>
																				<td>
																				<div class="span1.5">
																					<div class="form-group m-form__group">
																						<?=$pn_p?>
																					</div>
																				</div>
																				</td>
																				<td>
																				<div class="span1.5">
																					<div class="form-group m-form__group">
																						<?=$p_connectivity_data['connectivity_name']?>
																					</div>
																				</div>
																				</td>
																				<td>
																				<div class="span1.5">
																					<div class="form-group m-form__group">
																						<?=$p_storage_size?>
																					</div>
																				</div>
																				</td>
																				
																				<?php
																				$p_condition_items_array = $condition_items_array;
																				if(!empty($p_condition_items_array)) {
																					foreach($p_condition_items_array as $p_c_key=>$p_condition_data) {
																						$mc_query=mysqli_query($db,"SELECT * FROM model_catalog WHERE model_id='".$mobile_data['id']."' AND connectivity='".$p_connectivity_data['connectivity_name']."' AND storage='".$p_storage_size."'");
																						$model_catalog_data=mysqli_fetch_assoc($mc_query);
																						$ps_condition_items_array = json_decode($model_catalog_data['conditions'],true); ?>
																						<td>
																						<div class="span1.5">
																							<div class="form-group m-form__group">
																								<input type="number" class="form-control m-input" id="p_cond_price[]" name="p_cond_price[<?=$p_connectivity_data['connectivity_name']?>][<?=$p_storage_size?>][<?=$p_condition_data['condition_name']?>]" value="<?=$ps_condition_items_array[$p_condition_data['condition_name']]?>" placeholder="Price" style="padding:.65rem 0.1rem;width:50px;">
																							</div>
																						</div>
																						</td>
																					<?php
																					}
																				} ?>
																			</tr>
																		<?php
																		}
																	}
																}
															} ?>
														</table>
														<?php
														} //END for tablet category type
														
														//START for watch category type
														elseif($fields_cat_type=="watch") { ?>
														<table border="0" width="100%" class="table table-bordered table-hover">
															<tr>
																<td>
																	<div class="span1.5">
																		<div class="form-group m-form__group">
																			<strong>ID</strong>
																		</div>
																	</div>
																</td>
																<td>
																	<div class="span1.5">
																		<div class="form-group m-form__group">
																			<strong>Connectivity</strong>
																		</div>
																	</div>
																</td>
																<td>
																	<div class="span1.5">
																		<div class="form-group m-form__group">
																			<strong>Size</strong>
																		</div>
																	</div>
																</td>
																<td>
																	<div class="span1.5">
																		<div class="form-group m-form__group">
																			<strong>Model</strong>
																		</div>
																	</div>
																</td>
																<?php
																$p_condition_items_array = $condition_items_array;
																if(!empty($p_condition_items_array)) {
																	foreach($p_condition_items_array as $p_c_key=>$p_condition_data) { ?>
																		<td>
																		<div class="span1.5">
																			<div class="form-group m-form__group">
																				<strong>Offer<br /><small><?=$p_condition_data['condition_name']?></small></strong>
																			</div>
																		</div>
																		</td>
																	<?php
																	}
																} ?>
				
															</tr>
				
															<?php
															$p_connectivity_items_array = $connectivity_items_array;
															if(empty($p_connectivity_items_array)) {
																$p_connectivity_items_array[] = array("connectivity_name"=>"N/A");
															}
															if(!empty($p_connectivity_items_array)) {
																foreach($p_connectivity_items_array as $p_n_key=>$p_connectivity_data) {
																	$p_case_size_items_array = $case_size_items_array;
																	if(empty($p_case_size_items_array)) {
																		$p_case_size_items_array[] = array("case_size"=>"N/A");
																	}
																	if(!empty($p_case_size_items_array)) {
																		foreach($p_case_size_items_array as $p_s_key=>$p_case_size_item) {
																			$p_case_size = $p_case_size_item['case_size'];
																			
																			$p_model_items_array = $model_items_array;
																			if(empty($p_model_items_array)) {
																				$p_model_items_array[] = array("model_name"=>"N/A");
																			}
																			if(!empty($p_model_items_array)) {
																				foreach($p_model_items_array as $p_s_key=>$p_model_item) {
																					$pn_p = ($pn_p+1); ?>
																					<tr>
																						<td>
																						<div class="span1.5">
																							<div class="form-group m-form__group">
																								<?=$pn_p?>
																							</div>
																						</div>
																						</td>
																						<td>
																						<div class="span1.5">
																							<div class="form-group m-form__group">
																								<?=$p_connectivity_data['connectivity_name']?>
																							</div>
																						</div>
																						</td>
																						<td>
																						<div class="span1.5">
																							<div class="form-group m-form__group">
																								<?=$p_case_size?>
																							</div>
																						</div>
																						</td>
																						<td>
																						<div class="span1.5">
																							<div class="form-group m-form__group">
																								<?=$p_model_item['model_name']?>
																							</div>
																						</div>
																						</td>
																						<?php
																						$p_condition_items_array = $condition_items_array;
																						if(!empty($p_condition_items_array)) {
																							foreach($p_condition_items_array as $p_c_key=>$p_condition_data) {
																								$mc_query=mysqli_query($db,"SELECT * FROM model_catalog WHERE model_id='".$mobile_data['id']."' AND connectivity='".$p_connectivity_data['connectivity_name']."' AND case_size='".$p_case_size."' AND model='".$p_model_item['model_name']."'");
																								$model_catalog_data=mysqli_fetch_assoc($mc_query);
																								$ps_condition_items_array = json_decode($model_catalog_data['conditions'],true); ?>
																								<td>
																								<div class="span1.5">
																									<div class="form-group m-form__group">
																											<input type="number" class="form-control m-input" id="p_cond_price[]" name="p_cond_price[<?=$p_connectivity_data['connectivity_name']?>][<?=$p_case_size?>][<?=$p_model_item['model_name']?>][<?=$p_condition_data['condition_name']?>]" value="<?=$ps_condition_items_array[$p_condition_data['condition_name']]?>" placeholder="Price" style="padding:.65rem 0.1rem;width:50px;">
																									</div>
																								</div>
																								</td>
																							<?php
																							}
																						} ?>
																					</tr>
																				<?php
																				}
																			}
																		}
																	}
																}
															} ?>
														</table>
														<?php
														} //END for watch category type
														
														//START for watch category type
														elseif($fields_cat_type=="other") { ?>
														<table border="0" width="100%" class="table table-bordered table-hover">
															<tr>
																<td>
																	<div class="span1.5">
																		<div class="form-group m-form__group">
																			<strong>ID</strong>
																		</div>
																	</div>
																</td>
																<td>
																	<div class="span1.5">
																		<div class="form-group m-form__group">
																			<strong>Model</strong>
																		</div>
																	</div>
																</td>
																<?php
																$p_condition_items_array = $condition_items_array;
																if(!empty($p_condition_items_array)) {
																	foreach($p_condition_items_array as $p_c_key=>$p_condition_data) { ?>
																		<td>
																		<div class="span1.5">
																			<div class="form-group m-form__group">
																					<strong>Offer<br /><small><?=$p_condition_data['condition_name']?></small></strong>
																			</div>
																		</div>
																		</td>
																	<?php
																	}
																} ?>
															</tr>
				
															<?php
															$p_model_items_array = $model_items_array;
															if(empty($p_model_items_array)) {
																$p_model_items_array[] = array("model_name"=>"N/A");
															}
															if(!empty($p_model_items_array)) {
																foreach($p_model_items_array as $p_s_key=>$p_model_item) {
																	$pn_p = ($pn_p+1); ?>
																	<tr>
																		<td>
																		<div class="span1.5">
																			<div class="form-group m-form__group">
																				<?=$pn_p?>
																			</div>
																		</div>
																		</td>
																		<td>
																		<div class="span1.5">
																			<div class="form-group m-form__group">
																				<?=$p_model_item['model_name']?>
																			</div>
																		</div>
																		</td>
																		<?php
																		$p_condition_items_array = $condition_items_array;
																		if(!empty($p_condition_items_array)) {
																			foreach($p_condition_items_array as $p_c_key=>$p_condition_data) {
																				$mc_query=mysqli_query($db,"SELECT * FROM model_catalog WHERE model_id='".$mobile_data['id']."' AND model='".$p_model_item['model_name']."'");
																				$model_catalog_data=mysqli_fetch_assoc($mc_query);
																				$ps_condition_items_array = json_decode($model_catalog_data['conditions'],true); ?>
																				<td>
																				<div class="span1.5">
																					<div class="form-group m-form__group">
																							<input type="number" class="form-control m-input" id="p_cond_price[]" name="p_cond_price[<?=$p_model_item['model_name']?>][<?=$p_condition_data['condition_name']?>]" value="<?=$ps_condition_items_array[$p_condition_data['condition_name']]?>" placeholder="Price" style="padding:.65rem 0.1rem;width:50px;">
																					</div>
																				</div>
																				</td>
																			<?php
																			}
																		} ?>
																	</tr>
																<?php
																}
															} ?>
														</table>
														<?php
														} //END for watch category type
														
														//START for laptop category type
														if($fields_cat_type=="laptop") { ?>
														<table border="0" width="100%" class="table table-bordered table-hover">
															<tr>
																<td>
																	<div class="span1.5">
																		<div class="form-group m-form__group">
																			<strong>ID</strong>
																		</div>
																	</div>
																</td>
																<td>
																	<div class="span1.5">
																		<div class="form-group m-form__group">
																			<strong>Model</strong>
																		</div>
																	</div>
																</td>
																<td>
																	<div class="span1.5">
																		<div class="form-group m-form__group">
																			<strong>Processor</strong>
																		</div>
																	</div>
																</td>
																<td>
																	<div class="span1.5">
																		<div class="form-group m-form__group">
																			<strong>RAM</strong>
																		</div>
																	</div>
																</td>
																<td>
																	<div class="span1.5">
																		<div class="form-group m-form__group">
																			<strong>Storage</strong>
																		</div>
																	</div>
																</td>
																<td>
																	<div class="span1.5">
																		<div class="form-group m-form__group">
																			<strong>Graphics Card</strong>
																		</div>
																	</div>
																</td>
																<?php
																$p_condition_items_array = $condition_items_array;
																if(!empty($p_condition_items_array)) {
																	foreach($p_condition_items_array as $p_c_key=>$p_condition_data) { ?>
																		<td>
																		<div class="span1.5">
																			<div class="form-group m-form__group">
																				<strong>Offer<br /><small><?=$p_condition_data['condition_name']?></small></strong>
																			</div>
																		</div>
																		</td>
																	<?php
																	}
																} ?>
															</tr>
				
															<?php
															$p_model_items_array = $model_items_array;
															if(empty($p_model_items_array)) {
																$p_model_items_array[] = array("model_name"=>"N/A");
															}
															if(!empty($p_model_items_array)) {
																foreach($p_model_items_array as $p_n_key=>$p_model_data) {
																	
																	$p_processor_items_array = $processor_items_array;
																	if(empty($p_processor_items_array)) {
																		$p_processor_items_array[] = array("processor_name"=>"N/A");
																	}
																	if(!empty($p_processor_items_array)) {
																		foreach($p_processor_items_array as $p_n_key=>$p_processor_data) {
																		
																			$p_ram_items_array = $ram_items_array;
																			if(empty($p_ram_items_array)) {
																				$p_ram_items_array[] = array("ram_size"=>"N/A");
																			}
																			if(!empty($p_ram_items_array)) {
																				foreach($p_ram_items_array as $p_n_key=>$p_ram_data) {
																					$p_ram_size = $p_ram_data['ram_size'].$p_ram_data['ram_size_postfix'];
																					$p_storage_items_array = $storage_items_array;
																					if(empty($p_storage_items_array)) {
																						$p_storage_items_array[] = array("storage_size"=>"N/A");
																					}
																					if(!empty($p_storage_items_array)) {
																						foreach($p_storage_items_array as $p_s_key=>$p_storage_item) {
																							$p_storage_size = $p_storage_item['storage_size'].$p_storage_item['storage_size_postfix'];
																							$p_graphics_card_items_array = $graphics_card_items_array;
																							if(empty($p_graphics_card_items_array)) {
																								$p_graphics_card_items_array[] = array("graphics_card_name"=>"N/A");
																							}
																							if(!empty($p_graphics_card_items_array)) {
																								foreach($p_graphics_card_items_array as $p_n_key=>$p_graphics_card_data) {
																								$pn_p = ($pn_p+1); ?>
																								<tr>
																									<td>
																									<div class="span1.5">
																										<div class="form-group m-form__group">
																											<?=$pn_p?>
																										</div>
																									</div>
																									</td>
																									<td>
																									<div class="span1.5">
																										<div class="form-group m-form__group">
																											<?=$p_model_data['model_name']?>
																										</div>
																									</div>
																									</td>
																									<td>
																									<div class="span1.5">
																										<div class="form-group m-form__group">
																											<?=$p_processor_data['processor_name']?>
																										</div>
																									</div>
																									</td>
																									<td>
																									<div class="span1.5">
																										<div class="form-group m-form__group">
																											<?=$p_ram_size?>
																										</div>
																									</div>
																									</td>
																									<td>
																									<div class="span1.5">
																										<div class="form-group m-form__group">
																											<?=$p_storage_size?>
																										</div>
																									</div>
																									</td>
																									<td>
																									<div class="span1.5">
																										<div class="form-group m-form__group">
																											<?=$p_graphics_card_data['graphics_card_name']?>
																										</div>
																									</div>
																									</td>
																									<?php
																									$p_condition_items_array = $condition_items_array;
																									if(!empty($p_condition_items_array)) {
																										foreach($p_condition_items_array as $p_c_key=>$p_condition_data) {
																											$mc_query=mysqli_query($db,"SELECT * FROM model_catalog WHERE model_id='".$mobile_data['id']."' AND model='".$p_model_data['model_name']."' AND ram='".$p_ram_size."' AND processor='".$p_processor_data['processor_name']."' AND graphics_card='".$p_graphics_card_data['graphics_card_name']."' AND storage='".$p_storage_size."'");
																											$model_catalog_data=mysqli_fetch_assoc($mc_query);
																											$ps_condition_items_array = json_decode($model_catalog_data['conditions'],true); ?>
																											<td>
																											<div class="span1.5">
																												<div class="form-group m-form__group">
																														<input type="number" class="form-control m-input" id="p_cond_price[]" name="p_cond_price[<?=$p_model_data['model_name']?>][<?=$p_processor_data['processor_name']?>][<?=$p_ram_size?>][<?=$p_storage_size?>][<?=$p_graphics_card_data['graphics_card_name']?>][<?=$p_condition_data['condition_name']?>]" value="<?=$ps_condition_items_array[$p_condition_data['condition_name']]?>" placeholder="Price" style="padding:.65rem 0.1rem;width:50px;">
																												</div>
																											</div>
																											</td>
																										<?php
																										}
																									} ?>
																								</tr>
																								<?php
																								}
																							}
																						}
																					}
																				}
																			}
																		}
																	}
																}
															} ?>
														</table>
														<?php
														} //END for mobile laptop type ?>
													</div>
													<!--<div class="form-actions">
														<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button> <a href="mobile.php" class="btn btn-alt btn-large btn-black">Back</a>
													</div>-->
													</div>
													</div>
												</div>
												<?php
												} ?>	
											</div>
										</div>
									</div>
					
								</div>
							</div>
							<?php
							if($pricing_tb == 1) {
								echo '<input type="hidden" name="pricing" value="1" />';
							} else {
								echo '<input type="hidden" name="update" value="1" />';
							} ?>
							
							<input type="hidden" name="id" value="<?=$mobile_data['id']?>" />
							<div class="m-portlet__foot m-portlet__foot--fit">
								<div class="m-form__actions m-form__actions">
									<button type="submit" class="btn btn-primary">
									  <?=($id?'Update':'Save')?>
									</button>
									<?php
									if($pricing_tb==1) {
										echo '<a href="edit_mobile.php?id='.$id.'" class="btn btn-secondary">Back</a>';
									} else {
										echo '<a href="mobile.php" class="btn btn-secondary">Back</a>';
									} ?>
								</div>
							</div>
						</form>
					</div>
					<!--end::Portlet-->
				</div>
			</div>
		</div>
	</div>
	</div>
	<!-- begin::Footer -->
	<?php include("include/footer.php");?>
	<!-- end::Footer -->
</div>
<!-- end:: Body -->

<div class="modal fade" id="pricing_modal" tabindex="-1" role="dialog" aria-labelledby="lbl_pricing_modal" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="lbl_pricing_modal">Edit Pricing <small><b>For <?=$mobile_data['title']?></b></small></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="controllers/mobile.php" method="POST" enctype="multipart/form-data">
				<div class="modal-body pricing_modal_flds">
					<div class="m-loader m-loader--lg m-loader--brand" style="width:30px;display:inline-block;"></div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Update</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
function PricingModal() {
	jQuery(document).ready(function($) {
		$('#pricing_modal').modal({backdrop: 'static',keyboard: false});

		var model_id = '<?=$id?>';
		var post_data = {model_id:model_id};
		$.ajax({
			type: "POST",
			url:"ajax/get_pricing_modal_flds.php",
			data:post_data,
			success:function(data) {
				if(data!="") {
					$(".pricing_modal_flds").html(data);
				}
			}
		});
		
	});
}

jQuery(document).ready(function($) {
	$('.remove_network_icon').on('click',function() {
		var field_id = $(this).attr('data-field_id');
		var post_data = {field_id:field_id};
		$.ajax({
			type: "POST",
			url:"ajax/remove_network_icon.php",
			data:post_data,
			success:function(data) {
				if(data!="") {
					$("#network_icon_"+field_id).prev().remove();
					$("#network_icon_"+field_id).remove();
				}
			}
		});
	});
});

function get_cat_custom_fields(cat_id) {
	if(cat_id!="") {
		jQuery(document).ready(function($) {
			var fields_type = $("#cat_id").find(':selected').attr('data-fields-type');
			post_data = "cat_id="+cat_id+"&fields_cat_type="+fields_type;
			
			$(".fields_tab").hide();
			
			$.ajax({
				type: "POST",
				url:"ajax/get_cat_custom_fields.php?field_type=tabs",
				data:post_data,
				success:function(data){
					if(data!="") {
						$('.nav-tabs').html(data);
					}
				}
			});
			
			$.ajax({
				type: "POST",
				url:"ajax/get_cat_custom_fields.php?field_type=storage",
				data:post_data,
				success:function(data){
					if(data!="") {
						$('#add_storage_item').html(data);
						//$(".fields_tab1").show();
					} else {
						$('#add_storage_item').html('');
					}
				}
			});

			$.ajax({
				type: "POST",
				url:"ajax/get_cat_custom_fields.php?field_type=condition",
				data:post_data,
				success:function(data){
					if(data!="") {
						$('#add_condition_item').html(data);
						//$(".fields_tab2").show();
					} else {
						$('#add_condition_item').html('');
					}
				}
			});
			
			$.ajax({
				type: "POST",
				url:"ajax/get_cat_custom_fields.php?field_type=network",
				data:post_data,
				success:function(data){
					if(data!="") {
						$('#add_network_item').html(data);
						//$(".fields_tab3").show();
					} else {
						$('#add_network_item').html('');
					}
				}
			});
			
			$.ajax({
				type: "POST",
				url:"ajax/get_cat_custom_fields.php?field_type=connectivity",
				data:post_data,
				success:function(data){
					if(data!="") {
						$('#add_connectivity_item').html(data);
						$(".fields_tab4").show();
					} else {
						$('#add_connectivity_item').html('');
					}
				}
			});
			
			$.ajax({
				type: "POST",
				url:"ajax/get_cat_custom_fields.php?field_type=accessories",
				data:post_data,
				success:function(data){
					if(data!="") {
						$('#add_accessories_item').html(data);
						//$(".fields_tab12").show();
					} else {
						$('#add_accessories_item').html('');
					}
				}
			});
			
			$.ajax({
				type: "POST",
				url:"ajax/get_cat_custom_fields.php?field_type=band_included",
				data:post_data,
				success:function(data){
					if(data!="") {
						$('#add_band_included_item').html(data);
						//$(".fields_tab12").show();
					} else {
						$('#add_band_included_item').html('');
					}
				}
			});
			
			$.ajax({
				type: "POST",
				url:"ajax/get_cat_custom_fields.php?field_type=processor",
				data:post_data,
				success:function(data){
					if(data!="") {
						$('#add_processor_item').html(data);
						//$(".fields_tab16").show();
					} else {
						$('#add_processor_item').html('');
					}
				}
			});
			
			$.ajax({
				type: "POST",
				url:"ajax/get_cat_custom_fields.php?field_type=ram",
				data:post_data,
				success:function(data){
					if(data!="") {
						$('#add_ram_item').html(data);
						//$(".fields_tab17").show();
					} else {
						$('#add_ram_item').html('');
					}
				}
			});
			
			$.ajax({
				type: "POST",
				url:"ajax/get_cat_custom_fields.php?field_type=model",
				data:post_data,
				success:function(data){
					if(data!="") {
						$('#add_model_item').html(data);
					} else {
						$('#add_model_item').html('');
					}
				}
			});
			
			$.ajax({
				type: "POST",
				url:"ajax/get_cat_custom_fields.php?field_type=graphics_card",
				data:post_data,
				success:function(data){
					if(data!="") {
						$('#add_graphics_card_item').html(data);
					} else {
						$('#add_graphics_card_item').html('');
					}
				}
			});

			/*$.ajax({
				type: "POST",
				url:"ajax/get_cat_custom_fields.php?field_type=watchtype",
				data:post_data,
				success:function(data){
					if(data!="") {
						$('#add_watchtype_item').html(data);
						$(".fields_tab5").show();
					} else {
						$('#add_watchtype_item').html('');
					}
				}
			});
			
			$.ajax({
				type: "POST",
				url:"ajax/get_cat_custom_fields.php?field_type=case_material",
				data:post_data,
				success:function(data){
					if(data!="") {
						$('#add_case_material_item').html(data);
						$(".fields_tab7").show();
					} else {
						$('#add_case_material_item').html('');
					}
				}
			});*/

			$.ajax({
				type: "POST",
				url:"ajax/get_cat_custom_fields.php?field_type=case_size",
				data:post_data,
				success:function(data){
					if(data!="") {
						$('#add_case_size_item').html(data);
						//$(".fields_tab6").show();
					} else {
						$('#add_case_size_item').html('');
					}
				}
			});

		});
	}
}
</script>