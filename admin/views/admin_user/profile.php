<script type="text/javascript">
  function check_form(a) {
    if (a.username.value.trim() == "") {
      alert('Please enter your username');
      a.username.focus();
      a.username.value = '';
      return false;
    }

    if (a.email.value.trim() == "") {
      alert('Please enter your email');
      a.email.focus();
      a.email.value = '';
      return false;
    }

    if (a.password.value.trim() != "") {
      if (a.rpassword.value.trim() == "") {
        alert('Please retype password.');
        a.rpassword.focus();
        a.rpassword.value = '';
        return false;
      }

      if (a.password.value.trim() != a.rpassword.value.trim()) {
        alert('Password and Retype password not matched.');
        a.rpassword.focus();
        a.rpassword.value = '';
        return false;
      }
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
                    <div class="form-group m-form__group">
                      <label for="username">
                        Username :
                      </label>
                      <input type="text" name="username" class="form-control m-input" id="username" value="<?=$get_userdata_row['username']?>" placeholder="Enter your username" required>
                    </div>
                    <div class="form-group m-form__group">
                      <label for="email">
                        E-mail :
                      </label>
                      <input type="email" name="email" class="form-control m-input" id="email" value="<?=$get_userdata_row['email']?>" placeholder="Enter your E-mail" required>
                    </div>
					
					<div class="form-group m-form__group">
						<label for="cell_phone">Phone :</label>
						<input type="tel" id="cell_phone" name="cell_phone" class="form-control m-input" placeholder="">
						<input type="hidden" name="phone" id="phone" /><br />
						<span id="valid-msg" class="hide">✓ Valid</span>
						<span id="error-msg" class="hide">Invalid number</span>
					</div>
					
                    <div class="form-group m-form__group">
                      <label for="password">
                        Change Password :
                      </label>
                      <input type="password" name="password" class="form-control m-input" id="password" placeholder="Enter your passowrd">
                    </div>
                    <div class="form-group m-form__group">
                      <label for="rpassword">
                        Retype Password :
                      </label>
                      <input type="password" name="rpassword" class="form-control m-input" id="rpassword" placeholder="Retype your passowrd">
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
telInput.on("keyup change", reset);

$("#cell_phone").intlTelInput("setNumber", "<?=($get_userdata_row['phone']?'+'.$get_userdata_row['phone']:'')?>");

function check_form(a){
	if(a.username.value.trim()==""){
		alert('Please enter your username');
		a.username.focus();
		a.username.value='';
		return false;
	}

	if(a.email.value.trim()==""){
		alert('Please enter your email');
		a.email.focus();
		a.email.value='';
		return false;
	}
	
	var telInput = $("#cell_phone");
	$("#phone").val(telInput.intlTelInput("getNumber"));
	if(a.phone.value.trim()=="") {
		alert('Please enter phone');
		return false;
	}
	if(!telInput.intlTelInput("isValidNumber")) {
		alert('Please enter valid phone');
		return false;
	}
	if(a.phone.value.trim()==""){
		alert('Please enter phone');
		a.phone.focus();
		a.phone.value='';
		return false;
	}
	
	if(a.password.value.trim()!=""){
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
}
</script>