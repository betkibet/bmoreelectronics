<script src="js/jquery.copy.js"></script>

<script type="text/javascript">
function check_form(a){
	if(jQuery('.summernote').summernote('codeview.isActivated')) {
		jQuery('.summernote').summernote('codeview.deactivate');
	}

	if(jQuery('.summernote2').summernote('codeview.isActivated')) {
		jQuery('.summernote2').summernote('codeview.deactivate');
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

	if((FileExt != "gif" && FileExt != "png" && FileExt != "jpg" && FileExt != "jpeg" && FileExt != "svg")) {
	    var error = "Please make sure your file is in png | jpg | jpeg | gif | svg format.\n\n";
	    alert(error);
		document.getElementById(id).value = '';
	    return false;
	}
}

function checkFile_without_svg(fieldObj) {
	if(fieldObj.files.length == 0) {
		return false;
	}

    var id = fieldObj.id;
	var str  = fieldObj.value;
	var FileExt = str.substr(str.lastIndexOf('.')+1);
	var FileExt = FileExt.toLowerCase();
	var FileSize = fieldObj.files[0].size;
	var FileSizeMB = (FileSize/10485760).toFixed(2);

	if((FileExt != "gif" && FileExt != "png" && FileExt != "jpg" && FileExt != "jpeg")) {
	    var error = "Please make sure your file is in png | jpg | jpeg | gif format.\n\n";
	    alert(error);
		document.getElementById(id).value = '';
	    return false;
	}
}

function checkFileXml(fieldObj) {
	if(fieldObj.files.length == 0) {
		return false;
	}

    var id = fieldObj.id;
	var str  = fieldObj.value;
	var FileExt = str.substr(str.lastIndexOf('.')+1);
	var FileExt = FileExt.toLowerCase(); 
	var FileSize = fieldObj.files[0].size;
	var FileSizeMB = (FileSize/10485760).toFixed(2);

	if((FileExt != "xml")) {
	    var error = "Please make sure your file is in xml format.\n\n";
	    alert(error);
		document.getElementById(id).value = '';
	    return false;
	}
}

function chg_mailer_type(type) {
	if(type=="smtp") {
		$(".showhide_smtp_fields").show();
		$(".showhide_emailapi_fields").hide();
	} else if(type=="sendgrid") {
		$(".showhide_smtp_fields").hide();
		$(".showhide_emailapi_fields").show();
	} else {
		$(".showhide_smtp_fields").hide();
		$(".showhide_emailapi_fields").hide();
	}
}

$(document).ready(function() {
	
	$("#copy-constant").click(function() {
		var constant_name = $("#constant_name").val();
		if(constant_name == "") {
			alert("Please select constant.");
			return false;
		} else {
			var res = $.copy(constant_name);
			//$("#status").text(res);
		}
	});

	$('.default_carrier_account').on("click",function(e){
		var default_carrier_account = $("input[name='default_carrier_account']:checked").val();
		if(default_carrier_account == "usps") {
			$('.showhide_shipping_api_usps_service').show();
			$('.showhide_shipping_api_ups_service').hide();
			$('.showhide_shipping_api_fedex_service').hide();
			$('.showhide_shipping_api_dhl_service').hide();
		} else if(default_carrier_account == "ups") {
			$('.showhide_shipping_api_usps_service').hide();
			$('.showhide_shipping_api_ups_service').show();
			$('.showhide_shipping_api_fedex_service').hide();
			$('.showhide_shipping_api_dhl_service').hide();
		} else if(default_carrier_account == "fedex") {
			$('.showhide_shipping_api_usps_service').hide();
			$('.showhide_shipping_api_ups_service').hide();
			$('.showhide_shipping_api_fedex_service').show();
			$('.showhide_shipping_api_dhl_service').hide();
		} else if(default_carrier_account == "dhl") {
			$('.showhide_shipping_api_usps_service').hide();
			$('.showhide_shipping_api_ups_service').hide();
			$('.showhide_shipping_api_fedex_service').hide();
			$('.showhide_shipping_api_dhl_service').show();
		} else {
			$('.showhide_shipping_api_usps_service').hide();
			$('.showhide_shipping_api_ups_service').hide();
			$('.showhide_shipping_api_fedex_service').hide();
			$('.showhide_shipping_api_dhl_service').hide();	
		}
	});
	
	$('#is_ip_restriction').on("change",function(e){
		var checked = $("#is_ip_restriction").is(":checked");
		if(checked){
			$('.allowed_ip').show();
		} else {
			$('.allowed_ip').hide();	
		}
	});
	
	$('#shipping_option_print_a_prepaid_label').on("change",function(e){
		var checked = $("#shipping_option_print_a_prepaid_label").is(":checked");
		if(checked){
			$('.shipping_api_fields').show();
		} else {
			$('.shipping_api_fields').hide();	
		}
	});
});
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
					<div class="col-lg-12">
						<!--begin::Portlet-->
						<div class="m-portlet">
							<form class="m-form" action="controllers/general_settings.php" role="form" method="post" onSubmit="return check_form(this);" enctype="multipart/form-data">
								  <div class="m-portlet__head">
									<div class="m-portlet__head-caption">
									  <div class="m-portlet__head-title">
										<h3 class="m-portlet__head-text">
										  Settings
										</h3>
									  </div>
									</div>
								  </div>
								  <div class="m-portlet__body">
									<div class="row">
										<div class="col-md-3">
											<ul class="nav nav-tabs flex-column nav-pills vartical-tab  m-tabs-line m-tabs-line--success" role="tablist">
											  <li class="nav-item m-tabs__item">
												<a class="nav-link m-tabs__link active show" data-toggle="tab" href="#m_tabs_6_1" role="tab" aria-selected="false">
												  General Settings
												</a>
											  </li>
											  <li class="nav-item m-tabs__item">
												<a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_get_paid" role="tab" aria-selected="true">
												  Get Paid
												</a>
											  </li>
											  <li class="nav-item m-tabs__item">
												<a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_6_2" role="tab" aria-selected="true">
												  Company Details
												</a>
											  </li>
											  <li class="nav-item m-tabs__item">
												<a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_6_3" role="tab" aria-selected="true">
												  Email Settings
												</a>
											  </li>
											  <li class="nav-item m-tabs__item">
												<a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_6_5" role="tab" aria-selected="true">
												  SMS Settings
												</a>
											  </li>
											  <li class="nav-item m-tabs__item">
												<a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_6_4" role="tab" aria-selected="true">
												  Socials Settings
												</a>
											  </li>
											  <li class="nav-item m-tabs__item">
												<a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_6_7" role="tab" aria-selected="true">
												  Shipping API
												</a>
											  </li>
											  <li><a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_6_9" role="tab" aria-selected="true">Captcha Settings</a></li>
											  <li><a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_6_10" role="tab" aria-selected="true">Email Template Settings</a></li>
											  <li><a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_6_11" role="tab" aria-selected="true">Model Fields Settings</a></li>
											  <li><a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_6_12" role="tab" aria-selected="true">Menu Type Settings</a></li>
											  <li class="nav-item m-tabs__item">
												<a class="nav-link m-tabs__link" data-toggle="tab" href="#app_crons_tab" role="tab" aria-selected="true">
												  Cron Settings
												</a>
											  </li>
											  <li class="nav-item m-tabs__item">
												<a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_6_6" role="tab" aria-selected="true">
												  Blog Settings
												</a>
											  </li>
											  <li class="nav-item m-tabs__item">
												<a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_6_8" role="tab" aria-selected="true">
												  Sitemap (XML)
												</a>
											  </li>
											  <li class="nav-item m-tabs__item">
												<a class="nav-link m-tabs__link" data-toggle="tab" href="#app_settings_tab" role="tab" aria-selected="true">
												  App Settings
												</a>
											  </li>
											  <li class="nav-item m-tabs__item">
												<a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_success_page" role="tab" aria-selected="true">
												  Order Complete Page
												</a>
											  </li>
											  <li class="nav-item m-tabs__item">
												<a class="nav-link m-tabs__link" data-toggle="tab" href="#theme_settings_tab" role="tab" aria-selected="true">
												  Theme Settings
												</a>
											  </li>
											</ul>
										</div>
										<div class="col-md-9">
											<div class="tab-content">
			                  					<div class="tab-pane active show" id="m_tabs_6_1" role="tabpanel">
													<!--begin::Portlet-->
													<div class="m-portlet">
														<div class="m-portlet__head">
															<div class="m-portlet__head-caption">
																<div class="m-portlet__head-title">
																	<span class="m-portlet__head-icon m--hide">
																	  <i class="la la-gear"></i>
																	</span>
																	<h3 class="m-portlet__head-text">
																	  General Settings
																	</h3>
																</div>
															</div>
														</div>
														<!--begin::Form-->
														<div class="m-portlet__body">
															<div class="m-form__section m-form__section--first">
																<div class="form-group m-form__group">
																	<label for="admin_panel_name">
																		Admin Panel Name
																	</label>
																	<input type="text" class="form-control m-input" id="admin_panel_name" value="<?=$general_setting_data['admin_panel_name']?>" name="admin_panel_name">
																</div>
																
																<div class="form-group m-form__group row">
																	<div class="col-lg-6">
																		<label for="logo">Admin Logo</label>
																		<div class="custom-file">
																			<input type="file" id="admin_logo" class="custom-file-input" name="admin_logo" onChange="checkFile(this);" accept="image/*">
																			<label class="custom-file-label" for="logo">
																				Choose file
																			</label>
																		</div>
																		
																		<?php
																		if($general_setting_data['admin_logo']!="") { ?>
																			<img src="../images/<?=$general_setting_data['admin_logo'].'?token='.uniqid()?>" width="200" class="my-md-2">
																			<a class="btn btn-danger btn-sm" data-dismiss="fileupload" href="controllers/general_settings.php?r_a_logo_id=<?=$general_setting_data['id']?>" onclick="return confirm('Are you sure to delete logo?');">Remove</a>
																		<?php
																		} ?>
																	</div>
																	<div class="col-lg-3">
																		<label>Width</label>
																		<input type="number" class="form-control m-input m-input--square" name="other_settings[admin_logo_width]" value="<?=$other_settings['admin_logo_width']?>" maxlength="3" min="0">
																	</div>
																	<div class="col-lg-3">
																		<label>Height</label>
																		<input type="number" class="form-control m-input m-input--square" name="other_settings[admin_logo_height]" value="<?=$other_settings['admin_logo_height']?>" maxlength="3" min="0">
																	</div>
																</div>
																
																<div class="form-group m-form__group row">
																	<div class="col-lg-6">
																		<label for="logo">Front Logo</label>
																		<div class="custom-file">
																			<input type="file" id="logo" class="custom-file-input" name="logo" onChange="checkFile(this);" accept="image/*">
																			<label class="custom-file-label" for="logo">
																				Choose file
																			</label>
																		</div>
																		
																		<?php
																		if($general_setting_data['logo']!="") { ?>
																			<img src="../images/<?=$general_setting_data['logo'].'?token='.uniqid()?>" width="200" class="my-md-2">
																			<a class="btn btn-danger btn-sm" data-dismiss="fileupload" href="controllers/general_settings.php?r_logo_id=<?=$general_setting_data['id']?>" onclick="return confirm('Are you sure to delete logo?');">Remove</a>
																		<?php
																		} ?>
																	</div>
																	<div class="col-lg-3">
																		<label>Width</label>
																		<input type="number" class="form-control m-input m-input--square" name="other_settings[logo_width]" value="<?=$other_settings['logo_width']?>" maxlength="3" min="0">
																	</div>
																	<div class="col-lg-3">
																		<label>Height</label>
																		<input type="number" class="form-control m-input m-input--square" name="other_settings[logo_height]" value="<?=$other_settings['logo_height']?>" maxlength="3" min="0">
																	</div>
																</div>
										
																<div class="form-group m-form__group row">
																	<div class="col-lg-6">
																		<label for="logo_fixed">Front Logo (Fixed)</label>
																		<div class="custom-file">
																			<input type="file" id="logo_fixed" class="custom-file-input" name="logo_fixed" onChange="checkFile(this);" accept="image/*">
																			<label class="custom-file-label" for="logo">
																				Choose file
																			</label>
																		</div>
																		
																		<?php
																		if($general_setting_data['logo_fixed']!="") { ?>
																			<img src="../images/<?=$general_setting_data['logo_fixed'].'?token='.uniqid()?>" width="200" class="my-md-2">
																			<a class="btn btn-danger btn-sm" data-dismiss="fileupload" href="controllers/general_settings.php?r_logo_fixed_id=<?=$general_setting_data['id']?>" onclick="return confirm('Are you sure to delete logo?');">Remove</a>
																		<?php
																		} ?>
																	</div>
																	<div class="col-lg-3">
																		<label>Width</label>
																		<input type="number" class="form-control m-input m-input--square" name="other_settings[fixed_logo_width]" value="<?=$other_settings['fixed_logo_width']?>" maxlength="3" min="0">
																	</div>
																	<div class="col-lg-3">
																		<label>Height</label>
																		<input type="number" class="form-control m-input m-input--square" name="other_settings[fixed_logo_height]" value="<?=$other_settings['fixed_logo_height']?>" maxlength="3" min="0">
																	</div>
																</div>
																
																<div class="form-group m-form__group row">
																	<div class="col-lg-6">
																		<label for="footer_logo">Footer Logo</label>
																		<div class="custom-file">
																			<input type="file" id="footer_logo" class="custom-file-input" name="footer_logo" onChange="checkFile(this);" accept="image/*">
																			<label class="custom-file-label" for="logo">
																				Choose file
																			</label>
																		</div>
																	
																		<?php
																		if($general_setting_data['footer_logo']!="") { ?>
																			<img src="../images/<?=$general_setting_data['footer_logo'].'?token='.get_unique_id_on_load()?>" width="200" class="my-md-2">
																			<a class="btn btn-danger btn-sm" data-dismiss="fileupload" href="controllers/general_settings.php?r_footer_logo_id=<?=$general_setting_data['id']?>" onclick="return confirm('Are you sure to delete footer logo?');">Remove</a>
																		<?php
																		} ?>
																	</div>
																	<div class="col-lg-3">
																		<label>Width</label>
																		<input type="number" class="form-control m-input m-input--square" name="other_settings[footer_logo_width]" value="<?=$other_settings['footer_logo_width']?>" maxlength="3" min="0">
																	</div>
																	<div class="col-lg-3">
																		<label>Height</label>
																		<input type="number" class="form-control m-input m-input--square" name="other_settings[footer_logo_height]" value="<?=$other_settings['footer_logo_height']?>" maxlength="3" min="0">
																	</div>
																</div>
																
																<div class="form-group m-form__group row">
																	<div class="col-lg-6">
																		<label for="logo_email">Logo (Email)</label>
																		<div class="custom-file">
																			<input type="file" id="logo_email" class="custom-file-input" name="logo_email" onChange="checkFile_without_svg(this);" accept="image/*">
																			<label class="custom-file-label" for="logo">
																				Choose file
																			</label>
																		</div>
																		
																		<?php
																		if($general_setting_data['logo_email']!="") { ?>
																			<img src="../images/<?=$general_setting_data['logo_email'].'?token='.uniqid()?>" width="200" class="my-md-2">
																			<a class="btn btn-danger btn-sm" data-dismiss="fileupload" href="controllers/general_settings.php?r_logo_email_id=<?=$general_setting_data['id']?>" onclick="return confirm('Are you sure to delete logo?');">Remove</a>
																		<?php
																		} ?>
																	</div>
																	<div class="col-lg-3">
																		<label>Width</label>
																		<input type="number" class="form-control m-input m-input--square" name="other_settings[email_logo_width]" value="<?=$other_settings['email_logo_width']?>" maxlength="3" min="0">
																	</div>
																	<div class="col-lg-3">
																		<label>Height</label>
																		<input type="number" class="form-control m-input m-input--square" name="other_settings[email_logo_height]" value="<?=$other_settings['email_logo_height']?>" maxlength="3" min="0">
																	</div>
																</div>
																
																<div class="form-group m-form__group">
																	<label for="favicon_icon">Favicon</label>
																	<div class="custom-file">
																		<input type="file" class="custom-file-input" id="favicon_icon" name="favicon_icon" onChange="checkFaviconIcon(this);" accept="image/*">
																		<label class="custom-file-label" for="logo">
																			Choose file
																		</label>
																	</div>
																	<?php 
																	if($general_setting_data['favicon_icon']!="") { ?>
																		<img class="m--margin-top-10 img-container" src="../images/<?=$general_setting_data['favicon_icon'].'?token='.uniqid()?>" width="150">
																		<a class="btn btn-danger btn-sm" href="controllers/general_settings.php?r_favicon_id=<?=$general_setting_data['id']?>" onclick="return confirm('Are you sure to delete favicon?');">Remove</a>
																	<?php 
																	} ?>
																</div>
																
																<div class="form-group m-form__group row">
																	<div class="col-6">
																		<label for="site_name">Site Name</label>
																		<input type="text" class="form-control m-input" id="site_name" value="<?=$general_setting_data['site_name']?>" name="site_name">
																	</div>
																	<div class="col-6">
																		<label for="website">
																			Website
																		</label>
																		<input type="text" class="form-control m-input" id="website" value="<?=$general_setting_data['website']?>" name="website">
																	</div>
																</div>
																<div class="form-group m-form__group row">
																	<div class="col-6">
																		<label for="phone">
																		Header/Footer Phone
																		</label>
																		<input type="text" class="form-control m-input" id="phone" value="<?=$general_setting_data['phone']?>"  name="phone">
																	</div>
																	<div class="col-6">
																		<label for="email">
																		Header/Footer Email
																		</label>
																		<input type="text" class="form-control m-input" id="email" value="<?=$general_setting_data['email']?>"  name="email">
																	</div>
																</div>
																<div class="form-group m-form__group row">
																	<div class="col-6">
																		<label for="copyright">
																		Copyright
																		</label>
																		<input type="text" class="form-control m-input" id="copyright" value="<?=$general_setting_data['copyright']?>" name="copyright">
																	</div>
																	<?php /*?><div class="col-6">
																		<label>Customer Country Code</label>
																		<input type="text" class="form-control m-input" id="other_settings[customer_country_code]" value="<?=$other_settings['customer_country_code']?>" name="other_settings[customer_country_code]">
																	</div><?php */?>
																</div>
																
																<div class="m-separator m-separator--dash m-separator--sm"></div>
																<div class="form-group m-form__group row">
																	<div class="col-5">
																		<label>Timezone</label>
																		<select id="timezone" name="timezone" class="form-control m-input">
																		<?php
																		$timezone_list = time_zonelist();
																		if(!empty($timezone_list)) {
																			foreach($timezone_list as $timezone_data) {
																				$selected="";
																				if($general_setting_data['timezone']==$timezone_data['value']) {
																					$selected='selected="selected"';
																				} ?>
																				<option value="<?=$timezone_data['value']?>" <?=$selected?> ><?=$timezone_data['display']?></option>
																			<?php 
																			} 
																		}?>
																		</select>
																		<small>Default TIME ZONE saved in Database is UTC.</small>
																	</div>
														
																	<div class="col-3">
																		<label>Time Format</label>
																		<select class="form-control m-input" id="time_format" name="time_format">
																			<option value="">Select Time Format</option>
																			<option value="12_hour" <?php if($general_setting_data['time_format']=='12_hour'){echo 'selected="selected"';}?>>12 hour</option>
																			<option value="24_hour" <?php if($general_setting_data['time_format']=='24_hour'){echo 'selected="selected"';}?>>24 hour</option>
																		</select>
																	</div>
																
																	<div class="col-4">
																	   <label>Date Format</label>
																	   <select class="form-control m-input" id="date_format" name="date_format">
																		  <option value="m/d/Y" <?php if($general_setting_data['date_format']=='m/d/Y'){echo 'selected="selected"';}?>>m/d/Y ex. <?=date("m/d/Y")?></option>
																		  <option value="d-m-Y" <?php if($general_setting_data['date_format']=='d-m-Y'){echo 'selected="selected"';}?>>d-m-Y ex. <?=date("d-m-Y")?></option>
																		  <option value="M/d/Y" <?php if($general_setting_data['date_format']=='M/d/Y'){echo 'selected="selected"';}?>>M/d/Y ex. <?=date("M/d/Y")?></option>
																		  <option value="d-M-Y" <?php if($general_setting_data['date_format']=='d-M-Y'){echo 'selected="selected"';}?>>d-M-Y ex. <?=date("d-M-Y")?></option>
																		  <option value="m/d/y" <?php if($general_setting_data['date_format']=='m/d/y'){echo 'selected="selected"';}?>>m/d/y ex. <?=date("m/d/y")?></option>
																		  <option value="d-m-y" <?php if($general_setting_data['date_format']=='d-m-y'){echo 'selected="selected"';}?>>d-m-y ex. <?=date("d-m-y")?></option>
																		  <option value="M/d/y" <?php if($general_setting_data['date_format']=='M/d/y'){echo 'selected="selected"';}?>>M/d/y ex. <?=date("M/d/y")?></option>
																		  <option value="d-M-y" <?php if($general_setting_data['date_format']=='d-M-y'){echo 'selected="selected"';}?>>d-M-y ex. <?=date("d-M-y")?></option>
																	   </select>
																    </div>
																</div>
																
																<div class="m-separator m-separator--dash m-separator--sm"></div>
																<!--<div class="m-form__group form-group">
																	<label for="published">
																		Status of Terms & Conditions
																	</label>
																	<div class="m-radio-inline">
																		<label class="m-radio">
																			<input type="radio" id="terms_status" name="terms_status" value="1" <?=($general_setting_data['terms_status']=='1'||$general_setting_data['disp_currency']==''?'checked="checked"':'')?>>
																			Enable
																			<span></span>
																		</label>
																		<label class="m-radio">
																			<input type="radio" id="terms_status" name="terms_status" value="0" <?=($general_setting_data['terms_status']=='0'?'checked="checked"':'')?>>
																			Disable
																			<span></span>
																		</label>
																	</div>
																</div>-->
																<div class="m-form__group form-group">
																	<label for="published">
																		Display Terms & Conditions
																	</label>
																	<div class="m-checkbox-inline">
																		<label class="m-checkbox">
																			<input id="display_terms" type="checkbox" value="ac_creation" name="display_terms[ac_creation]" <?php if($display_terms['ac_creation']=="ac_creation"){echo 'checked="checked"';}?>>
																			On Account Creation
																			<span></span>
																		</label>
																		<label class="m-checkbox">
																			<input id="display_terms" type="checkbox" value="confirm_sale" name="display_terms[confirm_sale]" <?php if($display_terms['confirm_sale']=="confirm_sale"){echo 'checked="checked"';}?>>
																			On Confirm Sale
																			<span></span>
																		</label>
																	</div>
																</div>
																<?php /*?><div class="form-group m-form__group">
																	<label for="terms">
																		Terms & Conditions
																	</label>
																	<textarea class="form-control m-input summernote" id="terms" name="terms" rows="5"><?=$general_setting_data['terms']?></textarea>
																</div><?php */?>
																
																<div class="m-separator m-separator--dash m-separator--sm"></div>
																<div class="m-form__group form-group row">
																	<div class="col-6">
																		<label for="published">
																			Show Missing Product Section 
																			<a href="javascript:void(0);" data-container="body" data-toggle="m-popover" data-placement="top" data-content="If customer not seeing model he want to sell, it display form to contact shop"><i class="fa fa-question"></i></a>		
																		</label>
																		<div class="m-radio-inline">
																			<label class="m-radio">
																				<input type="radio" id="missing_product_section" name="missing_product_section" value="1" <?=($general_setting_data['missing_product_section']=='1'?'checked="checked"':'')?>>
																				Yes
																				<span></span>
																			</label>
																			<label class="m-radio">
																				<input type="radio" id="missing_product_section" name="missing_product_section" value="0" <?=(intval($general_setting_data['missing_product_section'])=='0'?'checked="checked"':'')?>>
																				No
																				<span></span>
																			</label>
																		</div>
																	</div>
																	<div class="col-6">
																		<label for="top_seller_limit">
																			Top Seller Limit
																			<a href="javascript:void(0);" data-container="body" data-toggle="m-popover" data-placement="top" data-content="On landing page display number of top sold models"><i class="fa fa-question"></i></a>
																		</label>
																		<input type="text" class="form-control m-input" id="top_seller_limit" value="<?=$general_setting_data['top_seller_limit']?>" name="top_seller_limit">
																	</div>
																</div>
																<div class="form-group m-form__group row">
																	<div class="col-6">
																		<label for="order_prefix">
																			Order Prefix
																		</label>
																		<input type="number" class="form-control m-input" id="order_prefix" value="<?=$general_setting_data['order_prefix']?>" name="order_prefix" maxlength="5">
																		<small>Order Number pattern is <?=$order_number_datetime_format_lbl?>-Order Prefix+1, so frequence change may duplicate order numbers.</small>
																	</div>
																	<div class="col-6">
																		<label for="page_list_limit">Page List Limit
																		<a href="javascript:void(0);" data-container="body" data-toggle="m-popover" data-placement="top" data-content="Number of items per page"><i class="fa fa-question"></i></a>
																		</label>
																		<select class="form-control m-select2 m-select2-general" name="page_list_limit" id="page_list_limit">
																			<option value=""> -Select- </option>
																			<option value="5" <?php if($page_list_limit=='5'){echo 'selected="selected"';}?>>5</option>
																			<option value="10" <?php if($page_list_limit=='10'){echo 'selected="selected"';}?>>10</option>
																			<option value="15" <?php if($page_list_limit=='15'){echo 'selected="selected"';}?>>15</option>
																			<option value="20" <?php if($page_list_limit=='20'){echo 'selected="selected"';}?>>20</option>
																			<option value="25" <?php if($page_list_limit=='25'){echo 'selected="selected"';}?>>25</option>
																			<option value="50" <?php if($page_list_limit=='50'){echo 'selected="selected"';}?>>50</option>
																			<option value="100" <?php if($page_list_limit=='100'){echo 'selected="selected"';}?>>100</option>
																			<option value="200" <?php if($page_list_limit=='200'){echo 'selected="selected"';}?>>200</option>
																			<option value="500" <?php if($page_list_limit=='500'){echo 'selected="selected"';}?>>500</option>
																		</select>
																	</div>
																</div>
																<div class="form-group m-form__group row">
																	<div class="col-6">
																		<label for="order_prefix">
																			Order Expiring Days
																			<a href="javascript:void(0);" data-container="body" data-toggle="m-popover" data-placement="top" data-content="Email/Sms alert to customer if still order status is awaiting"><i class="fa fa-question"></i></a>
																		</label>
																		<input type="number" class="form-control m-input" id="order_expiring_days" value="<?=$other_settings['order_expiring_days']?>" name="other_settings[order_expiring_days]" min="0" max="90" maxlength="5">
																	</div>
																	
																	<div class="col-6">
																		<label for="order_prefix">
																			Order Expired Days
																			<a href="javascript:void(0);" data-container="body" data-toggle="m-popover" data-placement="top" data-content="If order status is still awaiting after given days since order date"><i class="fa fa-question"></i></a>
																		</label>
																		<input type="number" class="form-control m-input" id="order_expired_days" value="<?=$other_settings['order_expired_days']?>" name="other_settings[order_expired_days]" min="0" max="90" maxlength="5">
																	</div>
																</div>
																<div class="m-form__group form-group row">
																	<div class="col-4">
																		<label>
																			Promocode Section
																		</label>
																		<div class="m-radio-inline">
																			<label class="m-radio">
																				<input type="radio" id="promocode_section_on" name="promocode_section" value="1" <?php if($general_setting_data['promocode_section']=='1'){echo 'checked="checked"';}?>>
																				Yes
																				<span></span>
																			</label>
																			<label class="m-radio">
																				<input type="radio" id="promocode_section_off" name="promocode_section" value="0" <?php if($general_setting_data['promocode_section']=='0'){echo 'checked="checked"';}?>>
																				No
																				<span></span>
																			</label>
																		</div>
																	</div>
																	<div class="col-8">
																		<div class="m-checkbox-inline">
																			<label class="m-checkbox">
																				<input type="checkbox" name="other_settings[show_instant_price_on_model_criteria_selections]" value="1" <?=(isset($other_settings['show_instant_price_on_model_criteria_selections']) && $other_settings['show_instant_price_on_model_criteria_selections']=='1'?'checked="checked"':'')?>>
																				<span></span> Show Instant Price On Model Criteria Selections <a href="javascript:void(0);" data-container="body" data-toggle="m-popover" data-placement="top" data-content="Display offer price instantly on same page OR after hitting next button"><i class="fa fa-question"></i></a>
																			</label>
																		</div>
																	</div>
																</div>
																
																<div class="m-separator m-separator--dash m-separator--sm"></div>
																<div class="form-group m-form__group row">
																	<div class="col-6">
																	<label for="currency">Currency</label>
																	<select class="form-control m-select2 m-select2-general" name="currency" id="currency">
																   <option value=""> -Select- </option>
																   <option value="AFN,؋" <?php if($currency[0]=='AFN'){echo 'selected="selected"';}?>>AFN(؋)</option>
				 												   <option value="ALL,Lek" <?php if($currency[0]=='ALL'){echo 'selected="selected"';}?>>ALL(Lek)</option>
				 												   <option value="USD,$" <?php if($currency[0]=='USD'){echo 'selected="selected"';}?>>USD($)</option>
				 												   <option value="EUR,€" <?php if($currency[0]=='EUR'){echo 'selected="selected"';}?>>EUR(€)</option>
				 												   <option value="AOA,Kz" <?php if($currency[0]=='AOA'){echo 'selected="selected"';}?>>AOA(Kz)</option>
				 												   <option value="XCD,$" <?php if($currency[0]=='XCD'){echo 'selected="selected"';}?>>XCD($)</option>
				 												   <option value="ARS,$" <?php if($currency[0]=='ARS'){echo 'selected="selected"';}?>>ARS($)</option>
				 												   <option value="AWG,ƒ" <?php if($currency[0]=='AWG'){echo 'selected="selected"';}?>>AWG(ƒ)</option>
				 												   <option value="AUD,$" <?php if($currency[0]=='AUD'){echo 'selected="selected"';}?>>AUD($)</option>
				 												   <option value="AZN,ман" <?php if($currency[0]=='AZN'){echo 'selected="selected"';}?>>AZN(ман)</option>
				 												   <option value="BSD,$" <?php if($currency[0]=='BSD'){echo 'selected="selected"';}?>>BSD($)</option>
				 												   <option value="BBD,$" <?php if($currency[0]=='BBD'){echo 'selected="selected"';}?>>BBD($)</option>
				 												   <option value="BYR,p." <?php if($currency[0]=='BYR'){echo 'selected="selected"';}?>>BYR(p.)</option>
				 												   <option value="BZD,BZ$" <?php if($currency[0]=='BZD'){echo 'selected="selected"';}?>>BZD(BZ$)</option>
				 												   <option value="BMD,$" <?php if($currency[0]=='BMD'){echo 'selected="selected"';}?>>BMD($)</option>
				 												   <option value="BOB,$b" <?php if($currency[0]=='BOB'){echo 'selected="selected"';}?>>BOB($b)</option>
				 												   <option value="BAM,KM" <?php if($currency[0]=='BAM'){echo 'selected="selected"';}?>>BAM(KM)</option>
				 												   <option value="BWP,P" <?php if($currency[0]=='BWP'){echo 'selected="selected"';}?>>BWP(P)</option>
				 												   <option value="NOK,kr" <?php if($currency[0]=='NOK'){echo 'selected="selected"';}?>>NOK(kr)</option>
				 												   <option value="BRL,R$" <?php if($currency[0]=='BRL'){echo 'selected="selected"';}?>>BRL(R$)</option>
				 												   <option value="BND,$" <?php if($currency[0]=='BND'){echo 'selected="selected"';}?>>BND($)</option>
				 												   <option value="BGN,лв" <?php if($currency[0]=='BGN'){echo 'selected="selected"';}?>>BGN(лв)</option>
				 												   <option value="KHR,៛" <?php if($currency[0]=='KHR'){echo 'selected="selected"';}?>>KHR(៛)</option>
				 												   <option value="XAF,FCF" <?php if($currency[0]=='XAF'){echo 'selected="selected"';}?>>XAF(FCF)</option>
				 												   <option value="CAD,$" <?php if($currency[0]=='CAD'){echo 'selected="selected"';}?>>CAD($)</option>
				 												   <option value="KYD,$" <?php if($currency[0]=='KYD'){echo 'selected="selected"';}?>>KYD($)</option>
				 												   <option value="CNY,¥" <?php if($currency[0]=='CNY'){echo 'selected="selected"';}?>>CNY(¥)</option>
				 												   <option value="COP,$" <?php if($currency[0]=='COP'){echo 'selected="selected"';}?>>COP($)</option>
				 												   <option value="NZD,$" <?php if($currency[0]=='NZD'){echo 'selected="selected"';}?>>NZD($)</option>
				 												   <option value="CRC,₡" <?php if($currency[0]=='CRC'){echo 'selected="selected"';}?>>CRC(₡)</option>
				 												   <option value="HRK,kn" <?php if($currency[0]=='HRK'){echo 'selected="selected"';}?>>HRK(kn)</option>
				 												   <option value="CUP,₱" <?php if($currency[0]=='CUP'){echo 'selected="selected"';}?>>CUP(₱)</option>
				 												   <option value="CZK,KĿ" <?php if($currency[0]=='CZK'){echo 'selected="selected"';}?>>CZK(KĿ)</option>
				 												   <option value="DKK,kr" <?php if($currency[0]=='DKK'){echo 'selected="selected"';}?>>DKK(kr)</option>
				 												   <option value="DOP,RD$" <?php if($currency[0]=='DOP'){echo 'selected="selected"';}?>>DOP(RD$)</option>
				 												   <option value="EGP,£" <?php if($currency[0]=='EGP'){echo 'selected="selected"';}?>>EGP(£)</option>
				 												   <option value="SVC,$" <?php if($currency[0]=='SVC'){echo 'selected="selected"';}?>>SVC($)</option>
				 												   <option value="ERN,Nfk" <?php if($currency[0]=='ERN'){echo 'selected="selected"';}?>>ERN(Nfk)</option>
				 												   <option value="EEK,kr" <?php if($currency[0]=='EEK'){echo 'selected="selected"';}?>>EEK(kr)</option>
				 												   <option value="FKP,£" <?php if($currency[0]=='FKP'){echo 'selected="selected"';}?>>FKP(£)</option>
				 												   <option value="FJD,$" <?php if($currency[0]=='FJD'){echo 'selected="selected"';}?>>FJD($)</option>
				 												   <option value="GMD,D" <?php if($currency[0]=='GMD'){echo 'selected="selected"';}?>>GMD(D)</option>
				 												   <option value="GHC,¢" <?php if($currency[0]=='GHC'){echo 'selected="selected"';}?>>GHC(¢)</option>
				 												   <option value="GIP,£" <?php if($currency[0]=='GIP'){echo 'selected="selected"';}?>>GIP(£)</option>
				 												   <option value="GTQ,Q" <?php if($currency[0]=='GTQ'){echo 'selected="selected"';}?>>GTQ(Q)</option>
				 												   <option value="GYD,$" <?php if($currency[0]=='GYD'){echo 'selected="selected"';}?>>GYD($)</option>
				 												   <option value="HTG,G" <?php if($currency[0]=='HTG'){echo 'selected="selected"';}?>>HTG(G)</option>
				 												   <option value="HNL,L" <?php if($currency[0]=='HNL'){echo 'selected="selected"';}?>>HNL(L)</option>
				 												   <option value="HKD,$" <?php if($currency[0]=='HKD'){echo 'selected="selected"';}?>>HKD($)</option>
				 												   <option value="HUF,Ft" <?php if($currency[0]=='HUF'){echo 'selected="selected"';}?>>HUF(Ft)</option>
				 												   <option value="ISK,kr" <?php if($currency[0]=='ISK'){echo 'selected="selected"';}?>>ISK(kr)</option>
				 												   <option value="INR,₹" <?php if($currency[0]=='INR'){echo 'selected="selected"';}?>>INR(₹)</option>
				 												   <option value="IDR,Rp" <?php if($currency[0]=='IDR'){echo 'selected="selected"';}?>>IDR(Rp)</option>
				 												   <option value="IRR,﷼" <?php if($currency[0]=='IRR'){echo 'selected="selected"';}?>>IRR(﷼)</option>
				 												   <option value="ILS,₪" <?php if($currency[0]=='ILS'){echo 'selected="selected"';}?>>ILS(₪)</option>
				 												   <option value="JMD,$" <?php if($currency[0]=='JMD'){echo 'selected="selected"';}?>>JMD($)</option>
				 												   <option value="JPY,¥" <?php if($currency[0]=='JPY'){echo 'selected="selected"';}?>>JPY(¥)</option>
				 												   <option value="KZT,лв" <?php if($currency[0]=='KZT'){echo 'selected="selected"';}?>>KZT(лв)</option>
				 												   <option value="KGS,лв" <?php if($currency[0]=='KGS'){echo 'selected="selected"';}?>>KGS(лв)</option>
				 												   <option value="LAK,₭" <?php if($currency[0]=='LAK'){echo 'selected="selected"';}?>>LAK(₭)</option>
				 												   <option value="LVL,Ls" <?php if($currency[0]=='LVL'){echo 'selected="selected"';}?>>LVL(Ls)</option>
				 												   <option value="LBP,£" <?php if($currency[0]=='LBP'){echo 'selected="selected"';}?>>LBP(£)</option>
				 												   <option value="LSL,L" <?php if($currency[0]=='LSL'){echo 'selected="selected"';}?>>LSL(L)</option>
				 												   <option value="LRD,$" <?php if($currency[0]=='LRD'){echo 'selected="selected"';}?>>LRD($)</option>
				 												   <option value="CHF,CHF" <?php if($currency[0]=='CHF'){echo 'selected="selected"';}?>>CHF(CHF)</option>
				 												   <option value="LTL,Lt" <?php if($currency[0]=='LTL'){echo 'selected="selected"';}?>>LTL(Lt)</option>
				 												   <option value="MOP,MOP" <?php if($currency[0]=='MOP'){echo 'selected="selected"';}?>>MOP(MOP)</option>
				 												   <option value="MKD,ден" <?php if($currency[0]=='MKD'){echo 'selected="selected"';}?>>MKD(ден)</option>
				 												   <option value="MWK,MK" <?php if($currency[0]=='MWK'){echo 'selected="selected"';}?>>MWK(MK)</option>
				 												   <option value="MYR,RM" <?php if($currency[0]=='MYR'){echo 'selected="selected"';}?>>MYR(RM)</option>
				 												   <option value="MVR,Rf" <?php if($currency[0]=='MVR'){echo 'selected="selected"';}?>>MVR(Rf)</option>
				 												   <option value="MRO,UM" <?php if($currency[0]=='MRO'){echo 'selected="selected"';}?>>MRO(UM)</option>
				 												   <option value="MUR,₨" <?php if($currency[0]=='MUR'){echo 'selected="selected"';}?>>MUR(₨)</option>
				 												   <option value="MXN,$" <?php if($currency[0]=='MXN'){echo 'selected="selected"';}?>>MXN($)</option>
				 												   <option value="MNT,₮" <?php if($currency[0]=='MNT'){echo 'selected="selected"';}?>>MNT(₮)</option>
				 												   <option value="MZN,MT" <?php if($currency[0]=='MZN'){echo 'selected="selected"';}?>>MZN(MT)</option>
				 												   <option value="MMK,K" <?php if($currency[0]=='MMK'){echo 'selected="selected"';}?>>MMK(K)</option>
				 												   <option value="NAD,$" <?php if($currency[0]=='NAD'){echo 'selected="selected"';}?>>NAD($)</option>
				 												   <option value="NPR,₨" <?php if($currency[0]=='NPR'){echo 'selected="selected"';}?>>NPR(₨)</option>
				 												   <option value="ANG,ƒ" <?php if($currency[0]=='ANG'){echo 'selected="selected"';}?>>ANG(ƒ)</option>
				 												   <option value="NIO,C$" <?php if($currency[0]=='NIO'){echo 'selected="selected"';}?>>NIO(C$)</option>
				 												   <option value="NGN,₦" <?php if($currency[0]=='NGN'){echo 'selected="selected"';}?>>NGN(₦)</option>
				 												   <option value="KPW,₩" <?php if($currency[0]=='KPW'){echo 'selected="selected"';}?>>KPW(₩)</option>
				 												   <option value="OMR,﷼" <?php if($currency[0]=='OMR'){echo 'selected="selected"';}?>>OMR(﷼)</option>
				 												   <option value="PKR,₨" <?php if($currency[0]=='PKR'){echo 'selected="selected"';}?>>PKR(₨)</option>
				 												   <option value="PAB,B/." <?php if($currency[0]=='PAB'){echo 'selected="selected"';}?>>PAB(B/.)</option>
				 												   <option value="PYG,Gs" <?php if($currency[0]=='PYG'){echo 'selected="selected"';}?>>PYG(Gs)</option>
				 												   <option value="PEN,S/." <?php if($currency[0]=='PEN'){echo 'selected="selected"';}?>>PEN(S/.)</option>
				 												   <option value="PHP,Php" <?php if($currency[0]=='PHP'){echo 'selected="selected"';}?>>PHP(Php)</option>
				 												   <option value="PLN,zł" <?php if($currency[0]=='PLN'){echo 'selected="selected"';}?>>PLN(zł)</option>
				 												   <option value="QAR,﷼" <?php if($currency[0]=='QAR'){echo 'selected="selected"';}?>>QAR(﷼)</option>
				 												   <option value="RON,lei" <?php if($currency[0]=='RON'){echo 'selected="selected"';}?>>RON(lei)</option>
				 												   <option value="RUB,руб" <?php if($currency[0]=='RUB'){echo 'selected="selected"';}?>>RUB(руб)</option>
				 												   <option value="SHP,£" <?php if($currency[0]=='SHP'){echo 'selected="selected"';}?>>SHP(£)</option>
				 												   <option value="WST,WS$" <?php if($currency[0]=='WST'){echo 'selected="selected"';}?>>WST(WS$)</option>
				 												   <option value="STD,Db" <?php if($currency[0]=='STD'){echo 'selected="selected"';}?>>STD(Db)</option>
				 												   <option value="SAR,﷼" <?php if($currency[0]=='SAR'){echo 'selected="selected"';}?>>SAR(﷼)</option>
				 												   <option value="RSD,Дин" <?php if($currency[0]=='RSD'){echo 'selected="selected"';}?>>RSD(Дин)</option>
				 												   <option value="SCR,₨" <?php if($currency[0]=='SCR'){echo 'selected="selected"';}?>>SCR(₨)</option>
				 												   <option value="SLL,Le" <?php if($currency[0]=='SLL'){echo 'selected="selected"';}?>>SLL(Le)</option>
				 												   <option value="SGD,$" <?php if($currency[0]=='SGD'){echo 'selected="selected"';}?>>SGD($)</option>
				 												   <option value="SKK,Sk" <?php if($currency[0]=='SKK'){echo 'selected="selected"';}?>>SKK(Sk)</option>
				 												   <option value="SBD,$" <?php if($currency[0]=='SBD'){echo 'selected="selected"';}?>>SBD($)</option>
				 												   <option value="SOS,S" <?php if($currency[0]=='SOS'){echo 'selected="selected"';}?>>SOS(S)</option>
				 												   <option value="ZAR,R" <?php if($currency[0]=='ZAR'){echo 'selected="selected"';}?>>ZAR(R)</option>
				 												   <option value="GBP,£" <?php if($currency[0]=='GBP'){echo 'selected="selected"';}?>>GBP(£)</option>
				 												   <option value="KRW,₩" <?php if($currency[0]=='KRW'){echo 'selected="selected"';}?>>KRW(₩)</option>
				 												   <option value="LKR,₨" <?php if($currency[0]=='LKR'){echo 'selected="selected"';}?>>LKR(₨)</option>
				 												   <option value="SRD,$" <?php if($currency[0]=='SRD'){echo 'selected="selected"';}?>>SRD($)</option>
				 												   <option value="SEK,kr" <?php if($currency[0]=='SEK'){echo 'selected="selected"';}?>>SEK(kr)</option>
				 												   <option value="SYP,£" <?php if($currency[0]=='SYP'){echo 'selected="selected"';}?>>SYP(£)</option>
				 												   <option value="TWD,NT$" <?php if($currency[0]=='TWD'){echo 'selected="selected"';}?>>TWD(NT$)</option>
				 												   <option value="THB,฿" <?php if($currency[0]=='THB'){echo 'selected="selected"';}?>>THB(฿)</option>
				 												   <option value="TOP,T$" <?php if($currency[0]=='TOP'){echo 'selected="selected"';}?>>TOP(T$)</option>
				 												   <option value="TTD,TT$" <?php if($currency[0]=='TTD'){echo 'selected="selected"';}?>>TTD(TT$)</option>
				 												   <option value="TRY,YTL" <?php if($currency[0]=='TRY'){echo 'selected="selected"';}?>>TRY(YTL)</option>
				 												   <option value="TMM,m" <?php if($currency[0]=='TMM'){echo 'selected="selected"';}?>>TMM(m)</option>
				 												   <option value="UAH,₴" <?php if($currency[0]=='UAH'){echo 'selected="selected"';}?>>UAH(₴)</option>
				 												   <option value="UYU,$U" <?php if($currency[0]=='UYU'){echo 'selected="selected"';}?>>UYU($U)</option>
				 												   <option value="UZS,лв" <?php if($currency[0]=='UZS'){echo 'selected="selected"';}?>>UZS(лв)</option>
				 												   <option value="VUV,Vt" <?php if($currency[0]=='VUV'){echo 'selected="selected"';}?>>VUV(Vt)</option>
				 												   <option value="VEF,Bs" <?php if($currency[0]=='VEF'){echo 'selected="selected"';}?>>VEF(Bs)</option>
				 												   <option value="VND,₫" <?php if($currency[0]=='VND'){echo 'selected="selected"';}?>>VND(₫)</option>
				 												   <option value="YER,﷼" <?php if($currency[0]=='YER'){echo 'selected="selected"';}?>>YER(﷼)</option>
				 												   <option value="ZMK,ZK" <?php if($currency[0]=='ZMK'){echo 'selected="selected"';}?>>ZMK(ZK)</option>
				 												   <option value="ZWD,Z$" <?php if($currency[0]=='ZWD'){echo 'selected="selected"';}?>>ZWD(Z$)</option>
																	</select>
																	</div>
																	<div class="col-6">
																		<label for="published">
																			Currency Symbol Position:
																			<a href="javascript:void(0);" data-container="body" data-toggle="m-popover" data-placement="top" data-content="Display currency symbol before of after amount"><i class="fa fa-question"></i></a>
																		</label>
																		<div class="m-radio-inline">
																			<label class="m-radio">
																				<input type="radio" id="disp_currency" name="disp_currency" value="prefix" <?=($general_setting_data['disp_currency']=="prefix"||$general_setting_data['disp_currency']==""?'checked="checked"':'')?>>
																				Before Amount
																				<span></span>
																			</label>
																			<label class="m-radio">
																				<input type="radio" id="disp_currency" name="disp_currency" value="postfix" <?=($general_setting_data['disp_currency']=="postfix"?'checked="checked"':'')?>>
																				After Amount
																				<span></span>
																			</label>
																		</div>
																	</div>
																</div>
																
																<div class="form-group m-form__group">
																	<label>&nbsp;</label>
																	<div class="m-checkbox-inline">
																		<label class="m-checkbox">
																			<input id="is_space_between_currency_symbol" type="checkbox" value="1" name="is_space_between_currency_symbol" <?php if($general_setting_data['is_space_between_currency_symbol']=="1"){echo 'checked="checked"';}?>> Keep space between currency symbol and amount <span></span>
																		</label>
																	</div>
																</div>
																
																<div class="form-group m-form__group row">
																	<div class="col-4">
																		<label>Thousand Separator</label>
																		<input type="text" class="form-control m-input" id="thousand_separator" value="<?=$general_setting_data['thousand_separator']?>" name="thousand_separator">
																	</div>
																	<div class="col-4">
																		<label>Decimal Separator</label>
																		<input type="text" class="form-control m-input" id="decimal_separator" value="<?=$general_setting_data['decimal_separator']?>" name="decimal_separator">
																	</div>
																	<div class="col-4">
																		<label>Number of Decimals</label>
																		<input type="number" class="form-control m-input" id="decimal_number" value="<?=$general_setting_data['decimal_number']?>" name="decimal_number">
																	</div>
																</div>
																
																<div class="m-separator m-separator--dash m-separator--sm"></div>
																<div class="m-form__group form-group row">
																	<div class="col-4">
																		<label>Newsletter Section</label>
																		<div class="m-radio-inline">
																			<label class="m-radio">
																				<input type="radio" name="other_settings[newslettter_section]" value="1" <?=($other_settings['newslettter_section']=='1'||$other_settings['newslettter_section']==''?'checked="checked"':'')?>>
																				Show <span></span>
																			</label>
																			<label class="m-radio">
																				<input type="radio" name="other_settings[newslettter_section]" value="0" <?=($other_settings['newslettter_section']=='0'?'checked="checked"':'')?>>
																				Hide <span></span>
																			</label>
																		</div>
																	</div>
																	<div class="col-4">
																		<label>Offline / Maintenance Mode</label>
																		<div class="m-radio-inline">
																			<label class="m-radio">
																				<input type="radio" name="other_settings[maintainance_mode]" value="1" <?=($other_settings['maintainance_mode']=='1'?'checked="checked"':'')?>>
																				On <span></span>
																			</label>
																			<label class="m-radio">
																				<input type="radio" name="other_settings[maintainance_mode]" value="0" <?=($other_settings['maintainance_mode']=='0'||$other_settings['maintainance_mode']==''?'checked="checked"':'')?>>
																				Off <span></span>
																			</label>
																		</div>
																	</div>
																	<div class="col-4">
																		<label>Service Hours</label>
																		<div class="m-radio-inline">
																			<label class="m-radio">
																				<input type="radio" name="other_settings[service_hours_status]" value="1" <?=($other_settings['service_hours_status']=='1'||$other_settings['service_hours_status']==''?'checked="checked"':'')?>>
																				Show <span></span>
																			</label>
																			<label class="m-radio">
																				<input type="radio" name="other_settings[service_hours_status]" value="0" <?=($other_settings['service_hours_status']=='0'?'checked="checked"':'')?>>
																				Hide <span></span>
																			</label>
																		</div>
																	</div>
																</div>
																
																<div class="m-separator m-separator--dash m-separator--sm"></div>
																<div class="m-form__group form-group">
																	<div class="m-checkbox-inline">
																		<label class="m-checkbox">
																			<input id="is_ip_restriction" type="checkbox" value="1" name="is_ip_restriction" <?php if($general_setting_data['is_ip_restriction']=="1"){echo 'checked="checked"';}?>> Restrict Access by IP<span></span>	
																		</label>
																		
																		<label class="m-checkbox">
																			<input id="allow_sms_verify_of_admin_staff_login" type="checkbox" value="1" name="allow_sms_verify_of_admin_staff_login" <?php if($general_setting_data['allow_sms_verify_of_admin_staff_login']=="1"){echo 'checked="checked"';}?>> Allow SMS Verify Of Admin/Staff Login<span></span>
																		</label>
																	</div>
																</div>
																<div class="m-form__group form-group allowed_ip" <?php if($general_setting_data['is_ip_restriction']=="1"){echo 'style="display:block;"';} else {echo 'style="display:none;"';}?>>
																	<label>Allowed IPs</label>
																	<textarea class="form-control m-input" name="allowed_ip" rows="3"><?=$general_setting_data['allowed_ip']?></textarea>
																	<small>IPs with comma seperated</small><br />
																	<small>Verify Your IP already added otherwise you can not access CRM: <?=USER_IP?></small>
																</div>

																<div class="m-separator m-separator--dash m-separator--sm"></div>
																<div class="m-form__group form-group row">
																	<div class="col-6">
																		<label for="published">
																			Customer Verification
																		</label>
																		<div class="m-radio-inline">
																			<label class="m-radio">
																				<input type="radio" id="verification" name="verification" value="none" <?=($general_setting_data['verification']=="none"||$general_setting_data['verification']==""?'checked="checked"':'')?>>
																				None
																				<span></span>
																			</label>
																			<label class="m-radio">
																				<input type="radio" id="verification" name="verification" value="email" <?=($general_setting_data['verification']=="email"?'checked="checked"':'')?>>
																				Email
																				<span></span>
																			</label>
																			<label class="m-radio">
																				<input type="radio" id="verification" name="verification" value="sms" <?=($general_setting_data['verification']=="sms"?'checked="checked"':'')?>>
																				SMS
																				<span></span>
																			</label>
																		</div>
																	</div>
																	<div class="col-6">
																		<div class="m-checkbox-inline">
																			<label class="m-checkbox">
																				<input id="other_settings[allow_guest_user_order]" type="checkbox" value="1" name="other_settings[allow_guest_user_order]" <?=($other_settings['allow_guest_user_order']=='1'?'checked="checked"':'')?>>
																					Allow Guest User to place Order <span></span>
																			</label>
																		</div>
																	</div>
																</div>
																
																<div class="m-separator m-separator--dash m-separator--sm"></div>
																<div class="m-form__group form-group row">
																	<div class="col-6">
																		<label>IMEI API KEY</label>
																		<input type="text" class="form-control m-input" name="other_settings[imei_api_key]" value="<?=$other_settings['imei_api_key']?>">
																		<small><a href="https://sickw.com/" target="_blank">Get key from sickw.com</a></small>
																	</div>
																	<div class="col-6">
																		<label>MAP KEY</label>
																		<input type="text" class="form-control m-input" name="other_settings[map_key]" value="<?=$other_settings['map_key']?>">
																	</div>
																</div>
																
																<div class="m-separator m-separator--dash m-separator--sm"></div>
																<div class="m-form__group form-group">
																	<div class="m-checkbox-inline">
																		<label class="m-checkbox">
																			<input id="allow_offer_popup" type="checkbox" value="1" name="allow_offer_popup" <?php if($general_setting_data['allow_offer_popup']=='1'){echo 'checked="checked"';}?>>
																				Allow Offer Popup <span></span>
																		</label>
																	</div>
																</div>
																<div class="m-form__group form-group">
																	<label>Offer Popup Title</label>
																	<input type="text" class="form-control m-input" id="offer_popup_title" value="<?=$general_setting_data['offer_popup_title']?>" name="offer_popup_title">
																</div>
																<div class="m-form__group form-group">
																	<label>Offer Popup Content</label>
																	<textarea class="form-control m-input summernote2" name="offer_popup_content" rows="5"><?=$general_setting_data['offer_popup_content']?></textarea>
																</div>
																
																<div class="m-separator m-separator--dash m-separator--sm"></div>
																<div class="form-group m-form__group">
																	<label for="custom_js_code">
																		JS code &#60;head&#62; just after opening of tag
																	</label>
																	<textarea class="form-control m-input" name="custom_js_code" rows="5"><?=$general_setting_data['custom_js_code']?></textarea>
																</div>
																
																<div class="form-group m-form__group">
																	<label for="after_body_js_code">JS code &#60;body&#62; just after opening of tag</label>
																	<textarea class="form-control m-input m-input--square" name="after_body_js_code" rows="5"><?=$general_setting_data['after_body_js_code']?></textarea>
																</div>
																<div class="form-group m-form__group">
																	<label for="before_body_js_code">JS code &#60;&#47;body&#62; just before close of tag</label>
																	<textarea class="form-control m-input m-input--square" name="before_body_js_code" rows="5"><?=$general_setting_data['before_body_js_code']?></textarea>
																</div>
															</div>
														</div>
														<div class="m-portlet__foot m-portlet__foot--fit">
															<div class="m-form__actions m-form__actions">
																<button type="submit" name="general_setting" class="btn btn-primary">
																  Save
																</button>
															</div>
														</div>
														<!--end::Form-->
													</div>
													<!--end::Portlet-->
											  </div>
											  <div class="tab-pane" id="m_tabs_get_paid" role="tabpanel">
													<!--begin::Portlet-->
													<div class="m-portlet">
														<div class="m-portlet__head">
															<div class="m-portlet__head-caption">
																<div class="m-portlet__head-title">
																	<span class="m-portlet__head-icon m--hide">
																	  <i class="la la-gear"></i>
																	</span>
																	<h3 class="m-portlet__head-text">
																	  Get Paid Settings
																	</h3>
																</div>
															</div>
														</div>
														<!--begin::Form-->
														<div class="m-portlet__body">
															<div class="m-form__section m-form__section--first">
																<div class="m-form__group form-group">
																	<label for="published">
																		Payment Option
																	</label>
																	<div class="m-form__group form-group">
																		<div class="m-checkbox-inline">
																			<label class="m-checkbox">
																				<input id="payment_option_bank" type="checkbox" value="bank" name="payment_option[bank]" <?php if($payment_option['bank']=="bank"){echo 'checked="checked"';}?>>
																				Bank
																				<span></span>
																			</label>
																		</div>
																		<label>Instruction</label>
																		<input class="form-control m-input" name="payment_instruction[bank]" rows="5" value="<?=$payment_instruction['bank']?>">
																	</div>
																	<div class="m-form__group form-group">
																		<div class="m-checkbox-inline">
																			<label class="m-checkbox">
																				<input id="payment_option_paypal" type="checkbox" value="paypal" name="payment_option[paypal]" <?php if($payment_option['paypal']=="paypal"){echo 'checked="checked"';}?>>
																				Paypal
																				<span></span>
																			</label>
																		</div>
																		<label>Instruction</label>
																		<input class="form-control m-input" name="payment_instruction[paypal]" rows="5" value="<?=$payment_instruction['paypal']?>">
																	</div>
																	
																	<div class="m-form__group form-group">
																		<div class="m-checkbox-inline">
																			<label class="m-checkbox">
																				<input id="payment_option_cheque" type="checkbox" value="cheque" name="payment_option[cheque]" <?php if($payment_option['cheque']=="cheque"){echo 'checked="checked"';}?>>
																			Cheque/Check
																			<span></span>
																			</label>
																		</div>
																		<label>Instruction</label>
																		<input class="form-control m-input" name="payment_instruction[cheque]" rows="5" value="<?=$payment_instruction['cheque']?>">
																	</div>
																	<div class="m-form__group form-group">
																		<div class="m-checkbox-inline">
																			<label class="m-checkbox">
																				<input id="payment_option_venmo" type="checkbox" value="venmo" name="payment_option[venmo]" <?php if($payment_option['venmo']=="venmo"){echo 'checked="checked"';}?>>
																			Venmo
																			<span></span>
																			</label>
																		</div>
																		<label>Instruction</label>
																		<input class="form-control m-input" name="payment_instruction[venmo]" rows="5" value="<?=$payment_instruction['venmo']?>">
																	</div>
																	<div class="m-form__group form-group">
																		<div class="m-checkbox-inline">
																			<label class="m-checkbox">
																				<input id="payment_option_zelle" type="checkbox" value="zelle" name="payment_option[zelle]" <?php if($payment_option['zelle']=="zelle"){echo 'checked="checked"';}?>>
																			Zelle
																			<span></span>
																			</label>
																		</div>
																		<label>Instruction</label>
																		<input class="form-control m-input" name="payment_instruction[zelle]" rows="5" value="<?=$payment_instruction['zelle']?>">
																	</div>
																	<div class="m-form__group form-group">
																		<div class="m-checkbox-inline">
																			<label class="m-checkbox">
																				<input id="payment_option_amazon_gcard" type="checkbox" value="amazon_gcard" name="payment_option[amazon_gcard]" <?php if($payment_option['amazon_gcard']=="amazon_gcard"){echo 'checked="checked"';}?>>
																			Amazon GCard
																			<span></span>
																			</label>
																		</div>
																		<label>Instruction</label>
																		<input class="form-control m-input" name="payment_instruction[amazon_gcard]" rows="5" value="<?=$payment_instruction['amazon_gcard']?>">
																	</div>
																	<div class="m-form__group form-group">
																		<div class="m-checkbox-inline">
																			<label class="m-checkbox">
																				<input id="payment_option_cash" type="checkbox" value="cash" name="payment_option[cash]" <?php if($payment_option['cash']=="cash"){echo 'checked="checked"';}?>>
																			Cash
																			<span></span>
																			</label>
																		</div>
																		<label>Instruction</label>
																		<input class="form-control m-input" name="payment_instruction[cash]" rows="5" value="<?=$payment_instruction['cash']?>">
																	</div>
																	
																	<div class="m-form__group form-group">
																		<div class="m-checkbox-inline">
																			<label class="m-checkbox">
																				<input id="payment_option_cash_app" type="checkbox" value="cash_app" name="payment_option[cash_app]" <?php if($payment_option['cash_app']=="cash_app"){echo 'checked="checked"';}?>>
																			Cash App
																			<span></span>
																			</label>
																		</div>
																		<label>Instruction</label>
																		<input class="form-control m-input" name="payment_instruction[cash_app]" rows="5" value="<?=$payment_instruction['cash_app']?>">
																	</div>
																	<div class="m-form__group form-group">
																		<div class="m-checkbox-inline">
																			<label class="m-checkbox">
																				<input id="payment_option_apple_pay" type="checkbox" value="apple_pay" name="payment_option[apple_pay]" <?php if($payment_option['apple_pay']=="apple_pay"){echo 'checked="checked"';}?>>
																			Apple Pay
																			<span></span>
																			</label>
																		</div>
																		<label>Instruction</label>
																		<input class="form-control m-input" name="payment_instruction[apple_pay]" rows="5" value="<?=$payment_instruction['apple_pay']?>">
																	</div>
																	<div class="m-form__group form-group">
																		<div class="m-checkbox-inline">
																			<label class="m-checkbox">
																				<input id="payment_option_google_pay" type="checkbox" value="google_pay" name="payment_option[google_pay]" <?php if($payment_option['google_pay']=="google_pay"){echo 'checked="checked"';}?>>
																			Google Pay
																			<span></span>
																			</label>
																		</div>
																		<label>Instruction</label>
																		<input class="form-control m-input" name="payment_instruction[google_pay]" rows="5" value="<?=$payment_instruction['google_pay']?>">
																	</div>
																	<div class="m-form__group form-group">
																		<div class="m-checkbox-inline">
																			<label class="m-checkbox">
																				<input id="payment_option_coinbase" type="checkbox" value="coinbase" name="payment_option[coinbase]" <?php if($payment_option['coinbase']=="coinbase"){echo 'checked="checked"';}?>>
																			Coinbase
																			<span></span>
																			</label>
																		</div>
																		<label>Instruction</label>
																		<input class="form-control m-input" name="payment_instruction[coinbase]" rows="5" value="<?=$payment_instruction['coinbase']?>">
																	</div>
																	<div class="m-form__group form-group">
																		<div class="m-checkbox-inline">
																			<label class="m-checkbox">
																				<input id="payment_option_facebook_pay" type="checkbox" value="facebook_pay" name="payment_option[facebook_pay]" <?php if($payment_option['facebook_pay']=="facebook_pay"){echo 'checked="checked"';}?>>
																			Facebook Pay
																			<span></span>
																			</label>
																		</div>
																		<label>Instruction</label>
																		<input class="form-control m-input" name="payment_instruction[facebook_pay]" rows="5" value="<?=$payment_instruction['facebook_pay']?>">
																	</div>
																</div>
																
																<div class="m-form__group form-group">
																	<label>Cheque/Check Label</label>
																	<input id="cheque_check_label" class="form-control m-input" type="text" name="other_settings[cheque_check_label]" value="<?=_dt_parse($other_settings['cheque_check_label'])?>">
																</div>
																
																<div class="m-form__group form-group">
																	<label for="published">
																		Default Payment Option
																	</label>
																	<div class="m-radio-inline">
																		<label class="m-radio">
																			<input type="radio" id="default_payment_option_bank" name="default_payment_option" value="bank" <?=($general_setting_data['default_payment_option']=="bank"||$general_setting_data['default_payment_option']==""?'checked="checked"':'')?>>
																			Bank<span></span>
																		</label>
																		<label class="m-radio">
																			<input type="radio" id="default_payment_option_paypal" name="default_payment_option" value="paypal" <?=($general_setting_data['default_payment_option']=="paypal"?'checked="checked"':'')?>>
																			Paypal<span></span>
																		</label>
																		<label class="m-radio">
																			<input type="radio" id="default_payment_option_cheque" name="default_payment_option" value="cheque" <?=($general_setting_data['default_payment_option']=="cheque"?'checked="checked"':'')?>>
																			Cheque/Check<span></span>
																		</label>
																		<label class="m-radio">
																			<input type="radio" id="default_payment_option_venmo" name="default_payment_option" value="venmo" <?=($general_setting_data['default_payment_option']=="venmo"?'checked="checked"':'')?>>
																			Venmo<span></span>
																		</label>
																		<label class="m-radio">
																			<input type="radio" id="default_payment_option_zelle" name="default_payment_option" value="zelle" <?=($general_setting_data['default_payment_option']=="zelle"?'checked="checked"':'')?>>
																			Zelle<span></span>
																		</label>
																		<label class="m-radio">
																			<input type="radio" id="default_payment_option_amazon_gcard" name="default_payment_option" value="amazon_gcard" <?=($general_setting_data['default_payment_option']=="amazon_gcard"?'checked="checked"':'')?>>
																			Amazon GCard<span></span>
																		</label>
																		<label class="m-radio">
																			<input type="radio" id="default_payment_option_cash" name="default_payment_option" value="cash" <?=($general_setting_data['default_payment_option']=="cash"?'checked="checked"':'')?>>
																			Cash<span></span>
																		</label>
																		
																		<label class="m-radio">
																			<input type="radio" id="default_payment_option_cash" name="default_payment_option" value="cash_app" <?=($general_setting_data['default_payment_option']=="cash_app"?'checked="checked"':'')?>>
																			Cash app<span></span>
																		</label>
																		<label class="m-radio">
																			<input type="radio" id="default_payment_option_cash" name="default_payment_option" value="apple_pay" <?=($general_setting_data['default_payment_option']=="apple_pay"?'checked="checked"':'')?>>
																			Apple Pay<span></span>
																		</label>
																		<label class="m-radio">
																			<input type="radio" id="default_payment_option_cash" name="default_payment_option" value="google_pay" <?=($general_setting_data['default_payment_option']=="google_pay"?'checked="checked"':'')?>>
																			Google Pay<span></span>
																		</label>
																		<label class="m-radio">
																			<input type="radio" id="default_payment_option_cash" name="default_payment_option" value="coinbase" <?=($general_setting_data['default_payment_option']=="coinbase"?'checked="checked"':'')?>>
																			Coinbase<span></span>
																		</label>
																		<label class="m-radio">
																			<input type="radio" id="default_payment_option_cash" name="default_payment_option" value="facebook_pay" <?=($general_setting_data['default_payment_option']=="facebook_pay"?'checked="checked"':'')?>>
																			Facebook Pay<span></span>
																		</label>
																	</div>
																</div>
																
																

															</div>
														</div>
														<div class="m-portlet__foot m-portlet__foot--fit">
															<div class="m-form__actions m-form__actions">
																<button type="submit" name="general_setting" class="btn btn-primary">
																  Save
																</button>
															</div>
														</div>
														<!--end::Form-->
													</div>
													<!--end::Portlet-->
												  </div>
											  <div class="tab-pane" id="m_tabs_6_2" role="tabpanel">
													<!--begin::Portlet-->
													<div class="m-portlet">
														<div class="m-portlet__head">
															<div class="m-portlet__head-caption">
																<div class="m-portlet__head-title">
																	<span class="m-portlet__head-icon m--hide">
																		<i class="la la-gear"></i>
																	</span>
																	<h3 class="m-portlet__head-text">
																		Company Details
																	</h3>
																</div>
															</div>
														</div>
														<!--begin::Form-->
														<div class="m-portlet__body">
															<div class="m-form__section m-form__section--first">
																<div class="form-group m-form__group">
																	<label for="company_name">
																		Company Name
																	</label>
																	<input type="text" class="form-control m-input" id="company_name" value="<?=$general_setting_data['company_name']?>" name="company_name">
																</div>
																<div class="form-group m-form__group">
																	<label for="company_address">
																		Address
																	</label>
																	<input type="text" class="form-control m-input" id="company_address" value="<?=$general_setting_data['company_address']?>" name="company_address">
																</div>
																<div class="form-group m-form__group row">
																	<div class="col-3">
																		<label for="company_city">
																			City
																		</label>
																		<input type="text" class="form-control m-input" id="company_city" value="<?=$general_setting_data['company_city']?>" name="company_city">
																	</div>
																	<div class="col-3">
																		<label for="company_state">
																			State
																		</label>
																		<input type="text" class="form-control m-input" id="company_state" value="<?=$general_setting_data['company_state']?>" name="company_state">
																	</div>
																	<div class="col-3">
																		<label for="company_country">
																			Country
																		</label>
																		<select class="form-control" name="company_country" id="company_country">
																			<option value=""> - Select - </option>
																			<?php
																			foreach($comp_countries_list as $comp_countries_data) { ?>
																				<option value="<?=$comp_countries_data['1']?>" <?php if($comp_countries_data['1']==$general_setting_data['company_country']){echo 'selected="selected"';}?>><?=$comp_countries_data['0']?></option>
																			<?php
																			} ?>
																		</select>
																		<?php /*?><input type="text" class="form-control m-input" id="company_country" value="<?=$general_setting_data['company_country']?>" name="company_country"><?php */?>
																	</div>
																	<div class="col-3">
																		<label for="company_zipcode">
																			Zipcode
																		</label>
																		<input type="text" class="form-control m-input" id="company_zipcode" value="<?=$general_setting_data['company_zipcode']?>" name="company_zipcode">
																	</div>
																</div>
																<div class="form-group m-form__group row">
																	<div class="col-6">
																		<label for="company_phone">
																			Phone
																		</label>
																		<input type="text" class="form-control m-input" id="company_phone" value="<?=$general_setting_data['company_phone']?>" name="company_phone">
																	</div>
																	<div class="col-6">
																		<label for="company_email">
																			Email
																		</label>
																		<input type="text" class="form-control m-input" id="company_email" value="<?=$general_setting_data['company_email']?>" name="company_email">
																	</div>
																</div>
															</div>
														</div>
														<div class="m-portlet__foot m-portlet__foot--fit">
															<div class="m-form__actions m-form__actions">
																<button type="submit" name="general_setting" class="btn btn-primary">
																	Save
																</button>
															</div>
														</div>
														<!--end::Form-->
													</div>
													<!--end::Portlet-->
												</div>
			                  					<div class="tab-pane" id="m_tabs_6_3" role="tabpanel">
													<!--begin::Portlet-->
													<div class="m-portlet">
														<div class="m-portlet__head">
															<div class="m-portlet__head-caption">
																<div class="m-portlet__head-title">
																	<span class="m-portlet__head-icon m--hide">
																		<i class="la la-gear"></i>
																	</span>
																	<h3 class="m-portlet__head-text">
																		Mail Settings
																	</h3>
																</div>
															</div>
														</div>
														<!--begin::Form-->
														<div class="m-portlet__body">
															<div class="m-form__section m-form__section--first">
																<div class="form-group m-form__group">
																	<label for="from_name">
																		From Name
																	</label>
																	<input type="text" class="form-control m-input" id="from_name" value="<?=$general_setting_data['from_name']?>" name="from_name">
																</div>
																<div class="form-group m-form__group">
																	<label for="from_email">
																		From Email
																	</label>
																	<input type="text" class="form-control m-input" id="from_email" value="<?=$general_setting_data['from_email']?>" name="from_email">
																</div>
																<div class="form-group m-form__group">
																	<label for="m_select2_2_modal">Mailer</label>
																	<select class="form-control" name="mailer_type" id="m_select2_2_modal" onchange="chg_mailer_type(this.value);">
																		<option value=""> - Select - </option>
																		<option value="mail" <?php if($general_setting_data['mailer_type']=='mail'||$general_setting_data['mailer_type']==''){echo 'selected="selected"';}?>>PHP Mail</option>
																		<option value="smtp" <?php if($general_setting_data['mailer_type']=='smtp'){echo 'selected="selected"';}?>>SMTP</option>
																		<option value="sendgrid" <?php if($general_setting_data['mailer_type']=='sendgrid'){echo 'selected="selected"';}?>>SendGrid</option>
																	</select>
																</div>
																<?php
																$is_smtp_mailter = 'style="display:none;"';
																$is_emailapi_mailter = 'style="display:none;"';
																if($general_setting_data['mailer_type']=='smtp') {
																	$is_smtp_mailter = 'style="display:block;"';
																}
																if($general_setting_data['mailer_type']=='sendgrid') {
																	$is_emailapi_mailter = 'style="display:block;"';
																} ?>
																<div class="form-group m-form__group showhide_smtp_fields" <?=$is_smtp_mailter?>>
																	<label for="smtp_host">
																		SMTP Host
																	</label>
																	<input type="text" class="form-control m-input" id="smtp_host" value="<?=$general_setting_data['smtp_host']?>" name="smtp_host">
																</div>
																<div class="form-group m-form__group showhide_smtp_fields" <?=$is_smtp_mailter?>>
																	<label for="smtp_port">
																		SMTP Port
																	</label>
																	<input type="text" class="form-control m-input" id="smtp_port" value="<?=$general_setting_data['smtp_port']?>" name="smtp_port">
																</div>
																<div class="form-group m-form__group showhide_smtp_fields" <?=$is_smtp_mailter?>>
																	<label for="smtp_security">SMTP Security</label>
																	<select class="form-control"  name="smtp_security" id="smtp_security">
																		<option value="none" <?php if($general_setting_data['smtp_security']=='none'){echo 'selected="selected"';}?>>None</option>
											<option value="ssl" <?php if($general_setting_data['smtp_security']=='ssl'){echo 'selected="selected"';}?>>SSL</option>
											<option value="tls" <?php if($general_setting_data['smtp_security']=='tls'){echo 'selected="selected"';}?>>TLS</option>
																	</select>
																</div>
																<div class="form-group m-form__group showhide_smtp_fields" <?=$is_smtp_mailter?>>
																	<label for="smtp_username">
																		SMTP Username
																	</label>
																	<input type="text" class="form-control m-input" id="smtp_username" value="<?=$general_setting_data['smtp_username']?>" name="smtp_username">
																</div>
																<div class="form-group m-form__group showhide_smtp_fields" <?=$is_smtp_mailter?>>
																	<label for="smtp_password">
																		SMTP Password
																	</label>
																	<input type="text" class="form-control m-input" id="smtp_password" value="<?=$general_setting_data['smtp_password']?>" name="smtp_password">
																</div>
																<div class="form-group m-form__group showhide_emailapi_fields" <?=$is_emailapi_mailter?>>
																	<label for="email_api_key">
																		API Key
																	</label>
																	<input type="text" class="form-control m-input" id="email_api_key" value="<?=$general_setting_data['email_api_key']?>" name="email_api_key">
																</div>
															</div>
														</div>
														
														<!--end::Form-->
													</div>
													<?php /*?><div class="m-portlet">
														<div class="m-portlet__head">
															<div class="m-portlet__head-caption">
																<div class="m-portlet__head-title">
																	<span class="m-portlet__head-icon m--hide">
																		<i class="la la-gear"></i>
																	</span>
																	<h3 class="m-portlet__head-text">
																		Email Template Settings
																	</h3>
																</div>
															</div>
														</div>
														<!--begin::Form-->
														<div class="m-portlet__body">
															<div class="m-form__section m-form__section--first">
																<div class="form-group m-form__group row">
																	<div class="col-6">
																		<label for="header_bg_color">Header bg color</label>
																		<input type="text" class="form-control m-input jscolor" name="other_settings[header_bg_color]" value="<?=$other_settings['header_bg_color']?>" id="chosen-value">
																	</div>
																	<div class="col-6">
																		<label for="header_text_color">Header text color</label>
																		<input type="text" class="form-control m-input jscolor" name="other_settings[header_text_color]" value="<?=$other_settings['header_text_color']?>">
																	</div>
																</div>
																<div class="form-group m-form__group row">
																	<div class="col-6">
																		<label for="footer_bg_color">Footer bg color</label>
																		<input type="text" class="form-control m-input jscolor" name="other_settings[footer_bg_color]" value="<?=$other_settings['footer_bg_color']?>">
																	</div>
																	<div class="col-6">
																		<label for="footer_text_color">Footer text color</label>
																		<input type="text" class="form-control m-input jscolor" name="other_settings[footer_text_color]" value="<?=$other_settings['footer_text_color']?>">
																	</div>
																</div>
															</div>
														</div>
														<div class="m-portlet__foot m-portlet__foot--fit">
															<div class="m-form__actions m-form__actions">
																<button type="submit" name="general_setting" class="btn btn-primary">
																	Save
																</button>
															</div>
														</div>
														<!--end::Form-->
													</div><?php */?>
													<!--end::Portlet-->
												</div>
			                  					<div class="tab-pane" id="m_tabs_6_4" role="tabpanel">
													<!--begin::Portlet-->
													<div class="m-portlet">
														<div class="m-portlet__head">
															<div class="m-portlet__head-caption">
																<div class="m-portlet__head-title">
																	<span class="m-portlet__head-icon m--hide">
																		<i class="la la-gear"></i>
																	</span>
																	<h3 class="m-portlet__head-text">
																		Socials Link
																	</h3>
																</div>
															</div>
														</div>
														<!--begin::Form-->
														<div class="m-portlet__body">
															<div class="m-form__section m-form__section--first">
																<div class="form-group m-form__group">
																	<label for="fb_link">
																		Facebook Link
																	</label>
																	<input type="text" class="form-control m-input" id="fb_link" value="<?=$general_setting_data['fb_link']?>"  name="fb_link">
																</div>
																<div class="form-group m-form__group">
																	<label for="twitter_link">
																		Twitter Link
																	</label>
																	<input type="text" class="form-control m-input" id="twitter_link" value="<?=$general_setting_data['twitter_link']?>"  name="twitter_link">
																</div>
																<div class="form-group m-form__group">
																	<label for="linkedin_link">
																		LinkedIn Link
																	</label>
																	<input type="text" class="form-control m-input" id="linkedin_link" value="<?=$general_setting_data['linkedin_link']?>"  name="linkedin_link">
																</div>
																<div class="form-group m-form__group">
																	<label for="input">
																		Instagram Link
																	</label>
																	<input type="text" class="form-control m-input" id="instagram_link" value="<?=$general_setting_data['instagram_link']?>"  name="instagram_link">
																</div>
															</div>
														</div>
														<div class="m-portlet__foot m-portlet__foot--fit">
															<div class="m-form__actions m-form__actions">
																<button type="submit" name="general_setting" class="btn btn-primary">
																	Save
																</button>
															</div>
														</div>
														<!--end::Form-->
													</div>
													<!--end::Portlet-->
													<!--begin::Portlet-->
													<div class="m-portlet">
														<div class="m-portlet__head">
															<div class="m-portlet__head-caption">
																<div class="m-portlet__head-title">
																	<span class="m-portlet__head-icon m--hide">
																		<i class="la la-gear"></i>
																	</span>
																	<h3 class="m-portlet__head-text">
																		Social Login Settings
																	</h3>
																</div>
															</div>
														</div>
														<!--begin::Form-->
														<div class="m-portlet__body">
															<div class="m-form__section m-form__section--first">
																<div class="m-form__group form-group">
																	<label for="published">
																		Social Login
																	</label>
																	<div class="m-radio-inline">
																		<label class="m-radio">
																			<input type="radio" id="show_social_login_on" name="social_login" value="1" <?php if($general_setting_data['social_login']=='1'){echo 'checked="checked"';}?>>
																			Yes
																			<span></span>
																		</label>
																		<label class="m-radio">
																			<input type="radio" id="show_social_login_off" name="social_login" value="0" <?php if($general_setting_data['social_login']=='0'){echo 'checked="checked"';}?>>
																			No
																			<span></span>
																		</label>
																	</div>
																</div>
																<div class="m-form__group form-group">
																	<label for="published">
																		Social Login Option
																	</label>
																	<div class="m-radio-inline">
																		<label class="m-radio">
																			<input type="radio" id="social_login_option" name="social_login_option" value="g_f" <?=($general_setting_data['social_login_option']=="g_f"||$general_setting_data['social_login_option']==""?'checked="checked"':'')?>>
																			Google & Facebook
																			<span></span>
																		</label>
																		<label class="m-radio">
																			<input type="radio" id="social_login_option" name="social_login_option" value="g" <?=($general_setting_data['social_login_option']=="g"?'checked="checked"':'')?>>
																			Google
																			<span></span>
																		</label>
																		<label class="m-radio">
																			<input type="radio" id="social_login_option" name="social_login_option" value="f" <?=($general_setting_data['social_login_option']=="f"?'checked="checked"':'')?>>
																			Facebook
																			<span></span>
																		</label>
																	</div>
																</div>
																<div class="form-group m-form__group">
																	<label for="input">
																		Google Client ID
																	</label>
																	<input type="text" class="form-control m-input" id="google_client_id" value="<?=$general_setting_data['google_client_id']?>" name="google_client_id">
																</div>
																<div class="form-group m-form__group">
																	<label for="input">
																		Google Client Secret
																	</label>
																	<input type="text" class="form-control m-input" id="google_client_secret" value="<?=$general_setting_data['google_client_secret']?>" name="google_client_secret">
																</div>
																<div class="form-group m-form__group">
																	<label>Google Redirect URL</label>
																	<input type="text" class="form-control m-input m-input--square" value="<?=SITE_URL?>social/social.php?google" readonly>
																	<span class="m-form__help">Copy this url and paste it to your Redirect URL in console.cloud.google.com.</span>
																</div>
																<div class="form-group m-form__group">
																	<label for="input">
																		Facebook App ID
																	</label>
																	<input type="text" class="form-control m-input" id="fb_app_id" value="<?=$general_setting_data['fb_app_id']?>" name="fb_app_id">
																</div>
																<div class="form-group m-form__group">
																	<label for="input">
																		Facebook App Secret
																	</label>
																	<input type="text" class="form-control m-input" id="fb_app_secret" value="<?=$general_setting_data['fb_app_secret']?>" name="fb_app_secret">
																</div>
																<div class="form-group m-form__group">
																	<label>Facebook Valid OAuth Redirect URI</label>
																	<input type="text" class="form-control m-input m-input--square" value="<?=SITE_URL?>social/success-fb.php?facebook=1" readonly>
																	<span class="m-form__help">Copy this url and paste it to your Valid OAuth Redirect URI in developers.facebook.com.</span>
																</div>
															</div>
														</div>
														<div class="m-portlet__foot m-portlet__foot--fit">
															<div class="m-form__actions m-form__actions">
																<button type="submit" name="general_setting" class="btn btn-primary">
																	Save
																</button>
															</div>
														</div>
														<!--end::Form-->
													</div>
													<!--end::Portlet-->
												</div>
			                  					<div class="tab-pane" id="m_tabs_6_5" role="tabpanel">
													<!--begin::Portlet-->
													<div class="m-portlet">
														<div class="m-portlet__head">
															<div class="m-portlet__head-caption">
																<div class="m-portlet__head-title">
																	<span class="m-portlet__head-icon m--hide">
																		<i class="la la-gear"></i>
																	</span>
																	<h3 class="m-portlet__head-text">
																		SMS Settings&nbsp;<a href="javascript:void(0);" data-toggle="tooltip" data-skin="light" title="You can get Twilio account SID & auth token from Twilio general settings, Twilio long code should be phone number of twilio where you have buy phone number into twilio platform." data-html="true"><span class="fa fa-info-circle"></span></a>
																	</h3>
																</div>
															</div>
														</div>
														<!--begin::Form-->
														<div class="m-portlet__body">
															<div class="m-form__section m-form__section--first">
																<div class="m-form__group form-group">
																	<label for="published">
																		SMS Sending Status
																	</label>
																	<div class="m-radio-inline">
																		<label class="m-radio">
																			<input type="radio" id="sms_sending_status" name="sms_sending_status" value="1" <?=($general_setting_data['sms_sending_status']=='1'?'checked="checked"':'')?>>
																			ON
																			<span></span>
																		</label>
																		<label class="m-radio">
																			<input type="radio" id="sms_sending_status" name="sms_sending_status" value="0" <?=(intval($general_setting_data['sms_sending_status'])=='0'?'checked="checked"':'')?>>
																			OFF
																			<span></span>
																		</label>
																	</div>
																</div>
																<div class="form-group m-form__group row">
																	<div class="col-4">
																		<label for="input">
																			Twilio Account SID
																		</label>
																		<input type="text" class="form-control m-input" id="twilio_ac_sid" value="<?=$general_setting_data['twilio_ac_sid']?>" name="twilio_ac_sid">
																	</div>
																	<div class="col-4">
																		<label for="input">
																			Twilio Account Auth Token
																		</label>
																		<input type="text" class="form-control m-input" id="twilio_ac_token" value="<?=$general_setting_data['twilio_ac_token']?>" name="twilio_ac_token">
																	</div>
																	<div class="col-4">
																		<label for="input">
																			Twilio Long Code
																		</label>
																		<input type="text" class="form-control m-input" id="twilio_long_code" value="<?=$general_setting_data['twilio_long_code']?>" name="twilio_long_code">
																		<small>With country code</small>
																	</div>
																</div>
															</div>
														</div>
														<div class="m-portlet__foot m-portlet__foot--fit">
															<div class="m-form__actions m-form__actions">
																<button type="submit" name="general_setting" class="btn btn-primary">
																	Save
																</button>
															</div>
														</div>
														<!--end::Form-->
													</div>
													<!--end::Portlet-->
												</div>
			                  					<div class="tab-pane" id="m_tabs_6_6" role="tabpanel">
													<!--begin::Portlet-->
													<div class="m-portlet">
														<div class="m-portlet__head">
															<div class="m-portlet__head-caption">
																<div class="m-portlet__head-title">
																	<span class="m-portlet__head-icon m--hide">
																		<i class="la la-gear"></i>
																	</span>
																	<h3 class="m-portlet__head-text">
																		Blog Settings
																	</h3>
																</div>
															</div>
														</div>
														<!--begin::Form-->
														<div class="m-portlet__body">
															<div class="m-form__section m-form__section--first">
																<div class="form-group m-form__group">
																	<label for="input">
																		Excerpt Length (number of words)
																	</label>
																	<input type="text" class="form-control m-input" id="blog_rm_words_limit" value="<?=$general_setting_data['blog_rm_words_limit']?>" name="blog_rm_words_limit">
																</div>
																<div class="m-form__group form-group row">
																	<div class="col-6">
																		<label for="published">
																			Display Recent Post
																		</label>
																		<div class="m-radio-inline">
																			<label class="m-radio">
																				<input type="radio" id="blog_recent_posts" name="blog_recent_posts" value="1" <?=($general_setting_data['blog_recent_posts']=='1'||$general_setting_data['blog_recent_posts']==""?'checked="checked"':'')?>>
																				Show
																				<span></span>
																			</label>
																			<label class="m-radio">
																				<input type="radio" id="blog_recent_posts" name="blog_recent_posts" value="0" <?=($general_setting_data['blog_recent_posts']=='0'?'checked="checked"':'')?>>
																				Hide
																				<span></span>
																			</label>
																		</div>
																	</div>
																	<div class="col-6">
																		<label for="blog_categories">
																			Display Categories
																		</label>
																		<div class="m-radio-inline">
																			<label class="m-radio">
																				<input type="radio" id="blog_categories" name="blog_categories" value="1" <?=($general_setting_data['blog_categories']=='1'||$general_setting_data['blog_categories']==""?'checked="checked"':'')?>>
																				Show
																				<span></span>
																			</label>
																			<label class="m-radio">
																				<input type="radio" id="blog_categories" name="blog_categories" value="0" <?=($general_setting_data['blog_categories']=='0'?'checked="checked"':'')?>>
																				Hide
																				<span></span>
																			</label>
																		</div>
																	</div>
																</div>
															</div>
														</div>
														<div class="m-portlet__foot m-portlet__foot--fit">
															<div class="m-form__actions m-form__actions">
																<button type="submit" name="general_setting" class="btn btn-primary">
																	Save
																</button>
															</div>
														</div>
														<!--end::Form-->
													</div>
													<!--end::Portlet-->
												</div>
			                  					
			                  					<div class="tab-pane" id="m_tabs_6_8" role="tabpanel">
													<!--begin::Portlet-->
													<div class="m-portlet">
														<div class="m-portlet__head">
															<div class="m-portlet__head-caption">
																<div class="m-portlet__head-title">
																	<span class="m-portlet__head-icon m--hide">
																		<i class="la la-gear"></i>
																	</span>
																	<h3 class="m-portlet__head-text">
																		Sitemap(XML) File for SEO
																	</h3>
																</div>
															</div>
														</div>
														<!--begin::Form-->
														<div class="m-portlet__body">
															<div class="m-form__section m-form__section--first">

																<div class="form-group m-form__group">
																	<label for="fileInput">Upload Sitemap(XML) File</label>
																	<div class="custom-file">
																		<input type="file" id="xml_file" class="custom-file-input" name="xml_file" onChange="checkFileXml(this)">
																		<label class="custom-file-label" for="image">
																			Choose file
																		</label>
																	</div>
																	
																	<?php
																	$sitemap_url = "../sitemap.xml";
																	if(file_exists($sitemap_url)) { ?>
																		<a class="btn btn-danger btn-sm mt-2" data-dismiss="fileupload" href="controllers/general_settings.php?r_sitemap=yes" onclick="return confirm('Are you sure to delete sitemap(XML) file?');">Remove</a>
																	<?php
																	} ?>
																</div>
																
															</div>
														</div>
														<div class="m-portlet__foot m-portlet__foot--fit">
															<div class="m-form__actions m-form__actions">
																<button type="submit" name="general_setting" class="btn btn-primary">
																	Save
																</button>
															</div>
														</div>
														<!--end::Form-->
													</div>
													<!--end::Portlet-->
												</div>
												
												<div class="tab-pane" id="m_tabs_6_7" role="tabpanel">
													<!--begin::Portlet-->
													<div class="m-portlet">
														<div class="m-portlet__head">
															<div class="m-portlet__head-caption">
																<div class="m-portlet__head-title">
																	<span class="m-portlet__head-icon m--hide">
																		<i class="la la-gear"></i>
																	</span>
																	<h3 class="m-portlet__head-text">
																		Shipping API Settings
																	</h3>
																</div>
															</div>
														</div>
														<!--begin::Form-->
														<div class="m-portlet__body">
															<div class="m-form__section m-form__section--first">
															
																<div class="m-form__group form-group row">
																	<div class="col-2">
																		<label>Order</label>
																		<input type="number" class="form-control m-input" value="<?=$shipping_option['post_me_a_prepaid_label_order']?>" name="shipping_option[post_me_a_prepaid_label_order]">
																	</div>
																	<div class="col-5">
																		<label>Shipping Option</label>
																		<div class="m-checkbox-inline">
																			<label class="m-checkbox">
																				<input type="checkbox" value="post_me_a_prepaid_label" name="shipping_option[post_me_a_prepaid_label]" <?php if($shipping_option['post_me_a_prepaid_label']=='post_me_a_prepaid_label'){echo 'checked="checked"';}?>>
																				Send me a Box and Label &nbsp;<a href="javascript:void(0);" data-toggle="tooltip" data-skin="light" title="Prepaid Shipping Label will be sent to customer my shop from admin panel.When you generate Shipping label from admin panel it sent email." data-html="true"><span class="fa fa-info-circle"></span></a>
																				<span></span>
																			</label>
																		</div>
																	</div>
																	<div class="col-3">
																		<label>Image</label>
																		<div class="custom-file">
																			<input type="file" class="custom-file-input" name="shipping_option[post_me_a_prepaid_label_image]" onChange="checkFile(this);" accept="image/*">
																			<label class="custom-file-label">
																				Choose
																			</label>
																		</div>
																		<?php
																		if($shipping_option['post_me_a_prepaid_label_image']!="") { ?>
																			<img src="../images/<?=$shipping_option['post_me_a_prepaid_label_image'].'?token='.uniqid()?>" width="50" class="my-md-2">
																			<input type="hidden" name="shipping_option[post_me_a_prepaid_label_image_old]" value="<?=$shipping_option['post_me_a_prepaid_label_image']?>">
																		<?php
																		} ?>
																	</div>
																	<div class="col-2">
																		<label>&nbsp;</label>
																		<div class="m-checkbox-inline">
																			<label class="m-checkbox">
																				<input type="checkbox" value="1" name="shipping_option[post_me_a_prepaid_label_image_rm]"> Remove
																				<span></span>
																			</label>
																		</div>
																	</div>
																</div>
																
																<div class="m-form__group form-group row">
																	<div class="col-2">
																		<input type="number" class="form-control m-input" value="<?=$shipping_option['use_my_own_courier_order']?>" name="shipping_option[use_my_own_courier_order]">
																	</div>
																	<div class="col-5">
																		<div class="m-checkbox-inline">
																			<label class="m-checkbox">
																				<input type="checkbox" value="use_my_own_courier" name="shipping_option[use_my_own_courier]" <?php if($shipping_option['use_my_own_courier']=='use_my_own_courier'){echo 'checked="checked"';}?>>
																				I will ship and send you tracking &nbsp;<a href="javascript:void(0);" data-toggle="tooltip" data-skin="light" title="Customer going to send devices via currier." data-html="true"><span class="fa fa-info-circle"></span></a>
																				<span></span>
																			</label>
																		</div>
																	</div>
																	<div class="col-3">
																		<div class="custom-file">
																			<input type="file" class="custom-file-input" name="shipping_option[use_my_own_courier_image]" onChange="checkFile(this);" accept="image/*">
																			<label class="custom-file-label">
																				Choose
																			</label>
																		</div>
																		<?php
																		if($shipping_option['use_my_own_courier_image']!="") { ?>
																			<img src="../images/<?=$shipping_option['use_my_own_courier_image'].'?token='.uniqid()?>" width="50" class="my-md-2">
																			<input type="hidden" name="shipping_option[use_my_own_courier_image_old]" value="<?=$shipping_option['use_my_own_courier_image']?>">
																		<?php
																		} ?>
																	</div>
																	<div class="col-2">
																		<div class="m-checkbox-inline">
																			<label class="m-checkbox">
																				<input type="checkbox" value="1" name="shipping_option[use_my_own_courier_image_rm]"> Remove
																				<span></span>
																			</label>
																		</div>
																	</div>
																</div>
																
																<div class="m-form__group form-group row">
																	<div class="col-2">
																		<input type="number" class="form-control m-input" value="<?=$shipping_option['we_come_for_you_order']?>" name="shipping_option[we_come_for_you_order]">
																	</div>
																	<div class="col-5">
																		<div class="m-checkbox-inline">
																			<label class="m-checkbox">
																				<input type="checkbox" value="we_come_for_you" name="shipping_option[we_come_for_you]" <?php if($shipping_option['we_come_for_you']=='we_come_for_you'){echo 'checked="checked"';}?>>
																				schedule on demand pickup &nbsp;<a href="javascript:void(0);" data-toggle="tooltip" data-skin="light" title="Shops User will go to customer to collect devices." data-html="true"><span class="fa fa-info-circle"></span></a>
																				<span></span>
																			</label>
																		</div>
																		<a href="demand_pickup_zipcodes.php">Upload Zip</a>
																	</div>
																	<div class="col-3">
																		<div class="custom-file">
																			<input type="file" class="custom-file-input" name="shipping_option[we_come_for_you_image]" onChange="checkFile(this);" accept="image/*">
																			<label class="custom-file-label">
																				Choose
																			</label>
																		</div>
																		<?php
																		if($shipping_option['we_come_for_you_image']!="") { ?>
																			<img src="../images/<?=$shipping_option['we_come_for_you_image'].'?token='.uniqid()?>" width="50" class="my-md-2">
																			<input type="hidden" name="shipping_option[we_come_for_you_image_old]" value="<?=$shipping_option['we_come_for_you_image']?>">
																		<?php
																		} ?>
																	</div>
																	<div class="col-2">
																		<div class="m-checkbox-inline">
																			<label class="m-checkbox">
																				<input type="checkbox" value="1" name="shipping_option[we_come_for_you_image_rm]"> Remove
																				<span></span>
																			</label>
																		</div>
																	</div>
																</div>
																
																<div class="m-form__group form-group row">
																	<div class="col-2">
																		<input type="number" class="form-control m-input" value="<?=$shipping_option['store_order']?>" name="shipping_option[store_order]">
																	</div>
																	<div class="col-5">
																		<div class="m-checkbox-inline">
																			<label class="m-checkbox">
																				<input type="checkbox" value="store" name="shipping_option[store]" <?php if($shipping_option['store']=='store'){echo 'checked="checked"';}?>>
																				in store drop off &nbsp;<a href="javascript:void(0);" data-toggle="tooltip" data-skin="light" title="Customer Come To chosen store for shipping devices." data-html="true"><span class="fa fa-info-circle"></span></a>
																				<span></span>
																			</label>
																		</div>
																	</div>
																	<div class="col-3">
																		<div class="custom-file">
																			<input type="file" class="custom-file-input" name="shipping_option[store_image]" onChange="checkFile(this);" accept="image/*">
																			<label class="custom-file-label">
																				Choose
																			</label>
																		</div>
																		<?php
																		if($shipping_option['store_image']!="") { ?>
																			<img src="../images/<?=$shipping_option['store_image'].'?token='.uniqid()?>" width="50" class="my-md-2">
																			<input type="hidden" name="shipping_option[store_image_old]" value="<?=$shipping_option['store_image']?>">
																		<?php
																		} ?>
																	</div>
																	<div class="col-2">
																		<div class="m-checkbox-inline">
																			<label class="m-checkbox">
																				<input type="checkbox" value="1" name="shipping_option[store_image_rm]"> Remove
																				<span></span>
																			</label>
																		</div>
																	</div>
																</div>
																
																<div class="m-form__group form-group row">
																	<div class="col-2">
																		<input type="number" class="form-control m-input" value="<?=$shipping_option['starbucks_order']?>" name="shipping_option[starbucks_order]">
																	</div>
																	<div class="col-5">
																		<div class="m-checkbox-inline">
																			<label class="m-checkbox">
																				<input type="checkbox" value="starbucks" name="shipping_option[starbucks]" <?php if($shipping_option['starbucks']=='starbucks'){echo 'checked="checked"';}?>>
																				schedule a local meet up &nbsp;<a href="javascript:void(0);" data-toggle="tooltip" data-skin="light" title="Customer Come To chosen starbucks Location for shipping devices." data-html="true"><span class="fa fa-info-circle"></span></a>
																				<span></span>
																			</label>
																		</div>
																	</div>
																	<div class="col-3">
																		<div class="custom-file">
																			<input type="file" class="custom-file-input" name="shipping_option[starbucks_image]" onChange="checkFile(this);" accept="image/*">
																			<label class="custom-file-label">
																				Choose
																			</label>
																		</div>
																		<?php
																		if($shipping_option['starbucks_image']!="") { ?>
																			<img src="../images/<?=$shipping_option['starbucks_image'].'?token='.uniqid()?>" width="50" class="my-md-2">
																			<input type="hidden" name="shipping_option[starbucks_image_old]" value="<?=$shipping_option['starbucks_image']?>">
																		<?php
																		} ?>
																	</div>
																	<div class="col-2">
																		<div class="m-checkbox-inline">
																			<label class="m-checkbox">
																				<input type="checkbox" value="1" name="shipping_option[starbucks_image_rm]"> Remove
																				<span></span>
																			</label>
																		</div>
																	</div>
																</div>
																
																<div class="m-form__group form-group row">
																	<div class="col-2">
																		<input type="number" class="form-control m-input" value="<?=$shipping_option['print_a_prepaid_label_order']?>" name="shipping_option[print_a_prepaid_label_order]">
																	</div>
																	<div class="col-5">
																		<div class="m-checkbox-inline">
																			<label class="m-checkbox">
																				<input type="checkbox" value="print_a_prepaid_label" name="shipping_option[print_a_prepaid_label]" id="shipping_option_print_a_prepaid_label" <?php if($shipping_option['print_a_prepaid_label']=='print_a_prepaid_label'){echo 'checked="checked"';}?>>
																				Print A Prepaid Label &nbsp;<a href="javascript:void(0);" data-toggle="tooltip" data-skin="light" title="
This use Shipping Label API to generate label.Customer can download and print  on order completion page as well email sent to customer with attached shipping label." data-html="true">
																		<span class="fa fa-info-circle"></span></a>
																				<span></span>
																			</label>
																		</div>
																	</div>
																	<div class="col-3">
																		<div class="custom-file">
																			<input type="file" class="custom-file-input" name="shipping_option[print_a_prepaid_label_image]" onChange="checkFile(this);" accept="image/*">
																			<label class="custom-file-label">
																				Choose
																			</label>
																		</div>
																		<?php
																		if($shipping_option['print_a_prepaid_label_image']!="") { ?>
																			<img src="../images/<?=$shipping_option['print_a_prepaid_label_image'].'?token='.uniqid()?>" width="50" class="my-md-2">
																			<input type="hidden" name="shipping_option[print_a_prepaid_label_image_old]" value="<?=$shipping_option['print_a_prepaid_label_image']?>">
																		<?php
																		} ?>
																	</div>
																	<div class="col-2">
																		<div class="m-checkbox-inline">
																			<label class="m-checkbox">
																				<input type="checkbox" value="1" name="shipping_option[print_a_prepaid_label_image_rm]"> Remove
																				<span></span>
																			</label>
																		</div>
																	</div>
																</div>
																
																<div class="m-separator m-separator--dash m-separator--sm"></div>
																<div class="shipping_api_fields" <?php if($shipping_option['print_a_prepaid_label']=='print_a_prepaid_label'){echo 'style="display:block;"';}else{echo 'style="display:none;"';}?>>
																<div class="form-group m-form__group">
																	<label for="fa_icon">Shipping API</label>
																	<select class="form-control" name="shipping_api" id="shipping_api">
																		<option value=""> -Select- </option>
																   	<option value="royal_mail" <?php if($general_setting_data['shipping_api']=='royal_mail'){echo 'selected="selected"';}?>>Royal Mail</option>
																		<option value="easypost" <?php if($general_setting_data['shipping_api']=='easypost'){echo 'selected="selected"';}?>>Easy Post</option>
																	</select>
																</div>
																<?php /*?><div class="m-form__group form-group">
																	<div class="m-checkbox-inline">
																		<label class="m-checkbox">
																			<input id="shipment_generated_by_cust" type="checkbox" value="1" name="shipment_generated_by_cust" <?php if($general_setting_data['shipment_generated_by_cust']=='1'){echo 'checked="checked"';}?>>
																				Allow Shipment Generated to Customer
																			<span></span>
																		</label>
																	</div>
																</div><?php */?>
																<div class="form-group m-form__group">
																	<label for="shipping_api_key">
																		Shipping API Key
																	</label>
																	<input type="text" class="form-control m-input" id="shipping_api_key" value="<?=$general_setting_data['shipping_api_key']?>" name="shipping_api_key">
																</div>
																
																<div class="m-form__group form-group">
																	<label for="published">Default Carrier Account</label>
																	<div class="m-radio-inline">
																		<label class="m-radio">
																			<input type="radio" id="default_carrier_account1" name="default_carrier_account" value="usps" class="default_carrier_account" <?=($general_setting_data['default_carrier_account']=="usps"||$general_setting_data['default_carrier_account']==""?'checked="checked"':'')?>>
																			USPS
																			<span></span>
																		</label>
																		<label class="m-radio">
																			<input type="radio" id="default_carrier_account2" name="default_carrier_account" value="ups" class="default_carrier_account" <?=($general_setting_data['default_carrier_account']=="ups"?'checked="checked"':'')?>>
																			UPS
																			<span></span>
																		</label>
																		<label class="m-radio">
																			<input type="radio" id="default_carrier_account3" name="default_carrier_account" value="fedex" class="default_carrier_account" <?=($general_setting_data['default_carrier_account']=="fedex"?'checked="checked"':'')?>>
																			FedEx
																			<span></span>
																		</label>
																		<label class="m-radio">
																			<input type="radio" id="default_carrier_account4" name="default_carrier_account" value="dhl" class="default_carrier_account" <?=($general_setting_data['default_carrier_account']=="dhl"?'checked="checked"':'')?>>
																			DHL
																			<span></span>
																		</label>
																		<label class="m-radio">
																			<input type="radio" id="default_carrier_account5" name="default_carrier_account" value="other" class="default_carrier_account" <?=($general_setting_data['default_carrier_account']=="other"?'checked="checked"':'')?>>
																			Other
																			<span></span>
																		</label>
																	</div>
																</div>
																
																<div class="showhide_shipping_api_usps_service" <?php if($general_setting_data['default_carrier_account']=="usps"){echo 'style="display:block;"';}else{echo 'style="display:none;"';}?>>
																<div class="form-group m-form__group row">
																	<div class="col-6">
																		<label>USPS Service</label>
																		<?php
																		$shipping_api_usps_service_arr = array('First','Priority','Express','ParcelSelect','LibraryMail','MediaMail','FirstClassMailInternational','FirstClassPackageInternationalService','PriorityMailInternational','ExpressMailInternational');?>
																		<select class="form-control m-input" name="shipping_api_usps_service">
																			<option value=""> -Select- </option>
																			<?php
																			foreach($shipping_api_usps_service_arr as $srvc_k=>$srvc_v) { ?>
																			<option value="<?=$srvc_v?>" <?php if($other_settings['shipping_api_service']==$srvc_v){echo 'selected="selected"';}?>><?=$srvc_v?></option>
																			<?php
																			} ?>
																		</select>
																	</div>
																	<div class="col-6">
																		<label>USPS Package</label>
																		<?php
																		$shipping_api_usps_package_arr = array('Card','Letter','Flat','FlatRateEnvelope','FlatRateLegalEnvelope','FlatRatePaddedEnvelope','Parcel','IrregularParcel','SoftPack','SmallFlatRateBox','MediumFlatRateBox','LargeFlatRateBox','LargeFlatRateBoxAPOFPO','RegionalRateBoxA','RegionalRateBoxB');?>
																		<select class="form-control m-input" name="shipping_api_usps_package">
																			<option value=""> -Select- </option>
																			<?php
																			foreach($shipping_api_usps_package_arr as $pkg_k=>$pkg_v) { ?>
																			<option value="<?=$pkg_v?>" <?php if($other_settings['shipping_api_package']==$pkg_v){echo 'selected="selected"';}?>><?=$pkg_v?></option>
																			<?php
																			} ?>
																		</select>
																	</div>
																</div>
																</div>
																
																<div class="showhide_shipping_api_ups_service" <?php if($general_setting_data['default_carrier_account']=="ups"){echo 'style="display:block;"';}else{echo 'style="display:none;"';}?>>
																<div class="form-group m-form__group row">
																	<div class="col-6">
																		<label>UPS Service</label>
																		<?php
																		$shipping_api_ups_service_arr = array('Ground','UPSStandard','UPSSaver','Express','ExpressPlus','Expedited','NextDayAir','NextDayAirSaver','NextDayAirEarlyAM','2ndDayAir','2ndDayAirAM','3DaySelect');?>
																		<select class="form-control m-input" name="shipping_api_ups_service">
																			<option value=""> -Select- </option>
																			<?php

																			foreach($shipping_api_ups_service_arr as $srvc_k=>$srvc_v) { ?>
																			<option value="<?=$srvc_v?>" <?php if($other_settings['shipping_api_service']==$srvc_v){echo 'selected="selected"';}?>><?=$srvc_v?></option>
																			<?php
																			} ?>
																		</select>
																	</div>
																	<div class="col-6">
																		<label>UPS Package</label>
																		<?php
																		$shipping_api_ups_package_arr = array('UPSLetter','UPSExpressBox','UPS25kgBox','UPS10kgBox','Tube','Pak','SmallExpressBox','MediumExpressBox','LargeExpressBox');?>
																		<select class="form-control m-input" name="shipping_api_ups_package">
																			<option value=""> -Select- </option>
																			<?php
																			foreach($shipping_api_ups_package_arr as $pkg_k=>$pkg_v) { ?>
																			<option value="<?=$pkg_v?>" <?php if($other_settings['shipping_api_package']==$pkg_v){echo 'selected="selected"';}?>><?=$pkg_v?></option>
																			<?php
																			} ?>
																		</select>
																	</div>
																</div>
																</div>
																
																<div class="showhide_shipping_api_fedex_service" <?php if($general_setting_data['default_carrier_account']=="fedex"){echo 'style="display:block;"';}else{echo 'style="display:none;"';}?>>
																<div class="form-group m-form__group row">
																	<div class="col-6">
																		<label>Fedex Service</label>
																		<?php
																		$shipping_api_fedex_service_arr = array('FEDEX_GROUND','FEDEX_2_DAY','FEDEX_2_DAY_AM','FEDEX_EXPRESS_SAVER','STANDARD_OVERNIGHT','FIRST_OVERNIGHT','PRIORITY_OVERNIGHT','INTERNATIONAL_ECONOMY','INTERNATIONAL_FIRST','GROUND_HOME_DELIVERY','SMART_POST');?>
																		<select class="form-control m-input" name="shipping_api_fedex_service">
																			<option value=""> -Select- </option>
																			<?php
																			foreach($shipping_api_fedex_service_arr as $srvc_k=>$srvc_v) { ?>
																			<option value="<?=$srvc_v?>" <?php if($other_settings['shipping_api_service']==$srvc_v){echo 'selected="selected"';}?>><?=$srvc_v?></option>
																			<?php
																			} ?>
																		</select>
																	</div>
																	<div class="col-6">
																		<label>Fedex Package</label>
																		<?php
																		$shipping_api_fedex_package_arr = array('FedExEnvelope','FedExSmallBox','FedExMediumBox','FedExLargeBox','FedExExtraLargeBox','FedExPak','FedExTube','FedEx10kgBox','FedEx25kgBox');?>
																		<select class="form-control m-input" name="shipping_api_fedex_package">
																			<option value=""> -Select- </option>
																			<?php
																			foreach($shipping_api_fedex_package_arr as $pkg_k=>$pkg_v) { ?>
																			<option value="<?=$pkg_v?>" <?php if($other_settings['shipping_api_package']==$pkg_v){echo 'selected="selected"';}?>><?=$pkg_v?></option>
																			<?php
																			} ?>
																		</select>
																	</div>
																</div>
																</div>
																
																<div class="showhide_shipping_api_dhl_service" <?php if($general_setting_data['default_carrier_account']=="dhl"){echo 'style="display:block;"';}else{echo 'style="display:none;"';}?>>
																<div class="form-group m-form__group row">
																	<div class="col-6">
																		<label>DHL Service</label>
																		<?php
																		$shipping_api_dhl_service_arr = array('BreakBulkEconomy','BreakBulkExpress','DomesticEconomySelect','DomesticExpress','DomesticExpress1030','DomesticExpress1200','EconomySelect','EconomySelectNonDoc','EuroPack','EuropackNonDoc','Express1030','Express1030NonDoc','Express1200NonDoc','Express1200','Express900','Express900NonDoc','ExpressEasy','ExpressEasyNonDoc','ExpressEnvelope','ExpressWorldwide','ExpressWorldwideB2C','ExpressWorldwideB2CNonDoc','ExpressWorldwideECX','ExpressWorldwideNonDoc','FreightWorldwide','GlobalmailBusiness','JetLine','JumboBox','LogisticsServices','SameDay','SecureLine','SprintLine');?>
																		<select class="form-control m-input" name="shipping_api_dhl_service">
																			<option value=""> -Select- </option>
																			<?php
																			foreach($shipping_api_dhl_service_arr as $srvc_k=>$srvc_v) { ?>
																			<option value="<?=$srvc_v?>" <?php if($other_settings['shipping_api_service']==$srvc_v){echo 'selected="selected"';}?>><?=$srvc_v?></option>
																			<?php
																			} ?>
																		</select>
																	</div>
																	<div class="col-6">
																		<label>DHL Package</label>
																		<?php
																		$shipping_api_dhl_package_arr = array('JumboDocument','JumboParcel','Document','DHLFlyer','Domestic','ExpressDocument','DHLExpressEnvelope','JumboBox','JumboJuniorDocument','JuniorJumboBox','JumboJuniorParcel','OtherDHLPackaging','Parcel','YourPackaging');?>
																		<select class="form-control m-input" name="shipping_api_dhl_package">
																			<option value=""> -Select- </option>
																			<?php
																			foreach($shipping_api_dhl_package_arr as $pkg_k=>$pkg_v) { ?>
																			<option value="<?=$pkg_v?>" <?php if($other_settings['shipping_api_package']==$pkg_v){echo 'selected="selected"';}?>><?=$pkg_v?></option>
																			<?php
																			} ?>
																		</select>
																	</div>
																</div>
																</div>
																
																<div class="form-group m-form__group">
																	<label for="carrier_account_id">Carrier Account ID</label>
																	<input type="text" class="form-control m-input" id="carrier_account_id" value="<?=$general_setting_data['carrier_account_id']?>" name="carrier_account_id">
																</div>
																<div class="form-group m-form__group row">
																	<div class="col-6">
																		<label for="shipping_parcel_length">
																			Shipping Parcel Length
																		</label>
																		<input type="text" class="form-control m-input" id="shipping_parcel_length" value="<?=$general_setting_data['shipping_parcel_length']?>" name="shipping_parcel_length" placeholder="20.2">
																	</div>
																	<div class="col-6">
																		<label for="shipping_parcel_width">
																			Shipping Parcel Width
																		</label>
																		<input type="text" class="form-control m-input" id="shipping_parcel_width" value="<?=$general_setting_data['shipping_parcel_width']?>" name="shipping_parcel_width" placeholder="10.9">
																	</div>
																</div>
																<div class="form-group m-form__group row">
																	<div class="col-6">
																		<label for="shipping_parcel_height">
																			Shipping Parcel Height
																		</label>
																		<input type="text" class="form-control m-input" id="shipping_parcel_height" value="<?=$general_setting_data['shipping_parcel_height']?>" name="shipping_parcel_height" placeholder="5">
																	</div>
																	<div class="col-6">
																		<label for="shipping_parcel_weight">
																			Shipping Parcel Weight
																		</label>
																		<input type="text" class="form-control m-input" id="shipping_parcel_weight" value="<?=$general_setting_data['shipping_parcel_weight']?>" name="shipping_parcel_weight" placeholder="65.9">
																	</div>
																</div>
																<div class="form-group m-form__group row">
																	<div class="col-12">
																		<label for="shipping_parcel_length">
																			Web Hook URL
																		</label>
																		<input type="text" class="form-control m-input" id="shipping_hook_url" value="<?=SITE_URL?>hook/shipment_status_update.php" name="shipping_hook_url" readonly>
																	</div>
																</div>
																</div>
															</div>
														</div>
														<div class="m-portlet__foot m-portlet__foot--fit">
															<div class="m-form__actions m-form__actions">
																<button type="submit" name="general_setting" class="btn btn-primary">
																	Save
																</button>
															</div>
														</div>
														<!--end::Form-->
													</div>
													<!--end::Portlet-->
												</div>
												
												<div class="tab-pane" id="m_tabs_6_9" role="tabpanel">
													<!--begin::Portlet-->
													<div class="m-portlet">
														<div class="m-portlet__head">
															<div class="m-portlet__head-caption">
																<div class="m-portlet__head-title">
																	<span class="m-portlet__head-icon m--hide">
																		<i class="la la-gear"></i>
																	</span>
																	<h3 class="m-portlet__head-text">
																		Captcha Settings
																	</h3>
																</div>
															</div>
														</div>
														<!--begin::Form-->
														<div class="m-portlet__body">
															<div class="m-form__section m-form__section--first">
																<div class="form-group m-form__group">
																	<label for="captcha_key">
																		Captcha Key
																	</label>
																	<input type="text" class="form-control m-input" name="captcha_settings[captcha_key]" value="<?=$captcha_settings['captcha_key']?>">
																</div>
																<div class="form-group m-form__group">
																	<label for="captcha_secret">
																		Captcha Secret
																	</label>
																	<input type="text" class="form-control m-input" name="captcha_settings[captcha_secret]" value="<?=$captcha_settings['captcha_secret']?>">
																</div>
																
																<div class="m-form__group form-group">
																	<label>Captcha Form Settings</label>
																	<div class="m-checkbox-inline">
																	
																		<label class="m-checkbox">
																			<input type="checkbox" value="1" name="captcha_settings[contact_form]" <?php if($captcha_settings['contact_form']=="1"){echo 'checked="checked"';}?>>
																			Contact Us Form <span></span>
																		</label>
																		<label class="m-checkbox">
																			<input type="checkbox" value="1" name="captcha_settings[write_review_form]" <?php if($captcha_settings['write_review_form']=="1"){echo 'checked="checked"';}?>>
																			Write A Review Form <span></span>
																		</label>
																		<label class="m-checkbox">
																			<input type="checkbox" value="1" name="captcha_settings[bulk_order_form]" <?php if($captcha_settings['bulk_order_form']=="1"){echo 'checked="checked"';}?>>
																			Bulk Order Form <span></span>
																		</label>
																		<label class="m-checkbox">
																			<input type="checkbox" value="1" name="captcha_settings[affiliate_form]" <?php if($captcha_settings['affiliate_form']=="1"){echo 'checked="checked"';}?>>
																			Affiliate Form <span></span>
																		</label>
																		<?php /*?><label class="m-checkbox">
																			<input type="checkbox" value="1" name="captcha_settings[appt_form]" <?php if($captcha_settings['appt_form']=="1"){echo 'checked="checked"';}?>>
																			Appt. Form <span></span>
																		</label><?php */?>
																		<label class="m-checkbox">
																			<input type="checkbox" value="1" name="captcha_settings[login_form]" <?php if($captcha_settings['login_form']=="1"){echo 'checked="checked"';}?>>
																			Login Form <span></span>
																		</label>
																		<label class="m-checkbox">
																			<input type="checkbox" value="1" name="captcha_settings[signup_form]" <?php if($captcha_settings['signup_form']=="1"){echo 'checked="checked"';}?>>
																			Signup Form <span></span>
																		</label>
																		<?php /*?><label class="m-checkbox">
																			<input type="checkbox" value="1" name="captcha_settings[contractor_form]" <?php if($captcha_settings['contractor_form']=="1"){echo 'checked="checked"';}?>>
																			Contractor Form <span></span>
																		</label>
																		<?php */?>
																		<label class="m-checkbox">
																			<input type="checkbox" value="1" name="captcha_settings[order_track_form]" <?php if($captcha_settings['order_track_form']=="1"){echo 'checked="checked"';}?>>
																			Order Track Form <span></span>
																		</label>
																		<!--<label class="m-checkbox">
																			<input type="checkbox" value="1" name="captcha_settings[newsletter_form]" <?php if($captcha_settings['newsletter_form']=="1"){echo 'checked="checked"';}?>>
																			Newsletter Form <span></span>
																		</label>-->
																		<label class="m-checkbox">
																			<input type="checkbox" value="1" name="captcha_settings[missing_product_form]" <?php if($captcha_settings['missing_product_form']=="1"){echo 'checked="checked"';}?>>
																			Missing Product Form <span></span>
																		</label>
																		<!--<label class="m-checkbox">
																			<input type="checkbox" value="1" name="captcha_settings[imei_number_based_search_form]" <?php if($captcha_settings['imei_number_based_search_form']=="1"){echo 'checked="checked"';}?>>
																			IMEI Number Based Search Form <span></span>
																		</label>-->
																	</div>
																</div>
															</div>
														</div>
														<div class="m-portlet__foot m-portlet__foot--fit">
															<div class="m-form__actions m-form__actions">
																<button type="submit" name="general_setting" class="btn btn-primary">
																	Save
																</button>
															</div>
														</div>
														<!--end::Form-->
													</div>
													<!--end::Portlet-->
												</div>
												
												<div class="tab-pane" id="m_tabs_6_10" role="tabpanel">
													<!--begin::Portlet-->
													<div class="m-portlet">
														<div class="m-portlet__head">
															<div class="m-portlet__head-caption">
																<div class="m-portlet__head-title">
																	<span class="m-portlet__head-icon m--hide">
																		<i class="la la-gear"></i>
																	</span>
																	<h3 class="m-portlet__head-text">
																		Email Template Settings
																	</h3>
																</div>
															</div>
														</div>
														<!--begin::Form-->
														<div class="m-portlet__body">
															<div class="m-form__section m-form__section--first">
																<div class="form-group m-form__group row">
																	<div class="col-6">
																		<label for="header_bg_color">Header bg color</label>
																		<input type="text" class="form-control m-input jscolor" name="other_settings[header_bg_color]" value="<?=$other_settings['header_bg_color']?>" id="chosen-value">
																	</div>
																	<div class="col-6">
																		<label for="header_text_color">Header text color</label>
																		<input type="text" class="form-control m-input jscolor" name="other_settings[header_text_color]" value="<?=$other_settings['header_text_color']?>">
																	</div>
																</div>
																<div class="form-group m-form__group row">
																	<div class="col-6">
																		<label for="footer_bg_color">Footer bg color</label>
																		<input type="text" class="form-control m-input jscolor" name="other_settings[footer_bg_color]" value="<?=$other_settings['footer_bg_color']?>">
																	</div>
																	<div class="col-6">
																		<label for="footer_text_color">Footer text color</label>
																		<input type="text" class="form-control m-input jscolor" name="other_settings[footer_text_color]" value="<?=$other_settings['footer_text_color']?>">
																	</div>
																</div>
															</div>
														</div>
														<div class="m-portlet__foot m-portlet__foot--fit">
															<div class="m-form__actions m-form__actions">
																<button type="submit" name="general_setting" class="btn btn-primary">
																	Save
																</button>
															</div>
														</div>
														<!--end::Form-->
													</div>
													<!--end::Portlet-->
												</div>
												
												<div class="tab-pane" id="theme_settings_tab" role="tabpanel">
													<!--begin::Portlet-->
													<div class="m-portlet">
														<div class="m-portlet__head">
															<div class="m-portlet__head-caption">
																<div class="m-portlet__head-title">
																	<span class="m-portlet__head-icon m--hide">
																		<i class="la la-gear"></i>
																	</span>
																	<h3 class="m-portlet__head-text">
																		Theme Settings
																	</h3>
																</div>
															</div>
														</div>
														<!--begin::Form-->
														<div class="m-portlet__body">
															<div class="m-form__section m-form__section--first">
																<div class="form-group m-form__group row">
																	<div class="col-6">
																		<label for="main_background_color">Site background color</label>
																		<input type="text" class="form-control m-input jscolor" name="theme_settings[main_background_color]" value="<?=$theme_settings['main_background_color']?>" id="chosen-value">
																	</div>
																	<div class="col-6">
																		<label for="main_background_text_color">Site Body Text color</label>
																		<input type="text" class="form-control m-input jscolor" name="theme_settings[main_background_text_color]" value="<?=$theme_settings['main_background_text_color']?>">
																	</div>
																</div>
																
																<h3 class="mt-3">Main Menu </h3>
																<div class="form-group m-form__group row">
																	<div class="col-6">
																		<label for="menu_color">Menu color</label>
																		<input type="text" class="form-control m-input jscolor" name="theme_settings[menu_color]" value="<?=$theme_settings['menu_color']?>" id="chosen-value">
																	</div>
																	<div class="col-6">
																		<label for="menu_hover_color">Menu hover color</label>
																		<input type="text" class="form-control m-input jscolor" name="theme_settings[menu_hover_color]" value="<?=$theme_settings['menu_hover_color']?>">
																	</div>
																</div>
																
																<div class="form-group m-form__group row">
																	<div class="col-4">
																		<label for="sub_menu_color">Sub menu color</label>
																		<input type="text" class="form-control m-input jscolor" name="theme_settings[sub_menu_color]" value="<?=$theme_settings['sub_menu_color']?>" id="chosen-value">
																	</div>
																	<div class="col-4">
																		<label for="sub_menu_hover_color">Sub menu hover color</label>
																		<input type="text" class="form-control m-input jscolor" name="theme_settings[sub_menu_hover_color]" value="<?=$theme_settings['sub_menu_hover_color']?>">
																	</div>
																	<div class="col-4">
																		<label for="sub_menu_background_color">Sub menu background color</label>
																		<input type="text" class="form-control m-input jscolor" name="theme_settings[sub_menu_background_color]" value="<?=$theme_settings['sub_menu_background_color']?>">
																	</div>
																</div>
																
																<h3 class="mt-3">Header Call To Action Buttons</h3>
																<div class="form-group m-form__group row">
																	<div class="col-6">
																		<label for="header_calltoaction_button_color">Button Background Color</label>
																		<input type="text" class="form-control m-input jscolor" name="theme_settings[header_calltoaction_button_color]" value="<?=$theme_settings['header_calltoaction_button_color']?>" id="chosen-value">
																	</div>
																	<div class="col-6">
																		<label for="header_calltoaction_button_text_color">Button  Text Color</label>
																		<input type="text" class="form-control m-input jscolor" name="theme_settings[header_calltoaction_button_text_color]" value="<?=$theme_settings['header_calltoaction_button_text_color']?>">
																	</div>
																</div>
																<div class="form-group m-form__group row">
																	<div class="col-6">
																		<label for="header_calltoaction_button_hover_color">Button Hover Background Color</label>
																		<input type="text" class="form-control m-input jscolor" name="theme_settings[header_calltoaction_button_hover_color]" value="<?=$theme_settings['header_calltoaction_button_hover_color']?>" id="chosen-value">
																	</div>
																	<div class="col-6">
																		<label for="header_calltoaction_button_text_hover_color">Button Hover Text Color</label>
																		<input type="text" class="form-control m-input jscolor" name="theme_settings[header_calltoaction_button_text_hover_color]" value="<?=$theme_settings['header_calltoaction_button_text_hover_color']?>">
																	</div>
																</div>
																
																<div class="form-group m-form__group row">
																	<div class="col-6">
																		<label for="heading_title_color">Heading color</label>
																		<input type="text" class="form-control m-input jscolor" name="theme_settings[heading_title_color]" value="<?=$theme_settings['heading_title_color']?>" id="chosen-value">
																	</div>
																</div>
																
																<h3 class="mt-3">Site Buttons, Products hover etc </h3>
																<div class="form-group m-form__group row">
																	<div class="col-6">
																		<label for="primary_color">Primary color</label>
																		<input type="text" class="form-control m-input jscolor" name="theme_settings[primary_color]" value="<?=$theme_settings['primary_color']?>" id="chosen-value">
																	</div>
																	<div class="col-6">
																		<label for="primary_text_color">Primary text color</label>
																		<input type="text" class="form-control m-input jscolor" name="theme_settings[primary_text_color]" value="<?=$theme_settings['primary_text_color']?>">
																	</div>
																</div>
																<div class="form-group m-form__group row">
																	<div class="col-6">
																		<label for="primary_hover_color">Primary hover color</label>
																		<input type="text" class="form-control m-input jscolor" name="theme_settings[primary_hover_color]" value="<?=$theme_settings['primary_hover_color']?>" id="chosen-value">
																	</div>
																	<div class="col-6">
																		<label for="primary_text_hover_color">Primary text hover color</label>
																		<input type="text" class="form-control m-input jscolor" name="theme_settings[primary_text_hover_color]" value="<?=$theme_settings['primary_text_hover_color']?>">
																	</div>
																</div>
																
																<div class="form-group m-form__group row">
																	<div class="col-6">
																		<label for="secondary_color">Secondary color</label>
																		<input type="text" class="form-control m-input jscolor" name="theme_settings[secondary_color]" value="<?=$theme_settings['secondary_color']?>" id="chosen-value">
																	</div>
																	<div class="col-6">
																		<label for="secondary_text_color">Secondary text color</label>
																		<input type="text" class="form-control m-input jscolor" name="theme_settings[secondary_text_color]" value="<?=$theme_settings['secondary_text_color']?>">
																	</div>
																</div>
																<div class="form-group m-form__group row">
																	<div class="col-6">
																		<label for="secondary_hover_color">Secondary hover color</label>
																		<input type="text" class="form-control m-input jscolor" name="theme_settings[secondary_hover_color]" value="<?=$theme_settings['secondary_hover_color']?>" id="chosen-value">
																	</div>
																	<div class="col-6">
																		<label for="secondary_text_hover_color">Secondary text hover color</label>
																		<input type="text" class="form-control m-input jscolor" name="theme_settings[secondary_text_hover_color]" value="<?=$theme_settings['secondary_text_hover_color']?>">
																	</div>
																</div>
																
																<div class="form-group m-form__group row">
																	<div class="col-6">
																		<label for="tertiary_color">Tertiary color</label>
																		<input type="text" class="form-control m-input jscolor" name="theme_settings[tertiary_color]" value="<?=$theme_settings['tertiary_color']?>" id="chosen-value">
																	</div>
																	<div class="col-6">
																		<label for="tertiary_text_color">Tertiary text color</label>
																		<input type="text" class="form-control m-input jscolor" name="theme_settings[tertiary_text_color]" value="<?=$theme_settings['tertiary_text_color']?>">
																	</div>
																</div>
																<div class="form-group m-form__group row">
																	<div class="col-6">
																		<label for="tertiary_hover_color">Tertiary hover color</label>
																		<input type="text" class="form-control m-input jscolor" name="theme_settings[tertiary_hover_color]" value="<?=$theme_settings['tertiary_hover_color']?>" id="chosen-value">
																	</div>
																	<div class="col-6">
																		<label for="tertiary_text_hover_color">Tertiary text hover color</label>
																		<input type="text" class="form-control m-input jscolor" name="theme_settings[tertiary_text_hover_color]" value="<?=$theme_settings['tertiary_text_hover_color']?>">
																	</div>
																</div>
																
																<h3 class="mt-3">Footer </h3>
																<div class="form-group m-form__group row">
																	<div class="col-4">
																		<label for="footer_background_color">Footer background color</label>
																		<input type="text" class="form-control m-input jscolor" name="theme_settings[footer_background_color]" value="<?=$theme_settings['footer_background_color']?>" id="chosen-value">
																	</div>
																	<div class="col-4">
																		<label for="footer_text_color">Footer text color</label>
																		<input type="text" class="form-control m-input jscolor" name="theme_settings[footer_text_color]" value="<?=$theme_settings['footer_text_color']?>">
																	</div>
																	<div class="col-4">
																		<label for="footer_text_hover_color">Footer text hover color</label>
																		<input type="text" class="form-control m-input jscolor" name="theme_settings[footer_text_hover_color]" value="<?=$theme_settings['footer_text_hover_color']?>">
																	</div>
																</div>
																
																<h3 class="mt-3">Social Items  </h3>
																<div class="form-group m-form__group row">
																	<div class="col-4">
																		<label for="social_icons_background_color">Social icons background color</label>
																		<input type="text" class="form-control m-input jscolor" name="theme_settings[social_icons_background_color]" value="<?=$theme_settings['social_icons_background_color']?>" id="chosen-value">
																	</div>
																	<div class="col-4">
																		<label for="social_icons_background_hover_color">Social Icons background hover color</label>
																		<input type="text" class="form-control m-input jscolor" name="theme_settings[social_icons_background_hover_color]" value="<?=$theme_settings['social_icons_background_hover_color']?>">
																	</div>
																	<div class="col-4">
																		<label for="social_icons_text_color">Social icons text color</label>
																		<input type="text" class="form-control m-input jscolor" name="theme_settings[social_icons_text_color]" value="<?=$theme_settings['social_icons_text_color']?>">
																	</div>
																</div>
																
																
															</div>
														</div>
														<div class="m-portlet__foot m-portlet__foot--fit">
															<div class="m-form__actions m-form__actions">
																<button type="submit" name="general_setting" class="btn btn-primary">
																	Save
																</button>
															</div>
														</div>
														<!--end::Form-->
													</div>
													<!--end::Portlet-->
												</div>
												
												<div class="tab-pane" id="m_tabs_6_11" role="tabpanel">
													<!--begin::Portlet-->
													<div class="m-portlet">
														<div class="m-portlet__head">
															<div class="m-portlet__head-caption">
																<div class="m-portlet__head-title">
																	<span class="m-portlet__head-icon m--hide">
																		<i class="la la-gear"></i>
																	</span>
																	<h3 class="m-portlet__head-text">
																		Model Fields Settings
																	</h3>
																</div>
															</div>
														</div>
														<!--begin::Form-->
														<div class="m-portlet__body">
															<div class="m-form__section m-form__section--first">
																<?php /*?><div class="m-form__group form-group">
																	<label>Text Field</label>
																	<div class="m-radio-inline">
																		<label class="m-radio">
																			<input type="radio" name="other_settings[text_field_of_model_fields]" value="1" <?=($other_settings['text_field_of_model_fields']=='1'||$other_settings['text_field_of_model_fields']==''?'checked="checked"':'')?>>
																			Enable<span></span>
																		</label>
																		<label class="m-radio">
																			<input type="radio" name="other_settings[text_field_of_model_fields]" value="0" <?=($other_settings['text_field_of_model_fields']=='0'?'checked="checked"':'')?>>
																			Disable<span></span>
																		</label>
																	</div>
																</div>

																<div class="m-form__group form-group">
																	<label>Text Area</label>
																	<div class="m-radio-inline">
																		<label class="m-radio">
																			<input type="radio" name="other_settings[text_area_of_model_fields]" value="1" <?=($other_settings['text_area_of_model_fields']=='1'||$other_settings['text_area_of_model_fields']==''?'checked="checked"':'')?>>
																			Enable<span></span>
																		</label>
																		<label class="m-radio">
																			<input type="radio" name="other_settings[text_area_of_model_fields]" value="0" <?=($other_settings['text_area_of_model_fields']=='0'?'checked="checked"':'')?>>
																			Disable<span></span>
																		</label>
																	</div>
																</div>
																
																<div class="m-form__group form-group">
																	<label>Calender/Date</label>
																	<div class="m-radio-inline">
																		<label class="m-radio">
																			<input type="radio" name="other_settings[calendar_of_model_fields]" value="1" <?=($other_settings['calendar_of_model_fields']=='1'||$other_settings['calendar_of_model_fields']==''?'checked="checked"':'')?>>
																			Enable<span></span>
																		</label>
																		<label class="m-radio">
																			<input type="radio" name="other_settings[calendar_of_model_fields]" value="0" <?=($other_settings['calendar_of_model_fields']=='0'?'checked="checked"':'')?>>
																			Disable<span></span>
																		</label>
																	</div>
																</div>
																
																<div class="m-form__group form-group">
																	<label>File Upload</label>
																	<div class="m-radio-inline">
																		<label class="m-radio">
																			<input type="radio" name="other_settings[file_upload_of_model_fields]" value="1" <?=($other_settings['file_upload_of_model_fields']=='1'||$other_settings['file_upload_of_model_fields']==''?'checked="checked"':'')?>>
																			Enable<span></span>
																		</label>
																		<label class="m-radio">
																			<input type="radio" name="other_settings[file_upload_of_model_fields]" value="0" <?=($other_settings['file_upload_of_model_fields']=='0'?'checked="checked"':'')?>>
																			Disable<span></span>
																		</label>
																	</div>
																</div><?php */?>
																
																<div class="m-form__group form-group">
																	<label>Tooltips</label>
																	<div class="m-radio-inline">
																		<label class="m-radio">
																			<input type="radio" name="other_settings[tooltips_of_model_fields]" value="1" <?=($other_settings['tooltips_of_model_fields']=='1'||$other_settings['tooltips_of_model_fields']==''?'checked="checked"':'')?>>
																			Enable<span></span>
																		</label>
																		<label class="m-radio">
																			<input type="radio" name="other_settings[tooltips_of_model_fields]" value="0" <?=($other_settings['tooltips_of_model_fields']=='0'?'checked="checked"':'')?>>
																			Disable<span></span>
																		</label>
																	</div>
																</div>
																
																<div class="m-form__group form-group">
																	<label>Icons</label>
																	<div class="m-radio-inline">
																		<label class="m-radio">
																			<input type="radio" name="other_settings[icons_of_model_fields]" value="1" <?=($other_settings['icons_of_model_fields']=='1'||$other_settings['icons_of_model_fields']==''?'checked="checked"':'')?>>
																			Enable<span></span>
																		</label>
																		<label class="m-radio">
																			<input type="radio" name="other_settings[icons_of_model_fields]" value="0" <?=($other_settings['icons_of_model_fields']=='0'?'checked="checked"':'')?>>
																			Disable<span></span>
																		</label>
																	</div>
																</div>
																
															</div>
														</div>
														<div class="m-portlet__foot m-portlet__foot--fit">
															<div class="m-form__actions m-form__actions">
																<button type="submit" name="general_setting" class="btn btn-primary">
																	Save
																</button>
															</div>
														</div>
														<!--end::Form-->
													</div>
													<!--end::Portlet-->
												</div>
												
												<div class="tab-pane" id="app_crons_tab" role="tabpanel">
													<!--begin::Portlet-->
													<div class="m-portlet">
														<div class="m-portlet__head">
															<div class="m-portlet__head-caption">
																<div class="m-portlet__head-title">
																	<span class="m-portlet__head-icon m--hide">
																		<i class="la la-gear"></i>
																	</span>
																	<h3 class="m-portlet__head-text">
																		Crons Settings
																	</h3>
																</div>
															</div>
														</div>
														<!--begin::Form-->
														<div class="m-portlet__body">
															<div class="m-form__section m-form__section--first">
																<div class="form-group m-form__group">
																	<div class="col-12">
																		<label>Order expired cron need to set on your server. Click to copy URL</label>
																		<input type="text" class="form-control m-input" value="wget -q -O - <?=SITE_URL.'cron/order_expired.php'?> >/dev/null 2>&1" readonly>
																		<strong>OR</strong>
																		<input type="text" class="form-control m-input" value="<?='/usr/local/bin/php '.CP_ROOT_PATH.'/cron/order_expired.php'?>" readonly>
																	</div>
																</div>
															</div>
														</div>
														<div class="m-portlet__foot m-portlet__foot--fit">
															<div class="m-form__actions m-form__actions">
																<button type="submit" name="general_setting" class="btn btn-primary">
																	Save
																</button>
															</div>
														</div>
														<!--end::Form-->
													</div>
													<!--end::Portlet-->
												</div>
												
												<div class="tab-pane" id="m_tabs_6_12" role="tabpanel">
													<!--begin::Portlet-->
													<div class="m-portlet">
														<div class="m-portlet__head">
															<div class="m-portlet__head-caption">
																<div class="m-portlet__head-title">
																	<span class="m-portlet__head-icon m--hide">
																		<i class="la la-gear"></i>
																	</span>
																	<h3 class="m-portlet__head-text">
																		Menu Type Settings
																	</h3>
																</div>
															</div>
														</div>
														<!--begin::Form-->
														<div class="m-portlet__body">
															<div class="m-form__section m-form__section--first">
																<?php /*?><div class="form-group m-form__group">
																	<div class="col-lg-6">
																		<label for="published">Top Right Menu:</label>
																		<div>
																			<span class="m-switch m-switch--icon m-switch--primary">
																				<label>
																					<input type="checkbox" name="other_settings[top_right_menu]" value="1" <?=($other_settings['top_right_menu']=='1'?'checked="checked"':'')?>>
																					<span></span>
																				</label>
																			</span>
																		</div>
																	</div>
																</div><?php */?>
																<div class="form-group m-form__group">
																	<div class="col-lg-6">
																		<label for="published">Header Menu:</label>
																		<div>
																			<span class="m-switch m-switch--icon m-switch--primary">
																				<label>
																					<input type="checkbox" name="other_settings[header_menu]" value="1" <?=($other_settings['header_menu']=='1'?'checked="checked"':'')?>>
																					<span></span>
																				</label>
																			</span>
																		</div>
																	</div>
																</div>
																<div class="form-group m-form__group">
																	<div class="col-lg-6">
																		<label for="published">Footer Menu Column 1:</label>
																		<div>
																			<span class="m-switch m-switch--icon m-switch--primary">
																				<label>
																					<input type="checkbox" name="other_settings[footer_menu_column1]" value="1" <?=($other_settings['footer_menu_column1']=='1'?'checked="checked"':'')?>>
																					<span></span>
																				</label>
																			</span>
																		</div>
																	</div>
																	<div class="col-lg-6">
																		<input type="text" class="form-control m-input m-input--square" name="other_settings[footer_menu_column1_title]" value="<?=_dt_parse($other_settings['footer_menu_column1_title'])?>" placeholder="Enter menu title">
																	</div>
																</div>
																<div class="form-group m-form__group">
																	<div class="col-lg-6">
																		<label for="published">Footer Menu Column 2:</label>
																		<div>
																			<span class="m-switch m-switch--icon m-switch--primary">
																				<label>
																					<input type="checkbox" name="other_settings[footer_menu_column2]" value="1" <?=($other_settings['footer_menu_column2']=='1'?'checked="checked"':'')?>>
																					<span></span>
																				</label>
																			</span>
																		</div>
																	</div>
																	<div class="col-lg-6">
																		<input type="text" class="form-control m-input m-input--square" name="other_settings[footer_menu_column2_title]" value="<?=_dt_parse($other_settings['footer_menu_column2_title'])?>" placeholder="Enter menu title">
																	</div>
																</div>
																<?php /*?><div class="form-group m-form__group">
																	<div class="col-lg-6">
																		<label for="published">Footer Menu Column3:</label>
																		<div>
																			<span class="m-switch m-switch--icon m-switch--primary">
																				<label>
																					<input type="checkbox" name="other_settings[footer_menu_column3]" value="1" <?=($other_settings['footer_menu_column3']=='1'?'checked="checked"':'')?>>
																					<span></span>
																				</label>
																			</span>
																		</div>
																	</div>
																	<div class="col-lg-6">
																		<input type="text" class="form-control m-input m-input--square" name="other_settings[footer_menu_column3_title]" value="<?=_dt_parse($other_settings['footer_menu_column3_title'])?>" placeholder="Enter menu title">
																	</div>
																</div>
																<div class="form-group m-form__group">
																	<div class="col-lg-6">
																		<label for="published">Copyright Menu:</label>
																		<div>
																			<span class="m-switch m-switch--icon m-switch--primary">
																				<label>
																					<input type="checkbox" name="other_settings[copyright_menu]" value="1" <?=($other_settings['copyright_menu']=='1'?'checked="checked"':'')?>>
																					<span></span>
																				</label>
																			</span>
																		</div>
																	</div>
																</div><?php */?>
															</div>
														</div>
														<div class="m-portlet__foot m-portlet__foot--fit">
															<div class="m-form__actions m-form__actions">
																<button type="submit" name="general_setting" class="btn btn-primary">
																	Save
																</button>
															</div>
														</div>
														<!--end::Form-->
													</div>
													<!--end::Portlet-->
												</div>
												
												<div class="tab-pane" id="m_tabs_success_page" role="tabpanel">
													<!--begin::Portlet-->
													<div class="m-portlet">
														<div class="m-portlet__head">
															<div class="m-portlet__head-caption">
																<div class="m-portlet__head-title">
																	<span class="m-portlet__head-icon m--hide">
																	  <i class="la la-gear"></i>
																	</span>
																	<h3 class="m-portlet__head-text">
																	  Order Complete Page Settings
																	</h3>
																</div>
															</div>
														</div>
														<!--begin::Form-->
														<div class="m-portlet__body">
															<div class="m-form__section m-form__section--first">
															
																<div class="m-form__group form-group">
																	<label>
																		Show Customer
																	</label>
																	<div class="m-checkbox-inline">
																		<label class="m-checkbox">
																			<input type="checkbox" name="other_settings[show_cust_delivery_note]" value="1" <?=($other_settings['show_cust_delivery_note']=='1'?'checked="checked"':'')?>> Delivery Note
																			<span></span>
																		</label>
																		<label class="m-checkbox">
																			<input type="checkbox" name="other_settings[show_cust_order_form]" value="1" <?=($other_settings['show_cust_order_form']=='1'?'checked="checked"':'')?>> Packing Slip
																			<span></span>
																		</label>
																		<label class="m-checkbox">
																			<input type="checkbox" name="other_settings[show_cust_sales_confirmation]" value="1" <?=($other_settings['show_cust_sales_confirmation']=='1'?'checked="checked"':'')?>> Receipt
																			<span></span>
																		</label>
																	</div>
																</div>
																
																<div class="m-separator m-separator--dash m-separator--sm"></div>
																<div class="form-group m-form__group">
																	<label>Receipt PDF Content </label>
																	<div class="input-group">
																	<select class="form-control" name="constant_name" id="constant_name">
																	 <option value="">Select Constant to Copy</option>
																	 <?php
																	 $constants_array = array('{$logo_path}', '{$logo}', '{$admin_logo}', '{$admin_email}', '{$admin_username}', '{$admin_site_url}', '{$admin_panel_name}', '{$from_name}', '{$from_email}', '{$site_name}', '{$site_url}', '{$customer_fname}', '{$customer_lname}', '{$customer_fullname}', '{$customer_phone}', '{$customer_email}', '{$billing_address1}', '{$billing_address2}', '{$billing_city}', '{$billing_state}', '{$customer_country}', '{$billing_postcode}', '{$order_id}', '{$order_payment_method}', '{$order_date}', '{$order_approved_date}', '{$order_expire_date}', '{$order_status}', '{$order_sales_pack}', '{$current_date_time}', '{$order_item_list}', '{$order_instruction}', '{$company_name}', '{$company_address}', '{$company_city}', '{$company_state}', '{$company_postcode}', '{$company_country}', '{$shipping_fname}', '{$shipping_lname}', '{$shipping_company_name}', '{$shipping_address1}', '{$shipping_address2}', '{$shipping_city}', '{$shipping_state}', '{$shipping_postcode}', '{$shipping_phone}', '{$order_expiring_days}', '{$order_expired_days}', '{$company_email}', '{$company_phone}');
																	 foreach($constants_array as $constants_value) { ?>
																		<option value="<?=$constants_value?>"><?=$constants_value?></option>
																	 <?php
																	 } ?>
																	</select>
																	<input type="button" class="btn btn-brand m-btn m-btn--custom m-btn--icon m-btn--air btn-sm float-right ml-2" id="copy-constant" style="cursor:pointer;" value="COPY">
																  </div>
																</div>
																<div class="m-form__group form-group">
																	<textarea class="form-control m-input summernote" name="sales_confirmation_pdf_content" rows="8"><?=$general_setting_data['sales_confirmation_pdf_content']?></textarea>
																</div>
																
																<?php /*?><div class="m-separator m-separator--dash m-separator--sm"></div>
																<div class="m-form__group form-group">
																	<label>Heading</label>
																	<input type="text" class="form-control m-input" name="success_page_content[heading]" value="<?=$success_page_content['heading']?>">
																</div>
																<div class="m-form__group form-group">
																	<label>Sub Heading - ${order_id}</label>
																	<input type="text" class="form-control m-input" name="success_page_content[sub_heading]" value="<?=$success_page_content['sub_heading']?>">
																</div>
																<div class="m-form__group form-group">
																	<label>Intro Text</label>
																	<textarea class="form-control m-input" name="success_page_content[intro_text]" rows="5"><?=$success_page_content['intro_text']?></textarea>
																</div>
																
																<div class="m-separator m-separator--dash m-separator--sm"></div>
																<div class="m-form__group form-group">
																	<label>Step Heading</label>
																	<input type="text" class="form-control m-input" name="success_page_content[step_heading]" value="<?=$success_page_content['step_heading']?>">
																</div>
																<div class="m-form__group form-group">
																	<label>Step Sub Heading</label>
																	<input type="text" class="form-control m-input" name="success_page_content[step_sub_heading]" value="<?=$success_page_content['step_sub_heading']?>">
																</div>
																
																<div class="m-form__group form-group">
																	<label>Step1 Title</label>
																	<input type="text" class="form-control m-input" name="success_page_content[step1_title]" value="<?=$success_page_content['step1_title']?>">
																</div>
																<div class="m-form__group form-group">
																	<label>Step1 Instruction</label>
																	<textarea class="form-control m-input" name="success_page_content[step1_instruction]" rows="5"><?=$success_page_content['step1_instruction']?></textarea>
																</div>
																
																<div class="m-form__group form-group">
																	<label>Step2 Title</label>
																	<input type="text" class="form-control m-input" name="success_page_content[step2_title]" value="<?=$success_page_content['step2_title']?>">
																</div>
																<div class="m-form__group form-group">
																	<label>Step2 Instruction</label>
																	<textarea class="form-control m-input" name="success_page_content[step2_instruction]" rows="5"><?=$success_page_content['step2_instruction']?></textarea>
																</div>
																
																<div class="m-form__group form-group">
																	<label>Step3 Title</label>
																	<input type="text" class="form-control m-input" name="success_page_content[step3_title]" value="<?=$success_page_content['step3_title']?>">
																</div>
																<div class="m-form__group form-group">
																	<label>Step3 Instruction - ${download_pdf_lebal_link}</label>
																	<textarea class="form-control m-input" name="success_page_content[step3_instruction]" rows="5"><?=$success_page_content['step3_instruction']?></textarea>
																</div><?php */?>
																
															</div>
														</div>
														<div class="m-portlet__foot m-portlet__foot--fit">
															<div class="m-form__actions m-form__actions">
																<button type="submit" name="general_setting" class="btn btn-primary">
																  Save
																</button>
															</div>
														</div>
														<!--end::Form-->
													</div>
													<!--end::Portlet-->
												  </div>
												  
												<div class="tab-pane" id="app_settings_tab" role="tabpanel">
													<!--begin::Portlet-->
													<div class="m-portlet">
														<div class="m-portlet__head">
															<div class="m-portlet__head-caption">
																<div class="m-portlet__head-title">
																	<span class="m-portlet__head-icon m--hide">
																		<i class="la la-gear"></i>
																	</span>
																	<h3 class="m-portlet__head-text">
																		App Settings
																	</h3>
																</div>
															</div>
														</div>
														<!--begin::Form-->
														<div class="m-portlet__body">
															<div class="m-form__section m-form__section--first">
																
																<div class="m-form__group form-group">
																	<label for="published">
																		App Side Bar Menu Option
																	</label>
																	<div class="m-checkbox-inline">
																		<label class="m-checkbox">
																			<input type="checkbox" name="other_settings[is_show_reviews_side_bar_menu]" value="1" <?=($other_settings['is_show_reviews_side_bar_menu']=='1'?'checked="checked"':'')?>>
																			Reviews
																			<span></span>
																		</label>
																		
																		<label class="m-checkbox">
																			<input type="checkbox" name="other_settings[is_show_write_review_side_bar_menu]" value="1" <?=($other_settings['is_show_write_review_side_bar_menu']=='1'?'checked="checked"':'')?>>
																			Write Review
																			<span></span>
																		</label>
																		
																		<label class="m-checkbox">
																			<input type="checkbox" name="other_settings[is_show_contact_us_side_bar_menu]" value="1" <?=($other_settings['is_show_contact_us_side_bar_menu']=='1'?'checked="checked"':'')?>>
																			Contact Us
																			<span></span>
																		</label>
																		
																		<label class="m-checkbox">
																			<input type="checkbox" name="other_settings[is_show_email_us_side_bar_menu]" value="1" <?=($other_settings['is_show_email_us_side_bar_menu']=='1'?'checked="checked"':'')?>>
																			Email Us
																			<span></span>
																		</label>
																		
																		<label class="m-checkbox">
																			<input type="checkbox" name="other_settings[is_show_terms_condition_side_bar_menu]" value="1" <?=($other_settings['is_show_terms_condition_side_bar_menu']=='1'?'checked="checked"':'')?>>
																			Terms and conditions
																			<span></span>
																		</label>
																		
																		<label class="m-checkbox">
																			<input type="checkbox" name="other_settings[is_show_privacy_side_bar_menu]" value="1" <?=($other_settings['is_show_privacy_side_bar_menu']=='1'?'checked="checked"':'')?>>
																			Privacy Policy
																			<span></span>
																		</label>
																		
																		<label class="m-checkbox">
																			<input type="checkbox" name="other_settings[is_show_track_order_side_bar_menu]" value="1" <?=($other_settings['is_show_track_order_side_bar_menu']=='1'?'checked="checked"':'')?>>
																			Track Order
																			<span></span>
																		</label>
																		
																		<label class="m-checkbox">
																			<input type="checkbox" name="other_settings[is_show_faq_side_bar_menu]" value="1" <?=($other_settings['is_show_faq_side_bar_menu']=='1'?'checked="checked"':'')?>>
																			Faq List 
																			<span></span>
																		</label>
																		
																		<label class="m-checkbox">
																			<input type="checkbox" name="other_settings[is_show_faq_grp]" value="1" <?=($other_settings['is_show_faq_grp']=='1'?'checked="checked"':'')?>>
																			Show Faq Group
																			<span></span>
																		</label>
																		
																	</div>
																</div>
																
																<div class="m-separator m-separator--dash m-separator--sm"></div>
																<div class="m-form__group form-group">
																	<label for="published">
																		App Bottom Bar Menu Option
																	</label>
																	<div class="m-checkbox-inline">
																		<label class="m-checkbox">
																			<input type="checkbox" name="other_settings[is_show_sell_by_category_bottom_menu]" value="1" <?=($other_settings['is_show_sell_by_category_bottom_menu']=='1'?'checked="checked"':'')?>>
																			Sell By Category
																			<span></span>
																		</label>
																		
																		<label class="m-checkbox">
																			<input type="checkbox" name="other_settings[is_show_sell_by_brand_bottom_menu]" value="1" <?=($other_settings['is_show_sell_by_brand_bottom_menu']=='1'?'checked="checked"':'')?>>
																			Sell By Brand
																			<span></span>
																		</label>
																		
																		<label class="m-checkbox">
																			<input type="checkbox" name="other_settings[is_show_sell_by_devices_bottom_menu]" value="1" <?=($other_settings['is_show_sell_by_devices_bottom_menu']=='1'?'checked="checked"':'')?>>
																			Sell By Devices
																			<span></span>
																		</label>
																		
																		<label class="m-checkbox">
																			<input type="checkbox" name="other_settings[is_show_search_bottom_menu]" value="1" <?=($other_settings['is_show_search_bottom_menu']=='1'?'checked="checked"':'')?>>
																			Search
																			<span></span>
																		</label>
																		
																	</div>
																</div>
															</div>
														</div>
														<div class="m-portlet__foot m-portlet__foot--fit">
															<div class="m-form__actions m-form__actions">
																<button type="submit" name="general_setting" class="btn btn-primary">
																	Save
																</button>
															</div>
														</div>
														<!--end::Form-->
													</div>
													<!--end::Portlet-->
												</div>
			                				</div>
										</div>
	                				</div>
	              				</div>
							</form>
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