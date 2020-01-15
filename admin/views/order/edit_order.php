<!-- begin:: Page -->
<div class="m-grid m-grid--hor m-grid--root m-page">
  <!-- BEGIN: Header -->
  <?php include("include/admin_menu.php"); ?>
  <!-- END: Header -->

  <!-- begin::Body -->
  <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
    <!-- BEGIN: Left Aside -->
    <?php include("include/navigation.php"); ?>
    <!-- END: Left Aside -->
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
      <div class="m-content">
        <?php require_once('confirm_message.php');?>
        <div class="row">
        	<div class="col-md-12">
				<div class="m-portlet">
					<div class="m-portlet__head m-portlet__head-bg-brand">
						<div class="m-portlet__head-caption">
							<div class="m-portlet__head-title">
								<h3 class="m-portlet__head-text">
									Invoice #<?=$order_id?>
								</h3>
							</div>
						</div>
					</div>
					<div class="m-portlet__body">
						<!--begin::Section-->
						<div class="m-section">
							<div class="m-section__content">
                    <div class="row">
                      <div class="col-md-4">
                        <div class="m-portlet">
						<div class="m-portlet__body">
							<!--begin::Section-->
							<div class="m-section">
								<div class="m-section__content">
                                <h4 class="no-margin"><?=$order_data_before_saved['name']?></h4>
								<dl class="no-bottom-margin">
								  <dt>Address:</dt>
								  <dd>
									<?=$order_data_before_saved['address']?>
								  </dd>
								  <dd>
									<?=$order_data_before_saved['city'].', '.$order_data_before_saved['state'].' '.$order_data_before_saved['postcode']?>
								  </dd>
								  <dd>
									<?=$order_data_before_saved['country']?>
								  </dd>
								  <dt>Contact:</dt>
								  <dd>
									<a href="mailto:<?=$order_data_before_saved['email']?>">
									  <?=$order_data_before_saved['email']?>
									</a>
								  </dd>
								  <dt>Sales Pack Option:</dt>
								  <dd>
								  	<?php
									if($order_data_before_saved['sales_pack']=="dropoff") {
										echo 'Drop off at a DHL Express point';
									} elseif($order_data_before_saved['sales_pack']=="pickup") {
										echo 'Pick up by courier';
									} else {
										echo ucfirst(str_replace("_"," ",$order_data_before_saved['sales_pack']));
									} ?>
								  </dd>
								
								  <?php
								  if($order_data_before_saved['sales_pack']=="pickup" && $order_data_before_saved['order_type']!="apr") { ?>
									<dt>Pickup Informations:</dt>
									<dd><strong>Date:</strong>
									  <?=date("m-d-Y",strtotime($order_data_before_saved['pickup_date']))?>
									</dd>
									<dd><strong>Time Slot:</strong>
									  <?=str_replace("_"," ",$order_data_before_saved['pickup_time'])?>
									</dd>
									<dd><strong>Address Line1:</strong>
									  <?=$order_data_before_saved['pickup_address']?>
									</dd>
									<dd><strong>Address Line2:</strong>
									  <?=$order_data_before_saved['pickup_address2']?>
									</dd>
									<dd><strong>City:</strong>
									  <?=$order_data_before_saved['pickup_city']?>
									</dd>
									<dd><strong>State:</strong>
									  <?=$order_data_before_saved['pickup_state']?>
									</dd>
									<dd><strong>Post Code:</strong>
									  <?=$order_data_before_saved['pickup_postcode']?>
									</dd>
								  <?php
								  } ?>
								</dl>
								
								<div style="overflow-y:auto; max-height:250px;">
								<?php
								if($order_data_before_saved['sales_pack']=="send_me_label" || $order_data_before_saved['sales_pack']=="own_print_label" || $order_data_before_saved['sales_pack']=="pickup" || $order_data_before_saved['sales_pack']=="dropoff") { ?>
									<h4 class="" style="margin-top:20px;">Shipping Info</h4>
									<dl class="no-bottom-margin">
									<?php
									if($order_data_before_saved['shipping_api']) { ?>
										<dd><strong>Shipping API:</strong> 
										<?php 
										if($order_data_before_saved['shipping_api']=="easypost") {
											echo 'Easy Post';
										}
										echo '</dd>';
									}
									if($order_data_before_saved['shipment_id']) { ?>
										<dd><strong>Shipment ID:</strong> <?=$order_data_before_saved['shipment_id']?></dd>
									<?php
									}
									if($order_data_before_saved['shipment_tracking_code']) { ?>
										<dd><strong>Shipment Tracking Code:</strong> <?=$order_data_before_saved['shipment_tracking_code']?></dd>
									<?php
									}
									if($order_data_before_saved['shipment_label_url']) { ?>
										<dd><strong>Download Shipment Label:</strong> <a target="_blank" href="<?=$order_data_before_saved['shipment_label_url']?>">View</a></dd>
									<?php
									} ?>
									</dl>
								
									<?php
									if($order_data_before_saved['shipping_api']=="easypost") {
										if($order_data_before_saved['shipment_id']) { ?>
											<h4 style="margin-top:20px;">Tracking Details</h4>
											<dl class="no-bottom-margin">
											<?php
											require_once("../libraries/easypost-php-master/lib/easypost.php");
											\EasyPost\EasyPost::setApiKey($shipping_api_key);
											
											$shipment = \EasyPost\Shipment::retrieve($order_data_before_saved['shipment_id']);
											
											echo '<h5 style="margin-top:20px;">Current Status</h5>';
											echo '<dd><strong>Date:</strong> '.date('m-d-Y h:i A',strtotime($shipment->tracker->created_at)).'</dd>';
											echo '<dd><strong>Tracking Code:</strong> '.$shipment->tracker->tracking_code.'</dd>';
											echo '<dd><strong>Est. Delivery Date:</strong> '.date('m-d-Y h:i A',strtotime($shipment->tracker->est_delivery_date)).'</dd>';
											echo '<dd><strong>Status:</strong> '.$shipment->tracker->status.'</dd>';
											echo '<dd><strong>Public Url:</strong> <a target="_blank" href="'.$shipment->tracker->public_url.'">Click Here To See</a></dd>';
											
											echo '<h5 style="margin-top:20px;">History</h5>';
											foreach($shipment->tracker->tracking_details as $tracking_details) {
												echo '<dd><strong>'.date('m-d-Y h:i A',strtotime($tracking_details->datetime)).'</strong><br>'.$tracking_details->message.'</dd>';
												if($tracking_details->tracking_location->city && $tracking_details->tracking_location->state) {
													echo '<dd>'.$tracking_details->tracking_location->city.', '.$tracking_details->tracking_location->state.($tracking_details->tracking_location->country?', '.$tracking_details->tracking_location->country:'').', '.$tracking_details->tracking_location->zip.'</dd>';
												}
												echo '<br>';
											} ?>
											</dl>
										<?php
										}
									}
									if($order_data_before_saved['shipment_label_url']) {
										$shipment_alert_msg = "Are you sure you want to re-create shipment for this order? current shipment may be in proccess.";
									} else {
										$shipment_alert_msg = "Are you sure you want to create shipment for this order?";
									}
								} ?>

								<dl class="no-bottom-margin">
									<form action="controllers/order/order.php" role="form" class="form-horizontal form-groups-bordered" method="post">
									  <input type="hidden" name="create_shipment" id="create_shipment" value="yes" />
									  <input type="hidden" name="order_id" id="order_id" value="<?=$order_id?>" />
									
									  <button class="btn btn-alt btn-primary" type="submit" name="create_shipment" onclick="return confirm('<?=$shipment_alert_msg?>');">Create Shipment</button>
									</form>
								</dl>
							</div>
								 
									</div>
								</div>
								<!--end::Section-->
							</div>
						</div>
                      </div>
                      <div class="col-md-4">
                        <div class="m-portlet">
            							<div class="m-portlet__body">
            								<!--begin::Section-->
            								<div class="m-section">
            									<div class="m-section__content">
                                <h4 class="no-margin">Billing details</h4>
                                <dl class="no-bottom-margin">
                                  <dd><b>Total Amount:</b> <?=amount_fomat($total_of_order)?></dd>
                                  <dd><b>Invoice Number:</b> #<?=$order_id?></dd>
                                  <dd><b>Order Status:</b> <?=ucwords(str_replace("_"," ",$order_data_before_saved['status']))?></dd>
                                  <dd><b>Invoice Date:</b> <?=date("m-d-Y h:i",strtotime($order_data_before_saved['date']))?></dd>
                                  <dd><b>Approved Date:</b>
								    <?php
									if($order_data_before_saved['approved_date']=="0000-00-00 00:00:00")
										echo 'xx-xx-xxxx';
									else
										echo date("m-d-Y h:i",strtotime($order_data_before_saved['approved_date']));
									?></dd>
								  <dd><b>Due Date:</b> 
									<?php
									if($order_data_before_saved['expire_date']=="0000-00-00 00:00:00")
										echo 'xx-xx-xxxx';
									else
										echo date("m-d-Y h:i",strtotime($order_data_before_saved['expire_date']));
									?>
								  </dd>
								  
								  <?php
								  if($order_data_before_saved['billing_first_name']!="") { ?>
								  <dd><b>Billing First Name:</b> <?=$order_data_before_saved['billing_first_name']?></dd>
								  <dd><b>Billing Last Name:</b> <?=$order_data_before_saved['billing_last_name']?></dd>
								  <dd><b>Billing Company Name:</b> <?=$order_data_before_saved['billing_company_name']?></dd>
								  <dd><b>Billing Address:</b> <?=$order_data_before_saved['billing_address']?></dd>
								  <dd><b>Billing City:</b> <?=$order_data_before_saved['billing_city']?></dd>
								  <dd><b>Billing Post Code:</b> <?=$order_data_before_saved['billing_postcode']?></dd>
								  <dd><b>Billing Country:</b> <?=$order_data_before_saved['billing_country']?></dd>
								  <?php
								  } ?>
                                </dl>
            									</div>
            								</div>
            								<!--end::Section-->
            							</div>
            						</div>
                      </div>
                      <div class="col-md-4">
                        <div class="m-portlet">
            							<div class="m-portlet__body">
            								<!--begin::Section-->
            								<div class="m-section">
            									<div class="m-section__content">
                                <h4 class="no-margin">Payment Details</h4>
                                <dl class="no-bottom-margin">
                                  <dd><b>Payment Method:</b> <?=ucfirst($order_data_before_saved['payment_method'])?></dd>
									<?php
									if($order_data_before_saved['payment_method']=="paypal") { ?>
										<dd><b>Paypal Address:</b> <?=$order_data_before_saved['paypal_address']?></dd>
									<?php
									} elseif($order_data_before_saved['payment_method']=="bank") { ?>
										<dd><b>Account Name:</b> <?=$order_data_before_saved['act_name']?></dd>
										<dd><b>Account Number:</b> <?=$order_data_before_saved['act_number']?></dd>
										<dd><b>Short Code:</b> <?=$order_data_before_saved['act_short_code']?></dd>
									<?php
									} elseif($order_data_before_saved['payment_method']=="cheque") { ?>
										<dd><b>Name:</b> <?=$order_data_before_saved['chk_name']?></dd>
										<dd><b>Address:</b> <?=$order_data_before_saved['chk_street_address']?></dd>
										<dd><?=$order_data_before_saved['chk_street_address_2']?></dd>
										<dd><?=$order_data_before_saved['chk_city'].', '.$order_data_before_saved['chk_state'].' '.$order_data_before_saved['chk_zip_code']?></dd>
									<?php
									} elseif($order_data_before_saved['payment_method']=="zelle") { ?>
										<dd><b>Zelle Address:</b> <?=$order_data_before_saved['zelle_address']?></dd>
									<?php
									} elseif($order_data_before_saved['payment_method']=="cashapp") { ?>
										<dd><b>Cashapp Address:</b> <?=$order_data_before_saved['cashapp_address']?></dd>
									<?php
									} elseif($order_data_before_saved['payment_method']=="venmo") { ?>
										<dd><b>Venmo Address:</b> <?=$order_data_before_saved['venmo_address']?></dd>
									<?php
									} elseif($order_data_before_saved['payment_method']=="google_pay") { ?>
										<dd><b>Google Pay Address:</b> <?=$order_data_before_saved['google_pay_address']?></dd>
									<?php
									} elseif($order_data_before_saved['payment_method']=="other") { ?>
										<dd><b>Name Of Method:</b> <?=$order_data_before_saved['other_name_of_method']?></dd>
										<dd><b>Account Details:</b> <?=$order_data_before_saved['other_account_details']?></dd>
									<?php
									} ?>
                                </dl>
            									</div>
            								</div>
            								<!--end::Section-->
            							</div>
            						</div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <table class="table table-sm m-table m-table--head-bg-brand">
    											<thead class="thead-inverse">
    												<tr>
                              <th width="25">#</th>
                              <th width="100">Item ID</th>
                              <th>Item(s)</th>
                              <th width="100">Qty</th>
                              <th width="100">Price</th>
    												</tr>
    											</thead>
    											<tbody>
                            <?php
              							if($order_num_of_rows>0) {
              								foreach($order_item_list as $order_item_list_data) {
              								//path of this function (get_order_item) admin/include/functions.php
              								$order_item_data = get_order_item($order_item_list_data['id'],'general'); ?>
                              <tr>
                                <td>
                                  <?=$n=$n+1?>
                                </td>
                                <td>
                                  <?=$order_item_list_data['id']?>
                                </td>
                                <td>
                                  <?=$order_item_list_data['device_title'].($order_item_list_data['device_title']=="" && $order_item_data['device_type']==""?' - ':'').$order_item_data['device_type']?>
                                    <?php
									if($order_item_list_data['images']) {
									$item_images_array = json_decode($order_item_list_data['images']);
										foreach($item_images_array as $item_image_key => $item_image_val) {
											if($item_image_val!=''){
												echo '<br>'.str_replace('_',' ',$item_image_key). ': <img src="../images/order/'.$item_image_val.'" width="30" height="30" alt="'.$item_image_key.'" />';
											}
										}
									}
									?>

                                </td>
                                <td>
                                  <?=$order_item_list_data['quantity']?>
                                </td>
                                <td>
                                  <?=amount_fomat($order_item_list_data['price'])?>
                                </td>
                              </tr>
                              <?php
              								} ?>
                                <tr>
                                  <td colspan="4"><strong>Sell Order Total:</strong></td>
                                  <td><strong><?=($sum_of_orders>0?amount_fomat($sum_of_orders):'')?></strong></td>
                                </tr>
                                <?php
              								if($promocode_amt>0) { ?>
                                  <tr>
                                    <td colspan="4"><strong><?=$discount_amt_label?></strong></td>
                                    <td><strong><?=amount_fomat($promocode_amt)?></strong></td>
                                  </tr>
                                  <tr>
                                    <td colspan="4"><strong>Total:</strong></td>
                                    <td><strong><?=amount_fomat($total_of_order)?></strong></td>
                                  </tr>
                                  <?php
              								}
              							} else {
              								echo '<tr><td colspan="6" align="center">No Record Found.</td></tr>';
              							} ?>
                          </tbody>
    											</tbody>
    										</table>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12 my-4">
                        <form action="controllers/order/order.php" role="form" class="form-horizontal form-groups-bordered" method="post" onSubmit="return check_form(this);" enctype="multipart/form-data">
                          <fieldset>
                            <div class="form-group m-form__group">
                              <label for="input">Email Content: </label>
                              <textarea class="form-control m-input summernote" name="note" id="note" placeholder="note" rows="10"><?=$email_body_text?></textarea>
                            </div>

                            <div class="form-group m-form__group">
                              <label for="input">Order Status: </label>
                              <select name="status" id="status" class="form-control m-select2 m-select2-general">
          											<option value="unconfirmed" <?php if($order_data_before_saved['status']=='unconfirmed'){echo 'selected="selected"';}?>>Unconfirmed</option>
          											<option value="submitted" <?php if($order_data_before_saved['status']=='submitted'){echo 'selected="selected"';}?>>Submitted</option>
          											<option value="expiring" <?php if($order_data_before_saved['status']=='expiring'){echo 'selected="selected"';}?>>Expiring</option>
          											<option value="received" <?php if($order_data_before_saved['status']=='received'){echo 'selected="selected"';}?>>Received</option>
          											<option value="problem" <?php if($order_data_before_saved['status']=='problem'){echo 'selected="selected"';}?>>Problem</option>
          											<option value="completed" <?php if($order_data_before_saved['status']=='completed'){echo 'selected="selected"';}?>>Completed</option>
          											<option value="returned" <?php if($order_data_before_saved['status']=='returned'){echo 'selected="selected"';}?>>Returned</option>
          											<option value="awaiting_delivery" <?php if($order_data_before_saved['status']=='awaiting_delivery'){echo 'selected="selected"';}?>>Awaiting Delivery</option>
          											<option value="expired" <?php if($order_data_before_saved['status']=='expired'){echo 'selected="selected"';}?>>Expired</option>
          											<option value="processed" <?php if($order_data_before_saved['status']=='processed'){echo 'selected="selected"';}?>>Processed</option>
          											<option value="rejected" <?php if($order_data_before_saved['status']=='rejected'){echo 'selected="selected"';}?>>Rejected</option>
          											<option value="posted" <?php if($order_data_before_saved['status']=='posted'){echo 'selected="selected"';}?>>Posted</option>
          										</select>
                            </div>

                            <div class="form-actions">
                              <button class="btn btn-primary" type="submit" name="update"><?=($order_id?'Update':'Save')?></button>
                              <a href="orders.php" class="btn btn-secondary">Back</a>
                            </div>
                          </fieldset>
                          <input type="hidden" name="order_id" id="order_id" value="<?=$post['order_id']?>" />
                        </form>
                      </div>
                    </div>
									</div>
								</div>
								<!--end::Section-->
							</div>
						</div>
        	</div>
        </div>
        <div class="row">
        	<div class="col-md-12">
						<div class="m-portlet">
							<div class="m-portlet__head">
								<div class="m-portlet__head-caption">
									<div class="m-portlet__head-title">
										<h3 class="m-portlet__head-text">
											Payment
										</h3>
									</div>
								</div>
							</div>
							<div class="m-portlet__body">
								<!--begin::Section-->
								<div class="m-section">
									<div class="m-section__content">
                    <?php //$order_data_before_saved['paypal_address'] = 'bharat@indiaphpexpert.com';
      							$order_data = get_order_data($order_id);
      							if($order_data_before_saved['payment_method']=="paypal") {
      								$exp_currency = @explode(",",$general_setting_data['currency']);
      								$currency = $exp_currency[0]; ?>
                    <form class="form-horizontal form-groups-bordered" action="payment/payments.php" method="post" id="paypal_form" target="_blank">
                      <input type="hidden" name="cmd" value="_xclick" />
                      <input type="hidden" name="currency_code" value="<?=$currency?>" />
                      <input type="hidden" name="payer_email" value="" />
                      <input type="hidden" name="business" value="<?=$order_data_before_saved['paypal_address']?>" />
                      <input type="hidden" name="item_number" value="<?=$order_id?>" />
                      <input type="hidden" name="no_shipping" value="1" />
                      <input type="hidden" name="amount" value="<?=$total_of_order?>" />
                      <div class="form-actions">
                        <button class="btn btn-alt btn-large btn-primary" type="submit" name="update">Pay Now</button>
                      </div>
                    </form>
                    <?php
      				} ?>

                      <form action="controllers/order/order.php" role="form" method="post" class="form-horizontal form-groups-bordered" onSubmit="return check_form(this);" enctype="multipart/form-data">
                        <?php
      					if($order_data_before_saved['payment_method']=="paypal") { ?>
                          <div class="form-group m-form__group">
                            <label class="control-label" for="input">Transaction ID</label>
                              <input type="text" class="form-control m-input" id="transaction_id" name="transaction_id" value="<?=$order_data['transaction_id']?>">
                          </div>
                        <?php
      					} else if($order_data_before_saved['payment_method']=="bank") { ?>
							<div class="form-group m-form__group">
								<label for="fileInput">Payment Receipt:</label>
								<div class="custom-file">
									<input type="file" id="payment_receipt" class="custom-file-input" name="payment_receipt" onChange="checkFile(this);">
									<label class="custom-file-label" for="image">
										Choose file
									</label>
								</div>
								
								<?php
								if($order_data['payment_receipt']!="") { ?>
									<img src="../images/payment/<?=$order_data['payment_receipt']?>" width="200" class="my-md-2">
									<a class="btn btn-danger btn-sm" data-dismiss="fileupload" href="controllers/order/order.php?d_p_i_id=<?=$order_id?>&mode=payment_receipt" onclick="return confirm('Are you sure to delete payment receipt?');">Remove</a>
								<?php
								} ?>
							</div>
                            <?php
      						} else if($order_data_before_saved['payment_method']=="cheque") { ?>
							<div class="form-group m-form__group">
								<label for="fileInput">Payment Receipt:</label>
								<div class="custom-file">
									<input type="file" id="payment_receipt" class="custom-file-input" name="payment_receipt" onChange="checkFile(this);">
									<label class="custom-file-label" for="image">
										Choose file
									</label>
								</div>
								
								<?php
								if($order_data['payment_receipt']!="") { ?>
									<img src="../images/payment/<?=$order_data['payment_receipt']?>" width="200" class="my-md-2">
									<a class="btn btn-danger btn-sm" data-dismiss="fileupload" href="controllers/order/order.php?d_p_i_id=<?=$order_id?>&mode=payment_receipt" onclick="return confirm('Are you sure to delete payment receipt?');">Remove</a>
								<?php
								} ?>
							</div>
							
                            <div class="form-group m-form__group">
								<label for="fileInput">Cheque Photo(optional):</label>
								<div class="custom-file">
									<input type="file" id="cheque_photo" class="custom-file-input" name="cheque_photo" onChange="checkFile(this);">
									<label class="custom-file-label" for="image">
										Choose file
									</label>
								</div>
								
								<?php
								if($order_data['cheque_photo']!="") { ?>
									<img src="../images/payment/<?=$order_data['cheque_photo']?>" width="200" class="my-md-2">
									<a class="btn btn-danger btn-sm" data-dismiss="fileupload" href="controllers/order/order.php?d_p_i_id=<?=$order_id?>&mode=cheque_photo" onclick="return confirm('Are you sure to delete cheque photo?');">Remove</a>
								<?php
								} ?>
							</div>
							
                              <div class="form-group m-form__group">
                                <label class="control-label" for="input">Check Number</label>
                                  <input type="text" class="form-control m-input" id="check_number" value="<?=$order_data['check_number']?>" name="check_number">
                              </div>
                              <div class="form-group m-form__group">
                                <label class="control-label" for="input">Bank Name</label>
                                  <input type="text" class="form-control m-input" id="bank_name" value="<?=$order_data['bank_name']?>" name="bank_name">
                              </div>
                            <?php
      						} ?>

                                <div class="form-group m-form__group">
                                  <div class="m-checkbox-list">
            												<label class="m-checkbox">
                                      <input id="is_payment_sent" type="checkbox" value="1" name="is_payment_sent" <?php if($order_data['is_payment_sent']=='1'){echo 'checked="checked"';}?>>
                											Mark Payment Sent
            													<span></span>
            												</label>
            											</div>
                                </div>

                                <div class="form-actions">
                                  <button class="btn btn-primary" type="submit" name="save">Save</button>
                                </div>
                                <input type="hidden" name="order_id" id="order_id" value="<?=$post['order_id']?>" />
                      </form>
									</div>
								</div>
								<!--end::Section-->
							</div>
						</div>
        	</div>
        </div>
      </div>
    </div>
  </div>
  <!-- end:: Body -->
  <!-- begin::Footer -->
  <?php include("include/footer.php");?>
  <!-- end::Footer -->
</div>
<!-- end:: Page -->

<!-- begin::Scroll Top -->
<div id="m_scroll_top" class="m-scroll-top">
  <i class="la la-arrow-up"></i>
</div>
<!-- end::Scroll Top -->

<script type="text/javascript">
  function check_form(a) {
    if (a.is_payment_sent.checked == false) {
      alert('Mark Payment Sent Checkbox Must Be Checked');
      return false;
    }
  }

  function checkFile(fieldObj) {
    if (fieldObj.files.length == 0) {
      return false;
    }

    var id = fieldObj.id;
    var str = fieldObj.value;
    var FileExt = str.substr(str.lastIndexOf('.') + 1);
    var FileExt = FileExt.toLowerCase();
    var FileSize = fieldObj.files[0].size;
    var FileSizeMB = (FileSize / 10485760).toFixed(2);

    if ((FileExt != "gif" && FileExt != "png" && FileExt != "jpg" && FileExt != "jpeg")) {
      var error = "Please make sure your file is in png | jpg | jpeg | gif format.\n\n";
      alert(error);
      document.getElementById(id).value = '';
      return false;
    }
  }
</script>
