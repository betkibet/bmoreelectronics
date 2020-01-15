  <!-- Footer -->
  <footer id="footer">
  		<span class="scroll_top">Scroll Top</span>
  		<div class="frow-top">
			<div class="wrap clearfix">
				<div class="col col1">
					<h5>About Us</h5>
					<div class="content_box">
						<ul class="fnav">
						  <?php
						  $footercolumn1_menu_list = get_menu_list('footer_column1');
						  foreach($footercolumn1_menu_list as $footercolumn1_menu_data) {
							  $is_open_new_window = $footercolumn1_menu_data['is_open_new_window'];
							  if($footercolumn1_menu_data['page_id']>0) {
								  $menu_url = $footercolumn1_menu_data['p_url'];
								  $is_custom_url = $footercolumn1_menu_data['p_is_custom_url'];
							  } else {
								  $menu_url = $footercolumn1_menu_data['url'];
								  $is_custom_url = $footercolumn1_menu_data['is_custom_url'];
							  }
							  $menu_url = ($is_custom_url>0?$menu_url:SITE_URL.$menu_url);
							  $is_open_new_window = ($is_open_new_window>0?'target="_blank"':'');
							  
							  $menu_fa_icon = "";
							  if($footercolumn1_menu_data['css_menu_fa_icon']) {
								  $menu_fa_icon = '&nbsp;<i class="'.$footercolumn1_menu_data['css_menu_fa_icon'].'" aria-hidden="true"></i>';
							  } ?>
							  <li <?=(count($footercolumn1_menu_data['submenu'])>0?'class="submenu"':'')?>>
								<a class="<?=$footercolumn1_menu_data['css_menu_class']?>" href="<?=$menu_url?>" <?=$is_open_new_window?>><?=$footercolumn1_menu_data['menu_name'].$menu_fa_icon?></a>
								<?php
								if(count($footercolumn1_menu_data['submenu'])>0) {
									$footercolumn1_submenu_list = $footercolumn1_menu_data['submenu']; ?>
									<ul>
										<?php
										foreach($footercolumn1_submenu_list as $footercolumn1_submenu_data) {
											$s_is_open_new_window = $footercolumn1_submenu_data['is_open_new_window'];
											if($footercolumn1_submenu_data['page_id']>0) {
												$s_is_custom_url = $footercolumn1_submenu_data['p_is_custom_url'];
												$s_menu_url = $footercolumn1_submenu_data['p_url'];
											} else {
												$s_menu_url = $footercolumn1_submenu_data['url'];
												$s_is_custom_url = $footercolumn1_submenu_data['is_custom_url'];
											}
											$s_menu_url = ($s_is_custom_url>0?$s_menu_url:SITE_URL.$s_menu_url);
											$s_is_open_new_window = ($s_is_open_new_window>0?'target="_blank"':'');
											
											$submenu_fa_icon = "";
											if($footercolumn1_submenu_data['css_menu_fa_icon']) {
												$submenu_fa_icon = '&nbsp;<i class="'.$footercolumn1_submenu_data['css_menu_fa_icon'].'" aria-hidden="true"></i>';
											} ?>
											<li><a href="<?=$s_menu_url?>" class="<?=$footercolumn1_submenu_data['css_menu_class']?>" <?=$s_is_open_new_window?>><?=$footercolumn1_submenu_data['menu_name'].$submenu_fa_icon?></a></li>
										<?php
										} ?>
									</ul>
								<?php
								} ?>
							  </li>
						  <?php
						  } ?>
						</ul>
					</div>
				</div>
				
				<div class="col col2">
					<h5>Partnerships</h5>
					<div class="content_box">
						<ul class="fnav">
						  <?php
						  $footercolumn2_menu_list = get_menu_list('footer_column2');
						  foreach($footercolumn2_menu_list as $footercolumn2_menu_data) {
							  $is_open_new_window = $footercolumn2_menu_data['is_open_new_window'];
							  if($footercolumn2_menu_data['page_id']>0) {
								  $menu_url = $footercolumn2_menu_data['p_url'];
								  $is_custom_url = $footercolumn2_menu_data['p_is_custom_url'];
							  } else {
								  $menu_url = $footercolumn2_menu_data['url'];
								  $is_custom_url = $footercolumn2_menu_data['is_custom_url'];
							  }
							  $menu_url = ($is_custom_url>0?$menu_url:SITE_URL.$menu_url);
							  $is_open_new_window = ($is_open_new_window>0?'target="_blank"':'');
							  
							  $menu_fa_icon = "";
							  if($footercolumn2_menu_data['css_menu_fa_icon']) {
								  $menu_fa_icon = '&nbsp;<i class="'.$footercolumn2_menu_data['css_menu_fa_icon'].'" aria-hidden="true"></i>';
							  } ?>
							  <li <?=(count($footercolumn2_menu_data['submenu'])>0?'class="submenu"':'')?>>
								<a class="<?=$footercolumn2_menu_data['css_menu_class']?>" href="<?=$menu_url?>" <?=$is_open_new_window?>><?=$footercolumn2_menu_data['menu_name'].$menu_fa_icon?></a>
								<?php
								if(count($footercolumn2_menu_data['submenu'])>0) {
									$footercolumn2_submenu_list = $footercolumn2_menu_data['submenu']; ?>
									<ul>
										<?php
										foreach($footercolumn2_submenu_list as $footercolumn2_submenu_data) {
											$s_is_open_new_window = $footercolumn2_submenu_data['is_open_new_window'];
											if($footercolumn2_submenu_data['page_id']>0) {
												$s_is_custom_url = $footercolumn2_submenu_data['p_is_custom_url'];
												$s_menu_url = $footercolumn2_submenu_data['p_url'];
											} else {
												$s_menu_url = $footercolumn2_submenu_data['url'];
												$s_is_custom_url = $footercolumn2_submenu_data['is_custom_url'];
											}
											$s_menu_url = ($s_is_custom_url>0?$s_menu_url:SITE_URL.$s_menu_url);
											$s_is_open_new_window = ($s_is_open_new_window>0?'target="_blank"':'');
											
											$submenu_fa_icon = "";
											if($footercolumn2_submenu_data['css_menu_fa_icon']) {
												$submenu_fa_icon = '&nbsp;<i class="'.$footercolumn2_submenu_data['css_menu_fa_icon'].'" aria-hidden="true"></i>';
											} ?>
											<li><a href="<?=$s_menu_url?>" class="<?=$footercolumn2_submenu_data['css_menu_class']?>" <?=$s_is_open_new_window?>><?=$footercolumn2_submenu_data['menu_name'].$submenu_fa_icon?></a></li>
										<?php
										} ?>
									</ul>
								<?php
								} ?>
							  </li>
						  <?php
						  } ?>
						</ul>
					</div>
				</div>
				
				<div class="col col3">
					
					<div class="content_box">
						<ul class="fnav">
						  <?php
						  $footercolumn3_menu_list = get_menu_list('footer_column3');
						  foreach($footercolumn3_menu_list as $footercolumn3_menu_data) {
							  $is_open_new_window = $footercolumn3_menu_data['is_open_new_window'];
							  if($footercolumn3_menu_data['page_id']>0) {
								  $menu_url = $footercolumn3_menu_data['p_url'];
								  $is_custom_url = $footercolumn3_menu_data['p_is_custom_url'];
							  } else {
								  $menu_url = $footercolumn3_menu_data['url'];
								  $is_custom_url = $footercolumn3_menu_data['is_custom_url'];
							  }
							  $menu_url = ($is_custom_url>0?$menu_url:SITE_URL.$menu_url);
							  $is_open_new_window = ($is_open_new_window>0?'target="_blank"':'');
							  
							  $menu_fa_icon = "";
							  if($footercolumn3_menu_data['css_menu_fa_icon']) {
								  $menu_fa_icon = '&nbsp;<i class="'.$footercolumn3_menu_data['css_menu_fa_icon'].'" aria-hidden="true"></i>';
							  } ?>
							  <li <?=(count($footercolumn3_menu_data['submenu'])>0?'class="submenu"':'')?>>
								<a class="<?=$footercolumn3_menu_data['css_menu_class']?>" href="<?=$menu_url?>" <?=$is_open_new_window?>><?=$footercolumn3_menu_data['menu_name'].$menu_fa_icon?></a>
								<?php
								if(count($footercolumn3_menu_data['submenu'])>0) {
									$footercolumn3_submenu_list = $footercolumn3_menu_data['submenu']; ?>
									<ul>
										<?php
										foreach($footercolumn3_submenu_list as $footercolumn3_submenu_data) {
											$s_is_open_new_window = $footercolumn3_submenu_data['is_open_new_window'];
											if($footercolumn3_submenu_data['page_id']>0) {
												$s_is_custom_url = $footercolumn3_submenu_data['p_is_custom_url'];
												$s_menu_url = $footercolumn3_submenu_data['p_url'];
											} else {
												$s_menu_url = $footercolumn3_submenu_data['url'];
												$s_is_custom_url = $footercolumn3_submenu_data['is_custom_url'];
											}
											$s_menu_url = ($s_is_custom_url>0?$s_menu_url:SITE_URL.$s_menu_url);
											$s_is_open_new_window = ($s_is_open_new_window>0?'target="_blank"':'');
											
											$submenu_fa_icon = "";
											if($footercolumn3_submenu_data['css_menu_fa_icon']) {
												$submenu_fa_icon = '&nbsp;<i class="'.$footercolumn3_submenu_data['css_menu_fa_icon'].'" aria-hidden="true"></i>';
											} ?>
											<li><a href="<?=$s_menu_url?>" class="<?=$footercolumn3_submenu_data['css_menu_class']?>" <?=$s_is_open_new_window?>><?=$footercolumn3_submenu_data['menu_name'].$submenu_fa_icon?></a></li>
										<?php
										} ?>
									</ul>
								<?php
								} ?>
							  </li>
						  <?php
						  } ?>
						</ul>
					</div>
				</div>
				
				<?php /*?><div class="col col3">
					<h5>Customer Service</h5>
					<div class="content_box">
					  <div class="number"><?=$site_phone?></div>
					  <a href="#" class="support_link">SUPPORT & FAQ</a>
					</div>
				</div><?php */?>
				
				<div class="col col4">
					<h5>Stay in Touch</h5>
					<div class="content_box">
						<div class="fsignup-box">
							<form action="#" method="post">
								<input type="email" name="ftr_signup_email" id="ftr_signup_email" class="textbox" placeholder="Enter Email" autocomplete="nope">
								<button type="button" id="ftr_signup_btn">Sign Up</button>
							</form>
						</div>
					</div>
					
					<div class="fsocial">
						<?php
						//START for socials link
						if($socials_link) { ?>
							<ul><?=$socials_link?></ul>
						<?php
						} //END for socials link ?>
					</div>
					
					<div class="numbemail">
						<?=$site_phone?> | <a href="mailto:<?=$site_phone?>"><?=$site_email?></a>
					</div>
				</div>
			</div>
        </div>
        
        <div class="frow-bottom">
            <div class="wrap clearfix">
				<?=($copyright?'<p class="copyright">'.$copyright.'</p>':'')?>
				<ul class="fbmenu">
				  <?php
				  $copyright_menu_list = get_menu_list('copyright_menu');
				  $cp_i = 0;
				  $cp_len = count($copyright_menu_list);
				  foreach($copyright_menu_list as $copyright_menu_data) {
					  $is_open_new_window = $copyright_menu_data['is_open_new_window'];
					  if($copyright_menu_data['page_id']>0) {
						  $menu_url = $copyright_menu_data['p_url'];
						  $is_custom_url = $copyright_menu_data['p_is_custom_url'];
					  } else {
						  $menu_url = $copyright_menu_data['url'];
						  $is_custom_url = $copyright_menu_data['is_custom_url'];
					  }
					  $menu_url = ($is_custom_url>0?$menu_url:SITE_URL.$menu_url);
					  $is_open_new_window = ($is_open_new_window>0?'target="_blank"':'');
					  
					  $menu_fa_icon = "";
					  if($copyright_menu_data['css_menu_fa_icon']) {
						  $menu_fa_icon = '&nbsp;<i class="'.$copyright_menu_data['css_menu_fa_icon'].'" aria-hidden="true"></i>';
					  } ?>
					  <li <?=(count($copyright_menu_data['submenu'])>0?'class="submenu"':'')?>>
						<a class="<?=$copyright_menu_data['css_menu_class']?>" href="<?=$menu_url?>" <?=$is_open_new_window?>><?=$copyright_menu_data['menu_name'].$menu_fa_icon?></a> <?=(($cp_i == $cp_len - 1)?"":" /")?>
					  </li>
				  <?php
				  $cp_i++;
				  } ?>
				</ul>	
            </div>
        </div>
        
  </footer>
