<?php 
require_once("include/login/header.php");

if(!empty($_SESSION['is_admin']) && $_SESSION['username']!="")
	setRedirect(ADMIN_URL.'profile.php');
?>

<script type="text/javascript">
function check_form(a){
	if(a.email.value.trim()==""){
		alert('Please enter your email');
		a.email.focus();
		a.email.value='';
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
			
        <form action="controllers/admin_user/lostlogin.php" method="post" role="form" onSubmit="return check_form(this);">
            <h3>Lost Password</h3>
            <div class="control-group">
                <label class="control-label" for="input">Email Address</label>
                <div class="controls">
                   <input type="email" class="form-control" name="email" placeholder="Enter email" autocomplete="off" />
                    <p class="help-block">Enter your email, and we will sent password reset link on your registered email.</p>
                </div>
            </div>
            <button class="btn btn-alt btn-large btn-primary" type="submit" name="reset">Submit</button>
            <div class="login-credits text-center"> <a class="login-link new-account" href="index.php">Return to Login Page</a></div>
        </form>
   </section>
</body>

<?php
//Footer section
require_once("include/login/footer.php"); ?>
