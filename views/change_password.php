<?php
$csrf_token = generateFormToken('change_psw');

//Header section
include("include/header.php");

//If direct access then it will redirect to home page
if($user_id<=0) {
	setRedirect(SITE_URL);
	exit();
} ?>

  <!-- Main -->
  <div id="main" class="profile_page">
    <section id="user_profile_sec" class="sectionbox white-bg">
      <div class="wrap clearfix">
        	<div id="sidebar_profile">
            	<div class="profile_pic clearfix">
                	<div class="inner">
                    	<?php
						if($user_data['image']) {
							$md_img_path = SITE_URL.'libraries/phpthumb.php?imglocation='.SITE_URL.'images/avatar/'.$user_data['image'].'&w=157&h=157';
                    		echo '<img src="'.$md_img_path.'">';
        				} else {
							$md_img_path = SITE_URL.'libraries/phpthumb.php?imglocation='.SITE_URL.'images/placeholder_avatar.jpg&w=157&h=157';
							echo '<img src="'.$md_img_path.'">';
						} ?>
                    </div>
                </div>
                <div class="profile_nav ecolumn">
                	<ul>
                    	<li><a href="account">My Orders</a></li>
                        <li><a href="profile">Profile</a></li>
                        <li class="active"><a href="change-password">Change Password</a></li>
                    </ul>
                    <div class="logout">
                        <a href="controllers/logout.php">Logout</a>
                    </div>
                </div>
            </div><!--#sidebar_profile-->
            
			<form action="controllers/user/change_password.php" class="phone-sell-form" method="post" id="chg_psw_form">
            <div id="container_profile">
            	<div class="inner ecolumn">
                	<div class="profile_bio">
                    	<h4>Change Your Password</h4>
                        <p>Enter your new password into the fields below.</p>
                    </div>
                    <hr>
                    <div class="form_box clearfix">
                        <div class="row">
                            <div class="form_group col-sm-4">
                                <label>New Password:</label>
                                <input type="password" class="textbox" name="password" id="password" required>
                            </div>
                            <div class="form_group col-sm-4">
                                <label>Confirm Password:</label>
                                <input type="password" class="textbox" name="password2" id="password2" required>
                            </div>
                        </div>
                     </div>
                     <div class="btn_box">
                     	<button class="btn btn_md btn-green" type="submit">Save your Password</button>
						<input type="hidden" name="submit_form" id="submit_form" />
                     </div>
                 </div><!--.inner-->
            </div><!--#container_profile-->
			<input type="hidden" name="id" id="id" value="<?=$user_data['id']?>"/>
			<input type="hidden" name="csrf_token" value="<?=$csrf_token?>">
			</form>
      </div>
    </section>
  </div>
  <!-- /.main --> 

<script>
(function( $ ) {
	$(function() {
		$('#chg_psw_form').bootstrapValidator({
			fields: {
				password: {
					validators: {
						notEmpty: {
							message: 'Please enter new password.'
						},
						identical: {
							field: 'password2',
							message: 'New password and confirm password not matched.'
						}
					}
				},
				password2: {
					validators: {
						notEmpty: {
							message: 'Please enter confirm password.'
						},
						identical: {
							field: 'password',
							message: 'New password and confirm password not matched.'
						}
					}
				}
			}
		}).on('success.form.bv', function(e) {
            $('#chg_psw_form').data('bootstrapValidator').resetForm();

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