</div>

<!-- Modal -->
<div class="modal fade" id="signupbox" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
      	<button type="button" class="close" data-dismiss="modal">&times;</button>
        <ul class="nav nav-tabs modal_tab">
          <li id="login_tab" class="login_tab"><a data-toggle="tab" href="#loginpage">Login</a></li>
          <li id="signup_tab" class="signup_tab active"><a data-toggle="tab" href="#signuppage">SignUp</a></li>
        </ul>
        
        <div class="modal-body">
                <div class="tab-content">
                  <div id="loginpage" class="tab-pane fade">
                    	<form action="<?=SITE_URL?>controllers/user/login.php" method="post" id="login_form">
						<div class="login-content">
							<p>Get Welcome Back, Please login to your account<br><br><br></p>
							<div class="form_box clearfix">
							<div class="row">
								<div class="form_group col-sm-6">
									<label>Email Address</label>
									<input type="text" class="textbox" id="username" name="username" placeholder="Enter email address" autocomplete="nope">
								</div>
							</div>
							<div class="row">
								<div class="form_group col-sm-6">
									<label>Password</label>
									<input type="password" class="textbox" id="password" name="password" placeholder="Enter password" autocomplete="nope">
								</div>
							</div>
							
							<?php
							if($login_form_captcha == '1') { ?>
							<div class="row">
							  <div class="form-group">
								<div id="p_l_g_form_gcaptcha"></div>
								<input type="hidden" id="p_l_g_captcha_token" name="p_l_g_captcha_token" value=""/>
							  </div>
							</div>
							<?php
							} ?>
							
							<div class="row">
								<div class="form_group col-sm-6">
									<button type="submit" class="btn btn-green">Login</button>
									<input type="hidden" name="submit_form" id="submit_form" />
								</div>
							</div>
							
							<p><a href="<?=SITE_URL?>lost_password">Forgotten your password?</a></p>
							</div>
						</div>
						<?php
						$p_l_csrf_token = generateFormToken('login');
						echo '<input type="hidden" name="csrf_token" value="'.$p_l_csrf_token.'">'; ?>
                    	</form>
						
						<?php
	  					if($social_login=='1') { ?>
							<script type="text/javascript" src="<?=SITE_URL?>social/js/oauthpopup.js"></script>
							<script type="text/javascript">
							jQuery(document).ready(function($){
								//For Google
								$('.google_auth').oauthpopup({
									path: 'social/social.php?google',
									width:650,
									height:350,
								});
								$('a.google_logout').googlelogout({
									redirect_url:'<?php echo $base_url; ?>social/logout.php?google'
								});

								//For Facebook
								$('.facebook_auth').oauthpopup({
									path: 'social/social.php?facebook',
									width:1000,
									height:1000,
								});
							});
							</script>

							<div class="orsignup">
								<div class="row">
									<div class="btn_box dis_table_cell col-sm-6">
										<?php
										if($social_login_option=="g_f") { ?>
											<a class="btn btn_md btn_fb facebook_auth" href="javascript:void(0);"><img src="<?=SITE_URL?>images/fb_img.png" alt=""></a>
											<a class="btn btn_md btn_gplus google_auth" href="javascript:void(0);"><img src="<?=SITE_URL?>images/google_plus.png" alt=""></a>
										<?php
										} elseif($social_login_option=="g") { ?>
											<a class="btn btn_md btn_gplus google_auth" href="javascript:void(0);"><img src="<?=SITE_URL?>images/google_plus.png" alt=""></a>
										<?php
										} elseif($social_login_option=="f") { ?>
											<a class="btn btn_md btn_fb facebook_auth" href="javascript:void(0);"><img src="<?=SITE_URL?>images/fb_img.png" alt=""></a>
										<?php
										} ?>
									</div>
								</div>
							</div>
						<?php
	  					} ?>
	  
                    </div>
                    
                    <div id="signuppage" class="tab-pane fade in active">
						<form action="<?=SITE_URL?>controllers/user/signup.php" method="post" id="popup_signup_form" role="form">
						<div class="signup-content">
							<p>Get Your FREE Acount Now!</p>
							<div class="form_box clearfix">
							<div class="row">
								<div class="form_group col-sm-3">
									<label>First Name</label>
									<input type="text" class="textbox" name="first_name" id="first_name" placeholder="First Name" autocomplete="nope">
								</div>
								<div class="form_group col-sm-3">
									<label>Last Name</label>
									<input type="text" class="textbox" name="last_name" id="last_name" placeholder="Last Name" autocomplete="nope">
								</div>
							</div>
							<div class="row">
								<div class="form_group col-sm-3">
									<label>Mobile</label>
									<input type="tel" id="signup_cell_phone" name="signup_cell_phone" class="textbox" placeholder="">
									<input type="hidden" name="phone" id="signup_phone" />
								</div>
								<div class="form_group col-sm-3">
									<label>Email</label>
									<input type="text" class="textbox signup_email" name="email" id="email" placeholder="Email Address" autocomplete="nope">
								</div>
							</div>
							<div class="row">
								<div class="form_group col-sm-3">
									<label>Password</label>
									<input type="password" class="textbox" name="password" id="password" placeholder="Password" autocomplete="nope">
								</div>
								<div class="form_group col-sm-3">
									<label>Confirm Password</label>
									<input type="password" class="textbox" name="confirm_password" id="confirm_password" placeholder="Confirm Password" autocomplete="nope">
								</div>
							</div>
							
							<?php
							if($signup_form_captcha == '1') { ?>
							<div class="row">
							  <div class="form-group">
								<div id="p_s_g_form_gcaptcha"></div>
								<input type="hidden" id="p_s_g_captcha_token" name="p_s_g_captcha_token" value=""/>
							  </div>
							</div>
							<?php
							} ?>
							
							<div class="row">
								<div class="form_group col-sm-6">
									<button type="submit" class="btn btn-green">Sign Up</button>
									<input type="hidden" name="submit_form" id="submit_form" />
								</div>
							</div>
							<?php
							if($general_setting_data['terms_status']=='1' && $display_terms_array['ac_creation']=="ac_creation") { ?>
							<div class="row clearfix">
								<div class="col-sm-12">
									<div class="accepturms">
										<div class="checkbox checkbox-success">
										<label for="ac_terms_conditions">
											<input class="checkboxele" name="ac_terms_conditions" id="ac_terms_conditions" value="1" type="checkbox">
											<span class="checkmark"></span> I accept <a href="javascript:void(0)" data-toggle="modal" data-target="#PricePromiseHelp">Terms and Condition</a></label>
										</div>
									</div>
								</div>
							</div>
							<?php
							} else {
								echo '<input type="hidden" name="ac_terms_conditions" id="ac_terms_conditions" value="1"/>';
							} ?>
							<p>Are you alredy Member? <a class="go_login_tab" data-toggle="tab" href="#loginpage">click here</a> to login</p>
						 </div>
						</div>
						<?php
						$p_s_csrf_token = generateFormToken('signup');
						echo '<input type="hidden" name="csrf_token" value="'.$p_s_csrf_token.'">'; ?>
                    	</form>
						
						<div class="orsignup">
							<div class="row">
								<div class="btn_box dis_table_cell col-sm-6">
									<?php
									if($social_login_option=="g_f") { ?>
										<a class="btn btn_md btn_fb facebook_auth" href="javascript:void(0);"><img src="<?=SITE_URL?>images/fb_img.png" alt=""></a>
										<a class="btn btn_md btn_gplus google_auth" href="javascript:void(0);"><img src="<?=SITE_URL?>images/google_plus.png" alt=""></a>
									<?php
									} elseif($social_login_option=="g") { ?>
										<a class="btn btn_md btn_gplus google_auth" href="javascript:void(0);"><img src="<?=SITE_URL?>images/google_plus.png" alt=""></a>
									<?php
									} elseif($social_login_option=="f") { ?>
										<a class="btn btn_md btn_fb facebook_auth" href="javascript:void(0);"><img src="<?=SITE_URL?>images/fb_img.png" alt=""></a>
									<?php
									} ?>
								</div>
							</div>
						</div>
                    
                  </div>
                    
                  </div>
                  
                </div>
            </div>
            
        </div><!--.modal-body-->
      </div>
      
    </div>
