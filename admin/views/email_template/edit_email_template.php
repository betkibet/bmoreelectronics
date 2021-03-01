<script src="js/jquery.copy.js"></script>

<script type="text/javascript">
$(document).ready(function() {
  $("#copy-constant").click(function() {
  	var constant_name = $("#constant_name").val();
	if(constant_name == "") {
		alert("Please select constant.");
		return false;
	} else {
   		var res = $.copy(constant_name);
    	//$("#status").text(res);
	}
  });
});

function form_validation(a){
	if(a.content.value.trim()=="") {
		alert('Please enter email content');
		a.content.focus();
		a.content.value='';
		return false;
	}

	<?php
	if(in_array($template_data['type'],$sms_sec_show_in_tmpl_array)) { ?>
	if(document.getElementById("sms_status_on").checked == true) {
		if(a.sms_content.value.trim()=="") {
			alert('Please enter sms content');
			a.sms_content.focus();
			a.sms_content.value='';
			return false;
		}
	}
	<?php
	} ?>
	
	if(jQuery('.summernote').summernote('codeview.isActivated')) {
		jQuery('.summernote').summernote('codeview.deactivate');
	}
}
</script>

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
			<div class="m-content ">
				<?php include('confirm_message.php'); ?>
				<!--Begin::Section-->
				<div class="row">
					<div class="col-lg-8">
						<!--begin::Portlet-->
						<div class="m-portlet">
							<div class="m-portlet__head">
								<div class="m-portlet__head-caption">
									<div class="m-portlet__head-title">
										<span class="m-portlet__head-icon m--hide">
										  <i class="la la-gear"></i>
										</span>
										<h3 class="m-portlet__head-text">Edit Email template</h3>
									</div>
								</div>
							</div>
							<!--begin::Form-->
							<form class="m-form" action="controllers/email_template.php" role="form" method="post" enctype="multipart/form-data" onSubmit="return form_validation(this);">
								<div class="m-portlet__body">
									<div class="m-form__section m-form__section--first">
										<div class="form-group m-form__group">
											<label for="input">
											Template type :
										</label>
										<?php
										if($template_data['id']!='' && $template_data['is_fixed'] == '1') { ?>
											<input type="text" class="form-control m-input" value="<?=$template_type_array[$template_data['type']]?>" readonly="" />
											<input type="hidden" name="is_fixed" value="1" />
										<?php 
										} else{ ?>
											<select class="form-control m-select2 m-select2-general" name="type" id="type" required>
												<option value="">Select Template Type</option>
												<?php
												if(!empty($order_status_list)) {
													foreach($order_status_list as $order_status_data) {
														$template_type_val = "order_".str_replace('-','_',$order_status_data['slug'])."_status";
														$template_type_label = "Order ".$order_status_data['name']." Status"; ?>
														<option value="<?=$template_type_val?>" <?php if($template_data['type'] == $template_type_val){echo 'selected="selected"';}?>><?=$template_type_label?></option>
													<?php
													}
												} ?>
											</select>
											<input type="hidden" name="is_fixed" value="0" />
										<?php 
										} ?>
										</div>
                   					    <div class="form-group m-form__group">
											<label for="input">Subject</label>
											<input type="text" class="form-control m-input" id="subject" value="<?=$template_data['subject']?>" name="subject">
										</div>
										<div class="form-group m-form__group">
											<label for="fa_icon">Copy :</label>
											<div class="input-group">
                        					<select class="form-control" name="constant_name" id="constant_name">
  											 <option value="">Select Constant to Copy</option>
                          					 <?php
     										 foreach($constants_array as $constants_value) { ?>
     										 	<option value="<?=$constants_value?>"><?=$constants_value?></option>
     										 <?php
     										 } ?>
  											</select>
											<input type="button" class="btn btn-brand m-btn m-btn--custom m-btn--icon m-btn--air btn-sm float-right ml-2" id="copy-constant" style="cursor:pointer;" value="COPY">
										  </div>
										</div>
										<div class="form-group m-form__group">
											<label for="input">
												Email Content :
											</label>
											<textarea class="form-control m-input summernote" id="text_editor" name="content" rows="8"><?=$template_data['content']?></textarea>
										</div>

										<?php
									if(in_array($template_data['type'],$sms_sec_show_in_tmpl_array) || ($template_data['id']=='' || $template_data['is_fixed'] != '1')) { ?>
										<div class="form-group m-form__group">
											<label for="published">SMS Section</label>
											<div class="m-radio-inline">
												<label class="m-radio">
													<input type="radio" id="sms_status_on" name="sms_status" value="1" <?=($template_data['sms_status']==1?'checked="checked"':'')?>>
													ON
													<span></span>
												</label>
												<label class="m-radio">
													<input type="radio" id="sms_status_off" name="sms_status" value="0" <?=(intval($template_data['sms_status'])=='0'?'checked="checked"':'')?>>
													OFF
													<span></span>
												</label>
											</div>
										</div>
	
										<div class="m-form__group form-group">
										  <label for="input">SMS Content :</label>
										  <div class="controls">
										  <textarea class="form-control m-input" id="sms_content" name="sms_content" rows="5" cols="50"><?=$template_data['sms_content']?></textarea>
										  </div>
										</div>
										<?php
										} ?>
									
										<div class="m-form__group form-group">
											<label for="">
												Active :
											</label>
											<div class="m-radio-inline">
												<label class="m-radio">
													<input type="radio" id="status_1" name="status" value="1" <?=($template_data['status']=='1'?'checked="checked"':'')?>>
													Yes
													<span></span>
												</label>
												<label class="m-radio">
													<input type="radio" id="status_0" name="status" value="0" <?=($template_data['status']=='0'||$template_data['status']==''?'checked="checked"':'')?>>
													No
													<span></span>
												</label>
											</div>
										</div>
									
									</div>
								</div>
								<input type="hidden" name="id" value="<?=$template_data['id'] ?>" />
								<div class="m-portlet__foot m-portlet__foot--fit">
									<div class="m-form__actions m-form__actions">
										<button class="btn btn-primary" type="submit" name="update">Submit</button>
										<a href="email_templates.php" class="btn btn-secondary">Back</a>
									</div>
								</div>
							</form>
							<!--end::Form-->
						</div>
						<!--end::Portlet-->
					</div>
				</div>
				<!--End::Section-->
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
