<?php
//Get from index.php, get_device_single_data function
$device_single_data=$device_single_data_resp['device_single_data'];
$device_id = $device_single_data['d_device_id'];
if($device_id>0) {
	$meta_title = $device_single_data['d_meta_title'];
	$meta_desc = $device_single_data['d_meta_desc'];
	$meta_keywords = $device_single_data['d_meta_keywords'];

	//$main_title = "Sell Your ".$device_single_data['device_title'];
	//$main_sub_title = $device_single_data['device_sub_title'];
	$description = $device_single_data['description'];
	$main_img = '<img class="image" src="images/apple_header_img.jpg" alt="" class="img-fluid">';
	
	$sub_title = $device_single_data['device_sub_title'];
	$short_description = $device_single_data['short_description'];
	$description = $device_single_data['description'];

	//Header section
	include("include/header.php");
} else {
	//$main_title = ($active_page_data['show_title']?$active_page_data['title']:'');
	//$main_sub_title = '';
	$description = $active_page_data['content'];
	if($active_page_data['image']) {
		$main_img = '<img class="img-fluid" src="'.SITE_URL.'images/pages/'.$active_page_data['image'].'" alt="'.$active_page_data['title'].'">';
	}
}

//Fetching data from model
require_once('models/model.php');

/*$brand_data_list = get_device_brands_data_list($device_id, $devices_id);
if(count($brand_data_list)>1) { ?>
  <section id="showCategory" class="pb-0">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
          <div class="block heading page-heading text-center">
            <h3>Сhoose a brand</h3>
          </div>
          <div class="block device-brands clearfix">
            <div class="brand-roll">
			    <?php
				foreach($brand_data_list as $brand_data) {
				  if($brand_data['brand_img']) { ?>
					  <div class="brand">
						<a href="<?=SITE_URL.$brand_data['device_sef_url'].'/'.$brand_data['brand_sef_url']?>">
						<?php
						if($brand_data['brand_img']) {
							$md_img_path = SITE_URL.'images/brand/'.$brand_data['brand_img'];
							echo '<img src="'.$md_img_path.'" alt="'.$brand_data['brand_title'].'">';
						} ?>
						</a>
					  </div>
				  <?php
				  }
				} ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  
	<?php
	if($description) { ?>
		<section class="sectionbox">
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
<?php
} else {*/
	//Get data from models/model.php, get_model_data_list function
	$model_data_list = get_model_data_list($device_id, $devices_id, $cat_id);
	$model_num_of_rows = count($model_data_list);
	if($model_num_of_rows>0) { ?>
	  <section id="showCategory">
		<div class="container-fluid">
		  <div class="row">
			<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
			  <div class="block heading text-center">
			    <?php
				if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER']) { ?>
			    <a class="btn btn-primary rounded-pill back-button" href="javascript:void(0);" onclick="history.back();">Back</a>
				<?php
				} ?>
				<h3>Choose you model<span> to calculate the cost:</span></h3>
				<form action="<?=SITE_URL?>search" method="post">
				  <div class="form-group">
					<input type="text" name="search" class="form-control border-bottom border-top-0 border-right-0 border-left-0 center mx-auto srch_list_of_model" id="autocomplete" placeholder="<?=$searchbox_placeholder?>">
				  </div>
				</form>
			  </div>
			  <div class="block devices inner_page_step clearfix">
				<div class="row category model-category pb-5 justify-content-center">					
				<?php
				$cat_ids_array = array();
				foreach($model_data_list as $model_list) {
				  $cat_ids_array[] = $model_list['cat_id'];
				  
				  $model_upto_price = 0;
				  $model_upto_price_data = get_model_upto_price($model_list['id'],$model_list['price']);
				  $model_upto_price = $model_upto_price_data['price']; ?>
				  <div class="col-6 col-md-6 col-lg-3 p-2">
					<a href="<?=SITE_URL.$model_details_page_slug.$model_list['sef_url']?>" class="card">
					  <div class="image">
						<?php
						if($model_list['model_img']) {
							//$md_img_path = SITE_URL.'libraries/phpthumb.php?imglocation='.SITE_URL.'images/mobile/'.$model_list['model_img'].'&h=138';
							$md_img_path = SITE_URL.'images/mobile/'.$model_list['model_img'];
							echo '<img src="'.$md_img_path.'" alt="'.$model_list['title'].'">';
						} ?>
					  </div>
					  <h5><?=$model_list['title']?></h5>
					  <?php
					  if($model_upto_price>0) {
					  	echo '<h6 class="price">Up to '.amount_fomat($model_upto_price).'</h6>';
					  } ?>
					</a>
				  </div>
				<?php
				}
				
				if($general_setting_data['missing_product_section']=='1') { ?>
				  <div class="col-6 col-md-6 col-lg-3 p-2">
					<a href="javascript:void(0);" data-toggle="modal" data-target="#MissingProduct" class="card">
					  <div class="image">
						<?php
						$md_img_path = SITE_URL.'images/iphone.png';
						echo '<img src="'.$md_img_path.'" alt="Missing Product">'; ?>
					  </div>
					  <h5>Missing Product</h5>
					  <h6 class="price">&nbsp;</h6>
					</a>
				  </div>
				<?php
				}
				if($general_setting_data['missing_product_section']=='1') { ?>
				<div class="modal fade common_popup" id="MissingProduct" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
					<div class="modal-dialog modal-md" role="document">
					  <div class="modal-content">
						<div class="modal-header">
						  <h5 class="modal-title">Can’t Find Your Item?</h5>
						  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<img src="<?=SITE_URL?>images/payment/close.png" alt="">
						  </button>
						</div>
						<div class="modal-body pt-3 text-center">
							<form method="post" action="<?=SITE_URL?>controllers/model.php" id="req_quote_form" class="sign-in">
								<p>If you want to find out how much your item is worth, please fill out the form below and we will reply to your email within 24 hours. Remember, the more information you include about the item(s) you are trying to sell, the easier it is for us to make you an offer. Please fill out a good contact number and email address in case we need to ask you a few more questions.</p>
								
								<div class="form-row">
								  <div class="form-group col-md-6">
									<img src="<?=SITE_URL?>images/icons/user-gray.png" alt="">
									<input type="text" class="form-control" name="name" id="name" placeholder="Enter name">
									<div class="invalid-feedback">
									  Name Required
									</div>
								  </div>
								  <div class="form-group mt-0 col-md-6">
									<img src="<?=SITE_URL?>images/icons/user-gray.png" alt="">
									<input type="tel" id="cell_phone" name="cell_phone" class="form-control" placeholder="">
									<input type="hidden" name="phone" id="phone" />
									<div class="invalid-feedback">
									  Phone Required
									</div>
								  </div>
								</div>
								<div class="form-row">
								  <div class="form-group col-md-6">
									<img src="<?=SITE_URL?>images/icons/user-gray.png" alt="">
									<input type="text" class="form-control" name="email" id="email" placeholder="Enter email">
									<div class="invalid-feedback">
									  Email Required
									</div>
								  </div>
								  <div class="form-group mt-0 col-md-6">
									<img src="<?=SITE_URL?>images/icons/user-items.png" alt="">
									<input type="text" class="form-control" name="item_name" id="item_name" placeholder="Enter name of your item">
									<div class="invalid-feedback">
									  Phone Required
									</div>
								  </div>
								</div>
								<div class="form-row">
								  <div class="form-group col-md-12">
									<img src="<?=SITE_URL?>images/icons/user-comment.png" alt="">
									<textarea name="message" id="message" placeholder="Enter message" class="form-control"></textarea>
									<div class="invalid-feedback">
									  Email Required
									</div>
								  </div>
								</div>
								
								<?php
								if($missing_product_form_captcha == '1') { ?>
								<div class="form-row">
									<div class="form-group col-md-12">
										<div id="g_form_gcaptcha"></div>
										<input type="hidden" id="g_captcha_token" name="g_captcha_token" value=""/>
									</div>
								</div>
								<?php
								} ?>
								
								<div class="form-group double-btn pt-5 text-center">
								  <button type="submit" class="btn btn-primary btn-lg rounded-pill ml-lg-3">Submit</button>
								  <input type="hidden" name="missing_product" id="missing_product" />
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
						  initialCountry: "<?=$phone_country_short_code?>",
		 				  allowDropdown: false,
						  geoIpLookup: function(callback) {
							$.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
							  var countryCode = (resp && resp.country) ? resp.country : "";
							  callback(countryCode);
							});
						  },
						  utilsScript: "<?=SITE_URL?>js/intlTelInput-utils.js" //just for formatting/placeholders etc
						});
				
						//on keyup / change flag: reset
						//telInput.on("keyup change", reset);
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
				</div>
			  </div>
			</div>
		  </div>
		</div>
	  </section>
	
	  <section id="haveQuestion">
		<div class="container-fluid">
		  <div class="col-md-12">
			<div class="block heading have_main_text text-center clearfix">
			  <h3 class="py-4">Have a Question?</h3>
			  <a href="javascript:void(0);" data-toggle="modal" data-target="#contactusForm" class="btn btn-tertiary btn-lg my-2 rounded-pill">Contact Us</a>
			</div>
		  </div>
		</div>
	  </section>
	
		<section id="whyChoose" class="gray-bg">
		<a name="why-us"></a>
		<div class="container">
		  <div class="row">
			<div class="col-md-12">
			  <div class="block heading text-center clearfix">
				<h3>Why choose us?</h3>
			  </div>
			  <div class="block why-choose">
				<div class="card-group">		
					<div class="card">
						<div class="card-body">
						  <img src="<?=SITE_URL?>images/section/120191014071821.png" class="img-fluid" alt=""><h5 class="card-title">We pay more then<br> any other buy back service</h5><p>Industry leading professional GPS<br> tracking and communication.</p>								
						</div>
					</div>
									
					<div class="card">
						<div class="card-body">
						  <img src="<?=SITE_URL?>images/section/220191014071821.png" class="img-fluid" alt=""><h5 class="card-title">No risk. 100%<br> satisfaction guaranteed</h5><p>Plan the truck trip with the most<br> advanced truck route calculator zero.</p>								
						</div>
					</div>
									
					<div class="card">
						<div class="card-body">
						  <img src="<?=SITE_URL?>images/section/320191014071821.png" class="img-fluid" alt=""><h5 class="card-title">We pay in 24 hours<br> after we got the parcel</h5><p>Plan the truck trip with the most<br> advanced truck route calculator.</p>								
						</div>
					</div>
				</div>
			  </div>
			  <div class="block text-center clearfix">
				<a href="<?=SITE_URL?>#category-section" class="btn btn-primary rounded-pill btn-lg mr-0 my-2">Get Started</a>
			  </div>
			</div>
		  </div>
		</div>
		</section>
  	
		<?php
		if($description) { ?>
			<section class="sectionbox white-bg">
				<div class="container">
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
			</div>
			</section>
		<?php
		} ?>
			
		<?php
		if(!empty($cat_ids_array)) {
			$faqs_groups_data_html = get_faqs_groups_with_html(array(),array_unique($cat_ids_array),'model_list');
			if($faqs_groups_data_html['html']!="") { ?>
				<section class="faq_page">
					<div class="container">
						<div class="block setting-page clearfix">
							<div class="wrap">
								<?=$faqs_groups_data_html['html']?>
							</div>
						</div>
					</div>	
				</section>
			<?php	
			}
		}
	} else { ?>
	  <section id="showCategory" class="pb-0 pt-0">
		<div class="container-fluid">
		  <div class="row">
			<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
			  <div class="block text-center">
				<h3>Items not available</h3>
			  </div>
			</div>
		  </div>
		</div>
	  </section>
	<?php
	}
//} ?>
