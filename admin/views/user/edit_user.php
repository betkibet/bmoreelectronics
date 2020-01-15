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
					<div class="col-lg-8">
						<!--begin::Portlet-->
						<div class="m-portlet">
							<div class="m-portlet__head">
								<div class="m-portlet__head-caption">
									<div class="m-portlet__head-title">
										<span class="m-portlet__head-icon m--hide">
										  <i class="la la-gear"></i>
										</span>
										<h3 class="m-portlet__head-text">
										  <?=($id?'Edit Customer':'Add Customer')?>
										</h3>
									</div>
								</div>
							</div>
							<!--begin::Form-->
							<form class="m-form" action="controllers/user.php" role="form" method="post" onSubmit="return check_form(this);" enctype="multipart/form-data">
								<div class="m-portlet__body">
									<div class="m-form__section m-form__section--first">
										<h5 class="m-portlet__head-text">
										  Customer Details
										</h5>
										<div class="form-group m-form__group">
											<label for="field-1">
												First Name
                      						</label>
											<input type="text" class="form-control m-input" id="first_name" value="<?=$user_data['first_name']?>" name="first_name">
											<!-- <span class="m-form__help">
												Please enter your username
											</span> -->
										</div>
										<div class="form-group m-form__group">
											<label for="field-1">
												Last Name
											</label>
											<input type="text" class="form-control m-input" id="last_name" value="<?=$user_data['last_name']?>" name="last_name">
										</div>
										<div class="form-group m-form__group">
											<label for="field-1">
												Company Name
											</label>
											<input type="text" class="form-control m-input" id="company_name" value="<?=$user_data['company_name']?>" name="company_name">
										</div>
										<div class="form-group m-form__group">
											<label for="field-1">
												Birth Date
											</label>
											<input type="date" class="form-control m-input" id="birth_date" value="<?=$user_data['birth_date']?>" name="birth_date">
										</div>
										<div class="form-group m-form__group">
											<label for="field-1">
												Vat Number
											</label>
											<input type="text" class="form-control m-input" id="vat_number" value="<?=$user_data['vat_number']?>" name="vat_number">
										</div>
										<div class="form-group m-form__group">
											<label for="field-1">Phone</label>
											<input type="tel" id="cell_phone" name="cell_phone" class="form-control m-input" placeholder="">
											<?php /*?><input type="tel" id="phone" name="phone" class="form-control m-input" placeholder="" value="<?=$user_data['phone']?>"><?php */?>
											<input type="hidden" name="phone" id="phone" />
											<span id="valid-msg" class="hide">✓ Valid</span>
											<span id="error-msg" class="hide">Invalid number</span>
										</div>
										<div class="form-group m-form__group">
											<label for="field-1">
												Other Phone
											  </label>
												
												   <?php /*?><input type="tel" id="cell_phone" name="cell_phone" class="form-control m-input" placeholder=""> <?php */?>
												   <input type="tel" id="other_phone" name="other_phone" class="form-control m-input" placeholder="" value="<?=$user_data['other_phone']?>"> 
												 <?php /*?> <input type="hidden" name="phone" id="phone" />
												  <span id="valid-msg" class="hide">✓ Valid</span>
												  <span id="error-msg" class="hide">Invalid number</span><?php */?>
												
											  </div>
										<div class="form-group m-form__group">
											<label for="field-1">
												Email
											</label>
											<input type="email" class="form-control m-input" id="email" value="<?=$user_data['email']?>" name="email">
										</div>
										<div class="form-group m-form__group">
											<label for="field-1">
												Password
											</label>
											<input type="password" class="form-control m-input" id="password" name="password">
										</div>
										<h5 class="m-portlet__head-text">
										  Customer Details
										</h5>
										<div class="form-group m-form__group">
											<label for="exampleTextarea">
												Address Line1
											</label>
											<textarea class="form-control m-input" id="address" name="address" rows="5"><?=$user_data['address']?></textarea>
										</div>
										<div class="form-group m-form__group">
											<label for="exampleTextarea">
												Address Line2
											</label>
											<textarea class="form-control m-input" id="address2" name="address2" rows="5"><?=$user_data['address2']?></textarea>
										</div>
										<div class="form-group m-form__group">
											<label for="field-1">
												City
											</label>
											<input type="text" class="form-control m-input" id="city" value="<?=$user_data['city']?>" name="city">
										</div>
										<div class="form-group m-form__group">
											<label for="field-1">
												State
											</label>
											<input type="text" class="form-control m-input" id="state" value="<?=$user_data['state']?>" name="state">
										</div>
										<div class="form-group m-form__group">
											<label for="field-1">
												Post Code
											</label>
											<input type="text" class="form-control m-input" id="postcode" value="<?=$user_data['postcode']?>" name="postcode">
										</div>
										<div class="m-form__group form-group">
											<label for="">
												Publish :
											</label>
											<div class="m-radio-inline">
												<label class="m-radio">
													<input type="radio" id="status" name="status" value="1" <?php if(!$id){echo 'checked="checked"';}?> <?=($user_data['status']==1?'checked="checked"':'')?>>
													Active
													<span></span>
												</label>
												<label class="m-radio">
													<input type="radio"  id="status" name="status" value="0" <?=($user_data['status']=='0'?'checked="checked"':'')?>>
													Inactive
													<span></span>
												</label>
											</div>
										</div>
									</div>
								</div>
								<input type="hidden" name="id" value="<?=$brand_data['id']?>" />
								<div class="m-portlet__foot m-portlet__foot--fit">
									<div class="m-form__actions m-form__actions">
										<button type="submit" name="update" class="btn btn-primary">
										  <?=($id?'Update':'Save')?>
										</button>
										<a href="users.php" class="btn btn-secondary">Back</a>
									</div>
								</div>
								<input type="hidden" name="id" value="<?=$user_data['id']?>" />
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
    initialCountry: "auto",
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

  // on keyup / change flag: reset
  //telInput.on("keyup change", reset);

  $("#cell_phone").intlTelInput("setNumber", "<?=($user_data['phone']?'+'.$user_data['phone']:'')?>");

  function check_form(a) {
    if (a.first_name.value.trim() == "") {
      alert('Please enter first name');
      a.first_name.focus();
      a.first_name.value = '';
      return false;
    }
    if (a.last_name.value.trim() == "") {
      alert('Please enter last name');
      a.last_name.focus();
      a.last_name.value = '';
      return false;
    }

    var telInput = $("#cell_phone");
    $("#phone").val(telInput.intlTelInput("getNumber"));
    if (a.phone.value.trim() == "") {
      alert('Please enter phone number');
      return false;
    }
    if (!telInput.intlTelInput("isValidNumber")) {
      alert('Please enter valid phone number');
      return false;
    }

    if (a.phone.value.trim() == "") {
      alert('Please enter phone');
      a.phone.focus();
      a.phone.value = '';
      return false;
    }
    if (a.email.value.trim() == "") {
      alert('Please enter email');
      a.email.focus();
      a.email.value = '';
      return false;
    }
    if (a.address.value.trim() == "") {
      alert('Please enter address line1');
      a.address.focus();
      a.address.value = '';
      return false;
    }
    if (a.city.value.trim() == "") {
      alert('Please enter city');
      a.city.focus();
      a.city.value = '';
      return false;
    }
    if (a.state.value.trim() == "") {
      alert('Please enter state');
      a.state.focus();
      a.state.value = '';
      return false;
    }
    if (a.postcode.value.trim() == "") {
      alert('Please enter post code');
      a.postcode.focus();
      a.postcode.value = '';
      return false;
    }
    if (a.phone.value.trim() == "") {
      alert('Please enter description');
      a.phone.focus();
      a.phone.value = '';
      return false;
    }
    if (a.phone.value.trim() == "") {
      alert('Please enter description');
      a.phone.focus();
      a.phone.value = '';
      return false;
    }
  }
</script>
