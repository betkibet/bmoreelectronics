<?php
//If already loggedin and try to access signup page, it will redirect to account
if($user_id>0) {
	setRedirect(SITE_URL.'account');
	exit();
}

$csrf_token = generateFormToken('signup');

$is_show_title = true;
$header_section = $active_page_data['header_section'];
$header_image = $active_page_data['image'];
$show_title = $active_page_data['show_title'];
$image_text = $active_page_data['image_text'];
$page_title = $active_page_data['title'];
?>
<section id="breadcrumb" class="<?=$active_page_data['css_page_class']?> py-0">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="block breadcrumb clearfix">
					<ul class="breadcrumb m-0">
						<li class="breadcrumb-item">
							<a href="<?=SITE_URL?>">Home</a>
						</li>
						<li class="breadcrumb-item active"><a href="javascript:void(0);"><?=$active_page_data['menu_name']?></a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</section>

<?php
//Header Image
if($header_section == '1' && ($header_image || $show_title == '1' || $image_text)) { ?>
	<section class="head-graphics <?=$active_page_data['css_page_class']?>" id="head-graphics" <?php if($header_image != ""){echo 'style="background-image: url('.SITE_URL.'images/pages/'.$header_image.')"';}?>>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="block header-caption text-center">
						<?php
						if($show_title == '1') {
							echo '<h1>'.$page_title.'</h1>';
						}
						if($image_text) {
							echo '<p>'.$image_text.'</p>';
						} ?>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php
$is_show_title = false;
} ?>

<?php
if($is_show_title && $show_title == '1') { ?>
	<section id="head-graphics-title" class="<?=$active_page_data['css_page_class']?>">
		<div class="container">
			<div class="col-md-12">
				<div class="block heading page-heading text-center">
					<h3><?=$page_title?></h3>
				</div>
			</div>
		</div>
	</section>
<?php
} ?>

