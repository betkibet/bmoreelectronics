<script type="text/javascript">
function check_form(a){
	if(a.title.value.trim()=="") {
		alert('Please enter question');
		a.title.focus();
		return false;
	}

	var description = jQuery(".summernote").summernote("code").replace(/&nbsp;|<\/?[^>]+(>|$)/g,"").trim();
	if(description.length == 0) {
		alert('Please enter answer');
		a.description.focus();
		return false;
	}

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
										<h3 class="m-portlet__head-text">
										  <?=($id?'Edit Faq':'Add Faq')?>
										</h3>
									</div>
								</div>
							</div>
							<!--begin::Form-->
							<form class="m-form" action="controllers/faq.php" role="form" method="post" onSubmit="return check_form(this);" enctype="multipart/form-data">
								<div class="m-portlet__body">
									<div class="m-form__section m-form__section--first">
										
										
										<div class="form-group m-form__group">
											<label for="input">Group :</label>
											<select class="form-control m-select2 m-select2-general" name="group_id" id="group_id">
												<option value=""> -Select- </option>
												<?php
												while($faqs_groups_data=mysqli_fetch_assoc($faqs_groups_q)) { ?>
													<option value="<?=$faqs_groups_data['id']?>" <?php if($faqs_groups_data['id']==$faq_data['group_id']){echo 'selected="selected"';}?>><?=$faqs_groups_data['title']?></option>
												<?php
												} ?>
											</select>
										</div>
										
										<div class="form-group m-form__group">
											<label for="title">Question :</label>
											<input type="text" class="form-control m-input" id="title" value="<?=$faq_data['title']?>" name="title">
										</div>
										
										<div class="form-group m-form__group">
											<label for="description">Answer :</label>
											<textarea class="form-control m-input summernote" name="description" rows="5"><?=$faq_data['description']?></textarea>
										</div>
										
										<div class="m-form__group form-group">
											<div class="m-checkbox-list">
												<label class="m-checkbox">
													<input id="is_show_in_home_page" type="checkbox" value="1" name="is_show_in_home_page" <?php if($faq_data['is_show_in_home_page']=='1'){echo 'checked="checked"';}?>>
													Is Show In Home Page
													<span></span>
												</label>
											</div>
										</div>
										
										<div class="m-form__group form-group">
											<label for="">
												Publish :
											</label>
											<div class="m-radio-inline">
												<label class="m-radio">
													<input type="radio" id="status" name="status" value="1" <?php if(!$id){echo 'checked="checked"';}?> <?=($faq_data['status']==1?'checked="checked"':'')?>>
													Yes
													<span></span>
												</label>
												<label class="m-radio">
													<input type="radio"  id="status" name="status" value="0" <?=($faq_data['status']=='0'?'checked="checked"':'')?>>
													No
													<span></span>
												</label>
											</div>
										</div>
									</div>
								</div>
								<input type="hidden" name="id" value="<?=$faq_data['id']?>" />
								<div class="m-portlet__foot m-portlet__foot--fit">
									<div class="m-form__actions m-form__actions">
										<button type="submit" name="update" class="btn btn-primary">
										  <?=($id?'Update':'Save')?>
										</button>
										<a href="faqs.php" class="btn btn-secondary">Back</a>
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