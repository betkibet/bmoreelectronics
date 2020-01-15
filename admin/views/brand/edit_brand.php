<script type="text/javascript">
function check_form(a) {
	if(a.title.value.trim()==""){
		alert('Please enter title');
		a.title.focus();
		a.title.value='';
		return false;
	}

	<?php /*?><?php
	if($brand_data['image']=="") { ?>
	var str_image = a.image.value.trim();
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
										  <?=($id?'Edit Brand':'Add Brand')?>
										</h3>
									</div>
								</div>
							</div>
							<!--begin::Form-->
							<form class="m-form" action="controllers/brand.php" role="form" method="post" onSubmit="return check_form(this);" enctype="multipart/form-data">
								<div class="m-portlet__body">
									<div class="m-form__section m-form__section--first">
										<?php /*?><div class="form-group m-form__group">
											<label for="input">Select Category</label>
											<select class="form-control m-select2 m-select2-general" name="cat_id" id="cat_id">
												<?php
												//Fetch device list
												$categories_data=mysqli_query($db,'SELECT * FROM categories WHERE published=1');
												while($categories_list=mysqli_fetch_assoc($categories_data)) { ?>
													<option value="<?=$categories_list['id']?>" <?php if($categories_list['id']==$brand_data['cat_id']){echo 'selected="selected"';}?>><?=$categories_list['title']?></option>
												<?php
												} ?>
											</select>
										</div><?php */?>
									
										<div class="form-group m-form__group">
											<label for="field-1">Title :</label>
											<input type="text" class="form-control m-input" id="first_name" value="<?=$brand_data['title']?>" name="title">
											<!-- <span class="m-form__help">
                        Please enter your username
                      </span> -->
										</div>
										<div class="form-group m-form__group">
											<label for="fileInput">Icon :</label>
											<div class="custom-file">
												<input type="file" id="image" class="custom-file-input" name="image" onChange="checkFile(this);" accept="image/*">
												<label class="custom-file-label" for="image">
													Choose file
												</label>
											</div>
											
											<?php
											if($brand_data['image']!="") { ?>
												<img src="../images/brand/<?=$brand_data['image']?>" width="200" class="my-md-2">
												<a class="btn btn-danger btn-sm" data-dismiss="fileupload" href="controllers/brand.php?id=<?=$_REQUEST['id']?>&r_img_id=<?=$brand_data['id']?>" onclick="return confirm('Are you sure to delete this icon?');">Remove</a>
												<input type="hidden" id="old_image" name="old_image" value="<?=$brand_data['image']?>">
											<?php
											} ?>
                    					</div>
										
										<div class="form-group m-form__group">
											<label for="sub_title">Sub Title</label>
											<textarea class="form-control m-input summernote" name="sub_title" rows="5"><?=$brand_data['sub_title']?></textarea>
										</div>
										
										<div class="form-group m-form__group">
											<label for="short_description">Short Description</label>
											<textarea class="form-control m-input summernote" name="short_description" rows="5"><?=$brand_data['short_description']?></textarea>
										</div>
										
										<div class="form-group m-form__group">
											<label for="exampleTextarea">
												Description :
											</label>
											<textarea class="form-control m-input summernote" id="exampleTextarea" name="description" rows="5"><?=$brand_data['description']?></textarea>
										</div>
										<div class="m-form__group form-group">
											<label for="">
												Publish :
											</label>
											<div class="m-radio-inline">
												<label class="m-radio">
													<input type="radio" id="published" name="published" value="1" <?php if(!$brand_id){echo 'checked="checked"';}?> <?=($brand_data['published']==1?'checked="checked"':'')?>>
													Yes
													<span></span>
												</label>
												<label class="m-radio">
													<input type="radio"  id="published" name="published" value="0" <?=($brand_data['published']=='0'?'checked="checked"':'')?>>
													No
													<span></span>
												</label>
											</div>
										</div>
									</div>
								</div>
								<input type="hidden" name="id" value="<?=$brand_data['id']?>" />
								<div class="m-portlet__foot m-portlet__foot--fit">
									<div class="m-form__actions m-form__actions">
										<button type="submit" name="update" class="btn btn-primary">
										  <?=($id?'Update':'Save')?>
										</button>
										<a href="brand.php" class="btn btn-secondary">Back</a>
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
