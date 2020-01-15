<?php
$custom_phpjs_path = "assets/js/custom/addedit_custom_fields.php"; ?>

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
			<div class="row">
				<div class="col-lg-12">

					<!--begin::Portlet-->
					<div class="m-portlet">
						<div class="m-portlet__head">
							<div class="m-portlet__head-caption">
								<div class="m-portlet__head-title">
									<span class="m-portlet__head-icon m--hide">
										<i class="la la-gear"></i>
									</span>
									<h3 class="m-portlet__head-text">
										<?=($id?'Edit Custom Fields':'Add Custom Fields')?>
									</h3>
								</div>
							</div>
						</div>
						
						<div class="m-portlet__body">
							<!--begin::Form-->
							<form id="form_step_1" class="m-form m-form--fit m-form--label-align-right" action="action.php" method="post" enctype="multipart/form-data">
								
								<div class="tab-content">
									<div class="tab-pane active" id="m_tabs_general" role="tabpanel">
										
										<div class="form-group m-form__group">
											<label for="title">Title</label>
											<input type="text" class="form-control m-input m-input--square" id="name" value="<?=$row_cus_grp['name']?>" name="name">
										</div>
										
										<div class="form-group m-form__group">
											<label for="group_id">Choose Group * </label>
											<select class="form-control select2 m_select2" multiple="multiple" name="group_id[]">
												<?php
												while($row_grp = mysqli_fetch_assoc($exe_grp)) { ?>
													<option <?php if(in_array($row_grp['id'],$rrr)){ echo "selected"; } ?> value="<?php echo $row_grp['id']; ?>"><?php echo $row_grp['name']; ?></option>
												<?php
												} ?>
											</select>
										</div>
										
										<div class="m-form__group form-group">
											<label for="">Publish</label>
											<div>
												<input name="status" data-switch="true" type="checkbox" data-on-text="Yes" data-handle-width="70" data-off-text="No" data-on-color="brand" <?=($row_cus_grp['status']==1||$row_cus_grp['status']==''?'checked="checked"':'')?> value="1">
											</div>
										</div>
										
										<?php
										$no_of_fields = 0; ?>

										<script>
										function up_title(id) {
											if($("#title_"+id).val()!="") {
												$("#tab_title_"+id).html($("#title_"+id).val());
											}
										}
										</script>
	
										<div class="m-form__group form-group">
											<button type="button" class="btn btn-success" onclick="add_fields()"><i class="fa fa-plus"></i> Add More Fields</button>
											<button type="button" class="btn btn-danger" onclick="del_current_tab()"><i class="la la-trash"></i> Delete Field</button>
										</div>

										<div class="form-group row dd" id="nestable_list_3">
											<input name="sorting_order" id="sorting_order" value="" type="hidden" />
											<div class="col-lg-3">
												<ul class="nav nav-pills nav-pills--accent tablist" id="tab_titles" role="tablist">
													<?php
													if(isset($id) && $id!="") {
														$sql_cus_fld = mysqli_query($db,"SELECT * FROM custom_fields WHERE custom_group_id = '".$row_cus_grp['id']."' ORDER BY sort_order");
														$no_of_fields = mysqli_num_rows($sql_cus_fld);
														$fid=1;
														while($row_cus_fld = mysqli_fetch_assoc($sql_cus_fld)) { ?>
															<li id="tab_<?=$fid?>" class="dd-item dd3-item nav-item" data-id="<?=$fid?>">
																<!-- <div class="dd-handle dd3-handle"> -->
																<div class="dd-handle-new">
																  <i class="fa fa-list"></i>
																</div>
																<!--<div class="dd3-content">-->
																	<a class="dd3-content nav-link <?php if($fid==1){echo "active";}?>" href="#field_<?=$fid?>" onclick="up_current_tab(<?=$fid?>)" data-toggle="tab"><span id="tab_title_<?=$fid?>"><?=$row_cus_fld['title']?></span></a>
																<!--</div>-->
															</li>
														<?php
														$fid++;
														}
													} ?>
												</ul>
											</div>
											
											<div class="col-lg-9 tab-content fields" id="tab_contents">	
											<?php
											if(isset($id) && $id!=""){
												$sql_cus_fld = mysqli_query($db,"SELECT * FROM custom_fields WHERE custom_group_id = '".$row_cus_grp['id']."' ORDER BY sort_order");
												$fid=1;
												while($row_cus_fld = mysqli_fetch_assoc($sql_cus_fld)) { ?>
													<div class="tab-pane <?=($fid==1?"active":"")?>" id="field_<?=$fid;?>" role="tabpanel">
														<div class=" form-group row">
															<div class="col-sm-7">
																<label for="title_<?=$fid?>">Title *</label>
																<input name="field[<?=$fid?>][title]" required="" id="title_<?=$fid;?>" type="text" class="form-control m-input m-input--square" onkeyup="up_title('<?=$fid;?>')" onkeydown="up_title('<?=$fid;?>')" value="<?php echo $row_cus_fld['title']; ?>" />
															</div>
															<div class="col-sm-5">
																<label for="input_type_<?=$fid?>">Input Type *</label>
																<select name="field[<?=$fid?>][input_type]" id="input_type_<?=$fid?>" class="form-control m-input custom-select" data-style="btn-default" onchange="change_input_type('<?=$fid;?>')">
																	<option <?php if($row_cus_fld['input_type']=="text"){ echo "selected"; } ?> value="text">Text Field</option>
																	<option <?php if($row_cus_fld['input_type']=="textarea"){ echo "selected"; } ?> value="textarea">Text Area</option>
																	<option <?php if($row_cus_fld['input_type']=="select"){ echo "selected"; } ?> value="select">Drop-down List</option>
																	<option <?php if($row_cus_fld['input_type']=="radio"){ echo "selected"; } ?> value="radio">Radio Buttons</option>
																	<option <?php if($row_cus_fld['input_type']=="checkbox"){ echo "selected"; } ?> value="checkbox">Checkboxes</option>
																	<option <?php if($row_cus_fld['input_type']=="datepicker"){ echo "selected"; } ?> value="datepicker">Date Picker</option>
																	<option <?php if($row_cus_fld['input_type']=="file"){ echo "selected"; } ?> value="file">Upload Files</option>
																</select>
															</div>
														</div>
														<div class=" form-group row">
															<div class="col-sm-7">
																<label for="tooltip_<?=$fid?>">Tooltip</label>
																<div class="m-input-icon m-input-icon--right">
																	<input name="field[<?=$fid?>][tooltip]" id="tooltip_<?=$fid?>" type="text" class="form-control" value="<?php echo @$row_cus_fld['tooltip']; ?>" />
																	<span class="m-input-icon__icon m-input-icon__icon--right" onclick="deleteTooltip(this);"><span><i class="la la-trash"></i></span></span>
																</div>
															</div>
															
															<div class="col-sm-2">
																<label for="tooltip">Icon</label>
																<button class="btn btn-md" type="button" onclick="$(this).next().click()"><i class="fa fa-folder"></i></button>
																<input name="field[<?=$fid?>][icon]" id="icon_<?=$fid?>" type="file" class="filestyle" data-input="false" style="display:none;">
															</div>
															<div class="col-sm-3">
																<!--<label for="">&nbsp;</label>-->
																<?php
																if($row_cus_fld['icon']!="") { ?>
																	<img src="../images/<?=$row_cus_fld['icon']?>" style="display:block;" width="40" />
																	<i style="padding-left:5px; padding-top:10px;" class="la la-trash float-left" onclick="deleteImage(this);"></i>
																<?php
																} ?>
																<input name="field[<?=$fid?>][icon_hidden]" value="<?=$row_cus_fld['icon']?>" type="hidden" />
															</div>
														</div>
														<div class=" form-group">
															<div class="m-checkbox-inline">
																<label class="m-checkbox">
																	<input name="field[<?=$fid?>][is_required]" id="is_required_<?=$fid?>" value="1" type="checkbox" <?php if($row_cus_fld['is_required']==1){ echo "checked"; } ?>>
																	 Require customer selection <span></span>
																 </label>
															</div>
														</div>
														
														<div id="type_options_<?=$fid?>">
															<?php
															$sql_cus_opt = mysqli_query($db,"SELECT * FROM custom_options WHERE field_id = '".$row_cus_fld['id']."' ORDER BY sort_order");
															$no_of_dd_options = mysqli_num_rows($sql_cus_opt);
															if($row_cus_fld['input_type']=="select" || $row_cus_fld['input_type']=="radio" || $row_cus_fld['input_type']=="checkbox")
															{ ?>
																<div class=" form-group">
																	<button type="button" class="btn btn-md btn-success" id="add_more_options_<?=$fid?>" onclick="add_more_options('<?=$fid;?>')"> <i class="fa fa-plus"></i>  Add New Option</button>
																</div>
																<div class="form-group row dd_header dd_header-new">
																	<div class="col-sm-2">
																		<label for="">Title</label>
																	</div>
																	<div class="col-sm-3">
																		<label for="">Price Modifier</label>
																	</div>
																	<div class="col-sm-3">
																		<label for="">Tooltip</label>
																	</div>
																	<div class="col-sm-2">
																		<label for="">Icon</label>
																	</div>
																	<div class="col-sm-2">
																		<label for="">Default</label>
																		<a href="javascript:void(0);" onclick="clear_default('<?=$fid;?>')"><i class="fa fa-times"></i></a>
																	</div>
																	<!--<div class="col-sm-1">
																		&nbsp;
																	</div>-->
																	<input id="no_of_dd_options_<?=$fid?>" value="<?=$no_of_dd_options?>" type="hidden" />
																</div>
															<?php    
															} ?>
															
															<div id="dd_options_<?=$fid;?>">    
																<?php
																if($no_of_dd_options>0) {
																	$oid=1;
																	echo '<ul id="sortable_'.$fid.'">';
																	while($row_cus_opt = mysqli_fetch_assoc($sql_cus_opt)) { ?>
																		<li class="ui-state-default m--margin-bottom-20" data-id="<?=$oid;?>">
																			<div class="form-group row">
																				<div class="col-sm-2">
																					<input name="field[<?=$fid?>][options][<?=$oid?>][label]" required="" id="dd_label_<?=$fid;?>_<?=$oid;?>" type="text" class="form-control m-input" value="<?=$row_cus_opt['label']?>" />
																				</div>
																				<div class="col-sm-3">
																					<div class="row">
																						<div class="col-sm-4" style="padding-left:2px;padding-right:2px;">
																						<select name="field[<?=$fid?>][options][<?=$oid?>][add_sub]" id="dd_add_sub_<?=$fid;?>_<?=$oid;?>" class="form-control m-input custom-select">
																							<option <?php if($row_cus_opt['add_sub']=="+"){ echo "selected"; } ?> value="+">+</option>
																							<option <?php if($row_cus_opt['add_sub']=="-"){ echo "selected"; } ?> value="-">-</option>
																						</select>
																						</div>
																						<div class="col-sm-4" style="padding-left:2px;padding-right:2px;">
																						<select name="field[<?=$fid?>][options][<?=$oid?>][price_type]" id="dd_price_type_<?=$fid;?>_<?=$oid;?>" class="form-control m-input custom-select">
																							<option <?php if($row_cus_opt['price_type']=="1"){ echo "selected"; } ?> value="1">Fixed</option>
																							<option <?php if($row_cus_opt['price_type']=="0"){ echo "selected"; } ?> value="0">%</option>
																						</select>
																						</div>
																						<div class="col-sm-4" style="padding-left:2px;padding-right:2px;">
																						<input name="field[<?=$fid?>][options][<?=$oid?>][price]" id="dd_price_<?=$fid;?>_<?=$oid;?>" type="text" class="form-control m-input" value="<?=$row_cus_opt['price']?>" placeholder="0.00" />
																						</div>
																					</div>
																				</div>
																				<div class="col-sm-3">
																					<div class="m-input-icon m-input-icon--right">
																
																					<input name="field[<?=$fid?>][options][<?=$oid?>][tooltip]" id="dd_tooltip_<?=$fid?>_<?=$oid?>" type="text" class="form-control m-input" value="<?=$row_cus_opt['tooltip']?>" />
																					<span class="m-input-icon__icon m-input-icon__icon--right" onclick="deleteTooltip(this);"><span><i class="la la-trash"></i></span></span>
																					</div>
																				</div>
																				<div class="col-sm-2">
																					<div class="row">
																						<div class="col-sm-6" style="padding-left:2px;padding-right:2px;">
																							<button class="btn btn-sm" type="button" onclick="$(this).next().click()"><i class="fa fa-folder"></i></button>
																							<input name="field[<?=$fid?>][options][<?=$oid?>][icon]" id="dd_icon_<?=$fid;?>_<?=$oid;?>" class="filestyle" type="file" data-input="false" style="display: none;">
																							<input name="field[<?=$fid?>][options][<?=$oid?>][icon_hidden]" class="icon_hidden" value="<?=$row_cus_opt['icon']?>" type="hidden">
																						</div>
																						
																						<?php
																						if($row_cus_opt['icon']!="") { ?>
																							<div class="col-sm-4" style="padding-left:2px;padding-right:2px;">
																							<img src="../images/<?=$row_cus_opt['icon']?>" style="display:block;" width="30"/>
																							</div>
																							<div class="col-sm-2" style="padding-left:2px;padding-right:2px;">
																								<i class="la la-trash text-danger" onclick="deleteImageOpt(this);"></i>
																							</div>
																						<?php
																						} ?>
																					</div>
																				</div>
																				<div class="col-sm-1">
																					<label class="m-radio">
																						<input name="field[<?=$fid?>][options][<?=$oid?>][is_default]" id="is_default_<?=$fid?>_<?=$oid?>" <?php if($row_cus_opt['is_default']=="1"){echo "checked";}?> value="1" type="radio" class="radio_class radio_<?=$fid?>" onclick="check_default('<?=$fid;?>')" />
																						<span></span>
																					</label>
																				</div>
																				<div class="col-sm-1">
																					<i class="la la-trash trash" style="cursor:pointer;" onclick="remove_row(this)"></i>
																				</div>
																			</div>
																		</li>
																	<?php
																	$oid++;
																	} ?>
																	</ul>
																	
																	<script>
																	$(function() {
																		$("#sortable_<?=$fid?>").sortable();
																		$("#sortable_<?=$fid?>").disableSelection();    
																	});
																	</script>
																<?php
																} ?>
															</div>
															<?php
															if($row_cus_fld['input_type']=="select" || $row_cus_fld['input_type']=="radio" || $row_cus_fld['input_type']=="checkbox") { ?>
																<div class="m-form__group form-group">
																	<button type="button" class="btn btn-md btn-success" id="add_more_options_<?=$fid;?>" onclick="add_more_options('<?=$fid;?>')"> <i class="fa fa-plus"></i>  Add New Option</button>
																</div>
															<?php
															}
															?>
														</div>
													</div>
													<?php
													$fid++;
													}
												} ?>
											</div>
										</div>

										<div class="m-form__group form-group">
											<input type="hidden" name="action" value="add_custom_fields">
											<input type="hidden" name="user_id" value="<?=$_SESSION['id']?>">
											<input type="hidden" name="id" value="<?=$id?>">
											<input type="submit" id="m_form_submit" class="btn btn-primary" value="Save">
											<a href="custom_fields.php" class="btn btn-secondary">Back</a>
										</div>
												
									</div>
								</div>
							</form>
							<!--end::Form-->
						</div>
					</div>
					<!--end::Portlet-->
				</div>
			</div>
		</div>
	</div>
