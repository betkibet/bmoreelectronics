<?php
$csrf_token = generateFormToken('order_offer');

//Url param
$order_id=$url_second_param;

//Header section
include("include/header.php");

//If direct access then it will redirect to home page
if($user_id<=0) {
	setRedirect(SITE_URL);
	exit();
}

//Get order batch data, path of this function (get_order_data) admin/include/functions.php
$order_data_before_saved = get_order_data($order_id);
if($user_id!=$order_data_before_saved['user_id']) {
	setRedirect(SITE_URL);
	exit();
}

//Get order price based on orderID, path of this function (get_order_price) admin/include/functions.php
$sum_of_orders=get_order_price($order_id);

if($order_data_before_saved['promocode_id']>0 && $order_data_before_saved['promocode_amt']>0) {
	$promocode_amt = $order_data_before_saved['promocode_amt'];
	$discount_amt_label = "Surcharge:";
	if($order_data_before_saved['discount_type']=="percentage")
		$discount_amt_label = "Surcharge (".$order_data_before_saved['discount']."% of Initial Quote):";

	$total_of_order = $sum_of_orders+$order_data_before_saved['promocode_amt'];
	$is_promocode_exist = true;
} else {
	$total_of_order = $sum_of_orders;
}

//Get order item list based on orderID, path of this function (get_order_item_list) admin/include/functions.php
$order_item_list = get_order_item_list($order_id);
$order_num_of_rows = count($order_item_list);

$is_offer_section_hide = true;
$readonly = 'readonly="readonly"';
$disabled = 'disabled="disabled"';
if($order_data_before_saved['status']=="processed" || $order_data_before_saved['status']=="problem") {
	$is_offer_section_hide = false;
	$readonly = '';
	$disabled = '';
}

