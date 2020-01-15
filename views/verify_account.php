<?php
//Fetching data from model
require_once("models/user/verify_account.php");

//Header section
include("include/header.php");
?>

<section>
<div class="container">
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
		  <form action="<?=SITE_URL?>controllers/user/verify_account.php" method="post" id="verify_ac_form" role="form">
		  <div class="form-inline form-group-full clearfix">
			<div class="form-group">
			  <label for="verification_code" class="control-label">Verification Code</label>
			  <div class="clearfix">
				<input type="text" class="form-control" name="verification_code" id="verification_code" placeholder="Enter verification code you received by <?=$user_data['verification_type']?> to varify">
			  </div>
			</div>
		  </div>
		  <div class="form-inline form-group-full clearfix">
			<div class="form-group">
			  <div class="clearfix">
				<button type="submit" class="btn btn-submit">Verify</button>
				<input type="hidden" name="submit_form" id="submit_form" />
				<input type="hidden" name="user_id" id="user_id" value="<?=$user_id?>" />
			  </div>
			</div>
		  </div>
		  </form>
	   
		  <form action="<?=SITE_URL?>controllers/user/verify_account.php" method="post">
			  <?php
			  if($user_data['verification_type']=="email") { ?>
			  <div class="form-inline form-group-full clearfix">
				<div class="form-group">
				  <label for="resend_veri" class="control-label">&nbsp;</label>
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
				  <label for="resend_veri" class="control-label">&nbsp;</label>
				  <div class="clearfix">
					<button type="submit" name="resend_veri" id="resend_veri" class="btn btn-submit">Resend</button>
				  </div>
				</div>
			  </div>
			  <?php
			  } ?>
			  <input type="hidden" name="user_id" id="user_id" value="<?=$user_id?>" />
			  
			<?php
			$csrf_token = generateFormToken('verify_account'); ?>
			<input type="hidden" name="csrf_token" value="<?=$csrf_token?>">
		  </form>
		</div>
	  </div>
	</div>
  </div>
</div>
</section>
  
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