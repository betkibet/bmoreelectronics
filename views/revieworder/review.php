<div id="breadcrumb">
	<div class="wrap">
		<ul>
			<li><a href="<?=SITE_URL?>">Home</a></li>
			<li><a href="<?=SITE_URL?>">Add Items</a></li>
			<li class="active"><a href="<?=SITE_URL?>revieworder">Review Order</a></li>
		</ul>
	</div>
</div>

<div id="main" class="reviewsale">

	<section id="model-steps" class="sectionbox white-bg clearfix">
	  <div class="wrap">
		<div class="content-block">
			<?php
			//Order steps
			$order_steps = 2;
			include("include/steps.php"); ?>
		</div>
	  </div>
	</section>
	
	<form action="controllers/revieworder/review.php" method="post">
	<section id="model-steps-select" class="sectionbox white-bg clearfix">
	  <div class="wrap">
		<div class="row phone-details modern-style-image">
		  <div class="col-md-12 phone-details-height">
				<div class="clearfix">
				  <div class="heading">
					<div class="h2"><strong>Review Your Sale</strong></div>
					<p>Please click on the <a href="<?=SITE_URL?>enterdetails"><strong>Complete Sale</strong></a> button to complete sale.</p>
				  </div>
				  <div class="price_box mb-sm-2">
				  	<strong class="price"><?=amount_fomat($sum_of_orders)?></strong>
				  </div>
				</div>

				<div id="review-sale-table" class="clearfix">
					<div class="table-responsive table-bordered">          
					  <table class="table">
						<thead>
						  <tr>
							<th class="imgbox">Image</th>
							<th class="divice-type">Handset/Device Type</th>
							<th class="quantity">Quantity</th>
							<th class="value">Price</th>
							<th class="subtotal">Subtotal</th>
							<th >&nbsp;</th>
						  </tr>
						</thead>
						<tbody>
						<?php
						$tid=1;
						foreach($order_item_list as $order_item_list_data) {
							//path of this function (get_order_item) admin/include/functions.php
							$order_item_data = get_order_item($order_item_list_data['id'],'list'); ?>
								<tr>
									<td>
										<div class="device_img">
										<?php
										if($order_item_list_data['model_img']) {
											echo '<img src="'.SITE_URL.'images/mobile/'.$order_item_list_data['model_img'].'" class="img-fluid"/>';
										} ?>
										</div>
									</td>
									<td>
										<div class="device_name"><?=$order_item_list_data['model_title']?></div>
										<div class="description_text">
											<a href="javascript:void(0)" class="description_link">Description <span></span></a>
											<div class="more_discript_box">
												<p><?=$order_item_data['device_type']?></p>
											</div>
										</div>
									</td>
									<td>
										<div class="input_box">
											<input type="number" class="textbox" min="1" max="10" id="qty-<?=$tid?>" name="qty[<?=$order_item_list_data['id']?>]" value="<?=$order_item_list_data['quantity']?>" autocomplete="nope">
										</div>
									</td>
									<td>
										<div class="value_box">
											<?=amount_fomat(($order_item_list_data['price'] / $order_item_list_data['quantity']))?>
										</div>
									</td>
									<td>
										<div class="subtotal_box">
											<?=amount_fomat($order_item_list_data['price'])?>
										</div>
									</td>
									<td>
										<div class="remove_row">
											<a href="controllers/revieworder/review.php?rorder_id=<?=$order_item_list_data['id']?>" onclick="return confirm('Are you sure you want to remove this item?');" class="remove">x</a>
										</div>
									</td>
								</tr>
							<?php
							$tid++;
							} ?>
						  
							<tr>
								<td colspan="6">
									<div class="tftotal_box">Sell Order Total<span class="price_total"><?=amount_fomat($sum_of_orders)?></span></div>
								</td>
							</tr>
						</tbody>
					  </table>
					</div>
				</div>
                
                <div class="row">
                	<div class="col-sm-12 mt20 text-right"><button type="submit" class="btn btn_md btn-blue-bg" name="update_cart" id="update_cart" onclick="return check_update_cart();">Update Cart</button></div>
                </div>
				
				<div class="row clearfix">
					<div class="col-sm-8">
						<div id="payment_box">
							<?php
							if($choosed_payment_option['bank']=="bank") { ?>
								<div class="head_row bank_transfer_head pmnt_bank_opt <?php if($default_payment_option=="bank"){echo 'active';}?>">
									<span class="round_box">&nbsp;</span>
									<span class="icon">i</span>
									<span class="title">Bank Transfer</span>
									<?php /*?><span class="price"><?=amount_fomat($sum_of_orders)?></span><?php */?>
								</div>
								<div class="detail_row bank_transfer_detail clearfix <?php if($default_payment_option=="bank"){echo 'active';}?>">
									<div class="inner_box row">
										<div class="form_group col-sm-4">
											<label>Account Holder Name</label>
											<input type="text" class="textbox" id="act_name" name="act_name" placeholder="Account Holder Name" value="<?=$order_data['act_name']?>" autocomplete="off">
										</div>
										<div class="form_group col-sm-4">
											<label>Account Number</label>
											<input type="text" class="textbox" id="act_number" name="act_number" placeholder="Account Number" value="<?=$order_data['act_number']?>" autocomplete="off">
										</div>
										<div class="form_group col-sm-4">
											<label>Short Code</label>
											<input type="text" class="textbox" id="act_short_code" name="act_short_code" placeholder="Short Code" value="<?=$order_data['act_short_code']?>" autocomplete="off">
										</div>
									</div>
								</div>
							<?php
							}
							if($choosed_payment_option['cheque']=="cheque") { ?>
								<div class="head_row cheque_head pmnt_cheque_opt <?php if($default_payment_option=="cheque"){echo 'active';}?>">
									<span class="round_box">&nbsp;</span>
									<span class="icon">i</span>
									<span class="title">Cheque</span>
									<?php /*?><span class="price"><?=amount_fomat($sum_of_orders)?></span><?php */?>
								</div>
								<div class="detail_row cheque_detail clearfix <?php if($default_payment_option=="cheque"){echo 'active';}?>">
									<div class="inner_box row">
										<div class="form_group col-sm-4">
											<label>Name</label>
											<input type="text" class="textbox" id="chk_name" name="chk_name" placeholder="Name" value="<?=$order_data['chk_name']?>" autocomplete="off">
										</div>
										<div class="form_group col-sm-4">
											<label>Street Address</label>
											<input type="text" class="textbox" id="chk_street_address" name="chk_street_address" placeholder="Street Address" value="<?=$order_data['chk_street_address']?>" autocomplete="off">
										</div>
										<div class="form_group col-sm-4">
											<label>Street Address Line2</label>
											<input type="text" class="textbox" placeholder="Street Address Line2" id="chk_street_address_2" name="chk_street_address_2" value="<?=$order_data['chk_street_address_2']?>" autocomplete="off">
										</div>
									</div>
									<div class="inner_box row">
										<div class="form_group col-sm-4">
											<label>City</label>
											<input type="text" class="textbox" name="chk_city" id="chk_city" placeholder="City" value="<?=$order_data['chk_city']?>" autocomplete="off">
										</div>
										<div class="form_group col-sm-4">
											<label>State</label>
											<input type="text" class="textbox" name="chk_state" id="chk_state" placeholder="State" value="<?=$order_data['chk_state']?>" autocomplete="off">
										</div>
										<div class="form_group col-sm-4">
											<label>Zip Code</label>
											<input type="text" class="textbox" placeholder="Zip Code" id="chk_zip_code" name="chk_zip_code" value="<?=$order_data['chk_zip_code']?>" autocomplete="off">
										</div>
									</div>
								</div>
							<?php
							}
							if($choosed_payment_option['paypal']=="paypal") { ?>
								<div class="head_row paypal_head pmnt_paypal_opt <?php if($default_payment_option=="paypal"){echo 'active';}?>">
									<span class="round_box">&nbsp;</span>
									<span class="icon">i</span>
									<span class="title">Paypal</span>
									<?php /*?><span class="price"><?=amount_fomat($sum_of_orders)?></span><?php */?>
								</div>
								<div class="detail_row paypal_detail clearfix <?php if($default_payment_option=="paypal"){echo 'active';}?>">
									<div class="inner_box row">
										<div class="form_group col-sm-6">
											<label>PayPal Address</label>
											<input type="text" class="textbox" placeholder="PayPal Address" id="paypal_address"  name="paypal_address" value="<?=$order_data['paypal_address']?>" autocomplete="off">
										</div>
										<div class="form_group col-sm-6">
											<label>Confirm PayPal Address</label>
											<input type="text" class="textbox" placeholder="Confirm PayPal Address" id="confirm_paypal_address"  name="confirm_paypal_address" value="<?=$order_data['paypal_address']?>" autocomplete="off">
										</div>
									</div>
								</div>
							<?php
							}
							
							if($choosed_payment_option['zelle']=="zelle") { ?>
								<div class="head_row zelle_head pmnt_zelle_opt <?php if($default_payment_option=="zelle"){echo 'active';}?>">
									<span class="round_box">&nbsp;</span>
									<span class="icon">i</span>
									<span class="title">Zelle</span>
									<?php /*?><span class="price"><?=amount_fomat($sum_of_orders)?></span><?php */?>
								</div>
								<div class="detail_row zelle_detail clearfix <?php if($default_payment_option=="zelle"){echo 'active';}?>">
									<div class="inner_box row">
										<div class="form_group col-sm-12">
											<label>Zelle Address</label>
											<input type="text" class="textbox" placeholder="Zelle Address" id="zelle_address"  name="zelle_address" value="<?=$order_data['zelle_address']?>" autocomplete="off">
										</div>
									</div>
								</div>
							<?php
							}
							if($choosed_payment_option['cashapp']=="cashapp") { ?>
								<div class="head_row cashapp_head pmnt_cashapp_opt <?php if($default_payment_option=="cashapp"){echo 'active';}?>">
									<span class="round_box">&nbsp;</span>
									<span class="icon">i</span>
									<span class="title">Cashapp</span>
									<?php /*?><span class="price"><?=amount_fomat($sum_of_orders)?></span><?php */?>
								</div>
								<div class="detail_row cashapp_detail clearfix <?php if($default_payment_option=="cashapp"){echo 'active';}?>">
									<div class="inner_box row">
										<div class="form_group col-sm-12">
											<label>Cashapp Address</label>
											<input type="text" class="textbox" placeholder="Cashapp Address" id="cashapp_address"  name="cashapp_address" value="<?=$order_data['cashapp_address']?>" autocomplete="off">
										</div>
									</div>
								</div>
							<?php
							}
							if($choosed_payment_option['venmo']=="venmo") { ?>
								<div class="head_row venmo_head pmnt_venmo_opt <?php if($default_payment_option=="venmo"){echo 'active';}?>">
									<span class="round_box">&nbsp;</span>
									<span class="icon">i</span>
									<span class="title">Venmo</span>
									<?php /*?><span class="price"><?=amount_fomat($sum_of_orders)?></span><?php */?>
								</div>
								<div class="detail_row venmo_detail clearfix <?php if($default_payment_option=="venmo"){echo 'active';}?>">
									<div class="inner_box row">
										<div class="form_group col-sm-12">
											<label>Venmo Address</label>
											<input type="text" class="textbox" placeholder="Venmo Address" id="venmo_address"  name="venmo_address" value="<?=$order_data['venmo_address']?>" autocomplete="off">
										</div>
									</div>
								</div>
							<?php
							}
							if($choosed_payment_option['google_pay']=="google_pay") { ?>
								<div class="head_row google_pay_head pmnt_google_pay_opt <?php if($default_payment_option=="google_pay"){echo 'active';}?>">
									<span class="round_box">&nbsp;</span>
									<span class="icon">i</span>
									<span class="title">Google Pay</span>
									<?php /*?><span class="price"><?=amount_fomat($sum_of_orders)?></span><?php */?>
								</div>
								<div class="detail_row google_pay_detail clearfix <?php if($default_payment_option=="google_pay"){echo 'active';}?>">
									<div class="inner_box row">
										<div class="form_group col-sm-12">
											<label>Google Pay Address</label>
											<input type="text" class="textbox" placeholder="Google Pay Address" id="google_pay_address"  name="google_pay_address" value="<?=$order_data['google_pay_address']?>" autocomplete="off">
										</div>
									</div>
								</div>
							<?php
							}
							if($choosed_payment_option['other']=="other") { ?>
								<div class="head_row other_head pmnt_other_opt <?php if($default_payment_option=="other"){echo 'active';}?>">
									<span class="round_box">&nbsp;</span>
									<span class="icon">i</span>
									<span class="title">Other</span>
									<?php /*?><span class="price"><?=amount_fomat($sum_of_orders)?></span><?php */?>
								</div>
								<div class="detail_row other_detail clearfix <?php if($default_payment_option=="other"){echo 'active';}?>">
									<div class="inner_box row">
										<div class="form_group col-sm-6">
											<label>Name of Method</label>
											<input type="text" class="textbox" placeholder="Name of Method" id="other_name_of_method"  name="other_name_of_method" value="<?=$order_data['other_name_of_method']?>" autocomplete="off">
										</div>
										<div class="form_group col-sm-6">
											<label>Account Details</label>
											<input type="text" class="textbox" placeholder="Account Details" id="other_account_details"  name="other_account_details" value="<?=$order_data['other_account_details']?>" autocomplete="off">
										</div>
									</div>
								</div>
							<?php
							}
							
							if($choosed_payment_option['cash']=="cash") { ?>
								<div class="head_row paypal_head pmnt_cash_opt <?php if($default_payment_option=="cash"){echo 'active';}?>">
									<span class="round_box">&nbsp;</span>
									<span class="icon">i</span>
									<span class="title">Cash</span>
									<?php /*?><span class="price"><?=amount_fomat($sum_of_orders)?></span><?php */?>
								</div>
							<?php
							} ?>
							
						</div><!--#payment_box-->
					</div>
					
					<div class="col-sm-4">
						<div id="total_price_box">
							<div class="top_part">
								Total Sale Value:<br>
								<span class="price_text"><?=amount_fomat($sum_of_orders)?></span>
							</div>
							<div class="but_sec">
								<a href="<?=$sell_my_mobile_link?>" class="btn more">More Handset</a>
								<button type="submit" class="btn btn-green" name="complete_sale" id="complete_sale" onclick="return check_form();">Complete Sale</button>
							</div>
						</div><!--#total_price_box-->
					</div>
				</div>
		  </div>
		</div>
	  </div>
	</section>
	<input id="payment_method" name="payment_method" value="<?=$default_payment_option?>" type="hidden">
	<input id="form_submit_type" name="form_submit_type" value="" type="hidden">
	</form>