</div>
<!-- end:: Body -->
</div>

<div id="field_structure" style="display:none;">   
	<div class="tab-pane active" id="field_f-no"> 
		<div class="m-form__group form-group row">
			<div class="col-sm-7">
				<label for="title">Title * :</label>
				<input name="field[f-no][title]" required="" id="title_f-no" type="text" class="form-control m-input m-input--square" onkeyup="up_title('f-no')" onkeydown="up_title('f-no')" />
			</div>
			<div class="col-sm-5">
				<label for="name">Input Type * :</label>
				<select name="field[f-no][input_type]" id="input_type_f-no" class="form-control m-input" onchange="change_input_type('f-no')">
					<option value="text">Text Field</option>
					<option value="textarea">Text Area</option>
					<option value="select">Drop-down List</option>
					<option value="radio">Radio Buttons</option>
					<option value="checkbox">Checkboxes</option>
					<option value="datepicker">Date Picker</option>
					<option value="file">Upload Files</option>
				</select>
			</div>
		</div>
		<div class="m-form__group form-group row">
			<div class="col-sm-7">
				<label for="tooltip">Tooltip :</label>
				<div class="m-input-icon m-input-icon--right">
					<input name="field[f-no][tooltip]" id="tooltip_f-no" type="text" class="form-control m-input m-input--square" value="" />
					<span class="m-input-icon__icon m-input-icon__icon--right" onclick="deleteTooltip(this);"><span><i class="la la-trash"></i></span></span>
				</div>
			</div>
			<div class="col-sm-5">
				<label for="tooltip">Icon :</label><br />
				<button class="btn btn-md" type="button" onclick="$(this).next().click()"><i class="fa fa-folder"></i></button>
				<input name="field[f-no][icon]" id="icon_f-no" type="file" data-input="false" style="display: none;">
			</div>
		</div>
		<div class="m-form__group form-group">
			<div class="m-checkbox-inline">
				<label class="m-checkbox">
					<input type="checkbox" name="field[f-no][is_required]" value="1" id="is_required_f-no" />
					Require customer selection <span></span>
				</label>
			</div>
		</div>
		
		<div id="type_options_f-no">
			
		</div>
	</div>
