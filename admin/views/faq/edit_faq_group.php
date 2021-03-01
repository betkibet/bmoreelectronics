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
										  <?=($id?'Edit Faq Group':'Add Faq Group')?>
										</h3>
									</div>
								</div>
							</div>
							<!--begin::Form-->
							<form class="m-form" action="controllers/faq_group.php" role="form" method="post" onSubmit="return check_form(this);" enctype="multipart/form-data">
								<div class="m-portlet__body">
									<div class="m-form__section m-form__section--first">
										<div class="form-group m-form__group">
											<label for="title">Name :</label>
											<input type="text" class="form-control m-input" id="title" value="<?=$faq_data['title']?>" name="title" required>
										</div>
										
										<div class="form-group m-form__group">
											<label for="input">Category :</label>
											<select class="form-control m-select2 m-select2-general" name="cat_id[]" id="cat_id" multiple="multiple">
												<option value=""> - Select - </option>
												<?php
												while($categories_list=mysqli_fetch_assoc($categories_data)) { ?>
													<option value="<?=$categories_list['id']?>" <?php if(in_array($categories_list['id'],$cat_ids_array)){echo 'selected="selected"';} //if($categories_list['id']==$faq_data['cat_id']){echo 'selected="selected"';}?>><?=$categories_list['title']?></option>
												<?php
												} ?>
											</select>
										</div>
										
										<div class="m-form__group form-group">
											<div class="m-checkbox-inline">
												<label class="m-checkbox">
													<input id="show_in_model_list" type="checkbox" value="1" name="show_in_model_list" <?=($faq_data['show_in_model_list']==1?'checked="checked"':'')?>>
													Show In Model List
													<span></span>
												</label>
												<label class="m-checkbox">
													<input id="show_in_model_details" type="checkbox" value="1" name="show_in_model_details" <?=($faq_data['show_in_model_details']==1?'checked="checked"':'')?>>
													Show In Model Details
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
										<a href="faqs_groups.php" class="btn btn-secondary">Back</a>
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