<?php
$csrf_token = generateFormToken('affiliate');

if(isset($_SESSION['affiliate_prefill_data'])) {
	$affiliate_prefill_data = $_SESSION['affiliate_prefill_data'];
	unset($_SESSION['affiliate_prefill_data']);
}

$affiliate_form_link = SITE_URL.get_inbuild_page_url('affiliates');

$is_show_title = true;
$header_section = $active_page_data['header_section'];
$header_image = $active_page_data['image'];
$show_title = $active_page_data['show_title'];
$image_text = $active_page_data['image_text'];
$page_title = $active_page_data['title'];
?>

<section id="breadcrumb" class="<?=$active_page_data['css_page_class']?> py-0">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="block breadcrumb clearfix">
					<ul class="breadcrumb m-0">
						<li class="breadcrumb-item">
							<a href="<?=SITE_URL?>">Home</a>
						</li>
						<li class="breadcrumb-item active"><a href="javascript:void(0);"><?=$active_page_data['menu_name']?></a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</section>

<?php
//Header Image
if($header_section == '1' && ($header_image || $show_title == '1' || $image_text)) { ?>
	<section class="head-graphics <?=$active_page_data['css_page_class']?>" id="head-graphics" <?php if($header_image != ""){echo 'style="background-image: url('.SITE_URL.'images/pages/'.$header_image.')"';}?>>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="block header-caption text-center">
						<?php
						if($show_title == '1') {
							echo '<h1>'.$page_title.'</h1>';
						}
						if($image_text) {
							echo '<p>'.$image_text.'</p>';
						} ?>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php
$is_show_title = false;
} ?>

<?php
if($is_show_title && $show_title == '1') { ?>
	<section id="head-graphics-title" class="<?=$active_page_data['css_page_class']?>">
		<div class="container">
			<div class="col-md-12">
				<div class="block heading page-heading text-center">
					<h3><?=$page_title?></h3>
				</div>
			</div>
		</div>
	</section>
<?php
} ?>

<section class="<?=$active_page_data['css_page_class']?>">
	<div class="container">
		<div class="row">
			<div class="col-md-8">
				<div class="block">
					<form action="controllers/affiliates.php" method="post" id="affiliate_form">
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<input type="text" class="form-control" name="name" id="name" placeholder="Enter name">
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<input class="form-control" type="tel" id="cell_phone" name="cell_phone">
									<input type="hidden" name="phone" id="phone" />
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form-group">
									<input type="text" class="form-control" name="email" id="email" placeholder="Enter email">
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form-group">
									<input type="text" class="form-control" name="company" id="company" placeholder="Enter company name">
								</div>
							</div>
							<!--<div class="col-sm-6">
								<div class="form-group">
									<input type="text" class="form-control" name="subject" id="subject" placeholder="Enter subject">
								</div>
							</div>-->
							<div class="col-sm-4">
								<div class="form-group">
									<input type="text" class="form-control" name="web_address" id="web_address" placeholder="Enter web address">
								</div>
							</div>
							<div class="col-sm-12">
								<div class="form-group mb0">
									<textarea class="form-control" name="message" id="message" placeholder="How will you promote us?"></textarea>
								</div>
							</div>
							
							<div class="col-sm-12">
								<div class="form-group mb0">	
									<?=$affiliate_form_link.'/?shop='?><input type="text" class="form-control rounded-0 w-25 d-inline-block border-top-0 border-right-0 border-left-0" name="shop_name" id="shop_name" placeholder="Shop name" value="<?=(isset($affiliate_prefill_data['shop_name'])?$affiliate_prefill_data['shop_name']:'')?>">
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
								<button type="submit" class="btn btn-primary">SUBMIT</button>
								<input type="hidden" name="submit_form" id="submit_form" />
							</div>
						</div>
						<input type="hidden" name="csrf_token" value="<?=$csrf_token?>">
					</form>
				</div>
			</div>
			<div class="col-md-4">
				<div class="block">
					<?=$active_page_data['content']?>
				</div>
			</div>
		</div>
	</div>
</section>

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
		  initialCountry: "<?=$phone_country_short_code?>",
		  allowDropdown: false,
		  geoIpLookup: function(callback) {
			$.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
			  var countryCode = (resp && resp.country) ? resp.country : "";
			  callback(countryCode);
			});
		  },
		  utilsScript: "js/intlTelInput-utils.js" //just for formatting/placeholders etc
		});
		
		<?php
		if(isset($affiliate_prefill_data['phone']) && $affiliate_prefill_data['phone']) { ?>
		$("#cell_phone").intlTelInput("setNumber", "<?=$affiliate_prefill_data['phone']?>");
		<?php
		} ?>
	
		$('#affiliate_form').bootstrapValidator({
			fields: {
				name: {
					validators: {
						stringLength: {
							min: 1,
						},
						notEmpty: {
							message: 'Enter name'
						}
					}
				},
				cell_phone: {
					validators: {
						callback: {
							message: 'Enter valid phone number',
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
							message: 'Enter email address'
						},
						emailAddress: {
							message: 'Enter valid email address'
						}
					}
				},
				message: {
					validators: {
						stringLength: {
							min: 1,
						},
						notEmpty: {
							message: 'Enter how will you promote us?'
						}
					}
				},
				shop_name: {
					validators: {
						stringLength: {
							min: 1,
						},
						notEmpty: {
							message: 'Enter shop name'
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