//Get order messaging data list based on orderID, path of this function (get_order_messaging_data_list) admin/include/functions.php
$order_messaging_data_list = get_order_messaging_data_list($order_id);
$num_rows = count($order_messaging_data_list);
if($num_rows>0) { ?>

  <!-- Main -->
  <div id="main"> 

    <section id="youroffer_page" class="sectionbox white-bg">
      <div class="wrap clearfix">
        	<div id="sidebar_profile">
            	<div class="profile_pic clearfix">
                	<div class="inner">
                    	<?php
						if($user_data['image']) {
							$md_img_path = SITE_URL.'libraries/phpthumb.php?imglocation='.SITE_URL.'images/avatar/'.$user_data['image'].'&w=157&h=157';
                    		echo '<img src="'.$md_img_path.'">';
        				} else {
							$md_img_path = SITE_URL.'libraries/phpthumb.php?imglocation='.SITE_URL.'images/placeholder_avatar.jpg&w=157&h=157';
							echo '<img src="'.$md_img_path.'">';
						} ?>
                    </div>
                </div>
                <div class="profile_nav ecolumn">
                	<ul>
                    	<li class="active"><a href="<?=SITE_URL?>account">My Orders</a></li>
                        <li><a href="<?=SITE_URL?>profile">Profile</a></li>
                        <li><a href="<?=SITE_URL?>change-password">Change Password</a></li>
                    </ul>
                    <div class="logout">
                        <a href="<?=SITE_URL?>controllers/logout.php">Logout</a>
                    </div>
                </div>
            </div><!--#sidebar_profile-->
            
            
            <div id="container_profile">
            	<div class="inner ecolumn">
                	
                    <div class="clearfix text-right">
                    	<a href="<?=SITE_URL?>account<?=($post['p']>0?'?p='.$post['p']:'')?>" class="btn btn-blue">Back</a>
                    </div>
                    <hr>
                    <h4>Your Offer</h4>
                    <div class="whitesextion_box">
						<form action="<?=SITE_URL?>controllers/order/order_offer.php" method="post" id="offer_form">
                    	<div class="yourofferbox">
                        	<div class="row">
                            	<div class="col-sm-8">
                                	<p class="text-blue">Order Id : <?=$order_id?></p>
                                    <p class="text-blue">Total Amount : <?=amount_fomat($total_of_order)?></p>
                                    <div class="form_group form-group">
                                    <label>Offer Note</label>
                                        <textarea class="textbox" name="note" id="note" placeholder="Note..." <?=$readonly?>></textarea>
                                    </div>
                                    <div class="btnbox">
									  <?php 
									  if($is_offer_section_hide==false) { ?>
										 <button class="btn btn-blue-bg" type="submit">SEND</button>
										 <input type="hidden" name="submit_resp_offer" id="submit_resp_offer" />
										 <input type="hidden" name="order_id" id="order_id" value="<?=$order_id?>" />
									  <?php 
									  } ?>
									</div>
                                </div>
                                
                                <div class="col-sm-4">
                                	<div class="offer-status">
										<div class="form_group form-group">
                                    	<label>Offer Status</label>
										<select name="status" id="status" class="textbox" <?=$disabled?>>
										  <option value="">-Select-</option>
										  <option value="offer_accepted" <?php if($order_data_before_saved['offer_status']=='offer_accepted'){echo 'selected="selected"';}?>>Offer Accept</option>
										  <option value="offer_rejected" <?php if($order_data_before_saved['offer_status']=='offer_rejected'){echo 'selected="selected"';}?>>Offer Rejected</option>
										</select>
                                        <?php /*?><button class="btn btn-md btn-green-bg">Offer Accept</button><?php */?>
										</div>
                                    </div>
                                </div>
                            </div>
                        </div>
						<input type="hidden" name="csrf_token" value="<?=$csrf_token?>">
						</form>
                    </div>
                    
                    <div id="review-sale-table" class="clearfix orderiteam">
                    <h4>Order Items (s)</h4>
                    <div class="table-responsive table-bordered">          
						<table class="table">
							<thead>
								<tr>
									<th class="text-left">Handset/Device Type</th>
									<th class="text-center" width="100">Quantity</th>
									<th class="text-center" width="100">price</th>
								</tr>
							</thead>
							<tbody>
								<?php
								if($order_num_of_rows>0) {
									foreach($order_item_list as $order_data) {
									  $order_item_data = get_order_item($order_data['id'],'general'); ?>
									  <tr>
										<td>
										<div class="order">
											<?=($order_data['device_title']?$order_data['device_title'].' - ':'').$order_item_data['device_type']?>
										</div>
										</td>
										<td>
											<div class="quantity"><?=$order_data['quantity']?></div>
										</td>
										<td>
											<div class="pricebox text-red"><?=amount_fomat($order_data['price'])?></div>
										</td>
									  </tr>
									<?php
									} ?>
									<tr>
										<td colspan="3">
											<div class="text-right totalsellprice">Sell Order Total: <?=($sum_of_orders>0?amount_fomat($sum_of_orders):'')?></div>
										</td>
									</tr>
									<?php
									if($promocode_amt>0) { ?>
										<tr>
											<td colspan="3">
												<div class="text-right totalsellprice"><?=$discount_amt_label?>: <?=amount_fomat($promocode_amt)?></div>
											</td>
										</tr>
										<tr>
											<td colspan="3">
												<div class="text-right totalsellprice">Total: <?=amount_fomat($total_of_order)?></div>
											</td>
										</tr>
									<?php
									}
								} else {
									echo '<tr><td colspan="3" align="center">No Record Found.</td></tr>';
								} ?>
							</tbody>
						</table>
                    </div>
                </div>
                
                <div id="messagehistory">
                	<h4>Message History</h4>
                	<div class="whitesextion_box">
                    	<div class="innerbox clearfix">
                        	<?php
							$i=1;
							foreach($order_messaging_data_list as $msg_data) {
								if($msg_data['type']=="admin") { ?>
								<div class="msgbox adminbox clearfix">
									<div class="name">ADMIN</div>
									<div class="chatbox">
										<div class="row">
											<div class="col-sm-8">
												<div class="date"><?=date('m-d-Y H:i A',strtotime($msg_data['date']))?></div>
												<div class="msg_text"><?=$msg_data['note']?></div>
											</div>
											<div class="col-sm-4">
												<div class="order-status">Order Status <br><span><?=ucwords(str_replace("_"," ",$msg_data['status']))?></span></div>
											</div>
										</div>
									</div>
								</div>
								<?php
								} else { ?>
								<div class="msgbox userbox clearfix">
									<div class="name">YOU</div>
									<div class="chatbox">
										<div class="row">
											<div class="col-sm-8">
												<div class="date"><?=date('m-d-Y H:i A',strtotime($msg_data['date']))?></div>
												<div class="msg_text"><?=$msg_data['note']?></div>
											</div>
											<div class="col-sm-4">
												<div class="order-status">Order Status <br><span><?=ucwords(str_replace("_"," ",$msg_data['status']))?></span></div>
											</div>
										</div>
									</div>
								</div>
								<?php
								}
							} ?>
                        </div>
                    </div>
                </div>
                     
                 </div><!--.inner-->
            </div><!--#container_profile-->
      </div>
    </section>
    
  </div>
  <!-- /.main --> 

<script>
(function( $ ) {
	$(function() {
		$('#offer_form').bootstrapValidator({
			fields: {
				note: {
					validators: {
						stringLength: {
							min: 1,
						},
						notEmpty: {
							message: 'Please enter note'
						}
					}
				}
			}
		}).on('success.form.bv', function(e) {
			$('#offer_form').data('bootstrapValidator').resetForm();

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
<?php
} else {
	$msg='Offer not available for this order.';
	setRedirectWithMsg(SITE_URL.'account'.($post['p']>0?'?p='.$post['p']:''),$msg,'info');
	exit();
} ?>