<script type="text/javascript">
function check_form(a){
	if(a.menu_name.value.trim()=="") {
		alert('Please enter menu name');
		a.menu_name.focus();
		return false;
	}
	<?php
	if(!in_array($post['slug'],array("home"))) { ?>
	if(a.title.value.trim()=="") {
		alert('Please enter title');
		a.title.focus();
		return false;
	} else if(a.url.value.trim()=="") {
		alert('Please enter url');
		a.url.focus();
		return false;
	}
	<?php
	}
	if(!$post['slug']) { ?>
	if(a.description.value.trim()=="") {
		alert('Please enter description');
		a.description.focus();
		a.description.value='';
		return false;
	}
	<?php
	} ?>
}

function get_c_b_d_type(type) {
	if(type == "cat") {
		$(".category_showhide").show();
		$(".brand_showhide").hide();
		$(".device_showhide").hide();
	} else if(type == "brand") {
		$(".category_showhide").hide();
		$(".brand_showhide").show();
		$(".device_showhide").hide();
	} else if(type == "device") {
		$(".category_showhide").hide();
		$(".brand_showhide").hide();
		$(".device_showhide").show();
	} else {
		$(".category_showhide").hide();
		$(".brand_showhide").hide();
		$(".device_showhide").hide();
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
										  <?=($id?'Edit Page':'Add Page')?>
										</h3>
									</div>
								</div>
							</div>
							<!--begin::Form-->
							<form class="m-form" action="controllers/custom_page.php" role="form" method="post" onSubmit="return check_form(this);" enctype="multipart/form-data">
								<div class="m-portlet__body">
									<div class="m-form__section m-form__section--first">
										<?php /*?>
										<div class="form-group m-form__group">
											<label for="fa_icon">Menu Position :</label>
											<select class="form-control m-input" name="position[]" id="position[]" multiple="multiple[]">
												<option value="">Select</option>
												<option value="top_right" <?php if("top_right"==$exp_position['top_right']){echo 'selected="selected"';}?>>Top Right Menu</option>
												<option value="header" <?php if("header"==$exp_position['header']){echo 'selected="selected"';}?>>Header Menu</option>
												<option value="footer_column1" <?php if("footer_column1"==$exp_position['footer_column1']){echo 'selected="selected"';}?>>Footer Menu Column1</option>
												<option value="footer_column2" <?php if("footer_column2"==$exp_position['footer_column2']){echo 'selected="selected"';}?>>Footer Menu Column2</option>
												<option value="footer_column3" <?php if("footer_column3"==$exp_position['footer_column3']){echo 'selected="selected"';}?>>Footer Menu Column3</option>
												<option value="copyright_menu" <?php if("copyright_menu"==$exp_position['copyright_menu']){echo 'selected="selected"';}?>>Copyright Menu</option>
											</select>
										</div>
										<?php */?>
										<?php
										if(!in_array($post['slug'],array("home"))) {
										$c_b_d_type = $page_data['c_b_d_type'];
										$arr_device_id = explode(",",$page_data['device_id']); ?>
										
										<div class="m-form__group form-group">
											<div class="m-radio-inline">
												<label class="m-radio">
													<input type="radio" id="d_type_cat" name="c_b_d_type" value="cat" <?=($c_b_d_type=='cat'?'checked="checked"':'')?> onclick="get_c_b_d_type('cat');">
													Category
													<span></span>
												</label>
												<label class="m-radio">
													<input type="radio" id="d_type_brand" name="c_b_d_type" value="brand" <?=($c_b_d_type=='brand'?'checked="checked"':'')?> onclick="get_c_b_d_type('brand');">
													Brand
													<span></span>
												</label>
												<label class="m-radio">
													<input type="radio" id="d_type_device" name="c_b_d_type" value="device" <?=($c_b_d_type=='device'?'checked="checked"':'')?> onclick="get_c_b_d_type('device');">
													Device
													<span></span>
												</label>
												<label class="m-radio">
													<input type="radio" id="d_type_none" name="c_b_d_type" value="none" <?=($c_b_d_type=='none'||$c_b_d_type==''?'checked="checked"':'')?> onclick="get_c_b_d_type('none');">
													None
													<span></span>
												</label>
											</div>
										</div>
										
										<div class="form-group m-form__group category_showhide" <?php if($c_b_d_type=='cat'){echo 'style="display:block;"';}else{echo 'style="display:none;"';}?>>
											<label for="input">Select Category</label>
											<select class="form-control <?php /*?>m-select2 m-select2-general<?php */?>" name="cat_id" id="cat_id">
												<option value=""> -Select- </option>
												<option value="all" <?php if('all'==$page_data['cat_id']){echo 'selected="selected"';}?>> All </option>
												<?php
												//Fetch device list
												$categories_data=mysqli_query($db,'SELECT * FROM categories WHERE published=1');
												while($categories_list=mysqli_fetch_assoc($categories_data)) { ?>
													<option value="<?=$categories_list['id']?>" <?php if($categories_list['id']==$page_data['cat_id']){echo 'selected="selected"';}?>><?=$categories_list['title']?></option>
												<?php
												} ?>
											</select>
										</div>
										
										<div class="form-group m-form__group brand_showhide" <?php if($c_b_d_type=='brand'){echo 'style="display:block;"';}else{echo 'style="display:none;"';}?>>
											<label for="input">Select Brand</label>
											<select class="form-control <?php /*?>m-select2 m-select2-general<?php */?>" name="brand_id" id="brand_id">
												<option value=""> -Select- </option>
												<option value="all" <?php if('all'==$page_data['brand_id']){echo 'selected="selected"';}?>> All </option>
												<?php
												//Fetch brand list
												$brand_l_q = mysqli_query($db,'SELECT * FROM brand WHERE published=1');
												while($brand_list = mysqli_fetch_assoc($brand_l_q)) { ?>
													<option value="<?=$brand_list['id']?>" <?php if($brand_list['id']==$page_data['brand_id']){echo 'selected="selected"';}?>><?=$brand_list['title']?></option>
												<?php
												} ?>
											</select>
										</div>
										
										<div class="form-group m-form__group device_showhide" <?php if($c_b_d_type=='device'){echo 'style="display:block;"';}else{echo 'style="display:none;"';}?>>
											<label for="input">Select Device</label>
											<select class="form-control <?php /*?>m-select2 m-select2-general<?php */?>" name="device_id[]" id="device_id[]" onchange="changedevice(this.value);">
												<option value=""> -Select- </option>
												<option value="all" <?php if(in_array('all',$arr_device_id)){echo 'selected="selected"';}?>> All </option>
												<?php
												while($devices_list=mysqli_fetch_assoc($devices_data)) { ?>
													<option value="<?=$devices_list['id']?>" <?php if(in_array($devices_list['id'],$arr_device_id)){echo 'selected="selected"';}?>><?=$devices_list['title']?></option>
												<?php
												} ?>
											</select>
										</div>
										<?php
										} ?>
										<div class="form-group m-form__group">
											<label for="input">
												Title :
											</label>
											<input type="text" class="form-control m-input" id="title" value="<?=($title?$title:$inbuild_page_data['title'])?>" name="title">
										</div>
										<div class="form-group m-form__group">
											<div class="m-checkbox-list">
												<label class="m-checkbox showhide_menu_url" <?=($menu_data['page_id']>0?'style="display:none;"':'')?>>
													<input type="checkbox" id="show_title" value="1" name="show_title" <?=($page_data['show_title']=='1'?'checked="checked"':'')?>>
													Show Title.
													<span></span>
												</label>
											</div>
										</div>
										
										<div class="form-group m-form__group">
											<label for="input">CSS Main Class :</label>
											<input type="text" class="form-control m-input" id="css_page_class" value="<?=$page_data['css_page_class']?>" name="css_page_class">
										</div>
											
										<?php
										if(!in_array($post['slug'],array("home"))) { ?>
											<div class="form-group m-form__group">
												<label for="input">
	                        URL :
	                      </label>
												<input type="text" class="form-control m-input" id="url" value="<?=$finl_url?>" name="url">
											</div>
											<div class="form-group m-form__group">
												<div class="m-checkbox-list">
													<label class="m-checkbox showhide_menu_url" <?=($menu_data['page_id']>0?'style="display:none;"':'')?>>
														<input type="checkbox" id="is_custom_url" value="1" name="is_custom_url" <?=($page_data['is_custom_url']=='1'?'checked="checked"':'')?>>
														Custom Url.
														<span></span>
													</label>
													<label class="m-checkbox">
														<input type="checkbox" id="is_open_new_window" value="1" name="is_open_new_window" <?=($page_data['is_open_new_window']=='1'?'checked="checked"':'')?>>
														Is Open New Window
														<span></span>
													</label>
												</div>
											</div>
										<?php
										} ?>
										<div class="form-group m-form__group">
											<label for="input">
                        Meta Title :
                      </label>
											<input type="text" class="form-control m-input" id="meta_title" value="<?=$page_data['meta_title']?>" name="meta_title">
										</div>
										<div class="form-group m-form__group">
											<label for="exampleTextarea">
												Meta Description :
											</label>
											<textarea class="form-control m-input" name="meta_desc" rows="4"><?=$page_data['meta_desc']?></textarea>
										</div>
										<div class="form-group m-form__group">
											<label for="exampleTextarea">
												Meta Keywords :
											</label>
											<textarea class="form-control m-input" name="meta_keywords" rows="3"><?=$page_data['meta_keywords']?></textarea>
										</div>

										<?php
										//,'contact'
										$slug_desc_not_show_array = array('blog','terms-and-conditions');
										if(!in_array($post['slug'],$slug_desc_not_show_array)) { ?>
										<div class="form-group m-form__group">
											<label for="fileInput">Header Image :</label>
											<div class="custom-file">
												<input type="file" id="image" class="custom-file-input" name="image" onChange="checkFile(this);" accept="image/*">
												<label class="custom-file-label" for="image">
													Choose file
												</label>
											</div>
											
											<?php
											if($page_data['image']!="") { ?>
												<img src="../images/pages/<?=$page_data['image']?>" width="200" class="my-md-2">
												<a class="btn btn-danger btn-sm" data-dismiss="fileupload" href="controllers/custom_page.php?id=<?=$_REQUEST['id']?>&r_img_id=<?=$page_data['id']?>" onclick="return confirm('Are you sure to delete this image?');">Remove</a>
												<input type="hidden" id="old_image" name="old_image" value="<?=$page_data['image']?>">
											<?php
											} ?>
                    					</div>
										
										<div class="form-group m-form__group">
											<label for="input">Header Image Text :</label>
											<input type="text" class="form-control m-input" id="image_text" value="<?=$page_data['image_text']?>" name="image_text">
										</div>
										<div class="form-group m-form__group">
											<label for="input">
												Description :
											</label>
											<textarea class="form-control m-input summernote" name="description"><?=$page_data['content']?></textarea>
										</div>
										<?php
										} ?>

										<div class="m-form__group form-group">
											<label for="">
												Publish :
											</label>
											<div class="m-radio-inline">
												<label class="m-radio">
													<input type="radio" id="published" name="published" value="1" <?php if(!$id){echo 'checked="checked"';}?> <?=($page_data['published']==1?'checked="checked"':'')?>>
													Yes
													<span></span>
												</label>
												<label class="m-radio">
													<input type="radio" id="published" name="published" value="0" <?=($page_data['published']=='0'?'checked="checked"':'')?>>
													No
													<span></span>
												</label>
											</div>
										</div>
									</div>
								</div>
								<input type="hidden" name="id" value="<?=$page_data['id']?>" />
								<input type="hidden" name="slug" value="<?=$post['slug']?>" />
								<div class="m-portlet__foot m-portlet__foot--fit">
									<div class="m-form__actions m-form__actions">
										<button type="submit" class="btn btn-primary" name="add_edit"><?=($id?'Update':'Save')?></button>
										<a href="custom_page.php" class="btn btn-secondary">Back</a>
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
