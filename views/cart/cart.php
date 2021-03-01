<?php
$promocode_amt = 0;
$discount_amt_label = "";
if($order_data['promocode_id']>0 && $order_data['promocode_amt']>0) {
	$promocode_amt = $order_data['promocode_amt'];
	$discount_amt_label = "";
	if($order_data['discount_type']=="percentage")
		$discount_amt_label = "(".$order_data['discount']."%)";

	$total_of_order = $sum_of_orders+$order_data['promocode_amt'];
	$is_promocode_exist = true;
} else {
	$total_of_order = $sum_of_orders;
}

if(!empty($guest_user_data) && $guest_user_id > 0) {
	$user_data = $guest_user_data;
	$user_id = $guest_user_id;
}

$open_shipping_popup = 0;
if(isset($_SESSION['open_shipping_popup'])) {
	$open_shipping_popup = $_SESSION['open_shipping_popup'];
	unset($_SESSION['open_shipping_popup']);
}

$is_confirm_sale_terms = false;
if($display_terms_array['confirm_sale']=="confirm_sale") {
	$is_confirm_sale_terms = true;
} ?>

<form action="controllers/cart/cart.php" method="post" id="revieworder_form">
  <section class="pb-0">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
          <div class="block heading page-heading text-center">
            <h1>Order details:</h1>
          </div>
          <div class="block order-details cart clearfix">
            <table class="table table-borderless parent">
              <tr class="card_order_detail">
                <th class="sl">No</th>
                <th class="image"></th>
                <th class="description">Name description</th>
                <th class="price">Price</th>
				<th class="imei">IMEI Number</th>
                <th class="action"></th>
              </tr> 
			  <?php
			  $tid=1;
			  foreach($order_item_list as $order_item_list_data) {

				$model_data = get_single_model_data($order_item_list_data['model_id']);
				$mdl_details_url = SITE_URL.$model_details_page_slug.$model_data['sef_url'];

				//path of this function (get_order_item) admin/include/functions.php
				$order_item_data = get_order_item($order_item_list_data['id'],'rev_ord_list'); ?>
				  <tr class="main_bulk_cell">
					<td class="sl bulk_order_cell"><?=$tid?></td>
					<td class="image bulk_order_cell">
						<?php
						if($order_item_list_data['device_icon']) {
							echo '<img src="'.SITE_URL.'images/device/'.$order_item_list_data['device_icon'].'"/>';
						} elseif($order_item_list_data['cat_cart_image']) {
							echo '<img src="'.SITE_URL.'images/categories/'.$order_item_list_data['cat_cart_image'].'"/>';
						} ?>
					</td>
					<td class="bulk_order_cell description item-description-<?=$order_item_list_data['id']?>">
					  <h6><?=$order_item_list_data['model_title']?></h6>
					  <a class="d-block d-md-none d-lg-none device-info" data-id="<?=$order_item_list_data['id']?>" href="javascript:void(0)">more info</a>
					  <?=$order_item_data['device_type']?> 
					</td>
					<td class="price bulk_order_cell"><?=amount_fomat($order_item_list_data['price'])?></td>
					<td class="imei bulk_order_cell"><input type="text" maxlength="15" class="form-control imei" id="imei_number-<?= $tid ?>" name="imei_number[<?= $order_item_list_data['id'] ?>]" value="<?= $order_item_list_data['imei_number'] ?>"></td>
					<td class="action bulk_order_cell">
					  <a href="<?=$mdl_details_url?>?item_id=<?=$order_item_list_data['id']?>"><img src="<?=SITE_URL?>images/cart/edit.png" alt="Edit"></a>
					  <a href="<?=SITE_URL?>controllers/cart/cart.php?rorder_id=<?=$order_item_list_data['id']?>" onclick="return confirm('Are you sure you want to remove this item?');"><img src="<?=SITE_URL?>images/icons/close-circle.png" alt="Remove"></a>
					</td>
				  </tr>
			  <?php
			  $tid++;
			  $item_price_array[] = amount_fomat($order_item_list_data['price']);
			  } ?>
				<tr>
					<td colspan="6">
					<div class="clearfix">
					  <button type="submit" name="empty_cart" class="btn btn-secondary btn-empty-cart btn-lg float-left">Empty Cart</button>
					  <button type="submit" name="update_cart" class="btn btn-secondary btn-update-quatity btn-lg float-right">Update</button>
					</div>
					</td>
				</tr>
					
              <tr class="total-table-cell pc-mobile-table-cell">
				<td colspan="6">
					<table class="table">
						<tr>
						  <td class="cart-total-cell">
                  			  <h5 class="title">Expected payments:</h5>
							  <p>
								<?php
								$expected_payments = ''; 
								if(count($item_price_array)==1) {
									$expected_payments = '<span>'.amount_fomat($sum_of_orders).'</span>';
								} else {
									$expected_payments = implode(" + ",$item_price_array).' = <span class="total-price_section">'.amount_fomat($sum_of_orders).'</span>';
								}
								echo $expected_payments; ?> <span id="showhide_promocode_row" <?php if($promocode_amt<=0) {echo 'style="display:none;"';}?>> + <span id="promocode_amt_label"><?=$discount_amt_label?></span> <span id="promocode_amt"><?=amount_fomat($promocode_amt)?></span>&nbsp;(Coupon)&nbsp;<a href="javascript:void(0);" id="promocode_removed">X</a></span>
							  </p>
							  <?php
							  $bonus_data = get_bonus_data_info_by_user($user_id);
							  $bonus_percentage = $bonus_data['bonus_data']['percentage'];
							  if($user_id>0 && $bonus_percentage>0) {
								$bonus_amount = ($sum_of_orders * $bonus_percentage / 100); ?>
								<p class="bonus"><img src="<?=SITE_URL?>images/icons/gift.png" alt="gift"> Bonus: <?=$bonus_percentage?>% = <?=amount_fomat($bonus_amount)?></p>
								<input type="hidden" name="bonus_percentage" id="bonus_percentage" value="<?=$bonus_percentage?>"/>
								<input type="hidden" name="bonus_amount" id="bonus_amount" value="<?=$bonus_amount?>"/>
							  <?php
							  }
							  if($general_setting_data['promocode_section']=='1') { ?>
								  <h5 class="price-coupon">
									<div>
									  <input type="text" name="promo_code" id="promo_code" class="form-control promo_code" placeholder="Coupon: $10" autocomplete="nope" value="<?=$order_data['promocode']?>" <?php if($order_data['promocode']!=""){echo 'readonly="readonly"';}?>>
									  <button class="btn btn-link close-icon" type="reset"><img src="<?=SITE_URL?>images/icons/close-circle.png" alt=""></button>
									  <a href="javascript:void(0);" name="apl_promo_code" id="apl_promo_code" class="apl_promo_code" onclick="getPromoCode();" <?php if($order_data['promocode']!=""){echo 'style="display:none;"';}?>><img class="status" src="<?=SITE_URL?>images/icons/tick.png" alt="tick"></a><span id="apl_promo_spining_icon"></span>
									  <img class="coupon-icon" src="<?=SITE_URL?>images/cart/coupon.png" alt="coupon">
									</div>
								  </h5>
							  	  <span class="showhide_promocode_msg" style="display:none;"><span class="promocode_msg"></span></span>
							  	  <input type="hidden" name="promocode_id" id="promocode_id" value="<?=$order_data['promocode_id']?>"/>
							  	  <input type="hidden" name="promocode_value" id="promocode_value" value="<?=$order_data['promocode']?>"/>
							  <?php
							  } ?>
                  			  <p class="note">*We occasionally offer promo codes in our email blasts or Facebook page</p>
                		</td>
						<td class="paid-cell text-center">
						  <p><button type="button" class="btn btn-primary btn-lg rounded-pill get-paid" data-toggle="modal" <?php if($user_id>0){echo 'data-target="#ShippingFields"';}else{echo 'data-target="#SignInRegistration"';}?>>Get Paid</button></p>
						  <p class="mb-0"><a href="<?=SITE_URL?>sell" class="btn btn-lg btn-outline-dark rounded-pill">Add Device</a></p>
						</td>
					</tr>
				</table>
			</td>
			<!-- <td class="total-cell"></td> --> 
              </tr>
            </table>
			
            <?php /*?><table class="d-block cart-table-mobile d-md-none table table-borderless parent">
              <tr>
                <td class="total-cell"></td>
                <td class="cart-total-cell" colspan="2">
                  <h5 class="title">Expected payments:</h5>
                  <p>
				  	<?=implode(" + ",$item_price_array)?> = <span><?=amount_fomat($sum_of_orders)?></span>
				  </p>
				  <?php
				  if($user_id>0) { ?>
                  <p class="bonus"><img src="<?=SITE_URL?>images/icons/gift.png" alt=""> Bonus: 1% = $4.5</p>
				  <?php
				  } ?>
                  <h5 class="price-coupon">
                    <div>
                      <input type="text" class="form-control" placeholder="Coupon: $10" required>
                      <button class="btn btn-link close-icon" type="reset"><img src="<?=SITE_URL?>images/icons/close-circle.png" alt=""></button>
                      <img class="status" src="<?=SITE_URL?>images/icons/tick.png" alt="">
                      <img class="coupon-icon" src="<?=SITE_URL?>images/cart/coupon.png" alt="">
                    </div>
                  </h5>
                  <p class="note">*We occasionally offer promo codes in our email blasts or Facebook page</p>				
                </td>
                <td class="paid-cell" colspan="2">
                  <button class="btn btn-primary btn-lg rounded-pill" data-toggle="modal" <?php if($user_id>0){echo 'data-target="#ShippingFields"';}else{echo 'data-target="#SignInRegistration"';}?>>Get Paid</button>
                </td>
              </tr>
            </table><?php */?>
			
          </div>
        </div>
      </div>
    </div>
  </section>
