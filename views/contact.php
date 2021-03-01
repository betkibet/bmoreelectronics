<?php
$csrf_token = generateFormToken('contact');

$is_show_title = true;
$header_section = $active_page_data['header_section'];
$header_image = $active_page_data['image'];
$show_title = $active_page_data['show_title'];
$image_text = $active_page_data['image_text'];
$page_title = $active_page_data['title'];

//Url encode for embed map
$business_address = trim(urlencode($company_name.' '.$company_address.' '.$company_city.' '.$company_state.' '.$company_zipcode));

$service_hours_data = get_service_hours_data();
$open_time = json_decode($service_hours_data['open_time'],true);
$open_time_zone = json_decode($service_hours_data['open_time_zone'],true);
$hours_opening = @array_merge_recursive($open_time, $open_time_zone);
$close_time = json_decode($service_hours_data['close_time'],true);
$close_time_zone = json_decode($service_hours_data['close_time_zone'],true);
$hours_closing = @array_merge_recursive($close_time, $close_time_zone);
$opening_slot = @array_merge_recursive($hours_opening, $hours_closing);
$closed = json_decode($service_hours_data['is_close'],true);

$new_array = array();
if($open_time > 0) {
	foreach($open_time as $k => $v) {
		switch($k) {
			case "sunday":
				$day_order=7;
				break;
			case "monday":
				$day_order=1;
				break;	
			case "tuesday":
				$day_order=2;
				break;
			case "wednesday":
				$day_order=3;
				break;
			case "thursday":
				$day_order=4;
				break;
			case "friday":
				$day_order=5;
				break;
			case "saturday":
				$day_order=6;
				break;
		}
		if(array_key_exists($k, $open_time_zone)) {
			$new_array1_day[$k] = '<tr><td><strong>'.ucfirst(substr($k,0,3)).'</strong></td><td><a href="javascript:void(0)" class="time_box"> '.$v.$open_time_zone[$k].' - '.$close_time[$k].$close_time_zone[$k].'</a></td></tr>';
			$new_array1[$day_order] = '<tr><td><strong>'.ucfirst(substr($k,0,3)).'</strong></td><td>'.$v.$open_time_zone[$k].' - '.$close_time[$k].$close_time_zone[$k].'</td></tr>';
		}
	}
}

if(count($closed) > 0) {
	foreach($closed as $k => $v) {
		if($k!='' && $v!='') {
			switch($k) {
				case "sunday":
					$day_order=7;
					break;
				case "monday":
					$day_order=1;
					break;	
				case "tuesday":
					$day_order=2;
					break;
				case "wednesday":
					$day_order=3;
					break;
				case "thursday":
					$day_order=4;
					break;
				case "friday":
					$day_order=5;
					break;
				case "saturday":
					$day_order=6;
					break;
			}
			$new_array1_day[$k] = '<tr><td><strong>'.ucfirst(substr($k,0,3)).'</strong></td><td><a href="javascript:void(0)" class="time_box">Closed</a></td></tr>';
			$new_array1[$day_order] = '<tr><td><strong>'.ucfirst(substr($k,0,3)).'</strong></td><td>Closed</td></tr>';
		}
	}
}

$is_office_open = 'yes';
$office_open_close_status = "";
$servertime = date('H:i');
$server_time = strtotime($servertime);
$server_timeday = strtolower(date('l',$server_time));
if(count($open_time) > 0) {
	foreach($open_time as $k => $v) {
		if($k==$server_timeday) {
			$opentimezone = $v;
			$opentimezone_label = $v.' '.$open_time_zone[$k];
			$closetimezone = $close_time[$k];
			
			$exp_opentimezone = explode(':',$v);
			if($v!='00:00' && $exp_opentimezone[0]!='00')
				$opentimezone = $v.' '.$open_time_zone[$k];
			if($close_time[$k]!='00:00')
				$closetimezone = $close_time[$k].' '.$close_time_zone[$k];

			$server_time=date('H:i',$server_time);
			$opening_time=date('H:i',strtotime($opentimezone));
			$closing_time=date('H:i',strtotime($closetimezone));

			if($v=="") {
				$is_office_open = 'no';
				$office_open_close_status = 'Today: Closed On '.ucfirst($server_timeday).' <span class="opennow">Closed Now</span>';
			} elseif($opening_time <= $server_time && $closing_time >= $server_time) {
				$is_office_open = 'yes';
				$office_open_close_status = 'Today: '.$opentimezone_label.' - '.$closetimezone.'<br><span class="opennow">Open Now</span>';	
			} else {
				$is_office_open = 'no';
				$office_open_close_status = 'Today: '.$opentimezone_label.' - '.$closetimezone.'<br><span class="opennow">Closed Now</span>';		
			}
		}
	}
}

if(count($closed) > 0) {
	foreach($closed as $k => $v) {
		if($k!="" && $v!="" && $k==$server_timeday) {
			$is_office_open = 'no';
			$office_open_close_status = 'Today: Closed On '.ucfirst($server_timeday).'<br><span class="opennow">Closed Now</span>';	
		}
	}
}
							
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
					<?php if($office_open_close_status) { ?>
							<p class="<?=($is_office_open=='no'?'office_close':'')?>"><?=$office_open_close_status?></p>
						<?php } ?>
				</div>
			</div>
		</div>
	</section>
