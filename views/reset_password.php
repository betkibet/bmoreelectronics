<?php
$csrf_token = generateFormToken('reset_password');

//Header section
include("include/header.php");

//Fetching data from model
require_once('models/user/reset_password.php'); ?>

<form action="controllers/user/reset_password.php" method="post" id="reset_psw_form" role="form">
  <section>
	<div class="container">
	  <div class="row">
		<div class="col-md-12">
		  <div class="head user-area-head text-center">
			<div class="h2"><strong>Reset Your Password</strong></div>
		  </div>
		</div>
	  </div>
	  <div class="row justify-content-center">
		<div class="col-md-6">
		  <div class="block login clearfix">
				<div class="card">
					<div class="card-body">
						<div class="form-horizontal form-login" role="form">
							<div class="form-wrap clearfix">
							<div class="form-group with-icon password-field">
								<label for="new_password">New Password</label>
								<input type="password" class="form-control" id="new_password" name="new_password" placeholder="Enter new password" autocomplete="off">
							</div>
							<div class="form-group with-icon password-field">
								<label for="confirm_password">Confirm Password</label>
								<input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Enter confirm password" autocomplete="off">
							</div>
							<div class="form-group">
								<button type="submit" class="btn btn-block btn-primary">Submit</button>
								<input type="hidden" name="reset" id="reset" />
								<input type="hidden" name="t" id="t" value="<?=$post['t']?>" />
							</div>
							</div>
						</div>
					</div>
				</div>
		  </div>
		</div>
	  </div>  
	</div>
  </section>
  <input type="hidden" name="csrf_token" value="<?=$csrf_token?>">
</form>

<script>
(function( $ ) {
	$(function() {
		$('#reset_psw_form').bootstrapValidator({
			fields: {
				new_password: {
					validators: {
						notEmpty: {
							message: 'Please enter new password.'
						},
						identical: {
							field: 'confirm_password',
							message: 'New password and confirm password not matched.'
						}
					}
				},
				confirm_password: {
					validators: {
						notEmpty: {
							message: 'Please enter confirm password.'
						},
						identical: {
							field: 'new_password',
							message: 'New password and confirm password not matched.'
						}
					}
				}
			}
		}).on('success.form.bv', function(e) {
            //$('#success_message').slideDown({ opacity: "show" }, "slow") // Do something ...
                $('#reset_psw_form').data('bootstrapValidator').resetForm();

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
