<script type="text/javascript">

</script>

<!-- begin:: Page -->
<div class="m-grid m-grid--hor m-grid--root m-page">
  <!-- BEGIN: Header -->
  <?php include("include/admin_menu.php"); ?>
  <!-- END: Header -->

  <!-- begin::Body -->
  <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body main_top_section">
    <!-- BEGIN: Left Aside -->
    <?php include("include/navigation.php"); ?>
    <!-- END: Left Aside -->
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
      
      <div class="m-content">
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
                      Profile
                    </h3>
                  </div>
                </div>
              </div>
              <!--begin::Form-->
              <form class="m-form" action="controllers/admin_user/profile.php" role="form" method="post" onSubmit="return check_form(this);">
                <div class="m-portlet__body">
                  <div class="m-form__section m-form__section--first">
					<div class="form-group m-form__group row">
						<div class="col-lg-4">
							<label for="name">Name *</label>
							<input type="text" class="form-control m-input" id="name" value="<?=$get_userdata_row['name']?>" name="name">
						</div>
						<div class="col-lg-4">
							<label for="company_name">Company Name *</label>
							<input type="text" class="form-control m-input" id="company_name" value="<?=$get_userdata_row['company_name']?>" name="company_name">
						</div>
						<div class="col-lg-4">
							<label for="email">Email *</label>
							<input type="text" class="form-control m-input" id="email" value="<?=$get_userdata_row['email']?>" name="email">
						</div>
					</div>
					
					<div class="form-group m-form__group row">
						<div class="col-lg-4">
							<label for="cell_phone">Phone :</label>
							<input type="tel" id="cell_phone" name="cell_phone" class="form-control m-input" placeholder="">
							<input type="hidden" name="phone" id="phone" /><br />
							<span id="valid-msg" class="hide">✓ Valid</span>
							<span id="error-msg" class="hide">Invalid number</span>
						</div>
						<div class="col-lg-4">
							<label for="password">Change Password</label>
							<input type="password" class="form-control m-input" id="password" name="password">
						</div>
						<div class="col-lg-4">
							<label for="rpassword">Retype Password</label>
							<input type="password" class="form-control m-input" id="rpassword" name="rpassword">
						</div>
					</div>
					
					<div class="form-group m-form__group row">
						<div class="col-lg-6">
							<label for="address">
								Address Line 1
							</label>
							<textarea class="form-control m-input" id="address" name="address" rows="4"><?=$get_userdata_row['address']?></textarea>
						</div>
						<div class="col-lg-6">
							<label for="address2">
								Address Line 2
							</label>
							<textarea class="form-control m-input" id="address2" name="address2" rows="4"><?=$get_userdata_row['address2']?></textarea>
						</div>
					</div>
					
					<div class="form-group m-form__group row">
						<div class="col-lg-3">
							<label for="country">Country</label>
							<select name="country" id="country" class="form-control m-input">
								<option value=""> - Country - </option>
								<?php
								foreach($countries_list as $c_k => $c_v) { ?>
									<option value="<?=$c_v?>" <?php if($get_userdata_row['country'] == $c_v){echo 'selected="selected"';}?>><?=$c_v?></option>
								<?php
								} ?>
							</select>
						</div>
						<div class="col-lg-3">
							<label for="state">State</label>
							<input type="text" class="form-control m-input" id="state" value="<?=$get_userdata_row['state']?>" name="state">
						</div>
						<div class="col-lg-3">
							<label for="city">City</label>
							<input type="text" class="form-control m-input" id="city" value="<?=$get_userdata_row['city']?>" name="city">
						</div>
						<div class="col-lg-3">
							<label for="zip_code">Zip Code</label>
							<input type="text" class="form-control m-input" id="zip_code" value="<?=$get_userdata_row['zip_code']?>" name="zip_code">
						</div>
					</div>
					
                    <input type="hidden" name="id" value="<?=$get_userdata_row['id']?>"/>
                    <input type="hidden" name="old_password" value="<?=$get_userdata_row['password']?>"/>
                  </div>
                </div>
                <div class="m-portlet__foot m-portlet__foot--fit">
                  <div class="m-form__actions m-form__actions">
                    <button type="submit" name="update" class="btn btn-primary">
                      Submit
                    </button>
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

<script src="../js/intlTelInput.js"></script>
<script>
var telInput = $("#cell_phone"),errorMsg = $("#error-msg"),validMsg = $("#valid-msg");
telInput.intlTelInput({
  //initialCountry: "auto",
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
	if(telInput.intlTelInput("isValidNumber")) {
	  validMsg.removeClass("hide");
	} else {
	  telInput.addClass("error");
	  errorMsg.removeClass("hide");
	}
  }
});

// on keyup / change flag: reset
//telInput.on("keyup change", reset);

$("#cell_phone").intlTelInput("setNumber", "<?=($get_userdata_row['phone']?'+'.$get_userdata_row['country_code'].$get_userdata_row['phone']:'')?>");

function check_form(a){
	if(a.name.value.trim()==""){
		alert('Please enter name');
		a.name.focus();
		a.name.value='';
		return false;
	}
	if(a.company_name.value.trim()==""){
		alert('Please enter company name');
		a.company_name.focus();
		a.company_name.value='';
		return false;
	}
	if(a.email.value.trim()==""){
		alert('Please enter email');
		a.email.focus();
		a.email.value='';
		return false;
	}
	
	var telInput = $("#cell_phone");
	$("#phone").val(telInput.intlTelInput("getNumber"));
	if(a.phone.value.trim()=="") {
		alert('Please enter phone');
		a.phone.focus();
		a.phone.value='';
		return false;
	}
	if(!telInput.intlTelInput("isValidNumber")) {
		alert('Please enter valid phone');
		return false;
	}

	if(a.password.value.trim()!=""){
		var regex = /^(?=(.*[a-z]){1,})(?=(.*[\d]){1,})(?!.*\s).{8,}$/;
        var password = a.password.value.trim();
        if(!regex.test(password)) {
            alert("Password must have at least one number and one albhabet and one special char, and at least 8 or more characters.");
			return false;
        }
		if(a.rpassword.value.trim()==""){
			alert('Please retype password.');
			a.rpassword.focus();
			a.rpassword.value='';
			return false;
		}
		if(a.password.value.trim()!=a.rpassword.value.trim()){
			alert('Password and Retype password not matched.');
			a.rpassword.focus();
			a.rpassword.value='';
			return false;
		}
	}
	
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