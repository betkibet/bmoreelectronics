
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
                      <?='Partner: Edit Profile'?>
                    </h3>
									</div>
								</div>
							</div>
							<!--begin::Form-->
							<form class="m-form" action="controllers/partner.php" role="form" method="post" onSubmit="return check_form(this);" enctype="multipart/form-data">
								<div class="m-portlet__body">
									<div class="m-form__section m-form__section--first">
										<h5 class="m-portlet__head-text">
                      Partner Details
                    </h5>
										<div class="form-group m-form__group">
											<label for="field-1">
												Name
                      </label>
											<input type="text" class="form-control m-input" id="name" value="<?=$partner_data['name']?>" name="name">
											
										</div>
										
										<div class="form-group m-form__group">
											<label for="field-1">
												Email
											</label>
											<input type="email" class="form-control m-input" id="email" value="<?=$partner_data['email']?>" name="email">
										</div>
										<div class="form-group m-form__group">
											<label for="field-1">
												Shop Name
											</label>
											<input type="text" class="form-control m-input" id="store_name" value="<?=$partner_data['store_name']?>" name="store_name">
											<?php
											if($partner_data['store_name']) { ?>
											SHOP URL: <a href="<?=SITE_URL?>apr/?apr=<?=$partner_data['store_name']?>" target="_blank"><?=SITE_URL?>apr/?apr=<?=$partner_data['store_name']?></a>
											<?php
											} ?>
										</div>
										
										<div class="m-form__group form-group">
											<label for="">
												Publish :
											</label>
											<div class="m-radio-inline">
												<label class="m-radio">
													<input type="radio" id="status" name="status" value="1" <?php if(!$id){echo 'checked="checked"';}?> <?=($partner_data['status']==1?'checked="checked"':'')?>>
													Active
													<span></span>
												</label>
												<label class="m-radio">
													<input type="radio"  id="status" name="status" value="0" <?=($partner_data['status']=='0'?'checked="checked"':'')?>>
													Inactive
													<span></span>
												</label>
											</div>
										</div>
									</div>
								</div>
								<div class="m-portlet__foot m-portlet__foot--fit">
									<div class="m-form__actions m-form__actions">
										<button type="submit" name="update" class="btn btn-primary">
										  <?=($_REQUEST['id']?'Update':'Save')?>
										</button>
										<a href="partners.php" class="btn btn-secondary">Back</a>
									</div>
								</div>
								<input type="hidden" name="id" value="<?=$partner_data['id']?>" />
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

<script>
  function check_form(a) {
    if (a.name.value.trim() == "") {
      alert('Please enter name');
      a.name.focus();
      a.name.value = '';
      return false;
    }
    if (a.email.value.trim() == "") {
      alert('Please enter email');
      a.email.focus();
      a.email.value = '';
      return false;
    }
    if (a.store_name.value.trim() == "") {
      alert('Please enter store name');
      a.store_name.focus();
      a.store_name.value = '';
      return false;
    }
  }
</script>
