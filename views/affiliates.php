<?php
$csrf_token = generateFormToken('affiliate'); ?>

<div id="breadcrumb">
	<div class="wrap">
		<ul>
			<li><a href="<?=SITE_URL?>">Home</a></li>
			<li class="active"><a href="#"><?=$active_page_data['menu_name']?></a></li>
		</ul>
	</div>
</div>

<div id="main">
	<div class="affiliate-page common-two-col-page">
	
	<?php
	//Header Image
	if($active_page_data['image'] != "") { ?>
		<section id="head-graphics">
			<img src="<?=SITE_URL.'images/pages/'.$active_page_data['image']?>" class="img-fluid">
			<div class="header-caption">
				<h2><?=$active_page_data['title']?></h2>
			</div>
		</section>
	<?php
	} ?>
	  
	  <!-- Select Your Model -->
	  <section class="white-bg">
		<div class="wrap">
		  <div class="content-block">
			<div class="row">
				<form action="controllers/affiliates.php" method="post" id="affiliate_form">
				<div class="col-sm-8">
					<div class="sectionbox">
						<div class="row">
							<div class="col-sm-6">
								<div class="form_group form-group">
									<input type="text" class="textbox" name="name" id="name" placeholder="Enter name">
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form_group form-group">
									<input class="textbox" type="tel" id="cell_phone" name="cell_phone">
									<input type="hidden" name="phone" id="phone" />
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form_group form-group">
									<input type="text" class="textbox" name="email" id="email" placeholder="Enter email">
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form_group form-group">
									<input type="text" class="textbox" name="company" id="company" placeholder="Enter company name">
								</div>
							</div>
							
							
							<div class="col-sm-6">
								<div class="form_group form-group">
									<input type="text" class="textbox" name="subject" id="subject" placeholder="Enter subject">
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form_group form-group">
									<input type="text" class="textbox" name="web_address" id="web_address" placeholder="Enter web address">
								</div>
							</div>
	
							<div class="col-sm-12">
								<div class="form_group form-group mb0">
									<textarea class="textbox" name="message" id="message" placeholder="Enter message"></textarea>
								</div>
							</div>
							
							<?php
							if($affiliate_form_captcha == '1') { ?>
								<div class="col-md-12">
									<div class="form-group">
										<div id="g_form_gcaptcha"></div>
										<input type="hidden" id="g_captcha_token" name="g_captcha_token" value=""/>
									</div>
								</div>
							<?php
							} ?>
							  
							<div class="col-sm-12 btn_row">
								<button type="submit" class="btn btn-blue-bg">SUBMIT</button>
								<input type="hidden" name="submit_form" id="submit_form" />
							</div>
						</div>
					</div>
				</div>
				<input type="hidden" name="csrf_token" value="<?=$csrf_token?>">
				</form>
				
				<div class="col-sm-4 sidebar">
					<div class="sectionbox">
						<?=$active_page_data['content']?>
					</div>
				</div>
				
			</div>
		  </div>
		</div>
	  </section>
	</div>
</div>

<?php
if($affiliate_form_captcha == '1') {
	echo '<script src="https://www.google.com/recaptcha/api.js?onload=CaptchaCallback&render=explicit"></script>';
} ?>
<script>
<?php
if($affiliate_form_captcha == '1') { ?>
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
		var telInput = $("#cell_phone");
		telInput.intlTelInput({
		  initialCountry: "auto",
		  geoIpLookup: function(callback) {
			$.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
			  var countryCode = (resp && resp.country) ? resp.country : "";
			  callback(countryCode);
			});
		  },
		  utilsScript: "js/intlTelInput-utils.js" //just for formatting/placeholders etc
		});

		// on keyup / change flag: reset
		telInput.on("keyup change", reset);
	});
})(jQuery);

(function( $ ) {
	$(function() {
		$('#affiliate_form').bootstrapValidator({
			fields: {
				name: {
					validators: {
						stringLength: {
							min: 1,
						},
						notEmpty: {
							message: 'Please enter name'
						}
					}
				},
				cell_phone: {
					validators: {
						callback: {
							message: 'Please enter valid phone number',
							callback: function(value, validator, $field) {
								var telInput = $("#cell_phone");
								$("#phone").val(telInput.intlTelInput("getNumber"));
								if(!telInput.intlTelInput("isValidNumber")) {
									return false;
								} else if(telInput.intlTelInput("isValidNumber")) {
									return true;
								}
							}
						}
					}
				},
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
            $('#affiliate_form').data('bootstrapValidator').resetForm();

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