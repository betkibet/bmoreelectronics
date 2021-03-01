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
							<div class="m-portlet__head">
								<div class="m-portlet__head-caption">
									<div class="m-portlet__head-title">
										<span class="m-portlet__head-icon m--hide">
										  <i class="la la-gear"></i>
										</span>
										<h3 class="m-portlet__head-text">
										  <?=($id?'Edit Contractor':'Add Contractor')?>
										</h3>
									</div>
								</div>
							</div>
							<!--begin::Form-->
							<form class="m-form" action="controllers/contractor.php" role="form" method="post" onSubmit="return check_form(this);" enctype="multipart/form-data">
								<div class="m-portlet__body">
									<div class="m-form__section m-form__section--first">
										<h5 class="m-portlet__head-text">
										  Contractor Details
										</h5>
										<div class="form-group m-form__group row">
											<div class="col-lg-4">
												<label for="name">
													Name
												</label>
												<input type="text" class="form-control m-input" id="name" value="<?=$contractor_data['name']?>" name="name">
											</div>
											<div class="col-lg-4">
												<label for="company_name">
													Company Name
												</label>
												<input type="text" class="form-control m-input" id="company_name" value="<?=$contractor_data['company_name']?>" name="company_name">
											</div>
											<div class="col-lg-4">
												<label for="email">
													Email
												</label>
												<input type="email" class="form-control m-input" id="email" value="<?=$contractor_data['email']?>" name="email">
											</div>
										</div>
										
										<div class="form-group m-form__group row">
											<div class="col-lg-6">
												<label for="cell_phone">Phone</label>
												<input type="tel" id="cell_phone" name="cell_phone" class="form-control m-input" placeholder="">
												<input type="hidden" name="phone_c_code" id="phone_c_code" />
											
												<span id="valid-msg" class="hide">✓ Valid</span>
												<span id="error-msg" class="hide">Invalid number</span>
											</div>
											<div class="col-lg-6">
												<label for="password">
													Password
												</label>
												<input type="password" class="form-control m-input" id="password" name="password">
											</div>
										</div>
										
										<div class="form-group m-form__group row">
											<div class="col-lg-6">
												<label for="address">
													Address Line 1
												</label>
												<textarea class="form-control m-input" id="address" name="address" rows="4"><?=$contractor_data['address']?></textarea>
											</div>
											<div class="col-lg-6">
												<label for="address2">
													Address Line 2
												</label>
												<textarea class="form-control m-input" id="address2" name="address2" rows="4"><?=$contractor_data['address2']?></textarea>
											</div>
										</div>
										<div class="form-group m-form__group row">
											<div class="col-lg-3">
												<label for="country">Country</label>
												<select name="country" id="country" class="form-control m-input">
													<option value=""> - Country - </option>
													<?php
													foreach($countries_list as $c_k => $c_v) { ?>
														<option value="<?=$c_v?>" <?php if($contractor_data['country'] == $c_v){echo 'selected="selected"';}?>><?=$c_v?></option>
													<?php
													} ?>
												</select>
											</div>
											<div class="col-lg-3">
												<label for="state">
													State
												</label>
												<input type="text" class="form-control m-input" id="state" value="<?=$contractor_data['state']?>" name="state">
											</div>
											<div class="col-lg-3">
												<label for="city">
													City
												</label>
												<input type="text" class="form-control m-input" id="city" value="<?=$contractor_data['city']?>" name="city">
											</div>
											<div class="col-lg-3">
												<label for="postcode">
													Post Code
												</label>
												<input type="text" class="form-control m-input" id="zip_code" value="<?=$contractor_data['zip_code']?>" name="zip_code">
											</div>
										</div>
										
										<h4 class="mt-4">Permissions</h4>
										<div class="form-group m-form__group">
											<label>Orders</label>
											<div class="controls">
												<?php /*?><label class="m-checkbox">
													<input type="checkbox" value="1" name="permissions[order_view]" <?php if($permissions_array['order_view']=='1'){echo 'checked="checked"';}?>>
													View <span></span>
												</label><?php */?>
												<label class="m-checkbox">
													<input type="checkbox" value="1" name="permissions[order_add]" <?php if(isset($permissions_array['order_add']) && $permissions_array['order_add']=='1'){echo 'checked="checked"';}?>>
													Add Order <span></span>
												</label>
												<?php /*?><label class="m-checkbox ml-4">
													<input type="checkbox" value="1" name="permissions[order_edit]" <?php if(isset($permissions_array['order_edit']) && $permissions_array['order_edit']=='1'){echo 'checked="checked"';}?>>
													Edit Order <span></span>
												</label><?php */?>
												<label class="m-checkbox ml-4">
													<input type="checkbox" value="1" name="permissions[order_delete]" <?php if(isset($permissions_array['order_delete']) && $permissions_array['order_delete']=='1'){echo 'checked="checked"';}?>>
													Delete Order <span></span>
												</label>
												<label class="m-checkbox ml-4">
													<input type="checkbox" value="1" name="permissions[order_edit_price]" <?php if(isset($permissions_array['order_edit_price']) && $permissions_array['order_edit_price']=='1'){echo 'checked="checked"';}?>>
													Edit Price <span></span>
												</label>
												<label class="m-checkbox ml-4">
													<input type="checkbox" value="1" name="permissions[order_add_item]" <?php if(isset($permissions_array['order_add_item']) && $permissions_array['order_add_item']=='1'){echo 'checked="checked"';}?>>
													Add Item <span></span>
												</label>
											</div>
											<div class="controls">
												<label class="m-checkbox">
													<input type="checkbox" value="1" name="permissions[order_edit_item]" <?php if(isset($permissions_array['order_edit_item']) && $permissions_array['order_edit_item']=='1'){echo 'checked="checked"';}?>>
													Edit Item <span></span>
												</label>
												<label class="m-checkbox ml-4">
													<input type="checkbox" value="1" name="permissions[order_delete_item]" <?php if(isset($permissions_array['order_delete_item']) && $permissions_array['order_delete_item']=='1'){echo 'checked="checked"';}?>>
													Delete Item <span></span>
												</label>
												<label class="m-checkbox ml-4">
													<input type="checkbox" value="1" name="permissions[order_edit_shipping_label]" <?php if(isset($permissions_array['order_edit_shipping_label']) && $permissions_array['order_edit_shipping_label']=='1'){echo 'checked="checked"';}?>>
													Edit Shipping Label <span></span>
												</label>
											</div>
										<!--</div>
										<div class="form-group m-form__group">-->
											<label class="mt-2">Customers</label>
											<div class="controls">
												<label class="m-checkbox">
													<input type="checkbox" value="1" name="permissions[customer_view]" <?php if(isset($permissions_array['order_add']) && $permissions_array['order_add']=='1'){echo 'checked="checked" disabled="disabled"';} elseif(isset($permissions_array['customer_view']) && $permissions_array['customer_view']=='1'){echo 'checked="checked"';}?>>
													View <span></span>
												</label>
												<label class="m-checkbox ml-4">
													<input type="checkbox" value="1" name="permissions[customer_add]" <?php /*if(isset($permissions_array['order_add']) && $permissions_array['order_add']=='1'){echo 'checked="checked" disabled="disabled"';} else*/if(isset($permissions_array['customer_add']) && $permissions_array['customer_add']=='1'){echo 'checked="checked"';}?>>
													Add <span></span>
												</label>
												<label class="m-checkbox ml-4">
													<input type="checkbox" value="1" name="permissions[customer_edit]" <?php /*if(isset($permissions_array['order_add']) && $permissions_array['order_add']=='1'){echo 'checked="checked" disabled="disabled"';} else*/if(isset($permissions_array['customer_edit']) && $permissions_array['customer_edit']=='1'){echo 'checked="checked"';}?>>
													Edit <span></span>
												</label>
												<label class="m-checkbox ml-4">
													<input type="checkbox" value="1" name="permissions[customer_delete]" <?php if(isset($permissions_array['customer_delete']) && $permissions_array['customer_delete']=='1'){echo 'checked="checked"';}?>>
													Delete <span></span>
												</label>
											</div>
										</div>
										
										<div class="m-form__group form-group">
											<label>
												Publish :
											</label>
											<div class="m-radio-inline">
												<label class="m-radio">
													<input type="radio" name="status" value="1" <?php if(!$id){echo 'checked="checked"';}?> <?=($contractor_data['status']==1?'checked="checked"':'')?>>
													Active
													<span></span>
												</label>
												<label class="m-radio">
													<input type="radio" name="status" value="0" <?=($contractor_data['status']=='0'?'checked="checked"':'')?>>
													Inactive
													<span></span>
												</label>
											</div>
										</div>
									</div>
								</div>
								<div class="m-portlet__foot m-portlet__foot--fit">
									<div class="m-form__actions m-form__actions">
										<button type="submit" name="update" class="btn btn-primary">
										  <?=($id?'Update':'Save')?>
										</button>
										<a href="contractors.php" class="btn btn-secondary">Back</a>
									</div>
								</div>
								<input type="hidden" name="id" value="<?=$contractor_data['id']?>" />
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

