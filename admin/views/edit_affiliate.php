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
										  <?='Affiliate: '.($affiliate_id?'Edit':'Add')?>
										</h3>
									</div>
								</div>
							</div>
							<!--begin::Form-->
							<form class="m-form" action="controllers/affiliate.php" role="form" method="post" onSubmit="return check_form(this);" enctype="multipart/form-data">
								<div class="m-portlet__body">
									<div class="m-form__section m-form__section--first">
										<!--<h5 class="m-portlet__head-text">
										  Affiliate Details
										</h5>-->
										<div class="form-group m-form__group">
											<label for="field-1">
												Name
                      						</label>
											<input type="text" class="form-control m-input" id="name" value="<?=$affiliate_data['name']?>" name="name">	
										</div>
										
										<div class="form-group m-form__group">
											<label for="cell_phone">Phone</label>
											<input type="tel" id="cell_phone" name="cell_phone" class="form-control m-input" placeholder="">
											<span id="valid-msg" class="hide">✓ Valid</span>
											<span id="error-msg" class="hide">Invalid number</span>
										</div>
										
										<div class="form-group m-form__group">
											<label for="field-1">
												Email
											</label>
											<input type="email" class="form-control m-input" id="email" value="<?=$affiliate_data['email']?>" name="email">
										</div>
										<div class="form-group m-form__group">
											<label for="field-1">
												Company Name
											</label>
											<input type="text" class="form-control m-input" id="company" value="<?=$affiliate_data['company']?>" name="company">
										</div>
										<div class="form-group m-form__group">
											<label for="field-1">
												Web Address
											</label>
											<input type="text" class="form-control m-input" id="web_address" value="<?=$affiliate_data['web_address']?>" name="web_address">
										</div>
										
										<div class="form-group m-form__group">
											<label for="exampleTextarea">
												How will you promote us? :
											</label>
											<textarea class="form-control m-input" id="message" name="message" rows="5"><?=$affiliate_data['message']?></textarea>
										</div>
										
										<?php
										$affiliate_form_link = SITE_URL.get_inbuild_page_url('affiliates'); ?>
										<div class="form-group m-form__group">
											<?=$affiliate_form_link.'/?shop='?><input type="text" class="form-control m-input" name="shop_name" id="shop_name" placeholder="Shop name" style="width:150px; display:inline-block;" value="<?=$affiliate_data['shop_name']?>">
										</div>
										
										<div class="form-group m-form__group">
											<?php
											if($affiliate_data['shop_name']) { ?>
											SHOP URL: <a href="<?=$affiliate_form_link.'/?shop='.$affiliate_data['shop_name']?>" target="_blank"><?=$affiliate_form_link.'/?shop='.$affiliate_data['shop_name']?></a>
											<?php
											} ?>
										</div>
										
										<div class="m-form__group form-group">
											<label for="">
												Status :
											</label>
											<div class="m-radio-inline">
												<label class="m-radio">
													<input type="radio" id="status" name="status" value="1" <?php if(!$affiliate_id){echo 'checked="checked"';}?> <?=($affiliate_data['status']==1?'checked="checked"':'')?>>
													Published
													<span></span>
												</label>
												<label class="m-radio">
													<input type="radio"  id="status" name="status" value="0" <?=($affiliate_data['status']=='0'?'checked="checked"':'')?>>
													Unpublished
													<span></span>
												</label>
											</div>
										</div>
									</div>
								</div>
								<div class="m-portlet__foot m-portlet__foot--fit">
									<div class="m-form__actions m-form__actions">
										<button type="submit" name="update" class="btn btn-primary">
										  <?=($affiliate_id?'Update':'Save')?>
										</button>
										<a href="affiliate.php" class="btn btn-secondary">Back</a>
									</div>
								</div>
								<input type="hidden" name="id" value="<?=$affiliate_data['id']?>" />
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

  // on keyup / change flag: reset
  //telInput.on("keyup change", reset);
  <?php
  if($affiliate_data['phone']) { ?>
  $("#cell_phone").intlTelInput("setNumber", "<?=($affiliate_data['phone'])?>");
  <?php
  } ?>
  
  function check_form(a) {
    if (a.name.value.trim() == "") {
      alert('Please enter name');
      a.name.focus();
      a.name.value = '';
      return false;
    }
	
	var telInput = $("#cell_phone");
	$("#cell_phone").val(telInput.intlTelInput("getNumber"));
    if(a.cell_phone.value.trim() == "") {
      alert('Please enter phone number');
      return false;
    }
    if(!telInput.intlTelInput("isValidNumber")) {
      alert('Please enter valid phone number');
      return false;
    }
	
    if (a.email.value.trim() == "") {
      alert('Please enter email');
      a.email.focus();
      a.email.value = '';
      return false;
    }
    if (a.shop_name.value.trim() == "") {
      alert('Please enter shop name');
      a.shop_name.focus();
      a.shop_name.value = '';
      return false;
    }
  }
</script>
