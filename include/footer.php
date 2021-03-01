  <footer class="footer_section_detail">
    <div id="top">
      <div class="container-fluid">
        <div class="row">
          <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
            <div class="block center_block">
			  <?php
			  if($footer_logo_url) {
				echo '<div class="footer-logo"><img src="'.$footer_logo_url.'" width="'.$footer_logo_width.'" height="'.$footer_logo_height.'" alt="'.SITE_NAME.'"></div>';
			  }
			  
			  //START for socials link
			  if($socials_link) { ?>
              <div class="social text-center">  
                <h5>Follow us:</h5>
                <ul class="list-inline">
					<?=$socials_link?>
                </ul>
              </div>
			  <?php
			  } //END for socials link ?>
            </div>
          </div>
          <div class="col-xl-4 col-lg-4 col-md-4 col-sm-5 col-6">
            <div class="block">
              <div class="customer_support">
                <h5>Customer support</h5>
                <ul>
					<?php
					if($site_phone) { ?>
						<li><strong>Tel:</strong><a class="border-0" href="+<?=$site_phone?>">+<?=$site_phone?></a></li>
					<?php
					}
					if($company_email) { ?>
						<li><strong>Email:</strong><a class="border-0" href="mailto:<?=$company_email?>"><?=$company_email?></a></li>
					<?php
					} ?>
                </ul>
				<h5 class="mt-3">Our Address:</h5>
				<ul class="mt-2 our_address_section">
					<li>
						<?php
						/*if($company_name) {
							echo '<strong>'.$company_name.'</strong>';
						}*/
						if($company_address) {
							echo $company_address;
						}
						if($company_city || $company_state || $company_zipcode || $company_country) {
							echo '<br />'.trim($company_city.' '.$company_state.' '.$company_zipcode.'<br>'.strtoupper($company_country));
						} ?>
					</li>
				</ul>
              </div>
            </div>
          </div>
		  <?php
		  if($is_act_footer_menu_column1 == '1') {
			  $footercolumn1_menu_list = get_menu_list('footer_column1');
			  if(!empty($footercolumn1_menu_list)) { ?>
			  <div class="col-xl-2 col-lg-2 col-md-2 col-sm-3 col-6">
				<div class="block">
				  <div class="company">
					<h5><?=$footer_menu_column1_title?></h5>
					<ul>
					  <?php
					  foreach($footercolumn1_menu_list as $footercolumn1_menu_data) {
						  $is_open_new_window = $footercolumn1_menu_data['is_open_new_window'];
						  if($footercolumn1_menu_data['page_id']>0) {
							  $menu_url = $footercolumn1_menu_data['p_url'];
						  } else {
							  $menu_url = $footercolumn1_menu_data['url'];
						  }
						  $is_custom_url = $footercolumn1_menu_data['is_custom_url'];
						  $menu_url = ($is_custom_url>0?$menu_url:SITE_URL.$menu_url);
						  $is_open_new_window = ($is_open_new_window>0?'target="_blank"':'');
						  
						  $menu_fa_icon = "";
						  if($footercolumn1_menu_data['css_menu_fa_icon']) {
							  $menu_fa_icon = '&nbsp;<i class="'.$footercolumn1_menu_data['css_menu_fa_icon'].'" aria-hidden="true"></i>';
						  }
						  
						  $f_fix_menu_popup = "";
						  if($footercolumn1_menu_data['menu_name'] == "Contact Us") {
							  $f_fix_menu_popup = 'data-toggle="modal" data-target="#contactusForm"';
						  } ?>
						  <li <?=(count($footercolumn1_menu_data['submenu'])>0?'class="submenu"':'')?>>
							<a class="<?=$footercolumn1_menu_data['css_menu_class']?>" href="<?=$menu_url?>" <?=$is_open_new_window.$f_fix_menu_popup?>><?=$footercolumn1_menu_data['menu_name'].$menu_fa_icon?></a>
							<?php
							if(count($footercolumn1_menu_data['submenu'])>0) {
								$footercolumn1_submenu_list = $footercolumn1_menu_data['submenu']; ?>
								<ul>
									<?php
									foreach($footercolumn1_submenu_list as $footercolumn1_submenu_data) {
										$s_is_open_new_window = $footercolumn1_submenu_data['is_open_new_window'];
										if($footercolumn1_submenu_data['page_id']>0) {
											$s_menu_url = $footercolumn1_submenu_data['p_url'];
										} else {
											$s_menu_url = $footercolumn1_submenu_data['url'];
										}
										
										$s_is_custom_url = $footercolumn1_submenu_data['is_custom_url'];
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
			  </div>
			  <?php
			  }
		  }
		  
		  if($is_act_footer_menu_column2 == '1') {
			  $footercolumn2_menu_list = get_menu_list('footer_column2');
			  if(!empty($footercolumn2_menu_list)) { ?>
				  <div class="col-6 col-lg-3 col-md-6">
					<div class="">
					  <div class="marketing-collaboration">
						<h5><?=$footer_menu_column2_title?></h5>
						<ul>
						  <?php
						  foreach($footercolumn2_menu_list as $footercolumn2_menu_data) {
							  $is_open_new_window = $footercolumn2_menu_data['is_open_new_window'];
							  if($footercolumn2_menu_data['page_id']>0) {
								  $menu_url = $footercolumn2_menu_data['p_url'];
							  } else {
								  $menu_url = $footercolumn2_menu_data['url'];
							  }
							  $is_custom_url = $footercolumn2_menu_data['is_custom_url'];
							  $menu_url = ($is_custom_url>0?$menu_url:SITE_URL.$menu_url);
							  $is_open_new_window = ($is_open_new_window>0?'target="_blank"':'');
							  
							  $menu_fa_icon = "";
							  if($footercolumn2_menu_data['css_menu_fa_icon']) {
								  $menu_fa_icon = '&nbsp;<i class="'.$footercolumn2_menu_data['css_menu_fa_icon'].'" aria-hidden="true"></i>';
							  }
							  
							  $f_fix_menu_popup = "";
							  if($footercolumn2_menu_data['menu_name'] == "Contact us") {
								  $f_fix_menu_popup = 'data-toggle="modal" data-target="#contactusForm"';
							  } ?>
							  <li <?=(count($footercolumn2_menu_data['submenu'])>0?'class="submenu"':'')?>>
								<a class="<?=$footercolumn2_menu_data['css_menu_class']?>" href="<?=$menu_url?>" <?=$is_open_new_window.$f_fix_menu_popup?>><?=$footercolumn2_menu_data['menu_name'].$menu_fa_icon?></a>
								<?php
								if(count($footercolumn2_menu_data['submenu'])>0) {
									$footercolumn2_submenu_list = $footercolumn2_menu_data['submenu']; ?>
									<ul>
										<?php
										foreach($footercolumn2_submenu_list as $footercolumn2_submenu_data) {
											$s_is_open_new_window = $footercolumn2_submenu_data['is_open_new_window'];
											if($footercolumn2_submenu_data['page_id']>0) {
												$s_menu_url = $footercolumn2_submenu_data['p_url'];
											} else {
												$s_menu_url = $footercolumn2_submenu_data['url'];
											}
											
											$s_is_custom_url = $footercolumn2_submenu_data['is_custom_url'];
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
						<?php /*?><ul>
							<li><a href="mailto:<?=$site_email?>"><?=$site_email?></a></li>
						</ul><?php */?>
					  </div>
					</div>
				  </div>
		 	 <?php
			 }
		  } ?>
        </div>
      </div>
    </div>
	
	<?php
	if($copyright) { ?>
    <div id="copyright" class="py-4">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="block copyright text-center"> 
				<?=($copyright?'<p class="my-2">'.$copyright.'</p>':'')?> 
            </div>
          </div>
        </div>
      </div>
    </div>
	<?php
	}

	$f_device_data_list = get_f_device_data_list();
	if(count($f_device_data_list)>0) { ?>
    <div id="bottom">
      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col-md-12 col-lg-12 col-xl-10">
            <div class="block product-links">
              <div class="row">
			    <?php
				foreach($f_device_data_list as $f_d_k=>$f_device_data) {
					$f_d_b_class = "col-6 col-md-3 col-lg-3 clo-xl-3 col-sm-4";
					$f_d_k = ($f_d_k+1);
					if($f_d_k%2==0) {
						$f_d_b_class = "col-6 col-md-3 col-lg-3 col-xl-3 col-sm-4";
					}

					$ft_model_data_list = get_f_model_data_list($f_device_data['id']);
					if(count($ft_model_data_list)>0) { ?>
						<div class="<?=$f_d_b_class?>">
						  <h4><?=$f_device_data['title']?></h4>
						  <ul>
						    <?php
							foreach($ft_model_data_list as $ft_model_data) { ?>
								<?php /*?><li><a href="<?=SITE_URL.$ft_model_data['sef_url'].'/'.$ft_model_data['id']?>"><?=$ft_model_data['title']?></a></li><?php */?>
								<li><a href="<?=SITE_URL.$ft_model_data['sef_url']?>"><?=$ft_model_data['title']?></a></li>
							<?php
							} ?>
						  </ul>
						</div>
					<?php
					}
				} ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
	<?php
	} ?>
  </footer>

<div class="modal fade" id="contactusForm" tabindex="-1" role="dialog" aria-labelledby="contactusFormLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Contact Us</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <img src="<?=SITE_URL?>images/payment/close.png" alt="">
          </button>
        </div>
        <div class="modal-body pt-3 text-center">
		  <?php
		  $contact_us_fill_data = array();
		  if(isset($_SESSION['contact_us_fill_data'])) {
		  	$contact_us_fill_data = $_SESSION['contact_us_fill_data'];
			unset($_SESSION['contact_us_fill_data']);
		  } ?>
          <form action="<?=SITE_URL?>controllers/contact.php" method="post" class="sign-in" id="contact_form">
            <div class="form-row">
              <div class="form-group col-md-6">
				<input type="text" class="form-control" name="name" id="name" placeholder="Enter name" value="<?=(isset($contact_us_fill_data['name'])?$contact_us_fill_data['name']:'')?>">
              </div>
              <div class="form-group telephone-form mt-0 col-md-6">
			  	<input type="tel" id="contact_cell_phone" name="cell_phone" class="form-control" placeholder="">
				<input type="hidden" name="phone" id="contact_phone" />
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
				<input type="text" class="form-control" name="email" id="email" placeholder="Enter email" value="<?=(isset($contact_us_fill_data['email'])?$contact_us_fill_data['email']:'')?>">
              </div>
              <div class="form-group mt-0 col-md-6">
				<input type="text" class="form-control" name="order_id" id="order_id" placeholder="Enter order number" value="<?=(isset($contact_us_fill_data['order_id'])?$contact_us_fill_data['order_id']:'')?>">
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-12">
				<input type="text" class="form-control" name="subject" id="subject" placeholder="Enter subject" value="<?=(isset($contact_us_fill_data['subject'])?$contact_us_fill_data['subject']:'')?>">
              </div>
            </div>
            <div class="form-row">
               <div class="form-group col-md-12">
				 <textarea class="form-control" name="message" id="message" placeholder="Enter message"><?=(isset($contact_us_fill_data['message'])?$contact_us_fill_data['message']:'')?></textarea>
               </div>
            </div>
            
			<?php
			if($contact_form_captcha == '1') { ?>
			<div class="form-row">
				<div class="form-group col-md-12">
					<div id="p_c_g_form_gcaptcha"></div>
					<input type="hidden" id="p_c_g_captcha_token" name="g_captcha_token" value=""/>
					<?php
					if(isset($contact_us_fill_data['msg_field']) && $contact_us_fill_data['msg_field'] == "captcha") {
						echo '<small style="display:inline;color:red;">'.$contact_us_fill_data['msg_label'].'</small>';
					} ?>
				</div>
			</div>
			<?php
			} ?>
			
            <div class="form-group double-btn pt-5 text-center">
              <button type="submit" class="btn btn-primary btn-lg rounded-pill ml-lg-3 contact_form_sbmt_btn">Submit</button>
			  <input type="hidden" name="submit_form" id="submit_form" />
            </div>
			<?php
			$ct_csrf_token = generateFormToken('contact');
			echo '<input type="hidden" name="csrf_token" value="'.$ct_csrf_token.'">'; ?>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="trackOrderForm" tabindex="-1" role="dialog" aria-labelledby="trackOrder" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content track_order_form_showhide">
        <div class="modal-header">
          <h5 class="modal-title">Track your order</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <img src="<?=SITE_URL?>images/payment/close.png" alt="">
          </button>
        </div>
        <div class="modal-body pt-3 text-center">
          <form class="form-inline track-order needs-validation justify-content-center" id="track_order_form" method="post" novalidate>
            <input type="text" class="form-control" id="track_order_id" name="track_order_id" placeholder="Enter order #, ex. Mn6HklO" required>
            <button type="button" class="btn btn-primary btn-lg rounded-pill track_order_form_btn">Track it</button>
          </form>
        </div>
      </div>
	  <div class="modal-content track_order_not_found_showhide" style="display:none;">
        <div class="modal-header pt-5">
          <h5 class="modal-title pl-lg-5 pr-lg-5 ml-lg-5 mr-lg-5">Your order isn’t found. Please check order number and try again.</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <img src="<?=SITE_URL?>images/payment/close.png" alt="">
          </button>
        </div>
        <div class="modal-body pt-3 text-center">
          <button type="button" class="btn btn-primary btn-lg rounded-pill track_order_try_again">Try again</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="trackOrder" tabindex="-1" role="dialog" aria-labelledby="trackOrder" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content track_order_found_info"></div>
    </div>
  </div>

  <div class="modal fade" id="SignInRegistration" tabindex="-1" role="dialog" aria-labelledby="SignInRegistration" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <img src="<?=SITE_URL?>images/payment/close.png" alt="">
          </button>
        </div>
        <div class="modal-body text-center pt-4">
		  <?php
		  $is_review_order_page_with_cart_items = false;
		  if($allow_guest_user_order == '1' && $url_first_param == "cart" && $basket_item_count_sum_data['basket_item_count']>0) {
		  	$is_review_order_page_with_cart_items = true;
		  } ?>
          <ul class="nav nav-tabs signInUpTab" id="myTab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">
                <p>Sign In</p>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">
                <p>
                  Registration
                </p>
              </a>
            </li>
          </ul>
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
              <form action="<?=SITE_URL?>controllers/user/login.php" method="post" class="sign-in needs-validation f-login-form" novalidate>
			  	<div class="f-signin-form-msg" style="display:none;"></div>
				<div class="form-group with-icon">
				  <img src="<?=SITE_URL?>images/icons/user-gray.png" alt="">
				  <input type="email" class="form-control" id="username" name="username" placeholder="Your e-mail" autocomplete="nope" required>
				  <div class="invalid-feedback">
					your e-mail incorrect
				  </div>
				</div>
				<div class="form-group with-icon">
				  <img src="<?=SITE_URL?>images/icons/lock.png" alt="">
				  <input type="password" class="form-control" id="password" name="password" placeholder="Password" autocomplete="nope" required>
				  <div class="invalid-feedback">
					Password incorrect
				  </div>
				</div>
				
				<?php
				if($login_form_captcha == '1') { ?>
				<div class="form-group">
					<div id="p_l_g_form_gcaptcha"></div>
					<input type="hidden" id="p_l_g_captcha_token" name="p_l_g_captcha_token" value=""/>
				</div>
				<?php
				} ?>
				
				<div class="form-group">
				  <a href="javascript:void(0);" id="forgot_password_link">Forgot password?</a>
				</div>
				<div class="form-group text-center">
				<button type="submit" class="btn btn-primary btn-lg rounded-pill">Continue</button>
				<input type="hidden" name="submit_form" id="submit_form" />
				</div>
				
				<?php
				if($social_login=='1') { ?>
					<div class="divider">
					  <span>or</span>
					</div>
					<ul class="social">
						<?php
						if($social_login_option=="g_f") { ?>
						  <li class="facebook">
							<a href="javascript:void(0);" class="facebook_auth"><i class="fab fa-facebook-f"></i>Continue with facebook</a>
						  </li>
						  <li class="google">
							<a href="javascript:void(0);" class="google_auth"><i class="fab fa-google"></i>Continue with Google</a>
						  </li>
						<?php
						} elseif($social_login_option=="g") { ?>
						  <li class="google">
							<a href="javascript:void(0);" class="google_auth"><i class="fab fa-google"></i>Continue with Google</a>
						  </li>
						<?php
						} elseif($social_login_option=="f") { ?>
						  <li class="facebook">
							<a href="javascript:void(0);" class="facebook_auth"><i class="fab fa-facebook-f"></i>Continue with facebook</a>
						  </li>
						<?php
						} ?>
					</ul>
				<?php
				}
				$p_l_csrf_token = generateFormToken('login');
				echo '<input type="hidden" name="csrf_token" value="'.$p_l_csrf_token.'">';
				if($is_review_order_page_with_cart_items) {
					echo '<input type="hidden" name="from_cart" value="1" />';
				} ?>
			  </form>
			  <form action="<?=SITE_URL?>controllers/user/lost_password.php" method="post" class="sign-in needs-validation f-lost-psw-form" style="display:none;" novalidate>
			  	<h5 class="modal-title">Don’t know your password?</h5>
				<div class="form-group with-icon">
				  <img src="<?=SITE_URL?>images/icons/user-gray.png" alt="">
				  <input type="email" class="form-control" id="email" name="email" placeholder="Your e-mail" autocomplete="nope" required>
				  <div class="invalid-feedback">
					your e-mail incorrect
				  </div>
				</div>
				
				<div class="form-group mt-2">
				  <p class="info-text form-text text-left">We’ll send you a link to change your password.<br>If you still need help, <a href="#">visit our Help Center.</a></p>
				</div>

				<div class="form-group double-btn pt-5 text-center">
				<button type="button" class="btn btn-lg btn-outline-dark rounded-pill mr-lg-3" id="forgot_password_back">Back</button>
				<button type="submit" class="btn btn-primary btn-lg rounded-pill">Request a password reset</button>
				<input type="hidden" name="reset" id="reset" />
				</div>
				<?php
				$l_p_csrf_token = generateFormToken('lost_password');
				echo '<input type="hidden" name="csrf_token" value="'.$l_p_csrf_token.'">'; ?>
			  </form>
            </div>

            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
              <form action="<?=SITE_URL?>controllers/user/signup.php" method="post" class="sign-in needs-validation f-signup-form" novalidate>
			  	<div class="f-signup-form-msg" style="display:none;"></div>
				<div class="form-group with-icon">
				  <img src="<?=SITE_URL?>images/icons/user-gray.png" alt="Signup Email">
				  <input type="email" class="form-control" name="email" id="signup_email" placeholder="Your e-mail" autocomplete="nope" required>
				  <div class="invalid-feedback">
					your e-mail incorrect
				  </div>
				</div>
				
				<?php
				if($is_review_order_page_with_cart_items) { ?>
					<div class="form-group">
						<div class="custom-control custom-checkbox">
						  <input type="checkbox" class="custom-control-input" name="is_guest" id="is_guest" value="1"/>
						  <label class="custom-control-label" for="is_guest">Checkout as Guest</label>
						</div>
					</div>
				<?php
				} else {
					echo '<input type="hidden" name="is_guest" id="is_guest" value="0"/>';
				} ?>
					
				<div class="form-group with-icon password-field">
				  <img src="<?=SITE_URL?>images/icons/lock.png" alt="Signup Password">
				  <input type="password" class="form-control" name="password" id="signup_password" placeholder="Password" autocomplete="nope" required>
				  <div class="invalid-feedback">
					Password incorrect
				  </div>
				</div>
				
				<?php
				if($display_terms_array['ac_creation']=="ac_creation") { ?>
				<div class="form-group">
					<div class="custom-control custom-checkbox">
						<input type="checkbox" class="custom-control-input" name="ac_terms_conditions" id="p_ac_terms_conditions" value="1" required/>
						<label class="custom-control-label" for="p_ac_terms_conditions">I accept <a href="javascript:void(0)" class="help-icon click_terms_of_website_use">Terms and Condition</a></label>
						<div class="invalid-feedback">
							Please accept terms & conditions.
						</div>
					</div>
					
				</div>
				<?php
				} else {
					echo '<input type="hidden" name="ac_terms_conditions" id="ac_terms_conditions" value="1"/>';
				}

				if($signup_form_captcha == '1') { ?>
				<div class="form-group">
					<div id="p_s_g_form_gcaptcha"></div>
					<input type="hidden" id="p_s_g_captcha_token" name="p_s_g_captcha_token" value=""/>
				</div>
				<?php
				} ?>

				<div class="form-group pt-3 text-center">
				  <button type="submit" class="btn btn-primary btn-lg rounded-pill signup_form_btn">Continue</button>
				  <input type="hidden" name="submit_form" id="submit_form" />
				</div>

				<?php
				if($social_login=='1') { ?>
					<div class="divider">
					  <span>or</span>
					</div>
					<ul class="social">
						<?php
						if($social_login_option=="g_f") { ?>
						  <li class="facebook">
							<a href="javascript:void(0);" class="facebook_auth"><i class="fab fa-facebook-f"></i>Continue with facebook</a>
						  </li>
						  <li class="google">
							<a href="javascript:void(0);" class="google_auth"><i class="fab fa-google"></i>Continue with Google</a>
						  </li>
						<?php
						} elseif($social_login_option=="g") { ?>
						  <li class="google">
							<a href="javascript:void(0);" class="google_auth"><i class="fab fa-google"></i>Continue with Google</a>
						  </li>
						<?php
						} elseif($social_login_option=="f") { ?>
						  <li class="facebook">
							<a href="javascript:void(0);" class="facebook_auth"><i class="fab fa-facebook-f"></i>Continue with facebook</a>
						  </li>
						<?php

						} ?>
					</ul>
				<?php
				}
				
				$p_s_csrf_token = generateFormToken('signup');
				echo '<input type="hidden" name="csrf_token" value="'.$p_s_csrf_token.'">'; ?>
				<input type="hidden" name="from_cart" value="1" />
			  </form>

			  <form action="<?=SITE_URL?>controllers/user/verify_account.php" method="post" class="sign-in needs-validation f-verifycode-form" style="display:none;" novalidate>
			  	<div class="f-verifycode-form-msg" style="display:none;"></div>
				<div class="form-group">
				  <input type="text" class="form-control" name="verification_code" id="verification_code" placeholder="Your verification code" autocomplete="nope" onkeyup="this.value=this.value.replace(/[^\d]/,'');" required>
				  <div class="invalid-feedback">
					enter verification code
				  </div>
				</div>

				<div class="form-group pt-3 text-center">
				  <button type="submit" class="btn btn-primary btn-lg rounded-pill verifycode_form_btn">Verify</button>
				  <input type="hidden" name="submit_form" id="submit_form" />
				  <input type="hidden" name="user_id" id="verifycode_user_id" />
				</div>

				<?php
				$v_a_csrf_token = generateFormToken('verify_account');
				echo '<input type="hidden" name="csrf_token" value="'.$v_a_csrf_token.'">'; ?>
			  </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<div class="modal fade common_popup" id="terms_of_website_use" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
	    <div class="modal-header">
          <h5 class="modal-title">Terms & Conditions</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <img src="<?=SITE_URL?>images/payment/close.png" alt="">
          </button>
        </div>
        <div class="modal-body">
		  <span id="terms_of_website_use_spining_icon"></span>
		  <div id="terms_of_website_use_content"></div>
          <?php
		  //$terms_pg_data = get_inbuild_page_data('terms-and-conditions');
		  //echo $terms_pg_data['data']['content']; ?>
        </div>
      </div>
    </div>
</div>

<?php
//START for offer popup
if(isset($active_page_data['slug']) && $active_page_data['slug'] == "home" && $allow_offer_popup == '1') { ?>
	<div class="modal fade common_popup" id="instant_offer_popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<?php
				if($offer_popup_title!="") {
					echo '<h5 class="modal-title">'.$offer_popup_title.'</h5>';
				} ?>
				<!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<img src="<?=SITE_URL?>images/payment/close.png" alt="">
				</button> -->
			</div>
			<div class="modal-body">
				<?php
				if($offer_popup_content!="") {
					echo $offer_popup_content;
				} ?>
      		</div>
			<div class="modal-footer footer_btn_section">
				<!-- <a href="javascript:void(0)" class="btn btn-success close_offer_popup_later">MAYBE LATER</a>
        		<a href="javascript:void(0)" class="btn btn-danger close_offer_popup_no_thanks">NO THANKS</a> -->
        		<a href="javascript:void(0)" class="close_offer_popup_later">MAYBE LATER</a> <span>|</span> <a href="javascript:void(0)" class="close_offer_popup_no_thanks">NO THANKS</a>
			</div>
		</div>
	  </div>
	</div>

	<a href="#" id="back-to-top" title="Back to top">
		<i class="ion ion-ios-arrow-up"></i>
	</a>

	<script type="text/javascript">
	var popup_once_per_session=1;
	function get_popup_cookie(Name) {
	  var search = Name + "="
	  var returnvalue = "";
	  if(document.cookie.length > 0) {
		offset = document.cookie.indexOf(search)
		if(offset != -1) { // if cookie exists
		  offset += search.length
		  // set index of beginning of value
		  end = document.cookie.indexOf(";", offset);
		  // set index of end of cookie value
		  if(end == -1)
			 end = document.cookie.length;
		  	 returnvalue=unescape(document.cookie.substring(offset, end))
		  }
	   }
	  return returnvalue;
	}

	function offer_popup_showORnot()
	{
		var delay_time=<?=$offer_popup_delay_time_in_ms?>;
		if((get_popup_cookie('instantpopup')=='')&&(!popup_readCookie('instantpopup'))){
			setTimeout(function() {
				jQuery('#instant_offer_popup').modal({backdrop: 'static',keyboard: false});
			}, delay_time);
		}
	}
	if(popup_once_per_session==1) {
		offer_popup_showORnot();
	}
	
	function popup_createCookie(name,value,days) {
	  if(days) {
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		var expires = "; expires="+date.toGMTString();
	  } else {
		var expires = "";
	  }
	  document.cookie = name+"="+value+expires+"; path=/";
	}
	
	function popup_readCookie(name) {
	  var nameEQ = name + "=";
	  var ca = document.cookie.split(';');
	  for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	  }
	  return null;
	}
	
	jQuery(document).ready(function($) {
		$('.close_offer_popup, .close_offer_popup_later').click(function() {
			$('#instant_offer_popup').modal('hide');
			popup_createCookie('instantpopup', true, 1);
			return false;
		});
	
		$('.close_offer_popup_no_thanks').click(function() {
			$('#instant_offer_popup').modal('hide');
			popup_createCookie('instantpopup', true, 365);
			return false;
		});
	});
	</script>
<?php
} //END for offer popup ?>

<?php
if($login_form_captcha == '1' || $signup_form_captcha == '1' || $contact_form_captcha == '1') { ?>
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
				g_c_signup_wdt_id = grecaptcha.render('p_s_g_form_gcaptcha', {
					'sitekey' : '<?=$captcha_key?>',
					'callback' : onSubmitFormOfps,
				});
			}
		<?php
		}
		if($contact_form_captcha == '1') { ?>
			if(jQuery('#p_c_g_form_gcaptcha').length) {
				g_c_contact_wdt_id = grecaptcha.render('p_c_g_form_gcaptcha', {
					'sitekey' : '<?=$captcha_key?>',
					'callback' : onSubmitFormOfpc,
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
	}
	if($contact_form_captcha == '1') { ?>
	var onSubmitFormOfpc = function(response) {
		if(response.length == 0) {
			//jQuery('.contact_form_sbmt_btn').prop('disabled', false);
			jQuery("#p_c_g_captcha_token").val('');
		} else {
			jQuery('.contact_form_sbmt_btn').prop('disabled', false);
			//jQuery("#p_c_g_captcha_token").val('yes');
		}
	};
	<?php
	} ?>
	</script>
<?php
}

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

		//For Facebook
		$('.facebook_auth').oauthpopup({
			path: 'social/social.php?facebook',
			width:1000,
			height:1000,
		});
	});
	</script>
<?php
} ?>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="<?=SITE_URL?>js/popper.min.js"></script>
  <script src="<?=SITE_URL?>js/bootstrap_4.3.1.min.js"></script>
  <script src="<?=SITE_URL?>js/slick.min.js"></script>
  <script src="<?=SITE_URL?>js/jquery.autocomplete.min.js"></script>
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
  <script src="<?=SITE_URL?>js/intlTelInput.js"></script>
  <script src="<?=SITE_URL?>js/bootstrapvalidator.min.js"></script>
  <script src="<?=SITE_URL?>js/bootstrap-datepicker.min.js"></script>
  <script>
    jQuery.noConflict();
    (function ($) {
      $(function () {

		$(window).on("scroll", function() {
			if($(window).scrollTop()) {
				  $('header').addClass('orang animated fadeInDown');
			} else {
				  $('header').removeClass('orang fadeInDown fadeInDown');
			}
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

		$('.block.review-slide.page .card .card-body, .offer-section .card-body').matchHeight();
		
		$('input').each(function() {
			$(window).keydown(function(event){
				if(event.keyCode == 13) {
				  return false;
				}
			});
		});
		
		$('#ac_table_id').DataTable({
		  <?php
		  if($url_first_param=="account") {
		  echo '"aaSorting": [[1, "desc"]],';
		  } ?>
          "bFilter": false,
          "bInfo": false,
          "dom": '<"top"i>rt<"bottom"flp><"clear">',
          "aoColumnDefs": [{
            "bSortable": false,
            "aTargets": ["no-sort"]
          }]
        });
		
		$('#ac_nopage_table_id').DataTable({
		  "paging":   false,
          "bFilter": false,
          "bInfo": false,
          "dom": '<"top"i>rt<"bottom"flp><"clear">',
          "aoColumnDefs": [{
            "bSortable": false,
            "aTargets": ["no-sort"]
          }]
        });
		
		if($('#ac_table_id tr').length < 11) {
			$('.dataTables_paginate').hide();
		}

        $('.menu-toggle').click(function () {
           $('body').toggleClass('menu-active');
        });
        $('.device-info').click(function() {
		  var id = $(this).attr('data-id');
          $('.device-info-table-'+id).toggleClass('d-block');
          $('.item-description-'+id).toggleClass('active');
          $(this).toggleClass('info-active');
          if($(this).hasClass('info-active')){
            $(this).empty().append('less info');
          } else {
            $(this).empty().append('more info');
          }
		});
		
		$('.click_terms_of_website_use').click(function() {
			$('#terms_of_website_use').modal('show');
			
			$("#terms_of_website_use_spining_icon").html('<div class="spining-full-wrap"><div class="spining-icon"><i class="fa fa-spinner fa-spin" style="font-size:34px;"></i></div></div>');
			$("#terms_of_website_use_spining_icon").show();
			
			$.ajax({
				type: 'POST',
				url: '<?=SITE_URL?>ajax/get_terms_and_conditions_content.php',
				success: function(data) {
					if(data!="") {
						$('#terms_of_website_use_content').html(data);
					}
					$("#terms_of_website_use_spining_icon").html('');
					$("#terms_of_website_use_spining_icon").hide();
				}
			});
			return false;
		});
			
			/*$('#brandSlider').slick({
				slidesToShow: 4,
				slidesToScroll: 4,
				dots: true,
				arrows: false,
				responsive: [
					{
						breakpoint: 1025,
						settings: {
							slidesToShow: 2,
							slidesToScroll: 2
						}
					},
					{
						breakpoint: 767,
						settings: {
							slidesToShow: 2,
							slidesToScroll: 2
						}
					},
				]
			});
			$('#deviceSlider').slick({
				slidesToShow: 5,
				slidesToScroll: 3,
				dots: true,
				arrows: false,
				responsive: [
					{
						breakpoint: 1340,
						settings: {
							slidesToShow: 3,
							slidesToScroll: 3
						}
					},
					{
						breakpoint: 1200,
						settings: {
							slidesToShow: 2,
							slidesToScroll: 2
						}
					},
					{
						breakpoint: 1025,
						settings: {
							slidesToShow: 2,
							slidesToScroll: 2
						}
					},
					{
						breakpoint: 900,
						settings: {
							slidesToShow: 1,
							slidesToScroll: 1
						}
					},
				]
			});*/

		<?php
		if($url_first_param=="") { ?>
        $('.slider-nav').slick({
          slidesToShow: 3,
          slidesToScroll: 1,
          dots: false,
          centerMode: true,
          focusOnSelect: true,
          nextArrow: '<button type="button" class="slick-next"><img src="<?=SITE_URL?>images/icons/left_arrow.png"></button>',
          prevArrow: '<button type="button" class="slick-prev"><img src="<?=SITE_URL?>images/icons/right_arrow.png"></button>',
          responsive: [{
              breakpoint: 1450,
              settings: {
                slidesToShow: 2,
                slidesToScroll: 1
              }
            },
            {
              breakpoint: 1025,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1
              }
            },
            {
              breakpoint: 767,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1
              }
            },
          ]
        });
		<?php
		} ?>

		//START for check booking available
		$('.repair_appt_date').datepicker({
			autoclose: true,
			startDate: "today",
			todayHighlight: true
		}).on('changeDate', function(e) {
			getTimeSlotListByDate();
		}); //END for check booking available
	
		$('.datepicker').datepicker({autoclose:true});
		
		$('#clk_ftr_signup_btn').click(function() {
			var ftr_signup_email = $("#ftr_signup_email").val();		
			var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
			if(ftr_signup_email == "") {
				$("#ftr_signup_email").focus();
				return false;
			} else if(!ftr_signup_email.match(mailformat)) {
				$("#ftr_signup_email").focus();
				return false;
			} else {
				$('#newsletter_form').submit();
			}
		});

		$("#forgot_password_link").click(function() {
			$(".f-login-form").hide();
			$(".f-lost-psw-form").show();
		});
		$("#forgot_password_back").click(function() {
			$(".f-login-form").show();
			$(".f-lost-psw-form").hide();
		});
		
		$('.track_order_try_again').click(function() {
			$('.track_order_form_showhide').show();
			$('.track_order_not_found_showhide').hide();
		});
		$(document).on('click', '.order_track_login', function() {
			$("#trackOrder").modal('hide');
			$("#trackOrderForm").modal('hide');
			$("#SignInRegistration").modal();
		});
		$('.track_order_form_btn').click(function() {
			var track_order_id = $("#track_order_id").val();
			if(track_order_id=='') {
				$("#track_order_form").addClass('was-validated');
				return false;
			}
			$.ajax({
				type: 'POST',
				url: '<?=SITE_URL?>ajax/order_track.php',
				data: $('#track_order_form').serialize(),
				success: function(data) {
					if(data!="") {
						var resp_data = JSON.parse(data);
						if(resp_data.error == "not_found" && resp_data.msg != "") {
							$('.track_order_form_showhide').hide();
							$('.track_order_not_found_showhide').show();
							$("#track_order_id").val('');
						}
						else if(resp_data.error == "found" && resp_data.msg != "") {
							$('.track_order_found_info').html(resp_data.html);
							$("#trackOrder").modal();
							$("#trackOrderForm").modal('hide');
							$("#track_order_id").val('');
							
							$('#table_id').DataTable({
							   "bPaginate": false,
							   "paging": false,
							   "bFilter": false,
							   "bInfo": false,
							});
						}
					}
				}
			});
			return false;
		});
		
		$('#is_guest').click(function() {
			if($(this).prop("checked") == true) {
				$(".password-field").hide();
			} else if($(this).prop("checked") == false) {
				$(".password-field").show();
			}
		});
		$('.signup_form_btn').click(function() {
			var signup_email = $("#signup_email").val();
			var signup_password = $("#signup_password").val();
			
			var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
			var is_guest = document.getElementById('is_guest').checked;
			var p_ac_terms_conditions = document.getElementById('p_ac_terms_conditions').checked;
			if(signup_email=='' || (signup_password=='' && is_guest == false)) {
				$(".f-signup-form").addClass('was-validated');
				return false;
			} else if(!signup_email.match(mailformat)) {
				$(".f-signup-form").addClass('was-validated');
				return false;
			} else if(p_ac_terms_conditions == false) {
				$(".f-signup-form").addClass('was-validated');
				return false;
			}
			
			$.ajax({
				type: 'POST',
				url: '<?=SITE_URL?>ajax/signup.php',
				data: $('.f-signup-form').serialize(),
				success: function(data) {
					if(data!="") {
						var resp_data = JSON.parse(data);
						if(resp_data.status == "invalid" && resp_data.msg != "") {
							$('.f-signup-form-msg').html(resp_data.msg);
							$('.f-signup-form-msg').show();
							
							if(g_c_signup_wdt_id == '0' || g_c_signup_wdt_id > 0) {
								grecaptcha.reset(g_c_signup_wdt_id);
							}
						} else if(resp_data.status == "success" && resp_data.msg != "") {
							$('.f-signup-form-msg').html(resp_data.msg);
							$('.f-signup-form-msg').show();
							$('.nav-tabs a[href="#home"]').tab('show');
						} else if(resp_data.status == "success_guest" && resp_data.msg != "") {
							location.reload(true);
						} else if(resp_data.status == "resend" && resp_data.msg != "") {
							$('.f-signup-form').hide();
							$('.f-verifycode-form').show();
							$('#verifycode_user_id').val(resp_data.user_id);
						}
					}
				}
			});
			return false;
		});
		$('.verifycode_form_btn').click(function() {
			var verification_code = $("#verification_code").val();
			if(verification_code=='') {
				$(".f-verifycode-form").addClass('was-validated');
				return false;
			}
			$.ajax({
				type: 'POST',
				url: '<?=SITE_URL?>ajax/verify_account.php',
				data: $('.f-verifycode-form').serialize(),
				success: function(data) {
					if(data!="") {
						var resp_data = JSON.parse(data);
						if(resp_data.status == "invalid" && resp_data.msg != "") {
							$('.f-verifycode-form-msg').html(resp_data.msg);
							$('.f-verifycode-form-msg').show();
						} else if(resp_data.status == "success" && resp_data.msg != "") {
							$('.f-signin-form-msg').html(resp_data.msg);
							$('.f-signin-form-msg').show();
							$('.nav-tabs a[href="#home"]').tab('show');
						}
					}
				}
			});
			return false;
		});

		var contact_telInput = $("#contact_cell_phone");
		contact_telInput.intlTelInput({
		  initialCountry: "<?=$phone_country_short_code?>",
		  allowDropdown: false,
		  geoIpLookup: function(callback) {
			$.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
			  var countryCode = (resp && resp.country) ? resp.country : "";
			  callback(countryCode);
			});
		  },
		  utilsScript: "<?=SITE_URL?>js/intlTelInput-utils.js"
		});
		
		<?php
		if(isset($contact_us_fill_data['phone']) && $contact_us_fill_data['phone']) { ?>
		$("#contact_cell_phone").intlTelInput("setNumber", "<?=$contact_us_fill_data['phone']?>");
		$("#contactusForm").modal();
		<?php
		} ?>
		
		$('#contact_form').bootstrapValidator({
			fields: {
				name: {
					validators: {
						stringLength: {
							min: 1,
						},
						notEmpty: {
							message: 'Name required'
						}
					}
				},
				cell_phone: {
					validators: {
						callback: {
							message: 'Enter valid phone number',
							callback: function(value, validator, $field) {
								var contact_telInput = $("#contact_cell_phone");
								$("#contact_phone").val(contact_telInput.intlTelInput("getNumber"));
								if(!contact_telInput.intlTelInput("isValidNumber")) {
									return false;
								} else if(contact_telInput.intlTelInput("isValidNumber")) {
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
				subject: {
					validators: {
						notEmpty: {
							message: 'Enter your subject'
						}
					}
				},
				message: {
					validators: {
						notEmpty: {
							message: 'Enter your message'
						}
					}
				}
			}/*,
			submitHandler: function(validator, form, submitButton) {
				//var email = $("#signup_email").val();
				var $captcha = $('#p_c_g_form_gcaptcha'),response = grecaptcha.getResponse();
				if (response.length === 0) {
    				//$( '.msg-error').text( "reCAPTCHA is mandatory" );
					alert('reCAPTCHA is mandatory');
					//return false;
				} else {
					//alert("Hiii");
					$('#contact_form').validator('validate');
					form.submit();
					//return true;
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
	 
    (function () {
      'use strict';
      window.addEventListener('load', function () {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function (form) {
          form.addEventListener('submit', function (event) {
            if (form.checkValidity() === false) {
              event.preventDefault();
              event.stopPropagation();
            }
            form.classList.add('was-validated');
          }, false);
        });
      }, false);
    })();
  </script>
  
  <?=$before_body_js_code?>
</body>
</html>