<?php
$meta_title = "Profile";
$active_menu = "profile";

$csrf_token = generateFormToken('profile');

//Header section
include("include/header.php");

//If direct access then it will redirect to home page
if($user_id<=0) {
	setRedirect(SITE_URL);
	exit();
} elseif($user_data['status'] == '0' || empty($user_data)) {
	$is_include = 1;
	require_once('controllers/logout.php');

	$msg='Your account is inactive or removed by shop owner so please contact with support team OR re-create account.';
	setRedirectWithMsg(SITE_URL,$msg,'warning');
	exit();
} ?>

<form action="controllers/user/profile.php" method="post" id="profile_form" enctype="multipart/form-data" autocomplete="off">
  <section id="showAccount" class="py-0">
    <div class="container-fluid">
      <div class="block setting-page account py-0 clearfix">
        <div class="row">
          <div class="col-md-5 left-menu col-lg-4 col-xl-3">
            <?php require_once('views/account_menu.php');?>
          </div>
          <div class="col-12 col-sm-12 col-md-5 col-lg-8 col-xl-9 right-content">
            <div class="block heading page-heading setting-heading clearfix">
                <h3 class="float-left">Personal settings:</h3>
				<div class="float-right">
					<a class="btn btn-outline-dark rounded-pill ml-lg-5" href="<?=SITE_URL?>profile">Cancel</a>
					<button type="submit" class="btn btn-primary rounded-pill ml-2">Save</button>
					<input type="hidden" name="submit_form" id="submit_form" />
				</div>
            </div>
            <div class="block">
              <div class="row">
                <div class="col-md-12 col-lg-12 col-xl-6">
                  <div class="card">
                    <div class="card-body">
                      <h5 class="card-title">Change name</h5>
                      <div>
                        <div class="form-group row">
                          <label for="first_name" class="col-sm-4 col-form-label">First name</label>
                          <div class="col-sm-8">
							<input type="text" class="form-control" name="first_name" id="first_name" placeholder="" value="<?=$user_data['first_name']?>" required autocomplete="nope">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="last_name" class="col-sm-4 col-form-label">Last name</label>
                          <div class="col-sm-8">
                            <input type="text" class="form-control" name="last_name" id="last_name" placeholder="" value="<?=$user_data['last_name']?>" required autocomplete="nope">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="company_name" class="col-sm-4 col-form-label">Company</label>
                          <div class="col-sm-8">
                            <input type="text" class="form-control" name="company_name" id="company_name" placeholder="" value="<?=$user_data['company_name']?>" autocomplete="nope">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="card mt-3">
                    <div class="card-body">
                      <h5 class="card-title">Change password</h5>
                      <div>
                        <div class="form-group row">
                          <label for="profl_password" class="col-sm-5 col-form-label">New password</label>
                          <div class="col-sm-7">
						    <input type="password" class="form-control" name="profl_password" id="profl_password" autocomplete="none">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="profl_password2" class="col-sm-5 col-form-label">Repeat password</label>
                          <div class="col-sm-7">
						    <input type="password" class="form-control" name="profl_password2" id="profl_password2" autocomplete="none">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="card mt-3">
                    <div class="card-body">
                      <h5 class="card-title">Change e-mail</h5>
                      <div>
                        <div class="form-group row">
                          <label for="email" class="col-sm-4 col-form-label">New e-mail</label>
                          <div class="col-sm-8">
                            <input type="text" class="form-control" name="email" id="email" placeholder="" value="<?=$user_data['email']?>" autocomplete="nope">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="repeat_email" class="col-sm-4 col-form-label">Repeat e-mail</label>
                          <div class="col-sm-8">
                            <input type="text" class="form-control" name="repeat_email" id="repeat_email" placeholder="" value="<?=$user_data['email']?>" autocomplete="nope">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
				  <div class="card mt-3">
					  <div class="card mt-3 mb-3 mb-lg-0">
						<div class="card-body">
						  <h5 class="card-title">E-mail preferences</h5>
						  <div>
							<div class="custom-control custom-checkbox">
							  <input type="checkbox" class="custom-control-input" name="email_preference_alert" id="email_preference_alert" value="1" <?=($user_data['email_preference_alert'] == '1'?'checked="checked"':'')?>/>
							  <label class="custom-control-label" for="email_preference_alert"> I want to receive promotions, promo codes and others</label>
							</div>
						  </div>
						</div>
					  </div>
				  </div>
                </div>
                <div class="col-md-12 col-lg-12 col-xl-6">
                  <div class="card">
                    <div class="card-body">
                      <h5 class="card-title">Change shipping address</h5>
                      <div>
                        <div class="form-group row">
                          <label for="address" class="col-sm-4 col-form-label">Street address</label>
                          <div class="col-sm-8">
						  	<input type="text" class="form-control" name="address" id="address" placeholder="" value="<?=$user_data['address']?>" required autocomplete="nope">
                          </div>
                        </div>
						<div class="form-group row">
                          <label for="address2" class="col-sm-4 col-form-label">Street address 2</label>
                          <div class="col-sm-8">
						  	<input type="text" class="form-control" name="address2" id="address2" placeholder="" value="<?=$user_data['address2']?>" autocomplete="nope">
                          </div>
                        </div>
						<div class="form-group row">
                          <label for="city" class="col-sm-4 col-form-label">City</label>
                          <div class="col-sm-8">
						  	<input type="text" class="form-control" name="city" id="city" placeholder="" value="<?=$user_data['city']?>" required autocomplete="nope">
                          </div>
                        </div>
						<div class="form-group row">
                          <label for="state" class="col-sm-4 col-form-label">State</label>
                          <div class="col-sm-8">
						  	<input type="text" class="form-control" name="state" id="state" placeholder="" value="<?=$user_data['state']?>" required autocomplete="nope">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="postcode" class="col-sm-4 col-form-label">Zip code</label>
                          <div class="col-sm-8">
                            <input type="text" class="form-control" name="postcode" id="postcode" placeholder="" value="<?=$user_data['postcode']?>" required autocomplete="nope">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="cell_phone" class="col-sm-4 col-form-label">Phone number</label>
                          <div class="col-sm-8">
						  	<input type="tel" id="cell_phone" name="cell_phone" class="form-control">
                  			<input type="hidden" name="phone_c_code" id="phone_c_code" value="<?=$user_data['country_code']?>"/>
                          </div>
                        </div>
                        <div class="custom-control custom-checkbox">
						  <input type="checkbox" class="custom-control-input" name="use_shipping_adddress_prefilled" id="use_shipping_adddress_prefilled" value="1" <?=($user_data['use_shipping_adddress_prefilled'] == '1'?'checked="checked"':'')?>/>
                          <label class="custom-control-label" for="use_shipping_adddress_prefilled">Auto fill shipping address for new orders</label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="card mt-3">
                    <div class="card-body">
                      <h5 class="card-title"><?=$profile_payment_method_title?></h5>
                      <div>
						<div id="payment">
							<?php
							$payment_method_details = json_decode($user_data['payment_method_details'],true);
							$my_payment_option = $payment_method_details['my_payment_option'];
							if($my_payment_option) {
								$default_payment_option = $my_payment_option;
							}
							if($choosed_payment_option['bank']=="bank") { ?>
							<div class="card mb-2">
								<div class="card-header" id="headingBank">
									<h5 class="mb-0">
										<button type="button" class="btn btn-link pmnt_bank_opt <?php if($default_payment_option!="bank"){echo 'collapsed';}?>" data-toggle="collapse" data-target="#collapseBank" aria-expanded="<?php if($default_payment_option=="bank"){echo 'true';}else{echo 'false';}?>" aria-controls="collapseBank">
											<?=$payment_method_bank_heading_text?>
										</button>
										<input type="hidden" name="data[bank][payment_method_name]" value="bank">
									</h5>
								</div>
						
								<div id="collapseBank" class="collapse <?php if($default_payment_option=="bank"){echo 'show';}?>" aria-labelledby="headingBank" data-parent="#payment">
									<div class="card-body">
										<div class="row mb-3">
											<div class="form_group col-sm-12">
												<label><?=$profile_payment_method_act_name_place_holder_text?></label>
												<input type="text" class="form-control" id="act_name" name="data[bank][act_name]" placeholder="" value="<?=(!empty($payment_method_details['data']['bank']['act_name'])?$payment_method_details['data']['bank']['act_name']:'')?>" autocomplete="nope">
											</div>
										</div>
										<div class="row mb-3">
											<div class="form_group col-sm-12">
												<label><?=$profile_payment_method_act_number_place_holder_text?></label>
												<input type="text" class="form-control" id="act_number" name="data[bank][act_number]" placeholder="" value="<?=(!empty($payment_method_details['data']['bank']['act_number'])?$payment_method_details['data']['bank']['act_number']:'')?>" autocomplete="nope">
											</div>
										</div>
										<div class="row">
											<div class="form_group col-sm-12">
												<label><?=$profile_payment_method_act_short_code_place_holder_text?></label>
												<input type="text" class="form-control" id="act_short_code" name="data[bank][act_short_code]" placeholder="" value="<?=(!empty($payment_method_details['data']['bank']['act_short_code'])?$payment_method_details['data']['bank']['act_short_code']:'')?>" autocomplete="nope">
											</div>
										</div>
									</div>
								</div>
							</div>
							<?php
							}
							if($choosed_payment_option['cheque']=="cheque") { ?>
							<div class="card mb-2">
								<div class="card-header" id="headingCheque">
									<h5 class="mb-0">
										<button type="button" class="btn btn-link pmnt_cheque_opt <?php if($default_payment_option!="cheque"){echo 'collapsed';}?>" data-toggle="collapse" data-target="#collapseCheque" aria-expanded="<?php if($default_payment_option=="cheque"){echo 'true';}else{echo 'false';}?>" aria-controls="collapseCheque">
											<?=$cheque_check_label?>
											<input type="hidden" name="data[cheque][payment_method_name]" value="cheque">
										</button>
									</h5>
								</div>
								<div id="collapseCheque" class="collapse <?php if($default_payment_option=="cheque"){echo 'show';}?>" aria-labelledby="headingCheque" data-parent="#payment">
								</div>
							</div>
							<?php
							}
							if($choosed_payment_option['paypal']=="paypal") { ?>
							<div class="card mb-2">
								<div class="card-header" id="headingPayPal">
									<h5 class="mb-0">
										<button type="button" class="btn btn-link pmnt_paypal_opt <?php if($default_payment_option!="paypal"){echo 'collapsed';}?>" data-toggle="collapse" data-target="#collapsePaypal" aria-expanded="<?php if($default_payment_option=="paypal"){echo 'true';}else{echo 'false';}?>" aria-controls="collapsePaypal">
											<?=$payment_method_paypal_heading_text?>
											<input type="hidden" name="data[paypal][payment_method_name]" value="paypal">
										</button>
									</h5>
								</div>
								<div id="collapsePaypal" class="collapse <?php if($default_payment_option=="paypal"){echo 'show';}?>" aria-labelledby="headingPayPal" data-parent="#payment">
									<div class="card-body">
										<div class="inner_box row">
											<div class="form_group col-sm-12">
												<label><?=$profile_payment_method_paypal_adr_place_holder_text?></label>
												<input type="text" class="form-control" placeholder="" id="paypal_address"  name="data[paypal][paypal_address]" value="<?=(!empty($payment_method_details['data']['paypal']['paypal_address'])?$payment_method_details['data']['paypal']['paypal_address']:'')?>" autocomplete="nope">
											</div>
										</div>
									</div>
								</div>
							</div>
							<?php
							}
							if($choosed_payment_option['venmo']=="venmo") { ?>
							<div class="card mb-2">
								<div class="card-header" id="headingVenmo">
									<h5 class="mb-0">
										<button type="button" class="btn btn-link pmnt_venmo_opt <?php if($default_payment_option!="venmo"){echo 'collapsed';}?>" data-toggle="collapse" data-target="#collapseVenmo" aria-expanded="<?php if($default_payment_option=="venmo"){echo 'true';}else{echo 'false';}?>" aria-controls="collapseVenmo">
											<?=$payment_method_venmo_heading_text?>
											<input type="hidden" name="data[venmo][payment_method_name]" value="venmo">
										</button>
									</h5>
								</div>
								<div id="collapseVenmo" class="collapse <?php if($default_payment_option=="venmo"){echo 'show';}?>" aria-labelledby="headingVenmo" data-parent="#payment">
									<div class="card-body">
										<div class="row">
											<div class="form_group col-sm-12">
												<label><?=$profile_payment_method_venmo_adr_place_holder_text?></label>
												<input type="text" class="form-control" placeholder="" id="venmo_address"  name="data[venmo][venmo_address]" value="<?=(!empty($payment_method_details['data']['venmo']['venmo_address'])?$payment_method_details['data']['venmo']['venmo_address']:'')?>" autocomplete="nope">
											</div>
										</div>
									</div>
								</div>
							</div>
							<?php
							}
							if($choosed_payment_option['zelle']=="zelle") { ?>
							<div class="card mb-2">
								<div class="card-header" id="headingZelle">
									<h5 class="mb-0">
										<button type="button" class="btn btn-link pmnt_zelle_opt <?php if($default_payment_option!="zelle"){echo 'collapsed';}?>" data-toggle="collapse" data-target="#collapseZelle" aria-expanded="<?php if($default_payment_option=="zelle"){echo 'true';}else{echo 'false';}?>" aria-controls="collapseZelle">
											<?=$payment_method_zelle_heading_text?>
											<input type="hidden" name="data[zelle][payment_method_name]" value="zelle">
										</button>
									</h5>
								</div>
								<div id="collapseZelle" class="collapse <?php if($default_payment_option=="zelle"){echo 'show';}?>" aria-labelledby="headingZelle" data-parent="#payment">
									<div class="card-body">
										<div class="inner_box row">
											<div class="form_group col-sm-12">
												<label><?=$profile_payment_method_zelle_adr_place_holder_text?></label>
												<input type="text" class="form-control" placeholder="" id="zelle_address"  name="data[zelle][zelle_address]" value="<?=(!empty($payment_method_details['data']['zelle']['zelle_address'])?$payment_method_details['data']['zelle']['zelle_address']:'')?>" autocomplete="nope">
											</div>
										</div>
									</div>
								</div>
							</div>
							<?php
							}
							if($choosed_payment_option['amazon_gcard']=="amazon_gcard") { ?>
							<div class="card mb-3">
								<div class="card-header" id="headingAmazon">
									<h5 class="mb-0">
										<button type="button" class="btn btn-link pmnt_amazon_gcard_opt <?php if($default_payment_option!="amazon_gcard"){echo 'collapsed';}?>" data-toggle="collapse" data-target="#collapseAmazon" aria-expanded="<?php if($default_payment_option=="amazon_gcard"){echo 'true';}else{echo 'false';}?>" aria-controls="collapseAmazon">
											<?=$payment_method_amazon_gcard_heading_text?>
											<input type="hidden" name="data[amazon_gcard][payment_method_name]" value="amazon_gcard">
										</button>
									</h5>
								</div>
								<div id="collapseAmazon" class="collapse <?php if($default_payment_option=="amazon_gcard"){echo 'show';}?>" aria-labelledby="headingAmazon" data-parent="#payment">
									<div class="card-body">
										<div class="inner_box row">
											<div class="form_group col-sm-12">
												<label><?=$profile_payment_method_amazon_gcard_adr_place_holder_text?></label>
												<input type="text" class="form-control" placeholder="" id="amazon_gcard_address"  name="data[amazon_gcard][amazon_gcard_address]" value="<?=(!empty($payment_method_details['data']['amazon_gcard']['amazon_gcard_address'])?$payment_method_details['data']['amazon_gcard']['amazon_gcard_address']:'')?>" autocomplete="nope">
											</div>
										</div>
									</div>
								</div>
							</div>
							<?php
							}
							if($choosed_payment_option['cash']=="cash") { ?>
							<div class="card mb-2">
								<div class="card-header" id="headingCash">
									<h5 class="mb-0">
										<button type="button" class="btn btn-link pmnt_cash_opt <?php if($default_payment_option!="cash"){echo 'collapsed';}?>" data-toggle="collapse" data-target="#collapseCash" aria-expanded="<?php if($default_payment_option=="cash"){echo 'true';}else{echo 'false';}?>" aria-controls="collapseCash">
											<?=$payment_method_cash_heading_text?>
										</button>
										<input type="hidden" name="data[cash][payment_method_name]" value="cash">
									</h5>
								</div>
								<div id="collapseCash" class="collapse <?php if($default_payment_option=="cash"){echo 'show';}?>" aria-labelledby="headingCash" data-parent="#payment">
									<div class="card-body">
										<div class="row mb-3">
											<div class="form_group col-sm-12">
												<label><?=$profile_payment_method_cash_name_place_holder_text?></label>
												<input type="text" class="form-control" id="cash_name" name="data[cash][cash_name]" placeholder="" value="<?=(!empty($payment_method_details['data']['cash']['cash_name'])?$payment_method_details['data']['cash']['cash_name']:'')?>" autocomplete="nope">
											</div>
										</div>
										<div class="row">
											<div class="form_group col-sm-12">
												<label><?=$profile_payment_method_cash_phone_place_holder_text?></label>
												<input type="text" class="form-control" id="cash_phone" name="data[cash][cash_phone]" placeholder="" value="<?=(!empty($payment_method_details['data']['cash']['cash_phone'])?$payment_method_details['data']['cash']['cash_phone']:'')?>" autocomplete="nope">
											</div>
										</div>
									</div>
								</div>
							</div>
							<?php
							}
							
							if($choosed_payment_option['cash_app']=="cash_app") { ?>
							<div class="card mb-3">
								<div class="card-header" id="heading_cash_app">
									<h5 class="mb-0">
										<button type="button" class="btn btn-link pmnt_cash_app_opt <?php if($default_payment_option!="cash_app"){echo 'collapsed';}?>" data-toggle="collapse" data-target="#collapse_cash_app" aria-expanded="<?php if($default_payment_option=="cash_app"){echo 'true';}else{echo 'false';}?>" aria-controls="collapse_cash_app">
											<?=$payment_method_cash_app_heading_text?>
											<input type="hidden" name="data[cash_app][payment_method_name]" value="cash_app">
										</button>
									</h5>
								</div>
								<div id="collapse_cash_app" class="collapse <?php if($default_payment_option=="cash_app"){echo 'show';}?>" aria-labelledby="heading_cash_app" data-parent="#payment">
									<div class="card-body">
										<div class="inner_box row">
											<div class="form_group col-sm-12">
												<label><?=$profile_payment_method_cash_app_adr_place_holder_text?></label>
												<input type="text" class="form-control" placeholder="" id="cash_app_address"  name="data[cash_app][cash_app_address]" value="<?=(!empty($payment_method_details['data']['cash_app']['cash_app_address'])?$payment_method_details['data']['cash_app']['cash_app_address']:'')?>" autocomplete="nope">
											</div>
										</div>
									</div>
								</div>
							</div>
							<?php
							}
							if($choosed_payment_option['apple_pay']=="apple_pay") { ?>
							<div class="card mb-3">
								<div class="card-header" id="heading_apple_pay">
									<h5 class="mb-0">
										<button type="button" class="btn btn-link pmnt_apple_pay_opt <?php if($default_payment_option!="apple_pay"){echo 'collapsed';}?>" data-toggle="collapse" data-target="#collapse_apple_pay" aria-expanded="<?php if($default_payment_option=="apple_pay"){echo 'true';}else{echo 'false';}?>" aria-controls="collapse_apple_pay">
											<?=$payment_method_apple_pay_heading_text?>
											<input type="hidden" name="data[apple_pay][payment_method_name]" value="apple_pay">
										</button>
									</h5>
								</div>
								<div id="collapse_apple_pay" class="collapse <?php if($default_payment_option=="apple_pay"){echo 'show';}?>" aria-labelledby="heading_apple_pay" data-parent="#payment">
									<div class="card-body">
										<div class="inner_box row">
											<div class="form_group col-sm-12">
												<label><?=$profile_payment_method_apple_pay_adr_place_holder_text?></label>
												<input type="text" class="form-control" placeholder="" id="apple_pay_address"  name="data[apple_pay][apple_pay_address]" value="<?=(!empty($payment_method_details['data']['apple_pay']['apple_pay_address'])?$payment_method_details['data']['apple_pay']['apple_pay_address']:'')?>" autocomplete="nope">
											</div>
										</div>
									</div>
								</div>
							</div>
							<?php
							}
							if($choosed_payment_option['google_pay']=="google_pay") { ?>
							<div class="card mb-3">
								<div class="card-header" id="heading_google_pay">
									<h5 class="mb-0">
										<button type="button" class="btn btn-link pmnt_google_pay_opt <?php if($default_payment_option!="google_pay"){echo 'collapsed';}?>" data-toggle="collapse" data-target="#collapse_google_pay" aria-expanded="<?php if($default_payment_option=="google_pay"){echo 'true';}else{echo 'false';}?>" aria-controls="collapse_google_pay">
											<?=$payment_method_google_pay_heading_text?>
											<input type="hidden" name="data[google_pay][payment_method_name]" value="google_pay">
										</button>
									</h5>
								</div>
								<div id="collapse_google_pay" class="collapse <?php if($default_payment_option=="google_pay"){echo 'show';}?>" aria-labelledby="heading_google_pay" data-parent="#payment">
									<div class="card-body">
										<div class="inner_box row">
											<div class="form_group col-sm-12">
												<label><?=$profile_payment_method_google_pay_adr_place_holder_text?></label>
												<input type="text" class="form-control" placeholder="" id="google_pay_address"  name="data[google_pay][google_pay_address]" value="<?=(!empty($payment_method_details['data']['google_pay']['google_pay_address'])?$payment_method_details['data']['google_pay']['google_pay_address']:'')?>" autocomplete="nope">
											</div>
										</div>
									</div>
								</div>
							</div>
							<?php
							}
							if($choosed_payment_option['coinbase']=="coinbase") { ?>
							<div class="card mb-3">
								<div class="card-header" id="heading_coinbase">
									<h5 class="mb-0">
										<button type="button" class="btn btn-link pmnt_coinbase_opt <?php if($default_payment_option!="coinbase"){echo 'collapsed';}?>" data-toggle="collapse" data-target="#collapse_coinbase" aria-expanded="<?php if($default_payment_option=="coinbase"){echo 'true';}else{echo 'false';}?>" aria-controls="collapse_coinbase">
											<?=$payment_method_coinbase_heading_text?>
											<input type="hidden" name="data[coinbase][payment_method_name]" value="coinbase">
										</button>
									</h5>
								</div>
								<div id="collapse_coinbase" class="collapse <?php if($default_payment_option=="coinbase"){echo 'show';}?>" aria-labelledby="heading_coinbase" data-parent="#payment">
									<div class="card-body">
										<div class="inner_box row">
											<div class="form_group col-sm-12">
												<label><?=$profile_payment_method_coinbase_adr_place_holder_text?></label>
												<input type="text" class="form-control" placeholder="" id="coinbase_address"  name="data[coinbase][coinbase_address]" value="<?=(!empty($payment_method_details['data']['coinbase']['coinbase_address'])?$payment_method_details['data']['coinbase']['coinbase_address']:'')?>" autocomplete="nope">
											</div>
										</div>
									</div>
								</div>
							</div>
							<?php
							}
							if($choosed_payment_option['facebook_pay']=="facebook_pay") { ?>
							<div class="card mb-3">
								<div class="card-header" id="heading_facebook_pay">
									<h5 class="mb-0">
										<button type="button" class="btn btn-link pmnt_facebook_pay_opt <?php if($default_payment_option!="facebook_pay"){echo 'collapsed';}?>" data-toggle="collapse" data-target="#collapse_facebook_pay" aria-expanded="<?php if($default_payment_option=="facebook_pay"){echo 'true';}else{echo 'false';}?>" aria-controls="collapse_facebook_pay">
											<?=$payment_method_facebook_pay_heading_text?>
											<input type="hidden" name="data[facebook_pay][payment_method_name]" value="facebook_pay">
										</button>
									</h5>
								</div>
								<div id="collapse_facebook_pay" class="collapse <?php if($default_payment_option=="facebook_pay"){echo 'show';}?>" aria-labelledby="heading_facebook_pay" data-parent="#payment">
									<div class="card-body">
										<div class="inner_box row">
											<div class="form_group col-sm-12">
												<label><?=$profile_payment_method_facebook_pay_adr_place_holder_text?></label>
												<input type="text" class="form-control" placeholder="" id="facebook_pay_address"  name="data[facebook_pay][facebook_pay_address]" value="<?=(!empty($payment_method_details['data']['facebook_pay']['facebook_pay_address'])?$payment_method_details['data']['facebook_pay']['facebook_pay_address']:'')?>" autocomplete="nope">
											</div>
										</div>
									</div>
								</div>
							</div>
							<?php
							} ?>
						</div>
						
						<div class="row">
							<div class="form_group col-md-12">
								<div class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input" name="use_payment_method_prefilled" id="use_payment_method_prefilled" value="1" <?=($user_data['use_payment_method_prefilled'] == '1'?'checked="checked"':'')?>/>
									<label class="custom-control-label" for="use_payment_method_prefilled">Auto fill payment method for new orders</label>
								</div>
							</div>
						</div>
                      </div>
                    </div>
                  </div>
				</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
