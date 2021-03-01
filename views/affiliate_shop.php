<?php
$affiliate_data = get_affiliate_data_by_store_name($_GET['shop']);
if(!empty($affiliate_data)) {

$meta_title = "Buyback Device";
$meta_keywords = "Buyback Device";
$meta_desc = "Buyback Device";

$csrf_token = generateFormToken('affiliate_shop'); ?>

<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="x-ua-compatible" content="IE=edge" >

<meta name="keywords" content="<?=$meta_keywords?>" />
<meta name="description" content="<?=$meta_desc?>" />
<title><?=$meta_title?></title>

<!-- Jquery Data Table -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="<?=SITE_URL?>css/style.css">
<link rel="stylesheet" href="<?=SITE_URL?>css/constant.css">
 <link rel="stylesheet" href="<?=SITE_URL?>css/color.css">
  
<link rel="stylesheet" href="<?=SITE_URL?>css/intlTelInput.css">

<link rel="stylesheet" href="<?=SITE_URL?>css/bootstrapValidator.min.css">
<link rel="stylesheet" href="<?=SITE_URL?>css/custom.css">

<style>
.d-none{display:none;}
.hide{display:none;}
</style>

<script src="<?=SITE_URL?>js/jquery.min.js"></script>
<script src="<?=SITE_URL?>js/jquery.scrollTo.min.js"></script>

<?=$custom_js_code?>
</head>

<body class="inner">
	<?php
	//START for confirm message
	$confirm_message = getConfirmMessage()['msg'];
	echo $confirm_message;
	//END for confirm message ?>

	<section id="search-product">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="block heading text-center" style="margin-bottom:0px;">
						<h3><?=$affiliate_shop_title?></h3>
						<h4><?=$affiliate_shop_search_title?></h4>
						<?php /*?><form role="form">
							<div class="form-group">
								<input type="email" class="form-control center mx-auto srch_list_of_model" id="imei_number" name="imei_number" placeholder="Search By IMEI Number">
							</div>
							<!-- <button type="button" class="btn btn-default" id="get_imei_info">Submit</button> -->
						</form><?php */?>
						<form class="form" action="<?=SITE_URL?>search" method="post">
							<div class="form-group">
							   <input type="text" name="search" class="form-control center mx-auto srch_list_of_model" id="autocomplete" placeholder="<?=$searchbox_placeholder?>">
							</div>
						</form>
						<!--<p>Information about you is used as described in our <a href="#">Privacy Policy.*</a></p>-->
						<div class="or-divider mt-4 pt-1">
							<strong>OR</strong>
						</div>
						<?php /*?><a href="javascript:void(0);" id="skip_imei_step">Select Your Device</a><?php */?>
					</div>
				</div>
			</div>
		</div>
	</section>
	
	<div id="wrapper">
		<div id="main" class="">
			<section class="sectionbox apr-section gray-bg">
				<div class="container">
					<div class="affiliate_section">
					<form action="<?=SITE_URL?>controllers/affiliate_shop.php" method="post" id="apr_form" enctype="multipart/form-data">
					<input type="hidden" name="affiliate_id" id="affiliate_id" value="<?=$affiliate_data['id']?>">
					<input type="hidden" name="affiliate_shop_name" id="affiliate_shop_name" value="<?=$affiliate_data['shop_name']?>">
					<div class="accordion-apr" id="accordion-apr">
						<?php /*?><div class="card" id="collapse_one_pos">
							<div class="card-header" id="headingOne">
							  <h5 class="mb-0">
								<button type="button" class="btn btn-link collapsed" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne" data-toggle="">
								  Select device type &nbsp;<i class="fas fa-chevron-down first-step-arrow-down hide"></i><i class="fas fa-chevron-up first-step-arrow-up"></i>
								</button>
							  </h5>
							</div>
							<div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion-apr">
							  <div class="card-body model-btn-group clearfix">
								<ul>
								<?php
								$device_data = get_device_data_list();
								$num_of_device = count($device_data);
								if($num_of_device>0) {
									foreach($device_data as $device_data) { ?>
										<li>
											<div class="custom-control custom-radio">
												<input type="radio" class="device_id custom-control-input" name="device_id" id="device_id_<?=$device_data['id']?>" value="<?=$device_data['id']?>">
												<label class="custom-control-label" for="device_id_<?=$device_data['id']?>">
													<?php
													if($device_data['device_img']) {
														$device_img_path = SITE_URL.'libraries/phpthumb.php?imglocation='.SITE_URL.'images/device/'.$device_data['device_img'].'&h=100'; ?>
														<p><img src="<?=$device_img_path?>" alt="<?=$device_data['title']?>"></p>
													<?php
													} ?>
													<h4><?=$device_data['title']?></h4>
												</label>
											</div>
										</li>
									<?php
									}
								} ?>
								</ul>
							  </div>
							</div>
						</div><?php */?>

						<div class="card" id="collapse_cat_pos">
							<div class="card-header" id="headingCat">
							  <h5 class="mb-0">
								<button type="button" class="btn btn-link collapsed" data-target="#collapseCat" aria-expanded="false" aria-controls="collapseCat" data-toggle="">
								  <span class="cat-step-arrow-down hide">Select category&nbsp;<i class="fas fa-chevron-down"></i></span>
								  <span class="cat-step-arrow-up">Select category&nbsp;<i class="fas fas fa-chevron-up"></i></span>
								</button>
							  </h5>
							</div>
							<div id="collapseCat" class="collapse show" aria-labelledby="headingCat" data-parent="#accordion-apr">
							  <div class="card-body model-btn-group">
								<ul>
								<?php
								$category_data_list = get_category_data_list();
								if(!empty($category_data_list)) {
									foreach($category_data_list as $category_data) { ?>
										<li>
											<div class="custom-control custom-radio">
												<input type="radio" class="cat_id custom-control-input" name="cat_id" id="cat_id_<?=$category_data['id']?>" value="<?=$category_data['id']?>">
												<label for="cat_id_<?=$category_data['id']?>" class="custom-control-label">
													<p>
													<?php
													if($category_data['icon_type']=="fa" && $category_data['fa_icon']!="") {
														echo '<i class="fa '.$category_data['fa_icon'].'"></i>';
													} elseif($category_data['icon_type']=="custom" && $category_data['image']!="") {
														$ct_img_path = SITE_URL.'images/categories/'.$category_data['image'];
														$ct_h_img_path = SITE_URL.'images/categories/'.$category_data['hover_image'];
														echo '<img class="main_img" src="'.$ct_img_path.'" alt="'.$category_data['title'].'">';
														echo '<img class="main_hover_img" src="'.$ct_h_img_path.'" alt="'.$category_data['title'].'">';
													} ?>
													</p>
													<h4><?=$category_data['title']?></h4>
												</label>
											</div>
										</li>
									<?php
									}
								} ?>
								</ul>
							  </div>
							</div>
						</div>
						
						<div class="card" id="collapse_brand_pos" style="display:none;">
							<div class="card-header" id="headingBrand">
							  <h5 class="mb-0">
								<button type="button" class="btn btn-link collapsed" data-target="#collapseBrand" aria-expanded="false" aria-controls="collapseBrand" data-toggle="">
								  <span class="brand-step-arrow-down hide">Select brand&nbsp;<i class="fas fa-chevron-down"></i></span>
								  <span class="brand-step-arrow-up">Select brand&nbsp;<i class="fas fas fa-chevron-up"></i></span>
								</button>
							  </h5>
							</div>
							<div id="collapseBrand" class="collapse " aria-labelledby="headingBrand" data-parent="#accordion-apr">
							  <div class="card-body model-btn-group">
								<div id="brand_list" class="clearfix"></div>
							  </div>
							</div>
						</div>
						
						<?php /*?><div class="card" id="collapse_two_pos" style="display:none;">
							<div class="card-header" id="headingTwo">
							  <h5 class="mb-0">
								<button type="button" class="btn btn-link collapsed" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" data-toggle="">
								  Choose model&nbsp;<i class="fas fa-chevron-down first-step-arrow-down hide"></i><i class="fas fa-chevron-up first-step-arrow-up"></i>
								</button>
							  </h5>
							</div>
							<div id="collapseTwo" class="collapse " aria-labelledby="headingTwo" data-parent="#accordion-apr">
								<div class="card-body model-btn-group">
									<!--<legend>Device Model</legend>-->
									<div class="row">
										<div class="col-lg-12">
											<div id="model_list"></div>
										</div>
									</div>
								</div>
							</div>
						</div><?php */?>

						<div class="card" id="collapse_two_pos" style="display:none;">
							<div class="card-header" id="headingTwo">
							  <h5 class="mb-0">
								<button type="button" class="btn btn-link collapsed" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" data-toggle="">
									<span class="second-step-arrow-down hide">Select model&nbsp;<i class="fas fa-chevron-down"></i></span>
								  <span class="second-step-arrow-up">Select model&nbsp;<i class="fas fas fa-chevron-up"></i></span>
								</button>
							  </h5>
							</div>
							<div id="collapseTwo" class="collapse " aria-labelledby="headingTwo" data-parent="#accordion-apr">
							  <div class="card-body model-btn-group">
								<div id="model_list" class="clearfix"></div>
							  </div>
							</div>
						</div>
						
						<div class="card" id="collapse_modeldetails_pos" style="display:none;">
							<div class="card-header" id="headingModeldetails">
							  <h5 class="mb-0">
								<button type="button" class="btn btn-link collapsed" data-target="#collapseModeldetails" aria-expanded="false" aria-controls="collapseModeldetails" data-toggle="">
									<span class="modeldetails-step-arrow-down hide">Choose model configuration&nbsp;<i class="fas fa-chevron-down"></i></span>
								  <span class="modeldetails-step-arrow-up">Choose model configuration&nbsp;<i class="fas fas fa-chevron-up"></i></span>
								</button>
							  </h5>
							</div>
							<div id="collapseModeldetails" class="collapse " aria-labelledby="headingModeldetails" data-parent="#accordion-apr">
							  <div class="card-body model-btn-group">
								<div id="model_fields_list" class="row"></div>
							  </div>
							</div>
						</div>
						
						<div class="card" id="collapse_three_pos" style="display:none;">
							<div class="card-header" id="headingThree">
							  <h5 class="mb-0">
								<button type="button" class="btn btn-link collapsed" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree" data-toggle="">
									<span class="third-step-arrow-down hide">Personal information&nbsp;<i class="fas fa-chevron-down"></i></span>
								  <span class="third-step-arrow-up">Personal information&nbsp;<i class="fas fas fa-chevron-up"></i></span>
								</button>
							  </h5>
							</div>
							<div id="collapseThree" class="collapse accordion-form" aria-labelledby="headingThree" data-parent="#accordion-apr">
							  <div class="card-body personal-information">
								<div class="row">
								  <div class="col-md-6">
									<div class="form-group">
									  <input type="text" name="first_name" id="first_name" placeholder="First Name" class="form-control"/>
									  <div id="first_name_error_msg" class="invalid-feedback text-center m_validations_showhide" style="display:none;"></div>
									</div>
								  </div>
								  <div class="col-md-6">
									<div class="form-group">
									  <input type="text" name="last_name" id="last_name" placeholder="Last Name" class="form-control"/>
									  <div id="last_name_error_msg" class="invalid-feedback text-center m_validations_showhide" style="display:none;"></div>
									</div>
								  </div>
								</div>
								<div class="row">
								  <div class="col-md-6">
									<div class="form-group">
									  <input type="text" name="phone" id="phone" <?php /*?>placeholder="Phone Number"<?php */?> class="form-control"/>
									  <input type="hidden" name="phone_c_code" id="phone_c_code"/>
									  <div id="phone_error_msg" class="invalid-feedback text-center m_validations_showhide" style="display:none;"></div>
									</div>
								  </div>
								  <div class="col-md-6">
									<div class="form-group">
									  <input type="text" name="email" id="email" placeholder="Email Address" class="form-control"/>
									  <div id="email_error_msg" class="invalid-feedback text-center m_validations_showhide" style="display:none;"></div>
									</div>
								  </div>
								</div>
								<div class="row">
								  <div class="col-md-12 text-right">
									<button type="button" class="btn btn-primary step3next">Continue</button>
								  </div>
								</div>
							  </div>
							</div>
						</div>
						
						<div class="card" id="collapse_four_pos" style="display:none;">
							<div class="card-header" id="headingFour">
							  <h5 class="mb-0">
								<button type="button" class="btn btn-link collapsed" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour" data-toggle="">
									<span class="fourth-step-arrow-down hide">Method of payment&nbsp;<i class="fas fa-chevron-down"></i></span>
								  <span class="fourth-step-arrow-up">Method of payment&nbsp;<i class="fas fas fa-chevron-up"></i></span>
								</button>
							  </h5>
							</div>
							<div id="collapseFour" class="collapse payment_bank_selection" aria-labelledby="headingFour" data-parent="#accordion-apr">
							  <div class="card-body">
								<div class="clearfix">
								  <?php
								  if($choosed_payment_option['bank']=="bank") { ?>
								  <div class="float-left payment-select">
									<div class="custom-control custom-radio">
									  <input type="radio" id="payment_method_bank" name="payment_method" value="bank" class="custom-control-input" <?php if($default_payment_option=="bank"){echo 'checked="checked"';}?>>
									  <label class="custom-control-label" for="payment_method_bank"><?=$payment_method_bank_heading_text?></label>
									</div>
								  </div>
								  <?php
								  }
								  if($choosed_payment_option['paypal']=="paypal") { ?>
								  <div class="float-left payment-select">
									<div class="custom-control custom-radio">
									  <input type="radio" id="payment_method_paypal" value="paypal" name="payment_method" class="custom-control-input" <?php if($default_payment_option=="paypal"){echo 'checked="checked"';}?>>
									  <label class="custom-control-label" for="payment_method_paypal"><?=$payment_method_paypal_heading_text?></label>
									</div>
								  </div>
								  <?php
								  }
								  if($choosed_payment_option['cheque']=="cheque") { ?>
								  <div class="float-left payment-select">
									<div class="custom-control custom-radio">
									  <input type="radio" id="payment_method_cheque" value="cheque" name="payment_method" class="custom-control-input" <?php if($default_payment_option=="cheque"){echo 'checked="checked"';}?>>
									  <label class="custom-control-label" for="payment_method_cheque"><?=$cheque_check_label?></label>
									</div>
								  </div>
								  <?php
								  }
								  if($choosed_payment_option['zelle']=="zelle") { ?>
								  <div class="float-left payment-select">
									<div class="custom-control custom-radio">
									  <input type="radio" id="payment_method_zelle" value="zelle" name="payment_method" class="custom-control-input" <?php if($default_payment_option=="zelle"){echo 'checked="checked"';}?>>
									  <label class="custom-control-label" for="payment_method_zelle"><?=$payment_method_zelle_heading_text?></label>
									</div>
								  </div>
								  <?php
								  }
								  if($choosed_payment_option['cash']=="cash") { ?>
								  <div class="float-left payment-select">
									<div class="custom-control custom-radio">
									  <input type="radio" id="payment_method_cash" value="cash" name="payment_method" class="custom-control-input" <?php if($default_payment_option=="cash"){echo 'checked="checked"';}?>>
									  <label class="custom-control-label" for="payment_method_cash"><?=$payment_method_cash_heading_text?></label>
									</div>
								  </div>
								  <?php
								  }
								  if($choosed_payment_option['venmo']=="venmo") { ?>
								  <div class="float-left  payment-select">
									<div class="custom-control custom-radio">
									  <input type="radio" id="payment_method_venmo" value="venmo" name="payment_method" class="custom-control-input" <?php if($default_payment_option=="venmo"){echo 'checked="checked"';}?>>
									  <label class="custom-control-label" for="payment_method_venmo"><?=$payment_method_venmo_heading_text?></label>
									</div>
								  </div>
								  <?php
								  }
								  if($choosed_payment_option['amazon_gcard']=="amazon_gcard") { ?>
								  <div class="float-left payment-select">
									<div class="custom-control custom-radio">
									  <input type="radio" id="payment_method_amazon_gcard" value="amazon_gcard" name="payment_method" class="custom-control-input" <?php if($default_payment_option=="amazon_gcard"){echo 'checked="checked"';}?>>
									  <label class="custom-control-label" for="payment_method_amazon_gcard"><?=$payment_method_amazon_gcard_heading_text?></label>
									</div>
								  </div>
								  <?php
								  }
								  if($choosed_payment_option['cash_app']=="cash_app") { ?>
								  <div class="float-left payment-select">
									<div class="custom-control custom-radio">
									  <input type="radio" id="payment_method_cash_app" value="cash_app" name="payment_method" class="custom-control-input" <?php if($default_payment_option=="cash_app"){echo 'checked="checked"';}?>>
									  <label class="custom-control-label" for="payment_method_cash_app"><?=$payment_method_cash_app_heading_text?></label>
									</div>
								  </div>
								  <?php
								  }
								  if($choosed_payment_option['apple_pay']=="apple_pay") { ?>
								  <div class="float-left payment-select">
									<div class="custom-control custom-radio">
									  <input type="radio" id="payment_method_apple_pay" value="apple_pay" name="payment_method" class="custom-control-input" <?php if($default_payment_option=="apple_pay"){echo 'checked="checked"';}?>>
									  <label class="custom-control-label" for="payment_method_apple_pay"><?=$payment_method_apple_pay_heading_text?></label>
									</div>
								  </div>
								  <?php
								  }
								  if($choosed_payment_option['google_pay']=="google_pay") { ?>
								  <div class="float-left payment-select">
									<div class="custom-control custom-radio">
									  <input type="radio" id="payment_method_google_pay" value="google_pay" name="payment_method" class="custom-control-input" <?php if($default_payment_option=="google_pay"){echo 'checked="checked"';}?>>
									  <label class="custom-control-label" for="payment_method_google_pay"><?=$payment_method_google_pay_heading_text?></label>
									</div>
								  </div>
								  <?php
								  }
								  if($choosed_payment_option['coinbase']=="coinbase") { ?>
								  <div class="float-left payment-select">
									<div class="custom-control custom-radio">
									  <input type="radio" id="payment_method_coinbase" value="coinbase" name="payment_method" class="custom-control-input" <?php if($default_payment_option=="coinbase"){echo 'checked="checked"';}?>>
									  <label class="custom-control-label" for="payment_method_coinbase"><?=$payment_method_coinbase_heading_text?></label>
									</div>
								  </div>
								  <?php
								  }
								  if($choosed_payment_option['facebook_pay']=="facebook_pay") { ?>
								  <div class="float-left payment-select">
									<div class="custom-control custom-radio">
									  <input type="radio" id="payment_method_facebook_pay" value="facebook_pay" name="payment_method" class="custom-control-input" <?php if($default_payment_option=="facebook_pay"){echo 'checked="checked"';}?>>
									  <label class="custom-control-label" for="payment_method_facebook_pay"><?=$payment_method_facebook_pay_heading_text?></label>
									</div>
								  </div>
								  <?php
								  } ?>
								</div>

								<?php
								if($choosed_payment_option['bank']=="bank") { ?>
								<div class="bank-fields <?php if($default_payment_option!="bank"){echo 'd-none';}?>" id="bank">
									<p><?=$payment_instruction['bank']?></p>
									<div class="row pt-3">
										<div class="col-md-4">
											<div class="form-group">
												<input type="text" class="form-control" id="act_name" name="act_name" placeholder="<?=$cart_payment_method_act_name_place_holder_text?>" autocomplete="nope">
												<div id="act_name_error_msg" class="invalid-feedback text-center m_validations_showhide" style="display:none;"></div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<input type="text" class="form-control" id="act_number" name="act_number" placeholder="<?=$cart_payment_method_act_number_place_holder_text?>" autocomplete="nope">
												<div id="act_number_error_msg" class="invalid-feedback text-center m_validations_showhide" style="display:none;"></div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<input type="text" class="form-control" id="act_short_code" name="act_short_code" placeholder="<?=$cart_payment_method_act_short_code_place_holder_text?>" autocomplete="nope">
												<div id="act_short_code_error_msg" class="invalid-feedback text-center m_validations_showhide" style="display:none;"></div>
											</div>
										</div>
									</div>
								</div>
								<?php
								}
								if($choosed_payment_option['paypal']=="paypal") { ?>
								<div class="paypal-fields <?php if($default_payment_option!="paypal"){echo 'd-none';}?>" id="paypal">
									<p><?=$payment_instruction['paypal']?></p>
									<div class="row pt-3">
										<div class="col-md-6">
											<div class="form-group">
												<input type="text" class="form-control" id="paypal_address" name="paypal_address" autocomplete="nope" placeholder="<?=$cart_payment_method_paypal_adr_place_holder_text?>">
												<div id="paypal_address_error_msg" class="invalid-feedback text-center m_validations_showhide" style="display:none;"></div>
												<div id="exist_paypal_address_msg" class="invalid-feedback text-center" style="display:none;"></div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<input type="text" class="form-control" id="confirm_paypal_address" name="confirm_paypal_address" autocomplete="nope" placeholder="<?=$cart_payment_method_paypal_adr_repeat_place_holder_text?>">
												<div id="confirm_paypal_address_error_msg" class="invalid-feedback text-center m_validations_showhide" style="display:none;"></div>
											</div>
										</div>
									</div>
								</div>
								<?php
								}
								if($choosed_payment_option['cheque']=="cheque") { ?>
								<div class="tab-pane fade <?php if($default_payment_option!="cheque"){echo 'd-none';}?>" id="cheque">
									<p><?=$payment_instruction['cheque']?></p>
								</div>
								<?php
								}
								
								if($choosed_payment_option['venmo']=="venmo") { ?>
								<div class="venmo-fields <?php if($default_payment_option!="venmo"){echo 'd-none';}?>" id="venmo">
									<p><?=$payment_instruction['venmo']?></p>
									<div class="form-group">
										<input type="text" class="form-control" placeholder="<?=$cart_payment_method_venmo_adr_place_holder_text?>" id="venmo_address"  name="venmo_address" autocomplete="nope">
										<div id="venmo_address_error_msg" class="invalid-feedback text-center m_validations_showhide" style="display:none;"></div>
									</div>
								</div>
								<?php
								}
								if($choosed_payment_option['amazon_gcard']=="amazon_gcard") { ?>
								<div class="amazon_gcard-fields <?php if($default_payment_option!="amazon_gcard"){echo 'd-none';}?>" id="amazon_gcard">
									<p><?=$payment_instruction['amazon_gcard']?></p>
									<div class="form-group">
										<input type="text" class="form-control" placeholder="<?=$cart_payment_method_amazon_gcard_adr_place_holder_text?>" id="amazon_gcard_address" name="amazon_gcard_address" autocomplete="nope">
										<div id="amazon_gcard_address_error_msg" class="invalid-feedback text-center m_validations_showhide" style="display:none;"></div>
									</div>
								</div>
								<?php
								}
								if($choosed_payment_option['cash']=="cash") { ?>
								<div class="cash-fields <?php if($default_payment_option!="cash"){echo 'd-none';}?>" id="cash">
									<p><?=$payment_instruction['cash']?></p>
									<div class="row pt-1">
										<div class="col-md-6">
											<div class="form-group">
												<input type="text" class="form-control" id="cash_name" name="cash_name" placeholder="<?=$cart_payment_method_cash_name_place_holder_text?>">
												<div id="cash_name_error_msg" class="invalid-feedback text-center m_validations_showhide" style="display:none;"></div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<input type="tel" class="form-control" id="cash_phone" name="cash_phone" <?php /*?>placeholder="<?=$cart_payment_method_cash_phone_place_holder_text?>"<?php */?>>
												<input type="hidden" name="f_cash_phone" id="f_cash_phone" />
												<div id="cash_phone_error_msg" class="invalid-feedback text-center m_validations_showhide" style="display:none;"></div>
											</div>
										</div>
									</div>
								</div>
								<?php
								}
								if($choosed_payment_option['zelle']=="zelle") { ?>
								<div class="zelle-fields <?php if($default_payment_option!="zelle"){echo 'd-none';}?>" id="zelle">
									<p><?=$payment_instruction['zelle']?></p>
									<div class="form-group">
										<input type="email" class="form-control" id="zelle_address" name="zelle_address" placeholder="<?=$cart_payment_method_zelle_adr_place_holder_text?>">
										<div id="zelle_address_error_msg" class="invalid-feedback text-center m_validations_showhide" style="display:none;"></div>
									</div>
								</div>
								<?php
								}
								
								if($choosed_payment_option['cash_app']=="cash_app") { ?>
								<div class="cash_app-fields <?php if($default_payment_option!="cash_app"){echo 'd-none';}?>" id="cash_app">
									<p><?=$payment_instruction['cash_app']?></p>
									<div class="form-group">
										<input type="text" class="form-control" placeholder="<?=$cart_payment_method_cash_app_adr_place_holder_text?>" id="cash_app_address" name="cash_app_address" autocomplete="nope">
										<div id="cash_app_address_error_msg" class="invalid-feedback text-center m_validations_showhide" style="display:none;"></div>
									</div>
								</div>
								<?php
								}
								if($choosed_payment_option['apple_pay']=="apple_pay") { ?>
								<div class="apple_pay-fields <?php if($default_payment_option!="apple_pay"){echo 'd-none';}?>" id="apple_pay">
									<p><?=$payment_instruction['apple_pay']?></p>
									<div class="form-group">
										<input type="text" class="form-control" placeholder="<?=$cart_payment_method_apple_pay_adr_place_holder_text?>" id="apple_pay_address" name="apple_pay_address" autocomplete="nope">
										<div id="apple_pay_address_error_msg" class="invalid-feedback text-center m_validations_showhide" style="display:none;"></div>
									</div>
								</div>
								<?php
								}
								if($choosed_payment_option['google_pay']=="google_pay") { ?>
								<div class="google_pay-fields <?php if($default_payment_option!="google_pay"){echo 'd-none';}?>" id="google_pay">
									<p><?=$payment_instruction['google_pay']?></p>
									<div class="form-group">
										<input type="text" class="form-control" placeholder="<?=$cart_payment_method_google_pay_adr_place_holder_text?>" id="google_pay_address" name="google_pay_address" autocomplete="nope">
										<div id="google_pay_address_error_msg" class="invalid-feedback text-center m_validations_showhide" style="display:none;"></div>
									</div>
								</div>
								<?php
								}
								if($choosed_payment_option['coinbase']=="coinbase") { ?>
								<div class="coinbase-fields <?php if($default_payment_option!="coinbase"){echo 'd-none';}?>" id="coinbase">
									<p><?=$payment_instruction['coinbase']?></p>
									<div class="form-group">
										<input type="text" class="form-control" placeholder="<?=$cart_payment_method_coinbase_adr_place_holder_text?>" id="coinbase_address" name="coinbase_address" autocomplete="nope">
										<div id="coinbase_address_error_msg" class="invalid-feedback text-center m_validations_showhide" style="display:none;"></div>
									</div>
								</div>
								<?php
								}
								if($choosed_payment_option['facebook_pay']=="facebook_pay") { ?>
								<div class="facebook_pay-fields <?php if($default_payment_option!="facebook_pay"){echo 'd-none';}?>" id="facebook_pay">
									<p><?=$payment_instruction['facebook_pay']?></p>
									<div class="form-group">
										<input type="text" class="form-control" placeholder="<?=$cart_payment_method_facebook_pay_adr_place_holder_text?>" id="facebook_pay_address" name="facebook_pay_address" autocomplete="nope">
										<div id="facebook_pay_address_error_msg" class="invalid-feedback text-center m_validations_showhide" style="display:none;"></div>
									</div>
								</div>
								<?php
								} ?>
							
								<div class="row">
								  <div class="col-md-12 text-right">
									<button type="button" class="btn btn-primary step4next">Continue</button>
								  </div>
								</div>
							  </div>
							</div>
						</div>
						
						<div class="card" id="collapse_five_pos" style="display:none;">
							<div class="card-header" id="headingFive">
							  <h5 class="mb-0">
								<button type="button" class="btn btn-link collapsed" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive" data-toggle="">
									<span class="fifth-step-arrow-down hide">Shipping information&nbsp;<i class="fas fa-chevron-down"></i></span>
								  <span class="fifth-step-arrow-up">Shipping information&nbsp;<i class="fas fas fa-chevron-up"></i></span>
								</button>
							  </h5>
							</div>
							<div id="collapseFive" class="collapse shpipping-info" aria-labelledby="headingFive" data-parent="#accordion-apr">
							  <div class="card-body">
								<div class="row">
								  <div class="col-md-4">
									<div class="form-group">
									  <input type="text" name="billing_first_name" id="billing_first_name" placeholder="First Name" class="form-control"/>
									  <div id="billing_first_name_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
									</div>
								  </div>
								  <div class="col-md-4">
									<div class="form-group">
									  <input type="text" name="billing_last_name" id="billing_last_name" placeholder="Last Name" class="form-control"/>
									  <div id="billing_last_name_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
									</div>
								  </div>
								  <div class="col-md-4">
									<div class="form-group">
									  <input type="text" name="billing_company_name" id="billing_company_name" placeholder="Company Name" class="form-control"/>
									</div>
								  </div>
								</div>
								<div class="row">
								  <div class="col-md-6">
									<div class="form-group">
									  <textarea name="billing_address" id="billing_address" placeholder="Street address" class="form-control" rows="3"></textarea>
									  <div id="billing_address_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
									</div>
								  </div>
								  <div class="col-md-6">
									<div class="form-group">
									  <textarea name="billing_address2" id="billing_address2" placeholder="Street address 2 (optional)" class="form-control" rows="3"></textarea>
									</div>
								  </div>
								</div>
								<div class="row">
								  <div class="col-md-3">
									<div class="form-group">
									  <input type="text" name="billing_city" id="billing_city" placeholder="City" class="form-control"/>
									  <div id="billing_city_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
									</div>
								  </div>
								  <div class="col-md-3">
									<div class="form-group">
									  <input type="text" name="billing_state" id="billing_state" placeholder="State" class="form-control"/>
									  <div id="billing_state_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
									</div>
								  </div>
								  <div class="col-md-3">
									<div class="form-group">
									  <input type="text" name="billing_postcode" id="billing_postcode" placeholder="Post Code" class="form-control"/>
									  <div id="billing_postcode_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
									</div>
								  </div>
								  <div class="col-md-3">
									<div class="form-group">
									  <input type="text" name="billing_phone" id="billing_phone" <?php /*?>placeholder="Phone Number"<?php */?> class="form-control"/>
									  <input type="hidden" name="billing_phone_c_code" id="billing_phone_c_code"/>
									  <div id="billing_phone_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
									  
									</div>
								  </div>
								</div>

								<?php
								if(!empty(array_filter($shipping_option))) { ?>
								<div class="row">
								  <div class="col-md-12">
									<div class="form-group">
										<label><strong><?=$cart_select_shipping_method_title?></strong></label>
											<div class="amount-radio clearfix">
												<?php
												foreach($shipping_option_ordr_arr as $sooa_k=>$sooa_v) {
													if($shipping_option['post_me_a_prepaid_label'] == $sooa_v) { ?>
													<div class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" id="sm_post_me_a_prepaid_label" name="shipping_method" value="post_me_a_prepaid_label">
														<label for="sm_post_me_a_prepaid_label" class="custom-control-label"><?=$cart_shipping_method_post_me_a_prepaid_label_title?></label>
														<?php
														/*if($shipping_option[$sooa_v.'_image']!="") {
															echo '<img src="'.SITE_URL.'/images/'.$shipping_option[$sooa_v.'_image'].'" width="30">';
														}*/ ?>
													</div>
													<?php
													}
													if($shipping_option['print_a_prepaid_label'] == $sooa_v) { ?>
													<div class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" id="sm_print_a_prepaid_label" name="shipping_method" value="print_a_prepaid_label">
														<label for="sm_print_a_prepaid_label" class="custom-control-label"><?=$cart_shipping_method_print_a_prepaid_label_title?></label>
														<?php
														/*if($shipping_option[$sooa_v.'_image']!="") {
															echo '<img src="'.SITE_URL.'/images/'.$shipping_option[$sooa_v.'_image'].'" width="30">';
														}*/ ?>
													</div>
													<?php
													}
													if($shipping_option['use_my_own_courier'] == $sooa_v) { ?>
													<div class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" id="sm_use_my_own_courier" name="shipping_method" value="use_my_own_courier">
														<label for="sm_use_my_own_courier" class="custom-control-label"><?=$cart_shipping_method_use_my_own_courier_title?></label>
														<?php
														/*if($shipping_option[$sooa_v.'_image']!="") {
															echo '<img src="'.SITE_URL.'/images/'.$shipping_option[$sooa_v.'_image'].'" width="30">';
														}*/ ?>
													</div>
													<?php
													}
													if($shipping_option['we_come_for_you'] == $sooa_v) { ?>
													<div class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" id="sm_we_come_for_you" name="shipping_method" value="we_come_for_you">
														<label for="sm_we_come_for_you" class="custom-control-label"><?=$cart_shipping_method_we_come_for_you_title?></label>
														<?php
														/*if($shipping_option[$sooa_v.'_image']!="") {
															echo '<img src="'.SITE_URL.'/images/'.$shipping_option[$sooa_v.'_image'].'" width="30">';
														}*/ ?>
													</div>
													<?php
													}
								
													$store_location_list = get_store_location_list('','store');
													if($shipping_option['store'] == $sooa_v && !empty($store_location_list)) { ?>
													<div class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" id="sm_store" name="shipping_method" value="store">
														<label for="sm_store" class="custom-control-label"><?=$cart_shipping_method_store_title?></label>
														<?php
														/*if($shipping_option[$sooa_v.'_image']!="") {
															echo '<img src="'.SITE_URL.'/images/'.$shipping_option[$sooa_v.'_image'].'" width="30">';
														}*/ ?>
													</div>
													<?php
													}
								
													$starbucks_location_list = get_store_location_list('','starbucks');
													if($shipping_option['starbucks'] == $sooa_v && !empty($starbucks_location_list)) { ?>
													<div class="custom-control custom-radio">
														<input type="radio" class="custom-control-input" id="sm_starbucks" name="shipping_method" value="starbucks">
														<label for="sm_starbucks" class="custom-control-label"><?=$cart_shipping_method_starbucks_title?></label>
														<?php
														/*if($shipping_option[$sooa_v.'_image']!="") {
															echo '<img src="'.SITE_URL.'/images/'.$shipping_option[$sooa_v.'_image'].'" width="30">';
														}*/ ?>
													</div>
													<?php
													}
												} ?>
											</div>
											<div id="shipping_method_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
										</div>
									</div>
								</div>
								<?php
								} else { ?>
								<div class="custom-control custom-radio" style="display:none;">
									<input type="radio" id="sm_post_me_a_prepaid_label" name="shipping_method" value="none" checked="checked">
									<label><span>None</span></label>
									<div id="shipping_method_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
								</div>
								<?php
								} ?>
								
								<div class="shipping_method_locations"></div>
								<div class="shipping_method_dates">
									<div class="form-row">
										<div class="form-group col-md-12">
											<input type="text" name="date" placeholder="Date..." class="form-control repair_appt_date" id="date" autocomplete="off">
											<small id="date_error_msg" class="help-block m_validations_showhide" style="display:none;"></small>
										</div>
									</div>
								</div>
								<div class="form-row shipping_method_times"></div>
								
								<div class="row">
								  <div class="col-md-12">
									<div class="checkbox">
										<input type="checkbox" class="checkboxele" name="chk_newsletter_promotions" id="chk_newsletter_promotions" value="1"/>
										<label for="chk_newsletter_promotions">
											<span class="checkmark"></span> I would like to receive the <?=$company_name?> newsletter and promotions
										</label>
									</div>
									
									<div class="checkbox">
										<label for="terms_and_conditions">
											<input type="checkbox" class="checkboxele" name="terms_and_conditions" id="terms_and_conditions" value="1">
											<span class="checkmark"></span> By continuing you accept the General <a href="javascript:void(0)" data-toggle="modal" data-target="#terms_of_website_use">Terms and Conditions</a> of <?=$company_name?> and you further agree to the processing of your personal data that are necessary to perform the assignment.
										</label>
									</div>
								  </div>
								</div>
								
								<div class="row">
								  <div class="col-md-12 text-right">
								  	<button type="button" class="btn btn-primary sell-btn sell-button step5next">Sell for <span class="show_final_amt"></span> <img src="https://img.icons8.com/ios/50/000000/hand-peace.png"></button>
								  </div>
								</div>
								
							  </div>
							</div>
						</div>  
					</div>
					<input type="hidden" name="csrf_token" value="<?=$csrf_token?>">
					</form>
				</div>
				</div>
			</section>
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
			  <?php
			  $terms_pg_data = get_inbuild_page_data('terms-and-conditions');
			  echo $terms_pg_data['data']['content']; ?>
			</div>
		  </div>
		</div>
	</div>
									
	<script>
	var tpj=jQuery;
	(function( tpj ) {
		tpj(function() {
			
			var telInput = tpj("#phone");
			telInput.intlTelInput({
			  initialCountry: "<?=$phone_country_short_code?>",
		 	  allowDropdown: false,
			  geoIpLookup: function(callback) {
				tpj.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
				  var countryCode = (resp && resp.country) ? resp.country : "";
				  callback(countryCode);
				});
			  },
			  utilsScript: "<?=SITE_URL?>js/intlTelInput-utils.js"
			});
	
			var telInput2 = tpj("#billing_phone");
			telInput2.intlTelInput({
			  initialCountry: "<?=$phone_country_short_code?>",
		 	  allowDropdown: false,
			  geoIpLookup: function(callback) {
				tpj.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
				  var countryCode = (resp && resp.country) ? resp.country : "";
				  callback(countryCode);
				});
			  },
			  utilsScript: "<?=SITE_URL?>js/intlTelInput-utils.js"
			});
			
			var telInput3 = tpj("#cash_phone");
			telInput3.intlTelInput({
			  initialCountry: "<?=$phone_country_short_code?>",
		 	  allowDropdown: false,
			  geoIpLookup: function(callback) {
				tpj.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
				  var countryCode = (resp && resp.country) ? resp.country : "";
				  callback(countryCode);
				});
			  },
			  utilsScript: "<?=SITE_URL?>js/intlTelInput-utils.js"
			});
			
			/*tpj("#skip_imei_step").on("click", function() {
				tpj("#collapseOne").collapse('show');
				setTimeout(function() {
					tpj.scrollTo($('#collapse_one_pos'), 500);
				}, 500);
			});*/

			//START for up down arrow
			tpj(".cat-step-arrow-down").click(function(e) {
				tpj(this).hide();
				tpj(".cat-step-arrow-up").show();
				
				tpj("#collapseCat").collapse('show');
				tpj("#collapseCat").addClass('show');
				
				$(".srch_list_of_model").val('');
				/*$("#collapse_brand_pos").hide();
				$("#collapse_two_pos").hide();
				$("#collapse_modeldetails_pos").hide();
				$("#collapse_three_pos").hide();
				$("#collapse_four_pos").hide();
				$("#collapse_five_pos").hide();*/
			});
			tpj(".cat-step-arrow-up").click(function(e) {
				tpj(this).hide();
				tpj(".cat-step-arrow-down").show();
				
				tpj("#collapseCat").collapse('hide');
				tpj("#collapseCat").removeClass('show');
			});
			
			tpj(".brand-step-arrow-down").click(function(e) {
				tpj(this).hide();
				tpj(".brand-step-arrow-up").show();
				
				tpj("#collapseBrand").collapse('show');
				tpj("#collapseBrand").addClass('show');
			});
			tpj(".brand-step-arrow-up").click(function(e) {
				tpj(this).hide();
				tpj(".brand-step-arrow-down").show();
				
				tpj("#collapseBrand").collapse('hide');
				tpj("#collapseBrand").removeClass('show');
			});
	
			tpj(".modeldetails-step-arrow-down").click(function(e) {
				tpj(this).hide();
				tpj(".modeldetails-step-arrow-up").show();
	
				tpj("#collapseModeldetails").collapse('show');
				tpj("#collapseModeldetails").addClass('show');
			});
			tpj(".modeldetails-step-arrow-up").click(function(e) {
				tpj(this).hide();
				tpj(".modeldetails-step-arrow-down").show();
	
				tpj("#collapseModeldetails").collapse('hide');
				tpj("#collapseModeldetails").removeClass('show');
			});
	
			tpj(".first-step-arrow-down").click(function(e) {
				tpj(this).hide();
				tpj(".first-step-arrow-up").show();
				
				tpj("#collapseOne").collapse('show');
				tpj("#collapseOne").addClass('show');
			});
			tpj(".first-step-arrow-up").click(function(e) {
				tpj(this).hide();
				tpj(".first-step-arrow-down").show();
				
				tpj("#collapseOne").collapse('hide');
				tpj("#collapseOne").removeClass('show');
			});
	
			tpj(".second-step-arrow-down").click(function(e) {
				tpj(this).hide();
				tpj(".second-step-arrow-up").show();
				
				tpj("#collapseTwo").collapse('show');
				tpj("#collapseTwo").addClass('show');
			});
			tpj(".second-step-arrow-up").click(function(e) {
				tpj(this).hide();
				tpj(".second-step-arrow-down").show();
				
				tpj("#collapseTwo").collapse('hide');
				tpj("#collapseTwo").removeClass('show');
			});
			
			tpj(".third-step-arrow-down").click(function(e) {
				tpj(this).hide();
				tpj(".third-step-arrow-up").show();
				
				tpj("#collapseThree").collapse('show');
				tpj("#collapseThree").addClass('show');
			});
			tpj(".third-step-arrow-up").click(function(e) {
				tpj(this).hide();
				tpj(".third-step-arrow-down").show();
				
				tpj("#collapseThree").collapse('hide');
				tpj("#collapseThree").removeClass('show');
			});
			
			tpj(".fourth-step-arrow-down").click(function(e) {
				tpj(this).hide();
				tpj(".fourth-step-arrow-up").show();
				
				tpj("#collapseFour").collapse('show');
				tpj("#collapseFour").addClass('show');
			});
			tpj(".fourth-step-arrow-up").click(function(e) {
				tpj(this).hide();
				tpj(".fourth-step-arrow-down").show();
				
				tpj("#collapseFour").collapse('hide');
				tpj("#collapseFour").removeClass('show');
			});
			
			tpj(".fifth-step-arrow-down").click(function(e) {
				tpj(this).hide();
				tpj(".fifth-step-arrow-up").show();
				
				tpj("#collapseFive").collapse('show');
				tpj("#collapseFive").addClass('show');
			});
			tpj(".fifth-step-arrow-up").click(function(e) {
				tpj(this).hide();
				tpj(".fifth-step-arrow-down").show();
				
				tpj("#collapseFive").collapse('hide');
				tpj("#collapseFive").removeClass('show');
			});
			
			tpj(".six-step-arrow-down").click(function(e) {
				tpj(this).hide();
				tpj(".six-step-arrow-up").show();
				
				tpj("#collapseSix").collapse('show');
				tpj("#collapseSix").addClass('show');
			});
			tpj(".six-step-arrow-up").click(function(e) {
				tpj(this).hide();
				tpj(".six-step-arrow-down").show();
				
				tpj("#collapseSix").collapse('hide');
				tpj("#collapseSix").removeClass('show');
			}); //END for up down arrow

			tpj(document).on('click', '#quantity-section', function() {
				checkdata();
				tpj("#collapse_three_pos").show();
				tpj("#collapseThree").collapse('show');
				tpj("#collapseThree").addClass('show');
				
				tpj(".modeldetails-step-arrow-up").hide();
				tpj(".modeldetails-step-arrow-down").show();

				/*tpj("#collapseSix").collapse('hide');
				tpj("#collapseSix").removeClass('show');
				tpj(".six-step-arrow-up").hide();
				tpj(".six-step-arrow-down").show();*/

				setTimeout(function() {
					tpj.scrollTo(tpj('#collapse_three_pos'), 500);
				}, 500);
			});

			$(".step3next").on("click", function() {
				var ok = check_step3_validations();
				if(ok == false) {
					return false;
				}
				$("#collapseFour").collapse('show');
				$("#collapse_four_pos").show();
				
				$(".third-step-arrow-up").hide();
				$(".third-step-arrow-down").show();
				
				setTimeout(function() {
					$.scrollTo($('#collapse_four_pos'), 500);
				}, 500);
			});
	
			$(".step4next").on("click", function() {
				var ok = check_step4_validations();
				if(ok == false) {
					return false;
				}
				$("#collapseFive").collapse('show');
				$("#collapse_five_pos").show();
				$(".fourth-step-arrow-up").hide();
				$(".fourth-step-arrow-down").show();
				
				setTimeout(function() {
					$.scrollTo($('#collapse_five_pos'), 500);
				}, 500);
			});

			$("input[type='radio']").click(function () {
				var payment_method_val = $("input[name='payment_method']:checked").val();
				if(payment_method_val) {
					<?php
					$payment_methods_nm_arr = array('cash','paypal','bank','cheque','venmo','zelle','amazon_gcard','cash_app','apple_pay','google_pay','coinbase','facebook_pay');
					foreach($payment_methods_nm_arr as $payment_methods_nm_k=>$payment_methods_nm_v) { ?>
						if(payment_method_val == '<?=$payment_methods_nm_v?>') {
							<?php
							foreach($payment_methods_nm_arr as $payment_methods_s_nm_k=>$payment_methods_s_nm_v) { ?>
								$('.<?=$payment_methods_s_nm_v?>-fields').addClass('d-none');
							<?php
							} ?>
							$('.<?=$payment_methods_nm_v?>-fields').removeClass('d-none');
						}
					<?php
					} ?>
				}
			});
			
			$(".step5next").on("click", function() {
				var ok = check_step3_validations();
				if(ok == false) {
					return false;
				}
	
				var ok2 = check_step4_validations();
				if(ok2 == false) {
					return false;
				}
				
				var ok3 = check_shipping_form();
				if(ok3 == false) {
					return false;
				}
		
				if($("#terms_and_conditions").prop("checked") == false) {
					alert("You must agree to terms & conditions.");
					return false;
				}
	
				$("#apr_form").submit();
				return true;
			});
			
			/*tpj("#get_imei_info").click(function(e) {
				var imei_number = tpj("#imei_number").val().trim();
				if(imei_number == "") {
					tpj("#imei_number").focus();
					return false;
				}
				post_data = "imei_number="+imei_number+"&mode=imei&token=<?=get_unique_id_on_load()?>";
				tpj(document).ready(function(tpj){
					tpj.ajax({
						type: "POST",
						url:"<?=SITE_URL?>ajax/affiliate/get_model_list.php",
						data:post_data,
						success:function(data) {
							if(data!="") {
								tpj("#model_list").html(data);
								tpj("#model_fields_list").html("");
								tpj("#collapseTwo").collapse('show');
								tpj("#collapseTwo").addClass('show');
								tpj("#collapse_two_pos").show();
								
								tpj("#collapseOne").collapse('hide');
								tpj("#collapseOne").removeClass('show');
								tpj(".first-step-arrow-up").hide();
								tpj(".first-step-arrow-down").show();
								
								setTimeout(function() {
									tpj.scrollTo(tpj('#collapse_two_pos'), 500);
								}, 500);
							} else {
								tpj("#model_list").html("");
								tpj("#model_fields_list").html("");
							}
						}
					});
				});
			});*/

			$(".cat_id").click(function(e) {
				var cat_id = $(this).val();
				post_data = "cat_id="+cat_id+"&token=<?=get_unique_id_on_load()?>";
				$(document).ready(function($){
					$.ajax({
						type: "POST",
						url:"<?=SITE_URL?>ajax/affiliate/get_brand_list.php",
						data:post_data,
						success:function(data) {
							if(data!="") {
								$("#brand_list").html(data);
								//$("#model_fields_list").html("");
								$("#collapseBrand").collapse('show');
								$("#collapse_brand_pos").show();
								
								$(".cat-step-arrow-up").hide();
								$(".cat-step-arrow-down").show();
								
								$(".srch_list_of_model").val('');
								$("#collapse_modeldetails_pos").hide();
								
								setTimeout(function() {
									$.scrollTo($('#collapse_brand_pos'), 500);
								}, 500);
							} else {
								$("#brand_list").html("");
							}
						}
					});
				});
			});
	
			//$(".brand_id").click(function(e) {
			$(document).on('click', '.brand_id', function() {
				var brand_id = $(this).val();
				var cat_id = $("input[name='cat_id']:checked").val();
	
				post_data = "brand_id="+brand_id+"&cat_id="+cat_id+"&token=<?=get_unique_id_on_load()?>";
				$(document).ready(function($){
					$.ajax({
						type: "POST",
						url:"<?=SITE_URL?>ajax/affiliate/get_model_list.php",
						data:post_data,
						success:function(data) {
							if(data!="") {
								$("#model_list").html(data);
								$("#model_fields_list").html("");
								$("#collapseTwo").collapse('show');
								$("#collapse_two_pos").show();
								
								$(".brand-step-arrow-up").hide();
								$(".brand-step-arrow-down").show();
								
								setTimeout(function() {
									$.scrollTo($('#collapse_two_pos'), 500);
								}, 500);
							} else {
								$("#model_list").html("");
								$("#model_fields_list").html("");
							}
						}
					});
				});
			});
			
			/*tpj(".device_id").click(function(e) {
				var device_id = tpj(this).val();
				post_data = "device_id="+device_id+"&token=<?=get_unique_id_on_load()?>";
				tpj(document).ready(function(tpj){
					tpj.ajax({
						type: "POST",
						url:"<?=SITE_URL?>ajax/affiliate/get_model_list.php",
						data:post_data,
						success:function(data) {
							if(data!="") {
								tpj("#model_list").html(data);
								tpj("#model_fields_list").html("");
								tpj("#collapseTwo").collapse('show');
								tpj("#collapseTwo").addClass('show');
								tpj("#collapse_two_pos").show();
								
								tpj("#collapseOne").collapse('hide');
								tpj("#collapseOne").removeClass('show');
								tpj(".first-step-arrow-up").hide();
								tpj(".first-step-arrow-down").show();
								
								setTimeout(function() {
									tpj.scrollTo(tpj('#collapse_two_pos'), 500);
								}, 500);
							} else {
								tpj("#model_list").html("");
								tpj("#model_fields_list").html("");
							}
						}
					});
				});
			});*/
			
			//tpj(".model_id").click(function(e) {
			tpj(document).on('click', '.model_id', function() {
				var model_id = tpj(this).val();
				post_data = "model_id="+model_id+"&token=<?=get_unique_id_on_load()?>";
				tpj(document).ready(function(tpj){
					tpj.ajax({
						type: "POST",
						url:"<?=SITE_URL?>ajax/affiliate/get_model_fields_list.php",
						data:post_data,
						success:function(data) {
							if(data!="") {
								$("#model_fields_list").html(data);
								
								$("#collapseModeldetails").collapse('show');
								$("#collapseModeldetails").addClass('show');
								$("#collapse_modeldetails_pos").show();
	
								$("#collapseTwo").collapse('hide');
								$("#collapseTwo").removeClass('show');
								$(".second-step-arrow-up").hide();
								$(".second-step-arrow-down").show();
								
								setTimeout(function() {
									$.scrollTo($('#model_fields_list'), 500);
								}, 500);
							} else {
								tpj("#model_fields_list").html("");
							}
						}
					});
				});
			});
			
			function check_step3_validations() {
				jQuery(".m_validations_showhide").hide();
				
				var first_name = $("#first_name").val().trim();
				var last_name = $("#last_name").val().trim();
				var phone = $("#phone").val().trim();
				var email = $("#email").val().trim();
	
				var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
	
				if(first_name == "") {
					jQuery("#first_name_error_msg").show().text('Please enter first name');
					//alert("Please enter first name");
					return false;
				} else if(last_name == "") {
					jQuery("#last_name_error_msg").show().text('Please enter last name');
					//alert("Please enter last name");
					return false;
				} else if(phone == "") {
					jQuery("#phone_error_msg").show().text('Please enter phone number');
					//alert("Please enter phone number");
					return false;
				} 
				
				var telInput = $("#phone");
				$("#phone_c_code").val(telInput.intlTelInput("getSelectedCountryData").dialCode);
				if(!telInput.intlTelInput("isValidNumber")) {
					jQuery("#phone_error_msg").show().text('Please enter valid phone');
					//alert('Please enter valid phone');
					return false;
				}
				
				if(email == "") {
					jQuery("#email_error_msg").show().text('Please enter email address');
					//alert("Please enter email address");
					return false;
				} else if(email!="" && !email.match(mailformat)) {
					jQuery("#email_error_msg").show().text('You have entered an invalid email address!');
					//alert("You have entered an invalid email address!");
					return false;
				}
			}
	
			$(".bank-fields, .paypal-fields, .zelle-fields, .cash-fields, .venmo-fields, .amazon_gcard-fields, .cash_app-fields, .apple_pay-fields, .google_pay-fields, .coinbase-fields, .facebook_pay-fields").on('blur keyup change paste', 'input, select, textarea', function(event) {
				check_step4_validations();
			});
			
			$(".shpipping-info").on('blur keyup change paste', 'input, select, textarea', function(event) {
				check_shipping_form();
			});
			
			$(".personal-information").on('blur keyup change paste', 'input, select, textarea', function(event) {
				check_step3_validations();
			});
			
			$("input[name='shipping_method']").click(function() {
				//$(".shipping_address_fields").hide();
				$(".shipping_method_locations").hide();
				$(".shipping_method_dates").hide();
				$(".shipping_method_times").html('');
			
				var shipping_method = $("input[name='shipping_method']:checked").val();
				if(shipping_method == "post_me_a_prepaid_label") {
					//$(".shipping_address_fields").show();
				}
				if(shipping_method == "print_a_prepaid_label") {
					//$(".shipping_address_fields").show();
				}
				if(shipping_method == "we_come_for_you") {
					//$(".shipping_address_fields").show();
				}
			
				if(shipping_method == "store" || shipping_method == "starbucks") {
					$.ajax({
						type: 'POST',
						url: '<?=SITE_URL?>ajax/get_locations_html.php',
						data: {shipping_method:shipping_method},
						success: function(data) {
							if(data!="") {
								$(".shipping_method_locations").html(data);
								$(".shipping_method_locations").show();
								getLocationList(0);
							}
						}
					});
				}
			});
			//$(".shipping_address_fields").hide();
			$(".shipping_method_dates").hide();
			
		});
	})(jQuery);

	function checkform_sbt_dt() {
		jQuery("#payment_amt").val($(".show_final_amt_val").html());
		return true;
	}
	
	function getLocationList(id)
	{
		var location_id = id;
		if(location_id>0) {
			jQuery(".shipping_method_times").html('');
			jQuery(".location-adr-show-hide").hide();
			jQuery("#location-adr-"+id).show();
			jQuery(".shipping_method_dates").show();
			jQuery(".repair_appt_date").val('');
		} else {
			jQuery(".shipping_method_times").html('');
			jQuery(".location-adr-show-hide").hide();
			jQuery(".shipping_method_dates").hide();
			jQuery(".repair_appt_date").val('');
		}
	
		var show_appt_datetime_selection_in_place_order = jQuery('#location_id option:selected').data('show_appt_datetime_selection_in_place_order');
		if(show_appt_datetime_selection_in_place_order == 1) {
			jQuery(".shipping_method_dates").show();
			jQuery(".repair_appt_date").val('');
		} else {
			jQuery(".shipping_method_dates").hide();
			jQuery(".repair_appt_date").val('');
		}
	}
	
	function getTimeSlotListByDate()
	{
		var location_id = jQuery("#location_id").val();
		if(location_id>0) {
			jQuery(".time_slot_sec_showhide").show();
			var date = jQuery("#date").val();
			post_data = "location_id="+location_id+"&date="+date+"&option=1&token=<?=get_unique_id_on_load()?>";
			jQuery(document).ready(function($){
				jQuery.ajax({
					type: "POST",
					url:"<?=SITE_URL?>ajax/get_timeslot_list.php",
					data:post_data,
					success:function(data) {
						if(data!="") {
							var resp_data = JSON.parse(data);
							if(resp_data.html!="") {
								jQuery(".shipping_method_times").html(resp_data.html);
								
								jQuery('.repair_time_slot').on('change', function(e) {
									check_booking_available();
								});
							}
						} else {
							alert('Something went wrong!!');
							return false;
						}
					}
				});
			});
		}
	}
	
	function check_booking_available() {
		var location_id = jQuery("#location_id").val();
		var date = jQuery("#date").val();
		var time = jQuery(".repair_time_slot").val();
		if(time) {
			var shipping_method = jQuery("input[name='shipping_method']:checked").val();
			
			post_data = "date="+date+"&time="+time+"&location_id="+location_id+"&shipping_method="+shipping_method+"&token=<?=get_unique_id_on_load()?>";
			jQuery.ajax({
				type: "POST",
				url:"<?=SITE_URL?>ajax/check_booking_available.php",
				data:post_data,
				success:function(data) {
					if(data!="") {
						var resp_data = JSON.parse(data);
						if(resp_data.booking_allow==false) {
							jQuery(".shipping_submit_btn").attr("disabled", "disabled");
							jQuery(".time-slot-msg").show();
							jQuery(".time-slot-msg").html(resp_data.msg);
						} else {
							jQuery(".shipping_submit_btn").removeAttr("disabled");
							jQuery(".time-slot-msg").hide();
						}
					} else {
						return false;
					}
				}
			});
		}
	}
	
	function check_step4_validations() {
		var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
		jQuery(".m_validations_showhide").hide();
		
		var payment_method = $("input[name='payment_method']:checked").val();
		<?php
		if($choosed_payment_option['bank']=="bank") { ?>
		if(payment_method=="bank") {
			if(document.getElementById("act_name").value.trim()=="") {
				jQuery("#act_name_error_msg").show().text('Please enter account holder name');
				return false;
			} else if(document.getElementById("act_number").value.trim()=="") {
				jQuery("#act_number_error_msg").show().text('Please enter account number');
				return false;
			} else if(document.getElementById("act_short_code").value.trim()=="") {
				jQuery("#act_short_code_error_msg").show().text('Please enter short code');
				return false;
			}
		}
		<?php
		}
		if($choosed_payment_option['paypal']=="paypal") { ?>
		if(payment_method=="paypal") {
			var paypal_address = document.getElementById("paypal_address").value.trim();
			var confirm_paypal_address = document.getElementById("confirm_paypal_address").value.trim();
			if(paypal_address=="") {
				jQuery("#paypal_address_error_msg").show().text('Enter paypal address');
				return false;
			} else if(!paypal_address.match(mailformat)) {
				jQuery("#paypal_address_error_msg").show().text('Enter enter paypal valid email');
				return false;
			} else if(confirm_paypal_address=="") {
				jQuery("#confirm_paypal_address_error_msg").show().text('Enter confirm paypal address');
				return false;
			} else if(paypal_address!=confirm_paypal_address) {
				jQuery("#paypal_address_error_msg").show().text('Does not match paypal address and confirm paypal address');
				return false;
			}
		}
		<?php
		}
		if($choosed_payment_option['cash']=="cash") { ?>
		if(payment_method=="cash") {
			if(document.getElementById("cash_name").value.trim()=="") {
				jQuery("#cash_name_error_msg").show().text('Please enter name');
				return false;
			}
	
			var telInput3 = jQuery("#cash_phone");
			var c_cash_phone = telInput3.intlTelInput("getNumber");
			jQuery("#f_cash_phone").val(c_cash_phone);
			//jQuery("#sms_notif_phone").html('<a href="tel:'+c_cash_phone+'">'+c_cash_phone+'</a>');
	
			var cash_phone = document.getElementById("cash_phone").value.trim();
			if(cash_phone=="") {
				jQuery("#cash_phone_error_msg").show().text('Please enter phone');
				return false;
			} else if(!telInput3.intlTelInput("isValidNumber")) {
				jQuery("#cash_phone_error_msg").show().text('Please enter valid phone');
				return false;
			}
		}
		<?php
		}
		if($choosed_payment_option['zelle']=="zelle") { ?>
		if(payment_method=="zelle") {
			var zelle_address = document.getElementById("zelle_address").value.trim();
			if(zelle_address=="") {
				jQuery("#zelle_address_error_msg").show().text('Please enter zelle address');
				return false;
			}/* else if(!zelle_address.match(mailformat)) {
				jQuery("#zelle_address_error_msg").show().text('Please enter zelle valid address');
				return false;
			}*/
		}
		<?php
		}
		if($choosed_payment_option['venmo']=="venmo") { ?>
		if(payment_method=="venmo") {
			var venmo_address = document.getElementById("venmo_address").value.trim();
			if(venmo_address=="") {
				jQuery("#venmo_address_error_msg").show().text('Please enter venmo address');
				return false;
			}/* else if(!venmo_address.match(mailformat)) {
				jQuery("#venmo_address_error_msg").show().text('Please enter venmo valid address');
				return false;
			}*/
		}
		<?php
		}
		if($choosed_payment_option['amazon_gcard']=="amazon_gcard") { ?>
		if(payment_method=="amazon_gcard") {
			var amazon_gcard_address = document.getElementById("amazon_gcard_address").value.trim();
			if(amazon_gcard_address=="") {
				jQuery("#amazon_gcard_address_error_msg").show().text('Please enter gcard address');
				return false;
			}/* else if(!amazon_gcard_address.match(mailformat)) {
				jQuery("#amazon_gcard_address_error_msg").show().text('Please enter gcard valid address');
				return false;
			}*/
		}
		<?php
		}
		if($choosed_payment_option['cash_app']=="cash_app") { ?>
		if(payment_method=="cash_app") {
			var cash_app_address = document.getElementById("cash_app_address").value.trim();
			if(cash_app_address=="") {
				jQuery("#cash_app_address_error_msg").show().text('Please enter cash app address');
				return false;
			}/* else if(!cash_app_address.match(mailformat)) {
				jQuery("#cash_app_address_error_msg").show().text('Please enter cash app valid address');
				return false;
			}*/
		}
		<?php
		}
		if($choosed_payment_option['apple_pay']=="apple_pay") { ?>
		if(payment_method=="apple_pay") {
			var apple_pay_address = document.getElementById("apple_pay_address").value.trim();
			if(apple_pay_address=="") {
				jQuery("#apple_pay_address_error_msg").show().text('Please enter apple pay address');
				return false;
			}/* else if(!apple_pay_address.match(mailformat)) {
				jQuery("#apple_pay_address_error_msg").show().text('Please enter apple pay valid address');
				return false;
			}*/
		}
		<?php
		}
		if($choosed_payment_option['google_pay']=="google_pay") { ?>
		if(payment_method=="google_pay") {
			var google_pay_address = document.getElementById("google_pay_address").value.trim();
			if(google_pay_address=="") {
				jQuery("#google_pay_address_error_msg").show().text('Please enter google pay address');
				return false;
			}/* else if(!google_pay_address.match(mailformat)) {
				jQuery("#google_pay_address_error_msg").show().text('Please enter google pay valid address');
				return false;
			}*/
		}
		<?php
		}
		if($choosed_payment_option['coinbase']=="coinbase") { ?>
		if(payment_method=="coinbase") {
			var coinbase_address = document.getElementById("coinbase_address").value.trim();
			if(coinbase_address=="") {
				jQuery("#coinbase_address_error_msg").show().text('Please enter coinbase address');
				return false;
			}/* else if(!coinbase_address.match(mailformat)) {
				jQuery("#coinbase_address_error_msg").show().text('Please enter coinbase valid address');
				return false;
			}*/
		}
		<?php
		}
		if($choosed_payment_option['facebook_pay']=="facebook_pay") { ?>
		if(payment_method=="facebook_pay") {
			var facebook_pay_address = document.getElementById("facebook_pay_address").value.trim();
			if(facebook_pay_address=="") {
				jQuery("#facebook_pay_address_error_msg").show().text('Please enter facebook pay address');
				return false;
			}/* else if(!facebook_pay_address.match(mailformat)) {
				jQuery("#facebook_pay_address_error_msg").show().text('Please enter facebook pay valid address');
				return false;
			}*/
		}
		<?php
		} ?>
	}
	
	function check_shipping_form() {
		jQuery(".m_validations_showhide").hide();
		if(document.getElementById("billing_first_name").value.trim()=="") {
			jQuery("#billing_first_name_error_msg").show().text('Enter first name');
			return false;
		} else if(document.getElementById("billing_last_name").value.trim()=="") {
			jQuery("#billing_last_name_error_msg").show().text('Enter last name');
			return false;
		} else if(document.getElementById("billing_address").value.trim()=="") {
			jQuery("#billing_address_error_msg").show().text('Enter address');
			return false;
		} else if(document.getElementById("billing_city").value.trim()=="") {
			jQuery("#billing_city_error_msg").show().text('Enter city');
			return false;
		} else if(document.getElementById("billing_state").value.trim()=="") {
			jQuery("#billing_state_error_msg").show().text('Enter state');
			return false;
		} else if(document.getElementById("billing_postcode").value.trim()=="") {
			jQuery("#billing_postcode_error_msg").show().text('Enter zip code');
			return false;
		} else if(document.getElementById("billing_phone").value.trim()=="") {
			jQuery("#billing_phone_error_msg").show().text('Enter phone');
			return false;
		}
	
		var telInput2 = jQuery("#billing_phone");
		jQuery("#billing_phone_c_code").val(telInput2.intlTelInput("getSelectedCountryData").dialCode);
		if(!telInput2.intlTelInput("isValidNumber")) {
			jQuery("#billing_phone_error_msg").show().text('Enter valid shipping phone');
			return false;
		}
	
		var shipping_method = jQuery("input[name='shipping_method']:checked").val();
		if(typeof shipping_method === 'undefined') {
			jQuery("#shipping_method_error_msg").show().text('Please select shipping method');
			return false;
		}
	
		if(shipping_method == "store" || shipping_method == "starbucks") {
			if(document.getElementById("location_id").value.trim()=="") {
				jQuery("#location_id_error_msg").show().text('Please select location');
				return false;
			}
			
			var show_appt_datetime_selection_in_place_order = jQuery('#location_id option:selected').data('show_appt_datetime_selection_in_place_order');
			if(document.getElementById("date") != null) {
				var l_date = document.getElementById("date").value.trim();
				if(l_date=="" && show_appt_datetime_selection_in_place_order == 1) {
					jQuery("#date_error_msg").show().text('Please select date');
					return false;
				}
			}
			if(document.getElementById("time_slot") != null) {
				var time_slot = document.getElementById("time_slot").value.trim();
				if(time_slot=="" && show_appt_datetime_selection_in_place_order == 1) {
					jQuery("#time_slot_error_msg").show().text('Please select time');
					return false;
				}
			}
		}
	}
	</script>
	
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
	$(function() {
		$('.srch_list_of_model').autocomplete({
			serviceUrl: '<?=SITE_URL?>ajax/affiliate/get_autocomplete_data.php',
			onSelect: function(suggestion) {
				console.log("onSelect");
				var model_id = suggestion.id;
				post_data = "model_id="+model_id+"&token=<?=get_unique_id_on_load()?>";
				$(document).ready(function($){
					$.ajax({
						type: "POST",
						url:"<?=SITE_URL?>ajax/affiliate/get_model_fields_list.php",
						data:post_data,
						success:function(data) {
							if(data!="") {
								$("#model_fields_list").html(data);
								
								$("#collapseModeldetails").collapse('show');
								$("#collapse_modeldetails_pos").show();
								
								$(".modeldetails-step-arrow-up").show();
								$(".modeldetails-step-arrow-down").hide();
								
								$(".cat-step-arrow-up").hide();
								$(".cat-step-arrow-down").show();
								$(".brand-step-arrow-up").hide();
								$(".brand-step-arrow-down").show();
								$(".second-step-arrow-up").hide();
								$(".second-step-arrow-down").show();
								
								$("#collapse_brand_pos").hide();
								$("#collapse_two_pos").hide();
								
								setTimeout(function() {
									$.scrollTo($('#model_fields_list'), 500);
								}, 500);
							} else {
								$("#model_fields_list").html("");
							}
						}
					});
				});
				//window.location.href = suggestion.url;
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
				
				/*$("#collapseCat").collapse('show');
				$("#collapseCat").addClass('show');
				
				$(".cat-step-arrow-up").show();
				$(".cat-step-arrow-down").hide();
				
				$("#collapse_brand_pos").hide();
				$("#collapse_two_pos").hide();*/
				$("#collapse_modeldetails_pos").hide();
			},
			onSearchComplete: function (query, suggestions) {
				console.log("onSearchComplete",suggestions);
			},
			showNoSuggestionNotice: true,
			noSuggestionNotice: "We didn't find any matching devices...",
		});
	
		$('.srch_list_of_model').keydown(function(event) {
			//if(event.keyCode == 13 && $(this).val() == "") {
			if(event.keyCode == 13) {
			  return false;
			}
		});
	});

	//START for check booking available
	$('.repair_appt_date').datepicker({
		autoclose: true,
		startDate: "today",
		todayHighlight: true
	}).on('changeDate', function(e) {
		getTimeSlotListByDate();
	}); //END for check booking available
	
	$('.datepicker').datepicker({autoclose:true});
	
	$(document).ready(function(){
		tpj('[data-toggle="tooltip"]').tooltip();
	});
	</script>
</body>
</html>
<?php
} ?>