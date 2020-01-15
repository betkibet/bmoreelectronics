<script type="text/javascript">
function form_validation(a){
	if(a.name.value.trim()=="") {
		alert('Please enter promo name');
		a.name.focus();
		return false;
	}
	if(a.promocode.value.trim()=="") {
		alert('Please enter promo code');
		a.promocode.focus();
		return false;
	}
	if(a.promocode.value.match(/\s/g)) {
		alert('Not allowed any spaces in promo code.');
		a.promocode.focus();
		return false;
	}
	if(a.description.value.trim()=="") {
		alert('Please enter promocode description');
		a.description.focus();
		return false;
	} else if(a.from_date.value.trim()=="") {
		alert('Please enter from date');
		a.from_date.focus();
		return false;
	} else if(a.to_date.value.trim()=="" && document.getElementById("never_expire").checked == false) {
		alert('Please enter expire date');
		a.to_date.focus();
		return false;
	}/* else if(a.discount.value.trim()=="") {
		alert('Please enter discount');
		a.discount.focus();
		return false;
	}*/
}

function change_disc_type(val) {
	if(val == "percentage") {
		jQuery(".discount_lbl").html('Surcharge (%) *');
	} else {
		jQuery(".discount_lbl").html('Surcharge (<?=$currency_symbol?>) *');
	}
}

function change_multi_act_by_same_cust() {
	if(document.getElementById("multiple_act_by_same_cust").checked == true) {
		jQuery(".showhide_cust_qty").show();
	} else {
		jQuery(".showhide_cust_qty").hide();
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
											Add Promo Code
                    					</h3>
									</div>
								</div>
							</div>
							<!--begin::Form-->
							<form class="m-form" action="controllers/promocode.php" role="form" method="post" onSubmit="return form_validation(this);" enctype="multipart/form-data">
								<div class="m-portlet__body">
									<div class="m-form__section m-form__section--first">
										<div class="form-group m-form__group">
										  <label for="input">Promo Name *</label>
										  <input type="text" class="form-control m-input" id="name" name="name" maxlength="255" placeholder="Enter promo name">
										</div>
										<div class="form-group m-form__group">
											<label for="input">
												Promo Code : *
											</label>
											<input type="text" class="form-control m-input" id="promocode" name="promocode" maxlength="15" placeholder="Enter promocode">
										</div>
										<div class="form-group m-form__group">
											<label for="input">
												Description :
											</label>
											<textarea class="form-control m-input summernote" rows="3" id="description" name="description" placeholder="Enter description"></textarea>
										</div>
										
										<div class="form-group m-form__group">
											<label for="fileInput">Image :</label>
											<div class="custom-file">
												<input type="file" id="image" class="custom-file-input" name="image" onChange="checkFile(this);" accept="image/*">
												<label class="custom-file-label" for="image">
													Choose file
												</label>
											</div>
                    					</div>
										
										<div class="form-group m-form__group">
											<label for="input">
												From Date : *
											</label>
											<input class="form-control m-input" type="date" id="from_date" name="from_date" placeholder="Enter from date (mm/dd/yyyy)">
										</div>
									</div>
									<div class="form-group m-form__group">
										<label for="input">
											Expire Date : *
										</label>
										<input class="form-control m-input" type="date" id="to_date" name="to_date" placeholder="Enter to date (mm/dd/yyyy)">
									</div>
									<div class="m-form__group form-group">
										<div class="m-checkbox-list">
											<label class="m-checkbox">
												<input id="never_expire" type="checkbox" value="1" name="never_expire"> Never expire
												<span></span>
											</label>
										</div>
									</div>
									<div class="form-group m-form__group">
										<label for="discount_type">Surcharge Type</label>
										<div class="m-radio-inline">
											<label class="m-radio">
												<input type="radio" id="discount_type_on" name="discount_type" value="flat" onchange="change_disc_type(this.value)">
												Flat
												<span></span>
											</label>
											<label class="m-radio">
												<input type="radio" id="discount_type_off" name="discount_type" value="percentage" checked="checked" onchange="change_disc_type(this.value)">
												Percentage
												<span></span>
											</label>
										</div>
									</div>
									<div class="form-group m-form__group">
										<label class="control-label discount_lbl" for="discount">Surcharge <?=($promocode_data['discount_type']=='flat'?'('.$currency_symbol.') ':'(%)')?> *</label>
										<input type="text" class="form-control m-input" id="discount" name="discount" placeholder="Enter discount" value="<?=$promocode_data['discount']?>">
									</div>
									<div class="m-form__group form-group">
										<div class="m-checkbox-list">
											<label class="m-checkbox">
												<input type="checkbox" value="1" id="multiple_act_by_same_cust" name="multiple_act_by_same_cust" onchange="change_multi_act_by_same_cust()">
												Allow multiple activation by same customer.
												<span></span>
											</label>
											<input type="number" class="form-control m-input showhide_cust_qty" id="multi_act_by_same_cust_qty" name="multi_act_by_same_cust_qty" value="<?=$promocode_data['multi_act_by_same_cust_qty']?>" placeholder="Enter Qty" style="display:none;">
										</div>
									</div>
									<div class="form-group m-form__group">
										<label for="act_by_cust">How many times can this code be activated? </label>
										<input type="number" class="form-control m-input" id="act_by_cust" name="act_by_cust" value="<?=$promocode_data['act_by_cust']?>">
									</div>
									<div class="m-form__group form-group">
										<label for="">
											Active :
										</label>
										<div class="m-radio-inline">
											<label class="m-radio">
												<input type="radio" id="status" name="status" value="1">
												Yes
												<span></span>
											</label>
											<label class="m-radio">
												<input type="radio" id="status" name="status" value="0" checked="checked">
												No
												<span></span>
											</label>
										</div>
									</div>
								</div>
								
								<div class="m-portlet__foot m-portlet__foot--fit">
									<div class="m-form__actions m-form__actions">
										<button class="btn btn-primary" type="submit" name="add">Submit</button>
										<a href="promocode.php" class="btn btn-secondary">Back</a>
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