<?php
} ?>
    
    <!-- Select Your Device -->
    <section id="contact-detail" class="<?=$active_page_data['css_page_class']?> white-bg">
    	<div class="container-fluid">
        	<div class="row">
            	<div class="col-sm-4">
                	<div class="contact_block">
                    	<div class="inner">
                        	<div class="img_box"><img src="images/ico_map.png" class="img-fluid"></div>
                        	<h5>Our Address</h5>
							<p>
							<?php
							if($company_name) {
								echo '<strong>'.$company_name.'</strong>';
							}
							if($company_address) {
								echo '<br />'.$company_address;
							}
							if($company_city) {
								echo '<br />'.$company_city.' '.$company_state.' '.$company_zipcode.' '.$company_country;
							} ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                	<div class="contact_block">
                    	<div class="inner">
                        	<div class="img_box"><img src="images/ico_phone.png" class="img-fluid"></div>
                        	<h5>Phone & Email</h5>
							<p>
							<?php
							if($site_phone) {
								echo '<a href="tel:'.$site_phone.'">Phone: '.$site_phone.'</a>';
							}
							if($site_email) {
								echo '<br><a href="mailto:'.$site_email.'">Email: '.$site_email.'</a>';
							} ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                	<div class="contact_block">
						<div class="inner">
							<div class="img_box"><img src="images/ico_clock.png" class="img-fluid"></div>
							<h5>Working Hours</h5>
							<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Show Hours</button>
						</div>
                    </div>
                  </div>
                </div>
            </div> 
        </div>
    </section>

		<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Working Hours</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<img src="<?=SITE_URL?>images/payment/close.png" alt="">
						</button>
					</div>
					<div class="modal-body pt-0">
						<table class="table">
							<?=$new_array1_day[strtolower(date('l'))]?>
							<?php
							@ksort($new_array1);
							if (!empty($new_array1)) {
								foreach ($new_array1 as $k => $v) {
									echo $v;
								}
							}
							?>    
						</table>
					</div>
				</div>
			</div>
		</div>

		
    
    <!-- Select Your Device -->
    <section id="map" class="<?=$active_page_data['css_page_class']?> white-bg">
    	<div class="google-map">
        	<?php
			if($business_address && $map_key) { ?>
				<iframe width="100%" height="425px" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/search?q=<?=$business_address?>&key=<?=$map_key?>" allowfullscreen></iframe>
			<?php
			} ?>
        </div>
    </section>
    
	<form action="controllers/contact.php" class="phone-sell-form" method="post" id="contact_form">
    <section id="contact-form" class="<?=$active_page_data['css_page_class']?> clearfix">
    	<div class="container-fluid">
				<div class="row">
					<div class="col-md-12">
						<div class="block">
							<h3>Let's Talk about your business</h3>
							<p class="para"><?=$active_page_data['content']?></p>
							<div class="form-outer">
								<div class="row">
									<div class="col-sm-6">
										<div class="form_group form-group">
											<input type="text" class="form-control" name="name" id="name" placeholder="Enter name">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form_group form-group">
											<input type="tel" id="cell_phone" name="cell_phone" class="form-control" placeholder="">
											<input type="hidden" name="phone" id="phone" />
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<div class="form_group form-group">
											<input type="text" class="form-control" name="email" id="email" placeholder="Enter email">
										</div>
										<div class="form_group form-group">
											<input type="text" class="form-control" name="order_id" id="order_id" placeholder="Enter order number">
										</div>
										<div class="form_group form-group">
											<input type="text" class="form-control" name="subject" id="subject" placeholder="Enter subject">
										</div>
									</div>

									<div class="col-sm-6">
										<div class="form_group form-group">
											<textarea class="form-control" name="message" id="message" placeholder="Enter message"></textarea>
										</div>
									</div>
								</div>
								<?php
								if($contact_form_captcha == '1') { ?>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<div id="g_form_gcaptcha"></div>
												<input type="hidden" id="g_captcha_token" name="g_captcha_token" value=""/>
											</div>
										</div>
									</div>
								<?php
								} ?>
								<div class="row">
									<div class="col-sm-12 btn_row">
										<button class="btn btn-primary" type="submit">Submit</button>
										<input type="hidden" name="submit_form" id="submit_form" />
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
      </div>
    </section>
		<input type="hidden" name="csrf_token" value="<?=$csrf_token?>">
  </form>
  

<?php
if($contact_form_captcha == '1') {
	echo '<script src="https://www.google.com/recaptcha/api.js?onload=CaptchaCallback&render=explicit"></script>';
} ?>
<script>
<?php
if($contact_form_captcha == '1') { ?>
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
		//jQuery("#submit_form").removeAttr("disabled");
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

		// on keyup / change flag: reset
		//telInput.on("keyup change", reset);
	});
})(jQuery);

(function( $ ) {
	$(function() {
		$('#contact_form').bootstrapValidator({
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
				subject: {
					validators: {
						notEmpty: {
							message: 'Please enter your subject'
						}
					}
				},
				message: {
					validators: {
						notEmpty: {
							message: 'Please enter your message'
						}
					}
				}/*,
				g_captcha_token: {
					validators: {
						notEmpty: {
							message: 'Please verify that you are not a robot.'
						}
					}
				}*/
			}/*,
			submitHandler: function(validator, form, submitButton) {
				var g_captcha_token = $("#g_captcha_token").val();
				if(g_captcha_token == "") {
					alert("Please verify that you are not a robot.");
					return false;
				} else {
					return true;
				}
			}*/
		}).on('success.form.bv', function(e) {
            $('#contact_form').data('bootstrapValidator').resetForm();

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
