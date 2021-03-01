<?php
//If already loggedin and try to access login page, it will redirect to account
if($user_id>0) {
	setRedirect(SITE_URL.'account');
	exit();
}

$csrf_token = generateFormToken('login');

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

<form action="controllers/user/login.php" method="post" id="login_form">
  <section>
	<div class="container">
	  <div class="row justify-content-center">
		<div class="col-md-5">
			<div class="card">
				<div class="card-body">
					<div class="col-md-12">
					<div class="text-center clearfix">
						<div class="form-horizontal form-login" role="form">
							<div class="head user-area-head text-center">
							<div class="h2"><strong>Login</strong></div>
							<?=($active_page_data['content']?'<p>'.$active_page_data['content'].'</p>':'')?>
							</div>
							<div class="form-wrap clearfix">
								<div class="form-group">
									<label for="username" class="control-label">Email</label>
									<div class="clearfix">
									<input type="text" class="form-control text-center" id="username" name="username" placeholder="Enter email address" autocomplete="off">
									</div>
								</div>
								<div class="form-group">
									<label for="password" class="control-label">Password</label>
									<div class="clearfix">
									<input type="password" class="form-control text-center" id="password" name="password" placeholder="Enter password" autocomplete="off">
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
								
								<div class="form-group">
									<div class="clearfix">
									<button type="submit" class="btn btn-primary btn-lg">Login</button>
									<input type="hidden" name="submit_form" id="submit_form" />
									</div>
								</div>
							</div>
								<div class="form-group text-center">
								<p><a href="<?=$signup_link?>">Are you alredy not Member? click here to Signup</a></p>
								<p><a href="lost_password">Forgotten your password?</a></p>
							</div>
						</div>
					</div>
				</div>
				</div>
			</div>
		</div>
	  </div>
	  <div class="row justify-content-center">
		
	  </div>

	  <?php
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
											<a class="btn btn_md btn_fb facebook_auth" href="javascript:void(0);"><img src="<?=SITE_URL?>images/fb_img.png" alt=""></a>
											<a class="btn btn_md btn_gplus google_auth" href="javascript:void(0);"><img src="<?=SITE_URL?>images/google_plus.png" alt=""></a>
										<?php
										} elseif($social_login_option=="g") { ?>
											<a class="btn btn_md btn_gplus google_auth" href="javascript:void(0);"><img src="<?=SITE_URL?>images/google_plus.png" alt=""></a>
										<?php
										} elseif($social_login_option=="f") { ?>
											<a class="btn btn_md btn_fb facebook_auth" href="javascript:void(0);"><img src="<?=SITE_URL?>images/fb_img.png" alt=""></a>
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