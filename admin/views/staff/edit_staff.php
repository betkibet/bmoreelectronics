<script type="text/javascript">
	function check_form(a) {
		if (a.username.value.trim() == "") {
			alert('Please enter username');
			a.username.focus();
			a.username.value = '';
			return false;
		}
		if (a.email.value.trim() == "") {
			alert('Please enter email');
			a.email.focus();
			a.email.value = '';
			return false;
		}

		<?php
	if($admin_data['id']=='') { ?>
		if (a.password.value.trim() == "") {
			alert('Please enter password.');
			a.password.focus();
			a.password.value = '';
			return false;
		}
		<?php
	} ?>

		if (a.password.value.trim() != "") {
			if (a.rpassword.value.trim() == "") {
				alert('Please enter confirm password.');
				a.rpassword.focus();
				a.rpassword.value = '';
				return false;
			}
			if (a.password.value.trim() != a.rpassword.value.trim()) {
				alert('Password and confirm password not matched.');
				a.rpassword.focus();
				a.rpassword.value = '';
				return false;
			}
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
			<!-- BEGIN: Subheader -->
			<!-- <div class="m-subheader ">
        <div class="d-flex align-items-center">
          <div class="mr-auto">
            <h3 class="m-subheader__title ">
              Profile
            </h3>
          </div>
          <!-- <div>
            <span class="m-subheader__daterange" id="m_dashboard_daterangepicker">
              <span class="m-subheader__daterange-label">
                <span class="m-subheader__daterange-title"></span>
                <span class="m-subheader__daterange-date m--font-brand"></span>
              </span>
              <a href="#" class="btn btn-sm btn-brand m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill">
                <i class="la la-angle-down"></i>
              </a>
            </span>
          </div> -->
			<!-- </div> -->
			<!-- </div> -->
			<!-- END: Subheader -->
			<div class="m-content ">
				<?php include('confirm_message.php'); ?>
				<!--Begin::Section-->
				<div class="row">
					<div class="col-lg-6">
						<!--begin::Portlet-->
						<div class="m-portlet">
							<div class="m-portlet__head">
								<div class="m-portlet__head-caption">
									<div class="m-portlet__head-title">
										<span class="m-portlet__head-icon m--hide">
                      <i class="la la-gear"></i>
                    </span>
										<h3 class="m-portlet__head-text">
                      <?=($id?'Edit Staff':'Add Staff')?>
                    </h3>
									</div>
								</div>
							</div>
							<!--begin::Form-->
							<form class="m-form" action="controllers/staff.php" role="form" method="post" onSubmit="return check_form(this);" enctype="multipart/form-data">
								<div class="m-portlet__body">
									<div class="m-form__section m-form__section--first">
										<div class="form-group m-form__group">
											<label for="field-1">
                        Username :
                      </label>
											<input type="text" class="form-control m-input" id="username" value="<?=$admin_data['username']?>" name="username">
										</div>
										<div class="form-group m-form__group">
											<label for="field-1">
                        Email :
                      </label>
											<input type="email" class="form-control m-input" id="email" value="<?=$admin_data['email']?>" name="email">
										</div>
										<div class="form-group m-form__group">
											<label for="field-1">
                        Password :
                      </label>
											<input type="password" class="form-control m-input" id="password" name="password">
										</div>
										<div class="form-group m-form__group">
											<label for="field-1">
                        Confirm Password :
                      </label>
											<input type="password" class="form-control m-input" id="rpassword" name="rpassword">
										</div>
										<div class="m-form__group form-group">
											<label for="">
												Publish :
											</label>
											<div class="m-radio-inline">
												<label class="m-radio">
													<input type="radio" id="status" name="status" value="1" <?=($admin_data['status']==1?'checked="checked"':'')?>>
													Active
													<span></span>
												</label>
												<label class="m-radio">
													<input type="radio" id="status" name="status" value="0" <?=($admin_data['status']=='0'||$admin_data['status']==''?'checked="checked"':'')?>>
													Inactive
													<span></span>
												</label>
											</div>
										</div>
									</div>
								</div>
								<input type="hidden" name="id" value="<?=$admin_data['id']?>" />

								<div class="m-portlet__foot m-portlet__foot--fit">
									<div class="m-form__actions m-form__actions">
										<button class="btn btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button>

										<a href="staff.php" class="btn btn-secondary">Back</a>
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

<!-- <div id="wrapper">
	<header id="header" class="container">
		<?php/* include("include/admin_menu.php"); ?>
	</header>

	<section class="container" role="main">
		<div class="row">
			<article class="span12 data-block">
				<header>
					<h2><?=($id?'Edit Staff':'Add Staff')?></h2></header>
				<section>
					<?php include('confirm_message.php');?>
					<div class="row-fluid">
						<div class="span9">
							<form role="form" action="controllers/staff.php" class="form-horizontal form-groups-bordered" method="post" onSubmit="return check_form(this);" enctype="multipart/form-data">
								<fieldset>
									<div class="control-group">
										<label class="control-label" for="input">Username</label>
										<div class="controls">
											<input type="text" class="input-large" id="username" value="<?=$admin_data['username']?>" name="username">
										</div>
									</div>

									<div class="control-group">
										<label class="control-label" for="input">Email</label>
										<div class="controls">
											<input type="text" class="input-large" id="email" value="<?=$admin_data['email']?>" name="email">
										</div>
									</div>

									<div class="control-group">
										<label class="control-label" for="input">Password</label>
										<div class="controls">
											<input type="password" class="input-large" id="password" name="password">
										</div>
									</div>

									<div class="control-group">
										<label class="control-label" for="input">Confirm Password</label>
										<div class="controls">
											<input type="password" class="input-large" id="rpassword" name="rpassword">
										</div>
									</div>

									<div class="control-group radio-inline">
										<label class="control-label" for="published">Status</label>
										<div class="controls">
											<label class="radio custom-radio">
												<input type="radio" id="status" name="status" value="1" <?=($admin_data['status']==1?'checked="checked"':'')?>>
												Active
											</label>
											<label class="radio custom-radio">
												<input type="radio" id="status" name="status" value="0" <?=($admin_data['status']=='0'||$admin_data['status']==''?'checked="checked"':'')?>>
												Inactive
											</label>
										</div>
									</div>

									<input type="hidden" name="id" value="<?=$admin_data['id']?>" />

									<div class="form-actions">
										<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')*/?></button>
										<a href="staff.php" class="btn btn-alt btn-large btn-black">Back</a>
									</div>
								</fieldset>
							</form>
						</div>
					</div>
				</section>
			</article>
		</div>
	</section>
	<div id="push"></div>
</div> -->
