<?php
$meta_title = "Verify Your Account";

//Fetching data from model
require_once("models/user/verify_step3.php");
if($user_id>0) {
	$msg='You have already loggedin with other user so please first logout from current session then you will able to verify you account.';
	setRedirectWithMsg(SITE_URL,$msg,'danger');
	exit();
}

//Header section
include("include/header.php");
?>

<!-- Main -->
<div id="main" class="orderdetail">
	<section id="model-steps-select" class="sectionbox white-bg clearfix">

		<div class="row">
			<div class="col-md-12">
				<div class="head user-area-head text-center">
					<div class="h2"><strong>Verify your account</strong></div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
			  <div class="block clearfix">
				<div class="form-signup">
				  <form action="<?=SITE_URL?>controllers/user/verify_step3.php" method="post" id="verify_ac_form">
				  <div class="form-inline form-group-full clearfix">
					<div class="form-group">
					  <label for="verification_code" class="control-label">Verification Code</label>
					  <div class="clearfix">
						<input type="number" class="form-control" name="verification_code" id="verification_code" placeholder="" autocomplete="nope">
					  </div>
					</div>
				  </div>
				  <div class="form-inline form-group-full clearfix">
					<div class="form-group">
					  <div class="clearfix">
						<button type="submit" class="btn btn-submit">Verify</button>
						<input type="hidden" name="submit_form" id="submit_form" />
						<input type="hidden" name="user_id" id="user_id" value="<?=$url_user_id?>" />
					  </div>
					</div>
				  </div>
					<?php
					$csrf_token = generateFormToken('verify_step3_1'); ?>
					<input type="hidden" name="csrf_token" value="<?=$csrf_token?>">
				  </form>
			   
				  <form class="pt-5" action="<?=SITE_URL?>controllers/user/verify_step3.php" method="post">
					  <?php
					  if($user_data['verification_type']=="email") { ?>
					  <div class="form-inline form-group-full clearfix">
						<div class="form-group">
						  <label for="resend_veri" class="control-label">please enter account varification code you received by email to varify.</label>
						  <div class="clearfix">
							<button type="submit" name="resend_veri" id="resend_veri" class="btn btn-submit">Resend</button>
						  </div>
						</div>
					  </div>
					  <?php
					  }
					  if($user_data['verification_type']=="sms") { ?>
					  <div class="form-inline form-group-full clearfix">
						<div class="form-group">
						  <label for="resend_veri" class="control-label">please enter account varification code you received by phone to varify.</label>
						  <div class="clearfix">
							<button type="submit" name="resend_veri" id="resend_veri" class="btn btn-submit">Resend</button>
						  </div>
						</div>
					  </div>
					  <?php
					  } ?>
					  <input type="hidden" name="user_id" id="user_id" value="<?=$url_user_id?>" />
					  
					<?php
					$csrf_token = generateFormToken('verify_step3_2'); ?>
					<input type="hidden" name="csrf_token" value="<?=$csrf_token?>">
				  </form>
				</div>
			  </div>
			</div>
		</div>
	</section>
</div>


<script>
(function( $ ) {
	$(function() {
		$('#verify_ac_form').bootstrapValidator({
			fields: {
				verification_code: {
					validators: {
						stringLength: {
							min: 1,
						},
						notEmpty: {
							message: 'Please enter verification code'
						}
					}
				}
			}
		}).on('success.form.bv', function(e) {
            $('#verify_ac_form').data('bootstrapValidator').resetForm();

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