<?php
//Get from index.php, get_device_single_data function
$device_single_data = $device_single_data_resp['device_single_data'];
$device_id = $device_single_data['device_id'];

//Get from index.php, get_brand_single_data_by_sef_url function
$brand_single_data = $brand_single_data_resp['brand_single_data'];
$brand_id = $brand_single_data['id'];
$sub_title = $brand_single_data['sub_title'];
$short_description = $brand_single_data['short_description'];
$description = $brand_single_data['description'];

$meta_title = $device_single_data['d_meta_title'];
$meta_desc = $device_single_data['d_meta_desc'];
$meta_keywords = $device_single_data['d_meta_keywords'];

//Fetching data from model
require_once('models/mobile.php');

//Get data from models/mobile.php, get_device_brand_models_data_list function
$model_data_list = get_device_brand_models_data_list($device_id, $brand_id);

//$main_title_last_word = "";
/*$fields_type = 	$model_data_list[0]['fields_type'];
if($fields_type == "mobile") {
	$main_title_last_word = "PHONE";
} else {
	$main_title_last_word = strtoupper($fields_type);
}*/

//$main_title = $device_single_data['device_title'];
//$main_title = 'SELL YOUR '.$brand_single_data['title'].' '.$main_title_last_word;
//$main_sub_title = $device_single_data['device_sub_title'];
$description = $brand_single_data['description'];

//Header section
include("include/header.php"); ?>

<div id="breadcrumb">
	<div class="wrap">
		<ul>
			<li><a href="<?=SITE_URL?>">Home</a></li>
			<li><a href="<?=SITE_URL.$device_single_data['sef_url']?>">Select Your Brand</a></li>
			<li class="active"><a href="javascript:void(0);">Select Your Model</a></li>
		</ul>
	</div>
</div>

<!-- head-graphics -->
<section id="head-graphics">
	<?=$main_img?>
	<div class="header-caption">
		<h2>Find Your <span>Model</span></h2>
		<p>Please Select Memory Size of your model to processed</p>
		<div class="device-h-search">
			<form action="<?=SITE_URL?>search" method="post">
				<input type="text" name="search" class="srch_list_of_model" placeholder="Search by device or model name..." required>
				<button type="submit"><i class="ico-search">Search</i></button>
			</form>
		</div>
	</div>
</section>

