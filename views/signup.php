<?php
//If already loggedin and try to access signup page, it will redirect to account
if($user_id>0) {
	setRedirect(SITE_URL.'account');
	exit();
}

$csrf_token = generateFormToken('signup');

//Header Image
if($active_page_data['image'] != "") { ?>
	<section>
	  <div class="row">

		<?php
		if($active_page_data['image_text'] != "") { ?>
			<h2><?=$active_page_data['image_text']?></h2>
		<?php
		} ?>

		<img src="<?=SITE_URL.'images/pages/'.$active_page_data['image']?>" alt="<?=$active_page_data['title']?>" width="100%">
	  </div>
	</section>
<?php
} ?>

<section>
<div class="container">
  <div class="row">
	<div class="col-md-12">
	  <div class="head user-area-head text-center">
		<?php
	  	if($active_page_data['show_title'] == '1') { ?>
		<div class="h2"><strong><?=$active_page_data['title']?></strong></div>
		<?php
		} ?>
		<?=($active_page_data['content']?'<p>'.$active_page_data['content'].'</p>':'')?>
	  </div>
	</div>
  </div>
  <div class="row">
	<div class="col-md-12">
	  <div class="block clearfix cust-box">
		<div class="form-signup">
		  <form action="controllers/user/signup.php" method="post" id="signup_form" role="form">
		  <div class="form-inline clearfix row mx-2">
			<div class="form-group col-md-6 col-xs-12">
			  <!-- <label for="username" class="control-label">First Name</label> -->
			  <div class="clearfix">
				<input type="text" class="form-control cust-form-control w-100" name="first_name" id="first_name" placeholder="First Name">
			  </div>
			</div>
			<div class="form-group col-md-6 col-xs-12">
			  <!-- <label for="password" class="control-label">Last Name</label> -->
			  <div class="clearfix">
				<input type="text" class="form-control cust-form-control w-100" name="last_name" id="last_name" placeholder="Last Name">
			  </div>
			</div>
		  </div>
		  <div class="form-inline clearfix row mx-2">
			<div class="form-group col-md-6 col-xs-12">
			  <!-- <label for="username" class="control-label">Mobile</label> -->
			  <div class="clearfix">
				<input type="tel" id="cell_phone" name="cell_phone" class="form-control cust-form-control w-100" placeholder="">
				<input type="hidden" name="phone" id="phone" />
			  </div>
			</div>
			<div class="form-group col-md-6 col-xs-12">
			  <!-- <label for="password" class="control-label">Email</label> -->
			  <div class="clearfix">
				<input type="text" class="form-control cust-form-control w-100" name="email" id="email" placeholder="Email Address" autocomplete="off">
			  </div>
			</div>
		  </div>
		  <div class="form-inline clearfix row mx-2">
			<div class="form-group col-md-6 col-xs-12">
			  <!-- <label for="username" class="control-label">Password</label> -->
			  <div class="clearfix">
				<input type="password" class="form-control cust-form-control w-100" name="password" id="password" placeholder="Password" autocomplete="off">
			  </div>
			</div>
			<div class="form-group col-md-6 col-xs-12">
			  <!-- <label for="password" class="control-label">Confirm Password</label> -->
			  <div class="clearfix">
				<input type="password" class="form-control cust-form-control w-100" name="confirm_password" id="confirm_password" placeholder="Confirm Password" autocomplete="off">
			  </div>
			</div>
		  </div>
		  
		  <?php
		  if($signup_form_captcha == '1') { ?>
		  <div class="form-row">
			<div class="form-group col-md-12">
			  <div id="g_form_gcaptcha"></div>
			  <input type="hidden" id="g_captcha_token" name="g_captcha_token" value=""/>
			</div>
		  </div>
		  <?php
		  } ?>
			  
		  <div class="form-inline form-group-full clearfix">
			<div class="form-group ">
				<div class="checkbox clearfix">
					<?php
					if($general_setting_data['terms_status']=='1' && $display_terms_array['ac_creation']=="ac_creation") { ?>
						<input type="checkbox" name="terms_conditions" id="terms_conditions" value="1"/>
						<label for="terms_conditions">I accept <a href="javascript:void(0)" class="help-icon" data-toggle="modal" data-target="#PricePromiseHelp">Terms and Condition</a></label>
					<?php
					} else { ?>
						<input type="hidden" name="terms_conditions" id="terms_conditions" value="1" checked="checked"/>
					<?php
					} ?>
				</div>
			</div>
		  </div>
		  <div class="form-inline form-group-full clearfix text-center">
			<div class="form-group">
			  <div class="clearfix">
				<button type="submit" class="btn btn-submit">Signup</button>
				<input type="hidden" name="submit_form" id="submit_form" />
			  </div>
			</div>
		  </div>
		  <input type="hidden" name="csrf_token" value="<?=$csrf_token?>">
		  </form>
		  <div class="form-inline form-group-full clearfix text-center">
			<div class="form-group">
			  <a class="btn btn-login" href="<?=$login_link?>">Are you alredy Member? click here to login</a>
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
	<div class="row text-center">
		<div class="col-md-12">
			<div class="head head-divider clarfix">
				<div class="h2">or  Sign Up Using</div>
			</div>
		</div>
	</div>

	<script type="text/javascript" src="social/js/oauthpopup.js"></script>
	<script type="text/javascript">
	jQuery(document).ready(function($){
		//For Google
		$('a.login').oauthpopup({
			path: 'social/social.php?google',
			width:650,
			height:350,
		});
		$('a.google_logout').googlelogout({
			redirect_url:'<?php echo $base_url; ?>social/logout.php?google'
		});

		//For Facebook
		$('#facebook').oauthpopup({
			path: 'social/social.php?facebook',
			width:1000,
			height:1000,
		});
	});
	</script>

	<div class="row">
		<div class="col-md-12 text-center">
		  <div class="block social mt-3 mb-3">
			<ul>
			<?php
			if($social_login_option=="g_f") { ?>
				<li class="facebook"><a id="facebook" class="h4" href="javascript:void(0);"><i class="fa fa-facebook"></i>Facebook</a></li>
				<li class="google"><a class="login h4" href="javascript:void(0);"><i class="fa fa-google-plus"></i>Google</a></li>
			<?php
			} elseif($social_login_option=="g") { ?>
				<li class="google"><a class="login h4" href="javascript:void(0);"><i class="fa fa-google-plus"></i>Google</a></li>
			<?php
			} elseif($social_login_option=="f") { ?>
				<li class="facebook"><a id="facebook" class="h4" href="javascript:void(0);"><i class="fa fa-facebook"></i>Facebook</a></li>
			<?php
			} ?>
			</ul>
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
		  initialCountry: "auto",
		  geoIpLookup: function(callback) {
			$.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
			  var countryCode = (resp && resp.country) ? resp.country : "";
			  callback(countryCode);
			});
		  },
		  utilsScript: "js/intlTelInput-utils.js" //just for formatting/placeholders etc
		});

		// on keyup / change flag: reset
		telInput.on("keyup change", reset);
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
								$("#phone").val(telInput.intlTelInput("getNumber"));
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