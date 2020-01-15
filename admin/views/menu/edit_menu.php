<script type="text/javascript">
function check_form(a){
	if(a.page_id.value=="" && a.url.value.trim()=="") {
		alert('Must be select page or enter url');
		a.page_id.focus();
		return false;
	}
	if(a.menu_name.value.trim()=="") {
		alert('Please enter menu name');
		a.menu_name.focus();
		a.menu_name.value='';
		return false;
	}
}

function SelectPage(page) {
	if(page!="") {
		$(".showhide_menu_url").hide();
	} else {
		$(".showhide_menu_url").show();
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
										  <?=($id?'Edit Menu':'Add Menu')?>
										</h3>
									</div>
								</div>
							</div>
							<!--begin::Form-->
							<form class="m-form" action="controllers/menu.php" role="form" method="post" onSubmit="return check_form(this);">
								<div class="m-portlet__body">
									<div class="m-form__section m-form__section--first">
										<div class="form-group m-form__group">
											<label for="input">Select Page :</label>
											<select class="form-control" name="page_id" id="page_id" onchange="SelectPage(this.value)">
												<option value=""> -Select- </option>
												<?php
												//Fetch page list
												$pages_data=mysqli_query($db,'SELECT * FROM pages WHERE published=1');
												while($pages_list=mysqli_fetch_assoc($pages_data)) { ?>
													<option value="<?=$pages_list['id']?>" <?php if($pages_list['id']==$menu_data['page_id']){echo 'selected="selected"';}?>><?=$pages_list['title']?></option>
												<?php
												} ?>
											</select>
										</div>
										<div class="form-group m-form__group showhide_menu_url" <?=($menu_data['page_id']>0?'style="display:none;"':'')?>>
											<label for="url">Url :</label>
											<input type="text" class="form-control m-input" id="url" value="<?=$menu_data['url']?>" name="url">
										</div>
										<div class="form-group m-form__group">
											<div class="m-checkbox-list">
												<label class="m-checkbox showhide_menu_url" <?=($menu_data['page_id']>0?'style="display:none;"':'')?>>
													<input type="checkbox" id="is_custom_url" value="1" name="is_custom_url" <?=($menu_data['is_custom_url']=='1'?'checked="checked"':'')?>>
													Custom Url.
													<span></span>
												</label>
												<label class="m-checkbox">
													<input type="checkbox" id="is_open_new_window" value="1" name="is_open_new_window" <?=($menu_data['is_open_new_window']=='1'?'checked="checked"':'')?>>
													Is Open New Window
													<span></span>
												</label>
											</div>
										</div>
										<div class="form-group m-form__group">
											<label for="input">Name :</label>
											<input type="text" class="form-control m-input" id="menu_name" value="<?=$menu_data['menu_name']?>" name="menu_name">
										</div>
										<div class="form-group m-form__group">
											<label for="input">Custom CSS Class :</label>
											<input type="text" class="form-control m-input" id="css_menu_class" value="<?=$menu_data['css_menu_class']?>" name="css_menu_class">
										</div>
										<div class="form-group m-form__group">
											<label for="input">Custom CSS Class Fa Icon :</label>
											<input type="text" class="form-control m-input" id="css_menu_fa_icon" value="<?=$menu_data['css_menu_fa_icon']?>" name="css_menu_fa_icon">
										</div>
										<div class="form-group m-form__group">
											<label for="input">Parent Menu :</label>
											<select class="form-control m-select2 m-select2-general	" name="parent" id="parent">
												<option value=""> -Select- </option>
												<?php
												//Fetch page list
												$pmenus_data=mysqli_query($db,"SELECT * FROM menus WHERE status=1 AND position='".$menu_position."'");
												while($parent_menus_list=mysqli_fetch_assoc($pmenus_data)) { ?>
													<option value="<?=$parent_menus_list['id']?>" <?php if($parent_menus_list['id']==$menu_data['parent']){echo 'selected="selected"';}?>><?=$parent_menus_list['menu_name']?></option>
												<?php
												} ?>
											</select>
											<small>Allow maximum two level</small>
										</div>
										<div class="form-group m-form__group">
											<label for="input">Order (Must be numeric) :</label>
											<input type="number" class="form-control m-input" id="ordering" name="ordering" value="<?=$menu_data['ordering']?>">
										</div>
										<div class="m-form__group form-group">
											<label for="">
												Status :
											</label>
											<div class="m-radio-inline">
												<label class="m-radio">
													<input type="radio" id="status" name="status" value="1" <?php if(!$id){echo 'checked="checked"';}?> <?=($menu_data['status']==1?'checked="checked"':'')?>>
													Active
													<span></span>
												</label>
												<label class="m-radio">
													<input type="radio" id="status" name="status" value="0" <?=($menu_data['status']=='0'?'checked="checked"':'')?>>
													Inactive
													<span></span>
												</label>
											</div>
										</div>
									</div>
								</div>
								<input type="hidden" name="id" value="<?=$menu_data['id']?>" />
								<input type="hidden" name="position" value="<?=$menu_position?>" />
								<div class="m-portlet__foot m-portlet__foot--fit">
									<div class="m-form__actions m-form__actions">
										<button type="submit" class="btn btn-primary" name="add_edit"><?=($id?'Update':'Save')?></button>
										<a href="menu.php?position=<?=$menu_position?>" class="btn btn-secondary">Back</a>
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