</div>

<div id="dd_structure" style="display:none;">
	<div class="m-form__group form-group">
		<button type="button" class="btn btn-md btn-success" id="add_more_options_f-no" onclick="add_more_options('f-no')"> <i class="fa fa-plus"></i>  Add New Option</button>
	</div>
	<div class="m-form__group form-group row dd_header">
		<div class="col-sm-2">
			<label for="">Title</label>
		</div>
		<div class="col-sm-3">
			<label for="">Price Modifier</label>
		</div>
		<div class="col-sm-3">
			<label for="">Tooltip</label>
		</div>
		<div class="col-sm-2">
			<label for="">Icon</label>
		</div>
		<div class="col-sm-2">
			<label for="">Default</label>
			<a href="javascript:void(0);" onclick="clear_default('f-no')"><i class="fa fa-times"></i></a>
		</div>
		<!--<div class="col-sm-1">
			&nbsp;
		</div>-->
		<input id="no_of_dd_options_f-no" value="0" type="hidden" />
	</div>
	<div id="dd_options_f-no">
		<ul id="sortable_f-no" style="padding-left:0px;">
		
		</ul>
	</div>
	<div class="m-form__group form-group">
		<button type="button" class="btn btn-md btn-success" id="add_more_options_f-no" onclick="add_more_options('f-no')"> <i class="fa fa-plus"></i>  Add New Option</button>
	</div>
