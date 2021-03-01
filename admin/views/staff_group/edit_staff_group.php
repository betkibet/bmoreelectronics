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
										  <?=($id?'Edit Staff Group':'Add Staff Group')?>
										</h3>
									</div>
								</div>
							</div>
							<!--begin::Form-->
							<form class="m-form" action="controllers/staff_group.php" role="form" method="post" onSubmit="return check_form(this);" enctype="multipart/form-data">
								<div class="m-portlet__body">
									<div class="m-form__section m-form__section--first">
										<div class="form-group m-form__group">
											<label for="username">
												Name :
											  </label>
											<input type="text" class="form-control m-input" id="name" value="<?=$staff_group_data['name']?>" name="name" required>
										</div>
										<div class="form-group m-form__group">
											<label for="email">
												Email :
											  </label>
											<input type="email" class="form-control m-input" id="email" value="<?=$staff_group_data['email']?>" name="email">
										</div>
										
										<h4>Permissions</h4>
										<div class="form-group m-form__group">
											<label>Orders</label>
											<div class="controls">
												<label class="m-checkbox">
													<input type="checkbox" value="1" name="permissions[order_view]" <?php if(isset($permissions_array['order_view']) && $permissions_array['order_view']=='1'){echo 'checked="checked"';}?>>
													View <span></span>
												</label>
												<label class="m-checkbox ml-4">
													<input type="checkbox" value="1" name="permissions[order_add]" <?php if(isset($permissions_array['order_add']) && $permissions_array['order_add']=='1'){echo 'checked="checked"';}?>>
													Add <span></span>
												</label>
												<label class="m-checkbox ml-4">
													<input type="checkbox" value="1" name="permissions[order_edit]" <?php if(isset($permissions_array['order_edit']) && $permissions_array['order_edit']=='1'){echo 'checked="checked"';}?>>
													Edit <span></span>
												</label>
												<label class="m-checkbox ml-4">
													<input type="checkbox" value="1" name="permissions[order_delete]" <?php if(isset($permissions_array['order_delete']) && $permissions_array['order_delete']=='1'){echo 'checked="checked"';}?>>
													Delete <span></span>
												</label>
											</div>
										</div>
										
										<div class="form-group m-form__group">
											<label>Models</label>
											<div class="controls">
												<label class="m-checkbox">
													<input type="checkbox" value="1" name="permissions[model_view]" <?php if(isset($permissions_array['model_view']) && $permissions_array['model_view']=='1'){echo 'checked="checked"';}?>>
													View <span></span>
												</label>
												<label class="m-checkbox ml-4">
													<input type="checkbox" value="1" name="permissions[model_add]" <?php if(isset($permissions_array['model_add']) && $permissions_array['model_add']=='1'){echo 'checked="checked"';}?>>
													Add <span></span>
												</label>
												<label class="m-checkbox ml-4">
													<input type="checkbox" value="1" name="permissions[model_edit]" <?php if(isset($permissions_array['model_edit']) && $permissions_array['model_edit']=='1'){echo 'checked="checked"';}?>>
													Edit <span></span>
												</label>
												<label class="m-checkbox ml-4">
													<input type="checkbox" value="1" name="permissions[model_delete]" <?php if(isset($permissions_array['model_delete']) && $permissions_array['model_delete']=='1'){echo 'checked="checked"';}?>>
													Delete <span></span>
												</label>
											</div>
										</div>
										
										<div class="form-group m-form__group">
											<label>Devices</label>
											<div class="controls">
												<label class="m-checkbox">
													<input type="checkbox" value="1" name="permissions[device_view]" <?php if(isset($permissions_array['device_view']) && $permissions_array['device_view']=='1'){echo 'checked="checked"';}?>>
													View <span></span>
												</label>
												<label class="m-checkbox ml-4">
													<input type="checkbox" value="1" name="permissions[device_add]" <?php if(isset($permissions_array['device_add']) && $permissions_array['device_add']=='1'){echo 'checked="checked"';}?>>
													Add <span></span>
												</label>
												<label class="m-checkbox ml-4">
													<input type="checkbox" value="1" name="permissions[device_edit]" <?php if(isset($permissions_array['device_edit']) && $permissions_array['device_edit']=='1'){echo 'checked="checked"';}?>>
													Edit <span></span>
												</label>
												<label class="m-checkbox ml-4">
													<input type="checkbox" value="1" name="permissions[device_delete]" <?php if(isset($permissions_array['device_delete']) && $permissions_array['device_delete']=='1'){echo 'checked="checked"';}?>>
													Delete <span></span>
												</label>
											</div>
										</div>
										
										<div class="form-group m-form__group">
											<label>Brands</label>
											<div class="controls">
												<label class="m-checkbox">
													<input type="checkbox" value="1" name="permissions[brand_view]" <?php if(isset($permissions_array['brand_view']) && $permissions_array['brand_view']=='1'){echo 'checked="checked"';}?>>
													View <span></span>
												</label>
												<label class="m-checkbox ml-4">
													<input type="checkbox" value="1" name="permissions[brand_add]" <?php if(isset($permissions_array['brand_add']) && $permissions_array['brand_add']=='1'){echo 'checked="checked"';}?>>
													Add <span></span>
												</label>
												<label class="m-checkbox ml-4">
													<input type="checkbox" value="1" name="permissions[brand_edit]" <?php if(isset($permissions_array['brand_edit']) && $permissions_array['brand_edit']=='1'){echo 'checked="checked"';}?>>
													Edit <span></span>
												</label>
												<label class="m-checkbox ml-4">
													<input type="checkbox" value="1" name="permissions[brand_delete]" <?php if(isset($permissions_array['brand_delete']) && $permissions_array['brand_delete']=='1'){echo 'checked="checked"';}?>>
													Delete <span></span>
												</label>
											</div>
										</div>
										
										<div class="form-group m-form__group">
											<label>Category</label>
											<div class="controls">
												<label class="m-checkbox">
													<input type="checkbox" value="1" name="permissions[category_view]" <?php if(isset($permissions_array['category_view']) && $permissions_array['category_view']=='1'){echo 'checked="checked"';}?>>
													View <span></span>
												</label>
												<label class="m-checkbox ml-4">
													<input type="checkbox" value="1" name="permissions[category_add]" <?php if(isset($permissions_array['category_add']) && $permissions_array['category_add']=='1'){echo 'checked="checked"';}?>>
													Add <span></span>
												</label>
												<label class="m-checkbox ml-4">
													<input type="checkbox" value="1" name="permissions[category_edit]" <?php if(isset($permissions_array['category_edit']) && $permissions_array['category_edit']=='1'){echo 'checked="checked"';}?>>
													Edit <span></span>
												</label>
												<label class="m-checkbox ml-4">
													<input type="checkbox" value="1" name="permissions[category_delete]" <?php if(isset($permissions_array['category_delete']) && $permissions_array['category_delete']=='1'){echo 'checked="checked"';}?>>
													Delete <span></span>
												</label>
											</div>
										</div>
										
										<div class="form-group m-form__group">
											<label>Customers</label>
											<div class="controls">
												<label class="m-checkbox">
													<input type="checkbox" value="1" name="permissions[customer_view]" <?php if(isset($permissions_array['customer_view']) && $permissions_array['customer_view']=='1'){echo 'checked="checked"';}?>>
													View <span></span>
												</label>
												<label class="m-checkbox ml-4">
													<input type="checkbox" value="1" name="permissions[customer_add]" <?php if(isset($permissions_array['customer_add']) && $permissions_array['customer_add']=='1'){echo 'checked="checked"';}?>>
													Add <span></span>
												</label>
												<label class="m-checkbox ml-4">
													<input type="checkbox" value="1" name="permissions[customer_edit]" <?php if(isset($permissions_array['customer_edit']) && $permissions_array['customer_edit']=='1'){echo 'checked="checked"';}?>>
													Edit <span></span>
												</label>
												<label class="m-checkbox ml-4">
													<input type="checkbox" value="1" name="permissions[customer_delete]" <?php if(isset($permissions_array['customer_delete']) && $permissions_array['customer_delete']=='1'){echo 'checked="checked"';}?>>
													Delete <span></span>
												</label>
											</div>
										</div>
										
										<div class="form-group m-form__group">
											<label>Pages Management</label>
											<div class="controls">
												<label class="m-checkbox">
													<input type="checkbox" value="1" name="permissions[page_view]" <?php if(isset($permissions_array['page_view']) && $permissions_array['page_view']=='1'){echo 'checked="checked"';}?>>
													View <span></span>
												</label>
												<label class="m-checkbox ml-4">
													<input type="checkbox" value="1" name="permissions[page_add]" <?php if(isset($permissions_array['page_add']) && $permissions_array['page_add']=='1'){echo 'checked="checked"';}?>>
													Add <span></span>
												</label>
												<label class="m-checkbox ml-4">
													<input type="checkbox" value="1" name="permissions[page_edit]" <?php if(isset($permissions_array['page_edit']) && $permissions_array['page_edit']=='1'){echo 'checked="checked"';}?>>
													Edit <span></span>
												</label>
												<label class="m-checkbox ml-4">
													<input type="checkbox" value="1" name="permissions[page_delete]" <?php if(isset($permissions_array['page_delete']) && $permissions_array['page_delete']=='1'){echo 'checked="checked"';}?>>
													Delete <span></span>
												</label>
											</div>
										</div>
										
										<div class="form-group m-form__group">
											<label>Menu Management</label>
											<div class="controls">
												<label class="m-checkbox">
													<input type="checkbox" value="1" name="permissions[menu_view]" <?php if(isset($permissions_array['menu_view']) && $permissions_array['menu_view']=='1'){echo 'checked="checked"';}?>>
													View <span></span>
												</label>
												<label class="m-checkbox ml-4">
													<input type="checkbox" value="1" name="permissions[menu_add]" <?php if(isset($permissions_array['menu_add']) && $permissions_array['menu_add']=='1'){echo 'checked="checked"';}?>>
													Add <span></span>
												</label>
												<label class="m-checkbox ml-4">
													<input type="checkbox" value="1" name="permissions[menu_edit]" <?php if(isset($permissions_array['menu_edit']) && $permissions_array['menu_edit']=='1'){echo 'checked="checked"';}?>>
													Edit <span></span>
												</label>
												<label class="m-checkbox ml-4">
													<input type="checkbox" value="1" name="permissions[menu_delete]" <?php if(isset($permissions_array['menu_delete']) && $permissions_array['menu_delete']=='1'){echo 'checked="checked"';}?>>
													Delete <span></span>
												</label>
											</div>
										</div>
										
										<div class="form-group m-form__group">
											<label>Forms</label>
											<div class="controls">
												<label class="m-checkbox">
													<input type="checkbox" value="1" name="permissions[form_view]" <?php if(isset($permissions_array['form_view']) && $permissions_array['form_view']=='1'){echo 'checked="checked"';}?>>
													View <span></span>
												</label>
												<label class="m-checkbox ml-4">
													<input type="checkbox" value="1" name="permissions[form_add]" <?php if(isset($permissions_array['form_add']) && $permissions_array['form_add']=='1'){echo 'checked="checked"';}?>>
													Add <span></span>
												</label>
												<label class="m-checkbox ml-4">
													<input type="checkbox" value="1" name="permissions[form_edit]" <?php if(isset($permissions_array['form_edit']) && $permissions_array['form_edit']=='1'){echo 'checked="checked"';}?>>
													Edit <span></span>
												</label>
												<label class="m-checkbox ml-4">
													<input type="checkbox" value="1" name="permissions[form_delete]" <?php if(isset($permissions_array['form_delete']) && $permissions_array['form_delete']=='1'){echo 'checked="checked"';}?>>
													Delete <span></span>
												</label>
											</div>
										</div>
										
										<div class="form-group m-form__group">
											<label>Blog</label>
											<div class="controls">
												<label class="m-checkbox">
													<input type="checkbox" value="1" name="permissions[blog_view]" <?php if(isset($permissions_array['blog_view']) && $permissions_array['blog_view']=='1'){echo 'checked="checked"';}?>>
													View <span></span>
												</label>
												<label class="m-checkbox ml-4">
													<input type="checkbox" value="1" name="permissions[blog_add]" <?php if(isset($permissions_array['blog_add']) && $permissions_array['blog_add']=='1'){echo 'checked="checked"';}?>>
													Add <span></span>
												</label>
												<label class="m-checkbox ml-4">
													<input type="checkbox" value="1" name="permissions[blog_edit]" <?php if(isset($permissions_array['blog_edit']) && $permissions_array['blog_edit']=='1'){echo 'checked="checked"';}?>>
													Edit <span></span>
												</label>
												<label class="m-checkbox ml-4">
													<input type="checkbox" value="1" name="permissions[blog_delete]" <?php if(isset($permissions_array['blog_delete']) && $permissions_array['blog_delete']=='1'){echo 'checked="checked"';}?>>
													Delete <span></span>
												</label>
											</div>
										</div>
										
										<div class="form-group m-form__group">
											<label>Faqs</label>
											<div class="controls">
												<label class="m-checkbox">
													<input type="checkbox" value="1" name="permissions[faq_view]" <?php if(isset($permissions_array['faq_view']) && $permissions_array['faq_view']=='1'){echo 'checked="checked"';}?>>
													View <span></span>
												</label>
												<label class="m-checkbox ml-4">
													<input type="checkbox" value="1" name="permissions[faq_add]" <?php if(isset($permissions_array['faq_add']) && $permissions_array['faq_add']=='1'){echo 'checked="checked"';}?>>
													Add <span></span>
												</label>
												<label class="m-checkbox ml-4">
													<input type="checkbox" value="1" name="permissions[faq_edit]" <?php if(isset($permissions_array['faq_edit']) && $permissions_array['faq_edit']=='1'){echo 'checked="checked"';}?>>
													Edit <span></span>
												</label>
												<label class="m-checkbox ml-4">
													<input type="checkbox" value="1" name="permissions[faq_delete]" <?php if(isset($permissions_array['faq_delete']) && $permissions_array['faq_delete']=='1'){echo 'checked="checked"';}?>>
													Delete <span></span>
												</label>
											</div>
										</div>
										
										<div class="form-group m-form__group">
											<label>Promo Codes</label>
											<div class="controls">
												<label class="m-checkbox">
													<input type="checkbox" value="1" name="permissions[promocode_view]" <?php if(isset($permissions_array['promocode_view']) && $permissions_array['promocode_view']=='1'){echo 'checked="checked"';}?>>
													View <span></span>
												</label>
												<label class="m-checkbox ml-4">
													<input type="checkbox" value="1" name="permissions[promocode_add]" <?php if(isset($permissions_array['promocode_add']) && $permissions_array['promocode_add']=='1'){echo 'checked="checked"';}?>>
													Add <span></span>
												</label>
												<label class="m-checkbox ml-4">
													<input type="checkbox" value="1" name="permissions[promocode_edit]" <?php if(isset($permissions_array['promocode_edit']) && $permissions_array['promocode_edit']=='1'){echo 'checked="checked"';}?>>
													Edit <span></span>
												</label>
												<label class="m-checkbox ml-4">
													<input type="checkbox" value="1" name="permissions[promocode_delete]" <?php if(isset($permissions_array['promocode_delete']) && $permissions_array['promocode_delete']=='1'){echo 'checked="checked"';}?>>
													Delete <span></span>
												</label>
											</div>
										</div>
										
										<div class="form-group m-form__group">
											<label>Email Templates</label>
											<div class="controls">
												<label class="m-checkbox">
													<input type="checkbox" value="1" name="permissions[emailtmpl_view]" <?php if(isset($permissions_array['emailtmpl_view']) && $permissions_array['emailtmpl_view']=='1'){echo 'checked="checked"';}?>>
													View <span></span>
												</label>
												<label class="m-checkbox ml-4">
													<input type="checkbox" value="1" name="permissions[emailtmpl_add]" <?php if(isset($permissions_array['emailtmpl_add']) && $permissions_array['emailtmpl_add']=='1'){echo 'checked="checked"';}?>>
													Add <span></span>
												</label>
												<label class="m-checkbox ml-4">
													<input type="checkbox" value="1" name="permissions[emailtmpl_edit]" <?php if(isset($permissions_array['emailtmpl_edit']) && $permissions_array['emailtmpl_edit']=='1'){echo 'checked="checked"';}?>>
													Edit <span></span>
												</label>
												<label class="m-checkbox ml-4">
													<input type="checkbox" value="1" name="permissions[emailtmpl_delete]" <?php if(isset($permissions_array['emailtmpl_delete']) && $permissions_array['emailtmpl_delete']=='1'){echo 'checked="checked"';}?>>
													Delete <span></span>
												</label>
											</div>
										</div>
										
										<div class="form-group m-form__group">
											<label>Inventory</label>
											<div class="controls">
												<label class="m-checkbox">
													<input type="checkbox" value="1" name="permissions[inventory_view]" <?php if(isset($permissions_array['inventory_view']) && $permissions_array['inventory_view']=='1'){echo 'checked="checked"';}?>>
													View <span></span>
												</label>
												<label class="m-checkbox ml-4">
													<input type="checkbox" value="1" name="permissions[inventory_edit]" <?php if(isset($permissions_array['inventory_edit']) && $permissions_array['inventory_edit']=='1'){echo 'checked="checked"';}?>>
													Edit <span></span>
												</label>
												<label class="m-checkbox ml-4">
													<input type="checkbox" value="1" name="permissions[inventory_delete]" <?php if(isset($permissions_array['inventory_delete']) && $permissions_array['inventory_delete']=='1'){echo 'checked="checked"';}?>>
													Delete <span></span>
												</label>
											</div>
										</div>
										
										<div class="m-form__group form-group">
											<label for="">
												Publish :
											</label>
											<div class="m-radio-inline">
												<label class="m-radio">
													<input type="radio" id="status" name="status" value="1" <?=($staff_group_data['status']==1?'checked="checked"':'')?>>
													Active
													<span></span>
												</label>
												<label class="m-radio">
													<input type="radio" id="status" name="status" value="0" <?=($staff_group_data['status']=='0'||$staff_group_data['status']==''?'checked="checked"':'')?>>
													Inactive
													<span></span>
												</label>
											</div>
										</div>
									</div>
								</div>
								<input type="hidden" name="id" value="<?=$staff_group_data['id']?>" />

								<div class="m-portlet__foot m-portlet__foot--fit">
									<div class="m-form__actions m-form__actions">
										<button class="btn btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button>

										<a href="staff_group.php" class="btn btn-secondary">Back</a>
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