<section>
<div class="container">
  <div class="row justify-content-center">
	<div class="col-md-7">
		<div class="card">
			<div class="card-body">
				<div class="head user-area-head text-center">
				<div class="h2"><strong>Signup</strong></div>
				<?=($active_page_data['content']?'<p>'.$active_page_data['content'].'</p>':'')?>
				</div>
				<div class="form-signup">
		  <form action="controllers/user/signup.php" method="post" id="signup_form" role="form">
		  <div class="row clearfix">
			<div class="form-group text-center col-md-6">
			  <label for="username" class="control-label">First Name</label>
			  <div class="clearfix">
				<input type="text" class="form-control text-center" name="first_name" id="first_name" placeholder="">
			  </div>
			</div>
			<div class="form-group text-center col-md-6">
			  <label for="password" class="control-label">Last Name</label>
			  <div class="clearfix">
				<input type="text" class="form-control text-center" name="last_name" id="last_name" placeholder="">
			  </div>
			</div>
		  </div>
		  <div class="row clearfix">
			<div class="form-group text-center col-md-6">
			  <label for="username" class="control-label">Mobile</label>
			  <div class="clearfix">
				<input type="tel" id="cell_phone" name="cell_phone" class="form-control text-center" placeholder="">
				<input type="hidden" name="phone_c_code" id="phone_c_code" />
			  </div>
			</div>
			<div class="form-group text-center col-md-6">
			  <label for="password" class="control-label">Email</label>
			  <div class="clearfix">
				<input type="text" class="form-control text-center" name="email" id="email" placeholder="" autocomplete="off">
			  </div>
			</div>
		  </div>
		  <div class="row clearfix">
			<div class="form-group text-center col-md-6">
			  <label for="username" class="control-label">Password</label>
			  <div class="clearfix">
				<input type="password" class="form-control text-center" name="password" id="password" placeholder="" autocomplete="off">
			  </div>
			</div>
			<div class="form-group text-center col-md-6">
			  <label for="password" class="control-label">Confirm Password</label>
			  <div class="clearfix">
				<input type="password" class="form-control text-center" name="confirm_password" id="confirm_password" placeholder="" autocomplete="off">
			  </div>
			</div>
		  </div>
		  
		  <?php
		  if($signup_form_captcha == '1') { ?>
		  <div class="row">
			<div class="form-group col-md-12">
			  <div id="g_form_gcaptcha"></div>
			  <input type="hidden" id="g_captcha_token" name="g_captcha_token" value=""/>
			</div>
		  </div>
		  <?php
		  } ?>
			  
		  <div class="form-group clearfix">
			<div class="checkbox signup-checkbox clearfix">
				<?php
				if($display_terms_array['ac_creation']=="ac_creation") { ?>
					<label for="terms_conditions">
						<input type="checkbox" name="terms_conditions" id="terms_conditions" value="1"/>
						<span class="checkmark"></span>
						I accept <a href="javascript:void(0)" class="help-icon click_terms_of_website_use">Terms and Condition</a>
					</label>
				<?php
				} else { ?>
					<input type="hidden" name="terms_conditions" id="terms_conditions" value="1" checked="checked"/>
				<?php
				} ?>
			</div>
		  </div>
		  
		  <div class="form-group text-center">
			  <div class="clearfix">
				 <button type="submit" class="btn btn-primary">Signup</button>
				 <input type="hidden" name="submit_form" id="submit_form" />
			  </div>
		  </div>
		
		  <input type="hidden" name="csrf_token" value="<?=$csrf_token?>">
		  </form>
		  <div class="form-group-full clearfix">
			<div class="form-group text-center">
			  <a  href="<?=$login_link?>">Are you alredy Member? click here to login</a>
			</div>
		  </div>
		</div>

			</div>
		</div>
	</div>
  </div>

  <div class="modal fade HelpPopup" id="PricePromiseHelp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<div class="modal-content">
		  <div class="modal-body">
			<div class="popUpInner">
			  <h2>TERMS & CONDITIONS</h2>
			  <?=$general_setting_data['terms']?>
			</div>
		  </div>
		</div>
	  </div>
  </div>

  <?php
  //START for social login
  if($social_login=='1') { ?>
	<script type="text/javascript" src="social/js/oauthpopup.js"></script>
	<script type="text/javascript">
	jQuery(document).ready(function($){
		//For Google
		$('.p_google_auth').oauthpopup({
			path: 'social/social.php?google',
			width:650,
			height:350,
		});

		//For Facebook
		$('.p_facebook_auth').oauthpopup({
			path: 'social/social.php?facebook',
			width:1000,
			height:1000,
		});
	});
	</script>

	<div id="signupbox2">
		<div class="row justify-content-center">
			<div class="col-md-7">
				<div class="block text-center">
					<div id="signupbox">
						<div class="orsignup">
							<div class="row">
								<div class="btn_box dis_table_cell col-sm-12">
									<?php
									if($social_login_option=="g_f") { ?>
										<a class="btn btn_md btn_fb p_facebook_auth" href="javascript:void(0);"><img src="<?=SITE_URL?>images/fb_img.png" alt="Facebook Auth"></a>
										<a class="btn btn_md btn_gplus p_google_auth" href="javascript:void(0);"><img src="<?=SITE_URL?>images/google_plus.png" alt="Google Auth"></a>
									<?php
									} elseif($social_login_option=="g") { ?>
										<a class="btn btn_md btn_gplus p_google_auth" href="javascript:void(0);"><img src="<?=SITE_URL?>images/google_plus.png" alt="Google Auth"></a>
									<?php
									} elseif($social_login_option=="f") { ?>
										<a class="btn btn_md btn_fb p_facebook_auth" href="javascript:void(0);"><img src="<?=SITE_URL?>images/fb_img.png" alt="Facebook Auth"></a>
									<?php
									} ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
  <?php
  } //END for social login ?>
</div>
</section>

