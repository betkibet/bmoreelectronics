<?php
$csrf_token = generateFormToken('contact');

//Url encode for embed map
$business_address = trim(urlencode($company_name.' '.$company_address.' '.$company_city.' '.$company_state.' '.$company_zipcode));

$service_hours_data = get_service_hours_data();
$open_time=json_decode($service_hours_data['open_time'],true);
$open_time_zone = json_decode($service_hours_data['open_time_zone'],true);
$hours_opening=@array_merge_recursive($open_time, $open_time_zone);
$close_time=json_decode($service_hours_data['close_time'],true);
$close_time_zone = json_decode($service_hours_data['close_time_zone'],true);
$hours_closing=@array_merge_recursive($close_time, $close_time_zone);
$opening_slot=@array_merge_recursive($hours_opening, $hours_closing);
$closed = json_decode($service_hours_data['is_close'],true);

$new_array = array();
if(count($open_time) > 0) {
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
			$new_array1_day[$k] = '<span>'.ucfirst(substr($k,0,3)).':</span><a href="javascript:void(0)" class="time_box"> '.$v.$open_time_zone[$k].' - '.$close_time[$k].$close_time_zone[$k].'</a>';
			$new_array1[$day_order] = '<p><span>'.ucfirst(substr($k,0,3)).':</span>'.$v.$open_time_zone[$k].' - '.$close_time[$k].$close_time_zone[$k].'</p>';
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
			$new_array1_day[$k] = ''.ucfirst(substr($k,0,3)).': <a href="javascript:void(0)" class="time_box">Closed</a>';
			$new_array1[$day_order] = '<p class="sun"><span>'.ucfirst(substr($k,0,3)).':</span>Closed</p>';
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
				/*$is_office_open = 'no';
				$office_open_close_status = 'Today: '.$opentimezone_label.' - '.$closetimezone.'<br><span class="opennow">Closed Now</span>';*/

				$is_office_open = 'yes';
				$office_open_close_status = 'Today: '.$opentimezone_label.' - '.$closetimezone.'<br><span class="opennow">Open Now</span>';			
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
?>	
								
<div id="breadcrumb">
	<div class="wrap">
		<ul>
			<li><a href="<?=SITE_URL?>">Home</a></li>
			<li class="active"><a href="#"><?=$active_page_data['menu_name']?></a></li>
		</ul>
	</div>
</div>
  
<?php
//Header Image
if($active_page_data['image'] != "") { ?>
  <section id="head-graphics"> 
  	<img src="<?=SITE_URL.'images/pages/'.$active_page_data['image']?>" class="img-fluid" alt="<?=$active_page_data['title']?>">
  	<div class="header-caption caption_contact">
    	<h2><?=$active_page_data['title']?></h2>
        <?php
		if($active_page_data['image_text'] != "") { ?>
			<p><?=$active_page_data['image_text']?></p>
		<?php
		} ?>
    </div>
  </section>
<?php
} else { ?>
  <section id="head-graphics">
  	<div class="header-caption caption_contact">
    	<h2><?=$active_page_data['title']?></h2>
    </div>
  </section>
<?php
}

if($office_open_close_status) {
?>
<section id="contact_time_sec">
	<div class="content_bg <?=($is_office_open=='no'?'office_close':'')?>">
		<div class="inner">
			<?=$office_open_close_status?>
		</div>
	</div>
</section>
<?php
} ?>
  
  <!-- Main -->
  <div id="main"> 
    
    <!-- Select Your Device -->
    <section id="contact-detail" class="sectionbox white-bg">
    	<div class="wrap">
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
                            <p><?=$new_array1_day[strtolower(date('l'))]?></p>
                            
                            <div id="time_block">
                            	<?php
								@ksort($new_array1);
								if(!empty($new_array1)) {
									foreach($new_array1 as $k => $v) {
										echo $v; 
									}
								} ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </section>
    
    <!-- Select Your Device -->
    <section id="map" class="sectionbox white-bg">
    	<div class="googlemap">
        	<?php
			if($business_address) { ?>
				<iframe width="100%" height="425px" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/search?q=<?=$business_address?>&key=AIzaSyCQ5WCiLnyjH-_5_RTHdicyRFb1l_L43Kc" allowfullscreen></iframe>
			<?php
			} ?>
        </div>
    </section>
    
	<form action="controllers/contact.php" class="phone-sell-form" method="post" id="contact_form">
    <section id="contact-form" class="clearfix">
    	<div class="wrap">
        	<div class="form_inner">
            	<h3>Let's Talk about your business</h3>
                <p class="para"><?=$active_page_data['content']?></p>
            </div>
            <div class="form-outer">
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
					<div class="col-sm-6">
                        <div class="form_group form-group">
                            <input type="text" class="textbox" name="email" id="email" placeholder="Enter email">
                        </div>
						<div class="form_group form-group">
                            <input type="text" class="textbox" name="order_id" id="order_id" placeholder="Enter order number">
                        </div>
						<div class="form_group form-group">
                            <input type="text" class="textbox" name="subject" id="subject" placeholder="Enter subject">
                        </div>
                    </div>
                    
                    <div class="col-sm-6">
                    	<div class="form_group form-group">
                            <textarea class="textbox" name="message" id="message" placeholder="Enter message"></textarea>
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
                    	<button class="btn btn-blue-bg" type="submit">Submit</button>
						<input type="hidden" name="submit_form" id="submit_form" />
                    </div>
                </div>
            </div>
        </div>
    </section>
	<input type="hidden" name="csrf_token" value="<?=$csrf_token?>">
    </form>
  </div><!-- /.main -->

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
