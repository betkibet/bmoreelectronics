<?php
//Header section
include("include/header.php");

//If already loggedin and try to access lost password page, it will redirect to account
if($user_id>0) {
	setRedirect(SITE_URL.'account');
	exit();
}

$csrf_token = generateFormToken('lost_password');
?>

<form action="controllers/user/lost_password.php" method="post" id="lost_psw_form" role="form">
  <section>
	<div class="container">
	  <div class="row">
		<div class="col-md-12">
		  <div class="head user-area-head text-center">
			<div class="h2"><strong>Forgot your password?</strong></div>
			<p>Enter the e-mail address associated with your <?=SITE_NAME?> account, then click Reset Password.<br />We'll email you a link to a page where you can easily create a new password.</p>
		  </div>
		</div>
	  </div>
	  <div class="row">
		<div class="col-md-12">
		  <div class="block clearfix">
			<div class="form-horizontal form-login" role="form">
			  <div class="form-wrap clearfix">
				<div class="form-group">
				  <label for="username" class="control-label">Email</label>
				  <div class="clearfix">
					<input type="text" class="form-control" id="email" name="email" placeholder="Enter email address" autocomplete="off">
				  </div>
				</div>
				<div class="form-group">
				  <div class="clearfix">
					<button type="submit" class="btn btn-submit">Submit</button>
					<input type="hidden" name="reset" id="reset" />
					<input type="hidden" name="user_id" id="user_id" value="<?=$user_id?>" />
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
		$('#lost_psw_form').bootstrapValidator({
			fields: {
				email: {
					validators: {
						notEmpty: {
							message: 'Please enter email address'
						},
						emailAddress: {
							message: 'Please enter valid email address'
						}
					}
				}
			}
		}).on('success.form.bv', function(e) {
            //$('#success_message').slideDown({ opacity: "show" }, "slow") // Do something ...
            $('#lost_psw_form').data('bootstrapValidator').resetForm();

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