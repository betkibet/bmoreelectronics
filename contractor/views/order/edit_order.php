<?php
$o_access_token = $order_data_before_saved['access_token'];

if($post['order_mode'] == "paid") {
	$back_url = CONTRACTOR_URL.'paid_orders.php';
} elseif($post['order_mode'] == "awaiting") {
	$back_url = CONTRACTOR_URL.'awaiting_orders.php';
} elseif($post['order_mode'] == "archive") {
	$back_url = CONTRACTOR_URL.'archive_orders.php';
} elseif($post['order_mode'] == "abandone") {
	$back_url = CONTRACTOR_URL.'abandone_orders.php';
} else {
	$back_url = CONTRACTOR_URL.'orders.php';
} ?>

<!-- begin:: Page -->
<div class="m-grid m-grid--hor m-grid--root m-page">
  <!-- BEGIN: Header -->
  <?php include("include/admin_menu.php"); ?>
  <!-- END: Header -->

  <!-- begin::Body -->
  <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body m-body main_top_section">
    <!-- BEGIN: Left Aside -->
    <?php include("include/navigation.php"); ?>
    <!-- END: Left Aside -->
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
      <div class="m-content">
        <?php require_once('confirm_message.php');?>
        <div class="row">
        	<div class="col-md-12">
				<div class="m-portlet">
					<div class="m-portlet__head m-portlet__head-bg-brand main_edit_order table-responsive">
						<div class="m-portlet__head-caption">
							<div class="m-portlet__head-title">
								<h3 class="m-portlet__head-text">
									Order #<?=$order_id?>
								</h3>
							</div>
						</div>
						<div class="m-portlet__head-tools">
						  <ul class="m-portlet__nav">
							<li class="m-portlet__nav-item"><a class="btn btn-success" href="javascript:open_window('<?=SITE_URL?>contractor/views/print/print_delivery_note.php?order_id=<?=$order_id?>&access_token=<?=$o_access_token?>');">Delivery note <i class="fa fa-print"></i></a></li>
							<li class="m-portlet__nav-item"><a class="btn btn-success" href="javascript:open_window('<?=SITE_URL?>pdf/order-<?=$order_id?>.pdf');">Order Form <i class="fa fa-download"></i></a></li>
							<li class="m-portlet__nav-item"><a class="btn btn-alt btn-success" href="javascript:open_window('<?=SITE_URL?>contractor/views/print/sales_confirmation.php?order_id=<?=$order_id?>&access_token=<?=$o_access_token?>');">sales Confirmation <i class="fa fa-download"></i></a></li>
							<?php
							if($order_data_before_saved['sales_pack']=="own_print_label" && $order_data_before_saved['shipment_label_url']!="") {
								echo '<li class="m-portlet__nav-item"><a class="btn btn-alt btn-success" href="'.SITE_URL.'controllers/download.php?download_link='.$order_data_before_saved['shipment_label_url'].'">Address Label <i class="fa fa-download"></i></a></li>';
							} ?>
						  </ul>
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
							<div class="m-section">
								<div class="m-section__content">
									<h4 class="no-margin">Customer Info</h4>
									<dl class="no-bottom-margin">
									  <?php
									  $is_customer_exist = false;
									  if($order_data_before_saved['first_name']) {
									  $is_customer_exist = true; ?>
									  <dt><a href="edit_user.php?id=<?=$order_data_before_saved['user_id']?>" target="_blank"><?=$order_data_before_saved['first_name'].' '.$order_data_before_saved['last_name']?></a></dt>
									  <?php
									  }
									  if($order_data_before_saved['email'] || $order_data_before_saved['phone']) {
									  $is_customer_exist = true; ?>
									  <dd>
										<a href="mailto:<?=$order_data_before_saved['email']?>"><?=$order_data_before_saved['email']?></a>
										<?php
										if($order_data_before_saved['phone']) { ?>
										<a href="callto:<?=$order_data_before_saved['country_code'].$order_data_before_saved['phone']?>"><?=$order_data_before_saved['phone']?></a>
										<?php
										} ?>
									  </dd>
									  <?php
									  }
									  if(!$is_customer_exist) {
										echo '<dd>Customer Not Exist</dd>';
									  } ?>
									</dl>
									<h4 class="no-margin">Shipping Info</h4>
									<dl class="no-bottom-margin">
										<?php
										if($order_data_before_saved['shipping_address1']) { ?>
											<a href="javascript:void(0)" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#EditShippingInfo">Edit</a>
										<?php
										} else { ?>
										<a href="javascript:void(0)" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#EditShippingInfo">Add</a>
										<?php
										} ?>
									  <dd><strong><?=$order_data_before_saved['shipping_first_name'].' '.$order_data_before_saved['shipping_last_name']?></strong></dd>
									  <dd><?=$order_data_before_saved['shipping_address1'].($order_data_before_saved['shipping_address2']?'<br>'.$order_data_before_saved['shipping_address2']:'').'<br>'.$order_data_before_saved['shipping_city'].', '.$order_data_before_saved['shipping_state'].' '.$order_data_before_saved['shipping_postcode']?>
									  <?=($order_data_before_saved['shipping_country']?'<br>'.$order_data_before_saved['shipping_country']:'')?>
									  </dd>
									  <?php
									  if($order_data_before_saved['shipping_phone']) { ?>
										<dd><a href="callto:<?=$order_data_before_saved['shipping_country_code'].$order_data_before_saved['shipping_phone']?>">
										  <?=$order_data_before_saved['shipping_phone']?>
										</a></dd>
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
										<h4 class="no-margin">Billing Info</h4>
										<dl class="no-bottom-margin">
										  <dd><b>Total Amount:</b> <?=amount_fomat($total_of_order)?></dd>
										  <dd><b>Order Status:</b> <?=replace_us_to_space($order_data_before_saved['order_status_name'])?></dd>
										  <dd><b>Order Date:</b> <?=format_date($order_data_before_saved['date']).' '.format_time($order_data_before_saved['date'])?></dd>
											<?php
											if($order_data_before_saved['approved_date']=="0000-00-00 00:00:00") {
												//echo 'xx-xx-xxxx';
											} else {
												echo '<dd><b>Approved Date:</b>'.format_date($order_data_before_saved['approved_date']).' '.format_time($order_data_before_saved['approved_date']).'</dd>';
											} ?>
										  <dd><b>Due Date:</b> 
											<?php
											if($order_data_before_saved['expire_date']=="0000-00-00 00:00:00")
												echo 'xx-xx-xxxx';
											else
												echo format_date($order_data_before_saved['expire_date']).' '.format_time($order_data_before_saved['expire_date']); ?>
										  </dd>
										</dl>
									</div>
								</div>
								<!--end::Section-->
							</div>
						</div>
					  </div>
						<?php /*?><div class="col-md-3">
							<div class="m-portlet">
								<div class="m-portlet__body">
									<!--begin::Section-->
									<div class="m-section">
										<div class="m-section__content">
											<h4 class="no-margin">Payment Info</h4>
											<dl class="no-bottom-margin">
												<?php
												if($order_data_before_saved['payment_method']) { ?>
													<a href="javascript:void(0)" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#EditPaymentMethod">Edit</a>
													<dd><b>Payment Method:</b> <?=replace_us_to_space_pmt_mthd($order_data_before_saved['payment_method'])?></dd>
												<?php
												} else { ?>
													<a href="javascript:void(0)" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#EditPaymentMethod">Add</a>
												<?php
												}
					
												$payment_method_details = json_decode($order_data_before_saved['payment_method_details'],true);
												if(!empty($payment_method_details)) {
													foreach($payment_method_details as $k => $v) {
														echo '<dt>'.replace_us_to_space($k).':</dt><dd>'.$v.'</dd>';
													}
												} ?>
											</dl>
										</div>
									</div>
									<!--end::Section-->
								</div>
							</div>
						</div><?php */?>
						
						<?php
						if($prms_order_edit_shipping_label == '1') { ?>
						<div class="col-md-3">
						<div class="m-portlet">
						<div class="m-portlet__body">
							<div class="m-section">
								<div class="m-section__content">
								<h4 class="no-margin">Shipping Label</h4>
								<dl class="no-bottom-margin">
								  <dt>Select Option:</dt>
								  <dd>
									<?php
									$sales_pack = $order_data_before_saved['sales_pack']; ?>
									<form action="controllers/order/order.php" method="post">
									<div class="form-group m-form__group row">
										<div class="col-md-12" style="padding-right:5px;">
										  <select name="shipping_method" id="shipping_method" class="form-control-sm">
											 <option value=""> - Select - </option>
											 <option value="send_me_label" <?php if($sales_pack=='send_me_label'){echo 'selected="selected"';}?>>Send Me Label</option>
											 <option value="own_print_label" <?php if($sales_pack=='own_print_label'){echo 'selected="selected"';}?>>Own Print Label</option>
											 <option value="own_courier" <?php if($sales_pack=='own_courier'){echo 'selected="selected"';}?>>Own Courier</option>
										  </select>
										  <button class="btn btn-primary btn-sm mt-1" type="submit" name="upd_shipping_method">Save</button>
										</div>
									</div>
									<input type="hidden" name="order_id" id="order_id" value="<?=$post['order_id']?>" />
									<input type="hidden" name="order_mode" id="order_mode" value="<?=$post['order_mode']?>">
									</form>
								  </dd> 
								</dl>
								<dl class="no-bottom-margin">
									<?php
									if($order_data_before_saved['shipment_label_url']) {
										$shipment_alert_msg = "Are you sure you want to re-create shipment for this order? current shipment may be in proccess.";
									} else {
										$shipment_alert_msg = "Are you sure you want to create shipment for this order?";
									} ?>
									<form action="controllers/order/order.php" role="form" class="form-horizontal form-groups-bordered" method="post">
									  <input type="hidden" name="create_shipment" id="create_shipment" value="yes" />
									  <input type="hidden" name="order_id" id="order_id" value="<?=$order_id?>" />
									
									  <button class="btn btn-alt btn-success" type="submit" name="create_shipment" onclick="return confirm('<?=$shipment_alert_msg?>');">Create Shipment</button>
									  <input type="hidden" name="order_mode" id="order_mode" value="<?=$post['order_mode']?>">
									</form>
								</dl>
								<?php
								if($order_data_before_saved['shipment_label_url']) { ?>
									<a href="javascript:void(0)" class="btn btn-info btn-info" data-toggle="modal" data-target="#ShippingInfo" style="width:140px;">Shipping Info</a>
								<?php
								} ?>
									</div>
								</div>
								<!--end::Section-->
							</div>
						</div>
					  </div>
					  <?php
					  } ?>
					</div>
					
                    <div class="row">
                      <div class="col-md-12">
					    <form action="controllers/order/order.php" role="form" method="post" enctype="multipart/form-data">
                        <table class="table table-sm m-table m-table--head-bg-brand table-responsive">
							<thead class="thead-inverse">
								<?php
								if($prms_order_add_item == '1') { ?>
								<tr>
									<td colspan="8" align="right">
										<button type="button" class="btn btn-primary btn-sm" onClick="EditOrder(0);return false;">Add Item</button>
									</td>
								</tr>
								<?php
								} ?>
								<tr>
									<th width="8%">Item ID</th>
									<th width="20%">Item(s)</th>
									<th width="15%">IMEI / SN</th>
									 <th width="5%">Qty</th> 
									<th width="25%">Image</th>
									<th width="17%">Status</th>
									<th width="15%">Price</th>
									<?php
									if($prms_order_delete_item == '1') { ?>
									<th width="5%">Action</th>
									<?php
									} ?>
								</tr>
							</thead>
    						<tbody>
                            <?php
							if($order_num_of_rows>0) {
								foreach($order_item_list as $order_item_list_data) {
									//path of this function (get_order_item) admin/include/functions.php
									$order_item_data = get_order_item($order_item_list_data['id'],'general');
									$item_id = $order_item_list_data['id'];
									
									$query = mysqli_query($db,"SELECT oit.*, a.username  FROM order_item_testing AS oit LEFT JOIN admin AS a ON a.id=oit.staff_id WHERE oit.item_id='".$item_id."'");
									$order_item_testing_data = mysqli_fetch_assoc($query); ?>
									<tr>
										<td><?=$order_item_list_data['id']?></td>
										<td>
										  <?php
										  	echo $order_item_list_data['device_title'].($order_item_list_data['device_title']!="" && $order_item_data['device_type']!=""?' - ':'').$order_item_data['device_type'];
											/*if($order_item_list_data['images']) {
											$item_images_array = json_decode($order_item_list_data['images']);
												foreach($item_images_array as $item_image_key => $item_image_val) {
													if($item_image_val!=''){
														echo '<br>'.str_replace('_',' ',$item_image_key). ': <img src="../images/order/'.$item_image_val.'" width="30" height="30" alt="'.$item_image_key.'" />';
													}
												}
											}*/ ?>
											<?php
											if($prms_order_edit_item == '1') { ?>
											<br /><button type="button" class="btn btn-primary btn-sm" onClick="EditOrder(<?=$item_id?>);return false;">Edit</button>
											<?php
											} ?>
										</td>
										<td>
											<input type="text" class="form-control m-input" id="imei_number-<?=$item_id?>" name="imei_number[<?=$item_id?>]" value="<?=$order_item_list_data['imei_number']?>">
											<button type="button" class="btn btn-primary btn-sm" style="margin-top:10px;" onClick="Check_iCloud_Order_Item(<?=$item_id?>);return false;" id="icloud_check_btn<?=$item_id?>"><?=($order_item_list_data['device_check_info']!=""?'Re-Check':'Check')?></button>&nbsp;<a href="javascript:void(0);" data-toggle="tooltip" data-skin="light" title="<?=$imei_sn_check_tooltips_text?>" data-html="true"><span class="fa fa-info-circle"></span></a>&nbsp;<span id="icloud_status<?=$item_id?>"></span>&nbsp;<button type="button" class="btn btn-primary btn-sm" onClick="View_iCloud_Order_Item(<?=$item_id?>);return false;" id="icloud_view_btn<?=$item_id?>" <?=($order_item_list_data['device_check_info']!=""?'style="display:block;margin-top:10px;"':'style="display:none;margin-top:10px;"')?> >View</button>&nbsp;<span style="display:none;" id="icloud_status_loading<?=$item_id?>" class="loading green" title="Loading, please wait&hellip;">Loading&hellip;</span>
										</td>
										<td>
										  <?=$order_item_list_data['quantity']?>
										</td>
										<td>
										<div class="form-group m-form__group">
											<?php /*?><input type="hidden" name="old_image[<?=$item_id?>]" value="<?=$order_item_list_data['image']?>">
											
											<div class="custom-file">
												<input type="file" class="custom-file-input" name="image[<?=$item_id?>]" id="image[]" onChange="checkFile(this);">
												<label class="custom-file-label" for="image[]">
													Choose file
												</label>
											</div>
											
											<?php
											if($order_item_list_data['image']!="") { ?>
												<img src="<?=SITE_URL?>images/order/items/<?=$order_item_list_data['image']?>" width="100" class="my-md-2">
												<a class="btn btn-danger btn-sm" data-dismiss="fileupload" href="controllers/order/order.php?d_item_img=<?=$item_id?>&order_id=<?=$order_id?>" onclick="return confirm('Are you sure to delete this image?');">Remove</a>
											<?php
											} ?><?php */?>
											
											<button type="button" class="btn btn-primary btn-sm mb-2" onClick="AddItemMedia(<?=$order_item_list_data['id']?>);return false;">Add Media</button>&nbsp;<button type="button" class="btn btn-primary btn-sm mb-2" onClick="CheckDevice(<?=$order_item_list_data['id']?>,'');return false;">Check Device</button>
											<?php
											if(!empty($order_item_testing_data)) { ?>
											<button type="button" class="btn btn-primary btn-sm mb-2" onClick="CheckDevice(<?=$order_item_list_data['id']?>,'checked','<?=_dt_parse($order_item_list_data['device_title'].($order_item_list_data['device_title']!="" && $order_item_list_data['model_title']!=""?' - ':'').$order_item_list_data['model_title'])?>');return false;">Checked</button>
											<?php
											} ?>
										</div>
										<?php
										$ii_n = 0;
										$item_images_array = json_decode($order_item_list_data['images_from_shop'],true);
										if(!empty($item_images_array)) {
											echo '<div class="form-group m-form__group">';
											foreach($item_images_array as $ii_k=>$ii_v) {
												if($ii_v) {
												$ii_n = $ii_n+1; ?>
												<?php /*?><img src="<?=SITE_URL?>images/order/items/<?=$ii_v?>" width="100" class="my-md-2"><?php */?>
												<a class="btn btn-info btn-sm" href="<?=SITE_URL?>images/order/items/<?=$ii_v?>" target="_blank" style="margin-top:5px;"><img src="<?=SITE_URL?>images/icons/image-icon.png" alt="Photo-<?=$ii_n?>"> Photo-<?=$ii_n?></a>&nbsp;<a class="btn btn-danger btn-sm" data-dismiss="fileupload" href="controllers/order/order.php?d_item_img=<?=$item_id?>&order_id=<?=$order_id?>&img=<?=$ii_v?>&order_mode=<?=$post['order_mode']?>" onclick="return confirm('Are you sure to delete this image?');" style="margin-top:5px;">Remove</a><br />					
												<?php
												}
											}
											echo '</div>';
										}
										$item_videos_array = json_decode($order_item_list_data['videos_from_shop'],true);
										if(!empty($item_videos_array)) {
											echo '<div class="form-group m-form__group">';
											foreach($item_videos_array as $iv_k=>$iv_v) {
												if($iv_v) { ?>
												<a class="btn btn-success btn-sm" target="_blank" href="<?=$iv_v?>" style="margin-top:5px;">Video <?=$iv_k_n=$iv_k_n+1?></a>&nbsp;<a class="btn btn-danger btn-sm" href="controllers/order/order.php?d_item_video=<?=$item_id?>&order_id=<?=$order_id?>&img=<?=$iv_v?>&order_mode=<?=$post['order_mode']?>" onclick="return confirm('Are you sure to delete this image?');" style="margin-top:5px;">Remove</a><br />
												<?php
												}
											}
											echo '</div>';
										} ?>
										</td>
										<td>
											<div class="form-group m-form__group">
											  <select name="status[<?=$item_id?>]" id="status[]" class="form-control">
											  		<?php
													if(!empty($order_item_status_list)) {
														foreach($order_item_status_list as $order_item_status_data) { ?>
															<option value="<?=$order_item_status_data['id']?>" <?php if($order_item_list_data['item_status']==$order_item_status_data['id']){echo 'selected="selected"';}?>><?=$order_item_status_data['name']?></option>
														<?php
														}
													} ?>
												</select>
											</div>
										</td>
										<td>
											<?php
											if($prms_order_edit_price == '1') { ?>
												<input type="text" class="form-control m-input item_price" id="price[]" name="price[<?=$item_id?>]" value="<?=$order_item_list_data['price']?>">
											<?php
											} else { ?>
												<?=amount_fomat($order_item_list_data['price'])?>
												<input type="hidden" class="form-control m-input item_price" id="price[]" name="price[<?=$item_id?>]" value="<?=$order_item_list_data['price']?>">
											<?php
											} ?>
										</td>
										<?php
										if($prms_order_delete_item == '1') { ?>
										<td>
											<a href="controllers/order/order.php?remove_item_id=<?=$item_id?>&order_id=<?=$post['order_id']?>&order_mode=<?=$post['order_mode']?>" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" onclick="return confirm('Are you sure you want to remove this item?')"><i class="la la-trash"></i></a>
										</td>
										<?php
										} ?>
									</tr>
                              	<?php
              					} ?>
                                <tr>
                                  <td colspan="4">&nbsp;</td>
                                  <td colspan="4" align="right"><strong>Sell Order Total:</strong> <strong id="item_price_total"><?=($sum_of_orders>0?amount_fomat($sum_of_orders):'')?></strong></td>
                                </tr>
                                <?php
								if($promocode_amt>0 || $f_express_service_price>0 || $f_shipping_insurance_price>0) {
								  if($promocode_amt>0) { ?>
                                  <tr>
                                    <td colspan="6"><strong><?=$discount_amt_label?></strong></td>
                                    <td colspan="2" align="right"><strong id="item_promo_total"><?=amount_fomat($promocode_amt)?></strong></td>
									<input type="hidden" name="promocode_amt" id="promocode_amt" value="<?=$promocode_amt?>" />
                                  </tr>
                                  <?php
								  }
								  if($f_express_service_price>0) { ?>
									<tr>
										<td colspan="6"><strong>Express Service:</strong></td>
										<td colspan="2" align="right"><strong id="item_express_service_price">-<?=amount_fomat($f_express_service_price)?></strong></td>
										<input type="hidden" name="express_service_price" id="express_service_price" value="<?=$f_express_service_price?>" />
									</tr>
								  <?php
								  }
								  if($f_shipping_insurance_price>0) { ?>
									<tr>
										<td colspan="6"><strong>Shipping Insurance:</strong></td>
										<td colspan="2" align="right"><strong id="item_shipping_insurance_price">-<?=amount_fomat($f_shipping_insurance_price)?></strong></td>
										<input type="hidden" name="shipping_insurance_price" id="shipping_insurance_price" value="<?=$f_shipping_insurance_price?>" />
									</tr>
								  <?php
								  } ?>
								  <tr>
                                    <td colspan="6"><strong>Total:</strong></td>
                                    <td colspan="2" align="right"><strong id="price_f_total"><?=amount_fomat($total_of_order)?></strong></td>
                                  </tr>
								<?php
								}
								} else {
									echo '<tr><td colspan="8" align="center">No Record Found.</td></tr>';
								} ?>
                          </tbody>
						</table>
						<table style="float:right;">
							<tbody>
								<tr>
									<td align="right"><button class="btn btn-alt btn-medium btn-primary" type="submit" name="update_order">Update</button></td>
								</tr>
							</tbody>
						</table>
						<input type="hidden" name="order_id" id="order_id" value="<?=$post['order_id']?>" />
						<input type="hidden" name="order_mode" id="order_mode" value="<?=$post['order_mode']?>">
					    </form>
                      </div>
                    </div>
                    <?php /*?><div class="row">
                      <div class="col-md-12 my-4">
                        <form action="controllers/order/order.php" role="form" class="form-horizontal form-groups-bordered" method="post" onSubmit="return check_o_status_form(this);" enctype="multipart/form-data">
                          <fieldset>
						  	<div class="row">
								<div class="col-md-6">
									<div class="form-group m-form__group">
									  <label for="input">Order Status: </label>
									  <select name="status" id="status" class="form-control" onchange="ChangeOrderStatus(this.value);">
											<?php
											if(!empty($order_status_list)) {
												foreach($order_status_list as $order_status_data) { ?>
													<option value="<?=$order_status_data['id']?>" <?php if($order_data_before_saved['status']==$order_status_data['id']){echo 'selected="selected"';}?>><?=$order_status_data['name']?></option>
												<?php
												}
											} ?>
										</select>
									 </div>
								</div>
								<div class="col-md-6">
									<div class="showhide_email_template_list" style="display:none;">
										<div id="email_template_list"></div>
									</div>
								</div>
                            </div>

                            <div class="form-group m-form__group">
                              <label for="input">Email Content: </label>
							  <div id="email_template_content">
                              <textarea class="form-control m-input summernote" name="note" id="note" placeholder="note" rows="10"><?=$email_body_text?></textarea>
							  </div>
                            </div>

                            <div class="form-group m-form__group">
								<div class="col-md-12">
									<label for="input">&nbsp;</label>
									<div class="custom-file">
										<input type="file" class="custom-file-input" name="image" onChange="checkFile(this);">
										<label class="custom-file-label" for="image">
											Choose file
										</label>
									</div>
								</div>
							</div>
							
							<?php
							if($order_data_before_saved['unsubscribe'] == '1') { ?>
								<div class="alert alert-info alert-dismissible fade show" role="alert">
									Message will not send because this customer unsubscribed automated message.
								</div>
							<?php
							} ?>
							
                            <div class="form-actions">
                              <button class="btn btn-primary" type="submit" name="update"><?=($order_id?'Update':'Save')?></button>
                              <a href="<?=$back_url?>" class="btn btn-secondary">Back</a>
                            </div>
                          </fieldset>
                          <input type="hidden" name="order_id" id="order_id" value="<?=$post['order_id']?>" />
						  <input type="hidden" name="order_mode" id="order_mode" value="<?=$post['order_mode']?>">
                        </form>
                      </div>
                    </div><?php */?>
									</div>
								</div>
								<!--end::Section-->
							</div>
						</div>
        	</div>
        </div>
        <?php /*?><div class="row">
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
						<?php
						$order_data = get_order_data($order_id);
						if($order_data_before_saved['payment_method']=="paypal") {
							$exp_currency = @explode(",",$general_setting_data['currency']);
							$currency = $exp_currency[0]; ?>
							<div class="form-group m-form__group">
								<form class="form-horizontal form-groups-bordered" action="payment/payments.php" method="post" id="paypal_form" target="_blank">
								  <input type="hidden" name="cmd" value="_xclick" />
								  <input type="hidden" name="currency_code" value="<?=$currency?>" />
								  <input type="hidden" name="payer_email" value="" />
								  <input type="hidden" name="business" value="<?=(!empty($payment_method_details['email_address'])?$payment_method_details['email_address']:'')?>" />
								  <input type="hidden" name="item_number" value="<?=$order_id?>" />
								  <input type="hidden" name="no_shipping" value="1" />
								  <input type="hidden" name="amount" value="<?=$total_of_order?>" />
								  <div class="form-actions">
									<button class="btn btn-alt btn-large btn-success" type="submit" name="update">Pay Now</button>
								  </div>
								</form>
							</div>
						<?php
						} ?>

						<form action="controllers/order/order.php" role="form" method="post" class="form-horizontal form-groups-bordered" onSubmit="return check_form(this);" enctype="multipart/form-data">
							<div class="form-group m-form__group row">
								<div class="col-md-3">
									<label for="item_id">Choose Item</label>
									<select name="item_id" id="item_id" class="form-control">
									<option value=""> - Select - </option>
									<?php
									if($order_num_of_rows>0) {
										foreach($order_item_list as $order_item_list_data) {
											$order_item_data = get_order_item($order_item_list_data['id'],'general');
											$device_title_item = $order_item_list_data['device_title'].($order_item_list_data['device_title']!="" && $order_item_data['device_type']!=""?' - ':'').$order_item_data['device_type']; ?>
											<option value="<?=$order_item_list_data['id']?>"><?=$device_title_item?></option>
										<?php
										}
									} ?>
									</select>
								</div>
								<div class="col-md-3">
									<label for="payment_paid_amount">Price Amount *</label>
									<input type="text" class="form-control m-input" id="payment_paid_amount" value="<?=($order_data['payment_paid_amount']>0?$order_data['payment_paid_amount']:$total_of_order)?>" name="payment_paid_amount" onkeyup="this.value=this.value.replace(/[^\d\.]/,'')" required>
								</div>
								<div class="col-md-3">
									<label for="transaction_id">Transaction/Reference ID</label>
									<input type="text" class="form-control m-input" id="transaction_id" name="transaction_id" value="<?=$order_data['transaction_id']?>">
								</div>
								<div class="col-md-3">
									<label for="payment_paid_method">Payment Method *</label>
									<select name="payment_paid_method" id="payment_paid_method" class="form-control" required>
										<option value=""> - Select - </option>
										<?php
										foreach($choosed_payment_option as $po_k=>$po_v) { ?>
										<option value="<?=$po_v?>" <?php if($order_data_before_saved['payment_paid_method']==$po_v){echo 'selected="selected"';}?>><?=replace_us_to_space($po_v)?></option>
										<?php
										} ?>
									</select>
								</div>
								<div class="col-md-3">
									<label for="payment_paid_date">Payment Date *</label>
									<input type="date" class="form-control m-input" id="payment_paid_date" name="payment_paid_date" value="<?=$order_data['payment_paid_date']?>" required>
								</div>
							</div>
							
							<div class="form-group m-form__group">
								<label for="fileInput">Payment Receipt</label>
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
								<label for="payment_paid_note">Additional Note </label>
								<textarea class="form-control m-input" name="payment_paid_note" id="payment_paid_note" rows="5"><?=$order_data['payment_paid_note']?></textarea>
							</div>
						
							<?php
							if($order_data_before_saved['payment_method']=="cheque") { ?>
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
								<input type="hidden" name="order_mode" id="order_mode" value="<?=$post['order_mode']?>">
						</form>
							</div>
						</div>
						<div class="m-section">
						<div class="m-section__content">
						  <h4>Order status & payment history</h4>
						  <table class="table">
							<?php
							$order_payment_status_list = get_order_payment_status_log($order_id);
							foreach($order_payment_status_list as $order_payment_status_data) {
								$log_type = $order_payment_status_data['log_type'];
								$order_status = isset($order_payment_status_data['order_status'])?$order_payment_status_data['order_status']:"";
								$item_status = isset($order_payment_status_data['item_status'])?$order_payment_status_data['item_status']:"";
								$status_log_date = format_date($order_payment_status_data['date']).' '.format_time($order_payment_status_data['date']);
								$item_id = $order_payment_status_data['item_id'];
								$shipment_tracking_code = isset($order_payment_status_data['shipment_tracking_code'])?$order_payment_status_data['shipment_tracking_code']:"";
								
								$oh_const_patterns = array(
									'{$status_log_date}',
									'{$shipment_tracking_code}',
									'{$company_name}',
									'{$item_id}'
								);
								
								$oh_const_replacements = array(
									$status_log_date,
									($shipment_tracking_code?'# '.$shipment_tracking_code:''),
									$company_name,
									$item_id
								);
								
								if($log_type == "payment") { ?>
								<tr>
								  <td>
									<?php
									echo $status_log_date?> - <?=$company_name?> paid <?=amount_fomat($order_payment_status_data['paid_amount'])?> by <?=replace_us_to_space($order_data_before_saved['payment_method'])?> for device #<?=$item_id.($order_payment_status_data['transaction_id']?', transaction id: '.$order_payment_status_data['transaction_id']:'');
									$payment_receipt_array = json_decode($order_payment_status_data['payment_receipt'],true);
									if(!empty($payment_receipt_array)) {
										echo '<br>';
										$pr_v_n = 1;
										foreach($payment_receipt_array as $pr_k=>$pr_v) {
											if($pr_v) {
												$pr_v_n = $pr_v_n+1; ?>
												<a class="attachment-btn" target="_blank" href="<?=SITE_URL?>images/order/payment/<?=$pr_v?>"><img src="<?=SITE_URL?>images/icons/image-icon.png" alt="Photo-0<?=$pr_v_n?>"> Photo-0<?=$pr_v_n?></a>
											<?php
											}
										}
									}
									if($order_payment_status_data['cheque_photo']) { ?>
										<a class="attachment-btn" target="_blank" href="<?=SITE_URL?>images/order/payment/<?=$order_payment_status_data['cheque_photo']?>"><img src="<?=SITE_URL?>images/icons/image-icon.png" alt="Photo-0<?=$pr_v_n+1?>"> Photo-0<?=$pr_v_n+1?></a>
									<?php
									} ?>
								  </td>
								</tr>
								<?php
								} elseif($order_status > 0) {
									$order_status_data_for_hist = get_order_status_data('order_status',"",$order_status)['data'];
									if($order_status_data_for_hist['text_in_order_history']) {
										$order_status_data_for_hist['text_in_order_history'] = str_replace($oh_const_patterns, $oh_const_replacements, $order_status_data_for_hist['text_in_order_history']); ?>
										<tr>
										  <td>
											<?=$order_status_data_for_hist['text_in_order_history']?>
										  </td>
										</tr>
									<?php
									} else { ?>
										<tr>
										  <td>
											<?=$status_log_date?> - <?=$company_name?> <?=replace_us_to_space($order_status_data_for_hist['name'])?> the order
										  </td>
										</tr>
									<?php
									}
								} elseif($item_status > 0) {
									$order_item_status_data_for_hist = get_order_status_data('order_item_status',"",$item_status)['data'];
									if($order_item_status_data_for_hist['text_in_order_history']) {
										$order_item_status_data_for_hist['text_in_order_history'] = str_replace($oh_const_patterns, $oh_const_replacements, $order_item_status_data_for_hist['text_in_order_history']); ?>
										<tr>
										  <td>
											<span class="d-none d-md-block"><?=$order_item_status_data_for_hist['text_in_order_history']?></span>
											<span class="d-lg-none"><?=$order_item_status_data_for_hist['text_in_order_history']?></span>
										  </td>
										</tr>
									<?php
									} else { ?>
										<tr>
										  <td>
											<span class="d-none d-md-block"><?=$status_log_date?> - <?=$company_name?> <?=replace_us_to_space($order_item_status_data_for_hist['name'])?> for device #<?=$item_id?></span>
											<span class="d-lg-none"><?=$status_log_date?> - <?=$company_name?> <?=replace_us_to_space($order_item_status_data_for_hist['name'])?> for device #<?=$item_id?></span>
										  </td>
										</tr>
									<?php
									}
								}
							} ?>
						  </table>
						
							</div>
						</div>
						<!--end::Section-->
					</div>
				</div>
        	</div>
        </div><?php */?>
		
		
		<?php
		//$contractor_concept ?>
		<?php /*?><div class="row">
			<div class="col-md-12">
				<div class="m-portlet m-portlet--tab">
					<div class="m-portlet__head">
						<div class="m-portlet__head-caption">
							<div class="m-portlet__head-title">
								<span class="m-portlet__head-icon m--hide">
									<i class="la la-gear"></i>
								</span>
								<h3 class="m-portlet__head-text">
									Assign to Contractor
								</h3>
							</div>
						</div>
					</div>
					
					<form action="controllers/order/order.php" method="post" class="m-form m-form--fit m-form--label-align-right">
					<div class="m-portlet__body m--padding-top-10 m--padding-bottom-10">
						<?php
						if($contractor_concept == '1') { ?>
						<div class="form-group m-form__group">
							<!--<h4 class="m-section__heading">Assign to Contractor</h4>-->
							<a class="btn btn-md btn-primary" data-toggle="modal" href="#demoModal">Assign to Contractor</a>
							<?php
							if(!empty($assigned_contractor_data)) { ?>
								<br />
								<span class="m-form__help">Already Assigned: <a href="edit_contractor.php?id=<?=$assigned_contractor_data['id']?>"><?=$assigned_contractor_data['name'].'('.$assigned_contractor_data['phone'].')'?></a></span>
							<?php
							} ?>
						</div>
						<?php
						} ?>
						<input type="hidden" name="order_id" id="order_id" value="<?=$post['order_id']?>" />
						<input type="hidden" name="order_mode" id="order_mode" value="<?=$post['order_mode']?>">	
					</div>
					<div class="m-portlet__foot m-portlet__foot--fit">
						<div class="m-form__actions">
							<a href="<?=$back_url?>" class="btn btn-secondary">Back</a>
						</div>
					</div>
					</form>
				</div>
			</div>
		</div><?php */?>

		<?php
		//if($assigned_contractor_data['contractor_id']>0) { ?>
		<div class="row">
			<div class="col-md-12">
				<div class="m-portlet m-portlet--tab">
					<div class="m-portlet__head">
						<div class="m-portlet__head-caption">
							<div class="m-portlet__head-title">
								<span class="m-portlet__head-icon m--hide">
									<i class="la la-gear"></i>
								</span>
								<h3 class="m-portlet__head-text">
									Leave Comments
								</h3>
							</div>
						</div>
					</div>
					
					<form action="controllers/order/order.php" method="post" class="m-form m-form--fit m-form--label-align-right comment_form">
					<div class="m-portlet__body m--padding-top-10 m--padding-bottom-10">
						
						<div class="form-group m-form__group">
							<label>Order Status</label>
							<select name="c_status" id="c_status" class="form-control m-input">
								<option value=""> -Select- </option>
								<?php
								if(!empty($order_status_list)) {
									foreach($order_status_list as $order_status_data) { ?>
										<option value="<?=$order_status_data['id']?>" <?php if($order_data_before_saved['status']==$order_status_data['id']){echo 'selected="selected"';}?>><?=$order_status_data['name']?></option>
									<?php
									}
								} ?>
							</select>
						</div>
						
						<div class="form-group m-form__group">
							<label>Comment * </label>
							<textarea class="form-control m-input m-input--square" name="comment" id="comment" placeholder="Comment" rows="3" required></textarea>
						</div>
						
						<input type="hidden" name="contractor_id" id="contractor_id" value="<?=$admin_l_id?>" />
						<input type="hidden" name="order_id" id="order_id" value="<?=$post['order_id']?>" />
						<input type="hidden" name="order_mode" id="order_mode" value="<?=$post['order_mode']?>">
						
						<div class="form-group m-form__group">
						<h4 class="m-section__heading">Comments History</h4>
						<div class="chat-messages" style="overflow-y:auto; max-height:350px;">
							<table class="table" width="100%">
								<tbody class="apd-chat-message">
									<small class="showhide_history_not_available"></small>
									<?php
									if($num_of_comment>0) {
										while($comment_list = mysqli_fetch_assoc($comment_query)) {
											if($comment_list['thread_type'] == "contractor") { ?>
												<tr>
													<td>
														<img src="img/user-avatar.png" width="15">
														<span><?=format_date($comment_list['date']).' '.format_time($comment_list['date'])?> <span class="label label-success"><?=$comment_list['status_name']?></span></span>
														<p><?=$comment_list['comment']?></p>
													</td>
												</tr>
											<?php
											} else { ?>
												<tr>
													<td style="text-align:right;">
														<span><?=format_date($comment_list['date']).' '.format_time($comment_list['date'])?> <span class="label label-success"><?=$comment_list['status_name']?></span></span><img src="img/admin_avatar.png" width="15">
														<p style="text-align:left;"><?=$comment_list['comment']?></p>
													</td>
												</tr>
											<?php
											}
										}
									} else {
										echo '<small class="showhide_history_not_available">History Not Available</small>';
									} ?>
								</tbody>
							</table>
						</div>
						</div>	
					</div>
					</form>
				</div>
			</div>
		</div>
		<?php
		//} ?>
		

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

<div class="modal fade" id="demoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Assign to contractor</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			
			<form action="controllers/order/order.php" method="post">
			<div class="modal-body">
				<div class="form-group m-form__group">
					<label>Contractor * </label>
					<select required="required" id="contractor_id" name="contractor_id" class="form-control m-input">
						  <option value=""> - Select - </option>
						  <?php
						  $contractor_data_list = get_contractor_list();
						  $contr_num_of_rows = count($contractor_data_list);
						  if($contr_num_of_rows>0) {
							  foreach($contractor_data_list as $contractor_data) { ?>
								<option value="<?=$contractor_data['id']?>" <?php if($contractor_data['id'] == $assigned_contractor_data['contractor_id']) {echo 'selected="selected"';}?>><?=$contractor_data['company_name']?></option>
							  <?php
							  }
						  } ?>
					</select>
					<span class="m-form__help contractor_info"><?=($assigned_contractor_data['contractor_id']>0?'<b>Name:</b> '.$assigned_contractor_data['name'].'<br><b>Email:</b> '.$assigned_contractor_data['email'].'<br><b>Phone:</b> '.$assigned_contractor_data['phone']:'')?></span>
				</div>
				
				<div class="form-group m-form__group">
					<label>Amount *</label>
					<input type="number" required="required" class="form-control m-input m-input--square" id="amount" value="<?=$assigned_contractor_data['amount']?>" name="amount">
				</div>
			</div>
			
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary" name="assign_to_contractor">Assign</button>
			</div>
			
			<input type="hidden" name="order_id" id="order_id" value="<?=$post['order_id']?>" />
			<input type="hidden" name="order_mode" id="order_mode" value="<?=$post['order_mode']?>">
			</form>
		</div>
	</div>
</div>

<div class="modal fade common_popup" id="ShippingInfo" role="dialog">
    <div class="modal-dialog modal-sm" role="document" style="min-width:500px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Shipping Info</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div style="overflow-y:auto; max-height:350px;">
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
							echo '<dd><strong>Date:</strong> '.($shipment->tracker->created_at).'</dd>';
							echo '<dd><strong>Tracking Code:</strong> '.$shipment->tracker->tracking_code.'</dd>';
							echo '<dd><strong>Est. Delivery Date:</strong> '.($shipment->tracker->est_delivery_date).'</dd>';
							echo '<dd><strong>Status:</strong> '.$shipment->tracker->status.'</dd>';
							echo '<dd><strong>Public Url:</strong> <a target="_blank" href="'.$shipment->tracker->public_url.'">Click Here To See</a></dd>';
							
							echo '<h5 style="margin-top:20px;">History</h5>';
							foreach($shipment->tracker->tracking_details as $tracking_details) {
								echo '<dd><strong>'.($tracking_details->datetime).'</strong><br>'.$tracking_details->message.'</dd>';
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
					} ?>
				</div>	
			</div>
        </div>
    </div>
</div>

<div class="modal fade common_popup" id="EditShippingInfo" role="dialog">
    <div class="modal-dialog modal-sm" role="document" style="min-width:800px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Shipping Address (Edit)</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="controllers/order/order.php" method="post">
			<div class="modal-body">
				<div class="form-group row">
					<div class="form_group col-sm-4">
						<label>First Name</label>
						<input type="text" class="form-control m-input" name="shipping_first_name" id="shipping_first_name"  value="<?=$order_data_before_saved['shipping_first_name']?>" autocomplete="nope">
					</div>
					<div class="form_group col-sm-4">
						<label>Last Name</label>
						<input type="text" class="form-control m-input" name="shipping_last_name" id="shipping_last_name" value="<?=$order_data_before_saved['shipping_last_name']?>" autocomplete="nope">
					</div>
					<div class="form_group col-sm-4">
						<label>Company</label>
						<input type="text" class="form-control m-input" name="shipping_company_name" id="shipping_company_name"  value="<?=$order_data_before_saved['shipping_company_name']?>" autocomplete="nope">
					</div>
				</div>
				<div class="form-group row">
					<div class="form_group col-sm-6">
						<label>Address</label>
						<input type="text" class="form-control m-input" name="shipping_address" id="shipping_address" value="<?=$order_data_before_saved['shipping_address1']?>" autocomplete="nope">
						<small id="shipping_address_error_msg" class="help-block m_validations_showhide" style="display:none;"></small>
					</div>
					<div class="form_group col-sm-6">
						<label>Address2</label>
						<input type="text" class="form-control m-input" name="shipping_address2" id="shipping_address2"  value="<?=$order_data_before_saved['shipping_address2']?>" autocomplete="nope">
					</div>
				</div>
				<div class="form-group row">
					<div class="form_group col-sm-3">
						<label>City</label>
						<input type="text" class="form-control m-input" name="shipping_city" id="shipping_city" value="<?=$order_data_before_saved['shipping_city']?>" autocomplete="nope">
					</div>
					<div class="form_group col-sm-3">
						<label>State</label>
						<input type="text" class="form-control m-input" name="shipping_state" id="shipping_state" value="<?=$order_data_before_saved['shipping_state']?>" autocomplete="nope">
					</div>
					<div class="form_group col-sm-3">
						<label>Postcode</label>
						<input type="text" class="form-control m-input" name="shipping_postcode" id="shipping_postcode" value="<?=$order_data_before_saved['shipping_postcode']?>" autocomplete="nope">
					</div>
					<div class="form_group col-sm-3">
						<label>Phone</label>
						<input type="tel" id="shipping_phone" name="shipping_phone" class="form-control m-input">
						<input type="hidden" name="shipping_phone_c_code" id="shipping_phone_c_code" value="<?=$order_data_before_saved['shipping_country_code']?>"/>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" name="shipping_change" id="shipping_change" class="btn btn-primary" onclick="return check_shipping_info_form();">Update</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
			<input type="hidden" name="order_id" id="order_id" value="<?=$post['order_id']?>" />
			<input type="hidden" name="order_mode" id="order_mode" value="<?=$post['order_mode']?>">
			</form>
        </div>
    </div>
</div>

<div class="modal fade common_popup" id="EditPaymentMethod" role="dialog">
    <div class="modal-dialog modal-sm" role="document" style="min-width:800px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Payment Details (Edit)</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="controllers/order/order.php" method="post">
			<div class="modal-body">
				<div id="payment_box">
					<?php
					if($order_data_before_saved['payment_method']!="") {
						$default_payment_option = $order_data_before_saved['payment_method'];
					}
					
					if($choosed_payment_option['bank']=="bank") { ?>
						<div class="head_row bank_transfer_head pmnt_bank_opt <?php if($default_payment_option=="bank"){echo 'active';}?> clearfix"><span class="round_box">&nbsp;</span><span class="icon"></span><span class="title">Bank Transfer</span></div>
						<div class="detail_row bank_transfer_detail clearfix <?php if($default_payment_option=="bank"){echo 'active';}?>">
							<div class="inner_box row">
								<div class="form_group col-sm-4">
									<label>Account Holder Name</label>
									<input type="text" class="textbox" id="act_name" name="act_name" placeholder="Account Holder Name" value="<?=(!empty($payment_method_details['account_holder_name'])?$payment_method_details['account_holder_name']:'')?>" autocomplete="nope">
								</div>
								<div class="form_group col-sm-4">
									<label>Account Number</label>
									<input type="text" class="textbox" id="act_number" name="act_number" placeholder="Account Number" value="<?=(!empty($payment_method_details['account_number'])?$payment_method_details['account_number']:'')?>" autocomplete="nope">
								</div>
								<div class="form_group col-sm-4">
									<label>Short Code</label>
									<input type="text" class="textbox" id="act_short_code" name="act_short_code" placeholder="Short Code" value="<?=(!empty($payment_method_details['short_code'])?$payment_method_details['short_code']:'')?>" autocomplete="nope">
								</div>
							</div>
						</div>
					<?php
					}
					if($choosed_payment_option['cheque']=="cheque") { ?>
						<div class="head_row cheque_head pmnt_cheque_opt <?php if($default_payment_option=="cheque"){echo 'active';}?>">
							<span class="round_box">&nbsp;</span>
							<span class="icon">i</span>
							<span class="title"><?=$cheque_check_label?></span>
							
						</div>
					<?php
					}
					if($choosed_payment_option['paypal']=="paypal") { ?>
						<div class="head_row paypal_head pmnt_paypal_opt <?php if($default_payment_option=="paypal"){echo 'active';}?>">
							<span class="round_box">&nbsp;</span>
							<span class="icon">i</span>
							<span class="title">Paypal</span>
							
						</div>
						<div class="detail_row paypal_detail clearfix <?php if($default_payment_option=="paypal"){echo 'active';}?>">
							<div class="inner_box row">
								<div class="form_group col-sm-6">
									<label>PayPal Address</label>
									<input type="text" class="textbox" placeholder="PayPal Address" id="paypal_address"  name="paypal_address" value="<?=(!empty($payment_method_details['email_address'])?$payment_method_details['email_address']:'')?>" autocomplete="nope">
								</div>
								<div class="form_group col-sm-6">
									<label>Confirm PayPal Address</label>
									<input type="text" class="textbox" placeholder="Confirm PayPal Address" id="confirm_paypal_address"  name="confirm_paypal_address" value="<?=(!empty($payment_method_details['email_address'])?$payment_method_details['email_address']:'')?>" autocomplete="nope">
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
							
						</div>
						<div class="detail_row venmo_detail clearfix <?php if($default_payment_option=="venmo"){echo 'active';}?>">
							<div class="inner_box row">
								<div class="form_group col-sm-12">
									<label>Venmo Email Address</label>
									<input type="text" class="textbox" placeholder="Venmo Email Address" id="venmo_email_address"  name="venmo_email_address" value="<?=(!empty($payment_method_details['email_address'])?$payment_method_details['email_address']:'')?>" autocomplete="nope">
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
							
						</div>
						<div class="detail_row zelle_detail clearfix <?php if($default_payment_option=="zelle"){echo 'active';}?>">
							<div class="inner_box row">
								<div class="form_group col-sm-12">
									<label>Zelle Email Address</label>
									<input type="text" class="textbox" placeholder="Zelle Email Address" id="zelle_email_address"  name="zelle_email_address" value="<?=(!empty($payment_method_details['email_address'])?$payment_method_details['email_address']:'')?>" autocomplete="nope">
								</div>
							</div>
						</div>
					<?php
					}
					if($choosed_payment_option['amazon_gcard']=="amazon_gcard") { ?>
						<div class="head_row amazon_gcard_head pmnt_amazon_gcard_opt <?php if($default_payment_option=="amazon_gcard"){echo 'active';}?>">
							<span class="round_box">&nbsp;</span>
							<span class="icon">i</span>
							<span class="title">Amazon GCard</span>
							
						</div>
						<div class="detail_row amazon_gcard_detail clearfix <?php if($default_payment_option=="amazon_gcard"){echo 'active';}?>">
							<div class="inner_box row">
								<div class="form_group col-sm-12">
									<label>Amazon GCard Email Address</label>
									<input type="text" class="textbox" placeholder="Amazon GCard Email Address" id="amazon_gcard_email_address"  name="amazon_gcard_email_address" value="<?=(!empty($payment_method_details['email_address'])?$payment_method_details['email_address']:'')?>" autocomplete="nope">
								</div>
							</div>
						</div>
					<?php
					}
					if($choosed_payment_option['cash']=="cash") { ?>
						<div class="head_row cash_head pmnt_cash_opt <?php if($default_payment_option=="cash"){echo 'active';}?> clearfix"><span class="round_box">&nbsp;</span><span class="icon"></span><span class="title">Cash</span></div>
						<div class="detail_row cash_detail clearfix <?php if($default_payment_option=="cash"){echo 'active';}?>">
							<div class="inner_box row">
								<div class="form_group col-sm-6">
									<label>Cash Name</label>
									<input type="text" class="textbox" id="cash_name" name="cash_name" placeholder="Cash Name" value="<?=(!empty($payment_method_details['cash_name'])?$payment_method_details['cash_name']:'')?>" autocomplete="nope">
								</div>
								<div class="form_group col-sm-6">
									<label>Cash Phone</label>
									<input type="text" class="textbox" id="cash_phone" name="cash_phone" placeholder="Cash Phone" value="<?=(!empty($payment_method_details['cash_phone'])?$payment_method_details['cash_phone']:'')?>" autocomplete="nope">
								</div>
							</div>
						</div>
					<?php
					} ?>
				</div>	
			</div>
			<div class="modal-footer">
				<button type="submit" name="pmt_change" id="pmt_change" class="btn btn-primary" onclick="return check_pmt_method_form();">Update</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
			<input type="hidden" id="payment_method" name="payment_method" value="<?=$default_payment_option?>" />
			<input type="hidden" name="order_id" id="order_id" value="<?=$post['order_id']?>" />
			<input type="hidden" name="order_mode" id="order_mode" value="<?=$post['order_mode']?>">
			</form>
        </div>
    </div>
</div>

<div class="modal fade" id="import_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm" role="document" style="min-width:800px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Edit Model</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="controllers/order/order.php" method="POST" class="m-form" id="model_details_form" onSubmit="return chechdata();" enctype="multipart/form-data">
				<div class="modal-body">
					<div class="m-portlet__body">
						<div class="m-form__section m-form__section--first model_form_data">

						</div>
					</div>
				</div>
				<input type="hidden" name="order_id" id="order_id" value="<?=$order_id?>"/>
				<input type="hidden" name="order_mode" id="order_mode" value="<?=$post['order_mode']?>">
			</form>

		</div>
	</div>
</div>

<div class="modal fade" id="device_item_check_popup" tabindex="-1" role="dialog" aria-labelledby="device_item_check_infol" aria-hidden="true">
	<div class="modal-dialog modal-sm" role="document" style="min-width:800px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="device_item_check_infol">Device Info</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="m-portlet__body">
					<div class="m-form__section m-form__section--first device_item_check_data">

					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="device_item_view_popup" tabindex="-1" role="dialog" aria-labelledby="device_item_view_infol" aria-hidden="true">
	<div class="modal-dialog modal-sm" role="document" style="min-width:800px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="device_item_view_infol">Device Info</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="m-portlet__body">
					<div class="m-form__section m-form__section--first device_item_view_data">

					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
jQuery(document).ready(function($) {
	var maxField = 10;
	
	var addButton = $('.add_item__image');
    var wrapper = $('.item_image__wrapper');
    var x = 1;
 
    //Once add button is clicked
    $(addButton).click(function() {
        //Check maximum number of input fields
        if(x < maxField) { 
            x++; //Increment field counter
			
			var fieldHTML = '<div class="form-group m-form__group row">';
			fieldHTML += '<div class="col-lg-12">';
				fieldHTML += '<div class="row">';
					
					fieldHTML += '<div class="col-md-8">';
						fieldHTML += '<div class="m-form__control">';
							fieldHTML += '<div class="custom-file">';
								fieldHTML += '<input type="file" id="item_image" class="custom-file-input" name="item_image['+x+']" onChange="checkFile(this);" accept="image/*">';
								fieldHTML += '<label class="custom-file-label" for="image">Choose file</label>';
							fieldHTML += '</div>';
						fieldHTML += '</div>';
					fieldHTML += '</div>';

					fieldHTML += '<div class="col-md-4">';
						fieldHTML += '<div class="m-form__control">';
							fieldHTML += '<div class="remove_item__image btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill">';
								fieldHTML += '<span><i class="la la-trash-o"></i><span>Delete</span>';
								fieldHTML += '</span>';
							fieldHTML += '</div>';
						fieldHTML += '</div>';
					fieldHTML += '</div>';
					
				fieldHTML += '</div>';
			fieldHTML += '</div>';
			fieldHTML += '</div>';
										
            $(wrapper).append(fieldHTML); //Add field html
        }
    });
	
	$(wrapper).on('click', '.remove_item__image', function(e){
        e.preventDefault();
        $(this).parent().parent().parent().parent().parent('div').remove();
        x--;
    });
	

	var addButton_2 = $('.add_item__image2');
    var wrapper_2 = $('.item_image__wrapper2');
    var x_2 = 1;
 
    //Once add button is clicked
    $(addButton_2).click(function() {
        //Check maximum number of input fields
        if(x_2 < maxField) { 
            x_2++; //Increment field counter
			
			var fieldHTML_2 = '<div class="form-group m-form__group row">';
			fieldHTML_2 += '<div class="col-lg-12">';
				fieldHTML_2 += '<div class="row">';
					
					fieldHTML_2 += '<div class="col-md-8">';
						fieldHTML_2 += '<div class="m-form__control">';
							fieldHTML_2 += '<input type="url" class="form-control m-input" name="item_video['+x_2+']">';
						fieldHTML_2 += '</div>';
					fieldHTML_2 += '</div>';

					fieldHTML_2 += '<div class="col-md-4">';
						fieldHTML_2 += '<div class="m-form__control">';
							fieldHTML_2 += '<div class="remove_item__image2 btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill">';
								fieldHTML_2 += '<span><i class="la la-trash-o"></i><span>Delete</span>';
								fieldHTML_2 += '</span>';
							fieldHTML_2 += '</div>';
						fieldHTML_2 += '</div>';
					fieldHTML_2 += '</div>';
					
				fieldHTML_2 += '</div>';
			fieldHTML_2 += '</div>';
			fieldHTML_2 += '</div>';
										
            $(wrapper_2).append(fieldHTML_2); //Add field html
        }
    });
	
	$(wrapper_2).on('click', '.remove_item__image2', function(e){
        e.preventDefault();
        $(this).parent().parent().parent().parent().parent('div').remove();
        x_2--;
    });
	
});
</script>

<div class="modal fade" id="item_media_popup" tabindex="-1" role="dialog" aria-labelledby="item_media_popup_l" aria-hidden="true">
	<div class="modal-dialog modal-sm" role="document" style="min-width:800px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="item_media_popup_l">Add Item Media</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="controllers/order/order.php" method="POST" class="m-form" enctype="multipart/form-data">
				<div class="modal-body">
					<div class="m-portlet__body">
						<div class="m-form__section m-form__section--first">
							<div class="row">
								<div class="col-md-6">
									<div class="item_image__wrapper">
										<div class="form-group m-form__group row" style="padding-bottom:0px;">
											<div class="col-lg-12">
												<div class="row">
													<div class="col-md-8">
														<div class="m-form__control">
															<label for="input"><strong>Image</strong></label>
														</div>
													</div>
													<div class="col-md-4">
														<div class="m-form__control">
															<label for="input"><strong>Action</strong></label>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="m-form__group form-group row">
										<div class="col-lg-4">
											<div class="add_item__image btn btn btn-sm btn-brand m-btn m-btn--icon m-btn--pill m-btn--wide">
												<span>
													<i class="la la-plus"></i>
													<span>Add</span>
												</span>
											</div>
										</div>
									</div>
								</div>
							
								<div class="col-md-6">
									<div class="item_image__wrapper2">
										<div class="form-group m-form__group row" style="padding-bottom:0px;">
											<div class="col-lg-12">
												<div class="row">
													<div class="col-md-8">
														<div class="m-form__control">
															<label for="input"><strong>Video</strong></label>
														</div>
													</div>
													<div class="col-md-4">
														<div class="m-form__control">
															<label for="input"><strong>Action</strong></label>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="m-form__group form-group row">
										<div class="col-lg-4">
											<div class="add_item__image2 btn btn btn-sm btn-brand m-btn m-btn--icon m-btn--pill m-btn--wide">
												<span>
													<i class="la la-plus"></i>
													<span>Add</span>
												</span>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" name="add_item_media" id="add_item_media" class="btn btn-primary">Add</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
				<input type="hidden" name="order_id" id="order_id" value="<?=$order_id?>"/>
				<input type="hidden" name="media_item_id" id="media_item_id"/>
				<input type="hidden" name="order_mode" id="order_mode" value="<?=$post['order_mode']?>">
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="check_device_popup" tabindex="-1" role="dialog" aria-labelledby="check_device_popup_l" aria-hidden="true">
	<div class="modal-dialog modal-sm" role="document" style="min-width:800px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="check_device_popup_l">Check Device</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
			
				<!--begin: Form Wizard-->
				<div class="m-wizard m-wizard--2 m-wizard--success" id="m_wizard">
					<!--begin: Message container -->
					<div class="m-portlet__padding-x">
						<!-- Here you can put a message or alert -->
					</div>
					<!--end: Message container -->
					<!--begin: Form Wizard Head -->
					<div class="m-wizard__head m-portlet__padding-x" style="margin-top:25px; display:none;">
						<!--begin: Form Wizard Progress -->
						<div class="m-wizard__progress">
							<div class="progress">
								<div class="progress-bar" role="progressbar"  aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
							</div>
						</div>
						<!--end: Form Wizard Progress -->  
						<!--begin: Form Wizard Nav -->
						<div class="m-wizard__nav">
							<div class="m-wizard__steps">
								<div class="m-wizard__step <?=($is_opn_check_device_pop=="yes"?'':'m-wizard__step--current')?>" m-wizard-target="m_wizard_form_step_1">
									<a href="#" class="m-wizard__step-number">
										<span>
											<i class="fa flaticon-list"></i>
										</span>
									</a>
									<div class="m-wizard__step-info">
										<div class="m-wizard__step-title">
											1. Prepare for testing
										</div>
									</div>
								</div>
								<div class="m-wizard__step" m-wizard-target="m_wizard_form_step_2">
									<a href="#" class="m-wizard__step-number">
										<span>
											<i class="fa flaticon-list"></i>
										</span>
									</a>
									<div class="m-wizard__step-info">
										<div class="m-wizard__step-title">
											2. Detailed testing
										</div>
									</div>
								</div>
								<div class="m-wizard__step <?=($is_opn_check_device_pop=="yes"?'m-wizard__step--current':'')?>" m-wizard-target="m_wizard_form_step_3">
									<a href="#" class="m-wizard__step-number">
										<span>
											<i class="fa flaticon-list"></i>
										</span>
									</a>
									<div class="m-wizard__step-info">
										<div class="m-wizard__step-title">
											3. Finish. Add notes
										</div>
									</div>
								</div>
							</div>
						</div>
						<!--end: Form Wizard Nav -->
					</div>
					<!--end: Form Wizard Head -->  
					<!--begin: Form Wizard Form-->
					<div class="m-wizard__form">
						<form class="m-form m-form--label-align-left- m-form--state- chk_device_frm" id="m_form" action="controllers/order/order.php" method="POST" enctype="multipart/form-data">
							<!--begin: Form Body -->
							<div class="m-portlet__body check_device_fields">
								
							</div>
							<!--end: Form Body -->
							<!--begin: Form Actions -->
							<div class="m-portlet__foot m-portlet__foot--fit m--margin-top-40">
								<div class="m-form__actions">
									<div class="row">
										<div class="col-lg-2"></div>
										<div class="col-lg-4 m--align-left">
											<a href="#" class="btn btn-secondary m-btn m-btn--custom m-btn--icon" data-wizard-action="prev">
												<span>
													<i class="la la-arrow-left"></i>
													&nbsp;&nbsp;
													<span>
														Back
													</span>
												</span>
											</a>
										</div>
										<div class="col-lg-4 m--align-right">
											<button type="submit" name="add_item_chk_device" class="btn btn-primary m-btn m-btn--custom m-btn--icon" data-wizard-action="submit">
												<span>
													<i class="la la-check"></i>
													&nbsp;&nbsp;
													<span>
														Submit
													</span>
												</span>
											</button>
											<a href="#" class="btn btn-warning m-btn m-btn--custom m-btn--icon" data-wizard-action="next">
												<span>
													<span>
														Next
													</span>
													&nbsp;&nbsp;
													<i class="la la-arrow-right"></i>
												</span>
											</a>
										</div>
										<div class="col-lg-2"></div>
									</div>
								</div>
							</div>
							<!--end: Form Actions -->
							<input type="hidden" name="order_id" id="order_id" value="<?=$order_id?>"/>
							<input type="hidden" name="chk_device_item_id" id="chk_device_item_id"/>
							<input type="hidden" name="order_mode" id="order_mode" value="<?=$post['order_mode']?>">
						</form>
					</div>
					<!--end: Form Wizard Form-->
				</div>
				<!--end: Form Wizard-->
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="checked_device_popup" tabindex="-1" role="dialog" aria-labelledby="checked_device_popup_l" aria-hidden="true">
	<div class="modal-dialog modal-sm" role="document" style="min-width:800px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="checked_device_popup_l">Checked Device Info</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body checked_device_fields">
			
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<script src="../js/intlTelInput.js"></script>
<script type="text/javascript">
function check_form(a) {
	if(a.is_payment_sent.checked==false) {
		alert('Mark Payment Sent Checkbox Must Be Checked');
		return false;
	}
}

function check_o_status_form(a) {
	if(jQuery('.summernote').summernote('codeview.isActivated')) {
		jQuery('.summernote').summernote('codeview.deactivate');
	}
}

function checkFile(fieldObj) {
	if(fieldObj.files.length == 0) {
		return false;
	}
	
	var id = fieldObj.id;
	var str  = fieldObj.value;
	var FileExt = str.substr(str.lastIndexOf('.')+1);
	var FileExt = FileExt.toLowerCase(); 
	var FileSize = fieldObj.files[0].size;
	var FileSizeMB = (FileSize/10485760).toFixed(2);

	if((FileExt != "gif" && FileExt != "png" && FileExt != "jpg" && FileExt != "jpeg")){
		var error = "Please make sure your file is in png | jpg | jpeg | gif format.\n\n";
		alert(error);
		document.getElementById(id).value = '';
		return false;
	}
}

function AddItemMedia(item_id) {
	jQuery(document).ready(function($) {
		$('#media_item_id').val(item_id);
		$('#item_media_popup').modal({backdrop: 'static',keyboard: false});
	});
}

function CheckDevice(item_id, mode, model_title) {
	jQuery(document).ready(function($) {
		$('#chk_device_item_id').val(item_id);
		if(mode == "checked") {
			$('#checked_device_popup_l').html(model_title);
			$('#checked_device_popup').modal({backdrop: 'static',keyboard: false});
		} else {
			$('#check_device_popup').modal({backdrop: 'static',keyboard: false});
		}

		post_data = "item_id="+item_id+"&order_id=<?=$order_id?>&order_mode=<?=$post['order_mode']?>&is_opn_check_device_pop=<?=$is_opn_check_device_pop?>&mode="+mode;
		jQuery(document).ready(function($) {
			$.ajax({
				type:"POST",
				url:"ajax/get_check_device_fields.php",
				data:post_data,
				success:function(data) {
					if(data!="") {
						if(mode == "checked") {
							$('.checked_device_fields').html(data);
						} else {
							$('.check_device_fields').html(data);
						}
					}
				}
			});
		});
	});
}

<?php
if($is_opn_check_device_pop == "yes") {
	echo 'CheckDevice('.$sess_item_id.');';
	unset($_SESSION['is_opn_check_device_pop']);
	unset($_SESSION['sess_item_id']);
} ?>

function EditOrder(item_id) {
	//if(item_id>0) {
		post_data = "item_id="+item_id;
		jQuery(document).ready(function($) {
			$.ajax({
				type:"POST",
				url:"ajax/get_model_data.php",
				data:post_data,
				success:function(data) {
					if(data!="") {
						$('.model_form_data').html(data);
					}
				}
			});
			$('#import_modal').modal({backdrop: 'static',keyboard: false});
		});
	//}
}

function ChangeOrderStatus(status) {
	if(status!="") {
		post_data = "status="+status;
		jQuery(document).ready(function($) {
			$.ajax({
				type: "POST",
				url:"ajax/get_email_template_list.php",
				data:post_data,
				success:function(data){
					if(data!="") {
						$('#email_template_list').html(data);
						$('.showhide_email_template_list').show();
					} else {
						ChangeEmailTemplate(33);
						$('#email_template_list').html('');
						$('.showhide_email_template_list').hide();
					}
				}
			});
		});
	}
}
ChangeOrderStatus('<?=$order_data_before_saved['status']?>');

function ChangeEmailTemplate(id) {
	if(id!="") {
		post_data = "id="+id+'&order_id=<?=$post['order_id']?>';
		jQuery(document).ready(function($) {
			$.ajax({
				type: "POST",
				url:"ajax/get_email_template_content.php",
				data:post_data,
				success:function(data){
					if(data!="") {
						$('#email_template_content').html(data);
					}
				}
			});
		});
	}
}

jQuery(document).ready(function ($) {

	$('#contractor_id').on('change', function(e) {
		var contractor_id = $(this).val();
		post_data = {contractor_id:contractor_id};
		jQuery.ajax({
			type: "POST",
			url:"get_contractor_info.php",
			data:post_data,
			success:function(data) {
				if(data!="") {
					var form_data = JSON.parse(data);
					if(form_data.status == true) {
						$('.contractor_info').html(form_data.contractor_info);
					} else {
						alert(form_data.message);
						return false;
					}
				}
			}
		});
	});

	//$('.send_comment').on('click', function(e) {
	$('#comment').on('blur keypress', function(e) {
		var keycode = (e.keyCode ? e.keyCode : e.which);
		if(keycode == '13' || e.type === 'blur'){
			var post_data = $('.comment_form').serialize();
			jQuery.ajax({
				type: "POST",
				url:"ajax/ajax_send_comment.php",
				data:post_data,
				success:function(data) {
					if(data!="") {
						var form_data = JSON.parse(data);
						if(form_data.status == "success") {
							if(form_data.is_comment == "yes") {
								var message = '';
								message += '<tr>';
									message += '<td>';
										message += '<img src="img/admin_avatar.png" width="15">';
										message += '<span>'+form_data.date;
										if(form_data.status_name!="") {
											message += ' <span class="label label-success">'+form_data.status_name+'</span>';
										}
										message += '</span>';
										message += '<p>'+form_data.comments+'</p>';
									message += '</td>';
								message += '</tr>';
								$('.apd-chat-message').prepend(message);
								$('#comment').val('');
								$('#c_status option[value='+form_data.status_id+']').attr('selected', 'selected');
								$('#status option[value='+form_data.status_id+']').attr('selected', 'selected');
								$('.showhide_history_not_available').hide();
							}
						} else {
							return false;
						}
					}
				}
			});
		}
	});
	
	$('.item_price').bind("keyup mouseup",function() {
		//var promocode_amt = '<?=$promocode_amt?>';
		var item_price = 0.00;
		$('.item_price').each(function() {
			item_price += parseFloat(this.value);
		});

		var item_promo_total = 0.00;
		var express_service_price = '<?=($express_service_price>0?$express_service_price:0)?>';
		var shipping_insurance_price = 0.00;

		<?php
		if($order_data_before_saved['discount_type'] == "percentage") { ?>
			var discount = '<?=$order_data_before_saved['discount']?>';
			item_promo_total = (item_price * discount / 100);
			$("#item_promo_total").html('<?=$amount_sign_with_prefix?>'+item_promo_total.toFixed(2)+'<?=$amount_sign_with_postfix?>');
			$("#promocode_amt").val(item_promo_total);
		<?php
		}

		if($shipping_insurance_per) { ?>
			var shipping_insurance_per = '<?=$shipping_insurance_per?>';
			shipping_insurance_price = (item_price*shipping_insurance_per/100);
			$("#item_shipping_insurance_price").html('-<?=$amount_sign_with_prefix?>'+shipping_insurance_price.toFixed(2)+'<?=$amount_sign_with_postfix?>');
			$("#shipping_insurance_price").val(shipping_insurance_price);
		<?php
		} ?>

		$("#item_price_total").html('<?=$amount_sign_with_prefix?>'+item_price.toFixed(2)+'<?=$amount_sign_with_postfix?>');

		//if(promocode_amt>0) {
			item_promo_total = parseFloat(item_promo_total);
			express_service_price = parseFloat(express_service_price);
			shipping_insurance_price = parseFloat(shipping_insurance_price);
			var price_f_total = (item_price + item_promo_total - express_service_price - shipping_insurance_price);
			$("#price_f_total").html('<?=$amount_sign_with_prefix?>'+price_f_total.toFixed(2)+'<?=$amount_sign_with_postfix?>');
		//}
	});
	
	$(".cash_head").click(function(){
		$(this).addClass("active");
		$(".paypal_head").removeClass("active");
		$(".cheque_head").removeClass("active");
		$(".venmo_head").removeClass("active");
		$(".zelle_head").removeClass("active");
		$(".amazon_gcard_head").removeClass("active");
		$(".bank_transfer_head").removeClass("active");
	});
	
	$(".bank_transfer_head").click(function(){
		$(this).addClass("active");
		$(".paypal_head").removeClass("active");
		$(".cheque_head").removeClass("active");
		$(".venmo_head").removeClass("active");
		$(".zelle_head").removeClass("active");
		$(".amazon_gcard_head").removeClass("active");
		$(".cash_head").removeClass("active");
	});
	
	$(".paypal_head").click(function(){
		$(this).addClass("active");
		$(".bank_transfer_head").removeClass("active");
		$(".cheque_head").removeClass("active");
		$(".venmo_head").removeClass("active");
		$(".zelle_head").removeClass("active");
		$(".amazon_gcard_head").removeClass("active");
		$(".cash_head").removeClass("active");
	});
	
	$(".cheque_head").click(function(){
		$(this).addClass("active");
		$(".bank_transfer_head").removeClass("active");
		$(".paypal_head").removeClass("active");
		$(".venmo_head").removeClass("active");
		$(".zelle_head").removeClass("active");
		$(".amazon_gcard_head").removeClass("active");
		$(".cash_head").removeClass("active");
	});
	
	$(".venmo_head").click(function(){
		$(this).addClass("active");
		$(".bank_transfer_head").removeClass("active");
		$(".cheque_head").removeClass("active");
		$(".paypal_head").removeClass("active");
		$(".zelle_head").removeClass("active");
		$(".amazon_gcard_head").removeClass("active");
		$(".cash_head").removeClass("active");
	});
	
	$(".zelle_head").click(function(){
		$(this).addClass("active");
		$(".bank_transfer_head").removeClass("active");
		$(".cheque_head").removeClass("active");
		$(".paypal_head").removeClass("active");
		$(".venmo_head").removeClass("active");
		$(".amazon_gcard_head").removeClass("active");
		$(".cash_head").removeClass("active");
	});
	
	$(".amazon_gcard_head").click(function(){
		$(this).addClass("active");
		$(".bank_transfer_head").removeClass("active");
		$(".cheque_head").removeClass("active");
		$(".paypal_head").removeClass("active");
		$(".venmo_head").removeClass("active");
		$(".zelle_head").removeClass("active");
		$(".cash_head").removeClass("active");
	});
	
	$(".paypal_head").click(function(){
		$('.paypal_detail').addClass("active");
		$(".bank_transfer_detail").removeClass("active");
		$(".cheque_detail").removeClass("active");
		$(".venmo_detail").removeClass("active");
		$(".zelle_detail").removeClass("active");
		$(".amazon_gcard_detail").removeClass("active");
		$(".cash_detail").removeClass("active");
	});
	
	$(".bank_transfer_head").click(function(){
		$('.bank_transfer_detail').toggleClass("active");
		$(".paypal_detail").removeClass("active");
		$(".cheque_detail").removeClass("active");
		$(".venmo_detail").removeClass("active");
		$(".zelle_detail").removeClass("active");
		$(".amazon_gcard_detail").removeClass("active");
		$(".cash_detail").removeClass("active");
	});
	
	$(".cheque_head").click(function(){
		$('.cheque_detail').addClass("active");
		$(".bank_transfer_detail").removeClass("active");
		$(".paypal_detail").removeClass("active");
		$(".venmo_detail").removeClass("active");
		$(".zelle_detail").removeClass("active");
		$(".amazon_gcard_detail").removeClass("active");
		$(".cash_detail").removeClass("active");
	});
	
	$(".venmo_head").click(function(){
		$('.venmo_detail').addClass("active");
		$('.cheque_detail').removeClass("active");
		$(".bank_transfer_detail").removeClass("active");
		$(".paypal_detail").removeClass("active");
		$(".zelle_detail").removeClass("active");
		$(".amazon_gcard_detail").removeClass("active");
		$(".cash_detail").removeClass("active");
	});
	
	$(".zelle_head").click(function(){
		$('.zelle_detail').addClass("active");
		$('.cheque_detail').removeClass("active");
		$(".bank_transfer_detail").removeClass("active");
		$(".paypal_detail").removeClass("active");
		$(".venmo_detail").removeClass("active");
		$(".amazon_gcard_detail").removeClass("active");
		$(".cash_detail").removeClass("active");
	});
	
	$(".amazon_gcard_head").click(function(){
		$('.amazon_gcard_detail').addClass("active");
		$('.cheque_detail').removeClass("active");
		$(".bank_transfer_detail").removeClass("active");
		$(".paypal_detail").removeClass("active");
		$(".venmo_detail").removeClass("active");
		$(".zelle_detail").removeClass("active");
		$(".cash_detail").removeClass("active");
	});
	
	$(".cash_head").click(function(){
		$('.cash_detail').addClass("active");
		$('.cheque_detail').removeClass("active");
		$(".bank_transfer_detail").removeClass("active");
		$(".paypal_detail").removeClass("active");
		$(".venmo_detail").removeClass("active");
		$(".zelle_detail").removeClass("active");
		$(".amazon_gcard_detail").removeClass("active");
	});

	$(".bank_transfer_head.active").click(function(){
		$('.bank_transfer_detail').addClass("active");
		$(this).addClass("active");
	});
	
	$(".paypal_head.active").click(function(){
		$('.paypal_detail').addClass("active");
		$(this).addClass("active");
	});
	
	$(".cheque_head.active").click(function(){
		$('.cheque_detail').addClass("active");
		$(this).addClass("active");
	});
	
	$(".venmo_head.active").click(function(){
		$('.venmo_detail').addClass("active");
		$(this).addClass("active");
	});
	
	$(".zelle_head.active").click(function(){
		$('.zelle_detail').addClass("active");
		$(this).addClass("active");
	});
	
	$(".amazon_gcard_head.active").click(function(){
		$('.amazon_gcard_detail').addClass("active");
		$(this).addClass("active");
	});
	
	$(".cash_head.active").click(function(){
		$('.cash_detail').addClass("active");
		$(this).addClass("active");
	});
	
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
	
	var telInput2 = $("#shipping_phone");
	telInput2.intlTelInput({
	  initialCountry: "auto",
	  geoIpLookup: function(callback) {
		$.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
		  var countryCode = (resp && resp.country) ? resp.country : "";
		  callback(countryCode);
		});
	  },
	  utilsScript: "../js/intlTelInput-utils.js"
	});

	<?php
	if($order_data_before_saved['shipping_country_code']) { ?>
	$("#shipping_phone").intlTelInput("setNumber", "<?=($order_data_before_saved['shipping_phone']?'+'.$order_data_before_saved['shipping_country_code'].$order_data_before_saved['shipping_phone']:'')?>");
	<?php
	} ?>
	
});

