<?php
$csrf_token = generateFormToken('model_details');

//Url params
$req_model_id=$url_third_param;

//Fetching data from model
require_once('models/mobile.php');

//Get data from models/mobile.php, get_single_model_data function
$model_data = get_single_model_data($req_model_id);
$meta_title = $model_data['meta_title'];
$meta_desc = $model_data['meta_desc'];
$meta_keywords = $model_data['meta_keywords'];

//Header section
include("include/header.php");
?>

<script src="<?=SITE_URL?>js/front.js"></script>

<div id="breadcrumb">
	<div class="wrap">
		<ul>
			<li><a href="<?=SITE_URL?>">Home</a></li>
			<?php
			if($model_data['device_id']>0) { ?>
			<li><a href="<?=SITE_URL.$model_data['sef_url']?>"><?=$model_data['device_title']?></a></li>
			<?php
			} elseif($model_data['brand_id']>0) { ?>
			<li><a href="<?=SITE_URL.'brand/'.$model_data['brand_sef_url']?>"><?=$model_data['brand_title']?></a></li>
			<?php
			} ?>
			<li class="active"><a href="javascript:void(0);"><?=$model_data['title']?></a></li>
		</ul>
	</div>
</div>

<section id="model-steps" class="sectionbox white-bg clearfix">
	<div class="wrap">
		<div class="content-block">
			<?php
			//Order steps
			$order_steps = 1;
			include("include/steps.php"); ?>
		</div>
	</div>
</section>

