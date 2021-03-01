<script src="js/jquery.copy.js"></script>

<script type="text/javascript">
function check_form(a) {
	if(a.slug.value.trim()==""){
		alert('Please enter slug');
		a.slug.focus();
		a.slug.value='';
		return false;
	} else if(a.name.value.trim()==""){
		alert('Please enter name');
		a.name.focus();
		a.name.value='';
		return false;
	}

	/*if(jQuery('.summernote').summernote('codeview.isActivated')) {
		jQuery('.summernote').summernote('codeview.deactivate');
	}*/
}

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
										<h3 class="m-portlet__head-text">
										  <?=($id?'Edit Order Status':'Add Order Status')?>
										</h3>
									</div>
								</div>
							</div>
							<!--begin::Form-->
							<form class="m-form" action="controllers/order_status.php" role="form" method="post" onSubmit="return check_form(this);" enctype="multipart/form-data">
								<div class="m-portlet__body">
									<div class="m-form__section m-form__section--first">
										<div class="form-group m-form__group">
											<label for="slug">Slug :</label>
											<input type="text" class="form-control m-input" id="slug" value="<?=$order_status_data['slug']?>" name="slug" <?=($order_status_data['id']>0?'readonly="readonly"':'')?>>
										</div>
										<div class="form-group m-form__group">
											<label for="name">Name :</label>
											<input type="text" class="form-control m-input" id="name" value="<?=$order_status_data['name']?>" name="name">
										</div>
										<div class="form-group m-form__group">
											<label for="description">Description :</label>
											<textarea class="form-control m-input" name="description" rows="4"><?=$order_status_data['description']?></textarea>
										</div>
										<div class="form-group m-form__group">
											<label for="color">Color :</label>
											<input type="color" class="form-control m-input" id="color" value="<?=$order_status_data['color']?>" name="color">
										</div>
										
										<div class="m-separator m-separator--dash m-separator--sm"></div>
										<div class="form-group m-form__group">
											<label>Order History Text : </label>
											<div class="input-group">
											<select class="form-control" name="constant_name" id="constant_name">
											 <option value="">Select Constant to Copy</option>
											 <?php
											 $constants_array = array('{$status_log_date}', '{$shipment_tracking_code}', '{$company_name}', '{$item_id}');
											 foreach($constants_array as $constants_value) { ?>
												<option value="<?=$constants_value?>"><?=$constants_value?></option>
											 <?php
											 } ?>
											</select>
											<input type="button" class="btn btn-brand m-btn m-btn--custom m-btn--icon m-btn--air btn-sm float-right ml-2" id="copy-constant" style="cursor:pointer;" value="COPY">
										  </div>
										</div>
										<div class="form-group m-form__group">
											<!--<label for="text_in_order_history">Order History Text :</label>-->
											<textarea class="form-control m-input" name="text_in_order_history" rows="4"><?=$order_status_data['text_in_order_history']?></textarea>
										</div>
										
										<?php
										if($order_status_data['type']!="fixed") { ?>
										<div class="m-form__group form-group">
											<label for="">
												Publish :
											</label>
											<div class="m-radio-inline">
												<label class="m-radio">
													<input type="radio" id="status" name="status" value="1" <?php if(!$order_status_data['id']){echo 'checked="checked"';}?> <?=($order_status_data['status']==1?'checked="checked"':'')?>>
													Yes
													<span></span>
												</label>
												<label class="m-radio">
													<input type="radio"  id="status" name="status" value="0" <?=($order_status_data['status']=='0'?'checked="checked"':'')?>>
													No
													<span></span>
												</label>
											</div>
										</div>
										<?php
										} else {
											echo '<input type="hidden" id="status" name="status" value="1">';
										} ?>
									</div>
								</div>
								<input type="hidden" name="id" value="<?=$order_status_data['id']?>" />
								<div class="m-portlet__foot m-portlet__foot--fit">
									<div class="m-form__actions m-form__actions">
										<button type="submit" name="update" class="btn btn-primary">
										  <?=($id?'Update':'Save')?>
										</button>
										<a href="order_status.php" class="btn btn-secondary">Back</a>
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