</div>

<div id="dd_options_structure" style="display:none;">
	<li class="ui-state-default m--margin-bottom-20" data-id="o-no">
		<div class="m-form__group form-group row">
			<div class="col-sm-2">
				<input name="field[f-no][options][o-no][label]" required="" id="dd_label_f-no_o-no" type="text" class="form-control m-input" />
			</div>
			<div class="col-sm-3">
				<div class="row">
					<div class="col-sm-4" style="padding-left:2px;padding-right:2px;">
					<select name="field[f-no][options][o-no][add_sub]" id="dd_add_sub_f-no_o-no" class="form-control m-input">
						<option value="+">+</option>
						<option value="-">-</option>
					</select>
					</div>
					<div class="col-sm-4" style="padding-left:2px;padding-right:2px;">
					<select name="field[f-no][options][o-no][price_type]" id="dd_price_type_f-no_o-no" class="form-control m-input">
						<option value="1">Fixed</option>
						<option value="0">%</option>
					</select>
					</div>
					<div class="col-sm-4" style="padding-left:2px;padding-right:2px;">
						<input name="field[f-no][options][o-no][price]" id="dd_price_f-no_o-no" type="text" class="form-control m-input" value="0" placeholder="0.00" />
					</div>
				</div>
			</div>
			<div class="col-sm-3">
				<div class="m-input-icon m-input-icon--right">
					<input name="field[f-no][options][o-no][tooltip]" id="dd_tooltip_f-no_o-no" type="text" class="form-control m-input" value="" />
					<span class="m-input-icon__icon m-input-icon__icon--right" onclick="deleteTooltip(this);"><span><i class="la la-trash"></i></span></span>
				</div>
			</div>																
			<div class="col-sm-2">
				<button class="btn btn-sm" type="button" onclick="$(this).next().click()"><i class="fa fa-folder"></i></button>
				<input name="field[f-no][options][o-no][icon]" id="dd_icon_f-no_o-no" type="file" data-input="false" style="display: none;">
			</div>
			<div class="col-sm-1">
				<label class="m-radio">
					<input name="field[f-no][options][o-no][is_default]" id="is_default_f-no_o-no" value="1" type="radio" class="radio_class radio_f-no" onclick="check_default('f-no')" />
					<span></span>
				</label>
			</div>
			<div class="col-sm-1">
				<i class="la la-trash trash" style="cursor:pointer;" onclick="remove_row(this)"></i>
			</div>
		</div>
	</li>