</div>

<?php
if($login_form_captcha == '1' || $signup_form_captcha == '1') { ?>
	<script src="https://www.google.com/recaptcha/api.js?onload=PopupCaptchaCallback&render=explicit"></script>
	<script>
	var PopupCaptchaCallback = function() {
		<?php
		if($login_form_captcha == '1') { ?>
			if(jQuery('#p_l_g_form_gcaptcha').length) {
				grecaptcha.render('p_l_g_form_gcaptcha', {
					'sitekey' : '<?=$captcha_key?>',
					'callback' : onSubmitFormOfpl,
				});
			}
		<?php
		}
		if($signup_form_captcha == '1') { ?>
			if(jQuery('#p_s_g_form_gcaptcha').length) {
				grecaptcha.render('p_s_g_form_gcaptcha', {
					'sitekey' : '<?=$captcha_key?>',
					'callback' : onSubmitFormOfps,
				});
			}
		<?php
		} ?>
	};

	<?php
	if($login_form_captcha == '1') { ?>
	var onSubmitFormOfpl = function(response) {
		if(response.length == 0) {
			jQuery("#p_l_g_captcha_token").val('');
		} else {
			jQuery("#p_l_g_captcha_token").val('yes');
		}
	};
	<?php
	}
	if($signup_form_captcha == '1') { ?>
	var onSubmitFormOfps = function(response) {
		if(response.length == 0) {
			jQuery("#p_s_g_captcha_token").val('');
		} else {
			jQuery("#p_s_g_captcha_token").val('yes');
		}
	};
	<?php
	} ?>
	</script>
<?php
} ?>

