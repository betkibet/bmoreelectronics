<script type="text/javascript">
function check_form(a) {
	if (a.title.value.trim() == "") {
		alert('Please enter title');
		a.title.focus();
		a.title.value = '';
		return false;
	}

	<?php
	if($home_settings_data['image']=="") { ?>
		var str_image = a.image.value.trim();
		if (str_image == "") {
			alert('Please select image');
			return false;
		}
	<?php
	} ?>

	if (a.description.value.trim() == "") {
		alert('Please enter description');
		a.description.focus();
		a.description.value = '';
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
										  <?=($id?'Edit Home Settings':'Add Home Settings')?>
										</h3>
									</div>
								</div>
							</div>
							<!--begin::Form-->
							<form class="m-form" action="controllers/home_settings.php" role="form" method="post" onSubmit="return check_form(this);" enctype="multipart/form-data">
								<div class="m-portlet__body">
									<div class="m-form__section m-form__section--first">
										<?php
										if($home_settings_data['type']=="inbuild") { ?>
										<div class="form-group m-form__group">
											<label for="input">
												Section Name :
											</label>
											<?=ucwords(str_replace("_"," ",$home_settings_data['section_name']))?>
										</div>
										<?php
										} ?>
										<div class="form-group m-form__group">
											<label for="input">Choose Section Color :</label>
											<select class="form-control m-input m-select2 m-select2-general" name="section_color" id="section_color">
												<option value=""> -Select- </option>
												<option value="white" <?php if($home_settings_data['section_color'] == "white"){echo 'selected="selected"';}?>>White</option>
												<option value="gray" <?php if($home_settings_data['section_color'] == "gray"){echo 'selected="selected"';}?>>Gray</option>
												<option value="dark" <?php if($home_settings_data['section_color'] == "dark"){echo 'selected="selected"';}?>>Dark</option>
												<option value="heavydark" <?php if($home_settings_data['section_color'] == "heavydark"){echo 'selected="selected"';}?>>Heavy dark</option>
												<option value="lightblue" <?php if($home_settings_data['section_color'] == "lightblue"){echo 'selected="selected"';}?>>Light Blue</option>
											</select>
										</div>
										
										<div class="form-group m-form__group">
											<label for="fileInput">Section Background Image :</label>
											<div class="custom-file">
												<input type="file" id="section_image" class="custom-file-input" name="section_image" onChange="checkFile(this);" accept="image/*">
												<label class="custom-file-label" for="image">
													Choose file
												</label>
											</div>
											
											<?php
											if($home_settings_data['section_image']!="") { ?>
												<img src="../images/section/<?=$home_settings_data['section_image']?>" width="200" class="my-md-2">
												<a class="btn btn-danger btn-sm" data-dismiss="fileupload" href="controllers/home_settings.php?id=<?=$_REQUEST['id']?>&r_img_id=<?=$home_settings_data['id']?>" onclick="return confirm('Are you sure to delete this image?');">Remove</a>
												<input type="hidden" id="old_section_image" name="old_section_image" value="<?=$home_settings_data['section_image']?>">
											<?php
											} ?>
                    					</div>
										
										<div class="form-group m-form__group">
											<label for="input">
											Title :
										    </label>
											<input type="text" class="form-control m-input" id="title" value="<?=$home_settings_data['title']?>" name="title">
											<div class="m-checkbox-inline pt-2">
												<label class="m-checkbox">
													<input type="checkbox" id="show_title" name="show_title" value="1" <?=($home_settings_data['show_title']=='1'?'checked="checked"':'')?>>
													Show Title
													<span></span>
												</label>
											</div>
										</div>
										<div class="form-group m-form__group">
											<label for="input">
											Sub Title :
										    </label>
											<input type="text" class="form-control m-input" id="sub_title" value="<?=$home_settings_data['sub_title']?>" name="sub_title">
											<div class="m-checkbox-inline pt-2">
												<label class="m-checkbox">
													<input type="checkbox" id="show_sub_title" name="show_sub_title" value="1" <?=($home_settings_data['show_sub_title']=='1'?'checked="checked"':'')?>>
													Show Sub Title
													<span></span>
												</label>
											</div>
										</div>
										<div class="form-group m-form__group">
											<label for="input">
											Intro Text :
										    </label>
											<textarea class="form-control m-input summernote" id="intro_text"  name="intro_text" rows="5"><?=$home_settings_data['intro_text']?></textarea>
											<div class="m-checkbox-inline pt-2">
												<label class="m-checkbox">
													<input type="checkbox" id="show_intro_text" name="show_intro_text" value="1" <?=($home_settings_data['show_intro_text']=='1'?'checked="checked"':'')?>>
													Show Intro Text
													<span></span>
												</label>
											</div>
										</div>
										<?php //if($home_settings_data['type']!="inbuild") { ?>
											<div class="form-group m-form__group">
												<label for="input">
												Description :
											    </label>
												<textarea class="form-control m-input summernote" id="description"  name="description" rows="5"><?=$home_settings_data['description']?></textarea>
												<div class="m-checkbox-inline pt-2">
													<label class="m-checkbox">
														<input type="checkbox" id="show_description" name="show_description" value="1" <?=($home_settings_data['show_description']=='1'?'checked="checked"':'')?>>
														Show Description
														<span></span>
													</label>
												</div>
											</div>
										<?php //} ?>
										<div class="m-form__group form-group">
											<label for="status">
												Status :
											</label>
											<div class="m-radio-inline">
												<label class="m-radio">
													<input type="radio" id="status" name="status" value="1" <?=($home_settings_data['status']=='1'||$home_settings_data['status']==''?'checked="checked"':'')?>>
													Active
													<span></span>
												</label>
												<label class="m-radio">
													<input type="radio" id="status" name="status" value="0" <?=($home_settings_data['status']=='0'?'checked="checked"':'')?>>
													Inactive
													<span></span>
												</label>
											</div>
										</div>
									</div>
								</div>
								<input type="hidden" name="id" value="<?=$home_settings_data['id']?>" />
								<div class="m-portlet__foot m-portlet__foot--fit">
									<div class="m-form__actions m-form__actions">
										<button type="submit" name="update" class="btn btn-primary">
										  <?=($id?'Update':'Save')?>
										</button>
										<a href="home_settings.php" class="btn btn-secondary">Back</a>
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

<?php/*
<div id="wrapper">
	<header id="header" class="container">
		<?php include("include/admin_menu.php"); ?>
	</header>

	<section class="container" role="main">
		<div class="row">
			<article class="span12 data-block">
				<header>
					<h2><?=($id?'Edit Home Settings':'Add Home Settings')?></h2></header>
				<section>
					<?php include('confirm_message.php');?>
					<div class="row-fluid">
						<div class="span9">
							<form role="form" action="controllers/home_settings.php" class="form-horizontal form-groups-bordered" method="post" onSubmit="return check_form(this);" enctype="multipart/form-data">
								<fieldset>
									<?php
									if($home_settings_data['type']=="inbuild") { ?>
										<div class="control-group">
											<label class="control-label" for="input">Section Name:</label>
											<div class="controls">
												<?=ucwords(str_replace("_"," ",$home_settings_data['section_name']))?>
											</div>
										</div>
										<?php
									} ?>

											<div class="control-group">
												<label class="control-label" for="input">Choose Section Color</label>
												<div class="controls">
													<select name="section_color" id="section_color">
												<option value=""> -Select- </option>
												<option value="white" <?php if($home_settings_data['section_color'] == "white"){echo 'selected="selected"';}?>>White</option>
												<option value="gray" <?php if($home_settings_data['section_color'] == "gray"){echo 'selected="selected"';}?>>Gray</option>
												<option value="dark" <?php if($home_settings_data['section_color'] == "dark"){echo 'selected="selected"';}?>>Dark</option>
												<option value="heavydark" <?php if($home_settings_data['section_color'] == "heavydark"){echo 'selected="selected"';}?>>Heavy dark</option>
												<option value="lightblue" <?php if($home_settings_data['section_color'] == "lightblue"){echo 'selected="selected"';}?>>Light Blue</option>
											</select>
												</div>
											</div>

											<div class="control-group">
												<label class="control-label" for="fileInput">Section Background Image</label>
												<div class="controls">
													<div class="fileupload fileupload-new" data-provides="fileupload">
														<div class="input-append">
															<div class="uneditable-input">
																<i class="icon-file fileupload-exists"></i>
																<span class="fileupload-preview"></span>
															</div>
															<span class="btn btn-alt btn-file">
                                                            <span class="fileupload-new">Select Image</span>
															<span class="fileupload-exists">Change</span>
															<input type="file" class="form-control" id="section_image" name="section_image" onChange="checkFile(this);" accept="image/*">
															</span>
															<a href="javascript:void(0);" class="btn btn-alt btn-danger fileupload-exists" data-dismiss="fileupload">Remove</a>
														</div>
													</div>

													<?php
											if($home_settings_data['section_image']!="") { ?>
														<div class="fileupload fileupload-new" data-provides="fileupload">
															<div class="fileupload-new thumbnail"><img src="../images/section/<?=$home_settings_data['section_image']?>" width="200"></div>
															<div class="fileupload-preview fileupload-exists fileupload-large flexible thumbnail"></div>
															<div>
																<a class="btn btn-alt btn-danger" data-dismiss="fileupload" href="controllers/home_settings.php?id=<?=$_REQUEST['id']?>&r_img_id=<?=$home_settings_data['id']?>" onclick="return confirm('Are you sure to delete this icon?');">Remove</a>
															</div>
														</div>
														<input type="hidden" id="old_section_image" name="old_section_image" value="<?=$home_settings_data['section_image']?>">
														<?php
											} ?>
												</div>
											</div>

											<div class="control-group">
												<label class="control-label" for="input">Title</label>
												<div class="controls">
													<input type="text" class="input-large" id="title" value="<?=$home_settings_data['title']?>" name="title">
												</div>
												<div class="controls">
													<label class="checkbox custom-checkbox">
													<input type="checkbox" id="show_title" name="show_title" value="1" <?=($home_settings_data['show_title']=='1'?'checked="checked"':'')?>>
														Show Title
													</label>
												</div>
											</div>

											<div class="control-group">
												<label class="control-label" for="input">Sub Title</label>
												<div class="controls">
													<input type="text" class="input-large" id="sub_title" value="<?=$home_settings_data['sub_title']?>" name="sub_title">
												</div>
												<div class="controls">
													<label class="checkbox custom-checkbox">
												<input type="checkbox" id="show_sub_title" name="show_sub_title" value="1" <?=($home_settings_data['show_sub_title']=='1'?'checked="checked"':'')?>>
												Show Sub Title
											</label>
												</div>
											</div>

											<div class="control-group">
												<label class="control-label" for="input">Intro Text</label>
												<div class="controls">
													<textarea class="form-control wysihtml5" name="intro_text" rows="5"><?=$home_settings_data['intro_text']?></textarea>
												</div>
												<div class="controls">
													<label class="checkbox custom-checkbox">
												<input type="checkbox" id="show_intro_text" name="show_intro_text" value="1" <?=($home_settings_data['show_intro_text']=='1'?'checked="checked"':'')?>>
												Show Intro Text
											</label>
												</div>
											</div>

											<?php
									//if($home_settings_data['type']!="inbuild") { ?>
												<div class="control-group">
													<label class="control-label" for="input">Description</label>
													<div class="controls">
														<textarea class="form-control wysihtml5" name="description" rows="5"><?=$home_settings_data['description']?></textarea>
													</div>
													<div class="controls">
														<label class="checkbox custom-checkbox">
													<input type="checkbox" id="show_description" name="show_description" value="1" <?=($home_settings_data['show_description']=='1'?'checked="checked"':'')?>>
													Show Description
												</label>
													</div>
												</div>
												<?php
									//} ?>

													<div class="control-group radio-inline">
														<label class="control-label" for="status">Status</label>
														<div class="controls">
															<label class="radio custom-radio">
																<input type="radio" id="status" name="status" value="1" <?=($home_settings_data['status']=='1'||$home_settings_data['status']==''?'checked="checked"':'')?>>
																Active
															</label>
															<label class="radio custom-radio">
																<input type="radio" id="status" name="status" value="0" <?=($home_settings_data['status']=='0'?'checked="checked"':'')?>>
																Inactive
															</label>
														</div>
													</div>

													<input type="hidden" name="id" value="<?=$home_settings_data['id']?>" />

													<div class="form-actions">
														<button class="btn btn-alt btn-large btn-primary" type="submit" name="update"><?=($id?'Update':'Save')?></button>
														<a href="home_settings.php" class="btn btn-alt btn-large btn-black">Back</a>
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
</div>
*/?>