</div>

<div id="radio_structure" style="display:none;">
	<div class="m-form__group form-group row">
		<div class="col-sm-3">
			<label for="label">Label * :</label>
		</div>
		<div class="col-sm-3">
			<label for="Price">Default * :</label>
		</div>
		<input id="no_of_radio_options" value="0" type="hidden" />
	</div>
	<div id="radio_options_f-no">

	</div>
	<div class="m-form__group form-group">
		<button type="button" class="btn btn-md btn-success" id="add_more_options_f-no" onclick="add_more_radios('f-no')"> <i class="fa fa-plus"></i>  Add More Option</button>
	</div>
</div>

<div id="radio_options_structure" style="display: none;">
	<div class="m-form__group form-group row">
		<div class="col-sm-3">
			<input name="radio_label[f-no][o-no]" id="dd_label_f-no_o-no" type="text" class="form-control" />
		</div>
		<div class="col-sm-3">
			<input name="radio_default[f-no][o-no]" id="dd_price_f-no_o-no" type="radio" class="form-control" />
		</div>
		<div class="col-sm-1">
			<i class="la la-trash trash" onclick="remove_row(this)"></i>
		</div>
	</div>
</div>

<div id="checkbox_structure" style="display: none;">
	<div class="m-form__group form-group row">
		<div class="col-sm-3">
			<label for="label">Label * :</label>
		</div>
		<input id="no_of_checkbox_options" value="0" type="hidden" />
	</div>
	<div id="checkbox_options_f-no">
		
	</div>
	<div class="m-form__group form-group">
		<button type="button" class="btn btn-md btn-success" id="add_more_options_f-no" onclick="add_more_checkboxs('f-no')"> <i class="fa fa-plus"></i>  Add More Option</button>
	</div>
</div>

<div id="checkbox_options_structure" style="display: none;">
	<div class="m-form__group form-group row">
		<div class="col-sm-3">
			<input name="checkbox_label[f-no][o-no]" id="checkbox_label_f-no_o-no" type="text" class="form-control" />
		</div>
		<div class="col-sm-1">
			<i class="la la-trash trash" onclick="remove_row(this)"></i>
		</div>
	</div>
</div>

<input id="no_of_fields" value="<?=$no_of_fields?>" type="hidden" />
<input id="current_field" value="1" type="hidden" />

<script>
// basic
$('.m_select2').select2({
	placeholder: " - Select - ",
	allowClear: true
});
</script>