<input id="order_id" name="order_id" value="<?=$order_id?>" type="hidden">
</form>

  <div class="modal fade" id="ShippingFields" tabindex="-1" role="dialog" aria-labelledby="ShippingFields" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title shipping_payment_label"><?=$cart_payment_method_title?></h5>
          <h6 class="address_label"></h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <img src="<?=SITE_URL?>images/payment/close.png" alt="">
          </button>
        </div>
		
        <div class="modal-body pt-3 text-center shipping_form_section" style="display:none;">
			<?php
			$shipping_first_name = $order_data['shipping_first_name'];
			$shipping_last_name = $order_data['shipping_last_name'];
			$shipping_company_name = $order_data['shipping_company_name'];
			if($user_data['first_name']) {
				$shipping_first_name = $user_data['first_name'];
			}
			if($user_data['last_name']) {
				$shipping_last_name = $user_data['last_name'];
			}
			if($user_data['company_name']) {
				$shipping_company_name = $user_data['company_name'];
			}
			
			$shipping_address = $order_data['shipping_address1'];
			$shipping_address2 = $order_data['shipping_address2'];
			$shipping_city = $order_data['shipping_city'];
			$shipping_state = $order_data['shipping_country'];
			$shipping_postcode = $order_data['shipping_postcode'];
			$shipping_phone = $order_data['shipping_phone'];
			$shipping_country_code = $order_data['shipping_country_code'];
			if($user_data['use_shipping_adddress_prefilled'] == '1' || $guest_user_id > 0) {
				if($user_data['address']) {
					$shipping_address = $user_data['address'];
				}
				if($user_data['address2']) {
					$shipping_address2 = $user_data['address2'];
				}
				if($user_data['city']) {
					$shipping_city = $user_data['city'];
				}
				if($user_data['state']) {
					$shipping_state = $user_data['state'];
				}
				if($user_data['postcode']) {
					$shipping_postcode = $user_data['postcode'];
				}
				if($user_data['phone']) {
					$shipping_phone = $user_data['phone'];
				}
				if($user_data['country_code']) {
					$shipping_country_code = $user_data['country_code'];
				}
			} ?>
			<form action="<?=(!$is_confirm_sale_terms?SITE_URL.'controllers/cart/confirm.php':'')?>" class="sign-in needs-validation" id="shipping_form" novalidate>
				<div class="form-row">
				  <div class="form-group mt-3 col-md-4 with-icon">
					<img src="<?=SITE_URL?>images/icons/user-gray.png" alt="">
					<input type="text" class="form-control" name="shipping_first_name" id="shipping_first_name" placeholder="First Name" value="<?=$shipping_first_name?>" autocomplete="nope">
					<div id="shipping_first_name_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
				  </div>
				  <div class="form-group mt-3 col-md-4 with-icon">
					 <img src="<?=SITE_URL?>images/icons/user-gray.png" alt=""> 
					 <input type="text" class="form-control" name="shipping_last_name" id="shipping_last_name" value="<?=$shipping_last_name?>" autocomplete="nope" placeholder="Last Name" required>
					<div id="shipping_last_name_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
				  </div>
				  <div class="form-group mt-3 col-md-4 with-icon telephone-form">
					<img src="<?=SITE_URL?>images/icons/phone_dial.png" alt="">
					<input type="tel" id="shipping_phone" name="shipping_phone" class="form-control">
					<input type="hidden" name="shipping_phone_c_code" id="shipping_phone_c_code" value="<?=$shipping_country_code?>"/>
					<div id="shipping_phone_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
				  </div>
				</div>
				
				<div class="form-row shipping_address_fields">
				  <div class="form-group mt-3  col-md-6 with-icon">
					<img src="<?=SITE_URL?>images/icons/place-marker.png" alt="">
					<input type="text" class="form-control" name="shipping_address" id="shipping_address" value="<?=$shipping_address?>" autocomplete="nope" placeholder="Street address" required>
					<div id="shipping_address_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
				  </div>
				  <div class="form-group mt-3 col-md-6 with-icon">
					<img src="<?=SITE_URL?>images/icons/place-marker.png" alt="">
					<input type="text" class="form-control" name="shipping_address2" id="shipping_address2"  value="<?=$shipping_address2?>" autocomplete="nope" placeholder="Street address 2 (optional)">
				  </div>
				</div>
				<div class="form-row shipping_address_fields">
				  <div class="form-group mt-3 col-md-6 with-icon">
					<img src="<?=SITE_URL?>images/icons/people.png" alt="">
					<input type="text" class="form-control" name="shipping_company_name" id="shipping_company_name"  value="<?=$shipping_company_name?>" autocomplete="nope" placeholder="Company (optional)">
				  </div>
				  <div class="form-group mt-3 col-md-6 with-icon">
					<img src="<?=SITE_URL?>images/icons/home.png" alt="">
					<input type="text" class="form-control" name="shipping_city" id="shipping_city" value="<?=$shipping_city?>" autocomplete="nope" placeholder="City" required>
					<div id="shipping_city_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
				  </div>
				</div>
				<div class="form-row shipping_address_fields">
				   <div class="form-group mt-3 col-md-6 with-icon">
					 <img src="<?=SITE_URL?>images/icons/state.png" alt="">
					 <input type="text" class="form-control" name="shipping_state" id="shipping_state" value="<?=$shipping_state?>" autocomplete="nope" placeholder="State" required>
					 <div id="shipping_state_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
				   </div>
				  <div class="form-group mt-3 col-md-6 with-icon">
					<img src="<?=SITE_URL?>images/icons/envelop.png" alt="">
					<input type="text" class="form-control" name="shipping_postcode" id="shipping_postcode" value="<?=$shipping_postcode?>" autocomplete="nope" placeholder="Zip code">
					<div id="shipping_postcode_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
					<input type="hidden" name="is_exist_demand_pickup_zipcode" id="is_exist_demand_pickup_zipcode">
				  </div>
				</div>

				<?php
				if($guest_user_id<=0) { ?>
				<div class="form-row shipping_address_fields">
				  <div class="form-group mt-3 col-md-6">
					<div class="custom-control custom-checkbox">
					  <input type="checkbox" class="custom-control-input" name="save_as_primary_address" id="save_as_primary_address" value="1"/>
					  <label class="custom-control-label" for="save_as_primary_address">Save as my primary address</label>
					</div>
				  </div>
				</div>
				<?php
				} ?>
				
				<?php
				if(!empty(array_filter($shipping_option))) { ?>
				<h5><?=$cart_select_shipping_method_title?></h5>
				<div class="form-row">
					<div class="form-group col-md-12 shipping_method_section">
						<?php
						foreach($shipping_option_ordr_arr as $sooa_k=>$sooa_v) {
							if($shipping_option['post_me_a_prepaid_label'] == $sooa_v) { ?>
							<div class="custom-control custom-radio">
								<label>
								<input type="radio" id="sm_post_me_a_prepaid_label" name="shipping_method" value="post_me_a_prepaid_label">
								<span><?=$cart_shipping_method_post_me_a_prepaid_label_title?></span></label>
								<?php
								if($shipping_option[$sooa_v.'_image']!="") {
									echo '<img src="'.SITE_URL.'/images/'.$shipping_option[$sooa_v.'_image'].'" width="30">';
								} ?>
							</div>
							<?php
							}
							if($shipping_option['print_a_prepaid_label'] == $sooa_v) { ?>
							<div class="custom-control custom-radio">
								<label>
								<input type="radio" id="sm_print_a_prepaid_label" name="shipping_method" value="print_a_prepaid_label">
								<span><?=$cart_shipping_method_print_a_prepaid_label_title?></span></label>
								<?php
								if($shipping_option[$sooa_v.'_image']!="") {
									echo '<img src="'.SITE_URL.'/images/'.$shipping_option[$sooa_v.'_image'].'" width="30">';
								} ?>
							</div>
							<?php
							}
							if($shipping_option['use_my_own_courier'] == $sooa_v) { ?>
							<div class="custom-control custom-radio">
								<label>
								<input type="radio" id="sm_use_my_own_courier" name="shipping_method" value="use_my_own_courier">
								<span><?=$cart_shipping_method_use_my_own_courier_title?></span></label>
								<?php
								if($shipping_option[$sooa_v.'_image']!="") {
									echo '<img src="'.SITE_URL.'/images/'.$shipping_option[$sooa_v.'_image'].'" width="30">';
								} ?>
							</div>
							<?php
							}
							if($shipping_option['we_come_for_you'] == $sooa_v) { ?>
							<div class="custom-control custom-radio">
								<label>
								<input type="radio" id="sm_we_come_for_you" name="shipping_method" value="we_come_for_you">
								<span><?=$cart_shipping_method_we_come_for_you_title?></span></label>
								<?php
								if($shipping_option[$sooa_v.'_image']!="") {
									echo '<img src="'.SITE_URL.'/images/'.$shipping_option[$sooa_v.'_image'].'" width="30">';
								}
								
								$demand_pickup_zipcodes_settings = get_demand_pickup_zipcodes_settings();
								if(!empty($demand_pickup_zipcodes_settings['url'])) {
									echo '<a href="'.$demand_pickup_zipcodes_settings['url'].'" target="_blank" class="readmore_demand_pickup">Read More On Demand Pickup</a>';
								} ?>
							</div>
							<?php
							}
	
							$store_location_list = get_store_location_list('','store');
							if($shipping_option['store'] == $sooa_v && !empty($store_location_list)) { ?>
							<div class="custom-control custom-radio">
								<label>
								<input type="radio" id="sm_store" name="shipping_method" value="store">
								<span><?=$cart_shipping_method_store_title?></span></label>
								<?php
								if($shipping_option[$sooa_v.'_image']!="") {
									echo '<img src="'.SITE_URL.'/images/'.$shipping_option[$sooa_v.'_image'].'" width="30">';
								} ?>
							</div>
							<?php
							}
	
							$starbucks_location_list = get_store_location_list('','starbucks');
							if($shipping_option['starbucks'] == $sooa_v && !empty($starbucks_location_list)) { ?>
							<div class="custom-control custom-radio">
								<label>
								<input type="radio" id="sm_starbucks" name="shipping_method" value="starbucks">
								<span><?=$cart_shipping_method_starbucks_title?></span></label>
								<?php
								if($shipping_option[$sooa_v.'_image']!="") {
									echo '<img src="'.SITE_URL.'/images/'.$shipping_option[$sooa_v.'_image'].'" width="30">';
								} ?>
							</div>
							<?php
							}
						} ?>
						
						<?php /*?><?php
						if($shipping_option['post_me_a_prepaid_label'] == "post_me_a_prepaid_label") { ?>
						<div class="custom-control custom-radio">
							
							<label>
 								<input type="radio" id="sm_post_me_a_prepaid_label" name="shipping_method" value="post_me_a_prepaid_label">
								<span><?=$cart_shipping_method_post_me_a_prepaid_label_title?></span></label>
						</div>
						<?php
						}
						if($shipping_option['print_a_prepaid_label'] == "print_a_prepaid_label") { ?>
						<div class="custom-control custom-radio">
							<label>
								<input type="radio" id="sm_print_a_prepaid_label" name="shipping_method" value="print_a_prepaid_label">
								<span><?=$cart_shipping_method_print_a_prepaid_label_title?></span></label>
						</div>
						<?php
						}
						if($shipping_option['use_my_own_courier'] == "use_my_own_courier") { ?>
						<div class="custom-control custom-radio">
							<label>
								<input type="radio" id="sm_use_my_own_courier" name="shipping_method" value="use_my_own_courier">
								<span><?=$cart_shipping_method_use_my_own_courier_title?></span></label>
						</div>
						<?php
						}
						if($shipping_option['we_come_for_you'] == "we_come_for_you") { ?>
						<div class="custom-control custom-radio">
							<label>
								<input type="radio" id="sm_we_come_for_you" name="shipping_method" value="we_come_for_you">
								<span><?=$cart_shipping_method_we_come_for_you_title?></span></label>
						</div>
						<?php
						}

						$store_location_list = get_store_location_list('','store');
						if($shipping_option['store'] == "store" && !empty($store_location_list)) { ?>
						<div class="custom-control custom-radio">
							
							<label>
                               <input type="radio" id="sm_store" name="shipping_method" value="store">
								<span><?=$cart_shipping_method_store_title?></span></label>
						</div>
						<?php
						}

						$starbucks_location_list = get_store_location_list('','starbucks');
						if($shipping_option['starbucks'] == "starbucks" && !empty($starbucks_location_list)) { ?>
						<div class="custom-control custom-radio">
							
							<label>
                               <input type="radio" id="sm_starbucks" name="shipping_method" value="starbucks">
								<span><?=$cart_shipping_method_starbucks_title?></span></label>
						</div>
						<?php
						} ?><?php */?>
					</div>
					<div id="shipping_method_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
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

				<div class="form-group double-btn pt-5 text-center">
				  <button type="button" class="btn btn-lg btn-outline-dark rounded-pill mr-lg-2 bk_payment_form">Back</button>
				  <button type="button" class="btn btn-primary btn-lg rounded-pill ml-lg-2 shipping_submit_btn"><?=($is_confirm_sale_terms?'Continue':'Place Order')?></button>
				</div>
				<span id="place_order_spining_icon"></span>
				<input type="hidden" name="confirm_sale" value="yes"/>
			<input type="hidden" name="num_of_item" id="num_of_item" value="<?=count($order_item_ids);?>"/>
			</form>
        </div>

		<div class="modal-body text-center payment_form_section">
          <ul class="nav nav-tabs" id="myTab" role="tablist">
		  	<?php
			$o_payment_method_details = json_decode($order_data['payment_method_details'],true);
			$account_holder_name = (!empty($o_payment_method_details['account_holder_name'])?$o_payment_method_details['account_holder_name']:'');
			$account_number = (!empty($o_payment_method_details['account_number'])?$o_payment_method_details['account_number']:'');
			$short_code = (!empty($o_payment_method_details['short_code'])?$o_payment_method_details['short_code']:'');
			$cash_name = (!empty($o_payment_method_details['cash_name'])?$o_payment_method_details['cash_name']:'');
			$cash_phone = (!empty($o_payment_method_details['cash_phone'])?$o_payment_method_details['cash_phone']:'');
			$paypal_address = (!empty($o_payment_method_details['paypal_address'])?$o_payment_method_details['paypal_address']:'');
			$venmo_address = (!empty($o_payment_method_details['venmo_address'])?$o_payment_method_details['venmo_address']:'');
			$zelle_address = (!empty($o_payment_method_details['zelle_address'])?$o_payment_method_details['zelle_address']:'');
			$amazon_gcard_address = (!empty($o_payment_method_details['amazon_gcard_address'])?$o_payment_method_details['amazon_gcard_address']:'');
			$cash_app_address = (!empty($o_payment_method_details['cash_app_address'])?$o_payment_method_details['cash_app_address']:'');
			$apple_pay_address = (!empty($o_payment_method_details['apple_pay_address'])?$o_payment_method_details['apple_pay_address']:'');
			$google_pay_address = (!empty($o_payment_method_details['google_pay_address'])?$o_payment_method_details['google_pay_address']:'');
			$coinbase_address = (!empty($o_payment_method_details['coinbase_address'])?$o_payment_method_details['coinbase_address']:'');
			$facebook_pay_address = (!empty($o_payment_method_details['facebook_pay_address'])?$o_payment_method_details['facebook_pay_address']:'');

			$payment_method_details = json_decode($user_data['payment_method_details'],true);
			if($user_data['use_payment_method_prefilled'] == '1') {
				$my_payment_option = $payment_method_details['my_payment_option'];
				if($my_payment_option) {
					$default_payment_option = $my_payment_option;
				}
				
				$account_holder_name = !empty($payment_method_details['data']['bank']['act_name'])?$payment_method_details['data']['bank']['act_name']:'';
				$account_number = !empty($payment_method_details['data']['bank']['act_number'])?$payment_method_details['data']['bank']['act_number']:'';
				$short_code = !empty($payment_method_details['data']['bank']['act_short_code'])?$payment_method_details['data']['bank']['act_short_code']:'';
				$cash_name = !empty($payment_method_details['data']['cash']['cash_name'])?$payment_method_details['data']['cash']['cash_name']:'';
				$cash_phone = !empty($payment_method_details['data']['cash']['cash_phone'])?$payment_method_details['data']['cash']['cash_phone']:'';
				$paypal_address = !empty($payment_method_details['data']['paypal']['paypal_address'])?$payment_method_details['data']['paypal']['paypal_address']:'';
				$venmo_address = !empty($payment_method_details['data']['venmo']['venmo_address'])?$payment_method_details['data']['venmo']['venmo_address']:'';
				$zelle_address = !empty($payment_method_details['data']['zelle']['zelle_address'])?$payment_method_details['data']['zelle']['zelle_address']:'';
				$amazon_gcard_address = !empty($payment_method_details['data']['amazon_gcard']['amazon_gcard_address'])?$payment_method_details['data']['amazon_gcard']['amazon_gcard_address']:'';
				$cash_app_address = (!empty($payment_method_details['data']['cash_app']['cash_app_address'])?$payment_method_details['data']['cash_app']['cash_app_address']:'');
				$apple_pay_address = (!empty($payment_method_details['data']['apple_pay']['apple_pay_address'])?$payment_method_details['data']['apple_pay']['apple_pay_address']:'');
				$google_pay_address = (!empty($payment_method_details['data']['google_pay']['google_pay_address'])?$payment_method_details['data']['google_pay']['google_pay_address']:'');
				$coinbase_address = (!empty($payment_method_details['data']['coinbase']['coinbase_address'])?$payment_method_details['data']['coinbase']['coinbase_address']:'');
				$facebook_pay_address = (!empty($payment_method_details['data']['facebook_pay']['facebook_pay_address'])?$payment_method_details['data']['facebook_pay']['facebook_pay_address']:'');
			}

			if($choosed_payment_option['bank']=="bank") { ?>
			<li class="nav-item <?php if($default_payment_option=="bank"){echo 'active';}?>">
              <a class="nav-link <?php if($default_payment_option=="bank"){echo 'active';}?>" id="bank-tab" data-toggle="tab" href="#bank" role="tab" aria-controls="bank" aria-selected="true">
                <p><img src="<?=SITE_URL?>images/payment/bank.png" alt="bank"><span class="name"><?=$payment_method_bank_heading_text?></span></p>
              </a>
            </li>
			<?php
			}
			if($choosed_payment_option['paypal']=="paypal") { ?>
			<li class="nav-item <?php if($default_payment_option=="paypal"){echo 'active';}?>">
              <a class="nav-link <?php if($default_payment_option=="paypal"){echo 'active';}?>" id="paypal-tab" data-toggle="tab" href="#paypal" role="tab" aria-controls="paypal" aria-selected="true">
                <p><img src="<?=SITE_URL?>images/payment/paypal.png" alt="paypal"><span class="name"><?=$payment_method_paypal_heading_text?></span></p>
              </a>
            </li>
			<?php
			}
			if($choosed_payment_option['cheque']=="cheque") { ?>
            <li class="nav-item <?php if($default_payment_option=="cheque"){echo 'active';}?>">
              <a class="nav-link <?php if($default_payment_option=="cheque"){echo 'active';}?>" id="cheque-tab" data-toggle="tab" href="#cheque" role="tab" aria-controls="cheque" aria-selected="false">
                <p>
                  <img src="<?=SITE_URL?>images/payment/bank.png" alt="bank">
                  <span class="name"><?=$cheque_check_label?></span>
                  <!--<span class="status">(not available at the moment)</span>-->
                </p>
              </a>
            </li>
			<?php
			}
			if($choosed_payment_option['zelle']=="zelle") { ?>
			<li class="nav-item <?php if($default_payment_option=="zelle"){echo 'active';}?>">
              <a class="nav-link <?php if($default_payment_option=="zelle"){echo 'active';}?>" id="zelle-tab" data-toggle="tab" href="#zelle" role="tab" aria-controls="zelle" aria-selected="true">
                <p><img src="<?=SITE_URL?>images/payment/zelle.png" alt="zelle"><span class="name"><?=$payment_method_zelle_heading_text?></span></p>
              </a>
            </li>
			<?php
			}
			if($choosed_payment_option['cash']=="cash") { ?>
			<li class="nav-item <?php if($default_payment_option=="cash"){echo 'active';}?>">
              <a class="nav-link <?php if($default_payment_option=="cash"){echo 'active';}?>" id="cash-tab" data-toggle="tab" href="#cash" role="tab" aria-controls="cash" aria-selected="true">
                <p><img src="<?=SITE_URL?>images/payment/cash.png" alt="cash"><span class="name"><?=$payment_method_cash_heading_text?></span></p>
              </a>
            </li>
			<?php
			}
			if($choosed_payment_option['venmo']=="venmo") { ?>
			<li class="nav-item <?php if($default_payment_option=="venmo"){echo 'active';}?>">
              <a class="nav-link <?php if($default_payment_option=="venmo"){echo 'active';}?>" id="venmo-tab" data-toggle="tab" href="#venmo" role="tab" aria-controls="venmo" aria-selected="true">
                <p><img src="<?=SITE_URL?>images/payment/venmo.png" alt="venmo"><span class="name"><?=$payment_method_venmo_heading_text?></span></p>
              </a>
            </li>
			<?php
			}
			if($choosed_payment_option['amazon_gcard']=="amazon_gcard") { ?>
			<li class="nav-item <?php if($default_payment_option=="amazon_gcard"){echo 'active';}?>">
              <a class="nav-link <?php if($default_payment_option=="amazon_gcard"){echo 'active';}?>" id="amazon_gcard-tab" data-toggle="tab" href="#amazon_gcard" role="tab" aria-controls="amazon_gcard" aria-selected="true">
                <p><img src="<?=SITE_URL?>images/payment/amazon_gcard.png" alt="amazon_gcard"><span class="name"><?=$payment_method_amazon_gcard_heading_text?></span></p>
              </a>
            </li>
			<?php
			}
			
			if($choosed_payment_option['cash_app']=="cash_app") { ?>
			<li class="nav-item <?php if($default_payment_option=="cash_app"){echo 'active';}?>">
              <a class="nav-link <?php if($default_payment_option=="cash_app"){echo 'active';}?>" id="cash_app-tab" data-toggle="tab" href="#cash_app" role="tab" aria-controls="cash_app" aria-selected="true">
                <p><img src="<?=SITE_URL?>images/payment/cash_app.png" alt="cash_app" width="120"><span class="name"><?=$payment_method_cash_app_heading_text?></span></p>
              </a>
            </li>
			<?php
			}
			if($choosed_payment_option['apple_pay']=="apple_pay") { ?>
			<li class="nav-item <?php if($default_payment_option=="apple_pay"){echo 'active';}?>">
              <a class="nav-link <?php if($default_payment_option=="apple_pay"){echo 'active';}?>" id="apple_pay-tab" data-toggle="tab" href="#apple_pay" role="tab" aria-controls="apple_pay" aria-selected="true">
                <p><img src="<?=SITE_URL?>images/payment/apple_pay.png" alt="apple_pay" width="120"><span class="name"><?=$payment_method_apple_pay_heading_text?></span></p>
              </a>
            </li>
			<?php
			}
			if($choosed_payment_option['google_pay']=="google_pay") { ?>
			<li class="nav-item <?php if($default_payment_option=="google_pay"){echo 'active';}?>">
              <a class="nav-link <?php if($default_payment_option=="google_pay"){echo 'active';}?>" id="google_pay-tab" data-toggle="tab" href="#google_pay" role="tab" aria-controls="google_pay" aria-selected="true">
                <p><img src="<?=SITE_URL?>images/payment/google_pay.png" alt="google_pay" width="120"><span class="name"><?=$payment_method_google_pay_heading_text?></span></p>
              </a>
            </li>
			<?php
			}
			if($choosed_payment_option['coinbase']=="coinbase") { ?>
			<li class="nav-item <?php if($default_payment_option=="coinbase"){echo 'active';}?>">
              <a class="nav-link <?php if($default_payment_option=="coinbase"){echo 'active';}?>" id="coinbase-tab" data-toggle="tab" href="#coinbase" role="tab" aria-controls="coinbase" aria-selected="true">
                <p><img src="<?=SITE_URL?>images/payment/coinbase.png" alt="coinbase" width="170"><span class="name"><?=$payment_method_coinbase_heading_text?></span></p>
              </a>
            </li>
			<?php
			}
			if($choosed_payment_option['facebook_pay']=="facebook_pay") { ?>
			<li class="nav-item <?php if($default_payment_option=="facebook_pay"){echo 'active';}?>">
              <a class="nav-link <?php if($default_payment_option=="facebook_pay"){echo 'active';}?>" id="facebook_pay-tab" data-toggle="tab" href="#facebook_pay" role="tab" aria-controls="facebook_pay" aria-selected="true">
                <p><img src="<?=SITE_URL?>images/payment/facebook_pay.png" alt="facebook_pay" width="120"><span class="name"><?=$payment_method_facebook_pay_heading_text?></span></p>
              </a>
            </li>
			<?php
			} ?>
          </ul>
		  <form action="" method="post" id="payment_form">
          <div class="tab-content" id="myTabContent">	
			<input class="r_payment_method" name="payment_method" value="<?=$default_payment_option?>" type="hidden">
			<input type="hidden" name="confirm_sale" value="yes"/>
			<input type="hidden" name="num_of_item" id="num_of_item" value="<?=count($order_item_ids);?>"/>
		    <?php
			if($choosed_payment_option['bank']=="bank") { ?>
			<div class="bank-fields tab-pane fade <?php if($default_payment_option=="bank"){echo 'show active';}?>" id="bank" role="tabpanel" aria-labelledby="bank-tab">
			  <p><?=$payment_instruction['bank']?></p>
                <div class="form-group">
					<input type="text" class="form-control" id="act_name" name="act_name" placeholder="<?=$cart_payment_method_act_name_place_holder_text?>" autocomplete="nope" value="<?=$account_holder_name?>">
					<div id="act_name_error_msg" class="invalid-feedback text-center m_validations_showhide" style="display:none;"></div>
                </div>
                <div class="form-group">
					<input type="text" class="form-control" id="act_number" name="act_number" placeholder="<?=$cart_payment_method_act_number_place_holder_text?>" autocomplete="nope" value="<?=$account_number?>">
					<div id="act_number_error_msg" class="invalid-feedback text-center m_validations_showhide" style="display:none;"></div>
                </div>
				<div class="form-group">
					<input type="text" class="form-control" id="act_short_code" name="act_short_code" placeholder="<?=$cart_payment_method_act_short_code_place_holder_text?>" autocomplete="nope" value="<?=$short_code?>">
					<div id="act_short_code_error_msg" class="invalid-feedback text-center m_validations_showhide" style="display:none;"></div>
                </div>
				
                <button type="submit" class="btn btn-primary btn-lg rounded-pill payment_submit_btn">Continue</button>
            </div>
			<?php
			}
			if($choosed_payment_option['paypal']=="paypal") { ?>
			<div class="paypal-fields tab-pane fade <?php if($default_payment_option=="paypal"){echo 'show active';}?>" id="paypal" role="tabpanel" aria-labelledby="paypal-tab">
			  <p><?=$payment_instruction['paypal']?></p>
                <div class="form-group">
					<input type="text" class="form-control" id="paypal_address" name="paypal_address" value="<?=$paypal_address?>" autocomplete="nope" placeholder="<?=$cart_payment_method_paypal_adr_place_holder_text?>">
					<div id="paypal_address_error_msg" class="invalid-feedback text-center m_validations_showhide" style="display:none;"></div>
					<div id="exist_paypal_address_msg" class="invalid-feedback text-center" style="display:none;"></div>
                </div>
                <div class="form-group">
					<input type="text" class="form-control" id="confirm_paypal_address" name="confirm_paypal_address" value="<?=$paypal_address?>" autocomplete="nope" placeholder="<?=$cart_payment_method_paypal_adr_repeat_place_holder_text?>">
					<div id="confirm_paypal_address_error_msg" class="invalid-feedback text-center m_validations_showhide" style="display:none;"></div>
                </div>
				
                <button type="submit" class="btn btn-primary btn-lg rounded-pill payment_submit_btn">Continue</button>
            </div>
			<?php
			}
			if($choosed_payment_option['cheque']=="cheque") { ?>
            <div class="tab-pane fade <?php if($default_payment_option=="cheque"){echo 'show active';}?>" id="cheque" role="tabpanel" aria-labelledby="cheque-tab">
			  <p><?=$payment_instruction['cheque']?></p>
				
                <button type="submit" class="btn btn-primary btn-lg rounded-pill payment_submit_btn">Continue</button>
            </div>
			<?php
			}
			
			if($choosed_payment_option['venmo']=="venmo") { ?>
			<div class="venmo-fields tab-pane fade <?php if($default_payment_option=="venmo"){echo 'show active';}?>" id="venmo" role="tabpanel" aria-labelledby="venmo-tab">
			  <p><?=$payment_instruction['venmo']?></p>
                <div class="form-group">
					<input type="text" class="form-control" placeholder="<?=$cart_payment_method_venmo_adr_place_holder_text?>" id="venmo_address"  name="venmo_address" autocomplete="nope" value="<?=$venmo_address?>">
					<div id="venmo_address_error_msg" class="invalid-feedback text-center m_validations_showhide" style="display:none;"></div>
                </div>
				
                <button type="submit" class="btn btn-primary btn-lg rounded-pill payment_submit_btn">Continue</button>
            </div>
			<?php
			}
			if($choosed_payment_option['amazon_gcard']=="amazon_gcard") { ?>
			<div class="amazon_gcard-fields tab-pane fade <?php if($default_payment_option=="amazon_gcard"){echo 'show active';}?>" id="amazon_gcard" role="tabpanel" aria-labelledby="amazon_gcard-tab">
			  <p><?=$payment_instruction['amazon_gcard']?></p>
                <div class="form-group">
					<input type="text" class="form-control" placeholder="<?=$cart_payment_method_amazon_gcard_adr_place_holder_text?>" id="amazon_gcard_address"  name="amazon_gcard_address" autocomplete="nope" value="<?=$amazon_gcard_address?>">
					<div id="amazon_gcard_address_error_msg" class="invalid-feedback text-center m_validations_showhide" style="display:none;"></div>
                </div>
				
                <button type="submit" class="btn btn-primary btn-lg rounded-pill payment_submit_btn">Continue</button>
            </div>
			<?php
			}
			if($choosed_payment_option['cash']=="cash") { ?>
			<div class="cash-fields tab-pane fade <?php if($default_payment_option=="cash"){echo 'show active';}?>" id="cash" role="tabpanel" aria-labelledby="cash-tab">
			  <p><?=$payment_instruction['cash']?></p>
                <div class="form-group">
					<input type="text" class="form-control" id="cash_name" name="cash_name" placeholder="<?=$cart_payment_method_cash_name_place_holder_text?>" value="<?=$cash_name?>">
					<div id="cash_name_error_msg" class="invalid-feedback text-center m_validations_showhide" style="display:none;"></div>
                </div>
                <div class="form-group">
					<input type="tel" class="form-control" id="cash_phone" name="cash_phone" <?php /*?>placeholder="<?=$cart_payment_method_cash_phone_place_holder_text?>"<?php */?>>
					<input type="hidden" name="f_cash_phone" id="f_cash_phone" />
					<div id="cash_phone_error_msg" class="invalid-feedback text-center m_validations_showhide" style="display:none;"></div>
                </div>
				
                <button type="submit" class="btn btn-primary btn-lg rounded-pill payment_submit_btn">Continue</button>
            </div>
			<?php
			}
			if($choosed_payment_option['zelle']=="zelle") { ?>
			<div class="zelle-fields tab-pane fade <?php if($default_payment_option=="zelle"){echo 'show active';}?>" id="zelle" role="tabpanel" aria-labelledby="zelle-tab">
			  <p><?=$payment_instruction['zelle']?></p>
                <div class="form-group">
					<input type="email" class="form-control" id="zelle_address" name="zelle_address" placeholder="<?=$cart_payment_method_zelle_adr_place_holder_text?>" value="<?=$zelle_address?>">
					<div id="zelle_address_error_msg" class="invalid-feedback text-center m_validations_showhide" style="display:none;"></div>
                </div>
				
                <button type="submit" class="btn btn-primary btn-lg rounded-pill payment_submit_btn">Continue</button>
            </div>
			<?php
			}
			
			if($choosed_payment_option['cash_app']=="cash_app") { ?>
			<div class="cash_app-fields tab-pane fade <?php if($default_payment_option=="cash_app"){echo 'show active';}?>" id="cash_app" role="tabpanel" aria-labelledby="cash_app-tab">
			  <p><?=$payment_instruction['cash_app']?></p>
                <div class="form-group">
					<input type="text" class="form-control" placeholder="<?=$cart_payment_method_cash_app_adr_place_holder_text?>" id="cash_app_address"  name="cash_app_address" autocomplete="nope" value="<?=$cash_app_address?>">
					<div id="cash_app_address_error_msg" class="invalid-feedback text-center m_validations_showhide" style="display:none;"></div>
                </div>
				
                <button type="submit" class="btn btn-primary btn-lg rounded-pill payment_submit_btn">Continue</button>
            </div>
			<?php
			}
			if($choosed_payment_option['apple_pay']=="apple_pay") { ?>
			<div class="apple_pay-fields tab-pane fade <?php if($default_payment_option=="apple_pay"){echo 'show active';}?>" id="apple_pay" role="tabpanel" aria-labelledby="apple_pay-tab">
			  <p><?=$payment_instruction['apple_pay']?></p>
                <div class="form-group">
					<input type="text" class="form-control" placeholder="<?=$cart_payment_method_apple_pay_adr_place_holder_text?>" id="apple_pay_address"  name="apple_pay_address" autocomplete="nope" value="<?=$apple_pay_address?>">
					<div id="apple_pay_address_error_msg" class="invalid-feedback text-center m_validations_showhide" style="display:none;"></div>
                </div>
				
                <button type="submit" class="btn btn-primary btn-lg rounded-pill payment_submit_btn">Continue</button>
            </div>
			<?php
			}
			if($choosed_payment_option['google_pay']=="google_pay") { ?>
			<div class="google_pay-fields tab-pane fade <?php if($default_payment_option=="google_pay"){echo 'show active';}?>" id="google_pay" role="tabpanel" aria-labelledby="google_pay-tab">
			  <p><?=$payment_instruction['google_pay']?></p>
                <div class="form-group">
					<input type="text" class="form-control" placeholder="<?=$cart_payment_method_google_pay_adr_place_holder_text?>" id="google_pay_address"  name="google_pay_address" autocomplete="nope" value="<?=$google_pay_address?>">
					<div id="google_pay_address_error_msg" class="invalid-feedback text-center m_validations_showhide" style="display:none;"></div>
                </div>
				
                <button type="submit" class="btn btn-primary btn-lg rounded-pill payment_submit_btn">Continue</button>
            </div>
			<?php
			}
			if($choosed_payment_option['coinbase']=="coinbase") { ?>
			<div class="coinbase-fields tab-pane fade <?php if($default_payment_option=="coinbase"){echo 'show active';}?>" id="coinbase" role="tabpanel" aria-labelledby="coinbase-tab">
			  <p><?=$payment_instruction['coinbase']?></p>
                <div class="form-group">
					<input type="text" class="form-control" placeholder="<?=$cart_payment_method_coinbase_adr_place_holder_text?>" id="coinbase_address"  name="coinbase_address" autocomplete="nope" value="<?=$coinbase_address?>">
					<div id="coinbase_address_error_msg" class="invalid-feedback text-center m_validations_showhide" style="display:none;"></div>
                </div>
				
                <button type="submit" class="btn btn-primary btn-lg rounded-pill payment_submit_btn">Continue</button>
            </div>
			<?php
			}
			if($choosed_payment_option['facebook_pay']=="facebook_pay") { ?>
			<div class="facebook_pay-fields tab-pane fade <?php if($default_payment_option=="facebook_pay"){echo 'show active';}?>" id="facebook_pay" role="tabpanel" aria-labelledby="facebook_pay-tab">
			  <p><?=$payment_instruction['facebook_pay']?></p>
                <div class="form-group">
					<input type="text" class="form-control" placeholder="<?=$cart_payment_method_facebook_pay_adr_place_holder_text?>" id="facebook_pay_address"  name="facebook_pay_address" autocomplete="nope" value="<?=$facebook_pay_address?>">
					<div id="facebook_pay_address_error_msg" class="invalid-feedback text-center m_validations_showhide" style="display:none;"></div>
                </div>
				
                <button type="submit" class="btn btn-primary btn-lg rounded-pill payment_submit_btn">Continue</button>
            </div>
			<?php
			} ?>
          </div>
		  </form>
        </div>

		<div class="modal-body text-center terms_form_section" style="display:none;">
		  <form action="<?=SITE_URL?>controllers/cart/confirm.php" method="post" onSubmit="return confirm_sale_validation(this);">
			<?php
			if($is_confirm_sale_terms) { ?>
			<div class="form-group" style="text-align:center;">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" name="cs_terms_conditions" id="p_cs_terms_conditions" value="1"/>
					<label class="custom-control-label" for="p_cs_terms_conditions">I accept <a href="javascript:void(0)" class="help-icon click_terms_of_website_use">Terms and Condition</a></label>
				</div>
				<div id="p_cs_terms_conditions_error_msg" class="invalid-feedback text-center m_validations_showhide" style="display:none;"></div>
			</div>
			<?php
			} else {
				echo '<input type="hidden" name="cs_terms_conditions" id="p_cs_terms_conditions" value="1"/>';
			} ?>
			<button type="button" class="btn btn-lg btn-outline-dark rounded-pill mr-lg-3 bk_shipping_form">Back</button>
			<button type="submit" class="btn btn-primary btn-lg rounded-pill confirm_sale_btn" name="confirm_sale_btn">Place Order</button>
			<input type="hidden" name="confirm_sale" value="yes"/>
			<input type="hidden" name="num_of_item" id="num_of_item" value="<?=count($order_item_ids);?>"/>
		  </form>
        </div>

      </div>
    </div>
  </div>
  
<script>
function getPromoCode()
{
	var promo_code = document.getElementById('promo_code').value.trim();
	if(promo_code=="") {
		jQuery("#promo_code").focus();
		return false;
	}

	post_data = "promo_code="+promo_code+"&amt=<?=$sum_of_orders?>&order_id=<?=$order_id?>&token=<?=unique_id()?>";
	jQuery(document).ready(function($) {
		jQuery("#apl_promo_spining_icon").html('<i class="fa fa-spinner fa-spin" style="font-size:16px;"></i>');
		$.ajax({
			type: "POST",
			url:"<?=SITE_URL?>ajax/promocode_verify.php",
			data:post_data,
			success:function(data) {
				$("#apl_promo_spining_icon").html('');
				if(data!="") {
					var resp_data = JSON.parse(data);
					if(resp_data.msg!="" && resp_data.mode == "expired") {
						$("#promo_code").val('');
						$("#showhide_promocode_row").hide();
						$("#promocode_id").val('');
						$("#promocode_value").val('');
						
						$(".showhide_promocode_msg").show();
						$(".promocode_msg").html('<div class="alert alert-warning alert-dismissable d-inline-block">'+resp_data.msg+'</div>');
					} else {
						$("#promocode_removed").show();
						$(".showhide_promocode_msg").hide();
						$(".promocode_msg").html('');
						$("#showhide_promocode_row").show();
						if(resp_data.coupon_type=='percentage') {
							$("#promocode_amt_label").html("("+resp_data.percentage_amt+"%)");
							$("#promocode_amt").html(resp_data.discount_of_amt);
						} else {
							$("#promocode_amt_label").html("");
							$("#promocode_amt").html(resp_data.discount_of_amt);
						}
						$("#promocode_id").val(resp_data.promocode_id);
						$("#promocode_value").val(resp_data.promocode_value);
						
						$("#apl_promo_code").attr("disabled", true);
						$("#promo_code").attr("readonly", true);
						$("#apl_promo_code").hide();
						check_update_cart();
					}
				}
			}
		});
	});
}

function check_shipping_form() {
	jQuery(".m_validations_showhide").hide();
	if(document.getElementById("shipping_first_name").value.trim()=="") {
		jQuery("#shipping_first_name_error_msg").show().text('Enter shipping first name');
		return false;
	} else if(document.getElementById("shipping_last_name").value.trim()=="") {
		jQuery("#shipping_last_name_error_msg").show().text('Enter shipping last name');
		return false;
	}
	
	var telInput = jQuery("#shipping_phone");
	jQuery("#shipping_phone_c_code").val(telInput.intlTelInput("getSelectedCountryData").dialCode);
	if(!telInput.intlTelInput("isValidNumber")) {
		jQuery("#shipping_phone_error_msg").show().text('Enter valid shipping phone');
		return false;
	}

	if(document.getElementById("shipping_address").value.trim()=="") {
		jQuery("#shipping_address_error_msg").show().text('Enter shipping address');
		return false;
	} else if(document.getElementById("shipping_city").value.trim()=="") {
		jQuery("#shipping_city_error_msg").show().text('Enter shipping city');
		return false;
	} else if(document.getElementById("shipping_state").value.trim()=="") {
		jQuery("#shipping_state_error_msg").show().text('Enter shipping state');
		return false;
	} else if(document.getElementById("shipping_postcode").value.trim()=="") {
		jQuery("#shipping_postcode_error_msg").show().text('Enter shipping zip code');
		return false;
	} else if(document.getElementById("shipping_phone").value.trim()=="") {
		jQuery("#shipping_phone_error_msg").show().text('Enter shipping phone');
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
	} else if(shipping_method == "we_come_for_you") {
		var is_exist_demand_pickup_zipcode = jQuery("#is_exist_demand_pickup_zipcode").val().trim();
		if(!is_exist_demand_pickup_zipcode) {
			jQuery("#shipping_method_error_msg").show().text('On Demand pickup not available to this location.');
			return false;
		}
	}
}

function check_payment_form() {
	var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
	jQuery(".m_validations_showhide").hide();				
	var payment_method = jQuery(".r_payment_method").val();

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

		var telInput2 = jQuery("#cash_phone");
		var c_cash_phone = telInput2.intlTelInput("getNumber");
		jQuery("#f_cash_phone").val(c_cash_phone);
		//jQuery("#sms_notif_phone").html('<a href="tel:'+c_cash_phone+'">'+c_cash_phone+'</a>');

		var cash_phone = document.getElementById("cash_phone").value.trim();
		if(cash_phone=="") {
			jQuery("#cash_phone_error_msg").show().text('Please enter phone');
			return false;
		} else if(!telInput2.intlTelInput("isValidNumber")) {
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

function check_form() {
	jQuery(".m_validations_showhide").hide();				
	var p_cs_terms_conditions = document.getElementById('p_cs_terms_conditions').checked;
	if(p_cs_terms_conditions == false) {
		jQuery("#p_cs_terms_conditions_error_msg").show().text('Please accept terms & conditions.');
		return false;
	}
}

$(".bank-fields, .paypal-fields, .zelle-fields, .cash-fields, .venmo-fields, .amazon_gcard-fields, .cash_app-fields, .apple_pay-fields, .google_pay-fields, .coinbase-fields, .facebook_pay-fields").on('blur keyup change paste', 'input, select, textarea', function(event) {
	check_payment_form();
});

function confirm_sale_validation() {
	var ok = check_form();
	if(ok == false) {
		return false;
	} else {
		jQuery("#place_order_spining_icon").html('<div class="spining-full-wrap"><div class="spining-icon"><i class="fa fa-spinner fa-spin"></i></div></div>');
		jQuery("#place_order_spining_icon").show();
		jQuery(".confirm_sale_btn").attr("disabled", true);

		/*var ok = confirm("Are you sure you want to submit order?");
		if(ok == false) {
			return false;
		}*/
	}
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

(function( $ ) {
	$(function() {
		
		var telInput3 = $("#cash_phone");
		telInput3.intlTelInput({
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
		$("#cash_phone").intlTelInput("setNumber", "<?=($cash_phone?'+'.$shipping_country_code.$cash_phone:'')?>");

		var telInput2 = $("#shipping_phone");
		telInput2.intlTelInput({
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
		$("#shipping_phone").intlTelInput("setNumber", "<?=($shipping_phone?'+'.$shipping_country_code.$shipping_phone:'')?>");

		$("#shipping_form").on('blur keyup change paste', 'input, select, textarea', function(event) {
			check_shipping_form();
		});
		$(".shipping_submit_btn").click(function() {
			var ok = check_shipping_form();
			if(ok == false) {
				return false;
			}

			<?php
			if($is_confirm_sale_terms) { ?>
			$(".shipping_form_section").hide();
			$(".terms_form_section").show();
			$(".shipping_payment_label").html('<?=$cart_terms_and_conditions_title?>');
			$(".address_label").html('');
			<?php
			} else { ?>
			$("#place_order_spining_icon").html('<div class="spining-full-wrap"><div class="spining-icon"><i class="fa fa-spinner fa-spin"></i></div></div>');
			$("#place_order_spining_icon").show();
			<?php
			} ?>

			$.ajax({
				type: 'POST',
				url: '<?=SITE_URL?>ajax/order_shipping_method.php',
				data: $('#shipping_form').serialize(),
				success: function(data) {
					var resp_data = JSON.parse(data);
					console.log(resp_data);
					if(resp_data.success == true) {
						<?php
						if(!$is_confirm_sale_terms) {
							echo "$('#shipping_form').submit();";
						} ?>
					}
				}
			});
			return false;
		});

		$(".bk_payment_form").click(function() {
			$(".shipping_form_section").hide();
			$(".payment_form_section").show();
			$(".shipping_payment_label").html('<?=$cart_payment_method_title?>');
			$(".address_label").html('');
		});

		$(".payment_submit_btn").click(function() {
			var ok = check_payment_form();
			if(ok == false) {
				return false;
			}
			
			$(".shipping_form_section").show();
			$(".payment_form_section").hide();
			$(".shipping_payment_label").html('<?=$cart_shipping_method_title?>');
			$(".address_label").html('Return Address Information');
			
			$.ajax({
				type: 'POST',
				url: '<?=SITE_URL?>ajax/order_payment_method.php',
				data: $('#payment_form').serialize(),
				success: function(data) {
					if(data!="") {
						var resp_data = JSON.parse(data);
						console.log(resp_data);
						if(resp_data.success == true) {
						<?php
						/*if(!$is_confirm_sale_terms) {
							echo "$('#payment_form').submit();";
						}*/ ?>
						}
					}
				}
			});
			return false;
		});

		$(".bk_shipping_form").click(function() {
			$(".shipping_form_section").show();
			$(".terms_form_section").hide();
			$(".shipping_payment_label").html('<?=$cart_shipping_method_title?>');
			$(".address_label").html('');
		});

		$("#bank-tab").click(function() {
			$(".r_payment_method").val('bank');
		});
		$("#paypal-tab").click(function() {
			$(".r_payment_method").val('paypal');
		});
		$("#cheque-tab").click(function() {
			$(".r_payment_method").val('cheque');
		});
		$("#zelle-tab").click(function() {
			$(".r_payment_method").val('zelle');
		});
		$("#cash-tab").click(function() {
			$(".r_payment_method").val('cash');
		});
		$("#venmo-tab").click(function() {
			$(".r_payment_method").val('venmo');
		});
		$("#amazon_gcard-tab").click(function() {
			$(".r_payment_method").val('amazon_gcard');
		});
		$("#cash_app-tab").click(function() {
			$(".r_payment_method").val('cash_app');
		});
		$("#apple_pay-tab").click(function() {
			$(".r_payment_method").val('apple_pay');
		});
		$("#google_pay-tab").click(function() {
			$(".r_payment_method").val('google_pay');
		});
		$("#coinbase-tab").click(function() {
			$(".r_payment_method").val('coinbase');
		});
		$("#facebook_pay-tab").click(function() {
			$(".r_payment_method").val('facebook_pay');
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

		$("#promocode_removed").click(function() {
			$("#promo_code").val('');
			$("#showhide_promocode_row").hide();
			$("#promocode_id").val('');
			$("#promocode_value").val('');
			$("#apl_promo_code").attr("disabled", false);
			$("#promo_code").attr("readonly", false);
			$("#apl_promo_code").show();
			check_update_cart();
			$(this).hide();
		});

		$("#promo_code").on('keyup',function() {
			var promo_code = document.getElementById('promo_code').value.trim();
			if(promo_code!="") {
				$(".showhide_promocode_msg").hide();
				$(".promocode_msg").html('');
			}
		});
		
		$("#shipping_postcode").on('keyup',function() {
			var postcode = $(this).val();
			if(postcode) {
				check_demand_pickup_zipcode(postcode);
			}
		});
		
		<?php
		if($guest_user_id > 0) { ?>
		$("#paypal_address").on('keyup',function() {
			var paypal_address = $(this).val();
			$.ajax({
				type: 'POST',
				url: '<?=SITE_URL?>ajax/check_paypal_address.php',
				data: {email:paypal_address},
				success: function(data) {
					if(data!="") {
						var resp_data = JSON.parse(data);
						if(resp_data.msg!="" && resp_data.exist == true) {
							$("#exist_paypal_address_msg").show();
							$("#exist_paypal_address_msg").html(resp_data.msg);
							$(".confirm_sale_btn").attr("disabled", true);
						} else {
							$("#exist_paypal_address_msg").hide();
							$("#exist_paypal_address_msg").html('');
							$(".confirm_sale_btn").attr("disabled", false);
						}
					}
				}
			});
		});
		$(document).on('click', '.paypal_address_login', function() {
			$("#ShippingFields").modal('hide');
			$("#SignInRegistration").modal();
		});
		<?php
		}

		if($open_shipping_popup) {
			echo '$("#ShippingFields").modal();';
		} ?>
	});
})(jQuery);

function check_demand_pickup_zipcode(postcode) {
	jQuery(document).ready(function($) {
		$.ajax({
			type: 'POST',
			url: '<?=SITE_URL?>ajax/check_demand_pickup_zipcode.php',
			data: {postcode:postcode},
			success: function(data) {
				if(data!="") {
					var resp_data = JSON.parse(data);
					if(resp_data.msg!="" && resp_data.exist == true) {
						$("#is_exist_demand_pickup_zipcode").val(postcode);
					} else {
						$("#is_exist_demand_pickup_zipcode").val('');
					}
				}
			}
		});
	});
}

<?php
if($shipping_postcode) { ?>
check_demand_pickup_zipcode('<?=$shipping_postcode?>');
<?php
} ?>

function check_update_cart() {
	jQuery(document).ready(function($){
		$.ajax({
			type: 'POST',
			url: '<?=SITE_URL?>ajax/upt_promo_bonus.php',
			data: $('#revieworder_form').serialize(),
			success: function(data) {
				if(data!="") {
					var resp_data = JSON.parse(data);
					console.log(resp_data);
					return false;
				}
			}
		});
	});
}
check_update_cart();
</script>