<input type="hidden" name="id" id="id" value="<?=$user_data['id']?>"/>
<input type="hidden" name="csrf_token" value="<?=$csrf_token?>">
<input id="payment_method" name="payment_method" value="<?=($payment_method_details['my_payment_option']?$payment_method_details['my_payment_option']:'paypal')?>" type="hidden">
</form>

<script>
function changefile(obj){
	var str  = obj.value;
	$(".upload_filename").html(str);
}

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
		$("#cell_phone").intlTelInput("setNumber", "<?=($user_data['phone']?'+'.$user_data['country_code'].$user_data['phone']:'')?>");

		var telInput = $("#cash_phone");
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
		$("#cash_phone").intlTelInput("setNumber", "<?=(!empty($payment_method_details['data']['cash']['cash_phone'])?$payment_method_details['data']['cash']['cash_phone']:'')?>");

		$(document).ready(function() {
			$(".pmnt_bank_opt").click(function() {
				$("#payment_method").val('bank');
			});
			$(".pmnt_cheque_opt").click(function() {
				$("#payment_method").val('cheque');
			});
			$(".pmnt_paypal_opt").click(function() {
				$("#payment_method").val('paypal');
			});
			$(".pmnt_venmo_opt").click(function() {
				$("#payment_method").val('venmo');
			});
			$(".pmnt_zelle_opt").click(function() {
				$("#payment_method").val('zelle');
			});
			$(".pmnt_amazon_gcard_opt").click(function() {
				$("#payment_method").val('amazon_gcard');
			});
			$(".pmnt_cash_opt").click(function() {
				$("#payment_method").val('cash');
			});
			$(".pmnt_cash_app_opt").click(function() {
				$("#payment_method").val('cash_app');
			});
			$(".pmnt_apple_pay_opt").click(function() {
				$("#payment_method").val('apple_pay');
			});
			$(".pmnt_google_pay_opt").click(function() {
				$("#payment_method").val('google_pay');
			});
			$(".pmnt_coinbase_opt").click(function() {
				$("#payment_method").val('coinbase');
			});
			$(".pmnt_facebook_pay_opt").click(function() {
				$("#payment_method").val('facebook_pay');
			});
		});

		$('#profile_form').bootstrapValidator({
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
								//$("#phone").val(telInput.intlTelInput("getNumber"));
								$("#phone_c_code").val(telInput.intlTelInput("getSelectedCountryData").dialCode);
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
						},
						identical: {
							field: 'repeat_email',
							message: 'New email and confirm email not matched.'
						}
					}
				},
				repeat_email: {
					validators: {
						notEmpty: {
							message: 'Please enter confirm email address.'
						},
						identical: {
							field: 'email',
							message: 'New email and confirm email not matched.'
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
				shipping_phone: {
					validators: {
						callback: {
							message: 'Please enter valid phone number',
							callback: function(value, validator, $field) {
								var telInput2 = $("#shipping_phone");
								$("#shipping_phone_c_code").val(telInput2.intlTelInput("getSelectedCountryData").dialCode);
								if(!telInput2.intlTelInput("isValidNumber")) {
									return false;
								} else if(telInput2.intlTelInput("isValidNumber")) {
									return true;
								}
							}
						}
					}
				},
				profl_password: {
					validators: {
						/*notEmpty: {
							message: 'Please enter new password.'
						},*/
						identical: {
							field: 'profl_password2',
							message: 'New password and repeat password not matched.'
						}
					}
				},
				profl_password2: {
					validators: {
						/*notEmpty: {
							message: 'Please enter confirm password.'
						},*/
						identical: {
							field: 'profl_password',
							message: '&nbsp;'
						}
					}
				}
			}
		}).on('success.form.bv', function(e) {
            $('#profile_form').data('bootstrapValidator').resetForm();

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