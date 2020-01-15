<?php
$csrf_token = generateFormToken('reset_password');

//Header section
include("include/header.php");

//Fetching data from model
require_once('models/user/reset_password.php'); ?>

<script type="text/javascript">
function check_form(a){
	if(a.new_password.value.trim()==""){
		alert('Please enter new password.');
		a.new_password.focus();
		return false;
	}
	if(a.confirm_password.value.trim()==""){
		alert('Please enter confirm password.');
		a.confirm_password.focus();
		return false;
	}
	if(a.new_password.value.trim()!=a.confirm_password.value.trim()){
		alert('New password and confirm password not matched.');
		a.confirm_password.focus();
		return false;
	}	
}
</script>

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
	  <div class="row">
		<div class="col-md-12">
		  <div class="block clearfix">
			<div class="form-horizontal form-login" role="form">
			  <div class="form-wrap clearfix">
				<div class="form-group">
				  <label for="username" class="control-label">New Password</label>
				  <div class="clearfix">
					<input type="password" class="form-control" id="new_password" name="new_password" placeholder="Enter new password" autocomplete="off">
				  </div>
				</div>
				<div class="form-group">
				  <label for="username" class="control-label">Confirm Password</label>
				  <div class="clearfix">
					<input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Enter confirm password" autocomplete="off">
				  </div>
				</div>
				<div class="form-group">
				  <div class="clearfix">
					<button type="submit" class="btn btn-submit">Submit</button>
					<input type="hidden" name="reset" id="reset" />
					<input type="hidden" name="t" id="t" value="<?=$post['t']?>" />
				  </div>
				</div>
			  </div>
			  <div class="form-group text-center">
				<a class="btn" href="<?=$login_link?>">Return to login</a>
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
