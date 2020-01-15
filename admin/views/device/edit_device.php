<script type="text/javascript">
function check_form(a){
	/*if(a.brand_id.value.trim()==""){
		alert('Please select device brand');
		a.brand_id.focus();
		return false;
	}*/

	if(a.title.value.trim()==""){
		alert('Please enter title');
		a.title.focus();
		a.title.value='';
		return false;
	}

	if(a.sef_url.value.trim()==""){
		alert('Please enter sef url');
		a.sef_url.focus();
		a.sef_url.value='';
		return false;
	}

	<?php /*?><?php
	if($device_data['device_img']=="") { ?>
	var str_image = a.device_img.value.trim();
	if(str_image == "") {
		alert('Please select image');
		return false;
	}
	<?php
	} ?>

	if(a.description.value.trim()==""){
		alert('Please enter description');
		a.description.focus();
		a.description.value='';
		return false;
	}<?php */?>
}

function checkFile(fieldObj) {
	if(fieldObj.files.length == 0) {
		return false;
	}

    var id = fieldObj.id;
	var str  = fieldObj.value;
	var FileExt = str.substr(str.lastIndexOf('.')+1);
	var FileExt = FileExt.toLowerCase();
	var FileSize = fieldObj.files[0].size;
	var FileSizeMB = (FileSize/10485760).toFixed(2);

	if((FileExt != "gif" && FileExt != "png" && FileExt != "jpg" && FileExt != "jpeg")){
	    var error = "Please make sure your file is in png | jpg | jpeg | gif format.\n\n";
	    alert(error);
		document.getElementById(id).value = '';
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
										  <?=($id?'Edit Device':'Add Device')?>
										</h3>
									</div>
								</div>
							</div>
							<!--begin::Form-->
							<form class="m-form" action="controllers/device.php" role="form" method="post" onSubmit="return check_form(this);" enctype="multipart/form-data">
								<div class="m-portlet__body">
									<div class="m-form__section m-form__section--first">
										<?php /*?><div class="form-group m-form__group">
											<label for="input">Select Device Brand :</label>
											<select class="form-control m-select2 m-select2-general" name="brand_id" id="brand_id">
												<option value=""> -Select- </option>
												<?php
												while($brands_list=mysqli_fetch_assoc($brands_data)) { ?>
													<option value="<?=$brands_list['id']?>" <?php if($brands_list['id']==$device_data['brand_id']){echo 'selected="selected"';}?>><?=$brands_list['title']?></option>
												<?php
												} ?>
											</select>
										</div><?php */?>
										<div class="form-group m-form__group">
											<label for="input">
												Device Title :
											  </label>
											<input type="text" class="form-control m-input" id="title" value="<?=$device_data['title']?>" name="title">
										</div>
										<div class="form-group m-form__group">
											<label for="sef_url">
												Sef Url :
											  </label>
											<input type="text" class="form-control m-input" id="sef_url" value="<?=$device_data['sef_url']?>" name="sef_url">
										</div>
										<div class="form-group m-form__group">
											<label for="input">
												Meta Title :
											  </label>
											<input type="text" class="form-control m-input" id="meta_title" value="<?=$device_data['meta_title']?>" name="meta_title">
										</div>
										<div class="form-group m-form__group">
											<label for="meta_desc">
												Meta Description :
											</label>
											<textarea class="form-control m-input" id="meta_desc" name="meta_desc" rows="4"><?=$device_data['meta_desc']?></textarea>
										</div>
										
										<div class="form-group m-form__group">
											<label for="meta_keywords">
												Meta Keywords :
											</label>
											<textarea class="form-control m-input" id="meta_keywords" name="meta_keywords" rows="4"><?=$device_data['meta_keywords']?></textarea>
										</div>
										
										<div class="form-group m-form__group">
											<label for="fileInput">Device Picture :</label>
											<div class="custom-file">
												<input type="file" id="device_img" class="custom-file-input" name="device_img" onChange="checkFile(this);" accept="image/*">
												<label class="custom-file-label" for="image">
													Choose file
												</label>
											</div>
											
											<?php
											if($device_data['device_img']!="") { ?>
												<img src="../images/device/<?=$device_data['device_img']?>" width="200" class="my-md-2">
												<a class="btn btn-danger btn-sm" data-dismiss="fileupload" href="controllers/device.php?id=<?=$_REQUEST['id']?>&r_img_id=<?=$device_data['id']?>" onclick="return confirm('Are you sure to delete this icon?');">Remove</a>
												<input type="hidden" id="old_image" name="old_image" value="<?=$device_data['device_img']?>">
											<?php
											} ?>
                    					</div>
										
										<div class="form-group m-form__group">
											<label for="sub_title">
												Sub Title :
											</label>
											<textarea class="form-control m-input" id="sub_title" name="sub_title" rows="5"><?=$device_data['sub_title']?></textarea>
										</div>
										<div class="form-group m-form__group">
											<label for="short_description">Short Description</label>
											<textarea class="form-control m-input summernote" name="short_description" rows="5"><?=$device_data['short_description']?></textarea>
										</div>
										<div class="form-group m-form__group">
											<label for="exampleTextarea">
												Description :
											</label>
											<textarea class="form-control m-input summernote" id="exampleTextarea" name="description" rows="5"><?=$device_data['description']?></textarea>
										</div>
										<div class="m-form__group form-group">
											<div class="m-checkbox-list">
												<label class="m-checkbox">
													<input id="popular_device" type="checkbox" value="1" name="popular_device" <?php if($device_data['popular_device']=='1'){echo 'checked="checked"';}?>>
													Check if device is popular, popular device appear in popular section.
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
													<input type="radio" id="published" name="published" value="1" <?php if(!$brand_id){echo 'checked="checked"';}?> <?=($device_data['published']==1?'checked="checked"':'')?>>
													Yes
													<span></span>
												</label>
												<label class="m-radio">
													<input type="radio"  id="published" name="published" value="0" <?=($device_data['published']=='0'?'checked="checked"':'')?>>
													No
													<span></span>
												</label>
											</div>
										</div>
									</div>
								</div>
								<input type="hidden" name="id" value="<?=$device_data['id']?>" />
								<div class="m-portlet__foot m-portlet__foot--fit">
									<div class="m-form__actions m-form__actions">
										<button type="submit" name="update" class="btn btn-primary">
										  <?=($id?'Update':'Save')?>
										</button>
										<a href="device.php" class="btn btn-secondary">Back</a>
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
