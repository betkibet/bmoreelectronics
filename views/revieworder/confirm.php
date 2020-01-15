  <div id="breadcrumb">
	<div class="wrap">
		<ul>
			<li><a href="<?=SITE_URL?>">Home</a></li>
			<li><a href="<?=SITE_URL?>">Add Items</a></li>
			<li><a href="<?=SITE_URL?>revieworder">Review Order</a></li>
			<li><a href="<?=SITE_URL?>enterdetails">Checkout</a></li>
			<li class="active"><a href="#">Confirm Order</a></li>
		</ul>
	</div>
  </div>
  
  <!-- Main -->
  <div id="main" class="completesale">
    
    <!-- Select Your Device -->
    <section id="model-steps" class="sectionbox white-bg clearfix">
      <div class="wrap">
        <div class="content-block">
          <?php
		  //Order steps
		  $order_steps = 4;
		  include("include/steps.php"); ?>
        </div>
      </div>
    </section>
    
    <form action="controllers/revieworder/confirm.php" method="post" onSubmit="return confirm_sale_validation(this);">
    <section id="completesale_sec" class="sectionbox white-bg clearfix">
      <div class="wrap">
        <h3 class="head"><span class="icon"></span>Complete Sale</h3>
        
        <div id="user_patment_detail" class="clearfix">
          <div class="row">
            <div class="col-sm-4 user_detail">
              <div class="inner_box">
              	<a href="javascript:void(0)" type="btn" data-toggle="modal" data-target="#EditAddress" class="edit_but">Edit</a>
                <h5><?=$user_data['name']?></h5>
                <p class="address"> <?=($user_data['address']?$user_data['address'].',<br />':'').($user_data['address2']?$user_data['address2'].',<br />':'').($user_data['state']?$user_data['state'].', ':'').($user_data['city']?$user_data['city'].' ':'').$user_data['postcode']?> </p>
				<?php
			    if($user_data['phone']) {
				   echo '<p class="tphone">Telephone: '.$user_data['phone'].'</p>';
			    } ?>
              </div>
            </div>
            <div class="col-sm-4 patment_detail">
              <div class="inner_box">
              	<?php /*?><a href="#" class="edit_but">Edit</a><?php */?>
                <h5>Payment Details</h5>
                <p class="payment_title"> Your payment Method : <?=replace_us_to_space($order_data['payment_method'])?> </p>
                <p class="payment_type">
					<?php
					if($order_data['payment_method']=="cheque") { ?>
						<strong>Check Name:</strong> <span class="text-pink"><?=$order_data['chk_name']?></span><br />
						<?=$order_data['chk_street_address'].'<br />'.$order_data['chk_street_address_2'].'<br />'.$order_data['chk_city'].'<br>'.$order_data['chk_state'].'<br>'.$order_data['chk_zip_code']?>
					<?php
					} elseif($order_data['payment_method']=="bank") { ?>
						<strong>Account Name:</strong> <span class="text-pink"><?=$order_data['act_name']?></span><br />
						<strong>Account Number:</strong> <span class="text-pink"><?=$order_data['act_number']?></span><br />
						<strong>Short Code:</strong> <span class="text-pink"><?=$order_data['act_short_code']?></span>
					<?php
					} elseif($order_data['payment_method']=="paypal") { ?>
						<strong>Paypal Address:</strong> <span class="text-pink"><?=$order_data['paypal_address']?></span>
					<?php
					} elseif($order_data['payment_method']=="zelle") { ?>
						<strong>Zelle Address:</strong> <span class="text-pink"><?=$order_data['zelle_address']?></span>
					<?php
					} elseif($order_data['payment_method']=="cashapp") { ?>
						<strong>Cashapp Address:</strong> <span class="text-pink"><?=$order_data['cashapp_address']?></span>
					<?php
					} elseif($order_data['payment_method']=="venmo") { ?>
						<strong>Venmo Address:</strong> <span class="text-pink"><?=$order_data['venmo_address']?></span>
					<?php
					} elseif($order_data['payment_method']=="google_pay") { ?>
						<strong>Google Pay Address:</strong> <span class="text-pink"><?=$order_data['google_pay_address']?></span>
					<?php
					} elseif($order_data['payment_method']=="other") { ?>
						<strong>Name Of Method:</strong> <span class="text-pink"><?=$order_data['other_name_of_method']?></span><br />
						<strong>Account Details:</strong> <span class="text-pink"><?=$order_data['other_account_details']?></span><br />
					<?php
					} ?>
				</p>
              </div>
            </div>
          </div>
        </div>
        <!--#user_patment_detail-->
        
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
                  <th>&nbsp;</th>
                </tr>
              </thead>
              <tbody>
			  <?php
			  if($order_num_of_rows>0) {
				  $num_of_quantity = array();
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
							<input type="text" class="textbox" id="qty-<?=$tid?>" name="qty[<?=$order_item_list_data['id']?>]" value="<?=$order_item_list_data['quantity']?>" autocomplete="off" readonly="">
						</div>
					  </td>
					  <td>
					  	<?php /*?><div class="edit_link"><a href="#">Edit</a></div><?php */?>
						<div class="value_box">
							<?=amount_fomat(($order_item_list_data['price'] / $order_item_list_data['quantity']))?>
						</div>
					  </td>
					  <td><div class="subtotal_box"><?=amount_fomat($order_item_list_data['price'])?></div></td>
					  <td><div class="remove_row"><a href="" class="remove">x</a></div></td>
					</tr>
					<?php
					$num_of_quantity[] = $order_item_list_data['quantity'];
					}
				} else {
					setRedirect(SITE_URL);
					exit();
				} ?>
                <tr>
                  <td colspan="6">
				  	<div class="tftotal_box">Sell Order Total <span class="price_total"><?=amount_fomat($sum_of_orders)?></span></div>
					<div class="tftotal_box" id="showhide_promocode_row" style="display:none;">Surcharge <span class="price_total" id="promocode_amt"></span>&nbsp;<a href="javascript:void(0);" id="promocode_removed">X</a></div>
					<div class="tftotal_box" id="showhide_total_row">Total <span class="price_total" id="total_amt"><?=amount_fomat($sum_of_orders)?></span></div>
				  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div><!--#review-sale-table-->
        
        <div id="howLikeDevice" class="clearfix">
        	<h4>How would you like to send your device?</h4>
            <div class="row">
            	<!--<div class="col-sm-3 col-3">
                	<div class="inner postme">
                    	<input type="radio" name="shipping_method" id="shipping_method_send_me_label" value="send_me_label">
                    	<span class="icon">a</span>
                        <div class="text"> Post Me A <br><span>Prepaid Label</span></div>
                        <span class="icocircle"></span>
                    </div>
                </div>-->
                <div class="col-sm-3">
                	<div class="inner printme active">
                    	<input type="radio" name="shipping_method" id="shipping_method_own_print_label" value="own_print_label" checked="checked">
                    	<span class="icon">a</span>
                        <div class="text"> I'll Print A <br><span>Prepaid Label</span></div>
                        <span class="icocircle"></span>
                    </div>
                </div>
                <!--<div class="col-sm-3">
                	<div class="inner courierme">
                    	<input type="radio" name="shipping_method" id="shipping_method_own_courier" value="own_courier">
                    	<span class="icon">a</span>
                        <div class="text"> I'll Use My <br><span>Own Courier</span></div>
                        <span class="icocircle"></span>
                    </div>
                </div>-->
            </div>
        </div><!--#CouponCode-->
        
        <?php
		if($general_setting_data['promocode_section']=='1') { ?>
        <div id="CouponCode" class="clearfix">
        	<h4>Coupon Code</h4>
            <div class="row">
            	<div class="col-sm-6">
                	<div class="form_box success_box">
                    	<div class="input_box row">
                          <div class="col-sm-9"><input type="text" class="textbox" name="promo_code" id="promo_code" placeholder="Coupon Code" autocomplete="nope"></div>
                          <div class="col-sm-3"><button type="button" class="btn btn_md btn-green" name="apl_promo_code" id="apl_promo_code" onclick="getPromoCode();">Apply</button></div>
                        </div>
                    </div>
					<div class="showhide_promocode_msg" style="display:none;">
						<div class="promocode_msg"></div>
					</div>
                </div>
            </div>
        </div>
		<input type="hidden" name="promocode_id" id="promocode_id" value=""/>
		<input type="hidden" name="promocode_value" id="promocode_value" value=""/>
        <?php
		} ?>
        
        <?php
		if($general_setting_data['terms_status']=='1' && $display_terms_array['confirm_sale']=="confirm_sale") { ?>
        <div class="accepturms">
          <div class="checkbox checkbox-success">
            <label for="terms">
              <input class="checkboxele" name="terms" id="terms" type="checkbox">
              <span class="checkmark"></span> By cofirming your sale,you confirm that you have read and understood the <a href="javascript:void(0)" data-toggle="modal" data-target="#terms_of_website_use">Terms & Conditions of supply</a></label>
          </div>
        </div>
        <?php
		} else {
			echo '<input type="hidden" name="terms" id="terms" checked="checked"/>';
		} ?>
	
		<input type="hidden" name="num_of_item" id="num_of_item" value="<?=count($order_item_ids);?>"/>
	
        <div id="complete_butbox" class="clearfix">
        	<a href="<?=SITE_URL?>revieworder" class="btn btn_md btn-back-arrow">Back</a>
            <button class="btn but_confirm_sale" type="submit" name="confirm_sale" id="confirm_sale">Confirm Sale</button>
        </div>
		
      </div>
    </section>
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

