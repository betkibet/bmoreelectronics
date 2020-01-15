<script type="text/javascript">
function check_form(a){
	if(a.new_password.value.trim()==""){
		alert('Please enter your new password.');
		a.new_password.focus();
		a.new_password.value='';
		return false;
	}
	if(a.confirm_password.value.trim()==""){
		alert('Please enter your confirm password.');
		a.confirm_password.focus();
		a.confirm_password.value='';
		return false;
	}
	if(a.new_password.value.trim()!=a.confirm_password.value.trim()){
		alert('New password and confirm password not matched.');
		a.confirm_password.focus();
		a.confirm_password.value='';
		return false;
	}	
}
</script>

<body class="login">
	<!-- Main page container -->
	<section class="container" role="main">
		<?php include('confirm_message.php');?>
		<div class="login-logo">
			<a href="login.html" class="brand"><?=ADMIN_PANEL_NAME?></a>
			<h4>Welcome to <?=ADMIN_PANEL_NAME?></h4>
		</div>
		
		<form action="controllers/admin_user/confirm_password_reset.php" method="post" role="form" onSubmit="return check_form(this);">
            <h3>Change Password</h3>
            <div class="control-group">
                <label class="control-label" for="input">New Password</label>
                <div class="controls">
                   <input type="password" class="form-control" name="new_password" placeholder="New Password" autocomplete="off" />
                </div>
            </div>
			<div class="control-group">
                <label class="control-label" for="input">Confirm Password</label>
                <div class="controls">
                   <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password" autocomplete="off" />
                </div>
            </div>
            <div class="form-actions">
                <button class="btn btn-alt btn-large btn-primary" type="submit" name="reset">Submit</button>
            </div>
			<input type="hidden" name="uid" value="<?=@$check_token_data['id']?>" />
        </form>
	</section>
</body>
