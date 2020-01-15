<?php
//If already loggedin and try to access login page, it will redirect to account
if($user_id>0) {
	setRedirect(SITE_URL.'account');
	exit();
}

$csrf_token = generateFormToken('login');

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

<form action="controllers/user/login.php" method="post" id="login_form">
  <section>
	<div class="container">
	  <div class="row">
		<div class="col-md-12">
		  <div class="head user-area-head text-center">
			<div class="h2"><strong>Login</strong></div>
			<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
		  </div>
		</div>
	  </div>
	  <div class="row">
		<div class="col-md-12">
		  <div class="block clearfix cust-box">
			<div class="form-horizontal form-login" role="form">
			  <div class="form-wrap clearfix">
				<div class="form-group">
				  <label for="username" class="control-label">Enter email address</label>
				  <div class="clearfix">
					<input type="text" class="form-control cust-form-control w-100" id="username" name="username" placeholder="" autocomplete="off">
				  </div>
				</div>
				<div class="form-group">
				  <label for="password" class="control-label">Enter password</label>
				  <div class="clearfix">
					<input type="password" class="form-control cust-form-control w-100" id="password" name="password" placeholder="" autocomplete="off">
				  </div>
				</div>
				
				<?php
				if($login_form_captcha == '1') { ?>
				  <div class="form-group">
					<div id="g_form_gcaptcha"></div>
					<input type="hidden" id="g_captcha_token" name="g_captcha_token" value=""/>
				  </div>
				<?php
				} ?>
				  
				<div class="form-group text-center">
				  <div class="clearfix">
					<button type="submit" class="btn btn-submit">Login</button>
					<input type="hidden" name="submit_form" id="submit_form" />
				  </div>
				</div>
			  </div>
			  <div class="form-group text-center">
				<a class="btn" href="<?=$signup_link?>">Are you alredy not Member? click here to Signup</a>
				<a class="btn" href="lost_password">Forgotten your password?</a>
			  </div>
			</div>
		  </div>
		</div>
	  </div>

	  <?php
	  if($social_login=='1') { ?>
		<div class="row">
			<div class="col-md-12 text-center">
				<div class="head head-divider clarfix">
					<div class="h2">or  Sign in Using</div>
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
		<div class="col-md-12">
		  <div class="block social text-center mt-3 mb-3">
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
	  } ?>
	</div>
  </section>
  <input type="hidden" name="csrf_token" value="<?=$csrf_token?>">
</form>

<?php
if($login_form_captcha == '1') {
	echo '<script src="https://www.google.com/recaptcha/api.js?onload=CaptchaCallback&render=explicit"></script>';
} ?>
<script>
<?php
if($login_form_captcha == '1') { ?>
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
		$('#login_form').bootstrapValidator({
			fields: {
				username: {
					validators: {
						notEmpty: {
							message: 'Please enter email address'
						},
						emailAddress: {
							message: 'Please enter valid email address'
						}
					}
				},
				password: {
					validators: {
						notEmpty: {
							message: 'Please enter password.'
						}
					}
				}
			}
		}).on('success.form.bv', function(e) {
            $('#login_form').data('bootstrapValidator').resetForm();

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