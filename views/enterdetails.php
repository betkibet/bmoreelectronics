<?php
//Header section
include("include/header.php");

if(!$order_id || $basket_item_count_sum_data['basket_item_count']<=0) {
	setRedirect(SITE_URL.'revieworder');
	exit();
}

$is_social_based_ac = false;
if($user_data['leadsource']=="social") {
	$is_social_based_ac = true;
}

$csrf_token = generateFormToken('enterdetails');
?>

  <div id="breadcrumb">
	<div class="wrap">
		<ul>
			<li><a href="<?=SITE_URL?>">Home</a></li>
			<li><a href="<?=SITE_URL?>">Add Items</a></li>
			<li><a href="<?=SITE_URL?>revieworder">Review Order</a></li>
			<li class="active"><a href="<?=SITE_URL?>enterdetails">Checkout</a></li>
		</ul>
	</div>
  </div>
  
  <!-- Main -->
  <div id="main" class="orderdetail"> 
    
    <!-- Select Your Device -->
    <section id="model-steps" class="sectionbox white-bg clearfix">
      <div class="wrap">
        <div class="content-block">
           <?php
  		   $order_steps = 3;
  		   include("include/steps.php"); ?>
        </div>
      </div>
    </section>
    
	<form action="controllers/user/enterdetails.php" method="post" id="signup_form">
    <section id="model-steps-select" class="sectionbox white-bg clearfix">
      <div class="wrap">
        <div class="row phone-details modern-style-image">
          <div class="col-md-12 phone-details-height">
                <div class="clearfix">
                  <div class="heading">
                    <div class="h2"><strong>Checkout</strong></div>
                  </div>
                </div>
                <div class="row clearfix">
                	<div class="col-sm-12">
                    	<div id="payment_box">
                        	<div class="head_row bank_transfer_head active">
                            	<div class="checkbox checkbox-success">
                                    <label for="Option 1"><input class="checkboxele" name="CheckBox[]" id="Option 1" value="Option 1" type="checkbox" onClick="updatePrice_chk('0','+','1',this)" data-price="0" data-add_sub="+" data-price_type="1" data-default="0"><span class="checkmark"></span>
                                     Your Details </label>
                                </div>
                            </div>
                            <div class="detail_row bank_transfer_detail clearfix active">
                            	<div class="inner_box row">
                                	<div class="form_group col-sm-4">
                                    	<label>First Name</label>
                                        <input type="text" class="textbox" name="first_name" id="first_name" placeholder="First Name" value="<?=$user_data['first_name']?>">
                                    </div>
                                    <div class="form_group col-sm-4">
                                    	<label>Last Name</label>
                                        <input type="text" class="textbox" name="last_name" id="last_name" placeholder="Last Name" value="<?=$user_data['last_name']?>">
                                    </div>
                                    <div class="form_group col-sm-4">
                                    	<label>Phone Number</label>
										<input type="tel" id="cell_phone" name="cell_phone" class="textbox" placeholder="">
                                        <input type="hidden" name="phone" id="phone" />
                                    </div>
                                    <div class="form_group col-sm-4">
                                    	<label>Email Address</label>
                                        <input type="email" class="textbox" name="email" id="email" placeholder="Email Address" value="<?=$user_data['email']?>" autocomplete="off">
                                    </div>
									<?php
			  						if($is_social_based_ac!=1 && $user_data['password']=="") { ?>
                                    <div class="form_group col-sm-4">
                                    	<label>Password</label>
                                        <input type="password" class="textbox" name="password" id="password" placeholder="Password" autocomplete="off">
                                    </div>
									<?php
			  						} ?>
                                </div>
                            </div>
                            
                            <div class="head_row paypal_head">
                            	<div class="checkbox checkbox-success">
                                    <label for="Option 1"><input class="checkboxele" name="CheckBox[]" id="Option 1" value="Option 1" type="checkbox" ><span class="checkmark"></span>
                                     Shipping Details</label>
                                </div>
                            </div>
                            <div class="detail_row paypal_detail clearfix">
                            	<div class="inner_box row">
                                	<div class="form_group col-sm-4">
                                    	<label>Address Line1</label>
                                        <input type="text" class="textbox" name="address" id="address" placeholder="Address Line1" value="<?=$user_data['address']?>" autocomplete="off">
                                    </div>
                                    <div class="form_group col-sm-4">
                                    	<label>Address Line2</label>
                                        <input type="text" class="textbox" name="address2" id="address2" placeholder="Address Line2" value="<?=$user_data['address2']?>" autocomplete="off">
                                    </div>
                                    <div class="form_group col-sm-4">
                                    	<label>City</label>
                                        <input type="text" class="textbox" name="city" id="city" placeholder="City" value="<?=$user_data['city']?>" autocomplete="off">
                                    </div>
                                    <div class="form_group col-sm-4">
                                    	<label>State</label>
                                        <input type="text" class="textbox" name="state" id="state" placeholder="State" value="<?=$user_data['state']?>" autocomplete="off">
                                    </div>
                                    <div class="form_group col-sm-4">
                                    	<label>Post Code</label>
                                        <input type="text" class="textbox" name="postcode" id="postcode" placeholder="Post Code" value="<?=$user_data['postcode']?>" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div><!--#payment_box-->
                    </div>
                </div>

				<?php
				if($general_setting_data['terms_status']=='1' && $display_terms_array['ac_creation']=="ac_creation") { ?>
					<div class="row clearfix">
						<div class="col-sm-12">
						<div class="accepturms">
							<div class="checkbox checkbox-success">
								<label for="Option 1">
									<input class="checkboxele" name="terms_conditions" id="terms_conditions" type="checkbox"><span class="checkmark"></span>
								</label>
								Yes, I have read and accept the <a href="#" data-toggle="modal" data-target="#terms_of_website_use">Terms of Website Use</a>.
							</div>
							</div>
						</div>
					</div>
                <?php
				} else {
					echo '<input type="hidden" name="terms_conditions" id="terms_conditions" checked="checked"/>';
				} ?>
                
                <div class="row btn_row clearfix">
                	<div class="col-sm-12 pl0">
						<div class="dis_table">
							<div class="dis_table_row">
								<div class="btn_box dis_table_cell">
								<button type="submit" class="btn btn_md btn-green">Contine</button>
								<input type="hidden" name="submit_form" id="submit_form" />
								</div>
								
								<?php
								//START for social login
								if($social_login=='1' && $user_id<=0) { ?>
									<script type="text/javascript" src="social/js/oauthpopup.js"></script>
									<script type="text/javascript">
									jQuery(document).ready(function($){
										//For Google
										$('a.login').oauthpopup({
											path: 'social/social.php?google',
											width:650,
											height:350,
										});
										$('a.google_logout').googlelogout({
											redirect_url:'<?php echo $base_url; ?>social/logout.php?google'
										});
								
										//For Facebook
										$('#facebook').oauthpopup({
											path: 'social/social.php?facebook',
											width:800,
											height:800,
										});
									});
									</script>
									<div class="or_img dis_table_cell"><img src="images/or_img.png" alt=""></div>
									<div class="btn_box dis_table_cell">
										<?php
										if($social_login_option=="g_f") { ?>
											<a id="facebook" href="javascript:void(0);" class="btn btn_md btn_fb"><img src="images/fb_img.png" alt="Facebook"></a>
											<a href="javascript:void(0);" class="login btn btn_md btn_gplus"><img src="images/google_plus.png" alt="Google"></a>
										<?php
										} elseif($social_login_option=="g") { ?>
											<a href="javascript:void(0);" class="login btn btn_md btn_gplus"><img src="images/google_plus.png" alt="Google"></a>
										<?php
										} elseif($social_login_option=="f") { ?>
											<a id="facebook" href="javascript:void(0);" class="btn btn_md btn_fb"><img src="images/fb_img.png" alt="Facebook"></a>
										<?php
										} ?>
									</div>
								<?php
  								} //END for social login ?>
								
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
  </div>

