<?php
$file_name="groups";

//Header section
require_once("include/header.php");
$con = $db;
?>

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
										<h3 class="m-portlet__head-text">Add / Edit Group</h3>
										<?php
										$sql = "select * from groups where id = '".$_REQUEST['id']."'";
										$exe = mysqli_query($con,$sql);
										$row = mysqli_fetch_assoc($exe); ?>

										<!--<div class="alert alert-warning hidden fade in">
										  <h4>Oh snap!</h4>
										  <p>This form seems to be invalid :(</p>
										</div>

										<div class="alert alert-info hidden fade in">
										  <h4>Yay!</h4>
										  <p>Everything seems to be ok :)</p>
										</div>-->
									</div>
								</div>
							</div>
							<!--begin::Form-->
							
							<form class="m-form" action="action.php" role="form" method="post" onSubmit="return check_form(this);" enctype="multipart/form-data">
								<div class="m-portlet__body">
									<div class="m-form__section m-form__section--first">
										<div class="form-group m-form__group">
											<label for="field-1">
                        Group Name * :
                      </label>
											<input type="text" class="form-control m-input" name="name" id="name" value="<?php echo $row['name']; ?>" required="">
										</div>
										<div class="m-form__group form-group">
											<label for="">
												Status * :
											</label>
											<div class="m-radio-inline">
												<label class="m-radio">
													<input type="radio"  name="status" id="statusP" value="1" <?php if($row['status']==1){ echo "checked"; } ?> required="">
													Active
													<span></span>
												</label>
												<label class="m-radio">
													<input type="radio"  name="status" id="statusNP" value="0" <?php if($row['status']==0){ echo "checked"; } ?>>
													Inactive
													<span></span>
												</label>
											</div>
										</div>
									</div>
								</div>
								<div class="m-portlet__foot m-portlet__foot--fit">
									<div class="m-form__actions m-form__actions">
										<input type="hidden" name="action" value="save_group">
										<input type="hidden" name="user_id" value="<?=$_SESSION['id']?>">
										<input type="hidden" name="id" value="<?=$row['id']?>">
										<input type="submit" class="btn btn-primary" value="Save">
										<a href="groups.php" class="btn btn-secondary">Back</a>
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