function check_pmt_method_form() {
	var payment_method = document.getElementById("payment_method").value;
	<?php
	if($choosed_payment_option['bank']=="bank") { ?>
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
	}
	<?php
	}
	if($choosed_payment_option['paypal']=="paypal") { ?>
	if(payment_method=="paypal") {
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
	<?php
	}
	if($choosed_payment_option['venmo']=="venmo") { ?>
	if(payment_method=="venmo") {
		if(document.getElementById("venmo_email_address").value.trim()=="") {
			alert('Please enter venmo email address');
			return false;
		}
	}
	<?php
	}
	if($choosed_payment_option['zelle']=="zelle") { ?>
	if(payment_method=="zelle") {
		if(document.getElementById("zelle_email_address").value.trim()=="") {
			alert('Please enter zelle email address');
			return false;
		}
	}
	<?php
	}
	if($choosed_payment_option['amazon_gcard']=="amazon_gcard") { ?>
	if(payment_method=="amazon_gcard") {
		if(document.getElementById("amazon_gcard_email_address").value.trim()=="") {
			alert('Please enter amazon GCard email address');
			return false;
		}
	}
	<?php
	}
	if($choosed_payment_option['cash']=="cash") { ?>
	if(payment_method=="cash") {
		if(document.getElementById("cash_name").value.trim()=="") {
			alert('Please enter cash name');
			return false;
		} else if(document.getElementById("cash_phone").value.trim()=="") {
			alert('Please enter cash phone');
			return false;
		}
	}
	<?php
	} ?>
}