<!-- Modal -->
<div class="modal fade common_popup" id="terms_of_website_use" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
      	<button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="modal-body">
        	<h3 class="title">Terms & Conditions</h3>
            <?=$general_setting_data['terms']?>
        </div><!--modal-body-->
      </div>
    </div>
</div><!-- Modal -->

<script>
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

		$("#cell_phone").intlTelInput("setNumber", "<?=($user_data['phone']?'+'.$user_data['phone']:'')?>");

		// on keyup / change flag: reset
		telInput.on("keyup change", reset);
	});
})(jQuery);

(function( $ ) {
	$(function() {
		$('#signup_form').bootstrapValidator({
			fields: {
				first_name: {
					validators: {
						stringLength: {
							min: 1,
						},
						notEmpty: {
							message: 'Please enter first name'
						}
					}
				},
				 last_name: {
					validators: {
						stringLength: {
							min: 1,
						},
						notEmpty: {
							message: 'Please enter last name'
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
				password: {
					validators: {
						notEmpty: {
							message: 'Please enter password.'
						}
					}
				},
				address: {
					validators: {
						notEmpty: {
							message: 'Please enter address.'
						}
					}
				}/*,
				address2: {
					validators: {
						notEmpty: {
							message: 'Please enter address2.'
						}
					}
				}*/,
				city: {
					validators: {
						notEmpty: {
							message: 'Please enter city.'
						}
					}
				},
				state: {
					validators: {
						notEmpty: {
							message: 'Please enter state.'
						}
					}
				},
				postcode: {
					validators: {
						notEmpty: {
							message: 'Please enter post code.'
						}
					}
				},
				terms_conditions: {
					validators: {
						callback: {
							message: 'You must agree to terms & conditions to sign-up.',
							callback: function(value, validator, $field) {
								var terms = document.getElementById("terms_conditions").checked;
								if(terms==false) {
									return false;
								} else {
									return true;
								}
							}
						}
					}
				}
			}
		}).on('success.form.bv', function(e) {
            //$('#success_message').slideDown({ opacity: "show" }, "slow") // Do something ...
                $('#signup_form').data('bootstrapValidator').resetForm();

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