<script>
(function( $ ) {
	$(function() {
		var telInput = $("#signup_cell_phone");
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
		
		// on keyup / change flag: reset
		telInput.on("keyup change", reset);
	});
})(jQuery);

(function( $ ) {
	$(function() {
		$('#popup_signup_form').bootstrapValidator({
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
				signup_cell_phone: {
					validators: {
						/*notEmpty: {
							message: 'Please enter phone number'
						},*/
						callback: {
							message: 'Please enter valid phone number',
							callback: function(value, validator, $field) {
								var telInput = $("#signup_cell_phone");
								$("#signup_phone").val(telInput.intlTelInput("getNumber"));
								if(!telInput.intlTelInput("isValidNumber")) {
									return false;
								} else if(telInput.intlTelInput("isValidNumber")) {
									return true;
								}
							}
						}
					}
				},
				password: {
					validators: {
						notEmpty: {
							message: 'Please enter password.'
						},
						identical: {
							field: 'confirm_password',
							message: 'Password and confirm password not matched.'
						}
					}
				},
				confirm_password: {
					validators: {
						notEmpty: {
							message: 'Please enter confirm password.'
						},
						identical: {
							field: 'password',
							message: 'Password and confirm password not matched.'
						}
					}
				},
				ac_terms_conditions: {
					validators: {
						callback: {
							message: 'You must agree to terms & conditions to sign-up.',
							callback: function(value, validator, $field) {
								var terms = document.getElementById("ac_terms_conditions").checked;
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
            $('#popup_signup_form').data('bootstrapValidator').resetForm();

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

(function( $ ) {
	$(function() {
		$('#login_form').bootstrapValidator({
			fields: {
				username: {
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
				}
			}
		}).on('success.form.bv', function(e) {
            $('#login_form').data('bootstrapValidator').resetForm();

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

<!-- Scripts --> 
<?php /*?><script src="<?=SITE_URL?>js/jquery.min.js"></script> <?php */?>
<script src="<?=SITE_URL?>js/responsiveslides.min.js"></script>
<script src="<?=SITE_URL?>js/owl.carousel.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="<?=SITE_URL?>js/jquery.autocomplete.min.js"></script>
<script src="<?=SITE_URL?>js/theme.min.js"></script>
<script src="<?=SITE_URL?>js/main.js"></script>
<script src="<?=SITE_URL?>js/intlTelInput.js"></script>
<script src="<?=SITE_URL?>js/bootstrapvalidator.min.js"></script>
<script>
$(function() {
	$("#datepicker").datepicker();

	$('#ftr_signup_btn').click(function() {
		var ftr_signup_email = $("#ftr_signup_email").val();		
		var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
		if(ftr_signup_email == "") {
			return false;
		} else if(!ftr_signup_email.match(mailformat)) {
			return false;
		} else {
			$('#signupbox').modal('show');

			$('.signup_email').val(ftr_signup_email);
			$('#signuppage').addClass(" active in");
			$('#signup_tab').addClass(" active");
			$('#loginpage').removeClass("active in");
			$('#login_tab').removeClass("active");
		}
	});
});

$(document).ready(function(){
	$('[data-toggle="tooltip"]').tooltip();
});

$('.srch_list_of_model').autocomplete({
	serviceUrl: '/ajax/get_autocomplete_data.php',
	onSelect: function(suggestion) {
		window.location.href = suggestion.url;
	},
	onHint: function (hint) {
		console.log("onHint");
	},
	onInvalidateSelection: function() {
		console.log("onInvalidateSelection");
	},
	onSearchStart: function(params) {
		console.log("onSearchStart");
	},
	onHide: function(container) {
		console.log("onHide");
	},
	onSearchComplete: function (query, suggestions) {
		console.log("onSearchComplete",suggestions);
	},
	showNoSuggestionNotice: true,
	noSuggestionNotice: "We didn't find any matching devices...",
});
</script>

</body>
</html>