<!-- Modal -->
<div class="modal fade common_popup" id="EditAddress" role="dialog">
    <div class="modal-dialog small_dialog">
      <!-- Modal content-->
      <div class="modal-content">
      	<button type="button" class="close" data-dismiss="modal">&times;</button>
        <div class="modal-body">
            <h3>Shipping Address (Edit)</h3>
			<form action="controllers/revieworder/confirm.php" method="post" id="chg_address_form">
            <div class="clearfix formbox">
            	<div class="row">
                	<div class="col-sm-12">
                    	<div class="form_group">
                            <input type="text" class="textbox" name="address" id="address" placeholder="Address Line1" value="<?=$user_data['address']?>">
                        </div>
                    </div>
					
                    <div class="col-sm-12">
                    	<div class="form_group">
                            <input type="text" class="textbox" name="address2" id="address2" placeholder="Address Line2" value="<?=$user_data['address2']?>">
                        </div>
                    </div>
					
                    <div class="col-sm-12">
                    	<div class="form_group">
                            <input type="text" class="textbox" name="city" id="city" placeholder="City" value="<?=$user_data['city']?>">
                        </div>
                    </div>
                    
                    <div class="col-sm-12">
                    	<div class="form_group">
                            <input type="text" class="textbox" name="state" id="state" placeholder="State" value="<?=$user_data['state']?>">
                        </div>
                    </div>
                    
                    <div class="col-sm-12">
                    	<div class="form_group">
                            <input type="text" class="textbox" name="postcode" id="postcode" placeholder="Post code" value="<?=$user_data['postcode']?>">
                        </div>
                    </div>
                    
                    <?php /*?><div class="col-sm-12">
                    	<div class="form_group">
                            <textarea class="textbox" placeholder="Message"></textarea>
                        </div>
                    </div><?php */?>
                    
                     <div class="col-sm-12">
                    	<div class="">
                            <button type="submit" class="btn btn_md btn-blue">Update</button>
							<input type="hidden" name="adr_change" id="adr_change" />
                        </div>
                    </div>
                </div>
            </div>
			</form>
        </div><!--modal-body-->
      </div>
    </div>