<form action="<?=SITE_URL?>controllers/mobile.php" method="post" enctype="multipart/form-data" onSubmit="return chechdata();" id="form_submit">
	<section id="model-steps-select" class="sectionbox white-bg clearfix">
	  <div class="wrap">
	  <div class="row phone-details modern-style-image">
		<div class="col-md-3">
		  <div class="block">
			<div class="text">
			  <div class="phone-select">
				<?php
				if($model_data['model_img']) {
					//$md_img_path = SITE_URL.'libraries/phpthumb.php?imglocation='.SITE_URL.'images/mobile/'.$model_data['model_img'].'&h=200';
					$md_img_path = SITE_URL.'images/mobile/'.$model_data['model_img'];
				  
				  ?>
					<div class="phone-select-inner">
					   <img src="<?=$md_img_path?>">
					</div>
				<?php
				} ?>
			  </div>
			  <div class="title"><strong>Device</strong>
			  	<span class="tips" <?=($model_data['tooltip_device']?'data-toggle="modal" data-target="#ModalTooltips"':'')?>>?</span>
			  </div>
              <div class="model_name"><?=$model_data['title']?></div>
			</div>
		  </div>
		</div>
		
		<!-- Modal -->
		<div class="modal fade common_popup" id="ModalTooltips" role="dialog">
			<div class="modal-dialog small_dialog">
			  <!-- Modal content-->
			  <div class="modal-content">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<div class="modal-body">
					<h3 class="title">Device</h3>
				    <p><?=$model_data['tooltip_device']?></p>
				</div><!--modal-body-->
			  </div>
			</div>
		</div><!-- Modal -->

		<div class="col-md-9 phone-details-height">
		  <div class="block hide_network">
			<div class="">
				<div class="clearfix">
				<div class="heading">
					<h3><strong><?=$model_data['title']?></strong></h3>
					<p>To sell your Apple iPhone select the required fields</p>
				</div>
				
				<div class="price_box">
					<strong class="price">
						<?=$amount_sign_with_prefix?><span class="show_final_amt"><?=amount_format_without_sign($total_price)?></span><?=$amount_sign_with_postfix?>
					</strong>
				</div>
	
				</div>
				<?php
				$path_info = parse_path();
				$call_parts_params = $path_info['call_parts'];
	
				$feilds_val = array();
				$rr=0;
				$tr=1;
				foreach($call_parts_params as $k=>$v) {
					if($k>0) {
						if($rr==0 || $rr==1) {
							$rr++;
							continue;
						}
						$feilds_val[$tr] = $v;
						$rr++;
						$tr++;
					}
				}
	
				function updatePrice($thisprice,$add_sub,$price_type,$total_price,$price) {
					if($price_type==0) {
						$temp_price = ($price*$thisprice)/100;
					} else {
						$temp_price = $thisprice;
					}
	
					if($add_sub=="+") {
						$total_price = $total_price + $temp_price;
					} else {
						$total_price = $total_price - $temp_price;
					}
					return $total_price;
				}
	
				$sql_pro = "select * from mobile where id = '".$req_model_id."'";
				$exe_pro = mysqli_query($db,$sql_pro);
				$row_pro = mysqli_fetch_assoc($exe_pro);
				$price = $row_pro['price'];
				$total_price = $row_pro['price'];
				?>
	
				<input type="hidden" name="base_price" value="<?=$price?>" />
				<div class="modern-text slideInRight animated" id="device-prop-area">
					<div class="sell-help">
					   &nbsp;
					</div>
	
					<?php
					$sql_cus_fld = "select * from product_fields where product_id = '".$req_model_id."' order by sort_order";
					$exe_cus_fld = mysqli_query($db,$sql_cus_fld);
					$no_of_dd_fld = mysqli_num_rows($exe_cus_fld);
					$no_of_fields = mysqli_num_rows($exe_cus_fld);
					$fid=1;
	
					if($no_of_fields==count($feilds_val)) {
						$btn_act = "display:;";
					} else {
						$btn_act = "display:none;";
					}
	
					while($row_cus_fld = mysqli_fetch_assoc($exe_cus_fld)) {
						$nn = $nn+1;
						$last_next_button = "";
						if($no_of_fields == $nn) {
							$last_next_button = "yes";
						}
						
						if(isset($feilds_val[$fid])) {
							$class = "selected";
						} elseif($fid==count($feilds_val)+1) {
							$class = "opened";
						} else {
							$class = "disabled";
						} ?>
	
						<div class="modern-text__row capacity-base-row modern-block__row <?=$class?>" data-row_type="<?=$row_cus_fld['input_type']?>" data-required="<?=$row_cus_fld['is_required']?>">
							<span class="modern-text__area">
								<span class="modern-text__num">
									<b class="modern-num"><?=$fid?></b>
									<b data-toggle="tooltip" title="Edit" class="modern-selected needhelp"></b>
								</span>
								<span class="modern-text__title">
									<?php
									if($row_cus_fld['icon']!="") { ?>
										<img src="/images/<?=$row_cus_fld['icon']?>" width="50px" />
									<?php
									}
									echo $row_cus_fld['title']; ?>
								</span>
								<span class="tips" data-toggle="tooltip" title="<?=$row_cus_fld['tooltip']?>">?</span>
								<?php /*?><span class="needhelp icon-help modern-text__help" data-toggle="tooltip" data-placement="bottom" title="<?=$row_cus_fld['tooltip']?>"></span><?php */?>
							</span>
							<div id="capacities" class="modern-block__content block-content-base">
								<?php
								if($row_cus_fld['input_type']=="select" || $row_cus_fld['input_type']=="radio")
								{
									$sql_cus_opt = "select * from product_options where product_field_id = '".$row_cus_fld['id']."'";
									$exe_cus_opt = mysqli_query($db,$sql_cus_opt);
									$no_of_dd_options = mysqli_num_rows($exe_cus_opt);
									$temp_fld_no = count($feilds_val) + 1;
	
									if($no_of_dd_options>0) {
										$oid=1;
										$checked = "";
										$sel_class = "";
										$tooltip_tabs = array();
										?>
										<div class="option_value_outer clearfix">
										<?php
										while($row_cus_opt = mysqli_fetch_assoc($exe_cus_opt)) {
											$checked = '';
											$sel_class = "";
											$tab_sel_class = "false";
											$tab_sel__content_class = "";
	
											if(@$feilds_val[$fid]==$row_cus_opt['label']) {
												$checked = 'checked';
												$sel_class = "sel";
												$tab_sel_class = "true";
												$tab_sel__content_class = "active";
												$total_price = updatePrice($row_cus_opt['price'],$row_cus_opt['add_sub'],$row_cus_opt['price_type'],$total_price,$price);
											} else {
												if($temp_fld_no == $fid) {
													if($row_cus_opt['is_default']==1) {
														$checked = 'checked';
														$sel_class = "sel";
														$tab_sel_class = "true";
														$tab_sel__content_class = "active";
														$total_price = updatePrice($row_cus_opt['price'],$row_cus_opt['add_sub'],$row_cus_opt['price_type'],$total_price,$price);
													}
												}
											} ?>
												<span class="options_values">
													<button data-issubmit="<?=$last_next_button?>" class="capacity-row btn btn-sm <?=$sel_class?> radio_btn" type="button" href="#<?=$fid?>_<?=$oid?>_tab" data-toggle="tab" aria-expanded="<?=$tab_sel_class?>" data-input-type="<?=$row_cus_fld['input_type']?>">
													<?php
													if($row_cus_opt['icon']!="") { ?>
														<img src="/images/<?php echo $row_cus_opt['icon']; ?>" width="50px" id="<?php echo $row_cus_opt['id']; ?>" />
														<br />
													<?php
													}
													echo $row_cus_opt['label']; ?>
													<?php
													$tooltip_tabs[$oid]['tab_id'] = $fid."_".$oid."_tab";
													$tooltip_tabs[$oid]['tooltip'] = $row_cus_opt['tooltip'];
													$tooltip_tabs[$oid]['sel_class'] = $tab_sel__content_class;
													?>

													<!--Display details when you hover over tooltips -->
														<div class="tab-content tab-pane">
															<p><?=$row_cus_opt['tooltip']?></p>
														</div>
														
												</button>
													<input class="radioele" name="<?php echo $row_cus_fld['title']; ?>" value="<?php echo $row_cus_opt['label']; ?>" <?php echo $checked; ?> type="radio" style="display:none;" onClick="updatePrice('<?php echo $row_cus_opt['price']; ?>','<?php echo $row_cus_opt['add_sub']; ?>','<?php echo $row_cus_opt['price_type']; ?>')" data-price="<?php echo $row_cus_opt['price']; ?>" data-add_sub="<?php echo $row_cus_opt['add_sub']; ?>" data-price_type="<?php echo $row_cus_opt['price_type']; ?>" data-default="<?php echo $row_cus_opt['is_default']; ?>" />
												</span>

											<?php
											$oid++;
										} ?>
										</div>
										<!-- <div class="tab-content tab_con">
											<?php
											/*foreach($tooltip_tabs as $tooltip_tab) {
												if($tooltip_tab['tooltip']) { ?>
													<!-- <div class="tab-pane <?//=$tooltip_tab['sel_class']?>" id="<?//=$tooltip_tab['tab_id']?>">
														<p><?//=$tooltip_tab['tooltip']?></p>
													</div> -->
												<?php
												}
											} */?>
										</div> -->
										
										<?php
										/*
										<a href="#" class="capacity-row" data-issubmit="<?=$last_next_button?>">Next</a>
										<?php
										*/ ?>
										
										<span class="text-danger"></span>
										<?php
									}
								}
								elseif($row_cus_fld['input_type']=="checkbox") {
									$sql_cus_opt = "select * from product_options where product_field_id = '".$row_cus_fld['id']."'";
									$exe_cus_opt = mysqli_query($db,$sql_cus_opt);
									$no_of_dd_options = mysqli_num_rows($exe_cus_opt);
									$temp_fld_no = count($feilds_val) + 1;
	
									if($no_of_dd_options>0) {
										$oid=1; ?>
										<div class="form-group">
										<?php
										$chks = explode(",",@$feilds_val[$fid]);
										while($row_cus_opt = mysqli_fetch_assoc($exe_cus_opt)) {
											$checked = '';
											$chk_lab = $row_cus_opt['label'];
	
											if(isset($feilds_val[$fid]) && count($chks)>0) {
												if(in_array($chk_lab,$chks)) {
													$checked = 'checked';
													$total_price = updatePrice($row_cus_opt['price'],$row_cus_opt['add_sub'],$row_cus_opt['price_type'],$total_price,$price);
												}
											} else {
												if($temp_fld_no == $fid) {
													if($row_cus_opt['is_default']==1) {
														$checked = 'checked';
														$total_price = updatePrice($row_cus_opt['price'],$row_cus_opt['add_sub'],$row_cus_opt['price_type'],$total_price,$price);
													}
												}
											} ?>
											<span class="options_values form-group">
												<div class="checkbox checkbox-success">
													<label for="<?php echo $chk_lab; ?>"><input class="checkboxele" name="<?php echo $row_cus_fld['title']; ?>[]" id="<?php echo $chk_lab; ?>" <?php echo $checked; ?> value="<?php echo $chk_lab; ?>" type="checkbox" onClick="updatePrice_chk('<?php echo $row_cus_opt['price']; ?>','<?php echo $row_cus_opt['add_sub']; ?>','<?php echo $row_cus_opt['price_type']; ?>',this)" data-price="<?php echo $row_cus_opt['price']; ?>" data-add_sub="<?php echo $row_cus_opt['add_sub']; ?>" data-price_type="<?php echo $row_cus_opt['price_type']; ?>" data-default="<?php echo $row_cus_opt['is_default']; ?>"><span class="checkmark"></span>
													 <?php echo $chk_lab; ?> </label>
												</div>
											</span>
										<?php
										}
										?>
										</div>
										<a href="#" class="capacity-row" data-issubmit="<?=$last_next_button?>">Next</a>
										<span class="text-danger"></span>
										<?php
									}
								}
								elseif($row_cus_fld['input_type']=="text") { ?>
									<input name="<?php echo $row_cus_fld['title']; ?>" class="form-control input" />
									<a class="capacity-row" data-issubmit="<?=$last_next_button?>">Next</a>
								<?php
								}
								elseif($row_cus_fld['input_type']=="textarea") { ?>
									<textarea name="<?php echo $row_cus_fld['title']; ?>" class="form-control textarea input"></textarea>
									<a class="capacity-row" data-issubmit="<?=$last_next_button?>">Next</a>
									<?php
								}
								elseif($row_cus_fld['input_type']=="datepicker") { ?>
									<input type="text" class="form-control input" id="datepicker" name="<?php echo $row_cus_fld['title']; ?>" autocomplete="off" />
									<a class="capacity-row" data-issubmit="<?=$last_next_button?>">Next</a>
									<?php
								}
								elseif($row_cus_fld['input_type']=="file") { ?>
									<span></span>
									<div class="clearfix fileupload">
										<input name="<?=$row_cus_fld['title']?>" type="file" class="input" onChange="changefile(this)" />
										<div class="filenamebox">No file choosen <?php /*?><i class="fa fa-times" onclick="selectNewFile(this);"></i><?php */?></div>
									</div>
									<a class="capacity-row" data-issubmit="<?=$last_next_button?>">Next</a>
								<?php
								} ?>
							</div>
							<div class="modern-block__selected">
								<span class="mobile-block">Capacity: </span>
								<span class="current-item">
								<?php
								if(isset($feilds_val[$fid])) {
									echo $feilds_val[$fid];
								} ?>
								</span>
							</div>
							<div class="modern-disabled"></div>
						</div>
						<?php
						$fid++;
					} ?>
		  			<br />
					<div class="device-get-price clearfix">
					<button type="button" class="btn btn-blue" onClick="backFeild()">Back </button>
					<button type="submit" class="btn btn-gray arrow" id="quantity-section" style="display:none;">Next </button>
					</div>
					
				</div>
			</div>
		  </div>
		</div>
	  </div>
	</div>

	</section>
    
    <!--<section id="quantity_sec" class="sectionbox lightblue-bg">
    	<div class="wrap">
            <div class="intro-text">Unlike many other recyclers, our prices are guaranteed rather than 'up to' prices. Provided your device is received as described, </div>
            <div class="subtitlebox">you'll receive the full value. Please see our Price Promise for more details.</div>

            <div class="content-block">
            	<form>
                	<div class="row">
                    	<div class="col-sm-12">
                        	<div class="form_group col-sm-push-4 col-sm-3">
                            	<label>Quantity:</label>
                                <select class="textbox">
                                	<option>1</option>
                                    <option>2</option>
                                </select>
                                <button class="btn btn_md btn-red-bg btn-shadow">Sell this  Device</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>-->
  
   

  <?php /*?><section id="guarantee-value" class="sectionbox white-bg clearfix">
      <div class="wrap">
      <div class="row">
        <div class="col-md-12">
          <div class="payment-method-head text-center">
            <div class="h3"><strong>Guaranteed Value</strong></div>
            <p>Please select payment method:</p>
          </div>
        </div>
      </div>
    </div>
  </section><?php */?>
  <?php /*?><section class="sectionbox white-bg clearfix">
      <div class="wrap">

	  <div class="row">
		<div class="col-md-12">
			<div class="payment-method clearfix">
			  <ul data-toggle="buttons">
			    <?php
				if($choosed_payment_option['bank']=="bank") { ?>
				<li class="btn <?php if($default_payment_option=="bank"){echo 'active';}?>">
					<div class="method bank">
						<div class="arrow"></div>
						<div class="right-sgin"><i class="fa fa-check" aria-hidden="true"></i></div>
						<div><strong>Bank Transfer</strong></div>
						<div><img src="<?=SITE_URL?>images/payment/bank-transfer.png"></div>
						<strong class="price">
						   <?=$amount_sign_with_prefix?><span class="show_final_amt"><?=amount_format_without_sign($total_price)?></span><?=$amount_sign_with_postfix?>
						</strong>
					</div>
					<input type="radio" id="payment_method_bank" name="payment_method" value="bank" <?php if($default_payment_option=="bank"){echo 'checked="checked"';}?>>
				</li>
				<?php
				}
				if($choosed_payment_option['cheque']=="cheque") { ?>
				<li class="btn <?php if($default_payment_option=="cheque"){echo 'active';}?>">
					<div class="method cheque">
						<div class="arrow"></div>
						<div class="right-sgin"><i class="fa fa-check" aria-hidden="true"></i></div>
						<strong>Cheque</strong>
						<img src="<?=SITE_URL?>images/payment/cheque.png">
						<strong class="price">
						   <?=$amount_sign_with_prefix?><span class="show_final_amt"><?=amount_format_without_sign($total_price)?></span><?=$amount_sign_with_postfix?>
						</strong>
					</div>
				   <input type="radio" id="payment_method_cheque" name="payment_method" value="cheque" <?php if($default_payment_option=="cheque"){echo 'checked="checked"';}?>>
				</li>
				<?php
				}
				if($choosed_payment_option['paypal']=="paypal") { ?>
				<li class="btn <?php if($default_payment_option=="paypal"){echo 'active';}?>">
					<div class="method paypal">
						<div class="arrow"></div>
						<div class="right-sgin"><i class="fa fa-check" aria-hidden="true"></i></div>
						<strong>Paypal</strong>
						<img src="<?=SITE_URL?>images/payment/paypal.png">
						<strong class="price">
						   <?=$amount_sign_with_prefix?><span class="show_final_amt"><?=amount_format_without_sign($total_price)?></span><?=$amount_sign_with_postfix?>
						</strong>
					</div>
				  <input type="radio" id="payment_method_paypal" name="payment_method" value="paypal" <?php if($default_payment_option=="paypal"){echo 'checked="checked"';}?>>
				</li>
				<?php
				}
				if($choosed_payment_option['cash']=="cash") { ?>
				<li class="btn <?php if($default_payment_option=="cash"){echo 'active';}?>">
					<div class="method paypal">
						<div class="arrow"></div>
						<div class="right-sgin"><i class="fa fa-check" aria-hidden="true"></i></div>
						<strong>Cash</strong>
						<img src="<?=SITE_URL?>images/payment/cash.png">
						<strong class="price">
						   <?=$amount_sign_with_prefix?><span class="show_final_amt"><?=amount_format_without_sign($total_price)?></span><?=$amount_sign_with_postfix?>
						</strong>
					</div>
				  <input type="radio" id="payment_method_paypal" name="payment_method" value="cash" <?php if($default_payment_option=="cash"){echo 'checked="checked"';}?>>
				</li>
				<?php
				} ?>
			</ul>
			</div>
		</div>
	  </div>
  </div>
</section><?php */?>

