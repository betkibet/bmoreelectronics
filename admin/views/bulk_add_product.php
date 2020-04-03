<?php
$custom_phpjs_path = "assets/js/custom/addedit_model.php"; ?>

<script type="text/javascript">
function check_form(a) {
	if(a.cat_id.value.trim()=="") {
		alert('Please select category');
		a.cat_id.focus();
		return false;
	}
	if(a.brand_id.value.trim()=="") {
		alert('Please select brand');
		a.brand_id.focus();
		return false;
	}
	if(a.mobile_id.value.trim()=="") {
		alert('Please select device');
		a.mobile_id.focus();
		return false;
	}
	if(a.title.value.trim()=="") {
		alert('Please enter title');
		a.title.focus();
		a.title.value='';
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

		<div class="m-content">
			<?php include('confirm_message.php'); ?>
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
										<?=($id?'Edit Product':'Add Product')?>
									</h3>
								</div>
							</div>
						</div>
						
						<div class="m-portlet__body">
							<!--begin::Form-->
							<form id="form_step_1" class="m-form m-form--fit m-form--label-align-right" action="controllers/bulk_upload.php" method="post" enctype="multipart/form-data" onSubmit="return check_form(this);">
								
								<div class="tab-content">
								
									<div class="tab-pane <?=($step_track=='1'||$step_track==''?'active':'')?>" id="m_tabs_general" role="tabpanel">
										<hr>
											<div class="form-group">Upload an Excel File</div>
										<hr>
										<div class="form-group">
											<div class="col-lg-4">
												<label for="cat_id">Upload Excel</label>
												<input type="file" name="bulk_upload">
													
											</div>
										</div>	
										<div class=" form-group">
											<input type="submit" id="m_form_submit" class="btn btn-primary" value="Save" name="b_upload" onclick="StepTrack(1)">
										</div>
									</div>
								</div>
							</form>
							<form id="form_step_1" class="m-form m-form--fit m-form--label-align-right" action="controllers/bulk_upload.php" method="post" enctype="multipart/form-data" onSubmit="return check_form(this);">
										<hr>
											<div class="form-group">Or Save a Single Record</div>
										<hr>
										<input type="hidden" name="id" value="<?=$row_pro['id']?>">
										<div class="form-group row">
											<div class="col-lg-4">
												<label for="title"><b>Title</b></label>
												<input type="text" class="form-control m-input m-input--square" id="title" value="<?=$row_pro['title']?>" name="title">
											</div>
											<div class="col-lg-4">
												<label for="carrier_title"><b>Carrier</b></label>
												<input type="text" class="form-control m-input m-input--square" id="carrier_title" value="<?=$row_pro['carrier_title']?>" name="carrier_title">
											</div>
											<div class="col-lg-4">
												<label for="storage_capacity"><b>Capacity</b></label>
												<input type="text" class="form-control m-input m-input--square" id="storage_capacity" value="<?=$row_pro['storage_capacity']?>" name="storage_capacity">
											</div>
										</div>
										<hr>
										<div class="form-group row">
											<div class="col-lg-2">
												<label for="offer_new"><b>Offer New</b></label>
												<input type="number" class="form-control m-input m-input--square" id="offer_new" value="<?=($row_pro['offer_new']>0?$row_pro['offer_new']:'')?>" name="offer_new">
											</div>
											<div class="col-lg-2">
												<label for="offer_mint"><b>Offer Mint</b></label>
												<input type="number" class="form-control m-input m-input--square" id="offer_mint" value="<?=($row_pro['offer_mint']>0?$row_pro['offer_mint']:'')?>" name="offer_mint">
											</div>
											<div class="col-lg-2">
												<label for="offer_good"><b>Offer Good</b></label>
												<input type="number" class="form-control m-input m-input--square" id="offer_good" value="<?=($row_pro['offer_good']>0?$row_pro['offer_good']:'')?>" name="offer_good">
											</div>
											<div class="col-lg-2">
												<label for="offer_fair"><b>Offer Fair</b></label>
												<input type="number" class="form-control m-input m-input--square" id="offer_fair" value="<?=($row_pro['offer_fair']>0?$row_pro['offer_fair']:'')?>" name="offer_fair">
											</div>
											<div class="col-lg-2">
												<label for="offer_broken"><b>Offer Broken</b></label>
												<input type="number" class="form-control m-input m-input--square" id="offer_broken" value="<?=($row_pro['offer_broken']>0?$row_pro['offer_broken']:'')?>" name="offer_broken">
											</div>
											<div class="col-lg-2">
												<label for="offer_damaged"><b>Offer Damaged</b></label>
												<input type="number" class="form-control m-input m-input--square" id="offer_damaged" value="<?=($row_pro['offer_damaged']>0?$row_pro['offer_damaged']:'')?>" name="offer_damaged">
											</div>

										</div>
										<div class=" form-group">
											<input type="submit" id="m_form_submit" class="btn btn-primary" value="Save" name="s_upload" onclick="StepTrack(1)">
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
</div>
<!-- end:: Body -->