</div><!-- Modal -->

<script>
function confirm_sale_validation() {
	<?php /*?>if(document.getElementById("shipping_method_send_me_label").checked==false && document.getElementById("shipping_method_own_print_label").checked==false && document.getElementById("shipping_method_own_courier").checked==false) {
		alert('You must select send your device type.');
		return false;
	} else <?php */?>if(document.getElementById("terms").checked==false) {
		alert('You must agree to terms & conditions to sign-up.');
		return false;
	}
}

function getPromoCode()
{
	var promo_code = document.getElementById('promo_code').value.trim();
	if(promo_code=="") {
		alert('Please enter coupon code');
		return false;
	}

	post_data = "promo_code="+promo_code+"&amt=<?=$sum_of_orders?>&user_id=<?=$user_id?>&order_id=<?=$order_id?>&token=<?=md5(uniqid());?>";
	jQuery(document).ready(function($){
		$.ajax({
			type: "POST",
			url:"../ajax/promocode_verify.php",
			data:post_data,
			success:function(data) {
				if(data!="") {
					var resp_data = JSON.parse(data);
					console.log(resp_data);
					if(resp_data.msg!="" && resp_data.mode == "expired") {
						$("#promo_code").val('');
						$("#showhide_promocode_row").hide();
						$("#promocode_id").val('');
						$("#promocode_value").val('');
						$("#total_amt").html('<?=amount_fomat($sum_of_orders)?>');

						$(".showhide_promocode_msg").show();
						$(".promocode_msg").html(resp_data.msg);
					} else {
						$(".showhide_promocode_msg").hide();
						$(".promocode_msg").html('');
						$("#showhide_promocode_row").show();
						if(resp_data.coupon_type=='percentage') {
							$("#promocode_amt").html("("+resp_data.percentage_amt+"%): "+resp_data.discount_of_amt);
						} else {
							$("#promocode_amt").html(resp_data.discount_of_amt);
						}
						$("#promocode_id").val(resp_data.promocode_id);
						$("#promocode_value").val(resp_data.promocode_value);
						$("#total_amt").html(resp_data.total);
					}
				} else {
					$('.promocode_msg').html('Something wrong so please try again...');
				}
			}
		});
	});
}

(function( $ ) {
	$(function() {
		$('input').each(function() {
			$(window).keydown(function(event){
				if(event.keyCode == 13) {
				  return false;
				}
			});
		});
	
		$("#promocode_removed").click(function() {
			$("#promo_code").val('');
			$("#showhide_promocode_row").hide();
			$("#promocode_id").val('');
			$("#promocode_value").val('');
			$("#total_amt").html('<?=amount_fomat($sum_of_orders)?>');
		});

		$('#chg_address_form').bootstrapValidator({
			fields: {
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
				}
			}
		}).on('success.form.bv', function(e) {
			$('#chg_address_form').data('bootstrapValidator').resetForm();

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

		$('#chg_address_form').bootstrapValidator({
			fields: {
				address: {
					validators: {
						notEmpty: {
							message: 'Please enter address.'
						}
					}
				},
				address2: {
					validators: {
						notEmpty: {
							message: 'Please enter address2.'
						}
					}
				},
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
				}
			}
		}).on('success.form.bv', function(e) {
			$('#chg_address_form').data('bootstrapValidator').resetForm();

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
		
		$("#num_of_devices").html('<?=array_sum($num_of_quantity)?>');
	});
})(jQuery);
</script>