<?php
if($signup_form_captcha == '1') {
	echo '<script src="https://www.google.com/recaptcha/api.js?onload=CaptchaCallback&render=explicit"></script>';
} ?>
<script>
<?php
if($signup_form_captcha == '1') { ?>
var CaptchaCallback = function() {
	if(jQuery('#g_form_gcaptcha').length) {
		grecaptcha.render('g_form_gcaptcha', {
			'sitekey' : '<?=$captcha_key?>',
			'callback' : onSubmitForm,
		});
	}

};
	
var onSubmitForm = function(response) {
	if(response.length == 0) {
		jQuery("#g_captcha_token").val('');
	} else {
		//$(".sbmt_button").removeAttr("disabled");
		jQuery("#g_captcha_token").val('yes');
	}
};
<?php
} ?>

(function( $ ) {
	$(function() {
		var telInput = $("#cell_phone");
		telInput.intlTelInput({
		  initialCountry: "<?=$phone_country_short_code?>",
		  allowDropdown: false,
		  geoIpLookup: function(callback) {
			$.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
			  var countryCode = (resp && resp.country) ? resp.country : "";
			  callback(countryCode);
			});
		  },
		  utilsScript: "js/intlTelInput-utils.js" //just for formatting/placeholders etc
		});

		// on keyup / change flag: reset
		//telInput.on("keyup change", reset);
	});
})(jQuery);

(function( $ ) {
	$(function() {
		$('#signup_form').bootstrapValidator({
			fields: {
				first_name: {
					validators: {
						stringLength: {
							min: 1,
						},
						notEmpty: {
							message: 'Please enter first name'
						}
					}
				},
				 last_name: {
					validators: {
						stringLength: {
							min: 1,
						},
						notEmpty: {
							message: 'Please enter last name'
						}
					}
				},
				email: {
					validators: {
						notEmpty: {
							message: 'Please enter email address'
						},
						emailAddress: {
							message: 'Please enter valid email address'
						}
					}
				},
				cell_phone: {
					validators: {
						/*notEmpty: {
							message: 'Please enter phone number'
						},*/
						callback: {
							message: 'Please enter valid phone number',
							callback: function(value, validator, $field) {
								var telInput = $("#cell_phone");
								//$("#phone").val(telInput.intlTelInput("getNumber"));
								$("#phone_c_code").val(telInput.intlTelInput("getSelectedCountryData").dialCode);
								if(!telInput.intlTelInput("isValidNumber")) {
									return false;
								} else if(telInput.intlTelInput("isValidNumber")) {
									return true;
								}
							}
						}
					}
				},
				password: {
					validators: {
						notEmpty: {
							message: 'Please enter password.'
						},
						identical: {
							field: 'confirm_password',
							message: 'Password and confirm password not matched.'
						}
					}
				},
				confirm_password: {
					validators: {
						notEmpty: {
							message: 'Please enter confirm password.'
						},
						identical: {
							field: 'password',
							message: 'Password and confirm password not matched.'
						}
					}
				},
				terms_conditions: {
					validators: {
						callback: {
							message: 'You must agree to terms & conditions to sign-up.',
							callback: function(value, validator, $field) {
								var terms = document.getElementById("terms_conditions").checked;
								if(terms==false) {
									return false;
								} else {
									return true;
								}
							}
						}
					}
				}
			}
		}).on('success.form.bv', function(e) {
            //$('#success_message').slideDown({ opacity: "show" }, "slow") // Do something ...
                $('#signup_form').data('bootstrapValidator').resetForm();

            // Prevent form submission
            e.preventDefault();

            // Get the form instance
            var $form = $(e.target);

            // Get the BootstrapValidator instance
            var bv = $form.data('bootstrapValidator');

            // Use Ajax to submit form data
            $.post($form.attr('action'), $form.serialize(), function(result) {
                console.log(result);
            }, 'json');
        });
	});
})(jQuery);
</script>