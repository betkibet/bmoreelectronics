<style type="text/css">
.condition-fields label {margin-bottom:2px !important;font-size:10px !important;}
.network-fields label {margin-bottom:2px !important;font-size:10px !important;}
</style>

<script type="text/javascript">
function check_form(a){
	if(a.title.value.trim()==""){
		alert('Please enter title');
		a.title.focus();
		a.title.value='';
		return false;
	}

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

	var connectivity_name = document.getElementsByName('connectivity_name[]');
	for(var i = 0; i < connectivity_name.length; i++) {
		if(connectivity_name[i].value.match(/:/g)) {
			alert("Do not allow : in connectivity name");
			connectivity_name[i].focus();
			return false;           
		}
	}
	
	var watchtype_name = document.getElementsByName('watchtype_name[]');
	for(var i = 0; i < watchtype_name.length; i++) {
		if(watchtype_name[i].value.match(/:/g)) {
			alert("Do not allow : in watchtype name");
			watchtype_name[i].focus();
			return false;           
		}
	}
	
	var case_material_name = document.getElementsByName('case_material_name[]');
	for(var i = 0; i < case_material_name.length; i++) {
		if(case_material_name[i].value.match(/:/g)) {
			alert("Do not allow : in case material name");
			case_material_name[i].focus();
			return false;           
		}
	}
	
	var case_size_name = document.getElementsByName('case_size_name[]');
	for(var i = 0; i < case_size_name.length; i++) {
		if(case_size_name[i].value.match(/:/g)) {
			alert("Do not allow : in case size name");
			case_size_name[i].focus();
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

function get_icon_type(type) {
	if(type == "fa") {
		$(".custom_icon_showhide").hide();
		$(".fa_icon_showhide").show();
		$('#fa_icon').select2();
	} else if(type == "custom") {
		$(".custom_icon_showhide").show();
		$(".fa_icon_showhide").hide();
	}
}
</script>

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
			<div class="m-content ">
				<?php include('confirm_message.php'); ?>
				<!--Begin::Section-->
				<div class="row">
					<div class="col-lg-10">
						<!--begin::Portlet-->
						<div class="m-portlet">
							<div class="m-portlet__head">
								<div class="m-portlet__head-caption">
									<div class="m-portlet__head-title">
										<span class="m-portlet__head-icon m--hide">
										  <i class="la la-gear"></i>
										</span>
										<h3 class="m-portlet__head-text">
										  <?=($id?'Edit Category':'Add Category')?>
										</h3>
									</div>
								</div>
							</div>
							<!--begin::Form-->
							<form class="m-form" action="controllers/device_categories.php" role="form" method="post" onSubmit="return check_form(this);" enctype="multipart/form-data">
								<div class="m-portlet__body">
									<div class="m-form__section m-form__section--first">
									
										<div class="row">
											<?php
											if($id>0) { ?>
											<div class="col-md-3">
												<ul class="nav nav-tabs flex-column nav-pills vartical-tab  m-tabs-line m-tabs-line--success" role="tablist">
													<li class="nav-item m-tabs__item"><a href="#tab1" data-toggle="tab" class="nav-link m-tabs__link active show">Basic</a></li>
													<?php
													if($category_data['fields_type'] == "mobile") { ?>
													<li class="nav-item m-tabs__item"><a href="#tab4" data-toggle="tab" class="nav-link m-tabs__link">Carrier</a></li>
													<li class="nav-item m-tabs__item"><a href="#tab2" data-toggle="tab" class="nav-link m-tabs__link">Storage</a></li>
													<li class="nav-item m-tabs__item"><a href="#tab3" data-toggle="tab" class="nav-link m-tabs__link">Condition</a></li>
													<li class="nav-item m-tabs__item"><a href="#tab12" data-toggle="tab" class="nav-link m-tabs__link">Accessories</a></li>
													<?php
													}
													if($category_data['fields_type'] == "laptop") { ?>
													<li class="nav-item m-tabs__item"><a href="#tab19" data-toggle="tab" class="nav-link m-tabs__link">Model</a></li>
													<li class="nav-item m-tabs__item"><a href="#tab16" data-toggle="tab" class="nav-link m-tabs__link">Processor</a></li>
													<li class="nav-item m-tabs__item"><a href="#tab17" data-toggle="tab" class="nav-link m-tabs__link">RAM</a></li>
													<li class="nav-item m-tabs__item"><a href="#tab2" data-toggle="tab" class="nav-link m-tabs__link">Storage</a></li>
													<li class="nav-item m-tabs__item"><a href="#tab20" data-toggle="tab" class="nav-link m-tabs__link">Graphics Card</a></li>
													<li class="nav-item m-tabs__item"><a href="#tab3" data-toggle="tab" class="nav-link m-tabs__link">Condition</a></li>
													<li class="nav-item m-tabs__item"><a href="#tab12" data-toggle="tab" class="nav-link m-tabs__link">Accessories</a></li>
													<?php
													}
													if($category_data['fields_type'] == "tablet") { ?>
													<li class="nav-item m-tabs__item"><a href="#tab5" data-toggle="tab" class="nav-link m-tabs__link">Connectivity</a></li>
													<li class="nav-item m-tabs__item"><a href="#tab2" data-toggle="tab" class="nav-link m-tabs__link">Storage</a></li>
													<li class="nav-item m-tabs__item"><a href="#tab3" data-toggle="tab" class="nav-link m-tabs__link">Condition</a></li>
													<li class="nav-item m-tabs__item"><a href="#tab12" data-toggle="tab" class="nav-link m-tabs__link">Accessories</a></li>
													<?php
													}
													if($category_data['fields_type'] == "watch") { ?>
													<li class="nav-item m-tabs__item"><a href="#tab5" data-toggle="tab" class="nav-link m-tabs__link">Connectivity</a></li>
													<li class="nav-item m-tabs__item"><a href="#tab6" data-toggle="tab" class="nav-link m-tabs__link">Size</a></li>
													<li class="nav-item m-tabs__item"><a href="#tab19" data-toggle="tab" class="nav-link m-tabs__link">Model</a></li>
													<li class="nav-item m-tabs__item"><a href="#tab3" data-toggle="tab" class="nav-link m-tabs__link">Condition</a></li>
													<li class="nav-item m-tabs__item"><a href="#tab18" data-toggle="tab" class="nav-link m-tabs__link">Band Included</a></li>
													<li class="nav-item m-tabs__item"><a href="#tab12" data-toggle="tab" class="nav-link m-tabs__link">Accessories</a></li>
													<?php
													}
													if($category_data['fields_type'] == "other") { ?>
													<li class="nav-item m-tabs__item"><a href="#tab19" data-toggle="tab" class="nav-link m-tabs__link">Model</a></li>
													<li class="nav-item m-tabs__item"><a href="#tab3" data-toggle="tab" class="nav-link m-tabs__link">Condition</a></li>
													<li class="nav-item m-tabs__item"><a href="#tab12" data-toggle="tab" class="nav-link m-tabs__link">Accessories</a></li>
													<?php
													} ?>
												</ul>
											</div>
											<?php
											} ?>
											<div class="col-md-9">
												<div class="tab-content">
												
													<div class="tab-pane active show" id="tab1" role="tabpanel">
														<div class="m-portlet">
															<div class="m-portlet__body">
															
																<div class="form-group m-form__group">
																	<label for="title">Title :</label>
																	<input type="text" class="form-control m-input" id="title" value="<?=$category_data['title']?>" name="title">
																</div>
																<div class="form-group m-form__group">
																	<label for="sef_url">
																		Sef Url :
																	  </label>
																	<input type="text" class="form-control m-input" id="sef_url" value="<?=$category_data['sef_url']?>" name="sef_url">
																</div>
								
																<div class="form-group m-form__group">
																	<label>Type</label>
																	<select name="fields_type" id="fields_type" class="form-control m-input">
																		<option value=""> - Select - </option>
																		<option value="mobile" <?php if($category_data['fields_type'] == "mobile"){echo 'selected="selected"';}?>>Mobile</option>
																		<option value="laptop" <?php if($category_data['fields_type'] == "laptop"){echo 'selected="selected"';}?>>Laptop</option>
																		<option value="tablet" <?php if($category_data['fields_type'] == "tablet"){echo 'selected="selected"';}?>>Tablet</option>
																		<option value="watch" <?php if($category_data['fields_type'] == "watch"){echo 'selected="selected"';}?>>Watch</option>
																		<option value="other" <?php if($category_data['fields_type'] == "other"){echo 'selected="selected"';}?>>Other</option>
																	</select>
																	<small>Further configuration of fields display per Gadget category choosen.</small>
																</div>
																
																<?php
																$icon_type = $category_data['icon_type']; ?>
																<div class="m-form__group form-group">
																	<div class="m-radio-inline">
																		<label class="m-radio">
																			<input type="radio" id="icon_type_fa" name="icon_type" value="fa" <?=($icon_type=='fa'||$icon_type==''?'checked="checked"':'')?> onclick="get_icon_type('fa');">
																			Fa Icon
																			<span></span>
																		</label>
																		<label class="m-radio">
																			<input type="radio" id="icon_type_img" name="icon_type" value="custom" <?=($icon_type=='custom'?'checked="checked"':'')?> onclick="get_icon_type('custom');">
																			Custom Icon
																			<span></span>
																		</label>
																	</div>
																</div>
																
																<div class="form-group m-form__group fa_icon_showhide" <?php if($icon_type=='fa'||$icon_type==''){echo 'style="display:block;"';}else{echo 'style="display:none;"';}?>>
																	<label for="fa_icon">Fa Icon:</label>
																	<select class="form-control m-select2 m-select2-general" name="fa_icon" id="fa_icon">
																		<option value=""> -Select- </option>
																		<?php
																		foreach($fa_icon_list as $fa_icon_k=>$fa_icon_val) { ?>
																		<option value="<?=$fa_icon_val?>" <?php if($category_data['fa_icon']==$fa_icon_val){echo 'selected="selected"';}?>><?=ucwords(str_replace(array("fa-","-"),array(""," "),$fa_icon_val))?></option>
																		<?php
																		} ?>
																	</select>
																</div>
																
																<div class="form-group m-form__group custom_icon_showhide" <?php if($icon_type=='custom'){echo 'style="display:block;"';}else{echo 'style="display:none;"';}?>>
																	<label for="image">Icon:</label>
																	<div class="custom-file">
																		<input type="file" id="image" class="custom-file-input" name="image" onChange="checkFile(this);" accept="image/*">
																		<label class="custom-file-label" for="image">
																			Choose file
																		</label>
																	</div>
																	
																	<?php
																	if($category_data['image']!="") { ?>
																		<img src="../images/categories/<?=$category_data['image']?>" width="200" class="my-md-2">
																		<a class="btn btn-danger btn-sm" data-dismiss="fileupload" href="controllers/device_categories.php?id=<?=$_REQUEST['id']?>&r_img_id=<?=$category_data['id']?>" onclick="return confirm('Are you sure to delete this icon?');">Remove</a>
																		<input type="hidden" id="old_image" name="old_image" value="<?=$category_data['image']?>">
																	<?php
																	} ?>
																</div>
																
																<div class="form-group m-form__group custom_icon_showhide" <?php if($icon_type=='custom'){echo 'style="display:block;"';}else{echo 'style="display:none;"';}?>>
																	<label for="hover_image">Hover Icon:</label>
																	<div class="custom-file">
																		<input type="file" id="hover_image" class="custom-file-input" name="hover_image" onChange="checkFile(this);" accept="image/*">
																		<label class="custom-file-label" for="image">
																			Choose file
																		</label>
																	</div>
																	
																	<?php
																	if($category_data['hover_image']!="") { ?>
																		<img src="../images/categories/<?=$category_data['hover_image']?>" width="200" class="my-md-2">
																		<a class="btn btn-danger btn-sm" data-dismiss="fileupload" href="controllers/device_categories.php?id=<?=$_REQUEST['id']?>&r_h_img_id=<?=$category_data['id']?>" onclick="return confirm('Are you sure to delete this icon?');">Remove</a>
																		<input type="hidden" id="old_hover_image" name="old_hover_image" value="<?=$category_data['hover_image']?>">
																	<?php
																	} ?>
																</div>
																
																<div class="form-group m-form__group">
																	<label for="cart_image">Cart Image:</label>
																	<div class="custom-file">
																		<input type="file" id="cart_image" class="custom-file-input" name="cart_image" onChange="checkFile(this);" accept="image/*">
																		<label class="custom-file-label" for="image">
																			Choose file
																		</label>
																	</div>
																	
																	<?php
																	if($category_data['cart_image']!="") { ?>
																		<img src="../images/categories/<?=$category_data['cart_image']?>" width="200" class="my-md-2">
																		<a class="btn btn-danger btn-sm" data-dismiss="fileupload" href="controllers/device_categories.php?id=<?=$_REQUEST['id']?>&r_c_img_id=<?=$category_data['id']?>" onclick="return confirm('Are you sure to delete this icon?');">Remove</a>
																		<input type="hidden" id="old_cart_image" name="old_cart_image" value="<?=$category_data['cart_image']?>">
																	<?php
																	} ?>
																</div>
																
																<div class="form-group m-form__group">
																	<label for="sub_title">Content Title :</label>
																	<input type="text" class="form-control m-input" id="sub_title" value="<?=$category_data['sub_title']?>" name="sub_title">
																</div>
																
																<div class="form-group m-form__group">
																	<label for="short_description">Short Description :</label>
																	<textarea class="form-control m-input" name="short_description" rows="4"><?=$category_data['short_description']?></textarea>
																</div>
																
																<div class="form-group m-form__group">
																	<label for="exampleTextarea">
																		Description :
																	</label>
																	<textarea class="form-control m-input summernote" id="exampleTextarea" name="description" rows="5"><?=$category_data['description']?></textarea>
																</div>
																
																<div class="m-form__group form-group">
																	<label for="">
																		Publish :
																	</label>
																	<div class="m-radio-inline">
																		<label class="m-radio">
																			<input type="radio" id="published" name="published" value="1" <?php if(!$id){echo 'checked="checked"';}?> <?=($category_data['published']==1?'checked="checked"':'')?>>
																			Yes
																			<span></span>
																		</label>
																		<label class="m-radio">
																			<input type="radio"  id="published" name="published" value="0" <?=($category_data['published']=='0'?'checked="checked"':'')?>>
																			No
																			<span></span>
																		</label>
																	</div>
																</div>
																	
																<!--<div class="form-actions">
																	<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button> <a href="device_categories.php" class="btn btn-alt btn-large btn-black">Back</a>
																</div>-->
															</div>
														</div>
													</div>
													
													<div class="tab-pane" id="tab2">
														<div class="m-portlet">
															<div class="m-portlet__body">
																<div class="form-group m-form__group">
																	<label>Storage Title</label>
																	<input type="text" class="form-control m-input" id="storage_title" value="<?=$category_data['storage_title']?>" name="storage_title">
																</div>
																<div class="form-group m-form__group">
																	<label>Storage Tooltip</label>
																	<textarea class="form-control summernote" name="tooltip_storage" rows="5"><?=$category_data['tooltip_storage']?></textarea>
																</div>
																<div class="m-form__group form-group">
																	<div class="m-checkbox-list">
																		<label class="m-checkbox">
																			<input id="required_storage" type="checkbox" value="1" name="required_storage" <?php if($category_data['required_storage']=='1'){echo 'checked="checked"';}?>>
																			Require customer selection
																			<span></span>
																		</label>
																	</div>
																</div>
																<div class="form-group m-form__group">
																	<label>Add Storages</label>
																</div>
																<div class="control-group" id="add_storage_item">
																	<div class="form-controls">
																	<?php
																	if(!empty($storage_items_array)) {
																		foreach($storage_items_array as $key=>$storage_item) {
																			$storage_id = $storage_item['id']; ?>
																			<div class="row" id="<?=$key?>" style="margin-top:5px;">
																				<div class="col-5">
																				<input type="text" class="form-control m-input" id="storage_size[<?=$storage_id?>]" name="storage_size[<?=$storage_id?>]" value="<?=html_entities($storage_item['storage_size'])?>" placeholder="Storage Size">
																				</div>
																				<div class="col-3">
																				<select class="form-control m-input" name="storage_size_postfix[<?=$storage_id?>]" id="storage_size_postfix[<?=$storage_id?>]">
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
																<div class="form-group m-form__group">
																	<a id="storage_plus_icon" class="btn btn-md btn-success"><i class="fa fa-plus"></i> Add</a>
																</div>
																<!--<div class="form-actions">
																	<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button> <a href="device_categories.php" class="btn btn-alt btn-large btn-black">Back</a>
																</div>-->
															</div>
														</div>
													</div>
										
													<div class="tab-pane" id="tab3">
														<!--<h3>Condition Fields</h3>-->
														<div class="form-group m-form__group">
															<label>Condition Title</label>
															<input type="text" class="form-control m-input" id="condition_title" value="<?=$category_data['condition_title']?>" name="condition_title">
														</div>
														<!--<div class="form-group m-form__group">
															<label>Condition Tooltip</label>
															
																<textarea class="form-control summernote" name="tooltip_condition" rows="5" style="width:620px;"><?=$category_data['tooltip_condition']?></textarea>
															
														</div>-->
														<div class="m-form__group form-group">
															<div class="m-checkbox-list">
																<label class="m-checkbox">
																	<input id="required_condition" type="checkbox" value="1" name="required_condition" <?php if($category_data['required_condition']=='1'){echo 'checked="checked"';}?>>
																	Require customer selection
																	<span></span>
																</label>
															</div>
														</div>
														<div class="form-group m-form__group">
															<label>Add Condition</label>
														</div>
														<div class="control-group condition-fields" id="add_condition_item">
															<?php
															if(!empty($condition_items_array)) {
																foreach($condition_items_array as $c_key=>$condition_data) {
																	$condition_id = $condition_data['id']; ?>
										
																	<div class="row" id="cnd<?=$c_key?>" style="margin-top:5px;">
																		<div class="col-5">
																			<div class="form-group m-form__group">
																				<label>Name</label>
																				
																					 <input type="text" class="form-control m-input" id="condition_name[<?=$condition_id?>]" name="condition_name[<?=$condition_id?>]" value="<?=html_entities($condition_data['condition_name'])?>" placeholder="Name">
																			</div>
																		</div>
																		<div class="col-6">
																			<div class="form-group m-form__group">
																				<label>Terms</label>
																				
																					 <textarea class="form-control" name="condition_terms[<?=$condition_id?>]" id="condition_terms[<?=$condition_id?>]" placeholder="Terms"><?=$condition_data['condition_terms']?></textarea>
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
														<div class="form-group m-form__group">
															<a id="condition_plus_icon" class="btn btn-md btn-success"><i class="fa fa-plus"></i> Add</a>
														</div>
														<!--<div class="form-actions">
															<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button>
															<a href="device_categories.php" class="btn btn-alt btn-large btn-black">Back</a>
														</div>-->
													</div>
										
													<div class="tab-pane" id="tab4">
														<!--<h3>Carrier Fields</h3>-->
														<div class="form-group m-form__group">
															<label>Carrier Title</label>
															<input type="text" class="form-control m-input" id="network_title" value="<?=$category_data['network_title']?>" name="network_title">
														</div>
														<div class="form-group m-form__group">
															<label>Carrier Tooltip</label>
																<textarea class="form-control summernote" name="tooltip_network" rows="5" style="width:620px;"><?=$category_data['tooltip_network']?></textarea>
														</div>
														<div class="m-form__group form-group">
															<div class="m-checkbox-list">
																<label class="m-checkbox">
																	<input id="required_network" type="checkbox" value="1" name="required_network" <?php if($category_data['required_network']=='1'){echo 'checked="checked"';}?>>
																	Require customer selection
																	<span></span>
																</label>
															</div>
														</div>
														<div class="form-group m-form__group">
															<label>Add Carrier</label>
														</div>
														<div class="control-group network-fields" id="add_network_item">
															<?php
															if(!empty($network_items_array)) {
															foreach($network_items_array as $n_key=>$network_data) {
																$network_id = $network_data['id']; ?>
																<div class="row" id="nvk<?=$n_key?>">
																	<div class="col-5">
																		<div class="form-group m-form__group">
																			<label>Name</label>
																				 <input type="text" class="form-control m-input" id="network_name[<?=$network_id?>]" name="network_name[<?=$network_id?>]" value="<?=html_entities($network_data['network_name'])?>" placeholder="Name">
																		</div>
																	</div>
																	<div class="col-5">
																		<div class="form-group m-form__group">
																			<label>Icon</label>
																			 <input type="file" name="network_icon[<?=$network_id?>]" id="network_icon[<?=$network_id?>]"/>
																			 <input type="hidden" name="old_network_icon[<?=$network_id?>]" id="old_network_icon[<?=$network_id?>]" value="<?=$network_data['network_icon']?>"/>
																			  
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
																		<label>&nbsp;</label>
																		<a href="javascript:void(0);" class="remove_network_item" id="rm_nvk<?=$n_key?>"><i class="la la-trash trash"></i></a>
																		</div>
																	</div>
																</div>
																<script>remove_network_item();</script>
															<?php
															}
															} ?>
														</div>
														<div class="form-group m-form__group">
															<a id="network_plus_icon" class="btn btn-md btn-success"><i class="fa fa-plus"></i> Add</a>
														</div>
														<!--<div class="form-actions">
															<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button>
															<a href="device_categories.php" class="btn btn-alt btn-large btn-black">Back</a>
														</div>-->
										
													</div>
										
													<div class="tab-pane" id="tab5">
														<div class="m-portlet">
															<div class="m-portlet__body">
																<!--<h3>Connectivity Fields</h3>-->
																<div class="form-group m-form__group">
																	<label>Connectivity Title</label>
																	<input type="text" class="form-control m-input" id="connectivity_title" value="<?=$category_data['connectivity_title']?>" name="connectivity_title">
																</div>
																<div class="form-group m-form__group">
																	<label>Connectivity Tooltip</label>
																		<textarea class="form-control summernote" name="tooltip_connectivity" rows="5"><?=$category_data['tooltip_connectivity']?></textarea>
																</div>
																<div class="m-form__group form-group">
																	<div class="m-checkbox-list">
																		<label class="m-checkbox">
																			<input id="required_connectivity" type="checkbox" value="1" name="required_connectivity" <?php if($category_data['required_connectivity']=='1'){echo 'checked="checked"';}?>>
																			Require customer selection
																			<span></span>
																		</label>
																	</div>
																</div>
																<div class="form-group m-form__group">
																	<label>Add Connectivity</label>
																</div>
																<div class="control-group" id="add_connectivity_item">
																	<div class="form-controls">
																	<?php
																	if(!empty($connectivity_items_array)) {
																		foreach($connectivity_items_array as $key=>$connectivity_item) {
																			$connectivity_id = $connectivity_item['id']; ?>
																			<div class="row" id="clr<?=$key?>" style="margin-top:5px;">
																				<div class="col-6"><input type="text" class="form-control m-input" id="connectivity_name[<?=$connectivity_id?>]" name="connectivity_name[<?=$connectivity_id?>]" value="<?=$connectivity_item['connectivity_name']?>" placeholder="Name"></div>
																				<div class="col-1">
																				<a href="javascript:void(0);" class="remove_connectivity_item" id="rm_clr<?=$key?>"><i class="la la-trash trash"></i></a></div>
																			</div>
																			<script>remove_connectivity_item();</script>
																		<?php
																		}
																	} ?>
																	</div>
																</div>
																<div class="form-group m-form__group">
																	<a id="connectivity_plus_icon" class="btn btn-md btn-success"><i class="fa fa-plus"></i> Add</a>
																</div>
																<!--<div class="form-actions">
																	<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button> <a href="device_categories.php" class="btn btn-alt btn-large btn-black">Back</a>
																</div>-->
															</div>
														</div>
													</div>
													
													<div class="tab-pane" id="tab19">
														<div class="m-portlet">
															<div class="m-portlet__body">
																<!--<h3>Model Fields</h3>-->
																<div class="form-group m-form__group">
																	<label>Model Title</label>
																	<input type="text" class="form-control m-input" id="model_title" value="<?=$category_data['model_title']?>" name="model_title">
																</div>
																<div class="form-group m-form__group">
																	<label>Model Tooltip</label>
																		<textarea class="form-control summernote" name="tooltip_model" rows="5"><?=$category_data['tooltip_model']?></textarea>
																</div>
																<div class="m-form__group form-group">
																	<div class="m-checkbox-list">
																		<label class="m-checkbox">
																			<input id="required_model" type="checkbox" value="1" name="required_model" <?php if($category_data['required_model']=='1'){echo 'checked="checked"';}?>>
																			Require customer selection
																			<span></span>
																		</label>
																	</div>
																</div>
																<div class="form-group m-form__group">
																	<label>Add Model</label>
																</div>
																<div class="control-group" id="add_model_item">
																	<div class="form-controls">
																	<?php
																	if(!empty($model_items_array)) {
																		foreach($model_items_array as $key=>$model_item) {
																			$model_id = $model_item['id']; ?>
																			<div class="row" id="mdl<?=$key?>" style="margin-top:5px;">
																				<div class="col-6">
																				<input type="text" class="form-control m-input" id="model_name[<?=$model_id?>]" name="model_name[<?=$model_id?>]" value="<?=$model_item['model_name']?>" placeholder="Name">
																				</div>
																				<div class="col-1">
																				<a href="javascript:void(0);" class="remove_model_item" id="rm_mdl<?=$key?>"><i class="la la-trash trash"></i></a>
																				</div>
																			</div>
																			<script>remove_model_item();</script>
																		<?php
																		}
																	} ?>
																	</div>
																</div>
																<div class="form-group m-form__group">
																	<a id="model_plus_icon" class="btn btn-md btn-success"><i class="fa fa-plus"></i> Add</a>
																</div>
																<!--<div class="form-actions">
																	<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button> <a href="device_categories.php" class="btn btn-alt btn-large btn-black">Back</a>
																</div>-->
															</div>
														</div>
													</div>
													
													<div class="tab-pane" id="tab20">
														<div class="m-portlet">
															<div class="m-portlet__body">
																<!--<h3>Graphics Card Fields</h3>-->
																<div class="form-group m-form__group">
																	<label>Graphics Card Title</label>
																	<input type="text" class="form-control m-input" id="graphics_card_title" value="<?=$category_data['graphics_card_title']?>" name="graphics_card_title">
																</div>
																<div class="form-group m-form__group">
																	<label>Graphics Card Tooltip</label>
																		<textarea class="form-control summernote" name="tooltip_graphics_card" rows="5"><?=$category_data['tooltip_graphics_card']?></textarea>
																</div>
																<div class="m-form__group form-group">
																	<div class="m-checkbox-list">
																		<label class="m-checkbox">
																			<input id="required_graphics_card" type="checkbox" value="1" name="required_graphics_card" <?php if($category_data['required_graphics_card']=='1'){echo 'checked="checked"';}?>>
																			Require customer selection
																			<span></span>
																		</label>
																	</div>
																</div>
																<div class="form-group m-form__group">
																	<label>Add Graphics Card</label>
																</div>
																<div class="control-group" id="add_graphics_card_item">
																	<div class="form-controls">
																	<?php
																	if(!empty($graphics_card_items_array)) {
																		foreach($graphics_card_items_array as $key=>$graphics_card_item) {
																			$graphics_card_id = $graphics_card_item['id']; ?>
																			<div class="row" id="gpc<?=$key?>" style="margin-top:5px;">
																				<div class="col-6">
																					<input type="text" class="form-control m-input" id="graphics_card_name[<?=$graphics_card_id?>]" name="graphics_card_name[<?=$graphics_card_id?>]" value="<?=$graphics_card_item['graphics_card_name']?>" placeholder="Name">
																				</div>
																				<div class="col-1">
																					<a href="javascript:void(0);" class="remove_graphics_card_item" id="rm_gpc<?=$key?>"><i class="la la-trash trash"></i></a>
																				</div>
																			</div>
																			<script>remove_graphics_card_item();</script>
																		<?php
																		}
																	} ?>
																	</div>
																</div>
																<div class="form-group m-form__group">
																	<a id="graphics_card_plus_icon" class="btn btn-md btn-success"><i class="fa fa-plus"></i> Add</a>
																</div>
																<!--<div class="form-actions">
																	<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button> <a href="device_categories.php" class="btn btn-alt btn-large btn-black">Back</a>
																</div>-->
															</div>
														</div>
													</div>
										
													<div class="tab-pane" id="tab6">
														<div class="m-portlet">
															<div class="m-portlet__body">
																<!--<h3>Case Size Fields</h3>-->
																<div class="form-group m-form__group">
																	<label>Size Title</label>
																	<input type="text" class="form-control m-input" id="case_size_title" value="<?=$category_data['case_size_title']?>" name="case_size_title">
																</div>
																<div class="form-group m-form__group">
																	<label>Size Tooltip</label>
																		<textarea class="form-control summernote" name="tooltip_case_size" rows="5"><?=$category_data['tooltip_case_size']?></textarea>
																</div>
																<div class="m-form__group form-group">
																	<div class="m-checkbox-list">
																		<label class="m-checkbox">
																			<input id="required_case_size" type="checkbox" value="1" name="required_case_size" <?php if($category_data['required_case_size']=='1'){echo 'checked="checked"';}?>>
																			Require customer selection
																			<span></span>
																		</label>
																	</div>
																</div>
																<div class="form-group m-form__group">
																	<label>Add Size</label>
																</div>
																<div class="control-group" id="add_case_size_item">
																	<div class="form-controls">
																	<?php
																	if(!empty($case_size_items_array)) {
																		foreach($case_size_items_array as $key=>$case_size_item) {
																			$case_size_id = $case_size_item['id']; ?>
																			<div class="row" id="misc<?=$key?>" style="margin-top:5px;">
																				<div class="col-6">
																				<input type="text" class="form-control m-input" id="case_size[<?=$case_size_id?>]" name="case_size[<?=$case_size_id?>]" value="<?=html_entities($case_size_item['case_size'])?>" placeholder="Case Size">
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
																<div class="form-group m-form__group">
																	<a id="case_size_plus_icon" class="btn btn-md btn-success"><i class="fa fa-plus"></i> Add</a>
																</div>
																<!--<div class="form-actions">
																	<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button> <a href="device_categories.php" class="btn btn-alt btn-large btn-black">Back</a>
																</div>-->
															</div>
														</div>
													</div>
										
													<div class="tab-pane" id="tab7">
														<div class="m-portlet">
															<div class="m-portlet__body">
																<!--<h3>Type Fields</h3>-->
																<div class="form-group m-form__group">
																	<label>Type Title</label>
																	<input type="text" class="form-control m-input" id="type_title" value="<?=$category_data['type_title']?>" name="type_title">
																</div>
																<div class="form-group m-form__group">
																	<label>Type Tooltip</label>
																		<textarea class="form-control summernote" name="tooltip_watchtype" rows="5"><?=$category_data['tooltip_watchtype']?></textarea>
																</div>
																<div class="m-form__group form-group">
																	<div class="m-checkbox-list">
																		<label class="m-checkbox">
																			<input id="required_watchtype" type="checkbox" value="1" name="required_watchtype" <?php if($category_data['required_watchtype']=='1'){echo 'checked="checked"';}?>>
																			Require customer selection
																			<span></span>
																		</label>
																	</div>
																</div>
																<div class="form-group m-form__group">
																	<label>Add Type</label>
																</div>
																<div class="control-group" id="add_watchtype_item">
																	<div class="form-controls">
																	<?php
																	if(!empty($watchtype_items_array)) {
																		foreach($watchtype_items_array as $key=>$watchtype_item) {
																			$watchtype_id = $watchtype_item['id']; ?>
																			<div id="accssr<?=$key?>" style="margin-top:5px;">
																				<input type="text" class="form-control m-input" id="watchtype_name[<?=$watchtype_id?>]" name="watchtype_name[<?=$watchtype_id?>]" value="<?=html_entities($watchtype_item['watchtype_name'])?>" placeholder="Name">
																				<a href="javascript:void(0);" class="remove_watchtype_item" id="rm_accssr<?=$key?>"><i class="la la-trash trash"></i></a>
																			</div>
																			<script>remove_watchtype_item();</script>
																		<?php
																		}
																	} ?>
																	</div>
																</div>
																<div class="form-group m-form__group">
																	<a id="watchtype_plus_icon" class="btn btn-md btn-success"><i class="fa fa-plus"></i> Add</a>
																</div>
																<!--<div class="form-actions">
																	<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button> <a href="device_categories.php" class="btn btn-alt btn-large btn-black">Back</a>
																</div>-->
															</div>
														</div>
													</div>
													
													<div class="tab-pane" id="tab8">
														<div class="m-portlet">
															<div class="m-portlet__body">
																<!--<h3>Type Fields</h3>-->
																<div class="form-group m-form__group">
																	<label>Case Material Title</label>
																	<input type="text" class="form-control m-input" id="case_material_title" value="<?=$category_data['case_material_title']?>" name="case_material_title">
																</div>
																<div class="form-group m-form__group">
																	<label>Case Material Tooltip</label>
																		<textarea class="form-control summernote" name="tooltip_case_material" rows="5"><?=$category_data['tooltip_case_material']?></textarea>
																</div>
																<div class="m-form__group form-group">
																	<div class="m-checkbox-list">
																		<label class="m-checkbox">
																			<input id="required_case_material" type="checkbox" value="1" name="required_case_material" <?php if($category_data['required_case_material']=='1'){echo 'checked="checked"';}?>>
																			Require customer selection
																			<span></span>
																		</label>
																	</div>
																</div>
																<div class="form-group m-form__group">
																	<label>Add Case Material</label>
																</div>
																<div class="control-group" id="add_case_material_item">
																	<div class="form-controls">
																	<?php
																	if(!empty($case_material_items_array)) {
																		foreach($case_material_items_array as $key=>$case_material_item) {
																			$case_material_id = $case_material_item['id']; ?>
																			<div id="accssr<?=$key?>" style="margin-top:5px;">
																				<input type="text" class="form-control m-input" id="case_material_name[<?=$case_material_id?>]" name="case_material_name[<?=$case_material_id?>]" value="<?=html_entities($case_material_item['case_material_name'])?>" placeholder="Name">
																				<a href="javascript:void(0);" class="remove_case_material_item" id="rm_accssr<?=$key?>"><i class="la la-trash trash"></i></a>
																			</div>
																			<script>remove_case_material_item();</script>
																		<?php
																		}
																	} ?>
																	</div>
																</div>
																<div class="form-group m-form__group">
																		 <a id="case_material_plus_icon" class="btn btn-md btn-success"><i class="fa fa-plus"></i> Add</a>
																</div>
																<!--<div class="form-actions">
																	<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button> <a href="device_categories.php" class="btn btn-alt btn-large btn-black">Back</a>
																</div>-->
															</div>
														</div>
													</div>
													
													<div class="tab-pane" id="tab12">
														<div class="m-portlet">
															<div class="m-portlet__body">
																<!--<h3>Type Fields</h3>-->
																<div class="form-group m-form__group">
																	<label>Accessories Title</label>
																	<input type="text" class="form-control m-input" id="accessories_title" value="<?=$category_data['accessories_title']?>" name="accessories_title">
																</div>
																<div class="form-group m-form__group">
																	<label>Accessories Tooltip</label>
																		<textarea class="form-control summernote" name="tooltip_accessories" rows="5"><?=$category_data['tooltip_accessories']?></textarea>
																</div>
																<div class="m-form__group form-group">
																	<div class="m-checkbox-list">
																		<label class="m-checkbox">
																			<input id="required_accessories" type="checkbox" value="1" name="required_accessories" <?php if($category_data['required_accessories']=='1'){echo 'checked="checked"';}?>>
																			Require customer selection
																			<span></span>
																		</label>
																	</div>
																</div>
																<div class="form-group m-form__group">
																	<label>Add Accessories</label>
																</div>
																<div class="control-group" id="add_accessories_item">
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
																	<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button> <a href="device_categories.php" class="btn btn-alt btn-large btn-black">Back</a>
																</div>-->
															</div>
														</div>
													</div>
													
													<div class="tab-pane" id="tab18">
														<div class="m-portlet">
															<div class="m-portlet__body">
																<!--<h3>Type Fields</h3>-->
																<div class="form-group m-form__group">
																	<label>Band Included Title</label>
																	<input type="text" class="form-control m-input" id="band_included_title" value="<?=$category_data['band_included_title']?>" name="band_included_title">
																</div>
																<div class="form-group m-form__group">
																	<label>Band Included Tooltip</label>
																		<textarea class="form-control summernote" name="tooltip_band_included" rows="5"><?=$category_data['tooltip_band_included']?></textarea>
																</div>
																<div class="m-form__group form-group">
																	<div class="m-checkbox-list">
																		<label class="m-checkbox">
																			<input id="required_band_included" type="checkbox" value="1" name="required_band_included" <?php if($category_data['required_band_included']=='1'){echo 'checked="checked"';}?>>
																			Require customer selection
																			<span></span>
																		</label>
																	</div>
																</div>
																<div class="form-group m-form__group">
																	<label>Add Band Included</label>
																</div>
																<div class="control-group" id="add_band_included_item">
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
																	<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button> <a href="device_categories.php" class="btn btn-alt btn-large btn-black">Back</a>
																</div>-->
															</div>
														</div>
													</div>
													
													<div class="tab-pane" id="tab16">
														<div class="m-portlet">
															<div class="m-portlet__body">
																<div class="form-group m-form__group">
																	<label>Processor Title</label>
																	<input type="text" class="form-control m-input" id="processor_title" value="<?=$category_data['processor_title']?>" name="processor_title">
																</div>
																<div class="form-group m-form__group">
																	<label>Processor Tooltip</label>
																		<textarea class="form-control summernote" name="tooltip_processor" rows="5"><?=$category_data['tooltip_processor']?></textarea>
																</div>
																<div class="m-form__group form-group">
																	<div class="m-checkbox-list">
																		<label class="m-checkbox">
																			<input id="required_processor" type="checkbox" value="1" name="required_processor" <?php if($category_data['required_processor']=='1'){echo 'checked="checked"';}?>>
																			Require customer selection
																			<span></span>
																		</label>
																	</div>
																</div>
																<div class="form-group m-form__group">
																	<label>Add Processor</label>
																</div>
																<div class="control-group" id="add_processor_item">
																	<div class="form-controls">
																	<?php
																	if(!empty($processor_items_array)) {
																		foreach($processor_items_array as $key=>$processor_item) {
																			$processor_id = $processor_item['id']; ?>
																			<div class="row" id="prcr<?=$key?>" style="margin-top:5px;">
																				<div class="col-6">
																				<input type="text" class="form-control m-input" id="processor_name[<?=$processor_id?>]" name="processor_name[<?=$processor_id?>]" value="<?=html_entities($processor_item['processor_name'])?>" placeholder="Name">
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
																<div class="form-group m-form__group">
																	<a id="processor_plus_icon" class="btn btn-md btn-success"><i class="fa fa-plus"></i> Add</a>
																</div>
																<!--<div class="form-actions">
																	<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button> <a href="device_categories.php" class="btn btn-alt btn-large btn-black">Back</a>
																</div>-->
															</div>
														</div>
													</div>
													
													<div class="tab-pane" id="tab17">
														<div class="m-portlet">
															<div class="m-portlet__body">
																<div class="form-group m-form__group">
																	<label>RAM Title</label>
																	<input type="text" class="form-control m-input" id="ram_title" value="<?=$category_data['ram_title']?>" name="ram_title">
																</div>
																<div class="form-group m-form__group">
																	<label>RAM Tooltip</label>
																		<textarea class="form-control summernote" name="tooltip_ram" rows="5"><?=$category_data['tooltip_ram']?></textarea>
																</div>
																<div class="m-form__group form-group">
																	<div class="m-checkbox-list">
																		<label class="m-checkbox">
																			<input id="required_ram" type="checkbox" value="1" name="required_ram" <?php if($category_data['required_ram']=='1'){echo 'checked="checked"';}?>>
																			Require customer selection
																			<span></span>
																		</label>
																	</div>
																</div>
																<div class="form-group m-form__group">
																	<label>Add RAM</label>
																</div>
																<div class="control-group" id="add_ram_item">
																	<div class="form-controls">
																	<?php
																	if(!empty($ram_items_array)) {
																		foreach($ram_items_array as $key=>$ram_item) {
																			$ram_id = $ram_item['id']; ?>
																			<div class="row" id="ram<?=$key?>" style="margin-top:5px;">
																				<div class="col-5">
																				<input type="text" class="form-control m-input" id="ram_size[<?=$ram_id?>]" name="ram_size[<?=$ram_id?>]" value="<?=html_entities($ram_item['ram_size'])?>" placeholder="Storage Sizes">
																				</div>
																				<div class="col-3">
																				<select class="form-control m-input" name="ram_size_postfix[<?=$ram_id?>]" id="ram_size_postfix[<?=$ram_id?>]">
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
																<div class="form-group m-form__group">
																	<a id="ram_plus_icon" class="btn btn-md btn-success"><i class="fa fa-plus"></i> Add</a>
																</div>
																<!--<div class="form-actions">
																	<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button> <a href="device_categories.php" class="btn btn-alt btn-large btn-black">Back</a>
																</div>-->
															</div>
														</div>
													</div>
													
												</div>
											</div>
										</div>
						
									</div>
								</div>
								<input type="hidden" name="id" value="<?=$category_data['id']?>" />
								<div class="m-portlet__foot m-portlet__foot--fit">
									<div class="m-form__actions m-form__actions">
										<button type="submit" name="update" class="btn btn-primary">
										  <?=($id?'Update':'Save')?>
										</button>
										<a href="device_categories.php" class="btn btn-secondary">Back</a>
									</div>
								</div>
							</form>
							<!--end::Form-->
						</div>
						<!--end::Portlet-->
					</div>
				</div>
				<!--End::Section-->
			</div>
		</div>
	</div>
	<!-- end:: Body -->
	<!-- begin::Footer -->
	<?php include("include/footer.php");?>
	<!-- end::Footer -->
</div>
<!-- end:: Page -->

<!-- begin::Scroll Top -->
<div id="m_scroll_top" class="m-scroll-top">
	<i class="la la-arrow-up"></i>
</div>
<!-- end::Scroll Top -->