function check_shipping_info_form() {
	if(document.getElementById("shipping_first_name").value.trim()=="") {
		alert('Please enter shipping first name');
		return false;
	} else if(document.getElementById("shipping_last_name").value.trim()=="") {
		alert('Please enter shipping last name');
		return false;
	} else if(document.getElementById("shipping_address").value.trim()=="") {
		alert('Please enter shipping address');
		return false;
	} else if(document.getElementById("shipping_city").value.trim()=="") {
		alert('Please enter shipping city');
		return false;
	} else if(document.getElementById("shipping_state").value.trim()=="") {
		alert('Please enter shipping state');
		return false;
	} else if(document.getElementById("shipping_postcode").value.trim()=="") {
		alert('Please enter shipping zip code');
		return false;
	} else if(document.getElementById("shipping_phone").value.trim()=="") {
		alert('Please enter shipping phone');
		return false;
	}

	var telInput = $("#shipping_phone");
	$("#shipping_phone_c_code").val(telInput.intlTelInput("getSelectedCountryData").dialCode);
	if(!telInput.intlTelInput("isValidNumber")) {
		alert('Please enter valid shipping phone');
		return false;
	}
}

function open_window(url) {
	apply = window.open(url,"Loading",'toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=800,height=800');
}

function Check_iCloud_Order_Item(item_id) {
	if(item_id>0) {
		var imei_number = $("#imei_number-"+item_id).val();
		if(imei_number=="") {
			$("#imei_number-"+item_id).focus();
			return false;
		}

		$("#icloud_status_loading"+item_id).show();

		post_data = "item_id="+item_id+"&imei_number="+imei_number;
		jQuery(document).ready(function($) {
			$.ajax({
				type: "POST",
				url:"ajax/check_icloud_data.php",
				data:post_data,
				success:function(data){
					if(data!="") {
						var form_data = JSON.parse(data);
						$("#icloud_status_loading"+item_id).hide();
						if(form_data.status == 'success' && form_data.icloud_status!="error") {
							$('#device_item_check_popup').modal({backdrop: 'static',keyboard: false});
							$(".device_item_check_data").html(form_data.html);
							$("#icloud_status"+item_id).html('');
							$("#icloud_check_btn"+item_id).html('Re-Check');
							$("#icloud_view_btn"+item_id).show();
						} else if(form_data.status == 'fail' && form_data.icloud_status=="error") {
							$("#icloud_status"+item_id).html(form_data.message);
						} else {
							return false;
						}
					}
				}
			});
		});
	}
}

function View_iCloud_Order_Item(item_id) {
	if(item_id>0) {
		$("#icloud_status_loading"+item_id).show();
		
		post_data = "item_id="+item_id;
		jQuery(document).ready(function($) {
			$.ajax({
				type: "POST",
				url:"ajax/view_icloud_data.php",
				data:post_data,
				success:function(data){
					if(data!="") {
						var form_data = JSON.parse(data);
						$("#icloud_status_loading"+item_id).hide();
						if(form_data.status == 'success' && form_data.icloud_status!="error") {
							$('#device_item_view_popup').modal({backdrop: 'static',keyboard: false});
							$(".device_item_view_data").html(form_data.html);
						} else if(form_data.status == 'fail' && form_data.icloud_status=="error") {
							$("#icloud_status"+item_id).html(form_data.message);
						} else {
							return false;
						}
					}
				}
			});
		});
	}
}
</script>
