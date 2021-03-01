<?php
require_once("_config/config.php");
require_once("include/functions.php");

if($general_setting_data['is_ip_restriction'] == '0') {
	$allowed_ip_array=explode(',',$general_setting_data['allowed_ip']);
	$final_allowed_ip_array = array_map('trim',$allowed_ip_array);
	if(in_array(USER_IP,$final_allowed_ip_array)){
		setRedirect(ADMIN_URL);
	}
}
?>

<!DOCTYPE html>
<html class="no-js" lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Error 401</title>
		<meta name="robots" content="index, follow">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<!-- Styles -->
		<link rel="stylesheet" href="css/sangoma-dark.css">

		<!-- JS Libs -->
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	</head>
	<body class="error-page">
		<section class="container">
			<h1>401</h1>
			<p class="description">Whoops! Access denied...</p>
			<p>
			Sorry! You are not allowed to use this CRM. As your IP address is restricted.<br>
			<a href="/admin" class="btn btn-alt btn-large btn-primary" title="Try Again">Try Again</a><br><br>
			<strong>OR</strong> <br>
			<a href="javascript:void(0);" onClick="showVerifyAjaxModal('');return false;" class="btn btn-alt btn-large btn-black">Click here if you are owner?</a>
			</p>
		</section>

		<div class="modal primary fade" id="invoice_details_model">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h3 class="modal-title">Verify Your Details</h3>
					</div>
					<div class="modal-body">
						<form role="form" class="form-horizontal form-groups-bordered unauthorized_form" method="post">
							<div class="control-group">
								<label class="control-label" for="email">Email *</label>
								<div class="controls">
									<input type="email" class="input-large" name="email" id="email" required>
								</div>
							</div>

							<div class="control-group">
								<label class="control-label" for="password">Password *</label>
								<div class="controls">
									<input type="password" class="input-large" name="password" id="password" required>
								</div>
							</div>
							
							<div class="control-group token-field" style="display:none;">
								<label class="control-label" for="token">Token *</label>
								<div class="controls">
									<input type="text" class="input-large" name="token" id="token">
								</div>
							</div>

							<div class="form-actions">
								<button type="submit" class="btn btn-alt btn-large btn-primary submit" name="submit">Submit</button>
								<button type="button" class="btn btn-alt btn-large btn-black" data-dismiss="modal">Close</button>
							</div>
							<input type="hidden" id="is_token_sent" name="is_token_sent" value="0">
						</form>
					</div>
				</div>
			</div>
		</div>

		<!-- Bootstrap scripts -->
		<script src="js/bootstrap/bootstrap.min.js"></script>
		<script>
		function showVerifyAjaxModal(id) {
			jQuery(document).ready(function($) {
				$('#invoice_details_model').modal({backdrop: 'static',keyboard: false});
			});
		}
		
		jQuery(document).ready(function($) {
			$('.unauthorized_form').on('submit', function(e) {
				e.preventDefault();
				
				var email = $('#email').val();
				var password = $('#password').val();
				var token = $('#token').val();
				var is_token_sent = $('#is_token_sent').val();
				
				if(email == "" || password == "") {
					return false;
				}
				if(is_token_sent == '1' && token == "") {
					alert("Please enter your token");
					return false;
				}
				var post_data = $('.unauthorized_form').serialize();
				$.ajax({
					type: "POST",
					url:"ajax/unauthorized.php",
					data:post_data,
					success:function(data) {
						if(data!="") {
							var form_data = JSON.parse(data);
							console.log(form_data);
							if(form_data.status == true) {
								if(form_data.token_status == "" && token == "") {
									$('#is_token_sent').val('1');
									$('.token-field').show();
									alert(form_data.message);
								}
								if(form_data.token_status == "verified" && token != "") {
									window.location = "<?=ADMIN_URL?>";
								}
							} else {
								alert(form_data.message);
								return false;
							}
						}
					}
				});
			});
		});
		</script>
	</body>
</html>