<script src="../js/intlTelInput.js"></script>
<script>
  var telInput = $("#cell_phone"),
    errorMsg = $("#error-msg"),
    validMsg = $("#valid-msg");
  telInput.intlTelInput({
    initialCountry: "<?=$phone_country_short_code?>",
	allowDropdown: false,
    geoIpLookup: function(callback) {
      $.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
        var countryCode = (resp && resp.country) ? resp.country : "";
        callback(countryCode);
      });
    },
    utilsScript: "../js/intlTelInput-utils.js" //just for formatting/placeholders etc
  });

  var reset = function() {
    telInput.removeClass("error");
    errorMsg.addClass("hide");
    validMsg.addClass("hide");
  };

  // on blur: validate
  telInput.blur(function() {
    reset();
    if ($.trim(telInput.val())) {
      if (telInput.intlTelInput("isValidNumber")) {
        validMsg.removeClass("hide");
      } else {
        telInput.addClass("error");
        errorMsg.removeClass("hide");
      }
    }
  });

  $("#cell_phone").intlTelInput("setNumber", "<?=($contractor_data['phone']?'+'.$contractor_data['country_code'].$contractor_data['phone']:'')?>");

	$("input[name='permissions[order_add]']").change(function() {
		if($(this).prop('checked')) {
			$("input[name='permissions[customer_view]']").prop("checked",true);
			$("input[name='permissions[customer_view]']").attr('disabled','disabled');
			
			//$("input[name='permissions[customer_add]']").prop("checked",true);
			//$("input[name='permissions[customer_add]']").attr('disabled','disabled');
			
			//$("input[name='permissions[customer_edit]']").prop("checked",true);
			//$("input[name='permissions[customer_edit]']").attr('disabled','disabled');
		} else {
			$("input[name='permissions[customer_view]']").removeAttr('disabled');
			//$("input[name='permissions[customer_add]']").removeAttr('disabled');
			//$("input[name='permissions[customer_edit]']").removeAttr('disabled');
		}
	});
	
  function check_form(a) {
    if(a.name.value.trim() == "") {
      alert('Please enter name');
      a.name.focus();
      a.name.value = '';
      return false;
    }
	/*if(a.company_name.value.trim()==""){
		alert('Please enter company name');
		a.company_name.focus();
		a.company_name.value='';
		return false;
	}*/
	if(a.email.value.trim() == "") {
      alert('Please enter email');
      a.email.focus();
      a.email.value = '';
      return false;
    }
	
    var telInput = $("#cell_phone");
    //$("#phone").val(telInput.intlTelInput("getNumber"));
	$("#phone_c_code").val(telInput.intlTelInput("getSelectedCountryData").dialCode);
    if(a.cell_phone.value.trim() == "") {
      alert('Please enter phone number');
      return false;
    }
    if(!telInput.intlTelInput("isValidNumber")) {
      alert('Please enter valid phone number');
      return false;
    }
	
	<?php
	if($contractor_data['password'] == "") { ?>
	if(a.password.value.trim() == "") {
      alert('Please enter password');
      a.password.focus();
      a.password.value = '';
      return false;
    }
	<?php
	} ?>
	
    /*if(a.address.value.trim() == "") {
      alert('Please enter address line1');
      a.address.focus();
      a.address.value = '';
      return false;
    }
	 if(a.state.value.trim() == "") {
      alert('Please enter state');
      a.state.focus();
      a.state.value = '';
      return false;
    }
    if(a.city.value.trim() == "") {
      alert('Please enter city');
      a.city.focus();
      a.city.value = '';
      return false;
    }
    if(a.zip_code.value.trim() == "") {
      alert('Please enter zip code');
      a.zip_code.focus();
      a.zip_code.value = '';
      return false;
    }*/

  }
</script>
