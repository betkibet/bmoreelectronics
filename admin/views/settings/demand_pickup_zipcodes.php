<script type="text/javascript">
function check_form(a){
	/*if(a.zipcodes.value.trim()==""){
		alert('Please enter zipcodes');
		a.zipcodes.focus();
		a.zipcodes.value='';
		return false;
	}*/
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

	if((FileExt != "gif" && FileExt != "png" && FileExt != "jpg" && FileExt != "jpeg" && FileExt != "svg")){
	    var error = "Please make sure your file is in png | jpg | jpeg | gif | svg format.\n\n";
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
										  Zip codes for on Demand Pickup
										</h3>
									</div>
								</div>
							</div>
							<!--begin::Form-->
							<form class="m-form" action="controllers/demand_pickup_zipcodes.php" role="form" method="post" onSubmit="return check_form(this);" enctype="multipart/form-data">
								<div class="m-portlet__body">
									<div class="m-form__section m-form__section--first">
										<div class="form-group m-form__group">
											<label>Zip codes separated by commas(,)</label>
											<textarea class="form-control m-input" id="zipcodes" name="zipcodes" rows="6"><?=$zipcodes_data['zipcodes']?></textarea>
										</div>
										
										<div class="form-group">
											<label for="recipient-name" class="form-control-label">Select Excel File To Import</label>
											<input type="file" class="form-control" id="file_name" name="file_name">
										</div>
										<div class="form-group">
											<a href="sample_files/demand_pickup_zipcodes.csv" class="btn btn-sm btn-success"><i class="la la-download"></i> Download Sample Excel File</a>
										</div>
										<div class="form-group m-form__group">
											<label>URL</label>
											<input type="url" class="form-control m-input" value="<?=$zipcodes_data['url']?>" name="url">
										</div>
									</div>
								</div>
								<input type="hidden" name="id" value="<?=$zipcodes_data['id']?>" />
								<div class="m-portlet__foot m-portlet__foot--fit">
									<div class="m-form__actions m-form__actions">
										<button type="submit" name="update" class="btn btn-primary">
										  Save
										</button>
										<a href="general_settings.php" class="btn btn-secondary">Back</a>
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