<?php /*?><section class="sectionbox white-bg clearfix">
      <div class="wrap">
      <div class="row">
        <div class="col-md-12">
          <p class="gray-text">Unlike many other recyclers, our prices are guaranteed rather than 'up to' prices. Provided your device is received as described, you'll receive the full value. Please see our Price Promise for more details.</p>
        </div>
      </div>
    </div>
  </section>
  <section class="sectionbox white-bg clearfix">
      <div class="wrap">
      <div class="row" id="quantity-section" style="<?=$btn_act?>">
        <div class="col-md-12">
          <div class="block clearfix">
            <div class="form-inline quantity-form" role="form">
              <div class="form-group">
                <label>Quantity:</label>
                <!--<input type="number" class="form-control" name="quantity" id="quantity" value="1">-->
                <div class="select-fancy">
                  <select name="quantity" id="quantity">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                  </select>
                </div>
              </div>
              <button type="submit" class="btn" name="sell_this_device" id="get-price-btn" style="<?=$btn_act?>">Sell this Device</button>
            </div>
          </div>
        </div>
      </div>

	  <?php */?>
	  
	  <span class="show_final_amt_val" style="display:none;"><?=$total_price?></span>

	  <input type="hidden" name="sell_this_device" value="yes">
	  <input type="hidden" name="quantity" id="quantity" value="1"/>
	  <input type="hidden" name="device_id" id="device_id" value="<?=$model_data['device_id']?>"/>
	  <input type="hidden" name="payment_amt" id="payment_amt" value="<?=$total_price?>"/>
	  <input type="hidden" name="req_model_id" id="req_model_id" value="<?=$req_model_id?>"/>

	  <input id="total_price_org" value="<?=$price?>" type="hidden" />
	  <input name="id" type="hidden" value="<?=$req_model_id?>" />
	  
	  <input type="hidden" name="csrf_token" value="<?=$csrf_token?>">
	  
 <?php /*?> </div>
</section><?php */?>