<!-- Main -->
<div id="main">
	<?php
	if(count($model_data_list)>0) { ?>
		<!-- Select Your Device -->
		<section id="select-device" class="sectionbox white-bg">
			<div class="wrap">
				<div class="sec-title"><h3>Select <strong>Your Model</strong></h3></div>
				<div class="content-block">
					<div class="list clearfix">
						<ul class="clearfix">
							<?php
							foreach($model_data_list as $model_list) { ?>
								<li><a href="<?=SITE_URL.$model_list['device_sef_url'].'/'.createSlug($model_list['title']).'/'.$model_list['id']?>">
									<div class="imgbox">
									<?php
									if($model_list['model_img']) {
										$md_img_path = SITE_URL.'libraries/phpthumb.php?imglocation=images/mobile/'.$model_list['model_img'].'&h=138';
										echo '<img src="'.$md_img_path.'" alt="'.$model_list['title'].'">';
									} ?>
									</div>
									<div class="btnbox"><?=$model_list['title']?></div>
									</a>
								</li>
							<?php
							}
							if($general_setting_data['missing_product_section']=='1') { ?>
							<li>
								<a href="javascript:void(0);" data-toggle="modal" data-target="#MissingProduct">
								<div class="imgbox">
								<?php
								$md_img_path = SITE_URL.'libraries/phpthumb.php?imglocation=images/iphone.png&h=138';
								echo '<img src="'.$md_img_path.'" alt="Missing Product">';
								?>
								</div>
								<div class="btnbox">
									Missing Product
								</div>
								</a>
							</li>
							<?php
							} ?>
						</ul>
					</div>
				</div>
			</div>
		</section>
	<?php
	} else { ?>
		<section id="select-device" class="sectionbox white-bg">
			<div class="wrap">
				<div><h3>Items not available</h3></div>
			</div>
		</section>
	<?php
	}

	//START quote request email...
	if($general_setting_data['missing_product_section']=='1') { ?>
	<div class="modal fade common_popup" id="MissingProduct" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog">
		<div class="modal-content">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<div class="modal-body">
				<form method="post" action="<?=SITE_URL?>controllers/mobile.php" id="req_quote_form">
					<h3 class="title">Can’t Find Your Item?</h3>
					<p>If you want to find out how much your item is worth, please fill out the form below and we will reply to your email within 24 hours. Remember, the more information you include about the item(s) you are trying to sell, the easier it is for us to make you an offer. Please fill out a good contact number and email address in case we need to ask you a few more questions.</p>
					<h3>Quote Request</h3>
					<div class="clearfix formbox">
						<div class="row">
							<div class="col-sm-6">
								<div class="form_group form-group">
									<input type="text" class="textbox" name="name" id="name" placeholder="Enter name">
								</div>
							</div>
							
							<div class="col-sm-6">
								<div class="form_group form-group">
									<input type="tel" id="cell_phone" name="cell_phone" class="textbox" placeholder="">
									<input type="hidden" name="phone" id="phone" />
								</div>
							</div>
							
							<div class="col-sm-12">
								<div class="form_group form-group">
									<input type="text" class="textbox" name="email" id="email" placeholder="Enter email">
								</div>
							</div>
							
							<div class="col-sm-12">
								<div class="form_group form-group">
									<input type="text" class="textbox" name="item_name" id="item_name" placeholder="Enter name of your item">
								</div>
							</div>
							
							<div class="col-sm-12">
								<div class="form_group form-group">
									<textarea name="message" id="message" placeholder="Enter message" class="textbox"></textarea>
								</div>
							</div>
							
							<?php
							if($missing_product_form_captcha == '1') { ?>
							<div class="col-sm-12">
								<div class="form_group form-group">
									<div id="g_form_gcaptcha"></div>
									<input type="hidden" id="g_captcha_token" name="g_captcha_token" value=""/>
								</div>
							</div>
							<?php
							} ?>
							
							 <div class="col-sm-12">
								<div class="form_group">
									<button type="submit" class="btn btn_md btn-blue">Submit</button>
									<input type="hidden" name="missing_product" id="missing_product" />
								</div>
							</div>
						</div>
					</div>
					<?php
					$csrf_token = generateFormToken('missing_product_form'); ?>
					<input type="hidden" name="csrf_token" value="<?=$csrf_token?>">
				</form>
			</div>
		</div>
	  </div>
	</div>
	
	<?php
	if($missing_product_form_captcha == '1') {
		echo '<script src="https://www.google.com/recaptcha/api.js?onload=CaptchaCallback&render=explicit"></script>';
	} ?>
	<script>
	<?php
	if($missing_product_form_captcha == '1') { ?>
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
			  utilsScript: "<?=SITE_URL?>js/intlTelInput-utils.js" //just for formatting/placeholders etc
			});
	
			//on keyup / change flag: reset
			telInput.on("keyup change", reset);
		});
	})(jQuery);
	
	(function( $ ) {
		$(function() {
			$('#req_quote_form').bootstrapValidator({
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
					},
					item_name: {
						validators: {
							notEmpty: {
								message: 'Please enter item name'
							}
						}
					},
					message: {
						validators: {
							notEmpty: {
								message: 'Please enter your message'
							}
						}
					}
				}
			}).on('success.form.bv', function(e) {
				$('#req_quote_form').data('bootstrapValidator').resetForm();
	
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
	<?php
	} ?>

  <?php
  if($description) { ?>
	<section class="sectionbox white-bg">
		<div class="wrap">
		<?php
		if($sub_title!="" || $short_description!="") { ?>
		<div class="row">
		  <div class="col-md-12">
			<div class="block clearfix">
			  <div class="head pb-3 text-center clearfix">
				<?php
				if($sub_title!="") { ?>
				<div class="sec-title"><h3><strong><?=$sub_title?></strong></h3></div>
				<?php
				}
				if($short_description!="") { ?>
				<div class="h3"><?=$short_description?></div>
				<?php
				} ?>
			  </div>
			</div>
		  </div>
		</div>
		<?php
		}
		echo $description; ?>
		</div>
	</section>
  <?php
  } ?>
  
</div>