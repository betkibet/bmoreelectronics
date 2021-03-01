<?php
$tooltips_content = "";
if($id == '1') {
	$tooltips_content = $order_complete_mail_in_tooltips_admin;
} elseif($id == '2') {
	$tooltips_content = $order_complete_meet_up_tooltips_admin;
} elseif($id == '3') {
	$tooltips_content = $order_complete_drop_by_tooltips_admin;
} ?>

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
										  <?=($id?'Edit Order Complete Page':'Add Order Complete Page')?>&nbsp;<a href="javascript:void(0);" data-toggle="tooltip" data-skin="light" title="<?=$tooltips_content?>" data-html="true"><span class="fa fa-info-circle"></span></a>
										</h3>
									</div>
								</div>
							</div>
							<!--begin::Form-->
							<form class="m-form" action="controllers/order_complete_page.php" role="form" method="post" onSubmit="return check_form(this);" enctype="multipart/form-data">
								<div class="m-portlet__body">
									<div class="m-form__section m-form__section--first">
										<div class="m-form__group form-group">
											<label>Heading</label>
											<input type="text" class="form-control m-input" name="success_page_content[heading]" value="<?=$success_page_content['heading']?>">
										</div>
										<div class="m-form__group form-group">
											<label>Sub Heading - ${order_id}</label>
											<input type="text" class="form-control m-input" name="success_page_content[sub_heading]" value="<?=$success_page_content['sub_heading']?>">
										</div>
										<div class="m-form__group form-group">
											<label>Intro Text</label>
											<textarea class="form-control m-input" name="success_page_content[intro_text]" rows="5"><?=$success_page_content['intro_text']?></textarea>
										</div>
										
										<div class="m-separator m-separator--dash m-separator--sm"></div>
										<div class="m-form__group form-group">
											<label>Step Heading</label>
											<input type="text" class="form-control m-input" name="success_page_content[step_heading]" value="<?=$success_page_content['step_heading']?>">
										</div>
										<div class="m-form__group form-group">
											<label>Step Sub Heading</label>
											<input type="text" class="form-control m-input" name="success_page_content[step_sub_heading]" value="<?=$success_page_content['step_sub_heading']?>">
										</div>
										
										<div class="m-form__group form-group">
											<label>Step1 Title</label>
											<input type="text" class="form-control m-input" name="success_page_content[step1_title]" value="<?=$success_page_content['step1_title']?>">
										</div>
										<div class="m-form__group form-group">
											<label>Step1 Instruction</label>
											<textarea class="form-control m-input" name="success_page_content[step1_instruction]" rows="5"><?=$success_page_content['step1_instruction']?></textarea>
										</div>
										
										<div class="m-form__group form-group">
											<label>Step2 Title</label>
											<input type="text" class="form-control m-input" name="success_page_content[step2_title]" value="<?=$success_page_content['step2_title']?>">
										</div>
										<div class="m-form__group form-group">
											<label>Step2 Instruction</label>
											<textarea class="form-control m-input" name="success_page_content[step2_instruction]" rows="5"><?=$success_page_content['step2_instruction']?></textarea>
										</div>
										
										<div class="m-form__group form-group">
											<label>Step3 Title</label>
											<input type="text" class="form-control m-input" name="success_page_content[step3_title]" value="<?=$success_page_content['step3_title']?>">
										</div>
										<div class="m-form__group form-group">
											<label>Step3 Instruction - ${download_pdf_lebal_link}</label>
											<textarea class="form-control m-input" name="success_page_content[step3_instruction]" rows="5"><?=$success_page_content['step3_instruction']?></textarea>
										</div>
										
										<?php /*?><div class="m-form__group form-group">
											<label>Publish</label>
											<div class="m-radio-inline">
												<label class="m-radio">
													<input type="radio" id="status" name="status" value="1" <?=($order_complete_page_data['status']==1?'checked="checked"':'')?>>
													Yes
													<span></span>
												</label>
												<label class="m-radio">
													<input type="radio"  id="status" name="status" value="0" <?=($order_complete_page_data['status']=='0'?'checked="checked"':'')?>>
													No
													<span></span>
												</label>
											</div>
										</div><?php */?>
									</div>
								</div>
								<input type="hidden" name="id" value="<?=$order_complete_page_data['id']?>" />
								<div class="m-portlet__foot m-portlet__foot--fit">
									<div class="m-form__actions m-form__actions">
										<button type="submit" name="update" class="btn btn-primary">
										  <?=($id?'Update':'Save')?>
										</button>
										<a href="order_complete_pages.php" class="btn btn-secondary">Back</a>
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