</div>

<script>
$(document).ready(function(){
	$(".pmnt_bank_opt").click(function() {
		$("#payment_method").val('bank');
	});
	$(".pmnt_cheque_opt").click(function() {
		$("#payment_method").val('cheque');
	});
	$(".pmnt_paypal_opt").click(function() {
		$("#payment_method").val('paypal');
	});
	$(".pmnt_cash_opt").click(function() {
		$("#payment_method").val('cash');
	});
	
	$(".pmnt_zelle_opt").click(function() {
		$("#payment_method").val('zelle');
	});
	$(".pmnt_cashapp_opt").click(function() {
		$("#payment_method").val('cashapp');
	});
	$(".pmnt_venmo_opt").click(function() {
		$("#payment_method").val('venmo');
	});
	$(".pmnt_google_pay_opt").click(function() {
		$("#payment_method").val('google_pay');
	});
	$(".pmnt_other_opt").click(function() {
		$("#payment_method").val('other');
	});
	
});

function check_form() {
	var payment_method = document.getElementById("payment_method").value;
	if(payment_method=="bank") {
		if(document.getElementById("act_name").value.trim()=="") {
			alert('Please enter account holder name');
			return false;
		} else if(document.getElementById("act_number").value.trim()=="") {
			alert('Please enter account number');
			return false;
		} else if(document.getElementById("act_short_code").value.trim()=="") {
			alert('Please enter short code');
			return false;
		}
	} else if(payment_method=="cheque") {
		if(document.getElementById("chk_name").value.trim()=="") {
			alert('Please enter check name');
			return false;
		} else if(document.getElementById("chk_street_address").value.trim()=="") {
			alert('Please enter address');
			return false;
		} else if(document.getElementById("chk_city").value.trim()=="") {
			alert('Please enter city');
			return false;
		} else if(document.getElementById("chk_state").value.trim()=="") {
			alert('Please enter state');
			return false;
		} else if(document.getElementById("chk_zip_code").value.trim()=="") {
			alert('Please enter zip code');
			return false;
		}
	} else if(payment_method=="paypal") {
		if(document.getElementById("paypal_address").value.trim()=="") {
			alert('Please enter paypal address');
			return false;
		} else if(document.getElementById("confirm_paypal_address").value.trim()=="") {
			alert('Please enter confirm paypal address');
			return false;
		} else if(document.getElementById("paypal_address").value.trim()!=document.getElementById("confirm_paypal_address").value.trim()) {
			alert('Does not match paypal address and confirm paypal address');
			return false;
		}
	}
	
	 else if(payment_method=="zelle") {
		if(document.getElementById("zelle_address").value.trim()=="") {
			alert('Please enter zelle address');
			return false;
		}
	} else if(payment_method=="cashapp") {
		if(document.getElementById("cashapp_address").value.trim()=="") {
			alert('Please enter cashapp address');
			return false;
		}
	} else if(payment_method=="venmo") {
		if(document.getElementById("venmo_address").value.trim()=="") {
			alert('Please enter venmo address');
			return false;
		}
	} else if(payment_method=="google_pay") {
		if(document.getElementById("google_pay_address").value.trim()=="") {
			alert('Please enter google pay address');
			return false;
		}
	} else if(payment_method=="other") {
		if(document.getElementById("other_name_of_method").value.trim()=="") {
			alert('Please enter other name of method');
			return false;
		} else if(document.getElementById("other_account_details").value.trim()=="") {
			alert('Please enter other account details');
			return false;
		}
	}
}

function check_update_cart() {
	$("#form_submit_type").val('update_cart');
	return true;
}
</script>