</form>

  <!--START for review section-->
  <?php /*
  //Get review list
  $review_list_data = get_review_list_data_random();
  if(!empty($review_list_data)) { ?>
    <section class="sectionbox white-bg clearfix">
      <div class="wrap">
      <div class="row quota-trustpilot">
        <div class="col-md-12">
          <div class="block clearfix">
            <div class="block-inner clearfix">
              <span class="quota-icon"></span>
              <h3><strong><?=$review_list_data['title']?></strong></h3>
              <div class="text">
              	<?php
              	if($review_list_data['stars'] == '0.5' || $review_list_data['stars'] == '1') { ?>
	                <i class="fa fa-star"></i>
                <?php
                } elseif($review_list_data['stars'] == '1.5' || $review_list_data['stars'] == '2') { ?>
	                <i class="fa fa-star"></i>
	                <i class="fa fa-star"></i>
	            <?php
                } elseif($review_list_data['stars'] == '2.5' || $review_list_data['stars'] == '3') { ?>
	                <i class="fa fa-star"></i>
	                <i class="fa fa-star"></i>
	                <i class="fa fa-star"></i>
	            <?php
                } elseif($review_list_data['stars'] == '3.5' || $review_list_data['stars'] == '4') { ?>
	                <i class="fa fa-star"></i>
	                <i class="fa fa-star"></i>
	                <i class="fa fa-star"></i>
	                <i class="fa fa-star"></i>
	            <?php
                } elseif($review_list_data['stars'] == '4.5' || $review_list_data['stars'] == '5') { ?>
	                <i class="fa fa-star"></i>
	                <i class="fa fa-star"></i>
	                <i class="fa fa-star"></i>
	                <i class="fa fa-star"></i>
	                <i class="fa fa-star"></i>
                <?php
            	} ?>
              </div>
              <div class="text">
                <p><?=$review_list_data['content']?></p>
              </div>
              <div class="arrow-down"></div>
            </div>
            <div class="trust-pilot-credits">
              <p><?=$review_list_data['name']?><br /><span><?=($review_list_data['country']?$review_list_data['country'].', ':'').$review_list_data['state'].', '.$review_list_data['city']?></span><br /><span class="date"><?=date('m/d/Y',$review_list_data['date'])?></span></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <?php
  } */ ?>
  <!--END for review section-->

  <script type="text/javascript">
  (function( $ ) {
	$(function() {
      // More code using $ as alias to jQuery
      var stickyNavTop = $('.float-section').offset().top;
      var stickyNav = function () {
          var scrollTop = $(window).scrollTop();
          if (scrollTop > stickyNavTop) {
              $('.float-section').addClass('cloned');
          } else {
              $('.float-section').removeClass('cloned');
          }
      };
      stickyNav();
      $(window).scroll(function () {
          stickyNav();
      });

	  //$('[data-toggle="tooltip"]').tooltip();
    });
  })(jQuery);

  </script>
